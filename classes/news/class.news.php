<?php
class news
{
    private static $db;
    private static $language;
    private static $is_comment;
    private static $internal;
    private static $pages_count;

    public static function init($db,$lang,$intenal)
    {
        self::$db = $db;
        self::$language = $lang;
        self::$internal = $intenal;
    }
    public static function isComment()
    {
        if(self::$is_comment == 'y')
            return true;
        else
            return false;
    }
    public static function addComment($new,$text,$user)
    {
        $sql = "insert into `obj_comments` (`date`,`text`,`id_post`,`id_user`) values ".
               " (now(),'".self::$db->escape($text)."','$new','$user')";
        
        self::$db->query($sql);
        self::$db->query("update `obj_news` set `comments_count` = `comments_count`+1 where `id` = ".$new);
    }
    public static function getOneNew($new)
    {
        $sql = "select `id`,`title_".self::$language."` as `title`,`title_ru`,`title_en`,`title_ua`,`text_ru`,`text_ua`,`text_en`,`text_".self::$language."` as `text`,`comments`,`internal`,`active` ".
               "  from `obj_news` where `obj_news`.`active` = 'y' ";

        if(self::$internal == 'n')
            $sql.=" and `internal` = '".self::$internal."' ";
        
        if($new != 0)
            $sql.= " and `obj_news`.`id` = $new ";
        else
            $sql.=" order by `date` limit 0,1";

        self::$db->query($sql);

        if(self::$db->numRows() > 0)
        {
            $return = self::$db->assoc();
            self::$is_comment = $return['comments'];
            return $return;
        }
        else
        {
            return -1;
        }
    }
    public static function getCommentsCount($new)
    {
        $sql = "select count(*) as `count` from `obj_comments` where `id_post` = $new";
        self::$db->query($sql);
        $result = self::$db->assoc();
        
        return $result['count'];
    }
    public static function getCommentInfo($new,$page,$count)
    {
        $sql = "select `obj_comments`.`id_user`,`obj_comments`.`date`,`obj_comments`.`text`,`Users`.`Name`,".
               "`Users`.`Surname`,`Users`.`ID`,`Users`.`Patronymic`,`Users`.`Photo` from `obj_comments`,`Users` where".
               " `obj_comments`.`id_post` = $new and `obj_comments`.`id_user` = `Users`.`ID` order by `obj_comments`.`date` desc".
               " limit ".($page-1)*$count.",".$count;

        self::$db->query($sql);
        
        return self::$db->assocAll();
    }
    public static function getNewsPage($page,$count)
    {
        $sql = "select `id`,`comments`,`comments_count`,`title_".self::$language."` as `title`,`text_".self::$language."` as `text`,".
               " `date`,`title_en` as `link` from `obj_news` where `active` = 'y' ";
        
        if(self::$internal == 'n')
            $sql .= " and `internal` = '".self::$internal."' ";

        $sql .= " order by `date` desc limit ".(($page-1)*$count).",$count";
        
        self::$db->query($sql);

        if(self::$db->numRows() == 0)
                return -1;
        else
                return self::$db->assocAll();
    }
    public static function makePaging($per_page,$count,$param_beg,$param_end,$active)
    {
        $pages = (int)($count/$per_page);
        if($pages*$per_page < $count)$pages++;

        self::$pages_count = $pages;

        if($pages == 1)return "";
        
        $from = (int)(($active-0.1)/10)*10+1;
        $to = $from + 9;
        
        if($to > $pages)$to = $pages;

        if($from > 10)
           $return .="&nbsp;<a href='$param_beg".($from-1)."$param_end'>...</a>";

        for($i=$from;$i<=$to;$i++)
        {
            $return.="&nbsp;<a href='$param_beg".$i."$param_end'";
            if($active == $i)
                $return.=" class='active_new_page' ";
            $return .= ">".$i."</a>";
            
        }

        if($to < $pages)
               $return .="&nbsp;<a href='$param_beg".($to+1)."$param_end'>...</a>";

        return $return;        
    }
    public static function getNewsCount()
    {
        $sql = "select count(*) as `count` from `obj_news` where `active` = 'y'";
        self::$db->query($sql);$result = self::$db->assoc();
     
        return $result['count'];
    }
    public static function getPagesCount()
    {
        return self::$pages_count;
    }
    public static function getDate($date_db)
    {
        $date = substr($date_db,0,10);

        $return.= substr($date,8,2).".";
        $return.= substr($date,5,2).".";
        $return.= substr($date,0,4)." ";

        $time = substr($date_db,11,5);

        return $return.$time;
    }
    public static function deleteNew($id)
    {
        $sql = "delete from `obj_news` where `id` = $id";        
        self::$db->query($sql);
        $sql = "delete from `obj_comments` where `id_post` = $id";
        self::$db->query($sql);
    }
    public static function getParamsAddEdit()
    {
        $page_data['title_ru'] = htmlspecialchars(Root::POSTString("title_ru"));
        $page_data['title_ua'] = htmlspecialchars(Root::POSTString("title_ua"));
        $page_data['title_en'] = htmlspecialchars(Root::POSTString("title_en"));

        $page_data['text_ru'] = htmlspecialchars(Root::POSTString("text_ru"));
        $page_data['text_ua'] = htmlspecialchars(Root::POSTString("text_ua"));
        $page_data['text_en'] = htmlspecialchars(Root::POSTString("text_en"));

        $page_data['active'] = htmlspecialchars(Root::POSTString("is_active"));
        $page_data['internal'] =  htmlspecialchars(Root::POSTString("internal"));
        $page_data['comments'] = htmlspecialchars( Root::POSTString("is_comment"));
        
        return $page_data;
    }
    public static function getCommentsPage($param,$count,$page)
    {
        $sql = "select `obj_news`.`id`,`obj_comments`.`id` as `ID`,`obj_comments`.`date`,`obj_comments`.`text`,`obj_news`.`title_ua`,".
               "`Users`.`Name`,`Users`.`Surname`,`Users`.`Patronymic` from `obj_comments`,".
               "`obj_news`,`Users` where `obj_comments`.`id_post` = `obj_news`.`id` and ".
               " `obj_comments`.`id_user` = `Users`.`ID` $param limit ".($page-1)*$count.",".$count;

        self::$db->query($sql);
        
        return self::$db->assocAll();
    }
    public static function getCommentsCountWithParam($param)
    {
        $sql = "select count(*) as `count` from `obj_comments` $param";
        self::$db->query($sql);
        $res = self::$db->assoc();

        return $res['count'];
    }
    public static function deleteComment($comment)
    {
        self::$db->query("select `id_post` from `obj_comments` where `id` = $comment");
        $res = self::$db->assoc();

        self::$db->query("update `obj_news` set `comments_count` = `comments_count`-1 where `id` = ".$res['id_post']);
        self::$db->query("delete from `obj_comments` where `id` = $comment");
        
    }
    public static function getAllNews()
    {
        self::$db->query("select `id`,`title_ua` from `obj_news`");
        return self::$db->assocAll();
    }
}
?>
