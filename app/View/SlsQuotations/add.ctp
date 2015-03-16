<div class="slsQuotations form">
<?php echo $this->Form->create('SlsQuotation'); ?>
	<fieldset>
		<legend><?php echo __('Add Sls Quotation'); ?></legend>
	<?php
		echo $this->Form->input('quotation_no');
		echo $this->Form->input('exchange_rate');
		echo $this->Form->input('description');
		echo $this->Form->input('issue_date');
		echo $this->Form->input('purchase_order_no');
		echo $this->Form->input('expiry_date');
		echo $this->Form->input('status');
		echo $this->Form->input('notes');
		echo $this->Form->input('sub_total');
		echo $this->Form->input('tax_total');
		echo $this->Form->input('func_estimate_total');
		echo $this->Form->input('acr_client_id');
		echo $this->Form->input('sbs_subscriber_id');
		echo $this->Form->input('invoice_amount');
		echo $this->Form->input('invoice_currency_code');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Sls Quotations'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Acr Clients'), array('controller' => 'acr_clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Client'), array('controller' => 'acr_clients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscribers'), array('controller' => 'sbs_subscribers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber'), array('controller' => 'sbs_subscribers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sls Quotation Custom Values'), array('controller' => 'sls_quotation_custom_values', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sls Quotation Custom Value'), array('controller' => 'sls_quotation_custom_values', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sls Quotation Products'), array('controller' => 'sls_quotation_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sls Quotation Product'), array('controller' => 'sls_quotation_products', 'action' => 'add')); ?> </li>
	</ul>
</div>
