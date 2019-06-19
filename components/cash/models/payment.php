<?php
/**
Package: Point of sale
version: 1.0.0
URI: https://webapplics.com/apps/pos/1.0.0/docs
Author: Shafique Ahmad
Author URI: http://webapplics.com/
Description: 
copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

*/

defined('_MEXEC') or die ('Restricted Access');

class ModelPayment extends Model{

	public function createData($data,$redirect=false){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$link="?com=customers&view=payments";
		if(!$this->validateData($data)){
			if($redirect){
				$link="?com=customers&view=payments";
				$db->redirect("{$link}");
			}
			echo 'validation failed';
			return false;
		}
		$c = $user->getCompany();
		$branch_id = $u['branch_id'];
		$row = $this->getModel('cash.cash')->getAccountByID($data['station_id']);
		if(!$row){return false;}
		$data['old_cash_value'] = $row['cash'];
		$sql = "INSERT INTO cash_payment_logs ";
		$sql .= "(cash,cash_source,user_id,transaction_date,file_name,file_id,ref_no,old_cash_value,details,branch_id";
		$sql .= ") VALUES ( ";
		$sql .= "'{$data['cash']}', ";
		$sql .= "'{$data['station_id']}', ";
		$sql .= "'{$u['user_id']}', ";
		$sql .= "'{$data['transaction_date']}', ";
		$sql .= "'{$data['file_name']}', ";
		$sql .= "'{$data['file_id']}', ";
		$sql .= "'{$data['ref_no']}', ";
		$sql .= "'{$data['old_cash_value']}', ";
		$sql .= "'{$data['details']}', ";
		$sql .= "'{$branch_id}' ";
		$sql .= ")";
		//echo $sql;exit;
		$ri = $db->insert_by_sql($sql);
		$message='';
		if($ri){
			$message .= ': Receipt save.<br/>';
			$db->setMessage($message);
		}
		if($db->insert_id()){
			//$id = $db->insert_id();
			//$link .= "&id={$id}";
		}
		if($data['station_id']){
			//update relevent table and add increase cash
			//old_account_value
			//`branch_cash_accounts`(`id`, `branch_id`, `title`, `cash`, `current_user_id`)
			$sql = "UPDATE branch_cash_accounts SET ";
			$sql .= "cash=cash-{$data['cash']} ";
			$sql .= "WHERE id = {$data['station_id']} and branch_id={$branch_id} ";
			$res = $db->update_by_sql($sql);
			if(!$res){
				$db->setMessage('Can\'t increase cash.<br/>','error');
				return false;
			}
		}
		if($ri && $res){
			return true;
		}
		return false;
	}

	public function validateData(&$data){
		$db=Core::getDBO();
		if(!isset($data['cash']) || !$data['cash']){
			$db->setMessage('Invalid amount.');
			return false;
		}
		if(!isset($data['station_id']) || !$data['station_id']){
			$db->setMessage('Invalid cash source.');
			return false;
		}
		if(isset($data['transaction_date']) && $data['transaction_date']){
			$data['transaction_date'] = $db->toDBDate($data['transaction_date']);
		}else{
			$data['transaction_date'] = $db->getCurrentDate('date');
		}
		if(!isset($data['file_name'])){
			$data['file_name'] = '';
		}
		if(!isset($data['file_id'])){
			$data['file_id'] = '0';
		}
		if(isset($data['old_cash_value']) && $data['old_cash_value']){}else{
			$data['old_cash_value'] = 0;
		}
		if(isset($data['details']) && $data['details']){}else{
			$data['details'] = '';
		}
		if(isset($data['ref_no']) && $data['ref_no']){}else{
			$data['ref_no'] = '';
		}
		return $data;
	}

}
