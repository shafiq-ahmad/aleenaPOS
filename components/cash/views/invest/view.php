<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class InvestViewCash extends View{
	public $id=0;
	public function display($tpl = null){
		$model = $this->getModel('receipt');
		$this->app = core::getApplication();
		$this->app->setTitle('Customer\'s payments');
		$home_model = $this->getModel('home.home');
		$task=Application::$options->task;
		//echo $task;exit;
		
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}elseif(isset($_POST['id'])){
			$this->id = $_POST['id'];
		}
		if($_POST && !$this->id && $task=='edit'){
			$id = $model->createData($_POST);
		}
		if($_POST && $this->id && $task =='edit'){
			$model->setData($_POST);
		}
		$this->towns = $home_model->getTowns();

		//$this->row = $model->getDataByID($this->id);
		parent::display($tpl);
	}
}
