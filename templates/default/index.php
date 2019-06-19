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
//$months = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');





$message=$this->getMessage();
$bArtsJSON = '';
$com = Application::$options->com;
$view = Application::$options->view;

if($com == 'sales' || $com == 'purchases'){
	if(!class_exists('View')){import('core.application.component.view');}
	$v_obj = new View();
	$model_art = $v_obj->getModel('articles.branch_articles');
	//$bArts = $model_art->getBranchArticles();
	//echo count($bArts) . '\n';
	//$bArtsJSON = json_encode($bArts);
}
//echo md5('abc123');exit;
//base_convert(number,frombase,tobase); // example: base2 to base10
//print_r($this->c);exit;
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?php /* ?><script src="templates/<?php echo $this->getTemplate();?>/js/script.js"></script><?php */?>
	<script type="text/javascript">
		var user_opt = '';
		var br_dt_opt = '';
		<?php 
			if($this->u['options']){
				echo "\n";
				echo 'user_opt = ' . $this->u['options'] . ';'; 
			}
		?>
		<?php 
			if(isset($this->c['local_data_opt']) && $this->c['local_data_opt']){
				echo "\n";
				echo 'br_dt_opt = ' . $this->c['local_data_opt'] . ';'; 
			}
		?>
		var auto_multiQty=true;
		var use_local_storage=false;
		if(br_dt_opt[0]){
			br_dt_opt = br_dt_opt[0];
		}
		console.log(br_dt_opt);
		if(user_opt[0]){
			user_opt = user_opt[0];
		}
		if(user_opt.auto_multiQty){
			auto_multiQty = user_opt.auto_multiQty;
		}
		if(br_dt_opt.use_local_storage){
			use_local_storage = br_dt_opt.use_local_storage;
		}
		var braArts = '';
		<?php //if($bArtsJSON){echo 'braArts = ' . $bArtsJSON . ';';} ?>
	</script>
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/general.css" media="all" />
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/style-lte.css" media="screen" />
	<?php /* ?><link rel="stylesheet" type="text/css" href="media/system/js/jquery-ui/jquery-ui.min.css" media="all" /><?php*/ ?>
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="components/<?php echo $com; ?>/com.css" media="all" />
  
<!-- jQuery 3 -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="media/system/js/jquery-ui/jquery-ui.min.js"></script>
	<link rel="stylesheet" type="text/css" href="media/system/js/jquery-ui/jquery-ui.min.css" media="all" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/dist/css/skins/skin-blue-light.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<title><?php echo $this->getTitle(); ?></title>
</head>

<body class="hold-transition skin-blue-light sidebar-collapse sidebar-mini">
<div class="wrapper">


  <header class="main-header">

    <!-- Logo -->
    <a href="?" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>W</b>AP</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo $this->branch_title; ?></b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">0</span>
            </a>
            <?php /* ?><ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                  </li>
                  <!-- end message -->
                  <li>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul><?php*/?>
          </li>
		  
		  
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i><?php
				$msg_count=0;
				$msg='';
				if(isset($message['count'])){
					$msg_count=$message['count'];
					$msg = $message['messages'];
				}
			  
              ?><span class="label label-warning"><?php echo $msg_count;?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?php echo $msg_count;?> notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> <?php echo $msg; ?>
                    </a>
                  </li>
                </ul>
              </li>
              <!--<li class="footer"><a href="#">View all</a></li>-->
            </ul>
          </li>
		  
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">0</span>
            </a>
            <?php /*?><ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul><?php*/?>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="templates/<?php echo $this->getTemplate();?>/dist/img/avatar5.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $this->full_name ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="templates/<?php echo $this->getTemplate();?>/dist/img/avatar5.png" class="img-circle" alt="User Image">
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="?com=users&view=profile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="?com=users&logout=1" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>

    </nav>
  </header>

		<aside class="main-sidebar">
		
		
		
		
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
		<!-- Sidebar user panel -->
		<?php  if($this->u){ ?>

		<ul class="sidebar-menu">
		<li><a href="?"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
		<li>
		<a href="?com=sales&view=pos" target="_blank" class="primary" title="Point of Sale"><i class="fa fa-cart-plus"></i> <span>Point of Sale</span></a>
		</li>
		<li>
		<a onclick="window.open('?com=articles&view=article&task=new','_blank');return false;" href="#" class="primary" title="New Article"><i class="fa fa-file"></i> <span>New Article</span></a>
		</li>
		</ul>
		<?php } ?>	
		<?php /* ?>	
		<form action="#" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
					<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
				</span>
			</div>
		</form>
		<!-- /.search form --><?php */ ?>
		<!-- sidebar menu: : style can be found in sidebar.less -->
	<ul class="sidebar-menu" data-widget="tree">
	<li class="header">MAIN NAVIGATION</li>
	<li class="treeview">

	<a href="#"><i class="fa fa-barcode"></i> <span>Items</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
	<ul class="treeview-menu">
	<li><a href="?com=articles&view=branch_articles" title="My Items" tabindex="-1"><i class="glyphicon glyphicon-barcode"></i>My Items</a></li>
	
	<li><a href="?com=articles&view=branch_stock" title="Stock" tabindex="-1"><i class="glyphicon glyphicon-th"></i>Stock</a></li>
	<li><a href="?com=articles&view=expiry_alerts" title="Expiry Alert" tabindex="-1"><i class="glyphicon glyphicon-alert"></i>Expiry Alert</a></li>
	<li><a href="?com=articles&view=stock_alerts" title="Stock alert" tabindex="-1"><i class="glyphicon glyphicon-alert"></i>Stock alert</a></li>
	
	<li><a href="?com=articles&view=article&task=new" title="New Item" tabindex="-1"><i class="fa fa-file"></i>New Item</a></li>
	<li><a href="?com=categories" title="Categories" tabindex="-1"><i class="fa fa-sitemap"></i>Categories</a></li>
	<?php /* ?><li><a href="?com=categories&view=category&task=new" title="New Category" tabindex="-1"><i class="glyphicon glyphicon-plus-sign"></i>New Category</a></li><?php */?>
	<li><a href="?com=messages" title="Inbox" tabindex="-1"><i class="glyphicon glyphicon-inbox"></i>Inbox</a></li>
	</ul>
	</li>
	<li class="treeview">
	<a href="#"><i class="fa fa-shopping-cart"></i> <span>Sales</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
	<ul class="treeview-menu">
	<li><a href="?com=sales&view=distributor" title="POS Distributor" class="hide" tabindex="-1"><i class="fa fa-circle-o"></i> POS Distributor</a></li>
	<li><a href="?com=sales&view=sales" title="Sales" tabindex="-1"><i class="fa fa-circle-o"></i> Sales</a></li>
	<li><a href="?com=sales&view=returns" title="Returns" tabindex="-1"><i class="fa fa-circle-o"></i> Returns</a></li>
	<li><a href="?com=customers" title="Customers" tabindex="-1"><i class="fa fa-users"></i> Customers</a></li>
	</ul>
	</li>

	<li class="treeview">
	<a href="#"><i class="fa fa-dollar"></i> <span>Purchases</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
	<ul class="treeview-menu">
		<li><a href="?com=purchases" title="Purchases" tabindex="-1"><i class="fa fa-circle-o"></i> Purchases</a></li>
		<li><a href="?com=purchases&view=returns" title="Purchases return" tabindex="-1"><i class="fa fa-circle-o"></i> Returns</a></li>
		<li><a href="?com=suppliers" title="Suppliers" tabindex="-1"><i class="fa fa-circle-o"></i> Suppliers</a></li>
	</ul>
	</li>

	<li class="treeview">
	<a href="#"><i class="fa fa-link"></i> <span>Expenses</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
	<ul class="treeview-menu">
	<li><a href="?com=expenses" title="Expenses" tabindex="-1"><i class="fa fa-circle-o"></i> Expenses</a></li>

	</ul>
	</li>

	<li class="treeview hide">
	<a href="#"><i class="fa fa-link"></i> <span>Utilities</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
	<ul class="treeview-menu">
	<li><a href="?com=inventories&view=inventories" title="Store Audit" tabindex="-1"><i class="fa fa-circle-o"></i> Store Audits</a></li>
	<li><a href="?com=inventories&view=inventory" title="Store Audit" tabindex="-1"><i class="fa fa-circle-o"></i> New Store Audit</a></li>

	</ul>
	</li>

	<li class="treeview">
	<a href="#"><i class="fa fa-clipboard"></i> <span>Reports</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
	<ul class="treeview-menu">
	<li><a href="?com=home&view=summery" title="Daily summery" tabindex="-1"><i class="fa fa-circle-o"></i> Daily summery</a></li>
	<li><a href="?com=sales&view=items_report" title="Sales" tabindex="-1"><i class="fa fa-circle-o"></i> Sale Itemwise</a></li>
	<li><a href="?com=sales&view=items_report&task=date" title="Sales" tabindex="-1"><i class="fa fa-circle-o"></i> Sale Datewise</a></li>
	<li><a href="?com=sales&view=items_report&task=users" title="Sales" tabindex="-1"><i class="fa fa-circle-o"></i> Sale Users</a></li>
	<li><a href="?com=sales&view=items_return_report" title="Sales" tabindex="-1"><i class="fa fa-circle-o"></i> Sale Return by Items</a></li>
	<li><a href="?com=purchases&view=items_report" title="Purchase by Items" tabindex="-1"><i class="fa fa-circle-o"></i> Purchase by Items</a></li>
	<li><a href="?com=purchases&view=items_return_report" title="Purchase Return by Items" tabindex="-1"><i class="fa fa-circle-o"></i> Purchase Return by Items</a></li>

	</ul>
	</li>

      </ul>
	  
	  
	  
  
	  
	  
	  
	  
	  
    </section>
    <!-- /.sidebar -->

	
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
			<?php if($this->u){ ?><div id="header" class="print">
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
					</p>
					</div><div class="clear"></div>
			</div><?php } ?>
    </section>

    <!-- Main content -->
    <section class="content">


	
	  
			<div id="center">
				<div id="componant"><?php
					echo $this->_com;
				?></div>
			</div>
	  
	  
    </section>
    <!-- /.content -->
  </div>
  
	<footer class="main-footer">
	<div class="pull-right hidden-xs"><b>Version</b> 1.0</div>
	<strong>Copyright &copy; 2014-2016 <a href="http://webapplics.com">Webapplics Studio</a>.</strong> All rights reserved.
	</footer>

  
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
    <!-- Tab panes -->
    <div class="tab-content">
    </div>
  </aside>
  <div class="control-sidebar-bg"></div>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    <input type="hidden" id="return-value" value="" />
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Choose an item</h4>
        </div>
        <table class="modal-body nav-able"></table>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
  
  
  
  
  
  
  
</body>
  <!-- Bootstrap 3.3.7 -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="templates/<?php echo $this->getTemplate();?>/dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="templates/<?php echo $this->getTemplate();?>/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- DataTables -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


<script src="templates/<?php echo $this->getTemplate();?>/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/jszip/dist/jszip.min.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/pdfmake/build/pdfmake.min.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/pdfmake/build/vfs_fonts.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>


<!-- SlimScroll -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/chart.js/Chart.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/jquery.couch/jquery.couch.js"></script>
	<script src="templates/<?php echo $this->getTemplate();?>/js/script.js"></script>
	<script src="components/<?php echo $com; ?>/com.js"></script>
	<!--<script src="media/system/DataTables/datatables.min.js"></script>-->
    <script type="text/javascript">
	<?php echo $this->getScript(); ?>

	
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

//$("#items-list").autocomplete({
$("#article_code").autocomplete({
    source:function(request,response){
        $.ajax({
          type: "GET",
          data:{txt: request.term},
          url: "?com=articles&view=branch_articles&task=json&tmpl=com&comboList=1",
          dataType: "json",
          success:function(data){
			var list= [];
			$.each(data,function (i,e){
				list.push({value:e.article_code, label:e.label});
			});
			response($.map(list, function (value, key) {
                return {label: value.label,value: value.value};
            }));
			
           }
         });
    },      
    minLength:2,
    delay: 100
});



	$("table.nav-able").keydown(function(e){
		var key = e.keyCode || e.which;
		if (key == 13) {
			// close model form
			//alert("entered");
			var cur_cell = currCell.html().toString();
			$("#article_code").val(cur_cell);$(".modal.in").modal("hide");return false;
		}
		currCell = navigateTableCells(e, currCell)
	});		




	$("input#left-article_code").keypress(function(e){
		e.stopPropagation();
		txt_article = $("input#left-article_code").val();
		var key = e.keyCode || e.which;
		if (key==13){
			//return false;
			txt_article = txt_article.toString();
			txt_article = txt_article.toString();
			var pos = txt_article.substr(0,1);
			if(pos=="-"){
				artSearch(txt_article,'left-article_code');
				return false;
			}
			
			var a = getArticleInfo(txt_article);
			if(a){
				$(this).val('');
				$(this).focus();
			}
			return false;
		}
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
            //console.log(key);

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
				if($('#save').length){
					$('#save').trigger('click');
				}
            }else if (key==70){
				e.preventDefault();
                vFind = $("[type=search]");
                if(vFind.length){
                    vFind.focus();
                    vFind.select();
                }
            }
        }else{return;}
    });

	
</script>

</html>