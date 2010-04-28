<? if($View->keyExists("error")):?><b style='color:red;font-size:20px'>Усі заголовки мають бути введені.</b><br/><br/><?endif;?>
<h3><? if($module[3]=='add'):?>Додати новину<?elseif($module[3]=='edit'):?>Редагувати новину "<?=$View->news['title_ua'];?>"<?endif;?></h3>

<br/>
<form action="http://<?=$_SERVER['HTTP_HOST'];?>/admin/news/<?=$module[3];?>" method="post" id="form_static">
<? if($module[3] == 'add'): ?>
    <input type="hidden" value="new" name="add_new"/>
<?endif;?>
<? if($module[3] == 'edit'): ?>
    <input type="hidden" value="<?=$module[4];?>" name="ID"/>
<? endif; ?>
<table id="edit_page">
    <? for($i=0;$i<count($View->langs);$i++): ?>
    <tr>
        <td>Заголовок на <?=$languages[$View->langs[$i]];?> мові</td>
        <td><input type="text" name="title_<?=$View->langs[$i];?>" class="edit_inputs" id="title_<?=$View->langs[$i];?>" value="<? if($module[3] == 'edit' || $View->keyExists("error")): ?><?=$View->news['title_'.$View->langs[$i]];?><?endif;?>"/></td>
    </tr>
    <? endfor;?>
    <tr><td class="hrr" colspan="2"></td></tr>
    <? for($i = 0;$i < count($View->langs);$i++):?>
    <tr>
        <td colspan="2">
             <span>Текст на <?=$languages[$View->langs[$i]];?> мові</span>
             <textarea id="editor_<?=$View->langs[$i];?>" name="text_<?=$View->langs[$i];?>"><? if($module[3] == 'edit' || $View->keyExists("error")): ?><?=$View->news['text_'.$View->langs[$i]];?><?endif;?></textarea>
        </td>
    </tr>
    <?endfor;?>
    <tr><td colspan="2" class="hrr"></td></tr>
    <tr>
        <td>Публікувати</td>
        <td>
            <select name="is_active" style="width:100px">
                <option value="y" <? if($View->news['active'] == 'y'): ?>selected<?endif;?>>Так</option>
                <option value="n" <? if($View->news['active'] == 'n'): ?>selected<?endif;?>>Ні</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Внутрішня</td>
        <td>
            <select name="internal" style="width:100px">
                <option value="y" <? if($View->news['internal'] == 'y'): ?>selected<?endif;?>>Так</option>
                <option value="n" <? if($View->news['internal'] == 'n'): ?>selected<?endif;?>>Ні</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Можливість коментувати</td>
        <td>
            <select name="is_comment" style="width:100px">
                <option value="y" <? if($View->news['comments'] == 'y'): ?>selected<?endif;?>>Так</option>
                <option value="n" <? if($View->news['comments'] == 'n'): ?>selected<?endif;?>>Ні</option>
            </select>
        </td>
    </tr>
    <tr><td colspan="2"><input type="submit" value="<? if($module[3] == 'edit'): ?>зберегти<? elseif($module[3] == 'add'):?>додати<?endif;?>" style="width:100px;height:30px"/></td></tr>
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
