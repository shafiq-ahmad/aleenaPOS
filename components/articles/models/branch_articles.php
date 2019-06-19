<?php
defined('_MEXEC') or die ('Restricted Access');

if(!class_exists('Model')){
	import('core.application.component.model');
}
class ModelBranch_articles extends Model{
	
	public function getData(){
		$rows = $this->getBranchArticles();
		return $rows;
	}

	public function _getBranchArticles(){
		$db=Core::getDBO();
		$u = Core::getUser()->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT arts.article_code, arts.ref_code, arts.title, arts.published, arts.comments, arts.category, arts.brand, arts.art_size, arts.unit, arts.packing, ";
		$sql .= "arts.cost_price, arts.sale_price, arts.qty, arts.loc_store, arts.loc_section, arts.loc_rack, arts.loc, arts.discount, ";
		$sql .= "cats.sub_category_title, cats.category_title, ";
		$sql .= "CONCAT(arts.title, ' - ', IFNULL(cats.sub_category_title,''), ' - ', IFNULL(cats.category_title,'')) AS searchTxt ";
		$sql .= "FROM ( ";
		$sql .= "SELECT a.article_code, a.ref_code, a.title, a.published, a.comments, a.category, a.brand, a.art_size, a.unit, a.packing, ";
		$sql .= "ba.cost_price, ba.sale_price, ba.qty, ba.loc_store, ba.loc_section, ba.loc_rack, ba.loc, ba.discount FROM articles AS a ";
		$sql .= "INNER JOIN branch_articles AS ba ON (a.article_code = ba.article_code) ";
		$sql .= "WHERE a.published=1 AND ba.branch_id = {$branch_id} ";
		$sql .= ") AS arts ";
		$sql .= "LEFT JOIN (";
		$sql .= "SELECT ac.id, acs.title AS category_title, ac.title AS sub_category_title ";
		$sql .= "FROM article_cats AS ac ";
		$sql .= "LEFT JOIN article_cats AS acs ON (ac.parent_cat = acs.id) ";
		$sql .= ") AS cats ";
		$sql .= "ON (arts.category= cats.id) ";
		//$sql .= "WHERE ac.parent_cat IS NOT NULL  ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getArtsExpiry(){
		$db=Core::getDBO();
		$u = Core::getUser()->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT a.article_code, a.ref_code, a.title, a.published, a.comments, a.category, a.brand, a.art_size, a.unit, a.packing, ";
		$sql .= "ba.cost_price, ba.sale_price, ba.qty, ba.loc_section, ba.loc_rack, ba.loc, ba.discount, ba.stock_expiry_dates, ba.expiry_alert_days FROM articles AS a ";
		$sql .= "INNER JOIN branch_articles AS ba ON (a.article_code = ba.article_code) ";
		$sql .= "WHERE a.published=1 AND ba.branch_id = {$branch_id} AND ba.stock_expiry_dates IS NOT NULL ";
		$sql .= " ";
		//$sql .= "WHERE ac.parent_cat IS NOT NULL  ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}


	public function getArticlesComboList($txt=''){
		$db=Core::getDBO();
		$u = Core::getUser()->getUser();
		$branch_id = $u['branch_id'];
		//$sql = "SELECT a.article_code, CONCAT(a.title, ' ', a.art_size, a.unit, ' ', ba.sale_price) AS itemDesc FROM articles AS a ";
		$sql = "SELECT a.article_code, CONCAT(a.title, ' ', ba.sale_price) AS label FROM articles AS a ";
		$sql .= "INNER JOIN branch_articles AS ba ON (a.article_code = ba.article_code) ";
		$sql .= "WHERE a.published=1 AND ba.branch_id = {$branch_id} ";
		if($txt){
			$sql .= " AND a.title LIKE '%{$txt}%' ";
		}
		//$sql .= "WHERE ac.parent_cat IS NOT NULL  ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getBranchArticles($txt=''){
		$db=Core::getDBO();
		$u = Core::getUser()->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT a.article_code, a.ref_code, a.title, a.published, a.comments, a.category, a.brand, a.art_size, a.unit, a.packing, ";
		$sql .= "ba.cost_price, ba.sale_price, ba.qty, ba.loc_store, ba.loc_section, ba.loc_rack, ba.loc, ba.discount, ba.stock_expiry_dates, ba.sale_price_terms ";
		$sql .= " ";
		$sql .= "FROM articles AS a ";
		$sql .= "INNER JOIN branch_articles AS ba ON (a.article_code = ba.article_code) ";
		$sql .= "WHERE a.published=1 AND ba.branch_id = {$branch_id} ";
		if($txt){
			$sql .= " AND a.title LIKE '%{$txt}%' ";
		}
		//$sql .= "WHERE ac.parent_cat IS NOT NULL  ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}


	public function getBranchStockAlerts($txt=''){
		$db=Core::getDBO();
		$u = Core::getUser()->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT a.article_code, a.ref_code, a.title, a.published, a.comments, a.category, a.brand, a.art_size, a.unit, a.packing, ";
		$sql .= "ba.cost_price, ba.sale_price, ba.qty, ba.min_stock, ba.loc_store, ba.loc_section, ba.loc_rack, ba.loc, ba.discount FROM articles AS a ";
		$sql .= "INNER JOIN branch_articles AS ba ON (a.article_code = ba.article_code) ";
		$sql .= "WHERE a.published=1 AND ba.branch_id = {$branch_id} AND ba.qty <= ba.min_stock AND ba.min_stock <>0 ";
		if($txt){
			$sql .= " AND a.title LIKE '%{$txt}%' ";
		}
		//$sql .= "WHERE ac.parent_cat IS NOT NULL  ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}


}
