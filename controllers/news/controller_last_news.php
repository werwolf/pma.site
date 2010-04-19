<?php
if (!defined("entrypoint"))die;

require_once("classes/news/class.news.php");

if(user::isLoged())
        $intenal = 'y';
else
        $intenal = 'n';

news::init($db, config::getDefaultLanguage(), $intenal);
$View->last_news = news::getNewsPage(1,config::getCountNewNews());

$View->left_menu = "news";
?>
