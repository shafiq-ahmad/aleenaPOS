<?php
defined('_MEXEC') or die ('Restricted Access');

$id=0;
$status='';
$comments='';
$id=0;

if($this->id){
	$id = $this->id;
	$row = $this->row;
}

//echo $id . '<br/>';
//echo $inv['id'];
//exit;
?><div class="com-head">
<script type="text/javascript">

</script>
</div>
  <!-- Select2 -->
  <link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<!-- Select2 -->
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script>

<!--<p><span class="suggest"></span></p>-->
<div>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Choose an item</h4>
        </div>
        <table class="modal-body nav-able"></table>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  

<form class="form-inline" method="post" name="frm" action="?com=inventories&view=inventory<?php if($id){echo '&id='.$id;} ?>">
		<fieldset class="form">
		<div class="form grid">
			<input type="hidden" id="form_type" name="form_type" value="inv_main" />
			<input type="hidden" id="frm_main_state" name="frm_main_state" value="<?php
				if($id){
					echo 'edit';
				}else{
					echo 'unset';
				}
			?>" />
			<input type="hidden" name="status" value="<?php echo $status ;?>" />
			<input type="hidden" name="payment_date" value="" /><?php if($id){ ?>
			<div class="row well-sm">
				<div class="col-sm-2"><input type="number" placeholder="Amount" name="amount" class="inputbox form-control input-sm" value="<?php if(isset($inv['amount']) && $inv['amount']){ echo $inv['amount'];}?>" tabindex="-1" readonly /></div>
				<div class="col-sm-2"><input type="number" placeholder="Cash" name="cash" class="inputbox form-control input-sm" value="<?php if(isset($inv) && $inv['cash']){ echo $inv['cash'];}?>" tabindex="-1" step="any" <?php if($status){echo 'disabled';} ?> /><span class="validity"></span></div>
				<div class="col-sm-2"><input type="number" placeholder="Credit" name="credit" class="inputbox form-control input-sm" value="<?php if(isset($inv) && $inv['credit']){ echo $inv['credit'];}?>" tabindex="-1" step="any" <?php if($status){echo 'disabled';} ?> /><span class="validity"></span></div>
				<div class="col-sm-1 hide"><label class="control-label" for="finish_inv">Finish:</label></div><div class="col-sm-1 hide"><input type="checkbox" name="finish_inv" class="checkbox" tabindex="-1" <?php if($status){echo 'disabled';} ?> checked /></div>
				<div class="col-sm-1">&nbsp;</div>
				<?php if(!$status){?><span><button id="save" name="save" id="save" class="btn btn-success btn-sm btn-flat" tabindex="-1"><i class="fa fa-edit"></i> Done</button></span><?php }?>
			</div><?php } ?>
			</div><div class="clear"></div>
		</fieldset></form><hr/><?php
	
		
		/*
			Items form section
		*/
//
	//if(!$this->row){
	?><form class="form-inline screen" method="post" id="frm_inv_art" name="frm_inv_art" action="?com=inventories&view=inventory<?php if($this->id){echo '&id='.$this->id;} ?>">
		<fieldset class="form">
			<legend>Items</legend>
			<div class="form grid">
				<input type="hidden" name="form_type" value="inv_items" />
				<input type="hidden" name="id" value="<?php if(isset($inv)){ echo $inv['id'];} ?>" />
				<div class="row well-sm">
					<div class="col-sm-2"><input placeholder="Item #" id="article_code" name="article_code" class="inputbox form-control input-sm" value="" autofocus /></div>
					<div class="col-sm-3"><input placeholder="Title" id="title" name="title" class="inputbox form-control input-sm" value="" readonly tabindex="-1" /></div>
					<div class="col-sm-1"><input placeholder="Stock" id="stock" name="stock" class="inputbox form-control input-sm number" value="" readonly tabindex="-1" /></div>	
					<div class="col-sm-1"><input placeholder="Price" type="number" step="any" id="sale_price" placeholder="Price" name="sale_price" class="inputbox form-control input-sm number" value="" readonly /></div>
					<div class="col-sm-1"><input autocomplete="off" type="number" step="any" id="qty" placeholder="Qty" name="qty" class="inputbox form-control input-sm number" value="" /></div>
					<div class="col-sm-1"><span><button id="save_art" name="save_art" id="save_art" class="btn btn-success btn-sm btn-flat" tabindex="-1" onclick="saveArticle();return false;"><i class="glyphicon glyphicon-plus"></i> Add</button></span></div>
				</div>
			</div><div class="clear"></div>
			<hr/>
		</fieldset>
	</form><?php
		//}
?></div>