<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelCategory extends Model{

	public function getDataByID($id){
		$db=Core::getDBO();
		$sql = "SELECT * FROM article_cats AS ac ";
		$sql .= "WHERE id={$id} LIMIT 1";
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function setData($data){
		$db=Core::getDBO();
		if(!$this->validateData($data)){return false;}
		$sql = "UPDATE article_cats ";
		$sql .= "SET id='{$data['id']}', ";
		$sql .= "title='{$data['title']}', ";
		$sql .= "parent_cat='{$data['category']}', ";
		$sql .= "discount_per='{$data['discount_per']}', ";
		$sql .= "gst_per='{$data['gst_per']}' ";
		$sql .= "WHERE id='{$data['id']}'";
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
		
	}

	function createData($data){
		if(!$this->validateData($data)){return false;}
		$db=Core::getDBO();
		$category=$data['category'];
		$sql = "INSERT INTO article_cats ";
		$sql .= "(id,title,parent_cat,discount_per,gst_per) VALUES ( ";
		$sql .= "'{$data['id']}', ";
		$sql .= "'{$data['title']}', ";
		$sql .= "{$category}, ";
		$sql .= "'{$data['discount_per']}', ";
		$sql .= "'{$data['gst_per']}' ";
		$sql .= ")";
		$ri = $db->update_by_sql($sql);
		$message='';
		if($ri){
			$message .= ': Record saved.<br/>';
			$db->setMessage($message);
		}else{
			$message .= ': Record not saved.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
	}

	public function getCategory($id) {
		$db=Core::getDBO();
		$sql  = "SELECT * FROM article_cats WHERE published = 1 AND id={$id} ";

		return $db->get_by_sqlRow($sql);
	}


	public function validateData(&$data){
		$id = 0;
		if(isset($data['id']) && $data['id']){
			$id = $data['id'];
		}elseif(isset($_GET['id']) && $_GET['id']){
			$id = $_GET['id'];
		}
		if(!$id){
			setMessage('Invalid Category code.');
			return false;
		}
		if(!$data['title']){
			setMessage('Invalid title.');
			return false;
		}
		if(!$data['category']){
			$data['category']="NULL";
		}
		if(!$data['discount_per']){
			$data['discount_per']=0;
		}
		if(!$data['gst_per']){
			$data['gst_per']=0;
		}
		return $data;
	}

}

