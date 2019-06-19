<?php
defined('_MEXEC') or die ('Restricted Access');


class ModelInventories extends Model{

	public function getBranchInventories(){
		$db=Core::getDBO();
		$today=$db->getCurrentDate('date');
		$today7=strftime("%Y-%m-%d", time()-(3600*24*7));
		//echo $today . ' . ' . $today7;exit;
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT bia.*,u.full_name, a.title ";
		$sql .= "FROM users AS u ";
		$sql .= "INNER JOIN branch_inv_articles AS bia ON (bia.user_id = u.user_id) ";
		$sql .= "INNER JOIN articles AS a ON (bia.article_code = a.article_code) ";
		$sql .= "WHERE bia.branch_id = {$branch_id} ";
		$sql .= "AND bia.inv_date >= '{$today7}' AND bia.inv_date <= '{$today}' ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function saveInventoryArt($data){
		
		if(!$this->validateInvData($data)){return false;}
		//print_r($data);exit;
		$db=Core::getDBO();
		$db->start();
		$data['adjustment_time']=$db->getCurrentDate('date');
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id=$u['branch_id'];
		$adjusted_qty=$data['qty'] - $data['actual_stock'];
		$closing_stock=$data['qty'];
		$sql = "INSERT INTO branch_inv_articles (";
		$sql .= "inv_id, inv_date, article_code, actual_stock, inv_qty, adjusted_qty, closing_stock,inv_time, branch_id, user_id ";
		$sql .= ") VALUES ( ";
		$sql .= "'0', ";
		$sql .= "'{$data['adjustment_time']}', ";
		$sql .= "'{$data['article_code']}', ";
		$sql .= "'{$data['actual_stock']}', ";
		$sql .= "'{$data['qty']}', ";
		$sql .= "'{$adjusted_qty}', ";
		$sql .= "'{$closing_stock}', ";
		$sql .= "'{$data['inv_time']}', ";
		$sql .= "'{$branch_id}', ";
		$sql .= "'{$u['user_id']}' ";
		$sql .= ")";
		//echo $sql;exit;
		$bia = $db->insert_by_sql($sql);
		
		
		$sql = "UPDATE branch_articles SET ";
		$sql .= "qty = '{$data['qty']}' ";
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
		$sql .= "action_time = '{$data['adjustment_time']}', user_id = '{$u['user_id']}' ";
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
		//var_dump($data);exit;
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$c = $user->getCompany();
		$data['user_id'] = $u['user_id'];
		$data['branch_id'] = $c['id'];
		//if(!isset($data['inv_id']) && !$data['inv_id']){return false;}
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
