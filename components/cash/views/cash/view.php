<?php
/**
Package: Point of sale
version: 1.0.0
URI: https://webapplics.com/apps/pos/1.0.0/docs
Author: Shafique Ahmad
Author URI: http://webapplics.com/
Description: 
copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

*/

defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class CashViewCash extends View{
	public $id=0;
	public function display($tpl = null){
		$model = $this->getModel('cash');
		$this->app = core::getApplication();
		$this->app->setTitle('Cash');
		$task=Application::$options->task;
		
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}elseif(isset($_POST['id'])){
			$this->id = $_POST['id'];
		}
		//$station_id = $model->getDefaultStation();
		$this->rows = $model->getSummery();
		//var_dump($this->rows);exit;
		parent::display($tpl);
	}
}
