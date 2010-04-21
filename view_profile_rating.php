<? if (!defined("entrypoint"))die;?>
<div id="profile">

<table id="le_table"></table>
<div id="le_tablePager"></div>
<div style="display:none"><table id="et"></table></div>

<script type="text/javascript">
jQuery("#le_table").jqGrid({
	datatype: "local",
	height: 250,
	colNames:['Inv No','Date', 'Client', 'Amount','Tax','Total','Notes'],
	colModel:[
		{name:'id',index:'id', width:60, sorttype:"int"},
		{name:'invdate',index:'invdate', width:90, sorttype:"none"},
		{name:'name',index:'name', width:100},
		{name:'amount',index:'amount', width:80, align:"right",sorttype:"none"},
		{name:'tax',index:'tax', width:80, align:"right",sorttype:"none"},		
		{name:'total',index:'total', width:80,align:"right",sorttype:"none"},		
		{name:'note',index:'note', width:150, sortable:false}		
	],
	multiselect: false,
	caption: "Оценки",

	onSortCol: function( index, colindex, sortorder) {
            if(jQuery("#le_table").jqGrid('getColProp',index).sorttype=="none") {
                jQuery("#et").jqGrid('setCell',1,'ec',undefined);
                jQuery("#et").jqGrid('editGridRow',1,{
                    reloadAfterSubmit:false,
                    top:425,
                    left:450,
                    width:250,
                    modal:true,
                    resize:false,
                    url:"http://pma.site/ua/profile/rating",//EXTRA
                    savekey:[true,13],
                    closeOnEscape:true,
                    closeAfterEdit:true,
                    viewPagerButtons:false,
                    afterComplete : function (response, postdata, formid) {
                        jQuery("#le_table").jqGrid('setLabel',jQuery("#le_table").jqGrid('getColProp',index).name,jQuery("#et").jqGrid('getCell',1,'ec'))
                    },
                    editCaption: "Тут якийсь title 8)",
                    bSubmit: "Зберегти",
                    bCancel: "Відміна"
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
	colNames:['Новый лейбл:'],
	colModel:[{name:'ec',index:'ec', width:90,editable:true,editoptions:{size:25}}]
});
jQuery("#et").jqGrid('addRowData',1,{ec:""});
    </script>
</div>