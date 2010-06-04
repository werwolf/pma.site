<? if(!defined("entrypoint"))die();?>
<div style="margin-top:10px;margin-bottom:10px"><a href="http://<?=$_SERVER['HTTP_HOST'];?>/admin/static_pages/add/0">Додати сторінка у корінь</a></div>
    <ul id="pages_tree">
        <?=$View->pages_tree;?>
    </ul>
