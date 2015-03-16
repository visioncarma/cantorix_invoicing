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
			<?php echo $this->Html->link(__('<i class="icon-home home-icon"></i>Home'),array('controller'=>'Users','action'=>'Dashboard'),array('escape'=>false));?>
		</li>
		<li>
			<?php echo $this->Html->link(__('Manage Subscriptions'),array('controller'=>'SubscriptionPlans','action'=>'index'),array('escape'=>false));?>
		</li>
		<li class="active">
			<?php echo __('Manage Invoices');?>
		</li>
	</ul><!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<h1> <?php echo __('Manage Invoices');?> </h1>
		<!--<div class="col-lg-2 paddingleftrightzero">
			<a class="btn btn-sm btn-success pull-right addbutton" href="#"> <i class="icon-arrow-left icon-on-left"></i> Back </a>
		</div>-->
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<div class="table-header">
					<?php echo __('Invoice List');?>
				</div>
				<div class="row margin-twenty-zero">
					<?php echo $this->Form->create('invoiceFilter',array('id'=>'invoiceFilter','url'=>array('controller'=>'SubscriberInvoices','action'=>'index')));?>
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Form->input('filterOption',array('label'=>false,'div'=>false,'options'=>array(''=>'Select filter Option','Company Name'=>'Company Name','Subscriber Name'=>'Subscriber Name')));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Form->input('filterBy',array('label'=>false,'div'=>false,'type'=>'text','placeholder'=>'Company Name/Subscriber Name'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Form->input('status',array('label'=>false,'div'=>false,'options'=>array(''=>'Select Status','Completed'=>'Paid','Failed'=>'Due','Pending'=>'Awaiting Payment','Refunded'=>'Void')));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Form->button('Filter',array('class'=>'btn btn-sm btn-primary filter-btn','type'=>'submit'))?>
					</div>
					<?php echo $this->Form->end(); ?>
				</div>

				<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
					<thead>
						<tr>
							<!--<th><label>
								<input class="ace" type="checkbox">
								<span class="lbl"></span> </label></th>-->
							<th><?php echo $this->Paginator->sort('SbsSubscriber.name','Subscriber Name');?></th>
							<th><?php echo $this->Paginator->sort('invoice_number','Invoice Number');?></th>
							<th><?php echo __('Company Name')?></th>
							<th><?php echo $this->Paginator->sort('last_payment_date','Last Payment Date');?></th>
							<th><?php echo $this->Paginator->sort('last_payment_amount','Invoice Value');?></th>
							<th><?php echo $this->Paginator->sort('payment_status','Status');?></th>
							<th><?php echo __('Action');?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($cpnSubscriberInvoiceDetails as $cpnSubscriberInvoiceDetail):?>
						<tr>
							<!--<td><span class=""> <label>
									<input class="ace delete-m-row" type="checkbox">
									<span class="lbl"></span> </label> </span></td>-->
							<td><span class="on-load"><?php echo $cpnSubscriberInvoiceDetail['SbsSubscriber']['name'].' '.$cpnSubscriberInvoiceDetail['SbsSubscriber']['surname']; ?></span>
							<input type="text" placeholder="Name" class="on-edit" />
							</td>
							<td><span class="on-load"><?php echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['invoice_no']?></span>
							<input type="text" placeholder="Invoice Number" class="on-edit" />
							</td>
							<td><span class="on-load"><?php echo $organization[$cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['invoice_no']]?></span>
							<input type="text" placeholder="Company Name" class="on-edit" />
							</td>
							<td><span class="on-load"><?php 
								$paymentdate = explode(' ',$cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_date']);
							    echo date('d-m-Y',strtotime($paymentdate['0']));
							 ?></span>
							<input type="text" placeholder="Issued Date" class="on-edit" />
							</td>
							<td><span class="on-load">$<?php $abccc = explode('.',$cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_amount']);if(!empty($abccc[1])) {echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_amount'];} else {echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_amount'].'.00';}?></span>
							<input type="text" placeholder="Invoice Value" class="on-edit" />
							</td>
							<td><span class="on-load paid">
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
							<select class="on-edit"  data-placeholder="Role">
								<option value="">Status</option>
								<option value="1">Paid</option>
								<option value="2">Due</option>
							</select></td>
							<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
								<button class="btn btn-xs btn-success view on-load" title="view" data-toggle="modal" data-target="#viewuser-<?php echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['invoice_no']?>">
									<i class="icon-zoom-in bigger-120"></i>
								</button>
							</div></td>
						</tr>
						<div class="modal fade" id="viewuser-<?php echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['invoice_no']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
															<?php echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_date'];?>
															<?php $lastPaymentDate = date('M d,Y',strtotime($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_date']));/*explode(' ',$cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_date']);*/?>
															<?php echo $lastPaymentDate;?>
														</p>
													</div>
												</div>
												<?php if($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['payment_fee']):?>
												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top"> <?php echo __('Invoiced Amount')?></label>
													<div class="col-sm-8">
														<p class="bold">
															$<?php $abccc1 = explode('.',$cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_amount']);if(!empty($abccc1[1])) {echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_amount'];} else {echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_amount'].'.00';}?>
														</p>
													</div>
												</div>
												<?php endif;?>
												<?php if($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['tax_amount']):?>
												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top"> <?php echo __('Tax')?></label>
													<div class="col-sm-8">
														<p class="bold">
															<?php echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['tax_amount']?>
														</p>
													</div>
												</div>
												<?php endif;?>
												<?php if($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['outstanding_balance']):?>
												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top"> <?php echo __('Out Standing Payment')?></label>
													<div class="col-sm-8">
														<p class="bold">
															<?php echo $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['outstanding_balance']?>
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
												'before' => $this->Js->get('#busy_indicator_back')->effect('fadeIn', array('buffer' => false)),
												'complete' => $this->Js->get('#busy_indicator_back')->effect('fadeOut', array('buffer' => false))
											)); 
											echo $this->Paginator->prev('<i class="icon-double-angle-left"></i>', array('escape'=>false,'tag' => 'li','class'=>'prev disabled'),'<a href="#"><i class="icon-double-angle-left"></i></a>', array('escape'=>false,'tag'=>'li','class' => 'disabled'));
											echo $this->Paginator->numbers(array('separator' => '','tag'=>'li','currentClass'=>'active','currentTag'=>'a'));
											echo $this->Paginator->next('<i class="icon-double-angle-right"></i>', array('escape'=>false,'tag' => 'li','class'=>'next'),'<a href="#"><i class="icon-double-angle-right"></i></a>', array('escape'=>false,'tag'=>'li','class' => 'disabled'));
										?>
	                                 </ul>
	                            </div>
	                     </div>
                     <?php endif;?>
                </div>

			</div>
		</div>
	</div>

</div><!-- /.page-content -->
<?php echo $this->Js->writeBuffer();?>
