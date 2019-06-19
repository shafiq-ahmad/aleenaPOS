<?php
defined('_MEXEC') or die ('Restricted Access');

//echo $id;exit;
if(isset($this->id)){
//print_r($_POST); echo $id;exit;
//if($_POST && $id!==0 && $task=="edit"){

$row = $this->row;

//print_r($row);exit;

?><div class="com-head">
	<?php /* ?><h3>Add/Edit Article</h3><?php 
	
	*/ ?>
</div><div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=suppliers&id=<?php echo $this->id;?>">
		<fieldset class="form">
		<div class="form grid">
			<input type="hidden" name="id" value="<?php if($row){echo $row['id'];}?>" />
			<input type="hidden" name="data_articles" value="<?php if($row){echo $row['data_articles'];}?>" />
			<!--<div class="row well-sm">
				<div class="col-sm-2"><label class="control-label" for="id">ID#:</label></div><div class="col-sm-2"><input name="id" class="inputbox form-control number" value="" /></div>
			</div>-->
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="title">Title:</label></div><div class="col-sm-4"><input name="title" autocomplete="off" pattern=".{2,}" class="inputbox form-control" value="<?php if($row){echo $row['title'];}?>" required autofocus /></div>
				<div class="col-sm-2"><input name="contact_person" placeholder="Person" autocomplete="off" class="inputbox form-control" value="<?php if($row){echo $row['contact_person'];}?>" /></div>
				<div class="col-sm-2"><input type="number" placeholder="Days" name="no_of_days" class="inputbox form-control" value="<?php if($row){echo $row['no_of_days'];}?>" /></div>

			</div>
			<div class="row well-sm"><div class="col-sm-1"><label class="control-label" for="address">Address:</label></div><div class="col-sm-6"><input name="address" autocomplete="off" pattern=".{5,}" class="inputbox form-control" value="<?php if($row){echo $row['address'];}?>" required /></div>
				<?php if(!$row){?><div class="col-sm-2"><input type="number" step="any" placeholder="Account" name="account_value" class="inputbox form-control" value="0" /></div><?php } ?>
			<div class="row well-sm hide"><div class="col-sm-2"><label class="control-label" for="terms_conditions">Terms. Cond.:</label></div><div class="col-sm-9"><input name="terms_conditions" class="inputbox form-control" value="<?php if($row){echo $row['terms_conditions'];}?>" /></div></div>
			</div>
			
			<div class="row well-sm"><div class="col-sm-1"><label class="control-label" for="phone">Contacts:</label></div>
				<div class="col-sm-2"><input name="phone" placeholder="Phone" title="Phone" autocomplete="off" class="inputbox form-control" value="<?php if($row){echo $row['phone'];}?>" /></div>
				<div class="col-sm-2"><input name="fax_no" placeholder="Fax #" title="Fax #" autocomplete="off" class="inputbox form-control" value="<?php if($row){echo $row['fax_no'];}?>" /></div>
				<div class="col-sm-2"><input name="mobile_no" placeholder="Cell#" title="Cell#" autocomplete="off" class="inputbox form-control" value="<?php if($row){echo $row['mobile_no'];}?>" /></div>
				<div class="col-sm-2"><input type="email" placeholder="E-mail" title="E-mail" autocomplete="off" name="e_mail" class="inputbox form-control" value="<?php if($row){echo $row['e_mail'];}?>" /></div>
			</div>
		
			
		</div>
		<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><button type="reset" id="Cancel" class="btn btn-danger" value="Cancel" onclick="history.back()" tabindex="-1" ><i class="glyphicon glyphicon-off"></i> Cancel</button></span>
				<span><button class="btn btn-warning" type="reset" name="reset" tabindex="-1" ><i class="glyphicon glyphicon-remove"></i> Reset</button></span>
				<span><button type="submit" name="save" id="save" class="btn btn-success" tabindex="-1" ><i class="fa fa-save"></i> Save</button></span>
				<span><a href="?com=suppliers" class="btn btn-info" tabindex="-1" ><i class="fa fa-file"></i> New</a></span>
			</li>
			<li></li>
		</ul>
		</div>
		</fieldset>
	</form>
	<div id="supplier-articles">
		<h3>Supplier Items</h3>
		
	</div>
</div><?php
}
 
?>
