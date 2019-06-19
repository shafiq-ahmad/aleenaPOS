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

//$pa =  $user->pageAccess(12);
//print_r ($_SESSION);exit;
//echo time();exit;
$message=$this->getMessage();
$bArtsJSON = '';
$com = Application::$options->com;
$view = Application::$options->view;
//$task = Application::$options->task;

if($com == 'sales' || $com == 'purchases'){
	if($view=='pos' || $view=='return' || $view=='purchase' ){
		if(!class_exists('View')){import('core.application.component.view');}
		$v_obj = new View();
		$model_art = $v_obj->getModel('articles.branch_articles');
		$bArts = $model_art->getBranchArticles();
		$bArtsJSON = json_encode($bArts);
	}
}
//echo md5('abc123');exit;
//base_convert(number,frombase,tobase); // example: base2 to base10
//print_r($_POST);exit;


/*
{"term":[{"qty":"2","expiry":"09/07/2018"},{"qty":"5","expiry":"09/30/2018"}]} // desired
{"term":{"qty":"5","expiry":"2018-09-30"}} //table
{"term":[{"qty":"5","expiry":"2018\/03\/05"}]} //now
$json = json_encode(array('term' => array(array('qty'=>'5', 'expiry'=>'2018/03/05'))));
var_dump($json);
$arrr= json_decode($json,true);
$arrr['term'][]=array('qty'=>50, 'expiry'=>'2018/09/20');
echo json_encode($arrr);
exit;



*/
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="media/system/js/jquery-3.3.1.min.js"></script>
	<script src="media/system/js/jquery-ui/jquery-ui.min.js"></script>
<script src="media/system/css/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script src="templates/<?php echo $this->getTemplate();?>/js/script.js"></script>
	<script type="text/javascript">
	auto_multiQty=true;
	function WhichButton(event) {
		console.log("You pressed button: " + event.button)
	}
    // Popup window code 
    function newPopup(url) {
        popupWindow = window.open(url, '_blank', 'height=300,width=500,left=200,top=200,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes')
    }
	$(function(){
		$(".date").datepicker();
		$(".date-default").datepicker().datepicker("setDate", new Date());
	});
	<?php if($bArtsJSON){echo 'var braArts = ' . $bArtsJSON . ';';} ?>
	</script>
	<link rel="stylesheet" href="media/system/css/bootstrap-3.3.7-dist/css/bootstrap.min.css" media="all">
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/general.css" media="all" />
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/style.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="media/system/js/jquery-ui/jquery-ui.min.css" media="all" />
	<link rel="stylesheet" type="text/css" href="media/system/DataTables/datatables.min.css" media="all" />
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="components/<?php echo $com; ?>/com.css" media="all" />

	<title><?php echo $this->getTitle(); ?></title>
</head>
	<body oncontextmenu="">
	<?php /*?><body onmousedown="WhichButton(event);return false;">
	<body onmousedown="alert(event.button);return false;"><?php */?>
		<div id="main" class="container container-fluid">
			<?php if($this->u){ ?><div id="header">
				<div id="logo-section">
					<div id="logo"></div>
					<div id="company">
						<div class="title"><?php echo $this->branch_title; ?></div>
						<div class="address"><?php echo $this->branch_address; ?></div><?php
						if($com=='sales' && ($view == 'pos' || $view == 'distributor')){ 
						?><div class="doc-title print">Sales invoice</div><?php }
					?></div>
					<div class="clear"></div>
				</div><div class="clear"></div>
				<div id="user">
					<p class="left">
					<?php echo date('d / m /Y       h:i:sa'); ?>
					</p><p class="right"><a href="?com=users&view=profile" tabindex="-1"><?php echo $this->full_name ?></a>
					&nbsp;&nbsp;|&nbsp;&nbsp;<a class="screen logout" href="?com=user&logout=1" tabindex="-1">(Logout)</a>
					</p>
					</div><div class="clear"></div>
			</div>
			<div id="top-menu" class="list-group">
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
			
<div class="clear"></div>
			</div><div class="clear"></div><?php } ?>
			<div id="message"><?php
				$msg_count=0;
				if(isset($message['count'])){
					$msg_count=$message['count'];
					echo $message['messages'];
				}
			  
			?></div>
			<div id="center">
				<div id="componant"><?php
					echo $this->_com;
				?></div>
			</div>
			<?php  if($this->u){ ?>
            <div id="left">
				<?php /* ?><div class="com-menu list-group"><?php
					//echo $this->getComMenu($this->com);
				?></div><?php */?>
				<div class="left-menu-item list-group">
					<a href="?com=sales&view=pos&tmpl=bill" title="Point of Sale" class="list-group-item primary" tabindex="-1">Point of Sale</a>
					<a href="?com=articles&view=article&task=new" title="New Article" class="list-group-item primary" tabindex="-1">New Article</a>
				</div>
                <div id="left-article-search" class="">
                    <h4>Search Item</h4>
                    <form class="search"  action="?com=articles&view=article&tmpl=com&task=json" method="post">
                        <input id="left-article_code" name="article_code" placeholder="Search..." class="inputbox form-control input-sm" value="" tabindex="-1" />
                        <?php /* ?><input type="button" class="btn btn-success" value="Go" /><?php */ ?>
                    </form>
                    <div class="results">
                        <div class="title"><b>Title: </b><div class="value"></div></div>
                        <div class="article_code"><b>ID: </b><span class="value"></span></div>
                        <div class="qty"><b>Stock: </b><span class="value"></span></div>
                        <div class="scheme"><b>Scheme: </b><span class="value"></span></div>
                        <div class="discount"><b>Discount: </b><span class="value"></span></div>
                        <div class="sale_price"><b>Price: </b><span class="value"></span></div>
                        <div class="cost_price"><b>Cost: </b><span class="value"></span></div>
                        
                    </div>
                </div>
			</div>
			<?php } ?>
			<div class="clear"></div>
			<div id="footer">
				<p>Powered by: webapplics.com</p>
			</div>
	</body>
	<script src="components/<?php echo $com; ?>/com.js"></script>
	<script src="media/system/DataTables/datatables.min.js"></script>
    <script type="text/javascript">
	<?php echo $this->getScript(); ?>

	
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
function getArticleInfo(txt){
	if(txt==''){return false;}
		txt = txt.toString();
		//console.log(txt);
		$('#left-article-search .results .article_code .value').text('');
		$('#left-article-search .results .title .value').text('');
		$('#left-article-search .qty .value').text('');
		$('#left-article-search .scheme .value').text('');
		$('#left-article-search .discount .value').text('');
        $('#left-article-search .sale_price .value').text('');
        $.post("?com=articles&view=article&task=json&tmpl=com", {article_code: txt}, function(result,status,xhr, dataType){
            //var r = JSON.stringify(result)
            //console.log(result);
            //console.log('safafsdf');
            //console.log(status);
            //var ct = xhr.getResponseHeader("content-type") || "";
            //console.log(ct);
            //console.log(dataType);
            //console.log(typeof(result));
            //try{
            //var obj = JSON.parse(result);
            //}catch(e){}
            var obj = result;
            //console.log(obj);
            if(!obj){
            $('#left-article-search .results .title .value').text('No Item found');
                return false;
            }


            return true;
	},'json')
		.done(function(obj) { 
		//console.log('Request done!');
            $('#left-article-search .results .article_code .value').text(obj.article_code);
            $('#left-article-search .results .title .value').text(obj.title);
            $('#left-article-search .qty .value').text(obj.qty);
            $('#left-article-search .scheme .value').text(obj.scheme);
            $('#left-article-search .discount .value').text(obj.discount);
            $('#left-article-search .sale_price .value').text(obj.sale_price);
            $('#left-article-search .cost_price .value').text(obj.cost_price);
			return true;
		})
        .fail(function(jqxhr, settings, ex) { console.log('failed, ' + ex); });
	//},dataType);
	
	
}

	$("input#left-article_code").keypress(function(e){
		e.stopPropagation();
		//alert(e.which);
		txt_article = $("input#left-article_code").val();
		if (e.which==13){
			//return false;
			txt_article = txt_article.toString();
			var a = getArticleInfo(txt_article);
			if(a){
				$(this).val('');
				$(this).focus();
			}
			return false;
		} //end keyCode
	});
    $(window).keydown(function(e){
            var key = e.keyCode || e.which;
            var vFind = '';
			//e.preventDefault();
            //console.clear();
            //console.log(key);
			if (key==36){
                vFind = $("input#article_code");
                if(vFind.length){
                    vFind.focus();
                    vFind.select();
                }
            }
        if(e.ctrlKey){
            //console.log(e.shiftKey);
            //console.log(e.ctrlKey);
            //console.log(e.altKey);

            if (key==73){
				e.preventDefault();
                vFind = $("input#left-article_code");
                if(vFind.length){
                    vFind.focus();
                    vFind.select();
                }
            }else if (key==83){
				e.preventDefault();
				/*if (typeof submitForm == 'function') { 
					submitForm(); 
				}*/
				if($('input#save').val()){
					$('input#save').trigger('click');
				}
            }else if (key==70){
				e.preventDefault();
                vFind = $("input#search_filter");
                if(vFind.length){
                    vFind.focus();
                    vFind.select();
                }
            }
        }else{return;}
    });

</script>
</html>