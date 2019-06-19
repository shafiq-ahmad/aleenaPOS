<?php
defined('_MEXEC') or die ('Restricted Access');

if(isset($this->rows) && $this->rows){
	//$id = $rows[0]['id'];
}
?>
<div class="com-head">
	<h3>Articles</h3>
</div>
<div class="form"><?php
	/*$list = array();
	$list['view']='customer';
	$list['task']='edit';
	$view = $this->getView('customer', 'customers', 'edit');
	echo $view->display($list);*/
?></div>
<div class="table-responsive">
	<div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="sales" />
			<input type="hidden" name="view" value="items_report" />
			<div>
			<?php /* ?><div class="date-range">
				<label class="control-label" for="start_date">Start date:</label>
				<input name="start_date" id="start_date"class="inputbox input-sm date<?php if(!isset($_GET['start_date'])){ echo '-default';}?>" value="<?php if(isset($_GET['start_date'])){ echo $_GET['start_date'];}?>" tabindex="-1" />
				<label class="control-label" for="end_date">End date:</label>
				<input name="end_date" id="end_date" class="inputbox input-sm date<?php if(!isset($_GET['end_date'])){ echo '-default';}?>" value="<?php if(isset($_GET['end_date'])){ echo $_GET['end_date'];}?>" tabindex="-1" />
				<input type="submit" name="search_date" class="btn btn-success screen" value="Search" />
			</div><?php */ ?>
			<div class="filter hide">
				<label class="control-label" for="search_filter">Filter:</label><input id="search_filter" name="search_filter" class="inputbox form-control" value="" />
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
	<table id="data-table" class="table">
		<thead>
		<tr>
			<th>ID</th><th>Ref#</th><th>Station</th><th>Date</th><th>Details</th><th>Amount</th><th>Old cash</th><!--<th>Actions</th>-->
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
		?><tr <?php if($this->id==$row['id']){echo ' class="active"';} ?>><?php 
			echo '<td>' . $row['id'] . '</td>';
			echo '<td>' . $row['ref_no'] . '</td>'; 
			echo '<td>' . $row['cash_source'] . '</td>'; 
			echo '<td>' . $row['transaction_date'] . '</td>'; 
			echo '<td>' . $row['details'] . '</td>';
			echo '<td>' . $row['cash'] . '</td>'; 
			echo '<td>' . $row['old_cash_value'] . '</td>'; 
			$arr=explode('.',$row['ref_no']);
			if($arr[0]=='purchases'){
				$edit_link = "?com={$arr[0]}&view={$arr[1]}&id={$arr[2]}";
			}else{
				$edit_link = "?com={$arr[0]}&view=sale&task=edit&id={$arr[2]}";
			}
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