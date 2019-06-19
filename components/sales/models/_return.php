<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelReturn extends Model{
	private $db,$u;
	
	public function getReturnByID($id){
		$db=Core::getDBO();
		$sql = "SELECT * FROM branch_sales_return WHERE id={$id} LIMIT 1";
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function getReturnArticles($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT bs.*, bsa.*, ac.title AS art_title, ac.ref_code, ba.cost_price AS actual_cost_price ";
		$sql .= "FROM branch_sales_return AS bs  ";
		$sql .= "INNER JOIN branch_sale_articles AS bsa ON (bs.id = bsa.sale_id) ";
		$sql .= "INNER JOIN articles AS ac ON (bsa.article_code= ac.article_code) ";
		$sql .= "INNER JOIN branch_articles AS ba ON (ba.article_code= ac.article_code) ";
		$sql .= "WHERE bs.branch_id = {$branch_id} AND bs.id = {$id} ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getAllInvoice($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT bs.*, c.title AS cust_title, u.full_name ";
		$sql .= "FROM branch_sales_return AS bs  ";
		$sql .= "LEFT JOIN customers AS c ON (bs.customer_id = c.id) ";
		$sql .= "LEFT JOIN users AS u ON (bs.user_id = u.user_id) ";
		$sql .= "WHERE bs.branch_id = {$branch_id} AND bs.id = {$id} ";
		//$sql .= "AND bs.sale_status=0 ";
		//echo $sql;exit;
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function getOpenInvoice($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT bs.*, c.title AS cust_title, u.full_name ";
		$sql .= "FROM branch_sales_return AS bs  ";
		$sql .= "LEFT JOIN customers AS c ON (bs.customer_id = c.id) ";
		$sql .= "LEFT JOIN users AS u ON (bs.user_id = u.user_id) ";
		$sql .= "WHERE bs.branch_id = {$branch_id} AND bs.id = {$id} ";
		$sql .= "AND bs.return_status=0 ";
		//echo $sql;exit;
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function setInvReturnArticles($data,$return_id){
		if(!$return_id){
			return false;
		}
		$sale_rec = $this->getOpenInvoice($return_id);
		if(!$sale_rec){return false;}
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$c=$user->getCompany();
		$error='';
		//print_r($data);exit;
		$db->start();
		$branch_id = $u['branch_id'];
		$article_code_arr = $data['article_code'];
		$qty_arr = $data['qty'];
		$price_arr = $data['price'];
		$price_terms_arr = $data['price_terms'];
		$discount_arr = $data['discount'];
		$data['account']['ref_no']='sales.return.'.$return_id;
		$data['account']['comments']='';
		//echo $return_id;exit;
		//print_r($c);exit;
		$art_model=$this->getModel('articles.article');
		$msg_model=$this->getModel('messages.message');
		$station_id=0;
		$total_discount=0;
		$total_amount=0;
		$json_arr = array();
		
		foreach($article_code_arr as $key => $article_code){
			$j_art=array();
			$price=0;
			$discount=0;
			$qty=$qty_arr[$key];
			$tp_price=$price_arr[$key];
			$price_terms=$price_terms_arr[$key];
			$discount=$discount_arr[$key];
			$art = $art_model->getArticleByID($article_code);
			$article_code = $art['article_code'];
			$title = $art['title'];
			$stock = $art['qty'];
			$cost_price = $art['cost_price'];
			$price = $art['sale_price'];
			$min_stock = $art['min_stock'];
			$stock_after = $stock - $qty;
			$total_amount = $total_amount + ($price*$qty);
			$total_discount = $total_discount + ($discount*$qty);
			//echo 'stock ' . $stock_after . ' ' .$min_stock . '<br/>';
			//if($qty > $stock){return $return_id;}
			$j_art['article_code']=$article_code;
			$j_art['title']=$title;
			$j_art['qty']=$qty;
			$j_art['stock']=$stock;
			$j_art['cost_price']=$cost_price;
			$j_art['price']=$price;
			$j_art['tp_price']=$tp_price;
			//$j_art['price_terms']=array($price_terms);
			$j_art['price_terms']=array();
			$j_art['discount']=$discount;
			$j_art['station_id']=$station_id;
			$json_arr[$key]=json_encode($j_art);
			//print_r($art);exit;
			
			$sql = "UPDATE branch_articles ";
			$sql .= "SET qty = qty - {$qty} ";
			$sql .= "WHERE branch_id='{$branch_id}' AND article_code = '{$article_code}'";
			//echo $sql;exit;
			$ba = $db->update_by_sql($sql);
			
			if(!$ba){
				$error .='qty update error:' . $article_code;
			}
		}
		
		$c_id = $c['id'];
		$cc = $c['admin_id'];
		if(round($data['sub_total'])<>round($total_amount)){
			//$json_arr['messages'][]='Sub total error.';
			$msg="<h3>Sub total error Alert</h3> \n";
			$msg.='<p><a href="?com=sales&view=return&id=' . $return_id .  '">' . $return_id . '</a></p> \n';
			$msg.="<p>amount: {$total_amount}</p> \n";
			$msg.="<p>Sub total: {$data['sub_total']}</p> \n";
			$msg.="<p>User ID: {$u['user_id']}</p> \n";
			$msg.="<p>User Name: {$u['full_name']}</p> \n";
			//echo $msg;
			$msg_model->sendMessage($msg,"Totals is not equal: {$total_amount} <> {$data['sub_total']}",$c_id,$cc);
		}
		
		//return $message;
		if(isset($data['station_id']) && $data['station_id']){
			$station_id = $data['station_id'];
		}
		if(!$station_id){
			$stn = $this->getModel('cash.cash')->getDefaultStation();
			//print_r($stn);exit;
			$station_id = $stn['id'];
		}
		if($data['cash']){
			$arr_cash=array();
			$cash=$data['sub_total'] - $data['discount_amount'] - $data['credit'];	//
			$arr_cash['ref_no'] = "sales.return.{$return_id}";
			$arr_cash['cash'] = $cash;
			$arr_cash['station_id'] = $station_id;
			$arr_cash['file_name'] = 'branch_sales_return';
			$arr_cash['file_id'] = $return_id;
			$cm = $this->getModel('cash.payment');
			//print_r($cm);exit;
			$cr = $cm->createData($arr_cash);
			//$json_arr['cash_log_ref']=$cr;
			if(!$cr){$error.='\n' . 'cash account error. ';}
		}
		
		
		
		
	
		
		
		if($data['credit'] && $data['customer_id']){
			$arr_credit=array();
			$arr_credit['id'] = $data['customer_id'];
			$arr_credit['ref_no'] = "sales.return.{$return_id}";
			$arr_credit['amount'] = $data['credit'];
			$cr_id = $this->getModel('customers.credit')->createData($arr_credit);
			//$json_arr['credit_log_ref']=$cr_id;
			if(!$cr_id){$error.='\n' . 'credit account# error';}
			$sql = "UPDATE customers c INNER JOIN customer_credits cr ON (c.id = cr.customer_id) ";
			$sql .= "SET ";
			$sql .= "cr.old_account_value=c.account_value, ";
			$sql .= "c.account_value=c.account_value-{$data['credit']} ";
			$sql .= "WHERE c.id='{$data['customer_id']}' AND c.branch_id = {$branch_id} AND cr.ref_no = '{$arr_credit['ref_no']}'";
			$ru = $db->update_by_sql($sql);
			if(!$ru){$error.='\n' . 'customer account error';}
		}
		$json = '[' . implode(',',$json_arr) . ']';
		$customer_id=0;
		if(isset($data['customer_id']) && $data['customer_id']){
			$customer_id = $data['customer_id'];
		}
		//update sales table with json value
		$return_dt=date('Y-m-d H:i:s');
		$return_date=date('Y-m-d');
		$sql = "UPDATE branch_sales_return ";
		$sql .= "SET ";
		$sql .= "data_articles='{$json}', ";
		$sql .= "return_status = 1, ";
		$sql .= "customer_id='{$customer_id}', person = '{$data['person']}', ";
		$sql .= "return_date='{$return_date}', time_stamp = '{$return_dt}', ";
		$sql .= "sub_total='{$data['sub_total']}', cash = '{$data['cash']}', ";
		$sql .= "credit='{$data['credit']}', ";
		$discount_percent = $data['discount_amount'] / $data['sub_total'] * 100;
		$sql .= "discount_amount = '{$data['discount_amount']}', ";
		$sql .= "user_id='{$u['user_id']}' ";
		$sql .= "WHERE id='{$return_id}' AND branch_id = {$branch_id} ";
		//echo $sql;exit;
		$art_updated = $db->update_by_sql($sql);
		if(!$art_updated){$error.='\n' . 'sale ID update error';}
		
		$sql = "SELECT * FROM branch_sales_return ";
		$sql .= "WHERE id='{$return_id}' AND branch_id = {$branch_id} ";
		//echo $sql;exit;
		$bill = $db->get_by_sqlRow($sql);
		if(!$bill){$error.='\n' . 'Bill not saved';}
		
		//return false;
		//echo $error . ':error';exit;
		if(!$error){
			$db->commit();
			$j = json_encode($bill);
			//echo $j;
			return $j;
		}else{
			//echo 'hi...';
			$db->rollback();
			return false;
		}
		//echo 'sssss';
		return false;
		
	}

	public function getEmptyInvoiceNo($user_id, $branch_id){
		$db=Core::getDBO();
		$sql="SELECT MIN(id) AS return_id FROM branch_sales_return ";
		$sql.="WHERE user_id={$user_id} AND branch_id = {$branch_id} AND sub_total=0 AND return_status=0 ";
		$row = $db->get_by_sqlRow($sql);
		//echo $sql;exit;
		if(count($row)==1){
			if($row['return_id']){
				return $row['return_id'];
			}
		}
		return false;
	}
	public function newReturnNo(&$data){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$c=$user->getCompany();
		$branch_id = $u['branch_id'];
		$id = $this->getEmptyInvoiceNo($u['user_id'],$branch_id);
		if($id){
			return $id;
		}
		$return_date=date('Y-m-d H:i:s');
		$customer_id=0;
		if(!isset($data['customer_id']) || !$data['customer_id']){
			$data['customer_id']=0;
		}
		$return_status=0;
		$comments='';
		$method_of_payment=0;
		$sub_total=0;
		if(isset($data['sub_total']) && $data['sub_total']){
			$sub_total=$data['sub_total'];
		}
		$cash=0;
		if(isset($data['cash']) && $data['cash']){
			$cash=$data['cash'];
		}
		$bank_check=0;
		$credit=0;
		if(isset($data['credit']) && $data['credit']){
			$credit=$data['credit'];
		}
		$bank_card=0;
		$change_return=0;
		if(isset($data['change']) && $data['change']){
			$change_return=$data['change'];
		}
		$discount_amount=0;
		$discount_percent=0;
		if(isset($data['discount_amount']) && $data['discount_amount']){
			$discount_amount=$data['discount_amount'];
			$discount_percent=($data['discount_amount']/$data['sub_total'])*100;
		}
		
		$user_id=$u['user_id'];
		$sql = "INSERT INTO branch_sales_return ";
		$sql .= "(return_date,customer_id,person,return_status,comments,branch_id,sub_total,cash, ";
		$sql .= "credit, change_return, discount_amount, user_id) VALUES ( ";
		$sql .= "'{$return_date}', ";
		$sql .= "'{$data['customer_id']}', ";
		$sql .= "'', ";
		$sql .= "'{$return_status}', ";
		$sql .= "'{$comments}', ";
		$sql .= "'{$branch_id}', ";
		$sql .= "'{$sub_total}', ";
		$sql .= "'{$cash}', ";
		$sql .= "'{$credit}', ";
		$sql .= "'{$change_return}', ";
		$sql .= "'{$discount_amount}', ";
		$sql .= "'{$user_id}' ";
		$sql .= ")";
		$ri = $db->insert_by_sql($sql);
		$message='';
		if($ri){
			//$message .= ': Record saved.<br/>';
			//$db->setMessage($message);
		}else{
			$message .= ': Record not saved.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		
		if($db->insert_id()){
			$id = $db->insert_id();
			//echo $id;exit;
			return $id;
		}
		return false;
	}

}
