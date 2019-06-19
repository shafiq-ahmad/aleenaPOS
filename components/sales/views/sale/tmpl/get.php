<?php
defined('_MEXEC') or die ('Restricted Access');

if(isset($_GET['type'])){
	$type=$_GET['type'];
	if($type=='new_id'){
		echo $this->model->newInvoiceNo();exit;
	}elseif($type=='new_quotation_id'){
		echo $this->model->newQuotationNo();exit;
	}
}
if(isset($_GET['type'])){
	$type=$_GET['type'];
	if($type=='invoice_by_id'){
		echo $this->model->getInvoiceByID();
	}
}
exit;

