<? if (!defined("entrypoint"))die;?>

<?
$View->subjects_id = $user->getProfessorSubjectsIds();
$View->subjects = $user->getProfessorSubjects();
?>

<div id="profile">

    <h3 align="center">Create rating table</h3>

    <form action="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/rating/" method="post" id="addColForm">
        <div style="padding: 5px; background-color: silver; margin-top: 5px; margin-left: 140px; margin-right: 140px;">

            <div>
                <div class="lable">Предмет</div>

                <select name="subject" id="subject" class="m_select">
                    <option>...</option>
                    <? for($i=0;$i<count($View->subjects_id);$i++): ?>
                    <option value="<?=$View->subjects_id[$i];?>"><?=$View->subjects[$i]['Title'];?></option>
                    <? endfor;?>
                </select>
            </div>

            <div id="groupes" style="clear: left;">
                <div class="lable">Группа</div>

                <select name="groupes" class="m_select">
                    <!--<?//for($i=1; $i<13; $i++):?>
                        </option>KM-<?//=$i;?></option>
                    <?//endfor;?>-->
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
        <input type="submit" name="createTable" id="createTable" value="Создать таблицу" class="button"/>
    </div>


    <script type="text/javascript">
        $(document).ready(function(){
            $("#groupes").hide(); $("#max_bal").hide(); $("#add_button").hide();

            $("#groupes").change(function(){
                if($("#groupes > select").val() == '...') {
                    $("#max_bal").hide(); $("#add_button").hide();
                } else {
                    $("#max_bal").show("slow"); $("#add_button").show("slow");
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
                $("#groupes").hide();$("#max_bal").hide(); $("#add_button").hide();
                if($("#subject").val() != '...') {
                    $.ajax({
                        type:"POST",
                        url:'http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/ajax/create_table/',
                        cache:false,
                        data:"subject="+$("#subject").val(),
                        success:function(data)
                        {
                            var groupes = eval("(" + data + ")");

                            var html='<option>...<\/option>';
                            var i = 0, key;

                            for (key in groupes) {
                                if (groupes.hasOwnProperty(key)) 
                                    html += '<option>KM-'+groupes[i++]+'<\/option>';
                            }
                            $("#groupes > select").html(html);
                            $("#groupes").show("slow");
                        }
                    });
                }
            });
        });
    </script>

</div>