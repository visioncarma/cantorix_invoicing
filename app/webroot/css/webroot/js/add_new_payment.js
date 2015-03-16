
	$(document).ready(function() {
        	  
		// calculate onkeyup credit note and outstanding
			
			$('body').on('keyup','.realfield',function(){
				
				var paidamount   = parseFloat($('.realfield').data("ref"));
				var actualamount = parseFloat($('.dummyfield').data("ref"));
								
				if($('#invNumber').val()){
						
					var recieptamount = parseFloat($(this).val());
					if(isNaN(recieptamount)){recieptamount = 0;};	
					if(recieptamount < paidamount ) {
						// alert("s1");										
						var outstanding   = actualamount - recieptamount;
						var outstanding   = parseFloat(outstanding.toFixed(2));
						$('.dummyfield').val(outstanding);						
						$('#creditAmount').val(0);
						
					} else if (recieptamount >= paidamount) {
						// alert("s2");
						var outstanding = 0;
						var outstanding   = parseFloat(outstanding.toFixed(2));					
						
						var creditamount   =  recieptamount - paidamount;
						var creditamount   =  parseFloat(creditamount.toFixed(2));					
						if(creditamount > 0){
							$('.amounttext').text("("+creditamount+")");
							$('#creditAmount').val(creditamount);								
						}
						else{
							
						}
						$('.dummyfield').val(outstanding);					
					}				
				}				
			});	     
	});

