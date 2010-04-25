<? if (!defined("entrypoint"))die;?>
<div id="profile">

<!---------------------------->
<!-- remember to sync el_id -->
<!---------------------------->

<div style="display:none"><table id="et"></table></div>
<div id="collabels"></div>

<div id="tcontainer">
	<table id="desttable" border=1></table>
</div>
<br>

<INPUT TYPE="button" ID="edittable" VALUE="edit cols" ONCLICK="myswitch(1)" />

<div id="editbar" style="display:none">
	<INPUT TYPE="text" SIZE=40 ID="labeledit" VALUE="" MAXLENGTH=200 ONKEYDOWN="return processkey(event)" /> <input id="addb" type="button" value="add" onclick="addCol(newlabel.value)" />
	<div id="scontainer">
		<!--select id="delnum"></select-->
		<INPUT ID="delb" TYPE="button" VALUE="delete" ONCLICK="if (myselect.options.length) delCol(myselect.options[myselect.selectedIndex].value)" />
	</div>
	<br>
	<INPUT ID="rest" TYPE="button" VALUE="restore" ONCLICK="restore()" disabled />
	<INPUT TYPE="button" ID="savetable" VALUE="save changes" ONCLICK="myswitch(0)" />
</div>
<br>
<br>


<script type="text/javascript">
	var el_id={et:"et", collabels:"collabels", tcontainer:"tcontainer", desttable:"desttable", edittable:"edittable", editbar:"editbar", labeledit:"labeledit", addb:"addb", scontainer:"scontainer", delb:"delb", rest:"rest", savetable:"savetable", delnum:"delnum"};	// don't change 'delnum'
	var colmod=[
			{label:"Ім\'я",name:"stud_name",index:"stud_name", width:100},
			{label:"22.04",name:"col1",index:"col1", width:80, align:"right",sorttype:"none", editable:true, editrules:{number:true}},
			{label:"29.04",name:"col2",index:"col2", width:80, align:"right",sorttype:"number", editable:true, editrules:{number:true}},
			{label:"КР",name:"col3",index:"col3", width:80, align:"right",sorttype:"none", editable:true, editrules:{number:true}}
		];
	var mydata=[
			{stud_name:"Тоха",col1:"2",col2:"1",col3:"2"},
			{stud_name:"Верес",col1:"1",col2:"2",col3:"3"},
			{stud_name:"Голубов",col1:"1",col2:"3",col3:"3"},
			{stud_name:"Зелінський",col1:"1",col2:"4",col3:"3"},
			{stud_name:"Корнічук",col1:"1",col2:"5",col3:"3"},
			{stud_name:"Парфьонов",col1:"1",col2:"6",col3:"3"},
		];
	var opts={
		caption: "Група: КМ-72",
		height: 150,
		width: 350,
		cellEdit: true,
		cellsubmit: "clientArray",
		multiselect: false,
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
							jQuery("#"+el_id["desttatble"]).jqGrid('setLabel',jQuery("#"+el_id["desttable"]).jqGrid('getColProp',index).name,newstr);
							colmod[colindex].label=newstr;
						}
					},
					editCaption: "Зміна '"+jQuery("#"+el_id["desttable"]).jqGrid('getColProp',index).label+"'",
					bSubmit: "Зберегти",
					bCancel: "Відміна",
				});
			};
		}
	};
	
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('6 f=5.8(4["q"]);6 7=5.8(4["1R"]);6 Q=5.8(4["27"]);6 L=5.8(4["29"]);6 1c,1g,1f,1d,12,i;r(5).26(g(){r("#"+4["q"]).A($.1K(1O,{1i:9}));k(i=0;i<h.a;i++)r("#"+4["q"]).A(\'18\',i+1,h[i]);r("#"+4["1u"]).A({2m:"2i",1m:[\'Нова назва:\'],1i:[{O:\'1b\',1z:\'1b\',1y:2d,1s:w,2f:{2g:25}}],});r("#"+4["1u"]).A(\'18\',1,{1b:""})});g 1r(1a){6 1B="2l.";6 Z=w;6 1p;k(i=0;i<1a.a&&Z==w;i++){1p=1a.2h(i);d(1B.S(1p)==-1){Z=1G}}x Z}g 1w(){x f.1C("2j")/f.1C("2n")}g 2c(e){d(1n==e)e=2k.2o;d(e.2a==13){5.8(4["23"]).22();x 1G}}g F(V){d(V){X(4["19"]);6 C=5.8(4["19"]);d(9.a==1){C.t="1m=[<b>&20;21&24;</b>]<E><E>";x}C.t="";C.t+="1m=[\\\'<b>"+9[1].P;d(9.a>2){k(i=2;i<9.a-1;i++)C.t+="</b>\\\', \\\'<b>"+9[i].P;C.t+="</b>\\\', \\\'<b>"+9[i].P+"</b>\\\']<E><E>"}B{C.t+="</b>\\\']<E><E>"}}B{W(4["19"])}}g X(U){5.8(U).I("1F")}g W(U){5.8(U).n("1F","2b:1H")}g 2e(V){d(V){X(4["1D"]);W(4["T"]);F(1);1P();5.8(4["T"]).n(\'y\',"");5.8(4["R"]).n(\'y\',"")}B{W(4["1D"]);X(4["T"]);F(0);1V();5.8(4["T"]).I(\'y\')}}g G(o){d(!o||\'1A\'!==1q o){x o}6 c=\'g\'===1q o.2J?[]:{};6 p,v;k(p 2H o){d(o.2N(p)){v=o[p];d(v&&\'1A\'===1q v){c[p]=G(v)}B{c[p]=v}}}x c}g 2F(J){J=J.1E(/^\\s\\s*/,\'\').1E(/\\s\\s*$/,\'\');d(J=="")x;6 K=f.1x;k(i=0;i<K.a;i++)K[i].1o(-1).t=\'0\';6 m=5.D(\'1T\');6 H=7.z.a;d(H==0){H=1}B{H+=1}m.16=(H)+\': \'+J;m.1l=H+1;1L{7.10(m,1n)}1M(1N){7.10(m)}6 s=\'2G\'+9.a;9=9.2w([{P:J,O:s,1z:s,1y:2u,2t:"2q",2r:"1H",1s:w,2y:{2D:w}}]);F(1);k(i=0;i<h.a;i++)h[i][s]="0";5.8(4["R"]).I(\'y\');5.8(4["M"]).I(\'y\');Q.1W();Q.1X()}g 2E(l){d(!1r(l)){1t(\'<2B 2z>\');x}d(l==\'1\'){1t(\'Нельзя удалить первый столбец!\');x}d(l==1w()){l=-1}6 K=f.1x;k(i=0;i<K.a;i++)K[i].2A(l-1);7.2v(l-2);k(i=l-2;i<7.z.a;i++){6 s=7.z[i].16;6 1e=s.1v(0,s.S(\':\'));6 1Y=s.1v(s.S(\':\'),s.a-s.S(\':\'));7.z[i].16=(1e-1)+1Y;7.z[i].n(\'1l\',1e)}d(7.z.a!=1){d(l-2!=7.z.a){7.1I=l-2}B{7.1I=l-3}}k(i=0;i<h.a;i++)2C h[i][9[l-1].O];9.2x(l-1,1);F(1);5.8(4["R"]).I(\'y\');d(7.z.a==0){5.8(4["M"]).n(\'y\',"")}}g 2s(){f.1J.N(f);f=1c.11(w);L.Y(f);7.1J.N(7);7=1g.11(w);6 1h=5.1U(\' \');6 u=5.8(4["17"]);6 14=5.8(4["M"]);u.15(1h,14);u.15(7,1h);9=G(1f);h=G(1d);F(1);5.8(4["R"]).n(\'y\',"");5.8(4["M"]).I(\'y\')}g 1V(){L.N(f);f=5.D(\'1S\');f.n(\'1j\',4["q"]);L.Y(f);6 u=5.8(4["17"]);u.N(7);u.N(12);r("#"+4["q"]).A($.1K(1O,{1i:9}));k(i=0;i<h.a;i++)r("#"+4["q"]).A(\'18\',i+1,h[i])}g 1P(){h=r("#"+4["q"]).A(\'2M\');r("#"+4["q"]).A(\'2I\',"#"+4["q"]);f=5.D(\'1S\');f.n(\'2K\',\'1\');f.n(\'1j\',"#"+4["q"]);6 1Q=f.Y(5.D(\'2L\'));k(i=0;i<h.a;i++){6 1k=1Q.2p(-1);k(6 j=0;j<9.a;j++)d(j==0){1k.1o(-1).t=\'<b>\'+h[i][9[0].O]+\'</b>\'}B{1k.1o(-1).t=h[i][9[j].O]}}L.Y(f);7=5.D(\'28\');7.n(\'1j\',4["1R"]);6 m;k(i=1;i<9.a;i++){m=5.D(\'1T\');m.16=i+\': \'+9[i].P;m.1l=i+1;1L{7.10(m,1n)}1M(1N){7.10(m)}}6 1Z=5.1U(\' \');6 14=5.8(4["M"]);6 u=5.8(4["17"]);12=u.15(1Z,14);u.15(7,12);1c=f.11(w);1g=7.11(w);1f=G(9);1d=G(h);Q.1X();Q.1W()}',62,174,'||||el_id|document|var|myselect|getElementById|colmod|length|||if||mytable|function|mydata|||for|deli|elOptNew|setAttribute|||desttable|jQuery||innerHTML|cont_node||true|return|disabled|options|jqGrid|else|where|createElement|br|printlabels|clone|len|removeAttribute|newl|trArr|mycontainer|delb|removeChild|name|label|newlabel|rest|indexOf|edittable|objid|ch|hide|show|appendChild|IsNumber|add|cloneNode|temp_space||delb_node|insertBefore|text|scontainer|addRowData|collabels|sText|ec|r_table|r_mydata|ii|r_colmod|r_select|temp|colModel|id|newRow|value|colNames|null|insertCell|Char|typeof|IsNumeric|editable|alert|et|substr|getcolnum|rows|width|index|object|ValidChars|getElementsByTagName|editbar|replace|style|false|none|selectedIndex|parentNode|extend|try|catch|ex|opts|totable|tbody|delnum|TABLE|option|createTextNode|togrid|select|focus|ss|text_node|lt|empty|click|addb|gt||ready|labeledit|SELECT|tcontainer|keyCode|display|processkey|90|myswitch|editoptions|size|charAt|local|td|window|0123456789|datatype|tr|event|insertRow|right|sorttype|restore|align|80|remove|concat|splice|editrules|request|deleteCell|bad|delete|number|delCol|addCol|col|in|GridUnload|pop|border|TBODY|getRowData|hasOwnProperty'.split('|'),0,{}))
</script>
</div>
