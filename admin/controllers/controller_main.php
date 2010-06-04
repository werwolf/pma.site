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
    case 'users':require_once("admin/controllers/users/controller_users.php");
    break;
    case 'groups':require_once("admin/controllers/groups/controller_groups.php");
    break;
    case 'subjects':require_once("admin/controllers/subjects/controller_subjects.php");
    break;
}
?>
