<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class Items_reportViewSales extends View{
	public $id=0;
	public $report_type="items";
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Sale (Item wise report)');
		$model = $this->getModel('items_report');
		$this->rows = $model->getBranchSalesByItems();
		$this->task = Application::$options->task;
		//$this->rows = $model->getBranchSalesArticles();
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
