<? if (!defined("entrypoint"))die;?>

<?
$View->subjects_id = $user->getProfessorSubjectsIds();
$View->subjects = $user->getProfessorSubjects();
?>

<div id="profile">

    <h3 align="center"><?=$labels['rating']['create_table'];?></h3>

    <div style="padding: 5px; background-color: silver; margin-top: 5px; margin-left: 140px; margin-right: 140px;">
        <div>
            <div class="label"><?=$labels['fileshare']['subject'];?></div>

            <select name="subject" id="subject" class="m_select">
                <option>...</option>
                <? for($i=0;$i<count($View->subjects_id);$i++): ?>
                <option value="<?=$View->subjects_id[$i];?>"><?=$View->subjects[$i]['Title'];?></option>
                <? endfor;?>
            </select>
        </div>

        <div id="groups" style="clear: left;">
            <div class="label"><?=$labels['profile']['group'];?></div>

            <select name="groups" id="group" class="m_select"></select>
        </div>

        <div style="clear: left;" id="max_bal">
            <div class="label"><?=$labels['rating']['create_max'];?></div>
            <input type="text" size="15" maxlength="5" value="" id="bal"/>
        </div>

        <div style="clear: left;">
            <input type="submit" name="createTable" id="createTable" value=" <?$t=explode(' ',$labels['rating']['create_table']);echo $t[0];?> " class="button"/>
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
                    $("#max_bal").show("slow"); $("#createTable").show("slow"); //$('#bal').focus();
                }
            });

            $('#bal').keypress(function (e) {
                if( e.which!=8 && e.which!=13 && e.which!=0 && (e.which<48 || e.which>57)) {
                    $(this).addClass("focus");
                    return false;
                } else {
                    $(this).removeClass("focus");
                }
                return true;
            });

            $('#max_bal > input[type="text"]').blur(function() {
                $(this).removeClass("focus");
            });

            $("#subject").change(function(){
                $("#groups").hide();$("#max_bal").hide(); $("#createTable").hide();
                if($("#subject").val() != '...') {
                    $.ajax({
                        type:"POST",
                        url:'http://'+window.location.hostname+'/en/ajax/create_table/',
                        cache:false,
                        data:"do=get_groups",//&subject="+$("#subject").val(),
                        success:function(data)
                        {
                            var groups = eval("(" + data + ")");

                        //alert(groups);return true;
                        
                            var html='<option>...<\/option>';
                            for (var i=0;i<groups.length;i++) {
                                html += '<option value='+groups[i]["ID"]+'>'+groups[i]["Title"]+'<\/option>';
                            }
                            $("#groups > select").html(html);
                            $("#groups").show("slow");
                        }
                    });
                }
            });

            $("#createTable").click(function(){
            if ($('#bal').val()=="") {
            	$('#bal').focus();
            	$('#bal').addClass("focus");
            } else {
                $.ajax({
                    type:"POST",
                    url:'http://'+window.location.hostname+'/en/ajax/create_table/',
                    cache:false,
                    data:"do=create_table&group_id="+$("#group").val()+"&subject_id="+$("#subject").val()+"&max_rating="+$('#bal').val(),
                    success:function(data)
                    {
                        var result = eval("(" + data + ")");
                        if (result==-1) {
                            alert("Таблица уже существует!");
                            return true;
                        }
                        if (!result) {
                            alert("Ошибка базы данных при создании таблицы!");
                        } else {
                            alert("Таблица успешно создана!");
                            $("#groups").hide();$("#max_bal").hide(); $("#createTable").hide();
                            $('#subject option:first').attr('selected', 'yes');
                            $('#bal').val("");
                        }
                        return true;
                    }
                });
            }

        });
        });
    </script>

</div>