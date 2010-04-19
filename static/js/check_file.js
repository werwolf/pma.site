function check_file(url_addr)
{
    $.ajax({
        type:"POST",
        url:url_addr,
        cache:false,
        data:"filename="+$("#file").val()+"&cover="+$("#cover").val(),
        success:function(data)
        {
            if(data == 'true')
            {
                $("#upload_file").submit();
            }
            else
            {
                alert("Error.");
            }
        }
    });
}