<? if (!defined("entrypoint"))die;?>

<ul id="mail_line" style="margin:0">
    <li style="display:inline">
        <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/mail" class="<?if($View->mail_submod!="input"):?>not_<?endif;?>active_menu"><?=$labels['mail']['input'];?></a>
    </li>
    <li style="display:inline">
        <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/mail/output" class="<?if($View->mail_submod!="output"):?>not_<?endif;?>active_menu"><?=$labels['mail']['output'];?></a>
    </li>
    <li style="display:inline">
        <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/mail/write" class="<?if($View->mail_submod!="write"):?>not_<?endif;?>active_menu"><?=$labels['mail']['write'];?></a>
    </li>
</ul>
<? require_once("view/profile/mail/view_profile_mail_".$View->mail_submod.".php");?>