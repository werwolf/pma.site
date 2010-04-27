<? if (!defined("entrypoint"))die;?>
<div id="profile">

    <!-- - - - - - - - - - - - - t-->
    <!-- remember to sync el_id  -->
    <!-- - - - - - - - - - - - - -->
    <a href="javascript:void(0);" onclick="get_table()">clic me</a>

    <div style="display:none"><table id="et"></table></div>
    <div id="thtmlcontainer" style="display:none"><table id="htmltable"></table></div>
    <div id="collabels"></div>

    <div id="tcontainer">
        <table id="desttable" border=1></table>
    </div>
    <br/>

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
    <br/>
    <br/>


    <script type="text/javascript">
        var el_id={et:"et", collabels:"collabels", tcontainer:"tcontainer", thtmlcontainer:"thtmlcontainer", desttable:"desttable", htmltable:"htmltable", edittable:"edittable", editbar:"editbar", labeledit:"labeledit", addb:"addb", scontainer:"scontainer", delb:"delb", rest:"rest", savetable:"savetable", delnum:"delnum"};	// don't change 'delnum'
//        var colmod=[
//            {label:"Ім\'я",name:"stud_name",index:"stud_name", width:150},
//            {label:"22.04",name:"col1",index:"col1", width:60, align:"right",sorttype:"none", editable:true, editrules:{number:true}},
//            {label:"29.04",name:"col2",index:"col2", width:60, align:"right",sorttype:"number", editable:true, editrules:{number:true}},
//            {label:"КР",name:"col3",index:"col3", width:60, align:"right",sorttype:"none", editable:true, editrules:{number:true}},
//            {label:"КР",name:"col4",index:"col4", width:60, align:"right",sorttype:"none", editable:true, editrules:{number:true}},
//            {label:"КР",name:"col5",index:"col5", width:60, align:"right",sorttype:"none", editable:true, editrules:{number:true}},
//            {label:"КР",name:"col6",index:"col6", width:60, align:"right",sorttype:"none", editable:true, editrules:{number:true}}
//        ];
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
            caption: "Група: КМ-72",
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

        //<!-- eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('6 T=5.8(4["q"]);6 d=5.8(4["1P"]);6 7=5.8(4["1G"]);6 J=5.8(4["1Z"]);6 1S=5.8(4["2i"]);6 11=5.8(4["2d"]);6 15,Z,X,N,Q,P,i;r(5).2g(h(){r("#"+4["q"]).z($.1T(1U,{18:f}));l(i=0;i<g.a;i++)r("#"+4["q"]).z(\'1h\',i+1,g[i]);r("#"+4["1M"]).z({28:"2h",2n:[\'Нова назва:\'],18:[{L:\'1c\',1H:\'1c\',1z:20,1s:u,23:{22:25}}]});r("#"+4["1M"]).z(\'1h\',1,{1c:""});N=y(f);Q=y(g);15=0});h 1r(1e){6 1W="2b.";6 O=u;6 1b;l(i=0;i<1e.a&&O==u;i++){1b=1e.2e(i);9(1W.10(1b)==-1){O=1I}}w O}h 1L(){w d.1t("2c")/d.1t("29")}h 2a(e){9(1k==e)e=2f.2l;9(e.2m==13){5.8(4["2k"]).2j();w 1I}}h 1a(S){5.8(S).C("1F")}h 16(S){5.8(S).n("1F","21:1K")}h y(o){9(!o||\'1u\'!==17 o){w o}6 c=\'h\'===17 o.24?[]:{};6 p,v;l(p 27 o){9(o.26(p)){v=o[p];9(v&&\'1u\'===17 v){c[p]=y(v)}H{c[p]=v}}}w c}h 2H(1f){9(1f){1a(4["1C"]);16(4["V"]);1n();5.8(4["V"]).n(\'t\',"")}H{16(4["1C"]);1a(4["V"]);I();N=y(f);Q=y(g);5.8(4["V"]).C(\'t\');5.8(4["R"]).n(\'t\',"")}15=1f}h 2G(E){E=E.1J(/^\\s\\s*/,\'\').1J(/\\s\\s*$/,\'\');9(E=="")w;6 B=d.1x;l(i=0;i<B.a;i++)B[i].1i(-1).1q=\'0\';6 m=5.D(\'1v\');6 F=7.A.a;9(F==0){F=1}H{F+=1}m.U=(F)+\': \'+E;m.1j=F+1;1l{7.14(m,1k)}1o(1d){7.14(m)}6 s=\'2J\'+f.a;f=f.2E([{1w:E,L:s,1H:s,1z:2I,2K:"2L",2F:"1K",1s:u,2C:{2t:u}}]);l(i=0;i<g.a;i++)g[i][s]="0";5.8(4["R"]).C(\'t\');5.8(4["K"]).C(\'t\');I();J.1D();J.1B()}h 2u(k){9(!1r(k)){1y(\'<2s 2D>\');w}9(k==\'1\'){1y(\'Нельзя удалить первый столбец!\');w}9(k==1L()){k=-1}6 B=d.1x;l(i=0;i<B.a;i++)B[i].2r(k-1);7.2p(k-2);l(i=k-2;i<7.A.a;i++){6 s=7.A[i].U;6 19=s.1R(0,s.10(\':\'));6 1V=s.1R(s.10(\':\'),s.a-s.10(\':\'));7.A[i].U=(19-1)+1V;7.A[i].n(\'1j\',19)}9(7.A.a!=1){9(k-2!=7.A.a){7.1Y=k-2}H{7.1Y=k-3}}l(i=0;i<g.a;i++)2q g[i][f[k-1].L];f.2o(k-1,1);5.8(4["R"]).C(\'t\');9(7.A.a==0){5.8(4["K"]).n(\'t\',"")}I()}h 2v(){d.1N.G(d);d=Z.M(u);11.Y(d);7.1N.G(7);7=X.M(u);6 1g=5.1E(\' \');6 x=5.8(4["1X"]);6 12=5.8(4["K"]);x.W(1g,12);x.W(7,1g);f=y(N);g=y(Q);5.8(4["R"]).n(\'t\',"");5.8(4["K"]).C(\'t\');I()}h I(){11.G(d);r("#"+4["q"]).z(\'2w\',"#"+4["q"]);T=5.D(\'1O\');T.n(\'1m\',4["q"]);1S.Y(T);r("#"+4["q"]).z($.1T(1U,{18:f}));l(i=0;i<g.a;i++)r("#"+4["q"]).z(\'1h\',i+1,g[i]);1n()}h 1n(){g=r("#"+4["q"]).z(\'2B\');d=5.D(\'1O\');d.n(\'2A\',\'1\');d.n(\'1m\',"#"+4["1P"]);6 1Q=d.Y(5.D(\'2z\'));l(i=0;i<g.a;i++){6 1p=1Q.2x(-1);l(6 j=0;j<f.a;j++)9(j==0){1p.1i(-1).1q=\'<b>\'+g[i][f[0].L]+\'</b>\'}H{1p.1i(-1).1q=g[i][f[j].L]}}11.Y(d);9(!Z){Z=d.M(u)}6 x=5.8(4["1X"]);9(7){x.G(7);x.G(P)}7=5.D(\'2y\');7.n(\'1m\',4["1G"]);6 m;l(i=1;i<f.a;i++){m=5.D(\'1v\');m.U=i+\': \'+f[i].1w;m.1j=i+1;1l{7.14(m,1k)}1o(1d){7.14(m)}}6 1A=5.1E(\' \');6 12=5.8(4["K"]);P=x.W(1A,12);x.W(7,P);9(!X){X=7.M(u)}1l{J.1B();J.1D()}1o(1d){}}',62,172,'||||el_id|document|var|myselect|getElementById|if|length|||myhtmltable||colmod|mydata|function|||deli|for|elOptNew|setAttribute|||desttable|jQuery||disabled|true||return|cont_node|clone|jqGrid|options|trArr|removeAttribute|createElement|newl|len|removeChild|else|togrid|newlabel|delb|name|cloneNode|r_colmod|IsNumber|temp_space|r_mydata|rest|objid|mytable|text|edittable|insertBefore|r_select|appendChild|r_table|indexOf|myhtmlcontainer|delb_node||add|editing|hide|typeof|colModel|ii|show|Char|ec|ex|sText|ch|temp|addRowData|insertCell|value|null|try|id|totable|catch|newRow|innerHTML|IsNumeric|editable|getElementsByTagName|object|option|label|rows|alert|width|text_node|focus|editbar|select|createTextNode|style|delnum|index|false|replace|none|getcolnum|et|parentNode|TABLE|htmltable|tbody|substr|mycontainer|extend|opts|ss|ValidChars|scontainer|selectedIndex|labeledit|90|display|size|editoptions|pop||hasOwnProperty|in|datatype|tr|processkey|0123456789|td|thtmlcontainer|charAt|window|ready|local|tcontainer|click|addb|event|keyCode|colNames|splice|remove|delete|deleteCell|bad|number|delCol|restore|GridUnload|insertRow|SELECT|TBODY|border|getRowData|editrules|request|concat|sorttype|addCol|myswitch|80|col|align|right'.split('|'),0,{})) -->
        var mytable = document.getElementById(el_id["desttable"]);
        var myhtmltable = document.getElementById(el_id["htmltable"]);
        var myselect = document.getElementById(el_id["delnum"]);
        var newlabel = document.getElementById(el_id["labeledit"]);
        var mycontainer = document.getElementById(el_id["tcontainer"]);
        var myhtmlcontainer = document.getElementById(el_id["thtmlcontainer"]);
        var editing, r_table, r_select, r_colmod, r_mydata, temp_space, i;


        //jQuery(document).ready(function(){
            //initialize grid & set data
            

        function get_table(){
            //alert('It is work');
            $.ajax({
                type:"POST",
                url:'http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/ajax/get_table/',
                cache:false,
                data:"subject=2_2",
                success:function(data)
                {
                    var table = eval("(" + data + ")");
                    //alert(table['data'][1]['stud_name']);

                    for(i=0; i<table["title"].length; i++)
                        $.extend(colmod[i],{ label:table["title"][colmod[i].name] });

                    for(i=0; i<table["data"].length; i++)
                        mydata[i]=clone(table["data"][i]);

                    InitTable();
//                    var html='<option>...</option>';
//                    var i = 0, key;
//
//                    for (key in groupes) {
//                        if (groupes.hasOwnProperty(key))
//                            html += '<option>KM-'+groupes[i++]+'</option>';
//                    }
//                    $("#groupes > select").html(html);
//                    $("#groupes").show("slow");
                }
            });
          };

        function InitTable(){
        //alert("work");
            jQuery("#"+el_id["desttable"]).jqGrid($.extend(opts,{colModel:colmod}));
            for (i=0;i<mydata.length;i++)
                jQuery("#"+el_id["desttable"]).jqGrid('addRowData',i+1,mydata[i]);

            //$("#"+el_id["desttable"]).jqGrid('setGridParam',{height:"500"});
            alert($("#destable").jqGrid('getGridParam',"height"));
            $("#profile").height($("#destable").jqGrid('getGridParam',"height"));
            alert($("#destable").jqGrid('getGridParam',"height"));

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