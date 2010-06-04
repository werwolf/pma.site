<?php
class pages
{
    private static $db;
    private static $lang;
    private static $is_loged = false;

    public static function init($db,$lang,$loged)
    {
        self::$db = $db;
        self::$lang = $lang;
        self::$is_loged = $loged;
    }

    public static function getStaticPage($page)
    {
         $sql = "select `title_".self::$lang."` as `title`,".
                "`text_".self::$lang."` as `text`,`hat`,`menu` from `obj_staticpages`";

         if($page > 0)
               $sql .= " where `id` = $page and `active` = 'y'";
         else
               $sql .= " order by `id` limit 0,1";

         self::$db->query($sql);

         if(self::$db->numRows() == 0)
                 return -1;
         else
                 return self::$db->assoc();
    }
    public static function unhtmlentities ($str)
    {
        $trans_tbl = get_html_translation_table (HTML_ENTITIES);
        $trans_tbl = array_flip ($trans_tbl);
        $trans_tbl["\\r\\n"] = "";
        return strtr ($str, $trans_tbl);
    }
    public static function getMainMenu()
    {
        self::$db->query("select `id`,`title_".self::$lang."` as title from `obj_staticpages` where `id_parent` = 0 order by `position`");
        $return = array();
        $index = 0;
        while($row = self::$db->assoc())
        {
            $return[$index]['id'] = $row['id'];
            $return[$index]['title'] = $row['title'];
            $return[$index]['margin'] = $margin*15;
            $index++;
        }
        return $return;
    }

    public static function getTopMenuView(&$array,$active_page,&$labels)
    {
        $return = array();$index_left = 0; $index_right = 0;

        for($i=0;$i<count($array);$i++)
        {
            if($index_left<6)
            {
              $return['left'][$index_left] = $array[$i];
              $index_left++;
            }
            else
            {
              $return['right'][$index_right] = $array[$i];
              $index_right++;
            }
        }
        foreach($return as $key=>$val)
        {
            $ret_string = "";
            for($i=0;$i<count($return[$key]);$i++)
            {
                $url = "page/{$return[$key][$i]['id']}/".urlencode($return[$key][$i]['title']).".html";
                $ret_string .= "<li ";

                if($return[$key][$i]['id'] == $active_page)
                    $ret_string.=" class='active'";
                
                $ret_string .= "><span class='selected_menu_li'><a href='/".self::$lang."/$url'>
                                {$return[$key][$i]['title']}</a></span></li>";                   
            }
            if($key == "left")
            {
                $ret_string_left = $ret_string;
            }
            else
            {
                $ret_string_right = $ret_string;
            }
        }

        if(count($return['left'])<6)
        {
            $ret_string_left.="<li ";

            if($active_page == 'news')
            {
                $ret_string_left.=" class='active'";
            }

            $ret_string_left.="><span class='selected_menu_li'><a href='/".self::$lang."/news'>".$labels['news']['bc_title']."</a></span></li>";
        }
        else{
            $ret_string_right.="<li";

            if($active_page == 'news')
            {
                $ret_string_right.=" class='active'";
            }

            $ret_string_right.="><span class='selected_menu_li'><a href='/".self::$lang."/news'>".$labels['news']['bc_title']."</a></span></li>";
        }
        if(self::$is_loged == true){
            if(count($return['left'])<6)
            {
                $ret_string_left.="<li ";

                if($active_page == 'profile')
                {
                    $ret_string_left.=" class='active'";
                }

                $ret_string_left.="><span class='selected_menu_li'><a href='/".self::$lang."/profile'>".$labels['profile']['bc_title']."</a></span></li>";
            }
            else{
                $ret_string_right.="<li";

                if($active_page == 'profile')
                {
                    $ret_string_right.=" class='active'";
                }

                $ret_string_right.="><span class='selected_menu_li'><a href='/".self::$lang."/profile'>".$labels['profile']['bc_title']."</a></span></li>";
            }
        }
        return array('left'=>$ret_string_left,'right'=>$ret_string_right);
    }
    public static function getAllPages()
    {
        self::$db->query("select `title_".self::$lang."` as `title`,`title_en` as `menu`,`id`,`id_parent`,`module` from `obj_staticpages`
                                              order by `id_parent`,`position`");
        $index = 0;
        while($row = self::$db->assoc())
        {
            $dbd[$index] = $row;
            $index++;
        }        
        return $dbd;
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
    public static function getLeftMenu($array,$current,$return,$pos)
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
                if($array[$i]['module']!="")
                    $return .= "<li><a href='/".self::$lang."/".$array[$i]['module']."/'>".$array[$i]['title']."</a>";
                else
                    $return.="<li><a href='/".self::$lang."/page/".$array[$i]['id']."/".str_replace(" ","_",$array[$i]['menu']).".html'>".$array[$i]['title']."</a>";
                        
                if($flag == 0)
                {
                    $return.="<ul>";
                    self::getLeftMenu($array,$array[$i]['id'],&$return,$i+1);
                    $return.="</ul>";
                }
                $return.="</li>";
            }
        }
   }

}
?>
