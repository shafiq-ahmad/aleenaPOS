<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class Expiry_alertsViewArticles extends View{
	public $id, $row;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Items Expiry alerts');
		$model = $this->getModel('branch_articles');
		$this->rows = $model->getArtsExpiry();
		//var_dump($this->rows);exit;

		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
