<?php
defined('_MEXEC') or die ('Restricted Access');


class Model extends Mobject{
	private $db;
	
	function __construct() {
		$this->db = Core::getDBO();
	}

	public function publishedList() {
		$arr=array();
		$arr[0]='No';
		$arr[1]='Yes';
		return $arr;
	}
	public function getGroups(){
		$user=Core::getUser();
		$u=$user->getUser();
		$db=Core::getDBO();
		$sql = "SELECT ug.* FROM user_groups AS ug ";
		$sql .= "WHERE group_id <= {$u['group_id']} ";
		//echo $sql;exit;
		$usr = $db->get_by_sqlRows($sql);
		return $usr;
	}
	
	public function getPrivileges(){
		$user=Core::getUser();
		$u=$user->getUser();
		$db=Core::getDBO();
		$sql = "SELECT up.* FROM user_privileges AS up ";
		//code to show only components allow to company
		/*$sql .= "WHERE id IN ( ";
		$sql .= " ";
		$sql .= " )";*/
		//echo $sql;exit;
		$usr = $db->get_by_sqlRows($sql);
		return $usr;
	}
	
	public function getUserPrivileges($u=null){
		if(!$u){
			$u = Core::getUser()->getUser();
		}
		$db=Core::getDBO();
		$sql = "SELECT up.*, CONCAT(up.com, '.', up.privilege_name) AS privilege_alias FROM user_privileges AS up ";
		$sql .= "WHERE id IN ({$u['privileges']})";
		//code to show only components allow to company
		/*$sql .= "WHERE id IN ( ";
		$sql .= " ";
		$sql .= " )";*/
		//echo $sql;exit;
		$usr = $db->get_by_sqlRows($sql);
		return $usr;
	}
	
	public static function getModel($name){
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
	


		
}

