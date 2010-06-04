<?php if(!defined("entrypoint"))die;?>
    <input type="hidden" id="month_number" value="<?=$View->month_c;?>"/>
    <input type="hidden" id="current_month" value="<?=$View->current_month;?>"/>
    <div class="header_calendar" align="center">
        <a href="javascript:void(0)" class="prev_month" onclick="getPrevMonth()"></a>
        <span><?=$View->month;?></span>
        <a href="javascript:void(0)" class="next_month" onclick="getNextMonth()"></a>
    </div>
    <table cellpadding="0" cellspacing="0">
    <tr>
        <th><?=$labels['calendar']['monday'];?></th>
        <th><?=$labels['calendar']['tuesday'];?></th>
        <th><?=$labels['calendar']['wednesday'];?></th>
        <th><?=$labels['calendar']['thursday'];?></th>
        <th><?=$labels['calendar']['friday'];?></th>
        <th><?=$labels['calendar']['saturday'];?></th>
        <th><?=$labels['calendar']['sunday'];?></th>
    </tr>
    <? foreach($calendar as $key=>$val): ?>
        <tr>
            <? foreach($val as $key_1=>$val_1): ?>
            <td  valign="top" <? if($key_1 == 6 || $key_1 == 5):?>class='freeday'<?endif;?>>
                <div class="date">
                    <b onclick="addMessage('<?=$val_1;?>')" style="cursor:pointer" title="<?=$labels['calendar']['addMessage'];?>"><?=$val_1;?></b>
                </div>
                <div style="position:relative;top:40px">
                <? if($calendar->isWithMessage($val_1)):?>
                        <? if($calendar->getFrom() == $user->getUserId()):?>
                            <div style="position:relative;left:3px;top:-30px;cursor:pointer" onclick="getMessages('<?=$val_1;?>','my')">
                            <!--<?if($View->current_month > 2 && $View->current_mont < 6): ?>-->
                                <img src="http://<?=$_SERVER['HTTP_HOST'];?>/static/img/spring_calendar_otvr.png"/>
                            <!--<?endif;?>-->
                            </div>
                        <?else:?>
                            <div style="position:relative;left:55px;top:-40px;cursor:pointer" onclick="getMessages('<?=$val_1;?>','inbox')">
                              <? $date = getDate();;?>
                              <? if($date['mon'] == $View->current_month && ($date['mday']+1) == $val_1):?>
                                <!--<?if($View->current_month > 2 && $View->current_month < 6): ?>-->
                                    <img src="http://<?=$_SERVER['HTTP_HOST'];?>/static/img/spring_calendar_vosk.png"/>
                                <!--<?endif;?>-->
                              <? else:?>
                                <!--<?if($View->current_month > 2 && $View->current_month < 6): ?>-->
                                    <img src="http://<?=$_SERVER['HTTP_HOST'];?>/static/img/spring_calendar_vosk_norm.png"/>
                                <!--<?endif;?>-->
                              <?endif;?>
                            </div>
                        <?endif;?>
                <?endif;?>
                </div>
            </td>
            <? endforeach; ?>
        </tr>
    <? endforeach; ?>    
    </table>
