
    <li>
        <span class='selected_menu_li'>
            <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/page/4/Research.html">Наукова робота</a>
        </span>
    </li>
    <li class="active">
        <span class='selected_menu_li'>
            <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/page/60/Foreign_Affairs.html">Зовнішні зв'язки</a>
        </span>
    </li>
<? if(user::isLoged()):?>
    <li>
        <span class='selected_menu_li'>
            <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile">Особистий кабінет</a>
        </span>
    </li>
<? endif;?>