<?php
defined('_MEXEC') or die ('Restricted Access');


?><?php /* ?><div class="com-head">
	<h3>View Articles</h3>
</div><?php */ ?>
<div class="form"><?php
	$list = array();
	$list['view']='category';
	$list['task']='edit';
	$view = $this->getView('category', 'categories', 'edit');
	echo $view->display($list);
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
	<table class="table table-bordered table-hover table-condenseds">
		<thead>
		<tr>
			<th>ID#</th><th>Sub Category</th><th>Category</th><th>Total / Items</th><th>Items Sum</th><th>Low Stock Items</th><th>Actions</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
		?><tr <?php if($this->id==$row['id']){echo ' class="active"';} ?>><?php 
			echo '<td>' . $row['id'] . '</td>';
			echo '<td>' . $row['title'] . '</td>'; 
			echo '<td>' . $row['parent_title'] . '</td>';
			echo '<td>' . $row['all_arts'] . ' / ' . $row['bra_art_count'] . '</td>';
			echo '<td>' . $row['item_sum'] . '</td>';
			echo '<td>' . $row['low_stock'] . '</td>';
			$edit_link = "?com=categories&view=categories&id={$row['id']}";
			echo '<td>'; 
			echo '<a href="' . $edit_link . '" title="Edit">Edit</a>'; 
			echo '</td>'; 
		?></tr><?php
			}
		?></tbody>
	</table>
</div><?php 
?>