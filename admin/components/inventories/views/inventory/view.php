<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class InventoryViewInventories extends View{
	public $id=0;
	public function display($tpl = null){
		$models = $this->getModel('inventories');
		$model = $this->getModel('inventory');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		$task='';
		if(isset($_GET['task'])){
			$task = $_GET['task'];
		}
		if(isset($_POST['inv_id']) && $_POST['inv_id']){
			$this->inv_id = $_POST['inv_id'];
		}
		if($_POST){
			$form_type="";
			if(isset($_POST['form_type'])){
				$form_type=$_POST['form_type'];
			}
			if($this->id!==0 && $form_type == 'inventory_main'){
				$model->updateInventory($_POST);
				$app = core::getApplication();
				$app->redirect('?com=inventories&view=inventory&id='.$this->id);
			}
			if(!$this->id && $form_type == 'inventory_main'){
				$this->id = $model->createInventory($_POST);
				$app = core::getApplication();
				$app->redirect('?com=inventories&view=inventory&id='.$this->id);
			}
		}
		
		$inv_done=0;
		if($task=='adjust'){
			$inv_done=1;
		}
		
		if($_POST && $_GET['part']=="saveInventoryArt"){
			//print_r($_POST);exit;
			echo $this->inv_id;exit;
			$m = $models->saveInventoryArt($_POST);
			$this->pur_arts = $model->getInventoryArticles($this->inv_id,$inv_done);
		}
		if($_POST && $_GET['part']=="remInvItem"){
			$m = $models->remInvItem($_POST);
			$this->pur_arts = $model->getInventoryArticles($this->inv_id,$inv_done);
		}
		if($_POST && $_GET['part']=="saveInvItem"){
			//echo $_GET['part'];
			$m = $models->saveInvItem($_POST);
			echo $m;
		}
		if($_POST && $_GET['part']=="adjustInvItem"){
			//echo $_GET['part'];
			$m = $models->adjustInvItem($_POST);
			echo $m;
		}
		if($this->id>0){
			$this->pur_arts = $model->getInventoryArticles($this->id,$inv_done);
			$this->row = $model->getInventoryByID($this->id);
			if($this->row['inv_status']=='Done'){
				$tpl='compare_inv_stock';
			}elseif($this->row['inv_status']=='Closed'){
				$tpl='closed';
			}
		}
		parent::display($tpl);
	}
}
