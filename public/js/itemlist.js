$(document).ready(function(){


	//get phone, name customer
	$('#khachhang').change(function(){
        var idc = $(this).val();                            
        $.ajax({
                type:'get',
                 url:'/get-customer',
                data:{id:idc},
                success:function(data){
                    if(data.success == true){
                        $('#sdt').val(data.info[0].phone);
                        $('#diachi').val(data.info[0].adress);
                        $('#fax').val(data.info[0].fax);
                     }                                                                                
                    else{
                        alert("that bai");
                     }
                                        
                }
            });
    });
	//get item when change project
	// $('#project').change(function(){
	// 	var projectid = $(this).val();                            
	// 	$.ajax({
	// 		type:'get',
	// 		url:'/ajax-request-item',
	// 		data:{id:projectid},
	// 		success:function(data){
				
	// 			$('#test').html(data);              
	// 		}
	// 	});
	// });

	/**
	 * change project -> load item of project
	 */
	$('#project').change(function(){
		var projectid = $(this).val();                           
		location.href = '/get-item'+projectid;
	});
	/**
	 * js keyup change add to cart
	 */
	$(document).ready(function(){
		$('#tab_logic tbody').on('keyup change',function(){
			$('#tab_logic tbody tr').each(function(i, element) {
				var html = $(this).html();
				if(html!=''){
					var qty = $(this).find('.qty').val();
					var price = parseInt($(this).find('.price').val().replace(new RegExp(',', 'g'),""));
					var total_item = qty*price;
					$(this).find('.total').val(number_format(total_item,0,"",","));
					calc_total();
				}
			});
		});
	});
	/**
	 * function get total invoice
	 */
	function calc_total(){
		total=0;
		$('.total').each(function() {
			if($(this).val() == 0 || $(this).val() == ""){
			}else{
				total += parseInt($(this).val().replace(new RegExp(',', 'g'),""));
			}
		});
		$('#sub_total').val(number_format(total,0,"",","));
		tax_sum=total/100*$('#tax').val();
		$('#tax_amount').val(number_format(Math.round(tax_sum),0,"",","));
		$('#total_amount').val(number_format(Math.round(tax_sum+total),0,"",","));
	}
	//function number format 123456->123,456
	function number_format(number, decimals, dec_point, thousands_point) {
		if (number == null || !isFinite(number)) {
			throw new TypeError("number is not valid");
		}
	
		if (!decimals) {
			var len = number.toString().split('.').length;
			decimals = len > 1 ? len : 0;
		}
	
		if (!dec_point) {
			dec_point = '.';
		}
	
		if (!thousands_point) {
			thousands_point = ',';
		}
	
		number = parseFloat(number).toFixed(decimals);
	
		number = number.replace(".", dec_point);
	
		var splitNum = number.split(dec_point);
		splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
		number = splitNum.join(dec_point);
	
		return number;
	}

});

