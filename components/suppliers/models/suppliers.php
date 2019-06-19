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

class ModelSuppliers extends Model{

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

	// Get Methods of Payments
	function getMOPS() {
		$db=Core::getDBO();
		$sql  = "SELECT * FROM payment_methods AS pm ";
		$sql  .= "WHERE pm.published=1 ";

		return $db->get_by_sqlRows($sql);
	}

	// Get Branch stores
	function getBranchStores() {
		$db=Core::getDBO();
		$user=Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql  = "SELECT * FROM branch_stores AS bs ";
		$sql  .= "WHERE bs.published=1 AND bs.branch_id = {$branch_id} ";

		return $db->get_by_sqlRows($sql);
	}

}
