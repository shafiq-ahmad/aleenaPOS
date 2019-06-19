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

if(!class_exists('Model')){
	import('core.application.component.model');
}
class ModelBranch_articles extends Model{
	
	public function getData(){
		$rows = $this->getBranchArticles();
		return $rows;
	}

	public function getBranchArticles(){
		$db=Core::getDBO();
		$u = Core::getUser()->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT a.*, ba.cost_price, ba.sale_price, ba.qty, ba.loc_store, ba.loc_section, ba.loc_rack, ba.loc, acs.title AS category_title, ac.title AS sub_category_title, CONCAT(a.title, ' - ', ac.title, ' - ', acs.title) AS searchTxt  FROM articles AS a ";
		$sql .= "INNER JOIN branch_articles AS ba ON (a.article_code = ba.article_code) ";
		$sql .= "INNER JOIN article_cats AS ac ON (a.category= ac.id) ";
		$sql .= "INNER JOIN article_cats AS acs ON (ac.parent_cat = acs.id) ";
		$sql .= "WHERE a.published=1 AND ba.branch_id = {$branch_id} AND ac.parent_cat IS NOT NULL  ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

}
