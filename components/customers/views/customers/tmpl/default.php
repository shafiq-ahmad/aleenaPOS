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

if(isset($this->rows) && $this->rows){
	//$id = $rows[0]['id'];
}
?>
<div class="com-head">
	<h3>Customers</h3>
</div>
<div class="form"><?php
	$list = array();
	$list['view']='customer';
	$list['task']='edit';
	$view = $this->getView('customer', 'customers', 'edit');
	echo $view->display($list);/**/
?></div>
<div class="table-responsive">
	<div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="sales" />
			<input type="hidden" name="view" value="items_report" />
			<div>
			<?php /* ?><div class="date-range">
				<label class="control-label" for="start_date">Start date:</label>
				<input name="start_date" id="start_date"class="inputbox input-sm date<?php if(!isset($_GET['start_date'])){ echo '-default';}?>" value="<?php if(isset($_GET['start_date'])){ echo $_GET['start_date'];}?>" tabindex="-1" />
				<label class="control-label" for="end_date">End date:</label>
				<input name="end_date" id="end_date" class="inputbox input-sm date<?php if(!isset($_GET['end_date'])){ echo '-default';}?>" value="<?php if(isset($_GET['end_date'])){ echo $_GET['end_date'];}?>" tabindex="-1" />
				<input type="submit" name="search_date" class="btn btn-success screen" value="Search" />
			</div><?php */ ?>
			<div class="filter hide">
				<label class="control-label" for="search_filter">Filter:</label><input id="search_filter" name="search_filter" class="inputbox form-control" value="" />
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
	<table id="data-table" class="table">
		<thead>
		<tr>
			<th>ID</th><th>Customer Name</th><th>Address</th><th>Phone</th><th>Town</th><th>Account</th><th>Actions</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
		?><tr <?php if($this->id==$row['id']){echo ' class="active"';} ?>><?php 
			echo '<td>' . $row['id'] . '</td>';
			echo '<td>' . $row['title'] . '</td>'; 
			echo '<td>' . $row['address'] . '</td>'; 
			echo '<td>' . $row['phone'] . '</td>'; 
			echo '<td>' . $row['town_title'] . '</td>'; 
			echo '<td class="account_value">' . $row['account_value'] . '</td>'; 
			$edit_link = "?com=customers&id={$row['id']}";
			$receipt_link = "?com=customers&view=receipt&task=edit&id={$row['id']}";
			//$delete_link = "?com=articles&view=article&task=delete&id={$row['article_code']}";
			echo '<td>'; 
			echo '<a href="' . $edit_link . '" title="Edit"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;| &nbsp;&nbsp;'; 
			echo '<a href="' . $receipt_link . '" title="Receipt">Receipt</a>'; 
			//echo '<a href="' . $delete_link . '" title="Delete">Delete</a>'; 
			echo '</td>'; 
		?></tr><?php
			}
		?></tbody>
		<tfoot>
			<tr>
				<th colspan="5" style="text-align:right">Total:</th>
				<th colspan="2"></th>
			</tr>
		</tfoot>
		<script>
		//cals_reportItemsTotal();
		</script>
	</table>
</div><?php 
?>