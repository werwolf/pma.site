/* 
 * Rating table view							:TODO: $("") => $("#"+el_id[""])
 * Golphamid N.N. , Chernyavskiy A.S.
 */

var el_id = {
    desttable: "desttable",
    subjects: "subjects",
    group: "group",
    subject: "subject",
    ajax_loader: "ajax_loader"
};

var colmod  = new Array;
var mydata  = new Array;
var foodata = new Array;
var table_select = new Array;
var stud_id = new Array; //выделяем студента по его ID
var js_labels = jQuery.jgrid.view_rating;
var all;
var host;

var opts = {
    //    height: "auto",
    autowidth: true,
    cellsubmit: "clientArray",
    multiselect: false,
    rownumbers: true,
    rownumWidth: 15,
//    shrinkToFit: false,
    datatype: "local",
    footerrow: true,
    userDataOnFooter: true
};

jQuery(document).ready(function(){
    host = document.location.href.substr(0,window.location.hostname.length+10);

    $("#"+el_id["subjects"]).hide();
    updateTables();

    $("#"+el_id["group"]).change(function(){
        $("#"+el_id["subjects"]).hide();
        hideall();
        if($("#"+el_id["group"]).val() != '...') {
            var html = '<option>...<\/option>';
            updateSelect(table_select,"subject");
            $("#subjects").show();
        }
    });

    $("#"+el_id["subject"]).change(function(){
        hideall();
        if ($("#"+el_id["subject"]).val() != "..." && escapeHTML($("#"+el_id["subject"]+" option:selected").text()) != js_labels["all"]) {
            for (var i in table_select) {
                var c = table_select[i]["tablename"];
                if (c.substr(c.indexOf("_")+1,1) == $("#group").val() && c.substr(c.indexOf("_",c.indexOf("_")+1)+1,1) == $("#subject").val()) {
                    all = false;
                    get_table(table_select[i]["tablename"]);
                }
            }
        } else if (escapeHTML($("#"+el_id["subject"]+" option:selected").text()) == js_labels["all"]) {
            all = true;
            get_table($("#group").val());
        }
    });

});

//--------------------------------------------------BEGIN AJAX
function get_table(tablename){
    $.ajax({
        type:"POST",
        url:host+'/ajax/get_table/',
        cache:false,
        data:(all?"do=get_rating_data&group_id=":"do=get_data&tablename=") + tablename,
        success:function(data)
        {
            var table = eval("(" + data + ")");

            if (!table){
                alert("Ошибка базы!\nПожалуйста, свяжитесь с администратором.");
                return true;
            } else {
                $.extend(opts,{
                    caption:"Оценки группы: "+$("#group option:selected").text()+" / "+$("#subject option:selected").text()
                });

                colmod.splice(0, colmod.length);
                colmod[0] = {
                    label:js_labels["title_0"],
                    name:"stud_name",
                    index:"stud_name",
                    width:150,
                    sorttype:"text"
                };
                for(i = 0; i < table["title"].length; i++)
                    colmod[i+1] = {
                        label:table["title"][i],
                        name:"col"+parseInt(i+1),
                        index:"col"+parseInt(i+1),
                        width:60,
                        align:"right",
                        sorttype:"number"
                    };
                colmod[i+1] = {
                    label:js_labels["ratio"],
                    name:"ratio",
                    index:"ratio",
                    width:60,
                    align:"right",
                    sorttype:"number"
                };

                foodata = {};
                foodata = clone(table["data"][table["data"].length-1]);
                foodata["stud_name"] = js_labels["footer_0"];
                var sum = 0;
                for(var j = 1; j < colmod.length-1; j++) {
                    sum += parseInt(foodata["col"+j]);
                }
                foodata["ratio"] = sum;

                for(i = 0; i < table["data"].length-1; i++){
                    mydata[i] = clone(table["data"][i]);
                    if(all) for(j = 1; j < colmod.length-1; j++) {
                        if(foodata["col"+j] == 0) {
                            mydata[i]["col"+j] += "/0";
                        } else mydata[i]["col"+j] = parseFloat(mydata[i]["col"+j]).toFixed(2).replace(/^0+/g,"");
                    }
                    
                    stud_id[i] = table["data"][i]["stud_id"];
                    sum=0;
                    for(j = 1; j < colmod.length-1; j++) {
                        sum += all?(parseFloat(mydata[i]["col"+j])*(foodata["col"+j] == 0 ? 1 : foodata["col"+j])):parseInt(mydata[i]["col"+j]);
                    }
                    if(foodata["ratio"] != "0"){
                        mydata[i]["ratio"] = (sum/foodata["ratio"]).toFixed(2).replace(/^0+/g,"");
                    } else {
                        mydata[i]["ratio"] = sum+"/0";
                    }
                }
                if(foodata["ratio"] != "0"){
                    foodata["ratio"] = "1.00";
                }

                // create table
                togrid();
                setMenuHeight();
                setHeight();

                //highlights & format
                for(i = 0; i < stud_id.length; ++i)
                    if(table['id'] == stud_id[i]){
                        $("#desttable tr:nth-child("+(i+1)+")").css("background", "#CDFFE9");//#95B6EF
                        break;
                    }

                for(i = 0; i < table["data"].length-1; i++){
                    var cl;
                    cl = (mydata[i]["ratio"] <= 0.6*foodata["ratio"]) ? "#CF3333" : "green";
                    $("#desttable tr:nth-child("+(i+1)+") td:nth-child("+(colmod.length+1)+")").css("color", cl);
                    $("#desttable tr:nth-child("+(i+1)+") td:nth-child("+(colmod.length+1)+")").css("background-color", "#DFDFDF");
                    $("#desttable tr:nth-child("+(i+1)+") td:nth-child("+(colmod.length+1)+")").css("font-weight", "bold");
                }
            }
            return true;
        },
        error: function(){
            alert('Ajax Error!');
        },
        beforeSend: function(){
            $('#'+el_id["ajax_loader"]+' > img').css("left","480px");
            $('#'+el_id["ajax_loader"]+' > img').show();
        },
        complete:   function(){
            $('#'+el_id["ajax_loader"]+' > img').hide();
        }
    });
}

//--------------------------------------------------BEGIN convert
function togrid() {
    jQuery("#"+el_id["desttable"]).jqGrid('GridUnload',"#"+el_id["desttable"]);

    jQuery("#"+el_id["desttable"]).jqGrid($.extend(opts,{
        colModel:colmod
    }));

    for (i = 0; i < mydata.length; i++)
        jQuery("#"+el_id["desttable"]).jqGrid('addRowData',i+1,mydata[i]);
    jQuery("#"+el_id["desttable"]).jqGrid('footerData',"set",foodata);
    jQuery("#"+el_id["desttable"]).jqGrid('setGridHeight',"auto");
}

function updateTables() {
    $.ajax({
        type:"POST",
        url:host+'/ajax/get_table/',
        cache:false,
        data:"do=get_all_tables", // :TODO: get_all_tables
        success:function(data)
        {
            table_select = eval("(" + data + ")");
            updateSelect(table_select,"group");
            return true;
        }
    });
}

function updateSelect(table_select,key,group_id){
    var html = '<option>...<\/option>';
    if (key == "subject") {
        html += '<option>'+js_labels["all"]+'<\/option>';
    }
    if (table_select) {
        for (var i in table_select) {
            var c = table_select[i]["tablename"];
            if (key == "group" && html.indexOf("="+c.substr(c.indexOf("_")+1,1)+">") == -1) {
                html += '<option value='+c.substr(c.indexOf("_")+1,1)+'>'+table_select[i]["group"]+'<\/option>';
            }
            if (key == "subject" && c.substr(c.indexOf("_")+1,1) == $("#group").val()) {
                html += '<option value='+c.substr(c.indexOf("_",c.indexOf("_")+1)+1,1)+'>'+table_select[i]["subject"]+'<\/option>';
            }
            
        }
    }
    (key == "group") ? $("#group").html(html) : $("#subject").html(html);
    return true;
}

function hideall() {
    jQuery("#"+el_id["desttable"]).jqGrid('GridUnload',"#"+el_id["desttable"]);
    colmod.splice(0,colmod.length);
    mydata.splice(0,mydata.length);
    foodata = {};
    setMenuHeight();
}

function clone(o) {
    if (!o || 'object' !== typeof o) return o;
    
    var c = 'function' === typeof o.pop ? [] : {};
    var p, v;
    for(p in o) {
        if (o.hasOwnProperty(p)) {
            v = o[p];
            if (v && 'object' === typeof v) {
                c[p] = clone(v);
            } else {
                c[p] = v;
            }
        }
    }
    return c;
}

function escapeHTML(str) {
    var div = document.createElement('div');
    var text = document.createTextNode(str);
    div.appendChild(text);
    return div.innerHTML;
}