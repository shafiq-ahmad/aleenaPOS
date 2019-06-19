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

//echo json_encode($row);exit;
?><div class="com-head">
	<?php /* ?><h3>Add/Edit Article</h3><?php */ ?>
</div><div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=articles&view=articles&id=<?php echo $this->id;?>">
		<fieldset class="form">
		<div class="form grid">
			<div class="row well-sm">
				<div class="col-sm-1 cell">Invoice #:</div><div class="col-sm-2 cell"><?php echo $this->inv['id'];?></div>
				<div class="col-sm-1 cell">Date:</div><div class="col-sm-2 cell"><?php echo $this->inv['return_date'];?></div>
				<div class="col-sm-1 cell">Customer: </div><div class="col-sm-2 cell"><?php echo $this->inv['cust_title'];?></div>
				<div class="col-sm-1 cell">Person: </div><div class="col-sm-2 cell"><?php echo $this->inv['person'];?></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-1 cell">Comments:</div><div class="col-sm-6 cell"><?php echo $this->inv['comments'];?></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-1 cell">Total: </div><div class="col-sm-1 cell"><?php echo $this->inv['sub_total'];?></div>
				<div class="col-sm-1 cell">Discount: </div><div class="col-sm-1 cell"><?php echo $this->inv['discount_amount'];?></div>
				<div class="col-sm-1 cell">Cash: </div><div class="col-sm-1 cell"><?php echo $this->inv['cash'];?></div>
				<div class="col-sm-1 cell">Credit: </div><div class="col-sm-1 cell"><?php echo $this->inv['credit'];?></div>
				<div class="col-sm-2 cell">Change: </div><div class="col-sm-1 cell"><?php echo $this->inv['change_return'];?></div>
			</div>
			<div class="row well-sm screen">
				<?php /* ?><div class="col-sm-1"><label class="control-label" for="bank_check">Bank Cheque:</label> </div><div class="col-sm-1"><input name="bank_check" class="inputbox form-control" value="<?php echo $this->inv['bank_check'];?>" /></div>
				<div class="col-sm-1"><label class="control-label" for="bank_card">Bank Card:</label> </div><div class="col-sm-1"><input name="bank_card" class="inputbox form-control" value="<?php echo $this->inv['bank_card'];?>" /></div>
				<?php */?><div class="col-sm-1 cell">User: </div><div class="col-sm-3 cell"><?php echo $this->inv['full_name'];?></div>
			</div>
		</div>
		</fieldset>
	</form>
</div>
	<table  class="table table-bordered table-hover table-condenseds">
		<thead>
		<tr>
			<th class="screen">Item Code</th><th>Title</th><th>Qty/Sch.</th><th>Price</th><th>Total Cost</th>
		</tr>
		</thead>
		<tbody id="pur_articles"><?php
			$sub_total=0;
			foreach ($this->rows as $ra){
			//$total = $ra['cost_price']*($ra['qty']+$ra['scheme']);
		?><tr <?php if($this->id==$ra['article_code']){echo ' class="active"';} ?>><?php 
			echo '<td class="screen">' . $ra['article_code'] . '</td>'; 
			echo '<td>' . $ra['art_title'] . '</td>'; 
			//echo '<td>' . $ra['packing'] . '</td>';
			$qty=0;
			if(is_numeric($ra['qty'])){
				$qty = $ra['qty'];
			}
			$scheme=0;
			if(is_numeric($ra['scheme'])){
				$scheme = $ra['scheme'];
			}
			$total_qty = $qty + $scheme;
			$total_amount = $total_qty*$ra['price'];
			$sub_total=$sub_total+$total_amount;
			echo '<td>' . $total_qty . '</td>';
			echo '<td>' . $ra['price'] . '</td>'; 
			echo '<td>' . $total_amount . '</td>'; 
			//$stock_link = "?com=purchases&view=purchase&task=delete&id={$ra['article_code']}";
			//echo '<td>'; 
			//echo '<a href="' . $stock_link . '" title="Delete">Delete</a>'; 
			//echo '</td>'; 
		?></tr><?php
			}
		?></tbody>
		<tfoot>
			<tr>
				<th colspan="4">Total:</th><th><?php echo $sub_total; ?></th>
			</tr>
		</tfoot>
	</table>