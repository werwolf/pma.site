<? if (!defined("entrypoint"))die;?>
<div id="profile">

<table id="le_table"></table>
<div id="le_tablePager"></div>
<div style="display:none"><table id="et"></table></div>

<br><table id="distTable" border=1>
<tbody>
<tr> 
	<td>Chatter</td><td>PC</td><td>123</td>
</tr> 
<tr> 
	<td>Boing</td><td>PC</td><td>456</td>
</tr> 
<tr> 
	<td>Zipper</td><td>Mac</td><td>789</td>
</tr> 
<tr> 
	<td>PingPong</td><td>Mac</td><td>24</td>
</tr>
</tbody>
</table>
<br><input type="button" id="magicbutton" value="let the magic begin" /><br><br>

<script type="text/javascript">
//jQuery(document).ready(function(){
jQuery("#magicbutton").click( function() {
	//function tableToGrid(selector, options, newcolModel) {...}
	tableToGrid("#distTable",{
		caption: "HTML table 2 jqGrid",
		height: 88,
		width:350,
		cellEdit: true,
		cellsubmit: 'clientArray',
		multiselect: false,

		onSortCol: function( index, colindex, sortorder) {
			if(jQuery("#distTable").jqGrid('getColProp',index).sorttype=="none") {
				jQuery("#et").jqGrid('setCell',1,'ec',undefined);
				jQuery("#et").jqGrid('editGridRow',1,{
					reloadAfterSubmit:false,
					top:document.body.clientHeight/2-20,
					left:document.body.clientWidth/2-120,
					width:240,
					modal:true,
					resize:false,
					url:"http://pma.site/ua/profile/rating",//EXTRA
					savekey:[true,13],
					closeOnEscape:true,
					closeAfterEdit:true,
					viewPagerButtons:false,
					afterComplete : function (response, postdata, formid) {
						newstr=jQuery("#et").jqGrid('getCell',1,'ec');
						if (newstr.replace(/^\s\s*/, '').replace(/\s\s*$/, '')!="") {
							jQuery("#distTable").jqGrid('setLabel',jQuery("#distTable").jqGrid('getColProp',index).name,newstr)
						}
					},
					editCaption: "Зміна '"+jQuery("#distTable").jqGrid('getColProp',index).label+"'",
					bSubmit: "Зберегти",
					bCancel: "Відміна",
				});
			};
		}
	},
//newcolModel
	[	{label:'Name',name:'name1',index:'name1', width:100},
		{label:'Platform',name:'platform1',index:'platform1', width:100},
		{label:'Size',name:'size1',index:'size1', width:80, align:"right",sorttype:"none", editable:true, editrules:{number:true}}
	]
	);
});	 
//});


jQuery("#le_table").jqGrid({
	datatype: "local",
	height: 220,
	cellEdit: true,
	cellsubmit: 'clientArray',
	colModel:[
		{label:'Inv No',name:'id',index:'id', width:60, sorttype:"int"},
		{label:'Date',name:'invdate',index:'invdate', width:90, sorttype:"none"},
		{label:'Client',name:'name',index:'name', width:100},
		{label:'Amount',name:'amount',index:'amount', width:80, align:"right",sorttype:"none"},
		{label:'Tax',name:'tax',index:'tax', width:80, align:"right",sorttype:"none", editable:true, editrules:{number:true}, align:"right"},		
		{label:'Total',name:'total',index:'total', width:80,align:"right",sorttype:"none"},		
		{label:'Notes',name:'note',index:'note', width:150, sortable:false}		
	],
	multiselect: false,
	caption: "Оценки",

	onSortCol: function( index, colindex, sortorder) {
		if(jQuery("#le_table").jqGrid('getColProp',index).sorttype=="none") {
			jQuery("#et").jqGrid('setCell',1,'ec',undefined);
			jQuery("#et").jqGrid('editGridRow',1,{
				reloadAfterSubmit:false,
				top:document.body.clientHeight/2-20,
				left:document.body.clientWidth/2-120,
				width:240,
				modal:true,
				resize:false,
				url:"http://pma.site/ua/profile/rating",//EXTRA
				savekey:[true,13],
				closeOnEscape:true,
				closeAfterEdit:true,
				viewPagerButtons:false,
				afterComplete : function (response, postdata, formid) {
					newstr=jQuery("#et").jqGrid('getCell',1,'ec');
					if (newstr.replace(/^\s\s*/, '').replace(/\s\s*$/, '')!="") {
						jQuery("#le_table").jqGrid('setLabel',jQuery("#le_table").jqGrid('getColProp',index).name,newstr)
					}
				},
				editCaption: 'Зміна \''+jQuery("#le_table").jqGrid('getColProp',index).label+'\'',
				bSubmit: "Зберегти",
				bCancel: "Відміна",
			});
		}
	}
});
var mydata = [
   		{id:"1",invdate:"2007-10-01",name:"test",note:"note",amount:"200.00",tax:"10.00",total:"210.00"},
   		{id:"2",invdate:"2007-10-02",name:"test2",note:"note2",amount:"300.00",tax:"20.00",total:"320.00"},
   		{id:"3",invdate:"2007-09-01",name:"test3",note:"note3",amount:"400.00",tax:"30.00",total:"430.00"},
   		{id:"4",invdate:"2007-10-04",name:"test",note:"note",amount:"200.00",tax:"10.00",total:"210.00"},
   		{id:"5",invdate:"2007-10-05",name:"test2",note:"note2",amount:"300.00",tax:"20.00",total:"320.00"},
   		{id:"6",invdate:"2007-09-06",name:"test3",note:"note3",amount:"400.00",tax:"30.00",total:"430.00"},
   		{id:"7",invdate:"2007-10-04",name:"test",note:"note",amount:"200.00",tax:"10.00",total:"210.00"},
   		{id:"8",invdate:"2007-10-03",name:"test2",note:"note2",amount:"300.00",tax:"20.00",total:"320.00"},
   		{id:"9",invdate:"2007-09-01",name:"test3",note:"note3",amount:"400.00",tax:"30.00",total:"430.00"}
   		];
for(var i=0;i<=mydata.length;i++)
	jQuery("#le_table").jqGrid('addRowData',i+1,mydata[i]);

jQuery("#et").jqGrid({
	datatype: "local",
	colNames:['Нова назва:'],
	colModel:[{name:'ec',index:'ec', width:90,editable:true,editoptions:{size:25}}],
});
jQuery("#et").jqGrid('addRowData',1,{ec:""});
    </script>
</div>
