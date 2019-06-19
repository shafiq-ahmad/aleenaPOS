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
class Stock_alertsViewArticles extends View{
	public $id, $row;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Low stock alerts');
		$model = $this->getModel('branch_articles');
		$model2 = $this->getModel('article');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		if($this->id && $_POST){
			$model2->setData($_POST);
		}elseif($_POST){
			$res = $model2->createData($_POST);
			if($res){
				redirect('?com=articles&view=articles');
			}
		}
		$this->rows = $model->getBranchStockAlerts();

		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
