<?if(!defined("entrypoint"))die();?>
<h3>Предмети</h3><br/>
<a href="http://<?=$_SERVER['HTTP_HOST'];?>/admin/subjects/add">Додати предмет</a>
<table id="news">
    <tr>
        <th>№</th>
        <th>Назва</th>
        <th></th>
    </tr>
    <? foreach($subjects as $key=>$val):?>
        <tr>
            <td><?=($subjects->key()+1);?></td>
            <td><?=$val['Title_ua'];?></td>
            <td>
                <a href="http://<?=$_SERVER['HTTP_HOST'];?>/admin/subjects/edit/<?=$val['ID'];?>" style="text-decoration:none">
                  <img src='http://<?=$_SERVER["HTTP_HOST"];?>/admin/static/img/page_edit.png' alt='Редактировать' title='Редактировать' style="border:0"/>
                </a>&nbsp;
                <a href="#" onclick="if(confirm('Ви впевнені, що бажаете видалити цей предмет?')){document.location.href='http://<?=$_SERVER['HTTP_HOST'];?>/admin/subjects/delete/<?=$val['ID'];?>'}">
                  <img alt='Удалить' title='Удалить' src='http://<?=$_SERVER["HTTP_HOST"];?>/admin/static/img/page_delete.png'/>
                </a>

            </td>
        </tr>
    <?endforeach;?>
</table>
