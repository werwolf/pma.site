<?php
if (!defined("entrypoint"))die;

if(!user::isLoged())
        Root::Redirect("/");

$View->left_menu = "profile";
$View->hat = "main";
$View->module = "profile";

switch($module[3])
{
    case 'profile':
           default:$View->title = $labels['profile']['bc_title']." - ".$labels['common']['bc_title'];
                   $View->sub_module = 'main';
    break;
    case 'download':require_once("controllers/download/controller_download.php");
    break;
    case 'upload':require_once("controllers/upload/controller_upload.php");
    break;
    case 'rating':require_once("controllers/rating/controller_rating.php");
    break;
}

?>