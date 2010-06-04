function showSelect()
{
    $('#basic-modal-content').modal();
    $('#simplemodal-container').css("background-color","#fdfafa");

    $('#simplemodal-container').css("height","400px");
    $('#simplemodal-container').css("margin-top","100px");
    
}
function getGroups()
{
    var whatdo = $("#showStudents").html();
    if(whatdo == "+")
    {
        var isLoad = $("#isGroupsLoad").val();

        if(isLoad == 0)
        {
            var url_1 = $("#url_to_get").val();

            $.ajax({
                type:"POST",
                url:url_1+"/getGroups",
                cache:false,
                success:function(data)
                {
                    $("#groups").html(data);
                    $("#groups").css("display","block");
                    $("#showStudents").html("-");
                    $("#isGroupsLoad").val('1');
                }
            });
        }
        else
        {
            $("#groups").css("display","block");
            $("#showStudents").html("-");
        }
    }
    else
    {
        $("#groups").css("display","none");
        $("#showStudents").html("+");
    }
}

function getProfessors()
{
    var url_1 = $("#url_to_get").val();

    $.ajax({
        type:"POST",
        url:url_1+"/getProfessors",
        cache:false,
        success:function(data)
        {
            $("#results").html(data);
        }
    });
}

function getStudents(group)
{
    var url_1 = $("#url_to_get").val();
    $.ajax({
        type:"POST",
        url:url_1+"/getStudents",
        cache:false,
        data:"groups="+group,
        success:function(data)
        {
            $("#results").html(data);
        }
    });
}