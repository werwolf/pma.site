<?php
if (!defined("entrypoint"))die;
$View->left_menu = "left_menu";
$View->hat = "main";
$View->title = $labels['login']['enter_site']." - ".$labels['common']['bc_title'];

if(Root::POSTExists("login") && Root::POSTExists("password"))
{
    
    if(user::authentification(Root::POSTString("login"),Root::POSTString("password"),$db))
            Root::Redirect("/".config::getDefaultLanguage()."/profile");
            
    $View->error = "error";
}
require_once("controllers/news/controller_last_news.php");
?>
