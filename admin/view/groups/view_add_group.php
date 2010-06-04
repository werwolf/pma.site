<?if(!defined("entrypoint"))die();?>
<link rel="stylesheet" type="text/css" media="screen" href="http://<?=$_SERVER['HTTP_HOST'];?>/static/css/datepicker.css" />
<script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/js/jquery.js"></script>
<script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/js/datepicker.js"></script>
<? if($View->keyExists("error")):?><b style="color:red;font-size:20px">Назва групи та дата вступу мають бути введені</b><br/><br/><?endif;?>
<h3><? if($module[3]=="add"):?>Додати<?elseif($module[3]=="edit"):?>Редагувати<?endif;?> Групу<?if($module[3]=="edit"):?>&nbsp;"<?=$View->group['Title'];?>"<?endif;?></h3><br/><br/>
<form action="" method="post">
    <input type="hidden" value="add" name="<?if($module[3]=="edit"):?>edit<?else:?>add<?endif;?>"/>
    <input type="hidden" value="<?=$user->getUserSecret()?>" name="secret"/>
    <table class="user_add">
        <tr>
            <td>Назва</td>
            <td><input type="text" name="title" <?if($module[3]=="edit"):?>value="<?=$View->group['Title'];?>"<?endif;?><? if($View->keyExists("error")):?>value="<?=Root::POSTString("title");?>"<?endif;?>/></td>
        </tr>
        <tr>
            <td>Дата вступу</td>
            <td>
                <input name='course' id='course' style="width:200px" readonly <?if($module[3]=="edit"):?>value="<?=$groups->getDate($View->group['Course']);?>"<?endif;?> <? if($View->keyExists("error")):?>value="<?=Root::POSTString("course");?>"<?endif;?>/>
                <input type="button" style="background: url('http://<?=$_SERVER['HTTP_HOST'];?>/static/img/datepicker.jpg') no-repeat; width: 30px; border: 0px;" onclick="displayDatePicker('course', false, 'dmy', '.')" readonly/>
            </td>            
        </tr>
        <tr>
            <td>Форма</td>
            <td>
                <select name="extranumeral" style="width:120px">
                    <option value="1" <?if($module[3]=="edit"):?><?if ($View->group['Extranumeral'] == 1):?>selected<?endif;?><?endif;?>>Заочна</option>
                    <option value="0" <?if($module[3]=="edit"):?><?if ($View->group['Extranumeral'] == 0):?>selected<?endif;?><?endif;?>>Очна</option>
                </select>
            </td>
        </tr>
    </table>
    <input type="submit" value="<?if($module[3]=="edit"):?>Змінити<?else:?>Додати<?endif;?>" style="padding:3px;width:100px;margin-top:10px"/>
</form>
