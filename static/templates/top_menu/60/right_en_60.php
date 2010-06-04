
    <li>
        <span class='selected_menu_li'>
            <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/page/4/Research.html">Research</a>
        </span>
    </li>
    <li class="active">
        <span class='selected_menu_li'>
            <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/page/60/Foreign_Affairs.html">External Relations</a>
        </span>
    </li>
<? if(user::isLoged()):?>
    <li>
        <span class='selected_menu_li'>
            <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile">Private Office</a>
        </span>
    </li>
<? endif;?>