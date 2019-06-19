<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class Stock_compareViewArticles extends View{
	public $id;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Item Stock compare');
		$model = $this->getModel('stock_compare');
		$m_cat = $this->getModel('categories.categories');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
			$this->rows = $model->getData($this->id);
		}
		
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
