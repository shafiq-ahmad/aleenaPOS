<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.model');
class ModelUser extends Model{
	
	public function get_by_id($user_id=0){
		$db=Core::getDBO();
		if(!$user_id){
			$user_id=core::getUser()->getUser()['user_id'];
		}
		$sql = "SELECT u.*, ug.group_name, ug.power_level FROM users AS u ";
		$sql .= "INNER JOIN user_groups AS ug ON (u.group_id = ug.group_id) ";
		$sql .= "WHERE user_id = '{$user_id}' ";
		$sql .= "AND u.published = 1 ";
		$sql .= "LIMIT 1";
		//echo $sql;exit;
		$usr = $db->get_by_sqlRow($sql);
		return $usr;
	}
	
	public function get_company_by_id($branch_id=0){
		$db=Core::getDBO();
		if(!$branch_id){
			$branch_id=core::getUser()->getUser()['branch_id'];
		}
		
		$sql  = "SELECT cb.*, c.title, c.admin_id, bs.id AS store_id, cb.address FROM company_branches AS cb ";
		$sql  .= "INNER JOIN companies AS c ON (c.id = cb.company_id) ";
		$sql .= "LEFT JOIN branch_stores AS bs ON (cb.id = bs.branch_id) ";
		$sql  .= "WHERE cb.id = '{$branch_id}' LIMIT 1 ";
		//echo $sql;
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}
	
	public function validate_user($username, $password){
		$db=Core::getDBO();
		if(!$username){
			$username=core::getUser()->getUser()['user_name'];
		}
		$username = addslashes($username);
		$sql = "SELECT u.*, ug.group_name, ug.power_level FROM users AS u ";
		$sql .= "INNER JOIN user_groups AS ug ON (u.group_id = ug.group_id) ";
		$sql .= "WHERE user_name = '{$username}' ";
		$sql .= "AND user_pass = '{$password}' ";
		$sql .= "AND u.published = 1 ";
		$sql .= "LIMIT 1";
		//echo $sql; //exit;
		$usr = $db->get_by_sqlRow($sql);
		//var_dump($usr);exit;
		return $usr;
	}
	
}
