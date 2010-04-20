<? if (!defined("entrypoint"))die;?>
<div id="profile">

    <form action="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/rating/" method="post" id="addColForm">
        <div style="padding: 5px; background-color: silver; margin-bottom: 5px;">
            <div class="lable" style="float: left; clear: right; margin-right: 5px; color: white; font-size: 17px;">Название колонки</div>
            <input type="text" name="colname" size="15" maxlength="100" value="" id="colname"/>
            <input type="submit" name="add" id="addCol"  value="Add" class="button"/>
        </div>
    </form>

    <h1>Create</h1>
</div>