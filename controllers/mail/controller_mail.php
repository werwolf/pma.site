<?php
if (!defined("entrypoint"))die;

$View->title = $labels['profile']['bc_title']." ".$labels['profile']['mail']." - ".$labels['common']['bc_title'];
$View->sub_module = 'mail';
require_once("classes/mail/class.mail.php");

$mails = new mail($db,$user->getUserId());

switch($module[4])
{
    case 'output':$View->mail_submod = "output";
    break;
    case 'input':
         default:$View->mail_submod = "input";
                 $flag = explode("=",$module[5]);

                 if($flag[0] == 'page' && (int)$flag[0] > 0)
                     $page = (int)$flag[1];
                 else
                     $page = 1;
                 
                 $mails->initInputOutput($page, MAILS_FOR_PAGE);
                 $mails->getInputMails();
    break;
    case 'write':$View->mail_submod = "write";
    break;
}
?>
