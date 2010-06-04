<?php
session_start();
define ("entrypoint",true);

if(!isset($module))
    header("Location:http://".$_SERVER['HTTP_HOST']."/admin/main");

require_once("configs/config.php");
require_once("classes/db/class.database.php");
require_once("classes/users/class.user.php");
require_once("classes/class.view.php");
require_once("classes/class.root.php");
require_once("classes/class.config.php");

$db = new MySQLDatabase(new MySQLConfiguration(MYSQL_HOST,MYSQL_BASE,MYSQL_USER,MYSQL_PASS));
$us_temp = user::checkUser($_SESSION['user_login'],(int)$_SESSION['userid'],$_SESSION['hash_user'],$db);

switch($us_temp['State'])
{
    case false:
       default:session_destroy();
    break;
    case STUDENT:$user = new Student($db,$us_temp['ID']);$user->getUserInformation();break;
    case PROFFESOR:$user = new Professor($db,$us_temp['ID']);$user->getUserInformation();break;
}

if(user::isLoged())
{
    if($user->isAdminCheck())
    {
        Root::Init();
        $View = ViewSingleton::getInstance();
        
        config::init($db);
        config::loadConfig();

        require_once("admin/controllers/controller_main.php");
        require_once("admin/view/admin.php");
    }
    else
        require_once("admin/view/login/view_login.php");
}
else
{
    require_once("admin/view/login/view_login.php");
}
?>