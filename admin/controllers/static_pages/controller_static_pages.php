<?php
if(!defined("entrypoint"))die();

require_once("admin/classes/static_pages/class.static_pages.php");
static_pages::init($db);

switch($module[3])
{
    case 'static_pages':
                default:static_pages::getPagesTree(static_pages::getAllPages(), 0, &$tree, 0);
                        $View->pages_tree = $tree;
                        $View->module = "static_pages";
                        $View->sub_module = "static_pages";
    break;
}

?>
