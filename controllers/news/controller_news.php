<?php
if (!defined("entrypoint"))die;
require_once("classes/news/class.news.php");


if(user::isLoged())
        $int = 'n';
else 
        $int = 'y';

news::init($db,config::getDefaultLanguage(),$int);

$View->title = $labels['news']['bc_title']." - ".$labels['common']['bc_title'];
$View->hat = "news";

$flag = explode("=",$module[3]);

if((int)$module[3] == 0 || $flag[0] == 'page')
{
    $View->view_type = 1;

    if(empty($flag[1]))
        $page = 1;
    else
        $page = $flag[1];

    $View->news_page = news::getNewsPage($page,config::getCountNewNews());
    $View->paging = news::makePaging(config::getCountNewNews(), news::getNewsCount(), "http://".$_SERVER["HTTP_HOST"]."/".config::getDefaultLanguage()."/news/page=","",$page);
}
else if(is_numeric($module[3]))
{
    $View->view_type = 2;
    $View->new = news::getOneNew((int)$module[3]);

    if(news::isComment())
    {
        $flag = explode("=",$module[4]);
        
        if($flag[0]!='page')
        {
            $page = 1;
            $last_param = $module[4];
        }
        else
        {
            $page = (int)$flag[1];
            $last_param = $module[5];
        }
        $View->comments = news::getCommentInfo((int)$module[3],$page,config::getMessagesPerPage());
        $View->paging = news::makePaging(config::getMessagesPerPage(),news::getCommentsCount((int)$module[3]),"http://".$_SERVER['HTTP_HOST']."/".config::getDefaultLanguage()."/news/".(int)$module[3]."/page=", "/".$last_param,$page);
    }
}

if(Root::POSTExists("action"))
{
    switch(Root::POSTString("action"))
    {
        case 'add_comment':if($user->getUserSecret() == Root::POSTString("user_secret") && $user->isLoged() && trim(Root::POSTString("comment"))!="")
                           {
                               news::addComment(Root::POSTInt("new_id"),Root::POSTString("comment"),Root::POSTInt("user_id"));
                               header("Location:".$_SERVER['HTTP_REFERER']);
                           }
        break;
    }
}
require_once("controllers/news/controller_last_news.php");
?>
