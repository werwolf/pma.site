var cover = true;
var file = false;
function check_file()
{
    var title = $("#title_file").val();
    var title_len = title.length;

    if(title_len > 0 && cover && file)
       $("#upload_file").submit();
    else if(title_len == 0)
        $("#title_file").css("background-color","red");
}

function checkCover(url_check)
{
    $.ajax({
        type:"POST",
        url:url_check,
        cache:false,
        data:"cover="+$("#cover").val(),
        success:function(data)
        {
            if(data == "true")
            {
                $("#cover_accept").html("<img src='static/img/check.png' style='width:20px;height:20px;border:0'/>");
                cover = true;
            }
            else
            {
                $("#cover_accept").html("<img src='static/img/close.png' style='width:20px;height:20px;border:0'/>");
                cover = false;
            }
        }
    });
}
function checkFile(url_check)
{
    $.ajax({
        type:"POST",
        url:url_check,
        cache:false,
        data:"filename="+$("#file").val(),
        success:function(data)
        {
            if(data == "true")
            {
                $("#file_success").html("<img src='static/img/check.png' style='width:20px;height:20px;border:0'/>");
                file=true;
            }
            else
            {
                $("#file_success").html("<img src='static/img/close.png' style='width:20px;height:20px;border:0'/>");
                file=false;
            }
        }
    });
}