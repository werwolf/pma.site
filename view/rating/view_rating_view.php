<? if (!defined("entrypoint"))die;?>

<div id="profile">
    <div class="top_container" style="display: inline-block">
        <div class="top_container_label"><?=$labels['profile']['group'];?>
            <select name="group" id="group" class=""></select>&nbsp;&nbsp;
            <div id="subjects" style="display: inline">
                <?=$labels['fileshare']['subject'];?>
                <select name="subject" id="subject" class=""></select>
            </div>
        </div>
        <div id="ajax_loader"><img alt="loading..." src="http://<?=$_SERVER['HTTP_HOST'];?>/static/img/basic/ajax_loader_Tedit.gif"/></div>
    </div>

    <table id="desttable"></table>

</div>