<?php
if(!defined("entrypoint"))die();

switch($module[2])
{
    case 'static_pages':require_once("admin/controllers/static_pages/controller_static_pages.php");
    break;
}
?>
