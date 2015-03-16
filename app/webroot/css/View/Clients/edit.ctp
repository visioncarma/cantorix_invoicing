<div class="acrClients form">
<?php echo $this->Form->create('AcrClient'); ?>
	<fieldset>
		<legend><?php echo __('Update Client Information'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('client_no');
		echo $this->Form->input('client_name');
		echo $this->Form->input('billing_address_line1');
		echo $this->Form->input('billing_address_line2');
		echo $this->Form->input('billing_city');
		echo $this->Form->input('billing_state');
		echo $this->Form->input('billing_country');
		echo $this->Form->input('billing_zip');
		echo $this->Form->input('shiping_address_line1');
		echo $this->Form->input('shipping_address_line2');
		echo $this->Form->input('shipping_city');
		echo $this->Form->input('shipping_state');
		echo $this->Form->input('shipping_country');
		echo $this->Form->input('shipping_zip');
		echo $this->Form->input('website');
		echo $this->Form->input('business_phone');
		echo $this->Form->input('business_fax');
		echo $this->Form->input('notes');
		echo $this->Form->input('status',array('options'=>array('active'=>'Active','inactive'=>'Inactive')));
		echo $this->Form->input('send_invoice_by',array('options'=>array(''=>'Select Notification Method','email'=>'Email','snail_mail'=>'Snail Mail','others'=>'Others')));
		echo $this->Form->input('cpn_language_id');
		echo $this->Form->input('cpn_currency_id');
		echo $this->Form->input('sbs_subscriber_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('AcrClient.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('AcrClient.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Acr Clients'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Cpn Languages'), array('controller' => 'cpn_languages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Language'), array('controller' => 'cpn_languages', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cpn Currencies'), array('controller' => 'cpn_currencies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Currency'), array('controller' => 'cpn_currencies', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscribers'), array('controller' => 'sbs_subscribers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber'), array('controller' => 'sbs_subscribers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Client Contacts'), array('controller' => 'acr_client_contacts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Client Contact'), array('controller' => 'acr_client_contacts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Client Custom Values'), array('controller' => 'acr_client_custom_values', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Client Custom Value'), array('controller' => 'acr_client_custom_values', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Client Invoices'), array('controller' => 'acr_client_invoices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Client Invoice'), array('controller' => 'acr_client_invoices', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Inventory Invoices'), array('controller' => 'acr_inventory_invoices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Inventory Invoice'), array('controller' => 'acr_inventory_invoices', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Invoice Payment Details'), array('controller' => 'acr_invoice_payment_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Invoice Payment Detail'), array('controller' => 'acr_invoice_payment_details', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sls Quotations'), array('controller' => 'sls_quotations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sls Quotation'), array('controller' => 'sls_quotations', 'action' => 'add')); ?> </li>
	</ul>
</div>
