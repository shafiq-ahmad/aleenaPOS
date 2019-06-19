<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class ReceiptsViewCash extends View{
	public $id=0;
	public function display($tpl = null){
		$model = $this->getModel('receipts');
		$this->app = core::getApplication();
		$this->app->setTitle('Cash receipts');
		$this->rows = $model->getData();
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		if(!$this->id && isset($rows[0]['id']) ){
			$this->id = $rows[0]['id'];
		}
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
