<?php
defined('_MEXEC') or die ('Restricted Access');


class ModelCategories extends Model{

	public function getParents(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "SELECT ac.* FROM article_cats AS ac ";
		$sql .= "WHERE ac.published=1 AND ac.parent_cat IS NULL AND branch_id=0 OR branch_id={$u['branch_id']}";
		
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getChilds2____(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "SELECT ac.id, ac.title, acp.title AS parent_title, count(ba.article_code) AS bra_art_count ";
		$sql .= "FROM article_cats AS ac ";
		$sql .= "RIGHT JOIN article_cats AS acp ON (ac.parent_cat = acp.id) ";
		$sql .= "RIGHT JOIN articles AS a ON (a.category = ac.id) ";
		$sql .= "RIGHT JOIN branch_articles AS ba ON (a.article_code = ba.article_code) ";
		$sql .= "WHERE ac.published=1 AND ac.parent_cat IS NOT NULL AND ac.branch_id=0 OR ac.branch_id={$u['branch_id']}";
		
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getChilds3____(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "SELECT ac.id, ac.title, acp.title AS parent_title, count(ba.article_code) AS bra_art_count ";
		$sql .= "FROM branch_articles AS ba LEFT JOIN articles AS a ON (a.article_code = ba.article_code) ";
		//$sql .= "FROM articles AS a LEFT JOIN branch_articles AS ba ON (a.article_code = ba.article_code) ";
		$sql .= "LEFT JOIN article_cats AS ac ON (a.category = ac.id) ";
		$sql .= "LEFT JOIN article_cats AS acp ON (ac.parent_cat = acp.id) ";
		$sql .= "WHERE ac.branch_id=0 OR ac.branch_id={$u['branch_id']}";
		
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}


	public function getChilds(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "SELECT ac.id, ac.title, acp.title AS parent_title, count(a.article_code) AS all_arts, count(ba.article_code) AS bra_art_count, sum(ba.qty) AS item_sum, sum(if(ba.qty<=ba.min_stock,1,0)) AS low_stock ";
		//$sql = "SELECT a.article_code as id, a.title, '' AS parent_title, (a.article_code) AS bra_art_count ";
		$sql .= "FROM articles AS a LEFT JOIN branch_articles AS ba ON (a.article_code = ba.article_code) ";
		$sql .= "LEFT JOIN article_cats AS ac ON (a.category = ac.id) ";
		$sql .= "LEFT JOIN article_cats AS acp ON (ac.parent_cat = acp.id) ";
		$sql .= "WHERE ac.branch_id=0 OR ac.branch_id={$u['branch_id']}";
		
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getCategories() {
		$db=Core::getDBO();
		$sql  = "SELECT ac.*,acp.title AS parent_title FROM article_cats AS ac INNER JOIN article_cats AS acp ON (ac.parent_cat=acp.id) ";
		$sql  .= "WHERE ac.published = 1 AND acp.published=1 ";

		return $db->get_by_sqlRows($sql);
	}

	public function getCategoriesHTML($selected=0) {	
		$rows = $this->getCategories();
		//print_r($rows);exit;
		if(!$rows){return false;}
		//$html = '<SELECT name="' . $name . '" id="' . $name . '" class="' . $name . '">';
		$options = array();
		foreach ($rows as $row){
			//print_r($row);echo '<br/><br/>';
			$sel = "";
			if($row['id'] == $selected){$sel='selected="selected"';}
			
			$opt = '<OPTION value="' . $row['id'] . '" ' . $sel . '>' . $row['title'] . '</OPTION>';
			$options[$row['parent_cat']]['name'] = $row['parent_title'];
			$options[$row['parent_cat']][] = $opt;
		}
		//$html .= '</SELECT>';
		return $options;
	}	

}

