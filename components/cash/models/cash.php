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

class ModelCash extends Model{

	public function getReceipts($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
	}

	public function getPayments($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
	}

	public function getAccountByID($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "SELECT * FROM branch_cash_accounts ";
		$sql .= "WHERE id = {$id} and branch_id={$u['branch_id']} LIMIT 1 ";
		$res = $db->get_by_sqlRow($sql);
		if(!$res){
			$db->setMessage('Account not exists.<br/>','error');
			return false;
		}
		return $res;
	}

	public function getBranchStation(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "SELECT * FROM branch_cash_accounts ";
		$sql .= "WHERE branch_id={$u['branch_id']} ";
		$res = $db->get_by_sqlRows($sql);
		if(!$res){
			$db->setMessage('Station not exists.<br/>','error');
			return false;
		}
		return $res;
	}

	public function getDefaultStation($id=0){
		//$_SESSION['default_station']='';
		if(isset($_SESSION['default_station']) && $_SESSION['default_station']){
			return $_SESSION['default_station'];
		}
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "SELECT * FROM branch_cash_accounts ";
		$sql .= "WHERE branch_id={$u['branch_id']} AND account_type='station' ";
		$res = $db->get_by_sqlRows($sql);
		if(!$res){
			$db->setMessage('Station not exists.<br/>','error');
			return false;
		}
		if(count($res)==1){
			$_SESSION['default_station'] = $res[0];
			return $res[0];
		}
		//print_r($res);exit;
		$db->setMessage('Many stations please choose one.<br/>','error');
		return false;
	}

	public function getSummery($id=0){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT tbl.ref_no, tbl.cash, tbl.cash_source, tbl.date_time, tbl.user_id, tbl.old_cash_value, tbl.details, tbl.action, tbl.dt FROM ( ";
		$sql .= "SELECT cp.ref_no, cp.cash, cp.cash_source, cp.date_time, cp.user_id, cp.old_cash_value, cp.details, 'Paid' AS action, transaction_date AS dt FROM cash_payment_logs AS cp ";
		$sql  .= "WHERE cp.branch_id = {$branch_id} ";
		
		$sql .= "UNION ALL ";
		$sql .= "SELECT cr.ref_no, cr.cash, cr.cash_source, cr.date_time, cr.user_id, cr.old_cash_value, cr.details, 'Receipt' AS action, cr.payment_date AS dt FROM cash_receipt_logs AS cr ";
		$sql  .= "WHERE cr.branch_id = {$branch_id} ) AS tbl ";
		$sql  .= "ORDER BY tbl.date_time DESC";
		//echo $sql;exit;
		$res = $db->get_by_sqlRows($sql);
		//print_r($res);exit;
		return $res;
	}


}
