<? if(!defined("entrypoint"))die();?>
<? if($View->keyExists("error")): ?>
<b style="color:red;font-size:20px;">Усі заголовки мають бути введені. Позиція - ціле число.</b><br/><br/>
<?endif;?>
<? if($module[3] == 'edit'): ?><h3>Сторінка:&nbsp;"<?=$View->page_info['title_ua'];?>"</h3><br/><? endif;?>
<form action="http://<?=$_SERVER['HTTP_HOST'];?>/admin/static_pages/<?=$module[3];?>/<?=$module[4];?>" method="post" id="form_static">
<input type="hidden" name="ID" value="<?=$module[4];?>" />
<table id="edit_page">    
        <? for($i = 0;$i < count($View->langs);$i++):?>
        <tr>
            <td>Заголовок на <?=$languages[$View->langs[$i]];?> мові</td>
            <td><input type="text" class="edit_inputs" value="<? if($module[3] == 'edit' || $View->keyExists("error")): ?><?=$View->page_info['title_'.$View->langs[$i]];?><?endif;?>" name="title_<?=$View->langs[$i];?>" id="title_<?=$View->langs[$i];?>"/></td>
        </tr>
        <? endfor; ?>
        <tr><td colspan="2" class="hrr"></td></tr>
        <? for($i = 0;$i < count($View->langs);$i++):?>
        <tr>
          <!-- <td valign="top"></td>-->
           <td colspan="2">
               <span>Текст на <?=$languages[$View->langs[$i]];?> мові</span>
               <textarea id="editor_<?=$View->langs[$i];?>" name="text_<?=$View->langs[$i];?>"><? if($module[3] == 'edit' || $View->keyExists("error")): ?><?=$View->page_info['text_'.$View->langs[$i]];?><?endif;?></textarea>
           </td>
        </tr>
        <?endfor;?>
        <tr><td colspan="2" class="hrr"></td></tr>
        <tr>
            <td>Опублікувати</td>
            <td><select name="is_show" style="width:100px">
                    <option value="n" <? if($View->page_info['active'] == 'n'): ?>selected<?endif;?>>Ні</option>
                    <option value="y" <? if($View->page_info['active'] == 'y'): ?>selected<?endif;?>>Так</option>
                </select></td>
        </tr>
        <tr>
            <td>Позиція сторінки</td>
            <td><input type="text" value="<? if($module[3] == 'edit' || $View->keyExists("error")): ?><?=$View->page_info['position'];?><?endif;?>" name="position" id="position"/>&nbsp;(ціле число)</td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" style="width:100px;height:30px;" value="<? if($module[3] == 'edit'): ?>зберегти<? elseif($module[3] == 'add'):?>додати<?endif;?>" /></td>
        </tr>
</table>
</form>

<script type="text/javascript" charset="utf-8">
		$().ready(function() {
			var opts = {
				cssClass : 'el-rte',
				lang     : 'ru',
                                styleWithCss : true,
                                fmAllow  : true,
				height   : 400,
				toolbar  : 'maxi',				
                                fmOpen: function(callback) {
					$('<div id="myelfinder" />').elfinder({
						url : 'http://<?=$_SERVER['HTTP_HOST'];?>/admin/static/elfinder/connectors/php/connector.php',
						lang : 'ru',
						dialog : { width : 800, modal : true, title : 'Files' },
						closeOnEditorCallback : true,
						editorCallback : callback
					})
                                }
			}
                        <? for($i=0;$i<count($View->langs);$i++):?>
                            $('#editor_<?=$View->langs[$i];?>').elrte(opts);
                        <? endfor;?>
		})
</script>
<div id="myelfinder"></div>
