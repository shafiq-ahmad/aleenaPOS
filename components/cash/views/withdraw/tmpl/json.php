<?php
/**
Package: Point of sale
version: 1.0.0
URI: https://webapplics.com/apps/pos/1.0.0/docs
Author: Shafique Ahmad
Author URI: http://webapplics.com/
Description: 
copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

*/

defined('_MEXEC') or die ('Restricted Access');
header("Content-Type: application/json; charset=UTF-8");
//header('Cache-Control: no-cache, must-revalidate');
//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

if(isset($this->row)){
	//print_r( $this->row);
	echo json_encode($this->row);
}
exit;


//if(!$output){
//we must output a valid json. even if there nothing to output
//echo json_encode(array());
//echo json_encode($this->row);
//}
