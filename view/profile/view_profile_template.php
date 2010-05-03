<? if (!defined("entrypoint"))die;?>
<ul>
    <li>
        <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile"><?=$labels['profile']['profile_user'];?></a>
        <ul>
            <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/edit"><?=$labels['profile']['edit'];?></a><li>
        </ul>
    </li>
    <li>
        <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/download"><?=$labels['profile']['download'];?></a>
    </li>
    <? if($user->getUserState() == PROFFESOR): ?>
    <li>
        <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/upload"><?=$labels['profile']['upgrade'];?></a>
    </li>

    <li>
        <a href="javascript:void(0)"><?=$labels['rating']['rating'];?></a>
        <ul>
            <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/rating/create"><?=$labels['rating']['create_table'];?></a></li>
            <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/rating/view"><?=$labels['rating']['view_table'];?></a></li>
            <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/rating/edit"><?=$labels['rating']['edit_table'];?></a></li>
        </ul>


    </li>
    <? endif;?>
</ul>