<? if (!defined("entrypoint"))die;?>
<script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/js/mail.js"></script>
<br/>
<div style="width:100%;background-color:#BCBECB;height:25px;border:1px solid #E2DEDF;margin:0;padding:0">
    <table style="color:#fff;width:100%">
        <tr>
            <td align="left" style="width:40px">№</td>
            <td align="left"><?=$labels['mail']['Subject'];?></td>
            <td align="left" style="width:200px"><?=$labels['mail']['from'];?></td>
            <td align="right" style="width:40px">                
            </td>
        </tr>
    </table>
</div>
<? for($i=0;$i<$mails->getMailsCount();$i++): ?>

<div style="width:100%;background-color:#fff;border:1px solid #E2DEDF;padding:0;margin:0">
    <table style="width:100%">
        <tr>
            <td align="left" style="width:40px" valign="top"><?=($i+1);?></td>
            <td align="left" valign="top"><?=$mails->getOneMailParam($i,'Subject');?></td>
            <td align="left" style="width:200px" valign="top"><?=$mails->getOneMailParam($i,'Surname');?>&nbsp;<?=$mails->getOneMailParam($i,'Name');?></td>
            <td align="right" style="width:40px" valign="top">
                <b onclick="showMail('message<?=$i;?>','<?=$i;?>')" style="display:block" id="show<?=$i;?>"><img src="http://<?=$_SERVER['HTTP_HOST'];?>/static/img/arrow_down.png"/></b><b onclick="hideMail('message<?=$i;?>','<?=$i;?>')" style="display:none" id="hide<?=$i;?>"><img src="http://<?=$_SERVER['HTTP_HOST'];?>/static/img/arrow_up.png"/></b>
            </td>
        </tr>
    </table>    
</div>
<div style="display:none;width:99%;background-color:#f8f3f3;margin:0;padding:0;margin-left:1px;padding:3px" id="message<?=$i;?>">
                <?=$mails->getOneMailParam($i,'Text');?>
</div>

<? endfor;?>
