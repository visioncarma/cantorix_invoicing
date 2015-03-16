<div class="slsQuotations index">
	<h2><?php echo __('Sls Quotations'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('quotation_no'); ?></th>
			<th><?php echo $this->Paginator->sort('exchange_rate'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('issue_date'); ?></th>
			<th><?php echo $this->Paginator->sort('purchase_order_no'); ?></th>
			<th><?php echo $this->Paginator->sort('expiry_date'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('notes'); ?></th>
			<th><?php echo $this->Paginator->sort('sub_total'); ?></th>
			<th><?php echo $this->Paginator->sort('tax_total'); ?></th>
			<th><?php echo $this->Paginator->sort('func_estimate_total'); ?></th>
			<th><?php echo $this->Paginator->sort('acr_client_id'); ?></th>
			<th><?php echo $this->Paginator->sort('sbs_subscriber_id'); ?></th>
			<th><?php echo $this->Paginator->sort('invoice_amount'); ?></th>
			<th><?php echo $this->Paginator->sort('invoice_currency_code'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($slsQuotations as $slsQuotation): ?>
	<tr>
		<td><?php echo h($slsQuotation['SlsQuotation']['id']); ?>&nbsp;</td>
		<td><?php echo h($slsQuotation['SlsQuotation']['quotation_no']); ?>&nbsp;</td>
		<td><?php echo h($slsQuotation['SlsQuotation']['exchange_rate']); ?>&nbsp;</td>
		<td><?php echo h($slsQuotation['SlsQuotation']['description']); ?>&nbsp;</td>
		<td><?php echo h($slsQuotation['SlsQuotation']['issue_date']); ?>&nbsp;</td>
		<td><?php echo h($slsQuotation['SlsQuotation']['purchase_order_no']); ?>&nbsp;</td>
		<td><?php echo h($slsQuotation['SlsQuotation']['expiry_date']); ?>&nbsp;</td>
		<td><?php echo h($slsQuotation['SlsQuotation']['status']); ?>&nbsp;</td>
		<td><?php echo h($slsQuotation['SlsQuotation']['notes']); ?>&nbsp;</td>
		<td><?php echo h($slsQuotation['SlsQuotation']['sub_total']); ?>&nbsp;</td>
		<td><?php echo h($slsQuotation['SlsQuotation']['tax_total']); ?>&nbsp;</td>
		<td><?php echo h($slsQuotation['SlsQuotation']['func_estimate_total']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($slsQuotation['AcrClient']['id'], array('controller' => 'acr_clients', 'action' => 'view', $slsQuotation['AcrClient']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($slsQuotation['SbsSubscriber']['name'], array('controller' => 'sbs_subscribers', 'action' => 'view', $slsQuotation['SbsSubscriber']['id'])); ?>
		</td>
		<td><?php echo h($slsQuotation['SlsQuotation']['invoice_amount']); ?>&nbsp;</td>
		<td><?php echo h($slsQuotation['SlsQuotation']['invoice_currency_code']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $slsQuotation['SlsQuotation']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $slsQuotation['SlsQuotation']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $slsQuotation['SlsQuotation']['id']), null, __('Are you sure you want to delete # %s?', $slsQuotation['SlsQuotation']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Sls Quotation'), array('action' => 'add')); ?></li>
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
