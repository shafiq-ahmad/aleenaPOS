<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class InventoryViewInventories extends View{
	public $id=0;
	public function display($tpl = null){
		$models = $this->getModel('inventories');
		$model = $this->getModel('inventory');
		$this->app = core::getApplication();
		$this->app->setTitle('Inventory');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		$task='';
		if(isset($_GET['task'])){
			$task = $_GET['task'];
		}

		if(isset($_POST['id']) && $_POST['id']){
			$this->id = $_POST['id'];
		}

		$inv_done=0;
		if($task=='adjust'){
			$inv_done=1;
		}

		if($_POST && $_GET['part']=="saveInventoryArt"){
			//echo $this->inv_id;exit;
			$m = $models->saveInventoryArt($_POST);
			$this->pur_arts = $model->getInventoryArticles($this->inv_id,$inv_done);
		}
		if($_POST && $_GET['part']=="remInvItem"){
			$m = $models->remInvItem($_POST);
			$this->pur_arts = $model->getInventoryArticles($this->inv_id,$inv_done);
		}
		if($_POST && $_GET['part']=="saveInvItem"){
			$m = $models->saveInvItem($_POST);
			echo $m;
		}
		if($_POST && $_GET['part']=="adjustInvItem"){
			$m = $models->adjustInvItem($_POST);
			echo $m;
		}
		if($this->id>0){
			$this->pur_arts = $model->getInventoryArticles($this->id,$inv_done);
			$this->row = $models->getBranchInventories($this->id);
			//$tpl='compare_inv_stock';
		}
		parent::display($tpl);
	}
}
