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


//print_r ($pur_arts);exit;
?><?php /* ?><div class="com-head">
	<h3>{branch name} Articles</h3>
</div><?php */ ?>
<div class="form"><?php
	/*$list = array();
	$list['view']='inventory';
	$list['task']='edit';
	$view = $this->getView('inventory', 'inventories', 'edit');
	echo $view->display($list);*/
	require_once ('view.php');
?></div>
<div class="table-responsive"><?php require_once ('_inv_stock_compare_list.php'); ?>
</div><?php
?>