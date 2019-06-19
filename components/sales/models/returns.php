<?php
defined('_MEXEC') or die ('Restricted Access');


class ModelReturns extends Model{

	public function getBranchReturns(){
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
		$sql = "SELECT bsr.*, cu.title AS cust_title ";
		$sql .= "FROM branch_sales_return AS bsr ";
		$sql .= "LEFT JOIN customers AS cu ON (bsr.customer_id = cu.id) ";
		$sql .= "WHERE bsr.branch_id = {$branch_id} ";
		if($start_date && $end_date){
			$sql .= " AND bsr.return_date >= '{$start_date}' AND bsr.return_date <='{$end_date}' ";
		}
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

}
