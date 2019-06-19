<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class View_returnViewSales extends View{
	public $id=0;
	public function display($tpl = null){
		$model = $this->getModel('view_return');
		$this->app = core::getApplication();
		$this->app->setTitle('View Return');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		$this->rows = $model->getReturnInvoiceArticles($this->id);
		$this->inv = $model->getReturnInvoice($this->id);
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
