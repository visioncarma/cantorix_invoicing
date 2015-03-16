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
			<li class="active">Capture Invoice Payment</li>
		</ul>
</div>
<div class="page-content">
	<div class="page-header">
		<h1 >Capture Invoice Payment <span class="header-span"> <i class="icon-double-angle-right"></i> <?php echo $invoiceNumber; ?> </span></h1>
	</div>
	<!-- /.page-header -->
	
	<?php echo $this -> Form -> create('capturePayment', array('id'=>'capturePayment', 'class' => 'form-horizontal formdetails', 'role' => 'form')); ?>
		<div class="row marginleftrightzero">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftrightzero">
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-lg-3 col-md-3 col-sm-4 col-xs-4 control-label marginleftrightzero paddingleftrightzero">Invoice No</label>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-8 marginleftrightzero paddingleftrightzero">
							<label  class="control-label marginleftrightzero paddingleftrightzero"><?php echo $invoiceNumber; ?></label>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero relative">
						<label  class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Payment Method</label>
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 marginleftrightzero paddingleftrightzero  labelerror">							
							<?php echo $this->Form->input('payment_method',array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control selectpicker selectitem','options'=>array(''=>'Select',$paymentMethods)));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Receipt Amount</label>
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 marginleftrightzero paddingleftrightzero">
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 marginleftrightzero paddingleftrightzero">								
								<?php echo $this->Form->input('invoice_currency',array('div'=>FALSE,'label'=>FALSE, 'id'=>'capturePaymentInvoiceCurrency', 'value'=>"$invoicedCurrency", 'class'=>'form-control text-center bold','readonly'=>"readonly"));?>  
							</div>
							<div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 marginleftrightzero paddingleftrightzero">								
								<?php $recieptAmount = money_format('%!(.2n',$recieptAmount); ?>
								<?php echo $this->Form->hidden('payableAmount',array('value'=>$recieptAmount));?>		
								<?php echo $this->Form->input('paid_amount',array('div'=>FALSE,'label'=>FALSE,'value'=>"$recieptAmount", 'data-ref'=>"$recieptAmount", 'class'=>'form-control realfield text-right','placeholder'=>''));?>  
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
						<label  class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Outstanding Balance</label>
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 marginleftrightzero paddingleftrightzero">
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 marginleftrightzero paddingleftrightzero">								
								<?php echo $this->Form->input('invoice_currency_dsply',array('div'=>FALSE,'label'=>FALSE, 'id'=>'capturePaymentInvoiceCurrencyDsply', 'value'=>"$invoicedCurrency", 'class'=>'form-control text-center bold','disabled'=>"disabled"));?>  
							</div>
							<div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 marginleftrightzero paddingleftrightzero">								
								<?php $balance_due = money_format('%!(.2n',$balance_due); ?>	
										
								<?php echo $this->Form->input('balance_due',array('div'=>FALSE,'label'=>FALSE, 'value'=>"$balance_due", 'data-ref'=>"$balance_due", 'class'=>'form-control dummyfield text-right','readonly'=>"readonly" ,'placeholder'=>''));?> 
							</div>
						</div>
					</div>
				</div>				
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Payment Date</label>
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 marginleftrightzero paddingleftrightzero">
							<div class="input-group custom-datepicker fullwidth">	
								<?php $todaysDate = date($date_format);?>							
								<?php echo $this->Form->input('payment_date',array('label'=>false,'div'=>false, 'id'=>"", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$date_format), 'readonly'=>'readonly','style'=>'cursor:default','default'=>$todaysDate)); ?>
								<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
							</div>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Payment reference #</label>
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('reference_no',array('div'=>FALSE,'label'=>FALSE,'value'=>"", 'class'=>'form-control','placeholder'=>''));?>  
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Notes</label>
						<div class="col-lg-4 col-md-3 col-sm-4 col-xs-12 marginleftrightzero paddingleftrightzero">							
							<?php echo $this->Form->textarea('notes',array('div'=>FALSE,'label'=>FALSE,'class'=>'height-auto form-control'));?>  
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group filed-left drop-down marginleftrightzero form-dropdown">
						<label  class="col-lg-3 col-md-3 col-sm-4 col-xs-10 control-label marginleftrightzero paddingleftrightzero">Payment Received Confirmation</label>
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-2 marginleftrightzero paddingleftrightzero paymentlabel">
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
					<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i> Submit", array('div'=>false,'class'=>'btn btn-info onsubmit','url' => array('controller'=>'AcrInvoicePaymentDetails','action' => 'add'),'escape'=>false));?>
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
	
	
	<div class="row ">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom">
				<?php foreach($payment_history as $k=>$val){ ?>	
				<table class="table table-striped roles-table">
					<tr>
						<td class="title_role bold rowwidth120px textleft">Invoice No</td>
						<td class="title bold rowwidth120px textleft">Date</td>
						<td class="title bold rowwidth120px textleft">Payment Method</td>
						<td class="title bold rowwidth120px textleft">Payment Reference</td>
						<td class="title bold rowwidth120px textleft">Payment Status</td>
						<td class="title bold rowwidth120px textright">Payment Amount</td>
					</tr>
					<tr class="even-strip">
						<td class="title_role rowwidth120px textleft"><?php echo $val['AcrClientInvoice']['invoice_number']; ?></td>
						<td class="title rowwidth120px textleft"><?php $pay_date = strtotime($val['AcrInvoicePaymentDetail']['payment_date']);$payment_date = date($date_format,$pay_date);?>
					    <?php echo $payment_date; ?></td>
						<td class="title rowwidth120px textleft"><?php echo $val['CpnPaymentMethod']['payment_option_name']; ?></td>
						<td class="title rowwidth120px textleft"><?php echo $val['AcrInvoicePaymentDetail']['reference_no']; ?></td>
						<td class="title rowwidth120px textleft statusconverttoinvoice">Completed</td>
						<td class="title rowwidth120px textright"><?php $options = array('places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');?> 
					    <?php echo $this->Number->currency($val['AcrInvoicePaymentDetail']['paid_amount'],$val['AcrClientInvoice']['invoice_currency_code']);?></td>
					</tr>					
				</table>
				<?php } ?>							
			</div>
		</div>
	</div>
	
	
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
		//table mobile view script//
		if ($('.roles-table-wrapper-inner').length) {
			var winsize = 1;
			if ($('.roles-table').length) {
				var i = 1;
				$('.roles-table').each(function() {
					$(this).addClass("role-table-" + i);
					i++;
				});
			}
			$('.roles-table').not('.role-table-1').find('tr:first').addClass("hidden-row");

			$changeTableView = function() {
				$(".table").each(function() {
					var $this = $(this);
					var newrows = [];
					$this.find("tr").each(function() {
						var i = 0;
						$(this).find("td").each(function() {
							i++;
							if (newrows[i] === undefined) {
								newrows[i] = $("<tr></tr>");
							}
							newrows[i].append($(this));
						});
					});
					$this.find("tr").remove();
					$.each(newrows, function() {
						$this.append(this);
					});
				});

			};

			if ($(window).width() < 992) {
				$changeTableView();
				winsize = 0;
			}

			$(window).on("resize", function() {

				if (Math.floor($(window).width() / 992) != winsize) {
					$changeTableView();
					winsize = Math.floor($(window).width() / 992);
				}
				if ($(window).width() > 992) {
					$('.roles-table').not('.role-table-1').find('tr:first').addClass("hidden-row");
				}
			});
		}
		//table mobile view script//

		//for alternative row colors
		var i = 0;
		$('.even-strip').each(function() {
			if (i % 2 != 0) {
				$(this).addClass("coloredrow");
			}
			i++;
		});

		//for alternative row colors

		$('.roles-table input[type="checkbox"]').click(function() {
			select_each_row_mobile($(this));
		});
	});

</script>
<script type="text/javascript">	
	$(document).ready(function() {
		
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
    		$('#capturePayment').submit();
    	})
    	$('.onsubmit').click(function(e){
    		
    	 $("#capturePayment").validate({
    	 	ignore: [],
			rules: {
				'data[capturePayment][payment_method]': "required",
				'data[capturePayment][paid_amount]': {
					required: true,
					morethanzeroAllowed: true,
				    number: true								
				}						
			},
			messages: {
				'data[capturePayment][payment_method]': "Please select payment method.",
				'data[capturePayment][paid_amount]': {
					required: "Please Enter Reciept Amount"	,
					morethanzeroAllowed:"Value should be greater than 0"								
				}				
			}
		});    		
    		
    	if($("#capturePayment").valid()){    		
    		if(parseInt($('#creditAmount').val())){
    			  $('.clientpopamount').text($(" "+'#capturePaymentInvoiceCurrency').val()+" "+$('#creditAmount').val());     			 
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
					var outstanding   = actualamount - recieptamount;
					var outstanding   = parseFloat(outstanding.toFixed(2));
					$('.dummyfield').val(outstanding);
					$('.conditiondiv').hide();
					$('#creditAmount').val(0);
				} else if (recieptamount >= paidamount) {
					var outstanding = 0;
					var outstanding    =  parseFloat(outstanding.toFixed(2));
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
