<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php $page = $this->Paginator->current('SlsQuotation');?>
<?php echo $this->Session->flash();?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
	<?php $homeLink = $this->Breadcrumb->getLink('Home');?>
	<?php //$this->CurrencySymbol->getAllCurrencies();?>
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link('Quotes',array('action'=>'index'),array('escape'=>FALSE));?>
		</li>
		<li class="active">
			Manage Quotes
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<h1 > Manage Quotes </h1>
		<?php if($permission['_create'] == '1'):?>
		<div class="col-lg-2 paddingleftrightzero managecustomeradd manageitemimport pull-right">
			<?php echo $this->Html->link('<i class="icon-plus"></i> Add New Quotes ',array('action'=>'add',$customer, $min, $max, $status, $from, $to, $page),array('class'=>'btn btn-sm btn-success pull-right addbutton','update'=>'#pageContent','escape'=>FALSE,'before' => $this->Js->get('#back-loading')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#back-loading')->effect('fadeOut', array('buffer' => false))));?>
		</div>
		<?php endif;?>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<div class="table-header">
					Quotes List
				</div>
				<div class="row margin-twenty-zero">
					<?php echo $this->Form->create('Filter',array('inputDefaults'=>array('div'=>FALSE,'label'=>FALSE)));?>
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Form->input('customer_name',array('id'=>"form-field-1",'placeholder'=>'Customer Name','class'=>'form-control'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Form->input('min_price',array('placeholder'=>'Min Amount','style'=>'width: 96px;','class'=>'form-control')); ?>
					</div> 
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Form->input('max_price',array('placeholder'=>'Max Amount','style'=>'width: 96px;','class'=>'form-control')); ?>
					</div>
					<div class="form-group filed-left margin-bottom-zero drop-down selectheight">
						<?php echo $this->Form->input('status',array('options'=>array(''=>'Status','Open'=>'Open','Draft'=>'Draft','Invoiced'=>'Invoiced'),'class'=>'form-control selectpicker','data-placeholder'=>"Status"));?>
					</div>
					<div class="input-group custom-datepicker margindate">
						<?php echo $this->Form->input('from_date',array('id'=>"id-date-picker-1",'class'=>'form-control date-picker','placeholder'=>'From','data-date-format'=>str_ireplace('y', 'yyyy', $settings['SbsSubscriberSetting']['date_format'])));
						?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="input-group custom-datepicker margindate">
						<?php echo $this->Form->input('to_date',array('id'=>"id-date-picker-1",'class'=>'form-control date-picker','placeholder'=>'To','data-date-format'=>str_ireplace('y', 'yyyy', $settings['SbsSubscriberSetting']['date_format'])));?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="form-group filed-left margin-bottom-zero">
						
						<div class="form-group filed-left margin-bottom-zero clearlefttrespon">
						<?php echo $this->Js->submit('Filter',array('url'=>array('action'=>'index'),'class'=>'btn btn-sm btn-primary filter-btn form-control','type'=>'submit','update'=>'#pageContent'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Js->link('Reset',array('action'=>'index'),array('update'=>'#pageContent','class'=>'btn btn-sm btn-primary filter-btn form-control','title'=>'Reset filtered result'));?>
					</div>
						
					</div>
					<?php echo $this->Form->end();?>
				</div>
				<div  class="row magin-delete-all">
					<span class="deleteicon delete" title="Delete All"> <i class="icon-trash bigger-120" style="color:#d15b47;"></i> </span>
				</div>
				<?php if($page == 1) {
					$url = array($customer, $min, $max, $status, $from, $to, $page);
				} else {
					$url = array('action'=>'index');
				} ?>
				<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
					<thead>
						<tr>
							<th class="width10"><label>
								<input class="ace" type="checkbox">
								<span class="lbl"></span> </label>
							</th>
							
							<th class="width120"><?php echo $this->Paginator->sort('quotation_no','Quote No',array('update'=>'#pageContent','url'=>$url));?></th>
							<th class="width200"><?php echo $this->Paginator->sort('AcrClient.client_name','Customer Name',array('update'=>'#pageContent'));?></th>
							<th class="width180"><?php echo $this->Paginator->sort('issue_date','Issue Date',array('update'=>'#pageContent'));?></th>
							<th class="width150"><?php echo $this->Paginator->sort('invoice_amount','Amount',array('update'=>'#pageContent'));?></th>
							<th class="width150"><?php echo $this->Paginator->sort('status','Status',array('update'=>'#pageContent'));?></th>
							<th class="width180">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($quotes as $quote):?>
						<tr>
							<td>
								<span class=""> 
									<label>
										<input class="ace delete-m-row" type="checkbox">
										<span class="lbl"></span>
									</label> 
								</span>
							</td>
							<td>
								<span class="on-load quoteno"><?php echo $quote['SlsQuotation']['quotation_no'];?></span>
							</td>
							<td>
								<span class="on-load"><?php echo $quote['AcrClient']['client_name'];?></span>
							</td>
							<td>
								<span class="on-load"><?php str_ireplace('y', 'yyyy', $settings['SbsSubscriberSetting']['date_format']);echo date($settings['SbsSubscriberSetting']['date_format'],strtotime($quote['SlsQuotation']['issue_date']));?></span>
							</td>
							<td>
								<span class="on-load">
									<?php echo $this->Number->currency($quote['SlsQuotation']['invoice_amount'], $quote['SlsQuotation']['invoice_currency_code']); ?>
								</span>
							</td>
							<td>
								<?php 
									if($quote['SlsQuotation']['status'] == 'Open') {
										$class = 'statusopn';
									} elseif($quote['SlsQuotation']['status'] == 'Invoiced') {
										$class = 'statusconverttoinvoice';
									} else {
										$class = NULL;
									}
								?>
								<span class="on-load <?php echo $class;?>"><?php echo $quote['SlsQuotation']['status'];?></span>
							</td>
							<td>
								<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
									<?php echo $this->Js->link('<i class="icon-zoom-in bigger-120"></i>',array('action'=>'view',$subscriberID,$quote['SlsQuotation']['id'],$customer, $min, $max, $status, $from, $to, $page),array('class'=>'btn btn-xs btn-success view on-load','title'=>'View','escape'=>FALSE,'update'=>'#pageContent'));?>
									<?php if($permission['_update'] == '1'):?>
									<?php echo $this->Js->link('<i class="icon-edit bigger-120"></i>',array('action'=>'edit',$subscriberID,$quote['SlsQuotation']['id'],$customer, $min, $max, $status, $from, $to, $page),array('class'=>'btn btn-xs btn-info edit on-load','title'=>'Edit','escape'=>FALSE,'update'=>'#pageContent'));?>
									<?php endif;?>
									<?php if($quote['SlsQuotation']['status'] != 'Invoiced') {?>
									<button class="btn btn-xs edit  on-load mail-popup" title="Mail" data-toggle="modal" data-target="#M<?php echo $quote['SlsQuotation']['id'];?>">
										<i class="icon-envelope-alt  bigger-120"></i>
									</button>
									<?php }?>
									<?php if($permission['_update'] == '1' && $quote['SlsQuotation']['status'] != 'Invoiced' && $invoiceCount < $currntPlan['CpnSubscriptionPlan']['no_of_invoices']) {?>
										<button class="btn btn-xs btn-warning edit on-load convertInvoice" title="Convert to invoice" data-toggle="modal" data-target="#<?php echo $quote['SlsQuotation']['id'];?>">
										<i class="icon-exchange  bigger-120"></i>
										</button>
										
									<?php }?>
									<?php //if($permission['_read'] == '1' && $quote['SlsQuotation']['status'] == 'Invoiced'):?>
										<?php //echo $this->Js->link('Invoice',array('controller'=>'acr_client_invoices','action'=>'view',$quote['SlsQuotation']['acr_client_invoice_id']),array('update'=>'#preview-Invoice','style'=>'display:none;','class'=>'viewInvoice'));?>
									<!--<button title="" class="btn btn-xs btn-grey edit  on-load viewInvoicebtn" data-original-title="View Invoice" data-toggle="modal" data-target="#invoice"> <i class="icon-save bigger-120"></i> </button> -->
									<?php //endif;?>
									<?php if($permission['_delete'] == '1' && $quote['SlsQuotation']['status'] != 'Invoiced'):?>
									<button class="btn btn-xs btn-danger delete on-load deleteQuote" title="Delete" data-toggle="modal" data-target="#D<?php echo $quote['SlsQuotation']['id'];?>">
										<i class="icon-trash bigger-120"></i>
									</button>
									<?php endif;?>
								</div>
								
								<div class="visible-xs visible-sm hidden-md hidden-lg">
									<div class="inline position-relative">
										<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
											<i class="icon-cog icon-only bigger-110"></i>
										</button>
										<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close ipadfix">
											<li>
												<?php echo $this->Js->link('<i class="icon-zoom-in bigger-120"></i>',array('action'=>'view',$subscriberID,$quote['SlsQuotation']['id'],$customer, $min, $max, $status, $from, $to, $page),array('class'=>'btn btn-xs btn-success view on-load curomeranchor','title'=>'View','escape'=>FALSE,'update'=>'#pageContent'));?>
											</li>
											<li>
												<?php if($permission['_update'] == '1'):?>
												<?php echo $this->Js->link('<i class="icon-edit bigger-120"></i>',array('action'=>'edit',$subscriberID,$quote['SlsQuotation']['id'],$customer, $min, $max, $status, $from, $to, $page),array('class'=>'btn btn-xs btn-info edit on-load curomeranchor','title'=>'Edit','escape'=>FALSE,'update'=>'#pageContent'));?>
												<?php endif;?>
											</li>
											<li>
												<?php if($quote['SlsQuotation']['status'] != 'Invoiced') {?>
												<button class="btn btn-xs edit  on-load mail-popup" title="Mail" data-toggle="modal" data-target="#M<?php echo $quote['SlsQuotation']['id'];?>">
													<i class="icon-envelope-alt  bigger-120"></i>
												</button>
												<?php }?>
											</li>
											<li>
												<?php if($permission['_update'] == '1' && $quote['SlsQuotation']['status'] != 'Invoiced' && $invoiceCount < $currntPlan['CpnSubscriptionPlan']['no_of_invoices']) {?>
										<button class="btn btn-xs btn-warning edit on-load convertInvoice" title="Convert to invoice" data-toggle="modal" data-target="#<?php echo $quote['SlsQuotation']['id'];?>">
										<i class="icon-exchange  bigger-120"></i>
										</button>
										
									<?php }?>
											</li>
											<li>
												<?php if($permission['_delete'] == '1' && $quote['SlsQuotation']['status'] != 'Invoiced'):?>
									<button class="btn btn-xs btn-danger delete on-load deleteQuote" title="Delete" data-toggle="modal" data-target="#D<?php echo $quote['SlsQuotation']['id'];?>">
										<i class="icon-trash bigger-120"></i>
									</button>
									<?php endif;?>
											</li>
										</ul>
									</div>
								</div>
								
								
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
				
				<div class="row">
					<div class="col-sm-6">
						<div id="sample-table-2_info" class="dataTables_info">
							<?php echo $this->Paginator->counter(array('format' => __('Showing {:start} to {:end} of {:count} entries')));?>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="dataTables_paginate paging_bootstrap">
							<ul class="pagination">
								<?php
									if($customer || $min || $max || $status || $from || $to) {
										$url = array('action'=>'index',$customer, $min, $max, $status, $from, $to, $page);
									} else {
										$url = array('action'=>'index');
									}
									$this->Paginator->options(array(
					 					'update' => '#pageContent',
										'evalScripts' => TRUE,
										'before' => $this->Js->get('#loading')->effect('fadeIn', array('buffer' => false)),
		    							'complete' => $this->Js->get('#loading')->effect('fadeOut', array('buffer' => false)),
										'url' => $url
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
<!-- /.page-content -->

<!--Popup add  -->
<div class="modal fade first"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modaldialogcancel475">
		<div class="modal-content">
			<div class="modelinsidesubscriber">
				<button class="close" aria-hidden="true" data-dismiss="modal" type="button">
					<i class="icon-remove"></i>
				</button>

				<form class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
					<div class="modal-body">
						<div class="model-body-inner-content">
							<div>
								<h3 class="bolder red 22pfont center"> Convert to Invoice </h3>
								<div class="center 14pfont paddingbottom">
									You are about to convert quote #<span class="quotepopno"><?php echo $value['AcrClient']['client_name'];?></span> to an invoice.
								</div>
								<div class="space-12"></div>

								<div class="paddingleftrightzero padingleftneed buttoncenter">
									<?php echo $this->Html->link('Ok',array('action'=>'convertToInvoice',$subscriberID,$quote['SlsQuotation']['id'],$customer, $min, $max, $status, $from, $to, $page),array('class'=>'btn btn-sm paddingbtn-sm-ok btn-danger delete on-load convertToInvoiceLink','escape'=>FALSE));?>
									<button class="btn btn-sm btn-danger" data-dismiss="modal">
										Cancel
									</button>
								</div>
								<div class="space-6"></div>
								<p> &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;</p>
							</div>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>
<!--end of pop--> 


<!--Popup add  -->
<div class="modal fade delete"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modaldialogcancel475">
		<div class="modal-content">
			<div class="modelinsidesubscriber">
				 <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button> 

				<div class="form-horizontal popup" >
					<div class="modal-body">
						<div class="model-body-inner-content">
							<div>
								<h3 class="bolder red 22pfont center"> Delete Quote </h3>
								<div class="center 14pfont paddingbottom">
									You are about to delete quote #<span class="quotepopno"><?php echo $value['AcrClient']['client_name'];?></span>. Are you sure want to delete ?
								</div>
								<div class="space-12"></div>

								<div class="paddingleftrightzero padingleftneed buttoncenter">
									<?php echo $this->Html->link('Delete',array('action'=>'delete',$subscriberID,$quote['SlsQuotation']['id'],$customer, $min ,$max, $status, $from, $to, $page),array('class'=>'btn btn-sm paddingbtn-sm-ok btn-danger delete on-load deleteLink','escape'=>FALSE));?>
									<button class="btn btn-sm btn-danger" data-dismiss="modal">
										Cancel
									</button>
								</div>
								<div class="space-6"></div>
								<p> &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;</p>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<!--end of pop-->

<!--Popup mail items  -->
<div class="modal fade mail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog model-quotes">
		<div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="icon-remove"></i>
				</button>
				<h1 class="modal-title bold" id="myModalLabel">Send Quote</h1>
			</div>
			<form class="form-horizontal popup" role="form" id="MailPopForm" method="POST">
				<div class="modal-body">
					<div class="model-body-inner-content">
						<div class="form-group login-form-group">
							<p>
								Please select the Template to continue
							</p>
						</div>
						<div id="mail-field" class="form-group filed-left margin-bottom-zero drop-down">
							<?php echo $this->Form->input('AcrClientInvoice.email_template',array('class'=>'chosen-select','data-placeholder'=>'Email Templates','options'=>array(''=>'Select Email Template','quote_product_classic'=>'Product Classic','quote_product_modern'=>'Product Modern','quote_service_classic'=>'Service Classic','quote_service_modern'=>'Service Modern')));?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				  <?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'previewpopup btn btn-success addbutton left marginleftzero marginright14','url' => array('controller'=>'quotes','action'=>'previewCommon'),'style'=>'display:none;','escape'=>false,'update' => '#preview-template'));?>
				  <?php echo $this->Form->submit('Submit', array('div'=>false,'class'=>'sendSubmit btn btn-success addbutton left marginleftzero marginright14','style'=>'display:none;'));?>
					<button class="btn btn-success addbutton left marginleftzero marginright14 previewbtn" type="submit" data-toggle="modal" data-target="#preview">
						<i class="icon-zoom-in bigger-110"></i> Preview
					</button>
					<button class="btn btn-info left marginleftzero marginright14 sendbtn" type="button">
						<i class="icon-share-alt bigger-110"></i> Send
					</button>
					<button class="btn left marginleftzero popup-cancel" type="button">
						<i class="icon-remove bigger-110"></i> Cancel
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--end of pop-->

<!--Popup preview items  -->
<div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div id="preview-template" class="modal-dialog model-quotes">
		
	</div>
</div>
<!--end of pop-->

<?php if(!$customer) $customer=0;?>
<script type="text/javascript">
	jQuery(function($) {
		$(".chosen-select").chosen();
	});
	$(document).ready(function(){
		$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
		if($('.selectpicker').length){
	   		      $('.selectpicker').selectpicker({
			       });
    	   
    	         }	
    	 
		$("#MailPopForm").validate({
			onkeyup: false,
			rules: {
				'data[AcrClientInvoice][email_template]' : {
					required : true
				}
			},
			messages: {
				'data[AcrClientInvoice][email_template]' : {
					required : 'Please select any template.'
				}
			}
		});
		
		
		var server = 'cantorix';
		$('.convertInvoice').click(function(){
			quoteno = $(this).parents('tr').find('td span.quoteno').text();
	 		$('.quotepopno').text(quoteno);
	 		var thisid=$(this).attr('data-target');
	 		var thislength=thisid.length;
	 		thisid=thisid.slice(1,thislength);
	 		$('.modal.fade.first').attr('id',thisid);
	 		$('.convertToInvoiceLink').attr('href',"<?php echo $this->webroot.'quotes/convertToInvoice/'.$subscriberID.'/';?>"+thisid+"<?php echo '/'.$customer.'/'.$min.'/'.$max.'/'.$status.'/'.$from.'/'.$to.'/'.$page;?>");
	 	});
	 	
	 	$('.deleteQuote').click(function(){
			quoteno = $(this).parents('tr').find('td span.quoteno').text();
			$('.quotepopno').text(quoteno);
	 		var thisid=$(this).attr('data-target');
	 		var thislength=thisid.length;
	 		thisid=thisid.slice(2,thislength);
	 		$('.modal.fade.delete').attr('id','D'+thisid);
	 		$('.deleteLink').attr('href',"<?php echo $this->webroot.'quotes/delete/'.$subscriberID.'/';?>"+thisid+"<?php echo '/'.$customer.'/'.$min.'/'.$max.'/'.$status.'/'.$from.'/'.$to.'/'.$page;?>");
	 	});
	 	
	 	$('.mail-popup').click(function(){
			var thisid=$(this).attr('data-target');
	 		var thislength=thisid.length;
	 		thisid=thisid.slice(2,thislength);
	 		$('.modal.fade.mail').attr('id','M'+thisid);
	 		$('#mail-field').append("<input name='data[AcrClientInvoice][id]' type='hidden' value='"+thisid+"'/>");
	 	});
	 	$('.previewbtn').click(function(){
			$('.previewpopup').trigger('click');
		});
		$('.sendbtn').click(function() {
			var urrl = '/'+server+'/quotes/sendMailQuotationCommon/0/<?php echo $customer.'/'.$min.'/'.$max.'/'.$status.'/'.$from.'/'.$to.'/'.'page:'.$page?>';
			$('#MailPopForm').attr('action',urrl);
			$('.sendSubmit').trigger('click');
		});
		
	});
	$(document).ready(function(){
		var flag=0;
		var count=0;
		$('th .ace').change(function(){
			if(flag==0){
				$('.magin-delete-all .deleteicon').fadeIn('slow');
				flag=1;
			} else {
				 $('.magin-delete-all .deleteicon').fadeOut('slow');
				 flag=0;
			}
		});
		$('td .ace').change(function(){
			  var x=$(this).prop("checked");
			  if(x==true){	 		  	
				count+=1;
			  } else {	 		  	
				count-=1;
			  }
			  if(count>0) {
				$('.magin-delete-all .deleteicon').fadeIn('slow');
			  } else { 	 		  	
				 $('.magin-delete-all .deleteicon').fadeOut('slow');	 			
			  }
		});
		$('.popup-cancel').click(function(){
			$('.close').trigger('click');
		});
		$('.sendbtn').click(function(){
			$('.close').trigger('click');
		});
		
    });
</script>
<?php echo $this->Js->writeBuffer();?>		