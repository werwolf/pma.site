<?php
if(!defined("entrypoint"))die();

switch($module[2])
{
    case 'static_pages':require_once("admin/controllers/static_pages/controller_static_pages.php");
    break;
    case 'news':require_once("admin/controllers/news/controller_news.php");
    break;
    case 'comments':require_once("admin/controllers/comments/controller_comments.php");
    break;
}
?>
