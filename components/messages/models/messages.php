<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelMessages extends Model{
	
	public function getUserMessages(){
		$db = Core::getDBO();
		$user = Core::getUser();
		$u = $user->getUser();
		$c = $user->getCompany();
		$sql = "SELECT m.*, u_from.full_name AS from_name, u_to.full_name AS to_name, u_cc.full_name AS cc_name ";
		$sql .= "FROM messages AS m LEFT JOIN users AS u_from ON (m.msg_to = u_from.user_id) ";
		$sql .= "LEFT JOIN users AS u_to ON (m.msg_to = u_to.user_id) ";
		$sql .= "LEFT JOIN users AS u_cc ON (m.msg_cc = u_cc.user_id) ";
		//$sql .= "WHERE m.msg_from={$u['user_id']} OR m.msg_to={$u['user_id']} OR m.msg_cc = {$u['user_id']} ";
		$sql .= "WHERE m.msg_to={$c['id']} ";
		$sql .= "ORDER BY time_stamp DESC LIMIT 50 ";
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}


}
