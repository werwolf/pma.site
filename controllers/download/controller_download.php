<?php
if (!defined("entrypoint"))die;

$View->title = $labels['profile']['bc_title']." ".$labels['profile']['upgrade']." - ".$labels['common']['bc_title'];
                    $View->sub_module = 'download';

                    $params = "";
                    $params_for_count = "";
                    if(Root::POSTExists("semester") && Root::POSTExists("subject"))
                    {
                        if(Root::POSTInt("subject") != '...')
                        {
                            $params .= " and `Subjects`.`ID` = ".Root::POSTInt("subject")." ";
                            $params_for_count =" where `Files`.`Subject_ID` = ".Root::POSTInt("subject");
                            $View->files_view = 2;
                        }
                        if(Root::POSTInt("semester") != '...')
                        {
                            $params .= " and `Files`.`Semester` = ".Root::POSTInt("semester")." ";
                            $params_for_count =" where `Files`.`Semester` = ".Root::POSTInt("semester");
                            $View->files_view = 3;
                        }
                        if(Root::POSTInt("subject") != '...' && Root::POSTInt("semester") != '...')
                        {
                            $params_for_count =" where `Files`.`Semester` = ".Root::POSTInt("semester")." and `Files`.`Subject_ID` = ".Root::POSTInt("subject");
                            $View->files_view = 1;
                        }
                    }
                    else
                        $View->files_view = 0;

                    if(!empty($module[4]) && (int)$module[4]!=0)
                        $page = (int)$module[4];
                    else
                        $page = 1;


                    require_once("classes/files/class.files.php");
                    files::initDB($db);
                    $View->files = files::getFilesPage($page,FILES_PER_PAGE, $params);
                    $View->subjects = files::getSubjects();

                    $file_count = files::getFilesCount($params_for_count);
?>
