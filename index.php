<?php
session_start();

$begin = microtime(1);
define ("entrypoint",true);

require_once("configs/config.php");
require_once("classes/db/class.database.php");
require_once("classes/class.root.php");
require_once("classes/class.config.php");
require_once("classes/users/class.user.php");
require_once("classes/class.view.php");
require_once("classes/pages/class.pages.php");
                                                                                            
$db = new MySQLDatabase(new MySQLConfiguration(MYSQL_HOST,MYSQL_BASE,MYSQL_USER,MYSQL_PASS));
$us_temp = user::checkUser($_SESSION['user_login'],(int)$_SESSION['userid'],$_SESSION['hash_user'],$db);

switch($us_temp['State'])
{
    case false:
       default:session_destroy();
    break;

    case STUDENT:$user = new Student($db,$us_temp['ID']);$user->getUserInformation();break;
    case PROFFESOR:$user = new Professor($db,$us_temp['ID']);$user->getUserInformation();
    break;
}
config::init($db);
config::loadConfig();

Root::Init();   
$View = ViewSingleton::getInstance();

$module = explode("/",preg_replace("/\?.*$/","",$_SERVER['REQUEST_URI']));                
        
if(config::isInAvailableLang($module[1]))
{
    config::setDefaultLanguage($module[1]);
}       		
else
{
    if(user::isLoged())
    {
            Root::Redirect("/".$user->getUserLanguage());
    }
    else
    {                
            Root::Redirect("/".config::getDefaultLanguage());
    }
}

require_once("controllers/controller_main.php");
        
switch($module[2])
{
    case 'page':
        default:$View->module = "pages";
                require_once("controllers/pages/controller_static.php");
                require_once("view/view_forall.php");
    break;
    case 'news':$View->module = "news";
                require_once("controllers/news/controller_news.php");
                require_once("view/view_forall.php");
    break;
    case 'login':$View->module = "login";
                require_once("controllers/login/controller_login.php");
                require_once("view/view_forall.php");
    break;
    case 'profile':$View->module = "profile";
                require_once("controllers/profile/controller_profile.php");
                require_once("view/view_forall.php");
    case 'rating':$View->module = "rating";
                require_once("controllers/rating/controller_rating.php");
                require_once("view/view_forall.php");
    break;
    case 'ajax':require_once("controllers/ajax/controller_ajax.php");
    break;
    case 'logout':if(user::isLoged())
                  {
                    $user->Logout();
                    Root::Redirect("/".config::getDefaultLanguage());
                  }
                  else
                  {
                    Root::Redirect("/".config::getDefaultLanguage());
                  }
    break;
}             
Root::POSTKillAll();
//$end = microtime(1);
//print $end - $begin." ";
?>