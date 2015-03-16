<div class="sbsSubscriberTaxGroups view">
<h2><?php echo __('Sbs Subscriber Tax Group'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($sbsSubscriberTaxGroup['SbsSubscriberTaxGroup']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group Name'); ?></dt>
		<dd>
			<?php echo h($sbsSubscriberTaxGroup['SbsSubscriberTaxGroup']['group_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Compounded'); ?></dt>
		<dd>
			<?php echo h($sbsSubscriberTaxGroup['SbsSubscriberTaxGroup']['compounded']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sbs Subscriber'); ?></dt>
		<dd>
			<?php echo $this->Html->link($sbsSubscriberTaxGroup['SbsSubscriber']['name'], array('controller' => 'sbs_subscribers', 'action' => 'view', $sbsSubscriberTaxGroup['SbsSubscriber']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Sbs Subscriber Tax Group'), array('action' => 'edit', $sbsSubscriberTaxGroup['SbsSubscriberTaxGroup']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Sbs Subscriber Tax Group'), array('action' => 'delete', $sbsSubscriberTaxGroup['SbsSubscriberTaxGroup']['id']), null, __('Are you sure you want to delete # %s?', $sbsSubscriberTaxGroup['SbsSubscriberTaxGroup']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscriber Tax Groups'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber Tax Group'), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php echo __('Related Acr Invoice Details'); ?></h3>
	<?php if (!empty($sbsSubscriberTaxGroup['AcrInvoiceDetail'])): ?>
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
	<?php foreach ($sbsSubscriberTaxGroup['AcrInvoiceDetail'] as $acrInvoiceDetail): ?>
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
	<h3><?php echo __('Related Sbs Subscriber Tax Group Mappings'); ?></h3>
	<?php if (!empty($sbsSubscriberTaxGroup['SbsSubscriberTaxGroupMapping'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Priority'); ?></th>
		<th><?php echo __('Sbs Subscriber Tax Id'); ?></th>
		<th><?php echo __('Sbs Subscriber Tax Group Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($sbsSubscriberTaxGroup['SbsSubscriberTaxGroupMapping'] as $sbsSubscriberTaxGroupMapping): ?>
		<tr>
			<td><?php echo $sbsSubscriberTaxGroupMapping['id']; ?></td>
			<td><?php echo $sbsSubscriberTaxGroupMapping['priority']; ?></td>
			<td><?php echo $sbsSubscriberTaxGroupMapping['sbs_subscriber_tax_id']; ?></td>
			<td><?php echo $sbsSubscriberTaxGroupMapping['sbs_subscriber_tax_group_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'sbs_subscriber_tax_group_mappings', 'action' => 'view', $sbsSubscriberTaxGroupMapping['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'sbs_subscriber_tax_group_mappings', 'action' => 'edit', $sbsSubscriberTaxGroupMapping['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'sbs_subscriber_tax_group_mappings', 'action' => 'delete', $sbsSubscriberTaxGroupMapping['id']), null, __('Are you sure you want to delete # %s?', $sbsSubscriberTaxGroupMapping['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Sbs Subscriber Tax Group Mapping'), array('controller' => 'sbs_subscriber_tax_group_mappings', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Sls Quotation Products'); ?></h3>
	<?php if (!empty($sbsSubscriberTaxGroup['SlsQuotationProduct'])): ?>
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
	<?php foreach ($sbsSubscriberTaxGroup['SlsQuotationProduct'] as $slsQuotationProduct): ?>
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
