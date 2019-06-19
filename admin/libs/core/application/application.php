<?php
defined('_MEXEC') or die ('Restricted Access');
//require_once 'functions.php';
//Get time zone from user profile    ------   date('Y-m-d H:i:s');
date_default_timezone_set('Asia/Karachi');
// System Check

import('core.database');
import('core.user');
class Application extends Mobject{
	public static $instance, $options, $template;
	private static $php_file_list = array();
	public $user, $u, $_com, $_script='', $_style='', $_scripts = array(), $_styles = array(), $_script_header='', $_scripts_header = array(), $_title='';
	
	public function __construct(){
		if(isset($_GET['logout']) && $_GET['logout']==1){
			$this->logout();
		}
		$this->loadOptions();
		if(!isset(self::$options->com)){
			self::$options->com = "home";
		}
		if(!isset(self::$options->view)){
			self::$options->view = self::$options->com;
		}
		if(!isset(self::$options->task)){
			self::$options->task = 'default';
		}
		if(!isset(self::$options->tmpl)){
			self::$options->tmpl = 'index';
		}
		$this->user=core::getUser();

	}
	
	public function loadOptions() {
		self::$options = new stdClass;
		$get = $_GET;
		foreach ($get as $key=>$value){
			$this->setOption($key, $value);
		}
	}

	public function getOptions() {
		return self::$options;
	}

	public function getOption($name, $default=null) {
		if(isset(self::$options->$name)){
			return self::$options->$name;
		}
		return $default;
	}
	public function setOption($key, $value=null) {
		//$old = self::$options->$key;
		self::$options->$key = $value;
		//return ;
	}

	public function setScript($txt, $default=null) {
		$this->_script= $this->_script . "\n" . $txt;
	}

	public function getScript() {
		if($this->_script){
			return $this->_script;
		}
	}


	public function setTitle($txt, $default=null) {
		$this->_title= $txt . ': by webapplics.com';
		return $this->_title;
	}

	public function getTitle() {
		if($this->_title){
			return $this->_title;
		}
		return 'webapplics.com';
	}


	public function logout(){
		$url = $this->getURI('last');
		/*session_unset();
		session_destroy();
		session_start();*/
		//unset($_SESSION[_CLIENT]);
		//echo _CLIENT . '<br>';
		if(isset($_SESSION[_CLIENT])){
			unset($_SESSION[_CLIENT]);
		}
		if(isset($_COOKIE["remember_me"])){
			setcookie ("remember_me","",0,'/');
		}
		if(isset($_COOKIE["username"])){
			setcookie ("username","",0,'/');
		}
		if(isset($_COOKIE["password"])){
			setcookie ("password","",0,'/');
		}
		//print_r($_SESSION);exit;
		$this->saveURI($url);
		$url_usr = "?com=users&view=login";
		$this->redirect($url_usr);
	}

	public static function getInstance() {
		if (empty(self::$instance[_CLIENT])){
			$app = new Application();
			self::$instance[_CLIENT] = $app;
		}
		return self::$instance[_CLIENT];
	}

	public function render(){
		$com = self::$options->com;
		$view = self::$options->view;
		$com_view = $com . '.' . $view;
		//if($com != 'user' && $view != 'login'){
		if($com_view != 'users.login'){
			$this->u = $this->user->getUser();
			$this->c = $this->user->getCompany();
		}
		$this->full_name = '';
		$this->branch_title = '';
		$this->branch_address = '';
		if(isset($this->u['full_name']) && $this->u['full_name']){
			$this->full_name = $this->u['full_name'];
		}
		if(isset($this->c['title']) && $this->c['title']){
			$this->branch_title = $this->c['title'];
		}
		if(isset($this->c['address']) && $this->c['address']){
			$this->branch_address = $this->c['address'];
		}
		if(!$this->u){
			if($com_view != 'users.login'){
				$url = '?com=users&view=login';
				$this->redirect($url);
			}
		}
		$this->loadCom();
		$this->_com = Controller::$buffer;
		$this->display(self::$options->tmpl);
	}

	public function loadPHPFile($file){
		//echo $file;
		//$self::php_file_list = $file;
		//print_r(self::$php_file_list[]);
		//check array for file....
		if (file_exists($file)) {
			require_once ($file);
		}else{
			//echo "{$file}<br/>";
			echo "File not exist<br/>" . $file;
			return false;
		}
	}

	public function loadModule($module){
		if(!$module){return false;}
		$file = ROOT_PATH . DS . 'modules' . DS . $module . DS . $module . '.php';
		
		ob_start();
		require_once $file;
		$buffer = ob_get_clean();
		return $buffer;
	}

	public function getURI($type="current"){
		if(isset($_SESSION[_CLIENT]['url'][$type])){
			return $_SESSION[_CLIENT]['url'][$type];
		}
		return false;
	}
	
	public function saveURI($url=''){
		$last='';
		//print_r($_SESSION['url']);
		if(isset($_SESSION[_CLIENT]['url']['last'])){
			$last = $_SESSION[_CLIENT]['url']['last'];
		}
		$current='';
		if(isset($_SESSION[_CLIENT]['url']['current'])){
			$current = $_SESSION[_CLIENT]['url']['current'];
		}
		if(!$url){
			$uri = explode('?',$_SERVER['REQUEST_URI']);
			$url = '?' . array_pop($uri);
			if($url=='?com=users&view=login'){
				return false;
			}
			if($current){
				if($url != $last){
					$_SESSION[_CLIENT]['url']['last'] = $_SESSION[_CLIENT]['url']['current'];
				}
			}
		}
		if($url=='?com=users&view=login'){
			return false;
		}
		$_SESSION[_CLIENT]['url']['current'] = $url;
		//print_r($_SESSION[_CLIENT]['url']);
		return $url;
	}

	public function loadCom(){
		$path = ROOT_PATH . DS . 'components' . DS . self::$options->com . DS . self::$options->com . '.php';
		$this->loadPHPFile($path);
		//echo $path;
		//load class
		$c_name = 'Controller' . ucfirst(self::$options->com);
		//echo $c_name;
		if(class_exists($c_name)){
			$controller = new $c_name();
			return $controller;
		}else{
			return false;
		}
	}
	
	public function getTemplate(){
		if(!self::$template){
			if(isset($this->u['default_template'])){
				self::$template = $this->u['default_template'];
			}else{
				self::$template = 'default';
			}
		}
		//load class
		return self::$template;
	}

	public function setTmpl($tmpl){
		self::$options->tmpl = $tmpl;
	}

	public function display($tmpl){
		$_template = $this->getTemplate();
		$path = ROOT_PATH . DS . 'templates' . DS . $_template . DS . $tmpl . '.php';
		$this->loadPHPFile($path);
		//load class
		return $path;
	}

	public function getComMenus(){
		try{
			$menus = array();
			$m = '<a href="?com=articles&view=branch_articles" title="My Items" class="list-group-item" tabindex="-1">My Items</a>';
			$m .= '<a href="?com=articles&view=articles" title="All Items" class="list-group-item" tabindex="-1">All Items</a>';
			$m .= '<a href="?com=articles&view=article&task=new" title="New Item" class="list-group-item" tabindex="-1">New Item</a>';
			$menus['articles'] = $m;
			$m = '<a href="?com=categories" title="Categories" class="list-group-item" tabindex="-1">Categories</a>';
			$menus['categories'] = $m;
			$menus['home'] = '';
			$m = '<a href="?com=messages" title="Messages" class="list-group-item" tabindex="-1">Messages</a>';
			$menus['messages'] = $m;
			$m = '<a href="?com=purchases" title="Purchases" class="list-group-item" tabindex="-1">Purchases</a>';
			$m .= '<a href="?com=purchases&view=purchase" title="Purchases" class="list-group-item" tabindex="-1">&nbsp;&nbsp;New Purchase</a>';
			$m .= '<a href="?com=purchases&view=returns" title="Purchase Return" class="list-group-item" tabindex="-1">&nbsp;&nbsp;Purchase Return</a>';
			$menus['purchases'] = $m;
			$m = '<a href="?com=sales&view=sales" title="Sale" class="list-group-item" tabindex="-1">Sales</a>';
			$m .= '<a href="?com=sales&view=pos" title="Point of Sale" class="list-group-item" tabindex="-1">&nbsp;&nbsp;Point of Sale</a>';
			$m .= '<a href="?com=sales&view=sale_return" title="Point of Sale" class="list-group-item" tabindex="-1">&nbsp;&nbsp;Sales Return</a>';
			$m .= '<a href="?com=sales&view=distributor" title="POS Distributor" class="list-group-item" tabindex="-1">&nbsp;&nbsp;POS Distributor</a>';
			$menus['sales'] = $m;
			$m = '<a href="?com=suppliers" title="Suppliers" class="list-group-item" tabindex="-1">Suppliers</a>';
			$menus['suppliers'] = $m;
			$m = '<a href="?com=users&view=profile" title="Profile" class="list-group-item" tabindex="-1">Profile</a>';
			$m .= '<a href="?com=users&view=change_pass" title="Change Password" class="list-group-item" tabindex="-1">Change Password</a>';
			$menus['user'] = $m;
			$m = '<a href="?com=customers" title="Profile" class="list-group-item" tabindex="-1">Customers</a>';
			$menus['customers'] = $m;
			//$menus['inventories'] = '';
			return $menus;
		} catch(Exception $e) {
			echo 'Message: ' .$e->getMessage();
		}finally {
			//echo "First finally.\n";
		}
	}
	
	public function getComMenu($index){
		$menus = $this->getComMenus();
		if(array_key_exists($index,$menus)){
			return $menus[$index];
		}
		return false;
	}

}

$application = new Application();
$app =& $application;
$app->saveURI();

?>
 