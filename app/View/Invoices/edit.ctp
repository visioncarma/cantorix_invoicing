<div class="acrClientInvoices form">
<?php echo $this->Form->create('AcrClientInvoice'); ?>
	<fieldset>
		<legend><?php echo __('Edit Acr Client Invoice'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('invoice_number');
		echo $this->Form->input('description');
		echo $this->Form->input('invoiced_date');
		echo $this->Form->input('purchase_order_no');
		echo $this->Form->input('due_date');
		echo $this->Form->input('discount_percent');
		echo $this->Form->input('status');
		echo $this->Form->input('notes');
		echo $this->Form->input('sub_total');
		echo $this->Form->input('tax_total');
		echo $this->Form->input('func_currency_total');
		echo $this->Form->input('exchange_rate');
		echo $this->Form->input('recurring');
		echo $this->Form->input('acr_client_id');
		echo $this->Form->input('inv_inventory_id');
		echo $this->Form->input('sbs_subscriber_id');
		echo $this->Form->input('sbs_subscriber_payment_term_id');
		echo $this->Form->input('invoice_total');
		echo $this->Form->input('invoice_currency_code');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('AcrClientInvoice.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('AcrClientInvoice.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Acr Client Invoices'), array('action' => 'index')); ?></li>
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
</div>
