<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelCredit extends Model{

	public function setData($data){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$link="?com=suppliers&view=credit";
		if(!$this->validateData($data)){
			$db->redirect("{$link}s");
			return false;
		}
		$branch_id = $u['branch_id'];
		$sql = "UPDATE supplier_credits ";
		$sql .= "SET ";
		//$sql .= "id='{$data['supplier_id']}', ";
		//$sql .= "ref_no='{$data['ref_no']}', ";
		$sql .= "amount='{$data['amount']}', ";
		$sql .= "user_id='{$u['user_id']}', ";
		$sql .= "transaction_date='{$data['transaction_date']}', ";
		$sql .= "old_account_value='{$data['old_account_value']}' ";
		$sql .= "WHERE id='{$data['id']}' AND branch_id = {$branch_id} ";
		$ru = $db->update_by_sql($sql);
		$message='';
		if($ru){
			$message .= ': Record updated.<br/>';
			$db->setMessage($message);
		}
		$db->redirect("{$link}");
	}

	public function createData($data, $redirect=true){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$link="?com=suppliers&view=credit";
		if(!$this->validateData($data)){
			$db->redirect("{$link}s");
			return false;
		}
		$branch_id = $u['branch_id'];
		$sql = "INSERT INTO supplier_credits ";
		$sql .= "(supplier_id,ref_no,amount,user_id,transaction_date,old_account_value ";
		$sql .= ") VALUES ( ";
		$sql .= "'{$data['supplier_id']}', ";
		$sql .= "'{$data['ref_no']}', ";
		$sql .= "'{$data['amount']}', ";
		$sql .= "'{$u['user_id']}', ";
		$sql .= "'{$data['transaction_date']}', ";
		$sql .= "'{$data['old_account_value']}' ";
		$sql .= ")";
		//echo $sql;exit;
		$ri = $db->update_by_sql($sql);
		
		$message='';
		if($ri){
			$message .= ': Record saved.<br/>';
			$db->setMessage($message);
		}else{
			$message .= ': Record not saved.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		if($db->insert_id()){
			$id = $db->insert_id();
			//echo $id;exit;
			if($redirect){
				$link .= "&id={$id}";
				$db->redirect("{$link}");
			}
			return $id;
		}
		return false;
	}

	public function validateData(&$data){
		$db=Core::getDBO();
		if(!isset($data['supplier_id']) || !$data['supplier_id']){
			$db->setMessage('Invalid Supplier.');
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
		if(isset($data['old_account_value']) && $data['old_account_value']){
			$data['old_account_value'] = $data['old_account_value'];
		}else{
			$data['old_account_value'] = 0;
		}
		if(!$data['ref_no']){
			$data['ref_no'] = '';
		}
		return $data;
	}


}