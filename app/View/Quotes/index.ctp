<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php $page = $this->Paginator->current('SlsQuotation');?>
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
		<div class="headernew col-lg-4 col-md-5 col-sm-12 col-xs-4 width-after-600" > Manage Quotes </div>
		<?php if($permission['_create'] == '1'):?>
		<div class="col-lg-8 col-md-7 col-sm-12 col-xs-8 no-padding-left no-padding-right width-after-600 ">
			<?php echo $this->Html->link('<i class="icon-plus"></i> Add New Quotes ',array('action'=>'add',$customer, $min, $max, $status, '?'=>array('from'=>$from, 'to'=>$to), $page),array('class'=>'btn btn-sm btn-success pull-right addbutton width-after-400 mobile_100','update'=>'#pageContent','escape'=>FALSE,'before' => $this->Js->get('#back-loading')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#back-loading')->effect('fadeOut', array('buffer' => false))));?>
		</div>
		<?php endif;?>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive tableexpense">
				<div class="table-header">
					Quotes List
				</div>
				<div class="row margin-twenty-zero expensemargin">
					<?php echo $this->Form->create('Filter',array('inputDefaults'=>array('div'=>FALSE,'label'=>FALSE)));?>
					<div class="form-group filed-left margin-bottom-zero width-100-480 mobile_100">
						<?php echo $this->Form->input('customer_name',array('id'=>"form-field-1",'placeholder'=>'Customer Name','class'=>'form-control'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero minimumValue width-100-480 mobile_100">
						<?php echo $this->Form->input('min_price',array('placeholder'=>'Min Amount','class'=>'form-control')); ?>
					</div> 
					<div class="form-group filed-left margin-bottom-zero maximumValue width-100-480 mobile_100">
						<?php echo $this->Form->input('max_price',array('placeholder'=>'Max Amount','class'=>'form-control')); ?>
					</div>
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new selectheight width-100-480 mobile_100 choosen_width">
						<?php echo $this->Form->input('',array('options'=>array(''=>'Select a Status','Open'=>'Open','Draft'=>'Draft','Invoiced'=>'Invoiced'),'class'=>'form-control invdrop','data-placeholder'=>"Select a Status"));?>
					</div>
					<div class="input-group form-group custom-datepicker margindate width-100-480 datewidth">
						<?php echo $this->Form->input('from_date',array('id'=>"id-date-picker-1",'class'=>'form-control date-picker','placeholder'=>'From','data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$settings['SbsSubscriberSetting']['date_format']),));
						?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="input-group form-group custom-datepicker margindate width-100-480 datewidth">
						<?php echo $this->Form->input('to_date',array('id'=>"id-date-picker-1",'class'=>'form-control date-picker','placeholder'=>'To','data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$settings['SbsSubscriberSetting']['date_format'])));?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">
						
						<div class="form-group filed-left margin-bottom-zero clearlefttrespon mobile_100">
						<?php echo $this->Js->submit('Filter',array('url'=>array('action'=>'index'),'class'=>'btn btn-sm btn-primary filter-btn form-control','type'=>'submit','update'=>'#pageContent'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Html->link('Reset',array('action'=>'index'),array('class'=>'btn btn-sm btn-primary filter-btn form-control','title'=>'Reset filtered result'));?>
					</div>
						
					</div>
					<?php echo $this->Form->end();?>
				</div>
			</div>
		</div>
	</div>	
    
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom">
								
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding margin-bottom5">
					<div class="select-all-mobile select-all">
						<div>
							<input class="ace" type="checkbox"/>
							<span class="lbl">&nbsp; Select All</span> 
						</div>
					</div>
					<div class="delete-all-trash">
						<?php echo $this->Form->create('DeleteQuote',array('url'=>array('controller'=>'Quotes','action'=>'deleteAllQuotes'),'inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'on-edit')));?>
						<?php 
							if($permission['_delete'] == '1') {
								echo $this->Form->submit('delete_selected.png',array('class'=>'deleteicon delete','type'=>'submit','title'=>'Delete Selected','onclick'=>"return confirm('Are you sure you want to delete selected quotes ?')"));
							}
						?>
					</div>
				</div>
				
				<?php //if($page == 1) {
					$url = array($customer, $min, $max, $status, '?'=>array('from'=>$from, 'to'=>$to));
				//} else {
					//$url = array('action'=>'index');
				//} ?>
				<?php foreach($quotes as $quote):?>
				<table id="sample-table-1" class="table table-striped roles-table">
					
												
						<tr>
							<td class="select-all width-30-new">
								<label>
									<input class="ace" type="checkbox"/>
									<span class="lbl"></span> 
								</label>
							</td>
							<td class="title_role bold width-120-new"><?php echo $this->Paginator->sort('quotation_no','Quote No',array('url'=>$url,'lock'=>TRUE));?></td>
							<td class="title bold width-120-new"><?php echo $this->Paginator->sort('AcrClient.organization_name','Customer Name',array('url'=>$url,'lock'=>TRUE));?></td>
							<td class="title bold width-80-new"><?php echo $this->Paginator->sort('issue_date','Issue Date',array('url'=>$url,'lock'=>TRUE));?></td>
							<td class="title bold width-100-new textright"><?php echo $this->Paginator->sort('invoice_amount','Amount',array('url'=>$url,'lock'=>TRUE));?></td>
							<td class="title bold width-80-new"><?php echo $this->Paginator->sort('status','Status',array('url'=>$url,'lock'=>TRUE));?></td>
							
							<td class="title bold action width-120-new">Action</td>
							<td class="title select-each-mobile bold">Select</td>
						</tr>
						
						
					
						
						<tr class="even-strip">
							<td class="select-each width-30-new">
								<label>
									<?php
										if($permission['_delete'] == '1' && $quote['SlsQuotation']['status'] != 'Invoiced') {
											echo $this->Form->checkbox('DeleteQuote.delete.'.$quote['SlsQuotation']['id'],array('class'=>'ace delete-m-row'));
										}
									?>
								<span class="lbl"></span> 
								</label>
							</td>
							
							<td class="title_role ewidth120 width-120-new expenseNO">
							    <span class="quoteno" style="display: none;"><?php echo $quote['SlsQuotation']['quotation_no'];?></span>
								<?php echo $this->Html->link($quote['SlsQuotation']['quotation_no'],array('action'=>'view',$subscriberID,$quote['SlsQuotation']['id'],$customer, $min, $max, $status, '?'=>array('from'=>$from, 'to'=>$to), $page),array('title'=>'View','escape'=>FALSE));?>
							</td>
							
							<td class="title width-120-new">
								<?php echo $quote['AcrClient']['organization_name'];?>
							</td>
							
							<td class="title width-80-new">
								<?php str_ireplace('y', 'yyyy', $settings['SbsSubscriberSetting']['date_format']);echo date($settings['SbsSubscriberSetting']['date_format'],strtotime($quote['SlsQuotation']['issue_date']));?>
							</td>
							
							<td class="title width-100-new textright">
								<?php echo $this->Number->currency($quote['SlsQuotation']['invoice_amount'], $quote['SlsQuotation']['invoice_currency_code']); ?>
							</td>
							
							<td class="title width-80-new">
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
							
							
							
							<td class="title width-120-new">
								<span class="quoteno1" style="display: none;"><?php echo $quote['SlsQuotation']['quotation_no'];?></span>
								<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
									<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('action'=>'view',$subscriberID,$quote['SlsQuotation']['id'],$customer, $min, $max, $status, '?'=> array('from'=>$from, 'to'=>$to), $page),array('class'=>'btn btn-xs btn-success view on-load','title'=>'View','escape'=>FALSE,'update'=>'#pageContent'));?>
									<?php if($permission['_update'] == '1'):?>
									<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('action'=>'edit',$subscriberID,$quote['SlsQuotation']['id'],$customer, $min, $max, $status, '?'=> array('from'=>$from, 'to'=>$to), $page),array('class'=>'btn btn-xs btn-info edit on-load','title'=>'Edit','escape'=>FALSE,'update'=>'#pageContent'));?>
									<?php endif;?>
									<?php if($quote['SlsQuotation']['status'] != 'Invoiced') {?>
									<button class="btn btn-xs edit  on-load mail-popup" title="Mail" data-toggle="modal" data-target="#M<?php echo $quote['SlsQuotation']['id'];?>">
										<i class="icon-envelope-alt  bigger-120"></i>
									</button>
									<?php }?>
									<?php if($permission['_update'] == '1' && $quote['SlsQuotation']['status'] != 'Invoiced' && ($invoiceCount < $currntPlan['CpnSubscriptionPlan']['no_of_invoices'] || $currntPlan['CpnSubscriptionPlan']['no_of_invoices'] == -1)) {?>
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
												<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('action'=>'view',$subscriberID,$quote['SlsQuotation']['id'],$customer, $min, $max, $status, '?'=>array('from'=>$from, 'to'=>$to), $page),array('class'=>'btn btn-xs btn-success view on-load curomeranchor','title'=>'View','escape'=>FALSE));?>
											</li>
											<li>
												<?php if($permission['_update'] == '1'):?>
												<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('action'=>'edit',$subscriberID,$quote['SlsQuotation']['id'],$customer, $min, $max, $status, '?'=>array('from'=>$from, 'to'=>$to), $page),array('class'=>'btn btn-xs btn-info edit on-load curomeranchor','title'=>'Edit','escape'=>FALSE));?>
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
												<?php if($permission['_update'] == '1' && $quote['SlsQuotation']['status'] != 'Invoiced' && ($invoiceCount < $currntPlan['CpnSubscriptionPlan']['no_of_invoices'] || $currntPlan['CpnSubscriptionPlan']['no_of_invoices'] == -1)) {?>
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
							
							<td class="select-each-mobile select-each">
								<label>
									<?php
										if($permission['_delete'] == '1' && $quote['SlsQuotation']['status'] != 'Invoiced') {
											echo $this->Form->checkbox('DeleteQuote.delete.'.$quote['SlsQuotation']['id'],array('class'=>'ace delete-m-row'));
										}
									?>
									<span class="lbl"></span> 
								</label>
							</td>
							
						</tr>
						
					
				</table>
				<?php endforeach;?>
			</div>
		</div>
	</div>	
				
	<!-- pagination -->			
				<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 no-padding-left no-padding-right pagination_container">
					<div class="col-sm-6 no-padding-left no-padding-right margin020 paginationText">
						<div id="sample-table-2_info" class="dataTables_info">
							<?php echo $this->Paginator->counter(array('format' => __('Showing {:start} to {:end} of {:count} entries')));?>
						</div>
					</div>
					<div class="col-sm-6 no-padding-left margin020  no-padding-right paginationNumber">
						<div class="dataTables_paginate paging_bootstrap">
							<ul class="pagination">
								<?php
									if($customer || $min || $max || $status || $from || $to) {
										$url = array('action'=>'index',$customer, $min, $max, $status, '?'=>array('from'=>$from, 'to'=>$to), $page);
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
									<?php echo $this->Html->link('Ok',array('action'=>'convertToInvoice',$subscriberID,$quote['SlsQuotation']['id'],$customer, $min, $max, $status, '?'=>array('from'=>$from, 'to'=>$to), $page),array('class'=>'btn btn-sm paddingbtn-sm-ok btn-danger delete on-load convertToInvoiceLink','escape'=>FALSE));?>
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
									You are about to delete quote  #<span class="quotepopno"><?php echo $value['AcrClient']['client_name'];?></span>.<br />Are you sure want to delete ?
								</div>
								<div class="space-12"></div>

								<div class="paddingleftrightzero padingleftneed buttoncenter">
									<?php echo $this->Html->link('Delete',array('action'=>'delete',$subscriberID,$quote['SlsQuotation']['id'],$customer, $min ,$max, $status, '?'=>array('from'=>$from, 'to'=>$to), $page),array('class'=>'btn btn-sm paddingbtn-sm-ok btn-danger delete on-load deleteLink','escape'=>FALSE));?>
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
							<?php echo $this->Form->input('AcrClientInvoice.email_template',array('class'=>'form-control selectpicker','data-placeholder'=>'Email Templates','options'=>array('quote_product_classic'=>'Product Classic','quote_product_modern'=>'Product Modern','quote_service_classic'=>'Service Classic','quote_service_modern'=>'Service Modern')));?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				  <?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'previewpopup btn btn-success addbutton left marginleftzero marginright4 padding0','url' => array('controller'=>'quotes','action'=>'previewCommon'),'style'=>'display:none;','escape'=>false,'update' => '#preview-template'));?>
				  <?php echo $this->Form->submit('Submit', array('div'=>false,'class'=>'sendSubmit btn btn-success addbutton left marginleftzero marginright4 padding0','style'=>'display:none;'));?>
					<button class="btn btn-success addbutton left marginleftzero marginright4 padding0 previewbtn" type="submit" data-toggle="modal" data-target="#preview">
						<i class="icon-zoom-in bigger-110"></i> Preview
					</button>
					<button class="btn btn-info left marginleftzero marginright4 padding0 sendbtn" type="button">
						<i class="icon-share-alt bigger-110"></i> Send
					</button>
					<button class="btn left marginleftzero marginright4 padding0 popup-cancel" type="button">
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
	 <div  class="modal-dialog model-quotes" style="width:927px;">
		 <div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="icon-remove"></i>
				</button>
			</div>
			<div id="preview-template" style="float:left;width:100%;">
				
			</div>
		</div>	
	 </div>
</div>
<!--end of pop-->





<?php if(!$customer) $customer=0;?>
<script type="text/javascript">
	jQuery(function($) {
		$(".chosen-select").chosen();
	});
	$(document).ready(function(){
		/* choosen select*/
			var config = {
				  
				  '.invdrop' : {search_contains:true}
				}
				for (var selector in config) {
				  $(selector).chosen(config[selector]);
			}
		/* choosen select*/
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
			if(quoteno ==''){
				quoteno = $(this).parents('tr').find('td span.quoteno1').text();
			}
	 		$('.quotepopno').text(quoteno);
	 		var thisid=$(this).attr('data-target');
	 		var thislength=thisid.length;
	 		thisid=thisid.slice(1,thislength);
	 		$('.modal.fade.first').attr('id',thisid);
	 		$('.convertToInvoiceLink').attr('href',"<?php echo $this->webroot.'quotes/convertToInvoice/'.$subscriberID.'/';?>"+thisid+"<?php echo '/'.$customer.'/'.$min.'/'.$max.'/'.$status.'/'.$page.'?from='.$from.'&to='.$to;?>");
	 	});
	 	
	 	$('.deleteQuote').click(function(){
			quoteno = $(this).parents('tr').find('td span.quoteno').text();
			if(quoteno ==''){
				quoteno = $(this).parents('tr').find('td span.quoteno1').text();
			}
			$('.quotepopno').text(quoteno);
	 		var thisid=$(this).attr('data-target');
	 		var thislength=thisid.length;
	 		thisid=thisid.slice(2,thislength);
	 		$('.modal.fade.delete').attr('id','D'+thisid);
	 		$('.deleteLink').attr('href',"<?php echo $this->webroot.'quotes/delete/'.$subscriberID.'/';?>"+thisid+"<?php echo '/'.$customer.'/'.$min.'/'.$max.'/'.$status.'/'.$page.'?from='.$from.'&to='.$to;?>");
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
			var urrl = '<?php echo $this->webroot;?>quotes/sendMailQuotationCommon/0/<?php echo $customer.'/'.$min.'/'.$max.'/'.$status.'/'.$page.'?from='.$from.'&to='.$to?>';
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
    
    
    
    deleteselected = function() {
		//alert($('.roles-table input[type="checkbox"]:checked').length);
		if ($('.roles-table input[type="checkbox"]:checked').length > 0) {
			$('.delete-all-trash').fadeIn();
		} else {
			$('.delete-all-trash').fadeOut();

		}
	};
	select_each_row_mobile = function(that) {
		if ((that).is(":checked")) {
			$(that).parents('table').find('.select-each input[type="checkbox"]').prop('checked', true);
		} else {
			$(that).parents('table').find('.select-each input[type="checkbox"]').prop('checked', false);
		}
	}
    
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

			$('#applycredit').on('show.bs.modal', function(e) {
				//$(this).find('tr:first').removeClass("hidden-row");
				$(this).find('table:first').addClass("popuptable");
				$('.popuptable').find('tr:first').removeClass("hidden-row");
			});

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
					$('.popuptable').find('tr:first').removeClass("hidden-row");
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

		//delete all trash fadein and fadeout

		//select all check boxes
		$('.select-all-mobile input[type="checkbox"]').click(function() {
			if ($(this).is(":checked")) {
				$('.roles-table .select-all').find('input[type="checkbox"]').prop('checked', true);
			} else {
				$('.roles-table .select-all').find('input[type="checkbox"]').prop('checked', false);
			}
		});

		$('.select-all input[type="checkbox"]').click(function() {
			if ($(this).is(":checked")) {
				$('.select-all-mobile').find('input[type="checkbox"]').prop('checked', true);
				$('.select-each').find('input[type="checkbox"]').prop('checked', true);
				$('.select-all').find('input[type="checkbox"]').prop('checked', true);
			} else {
				$('.select-all-mobile').find('input[type="checkbox"]').prop('checked', false);
				$('.select-each').find('input[type="checkbox"]').prop('checked', false);
				$('.select-all').find('input[type="checkbox"]').prop('checked', false);
			}
			deleteselected();
		});

		$('.select-each input[type="checkbox"]').click(function() {
			if ($(this).find('input[type="checkbox"]').prop('checked', true)) {
				if ($('.select-all').find('input[type="checkbox"]').prop('checked', true)) {
					$('.select-all').find('input[type="checkbox"]').prop('checked', false);
					$('.select-all-mobile').find('input[type="checkbox"]').prop('checked', false);
				}
			}
			if ($('.select-each input[type="checkbox"]').length == $('.select-each input[type="checkbox"]:checked').length) {
				$('.select-all').find('input[type="checkbox"]').prop('checked', true);
				$('.select-all-mobile').find('input[type="checkbox"]').prop('checked', true);
			}
			deleteselected();
		});

		$('.select-each-mobile input[type="checkbox"]').click(function() {
			if ($('.select-each-mobile input[type="checkbox"]').length == $('.select-each-mobile input[type="checkbox"]:checked').length) {
				$('.select-all').find('input[type="checkbox"]').prop('checked', true);
				$('.select-all-mobile').find('input[type="checkbox"]').prop('checked', true);
			}
			deleteselected();
		});

	});
</script>
<?php echo $this->Js->writeBuffer();?>		