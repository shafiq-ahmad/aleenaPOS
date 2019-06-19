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

?><?php /* ?><div class="com-head">
	<h3>View Articles</h3>
</div><?php */ ?>
<div class="form"><?php
	/*$list = array();
	$list['view']='supplier';
	$list['task']='edit';
	$view = $this->getView('supplier', 'suppliers', 'edit');
	echo $view->display($list);*/
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
			
			<div class="filter">
				<label class="control-label" for="search_filter">Filter:</label><input id="search_filter" name="search_filter" class="inputbox form-control" value="" />
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
	<div class="row">
		<div class="col-md-1"><label>Supplier: </label></div><div class="col-md-2"><?php echo $this->row['title'];?></div>
		<div class="col-md-1"><label>Address: </label></div><div class="col-md-6"><?php echo $this->row['address'];?></div>
	</div>
	<div class="row">
		<div class="col-md-1"><label>Phone: </label></div><div class="col-md-2"><?php echo $this->row['phone'];?></div>
		<div class="col-md-1"><label>Mobile: </label></div><div class="col-md-2"><?php echo $this->row['mobile_no'];?></div>
		<div class="col-md-1"><label>Email: </label></div><div class="col-md-2"><?php echo $this->row['e_mail'];?></div><div class="line-1px"></div>
	</div>
	<div class="row">
		<div class="col-md-1"><label>Account: </label></div><div class="col-md-2"><?php echo $this->row['account_value'];?></div>
	</div>
	<table id="data-table" class="table">
		<thead>
		<tr>
			<th>#</th><th>Action</th><th>Date</th><th>Purchase amount</th><th>Credit</th><th>Cash</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			$x=1;
			foreach ($this->rows as $row){
		?><tr><?php 
			echo '<td>' . $x . '</td>';
			echo '<td>' . $row['action'] . ': ' . $row['ref_no'] . '</td>'; 
			echo '<td>' . $row['dt'] . '</td>'; 
			echo '<td>' . $row['amount'] . '</td>';
			echo '<td>' . $row['credit'] . '</td>'; 
			echo '<td>' . $row['cash'] . '</td>'; 
		?></tr><?php
			$x++;
			}
		?></tbody>
	</table>
</div><?php 
?>