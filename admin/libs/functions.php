<?php
defined('_MEXEC') or die ('Restricted Access');


function redirect_( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

	
function import($key, $base = null) {
	// Setup some variables.
	$parts = explode('.', $key);
	$file_name = array_pop($parts);
	
	
	//$base = (!empty($base)) ? $base : ADMIN_PATH;
	$path = str_replace('.', DS, $key);
	//$class = ucfirst($file_name);

	if (strpos($path, 'core') === 0) {
		$file = ADMIN_PATH . DS . 'libs' . DS . $path . DS . $file_name . '.php';
		if (!is_file($file)) {
			$file = ADMIN_PATH . DS . 'libs' . DS . $path . '.php';		
		}
		if (is_file($file)) {
			require_once $file;
			return true;
		}
	}else{
		$file = ADMIN_PATH . DS . $path . DS . $file_name . '.php';
		if (!is_file($file)) {
			$file = ADMIN_PATH . DS . $path . '.php';		
		}
		if (is_file($file)) {
			require_once $file;
			return true;
		}
	}
	//if (class_exists($class)) { return; }

}


?>