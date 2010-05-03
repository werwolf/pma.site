<? if (!defined("entrypoint"))die;?>

<?
$View->subjects_id = $user->getProfessorSubjectsIds();
$View->subjects = $user->getProfessorSubjects();
?>

<div id="profile">

    <h3 align="center">Create rating table</h3>

    <div style="padding: 5px; background-color: silver; margin-top: 5px; margin-left: 140px; margin-right: 140px;">
        <div>
            <div class="label">Предмет</div>

            <select name="subject" id="subject" class="m_select">
                <option>...</option>
                <? for($i=0;$i<count($View->subjects_id);$i++): ?>
                <option value="<?=$View->subjects_id[$i];?>"><?=$View->subjects[$i]['Title'];?></option>
                <? endfor;?>
            </select>
        </div>

        <div id="groups" style="clear: left;">
            <div class="label">Группа</div>

            <select name="groups" class="m_select">
                <!--<?//for($i=1; $i<13; $i++):?>
                    </option>KM-<?//=$i;?></option>
                <?//endfor;?>-->
            </select>
        </div>

        <div style="clear: left;" id="max_bal">
            <div class="label">Максимальный бал</div>
            <input type="text" name="bal" size="15" maxlength="5" value="" id="bal"/>
        </div>

        <div style="clear: left;">
            <input type="submit" name="createTable" id="createTable" value="Создать таблицу" class="button"/>
        </div>

        <div style="clear: left; height: 0;"></div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#groups").hide(); $("#max_bal").hide(); $("#createTable").hide();

            $("#groups").change(function(){
                if($("#groups > select").val() == '...') {
                    $("#max_bal").hide(); $("#createTable").hide();
                } else {
                    $("#max_bal").show("slow"); $("#createTable").show("slow");
                }
            });

            $('#max_bal > input[type="text"]').keypress(function (e) {
                if( e.which!=8 && e.which!=13 && e.which!=0 && (e.which<48 || e.which>57)) {
                    $(this).addClass("focus");
                    return false;
                } else {
                    $(this).removeClass("focus");
                }
            });

            $('#max_bal > input[type="text"]').blur(function() {
                $(this).removeClass("focus");
            });

            $("#subject").change(function(){
                $("#groups").hide();$("#max_bal").hide(); $("#createTable").hide();
                if($("#subject").val() != '...') {
                    $.ajax({
                        type:"POST",
                        url:'http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/ajax/create_table/',
                        cache:false,
                        data:"subject="+$("#subject").val(),
                        success:function(data)
                        {
                            var groups = eval("(" + data + ")");

                            var html='<option>...<\/option>';
                            var i = 0, key;

                            for (key in groups) {
                                if (groups.hasOwnProperty(key)) 
                                    html += '<option>KM-'+groups[i++]+'<\/option>';
                            }
                            $("#groups > select").html(html);
                            $("#groups").show("slow");
                        }
                    });
                }
            });
        });
    </script>

</div>