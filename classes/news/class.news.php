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
    }
    public static function getOneNew($new)
    {
        $sql = "select `id`,`title_".self::$language."` as `title`,`text_".self::$language."` as `text`,`comments`".
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
               " `date` from `obj_news` where `active` = 'y' ";
        
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
}
?>
