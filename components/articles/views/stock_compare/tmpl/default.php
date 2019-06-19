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

//print_r(getArticleBrands());exit;
?><?php /* ?><div class="com-head">
	<h3>View Articles</h3>
</div><?php */ ?>
<div class="table-responsive">
	<table class="table table-bordered table-hover table-condenseds">
		<thead>
		<tr>
			<th>Item#</th><th>system_stock</th><th>calc_stock</th><th>purchase_qty</th><th>ret_purchase</th><?php /* ?><th>Brand</th><?php */ ?><th>sale_qty</th><th>return_sale_qty</th><th>Actions</th>
		</tr>
		</thead>
		<tbody><?php
		if($this->id){
			foreach ($this->rows as $row){
		?><tr <?php if($this->id==$row['article_code']){echo ' class="active"';} ?>><?php 
			echo '<td>' . $row['article_code'] . '</td>'; 
			echo '<td>' . $row['system_stock'] . '</td>'; 
			$calc_stock = $row['purchase_qty_sum'] - $row['ret_purchase_sum']-$row['sale_qty_sum']+$row['return_sale_qty'];
			echo '<td>' . $calc_stock . '</td>'; 
			echo '<td>' . $row['purchase_qty_sum'] . '</td>'; 
			echo '<td>' . $row['ret_purchase_sum'] . '</td>'; //echo '<td>' . $row['brand'] . '</td>'; 
			echo '<td>' . $row['sale_qty_sum'] . '</td>'; 
			echo '<td>' . $row['return_sale_qty'] . '</td>'; 
			$adjust_link = "?com=articles&view=articles&id={$row['article_code']}";
			//$delete_link = "?com=articles&view=article&task=delete&id={$row['article_code']}";
			echo '<td>'; 
			echo '<a href="' . $adjust_link . '" title="Adjust" tabindex="-1">Adjust</a>&nbsp; / &nbsp;';
			//echo '<a href="' . $delete_link . '" title="Delete">Delete</a>'; 
			echo '</td>'; 
		?></tr><?php
			}
		}
		?></tbody>
	</table>
</div><?php 
?>