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
//print_r($_POST);exit;
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?php /* ?><script src="templates/<?php echo $this->getTemplate();?>/js/script.js"></script><?php */?>
	<script type="text/javascript">
	auto_multiQty=true;
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
<!-- SlimScroll -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/chart.js/Chart.js"></script>
	<script src="templates/<?php echo $this->getTemplate();?>/js/script.js"></script>
	<script src="components/<?php echo $com; ?>/com.js"></script>
	<!--<script src="media/system/DataTables/datatables.min.js"></script>-->
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
	//console.log(e.which);
		if (e.which == 13) {
			// close model form
			//alert("entered");
			var cur_cell = currCell.html().toString();
			$("#article_code").val(cur_cell);$(".modal.in").modal("hide");return false;
		}
		currCell = navigateTableCells(e, currCell)
	});		




	$("input#left-article_code").keypress(function(e){
		e.stopPropagation();
		//alert(e.which);
		txt_article = $("input#left-article_code").val();
		if (e.which==13){
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