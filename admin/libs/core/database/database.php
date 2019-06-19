<?php
defined('_MEXEC') or die ('Restricted Access');

require_once ADMIN_PATH . DS . 'constants.php';
require_once 'helper.php';
//use Illuminate\Database\Capsule\Manager as Capsule;

class Database extends Mobject{

	private $connection;
	public $last_query, $current_page;
	private $magic_quotes_active;
	private static $instance;
	private $_page, $_per_page;
	//private $real_escape_string_exists;
	
  function __construct() {
    $this->open_connection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
		//$this->real_escape_string_exists = function_exists( "mysql_real_escape_string" );
  }

	public function open_connection() {
		$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		
		if(mysqli_connect_errno()){
			if(mysqli_connect_errno()==1049){
				require_once 'installer.php';
				$app=core::getApplication();
				$url = "?com=home";
				$app->redirect($url);
				
			}else{
				echo "Failed to connect to MySQL " . mysqli_connect_error();
			}
			exit;
		}
		//if (!$this->connection) {
		if ($this->connection->connect_error) {
			die("Database connection failed: " . mysqli_error());
		} else {
			/*$db_select = mysqli_select_db(DB_NAME, $this->connection);
			if (!$db_select) {
				die("Database selection failed: " . mysqli_error());
			} */
		}
	}

	public static function getInstance() {
		if (empty(self::$instance)){
			$db = new Database();
			self::$instance = $db;
		}
		return self::$instance;
	}

	public function close_connection() {
		if(isset($this->connection)) {
			mysqli_close($this->connection);
			unset($this->connection);
		}
	}

	public function getCurrentDate($type = 'datetime') {
		$mysql_datetime='';
		if($type == 'datetime'){
			$mysql_datetime = strftime("%Y-%m-%d %H:%M:%S", time());
		}elseif($type == 'date'){
			$mysql_datetime = strftime("%Y-%m-%d", time());
		}
		return $mysql_datetime;
	}

	public function toDBDateTime($date) {
		$mysql_datetime = strftime("%Y-%m-%d %H:%M:%S", strtotime($date));
		return $mysql_datetime;
	}

	public function toDBDate($date) {
		$mysql_datetime = strftime("%Y-%m-%d", strtotime($date));
		return $mysql_datetime;
	}

	public function query($sql) {
		$this->last_query = $sql;
		//echo $sql . '<br /><br />';
		$result = mysqli_query($this->connection, $sql);
		$this->confirm_query($result);
		return $result;
	}
	
	public function escape_value2($value) {
		if( $this->real_escape_string_exists ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $this->magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$this->magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}
	
	// "database-neutral" methods
  public function fetch_array($result_set) {
    //return mysqli_fetch_array($result_set);
    //return $result_set->fetch_assoc();
    return mysqli_fetch_assoc($result_set);
  }
  
  public function num_rows($result_set) {
   return mysqli_num_rows($result_set);
  }
  
  public function insert_id() {
    // get the last id inserted over the current db connection
    return mysqli_insert_id($this->connection);
  }
  
  public function affected_rows() {
    return mysqli_affected_rows($this->connection);
  }

	private function confirm_query($result) {
		if (!$result) {
		global $u;
	    //$output = "Database query failed: " . mysqli_error($this->connection) . "<br /><br />";
	    //Comment following statment for production
		$output = "Last SQL query: " . $this->last_query . '<br/>';
		$output .= "Error#: " . mysqli_errno($this->connection) . '<br/>';
		$output .= "Desc: " . mysqli_error($this->connection) . '<br/>';
		
		$user_id=$u['user_id'];
		$sql = "INSERT INTO debug_log ";
		$sql .= "(log_type,log_data,user_id,err) VALUES ( ";
		$sql .= "'DB_ERROR', ";
		$sql .= "'{$output}', ";
		$sql .= "'{$user_id}', ";
		$sql .= "'' ";
		$sql .= ")";
		//echo $sql;exit;
		mysqli_query($this->connection, $sql);
		//die( "Database Err: " . mysqli_error($this->connection) );
		die($output);
		}
	}
	
	public function get_by_sqlRows($sql="") {
		$result_set = $this->query($sql);
		$list = array();
		if($result_set){
			/*while ($row = $this->fetch_array($result_set)) {
				$list[] = $row;
				for ($i=0; $i < mysql_num_fields($res); $i++) {
					$info = mysql_fetch_field($res, $i);
					$type = $info->type;
					
				// cast for real
				if ($type == 'real')
					$row[$info->name] = doubleval($row[$info->name]);
				// cast for int
				if ($type == 'int')
					$row[$info->name] = intval($row[$info->name]);
				}
				
			}*/
			$list = $result_set->fetch_all(MYSQLI_ASSOC);
			return $list;
		}
		return false;
	}
	
	public function autocommit($val=1){
		$this->query("SET AUTOCOMMIT = {$val};");
		return true;
	}

	public function start(){
		$this->query('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO"');
		$this->query('SET AUTOCOMMIT = 0;');
		$this->query('START TRANSACTION;');
	}

	public function commit(){
		$this->query('COMMIT;');
		$this->query('SET AUTOCOMMIT = 1;');
	}

	public function rollback($txt=""){
		$this->query('ROLLBACK;');
		$this->query('SET AUTOCOMMIT = 1;');
	}

	public function get_by_sqlJSON($sql="") {
		$result_set = $this->query($sql);
		$list = array();
		$list = $result_set->fetch_all(MYSQLI_ASSOC);
		$json = '';
		$json = json_encode($list);
		return $json;
	}
	
	public function get_by_sqlRow($sql="") {
		$result_set = $this->query($sql);
		$list = array();
		if($result_set){
			//while ($row = $this->fetch_array($result_set)) {
				$list = $this->fetch_array($result_set);
			//}
			return $list;
		}
		return false;
	}
	
	public function insert_by_sql($sql="") {
		if($this->query($sql)) {
			//$this->id = $this->insert_id();
			return $this->affected_rows();
		} else {
			return false;
		}
		
	}
	
	public function update_by_sql($sql="") {
		global $messages;
		$this->query($sql);
		$affected_row=$this->affected_rows();
		$messages[] = $affected_row . ' Rows effected.';
		if ($affected_row >= 1){return true; }else{return false; }
		//return ($this->affected_rows() >= 1) ? true : false;
	}

	public function delete_by_sql($sql="") {
		$this->query($sql);
		return ($this->affected_rows() >= 1) ? true : false;
	}

	public function update_by_form($id=0, $table_name, $post, $element_name='') {
		global $messages;
		if($element_name==''){
			$element_name=$table_name;
		}
		$element_name = ucfirst($element_name);
		$attributes = $this->validate_form($post);
		$result = array();
		foreach ($attributes as $key => $value){
				$result[] = "{$key} = {$value}";
		}
		$sql="UPDATE {$table_name} SET ";
		$sql .= join(', ', $result);
		$sql .= " WHERE id={$id}";
		$this->query($sql);
		$affected_row=$this->affected_rows();
	}

	public function validate_form($form) {
		global $messages;
		$attributes = array();
		foreach ($form as $key => $value){
			$char = substr($key,0,1);
			if ($char != '_'){
				//$attributes[$key] = "'{$this->escape_value($value)}'";
				$attributes[$key] = "'{$value}'";
			}
		}
		return $attributes;
	}
		
}

$database = new Database();
$db =& $database;


//require_once 'tables.php';

?>