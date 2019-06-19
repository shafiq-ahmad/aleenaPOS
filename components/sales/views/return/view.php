<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class ReturnViewSales extends View{
	public $id=0;
	public function display($tpl = null){
		$this->task = Application::$options->task;
		$this->model = $this->getModel('return');
		$this->u = Core::getUser()->getUser();
		$cust_model = $this->getModel('customers.customers');
		$this->customers = $cust_model->getData();
		//$this->rows = $this->model->getChilds();
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		if($this->task!='get'){
			$this->app = core::getApplication();
			$this->app->setTitle('Sale Return');
			$this->rows = $this->model->getReturnArticles($this->id);
			$this->inv = $this->model->getAllInvoice($this->id);
			//var_dump($this->inv);
		}else{
			if($this->id){
				$this->row = $this->model->getReturnByID($this->id);
				echo json_encode($this->row);
				exit;
			}
			//$this->new_id = $this->model->newInvoiceNo();
			//echo $this->new_id;exit;
			if(isset($_GET['type'])){
				$type=$_GET['type'];
				if($type=='new_id'){
					echo $this->model->newReturnNo($_POST);exit;
				}
			}
		}
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
