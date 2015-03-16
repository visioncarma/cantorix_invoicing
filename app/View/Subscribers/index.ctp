<?php echo $this->Session->flash();?>
<div class="breadcrumbs" id="breadcrumbs">
	<?php $page = $this->Paginator->current('SbsSubscriber');?>
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
	$subscriptionsLink = $this->Breadcrumb->getLink('Manage Subscription');
	if($plan || $company || $subscriberName || $status) {
		$url = array('action'=>'index',$plan,$company,$subscriberName,$status);
	} else {
		$url = array('action'=>'index');
	}
?>
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link('Manage Subscriptions',"$subscriptionsLink");?>
		</li>
		<li class="active">
			Manage Subscribers
		</li>
	</ul><!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<!--<h1> Manage Subscribers </h1>-->
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">
			Manage Subscribers
		</div>
		<div class="col-lg-8 col-md-7 col-sm-8 col-xs-8 no-padding-left no-padding-right width-after-600">
			<?php echo $this->Html->link('Invoices',array('controller'=>'subscriber_invoices','action'=>'index'),array('class'=>'btn btn-sm btn-success pull-right addbutton width-after-400 btn-inverse addinvoice'));?>
		</div>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive table-responsivenoscroll tablemobile_overflowhidd">
				<div class="table-header">
					Subscribers
				</div>
				<div class="row margin-twenty-zero filterdivmob">
					<?php echo $this->Form->create('Filter',array('inputDefaults'=>array('div'=>FALSE,'label'=>FALSE)));?>
					
					
					<div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 nopadding col-lg-2 col-md-4 col-sm-4 choosen_width admin_choosen">                    	                    	                    	
                    	<?php echo $this->Form->input('plan',array('class'=>'form-control invdrop','data-placeholder'=>'Plans Type','options'=>array(''=>'',$plans)));?>                    	
                     </div>
                     
					<div class="form-group filed-left margin-bottom-zero col-xs-12 col-lg-2 col-md-4 col-sm-4 nopaddingmobile nopaddingleft nopaddingright">
						<?php echo $this->Form->input('companyName',array('placeholder'=>'Company Name','class'=>'col-xs-12 form-control'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero col-xs-12 col-lg-2 col-md-4 col-sm-4 nopaddingmobile nopaddingleft nopaddingright">
						<?php 
						if($subscriberName){
							echo $this->Form->input('subscriberName',array('placeholder'=>'Subscriber Name','value'=>$subscriberName,'class'=>'col-xs-12 form-control'));
						} else {
							echo $this->Form->input('subscriberName',array('placeholder'=>'Subscriber Name','class'=>'col-xs-12 form-control'));
						}?>
					</div>
					<div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 nopadding col-lg-2 col-md-4 col-sm-4 choosen_width admin_choosen">
						<?php echo $this->Form->input('status',array('class'=>'form-control invdrop','data-placeholder'=>'Status','options'=>array(''=>'','Active'=>'Active','Cancelled'=>'Cancelled','Expired'=>'Expired','Pending'=>'Pending','Suspended'=>'Suspended')));?>
					</div>
					
					
                     
					<div class="form-group filed-left margin-bottom-zero clearlefttrespon mobile_100">
						<?php echo $this->Js->submit('Filter',array('url'=>array('action'=>'index'),'class'=>'btn btn-sm btn-primary filter-btn mobile_100','type'=>'submit','update'=>'#content'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Js->link('Reset',array('action'=>'index'),array('class'=>'btn btn-sm btn-primary filter-btn mobile_100','update'=>'#content','title'=>'Reset filtered result'));?>
					</div>
					<?php echo $this->Form->end();?>
				</div>
				<?php /*echo $this->Form->create('Subscriber',array('inputDefaults'=>array('div'=>FALSE,'label'=>FALSE)));*/?>
				
				<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table nodeletspaceup">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('fullname','Subscriber Name',array('url'=>$url,'lock'=>TRUE)); ?></th>
							<th class="hidden-480 hidden-column">Subscriber email</th>
							<th class="hidden-480 hidden-column"><?php echo $this->Paginator->sort('SbsSubscriberOrganizationDetail.organization_name','Company Name',array('url'=>$url,'lock'=>TRUE)); ?></th>
							<th class="hidden-480"><?php echo $this->Paginator->sort('cpn_subscription_plan_id','Plan Type',array('url'=>$url,'lock'=>TRUE)); ?></th>
							<th class="hidden-480"><?php echo $this->Paginator->sort('status','Status',array('url'=>$url,'lock'=>TRUE)); ?></th>
							<th>Action</th>
						</tr>
					</thead>
					
					<tbody>
						<?php foreach($subscribers as $subscriber):?>
						<tr>
							
							<td ><span class="on-load"><?php echo $subscriber['SbsSubscriber']['fullname'];?></span></td>
							<td class="hidden-480 hidden-column"><span class="on-load"><?php echo $subscriber['User']['email'];?></span></td>
							<td class="hidden-480 hidden-column"><span class="on-load"><?php echo $subscriber['SbsSubscriberOrganizationDetail']['organization_name'];?></span></td>
							<td class="hidden-480"><span class="on-load"><?php echo $plans[$subscriber['SbsSubscriber']['cpn_subscription_plan_id']];?></span></td>
							<td class="hidden-480">
							<?php 
								if($subscriber['SbsSubscriber']['status'] == 'Active') {
									$colorCode = 'green';
								} elseif($subscriber['SbsSubscriber']['status'] == 'Suspended') {
									$colorCode = 'red';	
								} elseif($subscriber['SbsSubscriber']['status'] == 'Pending') {
									$colorCode = '#2C83B8';
								} elseif($subscriber['SbsSubscriber']['status'] == 'Cancelled') {
									$colorCode = 'black';
								} else {
									$colorCode = 'black';
								}
							?>
								<span class="on-load" style="color: <?php echo $colorCode;?>"><?php echo $subscriber['SbsSubscriber']['status'];?></span>
							</td>
							<td>
								<div class="visible-md visible-lg  btn-group">
									
									<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
									<?php echo $this->Js->submit('<i class="icon-ok bigger-120"></i>',array('action'=>'add'),array('type'=>'button','class'=>'btn btn-xs submit','escape'=>FALSE));?>
									<button class="btn btn-xs close-action" title="Cancel" type="reset">
										<i class="icon-remove bigger-120"></i>
									</button> </a>
									<?php 
										if($permission['_read'] == 1){
											echo $this->Form->postLink('<i class="icon-zoom-in bigger-120"></i>',array('action'=>'view',$subscriber['SbsSubscriber']['id'],$plan,$company,$subscriberName,$status,$page),array('class'=>'btn btn-xs btn-success view on-load','title'=>'View','escape'=>FALSE));
										}
									?>
									<?php 
										if($permission['_read'] == 1){
											echo $this->Html->link('<i class="icon-file-alt bigger-120"></i>',array('controller'=>'subscriber_invoices','action'=>'index','Subscriber id',$subscriber['SbsSubscriber']['id'],'0','0',$plan,$company,$subscriberName,$status,$page),array('class'=>'btn btn-xs btn-warning invoice','title'=>'Invoices','escape'=>FALSE));
										}
									?>
									<?php
										if($permission['_delete'] == 1) {
											if($subscriber['SbsSubscriber']['status'] == 'Suspended' && $subscriber['SbsSubscriber']['is_archived'] == 'N') {
												echo $this->Form->postLink('<i class="icon-rotate-right bigger-120"></i>',array('controller'=>'users','action'=>'activateSubscriber',$subscriber['SbsSubscriber']['id'],$plan,$company,$subscriberName,$status,$page),array('class'=>'btn btn-xs btn-inverse view on-load','title'=>'Activate','escape'=>FALSE,'confirm'=>'Are you sure want to activate subscriber ?'));
											} elseif($subscriber['SbsSubscriber']['status'] == 'Suspended' && $subscriber['SbsSubscriber']['is_archived'] == 'Y') {
												echo $this->Form->postLink('<i class="icon-play-sign bigger-120"></i>',array('controller'=>'users','action'=>'activateSubscriber',$subscriber['SbsSubscriber']['id'],$plan,$company,$subscriberName,$status,$page),array('class'=>'btn btn-xs btn-grey view on-load','title'=>'Restore and Activate','escape'=>FALSE,'confirm'=>'Are you sure want to restore and activate subscriber ?'));
											} elseif($subscriber['SbsSubscriber']['status'] == 'Active') {
											    echo $this->Form->postLink('<i class="icon-ban-circle bigger-120"></i>',array('controller'=>'users','action'=>'cancelSubscriber',$subscriber['SbsSubscriber']['id'],$plan,$company,$subscriberName,$status,$page),array('class'=>'btn btn-xs btn-grey view on-load','title'=>'Deactivate','escape'=>FALSE,'confirm'=>'Are you sure want to deactivate subscriber ?'));
											}
										} 
									?>
								</div>
									<div class="visible-xs visible-sm hidden-md hidden-lg">
										<div class="inline position-relative">
											<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
												<i class="icon-cog icon-only bigger-110"></i>
											</button>

											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
																						
												<li>
														<?php 
											if($permission['_read'] == 1){
												echo $this->Form->postLink('<i class="icon-zoom-in bigger-120"></i>',array('action'=>'view',$subscriber['SbsSubscriber']['id'],$plan,$company,$subscriberName,$status,$page),array('class'=>'btn btn-xs btn-success view on-load','title'=>'View','escape'=>FALSE));
											}
										?>
												</li>

												<li>
												<?php 
												if($permission['_read'] == 1) {
											         echo $this->Html->link('<i class="icon-file-alt bigger-120"></i>',array('controller'=>'subscriber_invoices','action'=>'index','Subscriber id',$subscriber['SbsSubscriber']['id'],'0','0',$plan,$company,$subscriberName,$status,$page),array('class'=>'btn btn-xs btn-warning invoice','title'=>'Invoices','escape'=>FALSE));
											    }
												?>
												</li>
												<li>
													<?php 
										if($permission['_delete'] == 1) {
											if($subscriber['SbsSubscriber']['status'] == 'Cancelled' || $subscriber['SbsSubscriber']['status'] == 'Suspended') {
												echo $this->Form->postLink('<i class="icon-play bigger-120"></i>',array('controller'=>'users','action'=>'activateSubscriber',$subscriber['SbsSubscriber']['id'],$plan,$company,$subscriberName,$status,$page),array('class'=>'btn btn-xs btn-inverse view on-load','title'=>'Activate','escape'=>FALSE,'confirm'=>'Are you sure want to activate subscriber ?'));
											}
											if($subscriber['SbsSubscriber']['status'] == 'Active') {
												echo $this->Form->postLink('<i class="icon-stop  bigger-120"></i>',array('controller'=>'users','action'=>'cancelSubscriber',$subscriber['SbsSubscriber']['id'],$plan,$company,$subscriberName,$status,$page),array('class'=>'btn btn-xs btn-grey view on-load','title'=>'Deactivate','escape'=>FALSE,'confirm'=>'Are you sure want to deactivate subscriber ?'));
											}
										} 
									?>
												</li>
											</ul>
										</div>
									</div>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
				<?php /*echo $this->Form->end();*/?>
			
			</div>
			
			
			
			<!-- pagination -->
			
				 <div class="row clear col-xs-12 paginationmaindiv">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 paginationText">
						<div id="sample-table-2_info" class="dataTables_info">
							<?php echo $this->Paginator->counter(array('format' => 'Showing {:start} to {:end} of {:count} entries'));?>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 paginationNumber">
						<div class="dataTables_paginate paging_bootstrap">
							<ul class="pagination">
								<?php
									
									$this->Paginator->options(array(
					 					'evalScripts' => true,
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
				
				<!-- pagination -->
		</div>
	</div>
</div><!-- /.page-content -->


<script type="text/javascript">
jQuery(function($) {
	if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});
    	
    	}
	$(".chosen-select").chosen();
	/* choosen select*/
						var config = {
							  
							  '.invdrop' : {search_contains:true}
							}
							for (var selector in config) {
							  $(selector).chosen(config[selector]);
						}
					/* choosen select*/
	
});
</script>
<?php echo $this->Js->writeBuffer();?>