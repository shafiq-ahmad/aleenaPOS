<?php
defined('APP_EXEC') or die('No direct access is allowed.');

//require_once "pagination.php";
require_once "list.php";

	
function getCheckState($state){
	if($state==1){
		return 'checked="checked"';
	}else{
		return '';
	}
}
	


?>