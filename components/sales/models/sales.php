<?php
defined('_MEXEC') or die ('Restricted Access');


class ModelSales extends Model{

	public function getBranchSales($limit=null){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$user_id = $u['user_id'];
		$start_date='';
		$end_date='';
		if(isset($_GET['start_date'])){
			$start_date = $db->toDBDate($_GET['start_date']);
		}else{
			$start_date = $db->getCurrentDate('date');
		}
		if(isset($_GET['end_date'])){
			$end_date = $db->toDBDate($_GET['end_date']);
		}else{
			$end_date = $db->getCurrentDate('date');
		}
		$sql = "SELECT bs.*, cu.title AS cust_title ";
		$sql .= "FROM branch_sales AS bs ";
		$sql .= "LEFT JOIN customers AS cu ON (bs.customer_id = cu.id) ";
		$sql .= "WHERE bs.branch_id = {$branch_id} ";
		//echo $sql;exit;
		if($start_date && $end_date){
			$sql .= " AND bs.sale_date >= '{$start_date}' AND bs.sale_date <='{$end_date}' ";
		}
		$sql .= "ORDER BY id DESC ";
		if($limit){
			$sql .= "LIMIT {$limit} ";
		}
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getDailySale(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$user_id = $u['user_id'];
		$start_date='';
		$t = time()-(3600*24*30);
		$start_date = strftime("%Y-%m-%d", $t);
		if(isset($_GET['end_date'])){
			$end_date = $db->toDBDate($_GET['end_date']);
		}else{
			$end_date = $db->getCurrentDate('date');
		}
		$sql = "SELECT (sale_date) AS date_day, SUM(sub_total) AS sum_total, SUM(cash) AS sum_cash, SUM(credit) AS sum_credit, SUM(discount_amount) AS sum_discount ";
		$sql .= "FROM branch_sales AS bs ";
		$sql .= "WHERE bs.branch_id = {$branch_id} ";
		//echo $sql;exit;
		if($start_date && $end_date){
			$sql .= " AND bs.sale_date >= '{$start_date}' AND bs.sale_date <='{$end_date}' ";
		}
		$sql.="GROUP BY bs.sale_date ";
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

}
