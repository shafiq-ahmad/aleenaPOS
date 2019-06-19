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

	public function getDataByID($id){
		$db=Core::getDBO();
		$sql = "SELECT * FROM suppliers WHERE id={$id} LIMIT 1";
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function getArticles($supplier_id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "SELECT DISTINCT(a.article_code), a.title, CONCAT(a.title, ' - ', ac.title, ' - ', acs.title) AS category, bpa.unit_price  FROM suppliers AS s ";
		$sql .= "INNER JOIN branch_purchases AS bp ON (bp.supplier_id = s.id) ";
		$sql .= "INNER JOIN branch_purchase_articles AS bpa ON (bpa.purchase_id = bp.purchase_id) ";
		$sql .= "INNER JOIN articles AS a ON (bpa.article_code = a.article_code) ";
		$sql .= "LEFT JOIN article_cats AS ac ON (a.category= ac.id) ";
		$sql .= "LEFT JOIN article_cats AS acs ON (ac.parent_cat = acs.id) ";
		$sql  .= "WHERE s.id={$supplier_id} AND s.branch_id={$branch_id} ";
		//$sql .= "ORDER BY ord ASC ";
		
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function setData($data){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$com = Application::$options->com;
		$view = Application::$options->view;
		$link="?";
		if($com){$link .= "com={$com}";}
		if($view){$link .= "&view={$view}";}
		if($data['id']){$link .= "&id={$data['id']}";}
		if(!$this->validateData($data)){
			$db->redirect("{$link}");
			return false;
		}
		$branch_id = $u['branch_id'];
		$sql = "UPDATE suppliers ";
		$sql .= "SET ";
		//$sql .= "ledger_code='{$data['ledger_code']}', ";
		$sql .= "title='{$data['title']}', ";
		$sql .= "contact_person='{$data['contact_person']}', ";
		$sql .= "type_of_items='{$data['type_of_items']}', ";
		$sql .= "address='{$data['address']}', ";
		$sql .= "cnic='{$data['cnic']}', ";
		$sql .= "terms_conditions='{$data['terms_conditions']}', ";
		$sql .= "account_no='{$data['account_no']}', ";
		$sql .= "phone='{$data['phone']}', ";
		$sql .= "no_of_days='{$data['no_of_days']}', ";
		$sql .= "fax_no='{$data['fax_no']}', ";
		$sql .= "mobile_no='{$data['mobile_no']}', ";
		
		$sql .= "e_mail='{$data['e_mail']}', ";
		$sql .= "ntn='{$data['ntn']}', ";
		$sql .= "gst_no='{$data['gst_no']}', ";
		$sql .= "opening_balance='{$data['opening_balance']}', ";
		$sql .= "closing_balance='{$data['closing_balance']}', ";
		$sql .= "lng='{$data['lng']}', ";
		$sql .= "mobile_no='{$data['mobile_no']}', ";
		$sql .= "lat={$data['lat']} ";
		$sql .= "WHERE id='{$data['id']}' AND branch_id = {$branch_id}";
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
		$db->redirect("{$link}");
	}

	public function validateData(&$data){
		$db=Core::getDBO();
		if(!$data['title']){
			$db->setMessage('Invalid Title.');
			return false;
		}
		if(!$data['contact_person']){
			$data['contact_person'] = '';
		}
		if(!$data['no_of_days']){
			$data['no_of_days'] = 0;
		}
		if(!$data['opening_balance']){
			$data['opening_balance'] = 0;
		}
		if(!$data['closing_balance']){
			$data['closing_balance'] = 0;
		}
		if(!$data['lng']){
			$data['lng'] = 0;
		}
		if(!$data['lat']){
			$data['lat'] = 0;
		}
		return $data;
	}

	public function createData($data){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$com = Application::$options->com;
		$view = Application::$options->view;
		$link="?";
		if($com){$link .= "com={$com}";}
		if($view){$link .= "&view={$view}";}
		if(!$this->validateData($data)){
			$db->redirect("{$link}");
			return false;
		}
		$u = $user->getUser();
		$c = $user->getCompany();
		$branch_id = $u['branch_id'];
		$sql = "INSERT INTO suppliers ";
		$sql .= "(title,contact_person,type_of_items,address,cnic,terms_conditions,account_no,";
		$sql .= "phone,no_of_days,fax_no,mobile_no,e_mail,ntn,gst_no,opening_balance,closing_balance,branch_id,lng, ";
		$sql .= "lat) VALUES ( ";
		//$sql .= "'{$data['ledger_code']}', ";
		$sql .= "'{$data['title']}', ";
		//$sql .= "'{$data['supplier_type']}', ";
		$sql .= "'{$data['contact_person']}', ";
		$sql .= "'{$data['type_of_items']}', ";
		$sql .= "'{$data['address']}', ";
		$sql .= "'{$data['cnic']}', ";
		$sql .= "'{$data['terms_conditions']}', ";
		$sql .= "'{$data['account_no']}', ";
		$sql .= "'{$data['phone']}', ";
		$sql .= "'{$data['no_of_days']}', ";
		$sql .= "'{$data['fax_no']}', ";
		$sql .= "'{$data['mobile_no']}', ";
		$sql .= "'{$data['e_mail']}', ";
		$sql .= "'{$data['ntn']}', ";
		$sql .= "'{$data['gst_no']}', ";
		$sql .= "'{$data['opening_balance']}', ";
		$sql .= "'{$data['closing_balance']}', ";
		$sql .= "'{$branch_id}', ";
		$sql .= "'{$data['lng']}', ";
		$sql .= "'{$data['lat']}' ";
		$sql .= ")";
		$ri = $db->update_by_sql($sql);
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
			$link .= "&id={$id}";
			$db->redirect("{$link}");
		}
		return false;
	}

}