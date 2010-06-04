<?php
if(!defined("entrypoint"))die();
$View->module = "groups";

require_once("admin/classes/groups/class.groups.php");
$groups = new groups($db);

switch($module[3])
{
    case 'groups':
          default:$groups->getGroups();
                  $View->sub_module="groups";

    break;
    case 'delete':$groups->deleteGroup((int)$module[4]);
                  Root::Redirect($_SERVER['HTTP_REFERER']);
    break;
    case 'add':$View->sub_module = "add_group";
                    
               if(Root::POSTExists("add") && $user->getUserSecret() == Root::POSTString("secret"))
               {
                   try
                   {
                        if(strlen(trim(Root::POSTString("title"))) == 0 || strlen(trim(Root::POSTString("course"))) == 0)
                            throw new Exception();
                        
                        $groups->addGroup();
                   }
                   catch(Exception $e)
                   {
                        $View->error = true;
                   }
               }
    break;
    case 'edit':$View->sub_module = "add_group";
                if(Root::POSTExists("edit") && $user->getUserSecret() == Root::POSTString("secret"))
                {
                    try
                    {
                        if(strlen(trim(Root::POSTString("title"))) == 0 || strlen(trim(Root::POSTString("course"))) == 0)
                            throw new Exception();

                        if((int)$module[4] == 0)
                            throw new Exception();

                        $groups->editGroup((int)$module[4]);
                    }
                    catch(Exception $e)
                    {
                        $View->error = true;
                    }
                }
                if((int)$module[4] > 0)
                    $View->group = $groups->getGroupInfo((int)$module[4]);
                
    break;
}
?>
