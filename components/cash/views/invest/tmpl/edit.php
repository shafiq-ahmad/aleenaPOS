<?php
defined('_MEXEC') or die ('Restricted Access');

//print_r($row);exit;

?><div class="com-head">
</div><div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=cash&view=invests">
		<fieldset class="form">
		<div class="form grid">
			<input type="hidden" name="token" value="" />
			<div class="row well-sm">
				<div class="col-sm-2">New Investment</div><div class="col-sm-1"><label class="control-label" for="amount">Amount#:</label></div><div class="col-sm-2"><input name="amount" class="inputbox form-control" value="" /></div>
				<span> <button type="submit" name="save" id="save" class="btn btn-success btn-flat" tabindex="-1"><i class="fa fa-save"></i> Save</button></span>
				<span> <button type="submit" name="reset" class="btn btn-info btn-flat reset" tabindex="-1"><i class="fa fa-remove"></i> Reset</button></span>
			</div>
		</div>
		</fieldset>
	</form>
</div><?php

?>