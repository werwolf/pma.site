<? if (!defined("entrypoint"))die;?>
<div id="profile">

    <!-- - - - - - - - - - - - - -->
    <!-- remember to sync el_id  -->
    <!-- - - - - - - - - - - - - -->

    <div style="width: 100%; background-color: #CFCFCF; padding: 5px 0; margin-bottom: 5px;">
        <div style="color: blue; float: left; margin-right: 10px; margin-left: 5px;">Выберите таблицу</div>
        <select name="tablename" style="width: 150px;" id="table_select">
            <option>...</option>
            <option>OS : KM-71</option>
            <option>OS : KM-72</option>
            <option>OS : KM-73</option>
        </select>
    </div>
<!-- -->
    <div style="width: 330px; background-color: #CFCFCF; padding: 5px; margin-top: 5px; display: none;">
        <div>
            <div style="color: blue; float: left; margin-right: 10px; width: 110px;">Имя колонки</div>
            <INPUT type="text" value="" maxlength="40" style="width: 145px; float: left; margin-right: 5px;"/>
            <input type="button" value="add" style="width: 50px;"/>
        </div>

        <div style="padding: 5px 0;">
            <div style="color: blue; float: left; margin-right: 10px; width: 110px;">Имя колонки</div>
            <select name="tablename" style="width: 150px; float: left; margin-right: 5px;"> 
                <option>...</option>
            </select>
            <input type="button" value="del" style="width: 50px;"/>
        </div>

        <div style="margin-top: 5px;">
            <input type="button" value="restore" style="float: left; width: 80px; margin-right: 10px; margin-left: 80px;"/>
            <input type="button" value="save" style="width: 80px;"/>
        </div>
    </div>
<!-- -->

    <div style="display:none"><table id="et"></table></div>
    <div id="thtmlcontainer" style="display:none"><table id="htmltable"></table></div>
    <div id="collabels"></div>

    <div id="tcontainer">
        <table id="desttable" border=1></table>
    </div>

    <INPUT TYPE="button" ID="edittable" VALUE="edit cols" ONCLICK="myswitch(1)" />

    <div id="editbar" style="display:none">
        <INPUT TYPE="text" SIZE=40 ID="labeledit" VALUE="" MAXLENGTH=200 ONKEYDOWN="return processkey(event)" /> <input id="addb" type="button" value="add" onclick="addCol(newlabel.value)" />
        <div id="scontainer">
            <!--select id="delnum"></select-->
            <INPUT ID="delb" TYPE="button" VALUE="delete" ONCLICK="if (myselect.options.length) delCol(myselect.options[myselect.selectedIndex].value)" />
        </div>
        <br/>
        <INPUT ID="rest" TYPE="button" VALUE="restore" ONCLICK="restore()" disabled />
        <INPUT TYPE="button" ID="savetable" VALUE="save changes" ONCLICK="myswitch(0)" />
    </div>

    <script type="text/javascript">
        var el_id={et:"et", collabels:"collabels", tcontainer:"tcontainer", thtmlcontainer:"thtmlcontainer", desttable:"desttable", htmltable:"htmltable", edittable:"edittable", editbar:"editbar", labeledit:"labeledit", addb:"addb", scontainer:"scontainer", delb:"delb", rest:"rest", savetable:"savetable", delnum:"delnum"};	// don't change 'delnum'
        var colmod=[
            {name:"stud_name",index:"stud_name", width:150},
            {name:"col1",index:"col1", width:60, align:"right",sorttype:"none", editable:true, editrules:{number:true}},
            {name:"col2",index:"col2", width:60, align:"right",sorttype:"number", editable:true, editrules:{number:true}},
            {name:"col3",index:"col3", width:60, align:"right",sorttype:"none", editable:true, editrules:{number:true}},
            {name:"col4",index:"col4", width:60, align:"right",sorttype:"none", editable:true, editrules:{number:true}},
            {name:"col5",index:"col5", width:60, align:"right",sorttype:"none", editable:true, editrules:{number:true}},
            {name:"col6",index:"col6", width:60, align:"right",sorttype:"none", editable:true, editrules:{number:true}}
        ];
        var mydata = new Array;
//        var mydata=[
//            {stud_name:"Тоха",col1:"2",col2:"1",col3:"2"},
//            {stud_name:"Верес",col1:"1",col2:"2",col3:"3"},
//            {stud_name:"Голубов",col1:"1",col2:"3",col3:"3"},
//            {stud_name:"Зелінський",col1:"1",col2:"4",col3:"3"},
//            {stud_name:"Корнічук",col1:"1",col2:"5",col3:"3"},
//            {stud_name:"Парфьонов",col1:"1",col2:"6",col3:"3"},
//        ];
        var opts={
            caption: "Група: KM-72",
            height: "100%",
            //width: "650",
            autowidth: true,
            cellEdit: true,
            cellsubmit: "clientArray",
            multiselect: false,
            rownumbers: true,
            rownumWidth: 15,
            shrinkToFit: false,
            datatype: "local",

            onSortCol: function( index, colindex, sortorder) {
                if(jQuery("#"+el_id["desttable"]).jqGrid('getColProp',index).sorttype=="none") {
                    jQuery("#"+el_id["et"]).jqGrid('setCell',1,'ec',undefined);
                    jQuery("#"+el_id["et"]).jqGrid('editGridRow',1,{
                        reloadAfterSubmit: false,
                        left: getDeadCenter(250,100)[0],
                        top: getDeadCenter(250,100)[1],
                        width: 240,
                        modal: true,
                        resize: false,
                        url: window.location,
                        savekey: [true,13],
                        closeOnEscape: true,
                        closeAfterEdit: true,
                        viewPagerButtons: false,
                        afterComplete: function (response, postdata, formid) {
                            newstr=jQuery("#"+el_id["et"]).jqGrid('getCell',1,'ec');
                            newstr=newstr.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
                            if (newstr!="") {
                                jQuery("#"+el_id["desttable"]).jqGrid('setLabel',jQuery("#"+el_id["desttable"]).jqGrid('getColProp',index).name,newstr);
                                colmod[colindex].label=newstr;
                                totable();
                                document.getElementById(el_id["rest"]).removeAttribute('disabled');

                            }
                        },
                        editCaption: "Зміна '"+jQuery("#"+el_id["desttable"]).jqGrid('getColProp',index).label+"'",
                        bSubmit: "Зберегти",
                        bCancel: "Відміна"
                    });
                };
            },
            beforeEditCell: function(rowid,celname,value,iRow,iCol) {
                hide(el_id["edittable"]);
            },
            beforeSaveCell: function(rowid,celname,value,iRow,iCol) {
                if (!editing) {show(el_id["edittable"]);}
            },
            afterSaveCell: function(rowid,celname,value,iRow,iCol) {
                mydata=jQuery("#"+el_id["desttable"]).jqGrid('getRowData');
                totable();
                document.getElementById(el_id["rest"]).removeAttribute('disabled');
            },
            afterRestoreCell: function(iRow,iCol) {
                if (!editing) {show(el_id["edittable"]);}
            }
        };

        var mytable = document.getElementById(el_id["desttable"]);
        var myhtmltable = document.getElementById(el_id["htmltable"]);
        var myselect = document.getElementById(el_id["delnum"]);
        var newlabel = document.getElementById(el_id["labeledit"]);
        var mycontainer = document.getElementById(el_id["tcontainer"]);
        var myhtmlcontainer = document.getElementById(el_id["thtmlcontainer"]);
        var editing, r_table, r_select, r_colmod, r_mydata, temp_space, i;


        jQuery(document).ready(function(){
            $('#table_select').change(function(){
                if($('#table_select').val() == '...') {} // if table not empty then delete & hide table
                else get_table();
            });
        });
            

        function get_table(){
            $.ajax({
                type:"POST",
                url:'http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/ajax/get_table/',
                cache:false,
                data:"subject=" + $('table_select').val(),
                success:function(data)
                {
                    var table = eval("(" + data + ")");

                    for(i=0; i<table["title"].length; i++)
                        $.extend(colmod[i],{ label:table["title"][colmod[i].name] });

                    for(i=0; i<table["data"].length; i++)
                        mydata[i]=clone(table["data"][i]);

                    InitTable();
                    setHeight(); // from ./static/js/setHeigyt.js made height of sidebar as height of content
                }
            });
          };

        function InitTable(){
            jQuery("#"+el_id["desttable"]).jqGrid($.extend(opts,{colModel:colmod}));
            for (i=0;i<mydata.length;i++)
                jQuery("#"+el_id["desttable"]).jqGrid('addRowData',i+1,mydata[i]);

            //$("#"+el_id["desttable"]).jqGrid('setGridParam',{height:"500"});
//            alert($("#destable").jqGrid('getGridParam',"height"));
//            $("#profile").height($("#destable").jqGrid('getGridParam',"height"));
//            alert($("#destable").jqGrid('getGridParam',"height"));

            //grid for input
            jQuery("#"+el_id["et"]).jqGrid({
                datatype: "local",
                colNames:['Нова назва:'],
                colModel:[{name:'ec',index:'ec', width:90,editable:true,editoptions:{size:25}}]
            });
            jQuery("#"+el_id["et"]).jqGrid('addRowData',1,{ec:""});

            r_colmod=clone(colmod);
            r_mydata=clone(mydata);
            editing=0;
        }

        //--------------------------------------------------BEGIN support
        function IsNumeric(sText) {
            var ValidChars = "0123456789.";
            var IsNumber=true;
            var Char;
            for (i = 0; i < sText.length && IsNumber == true; i++)
            {Char = sText.charAt(i);if (ValidChars.indexOf(Char) == -1){IsNumber = false;}}
            return IsNumber;
        }
        function getcolnum() {
            return myhtmltable.getElementsByTagName("td") / myhtmltable.getElementsByTagName("tr");
        }
        function processkey(e) {
            if (null == e)
                e = window.event ;
            if (e.keyCode == 13)  {
                document.getElementById(el_id["addb"]).click();
                return false;
            }
        }
        function show(objid) {
            document.getElementById(objid).removeAttribute("style");
        }
        function hide(objid) {
            document.getElementById(objid).setAttribute("style","display:none");
        }
        function clone(o) {
            if(!o || 'object' !== typeof o)  {
                return o;
            }
            var c = 'function' === typeof o.pop ? [] : {};
            var p, v;
            for(p in o) {
                if(o.hasOwnProperty(p)) {
                    v = o[p];
                    if(v && 'object' === typeof v) {
                        c[p] = clone(v);
                    }
                    else {
                        c[p] = v;
                    }
                }
            }
            return c;
        }
        function myswitch(ch) {
            if (ch) {
                show(el_id["editbar"]);
                hide(el_id["edittable"]);
                totable();
                document.getElementById(el_id["edittable"]).setAttribute('disabled',"");
            }
            else {
                hide(el_id["editbar"]);
                show(el_id["edittable"]);
                togrid();
                r_colmod=clone(colmod);
                r_mydata=clone(mydata);
                document.getElementById(el_id["edittable"]).removeAttribute('disabled');
                document.getElementById(el_id["rest"]).setAttribute('disabled',"");
            }
            editing=ch;
        }
        //--------------------------------------------------END support

        //--------------------------------------------------BEGIN cols edit
        function addCol(newl) {
            newl=newl.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
            if(newl=="") return;

            var trArr = myhtmltable.rows;
            for (i = 0; i < trArr.length; i++)
                trArr[i].insertCell(-1).innerHTML='0';

            var elOptNew = document.createElement('option');
            var len=myselect.options.length;
            if (len==0) {len=1;}
            else {len+=1;}
            elOptNew.text = (len)+': '+newl;
            elOptNew.value = len+1;
            try {
                myselect.add(elOptNew, null);
            }
            catch(ex) {
                myselect.add(elOptNew); // IE only
            }

            //add to colmod
            var s='col'+colmod.length;
            colmod=colmod.concat([{label:newl,name:s,index:s, width:60, align:"right",sorttype:"none", editable:true, editrules:{number:true}}]);
            //add to data
            for (i = 0; i < mydata.length; i++)
                mydata[i][s]="0";

            document.getElementById(el_id["rest"]).removeAttribute('disabled');
            document.getElementById(el_id["delb"]).removeAttribute('disabled');
            togrid();
            newlabel.select();newlabel.focus();
        }

        function delCol(deli) {
            if (!IsNumeric(deli)) {alert('<bad request>');return;}
            if (deli=='1') {alert('Нельзя удалить первый столбец!');return;}

            if (deli==getcolnum()) {deli=-1;}
            var trArr = myhtmltable.rows;
            for (i = 0; i < trArr.length; i++)
                trArr[i].deleteCell(deli-1);
            myselect.remove(deli-2);
            //correct indexes
            for (i = deli-2; i < myselect.options.length; i++) {
                var s=myselect.options[i].text;
                var ii=s.substr(0,s.indexOf(':'));
                var ss=s.substr(s.indexOf(':'),s.length-s.indexOf(':'));
                myselect.options[i].text=(ii-1)+ss;
                myselect.options[i].setAttribute('value',ii);
            }
            //correct selectedIndex
            if (myselect.options.length!=1){
                if (deli-2!=myselect.options.length) {
                    myselect.selectedIndex=deli-2;
                }
                else {
                    myselect.selectedIndex=deli-3;
                }
            }

            //del from data
            for (i = 0; i < mydata.length; i++)
                delete mydata[i][colmod[deli-1].name];
            //del from colmod
            colmod.splice(deli-1,1);

            document.getElementById(el_id["rest"]).removeAttribute('disabled');
            if (myselect.options.length==0) {document.getElementById(el_id["delb"]).setAttribute('disabled',"");}
            togrid();
        }

        function restore() {
            myhtmltable.parentNode.removeChild(myhtmltable);
            myhtmltable=r_table.cloneNode(true);
            myhtmlcontainer.appendChild(myhtmltable);

            myselect.parentNode.removeChild(myselect);
            myselect=r_select.cloneNode(true);
            var temp=document.createTextNode(' ');
            var cont_node=document.getElementById(el_id["scontainer"]);
            var delb_node=document.getElementById(el_id["delb"]);
            cont_node.insertBefore(temp,delb_node);
            cont_node.insertBefore(myselect,temp);

            colmod=clone(r_colmod);
            mydata=clone(r_mydata);

            document.getElementById(el_id["rest"]).setAttribute('disabled',"");
            document.getElementById(el_id["delb"]).removeAttribute('disabled');
            togrid();
        }
        //--------------------------------------------------END cols edit

        //--------------------------------------------------BEGIN convert
        function togrid() {
            myhtmlcontainer.removeChild(myhtmltable);
            jQuery("#"+el_id["desttable"]).jqGrid('GridUnload',"#"+el_id["desttable"]);
            mytable=document.createElement('TABLE');
            mytable.setAttribute('id',el_id["desttable"]);
            mycontainer.appendChild(mytable);

            jQuery("#"+el_id["desttable"]).jqGrid($.extend(opts,{colModel:colmod}));
//            if(jQuery("#"+el_id["desttable"]).jqGrid('getGridParam',"width")>600){
//                jQuery("#"+el_id["desttable"]).jqGrid('setGridWidth',650);
//            }
            for (i=0;i<mydata.length;i++)
                jQuery("#"+el_id["desttable"]).jqGrid('addRowData',i+1,mydata[i]);
            totable();
        }

        function totable() {
            //store data
            mydata=jQuery("#"+el_id["desttable"]).jqGrid('getRowData');

            myhtmltable=document.createElement('TABLE');
            myhtmltable.setAttribute('border','1');
            myhtmltable.setAttribute('id',"#"+el_id["htmltable"]);
            //table data
            var tbody=myhtmltable.appendChild(document.createElement('TBODY'));
            for (i = 0; i < mydata.length; i++) {
                var newRow=tbody.insertRow(-1);
                for (var j = 0; j < colmod.length; j++)
                    if (j==0) {newRow.insertCell(-1).innerHTML='<b>'+mydata[i][colmod[0].name]+'<\/b>';}
                else {newRow.insertCell(-1).innerHTML=mydata[i][colmod[j].name];}
            }
            myhtmlcontainer.appendChild(myhtmltable);
            if (!r_table) {r_table=myhtmltable.cloneNode(true);}

            var cont_node=document.getElementById(el_id["scontainer"]);
            if (myselect) {
                cont_node.removeChild(myselect);
                cont_node.removeChild(temp_space);
            }
            myselect=document.createElement('SELECT');
            myselect.setAttribute('id',el_id["delnum"]);
            //select data
            var elOptNew;
            for (i = 1; i < colmod.length; i++) {
                elOptNew = document.createElement('option');
                elOptNew.text = i+': '+colmod[i].label;
                elOptNew.value = i+1;
                try {
                    myselect.add(elOptNew, null);
                }
                catch(ex) {
                    myselect.add(elOptNew); // IE only
                }
            }
            var text_node=document.createTextNode(' ');
            var delb_node=document.getElementById(el_id["delb"]);
            temp_space=cont_node.insertBefore(text_node,delb_node);
            cont_node.insertBefore(myselect,temp_space);
            if (!r_select) {r_select=myselect.cloneNode(true);}

            try {
                newlabel.focus();newlabel.select();
            }
            catch(ex) {}
        }
        //--------------------------------------------------END convert
    </script>
</div>