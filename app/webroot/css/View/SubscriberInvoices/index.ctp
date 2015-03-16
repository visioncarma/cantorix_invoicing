<?php $counts = $this->Paginator->params();?>
<?php $pages = $this->Paginator->current('CpnSubscriberInvoiceDetail');?>

<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>

	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link(__('<i class="icon-home home-icon"></i>Home'),array('controller'=>'Users','action'=>'adminDashboard'),array('escape'=>false));?>
		</li>
		<li>
			<?php echo $this->Html->link(__('Manage Subscriptions'),array('controller'=>'Subscribers','action'=>'index'),array('escape'=>false));?>
		</li>
		<li class="active">
			<?php echo __('Manage Invoices');?>
		</li>
	</ul><!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<h1> <?php echo __('Manage Invoices');?> </h1>
		 <div class="col-lg-2 paddingleftrightzero">
               <?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('controller'=>'subscribers','action'=>'index',$subs_plan,$subs_company,$subs_name,$subs_status,'page:'.$subs_page),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
            </div>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive table-responsivenoscroll overflowvisible">
				<div class="table-header">
					<?php echo __('Invoice List');?>
				</div>
				<div class="row margin-twenty-zero filterdivmob">
					<?php echo $this->Form->create('invoiceFilter',array('id'=>'invoiceFilter','url'=>array('controller'=>'SubscriberInvoices','action'=>'index')));?>
					<div class="form-group filed-left margin-bottom-zero  form-filter-field col-xs-12 col-lg-2 col-md-4 col-sm-4 nopaddingmobile nopaddingleft nopaddingright">
						<?php echo $this->Form->input('filterOption',array('label'=>false,'class'=>'form-control selectpicker','div'=>false,'options'=>array(''=>'Select filter Option','Company Name'=>'Company Name','Subscriber Name'=>'Subscriber Name')));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero col-xs-12 col-lg-2 col-md-4 col-sm-4 nopaddingmobile nopaddingleft nopaddingright ">
						<?php echo $this->Form->input('filterBy',array('label'=>false,'class'=>'form-control','div'=>false,'type'=>'text','placeholder'=>'Company Name/Subscriber Name'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero col-xs-12 col-lg-2 col-md-4 col-sm-4 nopaddingmobile nopaddingleft nopaddingright form-filter-field">
						<?php echo $this->Form->input('status',array('label'=>false,'class'=>'form-control selectpicker','div'=>false,'options'=>array(''=>'Select Status','Completed'=>'Paid','Failed'=>'Due','Pending'=>'Awaiting Payment','Refunded'=>'Void')));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero clearlefttrespon">
						<?php echo $this->Form->button('Filter',array('class'=>'btn btn-sm btn-primary filter-btn form-control','type'=>'submit'))?>
					</div>
					<?php echo $this->Form->end(); ?>
				</div>
                <div  class="row magin-delete-all hidden-480">
                 <span class="deleteicon delete" title="Delete All"><i class="icon-trash bigger-120" style="color:#B74635;"></i></span>
                </div> 
                
				<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
					<thead>
						<tr>
							<!--<th><label>
								<input class="ace" type="checkbox">
								<span class="lbl"></span> </label></th>-->
							<th><?php echo $this->Paginator->sort('SbsSubscriber.fullname','Subscriber Name',array('update'=>'#content','data'=>array('filterOption'=>$filterOption,'filterBy'=>$filterBy,'status'=>$status)));?></th>
							<th  class="hidden-480 hidden-column"><?php echo $this->Paginator->sort('invoice_number','Invoice Number',array('update'=>'#content','data'=>array('filterOption'=>$filterOption,'filterBy'=>$filterBy,'status'=>$status)));?></th>
							<th class="hidden-480 hidden-column"><?php echo $this->Paginator->sort('sbs_subscriber_id','Company Name',array('update'=>'#content','data'=>array('filterOption'=>$filterOption,'filterBy'=>$filterBy,'status'=>$status)))?></th>
							<th class="hidden-480"><?php echo $this->Paginator->sort('last_payment_date','Last Payment Date',array('update'=>'#content','data'=>array('filterOption'=>$filterOption,'filterBy'=>$filterBy,'status'=>$status)));?></th>
							<th class="hidden-480"><?php echo $this->Paginator->sort('last_payment_amount','Invoice Value',array('update'=>'#content','data'=>array('filterOption'=>$filterOption,'filterBy'=>$filterBy,'status'=>$status)));?></th>
							<th class="hidden-480"><?php echo $this->Paginator->sort('payment_status','Status',array('update'=>'#content','data'=>array('filterOption'=>$filterOption,'filterBy'=>$filterBy,'status'=>$status)));?></th>
							<th><?php echo __('Action');?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($cpnSubscriberInvoiceDetails as $cpnSubscriberInvoiceDetail):?>
						<tr>
							<!--<td><span class=""> <label>
									<input class="ace delete-m-row" type="checkbox">
									<span class="lbl"></span> </label> </span></td>-->
							<td ><span class="on-load"><?php echo $cpnSubscriberInvoiceDetail['SbsSubscriber']['name'].' '.$cpnSubscriberInvoiceDetail['SbsSubscriber']['surname']; ?></span>
							
							</td>
							<td class="hidden-480 hidden-column"><span class="on-load"><?php echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['invoice_no']?></span>
							
							</td>
							<td class="hidden-480 hidden-column"><span class="on-load"><?php echo $organization[$cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['invoice_no']]?></span>
							
							</td>
							<td class="hidden-480"><span class="on-load"><?php 
							    echo date($getSetting['CpnSetting']['date_format'],strtotime($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_date']));
							 ?></span>
							
							</td>
							<td align = "center" class="hidden-480">
								<span class="on-load">
									<?php echo $this->Number->currency($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_amount'],$getSetting['CpnSetting']['currency_code']);?>
								</span>
						
							</td>
							<td class="hidden-480"><span class="on-load paid">
								<?php if($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['payment_status'] == 'Completed'){
																$displayStatusIndex = "Paid";
															}elseif($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['payment_status'] == 'Failed'){
																$displayStatusIndex = "Due";
															}elseif($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['payment_status'] == 'Pending'){
																$displayStatusIndex = "Awaiting Payment";
															}else{
																$displayStatusIndex = "Void";
															}?>
								<?php echo $displayStatusIndex?>
							</span>
							<td>
							<div class="visible-md visible-lg visible-sm visible-xs btn-group">
								<button class="btn btn-xs btn-success view on-load" title="View" data-toggle="modal" data-target="#viewuser-<?php echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['id']?>">
									<i class="icon-zoom-in bigger-120"></i>
								</button>
							</div></td>
						</tr>
						<div class="modal fade" id="viewuser-<?php echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header page-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
											<i class="icon-remove"></i>
										</button>
										<h1 class="modal-title" id="myModalLabel"><?php echo __('Invoice Details');?></h1>
									</div>
									<div class="form-horizontal popup">
										<div class="modal-body">
											<div class="model-body-inner-content">

												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top"><?php echo __('Invoice Number')?> </label>
													<div class="col-sm-8">
														<p class="bold">
															<?php echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['invoice_no']?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top"> <?php echo __('Subscriber Name');?> </label>
														<div class="col-sm-8">
															<p class="bold">
																<?php echo $cpnSubscriberInvoiceDetail['SbsSubscriber']['name'].' '.$cpnSubscriberInvoiceDetail['SbsSubscriber']['surname'];?>
															</p>
														</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top"> <?php echo __('Company Name')?></label>
													<div class="col-sm-8">
														<p class="bold">
															<?php echo $organization[$cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['invoice_no']]?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top"> <?php echo __('Subscription Plan')?></label>
													<div class="col-sm-8">
														<p class="bold">
															<?php echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['subscription_type']?>
														</p>
													</div>
												</div>
												<?php if($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['txn_type']):?>
												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top"> <?php echo __('Payment Type')?></label>
													<div class="col-sm-8">
														<p class="bold">
															<?php echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['txn_type']?>
														</p>
													</div>
												</div>
												<?php endif;?>
												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top"> <?php echo __('Paid On')?></label>
													<div class="col-sm-8">
														<p class="bold">
															
															<?php $lastPaymentDate = date($getSetting['CpnSetting']['date_format'],strtotime($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_date']));/*explode(' ',$cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_date']);*/?>
															<?php echo date($getSetting['CpnSetting']['date_format'],strtotime($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_date']));?>
														</p>
													</div>
												</div>
												<?php if($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['payment_fee']):?>
												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top"> <?php echo __('Invoiced Amount')?></label>
													<div class="col-sm-8">
														<p class="bold">
															<?php echo $this->Number->currency($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_amount'],$getSetting['CpnSetting']['currency_code']);?>
														</p>
													</div>
												</div>
												<?php endif;?>
												<?php if($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['tax_amount']):?>
												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top"> <?php echo __('Tax')?></label>
													<div class="col-sm-8">
														<p class="bold">
															<?php echo $this->Number->currency($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['tax_amount'],$getSetting['CpnSetting']['currency_code']);?>
															<?php /*echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['tax_amount']*/?>
														</p>
													</div>
												</div>
												<?php endif;?>
												<?php if($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['outstanding_balance']):?>
												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top"> <?php echo __('Out Standing Payment')?></label>
													<div class="col-sm-8">
														<p class="bold">
															<?php echo $this->Number->currency($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['outstanding_balance'],$getSetting['CpnSetting']['currency_code']);?>
															<?php /*echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['outstanding_balance']*/?>
														</p>
													</div>
												</div>
												<?php endif;?>
												<?php if($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['outstanding_balance']):?>
												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top"> <?php echo __('Next Payment Date')?></label>
													<div class="col-sm-8">
														<p class="bold">
															<?php echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['next_payment_date']?>
														</p>
													</div>
												</div>
												<?php endif;?>
												<?php if($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['payment_status']):?>
												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top"> <?php echo __('Status')?> </label>
													<div class="col-sm-8">
														<p class="bold">
															<?php if($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['payment_status'] == 'Completed'){
																$displayStatus = "Paid";
															}elseif($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['payment_status'] == 'Failed'){
																$displayStatus = "Due";
															}elseif($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['payment_status'] == 'Pending'){
																$displayStatus = "Awaiting Payment";
															}else{
																$displayStatus = "Void";
															}?>
															<?php echo $displayStatus;?>
														</p>
													</div>
												</div>
												<?php endif;?>
											</div>
										</div>
										<div class="modal-footer">
						
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php endforeach;?>
					</tbody>
				</table>
		

			</div>
			
			
					<div class="row clear col-xs-12 paginationmaindiv">
                   <div class="col-sm-6">
                      <div id="sample-table-2_info" class="dataTables_info">
	                     	<?php
								echo $this->Paginator->counter(array(
									'format' => __('showing <span>{:start}</span> to <span>{:end}</span> of {:count}')
								));
							?>
                     	</div>
                      </div>
                      <?php
                      	
						if($counts['count']>1):
                      ?>
                      	
	                      <div class="col-sm-6">
	                           <div class="dataTables_paginate paging_bootstrap">
	                                <ul class="pagination">
	                                	<?php
											$this->Paginator->options(array(
		     									'update' => '#content',
												'evalScripts' => true,
												'url' => array('controller'=>'SubscriberInvoices','action'=>'index',$filterOption,$filterBy,$status),
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
                     <?php endif;?>
                </div>
                
		</div>
	</div>

</div><!-- /.page-content -->
<script type="text/javascript">
 $(document).ready(function(){     	
    	if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
    	} 
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
});
</script>  	
<?php echo $this->Js->writeBuffer();?>
