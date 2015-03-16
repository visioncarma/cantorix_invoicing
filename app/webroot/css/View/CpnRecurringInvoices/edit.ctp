<div class="cpnRecurringInvoices form">
<?php echo $this->Form->create('CpnRecurringInvoice'); ?>
	<fieldset>
		<legend><?php echo __('Edit Cpn Recurring Invoice'); ?></legend>
	<?php
		echo $this->Form->input('id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('CpnRecurringInvoice.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('CpnRecurringInvoice.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Cpn Recurring Invoices'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Cpn Subscriber Invoice Details'), array('controller' => 'cpn_subscriber_invoice_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Subscriber Invoice Detail'), array('controller' => 'cpn_subscriber_invoice_details', 'action' => 'add')); ?> </li>
	</ul>
</div>
