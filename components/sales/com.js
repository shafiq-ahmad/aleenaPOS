
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
var invArts= [];
var multiQty=false;
var txt_article='';
var subTotal=0;
var row_id=0;
currCell = $('.nav-able td').first();

function cals_subTotal(){
	var total = 0;
	var discount = 0;
	$('#invArticles .row').each(function( index, element ){
		// element == this
		//$( element ).css( "backgroundColor", "yellow" );
		var qty = eval($(element).find('.qty input').val());
		var disc = eval($(element).find('.disc input.dis').val());
		var price_terms = $(element).find('.price input.price_terms').val();
		var price = $(element).find('.price input.pr').val();
		//console.log(price_terms);
		if(qty==0){
			$(element).remove();
		}else{
			if(price_terms){
				var match_qty = qty;
				var j_obj = JSON.parse(price_terms);
				//console.log(j_obj);
				for (i in j_obj){
					if(match_qty>=eval(j_obj[i].qty)){
						price=eval(j_obj[i].price);
					}
				}
			}
			discount += disc*qty;
			if(price){
				//console.log(typeof(price));
				$(element).find('.price input.pr').val(price);	//replace with new tp price
			}
			$(element).find('.total').text(price*qty);
			//console.log($(element).find('.price input.pr').val());	//replace with new tp price
			total += eval($(element).find('.total').text());
		}
	});
	$("#sub_total").val((total).toFixed(2));
	$("#discount_amount").val((discount).toFixed(2));
	$("#net_total").val((total-discount).toFixed(2));
	//$("#sub_total").val((eval($("#sub_total").val()) + eval($(element).text())).toFixed(2));

}

function cals_reportItemsTotal(){
	var subTotal =0;
	var subTotalMargin =0;
	var discount_amount =0;
	var cash =0;
	var credit =0;
	var change_return =0;
	$('#tblContentBody tr td').each(function( index, element ){
		var style = $( element ).parent().css( "display");
		if(style != 'none'){
			//$("#sub_total").val((eval($("#sub_total").val()) + eval($(element).text())).toFixed(2));
			if($(element).hasClass('total')==true){
				subTotal += eval($(this).text());
			}
			
			if($(element).hasClass('margin')==true){
				subTotalMargin += eval($(this).text());
			}
			
			if($(element).hasClass('discount_amount')==true){
				discount_amount += eval($(this).text());
			}
			
			if($(element).hasClass('cash')==true){
				cash += eval($(this).text());
			}
			
			if($(element).hasClass('credit')==true){
				credit += eval($(this).text());
			}
			
			if($(element).hasClass('change_return')==true){
				change_return += eval($(this).text());
			}
			
			//console.log(r);
		
		}
	});
	$('#subTotal').text(subTotal);
	$('#subTotalMargin').text(subTotalMargin);
	$('#discount_amount').text(discount_amount);
	$('#cash').text(cash);
	$('#credit').text(credit);
	$('#change_return').text(change_return);

}

function calc_bill(){
	var sub_total = Number($('#sub_total').val());
	var discount = Number($('#discount_amount').val());
	var net_total = sub_total-discount;
	$('#net_total').val(net_total)
	var cash = Number($('#cash').val());
	var credit = Number($('#credit').val());
	var cust_account_value = Number($('#cust_account_value').val());
	if(cust_account_value>0){
		//$( "#keep" ).prop( "tabindex", '' );
	}else{
		//$( "#keep" ).prop( "tabindex", -1 );
	}
	var payment = cash + credit;
	
	var change = payment-sub_total+discount;
	$("#change").val(change);
	return change;
}

function validate_form(){
	var need_customer = false;
	var credit = eval($('#credit').val());
	//var keep = eval($('#keep').val());
	var change = eval($('#change').val());
	var sub_total = eval($('#sub_total').val());
	var cust_account_value = eval($('#cust_account_value').val());
	//if(credit>0 || keep>0){
	if(credit>0){
		need_customer=true;
	}
	if(credit > sub_total){
		showMsg('Credit amount can\'t exceed total');
		$('#credit').focus();
		$('#credit').select();
		return false;
	}
	if(need_customer){
		var customer =$('#customer_id').val();
		if(!customer){
			showMsg('Please choose a customer');
			$('#customer_id').focus();
			$('#customer_id').select();
			return false;
		}
	}
	if(change < 0){
		showMsg('Please set payment.');
		$('#cash').focus();
		$('#cash').select();
		return false;
		
	}
	return true;
}

function showMsg(msg){
	$(".form-message").show();
	$(".form-message span").html(msg);
	//$(".form-message span").show();
	$(".form-message").fadeOut( 10000, function() {
		$(".form-message").hide();
	});
}

function getRecentSale(lmt=2){
	$.get("?com=sales&view=sales&task=json&tmpl=com", {limit: lmt}, function(result){
		if(!result){
			showMsg('Can\'t retrieve recent bills.');
			return false;
		}
		//console.log(result);
		var obj = result;
		var html = '<table id="" class="table"><tbody><tr><th>ID</th><th>Date</th><th>Amount</th></tr>';
		$.each(obj, function(i, v) {
			html = html + '<tr>';
			html = html + '<td><a onClick="getInvoice(' + v.id + ');return false;" href="?com=sales&view=pos&id=' + v.id + '">' + v.id + '</a></td>';
			html = html + '<td>' + v.sale_date + '</td>';
			html = html + '<td>' + v.sub_total + '</td>';
			html = html + '</tr>';
		});
		html = html + '</tbody></table>';
		//console.log(html);
		$("#recent-sale .module-wrapper").html(html);
		
		
	}).done(function(){ /*console.log('Request done!');*/ })
        .fail(function(jqxhr, settings, ex) { showMsg('failed, ' + ex); });
}

function getNewSaleNo(){
	$.get("?com=sales&view=sale&task=get&tmpl=com", {type: 'new_id'}, function(result){
		if(!result){
			showMsg('Can\'t retrieve new bill#.');
			return false;
		}
		//console.log(result+'from new bill#');
		if(!isNaN(result)){
			var sale_id = eval(result);
			$('#sale_').val(sale_id);
			$('#sale_id').val(sale_id);
			makeBarcode(sale_id);
			return sale_id;
		}else{
			showMsg('Can\'t retrieve new bill#.');
			return false;
		}
	}).done(function(){ /*console.log('Request done!');*/ })
        .fail(function(jqxhr, settings, ex) { showMsg('failed, ' + ex); });
}

function getNewQuotationNo(){
	$.get("?com=sales&view=sale&task=get&tmpl=com", {type: 'new_quotation_id'}, function(result){
		//console.log(result+'from new Quotation#');
		if(!result){
			showMsg('Can\'t retrieve new Quotation#.');
			return false;
		}
		if(!isNaN(result)){
			var quotation_id = eval(result);
			$('#quotation_').val(quotation_id);
			$('#quotation_id').val(quotation_id);
			return quotation_id;
		}else{
			showMsg('Can\'t retrieve new quotation#.');
			return false;
		}
	}).done(function(){ /*console.log('Request done!');*/ })
        .fail(function(jqxhr, settings, ex) { showMsg('failed, ' + ex); });
}

function getArtInfo(txt,mQty = false){
	//console.log(txt);
	var bill_status = $('#bill_status').val();
	if(bill_status!="Open"){
		//$("#invArticles").html(''); // clear invoice contents
		$('#bill_status').val('Open');
		//var sale_id = getNewSaleNo();
		getNewSaleNo();
		//console.log(sale_id);
		if(!sale_id){return false;}
		unlockForm();
	}
	
	if(txt==''){return false;}
		if(auto_multiQty){
			multiQty=true;
		}else{
			multiQty = false;
			txt = txt.toString();
			var pos = txt.substr(0,1);
			if(pos=="+"){
				txt = txt.substr(1);
				multiQty = true;
				mQty = true;
			}
		}
		//console.log(txt);
	$.post("?com=articles&view=article&task=json&tmpl=com", {article_code: txt}, function(obj){
		//try{
		//var obj = JSON.parse(result);
		//}catch(e){}
		//console.log(obj);
		if(!obj){
			//$('#title').val('No Item found');
			showMsg('No Item found');
			return false;
		}
		//window.location.assign("https://www.w3schools.com"); //load this location
		var loc_txt = window.location.search;
		$('#article_code').val(obj.article_code);
		$('#title').val(obj.title);
		$('#qty1').val(obj.qty1);
		var qty1 = eval($('#qty1').val());
		$('#qty').val(obj.qty1);
		$('#stock').val(obj.qty);
		$('#scheme').val(obj.scheme);
		//console.log(typeof(qty1));
		if(qty1<=0){
			showMsg('Please enter a valid Qty.');
			return false;
		}
		$('#sale_price').val(obj.sale_price);
		/*if(loc_txt=='?com=sales&view=pos'){
		}else{}*/
		$('#discount-item').val(obj.discount);
		$('#sale_price_terms').val(obj.sale_price_terms);
		
		if(multiQty==true){
			$('#qty1').focus();
			$('#qty1').select();
			return false;
		}
		if(mQty ==true){
			//console.log(pos);
			$('#qty1').focus();
			$('#qty1').select();
			return false;
		}
		preSetInvArticle();
	},'json').done(function() { /*console.log('Request done!');*/ })
        .fail(function(jqxhr, settings, ex) { console.log('failed, ' + ex); });/**/
}

function getArtInfoQuotation(txt,mQty = false){
	var bill_status = $('#bill_status').val();
	if(bill_status!="Open"){
		$('#bill_status').val('Open');
		getNewQuotationNo();
		if(!id){return false;}
		unlockForm();
	}
	
	if(txt==''){return false;}
		if(auto_multiQty){
			multiQty=true;
		}else{
			multiQty = false;
			txt = txt.toString();
			var pos = txt.substr(0,1);
			if(pos=="+"){
				txt = txt.substr(1);
				multiQty = true;
				mQty = true;
			}
		}
	$.post("?com=articles&view=article&task=json&tmpl=com", {article_code: txt}, function(result){
		var obj = result;
		if(!obj){
			showMsg('No Item found');
			return false;
		}
		var loc_txt = window.location.search;
		$('#article_code').val(obj.article_code);
		$('#title').val(obj.title);
		$('#qty1').val(obj.qty1);
		var qty1 = eval($('#qty1').val());
		$('#qty').val(obj.qty1);
		$('#stock').val(obj.qty);
		$('#scheme').val(obj.scheme);
		//console.log(typeof(qty1));
		if(qty1<=0){
			showMsg('Please enter a valid Qty.');
			return false;
		}
		$('#sale_price').val(obj.sale_price);
		/*if(loc_txt=='?com=sales&view=pos'){
		}else{}*/
		$('#discount-item').val(obj.discount);
		$('#sale_price_terms').val(obj.sale_price_terms);
		
		if(multiQty==true){
			$('#qty1').focus();
			$('#qty1').select();
			return false;
		}
		if(mQty ==true){
			//console.log(pos);
			$('#qty1').focus();
			$('#qty1').select();
			return false;
		}
		preSetQArticle();
	},'json').done(function() { /*console.log('Request done!');*/ })
        .fail(function(jqxhr, settings, ex) { console.log('failed, ' + ex); });/**/
}


function getReturnArtInfo(txt,mQty = false){
	if(txt==''){return false;}
	var bill_status = $('#bill_status').val();
	if(bill_status!="Open"){
		//$("#invArticles").html(''); // clear invoice contents
		$('#bill_status').val('Open');
		getNewReturnNo();
		//console.log(sale_id);
		if(!sale_id){return false;}
		unlockForm();
	}
	
		if(auto_multiQty){
			multiQty=true;
		}else{
			multiQty = false;
			txt = txt.toString();
			var pos = txt.substr(0,1);
			if(pos=="+"){
				txt = txt.substr(1);
				multiQty = true;
				mQty = true;
			}
		}
		//console.log(txt);
		
		
	$.post("?com=articles&view=article&task=json&tmpl=com", {article_code: txt}, function(obj){
		if(!obj){
			showMsg('No Item found');
			return false;
		}
		//var loc_txt = window.location.search;
		$('#article_code').val(obj.article_code);
		$('#title').val(obj.title);
		$('#qty1').val(obj.qty1);
		var qty1 = eval($('#qty1').val());
		$('#qty').val(obj.qty1);
		$('#stock').val(obj.qty);
		$('#scheme').val(obj.scheme);
		//console.log(typeof(qty1));
		if(qty1<=0){
			showMsg('Please enter a valid Qty.');
			return false;
		}
		$('#sale_price').val(obj.sale_price);
		/*if(loc_txt=='?com=sales&view=pos'){
		}else{}*/
		$('#discount-item').val(obj.discount);
		//$('#sale_price_terms').val(obj.sale_price_terms);
		$('#sale_price_terms').val('');
			//var j_obj = JSON.parse(price_terms);
		
		if(multiQty==true){
			$('#qty1').focus();
			$('#qty1').select();
			return false;
		}
		if(mQty ==true){
			//console.log(pos);
			$('#qty1').focus();
			$('#qty1').select();
			return false;
		}
		preSetInvArticleReturn();
	},'json').done(function() { /*console.log('Request done!');*/ })
        .fail(function(jqxhr, settings, ex) { console.log('failed, ' + ex); });
	
	
}

function setPostData(){
	var valid_form = validate_form();
	if(!valid_form){return false;}
	$.post('?com=sales&view=ajax&task=html&part=setInvArticle&tmpl=com', $('#invArts').serialize(), function(obj){
		//console.log(obj);
		if(!obj.sub_total){showMsg('Data not saved');return false;}
		if(eval($('#sub_total').val()) != eval(obj.sub_total)){
			showMsg('Data not saved...');
			return false;
		}else{
			printInvoice(obj.id);
		}
		$('#bill_status').val('Closed');
		if(user_opt.fast_new_bill){
			//console.log('fast billing');
			//unlockForm(true);
		}else{
			//lockForm();
		}
		lockForm();
		getRecentSale(5);
		$("#article_code").focus();
		$("#article_code").select();
		return obj.sub_total;
	//});
	},'json');
	return false;

}

function setQuotationData(){
	var valid_form = validate_form();
	if(!valid_form){return false;}
	$.post('?com=sales&view=ajax&task=html&part=setQuotationArticle&tmpl=com', $('#invArts').serialize(), function(obj){
		//console.log(obj);
		if(!obj.sub_total){showMsg('Data not saved');return false;}
		if(eval($('#sub_total').val()) != eval(obj.sub_total)){
			showMsg('Data not saved...');
			return false;
		}else{
			printInvoice(obj.id);
		}
		$('#bill_status').val('Closed');
		unlockForm();
		getRecentSale(5);
		$("#article_code").focus();
		$("#article_code").select();
		return obj.sub_total;
	//});
	//});
	},'json');
	return false;

}

function printInvoice(id){
	//if(!id){return false;}
	//$("#printabel").remove();
	//$("<iframe id='printabel'>")
	//.hide()
	//.attr("src", "?com=sales&view=pos&print=1&id="+id)
	//.attr("src", "?com=sales&view=pos&id="+id)
	//.appendTo("body");
	
	//return false;
	//console.log('printed');
	window.print();
	return false;
	try{
		var oIframe = document.getElementById('printabel');
		var oContent = document.getElementById('componant').innerHTML;
		var oDoc = (oIframe.contentWindow || oIframe.contentDocument);
		if (oDoc.document) oDoc = oDoc.document;
		oDoc.write('<head><title></title>');
		oDoc.write('<link rel="stylesheet" type="text/css" href="css/print.css" media="print" />');
		oDoc.write('</head><body onload="this.focus(); this.print();">');
		oDoc.write(oContent + '</body>');
		//oDoc.close();
	} catch(e){
		self.print();
	}
}

function setPostReturnData(){
	var valid_form = validate_form();
	if(!valid_form){return false;}
	//console.log('posting returns...');
	$.post('?com=sales&view=ajax&task=html&part=setInvReturnArticle&tmpl=com', $('#invArts').serialize(), function(obj){
		//console.log(obj);
		if(!obj){showMsg('Data not saved');return false;}
		if(eval($('#sub_total').val()) != eval(obj.sub_total)){
			showMsg('Data not saved...');
			return false;
		}else{
			printInvoice(obj.id);
		}
		$('#bill_status').val('Closed');
		unlockForm();
		getRecentSale(5);
		$("#article_code").focus();
		$("#article_code").select();
		return obj.sub_total;
	//});
	},'json');
	return false;

}

function addBillRow(row_id, article_code, sale_price, qty1,stock,bill_status, title, price_terms, discount,tp_price){
	var id ='#invRow' + row_id;
	//console.log(article_code);
	//var cost_total = sale_price*qty1;
	var cost_total = tp_price*qty1;
	$("input#cost_total").val(cost_total);
	var js ="";
	//if(bill_status==0){bill_status='Open';}
	//if(bill_status==1){bill_status='Closed';}
	bill_status = $("#bill_status").val()
	//console.log(bill_status);
	if(bill_status=='Open'){
		js ="if($('#bill_status').val()=='Open'){$('" + id + "').remove();} ";
		js = js + "$('#sub_total').val(0); cals_subTotal(); ";
		js = js + "return false; ";
	}
	var tableRow = $("#invArticles .item").filter(function() {
		//console.log($(this).text());
		return $(this).text() == article_code;
	}).closest(".row");
	if(tableRow.html()){
		var new_qty = tableRow.find('.qty input').val(eval(tableRow.find('.qty input').val())+qty1);
		//console.log(new_qty);
		var new_qty = $(tableRow).find('.qty input').val();
		var new_price = $(tableRow).find('.price').text();
		var new_disc = $(tableRow).find('.disc').text();
		$(tableRow).find('.total').text(eval(new_qty)*eval(new_price));	
	}else{
		var html = '<div id="invRow' + row_id + '" class="row well-sm">';
		html = html + '<div class="col-sm-2 cell item screen"><input type="hidden" name="article_code[]" value="'+article_code+'" />' +article_code+ '</div>';
		html = html + '<div class="col-sm-4 cell title">'+title+'</div>';
		html = html + '<div class="col-sm-1 cell qty"><input class="number inputbox form-control input-sm" name="qty[]" value="'+qty1+'" readonly /></div>';
		html = html + '<div class="col-sm-1 cell price" title="' + price_terms.replace(/\"/g, "") + '"><input name="price[]" class="pr inputbox form-control input-sm" value="'+sale_price+'" readonly />';
		html = html + '<input type="hidden" name="price_terms[]" class="price_terms" value=\''+price_terms+'\' /></div>';
		html = html + '<div class="col-sm-1 cell disc screen"><input name="discount[]" class="dis inputbox form-control input-sm" value="'+discount+'" /></div>';
		html = html + '<div class="col-sm-1 cell total">' + cost_total + '</div>';
		html = html + '<div class="col-sm-1 cell stock screen">'+stock+'</div>';
		if(bill_status=='Open'){
			html = html + '<div class="col-sm-1 cell action screen action"><a href="#" onclick="' + js + '" tabindex="-1">X</a></div>';
		}
		html = html + '</div">';
		//console.log(html);
		//$("#invArticles").append(html);
		$("#invArticles").append(html);
		cals_subTotal();
		//alert('ffffff');
	}
	
}

function clearArtForm(){
	$("#article_code").val('');
	$("#qty").val('');
	$("#qty1").val('');
	$("#scheme").val('');
	$("#title").val('');
	$("#sale_price").val('');
	//var loc_txt = window.location.search;
	//if(loc_txt=='?com=sales&view=distributor'){}
	$("#cost_total").val('');
	$("#stock").val('');
	$("#discount-item").val('');
	$("#article_code").focus();
	$("#article_code").select();
}

function getInvoice(sale_id){
	//?com=sales&view=sale&task=get&id=98
	clearForm();
	$.get("?com=sales&view=sale&task=get&tmpl=com", {id: sale_id}, function(result){
		if(!result){
			showMsg('Can\'t retrieve bill#: ' + sale_id);
			return false;
		}
		var obj = result;
		$('#sale_').val(obj.id);
		$('#sale_id').val(obj.id);
		$('#cash').val(obj.cash);
		$('#change').val(obj.change_return);
		$('#discount_amount').val(obj.discount_amount);
		$('#credit').val(obj.credit);
		$('#person').val(obj.person);
		$('#customer_id').val(obj.customer_id);
		$('#sub_total').val(obj.sub_total);
		$('#user .date-time').text(obj.time_stamp);
		if(obj.sale_status==0){$("#bill_status").val("Open");unlockForm(false);}
		if(obj.sale_status==1){$("#bill_status").val("Closed");lockForm();}
		//console.log(obj.time_stamp);
		//$('#cust_account_value').val(0);
		//$('#cust_address').val('');
		var arts = JSON.parse(obj.data_articles);
		//console.log(typeof(arts.articles));
		if(arts){
			var row_id=1;
			$.each(arts, function(i,v){
				//console.log(v);
				addBillRow(row_id, v.article_code, v.price, v.qty,v.stock,obj.bill_status, v.title, '', v.discount,v.tp_price)
				row_id++;
			});
		}
		
		
	},'json').done(function(){ /*console.log('Request done!');*/ })
        .fail(function(jqxhr, settings, ex) { showMsg('failed, ' + ex); });
}

function clearForm(){
	$('#sale_').val(0);
	$('#sale_id').val(0);
	$('#quotation_id').val(0);
	$('#cash').val(0);
	$('#change').val(0);
	$('#bank_card').val(0);
	$('#bank_check').val(0);
	$('#discount_amount').val(0);
	$('#credit').val(0);
	$('#net_total').val(0);
	$('#person').val('');
	$('#customer_id').val('');
	$('#cust_account_value').val(0);
	$('#cust_address').val('');
	//$('#keep').val(0);
}

function lockForm(){
	$( "#cash" ).prop( "readonly", true );
	$( "#credit" ).prop( "readonly", true );
	$( "#bank_card" ).prop( "readonly", true );
	$( "#customer_id" ).prop( "disabled", true );
	$( "#bank_check" ).prop( "readonly", true );
	$( "#discount_amount" ).prop( "readonly", true );
	$( "#person" ).prop( "readonly", true );
	$( ".form-bill-total #inv-done" ).prop( "disabled", true );
	$( ".form-bill-total #inv-done" ).hide();
}

function unlockForm(clear=true){
	if(clear){
		clearForm();
	}
	$( "#cash" ).prop( "readonly", false );
	$( "#credit" ).prop( "readonly", false );
	$( "#bank_card" ).prop( "readonly", false );
	$( "#customer_id" ).prop( "disabled", false );
	$( "#bank_check" ).prop( "readonly", false );
	$( "#discount_amount" ).prop( "readonly", false );
	$( "#person" ).prop( "readonly", false );
	$( "#inv-done" ).prop( "disabled", false );
	$( ".form-bill-total #inv-done" ).prop( "disabled", false );
	$( ".form-bill-total #inv-done" ).show();
	$("#invArticles").html('');

}

function preSetInvArticle(){
	//insert to invoice
	var bill_status = $('#bill_status').val();
	if(bill_status!="Open"){
		//$("#invArticles").html(''); // clear invoice contents
		$('#bill_status').val('Open');
		getNewSaleNo();
		if(!sale_id){return false;}
		unlockForm();
	}
	
	row_id += 1;
	var sale_price = eval($('#sale_price').val());
	var qty1 = eval($('#qty1').val());
	var article_code = $('#article_code').val();
	var bill_status = $('#bill_status').val();
	var stock = $('#stock').val();
	var title = $('#title').val();
	var price_terms = $('#sale_price_terms').val();
	var sale_price = $('#sale_price').val();
	var discount = $('#discount-item').val();
	var tp_price = $('#tp_price').val();
	addBillRow(row_id, article_code, sale_price, qty1, stock, bill_status, title, price_terms, discount,tp_price);
	//
	
	clearArtForm();
	$('#sub_total').val(0);
	cals_subTotal();
	
}

function preSetQArticle(){
	//insert to invoice
	var bill_status = $('#bill_status').val();
	if(bill_status!="Open"){
		//$("#invArticles").html(''); // clear invoice contents
		$('#bill_status').val('Open');
		getNewQuotationNo();
		if(!sale_id){return false;}
		unlockForm();
	}
	
	row_id += 1;
	var sale_price = eval($('#sale_price').val());
	var qty1 = eval($('#qty1').val());
	var article_code = $('#article_code').val();
	var bill_status = $('#bill_status').val();
	var stock = $('#stock').val();
	var title = $('#title').val();
	var price_terms = $('#sale_price_terms').val();
	var sale_price = $('#sale_price').val();
	var discount = $('#discount-item').val();
	var tp_price = $('#tp_price').val();
	addBillRow(row_id, article_code, sale_price, qty1, stock, bill_status, title, price_terms, discount,tp_price);
	//
	
	clearArtForm();
	$('#sub_total').val(0);
	cals_subTotal();
	
}

function preSetInvArticleReturn(){
	
	//insert to invoice
	var bill_status = $('#bill_status').val();
	if(bill_status!="Open"){
		//$("#invArticles").html(''); // clear invoice contents
		$('#bill_status').val('Open');
		getNewReturnNo();
		if(!sale_id){return false;}
		unlockForm();
	}
	
	row_id += 1;
	var sale_price = eval($('#sale_price').val());
	var qty1 = eval($('#qty1').val());
	var article_code = $('#article_code').val();
	var bill_status = $('#bill_status').val();
	var stock = $('#stock').val();
	var title = $('#title').val();
	var price_terms = $('#sale_price_terms').val();
	var sale_price = $('#sale_price').val();
	var discount = $('#discount-item').val();
	var tp_price = $('#tp_price').val();
	addBillRow(row_id, article_code, sale_price, qty1, stock, bill_status, title, price_terms, discount,tp_price);
	//
	
	clearArtForm();
	$('#sub_total').val(0);
	cals_subTotal();
	
}

function makeBarcode(code){
JsBarcode("#barcode", code, {height:40,fontSize:12});
// or with jQuery
//$("#barcode").JsBarcode(code);
}

function getNewReturnNo(){
	$.get("?com=sales&view=return&task=get&tmpl=com", {type: 'new_id'}, function(result){
		//console.log(result+'from new r#');
		if(!result){
			showMsg('Can\'t retrieve new Return#.');
			return false;
		}
		if(!isNaN(result)){
			var return_id = eval(result);
			$('#return_').val(return_id);
			$('#return_id').val(return_id);
			return return_id;
		}else{
			showMsg('Can\'t retrieve new return#.');
			return false;
		}
	}).done(function(){ /*console.log('Request done!');*/ })
        .fail(function(jqxhr, settings, ex) { showMsg('failed, ' + ex); });
}

function _calc_innerForm(){
	
	//var cost_total = (Number($('#sale_price').val())-Number($('#discount-item').val()))*Number($('#qty1').val());
	//$("input#cost_total").val(cost_total);
	var new_qty = $(this).find('.qty input').val();
	var new_price = $(this).find('.price').val();
	var new_disc = $(this).find('.disc').val();
	$(this).find('.total').val(eval(new_qty)*eval(new_price));
	
	
	$("#article_code").focus();
	$("#article_code").select();
}

function clearArtReturnForm(){
	$("#article_code").val('');
	$("#qty").val('');
	$("#qty1").val('');
	$("#scheme").val('');
	$("#title").val('');
	$("#sale_price").val('');
	$("#cost_total").val('');
	$("#stock").val('');
	$("#discount-item").val('');
	$("#article_code").focus();
	$("#article_code").select();
}


	