<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class ExpenseViewExpenses extends View{
	public $id=0;
	public function display($tpl = null){
		$model = $this->getModel('expense');
		$this->app = core::getApplication();
		$this->app->setTitle('Expense');
		$model_cash = $this->getModel('cash.cash');
		$model_payment = $this->getModel('cash.payment');
		$model_payments = $this->getModel('cash.payments');
		$task=Application::$options->task;
		//echo $task;exit;
		
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}elseif(isset($_POST['id'])){
			$this->id = $_POST['id'];
		}
		if($_POST && !$this->id && $task=='edit'){
			//$id = $model->createData($_POST);
			$db = core::getDBO();
			$data=$_POST;
			$db->start();
			$data['ref_no']='expenses.expense.'.$data['expense_id'];
			$c = $model_payment->createData($data);
			//$data['expense_id'],
			$ac = $model->createData($data);
			if($c && $ac){
				$db->commit();
				$db->redirect("?com=cash&view=payments");
			}else{
				$db->rollback();
				$db->redirect("?com=expenses&view=expense&task=edit&id={$this->id}");
			}/**/
		}
		if($_POST && $this->id && $task =='edit'){
			//$model->setData($_POST);
		}
		//$this->towns = $home_model->getTowns();

		$this->stns = $model_cash->getBranchStation();
		$this->expenses_list = $model->getExpenseList();
		$this->row = $model->getDataByID($this->id);
		parent::display($tpl);
	}
}
