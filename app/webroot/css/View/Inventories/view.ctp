<div class="invInventories view">
<h2><?php echo __('Inv Inventory'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($invInventory['InvInventory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($invInventory['InvInventory']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($invInventory['InvInventory']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('List Price'); ?></dt>
		<dd>
			<?php echo h($invInventory['InvInventory']['list_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Track Quantity'); ?></dt>
		<dd>
			<?php echo h($invInventory['InvInventory']['track_quantity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Current Stock'); ?></dt>
		<dd>
			<?php echo h($invInventory['InvInventory']['current_stock']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sbs Subscriber'); ?></dt>
		<dd>
			<?php echo $this->Html->link($invInventory['SbsSubscriber']['name'], array('controller' => 'sbs_subscribers', 'action' => 'view', $invInventory['SbsSubscriber']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Inv Inventory'), array('action' => 'edit', $invInventory['InvInventory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Inv Inventory'), array('action' => 'delete', $invInventory['InvInventory']['id']), null, __('Are you sure you want to delete # %s?', $invInventory['InvInventory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Inv Inventories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inv Inventory'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscribers'), array('controller' => 'sbs_subscribers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber'), array('controller' => 'sbs_subscribers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acp Inventory Expenses'), array('controller' => 'acp_inventory_expenses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acp Inventory Expense'), array('controller' => 'acp_inventory_expenses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Client Invoices'), array('controller' => 'acr_client_invoices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Client Invoice'), array('controller' => 'acr_client_invoices', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sls Quotation Products'), array('controller' => 'sls_quotation_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sls Quotation Product'), array('controller' => 'sls_quotation_products', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Acp Inventory Expenses'); ?></h3>
	<?php if (!empty($invInventory['AcpInventoryExpense'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Quantity'); ?></th>
		<th><?php echo __('Cost Price'); ?></th>
		<th><?php echo __('Total Amount'); ?></th>
		<th><?php echo __('Func Curr Amount'); ?></th>
		<th><?php echo __('Due Date'); ?></th>
		<th><?php echo __('Transaction Id'); ?></th>
		<th><?php echo __('Inv Inventory Id'); ?></th>
		<th><?php echo __('Acp Expense Id'); ?></th>
		<th><?php echo __('Sbs Subscriber Id'); ?></th>
		<th><?php echo __('Invoice Amount'); ?></th>
		<th><?php echo __('Invoice Currency Code'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($invInventory['AcpInventoryExpense'] as $acpInventoryExpense): ?>
		<tr>
			<td><?php echo $acpInventoryExpense['id']; ?></td>
			<td><?php echo $acpInventoryExpense['quantity']; ?></td>
			<td><?php echo $acpInventoryExpense['cost_price']; ?></td>
			<td><?php echo $acpInventoryExpense['total_amount']; ?></td>
			<td><?php echo $acpInventoryExpense['func_curr_amount']; ?></td>
			<td><?php echo $acpInventoryExpense['due_date']; ?></td>
			<td><?php echo $acpInventoryExpense['transaction_id']; ?></td>
			<td><?php echo $acpInventoryExpense['inv_inventory_id']; ?></td>
			<td><?php echo $acpInventoryExpense['acp_expense_id']; ?></td>
			<td><?php echo $acpInventoryExpense['sbs_subscriber_id']; ?></td>
			<td><?php echo $acpInventoryExpense['invoice_amount']; ?></td>
			<td><?php echo $acpInventoryExpense['invoice_currency_code']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'acp_inventory_expenses', 'action' => 'view', $acpInventoryExpense['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'acp_inventory_expenses', 'action' => 'edit', $acpInventoryExpense['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'acp_inventory_expenses', 'action' => 'delete', $acpInventoryExpense['id']), null, __('Are you sure you want to delete # %s?', $acpInventoryExpense['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Acp Inventory Expense'), array('controller' => 'acp_inventory_expenses', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Acr Client Invoices'); ?></h3>
	<?php if (!empty($invInventory['AcrClientInvoice'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Invoice Number'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Invoiced Date'); ?></th>
		<th><?php echo __('Purchase Order No'); ?></th>
		<th><?php echo __('Due Date'); ?></th>
		<th><?php echo __('Terms'); ?></th>
		<th><?php echo __('Discount Percent'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Notes'); ?></th>
		<th><?php echo __('Sub Total'); ?></th>
		<th><?php echo __('Tax Total'); ?></th>
		<th><?php echo __('Func Currency Total'); ?></th>
		<th><?php echo __('Exchange Rate'); ?></th>
		<th><?php echo __('Recurring'); ?></th>
		<th><?php echo __('Acr Client Id'); ?></th>
		<th><?php echo __('Inv Inventory Id'); ?></th>
		<th><?php echo __('Sbs Subscriber Id'); ?></th>
		<th><?php echo __('Invoice Total'); ?></th>
		<th><?php echo __('Invoice Currency Code'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($invInventory['AcrClientInvoice'] as $acrClientInvoice): ?>
		<tr>
			<td><?php echo $acrClientInvoice['id']; ?></td>
			<td><?php echo $acrClientInvoice['invoice_number']; ?></td>
			<td><?php echo $acrClientInvoice['description']; ?></td>
			<td><?php echo $acrClientInvoice['invoiced_date']; ?></td>
			<td><?php echo $acrClientInvoice['purchase_order_no']; ?></td>
			<td><?php echo $acrClientInvoice['due_date']; ?></td>
			<td><?php echo $acrClientInvoice['terms']; ?></td>
			<td><?php echo $acrClientInvoice['discount_percent']; ?></td>
			<td><?php echo $acrClientInvoice['status']; ?></td>
			<td><?php echo $acrClientInvoice['notes']; ?></td>
			<td><?php echo $acrClientInvoice['sub_total']; ?></td>
			<td><?php echo $acrClientInvoice['tax_total']; ?></td>
			<td><?php echo $acrClientInvoice['func_currency_total']; ?></td>
			<td><?php echo $acrClientInvoice['exchange_rate']; ?></td>
			<td><?php echo $acrClientInvoice['recurring']; ?></td>
			<td><?php echo $acrClientInvoice['acr_client_id']; ?></td>
			<td><?php echo $acrClientInvoice['inv_inventory_id']; ?></td>
			<td><?php echo $acrClientInvoice['sbs_subscriber_id']; ?></td>
			<td><?php echo $acrClientInvoice['invoice_total']; ?></td>
			<td><?php echo $acrClientInvoice['invoice_currency_code']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'acr_client_invoices', 'action' => 'view', $acrClientInvoice['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'acr_client_invoices', 'action' => 'edit', $acrClientInvoice['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'acr_client_invoices', 'action' => 'delete', $acrClientInvoice['id']), null, __('Are you sure you want to delete # %s?', $acrClientInvoice['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Acr Client Invoice'), array('controller' => 'acr_client_invoices', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Sls Quotation Products'); ?></h3>
	<?php if (!empty($invInventory['SlsQuotationProduct'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Quantity'); ?></th>
		<th><?php echo __('Unit Rate'); ?></th>
		<th><?php echo __('Discount Percent'); ?></th>
		<th><?php echo __('Line Total'); ?></th>
		<th><?php echo __('Sls Quotation Id'); ?></th>
		<th><?php echo __('Inv Inventory Id'); ?></th>
		<th><?php echo __('Sbs Subscriber Tax Id'); ?></th>
		<th><?php echo __('Sbs Subscriber Tax Group Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($invInventory['SlsQuotationProduct'] as $slsQuotationProduct): ?>
		<tr>
			<td><?php echo $slsQuotationProduct['id']; ?></td>
			<td><?php echo $slsQuotationProduct['quantity']; ?></td>
			<td><?php echo $slsQuotationProduct['unit_rate']; ?></td>
			<td><?php echo $slsQuotationProduct['discount_percent']; ?></td>
			<td><?php echo $slsQuotationProduct['line_total']; ?></td>
			<td><?php echo $slsQuotationProduct['sls_quotation_id']; ?></td>
			<td><?php echo $slsQuotationProduct['inv_inventory_id']; ?></td>
			<td><?php echo $slsQuotationProduct['sbs_subscriber_tax_id']; ?></td>
			<td><?php echo $slsQuotationProduct['sbs_subscriber_tax_group_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'sls_quotation_products', 'action' => 'view', $slsQuotationProduct['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'sls_quotation_products', 'action' => 'edit', $slsQuotationProduct['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'sls_quotation_products', 'action' => 'delete', $slsQuotationProduct['id']), null, __('Are you sure you want to delete # %s?', $slsQuotationProduct['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Sls Quotation Product'), array('controller' => 'sls_quotation_products', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
