<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelMessage extends Model{
	
	public function getDataByID($id){
		$db = Core::getDBO();
		$user = Core::getUser();
		$u = $user->getUser();
		$c = $user->getCompany();
		$sql = "SELECT m.*, u_from.full_name AS from_name, u_to.full_name AS to_name, u_cc.full_name AS cc_name ";
		$sql .= "FROM messages AS m LEFT JOIN users AS u_from ON (m.msg_to = u_from.user_id) ";
		$sql .= "LEFT JOIN users AS u_to ON (m.msg_to = u_to.user_id) ";
		$sql .= "LEFT JOIN users AS u_cc ON (m.msg_cc = u_cc.user_id) ";
		//$sql .= "WHERE m.msg_from={$u['user_id']} OR m.msg_to={$u['user_id']} OR m.msg_cc = {$u['user_id']} AND m.id ={$id} LIMIT 1";
		$sql .= "WHERE m.msg_to={$c['id']} AND m.id ={$id} LIMIT 1";
		//echo $sql;exit;
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function setData($id, $status){
		$db = Core::getDBO();
		$sql = "UPDATE messages SET ";
		$sql .= "msg_status={$status} ";
		$sql .= "WHERE id={$id}";
		return $db->update_by_sql($sql);
	}

	public function sendMessage($msg,$subject,$to,$cc=0,$from=11,$msg_status=2){
		$db=Core::getDBO();
		$u=Core::getUser()->getUser();
		if(!$msg || !$subject){
			return false;
		}
		$user_id = $u['user_id'];
		$sql = "INSERT INTO messages ";
		$sql .= "(msg_from,msg_to,msg_cc,msg_subject,msg_body,user_id,msg_status) VALUES ( ";
		$sql .= "{$from}, ";
		$sql .= "{$to}, ";
		$sql .= "{$cc}, ";
		$sql .= "'{$subject}', ";
		$sql .= "'{$msg}', ";
		$sql .= "{$user_id}, ";
		$sql .= "{$msg_status} ";
		$sql .= ")";
		return $db->update_by_sql($sql);
	}

}

