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

class ModelLedger extends Model{

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

	public function getLedger($id){
		if(!$id){return array();}
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT tbl.ref_no, tbl.amount, tbl.cash, tbl.date_time, tbl.credit, tbl.action, tbl.dt FROM ( ";
		
		$sql .= "SELECT  ";
		$sql .= "cp.ref_no, transaction_date AS dt, 0 AS amount, 0 AS cash, 0 AS credit, 'Paid' AS action, cp.date_time ";
		$sql .= "FROM cash_payment_logs AS cp ";
		$sql .= "WHERE cp.branch_id = {$branch_id} AND ref_no = 'suppliers.supplier.{$id}' ";
		
		$sql .= "UNION ALL ";
		//total +purchase, cash, credit
		$sql .= "SELECT purchase_id AS ref_no, purchase_date AS dt, amount, bp.cash AS cash, credit, 'Purchase' AS action, time_stamp AS date_time ";
		$sql .= " ";
		$sql .= "FROM branch_purchases AS bp ";
		$sql .= "WHERE bp.branch_id = {$branch_id} AND bp.supplier_id = {$id} ";
		
		$sql  .= ") AS tbl ";
		$sql  .= "ORDER BY tbl.date_time DESC";
		//echo $sql;exit;
		$res = $db->get_by_sqlRows($sql);
		//print_r($res);exit;
		return $res;
	}
}
