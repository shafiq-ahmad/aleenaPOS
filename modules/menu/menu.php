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


	function getMainMenu(){
		global $db;
		$sql  = "SELECT * FROM menu ";
		$sql .= "WHERE parent_id = 1 AND published = 1 ORDER BY ordering ";
		return false;
		//return $db->get_by_sql($sql);
	}


$rows=getMainMenu();

require_once("tmpl/default.php");

?>
