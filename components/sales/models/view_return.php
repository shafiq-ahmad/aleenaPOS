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

class ModelView_return extends Model{

	public function getInvoiceByID($id){
		$db=Core::getDBO();
		$sql = "SELECT * FROM branch_sales WHERE id={$id} LIMIT 1";
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function getReturnInvoice($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT bsr.*, c.title AS cust_title, u.full_name ";
		$sql .= "FROM branch_sales_return AS bsr  ";
		$sql .= "LEFT JOIN customers AS c ON (bsr.customer_id = c.id) ";
		$sql .= "LEFT JOIN users AS u ON (bsr.user_id = u.user_id) ";
		$sql .= "WHERE bsr.branch_id = {$branch_id} AND bsr.id = {$id} ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRow($sql);
		return $rows;
	}

	public function getReturnInvoiceArticles($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT bsr.*, bsra.*, ac.title AS art_title, ac.ref_code, ba.cost_price AS actual_cost_price ";
		$sql .= "FROM branch_sales_return AS bsr  ";
		$sql .= "INNER JOIN branch_sale_return_articles AS bsra ON (bsr.id = bsra.return_id) ";
		$sql .= "INNER JOIN articles AS ac ON (bsra.article_code= ac.article_code) ";
		$sql .= "INNER JOIN branch_articles AS ba ON (ba.article_code= ac.article_code) ";
		$sql .= "WHERE bsr.branch_id = {$branch_id} AND bsr.id = {$id} ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function setInvArticleFromJSON($data){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$c=$user->getCompany();
		$error=false;
		//print_r($data);exit;
		$db->start();
		//print_r($data); exit;
		$branch_id = $u['branch_id'];
		$article_code_arr = $data['article_code'];
		$qty_arr = $data['qty'];
		$sale_id=$this->newInvoiceNo($data);
		if(!$sale_id){
			$db->rollback();
			return false;
		}
		$data['account']['ref_no']='sales.sale.'.$sale_id;
		$data['account']['comments']='';
		//echo $sale_id;exit;
		//print_r($c);exit;
		$view = new View();
		foreach($article_code_arr as $key => $article_code){
			$qty=$qty_arr[$key];
			$price=0;
			$discount=0;
			//echo $article_code . '<br/>';
			if(isset($data['discount']) && $data['discount']){
				$discount=$data['discount'];
			}
			$status=0;
			if(isset($data['status']) && $data['status']){
				$status=$data['status'];
			}
			$station_id=0;
			if(isset($data['station_id']) && $data['station_id']){
				$station_id=$data['station_id'];
			}
			$art_model=$view->getModel('articles.article');
			$msg_model=$view->getModel('messages.message');
			$art = $art_model->getArticleByID($article_code);
			$article_code = $art['article_code'];
			$title = $art['title'];
			$stock = $art['qty'];
			$cost_price = $art['cost_price'];
			$whole_sale_price = $art['whole_sale_price'];
			$price = $art['sale_price'];
			$min_stock = $art['min_stock'];
			$stock_after = $stock - $qty;
			//echo 'stock ' . $stock_after . ' ' .$min_stock . '<br/>';
			if($min_stock>=$stock_after){
				$msg="<h3>Low stock Alert</h3>";
				$msg.='<p><a href="?com=articles&view=branch_articles&id=' . $article_code .  '">' . $title . '</a></p>';
				$msg.="<p>Current stock: {$stock_after}</p>";
				$msg.="<p>Min stock: {$min_stock}</p>";
				$msg.="<p>User ID: {$u['user_id']}</p>";
				$msg.="<p>User Name: {$u['full_name']}</p>";
				//echo $msg;
				$cc = $c['admin_id'];
				$msg_model->sendMessage($msg,"Insufficent Item balance: {$article_code} - {$title}",0,$cc);
			}
			//if($qty > $stock){return $sale_id;}
			$sql = "INSERT INTO branch_sale_articles ";
			$sql .= "(sale_id,article_code,qty,in_hand,cost_price,whole_sale_price,price,discount,status,station_id) VALUES ( ";
			$sql .= "'{$sale_id}', ";
			$sql .= "'{$article_code}', ";
			$sql .= "'{$qty}', ";
			$sql .= "'{$stock}', ";
			$sql .= "'{$cost_price}', ";
			$sql .= "'{$whole_sale_price}', ";
			$sql .= "'{$price}', ";
			$sql .= "'{$discount}', ";
			$sql .= "'{$status}', ";
			$sql .= "'{$station_id}' ";
			$sql .= ")";
			$i = $db->insert_by_sql($sql);
			//print_r($art);exit;
			
			$sql = "UPDATE branch_articles ";
			$sql .= "SET qty = qty - {$qty} ";
			$sql .= "WHERE branch_id='{$branch_id}' AND article_code = '{$article_code}'";
			//echo $sql;exit;
			$u = $db->update_by_sql($sql);
			
			if(!$i || !$u){
				$error =true;
			}
		//return $message;
		
		}
		if($data['credit'] && $data['customer_id']){
			$cust_model=$view->getModel('customers.customer');
			$cust_res = $cust_model->setAccount($data['customer_id'],$data['credit'],'+');
			if(!$cust_res){return false;}
		}
		if($data['keep'] && $data['customer_id']){
			$cust_model=$view->getModel('customers.customer');
			$cust_res = $cust_model->setAccount($data['customer_id'],$data['keep'],'-');
			if(!$cust_res){return false;}
		}
		$ac_model=$view->getModel('accounts.account');
		$res_ac = $ac_model->add_transaction_details($data);
		//return false;
		if(!$error){
			$db->commit();
		}else{
			$db->rollback();
		}
		return $sale_id;
	}
	
	
	public function newInvoiceNo(&$data){
		$db=Core::getDBO();
		//$db->start();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		
		$sale_date=date('Y-m-d H:i:s');
		$customer_id=0;
		if(!isset($data['customer_id']) || !$data['customer_id']){
			$data['customer_id']=0;
		}
		$sale_status=0;
		$comments='';
		$method_of_payment=0;
		if(isset($data['sub_total']) && $data['sub_total']){
			$data['trans']['account_id'][] = 50100;
			$data['trans']['account_action'][] = 'Cr';
			$data['trans']['action_value'][] = $data['sub_total'];
		}
		if(isset($data['cash']) && $data['cash']){
			if(!$data['credit']){
				$data['cash'] = ($data['sub_total']+$data['keep']-$data['discount_amount']);
			}
			$data['trans']['account_id'][] = 10100;
			$data['trans']['account_action'][] = 'Dr';
			$data['trans']['action_value'][] = $data['cash'];
		}
		/*if(isset($data['bank_check']) && $data['bank_check']){
			$data['trans']['account_id'][] = 11200;
			$data['trans']['account_action'][] = 'Dr';
			$data['trans']['action_value'][] = $data['bank_check'];
		}
		if(isset($data['bank_card']) && $data['bank_card']){
			$data['trans']['account_id'][] = 11300;
			$data['trans']['account_action'][] = 'Dr';
			$data['trans']['action_value'][] = $data['bank_card'];
		}*/
		if(isset($data['credit']) && $data['credit']){
			$data['trans']['account_id'][] = 11400;
			$data['trans']['account_action'][] = 'Dr';
			$data['trans']['action_value'][] = $data['credit'];
		}
		if(isset($data['keep']) && $data['keep']){
			$data['trans']['account_id'][] = 11400;
			$data['trans']['account_action'][] = 'Cr';
			$data['trans']['action_value'][] = $data['keep'];
		}
		$change_return=0;
		if(isset($data['change']) && $data['change']){
			$change_return=$data['change'];
		}
		
		$discount_amount=0;
		$discount_percent=0;
		if(isset($data['discount_amount']) && $data['discount_amount']){
			$discount_amount=$data['discount_amount'];
			$discount_percent=($discount_amount/$data['sub_total'])*100;
			$data['trans']['account_id'][] = 30200;
			$data['trans']['account_action'][] = 'Dr';
			$data['trans']['action_value'][] = $data['discount_amount'];
		}
		$sale_type='Retail';
		if(isset($data['sale_type']) && $data['sale_type']){
			$sale_type=$data['sale_type'];
		}
		
		$user_id=$u['user_id'];
		$sql = "INSERT INTO branch_sales ";
		$sql .= "(sale_date,sale_type,customer_id,person,sale_status,comments,method_of_payment,branch_store,branch_id,sub_total,cash,bank_check, ";
		$sql .= "credit, bank_card, change_return, discount_percent, discount_amount, user_id) VALUES ( ";
		$sql .= "'{$sale_date}', ";
		$sql .= "'{$sale_type}', ";
		$sql .= "'{$data['customer_id']}', ";
		$sql .= "'{$data['person']}', ";
		$sql .= "'{$sale_status}', ";
		$sql .= "'{$comments}', ";
		$sql .= "'{$method_of_payment}', ";
		$sql .= "'0', ";
		$sql .= "'{$branch_id}', ";
		$sql .= "'{$data['sub_total']}', ";
		$sql .= "'{$data['cash']}', ";
		//$sql .= "'{$data['bank_check']}', ";
		$sql .= "0, ";
		$sql .= "'{$data['credit']}', ";
		//$sql .= "'{$data['bank_card']}', ";
		$sql .= "0, ";
		$sql .= "'{$change_return}', ";
		$sql .= "'{$discount_percent}', ";
		$sql .= "'{$discount_amount}', ";
		$sql .= "'{$user_id}' ";
		$sql .= ")";
		$ri = $db->insert_by_sql($sql);
		$message='';
		if($ri){
			//$message .= ': Record saved.<br/>';
			//$this->setMessage($message);
		}else{
			$message .= ': Record not saved.<br/>';
			$this->setMessage($message,'error');
			return false;
		}
		if($db->insert_id()){
			$id = $db->insert_id();
			return $id;
		}
		return false;
	}
}
