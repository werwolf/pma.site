<?php
if (!defined("entrypoint"))die;

require_once("configs/labels/label_".config::getDefaultLanguage().".php");

pages::init($db,config::getDefaultLanguage(),user::isLoged());

switch($module[2])
{
    case 'pages':
         default:$active_page = (int)$module[3];    
                 if($active_page == 0)$active_page = 1;

                 $View->top_menu = pages::getTopMenuView(pages::getMainMenu(),$active_page,$labels);
    break;
    case 'news':$View->top_menu = pages::getTopMenuView(pages::getMainMenu(),"news",$labels);
    break;
    case 'profile':$View->top_menu = pages::getTopMenuView(pages::getMainMenu(),"profile", $labels);
    break;
    case 'rating':$View->top_menu = pages::getTopMenuView(pages::getMainMenu(),"profile", $labels);
    break;
}

$View->languages = config::getLanguagesFlags($_SERVER["REQUEST_URI"]);


?>
