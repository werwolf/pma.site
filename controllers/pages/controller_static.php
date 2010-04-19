<?php
if(!defined("entrypoint"))die();

$View->page = pages::getStaticPage((int)($module[3]));

if($View->page == -1)
    Root::Redirect("/".config::getDefaultLanguage());

$View->title = $View->page['title']." - ".$labels['common']['bc_title'];
$View->hat = $View->page['hat'];

$parent = pages::getParent((int)$module[3]);

if(file_exists("static/templates/left_menu/".md5("left_menu".$parent.config::getDefaultLanguage())))
{
    $f = fopen("static/templates/left_menu/".md5("left_menu".$parent.config::getDefaultLanguage()),"r");
    $View->left_menu_content = fgets($f);
    fclose($f);    
}
else
{
    pages::getLeftMenu(pages::getAllPages(), $parent, &$menu, 0);    
    
    $menu = str_replace("<ul></ul>","", $menu);

    $f = fopen("static/templates/left_menu/".md5("left_menu".$parent.config::getDefaultLanguage()),"w");
    fwrite($f, $menu);
    fclose($f);

    $View->left_menu_content = $menu;
}

if((int)$module[3] == 0 || (int)$module[3] ==1)
{
    require_once("controllers/news/controller_last_news.php");
}
else
    $View->left_menu = "left_menu";
?>
