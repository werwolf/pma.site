<? if (!defined("entrypoint"))die;?>
<script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/js/tablesort.js"></script>
<script type='text/javascript' src='http://<?=$_SERVER['HTTP_HOST'];?>/static/js/jquery.simplemodal.js'></script>
<script type='text/javascript' src='http://<?=$_SERVER['HTTP_HOST'];?>/static/js/basic.js'></script>
<link type='text/css' href='http://<?=$_SERVER['HTTP_HOST'];?>/static/css/basic.css' rel='stylesheet' media='screen' />
<link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST'];?>/static/css/tablesort.css" type="text/css" media="screen" />
<center>
    <div style="margin:10px 10px 10px 30px" align="left">
        <form action="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/download/" method="post" id="params">
        <table>
            <tr>
                <td><?=$labels['fileshare']['subject'];?></td>
                <td>&nbsp;:
                    <select name="subject" onchange="document.getElementById('params').submit()">
                        <option>...</option>
                        <? for($i=0;$i<count($View->subjects);$i++):?>
                        <option <? if($View->subjects[$i]['ID'] == $View->subject): ?>selected<?endif;?> value="<?=$View->subjects[$i]['ID'];?>"><?=$View->subjects[$i]['Title'];?></option>
                        <? endfor;?>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="padding-top:10px"><?=$labels['fileshare']['semest'];?></td>
                <td style="padding-top:10px">&nbsp;:
                    <select name="semester" onchange="document.getElementById('params').submit()">
                        <option>...</option>
                        <? for($i=1;$i<13;$i++): ?>
                            <option <? if($i == $View->semester): ?>selected<?endif;?> value="<?=$i;?>"><?=$i;?></option>
                        <? endfor;?>
                    </select>
                </td>
            </tr>
        </table>
    </form>
    </div>
    <div id="download">
    <div id='basic-modal'>
    <table id="example" class="tablesorter" border="0" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
                        <th style="width:30px">№</th>
			<th style="width:150px"><?=$labels['fileshare']['title'];?></th>			
                        <? if($View->files_view == 0): ?>
                            <th style="width:300px"><?=$labels['fileshare']['subject'];?></th>
                            <th style="width:300px"><?=$labels['fileshare']['semest'];?></th>
                        <? endif;?>
                        <? if($View->files_view != 2 && $View->files_view != 0 && $View->files_view != 1):?>
                            <th style="width:300px"><?=$labels['fileshare']['subject'];?></th>
                        <? endif;?>
                        <? if($View->files_view != 3 && $View->files_view != 0 && $View->files_view != 1):?>
                            <th style="width:300px"><?=$labels['fileshare']['semest'];?></th>
                        <? endif;?>
                        <th style="width:300px"><?=$labels['fileshare']['filesize'];?></th>
			<th><?=$labels['fileshare']['download'];?></th>			
		</tr>
	</thead>
	<tbody>
                <? for($i=0;$i<count($View->files);$i++):?>
		<tr>
                    <td valign="top"><?=($i+1);?></td>
                    <td valign="top">
                        <a href='#' onclick="showFileInfo('http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/ajax/get_file_data','<?=$View->files[$i]['ID'];?>')">
                            <?=$View->files[$i]['File'];?>
                        </a>
                    </td>
                    <? if($View->files_view == 0): ?>
                        <td valign="top"><?=$View->files[$i]['Subject'];?></td>
                        <td valign="top"><?=$View->files[$i]['Semester'];?></td>
                    <? endif;?>
                    <? if($View->files_view != 2 && $View->files_view != 0 && $View->files_view != 1):?>
                            <td valign="top"><?=$View->files[$i]['Subject'];?></td>
                    <? endif;?>
                    <? if($View->files_view != 3 && $View->files_view != 0 && $View->files_view != 1):?>
                            <td valign="top"><?=$View->files[$i]['Semester'];?></td>
                    <? endif;?>
                    <td valign="top"><?=$View->files[$i]['Size'];?></td>
                    <td valign="top">
                        <button class="button_download" onclick="document.location.href='http://<?=$_SERVER['HTTP_HOST'];?>/<?=$View->files[$i]['Filepath'];?>'"><?=$labels['fileshare']['download'];?></button>
                    </td>
                </tr>
                <? endfor;?>
	</tbody>
</table>

<script type="text/javascript">
$(document).ready(function(){
// ---- tablesorter -----
$("#example").tablesorter({
	sortList: [[0,0]],
	widgets: ['zebra'],
        headers: {<? if($View->files_view == 0): ?>5<? elseif($View->files_view == 2 || $View->files_view == 3): ?>4<? else: ?>3<?endif;?>:{sorter:false}}
});
// ---- tablesorter -----
});
</script>
    </div>
    </div>
    <div style="margin-bottom:20px"><?=$View->paging;?></div>

</center>
<div id="basic-modal-content">
    
</div>
<div class="loader" style="display:none"></div>
<script type="text/javascript">
function showFileInfo(url_get,id)
{
    $('#basic-modal-content').modal();
    var html = "<table style='width:100%;height:560px'><tr><td align='center' valign=''><div class='loader'></div></td></tr></table>";
    $('#basic-modal-content').html(html);

    $.ajax({
        type:"POST",
        url:url_get,
        cache:false,
        data:"file_id="+id,
        success:function(data)
        {
            var file_info = eval("(" + data + ")");
            
            var html = "";
            if(file_info.Cover != "")
                html += "<div><img style='border:1px solid #e2dedf' src='http://<?=$_SERVER['HTTP_HOST'];?>/"+file_info.Cover+"'/></div>";

            html += "<table id='fileinfo'>";
            html += "<tr><td class='title'><?=$labels['fileshare']['title'];?></td><td>"+file_info.File+"</td></tr>";
            html += "<tr><td class='title'><?=$labels['fileshare']['description'];?></td><td>"+file_info.Description+"</td></tr>";
            html += "<tr><td class='title'><?=$labels['fileshare']['subject'];?></td><td>"+file_info.Subject+"</td></tr>";
            html += "<tr><td class='title'><?=$labels['fileshare']['semest'];?></td><td>"+file_info.Semester+"</td></tr>";
            html += "<tr><td class='title'><?=$labels['fileshare']['uploader'];?></td><td>"+file_info.Surname+"&nbsp;"+file_info.Name+"&nbsp;"+file_info.Patronymic+"</td></tr>";
            html += "<tr><td style='padding:5px'colspan='2'><button class='button_download' onclick='document.location.href=\"http://<?=$_SERVER['HTTP_HOST'];?>/"+file_info.Filepath+"\"'><?=$labels['fileshare']['download'];?></button></td></tr>";
            html += "</table>"

            $('#simplemodal-container').css("background-color","#fdfafa");
            $('#basic-modal-content').html(html);
        }

    });
}
</script>