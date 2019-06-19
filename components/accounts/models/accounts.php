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

class ModelAccounts extends Model{
	public static $accounts = array();
	
	public function getAccounts($account_category=0, $ids='',$arr_type=''){
		$db = Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT ac.*, act.title AS act_title, act.increase_action, act.decrease_action, act.debit_action, act.credit_action, bac.branch_id, ";
		$sql .= "bac.account_value, bac.max_value, bac.min_value ";
		$sql .= "FROM accounts AS ac ";
		$sql .= "INNER JOIN account_categories AS act ON (ac.account_category= act.id) ";
		$sql .= "LEFT JOIN branch_accounts AS bac ON (bac.account_id= ac.id) ";
		$sql .= "WHERE ac.published=1 ";
		if($account_category){
			$sql .= "AND ac.account_category ={$account_category} ";
		}
		if($ids){
			$sql .= "AND ac.id  IN ({$ids}) ";
		}
		$sql .= "AND (bac.branch_id  = ({$branch_id}) OR bac.branch_id IS NULL) ";
		$rows = $db->get_by_sqlRows($sql);
		//echo $sql;
		//print_r($rows);
		$res = array();
		foreach($rows as $row){
			if($arr_type=='alias'){
				$a = $row['alias'];
			}else{
				$a = $row['id'];
			}
			$res[$a] = $row;
		}
		return $res;
	}

	public function getAccountByAlias($alias=''){
		if(!self::$accounts){
			$rows = $this->getAccounts(0,'','alias');
			if(!$rows){return false;}
			self::$accounts = $rows;
		}
		if(isset(self::$accounts[$alias])){
			return self::$accounts[$alias];
		}
		return false;
	}


}