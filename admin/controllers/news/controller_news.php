<?php
if(!defined("entrypoint"))die();

$View->module = "news";
require_once("classes/news/class.news.php");

news::init($db,"ua",'y');
switch($module[3])
{
    case 'add':$error = false;
               if(Root::POSTExists("add_new"))
               {
                    $news_data = news::getParamsAddEdit();

                    if(strlen($news_data['title_ru']) == 0 || strlen($news_data['title_ua']) == 0 || strlen($news_data['title_en']) == 0)
                        $error = true;
                    
                    if(!$error)
                    {
                        $sql = "insert into `obj_news` (`id_user`,`title_ru`,`title_ua`,`title_en`,`text_ru`,`text_ua`,`text_en`,
                           `internal`,`active`,`comments`,`date`) values (".$user->getUserId().",'".$news_data['title_ru']."','".$news_data['title_ua'].
                            "','".$news_data['title_en']."','".$news_data['text_ru']."','".$news_data['text_ua']."','".$news_data['text_en']."','".$news_data['internal'].
                            "','".$news_data['active']."','".$news_data['comments']."',now())";

                        $db->query($sql);
                        Root::Redirect("http://".$_SERVER['HTTP_HOST']."/admin/news");
                    }
                    else
                    {
                      $View->news = $news_data;
                      $View->error = true;
                    }
               }

               require_once("admin/static/languages/languages.php");
               
               $View->sub_module = "news_edit";
               $View->langs = config::getAvailableLanguages();
    break;
    case 'edit':$error = false;
                if(Root::POSTExists("ID"))
                {
                    $news_data = news::getParamsAddEdit();

                    if(strlen($news_data['title_ru']) == 0 || strlen($news_data['title_ua']) == 0 || strlen($news_data['title_en']) == 0)
                        $error = true;                    
                    
                    if(!$error)
                    {
                        $sql = "update `obj_news`  set `title_ru`='".$news_data['title_ru']."',`title_ua`='".$news_data['title_ua']."',".
                               "`title_en`='".$news_data['title_en']."',`text_ua`='".$news_data['text_ua']."',`text_ru`='".$news_data['text_ru']."'".
                               ",`text_en`='".$news_data['text_en']."',`active`='".$news_data['active']."',`internal` = '".$news_data['internal']."',".
                               "`comments` = '".$news_data['comments']."' where `id` = ".Root::POSTInt("ID");

                        $db->query($sql);

                        Root::Redirect("http://".$_SERVER['HTTP_HOST']."/admin/news/edit/".Root::POSTInt("ID"));
                    }
                }
                $page = (int)$module[4];
                
                if(!$error)
                    $View->news = news::getOneNew($page);
                else
                {
                    $View->news = $news_data;
                    $View->error = true;
                }
                require_once("admin/static/languages/languages.php");
                
                $View->sub_module = "news_edit";
                $View->langs = config::getAvailableLanguages();
    break;
    case 'delete':$news_id = (int)$module[4];
                  if($news_id  > 0)
                  {
                    news::deleteNew($news_id);
                  }
                  Root::Redirect("http://".$_SERVER['HTTP_HOST']."/admin/news");
    break;
    case 'news':
        default:$View->sub_module = "news";
                $flag = explode("=",$module[3]);
                if((int)$module[3] == 0 || $flag[0] == 'page')
                {
                    $View->view_type = 1;

                    if(empty($flag[1]))
                        $page = 1;
                    else
                        $page = $flag[1];

                    $View->news_page = news::getNewsPage($page,20);
                    $View->paging = news::makePaging(20, news::getNewsCount(), "http://".$_SERVER["HTTP_HOST"]."/admin/news/page=","",$page);

                }
    break;
    
}
?>
