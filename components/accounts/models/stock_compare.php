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

class ModelStock_compare extends Model{
	
	public function getData($article_code){
		$db = Core::getDBO();
		$user = Core::getUser();
		$u = $user->getUser();
		$branch_id = $u['branch_id'];
		
		$sql = "SELECT article_code, SUM(item_sum) AS system_stock, sum(purchase_item_sum) AS purchase_qty_sum, SUM(item_return_purchase_sum) AS ret_purchase_sum, SUM(item_sale_sum) AS sale_qty_sum, SUM(item_sale_return_sum) AS return_sale_qty ";
		$sql .= "FROM ( ";
		$sql .= "(SELECT ba.branch_id, a.article_code, SUM(ba.qty+ba.scheme) AS item_sum, 0 AS purchase_item_sum, 0 AS item_return_purchase_sum, 0 AS item_sale_sum, 0 AS item_sale_return_sum ";
		$sql .= "FROM branch_articles AS ba  ";
		$sql .= "INNER JOIN articles AS a ON (ba.article_code = a.article_code) ";
		$sql .= "WHERE ba.branch_id = '{$branch_id}' AND a.article_code='{$article_code}' ";
		$sql .= "GROUP BY a.article_code,ba.branch_id) ";

		$sql .= "UNION ALL ";
		$sql .= "(SELECT bp.branch_id, bpa.article_code, 0 AS item_sum, SUM(bpa.qty_scheme+bpa.scheme) AS purchase_item_sum, 0 AS item_return_purchase_sum, 0 AS item_sale_sum, 0 AS item_sale_return_sum ";
		$sql .= "FROM branch_purchase_articles AS bpa  ";
		$sql .= "INNER JOIN branch_purchases AS bp ON (bpa.purchase_id = bp.purchase_id) ";
		$sql .= "WHERE bp.branch_id = '{$branch_id}' AND bpa.article_code='{$article_code}' ";
		$sql .= "GROUP BY bpa.article_code,bp.branch_id) ";

		$sql .= "UNION ALL ";
		$sql .= "(SELECT bpr.branch_id, bpra.article_code, 0 AS item_sum, 0 AS purchase_item_sum, SUM(bpra.qty_scheme+bpra.scheme) AS item_return_purchase_sum, 0 AS item_sale_sum, 0 AS item_sale_return_sum ";
		$sql .= "FROM branch_purchase_return_articles AS bpra  ";
		$sql .= "INNER JOIN branch_purchase_returns AS bpr ON (bpra.return_id = bpr.id) ";
		$sql .= "WHERE bpr.branch_id = '{$branch_id}' AND bpra.article_code='{$article_code}' ";
		$sql .= "GROUP BY bpra.article_code,bpr.branch_id) ";

		$sql .= "UNION ALL ";
		$sql .= "(SELECT bs.branch_id, bsa.article_code, 0 AS item_sum, 0 AS purchase_item_sum, 0 AS item_return_purchase_sum, SUM(bsa.qty+bsa.scheme) AS item_sale_sum, 0 AS item_sale_return_sum ";
		$sql .= "FROM branch_sale_articles AS bsa ";
		$sql .= "INNER JOIN branch_sales AS bs ON (bsa.sale_id = bs.id) ";
		$sql .= "WHERE bs.branch_id = '{$branch_id}' AND bsa.article_code='{$article_code}' ";
		$sql .= "GROUP BY bsa.article_code,bs.branch_id) ";

		$sql .= "UNION ALL ";
		$sql .= "(SELECT bsr.branch_id, bsra.article_code, 0 AS item_sum, 0 AS purchase_item_sum, 0 AS item_return_purchase_sum, 0 AS item_sale_sum, SUM(bsra.qty+bsra.scheme) AS item_sale_return_sum  ";
		$sql .= "FROM branch_sale_return_articles AS bsra ";
		$sql .= "INNER JOIN branch_sales_return AS bsr ON (bsra.return_id = bsr.id) ";
		$sql .= "WHERE bsr.branch_id = '{$branch_id}' AND bsra.article_code='{$article_code}' ";
		$sql .= "GROUP BY bsra.article_code,bsr.branch_id) ";

		$sql .= ") stock_compare ";
		$sql .= "GROUP BY article_code ";
		
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}
}

