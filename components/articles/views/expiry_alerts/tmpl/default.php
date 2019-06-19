<?php
defined('_MEXEC') or die ('Restricted Access');

?>
<div class="com-head">
	<h3>Items Expiry Alerts</h3>
</div>
<div class="form"><?php
	/*$list = array();
	$list['view']='branch_article';
	$list['task']='edit';
	$view = $this->getView('branch_article', 'articles', 'edit');
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
	<table id="data-table" class="table table-bordered table-hover">
		<thead>
		<tr>
			<th>Item#</th><th>Title</th><th>Qty</th>
			<th>Expiry</th><th>Days</th><th>Alert</th><th class="screen">Actions</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><script>
	var json_data = <?php
		echo json_encode($this->rows); ?>;
	//console.log(json_data);
	var subTotal=0;
	var discount_amount=0;
	var cash=0;
	var credit=0;
	var change_return=0;
	$.each(json_data, function(i, v) {
			//var jsons= JSON.parse(v.stock_expiry_dates);
			if(v.stock_expiry_dates){
			var jsons = JSON.parse(v.stock_expiry_dates);
			if(jsons){
			$.each(jsons, function(j, t){
				var d = new Date(t.expiry);
				var now = new Date();
				var dif_days = (d.getTime() - now.getTime())/ (1000 * 3600 * 24);
				//console.log(dif_days);
				var class_tr='';
				if(dif_days>30){
					class_tr='expiring30';
				}else if(dif_days>20){
					class_tr='expiring20';
				}else if(dif_days>10){
					class_tr='expiring10';
				}else if(dif_days>0){
					class_tr='expiring1';
				}else{
					class_tr='expired';
				}
				var strDay=d.getDate();
				if(strDay<10){
					strDay = '0'+strDay;
				}
				var strMonth=d.getMonth()+1;
				if(strMonth<10){
					strMonth = '0'+strMonth;
				}
				var strDate=d.getFullYear()+'/'+strMonth+'/'+strDay;
				
				document.write('<tr class="' + class_tr + '">');
				document.write('<td class="sale_date">'+v.article_code+ '</td>');
				document.write('<td class="sale_date">'+v.title+ '</td>');
				document.write('<td class="sale_date">'+t.qty+ '</td>');
				document.write('<td class="cat">'+strDate+'</td>');
				document.write('<td class="cat">'+dif_days.toFixed(2)+'</td>');
				var alrt='';
				if(v.expiry_alert_days>0){
					alrt = eval(dif_days - v.expiry_alert_days).toFixed(2);
				}
				document.write('<td class="cat">'+alrt+'</td>');
				//document.write('<td class="total">'+v.sub_total+'</td>');
				document.write('<td class="no-print"><a href="?com=articles&view=branch_article&task=edit&id='+v.article_code+'" title="Edit"><i class="fa fa-edit"></i></a></td>');
				document.write('</tr>');
			//console.log(now);
			//console.log(d.toJSON());
			});
			}
			
			}
		/*
		$.each(jsons.stock_expiry_dates, function(j, ex) {
		});*/
	});
		</script></tbody>
		<tfoot></tfoot>
	</table>
</div>
<script type="text/javascript">
    $(function () {
        $("#data-table").DataTable();
    });
</script>