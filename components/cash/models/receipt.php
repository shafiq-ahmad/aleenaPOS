<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelReceipt extends Model{

	public function createData($data,$redirect=''){
		//`cash_receipt_logs`(``
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		if(!$this->validateData($data)){
			if($redirect){
				$db->redirect("{$redirect}");
			}
			return false;
		}
		$c = $user->getCompany();
		$branch_id = $u['branch_id'];
		$row = $this->getModel('cash.cash')->getAccountByID($data['station_id']);
		$id=0;
		if(!$row){return false;}
		$data['old_cash_value'] = $row['cash'];
		$sql = "INSERT INTO cash_receipt_logs ";
		$sql .= "(cash,cash_source,user_id,payment_date,file_name,file_id,ref_no,old_cash_value,details,branch_id";
		$sql .= ") VALUES ( ";
		$sql .= "'{$data['cash']}', ";
		$sql .= "'{$data['station_id']}', ";
		$sql .= "'{$u['user_id']}', ";
		$sql .= "'{$data['payment_date']}', ";
		$sql .= "'{$data['file_name']}', ";
		$sql .= "'{$data['file_id']}', ";
		$sql .= "'{$data['ref_no']}', ";
		$sql .= "'{$data['old_cash_value']}', ";
		$sql .= "'{$data['details']}', ";
		$sql .= "'{$branch_id}' ";
		$sql .= ")";
		//echo $sql;
		$ri = $db->insert_by_sql($sql);
		if($db->insert_id()){
			//$id = $db->insert_id();
			//$link .= "&id={$id}";
		}
		//echo $id;exit;
		$message='';
		if($ri){
			$message .= ': Receipt save.<br/>';
			$db->setMessage($message);
		}
		if($data['station_id']){
			//update relevent table and add increase cash
			//old_account_value
			//`branch_cash_accounts`(`id`, `branch_id`, `title`, `cash`, `current_user_id`)
			$sql = "UPDATE branch_cash_accounts SET ";
			$sql .= "cash=cash+{$data['cash']} ";
			$sql .= "WHERE id = {$data['station_id']} and branch_id={$branch_id} ";
			//echo $sql;exit;
			$res = $db->update_by_sql($sql);
			if(!$res){
				$db->setMessage('Can\'t increase cash.<br/>','error');
				return false;
			}
		}
		if($ri && $res){
			return true;
		}else{
			return false;
		}
	}

	public function validateData(&$data){
		//`cash_receipt_logs`(`old_account_value`
		$db=Core::getDBO();
		//print_r($data);exit;
		if(!isset($data['cash'])){
			$db->setMessage('Invalid amount.');
			return false;
		}
		if(!isset($data['station_id']) || !$data['station_id']){
			$db->setMessage('Invalid cash source.');
			return false;
		}
		if(isset($data['payment_date']) && $data['payment_date']){
			$data['payment_date'] = $db->toDBDate($data['payment_date']);
		}else{
			$data['payment_date'] = $db->getCurrentDate('date');
		}
		if(!isset($data['file_name'])){
			$data['file_name'] = '';
		}
		if(!isset($data['file_id'])){
			$data['file_id'] = '0';
		}
		if(isset($data['ref_no']) && $data['ref_no']){
			//$data['ref_no'] = '';
		}else{
			$data['ref_no'] = '';
		}
		if(isset($data['details']) && $data['details']){
			//$data['details'] = '';
		}else{
			$data['details'] = '';
		}
		return $data;
	}

}
