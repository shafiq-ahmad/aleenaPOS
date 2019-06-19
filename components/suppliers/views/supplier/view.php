<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class SupplierViewSuppliers extends View{
	public $id=0;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Add / Edit Supplier');
		$model = $this->getModel('supplier');
		$this->m = $this->getModel('categories.categories');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		if($_POST && !$this->id){
			$this->id = $model->createData($_POST);
		}
		if($_POST && $this->id!==0){
			$model->setData($_POST);
		}
		$this->row = $model->getDataByID($this->id);
		$this->items = $model->getArticles($this->id);

		parent::display($tpl);
	}
}
