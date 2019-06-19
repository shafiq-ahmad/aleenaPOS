<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelBranch_article extends Model{

	public function getBranchData($id){
		if(!$id){return false;}
		$db = Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "SELECT ba.*, a.* FROM branch_articles AS ba ";
		$sql .= "INNER JOIN articles AS a ON (ba.article_code=a.article_code)";
		$sql .= "WHERE ba.article_code='{$id}' AND branch_id={$branch_id} ";
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function setData($data){
		//print_r($data);exit;
		$db = Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		
		
		if(!$this->validateData($data)){return false;}
		if(isset($data['title']) && !$data['title']){
			$db->setMessage('Please enter a Title.');
			return false;
		}
		$sql = "UPDATE articles ";
		$sql .= "SET article_code='{$data['article_code']}', ";
		if(!$data['ref_code']){
			$sql .= "ref_code=NULL, ";
		}else{
			$sql .= "ref_code='{$data['ref_code']}', ";
		}
		$sql .= "comments='{$data['comments']}', ";
		$sql .= "title='{$data['title']}', ";
		//$sql .= "title_urdu='{$data['title_urdu']}', ";
		$sql .= "category={$data['category']}, ";
		//$sql .= "sub_category={$data['sub_category']}, ";
		//$sql .= "brand={$data['brand']}, ";
		$sql .= "art_size='{$data['size']}', ";
		$sql .= "unit='{$data['unit']}', ";
		$tags = json_encode($data['tags']);
		$seasons = json_encode($data['seasons']);
		$sql .= "tags='{$tags}', ";
		$sql .= "seasons='{$seasons}', ";
		$sql .= "packing={$data['packing']} ";
		$sql .= "WHERE article_code='{$data['article_code']}'";
		$rua = $db->update_by_sql($sql);
		$message='';
		if($rua){
			$message .= ': Record updated.<br/>';
			$db->setMessage($message);
		}
		
		
		
		$sale_price_terms='';
		$expiry_alert_days=$data['expiry_alert_days'];
		$sale_price_terms=$data['sale_price_terms'];
		$stock_expiry_dates=$data['stock_expiry_dates'];
		//$discount_terms=$data['discount_terms'];
		$sql = "UPDATE branch_articles ";
		$sql .= "SET cost_price='{$data['cost_price']}', ";
		$sql .= "sale_price='{$data['sale_price']}', ";
		//$sql .= "qty='{$data['qty']}', ";
		$sql .= "discount='{$data['discount']}', ";
		//$sql .= "seasonal='{$data['seasonal']}', ";
		//$sql .= "seasons={$seasons}, ";
		//$sql .= "status={$data['status']}, ";
		$sql .= "min_stock='{$data['min_stock']}', ";
		//$sql .= "max_stock='{$data['max_stock']}', ";
		//$sql .= "loc_store='{$data['loc_store']}', ";
		$sql .= "expiry_alert_days='{$data['expiry_alert_days']}', ";
		$sql .= "sale_price_terms='{$data['sale_price_terms']}', ";
		$sql .= "stock_expiry_dates='{$data['stock_expiry_dates']}', ";
		//$sql .= "discount_terms='{$data['discount_terms']}', ";
		
		$sql .= "loc_section='{$data['loc_section']}', ";
		$sql .= "loc_rack='{$data['loc_rack']}', ";
		$sql .= "loc='{$data['loc']}' ";
		$sql .= "WHERE branch_id='{$branch_id}' AND article_code = '{$_POST['id']}'";
		$ru = $db->update_by_sql($sql);
		$message='';
		if($ru){
			$message .= ': Record updated.<br/>';
			$db->setMessage($message);
		}
		return true;
	}

	public function createRecord($data=null){
		$db = Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$id=0;
		if(isset($_GET['id'])){
			$id = $_GET['id'];
		}elseif(isset($data['article_code'])){
			$id = $_POST['article_code'];
		}
		if(!$id){return false;}
		$this->validateData($data);
		if($this->getBranchData($id)){
			$message = ': Item record already exists.<br/>';
			$db->setMessage($message);
			return false;
		}
		$sql = "INSERT INTO branch_articles ";
		
		$sql .= "(branch_id,article_code,cost_price,sale_price,min_stock,discount,qty,expiry_alert_days,loc_section,loc_rack,loc,sale_price_terms,stock_expiry_dates) VALUES ( ";
		$sql .= "'{$branch_id}', ";
		$sql .= "'{$id}', ";
		$sql .= "'{$data['cost_price']}', ";
		$sql .= "'{$data['sale_price']}', ";
		$sql .= "'{$data['min_stock']}', ";
		$sql .= "'{$data['discount']}', ";
		$sql .= "'{$data['qty']}', ";
		$sql .= "'{$data['expiry_alert_days']}', ";
		$sql .= "'{$data['loc_section']}', ";
		$sql .= "'{$data['loc_rack']}', ";
		$sql .= "'{$data['loc']}', ";
		$sql .= "'{$data['sale_price_terms']}', ";
		$sql .= "'{$data['stock_expiry_dates']}' ";
		$sql .= ")";
		//echo $sql;exit;
		$ri = $db->insert_by_sql($sql);
		$message='';
		if($ri){
			$link = "?com=articles&view=branch_article&task=edit&id={$id}";
			$message .= $ri . ': Record saved. <a target="_blank" href="' . $link . '">Edit</a><br/>';
			$db->setMessage($message);
		}else{
			$message .= ': Record not saved.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		return true;
	}

	private function validateData(&$data){
		$db = Core::getDBO();
		$article_code = 0;
		if(isset($data['article_code']) && $data['article_code']){
			$article_code = $data['article_code'];
		}elseif(isset($_GET['id']) && $_GET['id']){
			$article_code = $_GET['id'];
		}
		if(!$article_code){
			$db->setMessage('Invalid Item code.');
			return false;
		}
		if(isset($data['category']) && !$data['category']){
			$data['category']=0;
		}
		if(isset($data['ref_code']) && !$data['ref_code']){
			$data['ref_code']="";
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
		if(!$data['cost_price']){
			$cost_price = 0;
		}
		if(!$data['sale_price']){
			$db->setMessage('Please enter a Sale price.');
			return false;
		}
		if(isset($data['qty']) && !$data['qty']){
			$data['qty']=0;
		}
		if(!$data['discount']){
			$data['discount']=0;
		}
		/*if(!$data['seasons']){
			$data['seasons']=""; //JSON
		}*/
		if(!$data['min_stock']){
			$data['min_stock']=0;
		}
		//if(!$data['loc_store']){
		//	$data['loc_store']=""; //need to convert into new numaric store foriegn id
		//}
		if(!$data['loc_section']){
			$data['loc_section']="";
		}
		if(!$data['loc_rack']){
			$data['loc_rack']="";
		}
		if(!$data['loc']){
			$data['loc']="";
		}
		if(!$data['expiry_alert_days']){
			$data['expiry_alert_days']=0;
		}
		if(!$data['sale_price_terms']){
			$data['sale_price_terms']="";
		}
		if(!$data['stock_expiry_dates']){
			$data['stock_expiry_dates']="";
		}
		/*if(!$data['discount_terms']){
			$data['discount_terms']="";
		}*/
		return $data;
	}


}
