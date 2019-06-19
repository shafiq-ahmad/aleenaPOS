<?php
defined('_MEXEC') or die ('Restricted Access');
//$data_articles = array_column($this->rows,'data_articles');
//print_r ($data_articles);exit;


//var_dump($this->rows);exit;
?><div class="com-head">
	<h3>Itemwise report</h3>
</div>

<div class="form"><?php
?></div>
<div class="table-responsive"><div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="sales" />
			<input type="hidden" name="view" value="items_report" />
			<input type="hidden" name="task" value="<?php echo $this->task;?>" />
			<div>
			<div class="date-range">
				<label class="control-label" for="start_date">Start date:</label>
				<input type="date" name="start_date" id="start_date"class="inputbox input-sm date<?php if(!isset($_GET['start_date'])){ echo '-default';}?>" value="<?php if(isset($_GET['start_date'])){ echo strftime("%Y-%m-%d", strtotime($_GET['start_date']));}?>" tabindex="-1" />
				<label class="control-label" for="end_date">End date:</label>
				<input type="date" name="end_date" id="end_date" class="inputbox input-sm date<?php if(!isset($_GET['end_date'])){ echo '-default';}?>" value="<?php if(isset($_GET['end_date'])){ echo strftime("%Y-%m-%d", strtotime($_GET['end_date']));}?>" tabindex="-1" />
				<button type="submit" name="search_date" class="btn btn-success screen btn-flat screen"><i class="fa fa-search"></i></button>
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
	<link rel="stylesheet" type="text/css" href="templates/default/bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" media="all" />
	<table id="data-table" class="table salesReportItems">
		<thead>
			<tr>
				<th>Sr#</th><th>bill#</th><th>Date/Time</th><th>Customer</th><th>Sub Total</th><th>Cash</th><th>Discount</th>
			</tr>
		</thead>
		<tbody id="tblContentBody" class="report-list"></tbody>
		<tfoot>
			<tr>
				<th colspan="4" style="text-align:right">Total:</th>
				<th colspan="1"></th>
				<th colspan="1"></th>
				<th colspan="1"></th>
			</tr>
		</tfoot>
	</table>
</div><script>
	var json_data = <?php
		echo json_encode($this->rows);
	?>;
		var vRow = 1;
		$.each(json_data, function(i, v) {
			var html = '<tr>';
			html = html + '<td class="sr_no">'+vRow+ '</td>';
			html = html + '<td class="sr_no">'+v.id+ '</td>';
			html = html + '<td class="time_stamp">'+v.time_stamp+ '</td>';
			html = html + '<td class="customer_id">'+v.customer_id+'</td>';
			html = html + '<td class="sub_total">'+eval(v.sub_total).toFixed(2)+'</td>';
			html = html + '<td class="cash">'+eval(v.cash).toFixed(2)+'</td>';
			html = html + '<td class="discount_amount">'+eval(v.discount_amount).toFixed(2)+'</td>';
			html = html + '</tr">';
			vRow++;
			$("#tblContentBody").append(html);
		});
		</script>
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
		.column(4)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);

		total2 = api
		.column(6)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);

		// Update footer
		$( api.column(4).footer()).html(eval(total1).toFixed(2));
		$( api.column(6).footer()).html(eval(total2).toFixed(2));
		
		},paging:false
	} );

	
	
})
</script>