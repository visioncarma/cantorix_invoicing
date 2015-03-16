<div class="acrClientInvoices view">
<h2><?php echo __('Acr Client Invoice'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($acrClientInvoice['AcrClientInvoice']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice Number'); ?></dt>
		<dd>
			<?php echo h($acrClientInvoice['AcrClientInvoice']['invoice_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($acrClientInvoice['AcrClientInvoice']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoiced Date'); ?></dt>
		<dd>
			<?php echo h($acrClientInvoice['AcrClientInvoice']['invoiced_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Purchase Order No'); ?></dt>
		<dd>
			<?php echo h($acrClientInvoice['AcrClientInvoice']['purchase_order_no']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Due Date'); ?></dt>
		<dd>
			<?php echo h($acrClientInvoice['AcrClientInvoice']['due_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Discount Percent'); ?></dt>
		<dd>
			<?php echo h($acrClientInvoice['AcrClientInvoice']['discount_percent']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($acrClientInvoice['AcrClientInvoice']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Notes'); ?></dt>
		<dd>
			<?php echo h($acrClientInvoice['AcrClientInvoice']['notes']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sub Total'); ?></dt>
		<dd>
			<?php echo h($acrClientInvoice['AcrClientInvoice']['sub_total']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tax Total'); ?></dt>
		<dd>
			<?php echo h($acrClientInvoice['AcrClientInvoice']['tax_total']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Func Currency Total'); ?></dt>
		<dd>
			<?php echo h($acrClientInvoice['AcrClientInvoice']['func_currency_total']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Exchange Rate'); ?></dt>
		<dd>
			<?php echo h($acrClientInvoice['AcrClientInvoice']['exchange_rate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Recurring'); ?></dt>
		<dd>
			<?php echo h($acrClientInvoice['AcrClientInvoice']['recurring']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acr Client'); ?></dt>
		<dd>
			<?php echo $this->Html->link($acrClientInvoice['AcrClient']['id'], array('controller' => 'acr_clients', 'action' => 'view', $acrClientInvoice['AcrClient']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Inv Inventory'); ?></dt>
		<dd>
			<?php echo $this->Html->link($acrClientInvoice['InvInventory']['name'], array('controller' => 'inv_inventories', 'action' => 'view', $acrClientInvoice['InvInventory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sbs Subscriber'); ?></dt>
		<dd>
			<?php echo $this->Html->link($acrClientInvoice['SbsSubscriber']['name'], array('controller' => 'sbs_subscribers', 'action' => 'view', $acrClientInvoice['SbsSubscriber']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sbs Subscriber Payment Term Id'); ?></dt>
		<dd>
			<?php echo h($acrClientInvoice['AcrClientInvoice']['sbs_subscriber_payment_term_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice Total'); ?></dt>
		<dd>
			<?php echo h($acrClientInvoice['AcrClientInvoice']['invoice_total']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice Currency Code'); ?></dt>
		<dd>
			<?php echo h($acrClientInvoice['AcrClientInvoice']['invoice_currency_code']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Acr Client Invoice'), array('action' => 'edit', $acrClientInvoice['AcrClientInvoice']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Acr Client Invoice'), array('action' => 'delete', $acrClientInvoice['AcrClientInvoice']['id']), null, __('Are you sure you want to delete # %s?', $acrClientInvoice['AcrClientInvoice']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Client Invoices'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Client Invoice'), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php echo __('Related Acr Client Recurring Invoices'); ?></h3>
	<?php if (!empty($acrClientInvoice['AcrClientRecurringInvoice'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Next Invoice Date'); ?></th>
		<th><?php echo __('Last Invoice Date'); ?></th>
		<th><?php echo __('Invoice Start Date'); ?></th>
		<th><?php echo __('Invoice End Date'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Payment Cycle'); ?></th>
		<th><?php echo __('Payment Frequency'); ?></th>
		<th><?php echo __('Acr Client Invoice Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($acrClientInvoice['AcrClientRecurringInvoice'] as $acrClientRecurringInvoice): ?>
		<tr>
			<td><?php echo $acrClientRecurringInvoice['id']; ?></td>
			<td><?php echo $acrClientRecurringInvoice['next_invoice_date']; ?></td>
			<td><?php echo $acrClientRecurringInvoice['last_invoice_date']; ?></td>
			<td><?php echo $acrClientRecurringInvoice['invoice_start_date']; ?></td>
			<td><?php echo $acrClientRecurringInvoice['invoice_end_date']; ?></td>
			<td><?php echo $acrClientRecurringInvoice['status']; ?></td>
			<td><?php echo $acrClientRecurringInvoice['payment_cycle']; ?></td>
			<td><?php echo $acrClientRecurringInvoice['payment_frequency']; ?></td>
			<td><?php echo $acrClientRecurringInvoice['acr_client_invoice_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'acr_client_recurring_invoices', 'action' => 'view', $acrClientRecurringInvoice['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'acr_client_recurring_invoices', 'action' => 'edit', $acrClientRecurringInvoice['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'acr_client_recurring_invoices', 'action' => 'delete', $acrClientRecurringInvoice['id']), null, __('Are you sure you want to delete # %s?', $acrClientRecurringInvoice['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Acr Client Recurring Invoice'), array('controller' => 'acr_client_recurring_invoices', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Acr Invoice Custom Values'); ?></h3>
	<?php if (!empty($acrClientInvoice['AcrInvoiceCustomValue'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Data'); ?></th>
		<th><?php echo __('Acr Client Invoice Id'); ?></th>
		<th><?php echo __('Acr Invoice Custom Field Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($acrClientInvoice['AcrInvoiceCustomValue'] as $acrInvoiceCustomValue): ?>
		<tr>
			<td><?php echo $acrInvoiceCustomValue['id']; ?></td>
			<td><?php echo $acrInvoiceCustomValue['data']; ?></td>
			<td><?php echo $acrInvoiceCustomValue['acr_client_invoice_id']; ?></td>
			<td><?php echo $acrInvoiceCustomValue['acr_invoice_custom_field_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'acr_invoice_custom_values', 'action' => 'view', $acrInvoiceCustomValue['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'acr_invoice_custom_values', 'action' => 'edit', $acrInvoiceCustomValue['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'acr_invoice_custom_values', 'action' => 'delete', $acrInvoiceCustomValue['id']), null, __('Are you sure you want to delete # %s?', $acrInvoiceCustomValue['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Acr Invoice Custom Value'), array('controller' => 'acr_invoice_custom_values', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Acr Invoice Details'); ?></h3>
	<?php if (!empty($acrClientInvoice['AcrInvoiceDetail'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Quantity'); ?></th>
		<th><?php echo __('Unit Rate'); ?></th>
		<th><?php echo __('Discount Percent'); ?></th>
		<th><?php echo __('Line Total'); ?></th>
		<th><?php echo __('Acr Client Invoice Id'); ?></th>
		<th><?php echo __('Sbs Subscriber Tax Id'); ?></th>
		<th><?php echo __('Sbs Subscriber Tax Group Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($acrClientInvoice['AcrInvoiceDetail'] as $acrInvoiceDetail): ?>
		<tr>
			<td><?php echo $acrInvoiceDetail['id']; ?></td>
			<td><?php echo $acrInvoiceDetail['quantity']; ?></td>
			<td><?php echo $acrInvoiceDetail['unit_rate']; ?></td>
			<td><?php echo $acrInvoiceDetail['discount_percent']; ?></td>
			<td><?php echo $acrInvoiceDetail['line_total']; ?></td>
			<td><?php echo $acrInvoiceDetail['acr_client_invoice_id']; ?></td>
			<td><?php echo $acrInvoiceDetail['sbs_subscriber_tax_id']; ?></td>
			<td><?php echo $acrInvoiceDetail['sbs_subscriber_tax_group_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'acr_invoice_details', 'action' => 'view', $acrInvoiceDetail['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'acr_invoice_details', 'action' => 'edit', $acrInvoiceDetail['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'acr_invoice_details', 'action' => 'delete', $acrInvoiceDetail['id']), null, __('Are you sure you want to delete # %s?', $acrInvoiceDetail['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Acr Invoice Detail'), array('controller' => 'acr_invoice_details', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Acr Invoice Payment Details'); ?></h3>
	<?php if (!empty($acrClientInvoice['AcrInvoicePaymentDetail'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Payment Method'); ?></th>
		<th><?php echo __('Payment Date'); ?></th>
		<th><?php echo __('Refrence No'); ?></th>
		<th><?php echo __('Notes'); ?></th>
		<th><?php echo __('Send Payment Note'); ?></th>
		<th><?php echo __('Acr Client Id'); ?></th>
		<th><?php echo __('Acr Client Invoice Id'); ?></th>
		<th><?php echo __('Sbs Subscriber Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($acrClientInvoice['AcrInvoicePaymentDetail'] as $acrInvoicePaymentDetail): ?>
		<tr>
			<td><?php echo $acrInvoicePaymentDetail['id']; ?></td>
			<td><?php echo $acrInvoicePaymentDetail['payment_method']; ?></td>
			<td><?php echo $acrInvoicePaymentDetail['payment_date']; ?></td>
			<td><?php echo $acrInvoicePaymentDetail['refrence_no']; ?></td>
			<td><?php echo $acrInvoicePaymentDetail['notes']; ?></td>
			<td><?php echo $acrInvoicePaymentDetail['send_payment_note']; ?></td>
			<td><?php echo $acrInvoicePaymentDetail['acr_client_id']; ?></td>
			<td><?php echo $acrInvoicePaymentDetail['acr_client_invoice_id']; ?></td>
			<td><?php echo $acrInvoicePaymentDetail['sbs_subscriber_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'acr_invoice_payment_details', 'action' => 'view', $acrInvoicePaymentDetail['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'acr_invoice_payment_details', 'action' => 'edit', $acrInvoicePaymentDetail['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'acr_invoice_payment_details', 'action' => 'delete', $acrInvoicePaymentDetail['id']), null, __('Are you sure you want to delete # %s?', $acrInvoicePaymentDetail['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Acr Invoice Payment Detail'), array('controller' => 'acr_invoice_payment_details', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
