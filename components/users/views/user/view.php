<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class UserViewUsers extends View{
	public $id=0;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('User');
		//$model = $this->getModel('user');
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
