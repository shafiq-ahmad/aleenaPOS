<?php
defined('_MEXEC') or die ('Restricted Access');


//if($this->id){
//print_r($_POST); echo $id;exit;
//if($_POST && $id!==0 && $task=="edit"){

?><div class="com-head"><h3>Add Expense</h3>
</div><div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=expenses&view=expense&task=edit">
		<fieldset class="form">
		<div class="form grid">
			<input type="hidden" name="id" value="" />
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="expense_id">Expense:</label></div>
				<div class="col-sm-2">
					<SELECT name="expense_id" class="form-control input-sm flat" required >
						<OPTION value=""></OPTION><?php
						//var_dump($sup_list);exit;
							foreach ($this->expenses_list as $st){
								$selected="";
								//if ($pur['supplier_id']==$st['id']){$selected='selected="selected"';}
								echo '<OPTION value="' . $st['id'] . '" ' . $selected . ' >' . $st['title'] . '</OPTION>';
							}
					?></SELECT>
				</div>
				<div class="col-sm-1"><label class="control-label" for="title">Station:</label></div>
				<div class="col-sm-2">
					<SELECT name="station_id" class="form-control input-sm flat" required >
						<OPTION value=""></OPTION><?php
						//var_dump($sup_list);exit;
							foreach ($this->stns as $st){
								$selected="";
								echo '<OPTION value="' . $st['id'] . '" ' . $selected . ' >' . $st['title'] . '</OPTION>';
							}
					?></SELECT>
				</div>
			
			
			</div>
			<div class="row well-sm"><div class="col-sm-1"><label class="control-label" for="cash">Amount:</label></div><div class="col-sm-2"><input type="number" step="any" name="cash" class="inputbox form-control" value="" required /></div>
			</div>
			<div class="row well-sm"><div class="col-sm-1"><label class="control-label" for="details">Details:</label></div><div class="col-sm-5"><input name="details" class="inputbox form-control" value="" /></div>
			</div>
		<div class="row">
			<div class="col-sm-1">&nbsp;</div>
			<div class="btn-group">
			<ul class="form-buttons">
				<li>
					<span><button type="reset" id="Cancel" class="btn btn-danger" value="Cancel" onclick="history.back()" tabindex="-1" ><i class="glyphicon glyphicon-off"></i> Cancel</button></span>
					<span><button class="btn btn-warning" type="reset" name="reset" tabindex="-1" ><i class="glyphicon glyphicon-remove"></i> Reset</button></span>
					<span><button type="submit" name="save" id="save" class="btn btn-success" tabindex="-1" ><i class="fa fa-save"></i> Save</button></span>
				</li>
				<li></li>
			</ul>
			</div>
		</div>
		</fieldset>
	</form>
</div></div>
<div>
<h3></h3>
<table class="table">
<thead>
<!--<tr><th>ID</th><th>Date</th><th>Cash</th><th>Old Account</th><th>Details</th></tr>-->
</thead>
<tbody>
<?php 
	/*foreach($this->history as $h){
		echo '<tr>';
		echo '<td>' . $h['id'] . '</td>';
		echo '<td>' . $h['transaction_date'] . '</td>';
		echo '<td>' . $h['cash'] . '</td>';
		echo '<td>' . $h['old_account_value'] . '</td>';
		echo '<td>' . $h['details'] . '</td>';
		echo '</tr>';
	}*/
?>
</tbody>
</table>
</div>
