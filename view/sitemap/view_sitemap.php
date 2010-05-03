<? if (!defined("entrypoint"))die;?>
<ul id="sitemap">
    <?=$map;?>
    <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/news"><?=$labels['news']['bc_title'];?></a></li>
</ul>