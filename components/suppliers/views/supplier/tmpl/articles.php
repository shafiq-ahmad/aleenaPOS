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

//echo $id;exit;
if(isset($this->id)){
//print_r($_POST); echo $id;exit;
//if($_POST && $id!==0 && $task=="edit"){

$row = $this->row;

//var_dump($this->items);exit;

?><div class="com-head">
	<?php /* ?><h3>Add/Edit Article</h3><?php 
	
	*/ ?>
</div><div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=suppliers&view=suppliers&id=<?php echo $this->id;?>">
		<fieldset class="form">
		<div class="form grid">
			<input type="hidden" name="id" value="<?php if($row){echo $row['id'];}?>" />
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="title">Title:</label></div><div class="col-sm-5"><input name="title" class="inputbox form-control required" value="<?php if($row){echo $row['title'];}?>" /></div>
				<div class="col-sm-1"><label class="control-label" for="contact_person">C. Person:</label></div><div class="col-sm-2"><input name="contact_person" class="inputbox form-control" value="<?php if($row){echo $row['contact_person'];}?>" /></div>
			</div>
			<div class="row well-sm">
			<div class="col-sm-1"><label class="control-label" for="address">Address:</label></div><div class="col-sm-5"><input name="address" class="inputbox form-control" value="<?php if($row){echo $row['address'];}?>" /></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="phone">Phone#:</label></div><div class="col-sm-2"><input name="phone" class="inputbox form-control" value="<?php if($row){echo $row['phone'];}?>" /></div>
				<div class="col-sm-1"><label class="control-label" for="mobile_no">Mobile#:</label> </div><div class="col-sm-2"><input name="mobile_no" class="inputbox form-control" value="<?php if($row){echo $row['mobile_no'];}?>" /></div>
				<div class="col-sm-1"><label class="control-label" for="e_mail">E-mail:</label></div><div class="col-sm-5"><input name="e_mail" class="inputbox form-control" value="<?php if($row){echo $row['e_mail'];}?>" tabindex="-1" /></div>
			</div>
			
		</div>
		</fieldset>
	</form>
</div><?php
} 
?>
<table class="table table-bordered table-hover table-condenseds">
	<thead>
	<tr>
		<th>Item Code</th><th>Title</th><th>Category</th><th>Price</th>
	</tr>
	</thead>
	<tbody id="tblContentBody"><?php
		if($this->items){
		foreach ($this->items as $item){
	?><tr><?php 
		echo '<td>' . $item['article_code'] . '</td>';
		echo '<td>' . $item['title'] . '</td>'; 
		echo '<td>' . $item['category'] . '</td>'; 
		//echo '<td>' . $item[''] . '</td>'; 	//number of times purchased
		echo '<td>' . $item['unit_price'] . '</td>'; 
	?></tr><?php
		}
		}
	?></tbody>
</table>