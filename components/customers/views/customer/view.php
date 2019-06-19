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
class CustomerViewCustomers extends View{
	public $id=0;
	public function display($tpl = null){
		$model = $this->getModel('customer');
		$this->app = core::getApplication();
		$this->app->setTitle('Add / Edit Customer');
		$home_model = $this->getModel('home.home');
		$task=Application::$options->task;
		//echo $task;exit;
		
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}elseif(isset($_POST['id'])){
			$this->id = $_POST['id'];
		}
		if($_POST && !$this->id){
			$id = $model->createData($_POST);
		}
		if($_POST && $this->id){
			$model->setData($_POST);
		}
		//$this->towns = $home_model->getTowns();

		$this->row = $model->getDataByID($this->id);
		parent::display($tpl);
	}
}
