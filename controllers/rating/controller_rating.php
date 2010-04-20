<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined("entrypoint"))die;

if(!user::isLoged())
        Root::Redirect("/");

$View->left_menu = "profile";
$View->hat = "main";
$View->module = "rating";

switch($module[3])
{
    case 'create':
            $View->title = $labels['rating']['bc_title']." - ".$labels['common']['bc_title'];
            $View->sub_module = 'create';
    break;
    case 'edit':
            $View->title = $labels['rating']['bc_title']." - ".$labels['common']['bc_title'];
            $View->sub_module = 'edit';
            //require_once("controllers/download/controller_download.php");
    break;
    case 'view':
            $View->title = $labels['rating']['bc_title']." - ".$labels['common']['bc_title'];
            $View->sub_module = 'view';
            //require_once("controllers/upload/controller_upload.php");
    break;
}

?>
