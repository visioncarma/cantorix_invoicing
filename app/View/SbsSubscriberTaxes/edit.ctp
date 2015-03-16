<div class="sbsSubscriberTaxes form">
<?php echo $this->Form->create('SbsSubscriberTax'); ?>
	<fieldset>
		<legend><?php echo __('Edit Sbs Subscriber Tax'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('code');
		echo $this->Form->input('percent');
		echo $this->Form->input('sbs_subscriber_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('SbsSubscriberTax.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('SbsSubscriberTax.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Sbs Subscriber Taxes'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Sbs Subscribers'), array('controller' => 'sbs_subscribers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber'), array('controller' => 'sbs_subscribers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Invoice Details'), array('controller' => 'acr_invoice_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Invoice Detail'), array('controller' => 'acr_invoice_details', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscriber Tax Group Mappings'), array('controller' => 'sbs_subscriber_tax_group_mappings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber Tax Group Mapping'), array('controller' => 'sbs_subscriber_tax_group_mappings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sls Quotation Products'), array('controller' => 'sls_quotation_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sls Quotation Product'), array('controller' => 'sls_quotation_products', 'action' => 'add')); ?> </li>
	</ul>
</div>
