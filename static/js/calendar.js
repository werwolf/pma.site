function loadCalendar(month)
{
    var data_p = "";

    if(month != "")
        data_p = "month="+month;
    
    $.ajax({
        type:"POST",
        //url:$("#url_ask").val(),
        url:'http://'+window.location.hostname+'/en/ajax/get_calendar/',
        cache:false,
        data:data_p,
        success:function(data)
        {
            $("#calendar").html(data);
        }
    });

}

function getNextMonth()
{
    var month = $("#month_number").val();    

    if(month < 12)
    {
        month++;
        loadCalendar(month);
    }
}
function getPrevMonth()
{
    var month = $("#month_number").val();

    if(month > 1)
    {
        month--;
        loadCalendar(month);
    }
}
function addMessage(date)
{
    $('#basic-modal-content').modal();
    $('#simplemodal-container').css("background-color","#fdfafa");

    $('#simplemodal-container').css("height","200px");
    $('#simplemodal-container').css("margin-top","100px");
    $("#add_date").val(date);
    $("#addMessage").css("display","block");
}
function addMessageForMe()
{
    var subject = $("#subject").val();
    var message = $("#messageMy").val();
    var month = $("#month_number").val();
    var date = $("#add_date").val();
    
    if(message != "")
    {
        $.ajax({
            type:"POST",
            url:$("#url_ask").val(),
            cache:false,
            data:"subject="+subject+"&text="+message+"&month="+month+"&day="+date+"&addMessage=true",
            success:function(data)
            {
                alert(data);
                var month = $("#month_number").val();
                loadCalendar(month);
            }
        });
    }
}
function getMesBegin()
{
    $("#basic-modal-content").modal();
    $('#simplemodal-container').css("background-color","#555");
    $('#simplemodal-container').css("height","400px");
    $('#simplemodal-container').css("margin-top","100px");
    $("#loading").css("display","block");
}
function getMesEnd(data)
{
    $("#loading").css("display","none");
    $('#simplemodal-container').css("background-color","#fdfafa");
    $("#inboxMessages").html(data);
    $("#inboxMessages").css("display","block");
}
function getMessages(date,type)
{
    getMesBegin();

    var dataPost = "";

    if(type == "inbox")
        dataPost = "getMessages=inbox&day="+date+"&month="+$("#month_number").val();
    else if(type == "my")
        dataPost = "getMessages=mymes&day="+date+"&month="+$("#month_number").val();
 
    $.ajax({
        type:"POST",
        url:$("#url_ask").val(),
        cache:false,
        data:dataPost,
        success:function(data)
        {
              getMesEnd(data);
        }
    });
}