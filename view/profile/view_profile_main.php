<? if (!defined("entrypoint"))die;?>
<div id="profile">
  <form action="" method="post">
    <input type="hidden" name="param" value="edit"/>
    <h2><?=$labels['profile']['user_profile'];?></h2>
    <table class="user_data">
        <tr>
            <td colspan="2">
                <img src="http://<?=$_SERVER['HTTP_HOST'];?>/static/uploaded/user_photo/<?=$user->getUserPhoto();?>"/>
            </td>
        </tr>
        <tr>
            <td colspan="2"><hr style="margin-top:10px;margin-bottom:10px"/></td>
        </tr>
        <tr>
            <td><?=$labels['profile']['surname'];?></td>
            <td><input type="text" style="width:200px" name="surname" value="<?=$user->getUserSurname();?>"/></td>
        </tr>
        <tr>
            <td><?=$labels['profile']['name'];?></td>
            <td><input type="text" style="width:200px" name="name" value="<?=$user->getUserName();?>"/></td>
        </tr>
        <tr>
            <td><?=$labels['profile']['patronymik'];?></td>
            <td><input type="text" style="width:200px" name="name" value="<?=$user->getUserPatronymic();?>"/></td>
        </tr>
        <tr>
            <td><?=$labels['profile']['status'];?></td>
            <td><input type="text" style="width:200px" name="name" value="<? if($user->getUserState() == "S"): ?><?=$labels['profile']['student'];?><? else:?><?=$labels['profile']['teacher'];?><?endif;?>" readonly/></td>
        </tr>
        <tr><td colspan="2"></td></tr>
        <tr>
            <td><?=$labels['profile']['sex'];?></td>
            <td><input type="text" style="width:200px" name="name" value="<? if($user->getUserSex() == "M"): ?><?=$labels['profile']['male'];?><? else:?><?=$labels['profile']['female'];?><?endif;?>"/></td>
        </tr>
        <tr>
            <td><?=$labels['profile']['birthday'];?></td>
            <td><input name='birthday' id='birthday' value="<?=$user->getDate($user->getUserBirthday());?>"/><input type="button" style="background: url('http://<?=$_SERVER['HTTP_HOST'];?>/static/img/datepicker.jpg') no-repeat; width: 30px; border: 0px;" onclick="displayDatePicker('birthday', false, 'dmy', '.')" readonly/></td>
        </tr>
        <tr><td colspan="2"></td></tr>
        <? if(get_class($user) == "Student"): ?>
            <tr>
                <td><?=$labels['profile']['group'];?></td>
                <td><input name='group' id='group' value='<?=$user->getUserGroupName();?>' style="width:200px"/></td>
            </tr>
            <tr>
                <td><?=$labels['profile']['rank'];?></td>
                <td><input name='group' id='group' value='<?=$labels['profile'][$user->getUserRank()];?>' style="width:200px"/></td>
            </tr>
        <? endif;?>
        <tr>
            <td colspan="2"><input type="submit" value="<?=$labels['profile']['save'];?>" class="save_profile"/></td>
        </tr>
    </table>
  </form>
</div>