<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelCustomer extends Model{

	public function getDataByID($id){
		$db=Core::getDBO();
		$sql = "SELECT * FROM customers WHERE id={$id} LIMIT 1";
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function setData($data){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u = $user->getUser();
		$link="?com=customers&view=customers" . "&id={$data['id']}";
		if(!$this->validateData($data,'update')){
			$db->redirect("{$link}");
			return false;
		}
		
		$id = $data['id'];
		DBHelper::data_field_remove($data,'id');
		DBHelper::data_field_remove($data,'save');
		$sql = DBHelper::array_update_sql($data,'customers',"id = '{$id}' AND branch_id = {$u['branch_id']}");
		/*$branch_id = $u['branch_id'];
		$sql = "UPDATE customers ";
		$sql .= "SET ";
		$sql .= "title='{$data['title']}', ";
		$sql .= "address='{$data['address']}', ";
		$sql .= "cnic='{$data['cnic']}', ";
		$sql .= "town_id='{$data['town_id']}', ";
		$sql .= "account_no='{$data['account_no']}', ";
		$sql .= "phone='{$data['phone']}', ";
		$sql .= "fax_no='{$data['fax_no']}', ";
		$sql .= "mobile_no='{$data['mobile_no']}', ";
		
		$sql .= "e_mail='{$data['e_mail']}', ";
		$sql .= "lng='{$data['lng']}', ";
		$sql .= "mobile_no='{$data['mobile_no']}', ";
		$sql .= "lat={$data['lat']} ";
		$sql .= "WHERE id='{$data['id']}' AND branch_id = {$branch_id}";*/
		//echo $sql;
		$ru = $db->update_by_sql($sql);
		$message='';
		if($ru){
			$message .= ': Record updated.<br/>';
			$db->setMessage($message);
		}else{
			$message .= ': Record not updated.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		//$db->redirect("{$link}");
	}

	public function setAccount($customer_id,$value,$action=''){
		if(!$customer_id || !$value ){return false;}
		$db=Core::getDBO();
		$user=Core::getUser();
		$u = $user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "UPDATE customers ";
		$sql .= "SET ";
		if($action){
			if($action=='+'){
				$sql .= "account_value=account_value+{$value} ";
			}elseif($action=='-'){
				$sql .= "account_value=account_value-{$value} ";
			}else{
				return false;
			}
		}else{
			$sql .= "account_value={$value} ";
		}
		$sql .= "WHERE id='{$customer_id}' AND branch_id = {$branch_id}";
		$ru = $db->update_by_sql($sql);
		if($ru){
			return true;
		}
		return false;
	}

	public function validateData(&$data, $crud_type='insert'){
		//`customers`(`id`, `title`, `father_name`, `branch_id`, `address`, `cnic`, `town_id`, `account_no`, `phone`, `fax_no`, `mobile_no`, `e_mail`, 
		//`account_value`, `lng`, `lat`, `register_date`, `user_id`, `consultant`, `reference`, `diagnosis`, `p_procedure`)

		$db=Core::getDBO();
		$user=Core::getUser();
		$u = $user->getUser();
		if(!isset($data['title']) || !$data['title']){
			$db->setMessage('Invalid Title.');
			return false;
		}
		//$date=date('Y-m-d H:i:s');
		DBHelper::$crud_type=$crud_type;
		DBHelper::data_field($data,'title','',true);
		DBHelper::data_field($data,'father_name','');
		DBHelper::data_field($data,'address','');
		DBHelper::data_field($data,'cnic','');
		DBHelper::data_field($data,'account_no','');
		DBHelper::data_field($data,'phone','');
		DBHelper::data_field($data,'fax_no','');
		DBHelper::data_field($data,'mobile_no','');
		DBHelper::data_field($data,'e_mail','');
		DBHelper::data_field($data,'account_value',0);
		DBHelper::data_field($data,'register_date',date('Y-m-d'));
		DBHelper::data_field($data,'user_id',$u['user_id']);
		DBHelper::data_field($data,'consultant',0);
		DBHelper::data_field($data,'reference','');
		DBHelper::data_field($data,'diagnosis','');
		DBHelper::data_field($data,'p_procedure','');
		DBHelper::data_field($data,'lng',0);
		DBHelper::data_field($data,'lat',0);
		DBHelper::data_field($data,'town_id',0);
		return $data;
	}

	public function createData($data){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		//$com = Application::$options->com;
		//$view = Application::$options->view;
		$link="?com=customers&view=customers";
		if(!$this->validateData($data)){
			$link="?com=customers&view=customer&task=edit";
			$db->redirect("{$link}");
			return false;
		}
		DBHelper::data_field_remove($data,'save');
		DBHelper::data_field_remove($data,'id');
		DBHelper::data_field($data,'branch_id',$u['branch_id']);
		$sql = DBHelper::array_insert_sql($data,'customers');
		/*$sql = "INSERT INTO customers ";
		$sql .= "(title,address,cnic,town_id,account_no,";
		$sql .= "phone,fax_no,mobile_no,e_mail,branch_id,account_value,lng, ";
		$sql .= "lat) VALUES ( ";
		//$sql .= "'{$data['ledger_code']}', ";
		$sql .= "'{$data['title']}', ";
		$sql .= "'{$data['address']}', ";
		$sql .= "'{$data['cnic']}', ";
		$sql .= "'{$data['town_id']}', ";
		$sql .= "'{$data['account_no']}', ";
		$sql .= "'{$data['phone']}', ";
		$sql .= "'{$data['fax_no']}', ";
		$sql .= "'{$data['mobile_no']}', ";
		$sql .= "'{$data['e_mail']}', ";
		$sql .= "'{$branch_id}', ";
		$sql .= "'{$data['account_value']}', ";
		$sql .= "'{$data['lng']}', ";
		$sql .= "'{$data['lat']}' ";
		$sql .= ")";*/
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
			$link .= "&id={$id}";
			$db->redirect($link);
		}
		return false;
	}


}
