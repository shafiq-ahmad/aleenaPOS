<?php
defined('_MEXEC') or die ('Restricted Access');

/* if(isset($_GET['create_record']) && $this->row ){
	createRecord();
} */
?>
		
		<?php /* ?>
		//this code is use for single insertion to inventory item from form....
		<form class="form-inline screen" method="post" id="frm_pur_art" name="frm_pur_art" action="?com=Inventories&view=inventory<?php if($this->id){echo '&id='.$this->id;} ?>">
		<fieldset class="form">
			<legend>Inventory Items</legend>
			<div class="form grid">
				<input type="hidden" name="form_type" value="inventory_items" />
				<input type="hidden" name="inv_id" value="<?php if(isset($this->row)){ echo $this->row['id'];} ?>" />
				<div class="row well-sm">
					<label class="control-label col-sm-2" for="article_code">Item#:</label><div class="col-sm-3"><input id="article_code" name="article_code" class="inputbox form-control input-sm" value="" style="display:inline-block;width:90% !important;" />&nbsp;<a style="display:inline-block;" onclick="getArtDetails();return false;" class="phone" tabindex="-1">OK</a></div>
					<label class="control-label col-sm-1" for="ref_code">Ref #:</label><div class="col-sm-2"><input id="ref_code" name="ref_code" class="inputbox form-control input-sm" value="" readonly tabindex="-1" /></div>
					<label class="control-label col-sm-2" for="qty">In Hand:</label><div class="col-sm-2"><input id="qty" name="qty" class="inputbox form-control input-sm number" value="0" readonly tabindex="-1" /></div>
				</div>
				<div class="row well-sm">
					<label class="control-label col-sm-2" for="title">Title:</label><div class="col-sm-6"><input id="title" name="title" class="inputbox form-control input-sm" value="" readonly tabindex="-1" /></div>
					<label class="control-label col-sm-2" for="packing">Packing:</label><div class="col-sm-2"><input id="packing" name="packing" class="inputbox form-control input-sm number" value="" readonly tabindex="-1" /></div>
				</div><div class="row well-sm">
					<label class="control-label col-sm-2" for="loc">Location:</label><div class="col-sm-4">
					<input id="loc" name="loc" class="inputbox form-control input-sm number" value="" readonly tabindex="-1" /></div>
					<label class="control-label col-sm-2" for="sale_price">Sale Price:</label><div class="col-sm-2"><input id="sale_price" name="sale_price" class="inputbox form-control input-sm number" value="0" tabindex="-1" readonly /></div>
				</div>
				<hr/>
				<div class="row well-sm"> 
					<label class="control-label col-sm-2" for="inv_qty">Inv Qty:</label><div class="col-sm-2"><input id="inv_qty" name="inv_qty" class="inputbox form-control input-sm number" value="0" /></div>
				</div>
			</div><div class="clear"></div>
			<hr/>
			<div class="btn-group no-print">
				<div class="row well-sm">
					<span><input type="reset" id="Cancel" class="btn btn-default" value="Cancel" onclick="history.back()" tabindex="-1" /></span>
					<span><input class="btn btn-default" type="reset" name="reset" value="Reset" tabindex="-1" /></span>
					<span><a id="save_art" name="save_art" id="save_art" class="btn btn-success" tabindex="-1" onclick="saveArticle();return false;">Add</a></span>

				</div>
			</div>
		</fieldset>
	</form><?php */ ?>