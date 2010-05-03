<?php
if (!defined("entrypoint"))die;
require_once("classes/news/class.news.php");
                    $View->title = $labels['profile']['bc_title']." ".$labels['profile']['upgrade']." - ".$labels['common']['bc_title'];
                    $View->sub_module = 'download';

                    $params = "";
                    $params_for_count = "";
                    if(Root::POSTExists("semester") && Root::POSTExists("subject"))
                    {
                        if(Root::POSTInt("subject") != '...')
                        {
                            $par_5 = "/subject=".Root::POSTInt("subject");
                            $params .= " and `Subjects`.`ID` = ".Root::POSTInt("subject")." ";
                            $params_for_count =" where `Files`.`Subject_ID` = ".Root::POSTInt("subject");
                            $View->files_view = 2;
                            $View->subject = Root::POSTInt("subject");
                            $View->semester = "";
                        }
                        if(Root::POSTInt("semester") != '...')
                        {
                            $par_5 = "/semester=".Root::POSTInt("semester");
                            $params .= " and `Files`.`Semester` = ".Root::POSTInt("semester")." ";
                            $params_for_count =" where `Files`.`Semester` = ".Root::POSTInt("semester");
                            $View->files_view = 3;
                            $View->subject = "";
                            $View->semester = Root::POSTInt("semester");
                        }
                        if(Root::POSTInt("subject") != '...' && Root::POSTInt("semester") != '...')
                        {
                            $par_5 = "/subject=".Root::POSTInt("subject");
                            $par_6 = "/semester=".Root::POSTInt("semester");
                            $params_for_count =" where `Files`.`Semester` = ".Root::POSTInt("semester")." and `Files`.`Subject_ID` = ".Root::POSTInt("subject");
                            $View->files_view = 1;
                            $View->subject = Root::POSTInt("subject");
                            $View->semester = Root::POSTInt("semester");
                        }
                    }
                    else
                        $View->files_view = 0;

                    $pp5 = explode("=",$module[5]);
                    $pp6 = explode("=",$module[6]);
                    if($pp5[0] == "subject" && $pp6[0] == "semester")
                    {
                        $par_5 = "/subject=".$pp5[1];
                        $par_6 = "/semester=".$pp6[1];
                        $params = " and `Files`.`Semester` = ".$pp6[1]." and `Files`.`Subject_ID` = ".$pp5[1]." ";
                        $params_for_count =" where `Files`.`Semester` = ".$pp6[1]." and `Files`.`Subject_ID` = ".$pp5[1];
                        $View->files_view = 1;
                        $View->semester = $pp6[1];
                        $View->subject = $pp5[1];
                    }
                    else if($pp5[0] == "subject" && empty($pp6[0]))
                    {
                        $par_5 = "/subject=".$pp5[1];
                        $params = " and `Files`.`Subject_ID` = ".$pp5[1]." ";
                        $params_for_count =" where `Files`.`Subject_ID` = ".$pp5[1];
                        $View->files_view = 2;
                        $View->semester = "";
                        $View->subject = $pp5[1];
                    }
                    else if($pp5[0] == "semester" && empty($pp6[0]))
                    {
                        $par_5 = "/semester=".$pp5[1];
                        $params = " and `Files`.`Semester` = ".$pp5[1];
                        $params_for_count =" where `Files`.`Semester` = ".$pp5[1];
                        $View->files_view = 3;
                        $View->semester = $pp5[1];
                        $View->subject = "";
                    }

                    if(!empty($module[4]) && (int)$module[4]!=0)
                        $page = (int)$module[4];
                    else
                        $page = 1;


                    require_once("classes/files/class.files.php");
                    files::initDB($db);
                    $FILES = files::getFilesPage($page,FILES_PER_PAGE, $params);
                    
                    for($i=0;$i<count($FILES);$i++)
                    {
                        $size = filesize($FILES[$i]['Filepath']);
                        $size_ind = 0;
                        while(true)
                        {
                            if($size < 1024)break;
                            $size = $size/1024;
                            $size_ind++;
                        }
                        $FILES[$i]['Size'] = round($size,1)." ".$file_sizes[$size_ind];
                    }
                    $View->files = $FILES;

                    $View->subjects = files::getSubjects();
                    $file_count = files::getFilesCount($params_for_count);
                    $View->paging = news::makePaging(FILES_PER_PAGE, $file_count, "http://".$_SERVER['HTTP_HOST']."/".config::getDefaultLanguage()."/profile/download/", $par_5.$par_6, $page);                    
?>
