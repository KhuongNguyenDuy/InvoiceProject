$(document).ready(function(){
	$('#tab_logic tbody').on('keyup change',function(){
		calc();
	});
	$('#tax').on('keyup change',function(){
		calc_total();
	});
	
    $('#soluong').on('keyup change',function(){
		alert("fadsf");
	});
    $('#tax').on('keyup change',function(){
		    alert("fadsf");
	    });
	//get phone, name customer
	$('#khachang').change(function(){
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
	$('#project').change(function(){
		var projectid = $(this).val();                            
		$.ajax({
			type:'get',
			url:'/ajax-request-item',
			data:{id:projectid},
			success:function(data){
				
				$('#test').html(data);              
			}
		});
	});

});

   

function calc()
{
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

function calc_total()
{
	total=0;
	$('.total').each(function() {
        total += parseInt($(this).val());
    });
	$('#sub_total').val(total.toFixed(2));
	tax_sum=total/100*$('#tax').val();
	$('#tax_amount').val(tax_sum.toFixed(2));
	$('#total_amount').val((tax_sum+total).toFixed(2));
}
