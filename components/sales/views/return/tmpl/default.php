<?php
defined('_MEXEC') or die ('Restricted Access');
$app = core::getApplication();
$message=$app->getMessage();

?>
<form id="invArts">
<div id="header">
	<div id="logo-section">
		<div id="logo"></div>
		<div id="company">
			<div class="title"><?php echo $app->branch_title; ?></div>
			<div class="address"><?php echo $app->branch_address; ?></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="doc-title">Sales return</div><div class="clear"></div>
	<div id="user">
		<p class="left">
		<?php echo date('d / m /Y       h:i:sa'); ?> - 
		</p><p class="right"><?php echo $app->full_name ?></p>
	</div><div class="clear"></div>
	
	
	<div><label class="" for="return_">Return#:</label><div><input id="return_" name="return_" class="inputbox form-control input-sm" value="" readonly tabindex="-1" /></div></div>
	<div><label class="" for="return_id">Bill#:</label><div><input id="return_id" name="return_id" class="inputbox form-control input-sm" value="" tabindex="-1" /></div></div>
	<div class="customer screen"><label class="" for="customer_id">Customer:</label><div class="customer_id"><?php
	echo '<SELECT name="customer_id" id="customer_id" class="customer_id form-control dropdown-header">';
	echo '<OPTION value="">....</OPTION>';
	foreach ($this->customers as $c){
		echo '<OPTION value="' . $c['id'] . '">' . $c['title'] . '</OPTION>';
	}
	echo '</SELECT>';
	?>
	</div>
	<div><label class="" for="cust_address">Address:</label><div class=""><input id="cust_address" name="cust_address" class="inputbox form-control input-sm" value="" readonly tabindex="-1" /></div></div>

</div>
	<div><label class="" for="cust_account_value">Balance:</label><div><input id="cust_account_value" name="cust_account_value" class="inputbox form-control input-sm number" value="" readonly tabindex="-1" /></div></div>
	<div><label class="" for="person">Person:</label><div><input id="person" name="person" class="inputbox form-control input-sm" value="<?php if(isset($pur)){ echo $pur['person'];}?>" /></div></div>

	
<div id="message"><?php
	if($message){
		//echo '<span class="message ' . $message['class'] . '">' . $message['text'] . '</span>';
	}
?></div>
</div>
<div id="center">
	<div id="componant">
	
	<iframe id="ifrmPrint" style="width:0;height:0;"></iframe><?php
	$app = core::getApplication();
	$css_path = "templates/{$app->getTemplate()}/css/print_" . $this->u['print_paper_size'] . ".css";

?><link rel="stylesheet" type="text/css" href="<?php echo $css_path;?>" media="print" />

<div class="form">
<div class="form-message"><span class="info"></span></div><?php
	$list = array();
	$list['view']='return';
	$list['task']='edit';
	$view = $this->getView('return', 'sales', 'edit');
	echo $view->display($list);
?></div>
<div class="table-responsive frm_sale_art">
		<div class="row well-sm th">
			<div class="col-sm-2 cell screen item">Item#</div><div class="col-sm-4 cell title">Title</div><div class="col-sm-1 cell qty">Return</div><div class="col-sm-1 cell price">Price</div>
			<div class="col-sm-1 cell screen disc">Dis.</div><div class="col-sm-1 cell price">Amount</div><div class="col-sm-1 cell screen">Stock</div><div class="col-sm-1 cell screen action">Action</div>
		</div><div id="invArticles"></div>
</div>
		<fieldset class="form-bill-total">
		<div class="grid">
			<input type="hidden" name="form_type" value="sale_main" />
			<input type="hidden" id="bill_status" name="bill_status" value="" />
			<div class="row well-sm">
				<div class="hide"><label class="control-label" for="sub_total">Total:</label><div><input id="sub_total" name="sub_total" class="inputbox form-control input-sm number" value="0" readonly tabindex="-1" /></div></div>
				<div class="hide"><label class="control-label" for="discount_amount">Discount:</label><div><input id="discount_amount" name="discount_amount" class="inputbox form-control input-sm number" value="0" tabindex="-1" readonly /></div></div>
				<div><label class="control-label" for="net_total">Amount:</label><div><input id="net_total" name="net_total" class="inputbox form-control input-sm" value="" tabindex="-1" readonly /></div></div>
				<div><label class="control-label" for="cash">Cash:</label><div><input id="cash" name="cash" title="Shortcut 'Insert' key" class="inputbox form-control input-sm" value="" /></div></div>
				<div><label class="control-label" for="credit">Credit:</label><div><input id="credit" name="credit" class="inputbox form-control input-sm" value="0" tabindex="-1" /></div></div>
				
				<div class="screen">
				<label>&nbsp;</label>
				<a href="#" id="inv-done" class="btn btn-primary btn-lg hide" tabindex="-1" onclick="calc_bill();setPostReturnData();printInvoice();return false;">Save</a>
				</div>

			</div><div class="clear"></div>
		</div><div class="clear"></div>
		</fieldset>

	</div>
</div>

</form>

<?php
$script = '


	function validateFormInput(){
		console.log("validating...");
		var article_code = $("#article_code").val();
		var sale_price = eval($("#sale_price").val());
		var qty = eval($("#qty1").val());
		if(!article_code){
			$("#article_code").focus();
			$("#article_code").select();
			return false;
		}
		console.log(qty);
		if(!qty){
		console.log(qty);
			$("#qty1").focus();
			$("#qty1").select();
			return false;
		}
		if(!sale_price){
			$("#sale_price").focus();
			$("#sale_price").select();
			return false;
		}
		return true;
	}

	$("#article_code").focus();
	$("#article_code").select();
	$("input#article_code").keypress(function(e){
		//alert(txt_article);
		e.stopPropagation();
		txt_article = $("input#article_code").val();
		if (e.which==13){
			//return false;
			txt_article = txt_article.toString();
			var pos = txt_article.substr(0,1);
			if(pos=="-"){
				artSearch(txt_article);
				return false;
			}
			getReturnArtInfo(txt_article);

		
		} //end which
	});

		$("#sub_total").change(function(e){
		//e.stopPropagation();
			subTotal = subTotal - eval($("#sub_total").val());
			//console.log(subTotal);
			calc_bill();
	});

	$("#cash").keyup(function(e){
		e.stopPropagation();
		if (e.which==13){
			if($("#bill_status").val()=="Open"){
				calc_bill();
				var res = setPostReturnData();
				if(!res){return false;}
				printInvoice();
				$("#article_code").focus();
				$("#article_code").select();
			}
			return false;
		} //end which
	});

	$("#credit").keyup(function(e){
		e.stopPropagation();
		if (e.which==13){
			$("#cash").focus();
			$("#cash").select();
			calc_bill();
			return false;
		} //end which
	});

	$("input#qty1").keypress(function(e){
		e.stopPropagation();
		if (e.which==13){
			if(validateFormInput()){
				preSetInvArticleReturn();
			}
			e.preventDefault();
		} //end which
	});
	
	$("input#sale_price").keypress(function(e){
		e.stopPropagation();
		if (e.which==13){
			if(validateFormInput()){
				preSetInvArticleReturn();
			}
			e.preventDefault();
		} //end which
	});
	
	$("input#discount_amount").keyup(function(e){
		//e.stopPropagation();
		if (e.which==13){
			$("#cash").focus();
			$("#cash").select();
			calc_bill();
			return false;
		} //end which
	});

	$("#customer_id").change(function(e){
		//e.stopPropagation();
		$("#cust_address").val("");
		$("#cust_account_value").val("");
		var cus = $("#customer_id option:selected").val();
		if(cus){
			$("#customer_id").closest(".customer").removeClass("screen");
		}else{
			$("#customer_id").closest(".customer").addClass("screen");
		}
		$("#cust_name").val($("#customer_id option:selected").text());
		var customer_id = $("#customer_id").val();
		if(!customer_id){return false;}
	$.post("?com=customers&view=customer&task=json&tmpl=com", {id: customer_id}, function(obj){
		//console.log(result);
		//var obj = JSON.parse(result);
		//console.log(obj.id);
		//console.log(typeof(result));
		if(!obj){showMsg("Data not saved");return false;}
		$("#cust_account_value").val(eval(obj.account_value));
		$("#cust_address").val(obj.address);
		calc_bill();
		if(obj.account_value>0){
			$("#cash").focus();
			$("#cash").select();
			return false;
			
		}
		return obj;
	});
	});

	$("div.form-bill-total input").focusout(function(e){
		calc_bill();
		return false;
	});

	$("input.number").keypress(function(e){
		//e.stopPropagation();
		if(!inputNumber(e)){return false;}
	});

	$("table.nav-able").keydown(function(e){
	//console.log(e.which);
		if (e.which == 13) {
			// close model form
			//alert("entered");
			var cur_cell = currCell.html().toString();
			$("#article_code").val(cur_cell);$(".modal.in").modal("hide");getReturnArtInfo(currCell.html(),true);return false;
		}
		currCell = navigateTableCells(e, currCell)
	});

	$("#art-ok").click(function(e){
		e.preventDefault();
		//alert("clicked");
		//console.log(multiQty);
		if(multiQty){
			preSetInvArticle();
			//alert("multiQty");
			multiQty=false;
		}else{
			getReturnArtInfo($("input#article_code").val());
			//alert("single");
		}
		return false;
	});

	$("#search_filter").focus();
	$("#search_filter").select();
	$("input#search_filter").keyup(function(e){
		var value = $(this).val().toLowerCase();
		$("#tblContentBody tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
		//culculate values
		cals_reportItemsTotal();
	});
	
	
	
	
	
	
    $("body").keydown(function(e){
		var key = e.keyCode || e.which;
		var vFind = "";
		if (key==45){
			vFind = $("input#cash");
			if(vFind.length){
				vFind.focus();
				vFind.select();
				e.preventDefault();
			}
		}
        if(e.ctrlKey){
				console.log(key);
            if (key==67){
            e.preventDefault();
                vFind = $("select#customer_id");
                if(vFind.length){
                    vFind.focus();
                    vFind.select();
                }
            }
            if (key==68){
            e.preventDefault();
                vFind = $("input#discount_amount");
                if(vFind.length){
                    vFind.focus();
                    vFind.select();
                }
            }
        }else{return;}
    });






';

$app->setScript($script);

?>