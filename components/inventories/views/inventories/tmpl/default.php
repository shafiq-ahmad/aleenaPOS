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

?><div class="com-head">
	<h3>Inventories</h3>
	<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><button type="reset" id="Cancel" class="btn btn-danger" value="Cancel" onclick="history.back();self.close();" tabindex="-1"><i class="glyphicon glyphicon-off"></i> Cancel</button></span>
				<span><a href="#" onclick="window.open('?com=inventories&view=inventory&tmpl=js_win','_blank', 'top=10, left= 100, scrollbars=no, titlebar=no, location=top, resizable=no, width=1124,height=560');return false;" class="btn btn-info" tabindex="-1"><i class="fa fa-file"></i> New</a></span>
			</li>
			<li></li>
		</ul>
	</div>
</div>


<div class="form"><?php
	//$form_model = "components/{$com}/models/purchase.php";
	//$form_file = "components/{$com}/views/purchase/edit.php";
	//require_once $form_model;
	//require_once $form_file;
	//print_r($rows);exit;
?></div>
<div class="table-responsive">
	<div id="search-date-range">
	</div>
	<link rel="stylesheet" type="text/css" href="templates/default/bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" media="all" />
	<table id="data-table" class="table table-bordered table-hover table-condenseds nav-able">
		<thead>
		<tr>
			<th>ID</th><th>Inv. Date</th><th>User Name</th><th>Item Code</th><th>Title</th><th>Old Stock</th><th>New Stock</th><th>Adjustment</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			$x=2;
			foreach ($this->rows as $row){
		?><tr <?php /*if($id==$row['purchase_id']){echo ' class="active"';}*/ ?>><?php 
			echo '<td tabindex="' . $x . '">' . $row['id'] . '</td>'; 
			echo '<td>' . $row['inv_date'] . '</td>'; 
			//echo '<td>' . $row['inv_status'] . '</td>'; 
			echo '<td>' . $row['full_name'] . '</td>';
			echo '<td>' . $row['article_code'] . '</td>'; 
			echo '<td>' . $row['title'] . '</td>'; 
			echo '<td>' . $row['actual_stock'] . '</td>'; 
			echo '<td>' . $row['closing_stock'] . '</td>'; 
			echo '<td>' . $row['adjusted_qty'] . '</td>'; 
		?></tr><?php
		$x++;
			}
		?></tbody>
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
		total3 = api
		.column(5)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);

		// Update footer
		$( api.column(5).footer()).html(
			eval(total3).toFixed(2)
		);
		},
		paging:false
		
	} );

	
	
})
</script>