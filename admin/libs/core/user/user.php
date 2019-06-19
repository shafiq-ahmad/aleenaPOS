<?php
defined('_MEXEC') or die ('Restricted Access');

class User{

	protected static $db_fields = array('id', 'user_name', 'name', 'user_pass');
	public $user;
	private $company, $packages;
	private static $instance, $_privs=array();
	public function authenticate($username="", $pass="",$silent=null ) {
		$db=core::getDBO();
		$app=core::getApplication();
		//$username = $db->escape_value($username);
		//$password = $db->escape_value($pass);
		$pass = addslashes($pass);
		$password=self::hash_password($pass);
		if(!class_exists('View')){
			import('core.application.component.view');
		}
		$view_obj = new View();
		$u_model=$view_obj->getModel('users.user');
		$usr = $u_model->validate_user($username, $password);
		//use count($user)=1 function to find if variable row=1
		//print_r($usr);exit;
		if($usr){
			$this->user = $usr;
			$_SESSION[_CLIENT]['user'] = $usr; //un comment this code for production
		}else{
			$msg = "Invalid Login Name or Password";
			$app->setMessage($msg);
			$url_usr = "?com=users&view=login";
			$app->redirect($url_usr);
		}
		
		$company = $this->getCompanyBranch($this->user);
		//return !empty($this->user) ? array_shift($this->user) : false;
		$url = $app->getURI();
		if($url){
			$url_usr = $url;
		}else{
			$url_usr = "?com=home";
		}
		//$remember_user='';
		//if(isset($_COOKIE["username"])){$remember_user = $_COOKIE["username"];}
		
		$days = time() + (60*60*24*6);
		if(isset($_POST['remember_me'])){
			setcookie('remember_me', 1, $days,'/');
			setcookie('username', $username, $days,'/');
			setcookie('password', $pass, $days,'/');
		}elseif(!isset($_POST['remember_me'])){
			if(isset($_COOKIE["username"])){
				//setcookie ("username","");
			}
			if(isset($_COOKIE["password"])){
				//setcookie ("password","");
			}
		}

		if(!$silent){
			$app->redirect($url_usr);
		}
		return !empty($this->user) ? $this->user : false;
	}

	public static function hash_password($pass='') {
		if (!$pass){
			return false;
		}
		//$hash = hash('sha256',$pass); // sha1,sha256,sha384,sha512
		//$hash = password_hash('abc123',PASSWORD_DEFAULT);
		$hash = md5($pass);
		return $hash;
	}

	public static function getInstance() {
		if (empty(self::$instance)){
			$user = new User();
			self::$instance = $user;
		}
		return self::$instance;
	}

	private function getCompanyBranch($user){
		$db = core::getDBO();
		$view_obj = new View();
		$u_model=$view_obj->getModel('users.user');
		$row = $u_model->get_company_by_id();
		if ($row) {
			$this->company = $row;
			$_SESSION[_CLIENT]['company'] = $row; // un comment this code for developement version
			return true;
		}else{
			return false;
		}
	}

	public function getPrivs($user=null){
		if(!$user){
			$user = $this->getUser();
		}
		$user_id = $user['user_id'];
		if(isset(self::$_privs[$user_id])){
			return self::$_privs[$user_id];
		}
		
		
		$db = core::getDBO();
		if(!class_exists('View')){
			import('core.application.component.view');
		}
		$view_obj = new View();
		$u_model=$view_obj->getModel('users.user');
		$row = $u_model->getUserPrivileges($user);
		if ($row) {
			self::$_privs[$user_id] = $row;
			return self::$_privs[$user_id];
		}else{
			return false;
		}
	}

	public function hasPriv($priv, $privs=null,$regex=false){
		if(!$privs){
			$privs = $this->getPrivs();
		}
		$arr_col = array_column($privs,'privilege_alias');
		if(!$regex){
			$aus = array_search($priv, $arr_col);
			if($aus || $aus===0){
				return ($privs[$aus]);
			}
		}else{
			//preg_match_all() //array function Perform a global regular expression match
			//$matches  = preg_grep('/^' . $priv . '/i', $arr_col);
			$matches  = preg_grep("/^{$priv}/i", $arr_col);
			return $matches;
			
		}
		return false;
	}

	public function pageAccess($req_power){
		$user = $this->getUser();
		$acl = $user['acl'];
		
		//$acl = decbin(2); // + decbin(4);
		$calc_power = $acl & $req_power;
		/*echo $acl . ' . ';
		echo $req_power . ' . ';
		echo $calc_power;*/
		if($req_power === $calc_power){
			return true;
		}else{
			return false;
		}
	}

	public function getUser(){
		$app=core::getApplication();
		if($this->user){
			return $this->user;
		}elseif(isset($_SESSION[_CLIENT]['user']) && $_SESSION[_CLIENT]['user']){
			return $_SESSION[_CLIENT]['user'];
		}elseif(isset($_COOKIE["username"]) && isset($_COOKIE["password"])){
			$res = $this->authenticate($_COOKIE["username"],$_COOKIE["password"],true);
			if($res){
				return $res;
			}else{
				$url_usr = "?com=users&view=login";
				$app->redirect($url_usr);
			}
			return false;
		}else{
			if(isset($_GET['com']) && $_GET['com']!='users' && isset($_GET['view']) && $_GET['view']!='login'){
				$url_usr = "?com=users&view=login";
				$app->redirect($url_usr);
			}
			return false;
		}
	}

	public function getCompany(){
		if($this->company){
			return $this->company;
		}elseif(isset($_SESSION[_CLIENT]['company']) && $_SESSION[_CLIENT]['company']){
			return $_SESSION[_CLIENT]['company'];
		}else{
			return false;
		}
	}

	public function getUserIdByLoginName($user_name){
		global $db;
		$sql  = "SELECT id FROM users WHERE user_name = '{$user_name}' LIMIT 1 ";
		$row = $db->get_by_sql($sql);
		//print_r($row);
		if ($row) {
			return $row;
		}else{
			return false;
		}
	}


	public function findLoginName($user_name){
		global $db;
		$sql  = "SELECT * FROM users WHERE user_name = '{$user_name}' LIMIT 1 ";
		return $db->get_by_sql($sql);
	}
		
	public function findEmail($email){
		global $db;
		$sql  = "SELECT * FROM users WHERE e_mail = '{$email}' LIMIT 1 ";
		return $db->get_by_sql($sql);
	}
	
	public function validateUser($user_name, $email){
		$msg='';
		if($this->findLoginName($user_name)){$msg .= 'Login name already exist, please try another one. <br />';}
		if($this->findEmail($email)){$msg .= 'E-mail ID already exist, please try another one. <br />';}
		return $msg;
	}

	
}


$user = new User();

