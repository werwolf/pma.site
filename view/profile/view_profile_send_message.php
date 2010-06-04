<? if (!defined("entrypoint"))die;?>
<h3><?=$labels['mail']['send_message'];?></h3>
<div id="send">
    <table class="message">
        <tr>
            <td><label><?=$labels['mail']['subject'];?></label>:&nbsp;</td>
            <td><input type="text" name="subject"/></td>
        </tr>
        <tr>
            <td><label><?=$labels['mail']['to'];?></label>:&nbsp;</td>
            <td><button class="button_download" style="height:20px;width:100px;margin:0" onclick="showSelect()">select</button></td>
        </tr>
        <tr>
            <td colspan="2"><br/>
                <?=$labels['mail']['message'];?><br/>
                <textarea name="message"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="right">
                <button class="button_download" style="padding:2px 10px 2px 10px"><?=$labels['mail']['send'];?></button>
            </td>
        </tr>
    </table>
</div>
    <input type="hidden" id="secret" value ="<?=$user->getUserSecret();?>"/>
    <input type="hidden" id="sendMessage"/>
    <input type="hidden" id="url_to_get" value="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/ajax/send_message"/>
    <input type="hidden" id="isGroupsLoad" value="0"/>
<div id="basic-modal-content">
    <table>
        <tr>
            <td>
                <div id="to_whom">
                    <a style="cursor:pointer;" onclick="getProfessors()">Преподователи</a><br/>
                    <a><button id="showStudents" class="button_download" style="margin:0;width:20px;" onclick="getGroups()">+</button>&nbsp;Студенты</a>
                    <div id="groups" style="margin-left:10px;display:none"></div>
                </div>
            </td>
            <td style="width:30px"></td>
            <td>
                <div id="results"></div>
            </td>
        </tr>
    </table>
</div>