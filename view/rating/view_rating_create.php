<? if (!defined("entrypoint"))die;?>

<div id="profile">

    <h3 align="center"><?=$labels['rating']['create_table'];?></h3>

    <div style="padding: 5px; background-color: silver; margin-top: 8px; margin-left: 140px; margin-right: 140px;">
        <div>
            <div class="label"><?=$labels['fileshare']['subject'];?></div>

            <select name="subject" id="subject" class="m_select">
                <option>...</option>
            </select>
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

        <div style="clear: left; height: 0;"></div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
//
            var ie_fixer=(navigator.appName == "Microsoft Internet Explorer")?"":"slow";
            if (navigator.appVersion.indexOf("Win")!=-1) navigator.appName=="Netscape"?$("#bal").width(148):$("#bal").width(146);
//
            var magic=[];
            updateSubjects();

            $("#groups").hide(); $("#max_bal").hide(); $("#createTable").hide();

            $("#subject").change(function(){
                $("#groups").hide();$("#max_bal").hide(); $("#createTable").hide();
                if($("#subject").val() != '...') {
                    var html='<option>...<\/option>';
                    var groups=magic[$("#subject").val()]["groups"];
                    for (var i=0;i<groups.length;i++) {
                        html += '<option value='+groups[i]["group_id"]+'>'+groups[i]["group_title"]+'<\/option>';
                    }
                    $("#group").html(html);
                    $("#groups").show(ie_fixer);
                }
            });

            $("#groups").change(function(){
                if($("#groups > select").val() == '...') {
                    $("#max_bal").hide(); $("#createTable").hide();
                } else {
                    $("#max_bal").show(ie_fixer); $("#createTable").show(ie_fixer); //$('#bal').focus();
                }
            });

            $("#bal").keypress(function (e) {
                if( e.which!=8 && e.which!=13 && e.which!=0 && (e.which<48 || e.which>57)) {
                    $(this).addClass("focus");
                    return false;
                } else {
                    $(this).removeClass("focus");
                }
                return true;
            });

            $("#max_bal > input[type='text']").blur(function() {
                $(this).removeClass("focus");
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

                            if (!result) {
                                alert("Ошибка базы данных при создании таблицы!");
                            } else {
                                alert("Таблица успешно создана!");
                                $("#groups").hide();$("#max_bal").hide(); $("#createTable").hide();
                                $('#subject option:first').attr('selected', 'yes');
                                $('#bal').val("");
                                updateSubjects();
                            }
                            return true;
                        }
                    });
                }
    
            });

            function updateSubjects(){
                $.ajax({
                    type:"POST",
                    url:'http://'+window.location.hostname+'/en/ajax/create_table/',
                    cache:false,
                    data:"do=init",
                    success:function(data)
                    {
                        magic = eval("(" + data + ")");
                        updateSelect(magic);
                    }
                });
                return true;
            }

            function updateSelect(magic){
                var html='<option>...<\/option>';
                if (magic) {
                    for (var i in magic) {
                        html += '<option value='+i+'>'+magic[i]["subject_title"]+'<\/option>';
                    }
                }
                $("#subject").html(html);
                return true;
            }
        });
    </script>

</div>