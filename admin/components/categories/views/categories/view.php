<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class CategoriesViewCategories extends View{
	public $id=0;
	public function display($tpl = null){
		$model = $this->getModel('categories');
		$this->rows = $model->getChilds();
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		if(isset($rows[0]['id']) && !$this->id){
			$this->id = $rows[0]['id'];
		}
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
