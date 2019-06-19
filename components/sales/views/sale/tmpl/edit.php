<?php
defined('_MEXEC') or die ('Restricted Access');

$cust_title=$this->inv['cust_title'];
$person=$this->inv['person'];
$credit=$this->inv['credit'];

//echo json_encode($row);exit;
?><div class="com-head">
	<?php /* ?><h3>Add/Edit Article</h3><?php */ ?>
	<style>
	.form-inline .row {margin-bottom:10px;}
	</style>
</div><div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=articles&view=articles&id=<?php echo $this->id;?>">
		<fieldset class="form">
		<div class="form grid">
			<div class="row well-sm">
				<div class="col-sm-1 cell">Invoice #: </div><div class="col-sm-2 cell"><?php echo $this->inv['id'];?></div>
				<div class="col-sm-1 cell">Date: </div><div class="col-sm-2 cell"><?php echo $this->inv['sale_date'];?></div>
				<div class="col-sm-1 cell">User: </div><div class="col-sm-3 cell"><?php echo $this->inv['full_name'];?></div>
			</div>
			<div class="row well-sm">
				<?php if($cust_title){?><div class="col-sm-1 cell">Customer: </div><div class="col-sm-2 cell"><?php echo $cust_title;?></div><?php } ?>
				<?php if($person){?><div class="col-sm-1 cell">Person: </div><div class="col-sm-2 cell cell"><?php echo $person;?></div></div><?php } ?>
			</div>
			<div class="row well-sm">
				<div class="col-sm-1 cell">Sub Total: </div><div class="col-sm-1 cell"><?php echo $this->inv['sub_total'];?></div>
				<div class="col-sm-1 cell">Discount: </div><div class="col-sm-1 cell"><?php echo $this->inv['discount_amount'];?></div>
				<div class="col-sm-1 cell highlight">Bill: </div><div class="col-sm-1 cell highlight"><?php echo $this->inv['sub_total']-$this->inv['discount_amount'];?></div>
				<div class="col-sm-1 cell">Cash: </div><div class="col-sm-1 cell"><?php echo $this->inv['cash'];?></div>
				<?php if($credit){?><div class="col-sm-1 cell">Credit: </div><div class="col-sm-1 cell"><?php echo $this->inv['credit'];?></div><?php } ?>
				<div class="col-sm-1 cell">Change: </div><div class="col-sm-1 cell"><?php echo $this->inv['change_return'];?></div>
			</div>
			<div class="row well-sm screen">
				<?php /* ?><div class="col-sm-1"><label class="control-label" for="bank_check">Bank Cheque:</label> </div><div class="col-sm-1"><input name="bank_check" class="inputbox form-control" value="<?php echo $this->inv['bank_check'];?>" /></div>
				<div class="col-sm-1"><label class="control-label" for="bank_card">Bank Card:</label> </div><div class="col-sm-1"><input name="bank_card" class="inputbox form-control" value="<?php echo $this->inv['bank_card'];?>" /></div>
			<?php */?></div>
		</div>
		</fieldset>
	</form>
</div>
	<table  class="table table-bordered table-hover table-condenseds">
		<thead>
		<tr>
			<th class="screen">Item Code</th><th>Title</th><th>Qty</th><th>Sch.</th><th>Price</th><th>Discount</th><th>TP Price</th><th>Total Cost</th>
		</tr>
		</thead>
		<tbody id="pur_articles">		
		<script>
	var json_data = <?php
		echo $this->inv['data_articles']; ?>;
	//console.log(json_data);
	var subTotal=0;
	var discount_amount=0;
	var cash=0;
	var credit=0;
	var change_return=0;
	$.each(json_data.articles, function(i, v) {
		document.write('<tr>');
		document.write('<td class="article_code">'+v.article_code+'</td>');
		document.write('<td class="title">'+v.title+'</td>');
		document.write('<td class="qty">'+v.qty+'</td>');
		document.write('<td class="cost_price">'+v.cost_price+'</td>');
		//price_terms
		document.write('<td class="price">'+eval(v.price).toFixed(2)+'</td>');
		document.write('<td class="tp_price">'+eval(v.tp_price).toFixed(2)+'</td>');
		document.write('<td class="discount">'+eval(v.discount).toFixed(2)+'</td>');
		document.write('<td class="station_id">'+eval(v.station_id).toFixed(2)+'</td>');
		//document.write('<td class="no-print"><a href="?com=sales&view=sale&task=edit&id='+v.id+'" title="Edit">Edit</a></td>');
		document.write('</tr>');
	});
		</script>
		
		</tbody>
		<tfoot>
			<tr>
				<th colspan="7">Total:</th><th><?php //echo $sub_total; ?></th>
			</tr>
		</tfoot>
	</table>