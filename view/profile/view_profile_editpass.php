<? if (!defined("entrypoint"))die;?>
<h2><?=$labels['profile']['change_pass'];?></h2>
<br/>
<? if($View->keyExists("error")):?>
    <b style="color:red;font-size:16px"><?=$View->error;?></b><br/><br/>
<? endif;?>
<form action="" method="post">
<input type="hidden" name="secret" value="<?=$user->getUserSecret();?>"/>
<input type="hidden" name="edit"/>
<table>
    <tr>
        <td><?=$labels['login']['password_wrd'];?>:&nbsp;</td>
        <td><input type="password" name="password1" value=""/></td>
    </tr>
    <tr>
        <td><?=$labels['login']['double_pass'];?>:&nbsp;</td>
        <td><input type="password" name="password2" value=""/></td>
    </tr>
    <tr>
        <td colspan="2"><input type="submit" value="<?=$labels['profile']['change_pass'];?>" class="button_download" style="margin:0;margin-top:20px;font-size:16px;"/></td>
    </tr>
</table>

</form>