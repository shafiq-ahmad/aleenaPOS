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
class LedgerViewSuppliers extends View{
	public $id=0;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Supplier Payments');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		$model = $this->getModel('suppliers.supplier');
		$model_ledger = $this->getModel('ledger');
		$this->row = $model->getDataByID($this->id);
		$this->rows = $model_ledger->getLedger($this->id);
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
