<?php
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