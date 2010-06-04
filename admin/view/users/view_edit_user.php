<?php if(!defined("entrypoint"))die();?>
<script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/admin/static/js/edits.js"></script>
<? if($View->keyExists("error_pass")):?>
    <b style="color:red;font-size:20px">Паролі не співпадають.</b><br/><br/>
<? endif;?>
<form action="" method="post" id="edit">
    <input type="hidden" name="add"/>
    <table class="user_add">
        <tr>
            <td>Им'я</td>
            <td><input type="text" name="name" value="<?=$user_info['Name'];?>"/></td>
        </tr>
        <tr>
            <td>Прізвище</td>
            <td><input type="text" name="surname" value="<?=$user_info['Surname'];?>"/></td>
        </tr>
        <tr>
            <td>По батькові</td>
            <td><input type="text" name="patronymic" value="<?=$user_info['Patronymic'];?>"/></td>
        </tr>
        <? if($module[4] == "lectors"):?>
        <tr>
            <td>Лектор</td>
            <td>
                <select style="width:120px" name="lector">
                    <option value="1" <?if(Root::POSTString("Lector")==1):?>selected<?endif;?><?if($user_info['Lector'] == 0):?>selected<?endif;?>>Лектор</option>
                    <option value="0" <?if(Root::POSTString("Lector")==0):?>selected<?endif;?><?if($user_info['Lector'] == 1):?>selected<?endif;?>>Не лектор</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Предмети</td>
            <td>
                <div>Доступні</div>
                    <select size="5" style="float:left;width:180px;margin-right:10px" id="left">
                        <?foreach($View->left_subjects as $key=>$val):?>
                            <? if($subjects->getSubjectNameById($val) != ""): ?>
                                <option value="<?=$val;?>"><?=$subjects->getSubjectNameById($val);?></option>
                            <? endif;?>
                        <? endforeach;?>
                    </select>
                    <div style="float:left;">
                        <a onclick="left_to_right()" style="display:block;border:1px solid #eee;width:30px;text-align:center;text-decoration:none">&nbsp;>&nbsp;</a><br/>
                        <a onclick="right_to_left()" style="display:block;border:1px solid #eee;width:30px;text-align:center;text-decoration:none">&nbsp;<&nbsp;</a>
                    </div>
                
                    <select name="subjects[]" multiple size="5" style="float:left;width:180px;margin-left:10px" id="right">
                        <? for($i = 0;$i< count($View->right_subjects);$i++):?>
                            <? if($subjects->getSubjectNameById($View->right_subjects[$i])!=""):?>
                                <option value="<?=$View->right_subjects[$i]?>"><?=$subjects->getSubjectNameById($View->right_subjects[$i])?></option>
                            <?endif;?>
                        <? endfor;?>
                    </select>
            </td>
        </tr>
        <? endif;?>
        <? if($module[4] == "students"):?>
        <tr>
            <td>Посада</td>
            <td>
                <select style="width:120px" name="state">
                    <option value="student" <?if(Root::POSTString("state")=="student"):?>selected<?endif;?><?if($user_info['State'] == "student"):?>selected<?endif;?>>Студент</option>
                    <option value="praepostor" <?if(Root::POSTString("state")=="praepostor"):?>selected<?endif;?><?if($user_info['State'] == "praepostor"):?>selected<?endif;?>>Староста</option>
                    <option value="trade-union" <?if(Root::POSTString("state")=="trade-union"):?>selected<?endif;?><?if($user_info['State'] == "trade-union"):?>selected<?endif;?>>Профорг</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Група</td>
            <td>
                <select name="group">
                <? foreach($groups as $key=>$val): ?>
                    <option value="<?=$val['ID'];?>" <? if($user_info['Groupe_ID'] == $val['ID']):?> selected<?endif;?>><?=$val['Title'];?></option>
                <? endforeach;?>
                </select>
            </td>
        </tr>
        <? endif;?>
        <tr>
            <td>E-mail</td>
            <td><input type="text" value="<?=$user_info['Email'];?>" name="email"/></td>
        </tr>
        <tr>
            <td>
                Пароль
            </td>
            <td>
                <input type="password" name="pass1"/><br/>
                <input type="password" name="pass2"/>
            </td>
        </tr>
    </table>
    <? if($module[4] == "students"):?><input type="submit" value="змінити"/><?endif;?>
</form>
    <? if($module[4] == "lectors"):?><input onclick="submitEditSubject()" type="submit" value="Змінити" style="width:100px;padding:3px;margin-top:10px"/><?endif;?>