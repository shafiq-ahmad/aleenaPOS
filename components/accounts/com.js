var invArts= [];
var multiQty=false;
var txt_article='';
var subTotal=0;
var invRowCount=0;
currCell = $('.nav-able td').first();

function cals_subTotal(){
	$('#invArticles .row .total').each(function( index, element ){
		// element == this
		//$( element ).css( "backgroundColor", "yellow" );
		$("#sub_total").val((eval($("#sub_total").val()) + eval($(element).text())).toFixed(2));
	});

}

function cals_reportItemsTotal(){
	var subTotal =0;
	var subTotalMargin =0;
	$('#tblContentBody tr td').each(function( index, element ){
		var style = $( element ).parent().css( "display");
		if(style != 'none'){
			var cellTotal = $(element).hasClass('total');
			var cellMargin = $(element).hasClass('margin');
			
			if(cellTotal==true){
				subTotal += eval($(this).text());
			}
			if(cellMargin==true){
				subTotalMargin += eval($(this).text());
			}
		}
	});
}

function setPostData(){
	$.post('?com=sales&view=ajax&task=html&part=setInvArticle&tmpl=com', $('#invArts').serialize(), function(result){
		//var obj = JSON.parse(result);
		//console.log(obj.id);
		//console.log(result);
		//console.log(typeof(result));
		$('#sale_').val(eval(result));
		$('#sale_id').val(eval(result));
		$('#bill_status').val('Closed');
		//return false;
	});
	$( "#cash" ).prop( "readonly", true );
	$( "#credit" ).prop( "readonly", true );
	$( "#bank_card" ).prop( "readonly", true );
	$( "#bank_check" ).prop( "readonly", true );
	$( "#discount" ).prop( "readonly", true );
	return false;

}

function getArtInfo(txt,mQty = false){
	if(txt==''){return false;}
		multiQty = false;
		txt = txt.toString();
		//console.log(txt);
		//console.log(txt);
	$.post("?com=sales&view=ajax&task=html&part=itemByIDpos&tmpl=com", {filter_text: txt}, function(result){
		//var r = JSON.stringify(result)
		var obj = JSON.parse(result);
		if(!obj){
			$('#title').val('No Item found');
			return false;
		}
		//window.location.assign("https://www.w3schools.com"); //load this location
		//console.log(result);
		var loc_txt = window.location.search;
		
		$('#title').val(obj.title);
		$('#qty1').val(obj.qty1);
		var qty1 = eval($('#qty1').val());
		$('#qty').val(obj.qty);
		$('#scheme').val(obj.scheme);
		if(loc_txt=='?com=sales&view=pos'){
			$('#sale_price').val(obj.sale_price);
		}else{
			$('#sale_price').val(obj.whole_sale_price);
			$('#retail').val(obj.sale_price);
		}
		
		return false;
	});
	
	
}

function clearArtForm(){
	$("#article_code").val('');
	$("#qty").val('');
	$("#qty1").val('');
	$("#scheme").val('');
	$("#title").val('');
	$("#sale_price").val('');
	var loc_txt = window.location.search;
	if(loc_txt=='?com=sales&view=distributor'){
		$("#retail").val('');
	}
	$("#cost_total").val('');
	$("#discount-item").val('');
	$("#article_code").focus();
	$("#article_code").select();
}

$(document).ready(function(){
	
	$("#article_code").focus();
	$("#article_code").select();
	$("input#article_code").keypress(function(e){
		//alert(txt_article);
		e.stopPropagation();
		txt_article = $("input#article_code").val();
		if (e.keyCode==13){
			//return false;
			txt_article = txt_article.toString();
			var pos = txt_article.substr(0,1);
			if(pos=="-"){
				artSearch(txt_article);
				return false;
			}
			getArtInfo(txt_article);
			return false;
		
		} //end keyCode
	});

	$("input.number").keypress(function(e){
		e.stopPropagation();
		if(!inputNumber(e)){return false;}
	});

	$('table.nav-able').keydown(function(e){
		var key = e.keyCode || e.which;
		if (key == 13) {
			// close model form
			//alert('entered');
			$('#article_code').val(currCell.html());$('.modal.in').modal('hide');getArtInfo(currCell.html(),true);return false;
		}
		currCell = navigateTableCells(e, currCell)
	});

	$("input#search_filter").keyup(function(e){
		var value = $(this).val().toLowerCase();
		$("#tblContentBody tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
		//culculate values
		cals_reportItemsTotal();
	});
	
	});
	
	
	