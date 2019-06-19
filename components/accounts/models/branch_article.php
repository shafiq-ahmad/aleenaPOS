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

class ModelBranch_article extends Model{

	public function getDataByID($id){
		$db = Core::getDBO();
		$sql = "SELECT a.*, c.title AS category_name, b.title AS brand_name FROM articles AS a  ";
		$sql .= "LEFT JOIN article_cats AS c ON (a.category = c.id) ";
		$sql .= "LEFT JOIN article_brands AS b ON (a.brand = b.id) ";
		$sql .= "WHERE article_code={$id} LIMIT 1";
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function getBranchData($id){
		if(!$id){return false;}
		$db = Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "SELECT * FROM branch_articles WHERE article_code={$id} AND branch_id={$branch_id}";
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function setData($data){
		$db = Core::getDBO();
		$user = Core::getUser();
		validateData($data);
		$c = $user->getCompany();
		$branch_id = $c['id'];
		if($data['seasons']){
			$seasons = "'{$data['seasons']}'";
		}else{
			$seasons = 'null';
		}
		$sql = "UPDATE branch_articles ";
		$sql .= "SET cost_price='{$data['cost_price']}', ";
		$sql .= "whole_sale_price='{$data['whole_sale_price']}', ";
		$sql .= "sale_price='{$data['sale_price']}', ";
		//$sql .= "qty='{$data['qty']}', ";
		$sql .= "discount='{$data['discount']}', ";
		$sql .= "seasonal='{$data['seasonal']}', ";
		$sql .= "seasons={$seasons}, ";
		$sql .= "status={$data['status']}, ";
		$sql .= "min_stock='{$data['min_stock']}', ";
		$sql .= "max_stock='{$data['max_stock']}', ";
		$sql .= "loc_store='{$data['loc_store']}', ";
		$sql .= "loc_section='{$data['loc_section']}', ";
		$sql .= "loc_rack='{$data['loc_rack']}', ";
		$sql .= "loc='{$data['loc']}' ";
		$sql .= "WHERE branch_id='{$branch_id}' AND article_code = '{$_POST['id']}'";
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
		return true;
	}

	public function createData($data){
		$db = Core::getDBO();
		validateData($data);
		$sql = "INSERT INTO articles ";
		$sql .= "(article_code,ref_code,comments,title,title_urdu,category,sub_category,brand,art_size,unit,packing) VALUES ( ";
		$sql .= "'{$data['article_code']}', ";
		$sql .= "'{$data['ref_code']}', ";
		$sql .= "'{$data['comments']}', ";
		$sql .= "'{$data['title']}', ";
		$sql .= "'{$data['title_urdu']}', ";
		$sql .= "'{$data['category']}', ";
		$sql .= "'{$data['sub_category']}', ";
		$sql .= "'{$data['brand']}', ";
		$sql .= "'{$data['size']}', ";
		$sql .= "'{$data['unit']}', ";
		$sql .= "'{$data['packing']}' ";
		$sql .= ")";
		$ri = $db->update_by_sql($sql);
		$message='';
		if($ri){
			$message .= ': Record saved.<br/>';
			//$db->setMessage($message);
		}else{
			$message .= ': Record not saved.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		return true;
	}

	public function createRecord(){
		$db = Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		//validateData($data);
		$sql = "INSERT INTO branch_articles ";
		//$sql .= "(branch_id,article_id,cost_price,whole_sale_price,sale_price,qty,discount,seasonal,seasons,status,min_stock,max_stock,loc_store,loc_section,loc_rack,loc) VALUES ( ";
		$sql .= "(branch_id,article_code) VALUES ( ";
		$sql .= "'{$branch_id}', ";
		$sql .= "'{$_GET['id']}' ";

		$sql .= ")";
		$ri = $db->update_by_sql($sql);
		$message='';
		if($ri){
			$message .= ': Record saved.<br/>';
			//$db->setMessage($message);
		}else{
			$message .= ': Record not saved.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		return true;
	}

	private function validateData(&$data){
		$article_code = 0;
		if(isset($data['article_code']) && $data['article_code']){
			$article_code = $data['article_code'];
		}elseif(isset($_GET['id']) && $_GET['id']){
			$article_code = $_GET['id'];
		}
		if(!$article_code){
			setMessage('Invalid Item code.');
			return false;
		}
		if(!$data['cost_price']){
			$cost_price = 0;
		}
		if(!$data['sale_price']){
			setMessage('Please enter a Sale price.');
			return false;
		}
		if(!$data['whole_sale_price']){
			$data['whole_sale_price']=0;
		}
		if(!$data['qty']){
			$data['qty']=0;
		}
		if(!$data['discount']){
			$data['discount']=0;
		}
		if(!$data['seasonal']){
			$data['seasonal']=0;
		}
		if(!$data['seasons']){
			$data['seasons']=""; //JSON
		}
		if(!$data['status']){
			$data['status']=0;
		}
		if(!$data['min_stock']){
			$data['min_stock']=0;
		}
		if(!$data['max_stock']){
			$data['max_stock']=0;
		}
		if(!$data['loc_store']){
			$data['loc_store']=""; //need to convert into new numaric store foriegn id
		}
		if(!$data['loc_section']){
			$data['loc_section']="";
		}
		if(!$data['loc_rack']){
			$data['loc_rack']="";
		}
		if(!$data['loc']){
			$data['loc']="";
		}
		return $data;
	}


}
