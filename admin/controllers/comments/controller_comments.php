<?php
if(!defined("entrypoint"))die();
require_once("classes/news/class.news.php");
news::init($db,"ua",'y');
$View->module = "comments";
$View->sub_module = "comments";

switch($module[3])
{
    case 'comments':
            default:$flag = explode("=",$module[3]);
                    if($flag[0] != 'page')
                        $page = 1;
                    else
                        $page = $flag[1];
                    
                    $View->comments = news::getCommentsPage(" order by `date` desc ",20,$page);
                    $View->paging = news::makePaging(20, news::getCommentsCountWithParam(""), "http://".$_SERVER["HTTP_HOST"]."/admin/comments/page=","", $page);
                    $View->news = news::getAllNews();
    break;
    case 'delete':$comment = (int)$module[4];print $comment;
                  if($comment != 0)
                  {
                      news::deleteComment($comment);
                  }
                  Root::Redirect("http://".$_SERVER['HTTP_HOST']."/admin/comments");
    break;
}
?>
