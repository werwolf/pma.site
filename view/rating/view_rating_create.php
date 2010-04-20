<? if (!defined("entrypoint"))die;?>
<div id="profile">

    <h3 align="center">Create rating table</h3>

    <form action="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/rating/" method="post" id="addColForm">
        <div style="padding: 5px; background-color: silver; margin-top: 5px; margin-left: 140px; margin-right: 140px;">
            
            <div>
                <div class="lable">Предмет</div>

                <select name="subject" id="subject">
                    <? for($i=1; $i<13; $i++):?>
                        <option><?=$i;?></option>
                    <?endfor;?>
                </select>
            </div>

            <div id="groupes" style="clear: left;">
                <div class="lable">Группа</div>

                <select name="groupes">
                    <? for($i=1; $i<13; $i++):?>
                        <option>KM-<?=$i;?></option>
                    <?endfor;?>
                </select>
            </div>

            <div style="clear: left;" id="max_bal">
                <div class="lable">Максимальный бал</div>
                <input type="text" name="colname" size="15" maxlength="100" value="" id="colname"/>
            </div>
            
            <div style="clear: left; height: 0;"></div>
        </div>
    </form>
    
    <div style="background-color: silver; margin-left: 140px; margin-right: 140px;" id="add_button">
        <input type="submit" name="add" id="addCol" value="Создать таблицу" class="button"/>
    </div>
    

    <script type="text/javascript">
        $(document).ready(function(){ $("#groupes").hide(); $("#max_bal").hide(); $("#add_button").hide();});
        $(document).ready(function(){ $("#subject").change( function(){ $("#groupes").show("slow"); }) ;});
        $(document).ready(function(){ $("#groupes").change( function(){ $("#max_bal").show("slow"); $("#add_button").show("slow");}) ;});
    </script>
    
</div>