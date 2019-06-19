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

if(isset($_GET['create_record']) && $row ){
	createRecord();
}

if($_POST){
	$form_type="";
	if(isset($_POST['form_type'])){
		$form_type=$_POST['form_type'];
	}
	//print_r($_POST);exit;
	if($id!==0 && $form_type == 'inventory_main'){
		updateInventory($_POST);
	}
	if(!$id && $form_type == 'inventory_main'){
		$id = createInventory($_POST);
		//echo $id;exit;
		redirect('?com=inventories&view=inventory&id='.$id);
	}
}
$sup_list = getBranchSuppliers();
$mops = getMOPS();
$bstores = getBranchStores();
if($id!==0){
	$row = getInventoryByID($id);
}

//echo $id . '<br/>';
//exit;
?><div class="com-head">
<script type="text/javascript">

</script>
</div>

<!--<p><span class="suggest"></span></p>-->
<div><form class="form-inline" method="post" name="frm" action="?com=inventories&view=inventory<?php if($id){echo '&id='.$id;} ?>">
		<fieldset class="form">
		<legend>Inventory</legend>
		<div class="form grid">
			<input type="hidden" id="form_type" name="form_type" value="inventory_main" />
			<input type="hidden" id="frm_main_state" name="frm_main_state" value="<?php
				if(isset($row)){
					echo 'edit';
				}else{
					echo 'unset';
				}
			?>" />
			<input type="hidden" name="status" value="<?php if(isset($row)){ echo $row['inv_status'];}?>" />
			<input type="hidden" name="id" value="<?php if($id){echo $row['id'];}else{echo '0';} ?>"  />
			<div class="row well-sm">
				<div class="col-sm-1 grid-label"><label class="control-label" for="id">ID:</label></div><div class="col-sm-2"><input name="inventory_" class="inputbox form-control input-sm number" value="<?php if($id){echo $row['id'];}?>" disabled /></div>
				<div class="col-sm-1 grid-label"><label class="control-label" for="inv_date">Inventory date:</label></div><div class="col-sm-2"><input name="inv_date" class="inputbox form-control input-sm date<?php if(!isset($row)){ echo '-default';}?>" value="<?php if(isset($row)){ echo $row['inv_date'];}?>" tabindex="-1" readonly /></div>
				<div class="col-sm-1 grid-label"><label class="control-label" for="inv_status">Status:</label></div><div class="col-sm-2"><input name="inv_status" class="inputbox form-control input-sm" value="<?php if(isset($row)){ echo $row['inv_status'];}?>" tabindex="-1" readonly /></div>
			</div>
			<hr/>
			<div class="row well-sm">
				<div class="col-sm-1 grid-label"><label class="control-label" for="remarks">Remarks:</label></div><div class="col-sm-8"><input name="remarks" class="inputbox form-control input-sm" value="<?php if(isset($row)){ echo $row['remarks'];}?>" tabindex="-1" /></div>
			</div>
			</div><div class="clear"></div>
			<fieldset>
			<div class="btn-group">
				<div class="row well-sm">
					<span><input type="reset" id="Cancel" class="btn btn-default" value="Cancel" onclick="history.back()" tabindex="-1" /></span>
					<span><input class="btn btn-default" type="reset" name="reset" id="reset-pa" value="Reset" tabindex="-1" /></span>
					<span><button id="save" name="save" id="save" class="btn btn-success" tabindex="-1"><?php 
						$btn_title="Create New";
						if($id){$btn_title="Update";}
						echo $btn_title;
					?></button></span>
				</div>
			</div>
			</fieldset>
		</fieldset></form>
		<div class="form grid" style="margin-top:20px;">
				<div class="row well-sm">
					<label class="control-label col-sm-1" for="search_filter">Search:</label><div class="col-sm-3"><input id="search_filter" name="search_filter" class="inputbox form-control input-sm" value="" style="display:inline-block;width:90% !important;" /></div>
				</div></div><?php
	
		
/*
	Items form section
*/
//		if ($sub){
	?><?php
//		}
?></div>