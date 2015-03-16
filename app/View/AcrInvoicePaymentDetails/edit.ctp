<?php 
    $this->CurrencySymbol->getAllCurrencies();
	$homeLink = $this->Breadcrumb->getLink('Home');
	$invoiceLink = $this->Breadcrumb->getLink('Invoices');
?>
<?php 
	$dbFormat = array("d", "M", "Y");
	$scriptFormat   = array("dd", "mm", "yyyy");
?>
<?php echo $this->Session->flash();?>

<div class="breadcrumbs" id="breadcrumbs">
		<script type="text/javascript">
			try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
		</script>

		<ul class="breadcrumb">
			<li>
				<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
			</li>
            <li>								
				<?php echo $this->Html->link('Invoices',"$invoiceLink");?>
			</li>
			<li class="active">Edit Payment</li>
		</ul>
</div>
<div class="page-content">	
	
	<div class="page-header">
		<h1><?php echo __('Edit Payment Details');?> <span class="header-span"> <i class="icon-double-angle-right"></i> <?php echo __($paymentData['AcrClientInvoice']['invoice_number']);?> </span></h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('action'=>'index', $filterAction, $filterValue, $filterValue1, $filterValue2, $fromDate, $toDate, 'page:'.$page),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
		</div>
	</div>	
	
	<!-- /.page-header -->
	
	<?php echo $this -> Form -> create('editPayment', array('id'=>'editPayment','class' => 'form-horizontal formdetails', 'role' => 'form')); ?>
		<div class="row marginleftrightzero">
			<div class="col-lg-8 paddingleftrightzero">
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-4 control-label marginleftrightzero paddingleftrightzero col-xs-5">Invoice No</label>
						<div class="col-sm-8 marginleftrightzero paddingleftrightzero col-xs-5">
							<label  class=" control-label marginleftrightzero paddingleftrightzero"><?php echo $paymentData['AcrClientInvoice']['invoice_number'];?></label>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero relative">
						<label  class="col-xs-12 col-sm-4 col-lg-4  control-label marginleftrightzero paddingleftrightzero">Payment Method</label>
						<div class="col-xs-12 col-sm-3 col-lg-3  marginleftrightzero paddingleftrightzero labelerror choosen_width">							
							<?php echo $this->Form->input('payment_method',array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control invdrop selectitem','data-placeholder'=>"Select",'options'=>array(''=>'',$paymentMethods),'default'=>$paymentData['CpnPaymentMethod']['id']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-4 control-label marginleftrightzero paddingleftrightzero">Reciept Amount</label>
						<div class="col-sm-3 marginleftrightzero paddingleftrightzero">
							<div class="col-sm-3 marginleftrightzero paddingleftrightzero col-xs-3">								
								<?php echo $this->Form->input('invoice_currency',array('div'=>FALSE,'label'=>FALSE, 'id'=>'editPaymentInvoiceCurrency','value'=>$paymentData['AcrClientInvoice']['invoice_currency_code'], 'class'=>'form-control text-center bold', 'readonly'=>"readonly"));?>  
							</div>
							<div class="col-sm-9 marginleftrightzero paddingleftrightzero col-xs-9">								
								<?php $recieptAmount = money_format('%!(.2n',$paymentData['AcrInvoicePaymentDetail']['paid_amount']); ?>
								<?php echo $this->Form->input('paid_amount',array('div'=>FALSE,'label'=>FALSE,'value'=>"$recieptAmount", 'data-ref'=>"$recieptAmount", 'class'=>'form-control realfield','placeholder'=>''));?>  
							</div>
						</div>
					</div>
				</div>			
				<?php echo $this->Form->hidden('creditAmount',array('id'=>'creditAmount', 'value'=>''));?>				
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-4 control-label marginleftrightzero paddingleftrightzero">Outstanding Balance</label>
						<div class="col-sm-3 marginleftrightzero paddingleftrightzero">
							<div class="col-sm-3 marginleftrightzero paddingleftrightzero col-xs-3">								
								<?php echo $this->Form->input('invoice_currency_dsply',array('div'=>FALSE,'label'=>FALSE, 'id'=>'editPaymentInvoiceCurrencyDsply','value'=>$paymentData['AcrClientInvoice']['invoice_currency_code'], 'class'=>'form-control text-center bold','disabled'=>"disabled"));?>  
							</div>
							<div class="col-sm-9 marginleftrightzero paddingleftrightzero col-xs-9">								
								<?php $balance_due = money_format('%!(.2n',$balance_due); ?>						
								<?php echo $this->Form->input('balance_due',array('div'=>FALSE,'label'=>FALSE, 'value'=>"$balance_due", 'data-ref'=>"$balance_due", 'class'=>'form-control dummyfield','readonly'=>"readonly" ,'placeholder'=>''));?>  
						   </div>
						</div>
					</div>
				</div>				
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-4 control-label marginleftrightzero paddingleftrightzero">Payment Date</label>
						<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12 marginleftrightzero paddingleftrightzero">
							<div class="input-group custom-datepicker ipadwidth">														
								<?php
								$paymntdate = date($date_format, strtotime($paymentData['AcrInvoicePaymentDetail']['payment_date']));								
								echo $this->Form->input('payment_date',array('div' => false , 'label'=>false, 'id'=>"", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$date_format),'readonly'=>'readonly','style'=>'cursor:default','default'=>$paymntdate)); ?>
								<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
							</div>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-4 control-label marginleftrightzero paddingleftrightzero">Payment reference #</label>
						<div class="col-sm-3 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('reference_no',array('div'=>FALSE,'label'=>FALSE,'value'=>$paymentData['AcrInvoicePaymentDetail']['reference_no'], 'class'=>'form-control','placeholder'=>''));?>  
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-4 control-label marginleftrightzero paddingleftrightzero">Notes</label>
						<div class="col-sm-8 marginleftrightzero paddingleftrightzero">							
							<?php echo $this->Form->textarea('notes',array('div'=>FALSE,'label'=>FALSE, 'value'=>$paymentData['AcrInvoicePaymentDetail']['notes'] ,'class'=>'termsandconditions height-auto textareawidth60'));?>  
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group filed-left drop-down marginleftrightzero form-dropdown">
						<label  class="col-sm-4 control-label marginleftrightzero paddingleftrightzero">Payment Recieved Confirmation</label>
						<div class="col-sm-3 marginleftrightzero paddingleftrightzero">
							<label>								
							<?php 
								if($paymentData['AcrInvoicePaymentDetail']['send_payment_note'] == 'Y') {
									echo $this->Form->input('send_payment_note',array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace','checked'=>'checked'));
								} else {
									echo $this->Form->input('send_payment_note',array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace'));
								}
							?>  
								<span class="lbl"></span> </label>
							<label class="maillabel">Yes</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row marginleftrightzero paddingbottom20">
			<div class="clearfix margintopzero paddingtopzero no-padding-left no-padding-right">
				<div class="col-md-offset-3 footerbutton">
					<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i> Submit", array('div'=>false,'class'=>'btn btn-info onsubmit button_mobile','url' => array('controller'=>'AcrInvoicePaymentDetails','action' => 'edit'),'escape'=>false));?>
					<?php echo $this->Html->link('<i class="icon-remove bigger-110"></i> Cancel',array('action'=>'index',$filterAction, $filterValue, $filterValue1, $filterValue2, $fromDate, $toDate, 'page:'.$page),array('class'=>'btn btn-inverse button_mobile','escape'=>FALSE));?>
				</div>
			</div>
		</div>
	<?php echo $this -> Form -> end(); ?>
	<div class="row marginleftrightzero paddingbottom10 borderbottom"></div>

</div>
<!-- /.page-content -->

<!--Popup add  -->
<div id ="submitpopup" class="modal fade first"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modelinsidesubscriber">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button> 
      
      <div class="form-horizontal popup">
      <div class="modal-body">
         <div class="model-body-inner-content">  
         	<div>
			 <h3 class="bolder red 22pfont center"> Generate Credit Note </h3>
			 <div class="center 14pfont paddingbottom">
			 	Would you like to create the credit note of <sapn class="clientpopamount" style="color:#dd5a43"></sapn> </span> as over payment from this customer?	 
			 </div>
			 <div class="space-12"></div>
			 
			 <div class="paddingleftrightzero padingleftneed buttoncenter">
					 	<button class="btn btn-sm paddingbtn-sm-ok btn-danger delete on-load okpopup">
							Yes
						</button>
			 		&nbsp;&nbsp;&nbsp;
			  			<button class="btn btn-sm btn-danger delete on-load" data-dismiss="modal">
							No
		   				</button>
			  
			</div>
			 <div class="space-6"></div>
			<p>
				<span class="bolder">  </span> 
			</p>
            </div>			
          </div>
      </div>     
      </div>
	  </div>
    </div>
  </div> 
</div>
<!--end of pop--> 



<!-- inline scripts related to this page -->

<script type="text/javascript">	
	
	$(document).ready(function() {	
		
		/* choosen select*/
			var config = {
				  
				  '.invdrop' : {search_contains:true}
				}
				for (var selector in config) {
				  $(selector).chosen(config[selector]);
			}
		/* choosen select*/
		
		
		$('body').on('change','.selectitem',function(){
	        var thisvalue = $('.selectitem option:selected').text();
	        if (thisvalue=="Select")
			   {
			   	 $(this).next('.error').show();
			   }
			   else{
			   	  $(this).next('.error').hide();
			   }
        });	
         	
		if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
    	} 
    	
    	// popup
    	$('.okpopup').click(function(){
    		$('#editPayment').submit();
    	})
	    	$('.onsubmit').click(function(e){
	    		$("#editPayment").validate({
				ignore: [],
				rules: {
					'data[editPayment][payment_method]': "required",
					'data[editPayment][paid_amount]': {
						required: true,
						morethanzeroAllowed: true,
						number: true								
					}								
				},
				messages: {
					'data[editPayment][payment_method]': "Please select payment method.",
					'data[editPayment][paid_amount]': {
						required: "Please Enter Reciept Amount",
						morethanzeroAllowed:"Value should be greater than 0"								
					},
				}
			});
			
    	if($("#editPayment").valid()){
    		  	if(parseInt($('#creditAmount').val())){
    			  $('.clientpopamount').text($(" "+'#editPaymentInvoiceCurrency').val()+" "+$('#creditAmount').val());     			 
    		      e.preventDefault();
    		      $('#submitpopup').modal('show');
    		    }  
    		 }
    	});	 	
		//
    	
		// calculate onkeyup outstanding			    
			
			$('body').on('keyup','.realfield',function(){
				
				var paidamount   = parseFloat($('.realfield').data("ref"));
				var actualamount = parseFloat($('.dummyfield').data("ref"));
				
				var recieptamount = parseFloat($(this).val()); 
				if(isNaN(recieptamount)){recieptamount = 0;};	
				if(recieptamount < paidamount ) {						
					var outstanding   = actualamount + (paidamount - recieptamount);
					var outstanding   = parseFloat(outstanding.toFixed(2));
					$('.dummyfield').val(outstanding);
					$('#creditAmount').val(0);
				} else if (recieptamount == paidamount) {					
					var outstanding   = actualamount;
					var outstanding   = parseFloat(outstanding.toFixed(2))
					$('.dummyfield').val(outstanding);
					$('#creditAmount').val(0);
				} else if (recieptamount > paidamount) {					
					var outstandings = actualamount - (recieptamount - paidamount);
					if(outstandings >= 0){						
						var outstanding = outstandings;
						$('#creditAmount').val(0);
					}else{						
						var outstanding = 0;
						var creditamount   =  -(outstandings);
						var creditamount   =  parseFloat(creditamount.toFixed(2));					
						if(creditamount > 0){
							$('.amounttext span').text(" "+creditamount);
							$('#creditAmount').val(creditamount);
						}
					}
					var outstanding   = parseFloat(outstanding.toFixed(2))					
					$('.dummyfield').val(outstanding);
				}
			})		
	
		
		// custom validation rule	
		 $.validator.addMethod("morethanzeroAllowed", 
	           function(value, element) {
	                  	if(value <=0) {
	                  		return false;
	                  	} else return true;                               
	           }, 
	 			"less than or equal to 0 not allowed"
	     );
					
		$('.date-picker').datepicker({
			autoclose : true
		}).next().on(ace.click_event, function() {
			$(this).prev().focus();
		});
	
	});
	 
</script>
