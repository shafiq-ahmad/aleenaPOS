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

class ModelArticles extends Model{
	
	public function getData(){
		$db = Core::getDBO();
		/*$sql = "SELECT a.*, ac.title AS category_title, acs.title AS sub_category_title FROM articles AS a INNER JOIN article_cats AS ac ON (a.category= ac.id) ";
		$sql .= "INNER JOIN article_cats AS acs ON (a.sub_category = acs.id) ";
		$sql .= "WHERE a.published=1 AND ac.parent_cat IS NULL AND acs.parent_cat IS NOT NULL ";*/
		$sql = "SELECT a.*, acs.title AS category_title, ac.title AS sub_category_title FROM articles AS a INNER JOIN article_cats AS ac ON (a.category= ac.id) ";
		$sql .= "INNER JOIN article_cats AS acs ON (ac.parent_cat = acs.id) ";
		$sql .= "WHERE a.published=1 AND ac.parent_cat IS NOT NULL ";
		
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}


}