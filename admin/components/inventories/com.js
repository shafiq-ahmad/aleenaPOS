
currCell = $('.nav-able td').first();


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

function getArtDetails(){
	var txt = $("input#article_code").val();
	var frm = $("#frm_main_state").val();
	//if(frm=="unset"){alert('Please create a purchase record first.');return false;}
	if(txt==""){return false;}
	$.post("?com=inventories&view=ajax&task=html&part=itemByID&tmpl=com", {filter_text: txt}, function(result){
		//console.log(result);
		var obj = JSON.parse(result);
		//console.clear();
		clearArtForm();
		$('#article_code').val(obj.article_code);
		$('#ref_code').val(obj.ref_code);
		$('#title').val(obj.title);
		$('#packing').val(obj.packing);
		$('#cost_price').val(obj.cost_price);
		$('#sale_price').val(obj.sale_price);
		$('#whole_sale_price').val(obj.whole_sale_price);
		$('#qty').val(obj.qty);
		$('#loc').val(obj.loc_section + ' / ' + obj.loc_rack + ' / ' + obj.loc);
		
	});

}

function saveArticle(){
	var inv_id = $('input#id').val();
	//if(!inv_id){return false;}
	$.post('?com=inventories&view=ajax&task=html&tmpl=com&part=saveInventoryArt&id='+inv_id, $('#frm_pur_art').serialize(), function(result){
		$(".table-responsive").html(result);
		//console.log(result);
	});
	clearArtForm();
	$("#article_code").focus();
	$("#article_code").select();
}

function remInvItem(v_id, item, row){
	$.post('?com=inventories&view=ajax&task=html&part=remInvItem&tmpl=com', {inv_id: v_id, itm: item}, function(result){
		$(".table-responsive").html(result);
		//console.log(result);
	});
	//clearArtForm();
	$("#article_code").focus();
	$("#article_code").select();
}

function saveInvItem(v_id, item, txt){
	txt = txt + ' input';
	var qty = $(txt).val();
	//console.log(txt);
	//console.log(qty);
	$.post('?com=inventories&view=ajax&task=html&part=saveInvItem&tmpl=com', {inv_id: v_id, article_code: item,inv_qty: qty}, function(result){
		//$(".table-responsive").html(result);
		//if no error then disable qty textbox
		$(txt).attr('disabled','disabled');
		//console.log(result);
	});
	//clearArtForm();
	$("#article_code").focus();
	$("#article_code").select();
}

function adjustInvItem(v_id, item, txt){
	txt = txt + ' input';
	var qty = $(txt).val();
	//console.log(txt);
	//console.log(qty);
	$.post('?com=inventories&view=ajax&task=html&part=adjustInvItem&tmpl=com', {inv_id: v_id, article_code: item,inv_qty: qty}, function(result){
		//$(".table-responsive").html(result);
		//if no error then disable qty textbox
		$(txt).attr('disabled','disabled');
		console.log(result);
	});
	//clearArtForm();
	$("#article_code").focus();
	$("#article_code").select();
}


function clearArtForm(){
	$("#article_code").val('');
	$('#ref_code').val('');
	$('#title').val('');
	$('#packing').val('');
	$('#cost_price').val('');
	$('#sale_price').val('');
	$('#whole_sale_price').val('');
	$('#qty').val('');
	$('#inv_qty').val('');
	$('#loc').val('');
}


$(document).ready(function(){

	currCell = $('.nav-able td').first();
	$('.nav-able td').focus();

	$("input.number").keypress(function(e){
		e.stopPropagation();
		if(!inputNumber(e)){e.preventDefault();}
	});

	
	$("tr .inv_qty input").keyup(function(e){
		if (e.keyCode==13 || e.which==13){
			e.preventDefault();
			var row_id = '#' + $(this).closest('tr').attr('id');
			var qty = $(this).val();
			var itm = row_id + ' .article_code';
			var item = $(itm).text();
			var v_id = $('input#id').val();
			if(!item || !v_id || !qty){
				console.log('Invalid value');
				return false;
			}
			$.post('?com=inventories&view=ajax&task=html&part=saveInvItem&tmpl=com', {inv_id: v_id, article_code: item,inv_qty: qty}, function(result){
				//$(txt).attr('disabled','disabled');
				//console.log(result);
				$(row_id).hide();
			});
			var next_input = '#' + $(row_id).next('tr').attr('id') + ' input';
			$(next_input).focus().select();
			return false;
		} //end keyCode
	});

	$("input#article_code").keyup(function(e){
		e.stopPropagation();
		if (e.keyCode==13 || e.which==13){
			e.preventDefault();
			var txt = $("input#article_code").val();
			if(txt==""){return false;}
			getArtDetails();
			$('#inv_qty').focus();
			$('#inv_qty').select();
			return false;
		} //end keyCode
	});

	$("#search_filter").focus();
	$("#search_filter").select();
	$("input#search_filter").keyup(function(e){
	var value = $(this).val().toLowerCase();
	$("#tblContentBody tr").filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	});
	});
	
	$("input#inv_qty").keypress(function(e){
		e.stopPropagation();
		if (e.keyCode==13 || e.which==13){
			e.preventDefault();
			saveArticle();
			$('#article_code').focus();
			$('#article_code').select();
	} //end keyCode
		//return false;
	});
	

$('.nav-able td').click(function () {
	currCell = $(this);

	var col = $(this).parent().children().index($(this)) + 1;
	var row = $(this).parent().parent().children().index($(this).parent()) + 1;
	//alert('Row: ' + row + ', Column: ' + col + ', Value: ' + currCell.html());

	//   edit();
});

	$('table.nav-able').keydown(function (e) {
	//console.log(e.which);
		currCell = navigateTableCells(e, currCell)
	});

	// User can cancel edit by pressing escape
	$('#edit').keydown(function (e) {
	if (e.which == 27) {
	// close model form
	}
	});
	
	$('.nav-able td').keydown(function (e) {
	if (e.which == 13) {
	// close model form
	alert('entered');
	}
	});
	
	
});