<?php
defined('_MEXEC') or die ('Restricted Access');

?>
<div class="com-head">
	<h3>Alerts</h3>
</div>
<div class="form"><?php
	/*$list = array();
	$list['view']='message';
	$list['task']='view';
	$view = $this->getView('message', 'messages', 'view');
	echo $view->display($list);*/
?>
	<!-- Modal -->
<div id="modalCom" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div></div>

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
	<table id="data-table" class="tablez">
		<thead>
		<tr>
			<th>Date</th><th>CC</th><th>Subject</th><th>Actions</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
		?><tr <?php if($this->id==$row['id']){echo ' class="active"';} ?>><?php 
			//echo '<td>' . $row['id'] . '</td>';
			$date = strftime("%Y-%m-%d", strtotime($row['time_stamp']));
			echo '<td>' . $date . '</td>';
			//echo '<td>' . $row['from_name'] . '</td>'; 
			//echo '<td>' . $row['to_name'] . '</td>';
			echo '<td>' . $row['cc_name'] . '</td>';
			$msg = $row['msg_body'];
			//echo "<td data-toggle=\"tooltip\" title='" . strip_tags($msg) . "'>" . $row['msg_subject'] . '</td>';	//bootstrap tooltip
			echo "<td>" . $row['msg_subject'] . '</td>';
			$edit_link = "?com=messages&view=message&task=view&tmpl=modal&id={$row['id']}";
			echo '<td>'; 
			echo '<a data-toggle="modal" data-target="#modalCom" href="' . $edit_link . '" title="View">View</a>'; 
			echo '</td>'; 
		?></tr><?php
			}
		?></tbody>
	</table>
</div>

<script>
	$(document).ready( function () {
		$('#data-table').DataTable({stateSave: true});
	} );
</script>