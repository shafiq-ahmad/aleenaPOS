<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelArticle extends Model{
	
	public function getDataByID($id){
		if(!$id){return false;}
		$db = Core::getDBO();
		$sql = "SELECT * FROM articles WHERE article_code='{$id}' LIMIT 1";
		$row = $db->get_by_sqlRow($sql);
		//echo $sql;print_r($row);exit;
		return $row;
	}

	public function setData($data){
		$db = Core::getDBO();
		if(!$this->validateData($data)){return false;}
		$sql = "UPDATE articles ";
		$sql .= "SET article_code='{$data['article_code']}', ";
		$sql .= "comments='{$data['comments']}', ";
		$sql .= "title='{$data['title']}', ";
		//$sql .= "title_urdu='{$data['title_urdu']}', ";
		$sql .= "category={$data['category']}, ";
		//$sql .= "sub_category={$data['sub_category']}, ";
		$sql .= "brand={$data['brand']}, ";
		$sql .= "art_size='{$data['size']}', ";
		$sql .= "unit='{$data['unit']}', ";
		$tags = json_encode($data['tags']);
		$seasons = json_encode($data['seasons']);
		$sql .= "tags='{$tags}', ";
		$sql .= "seasons='{$seasons}', ";
		$sql .= "packing={$data['packing']} ";
		$sql .= "WHERE article_code='{$data['article_code']}'";
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
		//print_r($data);exit;
		$db = Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		if(!$this->validateData($data)){return false;}
		if($this->getDataByID($data['article_code'])){
			$message = ': Item already exists.<br/>';
			$db->setMessage($message);
			return false;
		}
		$sql = "INSERT INTO articles ";
		$sql .= "(article_code,comments,title,category,art_size,unit, ";
		$sql .= "tags, ";
		$sql .= "seasons, ";
		$sql .= "packing) VALUES ( ";
		$sql .= "'{$data['article_code']}', ";
		$sql .= "'{$data['comments']}', ";
		$sql .= "'{$data['title']}', ";
		$sql .= "'{$data['category']}', ";
		$sql .= "'{$data['size']}', ";
		$sql .= "'{$data['unit']}', ";
		$tags = json_encode($data['tags']);
		$seasons = json_encode($data['seasons']);
		$sql .= "'{$tags}', ";
		$sql .= "'{$seasons}', ";
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
		return $data['article_code'];
	}

	private function validateData(&$data){
		$db = Core::getDBO();
		if(!isset($data['article_code'])){
			$db->setMessage('Invalid Item code.');
			return false;
		}
		if(isset($data['title']) && !$data['title']){
			$db->setMessage('Please enter a Title.');
			return false;
		}
		if(isset($data['category']) && !$data['category']){
			$data['category']=0;
			//$db->setMessage('Please enter a category.');
			//return false;
		}
		if(isset($data['comments']) && !$data['comments']){
			$data['comments']="";
		}
		if(isset($data['brand']) && !$data['brand']){
			$data['brand']=0;
		}
		if(isset($data['size']) && !$data['size']){
			$data['size']=0;
		}
		if(isset($data['unit']) && !$data['unit']){
			$data['unit']="";
		}
		if(isset($data['packing']) && !$data['packing']){
			$data['packing']=1;
		}
		return $data;
	}

	public function getArticleByID($id){
		$db=Core::getDBO();
		$user = Core::getUser();
		$u = $user->getUser();
		//print_r( $id);exit;
		$branch_id = $u['branch_id'];
		$sql = "SELECT a.*, ba.cost_price, ba.sale_price, ba.qty, 1 AS qty1, ba.loc_store, ba.loc_section, ba.loc_rack, ba.loc, ";
		$sql .= "acs.title AS category_title, ac.title AS sub_category_title, ba.discount, ba.min_stock,ba.scheme,ba.sale_price_terms ";
		$sql .= "FROM articles AS a ";
		$sql .= "INNER JOIN branch_articles AS ba ON (a.article_code = ba.article_code) ";
		$sql .= "LEFT JOIN article_cats AS ac ON (a.category= ac.id) ";
		$sql .= "LEFT JOIN article_cats AS acs ON (ac.parent_cat = acs.id) ";
		$sql .= "WHERE a.published=1 AND ba.branch_id = '{$branch_id}' AND a.article_code = '{$id}'  ";
		//echo $sql;exit;
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}




}
