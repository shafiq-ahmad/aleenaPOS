<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelInvetory2 extends Model{


	public function validateData(&$data){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$c = $user->getCompany();
		$data['user_id'] = $u['user_id'];
		$data['branch_id'] = $c['id'];
		$inv_date='';
		if($data['inv_date']){
			$data['inv_date']=$db->getCurrentDate();
		}
		if(!$data['inv_status']){
			$data['inv_status']='Open';
		}
		if(!$data['remarks']){
			$data['remarks']='';
		}
		return $data;
	}

	public function updateInventory($data){
		if(!$this->validateData($data)){return false;}
		if(!$data['id']){
			return false;
		}
		$db=Core::getDBO();
		$sql = "UPDATE branch_inventories ";
		$sql .= "SET inv_date='{$data['inv_date']}', ";
		$sql .= "inv_status='{$data['inv_status']}', ";
		$sql .= "remarks='{$data['remarks']}' ";
		$sql .= "WHERE id='{$data['id']}' AND branch_id = '{$data['branch_id']}'";
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
		
	}

	public function createInventory($data){
		if(!$this->validateData($data)){return false;}
		$db=Core::getDBO();
		$sql = "INSERT INTO branch_inventories ";
		$sql .= "(inv_date,inv_status,remarks,user_id,branch_id) VALUES ( ";
		$sql .= "'{$data['inv_date']}', ";
		$sql .= "'{$data['inv_status']}', ";
		$sql .= "'{$data['remarks']}', ";
		$sql .= "'{$data['user_id']}', ";
		$sql .= "{$data['branch_id']} ";
		$sql .= ")";
		//echo $sql;exit;
		$ri = $db->insert_by_sql($sql);
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
			return $id;
		}
		return false;
	}

	public function getInventories(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT bi.* ";
		$sql .= "FROM branch_inventories AS bi ";
		$sql .= "LEFT JOIN branch_inv_articles AS bia ON (bi.id = bia.purchase_id) ";
		$sql .= "WHERE bi.branch_id = {$branch_id} ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getInventoryByID($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		if(!$id){
			$db->setMessage('Invalid Purchase ID.');
			return false;
		}
		$branch_id = $u['branch_id'];
		$sql = "SELECT bi.* ";
		$sql .= "FROM branch_inventories AS bi ";
		$sql .= "LEFT JOIN branch_inv_articles AS bia ON (bi.id = bia.inv_id) ";
		$sql .= "WHERE bi.branch_id = {$branch_id} AND bi.id={$id} ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRow($sql);
		return $rows;
	}


	public function getInventoryArticles2($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT bi.*, bia.*, ac.title AS art_title, ac.ref_code, ba.cost_price, u.full_name ";
		$sql .= " ";
		$sql .= "FROM branch_inventories AS bi ";
		$sql .= "LEFT JOIN branch_inv_articles AS bia ON (bi.id = bia.inv_id) ";
		$sql .= "LEFT JOIN articles AS ac ON (bia.article_code= ac.article_code) ";
		$sql .= "LEFT JOIN branch_articles AS ba ON (ba.article_code= ac.article_code) ";
		$sql .= "LEFT JOIN users AS u ON (bia.user_id = u.user_id) ";
		//$sql .= "INNER JOIN article_cats AS acs ON (ac.parent_cat = acs.id) ";
		//$sql .= "WHERE bi.inv_status='Open' AND bi.branch_id = {$branch_id} AND bi.id = {$id} ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		//print_r($rows);exit;
		return $rows;
	}

	public function getInventoryArticles($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT bi.*, bia.inv_id, bia.actual_stock, bia.inv_qty, bia.inv_time, bia.user_id, ac.title AS art_title, ac.ref_code, ba.cost_price, ";
		$sql .= "u.full_name,ac.article_code, ba.qty AS current_stock, cat.title AS cat_name, pcat.title AS pcat_name, ";
		$sql .= "ba.loc_section, ba.loc_rack, ba.loc ";
		$sql .= "FROM articles AS ac ";
		$sql .= "INNER JOIN article_cats AS cat ON (cat.id = ac.category) ";
		$sql .= "INNER JOIN article_cats AS pcat ON (pcat.id = cat.parent_cat) ";
		$sql .= "INNER JOIN branch_articles AS ba ON (ba.article_code= ac.article_code) ";
		$sql .= "LEFT JOIN branch_inv_articles AS bia ON (bia.article_code= ac.article_code) ";
		$sql .= "LEFT JOIN branch_inventories AS bi ON (bi.id = bia.inv_id) ";
		$sql .= "LEFT JOIN users AS u ON (bia.user_id = u.user_id) ";
		$sql .= "WHERE (bi.inv_status='Open' OR bi.inv_status IS NULL) AND (bi.branch_id = {$branch_id} OR bi.branch_id IS NULL) AND (bi.id = {$id} OR bi.id IS NULL) ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		//print_r($rows);exit;
		return $rows;
	}

}
