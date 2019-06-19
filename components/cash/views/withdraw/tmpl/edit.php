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


//if($this->id){
//print_r($_POST); echo $id;exit;
//if($_POST && $id!==0 && $task=="edit"){

$row = $this->row;

//print_r($row);exit;
$id='';
if($this->id){
	$id = '&id=' . $this->id;
}

?><div class="com-head">
</div><div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=customers&view=customer&task=edit<?php echo $id;?>">
		<fieldset class="form">
		<div class="form grid">
			<input type="hidden" name="id" value="<?php if($row){echo $row['id'];}?>" />
			<div class="row well-sm">
				<div class="col-sm-2"><label class="control-label" for="title">Title:</label></div><div class="col-sm-5"><input name="title" class="inputbox form-control" value="<?php if($row){echo $row['title'];}?>" required /></div>
			</div>
			<div class="row well-sm"><div class="col-sm-2"><label class="control-label" for="address">Address:</label></div><div class="col-sm-5"><input name="address" class="inputbox form-control" value="<?php if($row){echo $row['address'];}?>" /></div>
				<div class="col-sm-1 hide"><label class="control-label" for="town">Town:</label> </div><div class="col-sm-3 hide"><?php 
			
				echo '<SELECT name="town_id" id="town_id" class="town_id form-control dropdown-header">';
				echo '<OPTION value="">Please select a value</OPTION>';
				$selected = '';
				foreach ($this->towns as $t){
					if($row['town'] == $t['id']){$selected = 'selected="selected"';}
					echo '<OPTION value="' . $t['id'] . '" ' . $selected . '>' . $t['title'] . '</OPTION>';
				}/**/
				echo '</SELECT>';
				?></div>
			</div>
				<div class="row well-sm"><div class="col-sm-2"><label class="control-label" for="lng">Lng:</label></div><div class="col-sm-2"><input type="number" name="lng" class="inputbox form-control" value="<?php if($row){echo $row['lng'];}?>" /></div>
					<div class="col-sm-2"><label class="control-label" for="lat">Lat:</label></div><div class="col-sm-2"><input type="number" name="lat" class="inputbox form-control" value="<?php if($row){echo $row['lat'];}?>" /></div></div>
			<div class="row well-sm"><div class="col-sm-2"><label class="control-label" for="account_no">Account#:</label></div><div class="col-sm-2"><input name="account_no" class="inputbox form-control" value="<?php if($row){echo $row['account_no'];}?>" /></div>
				<div class="col-sm-1"><label class="control-label" for="cnic">CNIC#:</label></div><div class="col-sm-2"><input name="cnic" class="inputbox form-control" value="<?php if($row){echo $row['cnic'];}?>" /></div>
			</div>
			
			<div class="row well-sm"><div class="col-sm-2"><label class="control-label" for="phone">Phone#:</label></div>
<div class="col-sm-2"><input type="tel" placeholder="" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" name="phone" class="inputbox form-control" value="<?php if($row){echo $row['phone'];}?>" /></div>
				<div class="col-sm-1"><label class="control-label" for="fax_no">Fax#:</label></div><div class="col-sm-2"><input name="fax_no" class="inputbox form-control" value="<?php if($row){echo $row['fax_no'];}?>" /></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-2"><label class="control-label col-sm-2" for="mobile_no">Mobile#:</label> </div><div class="col-sm-2"><input name="mobile_no" class="inputbox form-control" value="<?php if($row){echo $row['mobile_no'];}?>" /></div>
				<div class="col-sm-1"><label class="control-label" for="e_mail">E-mail:</label></div><div class="col-sm-5"><input type="email" name="e_mail" class="inputbox form-control" value="<?php if($row){echo $row['e_mail'];}?>" /></div>
			</div>
			<div class="row well-sm"><div class="col-sm-2"><label class="control-label" for="account_value">Account:</label></div><div class="col-sm-2"><input type="number" id="account_value" class="inputbox form-control" value="<?php if($row){echo $row['account_value'];}?>" readonly /></div>
		</div>
		<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><input type="reset" id="Cancel" class="btn btn-default" value="Cancel" onclick="history.back()"  /></span>
				<?php /* ?><span><input class="btn btn-default" type="reset" name="reset" value="Reset" /></span><?php */ ?>
				<span><input class="btn btn-default" type="reset" name="reset" value="Reset" /></span>
				<span><input type="submit" name="save" id="save" class="btn btn-success" value="<?php if($this->id){echo 'Update';}else{echo 'Create';}?>" /></span>
			</li>
			<li></li>
		</ul>
		</div>
		</fieldset>
	</form>
</div><?php
//} 
?>