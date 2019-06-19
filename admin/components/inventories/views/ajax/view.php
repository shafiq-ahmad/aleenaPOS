<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class AjaxViewInventories extends View{
	public $id,$inv_id;
	public function display($tpl = null){
		$models = $this->getModel('inventories');
		$model = $this->getModel('inventory');
		$list = array();
		$list['view']='inventory';
		$list['task']='_inv_art_list';
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		if(isset($_POST['inv_id']) && $_POST['inv_id']){
			$this->inv_id = $_POST['inv_id'];
		}
		if(isset($_POST['id']) && $_POST['id']){
			$this->id = $_POST['id'];
		}
		if($_POST && $_GET['part']=="saveInventoryArt"){
			$view = $this->getView('inventory', 'inventories', '_inv_art_list');
			echo $view->display($list);
		}
		if($_POST && $_GET['part']=="remInvItem"){
			$view = $this->getView('inventory', 'inventories', '_inv_art_list');
			echo $view->display($list);
		}
		if($_POST && $_GET['part']=="saveInvItem"){
			$view = $this->getView('inventory', 'inventories', '_inv_art_list');
			echo $view->display($list);
		}
		if($_POST && $_GET['part']=="adjustInvItem"){
			$view = $this->getView('inventory', 'inventories', '_inv_art_adj_list');
			echo $view->display($list);
		}
		if ($_GET['part']=='itemByID'){
			$m_arts = $this->getModel('articles.article');
			$sub = $m_arts->getArticleByID($_POST['filter_text']);
			echo json_encode($sub);
		}
		//parent::display($tpl);
	}
}
