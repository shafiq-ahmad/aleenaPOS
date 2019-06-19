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

class ModelBranch_report extends Model{
	
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
		$db = Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "SELECT * FROM branch_articles WHERE article_code={$id} AND branch_id={$branch_id}";
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

}

