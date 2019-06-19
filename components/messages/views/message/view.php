<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class MessageViewMessages extends View{
	public $id=0;
	public function display($tpl = null){
		$model = $this->getModel('message');
		$this->app = core::getApplication();
		$this->app->setTitle('View Message');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		$this->row = $model->getDataByID($this->id);
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
