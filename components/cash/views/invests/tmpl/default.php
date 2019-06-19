<?php
defined('_MEXEC') or die ('Restricted Access');

if(isset($this->rows) && $this->rows){
	//$id = $rows[0]['id'];
}
?>
<div class="com-head">
	<h3>Investments</h3>
	<?php /* ?><div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><button type="reset" id="Cancel" class="btn btn-danger" value="Cancel" onclick="history.back();self.close();" tabindex="-1"><i class="glyphicon glyphicon-off"></i> Cancel</button></span>
				<span><a onclick="window.open('?com=cash&view=invest&task=edit&tmpl=js_win','_blank', 'top=10, left= 100, location=top, width=800,height=500');return false;" class="btn btn-info" tabindex="-1"><i class="fa fa-cart-plus"></i> New</a></span>
			</li>
			<li></li>
		</ul>
	</div><?php */ ?>
</div>
<div class="form"><?php
	$list = array();
	$list['view']='invest';
	$list['task']='edit';
	$view = $this->getView('invest', 'cash', 'edit');
	echo $view->display($list);/**/
?></div><br/>
<div class="table-responsive">
	<div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="cash" />
			<input type="hidden" name="view" value="invests" />
			<div>
			
			
			<!--<div class="input-group date">
			<div class="input-group-addon">
			<i class="fa fa-calendar"></i>
			</div>
			<input type="text" class="form-control pull-right" id="datepicker">
			</div>-->
			
			
			<div class="form-group date-range">
				<label class="control-label col-sm-1" for="start_date">Range:</label>
				<div class="col-sm-2">
					<div class="input-group date">
						<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
						</div>
						<input name="start_date" type="date" autocomplete="off" id="start_date"class="form-control date<?php if(!isset($_GET['start_date'])){ echo '-default';}?>" value="<?php if(isset($_GET['start_date'])){ echo $_GET['start_date'];}?>" tabindex="-1" />
					</div>
				</div>
				<div class="col-sm-2">
					<div class="input-group date">
						<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
						</div>
						<input name="end_date" type="date" autocomplete="off" id="end_date"class="form-control date<?php if(!isset($_GET['end_date'])){ echo '-default';}?>" value="<?php if(isset($_GET['end_date'])){ echo $_GET['end_date'];}?>" tabindex="-1" />
					</div>
				</div>
				<div class="col-sm-2">
				<input type="submit" name="search_date" class="btn btn-success btn-sm screen" value="Search" />
				</div>
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
	<table id="data-table" class="table">
		<thead>
		<tr>
			<th>ID</th><th>Date</th><th>Ref#</th><th>Cash</th><th>Old Account</th><th>Old Cash</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
		?><tr <?php if($this->id==$row['id']){echo ' class="active"';} ?>><?php 
			echo '<td>' . $row['id'] . '</td>';
			echo '<td>' . $row['payment_date'] . '</td>'; 
			echo '<td>' . $row['ref_no'] . '</td>'; 
			echo '<td>' . $row['cash'] . '</td>'; 
			echo '<td>' . $row['old_account_value'] . '</td>'; 
			echo '<td>' . $row['old_cash_value'] . '</td>'; 
			//$edit_link = "?com=customers&view=customer&task=edit&id={$row['id']}";
			//$delete_link = "?com=articles&view=article&task=delete&id={$row['article_code']}";
			//echo '<td>'; 
			//echo '<a href="' . $edit_link . '" title="Edit">Edit</a>'; 
			//echo '<a href="' . $delete_link . '" title="Delete">Delete</a>'; 
			//echo '</td>'; 
		?></tr><?php
			}
		?></tbody>
		<tfoot>
			<tr>
				<th colspan="5" style="text-align:right">Total:</th>
				<th colspan="2"></th>
			</tr>
		</tfoot>
		<script>
		//cals_reportItemsTotal();
		</script>
	</table>
</div><?php 
?>