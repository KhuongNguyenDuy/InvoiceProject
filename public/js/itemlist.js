$(document).ready(function(){


	//get phone, name customer
	$('#khachhang').change(function(){
        var idc = $(this).val();                            
        $.ajax({
                type:'get',
                 url:'/ajax-request',
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
					var price = $(this).find('.price').val();
					$(this).find('.total').val(qty*price);
					calc_total();
				}
			});
		});
	});
	/**
	 * function get value amount when add to cart
	 */
	function calc(){
		$('#tab_logic tbody tr').each(function(i, element) {
			var html = $(this).html();
			if(html!='')
			{
				var qty = $(this).find('.qty').val();
				var price = $(this).find('.price').val();
				$(this).find('.total').val(qty*price);
				
				calc_total();
			}
		});
	}
	/**
	 * function get total invoice
	 */
	function calc_total(){
		total=0;
		$('.total').each(function() {
			total += parseInt($(this).val());
		});
		 $('#sub_total').val(total);
		 tax_sum=total/100*$('#tax').val();
		 $('#tax_amount').val(tax_sum);
		 $('#total_amount').val((tax_sum+total));
	}

});

