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


class ModelTest extends Model{

	public function setData(){
		$db=Core::getDBO();
		$error=false;
		//print_r($data);exit;
		$db->start();
		//$db->query('#SESSION 01');
		//if($qty > $stock){return $sale_id;}
		$sql = "INSERT INTO debug_log ";
		$sql .= "(log_type,log_data,user_id,err) VALUES ( ";
		$sql .= "'inserted', ";
		$sql .= "'data', ";
		$sql .= "'0', ";
		$sql .= "'{$error}' ";
		$sql .= ")";
		$i = $db->insert_by_sql($sql);
		//print_r($art);exit;
		$id = $db->insert_id();
		echo $db->affected_rows() . ' :rows<br/>';
		//$db->rollback();
		
		$sql = "UPDATE debug_log ";
		$sql .= "SET log_type = 'updated', err = '{$error}' ";
		$sql .= "WHERE id = '{$id}0'";
		//echo $sql;exit;
		$u = $db->update_by_sql($sql);
		echo $db->affected_rows() . ' :rows<br/>';
		//$db->rollback();
		if(!$i || !$u){
			$error =true;
		}
		//return $message;
		//$db->rollback();
		
		//return false;
		if(!$error){
			$db->commit();
		}else{
			echo 'ellor....';
			$db->rollback();
		}
		//$db->start();
		$sql = "UPDATE debug_log ";
		$sql .= "SET log_type = '{$id}', err = '{$error}' ";
		$sql .= "WHERE id = '88'";
		//echo $sql;exit;
		$u = $db->update_by_sql($sql);
		$db->rollback();

		return $id;
	}
}