<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelSupplier extends Model{

	public function getDataByID($id){
		$db=Core::getDBO();
		$sql = "SELECT * FROM suppliers WHERE id={$id} LIMIT 1";
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function getArticles($supplier_id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "SELECT DISTINCT(a.article_code), a.title, CONCAT(a.title, ' - ', ac.title, ' - ', acs.title) AS category, bpa.unit_price  FROM suppliers AS s ";
		$sql .= "INNER JOIN branch_purchases AS bp ON (bp.supplier_id = s.id) ";
		$sql .= "INNER JOIN branch_purchase_articles AS bpa ON (bpa.purchase_id = bp.purchase_id) ";
		$sql .= "INNER JOIN articles AS a ON (bpa.article_code = a.article_code) ";
		$sql .= "LEFT JOIN article_cats AS ac ON (a.category= ac.id) ";
		$sql .= "LEFT JOIN article_cats AS acs ON (ac.parent_cat = acs.id) ";
		$sql  .= "WHERE s.id={$supplier_id} AND s.branch_id={$branch_id} ";
		//$sql .= "ORDER BY ord ASC ";
		
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function setAccount($supplier_id,$value,$action=''){
		if(!$supplier_id || !$value ){return false;}
		$db=Core::getDBO();
		$user=Core::getUser();
		$u = $user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "UPDATE suppliers ";
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
		$sql .= "WHERE id='{$supplier_id}' AND branch_id = {$branch_id}";
		$ru = $db->update_by_sql($sql);
		if($ru){
			return true;
		}
		return false;
	}

	public function setData($data){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$com = Application::$options->com;
		$view = Application::$options->view;
		$link="?";
		if($com){$link .= "com={$com}";}
		if($view){$link .= "&view={$view}";}
		if($data['id']){$link .= "&id={$data['id']}";}
		if(!$this->validateData($data)){
			$db->redirect("{$link}");
			return false;
		}
		$branch_id = $u['branch_id'];
		$sql = "UPDATE suppliers ";
		$sql .= "SET ";
		$sql .= "title='{$data['title']}', ";
		$sql .= "contact_person='{$data['contact_person']}', ";
		$sql .= "data_articles='{$data['data_articles']}', ";
		$sql .= "address='{$data['address']}', ";
		$sql .= "terms_conditions='{$data['terms_conditions']}', ";
		$sql .= "phone='{$data['phone']}', ";
		$sql .= "no_of_days='{$data['no_of_days']}', ";
		$sql .= "fax_no='{$data['fax_no']}', ";
		$sql .= "mobile_no='{$data['mobile_no']}', ";
		
		$sql .= "e_mail='{$data['e_mail']}', ";
		$sql .= "mobile_no='{$data['mobile_no']}' ";
		$sql .= "WHERE id='{$data['id']}' AND branch_id = {$branch_id}";
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
		$db->redirect("{$link}");
	}

	public function validateData(&$data){
		$db=Core::getDBO();
		if(!$data['title']){
			$db->setMessage('Invalid Title.');
			return false;
		}
		if(!$data['contact_person']){
			$data['contact_person'] = '';
		}
		if(!$data['no_of_days']){
			$data['no_of_days'] = 0;
		}
		return $data;
	}

	public function createData($data){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$com = Application::$options->com;
		$view = Application::$options->view;
		$link="?";
		if($com){$link .= "com={$com}";}
		if($view){$link .= "&view={$view}";}
		if(!$this->validateData($data)){
			$db->redirect("{$link}");
			return false;
		}
		$branch_id = $u['branch_id'];
		$sql = "INSERT INTO suppliers ";
		$sql .= "(title,contact_person,data_articles,address,terms_conditions,";
		$sql .= "phone,no_of_days,fax_no,mobile_no,account_value,e_mail,branch_id ";
		$sql .= ") VALUES ( ";
		$sql .= "'{$data['title']}', ";
		$sql .= "'{$data['contact_person']}', ";
		$sql .= "'{$data['data_articles']}', ";
		$sql .= "'{$data['address']}', ";
		$sql .= "'{$data['terms_conditions']}', ";
		$sql .= "'{$data['phone']}', ";
		$sql .= "'{$data['no_of_days']}', ";
		$sql .= "'{$data['fax_no']}', ";
		$sql .= "'{$data['mobile_no']}', ";
		$sql .= "'{$data['account_value']}', ";
		$sql .= "'{$data['e_mail']}', ";
		$sql .= "'{$branch_id}' ";
		$sql .= ")";
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
			$db->redirect("{$link}");
		}
		return false;
	}

}