<?php
defined('_MEXEC') or die ('Restricted Access');


?><div class="com-head">
<script type="text/javascript">

</script>
</div>

<div><form class="form-inline" method="post" name="frm" action="?com=inventories&view=inventory<?php if($this->id){echo '&id='.$this->id;} ?>">
		<fieldset class="form">
		<legend>Inventory</legend>
		<div class="form grid">
			<input type="hidden" id="form_type" name="form_type" value="inventory_main" />
			<input type="hidden" id="frm_main_state" name="frm_main_state" value="<?php
				if(isset($this->row)){
					echo 'edit';
				}else{
					echo 'unset';
				}
			?>" />
			<input type="hidden" name="status" value="<?php if(isset($this->row)){ echo $this->row['inv_status'];}?>" />
			<input type="hidden" name="id" value="<?php if($this->id){echo $this->row['id'];}else{echo '0';} ?>"  />
			<div class="row well-sm">
				<div class="col-sm-1 cell"><strong>ID: </strong></div><div class="col-sm-2 cell"><?php if($this->id){echo $this->row['id'];}?></div>
				<div class="col-sm-1 cell"><strong>Date: </strong></div><div class="col-sm-2 cell"><?php if(isset($this->row)){ echo $this->row['inv_date'];}?></div>
				<div class="col-sm-1 cell"><strong>Status: </strong></div><div class="col-sm-1 cell"><?php if(isset($this->row)){ echo $this->row['inv_status'];}?></div>
			</div>
			<hr/>
			<div class="row well-sm">
				<div class="col-sm-1 cell"><strong>Remarks: </strong></label></div><div class="col-sm-7 cell"><?php if(isset($this->row)){ echo $this->row['remarks'];}?></div>
			</div>
			</div><div class="clear"></div>
		</fieldset></form>
		<div class="form grid" style="margin-top:20px;">
			<div class="row well-sm">
				<label class="control-label col-sm-1" for="search_filter">Search:</label><div class="col-sm-3"><input id="search_filter" name="search_filter" class="inputbox form-control input-sm" value="" style="display:inline-block;width:90% !important;" /></div>
			</div>
		</div>
		
</div>