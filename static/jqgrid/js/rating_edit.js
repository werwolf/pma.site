/* 
 * Rating table edit
 * Golphamid N.N. , Chernyavskiy A.S.
 */

var el_id = {
    et: "et",
    desttable: "desttable",
    pager: "pager",
    editb: "editb",
    editbar: "editbar",
    labeledit: "labeledit",
    fooedit: "fooedit",
    addb: "addb",
    delb: "delb",
    editr: "editr",
    editrb: "editrb",
    rest: "rest",
    savetable: "savetable",
    table_select: "table_select",
    ajax_loader: "ajax_loader",
    newrnum: "newrnum",          // 'newrnum' &
    delnum: "delnum"             // 'delnum' are reserved!
};

var colmod  = new Array;
var mydata  = new Array;
var foodata = new Array;
var stud_id = new Array; //при сохранении имена переписываются этими ID'ми

var myselect;
var myrselect;
var newlabel;
var newfoo;
var newr;
var r_select;
var r_colmod;
var r_mydata;
var r_foodata;
var i;
var js_labels = jQuery.jgrid.view_rating;

var opts={
//    height: "auto",
    autowidth: true,
    cellEdit: true,
    cellsubmit: "clientArray",
    multiselect: false,
    rownumbers: true,
    rownumWidth: 15,
    shrinkToFit: false,
    datatype: "local",
    footerrow: true,
    userDataOnFooter: true,
    pager: el_id["pager"],
    pgbuttons: false,
    pginput: false,

    onSortCol: function(index, colindex, sortorder) { sort_col(index, colindex, sortorder); },
    beforeEditCell: function(rowid,celname,value,iRow,iCol) {
    	$("#"+el_id["editb"]).hide();
    	$(".ui-separator:first").hide();
    },
    beforeSaveCell: function(rowid,celname,value,iRow,iCol) {
    	if (!$("#"+el_id["editbar"]+":visible").length) {
    	    $("#"+el_id["editb"]).show();
    	    $(".ui-separator:first").show();
        }
    },
    afterSaveCell:  function(rowid,celname,value,iRow,iCol) {
        mydata = jQuery("#"+el_id["desttable"]).jqGrid('getRowData');
        totable();
        document.getElementById(el_id["rest"]).removeAttribute('disabled');
    },
    afterRestoreCell: function(iRow,iCol) {
    	if (!$("#"+el_id["editbar"]+":visible").length) {
    		$("#"+el_id["editb"]).show();
    	    $(".ui-separator:first").show();
        }
    }
};

jQuery(document).ready(function(){

	// editbar fix
	if (navigator.appVersion.toLowerCase().indexOf("win")==-1) { $("#labeledit").css("width",70); }
	if (navigator.appName=="Netscape") navigator.appVersion.toLowerCase().indexOf("win")!=-1?$("#newrnum").css("width",76):$("#newrnum").css("width",74);

    updateTables();
    myselect = document.getElementById(el_id["delnum"]);
    myrselect = document.getElementById(el_id["newrnum"]);
    newlabel = document.getElementById(el_id["labeledit"]);
    newfoo = document.getElementById(el_id["fooedit"]);
    newr = document.getElementById(el_id["editr"]);


    $("#"+el_id["table_select"]).change(function(){
    	hideall();
        if ($("#"+el_id["table_select"]).val() != "...") get_table();
    });


    $("#"+el_id["addb"]).click(function(){ addCol(newlabel.value, newfoo.value); });
    $("#"+el_id["delb"]).click(function(){
        if (myselect.options.length>1) delCol(myselect.options[myselect.selectedIndex].value);
    });
    $("#"+el_id["editrb"]).click(function(){
        if (myrselect.options.length) editmaxr(myrselect.selectedIndex, newr.value);
    });
    $("#"+el_id["rest"]).click(function(){ restore(); });
    $("#"+el_id["savetable"]).click(function(){ myswitch(false); });

    $("#"+el_id["labeledit"]).keydown(function(e){ processkey(e,1); });
    $("#"+el_id["fooedit"]).keydown(function(e){ processkey(e,1); });
    $("#"+el_id["editr"]).keydown(function(e){ processkey(e,2); });

    $("#"+el_id["labeledit"]).blur( function(){ inp_def_val(this,js_labels["title"],'blur');  });
    $("#"+el_id["labeledit"]).focus(function(){ inp_def_val(this,js_labels["title"],'click'); });

    $("#"+el_id["fooedit"]).blur( function(){ inp_def_val(this,js_labels["mark"],'blur');  });
    $("#"+el_id["fooedit"]).focus(function(){ inp_def_val(this,js_labels["mark"],'click'); });

    $("#"+el_id["editr"]).blur( function(){ inp_def_val(this,js_labels["mark"],'blur');  });
    $("#"+el_id["editr"]).focus(function(){ inp_def_val(this,js_labels["mark"],'click'); });
});


function inp_def_val(inp, def_val, mode) {
    if (mode == "click") {
        if ($(inp).val() == def_val) {
            $(inp).val("");
            $(inp).css('color', 'black');
        }
    } else if (mode == "blur") {
        if ($(inp).val() == "") {
            $(inp).val(def_val);
            $(inp).css('color', 'gray');
        }
    }
}

//--------------------------------------------------BEGIN AJAX
function get_table(){
    $.ajax({
        type:"POST",
        url:'http://' + window.location.hostname + '/en/ajax/get_table/',
        cache:false,
        data:"do=get_data&tablename=" + $('#'+el_id["table_select"]).val(),
        success:function(data)
        {
            var table = eval("(" + data + ")");
            
            if (!table){
            	alert("Таблица пустая!\nПожалуйста, свяжитесь с администратором.");
            	return true;
            } else {
                var c=$('#'+el_id["table_select"]+" :selected").html();
                var subject=c.substr(0,c.indexOf(" : "));
                var group=c.substr(c.indexOf(" : ")+3);
                $.extend(opts,{ caption:"Оценки группы: "+group+" / "+subject });
    
                colmod.splice(0, colmod.length);
                colmod[0] = {
                    label:js_labels["title_0"],
                    name:"stud_name",
                    index:"stud_name",
                    width:150,
                    sortable:false
                };
    
                for(i = 0; i < table["title"].length; i++)
                    colmod[i+1] = {
                        label:table["title"][i],
                        name:"col"+parseInt(i+1),
                        index:"col"+parseInt(i+1),
                        width:60,
                        align:"right",
                        sorttype:"none",
                        editable:true,
                        editrules:{
                            number:true
                        }
                    };
                for(i = 0; i < table["data"].length-1; i++){
                    mydata[i] = clone(table["data"][i]);
                    stud_id[i] = table["data"][i]["stud_id"];
                }
                foodata = clone(table["data"][i]);
                foodata["stud_name"]=js_labels["footer_0"];
    
                InitTable();
            }
        },
        error: function(){ alert('Ajax Error!'); },
        beforeSend: function(){ $('#'+el_id["ajax_loader"]+' > img').show(); },
        complete:   function(){ $('#'+el_id["ajax_loader"]+' > img').hide(); }
    });
}

function InitTable(){
    myswitch(false);

    jQuery("#"+el_id["et"]).jqGrid('GridUnload',"#"+el_id["et"]);
    //grid for input
    jQuery("#"+el_id["et"]).jqGrid({
        datatype: "local",
        colModel:[{
            label:js_labels["et"],
            name:'ec',
            index:'ec',
            width:90,
            editable:true,
            editoptions:{
                size:25
            }
        }]
    });
    jQuery("#"+el_id["et"]).jqGrid('addRowData',1,{ ec:"" });

    r_colmod  = clone(colmod);
    r_mydata  = clone(mydata);
    r_foodata = clone(foodata);
}

//--------------------------------------------------BEGIN support
function IsNumeric(sText) {
    var ValidChars = "0123456789";
    var IsNumber=true;
    var Char;
    for (i = 0; i < sText.length && IsNumber == true; i++)
    {
        Char = sText.charAt(i);
        if (ValidChars.indexOf(Char) == -1) IsNumber = false;
    }
return IsNumber;
}
function processkey(e,c) {
    if (e.which == 13)  {
        if (c == 1) {
            document.getElementById(el_id["addb"]).click();
        } else if (c == 2) {
            document.getElementById(el_id["editrb"]).click();
        }
        return false;
    }
    return true;
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
function myswitch(ch) {
    if (ch) {
        newlabel.value = '';
        newfoo.value = '';
        newr.value = '';
        
        inp_def_val(('#'+el_id["labeledit"]),js_labels["title"],'blur');
        inp_def_val(('#'+el_id["fooedit"]),js_labels["mark"],'blur');
        inp_def_val(('#'+el_id["editr"]),js_labels["mark"],'blur');

        $("#"+el_id["editbar"]).show('slow',function(){setHeight();});
        $("#editb").hide();
        $(".ui-separator:first").hide();

        document.getElementById(el_id["delb"]).removeAttribute('disabled');
        totable();
        document.getElementById(el_id["rest"]).disabled="disabled";
    } else {
        $("#"+el_id["editbar"]).hide();
        $("#editb").show();
        $(".ui-separator:first").show();

        togrid();
        r_colmod  = clone(colmod);
        r_mydata  = clone(mydata);
        r_foodata = clone(foodata);
        setMenuHeight();
    }
    setHeight();
}
function r_update() {
    if (myrselect) $('#newrnum').html($('#delnum').html());
}
function hideall() {
    jQuery("#"+el_id["desttable"]).jqGrid('GridUnload',"#"+el_id["desttable"]);
    colmod.splice(0,colmod.length);
    mydata.splice(0,mydata.length);
    $("#"+el_id["editbar"]).hide();
    $("#editb").hide();
    setMenuHeight();
}
//--------------------------------------------------END support

//--------------------------------------------------BEGIN cols edit
function addCol(newl, newf) {
    newl = newl.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
    newf = newf.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
    if (newf == "" || !IsNumeric(newf)) {
        newfoo.focus();
        newfoo.select();
        return;
    }
    if (newl == "") return;

    newf = newf.replace(/^[0]+/g,"");

    if (newf == "") newf = "0";

    var elOptNew = document.createElement('option');
    var len = myselect.options.length;

    len = (len == 0 ? 1 : len+1);

    elOptNew.text  = len+': '+newl;
    elOptNew.value = len+1;
    try {
        myselect.add(elOptNew, null);
    }
    catch(ex) {
        myselect.add(elOptNew); // IE only
    }
    r_update();

    //add to colmod
    var s = "col"+(parseInt(colmod[colmod.length-1].name.substr(3))+1);
    colmod=colmod.concat([{
        label:newl,
        name:s,
        index:s,
        width:60,
        align:"right",
        sorttype:"none",
        editable:true,
        editrules:{
            number:true
        }
    }]);
    //add to data
    for (i = 0; i < mydata.length; i++)
        mydata[i][s] = "0";
    //add to foodata
    foodata[s] = newf;

    document.getElementById(el_id["rest"]).removeAttribute('disabled');
    document.getElementById(el_id["delb"]).removeAttribute('disabled');
    togrid();
    newlabel.select();
    newlabel.focus();
}

function delCol(deli) {
    if (!IsNumeric(deli)) {
        alert('<bad request>');
        return;
    }
    if (deli == '1') {
        alert('You can not delete the first column!');
        return;
    }
    myselect.remove(deli-2);
    //correct indexes
    for (i = deli-2; i < myselect.options.length; i++) {
        var s  = myselect.options[i].text;
        var ii = s.substr(0,s.indexOf(':'));
        var ss = s.substr(s.indexOf(':'),s.length-s.indexOf(':'));
        myselect.options[i].text=(ii-1)+ss;
        myselect.options[i].setAttribute('value',ii);
    }
    //correct selectedIndex
    if (myselect.options.length != 1){
        if (deli-2 != myselect.options.length) {
            myselect.selectedIndex = deli - 2;
        } else {
            myselect.selectedIndex = deli - 3;
        }
    }
    r_update();

    //del from data
    for (i = 0; i < mydata.length; i++)
        delete mydata[i][colmod[deli-1].name];

    //del from foodata
    delete foodata[colmod[deli-1].name];

    //del from colmod
    colmod.splice(deli-1,1);

    document.getElementById(el_id["rest"]).removeAttribute('disabled');
    if (myselect.options.length < 2) {
        document.getElementById(el_id["delb"]).disabled="disabled";
    }
    togrid();
}

function restore() {
    myselect.parentNode.removeChild(myselect);
    myselect = r_select.cloneNode(true);
    var delb_node=document.getElementById(el_id["delb"]);
    delb_node.parentNode.insertBefore(myselect,delb_node);
    r_update();

    colmod  = clone(r_colmod);
    mydata  = clone(r_mydata);
    foodata = clone(r_foodata);

    document.getElementById(el_id["rest"]).disabled="disabled";
    document.getElementById(el_id["delb"]).removeAttribute('disabled');
    togrid();
}

function editmaxr(index,newf) {    
    newf = newf.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
    if (newf == "" || !IsNumeric(newf)) {
        newr.focus();
        newr.select();
        return;
    }
    newf = newf.replace(/^[0]+/g,"");
    if(newf == "") newf = "0";
    foodata[colmod[index+1].name] = newf;
    jQuery("#"+el_id["desttable"]).jqGrid('footerData',"set",foodata);
    document.getElementById(el_id["rest"]).removeAttribute('disabled');
}
//--------------------------------------------------END cols edit

//--------------------------------------------------BEGIN convert
function togrid() {
    jQuery("#"+el_id["desttable"]).jqGrid('GridUnload',"#"+el_id["desttable"]);

    jQuery("#"+el_id["desttable"]).jqGrid($.extend(opts,{
        colModel:colmod
    })).navGrid("#"+el_id["pager"],
        {
    	    position: "right",
            edit: false,
            add: false,
            del: false,
            search: false,
            refresh: false
        }
    ).navButtonAdd("#"+el_id["pager"], {
        caption: js_labels["editb"],
        id: "editb",
        buttonicon: "ui-icon-pencil",
        onClickButton: function () { myswitch(true); }
    }).navSeparatorAdd("#"+el_id["pager"],{
    	sepcontent:''
    }).navButtonAdd("#"+el_id["pager"], {
    	id: "savebb",
        caption: js_labels["pager_save"],
        buttonicon:"ui-icon-disk",
        onClickButton: function () { save_table(); }
   }).navSeparatorAdd("#"+el_id["pager"],{
    	sepcontent:''
    }).navButtonAdd("#"+el_id["pager"], {
    	id: "delbb",
        caption: js_labels["pager_delete"],
        buttonicon:"ui-icon-trash",
        onClickButton: function () { drop_table(); }
    }).navSeparatorAdd("#"+el_id["pager"],{
    	sepcontent:''
    });

    for (i = 0; i < mydata.length; i++)
        jQuery("#"+el_id["desttable"]).jqGrid('addRowData',i+1,mydata[i]);
    jQuery("#"+el_id["desttable"]).jqGrid('footerData',"set",foodata);
    jQuery("#"+el_id["desttable"]).jqGrid('setGridHeight',"auto");
    if ($("#"+el_id["editbar"]+":visible").length) { $("#"+el_id["editb"]).hide(); }
    totable();
}

function totable() {
    if (colmod.length == 0) return;
    //store data
    mydata=jQuery("#"+el_id["desttable"]).jqGrid('getRowData');

    var html;
    for(i = 1; i < colmod.length; ++i) {
        html += '<option value ='+(i+1)+'>'+i+': '+colmod[i].label+'<\/option>';
    }
    $("#delnum").html(html);
    if (myselect.options.length < 2) {
        document.getElementById(el_id["delb"]).disabled="disabled";
    }

    r_update();
    if (!r_select) r_select=myselect.cloneNode(true);
}

function updateTables() {
    $.ajax({
        type:"POST",
        url:'http://'+window.location.hostname+'/en/ajax/get_table/',
        cache:false,
        data:"do=get_my_tables",
        success:function(data)
        {
            var table_select = eval("(" + data + ")");
            updateSelect(table_select);
            return true;
        }
    });
}

function updateSelect(table_select){
    var html='<option>...<\/option>';
    if (table_select) {
        for (var i in table_select) {
            html += '<option value='+table_select[i]["tablename"]+'>'+table_select[i]["subject"]+" : "+table_select[i]["group"]+'<\/option>';
        }
    }
    $("#table_select").html(html);
    return true;
}

function sort_col(index, colindex, sortorder) {
    if ($("#"+el_id["desttable"]).jqGrid('getColProp',index).sorttype == "none") {
        $("#"+el_id["et"]).jqGrid('setCell',1,'ec',undefined);
        $("#"+el_id["et"]).jqGrid('editGridRow',1,{
            reloadAfterSubmit: false,
            left: getDeadCenter(270,100)[0],
            top:  getDeadCenter(270,100)[1],
            width: 260,
            modal: true,
            resize: false,
            url: window.location,
            savekey: [true,13],
            closeOnEscape: true,
            closeAfterEdit: true,
            viewPagerButtons: false,
            afterComplete: function(response, postdata, formid) {
                newstr=jQuery("#"+el_id["et"]).jqGrid('getCell',1,'ec');
                newstr=newstr.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
                if (newstr!="") {
                    document.getElementById("jqgh_"+index).setAttribute("title",newstr);
                    $("#"+el_id["desttable"]).jqGrid('setLabel',$("#"+el_id["desttable"]).jqGrid('getColProp',index).name,newstr);
                    colmod[colindex-1].label = newstr;
                    totable();
                    document.getElementById(el_id["rest"]).removeAttribute('disabled');
                }
            },
            editCaption: js_labels["editcaption"]+" '"+$("#"+el_id["desttable"]).jqGrid('getColProp',index).label+"'"
        });
    }
}
function save_table() {
    if ($("#"+el_id["editb"]+":visible").length) {
    	var data = new Array;
    	var title = new Array;

        for(i = 0; i < mydata.length; i++){
        	data[i] = clone(mydata[i]);
        	if (opts.rownumbers) delete data[i]["rn"];
        }
        data[i] = clone(foodata);

        for(i in data) data[i]["stud_name"]=stud_id[i];
        data[i]["stud_name"]="max_rating";
        delete data[data.length-1]["stud_id"];

        for(i = 0; i < colmod.length; i++)
        	if(colmod[i]["name"]!="stud_name"){
        		title[title.length]=new Object();
        		title[title.length-1]["name"]=colmod[i]["name"];
        		title[title.length-1]["label"]=colmod[i]["label"];
        	}

        $.ajax({
            type:"POST",
            url:'http://'+window.location.hostname+'/en/ajax/get_table/',
            cache:false,
            data:"do=save_data&tablename="+$("#"+el_id["table_select"]).val()+"&data="+encodeURIComponent(array2json(data))+"&title="+encodeURIComponent(array2json(title)),
            success:function(data)
            {
        	    var result = eval("(" + data + ")");
                if (result){
                    r_colmod  = clone(colmod);
                    r_mydata  = clone(mydata);
                    r_foodata = clone(foodata);
                    alert(js_labels["pager_saved"]);
                }
                return true;
            }
        });
    } else {
        alert(js_labels["pager_editing"]);
    }
}

function drop_table() {
    if ($("#"+el_id["editb"]+":visible").length) {
        if (confirm(js_labels["pager_delete_confirm"])) {
            $.ajax({
                type:"POST",
                url:'http://'+window.location.hostname+'/en/ajax/get_table/',
                cache:false,
                data:"do=drop_table&tablename="+$("#"+el_id["table_select"]).val(),
                success:function(data)
                {
    	          var result = eval("(" + data + ")");
                    if (result){
                        hideall();
                        updateTables();
                        alert(js_labels["pager_dropped"]);
                    }
                    return true;
                }
            });
        }
    } else {
        alert(js_labels["pager_editing"]);
    }
}
/**
 * Converts the given data structure to a JSON string.
 * Argument: arr - The data structure that must be converted to JSON
 * Example: var json_string = array2json(['e', {pluribus: 'unum'}]);
 * 			var json = array2json({"success":"Sweet","failure":false,"empty_array":[],"numbers":[1,2,3],"info":{"name":"Binny","site":"http:\/\/www.openjs.com\/"}});
 * http://www.openjs.com/scripts/data/json_encode.php
 */
function array2json(arr) {
    var parts = [];
    var is_list = (Object.prototype.toString.apply(arr) === '[object Array]');

    for(var key in arr) {
    	var value = arr[key];
        if(typeof value == "object") { //Custom handling for arrays
            if(is_list) parts.push(array2json(value)); /* :RECURSION: */
            else parts[key] = array2json(value); /* :RECURSION: */
        } else {
            var str = "";
            if(!is_list) str = '"' + key + '":';

            //Custom handling for multiple data types
            if(typeof value == "number") str += value; //Numbers
            else if(value === false) str += 'false'; //The booleans
            else if(value === true) str += 'true';
            else str += '"' + value + '"'; //All other things
            // :TODO: Is there any more datatype we should be in the lookout for? (Functions?)

            parts.push(str);
        }
    }
    var json = parts.join(",");
    
    if(is_list) return '[' + json + ']';//Return numerical JSON
    return '{' + json + '}';//Return associative JSON
}
//--------------------------------------------------END convert