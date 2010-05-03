<?php
if (!defined("entrypoint"))die;

$View->hat = "main";

try{
    $f = fopen("static/templates/maps/map_".config::getDefaultLanguage(),"r");

    if(!$f)
        throw new Exception("Файл не сужествует", 1);
    
    $map = fgets($f);
    fclose($f);
}
catch(Exception $e)
{    
    require_once("classes/pages/class.pages.php");
    pages::init($db,config::getDefaultLanguage(),user::isLoged());
    pages::getLeftMenu(pages::getAllPages(), 0,&$map,0);
    $map = str_replace("<ul></ul>","",$map);

    $f = fopen("static/templates/maps/map_".config::getDefaultLanguage(),"w");
    fwrite($f,$map);
    fclose($f);
}

$View->title = $labels['common']['sitemap']." - ".$labels['common']['header_pma'];
require_once("controllers/news/controller_last_news.php");
?>
