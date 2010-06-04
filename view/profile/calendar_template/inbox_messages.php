<?php if (!defined("entrypoint"))die;?>
<ul class="inbox_messages">
<? foreach($calendar as $key=>$val): ?>
    <? if($val['Text']!=""): ?>
        <li><b style="color:#444444"><?=($key+1);?>)</b>&nbsp;
            <?if($type=="inbox"):?><b style="color:#444"><?=$labels['calendar']['from'];?></b>&nbsp;<?=$val['Surname']." ".$val['Name']." ".$val['Patronymic'];?><br/><?endif;?>
            <? if(trim($val['Subject']) != ""):?>
                    <?=$labels['calendar']['subject'];?>:&nbsp;"<?=$val['Subject'];?>"
            <?else:?>
                    <?=$labels['calendar']['without_subject'];?>
            <?endif;?>
            <br/><hr/>
            <?=$val['Text'];?>
        </li>
    <?endif;?>
<? endforeach;?>
</ul>
