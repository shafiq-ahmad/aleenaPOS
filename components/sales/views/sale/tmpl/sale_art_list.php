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

$pur_arts = $this->rows;

//print_r ($pur_arts);exit;

?><div class="row well-sm th">
	<div class="col-sm-2 cell">Item Code</div><div class="col-sm-4 cell">Title</div><div class="col-sm-1 cell">Qty</div><div class="col-sm-1 cell">Price</div>
	<div class="col-sm-1 cell">Dis.</div><div class="col-sm-1 cell">Total</div><div class="col-sm-1 cell">Status</div>
</div>
<div id="invArticles" class="grid"><?php
	$total = 0;
	$sub_total = 0;
	foreach ($pur_arts as $pa){
?><div class="row well-sm"><?php 
	$total = ($pa['price']-$pa['discount'])*$pa['qty'];
	$sub_total += $total;
	echo '<div class="col-sm-2 cell">' . $pa['article_code'] . '</div>'; 
	echo '<div class="col-sm-4 cell">' . $pa['art_title'] . '</div>'; 
	echo '<div class="col-sm-1 cell">' . $pa['qty'] . '</div>'; 
	echo '<div class="col-sm-1 cell">' . $pa['price'] . '</div>';
	echo '<div class="col-sm-1 cell">' . $pa['discount'] . '</div>';
	echo '<div class="col-sm-1 cell total_price">' . $total . '</div>';
	echo '<div class="col-sm-1 cell">' . $pa['status'] . '</div>'; 
?></div><?php
	}
?></div><input type="hidden" id="subTotal" value="<?php echo $sub_total; ?>" />
<?php  ?>