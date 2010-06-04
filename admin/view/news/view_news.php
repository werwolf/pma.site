<? if(!defined("entrypoint"))die();?>
<h3>Новини</h3><br/>
<a href="http://<?=$_SERVER['HTTP_HOST'];?>/admin/news/add">Додати новину</a>
<table id="news">
    <tr>
        <th>№</th>
        <th>Заголовок</th>
        <th>Текст новини</th>
        <th>Дата</th>
        <th></th>
    </tr>
    <? for($i=0;$i<count($View->news_page);$i++): ?>
        <tr>
            <td><?=($i+1);?></td>
            <td><a href="http://<?=$_SERVER['HTTP_HOST'];?>/admin/news/edit/<?=$View->news_page[$i]['id'];?>"><?=$View->news_page[$i]['title'];?></a></td>
            <td><?=static_pages::unhtmlentities($View->news_page[$i]['text']);?></td>
            <td><?=news::getDate($View->news_page[$i]['date']);?></td>
            <td>
                <a href="http://<?=$_SERVER['HTTP_HOST'];?>/admin/news/edit/<?=$View->news_page[$i]['id'];?>" style="text-decoration:none">
                <img src='http://<?=$_SERVER["HTTP_HOST"];?>/admin/static/img/page_edit.png' alt='Редактировать' title='Редактировать' style="border:0"/></a>&nbsp;
                <a href="#" onclick="if(confirm('Ви впевнені, що бажаете видалити данну новини?')){document.location.href='http://<?=$_SERVER['HTTP_HOST'];?>/admin/news/delete/<?=$View->news_page[$i]['id'];?>'}"><img alt='Удалить' title='Удалить' src='http://<?=$_SERVER["HTTP_HOST"];?>/admin/static/img/page_delete.png'/></a>
            </td>
        </tr>
    <? endfor;?>        
</table>
<div style="text-align:center;margin:10px;width:100%;"><?=$View->paging;?></div>