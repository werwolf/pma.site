<?php if(!defined("entrypoint"))die();?>
<h3>Користувачі "<? if ($module[3] == "students"):?>Студенти<?else:?>Викладачі<?endif;?>"</h3><br/>
<a href="http://<?=$_SERVER['HTTP_HOST'];?>/admin/users/add/<? if ($module[3] == "students"):?>students<?else:?>lectors<?endif;?>">Додати користувача</a>
<table id="news">
    <tr>
        <th>№</th>
        <th>П.І.П.</th>
        <? if ($module[3] == "students"):?><th>Група</th><?endif;?>
        <th></th>
    </tr>
    <? foreach($users_admin as $key=>$val): ?>
        <tr>
            <td><?=($key+1);?></td>
            <td>
                <a href="http://<?=$_SERVER['HTTP_HOST'];?>/admin/users/edit/<? if ($module[3] == "students"):?>students<?else:?>lectors<?endif;?>/<?=$val['user'];?>">
                    <?=$val['Surname']." ".$val['Name']." ".$val['Patronymic'];?>
                </a>
            </td>
            <? if ($module[3] == "students"):?><td><?=$val['Groupe'];?></td><?endif;?>
            <td>
                <a href="http://<?=$_SERVER['HTTP_HOST'];?>/admin/users/edit/<?=$module[3];?>/<?=$val['user'];?>" style="text-decoration:none">
                <img src='http://<?=$_SERVER["HTTP_HOST"];?>/admin/static/img/page_edit.png' alt='Редактировать' title='Редактировать' style="border:0"/></a>&nbsp;
                <a href="#" onclick="if(confirm('Ви впевнені, що бажаете видалити цього користувача?')){document.location.href='http://<?=$_SERVER['HTTP_HOST'];?>/admin/users/delete/<?=$module[3];?>/<?=$val['user'];?>'}">
                    <img alt='Удалить' title='Удалить' src='http://<?=$_SERVER["HTTP_HOST"];?>/admin/static/img/page_delete.png'/></a>
            </td>
        </tr>
    <? endforeach;?>
</table>
<center><?=$View->paging;?></center>