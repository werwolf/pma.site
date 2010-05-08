function showMail(id,num)
{
    $("#"+id).css("display","block");
    $("#show"+num).css("display","none");
    $("#hide"+num).css("display","block");    
    var height = document.getElementById(id).clientHeight;
    var cont_height = document.getElementById("content").clientHeight;
    document.getElementById("content").style.height = cont_height+height+'px';    
}
function hideMail(id,num)
{
    var height = document.getElementById(id).clientHeight;
    var cont_height = document.getElementById("content").clientHeight;    
    $("#"+id).css("display","none");
    $("#show"+num).css("display","block");
    $("#hide"+num).css("display","none");        
    document.getElementById("content").style.height = cont_height-height+'px';
}