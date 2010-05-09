<? if (!defined("entrypoint"))die;?>
<div id="profile">

    <!-- - - - - - - - - - - - - -->
    <!-- remember to sync el_id  -->
    <!-- - - - - - - - - - - - - -->
    
    <div class="top_container">
        <div class="top_container_label"><?=$labels['rating']['top_label'];?></div>
        <select name="tablename" id="table_select">
            <option>...</option>
            <option>OS : KM-71</option>
            <option>OS : KM-72</option>
            <option>OS : KM-73</option>
        </select>
        <div id="ajax_loader"><img alt="" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/img/basic/ajax_loader_Tedit.gif"/></div>
    </div>

    <table id="desttable"></table>
    <div style="display:none;"><table id="et"></table></div>

    <input type="button" id="editb" value="<?=$labels['rating']['editb'];?>"/>

<!-- -->
    <div id="editbar">
        <div>
            <div class="editbar_label"><?=$labels['rating']['add_label'];?></div>
            <input id="labeledit" type="text" maxlength="20" class="editbar_input" value="<?=$labels['rating']['title'];?>" />
            <input id="fooedit" type="text" maxlength="5" class="editbar_input" value="<?=$labels['rating']['mark'];?>"/>
            <input id="addb" type="button" value="<?=$labels['rating']['addb'];?>"/>
        </div>

        <div style="padding: 5px 0;">
            <input id="editr" type="text" maxlength="5" class="editbar_input" />
            <select id="newrnum" name="tablename">
                <option>...</option>
            </select>
            <input id="editrb" type="button" value="<?=$labels['rating']['editrb'];?>" />
        </div>

        <div>
            <div class="editbar_label"><?=$labels['rating']['del_label'];?></div>
            <select id="delnum" name="tablename">
                <option>...</option>
            </select>
            <input id="delb" type="button" value="<?=$labels['rating']['delb'];?>" />
        </div>

        <div style="margin-top: 5px;">
            <input id="rest" type="button" disabled value="<?=$labels['rating']['rest'];?>" />
            <input id="savetable" type="button" value="<?=$labels['rating']['savetable'];?>" />
        </div>
    </div>
<!-- -->

    <script type="text/javascript">
        var el_id={
                    et:"et",
                    desttable:"desttable",
                    editb:"editb",
                    editbar:"editbar",
                    labeledit:"labeledit",
                    fooedit:"fooedit",
                    addb:"addb",
                    delb:"delb",
                    editr:"editr",
                    editrb:"editrb",
                    rest:"rest",
                    savetable:"savetable",
                    table_select:"table_select",
                    ajax_loader:"ajax_loader",
                    newrnum:"newrnum",          // 'newrnum' &
                    delnum:"delnum"             // 'delnum' are reserved!
                };
        var colmod= new Array;
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
                if (jQuery("#"+el_id["desttable"]).jqGrid('getColProp',index).sorttype=="none") {
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
                        editCaption: js_labels["editcaption"]+jQuery("#"+el_id["desttable"]).jqGrid('getColProp',index).label+"'"
                    });
                };
            },
            beforeEditCell: function(rowid,celname,value,iRow,iCol) {
                hide(el_id["editb"]);
            },
            beforeSaveCell: function(rowid,celname,value,iRow,iCol) {
                if (!editing) {show(el_id["editb"]);}
            },
            afterSaveCell: function(rowid,celname,value,iRow,iCol) {
                mydata=jQuery("#"+el_id["desttable"]).jqGrid('getRowData');
                totable();
                document.getElementById(el_id["rest"]).removeAttribute('disabled');
            },
            afterRestoreCell: function(iRow,iCol) {
                if (!editing) {show(el_id["editb"]);}
            }
        };

        var mytable = document.getElementById(el_id["desttable"]);
        var myselect = document.getElementById(el_id["delnum"]);
        var myrselect = document.getElementById(el_id["newrnum"]);
        var newlabel = document.getElementById(el_id["labeledit"]);
        var newfoo = document.getElementById(el_id["fooedit"]);
        var newr = document.getElementById(el_id["editr"]);
        var js_labels = jQuery.jgrid.view_rating_edit;
        var editing, r_select, r_colmod, r_mydata, r_foodata, i;


        jQuery(document).ready(function(){
            $("#"+el_id["table_select"]).change(function(){
                if ($("#"+el_id["table_select"]).val() == "...") {
                    jQuery("#"+el_id["desttable"]).jqGrid('GridUnload',"#"+el_id["desttable"]);
                    colmod.splice(0,colmod.length);
                    mydata.splice(0,mydata.length);
                    hide(el_id["editbar"]);
                    hide(el_id["editb"]);
                    setMenuHeight();
                } else get_table();
            });

            $("#"+el_id["editb"]).click(function(){ myswitch(true); });
            $("#"+el_id["addb"]).click(function(){ addCol(newlabel.value, newfoo.value); });
            $("#"+el_id["delb"]).click(function(){ if (myselect.options.length) delCol(myselect.options[myselect.selectedIndex].value); });
            $("#"+el_id["editrb"]).click(function(){ if (myrselect.options.length) editmaxr(myrselect.selectedIndex, newr.value); });
            $("#"+el_id["rest"]).click(function(){ restore(); });
            $("#"+el_id["savetable"]).click(function(){ myswitch(false); });

            $("#"+el_id["labeledit"]).keydown(function(){ return processkey(event,1); });
            $("#"+el_id["fooedit"]).keydown(function(){ return processkey(event,1); });
            $("#"+el_id["editr"]).keydown(function(){ return processkey(event,2); });

            $("#"+el_id["labeledit"]).blur(function(){ inp_def_val(this,"<?=$labels['rating']['title'];?>",'blur'); });
            $("#"+el_id["labeledit"]).focus(function(){ inp_def_val(this,"<?=$labels['rating']['title'];?>",'click'); });

            $("#"+el_id["fooedit"]).blur(function(){ inp_def_val(this,"<?=$labels['rating']['mark'];?>",'blur'); });
            $("#"+el_id["fooedit"]).focus(function(){ inp_def_val(this,"<?=$labels['rating']['mark'];?>",'click'); });

            $("#"+el_id["editr"]).blur(function(){ inp_def_val(this,"<?=$labels['rating']['mark'];?>",'blur'); });
            $("#"+el_id["editr"]).focus(function(){ inp_def_val(this,"<?=$labels['rating']['mark'];?>",'click'); });
            
			var key, obj=jQuery.jgrid.my_html;
            for (key in obj) {
            	if (obj.hasOwnProperty(key))
                	if (key.indexOf("_label")>0) {
                		jQuery("#"+key).text(obj[key]);
                	} else {
						jQuery("#"+key).attr("value", obj[key]);
            		}
            }
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
                url:'http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/ajax/get_table/',
                cache:false,
                data:"tablename="+$('#'+el_id["table_select"]).val(),
                success:function(data)
                {
                    var table = eval("(" + data + ")");

                    $.extend(opts,{caption:table["caption"]});

                    colmod.splice(0, colmod.length);
                    colmod[0]={label:js_labels["title_0"], name:"stud_name",index:"stud_name", width:150, sortable:false};
                    for(i=1; i<table["title"].length; i++)
                        colmod[i]={label:table["title"][i], name:"col"+i,index:"col"+i, width:60, align:"right",sorttype:"none", editable:true, editrules:{number:true}};

                    for(i=0; i<table["data"].length; i++)
                        mydata[i]=clone(table["data"][i]);

                    foodata=clone(table["rating"]);

                    InitTable();
                },

                error: function(){
                    alert('Error!');
                },

                beforeSend: function(){
                    $('#'+el_id["ajax_loader"]+' > img').show();
                },
                complete: function(){
                    $('#'+el_id["ajax_loader"]+' > img').hide();
                }
            });
        }

        function InitTable(){
            myswitch(false);

            //grid for input
            jQuery("#"+el_id["et"]).jqGrid({
                datatype: "local",
                colModel:[{label:js_labels["et"],name:'ec',index:'ec', width:90,editable:true,editoptions:{size:25}}]
            });
            jQuery("#"+el_id["et"]).jqGrid('addRowData',1,{ec:""});

            r_colmod=clone(colmod);
            r_mydata=clone(mydata);
            r_foodata=clone(foodata);
        }

        //--------------------------------------------------BEGIN support
        function IsNumeric(sText) {
            var ValidChars = "0123456789";
            var IsNumber=true;
            var Char;
            for (i = 0; i < sText.length && IsNumber == true; i++)
            {Char = sText.charAt(i);if (ValidChars.indexOf(Char) == -1){IsNumber = false;}}
            return IsNumber;
        }
        function processkey(e,c) {
            if (null == e)
                e = window.event ;
            if (e.keyCode == 13)  {
                if (c==1) {document.getElementById(el_id["addb"]).click();}
                if (c==2) {document.getElementById(el_id["editrb"]).click();}
                return false;
            }
        }
        function hide(id) {
            if (document.getElementById) {
                document.getElementById(id).style.display = 'none';
            } else {
                if (document.layers) {
                    document.id.display = 'none';
                } else {
                    document.all.id.style.display = 'none';
                }
            }
        }
        function show(id) {
            if (document.getElementById) {
                document.getElementById(id).style.display = 'block';
            }
            else {
                if (document.layers) {
                    document.id.display = 'block';
                } else {
                    document.all.id.style.display = 'block';
                }
            }
        }
        function clone(o) {
            if (!o || 'object' !== typeof o)  {
                return o;
            }
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
                newlabel.value="<?=$labels['rating']['title'];?>";
                newfoo.value="<?=$labels['rating']['mark'];?>";
                newr.value="<?=$labels['rating']['mark'];?>";
                show(el_id["editbar"]);
                hide(el_id["editb"]);
                totable();
                document.getElementById(el_id["editb"]).setAttribute('disabled',"");
            } else {
                hide(el_id["editbar"]);
                show(el_id["editb"]);
                togrid();
                r_colmod=clone(colmod);
                r_mydata=clone(mydata);
                r_foodata=clone(foodata);
                document.getElementById(el_id["editb"]).removeAttribute('disabled');
                document.getElementById(el_id["rest"]).setAttribute('disabled',"");
                setMenuHeight();
            }
            setHeight();
            editing=ch;
        }
        function r_update() {
            if (myrselect) {
	        	myrselect.parentNode.removeChild(myrselect);
	        	myrselect=myselect.cloneNode(true);
	        	var editrb_node=document.getElementById(el_id["editrb"]);
	            editrb_node.parentNode.insertBefore(myrselect,editrb_node);
            }
        }
        //--------------------------------------------------END support

        //--------------------------------------------------BEGIN cols edit
        function addCol(newl, newf) {
            newl=newl.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
            newf=newf.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
            if (newf=="" || !IsNumeric(newf)) {newfoo.focus(); newfoo.select(); return;}
            if (newl=="") return;
            newf=newf.replace(/^[0]+/g,"");
            if(newf=="") {newf="0";}

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
            r_update();

            //add to colmod
            var s="col"+(parseInt(colmod[colmod.length-1].name.substr(3))+1);
            colmod=colmod.concat([{label:newl,name:s,index:s, width:60, align:"right",sorttype:"none", editable:true, editrules:{number:true}}]);
            //add to data
            for (i = 0; i < mydata.length; i++)
                mydata[i][s]="0";
            //add to foodata
            foodata[s]=newf;

            document.getElementById(el_id["rest"]).removeAttribute('disabled');
            document.getElementById(el_id["delb"]).removeAttribute('disabled');
            togrid();
            newlabel.select();newlabel.focus();
        }

        function delCol(deli) {
            if (!IsNumeric(deli)) {alert('<bad request>');return;}
            if (deli=='1') {alert('You can not delete the first column!');return;}

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
                } else {
                    myselect.selectedIndex=deli-3;
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
            if (myselect.options.length==0) {document.getElementById(el_id["delb"]).setAttribute('disabled',"");}
            togrid();
        }

        function restore() {
            myselect.parentNode.removeChild(myselect);
            myselect=r_select.cloneNode(true);
            var delb_node=document.getElementById(el_id["delb"]);
            delb_node.parentNode.insertBefore(myselect,delb_node);
            r_update();

            colmod=clone(r_colmod);
            mydata=clone(r_mydata);
            foodata=clone(r_foodata);

            document.getElementById(el_id["rest"]).disabled="disabled";
            document.getElementById(el_id["delb"]).removeAttribute('disabled');
            togrid();
        }

        function editmaxr(index,newf) {
            newf=newf.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
            if (newf=="" || !IsNumeric(newf)) {newr.focus(); newr.select(); return;}
            newf=newf.replace(/^[0]+/g,"");
            if(newf=="") {newf="0";}
            foodata[colmod[index+1].name]=newf;
            jQuery("#"+el_id["desttable"]).jqGrid('footerData',"set",foodata);
            document.getElementById(el_id["rest"]).removeAttribute('disabled');
        }
        //--------------------------------------------------END cols edit

        //--------------------------------------------------BEGIN convert
        function togrid() {
            jQuery("#"+el_id["desttable"]).jqGrid('GridUnload',"#"+el_id["desttable"]);

            jQuery("#"+el_id["desttable"]).jqGrid($.extend(opts,{colModel:colmod}));
            for (i=0;i<mydata.length;i++)
                jQuery("#"+el_id["desttable"]).jqGrid('addRowData',i+1,mydata[i]);
            jQuery("#"+el_id["desttable"]).jqGrid('footerData',"set",foodata);
            totable();
        }

        function totable() {
            if (colmod.length==0) return;
            //store data
            mydata=jQuery("#"+el_id["desttable"]).jqGrid('getRowData');

            if (myselect) {
                myselect.parentNode.removeChild(myselect);
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
            var delb_node=document.getElementById(el_id["delb"]);
            delb_node.parentNode.insertBefore(myselect,delb_node);
            r_update();
            if (!r_select) {r_select=myselect.cloneNode(true);}

            try {
                newlabel.focus();newlabel.select();
            }
            catch(ex) {}
        }
        //--------------------------------------------------END convert
    </script>
</div>