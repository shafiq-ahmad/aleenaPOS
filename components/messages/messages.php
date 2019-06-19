<?php
defined('_MEXEC') or die ('Restricted Access');


import('core.application.component.controller');
class ControllerMessages extends Controller{

	function __construct(){
		$app=core::getApplication();
		$this->user = core::getUser();
		$priv=$this->user->hasPriv('messages',null,true);
		if($priv){
			$this->view = $this->getView();
			
			$this->view->priv=$priv;
			$this->view->priv_delete=$this->user->hasPriv('messages.delete');
			//$app->setTmpl('adminlte');
			parent::display();
		}else{
			Controller::$buffer = '<h3>No privilages, please contact admistrator!</h3>';
		}
	}
	
}
 
