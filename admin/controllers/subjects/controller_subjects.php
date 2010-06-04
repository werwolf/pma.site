<?php
if(!defined("entrypoint"))die();
$View->module = "subjects";

require_once("admin/classes/subjects/class.subjects.php");
require_once("admin/static/languages/languages.php");
$subjects = new subjects($db);

switch($module[3])
{
    case 'subjects':
            default:$View->sub_module="subjects";
                    $subjects->getSubjects();                    
    break;
    case 'add':$View->sub_module = "add_subject";
               $View->langs = config::getAvailableLanguages();
               
               if(Root::POSTExists("add") && $user->getUserSecret() == Root::POSTString("secret"))
               {
                    try
                    {                        
                        for($i=0;$i<count($View->langs);$i++)
                        {
                            if(strlen(trim(Root::POSTString("Title_".$View->langs[$i]))) == 0)
                            {
                                throw new Exception();break;
                            }
                        }                        
                        
                        if(count(Root::POSTPure("semesters")) == 0)
                            throw new Exception();

                        $subjects->addSubject();
                    }
                    catch(Exception $e)
                    {
                        $View->error = true;
                    }
               }
    break;
    case 'edit':$View->sub_module = "add_subject";
                $View->langs = config::getAvailableLanguages();

                if(Root::POSTExists("edit"))
                {
                    try
                    {
                        for($i=0;$i<count($View->langs);$i++)
                        {
                            if(strlen(trim(Root::POSTString("Title_".$View->langs[$i]))) == 0)
                            {
                                throw new Exception();break;
                            }
                        }

                        if(count(Root::POSTPure("semesters")) == 0)
                            throw new Exception();

                        if((int)$module[4] == 0)
                            throw new Exception();

                        $subjects->editSubject((int)$module[4]);
                    }
                    catch(Exception $e)
                    {
                        $View->error = true;
                    }
                }
                if((int)$module[4] > 0)
                {
                    $View->subject = $subjects->getSubjectInfo((int)$module[4]);
                    $View->right_semestr = explode("||",$View->subject['Semester']);

                    $semestrs = array(1,2,3,4,5,6,7,8,9,10,11,12);
                    $View->left_semestr = array_diff($semestrs,$View->right_semestr);
                }
    break;
    case 'delete':if((int)$module[4] > 0)
                       $subjects->deleteSubject((int)$module[4]);
                  Root::Redirect($_SERVER['HTTP_REFERER']);
    break;
}
?>
