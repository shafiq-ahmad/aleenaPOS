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

	public function getBranchSalesArticles(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
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
		$sql = "SELECT * FROM branch_sales AS bs ";
		$sql .= "WHERE bs.branch_id = {$branch_id} AND data_articles<>'' ";
		if($start_date && $end_date){
			$sql .= "AND bs.sale_date >= '{$start_date}' AND bs.sale_date <='{$end_date}' ";
		}
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		//print_r ($rows);//exit;
		return $rows;
	}
	
	public function getBranchSalesByItems(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
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
		$sql = "SELECT bs.*, u.full_name FROM branch_sales AS bs ";
		$sql .= "INNER JOIN users AS u ON (bs.user_id = u.user_id) ";
		$sql .= "WHERE bs.branch_id = {$branch_id} ";
		if($start_date && $end_date){
			$sql .= "AND bs.sale_date >= '{$start_date}' AND bs.sale_date <='{$end_date}' ";
		}
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		//print_r ($rows);//exit;
		return $rows;
	}

}
