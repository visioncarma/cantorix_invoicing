<div class="cpnRecurringInvoices view">
<h2><?php echo __('Cpn Recurring Invoice'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($cpnRecurringInvoice['CpnRecurringInvoice']['id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Cpn Recurring Invoice'), array('action' => 'edit', $cpnRecurringInvoice['CpnRecurringInvoice']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Cpn Recurring Invoice'), array('action' => 'delete', $cpnRecurringInvoice['CpnRecurringInvoice']['id']), null, __('Are you sure you want to delete # %s?', $cpnRecurringInvoice['CpnRecurringInvoice']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Cpn Recurring Invoices'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Recurring Invoice'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cpn Subscriber Invoice Details'), array('controller' => 'cpn_subscriber_invoice_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Subscriber Invoice Detail'), array('controller' => 'cpn_subscriber_invoice_details', 'action' => 'add')); ?> </li>
	</ul>
</div>
