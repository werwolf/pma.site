<?php if(!defined("entrypoint"))die(); ?>
<h3>Комментарі</h3><br/>
<table id="news">
    <tr>
        <th>№</th>
        <th>Коментар</th>
        <th>Ф.І.П.</th>
        <th>Дата</th>
        <th>Новина</th>
        <th></th>
    </tr>
    <? for($i = 0;$i<count($View->comments);$i++): ?>
        <tr>
            <td valign="top"><?=($i+1);?></td>
            <td valign="top"><?=$View->comments[$i]['text'];?></td>
            <td valign="top"><?=$View->comments[$i]['Surname']." ".$View->comments[$i]['Name']." ".$View->comments[$i]['Patronymic'];?></td>
            <td valign="top"><?=$View->comments[$i]['date'];?></td>
            <td valign="top"><a href="http://<?=$_SERVER['HTTP_HOST'];?>/admin/news/edit/<?=$View->comments[$i]['id'];?>"><?=$View->comments[$i]['title_ua'];?></a></td>
            <td valign="top">
                <a href="#" onclick="if(confirm('Ви впевнені, що бажаете видалити данний коментар?')){document.location.href='http://<?=$_SERVER['HTTP_HOST'];?>/admin/comments/delete/<?=$View->comments[$i]['ID'];?>'}"><img alt='Удалить' title='Удалить' src='http://<?=$_SERVER["HTTP_HOST"];?>/admin/static/img/page_delete.png'/></a>
            </td>
        </tr>
    <? endfor;?>
</table>