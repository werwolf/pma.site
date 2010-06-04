<?php
if (!defined("entrypoint"))die;
$View->left_menu = "left_menu";
$View->hat = "main";
$View->title = $labels['login']['enter_site']." - ".$labels['common']['bc_title'];

if(Root::POSTExists("login") && Root::POSTExists("password"))
{
    
    if(user::authentification(Root::POSTString("login"),Root::POSTString("password"),$db))
    {
        if(Root::POSTExists("admin"))
            Root::Redirect("http://".$_SERVER['HTTP_HOST']."/admin");
        else
            Root::Redirect("/".config::getDefaultLanguage()."/profile");
    }
    else
    {
        if(Root::POSTExists("admin"))
            Root::Redirect("http://".$_SERVER['HTTP_HOST']."/admin");
    }

    $View->error = "error";
}
require_once("controllers/news/controller_last_news.php");
$View->top_left_menu = 1;
$View->top_right_menu = 1;

?>
