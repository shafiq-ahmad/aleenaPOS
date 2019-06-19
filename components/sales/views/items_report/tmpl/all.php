<?php
/**
Package: Point of sale
version: 1.0.0
URI: https://webapplics.com/apps/pos/1.0.0/docs
Author: Shafique Ahmad
Author URI: http://webapplics.com/
Description: 
copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

*/

defined('_MEXEC') or die ('Restricted Access');
//$data_articles = array_column($this->rows,'data_articles');
//print_r ($data_articles);exit;
$this->app->setTitle('Sale (Item log report)');
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
				<input type="date" name="start_date" id="start_date"class="inputbox input-sm" value="<?php if(isset($_GET['start_date'])){ echo strftime("%Y-%m-%d", strtotime($_GET['start_date']));}?>" tabindex="-1" />
				<label class="control-label" for="end_date">End date:</label>
				<input type="date" name="end_date" id="end_date" class="inputbox input-sm date<?php if(!isset($_GET['end_date'])){ echo '-default';}?>" value="<?php if(isset($_GET['end_date'])){ echo strftime("%Y-%m-%d", strtotime($_GET['end_date']));}?>" tabindex="-1" />
				<button type="submit" name="search_date" class="btn btn-success screen btn-flat screen"><i class="fa fa-search"></i></button>
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
	<table id="data-table" class="table salesReportItems">
		<thead>
			<tr>
				<th>Sr#</th><th>Bill#</th><th>Date</th><th>Items</th><th>Title</th><th>Cost Price</th><th>Sales Price</th><th>Discount</th>
				<th>Qty</th><th>Total</th><th>Saving</th><th>%</th>
			</tr>
		</thead>
		<tbody id="tblContentBody"><script>
	var json_data = <?php
		echo json_encode($this->rows);
	?>;
		//console.log(json_data);
		//var subTotal=0;
		//var subTotalMargin=0;
		var vRow = 1;
		$.each(json_data, function(i, v) {
			//console.log(v);
			if(v.data_articles){
			var json_arts = JSON.parse(v.data_articles);
			$.each(json_arts, function(j, vt) {
			if(vt){
			//console.log(vt);
				document.write('<tr>');
				document.write('<td class="article_code">'+vRow+ '</td>');
				document.write('<td class="article_code">'+v.id+ '</td>');
				document.write('<td class="article_code">'+v.time_stamp+ '</td>');
				document.write('<td class="article_code">'+vt.article_code+ '</td>');
				document.write('<td class="title">'+vt.title+'</td>');
				document.write('<td class="cost_price">'+vt.cost_price+'</td>');
				document.write('<td class="salePrice">'+eval(vt.tp_price).toFixed(2)+'</td>');
				document.write('<td class="discount">'+vt.discount+'</td>');
				document.write('<td class="saleQty">'+eval(vt.qty).toFixed(2)+'</td>');
				var total_cost = eval(vt.qty) * eval(vt.cost_price);
				var total = eval(vt.qty) * (eval(vt.tp_price)-eval(vt.discount));
				var saving = total-total_cost;
				document.write('<td class="saleQty">'+(total).toFixed(2)+'</td>');
				document.write('<td class="total">'+eval(saving).toFixed(2)+'</td>');
				document.write('<td class="total">'+eval(saving/total *100).toFixed(2)+' %</td>');
				//document.write('<td class="margin">'+eval(vt.margin).toFixed(2)+'</td>');
				//subTotalMargin += eval(v.margin);
				document.write('</tr>');/**/
				vRow++;
			}
			});
			}
		});
		</script></tbody>
		<tfoot>
			<tr>
				<th colspan="6" style="text-align:right">Total:</th>
				<th colspan="1"></th>
				<th colspan="1"></th>
				<th colspan="1"></th>
				<th colspan="1"></th>
				<th colspan="1"></th>
			</tr>
		</tfoot>
	</table>
</div>
<script>
$(document).ready(function(){
	
	$('#data-table').DataTable({
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
		total = api
		.column(6)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);

		total1 = api
		.column(7)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);

		total2 = api
		.column(8)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);

		total3 = api
		.column(9)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);

		// Total over this page
		pageTotal = api
		.column(6, { page: 'current'} )
		.data()
		.reduce(function (a, b){
			return intVal(a) + intVal(b);
		},0);

		pageTotal1 = api
		.column(7, { page: 'current'} )
		.data()
		.reduce(function (a, b){
			return intVal(a) + intVal(b);
		},0);

		pageTotal2 = api
		.column(8, { page: 'current'} )
		.data()
		.reduce(function (a, b){
			return intVal(a) + intVal(b);
		},0);

		pageTotal3 = api
		.column(9, { page: 'current'} )
		.data()
		.reduce(function (a, b){
			return intVal(a) + intVal(b);
		},0);

		// Update footer
		$( api.column(6).footer()).html(
			''+pageTotal +' ( '+ total +' total)'
		);
		$( api.column(7).footer()).html(
			''+pageTotal1 +' ( '+ total1 +' total)'
		);
		$( api.column(8).footer()).html(
			''+pageTotal2 +' ( '+ total2 +' total)'
		);
		$( api.column(9).footer()).html(
			''+pageTotal3 +' ( '+ total3 +' total)'
		);
		
		}
	} );

	
	
})
</script>