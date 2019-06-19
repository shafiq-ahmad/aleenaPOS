<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class CategoryViewCategories extends View{
	public $id=0;
	public $row;
	public function display($tpl = null){
		$app = Core::getApplication();
		$task = Application::$options->task;
		$models = $this->getModel('categories');
		$model = $this->getModel('category');
		if($_POST && $task=="new"){
			$model->createData($_POST);
		}
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		if($_POST){
			$model->setData($_POST);
		}
		$this->cats = $models->getParents();

		$this->row = $model->getDataByID($this->id);
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
