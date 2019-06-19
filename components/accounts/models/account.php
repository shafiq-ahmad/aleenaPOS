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

class ModelAccount extends Model{
	
	public function getAccountByID($id){
		if(!$id){return false;}
		$db = Core::getDBO();
		$sql = "SELECT ac.*, act.title AS act_title, act.increase_action, act.decrease_action FROM accounts AS ac ";
		$sql .= "INNER JOIN account_categories AS act ON (ac.account_category= act.id) ";
		$sql .= "WHERE ac.published=1 AND id={$id} LIMIT 1 ";
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function setAccountByID($data){
		$db = Core::getDBO();
		if(!$this->validateData($data)){return false;}
		$sql = "UPDATE accounts ";
		$sql .= "SET title='{$data['title']}', ";
		$sql .= "alias='{$data['alias']}', ";
		$sql .= "published='{$data['published']}', ";
		$sql .= "account_category='{$data['account_category']}', ";
		$sql .= "comments={$data['comments']} ";
		$sql .= "WHERE id='{$data['id']}'";
		$ru = $db->update_by_sql($sql);
		$message='';
		if(!$ru){
			$message .= ': Record not updated.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		return true;
		
	}

	public function add_transaction_details($data){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$error=false;
		//print_r($data);exit;
		$db->start();
		$transaction_id=$this->newTransaction($data);
		if(!$transaction_id){
			$db->rollback();
			return false;
		}
		$view = new View();
		$trans = $data['trans'];
		$ids='';
		if(isset($trans['account_id']) && $trans['account_id']){
			$ids = implode(',',$trans['account_id']);
		}
		$ac_model=$view->getModel('accounts.accounts');
		//echo $ids;
		$acs = $ac_model->getAccounts(0,$ids);
		$c_trans = count($trans['account_id']);
		//echo $c_trans;
		//print_r($trans);
		$trans_ac = $trans['account_id'];
		$trans_action = $trans['account_action'];
		$trans_val = $trans['action_value'];
		for($x=0;$x<$c_trans;$x++){
			//$transaction_id=$t['transaction_id'];
			$account_id=$trans_ac[$x];
			$account_action=$trans_action[$x];
			$action_value=$trans_val[$x];
			//echo $action_value . '....' . $account_id . '<br/>';
			$sql = "INSERT INTO account_trans_details ";
			$sql .= "(transaction_id,account_id,account_action,action_value) VALUES ( ";
			$sql .= "'{$transaction_id}', ";
			$sql .= "'{$account_id}', ";
			$sql .= "'{$account_action}', ";
			$sql .= "'{$action_value}' ";
			$sql .= ")";
			//echo $sql;
			$i = $db->insert_by_sql($sql);
			//$min_value = $art['min_value'];
			//$max_value = $art['max_value'];
			//print_r($art);exit;
			//echo 'stock ' . $stock_after . ' ' .$min_stock . '<br/>';
			/*if($min_stock>=$stock_after){
				$msg="<h3>Low stock Alert</h3>";
				$msg.='<p><a href="?com=articles&view=branch_articles&id=' . $article_code .  '">' . $title . '</a></p>';
				$msg.="<p>Current stock: {$stock_after}</p>";
				$msg.="<p>Min stock: {$min_stock}</p>";
				$msg.="<p>User ID: {$u['user_id']}</p>";
				$msg.="<p>User Name: {$u['full_name']}</p>";
				//echo $msg;
				$cc = $c['admin_id'];
				$msg_model->sendMessage($msg,"Insufficent Item balance: {$article_code} - {$title}",0,$cc);
			}*/
			//if($qty > $stock){return $sale_id;}
			
			//check if branch_account not exists then create new one
			//update account if exists otherwise insert new....
			//print_r($acs);
			$ac = $acs[$account_id];
			//print_r($acs[$account_id]);
			if(isset($ac['branch_id']) && $ac['branch_id']){
				$sql = "UPDATE branch_accounts ";
				$sql .= "SET ";
				if($ac['increase_action']==$account_action){
					$sql .= "account_value = account_value + {$action_value} ";
				}else{
					$sql .= "account_value = account_value - {$action_value} ";
				}
				$sql .= "WHERE branch_id='{$branch_id}' AND account_id = '{$account_id}'";
				//echo $sql;exit;
				$u = $db->update_by_sql($sql);
				if(!$i || !$u){
					$error =true;
				}
			}else{
				$sql = "INSERT INTO branch_accounts (branch_id, account_id, account_value) VALUES ( ";
				if($ac['increase_action']==$account_action){
					$ins_account_value = 0+$action_value;
				}else{
					$ins_account_value = 0-$action_value;
				}
			$sql .= "{$branch_id}, {$account_id}, {$ins_account_value} )";
				//echo $sql;exit;
				$u = $db->update_by_sql($sql);
				if(!$i || !$u){
					$error =true;
				}
			}
		//return $message;
		
		}
		if(!$error){
			$db->commit();
		}else{
			$db->rollback();
		}
		
		return $transaction_id;
		
	}

	public function newTransaction($data){
		//print_r($data);exit;
		$db = Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$user_id = $u['user_id'];
		$transaction_date=date('Y-m-d');
		if(isset($data['transaction_date']) && $data['transaction_date']){
			$transaction_date=$data['transaction_date'];
		}
		$sql = "INSERT INTO account_transactions ";
		$sql .= "(transaction_date,ref_no,comments,branch_id,user_id) VALUES ( ";
		$sql .= "'{$transaction_date}', ";
		$sql .= "'{$data['account']['ref_no']}', ";
		$sql .= "'{$data['account']['comments']}', ";
		$sql .= "'{$branch_id}', ";
		$sql .= "'{$user_id}' ";
		$sql .= ")";
		$ri = $db->update_by_sql($sql);
		//echo $sql;exit;
		$message='';
		if(!$ri){
			return false;
		}
		if($db->insert_id()){
			$id = $db->insert_id();
			return $id;
		}
		return false;
	}

	public function createAccount($data){
		//print_r($data);exit;
		$db = Core::getDBO();
		$sql = "INSERT INTO accounts ";
		$sql .= "(title,alias,published,account_category, comments) VALUES ( ";
		$sql .= "'{$data['title']}', ";
		$sql .= "'{$data['alias']}', ";
		$sql .= "'{$data['published']}', ";
		$sql .= "'{$data['account_category']}', ";
		$sql .= "'{$data['comments']}' ";
		$sql .= ")";
		$ri = $db->update_by_sql($sql);
		//echo $sql;exit;
		$message='';
		if(!$ri){
			$message .= ': Record not saved.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		return true;
	}



}
