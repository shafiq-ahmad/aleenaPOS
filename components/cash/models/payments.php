<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelPayments extends Model{

	public function getData($id=0){
		//`cash_payment_logs`(`id`, `file_name`, `file_id`, `ref_no`, `cash`, `cash_source`, `date_time`, `transaction_date`, `user_id`, `old_account_value`, `old_cash_value`, `branch_id`, `details`) 
		$db=Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "SELECT cp.* FROM cash_payment_logs AS cp ";
		$sql  .= "WHERE cp.branch_id = {$branch_id} ";
		if($id){
			//$sql  .= "AND cp.id = {$id} ";
		}
		//$sql .= "ORDER BY ord ASC";
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getDataByRefno($ref_no,$limit=20){
		//`cash_payment_logs`(`id`, `file_name`, `file_id`, `ref_no`, `cash`, `cash_source`, `date_time`, `transaction_date`, `user_id`, `old_account_value`, `old_cash_value`, `branch_id`, `details`) 
		$db=Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "SELECT cp.* FROM cash_payment_logs AS cp ";
		$sql  .= "WHERE cp.branch_id = {$branch_id} ";
		$sql  .= "AND cp.ref_no = '{$ref_no}' ";
		//$sql .= "ORDER BY cp.id DESC ";
		$sql .= "LIMIT {$limit} ";
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}


}

