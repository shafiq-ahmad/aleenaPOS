<?php
defined('_MEXEC') or die ('Restricted Access');


class ModelInventory extends Model{

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
		if(isset($data['done']) && $data['done']){
			$sql .= "inv_status='Done', ";
		}
		$sql .= "remarks='{$data['remarks']}' ";
		$sql .= "WHERE id='{$data['id']}' AND branch_id = '{$data['branch_id']}'";
		//echo $sql;exit;
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
		$inv_open = $this->getOpenInventory();
		if($inv_open){
			return $inv_open['id'];
		}
		$inv_last = $this->getLastInventory();
		if($inv_last){
			//if last inventory have done in current month then stop process
			$date=$db->getCurrentDate();
			$this_month = strftime("%Y-%m", strtotime($date));
			$sel_month = strftime("%Y-%m", strtotime($inv_last['inv_date']));
			if($this_month==$sel_month){
				$db->setMessage('Inventory process is allowed only once in a month.<br/>');
				return false;
			}
		}
		
		$sql = "INSERT INTO branch_inventories ";
		$sql .= "(inv_date,inv_status,remarks,user_id,branch_id) VALUES ( ";
		$sql .= "'{$data['inv_date']}', ";
		$sql .= "'Open', ";
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

	public function getLastInventory(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT bi.* ";
		$sql .= "FROM branch_inventories AS bi ";
		$sql .= "WHERE bi.branch_id = {$branch_id} AND inv_date = (SELECT MAX(inv_date) FROM branch_inventories WHERE branch_id={$branch_id} ) ";
		//echo $sql;exit;
		$inv_last = $db->get_by_sqlRow($sql);
		if($inv_last){
			return $inv_last;
		}
		return false;
	}

	public function getInventoryArticles($id,$inv_done=0){
		//echo $id;exit;
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT arts.article_code, arts.art_title, arts.cost_price, arts.current_stock, arts.cat_name, arts.pcat_name, arts.loc_section, arts.loc_rack, arts.loc, ";
		$sql .= "invs.id, invs.inv_date, invs.status, invs.branch_id, invs.user_id, invs.remarks, invs.inv_id, invs.actual_stock, invs.inv_qty, invs.inv_time  ";
		$sql .= "FROM ( ";
		$sql .= "SELECT ac.title AS art_title, ba.cost_price, ";
		$sql .= "ac.article_code, ba.qty AS current_stock, cat.title AS cat_name, pcat.title AS pcat_name, ";
		$sql .= "ba.loc_section, ba.loc_rack, ba.loc ";
		$sql .= "FROM articles AS ac ";
		$sql .= "LEFT JOIN article_cats AS cat ON (cat.id = ac.category) ";
		$sql .= "LEFT JOIN article_cats AS pcat ON (pcat.id = cat.parent_cat) ";
		$sql .= "INNER JOIN branch_articles AS ba ON (ba.article_code= ac.article_code) ";
		$sql .= "WHERE ba.branch_id = {$branch_id}) AS arts LEFT JOIN ( ";
		
		
		$sql .= "SELECT bia.id,bia.inv_date,0 AS status,bia.branch_id,bia.user_id,bia.remarks, ";
		$sql .= "bia.article_code, bia.inv_id, bia.actual_stock, bia.inv_qty, bia.inv_time, bia.action_time ";
		$sql .= "FROM branch_inv_articles AS bia ";
		//$sql .= "LEFT JOIN branch_inventories AS bi ON (bi.id = bia.inv_id) ";
		$sql .= "WHERE bia.branch_id = {$branch_id} AND bia.id = {$id} ) AS invs ";
		$sql .= "ON (arts.article_code = invs.article_code) ";
		//if($inv_done==1){
			//$sql .= "WHERE invs.inv_qty IS NOT NULL ";
			//$sql .= "AND invs.action_time IS NULL ";
		//}else{
			$sql .= "WHERE invs.inv_qty IS NULL ";
		//}
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		//print_r($rows);exit;
		return $rows;
	}

}



