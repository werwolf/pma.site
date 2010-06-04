<?php
if (!defined("entrypoint"))die;

if($module[4] == "getGroups")
{
    require_once("admin/classes/groups/class.groups.php");
    $groups = new groups($db);
    $groups->getGroups();
    require_once("view/profile/send_message_template/get_groups.php");
}
else if($module[4] == 'getProfessors')
{
    require_once("admin/classes/users_admin/class.users_admin.php");
    $users = new users_admin($db,1);
    $users->getProfessorsForCalendar();
    require_once("view/profile/send_message_template/get_professors.php");
}
else if($module[4] == "getStudents")
{
    require_once("admin/classes/users_admin/class.users_admin.php");
    $users = new users_admin($db,1);
    $users->getStudentsFromGroups(Root::POSTInt("groups"));
    require_once("view/profile/send_message_template/get_professors.php");
}
?>
