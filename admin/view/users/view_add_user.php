<?php if(!defined("entrypoint"))die();?>
<h3>Додати користувача "<? if($module[4] == "students"):?>Студента<?else:?>Викладача<?endif;?>"</h3><br/>
<?if($View->keyExists("error")):?><b style="color:red;font-size:20px">Логін та пароль мають бути вказаними.</b><?endif;?>
<form action="" method="post">
<input type="hidden" value="<?=$user->getUserSecret()?>" name="secret"/>
<table class="user_add">
    <tr>
        <td style="width:200px">Прізвище</td><td><input type="text" name="surname" value="<?if($View->keyExists("error")):?><?=Root::POSTString("surname");?><?endif;?>"/></td>
    </tr>
    <tr>
        <td>Ім’я</td><td><input type="text" name="name" value="<?if($View->keyExists("error")):?><?=Root::POSTString("name");?><?endif;?>"/></td>
    </tr>
    <tr>
        <td>По батькові</td><td><input type="text" name="patronymic" с/></td>
    </tr>
    <tr>
        <td>Стать</td><td><select name="sex" style="width:120px">
                <option value="M" <?if($View->keyExists("error")):?><?if(Root::POSTString("sex")=="M"):?>selected<?endif;?><?endif;?>>Чоловік</option>
                <option value="F" <?if($View->keyExists("error")):?><?if(Root::POSTString("sex")=="F"):?>selected<?endif;?><?endif;?>>Жінка</option></select>
        </td>
    </tr>
    <? if($module[4] == "students"):?>
        <tr>
            <td>Група</td>
            <td>
                <select name="group" style="width:120px">
                    <? foreach($groups as $key=>$val): ?>
                        <option value="<?=$val['ID'];?>" <?if($View->keyExists("error")):?><?if(Root::POSTString("group")==$val['ID']):?>selected<?endif;?><?endif;?>><?=$val['Title'];?></option>
                    <? endforeach;?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Посада</td><td><select style="width:120px" name="state">
                    <option value="student" <?if($View->keyExists("error")):?><?if(Root::POSTString("state")=="student"):?>selected<?endif;?><?endif;?>>Студент</option>
                    <option value="praepostor" <?if($View->keyExists("error")):?><?if(Root::POSTString("state")=="praepostor"):?>selected<?endif;?><?endif;?>>Староста</option>
                    <option value="trade-union" <?if($View->keyExists("error")):?><?if(Root::POSTString("state")=="trade-union"):?>selected<?endif;?><?endif;?>>Профорг</option>
                </select>
            </td>
        </tr>
    <? endif;?>
    <? if($module[4] == "lectors"):?>
        <tr>
            <td>Предмети</td>
            <td>
                <select name="subjects[]" multiple size="10">
                    <? foreach($subjects as $key=>$val): ?>
                        <option value="<?=$val['ID'];?>"><?=$val['Title_ua'];?></option>
                    <? endforeach;?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Лектор</td><td><select name="lector">
                    <option value="1" <?if($View->keyExists("error")):?><?if(Root::POSTString("lector")==1):?>selected<?endif;?><?endif;?>>Лектор</option>
                    <option value="0" <?if($View->keyExists("error")):?><?if(Root::POSTString("lector")==0):?>selected<?endif;?><?endif;?>>Не лектор</option>
                </select>
            </td>
        </tr>

    <?endif;?>
    <tr>
        <td>Логін&nbsp;<b style="color:red">*</b></td><td><input type="text" name="login" value="<?if($View->keyExists("error")):?><?=Root::POSTString("login");?><?endif;?>"/></td>
    </tr>
    <tr>
        <td>Пароль&nbsp;<b style="color:red">*</b></td><td><input type="text" name="password" value="<?if($View->keyExists("error")):?><?=Root::POSTString("password");?><?endif;?>"/></td>
    </tr>
</table>
    <input type="hidden" value="add" name="add"/>
    <input type="submit" value="Додати" style="margin-top:10px;padding:2px;width:100px"/>
</form>