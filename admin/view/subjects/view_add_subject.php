<?if(!defined("entrypoint"))die();?>
<? if($module[3] == "edit"):?>
<script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/admin/static/js/edits.js"></script>
<? endif;?>
<? if($View->keyExists("error")):?><b style="color:red;font-size:20px">Всі назви мають бути введені.Хоча б один семестр має бути вибраний.</b><br/><br/><?endif;?>
<h3><? if($module[3]=="add"):?>Додати<?elseif($module[3]=="edit"):?>Редагувати<?endif;?> Предмет<?if($module[3]=="edit"):?>&nbsp;"<?=$View->subject['Title_ua'];?>"<?endif;?></h3><br/><br/>
<form action="" method="post" id="edit">
    <input type="hidden" value="add" name="<?if($module[3]=="edit"):?>edit<?else:?>add<?endif;?>"/>
    <input type="hidden" value="<?=$user->getUserSecret()?>" name="secret"/>
    <table class="user_add">
        <? for($i = 0;$i < count($View->langs);$i++):?>
        <tr>
            <td style="width:250px">Назва на <?=$languages[$View->langs[$i]];?> мові</td>
            <td><input type="text" name="Title_<?=$View->langs[$i];?>" <?if($module[3] == 'edit'):?>value="<?=$View->subject['Title_'.$View->langs[$i]];?>" <?endif;?><? if($View->keyExists("error")):?>value="<?=$_GET["Title_".$View->langs[$i]];?>"<?endif;?>/></td>
        </tr>
        <?endfor;?>
        <tr>
            <td>Семестри</td>
            <td>
                <? if($module[3] == "add"): ?>
                    <select name="semesters[]" multiple size="5" style="width:80px">
                    <? for($i=1;$i<13;$i++):?>
                        <option><?=$i;?></option>
                    <?endfor;?>
                    </select>
                <? elseif($module[3] == "edit"): ?>
                <div>Доступні</div>
                    <select size="5" style="float:left;width:80px;margin-right:10px" id="left">
                        <? foreach($View->left_semestr as $key=>$val): ?>
                            <? if ($val != ""): ?>
                                <option><?=$val?></option>
                            <? endif;?>
                        <? endforeach;?>
                    </select>
                    <div style="float:left;">
                        <a onclick="left_to_right()" style="display:block;border:1px solid #eee;width:30px;text-align:center;text-decoration:none">&nbsp;>&nbsp;</a><br/>
                        <a onclick="right_to_left()" style="display:block;border:1px solid #eee;width:30px;text-align:center;text-decoration:none">&nbsp;<&nbsp;</a>
                    </div>
                
                    <select name="semesters[]" multiple size="5" style="float:left;width:80px;margin-left:10px" id="right">
                        <? for($i=0;$i<count($View->right_semestr);$i++):?>
                            <? if($View->right_semestr[$i] != ""):?>
                                <option><?=$View->right_semestr[$i];?></option>
                            <? endif;?>
                        <? endfor;?>
                    </select>
                <? endif;?>
            </td>
        </tr>
    </table>
    <? if($module[3] == "add"):?><input type="submit" value="Додати" style="width:100px;padding:3px;margin-top:10px"/><?endif;?>
</form>
<? if($module[3] == "edit"):?><input onclick="submitEditSubject()" type="submit" value="Змінити" style="width:100px;padding:3px;margin-top:10px"/><?endif;?>