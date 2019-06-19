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
	<h3>{branch name} Articles</h3>
</div>
<div class="com-head">
	<div class="text-right"><a href="?com=articles&view=articles" title="New Article">All Articles</a></div>
</div><?php */ ?>
<div class="form"><?php
	/*$list = array();
	$list['view']='branch_article';
	$list['task']='edit';
	$view = $this->getView('branch_article', 'articles', 'edit');
	echo $view->display($list);*/
?></div>
<div class="table-responsive">
	<div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="sales" />
			<input type="hidden" name="view" value="items_report" />
			<div>
			<div class="filter hide">
				<label class="control-label" for="search_filter">Filter:</label><input id="search_filter" name="search_filter" class="inputbox form-control" value="" />
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
	<table id="data-table" class="table">
		<thead>
		<tr>
			<th>Item#</th><th>Title</th>
			<th>Cost Price</th><th>Sale Price</th><th>Stock</th><th>Alert Limit</th><th>Actions</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
			$tr_class='';
			if($row['qty']<0){
				//$qty = abs($row['qty']);
				$qty = 0;
				$tr_class='neg-qty';
			}else{
				$qty =$row['qty'];
			}
			if($this->id==$row['article_code']){
				if($tr_class){
					$tr_class .= ' active';
				}else{
					$tr_class = 'active';
				}
			}
		?><tr class="<?php echo $tr_class; ?>"><?php 
			//echo '<td><input type="checkbox" name="items[]" value="' . $row['article_code'] . '" /></td>'; 
			echo '<td>' . $row['article_code'] . '</td>'; 
			echo '<td>' . $row['title'] . '</td>'; 
			echo '<td>' . $row['cost_price'] . '</td>'; 
			echo '<td>' . $row['sale_price'] . '</td>';
			echo '<td>' . $qty . '</td>'; 
			echo '<td>' . ($row['min_stock']) . '</td>'; 
			echo '<td></td>';
		?></tr><?php
			}
		?></tbody>
		<tfoot>
			<tr>
				<th colspan="4" style="text-align:right"></th>
				<th colspan="2"></th>
			</tr>
		</tfoot>
	</table>
</div>
<script>
$(document).ready(function(){
	
	$('#data-table').DataTable();

	
	
})
</script>