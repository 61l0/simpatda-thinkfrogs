<fieldset>
  <legend><?php echo $breadcrumbs;?></legend>
</fieldset>

<table id="grid"></table>
<div id="pager"></div>

	<script type="text/javascript">

	$(document).ready(function() {
		
		
		$("#grid").jqGrid({
			url:'<?php echo base_url()?>sts/daftar_sts',
			editurl:'<?php echo base_url()?>sts/daftar_sts',
			datatype:'json',
			mtype:'POST',
			colNames:['NOMOR STS','TGL SETOR', 'TOTAL SETOR'],
			colModel:[
				{name:'nomor_sts',index:'nomor_sts',width:180,editable:true,editoptions:{size:30,class:"span3"},editrules:{required:true}},
				{name:'tgl_setor', index:'tgl_setor',width:115,editable:true,edittype:'text',editoptions:{size:10,class:"span2"}},
				{name:'total_setor', index:'total_setor',width:115,editable:true,edittype:'text',editoptions:{size:10,class:"span2"}}
			],
			rowNum:10,
			rowList:[10,20,30],
			rownumbers:true,
			pager:'#pager',
			viewrecords:true,
			gridview:true,
			width:930,
			height:250,
			ondblClickRow:edit_row
		});
		
		
		
	
		$("#grid").jqGrid( 'navGrid', '#pager', { 
			add:true,
			addtext: 'Tambah',
			addfunc:function(){
			  location.href = root+modul+'<?php echo $link_form;?>/create';
			},
			refresh: true,
			refreshtext: 'Refresh',
			editfunc:edit_row,
		});
		
		function edit_row(){
			location.href = root+modul+'/update/'+ $("#grid").jqGrid ('getCell', $("#grid").jqGrid('getGridParam', 'selrow'), 'nomor_sts');
		}
		
		$("#add_grid").show();
		$("#edit_grid").hide();
		$("#del_grid").hide();
		$("#search_grid").hide();
		
		function restore_row(id){
			if(id && id !== last){
				$('#grid').jqGrid('restoreRow', last);
				last = null;
			}
		}

	
		
		function errorfunc(id, resp){
			var msg = $.parseJSON(resp.responseText);
			$.pnotify({
			  title: msg.isSuccess ? 'Sukses' : 'Gagal',
			  text: msg.message,
			  type: msg.isSuccess ? 'info' : 'error'
			});

			$('#grid').jqGrid('restoreRow', last);
			$('#grid').trigger("reloadGrid");
		}
	
		$('#filter').click(function(){
			var field 	= $("#field").val();
			var oper 	= $("#oper").val();
			var string 	= $("#string").val();
			
			var grid = $("#grid");
			var postdata = grid.jqGrid('getGridParam','postData');
			$.extend (postdata,
						   {filters:'',
							searchField: field,
							searchOper: oper,
							searchString: string});
			grid.jqGrid('setGridParam', { search: true, postData: postdata });
			grid.trigger("reloadGrid",[{page:1}]);
		}); 
	
		$('#string').keypress(function (e) {
			if (e.which == 13) {
				$('#filter').click();
			}
		}); 
	
	});
	</script>