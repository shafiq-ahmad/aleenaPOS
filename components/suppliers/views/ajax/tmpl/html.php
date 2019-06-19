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

global $com,$view,$task;
if($_POST && $task=="new"){
	createData($_POST);
}
//echo $id;exit;
if(isset($id)){
//print_r($_POST); echo $id;exit;
//if($_POST && $id!==0 && $task=="edit"){
if($_POST && $id!==0){
	setData($_POST);
}
$row = getDataByID($id);

//print_r($row);exit;

?><div class="com-head">
	<?php /* ?><h3>Add/Edit Article</h3><?php 
	
	*/ ?>
</div><div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=suppliers&view=suppliers&id=<?php echo $id;?>">
		<fieldset class="form">
		<div class="form grid">
			<input type="hidden" name="id" value="" />
			<div class="row well-sm">
				<div class="col-sm-2"><label class="control-label" for="id">ID#:</label></div><div class="col-sm-2"><input name="id" class="inputbox form-control" value="<?php echo $row['id'];?>" /></div>
				<div class="col-sm-1"><label class="control-label" for="ledger_code">Ledger#:</label> </div><div class="col-sm-2"><input name="ledger_code" class="inputbox form-control" value="<?php echo $row['ledger_code'];?>" /></div>
				<div class="col-sm-2"><label class="control-label" for="supplier_type">Sup. Type:</label></div><div class="col-sm-2"><input name="supplier_type" class="inputbox form-control" value="<?php echo $row['supplier_type'];?>" /></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-2"><label class="control-label" for="title">Title:</label></div><div class="col-sm-5"><input name="title" class="inputbox form-control" value="<?php echo $row['title'];?>" /></div>
				<div class="col-sm-2"><label class="control-label" for="contact_person">C. Person:</label></div><div class="col-sm-2"><input name="contact_person" class="inputbox form-control" value="<?php echo $row['contact_person'];?>" /></div>
			</div>
			<div class="row well-sm"><div class="col-sm-2"><label class="control-label" for="type_of_items">Type of Items:</label></div><div class="col-sm-8"><input name="type_of_items" class="inputbox form-control" value="<?php echo $row['type_of_items'];?>" /></div></div>
			<div class="row well-sm"><div class="col-sm-2"><label class="control-label" for="address">Address:</label></div><div class="col-sm-5"><input name="address" class="inputbox form-control" value="<?php echo $row['address'];?>" /></div>
				<div class="col-sm-1"><label class="control-label col-sm-1" for="town">Town:</label> </div><div class="col-sm-3"><?php 
			
				$cats = getCategoriesHTML($row['town_id']);
				echo '<SELECT name="town_id" id="town_id" class="town_id form-control dropdown-header">';
				echo '<OPTION value="">Please select a value</OPTION>';
				foreach ($cats as $cat){
					echo '<optgroup label="' . $cat['name'] . '">';
					foreach ($cat as $c){
						print_r($c);echo '<br/>';
					}
					echo '</optgroup>';
				}
				echo '</SELECT>';
				?></div>

			</div>
			
				<div class="row well-sm"><div class="col-sm-2"><label class="control-label" for="lng">Lng:</label></div><div class="col-sm-2"><input name="lng" class="inputbox form-control" value="<?php echo $row['lng'];?>" /></div>
					<div class="col-sm-2"><label class="control-label" for="lat">Lat:</label></div><div class="col-sm-2"><input name="lat" class="inputbox form-control" value="<?php echo $row['lat'];?>" /></div></div>
							
				
			<div class="row well-sm"><div class="col-sm-2"><label class="control-label" for="terms_conditions">Terms. Cond.:</label></div><div class="col-sm-9"><input name="terms_conditions" class="inputbox form-control" value="<?php echo $row['terms_conditions'];?>" /></div></div>
			<div class="row well-sm"><div class="col-sm-2"><label class="control-label" for="account_no">Account#:</label></div><div class="col-sm-2"><input name="account_no" class="inputbox form-control" value="<?php echo $row['account_no'];?>" /></div>
				<div class="col-sm-1"><label class="control-label" for="cnic">CNIC#:</label></div><div class="col-sm-2"><input name="cnic" class="inputbox form-control" value="<?php echo $row['cnic'];?>" /></div>
			<div class="col-sm-1"><label class="control-label" for="ntn">NTN#:</label></div><div class="col-sm-1"><input name="ntn" class="inputbox form-control" value="<?php echo $row['ntn'];?>" /></div>
				<div class="col-sm-1"><label class="control-label col-sm-2" for="gst_no">GST#:</label> </div><div class="col-sm-1"><input name="gst_no" class="inputbox form-control" value="<?php echo $row['gst_no'];?>" /></div>
			</div>
			
			<div class="row well-sm"><div class="col-sm-2"><label class="control-label" for="phone">Phone#:</label></div><div class="col-sm-2"><input name="phone" class="inputbox form-control" value="<?php echo $row['phone'];?>" /></div>
				<div class="col-sm-2"><label class="control-label col-sm-2" for="no_of_days">No. of days:</label> </div><div class="col-sm-2"><input name="no_of_days" class="inputbox form-control" value="<?php echo $row['no_of_days'];?>" /></div>
				<div class="col-sm-1"><label class="control-label" for="fax_no">Fax#:</label></div><div class="col-sm-2"><input name="fax_no" class="inputbox form-control" value="<?php echo $row['fax_no'];?>" /></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-2"><label class="control-label col-sm-2" for="mobile_no">Mobile#:</label> </div><div class="col-sm-2"><input name="mobile_no" class="inputbox form-control" value="<?php echo $row['mobile_no'];?>" /></div>
				<div class="col-sm-1"><label class="control-label" for="e_mail">E-mail:</label></div><div class="col-sm-5"><input name="e_mail" class="inputbox form-control" value="<?php echo $row['e_mail'];?>" /></div>
			</div>
			<div class="row well-sm"><div class="col-sm-2"><label class="control-label" for="opening_balance">Opening Bal.:</label></div><div class="col-sm-2"><input name="opening_balance" class="inputbox form-control" value="<?php echo $row['opening_balance'];?>" /></div>
				<div class="col-sm-2"><label class="control-label col-sm-2" for="closing_balance">Closing Bal.:</label> </div><div class="col-sm-2"><input name="closing_balance" class="inputbox form-control" value="<?php echo $row['closing_balance'];?>" /></div></div>
		
			
		</div>
		<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><input type="reset" id="Cancel" class="btn btn-default" value="Cancel" onclick="history.back()"  /></span>
				<?php /* ?><span><input class="btn btn-default" type="reset" name="reset" value="Reset" /></span><?php */ ?>
				<span><input class="btn btn-default" type="reset" name="reset" value="Reset" /></span>
				<span><input type="submit" name="save" id="save" class="btn btn-success" value="Save" /></span>
				<span><a href="?com=suppliers&view=supplier&task=new" title="New Article" class="btn btn-info">New</a></span>
			</li>
			<li></li>
		</ul>
		</div>
		</fieldset>
	</form>
</div><?php
} 
?>