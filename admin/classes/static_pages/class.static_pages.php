<?php

class static_pages
{
    private static $db;
    private static $lang = "ua";

    public static function init($db)
    {
        self::$db = $db;
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

                $return.="<li><div class='block_page'><a href='http://".$_SERVER['HTTP_HOST']."/admin/static_pages/edit/".$array[$i]['id']."/".urlencode($array[$i]['title']).".html' class='links'>".$array[$i]['title']."</a>";
                $return.="<div><img src='http://".$_SERVER["HTTP_HOST"]."/admin/static/img/page_edit.png' alt='Редактировать' title='Редактировать'/>".
                         "<img alt='Добавить дочернюю страницу' title='Добавить дочернюю страницу' src='http://".$_SERVER["HTTP_HOST"]."/admin/static/img/page_add.png'/>".
                         "<img alt='Удалить' title='Удалить' src='http://".$_SERVER["HTTP_HOST"]."/admin/static/img/page_delete.png'/></div></div>";
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
}
?>
