<?php if (!defined("entrypoint"))die; ?>
<? foreach($users as $key=>$val):?>
    <input type="checkbox" id="<?=$val['user'];?>"/>&nbsp;<?=$val['Surname'];?>&nbsp;<?=$val['Name'];?>&nbsp;<?=$val['Patronymic'];?><br/>
<? endforeach;?>