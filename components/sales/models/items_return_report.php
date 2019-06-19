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

class ModelItems_return_report extends Model{

	function getBranchSalesByItems(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$user_id = $u['user_id'];
		$start_date='';
		$end_date='';
		if(isset($_POST['start_date'])){
			$start_date = $db->toDBDate($_POST['start_date']);
		}else{
			$start_date = $db->getCurrentDate('date');
		}
		if(isset($_POST['end_date'])){
			$end_date = $db->toDBDate($_POST['end_date']);
		}else{
			$end_date = $db->getCurrentDate('date');
		}
		//$start_date='2018-06-13';
		$sql = "SELECT a.article_code, pac.title AS pcat_title, ac.title AS cat_title, a.title, a.unit, AVG(bsra.price) AS salePrice, ";
		$sql .= "SUM(bsra.qty) AS return_qty, SUM(bsra.price*bsra.qty) AS total ";
		//$sql .= "SUM(bsra.price - bsra.cost_price) AS margin ";
		$sql .= "FROM branch_sales_return AS bsr ";
		$sql .= "LEFT JOIN customers AS c ON (bsr.customer_id = c.id) ";
		$sql .= "LEFT JOIN branch_sale_return_articles AS bsra ON (bsra.return_id = bsr.id) ";
		//$sql .= "LEFT JOIN branch_articles AS ba ON (bsra.article_code = ba.article_code) ";
		$sql .= "LEFT JOIN articles AS a ON (bsra.article_code = a.article_code) ";
		$sql .= "LEFT JOIN article_cats AS ac ON (ac.id = a.category) ";
		$sql .= "LEFT JOIN article_cats AS pac ON (pac.id = ac.parent_cat) ";
		
		$sql .= "WHERE bsr.branch_id = {$branch_id} AND a.article_code IS NOT NULL ";
		if($start_date && $end_date){
			$sql .= " AND bsr.return_date >= '{$start_date}' AND bsr.return_date <='{$end_date}' ";
		}
		$sql .= "GROUP BY a.article_code, pcat_title, cat_title, a.unit, a.title ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		//print_r ($rows);exit;
		return $rows;
	}

}
