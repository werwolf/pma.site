/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var host;
var magic;

$(document).ready(function(){

    host = document.location.href.substr(0,window.location.hostname.length+10);
    //
    var ie_fixer = (navigator.appName == "Microsoft Internet Explorer")?"":"slow";
    if (navigator.appVersion.toLowerCase().indexOf("win") != -1) navigator.appName == "Netscape"?$("#bal").width(148):$("#bal").width(146);
    //
    magic = [];
    
    $("#groups").hide();
    $("#max_bal").hide();
    $("#createTable").hide();

    updateSubjects();

    $("#subject").change(function(){
        if($("#info").html() != "") $("#info").html("");
        $("#groups").hide();
        $("#max_bal").hide();
        $("#createTable").hide();
        if($("#subject").val() != '...') {
            var html = '<option>...<\/option>';
            var groups = magic[$("#subject").val()]["groups"];
            for (var i = 0; i < groups.length; i++) {
                html += '<option value='+groups[i]["group_id"]+'>'+groups[i]["group_title"]+'<\/option>';
            }
            $("#group").html(html);
            $("#groups").show(ie_fixer);
        }
    });

    $("#groups").change(function(){
        if($("#groups > select").val() == '...') {
            $("#max_bal").hide();
            $("#createTable").hide();
        } else {
            $("#max_bal").show(ie_fixer);
            $("#createTable").show(ie_fixer); //$('#bal').focus();
        }
    });

    $("#bal").keypress(function (e) {
        if( e.which != 8 && e.which != 13 && e.which != 0 && (e.which < 48 || e.which > 57)) {
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
        if ($('#bal').val() == "") {
            $('#bal').focus();
            $('#bal').addClass("focus");
        } else {
            $.ajax({
                type:"POST",
                url: host + '/ajax/create_table/',
                cache:false,
                data:"do=create_table&group_id="+$("#group").val()+"&subject_id="+$("#subject").val()+"&max_rating="+$('#bal').val(),
                success:function(data)
                {
                    var result = eval("(" + data + ")");

                    if (!result) {
                        //alert("Ошибка базы данных при создании таблицы!");
                        $("#info").css('color','red');
                        $("#info").html("<b>Ошибка базы данных при создании таблицы!</b>");
                    } else {
                        //alert("Таблица успешно создана!");
                        //$().css('border','2px solid #00FF00');
                        $("#info").css('color','green');
                        $("#info").html("<b>Таблица успешно создана!</b>");
                        $("#groups").hide();
                        $("#max_bal").hide();
                        $("#createTable").hide();
                        $('#subject option:first').attr('selected', 'yes');
                        $('#bal').val("");
                        updateSubjects();
                    }
                    return true;
                }
            });
        }

    });

})

function updateSubjects(){
    $.ajax({
        type:"POST",
        url:host + '/ajax/create_table/',
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
    var html = '<option>...<\/option>';
    if (magic) {
        for (var i in magic) {
            html += '<option value='+i+'>'+magic[i]["subject_title"]+'<\/option>';
        }
    }
    $("#subject").html(html);
    return true;
}