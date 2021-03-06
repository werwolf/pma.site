<?php

class static_pages
{
    private static $db;
    private static $lang = "ua";

    public static function init($db)
    {
        self::$db = $db;
    }
    public static function unhtmlentities ($str)
    {
        $trans_tbl = get_html_translation_table (HTML_ENTITIES);
        $trans_tbl = array_flip ($trans_tbl);
        $trans_tbl["\\r\\n"] = "";
        return strtr ($str, $trans_tbl);
    }
    public static function getPagesTree($array,$current,$return,$pos)
    {
        if($pos>=count($array))return;

        for($i=0;$i<count($array);$i++)
        {
            if($array[$i]['id_parent'] == $current)
            {
                $flag = -1;
                for($j=$i;$j<count($array);$j++)
                {
                    if($array[$j]['id_parent'] == $current)
                    {
                       $flag++;break;
                    }
                }

                $return.="<li><div class='block_page'><a href='http://".$_SERVER['HTTP_HOST']."/admin/static_pages/edit/".$array[$i]['id']."/".urlencode($array[$i]['title']).
                         ".html' class='links'>".$array[$i]['title']."</a>";
                
                $return.="<div>
                            <a href='http://".$_SERVER['HTTP_HOST']."/admin/static_pages/edit/".$array[$i]['id']."' class='link_work_page'>
                            <img src='http://".$_SERVER["HTTP_HOST"]."/admin/static/img/page_edit.png' alt='Редактировать' title='Редактировать'/></a>".
                         "<a href='http://".$_SERVER['HTTP_HOST']."/admin/static_pages/add/".$array[$i]['id']."' class='link_work_page'>
                             <img alt='Добавить дочернюю страницу' title='Добавить дочернюю страницу' src='http://".$_SERVER["HTTP_HOST"]."/admin/static/img/page_add.png'/></a>".
                         "<a href='#' onclick=\"if(confirm('Видалити?')){document.location.href='http://".$_SERVER['HTTP_HOST']."/admin/static_pages/delete/".$array[$i]['id']."';}\" class='link_work_page'>
                             <img alt='Удалить' title='Удалить' src='http://".$_SERVER["HTTP_HOST"]."/admin/static/img/page_delete.png'/></a></div></div>";

                if($flag == 0)
                {
                    $return.="<ul>";
                    self::getPagesTree($array,$array[$i]['id'],&$return,$i+1);
                    $return.="</ul>";
                }
                $return.="</li>";
            }
        }
    }

    public static function getAllPages()
    {
        self::$db->query("select `title_".self::$lang."` as `title`,`id`,`id_parent`,`module` from `obj_staticpages`
                                              order by `id_parent`,`position`");
        $index = 0;
        while($row = self::$db->assoc())
        {
            $dbd[$index] = $row;
            $index++;
        }
        return $dbd;
    }

    public static function getOnePageInfo($id)
    {
        self::$db->query("select * from `obj_staticpages` where `id` = $id");
        return self::$db->assoc();
    }

    public static function getParamsAddEdit()
    {
         $page_data['title_ru'] = htmlspecialchars(Root::POSTString("title_ru"));
         $page_data['title_ua'] = htmlspecialchars(Root::POSTString("title_ua"));
         $page_data['title_en'] = htmlspecialchars(Root::POSTString("title_en"));

         $page_data['text_ru'] = htmlspecialchars(Root::POSTString("text_ru"),ENT_QUOTES);
         $page_data['text_ua'] = htmlspecialchars(Root::POSTString("text_ua"),ENT_QUOTES);
         $page_data['text_en'] = htmlspecialchars(Root::POSTString("text_en"),ENT_QUOTES);
         $page_data['active'] = htmlspecialchars(Root::POSTString("is_show"));
         $page_data['position'] = htmlspecialchars(Root::POSTString("position"));

         return $page_data;
    }

    public static function deleteCache($id)
    {
        $langs = config::getAvailableLanguages();

        for($i = 0;$i<count($langs);$i++)
        {
            unlink("static/templates/left_menu/".md5("left_menu".self::getParent($id).$langs[$i]));
            unlink("static/templates/maps/map_".$langs[$i]);
        }
    }

    public static function getParent($id)
    {
        $index = 1;$parents[0] = $id;

        while(true)
        {
            $sql = "select `id_parent` from `obj_staticpages` where `id` = ".$id;

            self::$db->query($sql);

            $res = self::$db->assoc();
            $parents[$index] = $res['id_parent'];
            $id = $parents[$index];

            if($parents[$index]==0)break;
            $index++;
        }
        $parents = array_reverse($parents);

        return $parents[1];
    }
  
}
?>
