<? if (!defined("entrypoint"))die;?>
<div id="profile">

    <!-- - - - - - - - - - - - - -->
    <!-- remember to sync el_id  -->
    <!-- - - - - - - - - - - - - -->
    
    <div class="top_container">
        <div class="top_container_label"><?=$labels['rating']['top_label'];?></div>
        <select name="tablename" id="table_select">
            <option>...</option>
            <option>OS : KM-71</option>
            <option>OS : KM-72</option>
            <option>OS : KM-73</option>
        </select>
        <div id="ajax_loader"><img alt="loading..." src="http://<?=$_SERVER['HTTP_HOST'];?>/static/img/basic/ajax_loader_Tedit.gif"/></div>
    </div>

    <table id="desttable"></table>
    <div style="display:none;"><table id="et"></table></div>

    <input type="button" id="editb" value="<?=$labels['rating']['editb'];?>"/>

<!-- -->
    <div id="editbar">
        <div>
            <div class="editbar_label"><?=$labels['rating']['add_label'];?></div>
            <input id="labeledit" type="text" maxlength="20" class="editbar_input" />
            <input id="fooedit" type="text" maxlength="5" class="editbar_input" />
            <input id="addb" type="button" value="<?=$labels['rating']['addb'];?>"/>
        </div>

        <div style="padding-top: 5px;">
            <div class="editbar_label"><?=$labels['rating']['del_label'];?></div>
            <select id="delnum" name="tablename"></select>
            <input id="delb" type="button" value="<?=$labels['rating']['delb'];?>" />
        </div>

        <div style="padding: 5px 0;">
            <div class="editbar_label"><?=$labels['rating']['new_bal_label'];?></div>
            <select id="newrnum" name="tablename"></select>
            <input id="editr" type="text" maxlength="5" class="editbar_input" />
            <input id="editrb" type="button" value="<?=$labels['rating']['editrb'];?>" />
        </div>

        <div style="margin-top: 5px;">
            <input id="rest" type="button" disabled value="<?=$labels['rating']['rest'];?>" />
            <input id="savetable" type="button" value="<?=$labels['rating']['savetable'];?>" />
        </div>
    </div>
<!-- -->

</div>