<?php if (!defined("entrypoint"))die;?>
<script type='text/javascript' src='http://<?=$_SERVER['HTTP_HOST'];?>/static/js/basic.js'></script>
<script type='text/javascript' src='http://<?=$_SERVER['HTTP_HOST'];?>/static/js/jquery.simplemodal.js'></script>
<link type='text/css' href='http://<?=$_SERVER['HTTP_HOST'];?>/static/css/basic.css' rel='stylesheet' media='screen' />
<link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST'];?>/static/css/tablesort.css" type="text/css" media="screen" />

<input type="hidden" id="url_ask" value="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/ajax/get_calendar"/>

<div id="calendar">
    
</div>

<div id="basic-modal-content">
    <div id="addMessage" style="display:none">
        <input type="hidden" id="add_date"/>
        <table>
            <tr>
                <td><?=$labels['calendar']['subject'];?></td>
                <td><input id="subject" type="text" style="width:100%"/></td>
            </tr>
            <tr>
                <td colspan="2">
                    <?=$labels['calendar']['messageText'];?><br/>
                    <textarea style="width:100%;height:100px" id="messageMy"></textarea><br/>
                    <button onclick="addMessageForMe()" class="button_download" style="margin-left:0;margin-top:4px;font-size:14px;padding-left:5px;padding-right:5px"><?=$labels['calendar']['add'];?></button>
                </td>
            </tr>
        </table>
    </div>
    <div id="inboxMessages" style="display:none">
    </div>
    <div id="loading" class="loader" style="display:none">

    </div>
</div>
<script type="text/javascript">
    window.onload = loadCalendar("");
</script>