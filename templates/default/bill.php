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

$com = Application::$options->com;
$view = Application::$options->view;

$bArtsJSON = '';
if(!class_exists('View')){import('core.application.component.view');}
$v_obj = new View();
$model_art = $v_obj->getModel('articles.branch_articles');
$bArts = $model_art->getBranchArticles();
//echo count($bArts) . '\n';
//$bArtsJSON = json_encode($bArts);
//$pa =  $user->pageAccess(12);
//print_r ($_SESSION);exit;
//echo time();exit;
//echo md5('abc123');exit;
//base_convert(number,frombase,tobase); // example: base2 to base10
//print_r($_POST);exit;
?><!DOCTYPE html>
<html lang="en"><?php if($this->u){ ?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="media/system/js/jquery-3.3.1.min.js"></script>
	<script src="media/system/js/jquery-ui/jquery-ui.min.js"></script>
<script src="media/system/css/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/JsBarcode/dist/JsBarcode.all.js"></script>
	<script src="templates/<?php echo $this->getTemplate();?>/js/script.js"></script>
	<script type="text/javascript">
		var user_opt = '';
		<?php 
			if($this->u['options']){
				echo 'user_opt = ' . $this->u['options'] . ';'; 
			}
		?>
		var auto_multiQty=true;
		if(user_opt[0]){
			user_opt = user_opt[0];
		}
		if(user_opt.auto_multiQty){
			auto_multiQty = user_opt.auto_multiQty;
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
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/bill.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="media/system/js/jquery-ui/jquery-ui.min.css" media="all" />
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="components/<?php echo $com; ?>/com.css" media="all" />
	<script src="components/<?php echo $com; ?>/com.js"></script>
 

	<title>POS by webapplics.com</title>
</head>
	<body oncontextmenu="">
		<div id="main" class="container-fluid"><?php echo $this->_com;?>
			<div class="clear"></div>
			<div id="footer">
				<p>Powered by: <i>webapplics.com</i></p>
			</div>
			</div>
	</body>
    <script type="text/javascript">
	<?php echo $this->getScript(); ?>

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


    $(window).keydown(function(e){
            var key = e.keyCode || e.which;
            var vFind = '';
            //console.clear();
            //console.log(key);
			if (key==36){
				e.preventDefault();
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

</script><?php } ?>
</html>