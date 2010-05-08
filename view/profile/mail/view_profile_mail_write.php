<? if (!defined("entrypoint"))die;?>
<div id="send">
    <form action="" method="post">
    <input type="hidden" value="<?=$user->getUserSecret();?>"/>
    <div class="title"><?=$labels['mail']['new_message'];?></div>
    <table class="message">
        <tr>
            <td><?=$labels['mail']['from'];?>:</td>
            <td class="right"><?=$user->getUserSurname()." ".$user->getUserName()." ".$user->getUserPatronymic();?></td>
        </tr>
        <tr><td class="right"><?=$labels['mail']['to'];?>:</td><td></td></tr>
        <tr>
            <td class="right"><?=$labels['mail']['Subject'];?>:</td>
            <td><input name="subject" type="text"/></td>
        </tr>
        <tr>
            <td colspan="2"><br/>
                <?=$labels['mail']['message'];?><br/>
                <textarea name="message" rows="10">
                </textarea>
            </td>
        </tr>
    </table>
    <div class="submit">
        <input type="submit" value="<?=$labels['mail']['send'];?>" class="button_download" style="width:100px;height:25px"/>
    </div>
    </form>
</div>