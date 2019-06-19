<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class MessagesViewMessages extends View{
	public $id=0;
	public function display($tpl = null){
		$model = $this->getModel('messages');
		$this->app = core::getApplication();
		$this->app->setTitle('Messages');
		$this->rows = $model->getUserMessages();
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
