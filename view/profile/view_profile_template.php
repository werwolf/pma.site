<? if (!defined("entrypoint"))die;?>
<ul>
    <li>
        <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile"><?=$labels['profile']['profile_user'];?></a>
        <ul>
            <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/edit"><?=$labels['profile']['edit'];?></a><li>
            <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/editpass"><?=$labels['profile']['change_pass'];?></a><li>
        </ul>
    </li>
    <li>
        <a href="javascript:void(0)"><?=$labels['rating']['rating'];?></a>
        <ul>
            <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/rating/create"><?=$labels['rating']['create_table'];?></a></li>
            <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/rating/view"><?=$labels['rating']['view_table'];?></a></li>
            <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/rating/edit"><?=$labels['rating']['edit_table'];?></a></li>
        </ul>

    </li>
    <li>
        <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/calendar"><?=$labels['profile']['calendar'];?></a>
    </li>
    <? if($user->getUserState() == PROFFESOR || ($user->getUserState() == STUDENT && ($user->getUserRank() == 'praepostor' || $user->getUserRank() == "trade-union"))):?>
    <li>
        <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/send_message"><?=$labels['mail']['send_message'];?></a>
    </li>
    <? endif;?>
    <li>
        <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/download"><?=$labels['profile']['download'];?></a>
    </li>
    <? if($user->getUserState() == PROFFESOR): ?>
    <li>
        <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/upload"><?=$labels['profile']['upgrade'];?></a>
    </li>
    <? endif;?>
</ul>