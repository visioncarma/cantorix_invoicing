<?php $counts = $this->Paginator->params();?>
<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php $page = $this->Paginator->current('AcrInvoicePaymentDetail');?>
<?php 
	$homeLink 	 = $this->Breadcrumb->getLink('Home');
	$invoiceLink = $this->Breadcrumb->getLink('Invoices');
?>
<?php 
	$dbFormat = array("d", "M", "Y");
	$scriptFormat   = array("dd", "mm", "yyyy");
?>
<?php echo $this->Session->flash();?>

<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link('Invoices',"$invoiceLink");?>
		</li>
		<li class="active">
			<?php echo __('Payments');?>
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">
			<?php echo __('Manage Payments');?>
		</div>
		<div class="col-lg-2 paddingleftrightzero managecustomeradd manageitemimport addpayment pull-right mobile_100">
			<?php if($permission['_create'] == '1') { echo $this->Html->link('<i class="icon-plus"></i> Add New Payment',array('action'=>'addNewPayment'),array('class'=>'btn btn-sm btn-success pull-right addbutton mobile_100','escape'=>FALSE)); } ?>
		</div>
		<!-- 
		<div class="col-lg-2 paddingleftrightzero manageitemimport importinvoice pull-right">
			<div class="btn btn-sm btn-success pull-right manageinventoryexport">
				Export Payments <i class="icon-caret-down icon-on-right"></i>
			</div>
		</div>
		<div class="col-lg-2 paddingleftrightzero manageitemimport importinvoice pull-right">
			<?php echo $this->Html->link('Import Payments <i class="icon-caret-down icon-on-right"></i>',array('action'=>''),array('class'=>'btn btn-sm btn-success pull-right importbutton','escape'=>FALSE));?>
		</div>
       -->
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<div class="table-header">
					<?php echo __('Payments List');?>
				</div>
				<?php echo $this->Form->create('PaymentFilter',array('id'=>'PaymentFilter','url'=>array('controller'=>'AcrInvoicePaymentDetails','action'=>'index')));?>
				<div class="row margin-twenty-zero expensemargin">
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-100-480 mobile_100 choosen_width">						
						<?php echo $this->Form->input('filterAction',array('label'=>false,'class'=>'form-control invdrop selectitem','data-placeholder'=>'Filter By','options'=>array(''=>'Filter By','invoice_number'=>'Invoice Number','customer_name'=>'Customer Name','amount'=>'Amount')));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero dispalycommon width-100-480 mobile_100">						
						<?php echo $this->Form->input('filterValue',array('label'=>false, 'placeholder'=>'Enter', 'id'=>"", 'class'=>"form-control")); ?>
					</div>
					<div class="form-group filed-left margin-bottom-zero widthinput150 displayifnumber width-100-480 mobile_100">
						<div class="form-group margin-bottom-zero inpuwidth70 left marginright10">						     
						    <?php echo $this->Form->input('filterValue1',array('label'=>false, 'placeholder'=>'Min', 'id'=>"", 'class'=>"form-control")); ?>
						</div>
						<div class="form-group margin-bottom-zero inpuwidth70 left">						    
						     <?php echo $this->Form->input('filterValue2',array('label'=>false, 'placeholder'=>'Max', 'id'=>"", 'class'=>"form-control"));?>
						</div>     
					</div>					
					<div class="form-group input-group custom-datepicker width-100-480 datewidth">
						<?php echo $this->Form->input('fromDate',array('div'=>false,'label'=>false, 'placeholder'=>'From', 'id'=>"from", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$date_format), 'readonly'=>'readonly', 'style'=>'cursor:default')); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="form-group input-group custom-datepicker width-100-480 margin-top-15-1100 margintopzero datewidth">
						<?php echo $this->Form->input('toDate',array('div'=>false,'label'=>false, 'placeholder'=>'To', 'id'=>"", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$date_format), 'readonly'=>'readonly', 'style'=>'cursor:default')); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="form-group filed-left margin-bottom-zero margin-top-15-1300 margintopzero mobile_100">						
						<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn  filterwidth mobile_100','url' => array('controller'=>'AcrInvoicePaymentDetails','action' => 'index'),'escape'=>false,'update' => '#pageContent','before' => $this->Js->get('#loading2')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading2')->effect('fadeOut', array('buffer' => false))));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero margin-top-15-1300 margintopzero mobile_100">
						<?php echo $this->Js->link('Reset',array('controller'=>'AcrInvoicePaymentDetails','action'=>'index'),array('class'=>'btn btn-sm btn-primary filter-btn  filterwidth mobile_100','update'=>'#pageContent'));?>
					</div>
					<?php echo $this->Html->image('loding.gif', array('id'=>'loading2','style'=>'display:none;float: right;margin-right:25%;'));?>
				</div>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
			  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding margin-bottom5">		
				<?php echo $this->Form->create('PaymentDelete',array('id'=>'PaymentDelete','url'=>array('controller'=>'AcrInvoicePaymentDetails','action'=>'deleteSelected')));			
					
					if($filterAction || $filterValue || $filterValue1 || $filterValue2  || $fromDate || $toDate ) {
							$url = array('action'=>'index',$filterAction, $filterValue, $filterValue1, $filterValue2, $fromDate, $toDate, $page);
						} else {
							$url = array('action'=>'index');
						}
				?>					
					<?php foreach($acrInvoicePaymentDetails as $acrInvoicePaymentDetail):?>
					<table class="table table-striped roles-table">
					<tr>
						<td class="title_role bold width-120-new"><?php echo $this->Paginator->sort('AcrClientInvoice.invoice_number','Invoice No',array('url'=>$url,'lock'=>TRUE));?></td>
						<td class="title bold width-150-new"><?php echo $this->Paginator->sort('AcrClient.organization_name','Customer Name',array('url'=>$url,'lock'=>TRUE));?></td>
						<td class="title bold width-120-new"><?php echo $this->Paginator->sort('payment_date','Payment Date',array('url'=>$url,'lock'=>TRUE));?></td>
						<td class="title bold width-120-new "><?php echo $this->Paginator->sort('CpnPaymentMethod.payment_option_name','Payment Method',array('url'=>$url,'lock'=>TRUE));?></td>
						<td class="title bold width-120-new textright padding-right-25"><?php echo $this->Paginator->sort('paid_amount','Amount',array('url'=>$url,'lock'=>TRUE));?></td>
						<td class="title bold action width-100-new"><?php echo __('Action');?></td>
					</tr>
						<tr class="even-strip">
							<td class="title_role width-120-new"><span class="on-load statusopn">
								<?php echo $this->Html->link($acrInvoicePaymentDetail['AcrClientInvoice']['invoice_number'],array('controller'=>'acr_invoice_payment_details','action'=>'view',$acrInvoicePaymentDetail['AcrInvoicePaymentDetail']['id'],$filterAction, $filterValue, $filterValue1, $filterValue2, $fromDate, $toDate, $page),array('escape'=>FALSE,'title'=>'View'));?>
								</span>
							</td>
							<td class="title width-150-new"><span class="on-load"><?php echo $acrInvoicePaymentDetail['AcrClient']['organization_name'];?></span>							
							</td>
							<td class="title width-120-new"><span class="on-load">
								<?php $pay_date = strtotime($acrInvoicePaymentDetail['AcrInvoicePaymentDetail']['payment_date']);$payment_date = date($date_format,$pay_date);?>
								<?php echo $payment_date; ?></span>															
							</td>
							<td class="title width-120-new"><span class="on-load"><?php echo $acrInvoicePaymentDetail['CpnPaymentMethod']['payment_option_name'];?></span>							
							</td>
							<td class="title width-120-new textright padding-right-25"><span class="on-load amount" style="float:none;">							
								<?php echo $this->Number->currency($acrInvoicePaymentDetail['AcrInvoicePaymentDetail']['paid_amount'],$acrInvoicePaymentDetail['AcrClientInvoice']['invoice_currency_code']);?>
							</span>							
							</td>
							<td class="title width-100-new">
							<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
								<?php //echo $this -> Html -> link('<i class="icon-trash bigger-120"></i>', 
									//array('controller' => 'acr_invoice_payment_details', 'action' => 'delete',$acrInvoicePaymentDetail['AcrInvoicePaymentDetail']['id']),
								    //array('class'=>'btn btn-xs btn-danger delete on-load  pull-right', 'escape' => FALSE, 'title'=>'Delete','confirm'=>'Are you sure to Delete the Payment ?'));?>								
								
								<?php if($permission['_read'] == '1') { echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('controller'=>'acr_invoice_payment_details','action'=>'view',$acrInvoicePaymentDetail['AcrInvoicePaymentDetail']['id'],$filterAction, $filterValue, $filterValue1, $filterValue2, $fromDate, $toDate, $page),array('class'=>'btn btn-xs btn-success edit on-load ','escape'=>FALSE,'title'=>'View')); } ?>
							    <?php if($permission['_update'] == '1') { echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('controller'=>'acr_invoice_payment_details','action'=>'edit',$acrInvoicePaymentDetail['AcrInvoicePaymentDetail']['id'],$filterAction, $filterValue, $filterValue1, $filterValue2, $fromDate, $toDate, $page),array('class'=>'btn btn-xs btn-info  edit on-load ','escape'=>FALSE,'title'=>'Edit')); } ?>								
								<?php if($permission['_delete'] == '1') { ?>
								<button data-target="#payment<?php echo $acrInvoicePaymentDetail['AcrInvoicePaymentDetail']['id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger delete on-load deletepayment" title="Delete Payment">
										<i class="icon-trash bigger-120"></i>
								</button>
								<?php } ?>
								</div>
							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
										<i class="icon-cog icon-only bigger-110"></i>
									</button>
									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close ipadfix">
										<li>
											<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('controller'=>'acr_invoice_payment_details','action'=>'edit',$acrInvoicePaymentDetail['AcrInvoicePaymentDetail']['id'],$filterAction, $filterValue, $filterValue1, $filterValue2, $fromDate, $toDate, $page),array('class'=>'btn btn-xs btn-info  edit on-load pull-right padding3','escape'=>FALSE,'title'=>'Edit'));?>
										</li>
										<li>
											<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('controller'=>'acr_invoice_payment_details','action'=>'view',$acrInvoicePaymentDetail['AcrInvoicePaymentDetail']['id'],$filterAction, $filterValue, $filterValue1, $filterValue2, $fromDate, $toDate, $page),array('class'=>'btn btn-xs btn-success edit on-load pull-right padding3','escape'=>FALSE,'title'=>'View'));?>
										</li>
										<li>
											<button data-target="#payment<?php echo $acrInvoicePaymentDetail['AcrInvoicePaymentDetail']['id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger delete on-load pull-right deletepayment" title="Delete Payment">
													<i class="icon-trash bigger-120"></i>
											</button>
											
										</li>
									</ul>
								</div>
							</div>
							</td>
						</tr>
						</table>	
						<?php endforeach;?>	
						<?php echo $this->Form->end();?>
				</div>
				</div>
				</div>
			</div>
				
				<div class="row">
					<div class="col-sm-6">
						<div id="sample-table-2_info" class="dataTables_info">
							<?php
								echo $this->Paginator->counter(array(
									'format' => __('showing <span>{:start}</span> to <span>{:end}</span> of {:count}')
								));
							?>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="dataTables_paginate paging_bootstrap">
							<ul class="pagination">								
								<?php
									if($filterAction || $filterValue || $filterValue1 || $filterValue2  || $fromDate || $toDate ) {
										$url = array('action'=>'index',$filterAction, $filterValue, $filterValue1, $filterValue2, $fromDate, $toDate, $page);
									} else {
										$url = array('action'=>'index');
									}
									$this->Paginator->options(array(
     									'update' => '#pageContent',
										'evalScripts' => true,
										'url' => $url,
										'before' => $this->Js->get('#loading')->effect('fadeIn', array('buffer' => false)),
    									'complete' => $this->Js->get('#loading')->effect('fadeOut', array('buffer' => false))
									));
									echo $this->Paginator->first('<i class="icon-double-angle-left"></i>', array('escape'=>false,'tag' => 'li','title'=>'First'), array('escape'=>false,'tag'=>'li','title'=>'First')); 
									echo $this->Paginator->prev('<i class="icon-angle-left"></i>', array('escape'=>false,'tag' => 'li','title'=>'Previous'), '',array('escape'=>false,'tag'=>'li','style'=>'display:none;'));
									echo $this->Paginator->numbers(array('separator' => '','tag'=>'li','currentClass'=>'active','currentTag'=>'a'));
									echo $this->Paginator->next('<i class="icon-angle-right"></i>', array('escape'=>false,'tag' => 'li','title'=>'Next'),'<a href="#"><i class="icon-double-angle-right"></i></a>', array('escape'=>false,'tag'=>'li','style'=>'display:none;'));
									echo $this->Paginator->last('<i class="icon-double-angle-right"></i>', array('escape'=>false,'tag' => 'li','title'=>'Last'), array('escape'=>false,'tag'=>'li','title'=>'Last'));
									echo $this->Html->image('loding.gif', array('id'=>'loading','style'=>'display:none;float: right;margin-right: -18px;padding-top: 4px;'));
											
								?>								
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--Popup add  -->
<div class="modal fade first"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
			 	Would you like to create the credit note of<sapn class="clientpopamount" style="color:#dd5a43"></sapn> </span> as over payment from this customer?	 
			 </div>
			 <div class="space-12"></div>
			 
			 <div class="paddingleftrightzero padingleftneed buttoncenter">
					 	<button data-target="#paymentConfirm" data-toggle="modal" data-dismiss="modal" class="btn btn-sm paddingbtn-sm-ok btn-danger delete on-load okpopup">
							Yes
						</button>
			 		&nbsp;&nbsp;&nbsp;
			  			<button data-target="#paymentConfirm" data-toggle="modal" data-dismiss="modal" class="btn btn-sm paddingbtn-sm-ok btn-danger delete on-load okpopup">
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
									
									
<!--Popup add  -->
<div class="modal fade second" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modelinsidesubscriber">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button> 
      
      <div class="form-horizontal popup">
      <div class="modal-body">
         <div class="model-body-inner-content">  
         	<div>
			 <h3 class="bolder red 22pfont center"> Confirm Delete Payment</h3>
			 <div class="center 14pfont paddingbottom">
			 	Are you sure you wish to delete payment ?		 	 
			 </div>
			 <div class="space-12"></div>
			 
			 <div class="paddingleftrightzero padingleftneed buttoncenter">
				<?php echo $this->Html->link('Yes',array('#'),array('class'=>'btn btn-sm btn-danger delete on-load paddingbtn-sm'));?>
				&nbsp;&nbsp;&nbsp;
				<button class="btn btn-sm btn-danger delete on-load" data-dismiss="modal">
					No
		   		</button>
			</div>
			 <div class="space-6"></div>
			<p>
				<span class="bolder">&nbsp;&nbsp;&nbsp;&nbsp; </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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




<script type="text/javascript">
            $(document).ready(function() {
		      $('.date-picker').datepicker({
			     autoclose : true
		          }).next().on(ace.click_event, function() {
		    	$(this).prev().focus();
		       });
		       
		       /* choosen select*/
					var config = {
						  
						  '.invdrop' : {search_contains:true}
						}
						for (var selector in config) {
						  $(selector).chosen(config[selector]);
					}
				/* choosen select*/
	      });
			
			$(document).ready(function(){
				check();				
				
				if($('.selectpicker').length){
	   		      $('.selectpicker').selectpicker({
			       });
    	   
    	         }				
				});
				
				
	$(document).ready(function(){
		
		// popup
		var amount;
	 	$('.deletepayment').click(function(){
	 		amount = $(this).parents('tr').find('td span.amount').text();
	 		$('.clientpopamount').text(amount);
	 		var thisid=$(this).attr('data-target');
	 		var thislength=thisid.length;
	 		thisid=thisid.slice(8,thislength);
	 		$('.modal.fade.first').attr('id','payment'+thisid);
	 		$('.okpopup').attr('data-target','#paymentConfirm'+thisid);
	 	});
	 	$('.okpopup').click(function(){
	 		var credit_note=$(this).text();	
	 		var thisid=$(this).attr('data-target');
	 		var thislength=thisid.length;
	 		thisid=thisid.slice(15,thislength);
            $('.modal.fade.second').attr('id','paymentConfirm'+thisid);
	 		$('.btn.btn-sm.btn-danger.delete.on-load.paddingbtn-sm').attr('href',"<?php echo $this->webroot.'acr_invoice_payment_details/delete/';?>"+thisid+'/'+credit_note+"<?php echo '/'.$filterAction.'/'.$filterValue.'/'.$filterValue1.'/'.$filterValue2.'/'.$fromDate.'/'.$toDate.'/'.$page;?>");
	 	});
		//
		
	    var flag=0;
	    var count=0;
	 	$('th .ace').change(function(){
	 		if(count!=0)
	 		   count=0;
	 		if(flag==0){
	 		    $('.magin-delete-all .deleteicon').fadeIn('slow');
	 		    flag=1;
	 		}
	 		else{
	 			 $('.magin-delete-all .deleteicon').fadeOut('slow');
	 			 flag=0;
	 		}
	 	});
	 	$('td .ace').change(function(){
	 		if(flag==0){
	 		  var x=$(this).prop("checked");
	 		  if(x==true){		 		
	 		  	count+=1;
	 		  }
	 		  else{	 		  	
	 		  	count-=1;
	 		  }
	 		  
	 		 
	 		  if(count>0 )
	 		    $('.magin-delete-all .deleteicon').fadeIn('slow');
	 		  else if(count<=0&&flag==0){ 	 		  	
	 			 $('.magin-delete-all .deleteicon').fadeOut('slow');	 			
	 		  }
	 		 }
});	
$('body').on('change','.selectitem',function(){
	var thisvalue = $('.selectitem option:selected').text();
	$('.dispalycommon').find('.input .form-control').val('');
	$('.displayifnumber').find('.input .form-control').val('');
	if (thisvalue=="Amount")
	   {
	   	 $('.dispalycommon').hide();
	   	 $('.displayifnumber').show();
	   }
	   else{
	   	   $('.dispalycommon').show();
	   	   $('.displayifnumber').hide();
	   }
});

});


function check(){
	var thisvalue = $('.selectitem option:selected').text();
	if (thisvalue=="Amount")
	   {  
	   	 $('.dispalycommon').hide();	
	   	 $('.displayifnumber').show();
	   }
	   
}	




$(document).ready(function(){
	
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
});





</script>
<?php echo $this->Js->writeBuffer();?>