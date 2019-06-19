<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class ReceiptViewCustomers extends View{
	public $id=0;
	public function display($tpl = null){
		$model = $this->getModel('customer');
		$model_receipt = $this->getModel('cash.receipt');
		$model_receipts = $this->getModel('cash.receipts');
		$model_cash = $this->getModel('cash.cash');
		$this->app = core::getApplication();
		$this->app->setTitle('Customer\'s payments');
		$task=Application::$options->task;
		//echo $task;exit;
		
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}elseif(isset($_POST['id'])){
			$this->id = $_POST['id'];
		}
		if($_POST && $this->id && $task=='edit'){
			$db = core::getDBO();
			$data=$_POST;
			$db->start();
			$data['ref_no']='customers.customer.'.$this->id;
			$c = $model_receipt->createData($data);
			$ac = $model->setAccount($this->id,$data['cash'],'-');
			if($c && $ac){
				$db->commit();
				$db->redirect("?com=cash&view=receipts");
			}else{
				$db->rollback();
				$db->redirect("?com=customers&view=receipt&task=edit&id={$this->id}");
			}
		}
		$this->history = $model_receipts->getDataByRefNo('customers.customer.'.$this->id);

		$this->row = $model->getDataByID($this->id);
		$this->stns = $model_cash->getBranchStation();
		parent::display($tpl);
	}
}
