<div class="slsQuotations view">
<h2><?php echo __('Sls Quotation'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($slsQuotation['SlsQuotation']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Quotation No'); ?></dt>
		<dd>
			<?php echo h($slsQuotation['SlsQuotation']['quotation_no']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Exchange Rate'); ?></dt>
		<dd>
			<?php echo h($slsQuotation['SlsQuotation']['exchange_rate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($slsQuotation['SlsQuotation']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Issue Date'); ?></dt>
		<dd>
			<?php echo h($slsQuotation['SlsQuotation']['issue_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Purchase Order No'); ?></dt>
		<dd>
			<?php echo h($slsQuotation['SlsQuotation']['purchase_order_no']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Expiry Date'); ?></dt>
		<dd>
			<?php echo h($slsQuotation['SlsQuotation']['expiry_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($slsQuotation['SlsQuotation']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Notes'); ?></dt>
		<dd>
			<?php echo h($slsQuotation['SlsQuotation']['notes']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sub Total'); ?></dt>
		<dd>
			<?php echo h($slsQuotation['SlsQuotation']['sub_total']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tax Total'); ?></dt>
		<dd>
			<?php echo h($slsQuotation['SlsQuotation']['tax_total']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Func Estimate Total'); ?></dt>
		<dd>
			<?php echo h($slsQuotation['SlsQuotation']['func_estimate_total']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acr Client'); ?></dt>
		<dd>
			<?php echo $this->Html->link($slsQuotation['AcrClient']['id'], array('controller' => 'acr_clients', 'action' => 'view', $slsQuotation['AcrClient']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sbs Subscriber'); ?></dt>
		<dd>
			<?php echo $this->Html->link($slsQuotation['SbsSubscriber']['name'], array('controller' => 'sbs_subscribers', 'action' => 'view', $slsQuotation['SbsSubscriber']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice Amount'); ?></dt>
		<dd>
			<?php echo h($slsQuotation['SlsQuotation']['invoice_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice Currency Code'); ?></dt>
		<dd>
			<?php echo h($slsQuotation['SlsQuotation']['invoice_currency_code']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Sls Quotation'), array('action' => 'edit', $slsQuotation['SlsQuotation']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Sls Quotation'), array('action' => 'delete', $slsQuotation['SlsQuotation']['id']), null, __('Are you sure you want to delete # %s?', $slsQuotation['SlsQuotation']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sls Quotations'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sls Quotation'), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php echo __('Related Sls Quotation Custom Values'); ?></h3>
	<?php if (!empty($slsQuotation['SlsQuotationCustomValue'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Data'); ?></th>
		<th><?php echo __('Sls Quotation Custom Field Id'); ?></th>
		<th><?php echo __('Sls Quotation Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($slsQuotation['SlsQuotationCustomValue'] as $slsQuotationCustomValue): ?>
		<tr>
			<td><?php echo $slsQuotationCustomValue['id']; ?></td>
			<td><?php echo $slsQuotationCustomValue['data']; ?></td>
			<td><?php echo $slsQuotationCustomValue['sls_quotation_custom_field_id']; ?></td>
			<td><?php echo $slsQuotationCustomValue['sls_quotation_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'sls_quotation_custom_values', 'action' => 'view', $slsQuotationCustomValue['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'sls_quotation_custom_values', 'action' => 'edit', $slsQuotationCustomValue['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'sls_quotation_custom_values', 'action' => 'delete', $slsQuotationCustomValue['id']), null, __('Are you sure you want to delete # %s?', $slsQuotationCustomValue['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Sls Quotation Custom Value'), array('controller' => 'sls_quotation_custom_values', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Sls Quotation Products'); ?></h3>
	<?php if (!empty($slsQuotation['SlsQuotationProduct'])): ?>
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
	<?php foreach ($slsQuotation['SlsQuotationProduct'] as $slsQuotationProduct): ?>
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
