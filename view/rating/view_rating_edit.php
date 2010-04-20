<? if (!defined("entrypoint"))die;?>
<div id="profile">

    <form action="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/rating/" method="post" id="addColForm">
        <div style="padding: 5px; background-color: silver; margin-bottom: 5px;">
            <div class="lable" style="float: left; clear: right; margin-right: 5px; color: white; font-size: 17px;">Название колонки</div>
            <input type="text" name="colname" size="15" maxlength="100" value="" id="colname"/>
            <input type="submit" name="add" id="addCol"  value="Add" class="button"/>
        </div>
    </form>

    <table id="celltbl"></table>
    <!--<div id="le_tablePager"></div>-->
    <a href="javascript:void(0)" id="clickme">click me</a>

    <script src="http://<?=$_SERVER['HTTP_HOST'];?>/static/jqgrid/js/celledit.js" type="text/javascript"></script>

    <script type="text/javascript">
        jQuery("#celltbl").jqGrid({
            datatype: "local",
            height: "100%",
            //colNames:['Inv No','Date', 'Client', 'Amount','Tax','Total','Notes'],
            colModel:[
                {name:'id',     index:'id',      width:60,  sortable:false},
                {name:'invdate',index:'invdate', width:90,  sortable:false},
                {name:'name',   index:'name',    width:100, sortable:false},
                {name:'amount', index:'amount',  width:80,  sortable:false, editable:true, editrules:{number:true}, align:"right"},
                {name:'tax',    index:'tax',     width:80,  sortable:false, editable:true, editrules:{number:true}, align:"right"},
                {name:'total',  index:'total',   width:80,  sortable:false, editable:true, editrules:{number:true}, align:"right"},
                {name:'note',   index:'note',    width:150, sortable:false}
            ],
            multiselect: false,
            caption: "Manipulating Array Data",

            //forceFit : true,
            rownumbers: true,
            rownumWidth: 15,
            cellEdit: true,
            cellsubmit: 'clientArray',

            //onCellSelect: function( rowid, iCol, cellcontent, e) {
            //    jQuery("#celltbl").jqGrid('setLabel','id','haha');
            //}

//	afterEditCell: function (id,name,val,iRow,iCol){
//		if(name=='invdate') {
//			jQuery("#"+iRow+"_invdate","#celltbl").datepicker({dateFormat:"yy-mm-dd"});
//		}
//	},
//	afterSaveCell : function(rowid,name,val,iRow,iCol) {
//		if(name == 'amount') {
//			var taxval = jQuery("#celltbl").jqGrid('getCell',rowid,iCol+1);
//			jQuery("#celltbl").jqGrid('setRowData',rowid,{total:parseFloat(val)+parseFloat(taxval)});
//		}
//		if(name == 'tax') {
//			var amtval = jQuery("#celltbl").jqGrid('getCell',rowid,iCol-1);
//			jQuery("#celltbl").jqGrid('setRowData',rowid,{total:parseFloat(val)+parseFloat(amtval)});
//		}
//	}
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
            jQuery("#celltbl").jqGrid('addRowData',i+1,mydata[i]);

        //jQuery("#clickme").click( function() {jQuery("#celltbl").jqGrid('setLabel','id','haha')});

    </script>

    <h1>WERWOLF</h1>
</div>