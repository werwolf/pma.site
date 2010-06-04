<?php
if (!defined("entrypoint"))die;
switch($module[3])
{
    case 'check_file':require_once("classes/files/class.files.php");
                      require_once("controllers/ajax/controller_check_file.php");
    break;
    case 'get_file_data':require_once("classes/files/class.files.php");
                         require_once("controllers/ajax/controller_get_file_data.php");
    break;
    
    case 'get_user_info':
    break;
    case 'get_calendar':require_once("controllers/ajax/controller_get_calendar.php");
    break;
    case 'send_message':require_once("controllers/ajax/controller_send_message.php");
    break;

    case 'get_table':require_once("classes/rating/class.rating.php");
                     require_once("controllers/ajax/controller_get_table.php");
    break;
    case 'create_table':require_once("classes/rating/class.rating.php");
                        require_once("controllers/ajax/controller_create_table.php");
    break;
}

?>
