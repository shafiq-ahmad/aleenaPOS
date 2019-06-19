<?php
defined('_MEXEC') or die ('Restricted Access');

//print_r($_POST);exit;

?><div class="com-head">
	<?php /* ?><h3>Add/Edit Category</h3><?php */ ?>
</div><div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=categories&view=category&task=new">
		<fieldset class="form">
		<div class="form grid">
			<input type="hidden" name="id" value="" />
			<div class="row well-sm"><div class="col-sm-1"><label class="control-label" for="id">ID#:</label></div><div class="col-sm-2"><input name="id" class="inputbox form-control number" value="" /></div>
				<div class="col-sm-2"><label class="control-label" for="title">Title:</label></div><div class="col-sm-2"><input name="title" class="inputbox form-control" value="" /></div>
				<div class="col-sm-2"><label class="control-label col-sm-1" for="category">Category:</label> </div><div class="col-sm-3"><?php 
			
			echo '<SELECT name="category" id="category" class="category form-control dropdown-header">';
			echo '<OPTION value="">This is Main Category</OPTION>';
			foreach ($this->cats as $cat){
				//echo '<optgroup label="' . $cat['name'] . '">';
				echo '<OPTION VALUE="' . $cat['id'] . '">' . $cat['title'] . '</OPTION>';
				//echo '</optgroup>';
			}
			echo '</SELECT>';
			
			
			?></div></div>
			<div class="row well-sm"><div class="col-sm-1"><label class="control-label" for="discount_per">Discount%:</label> </div><div class="col-sm-2"><input name="discount_per" class="inputbox form-control number" value="" readonly /></div>
				<div class="col-sm-2"><label class="control-label col-sm-2" for="gst_per">GST%:</label> </div><div class="col-sm-2"><input name="gst_per" class="inputbox form-control number" value="" readonly /></div></div>
		</div>
		<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><input type="reset" id="Cancel" class="btn btn-default" value="Cancel" onclick="history.back()"  /></span>
				<?php /* ?><span><input class="btn btn-default" type="reset" name="reset" value="Reset" /></span><?php */ ?>
				<span><input class="btn btn-default" type="reset" name="reset" value="Reset" /></span>
				<span><input type="submit" name="save" id="save" class="btn btn-success" value="Save" /></span>
			</li>
			<li></li>
		</ul>
		</div>
		</fieldset>
	</form>
</div><?php

?>
