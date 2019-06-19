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

//print_r($this->pur_arts);
if(isset($this->pur_arts) && $this->pur_arts){
?><table  class="table table-bordered table-hover table-condenseds">
<thead><tr><th>#</th><th>Item#</th><th>Title</th><th>Category</th><th>Location</th><th>System Qty</th><th>Physical Qty</th><th>Actions</th></tr></thead>
	<tbody id="tblContentBody"><?php
		$x=1;
		foreach ($this->pur_arts as $pa){
			$inv_id=0;
			if(isset($this->row)){ $inv_id = $this->row['id'];}
			if(!$inv_id){ $inv_id = $this->inv_id;}
			$inv_qty = 0;
			if($pa['inv_qty']){$inv_qty = $pa['inv_qty'];}
			//$actual_stock = 0;
			//if($pa['actual_stock']){$actual_stock = $pa['actual_stock'];}
			//$difference=$inv_qty-$actual_stock;
		/*
			if $difference < 0 its mean stock need to be reduce
			if $difference > 0 its mean increase stock by difference
		*/
		//echo  $difference . '<br>';
		//if($difference !== 0){
		$row_id = 'row-' . $x;
	?><tr id="<?php echo $row_id; ?>"><?php 
		echo '<td>' .  $x. '</td>'; 
		$js = "saveInvItem({$inv_id},'{$pa['article_code']}', " . "'#{$row_id} .inv_qty');$('#" . $row_id . "').hide();return false;";
		echo '<td class="article_code">' . $pa['article_code'] . '</td>'; 
		echo '<td>' . $pa['art_title'] . '</td>'; 
		echo '<td class="cat">' . $pa['pcat_name'] . ' - ' . $pa['cat_name'] . '</td>'; 
		echo '<td class="loc">' . $pa['loc_section'] . ' - ' . $pa['loc_rack'] . ' - ' . $pa['loc'] . '</td>'; 
		echo '<td>' . $pa['current_stock'] . '</td>';
		//echo '<td class="inv_qty"><input onclick="console.log($(this).parents().html());return false;" class="" type="input" value="' . $pa['inv_qty'] . '" /></td>';
		//echo '<td class="inv_qty"><input onclick="console.log($(this).closest(\'tr\').attr(\'id\'));return false;" class="" type="input" value="' . $pa['inv_qty'] . '" /></td>';
		echo '<td class="inv_qty"><input type="input" value="' . $pa['inv_qty'] . '" /></td>';
	//	echo '<td>' . $difference . '</td>';
		echo '<td>'; 
		echo '<a onclick="' . $js . '" href="#" title="Delete" tabindex="-1">Save</a>'; 
		echo '</td>'; 
		$x++;
	?></tr><?php
		//}
}
	?></tbody>
</table><?php 
}
