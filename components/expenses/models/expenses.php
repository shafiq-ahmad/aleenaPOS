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

class ModelExpenses extends Model{

	public function getData($id=0){
		$db=Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "SELECT e.*, et.title AS expense_title, et.category, u.full_name, cba.title as station_title FROM expenses AS e ";
		$sql .= "INNER JOIN expense_types AS et ON (et.id = e.expense_id) ";
		$sql .= "INNER JOIN users AS u ON (u.user_id = e.user_id) ";
		$sql .= "INNER JOIN branch_cash_accounts AS cba ON (cba.id = e.station_id) ";
		$sql .= "WHERE e.branch_id = {$branch_id} ";
		if($id){
			$sql  .= "AND e.id = {$id} ";
		}
		$sql .= "ORDER BY e.id DESC";
		//$sql .= "LIMIT 50 ";
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getDataByRefno($ref_no,$limit=20){
		$db=Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "SELECT e.* FROM expenses AS e ";
		$sql  .= "WHERE e.branch_id = {$branch_id} ";
		$sql  .= "AND e.ref_no = '{$ref_no}' ";
		$sql .= "ORDER BY e.id DESC ";
		$sql .= "LIMIT {$limit} ";
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}


}

