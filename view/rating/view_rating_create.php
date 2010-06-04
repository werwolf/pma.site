<? if (!defined("entrypoint"))die;?>

<div id="profile">

    <h3 align="center"><?=$labels['rating']['create_table'];?></h3>

    <div style="padding: 5px; background-color: #70AAD0; margin-top: 8px; margin-left: 140px; margin-right: 140px;">
        <div>
            <div class="label"><?=$labels['fileshare']['subject'];?></div>
            <select name="subject" id="subject" class="m_select"></select>
        </div>

        <div id="groups" style="clear: left;">
            <div class="label"><?=$labels['profile']['group'];?></div>
            <select name="group" id="group" class="m_select"></select>
        </div>

        <div style="clear: left;" id="max_bal">
            <div class="label"><?=$labels['rating']['create_max'];?></div>
            <input type="text" size="15" maxlength="5" value="" id="bal"/>
        </div>

        <div style="clear: left;">
            <input type="submit" name="createTable" id="createTable" value=" <?$t=explode(' ',$labels['rating']['create_table']);echo $t[0];?> " class="button"/>
        </div>

        <div style="clear: left; font-family: Verdana; font-size: 18px; text-align: center;" id="info"></div>

        <div style="clear: left; height: 0;"></div>
    </div>
    
</div>