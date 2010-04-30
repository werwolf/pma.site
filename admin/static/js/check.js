function checkStatic()
{
    var error = 0;

    if($("#title_ru").val() == "") error++;
    if($("#title_en").val() == "") error++;
    if($("#title_ua").val() == "") error++;

    if(!is_numeric($("#position").val())) error++;

    if(error == 0)
        document.getElementById("form_static").submit();
    else alert("Всі заголовки повинні бути введені.Поле позиція має бути ціле число.");
}
function is_numeric(val)
{
    if(val == "") return false;
    return !isNaN(val * 1);
}
function checkNews()
{
    var error = 0;

    if($("#title_ru").val() == "") error++;
    if($("#title_en").val() == "") error++;
    if($("#title_ua").val() == "") error++;

    if(error == 0)
        document.getElementById("form_static").submit();
    else alert("Всі заголовки повинні бути введені..");
}
