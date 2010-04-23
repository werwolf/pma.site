<? if (!defined("entrypoint"))die;?>
<div id="profile">
    <div style="color:red;font-weight:bold">
        <? if($View->keyExists('cover_success') && $View->keyExists('file_success')):?>
            <?=$labels['fileshare']['upload_success'];?>.
        <? endif;?>
        <? if($View->keyExists("permition_denied")) :?>
            <?=$labels['fileshare']['error_permition'];?>!<br/>
        <? endif;?>
        <? if($View->keyExists("cant_upload_file")) :?>
            <?=$labels['fileshare']['error_upload_file'];?>!<br/>
        <? endif;?>
        <? if($View->keyExists("file_to_big")) :?>
            <?=$labels['fileshare']['error_file_to_big'];?>!<br/>
        <? endif;?>
        <? if($View->keyExists("cant_upload_cover")) :?>
            <?=$labels['fileshare']['error_upload_cover'];?>!<br/>
        <? endif;?>
        <? if($View->keyExists("cover_to_big")) :?>
            <?=$labels['fileshare']['error_cover_to_big'];?>!<br/>
        <? endif;?>
    </div>
    <form action="" method="post" enctype="multipart/form-data" id="upload_file">
        <table class="user_data">
            <tr>
                <td><?=$labels['fileshare']['picture'];?></td>
                <td align="left"><input type="file" name="cover" id="cover" onchange="checkCover('http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/ajax/check_file')"/><b id="cover_accept"></b></td>
            </tr>
            <tr>
                <td><?=$labels['fileshare']['file'];?></td>
                <td><input type="file" name="file" id="file" onchange="checkFile('http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/ajax/check_file')"/><b id="file_success"></b></td>
            </tr>
            <tr>
                <td><?=$labels['fileshare']['subject'];?></td>
                <td><select name="subject">
                        <? for($i=0;$i<count($View->subjects_id);$i++): ?>
                            <option value="<?=$View->subjects_id[$i];?>"><?=$View->subjects[$i]['Title'];?></option>
                        <? endfor;?>
                    </select></td>
            </tr>
            <tr>
                <td><?=$labels['fileshare']['semest'];?></td>
                <td><select name="semestr">
                        <? for($i=1;$i<13;$i++):?>
                        <option><?=$i;?></option>
                        <?endfor;?>
                    </select></td>
            </tr>
            <tr>
                <td><?=$labels['fileshare']['title'];?></td>
                <td><input type="text" name="title" id="title_file"/></td>
            </tr>

            <tr>
                <td><?=$labels['fileshare']['description'];?></td>
                <td><textarea style="width:480px;height:200px;" name="description"></textarea></td>
            </tr>
        </table>
        <input type="hidden" name="action" value="upload"/>
        <input type="hidden" name="user_secret" value="<?=$user->getUserSecret();?>"/>
    </form>
    <div style="margin-top:30px;text-align:right;margin-right:18px">
        <button onclick="check_file()"><?=$labels['fileshare']['upload'];?></button>
    </div>
</div>