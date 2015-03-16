<div class="acrClients view">
<h2><?php echo __('Acr Client'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client No'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['client_no']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client Name'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['client_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Billing Address Line1'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['billing_address_line1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Billing Address Line2'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['billing_address_line2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Billing City'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['billing_city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Billing State'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['billing_state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Billing Country'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['billing_country']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Billing Zip'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['billing_zip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Shiping Address Line1'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['shiping_address_line1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Shipping Address Line2'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['shipping_address_line2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Shipping City'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['shipping_city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Shipping State'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['shipping_state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Shipping Country'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['shipping_country']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Shipping Zip'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['shipping_zip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Website'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['website']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Business Phone'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['business_phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Business Fax'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['business_fax']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Notes'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['notes']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Send Invoice By'); ?></dt>
		<dd>
			<?php echo h($acrClient['AcrClient']['send_invoice_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cpn Language'); ?></dt>
		<dd>
			<?php echo $this->Html->link($acrClient['CpnLanguage']['id'], array('controller' => 'cpn_languages', 'action' => 'view', $acrClient['CpnLanguage']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cpn Currency'); ?></dt>
		<dd>
			<?php echo $this->Html->link($acrClient['CpnCurrency']['name'], array('controller' => 'cpn_currencies', 'action' => 'view', $acrClient['CpnCurrency']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sbs Subscriber'); ?></dt>
		<dd>
			<?php echo $this->Html->link($acrClient['SbsSubscriber']['name'], array('controller' => 'sbs_subscribers', 'action' => 'view', $acrClient['SbsSubscriber']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Acr Client'), array('action' => 'edit', $acrClient['AcrClient']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Acr Client'), array('action' => 'delete', $acrClient['AcrClient']['id']), null, __('Are you sure you want to delete # %s?', $acrClient['AcrClient']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Clients'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Client'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cpn Languages'), array('controller' => 'cpn_languages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Language'), array('controller' => 'cpn_languages', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cpn Currencies'), array('controller' => 'cpn_currencies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Currency'), array('controller' => 'cpn_currencies', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscribers'), array('controller' => 'sbs_subscribers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber'), array('controller' => 'sbs_subscribers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Client Contacts'), array('controller' => 'acr_client_contacts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Client Contact'), array('controller' => 'acr_client_contacts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Client Custom Values'), array('controller' => 'acr_client_custom_values', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Client Custom Value'), array('controller' => 'acr_client_custom_values', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Client Invoices'), array('controller' => 'acr_client_invoices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Client Invoice'), array('controller' => 'acr_client_invoices', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Inventory Invoices'), array('controller' => 'acr_inventory_invoices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Inventory Invoice'), array('controller' => 'acr_inventory_invoices', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Invoice Payment Details'), array('controller' => 'acr_invoice_payment_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Invoice Payment Detail'), array('controller' => 'acr_invoice_payment_details', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sls Quotations'), array('controller' => 'sls_quotations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sls Quotation'), array('controller' => 'sls_quotations', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Acr Client Contacts'); ?></h3>
	<?php if (!empty($acrClient['AcrClientContact'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Sur Name'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Mobile'); ?></th>
		<th><?php echo __('Home Phone'); ?></th>
		<th><?php echo __('Work Phone'); ?></th>
		<th><?php echo __('Is Primary'); ?></th>
		<th><?php echo __('Acr Client Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($acrClient['AcrClientContact'] as $acrClientContact): ?>
		<tr>
			<td><?php echo $acrClientContact['id']; ?></td>
			<td><?php echo $acrClientContact['name']; ?></td>
			<td><?php echo $acrClientContact['sur_name']; ?></td>
			<td><?php echo $acrClientContact['email']; ?></td>
			<td><?php echo $acrClientContact['mobile']; ?></td>
			<td><?php echo $acrClientContact['home_phone']; ?></td>
			<td><?php echo $acrClientContact['work_phone']; ?></td>
			<td><?php echo $acrClientContact['is_primary']; ?></td>
			<td><?php echo $acrClientContact['acr_client_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'acr_client_contacts', 'action' => 'view', $acrClientContact['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'acr_client_contacts', 'action' => 'edit', $acrClientContact['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'acr_client_contacts', 'action' => 'delete', $acrClientContact['id']), null, __('Are you sure you want to delete # %s?', $acrClientContact['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Acr Client Contact'), array('controller' => 'acr_client_contacts', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Acr Client Custom Values'); ?></h3>
	<?php if (!empty($acrClient['AcrClientCustomValue'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Data'); ?></th>
		<th><?php echo __('Acr Client Id'); ?></th>
		<th><?php echo __('Acr Client Custom Field Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($acrClient['AcrClientCustomValue'] as $acrClientCustomValue): ?>
		<tr>
			<td><?php echo $acrClientCustomValue['id']; ?></td>
			<td><?php echo $acrClientCustomValue['data']; ?></td>
			<td><?php echo $acrClientCustomValue['acr_client_id']; ?></td>
			<td><?php echo $acrClientCustomValue['acr_client_custom_field_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'acr_client_custom_values', 'action' => 'view', $acrClientCustomValue['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'acr_client_custom_values', 'action' => 'edit', $acrClientCustomValue['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'acr_client_custom_values', 'action' => 'delete', $acrClientCustomValue['id']), null, __('Are you sure you want to delete # %s?', $acrClientCustomValue['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Acr Client Custom Value'), array('controller' => 'acr_client_custom_values', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Acr Client Invoices'); ?></h3>
	<?php if (!empty($acrClient['AcrClientInvoice'])): ?>
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
	<?php foreach ($acrClient['AcrClientInvoice'] as $acrClientInvoice): ?>
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
	<h3><?php echo __('Related Acr Inventory Invoices'); ?></h3>
	<?php if (!empty($acrClient['AcrInventoryInvoice'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Acr Client Id'); ?></th>
		<th><?php echo __('Acp Inventory Expense Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($acrClient['AcrInventoryInvoice'] as $acrInventoryInvoice): ?>
		<tr>
			<td><?php echo $acrInventoryInvoice['id']; ?></td>
			<td><?php echo $acrInventoryInvoice['acr_client_id']; ?></td>
			<td><?php echo $acrInventoryInvoice['acp_inventory_expense_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'acr_inventory_invoices', 'action' => 'view', $acrInventoryInvoice['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'acr_inventory_invoices', 'action' => 'edit', $acrInventoryInvoice['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'acr_inventory_invoices', 'action' => 'delete', $acrInventoryInvoice['id']), null, __('Are you sure you want to delete # %s?', $acrInventoryInvoice['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Acr Inventory Invoice'), array('controller' => 'acr_inventory_invoices', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Acr Invoice Payment Details'); ?></h3>
	<?php if (!empty($acrClient['AcrInvoicePaymentDetail'])): ?>
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
	<?php foreach ($acrClient['AcrInvoicePaymentDetail'] as $acrInvoicePaymentDetail): ?>
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
<div class="related">
	<h3><?php echo __('Related Sls Quotations'); ?></h3>
	<?php if (!empty($acrClient['SlsQuotation'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Quotation No'); ?></th>
		<th><?php echo __('Exchange Rate'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Issue Date'); ?></th>
		<th><?php echo __('Purchase Order No'); ?></th>
		<th><?php echo __('Expiry Date'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Notes'); ?></th>
		<th><?php echo __('Sub Total'); ?></th>
		<th><?php echo __('Tax Total'); ?></th>
		<th><?php echo __('Func Estimate Total'); ?></th>
		<th><?php echo __('Acr Client Id'); ?></th>
		<th><?php echo __('Sbs Subscriber Id'); ?></th>
		<th><?php echo __('Invoice Amount'); ?></th>
		<th><?php echo __('Invoice Currency Code'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($acrClient['SlsQuotation'] as $slsQuotation): ?>
		<tr>
			<td><?php echo $slsQuotation['id']; ?></td>
			<td><?php echo $slsQuotation['quotation_no']; ?></td>
			<td><?php echo $slsQuotation['exchange_rate']; ?></td>
			<td><?php echo $slsQuotation['description']; ?></td>
			<td><?php echo $slsQuotation['issue_date']; ?></td>
			<td><?php echo $slsQuotation['purchase_order_no']; ?></td>
			<td><?php echo $slsQuotation['expiry_date']; ?></td>
			<td><?php echo $slsQuotation['status']; ?></td>
			<td><?php echo $slsQuotation['notes']; ?></td>
			<td><?php echo $slsQuotation['sub_total']; ?></td>
			<td><?php echo $slsQuotation['tax_total']; ?></td>
			<td><?php echo $slsQuotation['func_estimate_total']; ?></td>
			<td><?php echo $slsQuotation['acr_client_id']; ?></td>
			<td><?php echo $slsQuotation['sbs_subscriber_id']; ?></td>
			<td><?php echo $slsQuotation['invoice_amount']; ?></td>
			<td><?php echo $slsQuotation['invoice_currency_code']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'sls_quotations', 'action' => 'view', $slsQuotation['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'sls_quotations', 'action' => 'edit', $slsQuotation['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'sls_quotations', 'action' => 'delete', $slsQuotation['id']), null, __('Are you sure you want to delete # %s?', $slsQuotation['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Sls Quotation'), array('controller' => 'sls_quotations', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
