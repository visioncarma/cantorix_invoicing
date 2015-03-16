<?php 
    $this->CurrencySymbol->getAllCurrencies();
	$homeLink = $this->Breadcrumb->getLink('Home');
	$invoiceLink = $this->Breadcrumb->getLink('Payments');
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
			<li class="active">Add New Payment</li>
		</ul>
</div>
<div class="page-content">
	<div class="page-header">
		<h1 >Add New Payment <span class="header-span"> <i class="icon-double-angle-right"></i>  </span></h1>
	</div>
	<!-- /.page-header -->
	
	<?php echo $this -> Form -> create('addNewPayment', array('id'=>'addNewPayment','class' => 'form-horizontal formdetails', 'role' => 'form')); ?>
		<div class="row marginleftrightzero">
			<div class="col-lg-8 paddingleftrightzero">
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-4 control-label marginleftrightzero paddingleftrightzero">Invoice No</label>
						<div class="col-sm-2 marginleftrightzero paddingleftrightzero">							
						<?php echo $this -> Form -> input('invoice_number', array('id' => 'invNumber', 'div' => false, 'label' => false, 'type' => 'text', 'class' => 'form-control','value'=>$invoiceNumber));
						$this -> Js -> get('#invNumber') -> event('change', $this -> Js -> request(array('controller' => 'acr_invoice_payment_details', 'action' => 'addNewPayment'), array('update' => '#pageContent', 'async' => true, 'dataExpression' => true, 'method' => 'put', 'data' => $this -> Js -> serializeForm(array('isForm' => true, 'inline' => true)))));
						?>						
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group filed-left drop-down marginleftrightzero form-dropdown relative">
						<label  class="col-sm-4 control-label marginleftrightzero paddingleftrightzero">Payment Method</label>
						<div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 col-lg-3 nopadding marginleftrightzero labelerror">							
							<?php echo $this->Form->input('payment_method',array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control selectpicker selectitem','options'=>array(''=>'Select',$paymentMethods)));?>
						</div>
					</div>
				</div>
				
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-4 control-label marginleftrightzero paddingleftrightzero">Reciept Amount</label>
						<div class="col-sm-3 marginleftrightzero paddingleftrightzero">
							<div class="col-sm-3 marginleftrightzero paddingleftrightzero">								
								<?php echo $this->Form->input('invoice_currency',array('div'=>FALSE,'label'=>FALSE, 'id'=>'addPaymentInvoiceCurrency', 'value'=>"$invoicedCurrency", 'class'=>'form-control text-center bold','disabled'=>"disabled"));?>  
							</div>
							<div class="col-sm-9 marginleftrightzero paddingleftrightzero">								
								<?php $recieptAmount = money_format('%!(.2n',$recieptAmount); ?>
								<?php echo $this->Form->input('paid_amount',array('div'=>FALSE,'label'=>FALSE,'value'=>"$recieptAmount",'data-ref'=>"$recieptAmount", 'class'=>'form-control realfield','placeholder'=>''));?>  
							</div>
						</div>
					</div>
				</div>
				<?php
				if($errorFlag){
					echo $this->Form->hidden('creditAmount',array('id'=>'', 'value'=>'0'));
				}else {
					echo $this->Form->hidden('creditAmount',array('id'=>'creditAmount', 'value'=>''));
				} ?>				 
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-4 control-label marginleftrightzero paddingleftrightzero">Outstanding Balance</label>
						<div class="col-sm-3 marginleftrightzero paddingleftrightzero">	
							<?php $balance_due = money_format('%!(.2n',$balance_due); ?>						
							<?php echo $this->Form->input('balance_due',array('div'=>FALSE,'label'=>FALSE, 'value'=>"$balance_due", 'data-ref'=>"$balance_due",'class'=>'form-control dummyfield', 'disabled'=>'disabled' ,'placeholder'=>''));?>  
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-4 control-label marginleftrightzero paddingleftrightzero">Payment Date</label>
						<div class="col-sm-2 marginleftrightzero paddingleftrightzero">
							<div class="input-group custom-datepicker">	
								<?php $todaysDate = date($date_format);?>							
								<?php echo $this->Form->input('payment_date',array('div' =>false , 'label'=>false, 'id'=>"", 'class'=>"form-control date-picker", 'data-date-format'=>str_ireplace('y','yyyy',$date_format), 'readonly'=>'readonly','style'=>'cursor:default','default'=>$todaysDate)); ?>
								<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
							</div>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-4 control-label marginleftrightzero paddingleftrightzero">Payment reference #</label>
						<div class="col-sm-3 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('reference_no',array('div'=>FALSE,'label'=>FALSE,'value'=>"", 'class'=>'form-control','placeholder'=>''));?>  
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-4 control-label marginleftrightzero paddingleftrightzero">Notes</label>
						<div class="col-sm-8 marginleftrightzero paddingleftrightzero">							
							<?php echo $this->Form->textarea('notes',array('div'=>FALSE,'label'=>FALSE,'class'=>'termsandconditions height-auto textareawidth60'));?>  
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group filed-left drop-down marginleftrightzero form-dropdown">
						<label  class="col-sm-4 control-label marginleftrightzero paddingleftrightzero">Payment Recieved Confirmation</label>
						<div class="col-sm-3 marginleftrightzero paddingleftrightzero">
							<label>								
								<?php echo $this->Form->input('send_payment_note',array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace'));?>  
								<span class="lbl"></span> </label>
							<label class="maillabel">Yes</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row marginleftrightzero paddingbottom20">
			<div class="clearfix margintopzero paddingtopzero no-padding-left no-padding-right">
				<div class="col-md-offset-3">
					<?php echo $this->Form->hidden('acr_client_id',array('value'=>$acr_client_id));?>
					<?php echo $this->Form->hidden('acr_client_invoice_id',array('value'=>$acr_client_invoice_id));?>
					<?php echo $this->Form->hidden('invoiceStatus',array('value'=>$invoiceStatus));?>
					<?php echo $this->Form->hidden('client_name',array('value'=>$client_name));?>
					
					<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i> Submit", array('div'=>false,'class'=>'btn btn-info onsubmit','url' => array('controller'=>'AcrInvoicePaymentDetails','action' => 'addNewPayment'),'escape'=>false));?>
					<?php echo $this->Form->button('<i class="icon-undo bigger-110"></i> Reset', array('div'=>false,'class'=>'btn btn-inverse','type'=>'reset','escape'=>false));?>
					
				</div>
			</div>
		</div>
	<?php echo $this -> Form -> end(); ?>
	<div class="row marginleftrightzero paddingbottom10 borderbottom"></div>
	<div class="row marginleftrightzero  paddingtop15">
		<div class="row marginleftrightzero additionalinfo">
			<h5 class="no-border-bottom">Payments History</h5>
		</div>
	</div>
	<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
		<thead>
			<tr>
				<th class="width200">Invoice No</th>
				<th class="width200">Date</th>
				<th class="width200">Payment Method</th>
				<th class="width200">Payment Reference</th>
				<th class="width200">Payment Status</th>
				<th class="width150">Payment Amount</th>
			</tr>
		</thead>
		<tbody>				
			<?php foreach($payment_history as $k=>$val){ ?>		
			<tr>
				<td><span class="on-load"><?php echo $val['AcrClientInvoice']['invoice_number']; ?></span></td>
				<td><span class="on-load">
					<?php $pay_date = strtotime($val['AcrInvoicePaymentDetail']['payment_date']);$payment_date = date($date_format,$pay_date);?>
					<?php echo $payment_date; ?></span></td>
				<td><span class="on-load"><?php echo $val['CpnPaymentMethod']['payment_option_name']; ?></span></td>
				<td><span class="on-load"><?php echo $val['AcrInvoicePaymentDetail']['reference_no']; ?></span></td>
				<td><span class="on-load statusconverttoinvoice">Completed</span></td>
				<td><span class="on-load ">
					<?php $options = array('places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');?> 
					<?php echo $this->Number->currency($val['AcrInvoicePaymentDetail']['paid_amount'],$val['AcrClientInvoice']['invoice_currency_code']);?>
				</span></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
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

<!-- inline scripts related to this page 
	add_new_payment.js
	-->
<script type="text/javascript">
	$(document).ready(function() {
		
		if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
    	}  
		
		
		$('.date-picker').datepicker({
			autoclose : true
		}).next().on(ace.click_event, function() {
			$(this).prev().focus();
		});
		
		
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
	
	// popup
    	$('.okpopup').click(function(){
    		$('#addNewPayment').submit();
    	})
    	$('.onsubmit').click(function(e){ 
    		
    		$("#addNewPayment").validate({
			ignore: [],
			rules: {
				'data[addNewPayment][invoice_number]': "required",
				'data[addNewPayment][payment_method]': "required",
				'data[addNewPayment][paid_amount]': {
					required: true,					
					morethanzeroAllowed: true,
				    number: true								
				}						
			},
			messages: {
				'data[addNewPayment][invoice_number]': "Please Enter the Invoice No.",
				'data[addNewPayment][payment_method]': "Please Select Payment Method",
				'data[addNewPayment][paid_amount]': {
					required: "Please Enter Reciept Amount",
					morethanzeroAllowed:"Value should be greater than 0"								
				}				
			}
		});
		
    	if($("#addNewPayment").valid()){	   		
    		if(parseInt($('#creditAmount').val())){
    			  $('.clientpopamount').text($(" "+'#addPaymentInvoiceCurrency').val()+" "+$('#creditAmount').val());     			 
    		      e.preventDefault();
    		      $('#submitpopup').modal('show');
    		}  
    	} 
    	 		
    	});	
    	
    	
		// custom validation rule	
		 $.validator.addMethod("morethanzeroAllowed", 
	           function(value, element) {
	                  	if(value <=0) {
	                  		return false;
	                  	} else return true;                               
	           }, 
	 			"less than or equal to 0 not allowed"
	     );
	
	});
	
</script>	

<?php echo $this -> Js -> writeBuffer(); ?>