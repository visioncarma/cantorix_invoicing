<div class="cpnSubscriberInvoiceDetails view">
<h2><?php echo __('Cpn Subscriber Invoice Detail'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice No'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['invoice_no']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Payment Date'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Payment Amount'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['last_payment_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tax Amount'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['tax_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payment Status'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['payment_status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Txn Type'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['txn_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Txn Id'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['txn_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Next Payment Date'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['next_payment_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Outstanding Balance'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['outstanding_balance']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payment Fee'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['payment_fee']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Time Created'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['time_created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sbs Subscriber'); ?></dt>
		<dd>
			<?php echo $this->Html->link($cpnSubscriberInvoiceDetail['SbsSubscriber']['name'], array('controller' => 'sbs_subscribers', 'action' => 'view', $cpnSubscriberInvoiceDetail['SbsSubscriber']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Cpn Subscriber Invoice Detail'), array('action' => 'edit', $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Cpn Subscriber Invoice Detail'), array('action' => 'delete', $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['id']), null, __('Are you sure you want to delete # %s?', $cpnSubscriberInvoiceDetail['CpnSubscriberInvoiceDetail']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Cpn Subscriber Invoice Details'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Subscriber Invoice Detail'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscribers'), array('controller' => 'sbs_subscribers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber'), array('controller' => 'sbs_subscribers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cpn Recurring Invoices'), array('controller' => 'cpn_recurring_invoices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Recurring Invoice'), array('controller' => 'cpn_recurring_invoices', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Cpn Recurring Invoices'); ?></h3>
	<?php if (!empty($cpnSubscriberInvoiceDetail['CpnRecurringInvoice'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($cpnSubscriberInvoiceDetail['CpnRecurringInvoice'] as $cpnRecurringInvoice): ?>
		<tr>
			<td><?php echo $cpnRecurringInvoice['id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'cpn_recurring_invoices', 'action' => 'view', $cpnRecurringInvoice['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'cpn_recurring_invoices', 'action' => 'edit', $cpnRecurringInvoice['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'cpn_recurring_invoices', 'action' => 'delete', $cpnRecurringInvoice['id']), null, __('Are you sure you want to delete # %s?', $cpnRecurringInvoice['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Cpn Recurring Invoice'), array('controller' => 'cpn_recurring_invoices', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
