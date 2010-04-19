<? if (!defined("entrypoint"))die;?>
<ul>
    <li>
        <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile"><?=$labels['profile']['profile_user'];?></a>
    </li>
    <li>
        <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/download"><?=$labels['profile']['download'];?></a>
    </li>
    <? if($user->getUserState() == PROFFESOR): ?>
    <li>
        <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/upload"><?=$labels['profile']['upgrade'];?></a>
    </li>

    <li>
        <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/rating"><?=$labels['profile']['rating'];?></a>
    </li>
    <? endif;?>
</ul>