<?php
defined('_MEXEC') or die ('Restricted Access');


class Filesystem {
	
	private static $instance;

	function __construct() {}

  	public static function getInstance() {
		if (empty(self::$instance)){
			import('core.filesystem');
			$fs = new Filesystem();
			self::$instance = $fs;
		}
		return self::$instance;
	}
	
	
  	public static function newFile($filename, $path='.') {
		//if(!$path){}
		$file = $path . DS . $filename;
		$fileH = fopen($file, "x+") or die("Unable to open file!");
		//echo fread($fileH,filesize($file));
		fclose($fileH);
		
	}
	
	
}


