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
    case 'rating':require_once("controllers/rating/controller_rating.php");
    break;
    case 'calendar':require_once("controllers/calendar/controller_calendar.php");
    break;
    case 'edit':$View->title = $labels['profile']['bc_title']." ".$labels['profile']['edit']." - ".$labels['common']['bc_title'];
                $View->sub_module = 'edit';
                
                if(Root::POSTExists("param_edit") && $user->getUserSecret() == Root::POSTString("secret"))
                {
                    $user->updateUserInformation();

                    if(strlen(Root::FILESName("cover")) > 0)
                    {
                        require_once("classes/files/class.files.php");
                        try
                        {
                            files::init($db, $viewextensions,MAX_PHOTO_SIZE);
                            files::setDirectory("static/uploaded/user_photo/");
                            
                            if(!files::isFileOnServer(Root::FILESTmpName("cover")))
                                throw new Exception($labels['fileshare']['error_upload_file']);

                            if(!files::checkFileSize(Root::FILESSize("cover")))
                                throw new Exception($labels['fileshare']['error_cover_to_big']);

                            $file_name = files::checkFileExists(Root::FILESName('cover'));

                            if(!files::uploadFile(Root::FILESTmpName("cover"), $file_name))
                                throw new Exception($labels['fileshare']['error_upload_file']);
                                
                            files::deleteFile($user->getUserPhoto());
                            $user->setUserPhoto(files::getUserPhoto($file_name));

                        }
                        catch(Exception $e)
                        {
                            $View->error = $e->getMessage();
                        }

                    }

                    if(!$View->keyExists("error"))
                            Root::Redirect("http://".$_SERVER['HTTP_HOST']."/".config::getDefaultLanguage()."/profile/edit");
                }
    break;
    case 'download':require_once("controllers/download/controller_download.php");
    break;
    case 'upload':require_once("controllers/upload/controller_upload.php");
    break;
    case 'editpass':$View->sub_module = 'editpass';
                    $View->title = $labels['profile']['bc_title']." ".$labels['profile']['change_pass']." - ".$labels['common']['bc_title'];

                    if(Root::POSTExists("edit") && $user->getUserSecret() == Root::POSTString("secret"))
                    {
                        try
                        {
                            if(trim(Root::POSTString("password1")) != trim(Root::POSTString("password2")))
                                throw new Exception($labels['profile']['pass_not_one']);

                            $user->setNewPass($db->escape(trim(Root::POSTString("password1"))));
                            $View->error = $labels['profile']['pass_changed'];
                        }
                        catch(Exception $e)
                        {
                            $View->error = $e->getMessage();
                        }
                    }
    break;
    case 'send_message':$View->sub_module = "send_message";
                        $View->title = $labels['profile']['bc_title']." ".$labels['mail']['send_message']." - ".$labels['common']['bc_title'];
    break;
}

?>