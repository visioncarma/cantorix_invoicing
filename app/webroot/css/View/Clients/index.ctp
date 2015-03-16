<div class="acrClients index">
	<h2><?php echo __('Acr Clients'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('client_no'); ?></th>
			<th><?php echo $this->Paginator->sort('client_name'); ?></th>
			<th><?php echo $this->Paginator->sort('billing_address_line1'); ?></th>
			<th><?php echo $this->Paginator->sort('billing_address_line2'); ?></th>
			<th><?php echo $this->Paginator->sort('billing_city'); ?></th>
			<th><?php echo $this->Paginator->sort('billing_state'); ?></th>
			<th><?php echo $this->Paginator->sort('billing_country'); ?></th>
			<th><?php echo $this->Paginator->sort('billing_zip'); ?></th>
			<th><?php echo $this->Paginator->sort('shiping_address_line1'); ?></th>
			<th><?php echo $this->Paginator->sort('shipping_address_line2'); ?></th>
			<th><?php echo $this->Paginator->sort('shipping_city'); ?></th>
			<th><?php echo $this->Paginator->sort('shipping_state'); ?></th>
			<th><?php echo $this->Paginator->sort('shipping_country'); ?></th>
			<th><?php echo $this->Paginator->sort('shipping_zip'); ?></th>
			<th><?php echo $this->Paginator->sort('website'); ?></th>
			<th><?php echo $this->Paginator->sort('business_phone'); ?></th>
			<th><?php echo $this->Paginator->sort('business_fax'); ?></th>
			<th><?php echo $this->Paginator->sort('notes'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('send_invoice_by'); ?></th>
			<th><?php echo $this->Paginator->sort('cpn_language_id'); ?></th>
			<th><?php echo $this->Paginator->sort('cpn_currency_id'); ?></th>
			<th><?php echo $this->Paginator->sort('sbs_subscriber_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($acrClients as $acrClient): ?>
	<tr>
		<td><?php echo h($acrClient['AcrClient']['id']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['client_no']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['client_name']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['billing_address_line1']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['billing_address_line2']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['billing_city']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['billing_state']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['billing_country']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['billing_zip']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['shiping_address_line1']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['shipping_address_line2']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['shipping_city']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['shipping_state']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['shipping_country']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['shipping_zip']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['website']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['business_phone']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['business_fax']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['notes']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['status']); ?>&nbsp;</td>
		<td><?php echo h($acrClient['AcrClient']['send_invoice_by']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($acrClient['CpnLanguage']['id'], array('controller' => 'cpn_languages', 'action' => 'view', $acrClient['CpnLanguage']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($acrClient['CpnCurrency']['name'], array('controller' => 'cpn_currencies', 'action' => 'view', $acrClient['CpnCurrency']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($acrClient['SbsSubscriber']['name'], array('controller' => 'sbs_subscribers', 'action' => 'view', $acrClient['SbsSubscriber']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $acrClient['AcrClient']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $acrClient['AcrClient']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $acrClient['AcrClient']['id']), null, __('Are you sure you want to delete # %s?', $acrClient['AcrClient']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Acr Client'), array('action' => 'add')); ?></li>
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
