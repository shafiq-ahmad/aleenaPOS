<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class PaymentViewSuppliers extends View{
	public $id=0;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Supplier\'s Payment');
		$model = $this->getModel('supplier');
		$db = core::getDBO();
		$model_payment = $this->getModel('cash.payment');
		$model_payments = $this->getModel('cash.payments');
		$model_cash = $this->getModel('cash.cash');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		if($_POST && !$this->id){
			$this->id = $model->createData($_POST);
		}
		if($_POST && $this->id!==0){
			$data=$_POST;
			$db->start();
			$data['ref_no']='suppliers.supplier.'.$this->id;
			$c = $model_payment->createData($data);
			$ac = $model->setAccount($this->id,$data['cash'],'-');
			if($c && $ac){
				$db->commit();
				$db->redirect("?com=cash&view=payments");
			}else{
				$db->rollback();
				$db->redirect("?com=suppliers&view=payment&task=edit&id={$this->id}");
			}
		}
		$this->row = $model->getDataByID($this->id);
		$this->items = $model->getArticles($this->id);
		$this->history = $model_payments->getDataByRefNo('suppliers.supplier.'.$this->id);
		$this->stns = $model_cash->getBranchStation();

		parent::display($tpl);
	}
}
