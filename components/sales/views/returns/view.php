<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class ReturnsViewSales extends View{
	public $id=0;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Sales Return');
		$model = $this->getModel('returns');
		$this->rows = $model->getBranchReturns();
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
