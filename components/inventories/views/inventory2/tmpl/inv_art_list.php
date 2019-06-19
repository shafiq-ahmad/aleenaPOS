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
$id=0;
$filter_text = "";
//print_r($_POST);
//echo "<br/>get<br/>";
//print_r($_GET);	exit;

if(isset($_GET['id']) && $_GET['id']){
	$id = $_GET['id'];
}
if(isset($_POST['inv_id']) && $_POST['inv_id']){
	$inv_id = $_POST['inv_id'];
}
if(isset($_POST['id']) && $_POST['id']){
	$inv_id = $_POST['id'];
}


$pur_arts = getInventoryArticles($inv_id);

?>
	<table  class="table table-bordered table-hover table-condenseds">
		<thead>
		<tr>
			<th>Item Code</th><th>Title</th><th>Ref code</th><th>Packing</th><th>Qty</th><th>Sch.</th>
			<th>Cost</th><th>Sale</th><th>Total Cost</th><th>Actions</th>
		</tr>
</thead><tbody id="pur_articles"><?php
			$x=1;exit;
			foreach ($pur_arts as $pa){
		?><tr <?php if($id==$pa['article_code']){echo ' class="active"';} ?>><?php 
			echo '<td tabindex="' . $x . '">' . $pa['article_code'] . '</td>'; 
			echo '<td>' . $pa['art_title'] . '</td>'; 
			echo '<td>' . $pa['ref_code'] . '</td>'; 
			echo '<td>' . $pa['packing'] . '</td>';
			echo '<td>' . $pa['qty_scheme'] . '</td>'; 
			echo '<td>' . $pa['scheme'] . '</td>'; 
			echo '<td>' . $pa['cost_price'] . '</td>'; 
			echo '<td>' . $pa['sale_price'] . '</td>'; 
			echo '<td>' . $pa['cost_price']*($pa['qty_scheme']) . '</td>';
			$art_qty = $pa['qty_scheme']+$pa['scheme'];
			$js = "remInvItem({$pa['inv_id']},{$pa['article_code']}, {$art_qty});return false;";
			echo '<td>';
			echo '<a onclick="' . $js . '" href="#" title="Delete" tabindex="-1">X</a>'; 
			//echo '<a href="' . $delete_link . '" title="Delete">Delete</a>'; 
			echo '</td>';
			$x +=1;	
		?></tr><?php
			}
		?></tbody></table>