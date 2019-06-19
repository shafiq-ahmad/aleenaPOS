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
//echo getNewID();exit;
global $com;
$id=0;
if(isset($_GET['id'])){
	$id = $_GET['id'];
}
$pur_arts = getInventoryArticles($id);

//print_r ($pur_arts);exit;
?><?php /* ?><div class="com-head">
	<h3>{branch name} Articles</h3>
</div><?php */ ?>
<div class="form"><?php
	//$form_model = "components/{$com}/models/purchase.php";
	$form_file = "components/{$com}/views/inventory/edit.php";
	//require_once $form_model;
	require_once $form_file;
?></div>
<div class="table-responsive">
	<table id="inv_form" class="table table-bordered table-hover table-condenseds">
		<thead>
		<tr>
			<!--<th>Inv#</th>--><th>Item#</th><th>Title</th><th>Category</th><th>Location</th><!--<th>Current stock</th><th>Actual Stock</th>-->
			<th>Inv. Qty</th><!--<th>Time</th><th>User</th><th>Diff.</th>--><th>Actions</th>
		</tr>
</thead>
		<tbody id="inv_form-body"><?php
		if($pur_arts){
			$x=1;
			foreach ($pur_arts as $pa){
				$inv_id=0;
				if(isset($row)){ $inv_id = $row['id'];}
		?><tr <?php if($id==$pa['article_code']){echo ' class="active"';} ?>><?php 
			//echo '<td id="id-' . $x . '">' .  $inv_id. '</td>'; 
			echo '<td id="article_code-' . $x . '">' . $pa['article_code'] . '</td>'; 
			echo '<td>' . $pa['art_title'] . '</td>'; 
			//echo '<td>' . $pa['current_stock'] . '</td>'; 
			//echo '<td>' . $pa['actual_stock'] . '</td>'; 
			echo '<td id="inv_qty-' . $x . '"><input class="" type="input" value="' . $pa['inv_qty'] . '" /></td>'; 
			echo '<td>' . $pa['inv_time'] . '</td>'; 
			echo '<td>' . $pa['full_name'] . '</td>'; 
			//$diff = floatval($pa['inv_qty'])-floatval($pa['actual_stock']);
			//echo '<td>' . $diff . '</td>'; 
			//$art_qty = $pa['qty_scheme']+$pa['scheme'];
			$js_rem = "remInvItem({$inv_id},{$pa['article_code']});return false;";
			$js = "saveInvItem({$inv_id},{$pa['article_code']}, " . "'#inv_qty-" . $x . "');$(this).hide();return false;";
			echo '<td>'; 
			echo '<a onclick="' . $js_rem . '" href="#" title="Delete" tabindex="-1">X</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;'; 
			echo '<a onclick="' . $js . '" href="#" title="Delete" tabindex="-1">Save</a>'; 
			//echo '<a href="' . $delete_link . '" title="Delete">Delete</a>'; 
			echo '</td>'; 
		?></tr><?php
		$x++;
			}
		}else{
			echo "<tr><td><p>No item(s)</p></td></tr>";
		}
		?></tbody>
	</table>
</div><?php
?>