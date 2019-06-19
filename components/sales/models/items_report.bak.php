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


class ModelItems_report extends Model{

	public function getBranchSalesByItems(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$report_type = 'items';
		if(isset($_GET['report_type'])){
			$report_type = $_GET['report_type'];
		}
		$branch_id = $u['branch_id'];
		$user_id = $u['user_id'];
		$start_date='';
		$end_date='';
		if(isset($_GET['start_date'])){
			$start_date = $db->toDBDate($_GET['start_date']);
		}else{
			$start_date = $db->getCurrentDate('date');
		}
		if(isset($_GET['end_date'])){
			$end_date = $db->toDBDate($_GET['end_date']);
		}else{
			$end_date = $db->getCurrentDate('date');
		}
		//$start_date='2018-06-13';
		$sql = "SELECT ";
		if($report_type=='items' || $report_type=='customer'){
			$sql .= "a.article_code, pac.title AS pcat_title, ac.title AS cat_title, a.title, a.unit, ";
			if($report_type=='customer'){
				$sql .= "c.title AS customer_title, ";
			}
		}elseif($report_type=='daily'){
			$sql .= "bs.sale_date AS periodic, ";
		}elseif($report_type=='weekly'){
			$sql .= "WEEK(bs.sale_date) AS periodic, ";
		}elseif($report_type=='monthly'){
			$sql .= "MONTH(bs.sale_date) AS periodic, ";
		}elseif($report_type=='quarterly'){
			$sql .= "QUARTER(bs.sale_date) AS periodic, ";
		}elseif($report_type=='yearly'){
			$sql .= "YEAR(bs.sale_date) AS periodic, ";
		}
		$sql .= "AVG(bsa.price) AS salePrice, AVG(bsa.cost_price) AS costPrice, ";
		$sql .= "SUM(bsa.qty) AS sale_qty, SUM(bsa.price*bsa.qty) AS total, SUM((bsa.price - bsa.cost_price)*bsa.qty) AS margin ";
		$sql .= "";
		$sql .= "FROM branch_sales AS bs ";
		$sql .= "LEFT JOIN branch_sale_articles AS bsa ON (bsa.sale_id = bs.id) ";
		//$sql .= "LEFT JOIN customers AS c ON (bs.customer_id = c.id) ";
		//$sql .= "LEFT JOIN branch_articles AS ba ON (bsa.article_code = ba.article_code) ";
		$sql .= "LEFT JOIN articles AS a ON (bsa.article_code = a.article_code) ";
		if($report_type=='customer'){
			$sql .= "LEFT JOIN customers AS c ON (bs.customer_id = c.id) ";
		}
		if($report_type=='items' || $report_type=='customer'){
			$sql .= "LEFT JOIN article_cats AS ac ON (ac.id = a.category) ";
			$sql .= "LEFT JOIN article_cats AS pac ON (pac.id = ac.parent_cat) ";
		}
		$sql .= "WHERE bs.branch_id = {$branch_id} AND a.article_code IS NOT NULL ";
		if($start_date && $end_date){
			$sql .= " AND bs.sale_date >= '{$start_date}' AND bs.sale_date <='{$end_date}' ";
		}
		if($report_type=='items' || $report_type=='customer'){
			$sql .= "GROUP BY a.article_code, pcat_title, cat_title, a.unit, a.title ";
		}elseif($report_type=='daily'){
			$sql .= "GROUP BY bs.sale_date ";
		}elseif($report_type=='weekly'){
			$sql .= "GROUP BY WEEK(bs.sale_date) ";
		}elseif($report_type=='monthly'){
			$sql .= "GROUP BY MONTH(bs.sale_date) ";
		}elseif($report_type=='quarterly'){
			$sql .= "GROUP BY QUARTER(bs.sale_date) ";
		}elseif($report_type=='yearly'){
			$sql .= "GROUP BY YEAR(bs.sale_date) ";
		}elseif($report_type=='customer'){
			$sql .= ",c.id ";
		}
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		//print_r ($rows);exit;
		return $rows;
	}

}
