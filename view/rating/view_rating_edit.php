<? if (!defined("entrypoint"))die;?>
<div id="profile">

    <div id="message" style="height: 20px; color: black;"></div>

    <div style="padding: 5px; background-color: silver; margin-bottom: 5px;">
        <form action="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/rating/" method="post" id="addColForm">
            <div style="float: left;">
                <div class="lable2" style="float: left; clear: right; margin-right: 5px; color: white; font-size: 17px;">Название колонки</div>
                <input type="text" name="colname" id="colname2" value="" size="15" maxlength="100" style="float: left;" />
                <!--<input type="submit" name="add" id="addCol"  value="Add" id="addCol_btn"/>-->
            </div>

        </form>
        <input type="submit" name="add" value="Add" id="addCol_btn" style="float: left;" />
        <div style="clear: left;"></div>
    </div>

    <table id="celltbl"></table>
    <!--<div id="le_tablePager"></div>-->
    <div style="display:none"><table id="et"></table></div>

    <a href="javascript:void(0)" id="clickme">click me</a>

    <script src="http://<?=$_SERVER['HTTP_HOST'];?>/static/jqgrid/js/celledit.js" type="text/javascript"></script>

    <script type="text/javascript">
        jQuery("#celltbl").jqGrid({
            datatype: "local",
            height: "100%",
            colNames:['Inv No','Date', 'Client', 'Amount','Tax','Total','Notes'],
            colModel:[
                {name:'id',     index:'id',      width:60,  sorttype:'none'},
                {name:'invdate',index:'invdate', width:90,  sorttype:'date'},
                {name:'name',   index:'name',    width:100, sorttype:'none'},
                {name:'amount', index:'amount',  width:80,  sorttype:'none', editable:true, editrules:{number:true}, align:"right"},
                {name:'tax',    index:'tax',     width:80,  sorttype:'none', editable:true, editrules:{number:true}, align:"right"},
                {name:'total',  index:'total',   width:80,  sorttype:'none', editable:true, editrules:{number:true}, align:"right"},
                {name:'note',   index:'note',    width:150, sorttype:'none'}
            ],
            multiselect: false,
            caption: "Manipulating Array Data",

            //forceFit : true,
            rownumbers: true,
            rownumWidth: 15,
            cellEdit: true,
            cellsubmit: 'clientArray',

            onSortCol: function( index, colindex, sortorder) {
                if(jQuery("#celltbl").jqGrid('getColProp',index).sorttype=="none") {
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
                            jQuery("#celltbl").jqGrid('setLabel',jQuery("#celltbl").jqGrid('getColProp',index).name,jQuery("#et").jqGrid('getCell',1,'ec'))
                        },
                        editCaption: "Тут якийсь title 8)",
                        bSubmit: "Зберегти",
                        bCancel: "Відміна"
                    });
                }
            }
        });

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


        //$(document).ready(function(){
        jQuery("#addCol_btn").click( function(){
            jQuery("#celltbl").jqGrid('setLabel','id','haha');
            //jQuery("#celltbl").jqGrid('setGridParam'
        });
        //});
        //jQuery("#clickme").click( function() {jQuery("#celltbl").jqGrid('setLabel','id','haha')});

        jQuery("#et").jqGrid({
            datatype: "local",
            colNames:['Новый лейбл:'],
            colModel:[{name:'ec',index:'ec', width:90,editable:true,editoptions:{size:25}}]
        });
        jQuery("#et").jqGrid('addRowData',1,{ec:""});

    </script>

    <h1>WERWOLF</h1>
</div>