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

class ModelExpense extends Model{

	public function getDataByID($id=0){
		$db=Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "SELECT e.* FROM expenses AS e ";
		$sql  .= "WHERE e.branch_id = {$branch_id} ";
		if($id){
			$sql  .= "AND e.id = {$id} ";
		}
		//$sql .= "ORDER BY id ASC";
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getExpenseList($cat=null){
		$db=Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "SELECT et.* FROM expense_types AS et ";
		if($cat){
			$sql  .= "WHERE et.category = '{$cat}' ";
		}
		//$sql .= "ORDER BY id ASC";
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function createData($data,$redirect=false){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		//$link="?com=customers";
		if(!$this->validateData($data)){
			if($redirect){
				//$link="?com=customers";
				$db->redirect("{$redirect}");
			}
			echo 'validation failed';
			return false;
		}
		$c = $user->getCompany();
		$branch_id = $u['branch_id'];
		$row = $this->getModel('cash.cash')->getAccountByID($data['station_id']);
		if(!$row){return false;}
		$data['old_cash_value'] = $row['cash'];
		$sql = "INSERT INTO expenses ";
		$sql .= "(expense_id,amount,station_id,user_id,expense_date,remarks,branch_id";
		$sql .= ") VALUES ( ";
		$sql .= "'{$data['expense_id']}', ";
		$sql .= "'{$data['cash']}', ";
		$sql .= "'{$data['station_id']}', ";
		$sql .= "'{$u['user_id']}', ";
		$sql .= "'{$data['expense_date']}', ";
		$sql .= "'{$data['details']}', ";
		$sql .= "'{$branch_id}' ";
		$sql .= ")";
		//echo $sql;
		$ri = $db->insert_by_sql($sql);
		$message='';
		if($ri){
			$message .= ': Receipt save.<br/>';
			$db->setMessage($message);
		}
		$id=0;
		if($db->insert_id()){
			$id = $db->insert_id();
			//$link .= "&id={$id}";
		}
		$station_id=0;
		if(isset($data['station_id']) && $data['station_id']){
			$station_id = $data['station_id'];
		}
		if(!$station_id){
			$stn = $this->getModel('cash.cash')->getDefaultStation();
			$station_id = $stn['id'];
		}
		if($data['station_id']){
			//cash account decreased
			$arr_cash=array();
			$cash=$data['cash'];
			$arr_cash['ref_no'] = "expenses.expense.{$id}";
			$arr_cash['cash'] = $cash;
			$arr_cash['station_id'] = $station_id;
			$arr_cash['file_name'] = 'expenses';
			$arr_cash['file_id'] = $id;
			$cp = $this->getModel('cash.payment');
			//echo $id . '...';
			$cr = $cp->createData($arr_cash);
			if(!$cr){
				$error=true;
				$this->db->setMessage('Error cash payment. ');
			}/**/
			
		}
		if($id){
			return $id;
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
		if(isset($data['expense_date']) && $data['expense_date']){
			$data['expense_date'] = $db->toDBDate($data['expense_date']);
		}else{
			$data['expense_date'] = $db->getCurrentDate('date');
		}
		if(isset($data['details']) && $data['details']){}else{
			$data['details'] = '';
		}
		return $data;
	}

}
