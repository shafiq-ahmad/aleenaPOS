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

class ModelPayments extends Model{

	public function getData(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "SELECT s.*, LOWER(s.title) AS ord FROM suppliers AS s ";
		$sql  .= "WHERE s.branch_id=0 OR s.branch_id={$branch_id} ";
		$sql .= "ORDER BY ord ASC ";
		
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

}
