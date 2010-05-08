<?php
$View->module = "users";

$flag = explode("=",$module[4]);
if($flag[0] == 'page' && $flag[1] > 0)
     $page = $flag[1];
else
     $page = 1;

require_once("admin/classes/users_admin/class.users_admin.php");

$users_admin = new users_admin($db, $page);

if($module[3] == "students" && strlen($module[4]) ==0 && (int)$module[4]==0 || $flag[0] == 'page')
{
    require_once("classes/news/class.news.php");
    
    $View->sub_module = "users";
    $users_admin->getStudets();
    $View->paging = news::makePaging(20, $users_admin->getUsersCount("S"),"http://".$_SERVER['HTTP_HOST']."/admin/users/students/page=", "", $page);
}
elseif($module[3] == "lectors" && strlen($module[4]) ==0 && (int)$module[4]==0  || $flag[0] == 'page')
{
    require_once("classes/news/class.news.php");
    $View->sub_module = "users";
    $users_admin->getProfessors();
    $View->paging = news::makePaging(20, $users_admin->getUsersCount("P"),"http://".$_SERVER['HTTP_HOST']."/admin/users/lectors/page=", "", $page);
}
elseif($module[3] == "add")
{
    $View->sub_module = "add_user";

    if(Root::POSTExists("add") && $user->getUserSecret() == Root::POSTString("secret"))
    {
            try
            {
                if(strlen(Root::POSTString("login"))==0 || strlen(Root::POSTString("password"))==0)
                    throw new Exception();

                if($module[4] == "students")
                {
                    $users_admin->addStudent();
                    Root::Redirect("http://".$_SERVER['HTTP_HOST']."/admin/users/students");
                }
                elseif($module[4] == "lectors")
                {
                    $users_admin->addLector();
                    Root::Redirect("http://".$_SERVER['HTTP_HOST']."/admin/users/lectors");
                }
            }
            catch(Exception $e)
            {
                $View->error = true;
            }
    }
    if($module[4] == "students")
    {      
        require_once("admin/classes/groups/class.groups.php");
        $groups = new groups($db);
        $groups->getGroups();
    }
    elseif($module[4] == "lectors")
    {
        require_once("admin/classes/subjects/class.subjects.php");
        $subjects = new subjects($db);
        $subjects->getSubjects();
    }
}
elseif($module[3] == 'delete')
{
    $users_admin->deleteUser($module[5],$module[4]);
    Root::Redirect($_SERVER['HTTP_REFERER']);
}
?>
