<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class ReceiptViewCustomers extends View{
	public $id=0;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Customer\'s payments');
		$task=Application::$options->task;
		//echo $task;exit;
		
		parent::display($tpl);
	}
}
