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

class ModelCredits extends Model{

	public function getData($id=0){
		$db=Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "SELECT c.*, cc.ref_no, cc.amount, cc.date_time, cc.transaction_date, cc.user_id FROM customers AS c ";
		$sql .= "INNER JOIN customer_credits AS cc ON (c.id = cc.customer_id) ";
		$sql  .= "WHERE c.branch_id = {$branch_id} ";
		if($id){
			$sql  .= "AND c.id = {$id} ";
		}
		$sql .= "ORDER BY ord ASC";
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}


}

