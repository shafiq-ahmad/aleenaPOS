<?php
defined('_MEXEC') or die ('Restricted Access');
//spl_autoload_register(function ($class_name) {include $class_name . DS . $class_name . '.php';});


class Core {
	// Vars 
	private static $application = null;
	private static $document = null;
	private static $database = null;
	private static $user = null;

	function __construct() {}
	
	public static function getApplication (){
		if (!self::$application[_CLIENT]){
			//import('core.application');
			self::$application[_CLIENT] = Application::getInstance();
		}
		return self::$application[_CLIENT];
		
	}

	public static function getDocument (){
		if (!self::$document){
			//import('core.document');
			self::$document = Document::getInstance();
		}
		return self::$document;
		
	}

	public static function getDBO (){
		if (!self::$database){
			self::$database = Database::getInstance();
		}
		return self::$database;
		
	}

	public static function getUser(){
		if (!self::$user){
			self::$user = User::getInstance();
		}
		return self::$user;
		
	}




}	//End class Core

?>