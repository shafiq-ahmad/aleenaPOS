<?php
defined('_MEXEC') or die ('Restricted Access');

?><div class="com-head">
	<h3>Sales Return</h3>
	<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><button type="reset" id="Cancel" class="btn btn-danger" value="Cancel" onclick="history.back();self.close();" tabindex="-1"><i class="glyphicon glyphicon-off"></i> Cancel</button></span>
				<span><a onclick="window.open('?com=sales&view=return&tmpl=bill','_blank', 'top=10, left= 100, scrollbars=no, titlebar=no, location=top, resizable=no, width=1124,height=560');return false;" class="btn btn-info" tabindex="-1"><i class="fa fa-file"></i> New</a></span>
			</li>
			<li></li>
		</ul>
	</div>
</div>
	<link rel="stylesheet" type="text/css" href="templates/default/bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" media="all" />
<div class="table-responsive">
	<div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="sales" />
			<input type="hidden" name="view" value="returns" />
			<div>
			
			<div class="form-group date-range">
				<label class="control-label col-sm-1" for="start_date">Range:</label>
				<div class="col-sm-2">
					<div class="input-group date">
						<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
						</div>
						<input name="start_date" type="date" autocomplete="off" id="start_date"class="form-control date<?php if(!isset($_GET['start_date'])){ echo '-default';}?>" value="<?php if(isset($_GET['start_date'])){ echo $_GET['start_date'];}?>" tabindex="-1" />
					</div>
				</div>
				<div class="col-sm-2">
					<div class="input-group date">
						<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
						</div>
						<input name="end_date" type="date" autocomplete="off" id="end_date"class="form-control date<?php if(!isset($_GET['end_date'])){ echo '-default';}?>" value="<?php if(isset($_GET['end_date'])){ echo $_GET['end_date'];}?>" tabindex="-1" />
					</div>
				</div>
				<div class="col-sm-2">
				<input type="submit" name="search_date" class="btn btn-success btn-sm screen" value="Search" />
				</div>
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
	<table id="data-table" class="table">
		<thead>
		<tr>
			<th>Date</th><th>Customer</th><th>Person</th><th>Total</th><th>Discount</th><th>Cash</th>
			<th>Credit</th><th>Change</th><th class="no-print">Actions</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><script>
	var json_data = <?php
		echo json_encode($this->rows); ?>;
	//console.log(json_data);
	var subTotal=0;
	var discount_amount=0;
	var cash=0;
	var credit=0;
	var change_return=0;
	$.each(json_data, function(i, v){
		document.write('<tr>');
		document.write('<td class="return_date">'+v.return_date+ '</td>');
		var cust = '';
		if(v.cust_title){
			cust = v.cust_title;
		}
		document.write('<td class="cat">'+cust+'</td>');
		document.write('<td class="cat">'+v.person+'</td>');
		document.write('<td class="total">'+eval(v.sub_total).toFixed(2)+'</td>');
		document.write('<td class="discount_amount">'+eval(v.discount_amount).toFixed(2)+'</td>');
		document.write('<td class="cash">'+eval(v.cash).toFixed(2)+'</td>');
		document.write('<td class="credit">'+eval(v.credit).toFixed(2)+'</td>');
		document.write('<td class="change_return">'+eval(v.change_return).toFixed(2)+'</td>');
		document.write('<td class="no-print"><a href="?com=sales&view=view_return&task=edit&id='+v.id+'" title="Edit"><i class="fa fa-edit"></i></a></td>');
		document.write('</tr>');
	});
		</script></tbody>
		<tfoot>
			<tr>
				<th colspan="3" style="text-align:right">Total:</th>
				<th colspan="1"></th>
				<th colspan="1"></th>
				<th colspan="1"></th>
				<th colspan="1"></th>
				<th colspan="2"></th>
			</tr>
		<script>
		//cals_reportItemsTotal();
		</script>
		</tfoot>
	</table>
</div>
<script>
$(document).ready(function(){
	
	$('#data-table').DataTable({
		dom: 'lfBrtip',buttons:['excel', 'pdf'],
		"footerCallback": function(row, data, start, end, display ) {
		var api = this.api(), data;

		// Remove the formatting to get integer data for summation
		var intVal = function (i) {
			return typeof i === 'string' ?
			i.replace(/[\$,]/g, '')*1 :
			typeof i === 'number' ?
			i : 0;
		};

		// Total over all pages
		total1 = api
		.column(3)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);

		total2 = api
		.column(4)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);
		total3 = api
		.column(5)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);
		total4 = api
		.column(6)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);
		total5 = api
		.column(7)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);

		// Total over this page
		pageTotal1 = api
		.column(3, { page: 'current'} )
		.data()
		.reduce(function (a, b){
			return intVal(a) + intVal(b);
		},0);
		pageTotal2 = api
		.column(4, { page: 'current'} )
		.data()
		.reduce(function (a, b){
			return intVal(a) + intVal(b);
		},0);
		pageTotal3 = api
		.column(5, { page: 'current'} )
		.data()
		.reduce(function (a, b){
			return intVal(a) + intVal(b);
		},0);
		pageTotal4 = api
		.column(6, { page: 'current'} )
		.data()
		.reduce(function (a, b){
			return intVal(a) + intVal(b);
		},0);
		pageTotal5 = api
		.column(7, { page: 'current'} )
		.data()
		.reduce(function (a, b){
			return intVal(a) + intVal(b);
		},0);

		// Update footer
		$( api.column(3).footer()).html(
			''+eval(pageTotal1).toFixed(2) +' ( '+ eval(total1).toFixed(2) +' total)'
		);
		$( api.column(4).footer()).html(
			''+eval(pageTotal2).toFixed(2) +' ( '+ eval(total2).toFixed(2) +' total)'
		);
		$( api.column(5).footer()).html(
			''+eval(pageTotal3).toFixed(2) +' ( '+ eval(total3).toFixed(2) +' total)'
		);
		$( api.column(6).footer()).html(
			''+eval(pageTotal4).toFixed(2) +' ( '+ eval(total4).toFixed(2) +' total)'
		);
		$( api.column(7).footer()).html(
			''+eval(pageTotal5).toFixed(2) +' ( '+ eval(total5).toFixed(2) +' total)'
		);
		}
		
	} );

	
	
})
</script>