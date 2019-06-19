<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelReceipts extends Model{

	public function getData($txt=''){
		//`cash_receipt_logs`(`id`, `cash`, `cash_source`, `date_time`, `user_id`, `payment_date`, `branch_id`, `file_name`, `file_id`, `ref_no`, `old_account_value`, `old_cash_value`, `details`
		$db=Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "SELECT cr.* FROM cash_receipt_logs AS cr ";
		$sql  .= "WHERE cr.branch_id = {$branch_id} ";
		if($txt){
			//$sql  .= "AND cr.id = {$id} ";
		}
		$sql .= "ORDER BY cr.date_time DESC";
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getDataByRefNo($ref_no='', $limit=20){
		//`cash_receipt_logs`(`id`, `cash`, `cash_source`, `date_time`, `user_id`, `payment_date`, `branch_id`, `file_name`, `file_id`, `ref_no`, `old_account_value`, `old_cash_value`, `details`
		$db=Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
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
		$sql = "SELECT cr.* FROM cash_receipt_logs AS cr ";
		$sql  .= "WHERE cr.branch_id = {$branch_id} ";
		if($ref_no){
			$sql  .= "AND cr.ref_no = '{$ref_no}' ";
		}
		if($start_date && $end_date){
			$sql .= " AND cr.date_time >= '{$start_date}' AND cr.date_time <='{$end_date}' ";
		}
		$sql .= "ORDER BY cr.date_time DESC ";
		$sql .= "LIMIT {$limit} ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}


}

