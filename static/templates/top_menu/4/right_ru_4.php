
    <li class="active">
        <span class='selected_menu_li'>
            <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/page/4/Research.html">Научная работа</a>
        </span>
    </li>
    <li>
        <span class='selected_menu_li'>
            <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/page/60/Foreign_Affairs.html">Внешние связи</a>
        </span>
    </li>

<? if(user::isLoged()):?>
    <li>
        <span class='selected_menu_li'>
            <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile">Личный кабинет</a>
        </span>
    </li>
<? endif;?>