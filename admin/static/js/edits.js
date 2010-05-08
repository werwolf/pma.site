function left_to_right()
{
    var array_left = $("#left option:selected").val();
    var array_right = document.getElementById("right").options;
    var array_temp = document.getElementById("left").options;
    
    var html = "";

    for(var i = 0;i < array_right.length;i++)
    {
        html += "<option>"+array_right[i].value+"</option>";
    }
    html += "<option>"+array_left+"</option>";
    
    $("#right").html(html);

    html = "";
    
    for(i = 0;i < array_temp.length;i++)
    {        
        if(array_temp[i].value != array_left)
        {
            html += "<option>"+array_temp[i].value+"</option>";
        }
    }
    $("#left").html(html);
}
function right_to_left()
{
    var array_right = $("#right option:selected").val();
    var array_left = document.getElementById("left").options;
    var array_temp = document.getElementById("right").options;

    var html = "";

    for(var i = 0;i < array_left.length;i++)
    {
        html += "<option>"+array_left[i].value+"</option>";
    }
    html += "<option>"+array_right+"</option>";

    $("#left").html(html);

    html = "";

    for(i = 0;i < array_temp.length;i++)
    {
        if(array_temp[i].value != array_right)
        {
            html += "<option>"+array_temp[i].value+"</option>";
        }
    }
    $("#right").html(html);
}
function submitEditSubject()
{
    var count = document.getElementById("right").options;
    
    for(var i = 0;i < count.length; i++)
    {
        document.getElementById("right").options[i].selected = true;
    }
    document.getElementById("edit").submit();
}