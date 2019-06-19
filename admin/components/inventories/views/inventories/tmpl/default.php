<?php
defined('_MEXEC') or die ('Restricted Access');

?><div class="form"><?php
	//$form_model = "components/{$com}/models/purchase.php";
	//$form_file = "components/{$com}/views/purchase/edit.php";
	//require_once $form_model;
	//require_once $form_file;
	//print_r($rows);exit;
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
			<div class="filter">
				<label class="control-label" for="search_filter">Filter:</label><input id="search_filter" name="search_filter" class="inputbox form-control" value="" />
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
	<table  class="table table-bordered table-hover table-condenseds nav-able">
		<thead>
		<tr>
			<th>ID</th><th>Inv. Date</th><th>Inv. Status</th><th>User Name</th><th>Remarks</th><th>NOS Inventories</th>
			<th class="no-print">Actions</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			$x=2;
			foreach ($this->rows as $row){
		?><tr <?php /*if($id==$row['purchase_id']){echo ' class="active"';}*/ ?>><?php 
			echo '<td tabindex="' . $x . '">' . $row['id'] . '</td>'; 
			echo '<td>' . $row['inv_date'] . '</td>'; 
			echo '<td>' . $row['inv_status'] . '</td>'; 
			echo '<td>' . $row['full_name'] . '</td>';
			echo '<td>' . $row['remarks'] . '</td>'; 
			echo '<td>' . $row['nos_inv'] . '</td>'; 
			echo '<td class="no-print">'; 
			if($row['inv_status']=='Open'){
				$stock_link = "?com=inventories&view=inventory&id={$row['id']}";
				echo '<a href="' . $stock_link . '" title="Edit" tabindex="-1">Edit</a>';
			}
			echo '</td>'; 
		?></tr><?php
		$x++;
			}
		?></tbody>
	</table>
</div><?php 
?>