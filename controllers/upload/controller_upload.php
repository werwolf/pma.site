<?php
if (!defined("entrypoint"))die;

$View->title = $labels['profile']['bc_title']." ".$labels['profile']['upgrade']." - ".$labels['common']['bc_title'];
$View->sub_module = "upload";
$View->subjects_id = $user->getProfessorSubjectsIds();
$View->subjects = $user->getProfessorSubjects();

if(Root::POSTExists("action")) {
    require_once("classes/files/class.files.php");

    if(Root::POSTString("action") == 'upload') {
        if($user->isLoged() && $user->getUserState() == PROFFESOR && $user->getUserSecret() == Root::POSTString("user_secret")) {
            files::init($db, $viewextensions,MAX_FILE_SIZE);
            files::setDirectory("static/uploaded/files/");

            if(files::isFileOnServer(Root::FILESTmpName('file')) && files::checkFileSize(Root::FILESSize('file'))) {
                $file_name = files::checkFileExists(Root::FILESName('file'));
                $View->file_name = $file_name;
                if(files::uploadFile(Root::FILESTmpName('file'), $file_name)) {
                    $View->file_success = true;

                    if(strlen(Root::FILESName('cover')) > 0) {
                        if(files::isFileOnServer(Root::FILESTmpName('cover')) && files::checkFileSize(Root::FILESSize('cover'))) {
                            files::setDirectory("static/uploaded/covers/");
                            $file_name = files::checkFileExists(Root::FILESName('cover'));


                            if(files::uploadFile(Root::FILESTmpName('cover'),$file_name)) {
                                $View->cover_success = true;
                                $View->cover = $file_name;
                            }
                            else
                                $View->cant_upload_cover = "error";
                        }
                        else {
                            if(!files::checkFileSize(Root::FILESSize('cover')))
                                $View->cover_to_big = "error";
                            else
                                $View->cant_upload_cover = "error";
                        }
                    }
                    else {
                        $View->cover_success = true;
                        $View->cover = "";
                    }
                }
                else {
                    $View->cant_upload_file = "error";
                }
            }
            else {
                if(!files::checkFileSize(Root::FILESSize('file')))
                    $View->file_to_big = "error";
                else
                    $View->cant_upload_file = "error";
            }
        }
        else {
            $View->permition_denied = 'error';
        }
    }
}
if($View->keyExists("file_success")) {
    $sql = "insert into `Files` (`Title`,`Filepath`,`Master`,`Date`,`Semester`,`Description`,`Subject_ID`";

    if($View->keyExists("cover_success"))
        $sql.=",`Cover`";

    $sql.=") values (\"".$db->escape(Root::POSTString('title'))."\",\"".$db->escape("static/uploaded/files/").$db->escape($View->file_name)."\",".
            "".$user->getUserId().",now(),".Root::POSTInt("semestr").",\"".$db->escape(Root::POSTExists('description'))."\",".Root::POSTInt("subject");

    if($View->keyExists("cover_success"))
        $sql.=",\"static/uploaded/covers/".$db->escape($View->cover)."\"";
    $sql.=")";

    $db->query($sql);
}
?>