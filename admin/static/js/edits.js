function left_to_right()
{
    var array_left_index = document.getElementById("left").selectedIndex;
    var array_left = document.getElementById("left").options[array_left_index].value;
    
    if(array_left_index > -1)
    {
        var array_right = document.getElementById("right").options;
        var array_temp = document.getElementById("left").options;    
        var html = "";
        
        for(var i = 0;i < array_right.length;i++)
        {
            html += "<option value = '"+array_right[i].value+"'>"+array_right[i].textContent+"</option>";
        }
        html += "<option value = '"+array_temp[array_left_index].value+"'>"+array_temp[array_left_index].textContent+"</option>";
    
        $("#right").html(html);
        html = "";
    
        for(i = 0;i < array_temp.length;i++)
        {
            if(array_temp[i].value != array_left)
            {
                html += "<option value = '"+array_temp[i].value+"'>"+array_temp[i].textContent+"</option>";
            }
        }
        $("#left").html(html);
    }   
}
function right_to_left()
{
    var array_right_index = document.getElementById("right").selectedIndex;
    var array_right = document.getElementById("right").options[array_right_index].value;
    
    if(array_right_index > -1)
    {
        var array_left = document.getElementById("left").options;
        var array_temp = document.getElementById("right").options;
        var html = "";

        for(var i = 0;i < array_left.length;i++)
        {
            html += "<option value = '"+array_left[i].value+"'>"+array_left[i].textContent+"</option>";
        }
        html += "<option value = '"+array_temp[array_right_index].value+"'>"+array_temp[array_right_index].textContent+"</option>";

        $("#left").html(html);

        html = "";

        for(i = 0;i < array_temp.length;i++)
        {
            if(array_temp[i].value != array_right)
            {
                html += "<option value = '"+array_temp[i].value+"'>"+array_temp[i].textContent+"</option>";
            }
        }
        $("#right").html(html);
    }
}
function submitEditSubject()
{
    var count = document.getElementById("right").options;
    
    for(var i = 0;i < count.length; i++)
    {
        if(document.getElementById("right").options[i].value != "" && document.getElementById("right").options[i].textContent != "")
            document.getElementById("right").options[i].selected = true;
    }
    document.getElementById("edit").submit();
}