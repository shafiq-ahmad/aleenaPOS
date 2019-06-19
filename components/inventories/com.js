
function close_window() {
	if (confirm("Close Window?")) {
		close();
	}
}
	
function clearArtForm(){
	$("#article_code").val('');
	$('#ref_code').val('');
	$('#title').val('');
	$('#packing').val('');
	$('#cost_price').val('');
	$('#sale_price').val('');
	$('#stock').val('');
	$('#qty').val('');
	$('#loc').val('');
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
		$('#title').val(obj.title);
		$('#packing').val(obj.packing);
		$('#cost_price').val(obj.cost_price);
		$('#sale_price').val(obj.sale_price);
		$('#stock').val(obj.qty);
		$('#qty').val('');
		
	});

}

function saveArticle(){
	var inv_id = $('input#id').val();
	//if(!inv_id){return false;}
	$.post('?com=inventories&view=ajax&task=html&tmpl=com&part=saveInventoryArt&id='+inv_id, $('#frm_inv_art').serialize(), function(result){
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
		//console.log(result);
	});
	$("#article_code").focus();
	$("#article_code").select();
}


	
$(document).ready(function(){

	$("#article_code").keypress(function(e){
		e.stopPropagation();
		if (e.keyCode==13 || e.which==13){
			e.preventDefault();
			var txt = $("#article_code").val();
			if(txt==""){return false;}
			getArtDetails();
			$('#qty').focus();
			$('#qty').select();
			return false;
		}
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
		}
	});

	$("#search_filter").focus();
	$("#search_filter").select();
	$("#search_filter").keyup(function(e){
	var value = $(this).val().toLowerCase();
	$("#tblContentBody tr").filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	});
	});
	
	$("#qty").keypress(function(e){
		e.stopPropagation();
		if (e.keyCode==13 || e.which==13){
			e.preventDefault();
			saveArticle();
			clearArtForm();
			$('#article_code').focus();
			$('#article_code').select();
	}
		//return false;
	});
	
	
});