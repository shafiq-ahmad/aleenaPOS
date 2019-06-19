<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelCredit extends Model{

	public function createData($data){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$com = Application::$options->com;
		$view = Application::$options->view;
		$link="?com=customers&view=credits";
		if(!$this->validateData($data)){
			$link="?com=customers&view=credits";
			$db->redirect("{$link}");
			return false;
		}
		$branch_id = $u['branch_id'];
		$sql = "INSERT INTO customer_credits ";
		$sql .= "(customer_id,ref_no,amount,user_id,transaction_date,old_account_value";
		$sql .= ") VALUES ( ";
		$sql .= "'{$data['id']}', ";
		$sql .= "'{$data['ref_no']}', ";
		$sql .= "'{$data['amount']}', ";
		$sql .= "'{$u['user_id']}', ";
		$sql .= "'{$data['transaction_date']}', ";
		$sql .= "'{$data['old_account_value']}' ";
		$sql .= ")";
		$ri = $db->insert_by_sql($sql);
		$message='';
		if($ri){
			$message .= ': Record saved.<br/>';
			$db->setMessage($message);
		}
		if($db->insert_id()){
			$id = $db->insert_id();
			$link .= "&id={$id}";
			return $id;
			//$db->redirect($link);
		}
		return false;
	}

	public function validateData(&$data){
		$db=Core::getDBO();
		if(!isset($data['id']) || !$data['id']){
			$db->setMessage('Invalid Customer.');
			return false;
		}
		if(!isset($data['amount']) || !$data['amount']){
			$db->setMessage('Invalid amount.');
			return false;
		}
		if(!isset($data['transaction_date']) || $data['transaction_date']){
			$data['transaction_date'] = $db->getCurrentDate('date');
		}else{
			$data['transaction_date'] = $db->toDBDate($data['transaction_date']);
		}
		if(!isset($data['old_account_value']) || $data['old_account_value']){
			$data['old_account_value'] = 0;
		}else{
			$data['old_account_value'] = $data['old_account_value'];
		}
		if(!$data['ref_no']){
			$data['ref_no'] = '';
		}
		return $data;
	}



}
