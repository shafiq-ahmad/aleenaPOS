
function cals_reportItemsTotal(){
	var subTotal =0;
	var subTotalMargin =0;
	var discount_amount =0;
	var cash =0;
	var credit =0;
	var change_return =0;
	var account_value =0;
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
			if($(element).hasClass('account_value')==true){
				account_value += eval($(this).text());
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
	$('#accounts_total').text(account_value);

}

$(document).ready(function(){
	
	$("input#search_filter").keyup(function(e){
		var value = $(this).val().toLowerCase();
		$("#tblContentBody tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
		//culculate values
		cals_reportItemsTotal();
	});
	
	

	$('#data-table').DataTable({
		"footerCallback": function(row, data, start, end, display ) {
		var api = this.api(), data;

		// Remove the formatting to get integer data for summation
		var intVal = function (i) {
			return typeof i === 'string' ?
			i.replace(/[\$,]/g, '')*1 :
			typeof i === 'number' ?
			i : 0;
		};

		// Total over all pages
		total = api
		.column(5)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);

		// Total over this page
		pageTotal = api
		.column(5, { page: 'current'} )
		.data()
		.reduce(function (a, b){
			return intVal(a) + intVal(b);
		},0);

		// Update footer
		$( api.column(5).footer()).html(
			''+pageTotal +' ( '+ total +' total)'
		);
		}
	} );

	
});


