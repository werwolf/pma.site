<?php if (!defined("entrypoint"))die;

$view_module_file = "view/".$View->module."/view_".$View->module."_".$View->sub_module.".php";

if (file_exists($view_module_file)) {
    require_once($view_module_file);
}
else {
    print "<h1>Страница не найдена.</h1>";
}
//require_once("view/".$View->module."/view_".$View->module."_".$View->sub_module.".php");
?>