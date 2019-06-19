<?php
defined('_MEXEC') or die ('Restricted Access');


class View {
	
	private $db;
	private $model;
	private $layout = 'default';
	
	function __construct() {}

	public function loadLayout($name = 'default'){
		global $db;
		$this->$db = $db;
		$file = 'tmpl' . DS . $name . '.php';
		if(is_file($file)){
			include $file;
		}
	}
	
	public function getLayout(){
		if($this->layout){return $this->layout;}
	}

	public function getView($name = '', $com = '', $task='default') {
		$task = Request::getVar('task', '');
		$app = Core::getApplication();
		$options = $app->getOptions();
		if(!$com){
			$com = $options->com;
		}
		if(!$name){
			$name = $options->view;
		}
		$this->_com=$com;
		$this->_view=$name;
		$this->_task=$task;
		//$file = BASE_PATH . DS . 'components' . DS . $com  . DS . 'views' . DS . $name . DS . $options->task . '.php';
		$file = BASE_PATH . DS . 'components' . DS . $com . DS . 'views' . DS . $name . DS . 'view.php';
		if (file_exists($file)){
			require_once $file;
		}
		$class_name = ucfirst($name) . 'View' . ucfirst($options->com);
		//echo $class_name;exit;
		//echo $file . '<br>';
		if(class_exists($class_name)){
			$obj = new $class_name();
			return $obj;
		}
		return false;
	}

	public function loadTemplate($params){
		//if(!$params){return false;}
		$app = Core::getApplication();
		//echo $name . ': ' . count($parts) .  '<br/>';
		//print_r($parts);exit;
		$com = Application::$options->com;
		$view = Application::$options->view;
		$task = Application::$options->task;
		if(is_array($params)){
			if(isset($params['com'])){
				$com = $params['com'];
			}
			if(isset($params['view'])){
				$view = $params['view'];
			}
			if(isset($params['task'])){
				$task = $params['task'];
			}
			$path = ROOT_PATH . DS . 'components' . DS . $com . DS . 'views' . DS . $view . DS . 'tmpl' . DS;
		}elseif($params){
			$task = $params;
			$path = ROOT_PATH . DS . 'components' . DS . $com . DS . 'views' . DS . $view . DS . 'tmpl' . DS;
		}else{
			if(isset($this->_com)){
				$com=$this->_com;
			}
			if(isset($this->_view)){
				$view=$this->_view;
			}
			if(isset($this->_task)){
				$task=$this->_task;
			}
			$path = ROOT_PATH . DS . 'components' . DS . $com . DS . 'views' . DS . $view . DS . 'tmpl' . DS;
			//echo $path;
		}
		$path .= $task . '.php';
		//echo $path.'<br/>';
		ob_start();
		require_once $path;
		$buffer = ob_get_clean();
		return $buffer;
	}
	
	public function assignRef($key, &$val){
		if (is_string($key) && substr($key, 0, 1) != '_'){
			$this->$key = &$val;
			return true;
		}

		return false;
	}
	public function display($tpl = null){
		$result = $this->loadTemplate($tpl);
		if ($result instanceof Exception)
		{
			return $result;
		}

		echo $result;
	}
	
	public function get($property, $default = null)	{
		$method = 'get' . ucfirst($property);
		$model = $this->getModel($default);
		//if (method_exists($model, $method))
		$result = $model->$method();
		return $result;
	}

	public function getModel($name){
		if(!$name){return false;}
		$app = Core::getApplication();
		$parts = explode('.',$name);
		$num = count($parts);
		if($num==2){
			$com_name = $parts[0];
			$model_name = $parts[1];
			$path = ROOT_PATH . DS . 'components' . DS . $com_name . DS . 'models' . DS . $model_name . '.php';
		}elseif($num==1){
			$model_name = $name;
			$path = ROOT_PATH . DS . 'components' . DS . Application::$options->com . DS . 'models' . DS . $name . '.php';
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
	
	public static function getHelper($name = '') {
		//if(empty($name)){$name = "";}
		$helperClass = ucfirst($name) . 'Helper';
		//$helperClass = $classPrefix . ucfirst($name);
		$path = BASE_PATH . DS . 'components' . DS . Controller::$options['component'] . DS . 'helpers' ;
		if ($name!=""){
			$file = $path . DS . $name . '.php';
		}else{
			$file = $path . '.php';
		}
		//echo $helperClass . '<br />' . $file;
		if (!class_exists($helperClass)) {
			if (is_file($file)) {
				require_once $file;
			}
		}
		if(class_exists($helperClass)){
			$helper = new $helperClass();
			return $helper;
		}
		return false;
		
	}


	public function getPaginationList() {
		//$db = Core::getDBO();
		$list = Database::$pagination_list;
		if($list){
			return $list;
		}
		return false;
		
	}

}


?>