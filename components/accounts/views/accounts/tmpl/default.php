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

//print_r($this);exit;
//print_r(getArticleBrands());exit;
?><?php /* ?><div class="com-head">
	<h3>View Articles</h3>
</div><?php */ ?>
<div class="form"><?php
	$list = array();
	$list['view']='account';
	$list['task']='edit';
	$view = $this->getView('account', 'accounts', 'edit');
	//echo $view->display($list);
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
	<table class="table table-bordered table-hover table-condenseds">
		<thead>
		<tr>
			<th>Account#</th><th>Title</th><th>Category</th><th>Value</th><th>Max value</th><th>Min value</th><th>Actions</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
		?><tr <?php if($this->id==$row['id']){echo ' class="active"';} ?>><?php 
			echo '<td>' . $row['id'] . '</td>'; 
			echo '<td>' . $row['title'] . '</td>'; 
			echo '<td>' . $row['act_title'] . '</td>'; //echo '<td>' . $row['brand'] . '</td>'; 
			echo '<td>' . $row['account_value'] . '</td>'; 
			echo '<td>' . $row['max_value'] . '</td>'; 
			echo '<td>' . $row['min_value'] . '</td>'; 
			$edit_link = "?com=accounts&view=accounts&id={$row['id']}";
			//$stock_link = "?com=articles&view=branch_articles&id={$row['id']}";
			echo '<td>'; 
			echo '<a href="' . $edit_link . '" title="Edit" tabindex="-1">Edit</a>&nbsp; / &nbsp;'; 
			//echo '<a href="' . $stock_link . '" title="Stock" tabindex="-1">Stock</a>';
			echo '</td>'; 
		?></tr><?php
			}
		?></tbody>
	</table>
</div><?php 
?>