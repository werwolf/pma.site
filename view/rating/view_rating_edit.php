<? if (!defined("entrypoint"))die;?>
<div id="profile">

    <!-- - - - - - - - - - - - - -->
    <!-- remember to sync el_id  -->
    <!-- - - - - - - - - - - - - -->
    <a href="javascript:void(0);" onclick="get_table()">click me</a>

    <div style="display:none"><table id="et"></table></div>

    <div id="tcontainer" style="display:none">
        <table id="desttable" border=1></table>
    </div>
    <br/>

    <input type="button" id="edittable" value="редагувати" onclick="myswitch(true)" style="display:none" />

    <div id="editbar" style="display:none">
        <input type="text" size=40 id="labeledit" value="" maxlength=200 onkeydown="return processkey(event)" />
        <input type="text" size=40 id="fooedit" value="максимальний бал" maxlength=200 onfocus="if(fooedit.value=='максимальний бал'){fooedit.value='';newfoo.select()}" onkeydown="return processkey(event)" />
        <input id="addb" type="button" value="додати" onclick="addCol(newlabel.value, newfoo.value)" />
        <div id="scontainer">
            <!--select id="delnum"></select-->
            <input id="delb" type="button" value="видалити" onclick="if (myselect.options.length) delCol(myselect.options[myselect.selectedIndex].value)" />
        </div>
        <br/>
        <input id="rest" type="button" value="відновити" onclick="restore()" disabled />
        <input type="button" id="savetable" value="зберегти" onclick="myswitch(false)" />
    </div>
    <br/>
    <br/>


    <script type="text/javascript">
        var el_id={et:"et", tcontainer:"tcontainer", desttable:"desttable", edittable:"edittable", editbar:"editbar", labeledit:"labeledit", fooedit:"fooedit", addb:"addb", scontainer:"scontainer", delb:"delb", rest:"rest", savetable:"savetable", delnum:"delnum"};	// 'delnum' is reserved!
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
        var foodata = new Array;

        var opts={
            height: "100%",
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
                                document.getElementById("jqgh_"+index).setAttribute("title",newstr);
                                jQuery("#"+el_id["desttable"]).jqGrid('setLabel',jQuery("#"+el_id["desttable"]).jqGrid('getColProp',index).name,newstr);
                                colmod[colindex-1].label=newstr;
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
        var myselect = document.getElementById(el_id["delnum"]);
        var newlabel = document.getElementById(el_id["labeledit"]);
        var newfoo = document.getElementById(el_id["fooedit"]);
        var mycontainer = document.getElementById(el_id["tcontainer"]);
        var editing, r_select, r_colmod, r_mydata, temp_space, i;


        function get_table(){
            $.ajax({
                type:"POST",
                url:'http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/ajax/get_table/',
                cache:false,
                data:"subject=2_2",
                success:function(data)
                {
                    var table = eval("(" + data + ")");

                    $.extend(opts,{caption:table["caption"]});

                    for(i=0; i<table["title"].length; i++)
                        $.extend(colmod[i],{ label:table["title"][i] });

                    for(i=0; i<table["data"].length; i++)
                        mydata[i]=clone(table["data"][i]);

                    foodata=clone(table["rating"]);

                    InitTable();
                    setHeight(); // from ./static/js/setHeight.js made height of sidebar as height of content
                }
            });
        }

        function InitTable(){
            show(el_id["tcontainer"]);
            togrid();

            //grid for input
            jQuery("#"+el_id["et"]).jqGrid({
                datatype: "local",
                colNames:['Нова назва:'],
                colModel:[{name:'ec',index:'ec', width:90,editable:true,editoptions:{size:25}}]
            });
            jQuery("#"+el_id["et"]).jqGrid('addRowData',1,{ec:""});

            r_colmod=clone(colmod);
            r_mydata=clone(mydata);
            show(el_id["edittable"]);
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
        function addCol(newl, newf) {
            newl=newl.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
            newf=newf.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
            if(newf=="" || !IsNumeric(newf)) {newfoo.focus(); newfoo.select(); return;}
            if(newl=="") return;

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
            //add to foodata
            foodata["col"+len]=newf;

            document.getElementById(el_id["rest"]).removeAttribute('disabled');
            document.getElementById(el_id["delb"]).removeAttribute('disabled');
            togrid();
            newlabel.select();newlabel.focus();
        }

        function delCol(deli) {
            if (!IsNumeric(deli)) {alert('<bad request>');return;}
            if (deli=='1') {alert('Нельзя удалить первый столбец!');return;}

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
            jQuery("#"+el_id["desttable"]).jqGrid('GridUnload',"#"+el_id["desttable"]);
            mytable=document.createElement('TABLE');
            mytable.setAttribute('id',el_id["desttable"]);
            mycontainer.appendChild(mytable);

            jQuery("#"+el_id["desttable"]).jqGrid($.extend(opts,{colModel:colmod}));
            for (i=0;i<mydata.length;i++)
                jQuery("#"+el_id["desttable"]).jqGrid('addRowData',i+1,mydata[i]);
            jQuery("#"+el_id["desttable"]).jqGrid('footerData',"set",foodata);
            totable();
        }

        function totable() {
            //store data
            mydata=jQuery("#"+el_id["desttable"]).jqGrid('getRowData');

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