<?php
defined('_MEXEC') or die ('Restricted Access');


import('core.env');
import('core.application.component.model');
//import('core.application.component.view');
class Controller {
	
	private $db;
	private static $instance;
	private $default_view;
	private $message;
	private $redirect = null;
	private $messageType;
	public static $buffer;
	
	public function display() {
		ob_start();
		if(!isset($this->view) || !$this->view){
			$this->view = $this->getView();
		}
		// Display the view
		$this->view->display();
		self::$buffer = ob_get_clean();
		return self::$buffer;
	}
	
	function getModel($name){
		if(!$name){return false;}
		$app = Core::getApplication();
		$parts = explode('.',$name);
		$num = count($parts);
		if($num==2){
			$com_name = $parts[0];
			$model_name = $parts[1];
			$path = BASE_PATH . DS . 'components' . DS . $com_name . DS . 'models' . DS . $model_name . '.php';
		}elseif($num==1){
			$model_name = $name;
			$path = BASE_PATH . DS . 'components' . DS . Application::$options->com . DS . 'models' . DS . $name . '.php';
		}
		$app->loadPHPFile($path);
		//load class
		$m_name = 'Model' . $model_name;
		if(class_exists($m_name)){
			$model = new $m_name();
			return $model;
		}else{
			return false;
		}
	}
	
	public function execute($task='display'){
		if (strpos($task, '.') !== false){
			$ar = array();
			$ar = explode('.', $task);
			$task = array_pop($ar);
		}
		$task = strtolower($task);
		$this->$task();
	}

	public function getView($name = '', $com = '', $layout='default') {
		$task = Request::getVar('task', '');
		$app = Core::getApplication();
		$options = $app->getOptions();
		if(!$com){
			$com = $options->com;
		}
		if(!$name){
			$name = $options->view;
		}
		//$file = BASE_PATH . DS . 'components' . DS . $com  . DS . 'views' . DS . $name . DS . $options->task . '.php';
		$file = BASE_PATH . DS . 'components' . DS . $com . DS . 'views' . DS . $name . DS . 'view.php';
		if (file_exists($file)) {
			require_once $file;
		}
		$class_name = ucfirst($name) . 'View' . ucfirst($options->com);
		//echo $class_name;exit;
		if(class_exists($class_name)){
			$obj = new $class_name();
			return $obj;
		}
		return false;
	}
	
	
}

