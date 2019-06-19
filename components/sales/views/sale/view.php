<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class SaleViewSales extends View{
	public $id=0;
	public function display($tpl = null){
		$this->task = Application::$options->task;
		$this->model = $this->getModel('sale');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		if($this->task!='get'){
			$this->app = core::getApplication();
			$this->app->setTitle('Sale');
			$this->rows = $this->model->getSaleInvoiceArticles($this->id);
			$this->inv = $this->model->getAllInvoice($this->id);
			//var_dump($this->inv);
		}else{
			if($this->id){
				$this->row = $this->model->getInvoiceByID($this->id);
				echo json_encode($this->row);
				exit;
			}
			//$this->new_id = $this->model->newInvoiceNo();
			//echo $this->new_id;exit;
			if(isset($_GET['type'])){
				$type=$_GET['type'];
				if($type=='new_id'){
					echo $this->model->newInvoiceNo();exit;
				}elseif($type=='new_quotation_id'){
					echo $this->model->newQuotationNo();exit;
				}
			}
		}
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
