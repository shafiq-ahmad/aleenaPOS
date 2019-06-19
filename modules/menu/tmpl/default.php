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
global $v_view;
global $task;
$class = '';

?>

	<div class="navbar screen">
	<div class="dropdown">
	<button class="dropbtn">Primary<i class="fa fa-caret-down"></i></button>
		<div class="dropdown-content">
			<a href="?com=articles&view=branch_articles" title="My Items" class="list-group-item" tabindex="-1">My Items</a>
			<a href="?com=articles&view=articles" title="All Items" class="list-group-item hide" tabindex="-1">All Items</a>
			<a href="?com=articles&view=expiry_alerts" title="Items Expiry Alert" class="list-group-item" tabindex="-1">Expiry Alert</a>
			<a href="?com=articles&view=branch_stock" title="New Item" class="list-group-item" tabindex="-1">Stock</a>
			<a href="?com=articles&view=article&task=new" title="New Item" class="list-group-item" tabindex="-1">New Item</a><hr/>
			<a href="?com=categories" title="Categories" class="list-group-item" tabindex="-1">Categories</a>
			<a href="?com=categories&view=category&task=new" title="New Category" class="list-group-item" tabindex="-1">New Category</a><hr/>
			<a href="?com=messages" title="Alerts" class="list-group-item" tabindex="-1">Alerts</a>
		</div>
	</div> 
	<div class="dropdown">
	<button class="dropbtn">Sales<i class="fa fa-caret-down"></i></button>
		<div class="dropdown-content">
			<a href="?com=sales&view=pos&tmpl=bill" title="Point of Sale" class="list-group-item" tabindex="-1">Point of Sale</a>
			<a href="?com=sales&view=return" title="Point of Sale" class="list-group-item" tabindex="-1">Sales Return</a>
			<a href="?com=sales&view=distributor&tmpl=bill" title="POS Distributor" class="list-group-item hide" tabindex="-1">POS Distributor</a>
			<a href="?com=sales&view=sales" title="Sales" class="list-group-item" tabindex="-1">Sales</a>
			<a href="?com=sales&view=returns" title="Returns" class="list-group-item" tabindex="-1">Returns</a><hr/>
			<a href="?com=customers" title="Customers" class="list-group-item" tabindex="-1">Customers</a>
			<a href="?com=customers&view=customer&task=edit" title="Customers" class="list-group-item" tabindex="-1">New Customer</a>
		</div>
	</div> 
	<div class="dropdown">
	<button class="dropbtn">Purchases<i class="fa fa-caret-down"></i></button>
		<div class="dropdown-content">
			<a href="?com=purchases&view=purchase" title="Purchases" class="list-group-item" tabindex="-1">New Purchase</a>
			<a href="?com=purchases&view=returns" title="Purchase Return" class="list-group-item" tabindex="-1">Purchase Return</a>
			<a href="?com=purchases" title="Purchases" class="list-group-item" tabindex="-1">Purchases</a><hr/>
			<a href="?com=suppliers" title="Suppliers" class="list-group-item" tabindex="-1">Suppliers</a>
			<a href="?com=suppliers&view=supplier&task=edit" title="Suppliers" class="list-group-item" tabindex="-1">New Supplier</a>
		</div>
	</div> 
	<a href="" title="Transaction" tabindex="-1">Transaction</a>
	<div class="dropdown">
	<button class="dropbtn">Utilities<i class="fa fa-caret-down"></i></button>
		<div class="dropdown-content">
			<a href="?com=inventories&view=inventories" title="Store Audit" class="list-group-item" tabindex="-1">Store Audits</a>
			<a href="?com=inventories&view=inventory" title="Store Audit" class="list-group-item" tabindex="-1">New Store Audit</a>
		</div>
	</div> 
	<a href="" title="Accounts" tabindex="-1">Accounts</a>


	<div class="dropdown">
	<button class="dropbtn">Reports<i class="fa fa-caret-down"></i></button>
		<div class="dropdown-content">
			<a href="?com=sales&view=items_report" title="Sales" tabindex="-1">Sale by Items</a>
			<a href="?com=sales&view=items_return_report" title="Sales" tabindex="-1">Sale Return by Items</a>
			<a href="?com=purchases&view=items_report" title="Purchase by Items" tabindex="-1">Purchase by Items</a>
			<a href="?com=purchases&view=items_return_report" title="Purchase Return by Items" tabindex="-1">Purchase Return by Items</a>

		</div>
	</div> 
	</div>
		
		