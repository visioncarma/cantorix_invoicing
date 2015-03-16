<div class="cpnSubscriberInvoiceDetails form">
<?php echo $this->Form->create('CpnSubscriberInvoiceDetail'); ?>
	<fieldset>
		<legend><?php echo __('Edit Cpn Subscriber Invoice Detail'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('invoice_no');
		echo $this->Form->input('last_payment_date');
		echo $this->Form->input('last_payment_amount');
		echo $this->Form->input('tax_amount');
		echo $this->Form->input('payment_status');
		echo $this->Form->input('txn_type');
		echo $this->Form->input('txn_id');
		echo $this->Form->input('next_payment_date');
		echo $this->Form->input('outstanding_balance');
		echo $this->Form->input('payment_fee');
		echo $this->Form->input('time_created');
		echo $this->Form->input('sbs_subscriber_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('CpnSubscriberInvoiceDetail.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('CpnSubscriberInvoiceDetail.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Cpn Subscriber Invoice Details'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Sbs Subscribers'), array('controller' => 'sbs_subscribers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber'), array('controller' => 'sbs_subscribers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cpn Recurring Invoices'), array('controller' => 'cpn_recurring_invoices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Recurring Invoice'), array('controller' => 'cpn_recurring_invoices', 'action' => 'add')); ?> </li>
	</ul>
</div>
