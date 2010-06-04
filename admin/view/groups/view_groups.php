<?php if(!defined("entrypoint"))die();?>
<h3>Групи</h3><br/>
<a href="http://<?=$_SERVER['HTTP_HOST'];?>/admin/groups/add">Додати групу</a>
<table id="news">
    <tr>
        <th>№</th>
        <th>Назва</th>
        <th>Курс</th>
        <th>Заочна</th>
        <th></th>
    </tr>
    <? foreach($groups as $key=>$val): ?>
        <tr>
            <td><?=($groups->key+1);?></td>
            <td><?=$val['Title'];?></td>
            <td><?=$groups->getCourse($val['Kurs']);?></td>
            <td><? if($val['Extranumeral'] == 1):?>Заочна<?endif;?></td>
            <td>
                <a href="http://<?=$_SERVER['HTTP_HOST'];?>/admin/groups/edit/<?=$val['ID'];?>" style="text-decoration:none">
                  <img src='http://<?=$_SERVER["HTTP_HOST"];?>/admin/static/img/page_edit.png' alt='Редактировать' title='Редактировать' style="border:0"/>
                </a>&nbsp;
                <a href="#" onclick="if(confirm('Ви впевнені, що бажаете видалити данну групу?')){document.location.href='http://<?=$_SERVER['HTTP_HOST'];?>/admin/groups/delete/<?=$val['ID'];?>'}">
                  <img alt='Удалить' title='Удалить' src='http://<?=$_SERVER["HTTP_HOST"];?>/admin/static/img/page_delete.png'/>
                </a>

            </td>
        </tr>
    <?endforeach;?>
</table>