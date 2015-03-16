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
					<?php echo $this->Form->create('invoiceFilter',array('id'=>'invoiceFilter'));?>
					<div class="form-group filed-left margin-bottom-zero">
						<input id="form-field-1"  type="text" placeholder="Company Name" />
					</div>
					<div class="form-group filed-left margin-bottom-zero">
						<input id="form-field-1"  type="text" placeholder="Subscriber Name" />
					</div>
					<div class="form-group filed-left margin-bottom-zero">
						<select class="chosen-select"  data-placeholder="Role">
							<option value="">Status</option>
							<option value="1">Paid</option>
							<option value="2">Due</option>
						</select>
					</div>
					<div class="form-group filed-left margin-bottom-zero">
						<button class="btn btn-sm btn-primary filter-btn">
							Filter
						</button>
					</div>
					<?php echo $this->Form->end(); ?>
				</div>

				<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
					<thead>
						<tr>
							<th><label>
								<input class="ace" type="checkbox">
								<span class="lbl"></span> </label></th>
							<th><?php echo $this->Paginator->sort('sbs_subscriber_id','Subscriber Name');?></th>
							<th><?php echo $this->Paginator->sort('invoice_number','Invoice Number');?></th>
							<th><?php echo $this->Paginator->sort('acr_client_id','Company Name');?></th>
							<th><?php echo $this->Paginator->sort('invoiced_date','Invoice Issued Date');?></th>
							<th><?php echo $this->Paginator->sort('invoice_total','Invoice Value');?></th>
							<th><?php echo $this->Paginator->sort('status','Status');?></th>
							<th><?php echo __('Action');?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($acrClientInvoices as $acrClientInvoice):?>
						<tr>
							<td><span class=""> <label>
									<input class="ace delete-m-row" type="checkbox">
									<span class="lbl"></span> </label> </span></td>
							<td><span class="on-load">John Samuel</span>
							<input type="text" placeholder="Name" class="on-edit" />
							</td>
							<td><span class="on-load">INV128</span>
							<input type="text" placeholder="Invoice Number" class="on-edit" />
							</td>
							<td><span class="on-load">Carmatec</span>
							<input type="text" placeholder="Company Name" class="on-edit" />
							</td>
							<td><span class="on-load">12-05-2013</span>
							<input type="text" placeholder="Issued Date" class="on-edit" />
							</td>
							<td><span class="on-load">$125</span>
							<input type="text" placeholder="Invoice Value" class="on-edit" />
							</td>
							<td><span class="on-load paid">Paid</span>
							<select class="on-edit"  data-placeholder="Role">
								<option value="">Status</option>
								<option value="1">Paid</option>
								<option value="2">Due</option>
							</select></td>
							<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
								<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
								<button class="btn btn-xs submit" title="submit">
									<i class="icon-ok bigger-120"></i>
								</button>
								<button class="btn btn-xs close-action" title="close">
									<i class="icon-remove bigger-120"></i>
								</button> </a>
								<button class="btn btn-xs btn-success view on-load" title="view" data-toggle="modal" data-target="#viewuser">
									<i class="icon-zoom-in bigger-120"></i>
								</button>

								<button class="btn btn-xs btn-info edit edit-row on-load" title="edit">
									<i class="icon-edit bigger-120"></i>
								</button>
								<button class="btn btn-xs btn-danger delete on-load delete-row" title="delete">
									<i class="icon-trash bigger-120"></i>
								</button>
							</div></td>
						</tr>
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
												'url' => array('controller'=>'Currencies','action'=>'index',$filterBy,$value),
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
<!--Popup add  -->
<div class="modal fade" id="addnewuser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="icon-remove"></i>
				</button>
				<h1 class="modal-title" id="myModalLabel">Add New User</h1>
			</div>
			<form class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
				<div class="modal-body">
					<div class="model-body-inner-content">
						<div class="form-group login-form-group">
							<p>
								Each user you add will receive an email inviting them to log in.
							</p>
						</div>
						<div class="form-group login-form-group">
							<label class="col-sm-4 control-label">Role </label>
							<div class="col-sm-8">
								<select class="form-control">
									<option value="">Role</option>
									<option value="1">Role 1</option>
									<option value="2">Role 2</option>
									<option value="3">Role 3</option>
								</select>
							</div>
						</div>
						<div class="form-group login-form-group">
							<label class="col-sm-4 control-label"> First Name </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="firstname" placeholder="First Name">
							</div>
						</div>
						<div class="form-group login-form-group">
							<label class="col-sm-4 control-label"> Last Name </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="lastname" placeholder="last Name">
							</div>
						</div>
						<div class="form-group login-form-group">
							<label class="col-sm-4 control-label"> Email </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="email" placeholder="Email">
							</div>
						</div>

					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-info" type="button">
						<i class="icon-ok bigger-110"></i>
						Submit
					</button>

					&nbsp; &nbsp; &nbsp;
					<button class="btn" type="button">
						<i class="icon-remove bigger-110"></i>
						Cancel
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--end of pop-->

<!--Popup veiw  -->
<div class="modal fade" id="viewuser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="icon-remove"></i>
				</button>
				<h1 class="modal-title" id="myModalLabel">View User</h1>
			</div>
			<form class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
				<div class="modal-body">
					<div class="model-body-inner-content">

						<div class="form-group login-form-group">
							<label class="col-sm-4 no-padding-top">User Name </label>
							<div class="col-sm-8">
								<p class="bold">
									John
								</p>
							</div>
						</div>
						<div class="form-group login-form-group">
							<label class="col-sm-4 no-padding-top"> Email </label>
							<div class="col-sm-8">
								<p class="bold">
									john@gmail.com
								</p>
							</div>
						</div>
						<div class="form-group login-form-group">
							<label class="col-sm-4 no-padding-top"> Role</label>
							<div class="col-sm-8">
								<p class="bold">
									Administrator
								</p>
							</div>
						</div>
						<div class="form-group login-form-group">
							<label class="col-sm-4 no-padding-top"> Active </label>
							<div class="col-sm-8">
								<p class="bold">
									Yes
								</p>
							</div>
						</div>

					</div>
				</div>
				<div class="modal-footer">

				</div>
			</form>
		</div>
	</div>
</div>
<!--end of pop-->




<!--<div class="acrClientInvoices index">
	<h2><?php echo __('Acr Client Invoices'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('invoice_number'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('invoiced_date'); ?></th>
			<th><?php echo $this->Paginator->sort('purchase_order_no'); ?></th>
			<th><?php echo $this->Paginator->sort('due_date'); ?></th>
			<th><?php echo $this->Paginator->sort('discount_percent'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('notes'); ?></th>
			<th><?php echo $this->Paginator->sort('sub_total'); ?></th>
			<th><?php echo $this->Paginator->sort('tax_total'); ?></th>
			<th><?php echo $this->Paginator->sort('func_currency_total'); ?></th>
			<th><?php echo $this->Paginator->sort('exchange_rate'); ?></th>
			<th><?php echo $this->Paginator->sort('recurring'); ?></th>
			<th><?php echo $this->Paginator->sort('acr_client_id'); ?></th>
			<th><?php echo $this->Paginator->sort('inv_inventory_id'); ?></th>
			<th><?php echo $this->Paginator->sort('sbs_subscriber_id'); ?></th>
			<th><?php echo $this->Paginator->sort('sbs_subscriber_payment_term_id'); ?></th>
			<th><?php echo $this->Paginator->sort('invoice_total'); ?></th>
			<th><?php echo $this->Paginator->sort('invoice_currency_code'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($acrClientInvoices as $acrClientInvoice): ?>
	<tr>
		<td><?php echo h($acrClientInvoice['AcrClientInvoice']['id']); ?>&nbsp;</td>
		<td><?php echo h($acrClientInvoice['AcrClientInvoice']['invoice_number']); ?>&nbsp;</td>
		<td><?php echo h($acrClientInvoice['AcrClientInvoice']['description']); ?>&nbsp;</td>
		<td><?php echo h($acrClientInvoice['AcrClientInvoice']['invoiced_date']); ?>&nbsp;</td>
		<td><?php echo h($acrClientInvoice['AcrClientInvoice']['purchase_order_no']); ?>&nbsp;</td>
		<td><?php echo h($acrClientInvoice['AcrClientInvoice']['due_date']); ?>&nbsp;</td>
		<td><?php echo h($acrClientInvoice['AcrClientInvoice']['discount_percent']); ?>&nbsp;</td>
		<td><?php echo h($acrClientInvoice['AcrClientInvoice']['status']); ?>&nbsp;</td>
		<td><?php echo h($acrClientInvoice['AcrClientInvoice']['notes']); ?>&nbsp;</td>
		<td><?php echo h($acrClientInvoice['AcrClientInvoice']['sub_total']); ?>&nbsp;</td>
		<td><?php echo h($acrClientInvoice['AcrClientInvoice']['tax_total']); ?>&nbsp;</td>
		<td><?php echo h($acrClientInvoice['AcrClientInvoice']['func_currency_total']); ?>&nbsp;</td>
		<td><?php echo h($acrClientInvoice['AcrClientInvoice']['exchange_rate']); ?>&nbsp;</td>
		<td><?php echo h($acrClientInvoice['AcrClientInvoice']['recurring']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($acrClientInvoice['AcrClient']['id'], array('controller' => 'acr_clients', 'action' => 'view', $acrClientInvoice['AcrClient']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($acrClientInvoice['InvInventory']['name'], array('controller' => 'inv_inventories', 'action' => 'view', $acrClientInvoice['InvInventory']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($acrClientInvoice['SbsSubscriber']['name'], array('controller' => 'sbs_subscribers', 'action' => 'view', $acrClientInvoice['SbsSubscriber']['id'])); ?>
		</td>
		<td><?php echo h($acrClientInvoice['AcrClientInvoice']['sbs_subscriber_payment_term_id']); ?>&nbsp;</td>
		<td><?php echo h($acrClientInvoice['AcrClientInvoice']['invoice_total']); ?>&nbsp;</td>
		<td><?php echo h($acrClientInvoice['AcrClientInvoice']['invoice_currency_code']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $acrClientInvoice['AcrClientInvoice']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $acrClientInvoice['AcrClientInvoice']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $acrClientInvoice['AcrClientInvoice']['id']), null, __('Are you sure you want to delete # %s?', $acrClientInvoice['AcrClientInvoice']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Acr Client Invoice'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Acr Clients'), array('controller' => 'acr_clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Client'), array('controller' => 'acr_clients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Inv Inventories'), array('controller' => 'inv_inventories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inv Inventory'), array('controller' => 'inv_inventories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscribers'), array('controller' => 'sbs_subscribers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber'), array('controller' => 'sbs_subscribers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Client Recurring Invoices'), array('controller' => 'acr_client_recurring_invoices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Client Recurring Invoice'), array('controller' => 'acr_client_recurring_invoices', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Invoice Custom Values'), array('controller' => 'acr_invoice_custom_values', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Invoice Custom Value'), array('controller' => 'acr_invoice_custom_values', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Invoice Details'), array('controller' => 'acr_invoice_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Invoice Detail'), array('controller' => 'acr_invoice_details', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Invoice Payment Details'), array('controller' => 'acr_invoice_payment_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Invoice Payment Detail'), array('controller' => 'acr_invoice_payment_details', 'action' => 'add')); ?> </li>
	</ul>
</div>-->
