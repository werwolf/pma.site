<?php if (!defined("entrypoint"))die; ?>
<? foreach($groups as $key=>$val):?>
    <input type="checkbox" id="<?=$val['ID'];?>"/>&nbsp;<label><a style="cursor:pointer" onclick="getStudents('<?=$val['ID'];?>')"><?=$val['Title'];?></a></label><br/>
<? endforeach;?>