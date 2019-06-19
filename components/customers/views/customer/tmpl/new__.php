<?php
defined('_MEXEC') or die ('Restricted Access');

//print_r($row);exit;

?><div class="com-head">
	<?php /* ?><h3>Add/Edit Article</h3><?php 
	
	*/ ?>
</div><div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=customers&view=customers">
		<fieldset class="form">
		<div class="form grid">
			<input type="hidden" name="id" value="" />
			<div class="row well-sm">
				<div class="col-sm-2"><label class="control-label" for="title">Title:</label></div><div class="col-sm-5"><input name="title" class="inputbox form-control" value="" autofocus required /></div>
			</div>
			<div class="row well-sm"><div class="col-sm-2"><label class="control-label" for="address">Address:</label></div><div class="col-sm-5"><input name="address" class="inputbox form-control" value="" /></div>
				<div class="col-sm-1 hide"><label class="control-label" for="town">Town:</label> </div><div class="col-sm-3 hide"><?php 

				echo '<SELECT name="town_id" id="town_id" class="town_id form-control dropdown-header">';
				echo '<OPTION value="">Please select a value</OPTION>';
				$selected = '';
				foreach ($this->towns as $t){
					echo '<OPTION value="' . $t['id'] . '" ' . $selected . '>' . $t['title'] . '</OPTION>';
				}/**/
				echo '</SELECT>';
				?></div>

			</div>
			
				<div class="row well-sm"><div class="col-sm-2"><label class="control-label" for="lng">Lng:</label></div><div class="col-sm-2"><input type="number" name="lng" class="inputbox form-control" value="" /></div>
					<div class="col-sm-2"><label class="control-label" for="lat">Lat:</label></div><div class="col-sm-2"><input type="number" name="lat" class="inputbox form-control" value="" /></div></div>
			<div class="row well-sm"><div class="col-sm-2"><label class="control-label" for="account_no">Account#:</label></div><div class="col-sm-2"><input name="account_no" class="inputbox form-control" value="" /></div>
				<div class="col-sm-1"><label class="control-label" for="cnic">CNIC#:</label></div><div class="col-sm-2"><input name="cnic" class="inputbox form-control" value="" /></div>
			</div>
			
			<div class="row well-sm"><div class="col-sm-2"><label class="control-label" for="phone">Phone#:</label></div><div class="col-sm-2"><input name="phone" class="inputbox form-control" value="" /></div>
				<div class="col-sm-1"><label class="control-label" for="fax_no">Fax#:</label></div><div class="col-sm-2"><input name="fax_no" class="inputbox form-control" value="" /></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-2"><label class="control-label col-sm-2" for="mobile_no">Mobile#:</label> </div><div class="col-sm-2"><input name="mobile_no" class="inputbox form-control" value="" /></div>
				<div class="col-sm-1"><label class="control-label" for="e_mail">E-mail:</label></div><div class="col-sm-5"><input name="e_mail" class="inputbox form-control" value="" /></div>
			</div>
			<br/>
			<div class="row well-sm"><div class="col-sm-2"><label class="control-label" for="opening_balance">Opening Balance:</label></div><div class="col-sm-2"><input name="opening_balance number" class="inputbox form-control" value="0" /></div>
				<div class="col-sm-2"><label class="control-label col-sm-2" for="closing_balance">Closing:</label> </div><div class="col-sm-2"><input name="closing_balance" class="inputbox form-control number" value="0" /></div></div>
		
			
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