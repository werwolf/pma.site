<?php
if (!defined("entrypoint"))die;
misc::init($db);

require_once("configs/labels/label_".config::getDefaultLanguage().".php");

pages::init($db,config::getDefaultLanguage(),user::isLoged());
$View->show_quote = true;

switch($module[2])
{
    case 'pages':
         default:$active_page = (int)$module[3];    
                 if($active_page == 0)$active_page = 1;

                 if($active_page == 1)$View->show_quote = false;
                 $View->top_menu = pages::getTopMenuView(pages::getMainMenu(),$active_page,$labels);                 
    break;
    case 'news':       
                 $View->top_left_menu = "news";
                 $View->top_right_menu = "news";
    break;
    case 'profile':$View->top_left_menu = "profile";
                   $View->top_right_menu = "profile";
    break;
    case 'site_map':$View->top_left_menu = "sitemap";
                    $View->top_right_menu = "sitemap";
    break;    
}

$View->languages = config::getLanguagesFlags($_SERVER["REQUEST_URI"]);
$View->quote = misc::getQuote(config::getQoutesCount(), config::getDefaultLanguage());
?>
