<?php


class Mobject{

	protected $_errors = array();

	public function __construct($properties = null){
		if ($properties !== null){
			$this->setProperties($properties);
		}
	}

	public function __toString(){
		return get_class($this);
	}

	public function redirect($location=NULL){
	  if ($location != NULL){
		if (headers_sent()){
			//echo "<script>document.location.href='" . htmlspecialchars($location) . "';</script>\n";
			echo "<script>document.location.href='" . $location . "';</script>\n";
		}
		header("Location: {$location}");
		exit;
	  }
	}

	public function def($property, $default = null){
		$value = $this->get($property, $default);
		return $this->set($property, $value);
	}

	public function get($property, $default = null){
		if (isset($this->$property)){
			return $this->$property;
		}
		return $default;
	}

	public function getProperties($public = true){
		$vars = get_object_vars($this);
		if ($public){
			foreach ($vars as $key => $value){
				if ('_' == substr($key, 0, 1)){
					unset($vars[$key]);
				}
			}
		}

		return $vars;
	}

	public function getError($i = null, $toString = true){
		// Find the error
		if ($i === null){
			// Default, return the last message
			$error = end($this->_errors);
		}
		elseif (!array_key_exists($i, $this->_errors)){
			// If $i has been specified but does not exist, return false
			return false;
		}
		else{
			$error = $this->_errors[$i];
		}
		// Check if only the string is requested
		if ($error instanceof Exception && $toString){
			return (string) $error;
		}
		return $error;
	}

	public function getErrors(){
		return $this->_errors;
	}

	public function set($property, $value = null){
		$previous = isset($this->$property) ? $this->$property : null;
		$this->$property = $value;
		return $previous;
	}

	public function setProperties($properties){
		if (is_array($properties) || is_object($properties)){
			foreach ((array) $properties as $k => $v){
				// Use the set function which might be overridden.
				$this->set($k, $v);
			}
			return true;
		}

		return false;
	}

	public function setError($error){
		array_push($this->_errors, $error);
	}
	
	public function setMessage($msg, $class="info"){
		if(isset($_SESSION[_CLIENT]['message'])){
		$key=count($_SESSION[_CLIENT]['message'])+1;
		}else{
		$key=0;
		}
		$_SESSION[_CLIENT]['message'][$key]['text'] = $msg;
		$_SESSION[_CLIENT]['message'][$key]['class'] = $class;
	}

	public function getMessage(){
		$message='';
		$count=0;
		$res = array();
		if(isset($_SESSION[_CLIENT]['message'])){
			$arr_msgs = $_SESSION[_CLIENT]['message'];
			foreach ($arr_msgs as $msg){
				$message .= '<span class="message ' . $msg['class'] . '">' .$msg['text'] . '</span>';
				$count++;
			}
			unset($_SESSION[_CLIENT]['message']);
		}
		$res['count']=$count;
		$res['messages']=$message;
		return $res;
	}

	
}
