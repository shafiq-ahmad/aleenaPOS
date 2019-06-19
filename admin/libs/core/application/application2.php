<?php


class Application {
	//Vars
	private static $instance = array();
	protected $template = array();
	protected $db;
	public $buffer;
	
	function __construct() {
		global $db;
		$this->db=$db;
		$this->loadOptions();
		$this->loadTemplates();
	}

	public function getViewName($default=null) {
		if(isset($this->options->view)){
			return $this->options->view;
		}elseif(isset($this->options->option)){
			return $this->options->option;
		}
		return $default;
	}

	public function loadTemplates() {
		global $settings;
		$this->template[1] = $settings->get_template('admin');
		$this->template[0] = $settings->get_template();
	}

	public function getTemplate($client=null, $default=0) {
		global $settings;
		if($client){
			return $this->template[$client];
		}
		return $this->template[$default];
	}

	public function includeModule($name){
		global $db;
		$sql = "SELECT * FROM modules WHERE position='{$name}' AND published = 1 ORDER BY ordering, id ";
		$position_modules = $db->loadObjectList($sql);
		if ($position_modules) {
			foreach ($position_modules as $mod) {
				echo '<div class="module" >';
				if ($mod->show_title==1){
					echo '<h3 class="module-title" >' . $mod->title . '</h3>';
				}
				include(BASE_PATH . DS . 'modules' . DS . $mod->module . DS . $mod->module . '.php');	
				echo '</div>';
			}
		}
	}

	public function includeComponent(){
		if(!isset($this->options->option)){
			$this->options->option='content';
		}
		import("components.{$this->options->option}");
	
		//$app = Core::getApplication();
		echo $this->buffer;
	}


	public function includeHead(){
		$doc = Core::getDocument();
		echo $doc->getHead();
	}

	public function addLastVisitedLink(){
		global $session;
		$url = $session->last_url();
		$ar = array();
		$ar = explode('?', $url);
		// if url contain ? then do following ... otherwise return blank query string
		$query = array_pop($ar);
		$last_url = $query;
		
		echo "<a onclick=\"return getPage('{$last_url}');\" href=\"index.php?{$last_url}\" class=\"go-back\" >Go Back</a>";
	}
	
	public function redirect($url) {
		if (headers_sent()) {
			//echo "<script>document.location.href='" . htmlspecialchars($url) . "';</script>\n";
			echo "<script>document.location.href='" . $url . "';</script>\n";
		}
		else {
			header("Location: {$url}");
		}
		exit;
	}
	
	public function isAdmin(){
		return ($this->client->id == 1);
	}
	
	public function isSite(){
		return ($this->client->id == 0);
	}
	
	public function getClientId(){
		return $this->client->id;
	}

	
}


?>