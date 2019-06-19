<?php
defined('_MEXEC') or die ('Restricted Access');


class ModelInventories extends Model{

	public function getBranchInventories(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT bi.*,u.full_name, COUNT(bia.article_code) AS nos_inv ";
		$sql .= "FROM branch_inventories AS bi ";
		$sql .= "INNER JOIN users AS u ON (bi.user_id = u.user_id) ";
		$sql .= "LEFT JOIN branch_inv_articles AS bia ON (bi.id = bia.inv_id) ";
		$sql .= "WHERE bi.branch_id = {$branch_id} ";
		$sql .= "GROUP BY bi.id,bi.inv_date,bi.inv_status,bi.branch_id,bi.user_id,bi.remarks,u.full_name ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function saveInventoryArt($data){
		//print_r($data);exit;
		if(!$this->validateInvData($data)){return false;}
		$db=Core::getDBO();
		//print_r($data);exit;
		$user=Core::getUser();
		$u=$user->getUser();
		if(!isset($data['inv_qty'])){
			$db->setMessage('Invalid Inventory Quantity.');
			return false;
		}
		$sql = "INSERT INTO branch_inv_articles (";
		$sql .= "inv_id, article_code, actual_stock, inv_qty,inv_time, user_id ";
		$sql .= ") VALUES ( ";
		$sql .= "'{$data['inv_id']}', ";
		$sql .= "'{$data['article_code']}', ";
		$sql .= "'{$data['actual_stock']}', ";
		$sql .= "'{$data['inv_qty']}', ";
		$sql .= "'{$data['inv_time']}', ";
		$sql .= "'{$u['user_id']}' ";
		$sql .= ")";
		//echo $sql;exit;
		$ri = $db->insert_by_sql($sql);
		
		
		if($ri){
			$message = '';
			$message .= ': Record saved.<br/>';
			$db->setMessage($message);
		}else{
			$message .= ': Record not saved.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		return true;
	}

	public function updateInventoryArt($data){
		if(!$this->validateInvData($data)){return false;}
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		if(!isset($data['inv_qty'])){
			$db->setMessage('Invalid Inventory Quantity.');
			return false;
		}
		
		$sql = "UPDATE branch_inv_articles SET ";
		$sql .= "actual_stock = '{$data['actual_stock']}', inv_qty = '{$data['inv_qty']}', ";
		$sql .= "inv_time = '{$data['inv_time']}', user_id = '{$u['user_id']}' ";
		$sql .= "WHERE inv_id='{$data['inv_id']}' AND article_code = '{$data['article_code']}' ";
		//echo $sql;exit;
		$ri = $db->update_by_sql($sql);
		
		
		if($ri){
			$message = '';
			$message .= ': Record saved.<br/>';
			$db->setMessage($message);
		}else{
			$message .= ': Record not saved.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		return true;
	}

	public function adjustInventoryArt($data){
		if(!$this->validateInvData($data)){return false;}
		//print_r($data);exit;
		$db=Core::getDBO();
		$db->start();
		$data['adjustment_time']=$db->getCurrentDate();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id=$u['branch_id'];
		$adjusted_qty=$data['inv_qty'];
		$closing_stock=$data['actual_stock'] + $adjusted_qty;
		$sql = "UPDATE branch_inv_articles SET ";
		$sql .= "adjusted_qty = '{$adjusted_qty}', ";
		$sql .= "actual_stock = '{$data['actual_stock']}', ";
		$sql .= "closing_stock = '{$closing_stock}', ";
		$sql .= "adjustment_time = '{$data['adjustment_time']}', user_id = '{$u['user_id']}' ";
		$sql .= "WHERE inv_id='{$data['inv_id']}' AND article_code = '{$data['article_code']}' ";
		//echo $sql;exit;
		$bia = $db->update_by_sql($sql);
		
		$sql = "UPDATE branch_articles SET ";
		$sql .= "qty = '{$closing_stock}' ";
		$sql .= "WHERE branch_id='{$branch_id}' AND article_code = '{$data['article_code']}' ";
		//echo $sql;exit;
		$ba = $db->update_by_sql($sql);
		
		
		$message = '';
		if($bia && $ba){
			$db->commit();
			$message .= ': Record saved.<br/>';
		}else{
			$message .= ': Record not saved.<br/>';
			$db->rollback();
			return false;
		}
		return true;
	}


	public function remInvItem($data){
		$db=Core::getDBO();
		$user=Core::getUser();
		//print_r($data);exit;
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "DELETE FROM branch_inv_articles WHERE ";
		//make sure current branch user is deleting record
		$sql .= "inv_id = {$data['inv_id']} AND article_code='{$data['itm']}' ";
		//echo $sql . '<br/>';
		$ri = $db->delete_by_sql($sql);
		if($ri){}else{return false;}
		return true;
	}

	public function saveInvItem($data){
		$db=Core::getDBO();
		$user=Core::getUser();
		//print_r($data);exit;
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "SELECT * FROM branch_inv_articles WHERE ";
		$sql .= "inv_id = {$data['inv_id']} AND article_code='{$data['article_code']}' ";
		//echo $sql . '<br/>';
		$ri = $db->get_by_sqlRow($sql);
		if($ri){
			//update
			return $this->updateInventoryArt($data);
		}else{
			//insert
			return $this->saveInventoryArt($data);
		}
		return false;
	}

	public function adjustInvItem($data){
		$db=Core::getDBO();
		$user=Core::getUser();
		//print_r($data);exit;
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "SELECT * FROM branch_inv_articles WHERE ";
		$sql .= "inv_id = {$data['inv_id']} AND article_code='{$data['article_code']}' ";
		//echo $sql . '<br/>';
		$ri = $db->get_by_sqlRow($sql);
		//print_r($ri);exit;
		$data['inv_qty']=$ri['inv_qty'];
		if($ri){
			//adjust
			return $this->adjustInventoryArt($data);
		}
		return false;
	}

	public function validateInvData(&$data){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$c = $user->getCompany();
		$data['user_id'] = $u['user_id'];
		$data['branch_id'] = $c['id'];
		if(!isset($data['inv_id']) && !$data['inv_id']){
			return false;
		}
		if(!$data['article_code']){
			$db->setMessage('Invalid Item code.');
			return false;
		}
		$task = $_GET['task'];
		if(!isset($data['inv_time'])){
			$data['inv_time']=$db->getCurrentDate();
		}
		$v = new View();
		$mdl = $v->getModel('articles.article');
		$art = $mdl->getArticleByID($data['article_code']);
		if(!$art){
			$db->setMessage('Invalid Item code.');
			return false;
		}
		$data['actual_stock']=$art['qty'];
		
		//print_r($art);
		//print_r($data);exit;
		
		return $data;
	}

}
