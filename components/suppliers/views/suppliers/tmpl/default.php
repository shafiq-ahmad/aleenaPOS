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
	$list = array();
	$list['view']='supplier';
	$list['task']='edit';
	$view = $this->getView('supplier', 'suppliers', 'edit');
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
			<div class="filter">
				<label class="control-label" for="search_filter">Filter:</label><input id="search_filter" name="search_filter" class="inputbox form-control" value="" />
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
	<table id="data-table" class="table">
		<thead>
		<tr>
			<th>ID</th><th>Supplier Name</th><th>Address</th><th>Contact Person</th><th>Type of Items</th><th>Account</th><th>Actions</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
		?><tr <?php if($this->id==$row['id']){echo ' class="active"';} ?>><?php 
			echo '<td>' . $row['id'] . '</td>';
			echo '<td>' . $row['title'] . '</td>'; 
			echo '<td>' . $row['address'] . '</td>'; 
			echo '<td>' . $row['contact_person'] . '</td>'; 
			echo '<td>' . $row['data_articles'] . '</td>'; 
			echo '<td>' . $row['account_value'] . '</td>'; 
			$edit_link = "?com=suppliers&id={$row['id']}";
			$item_link = "?com=suppliers&view=supplier&task=articles&id={$row['id']}";
			$pay_link = "?com=suppliers&view=payment&id={$row['id']}";
			$le_link = "?com=suppliers&view=ledger&id={$row['id']}";
			//$delete_link = "?com=articles&view=article&task=delete&id={$row['article_code']}";
			echo '<td>'; 
			echo '<a href="' . $edit_link . '" title="Edit"><i class="fa fa-edit"></i></a>' . '&nbsp;&nbsp;|&nbsp;&nbsp;'; 
			echo '<a href="' . $item_link . '" title="Items"><i class="fa fa-barcode"></i></a>' . '&nbsp;&nbsp;|&nbsp;&nbsp;'; 
			echo '<a href="' . $pay_link . '" title="Payment"><i class="fa fa-dollar"></i></a>' . '&nbsp;&nbsp;|&nbsp;&nbsp;'; 
			echo '<a href="' . $le_link . '" title="Ledger"><i class="fa fa-circle-o"></i></a>'; 
			//echo '<a href="' . $delete_link . '" title="Delete">Delete</a>'; 
			echo '</td>'; 
		?></tr><?php
			}
		?></tbody>
	</table>
</div><?php 
?>