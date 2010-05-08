<?php
if(!defined("entrypoint"))die();

require_once("admin/classes/static_pages/class.static_pages.php");
static_pages::init($db);
$View->module = "static_pages";

switch($module[3])
{
    case 'static_pages':
                default:static_pages::getPagesTree(static_pages::getAllPages(), 0, &$tree, 0);
                        $View->pages_tree = $tree;                        
                        $View->sub_module = "static_pages";
    break;
    case 'edit':$error = false;
                if(Root::POSTExists("ID"))
                {                    
                    $page_data = static_pages::getParamsAddEdit();
                    
                    try
                    {
                        if(strlen($page_data['title_ru']) == 0 || strlen($page_data['title_ua']) == 0 || strlen($page_data['title_en']) == 0)
                                throw new Exception();

                        if((int)$page_data['position'] == 0 && $page_data['position'] != '0')
                                throw new Exception();
                    
                        $sql = "update `obj_staticpages` set `title_ru` = '".$db->escape($page_data['title_ru'])."',`title_en` = '".$db->escape($page_data['title_en'])."',`title_ua` = '".$db->escape($page_data['title_ua'])."',".
                           "`text_ua` = '".$db->escape($page_data['text_ua'])."',`text_en` = '".$db->escape($page_data['text_en'])."',`text_ru`='".$db->escape($page_data['text_ru'])."',`active` = '".$page_data['active']."',`position` = ".$page_data['position'].
                           " where `id` = ".Root::POSTInt("ID");

                        $db->query($sql);
                        static_pages::deleteCache(Root::POSTInt("ID"));

                    }
                    catch(Exception $e)
                    {
                        $error = true;
                    }
                }

                $page = (int)$module[4];

                if($page != 0)
                {
                     if(!$error)
                     {
                        $View->page_info = static_pages::getOnePageInfo($page);
                     }
                     else
                     {
                        $View->error = true;
                        $View->page_info = $page_data;
                     }
                     $View->sub_module = "edit_page";
                     $View->langs = config::getAvailableLanguages();
                     require_once("admin/static/languages/languages.php");
                }                                   
    break;
    case 'add':$error = false;
               if(Root::POSTExists("ID"))
               {
                   $page_data = static_pages::getParamsAddEdit();
                   
                   try
                   {
                        if(strlen($page_data['title_ru']) == 0 || strlen($page_data['title_ua']) == 0 || strlen($page_data['title_en']) == 0)
                                throw new Exception();

                        if((int)$page_data['position'] == 0 && $page_data['position'] != '0')
                                throw new Exception();
                        
                        $sql = "select `hat`,`menu` from `obj_staticpages` where `id` = ".Root::POSTInt("ID");
                        $db->query($sql);$res = $db->assoc();

                        $sql = "insert into `obj_staticpages` (`title_ru`,`title_ua`,`title_en`,`text_ru`,`text_ua`,`text_en`,`position`,".
                               "`active`,`id_parent`,`hat`,`menu`) values ('".$page_data['title_ru']."','".$page_data['title_ua']."','".$page_data['title_en']."',".
                               "'".$page_data['title_ru']."','".$page_data['title_ua']."','".$page_data['title_en']."',".$page_data['position'].",".
                               "'".$page_data['active']."',".Root::POSTInt("ID").",'".$res['hat']."','".$res['menu']."')";
                               
                        $db->query($sql);

                        $db->query("select `id` from `obj_staticpages` order by `id` desc limit 0,1");
                        $result = $db->assoc();

                        static_pages::deleteCache(Root::POSTInt("ID"));
                        Root::Redirect("http://".$_SERVER['HTTP_HOST']."/admin/static_pages/edit/".$result['id']);
                   }
                   catch(Exception $e)
                   {
                        $View->error = true;
                        $View->page_info = $page_data;
                   }
               }
               require_once("admin/static/languages/languages.php");
               $View->sub_module = "edit_page";
               $View->langs = config::getAvailableLanguages();
    break;
    case 'delete':$page = (int)$module[4];
                  $db->query("delete from `obj_staticpages` where `id` = ".$page." or `id_parent` = ".$page);
                  static_pages::deleteCache($page);
                  Root::Redirect("http://".$_SERVER['HTTP_HOST']."/admin/static_pages");
    break;
}

?>
