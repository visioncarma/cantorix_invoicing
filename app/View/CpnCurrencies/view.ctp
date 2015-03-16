<div class="cpnCurrencies view">
<h2><?php echo __('Currency'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($cpnCurrency['CpnCurrency']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($cpnCurrency['CpnCurrency']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($cpnCurrency['CpnCurrency']['code']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Cpn Currency'), array('action' => 'edit', $cpnCurrency['CpnCurrency']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Cpn Currency'), array('action' => 'delete', $cpnCurrency['CpnCurrency']['id']), null, __('Are you sure you want to delete # %s?', $cpnCurrency['CpnCurrency']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Cpn Currencies'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Currency'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Clients'), array('controller' => 'acr_clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Client'), array('controller' => 'acr_clients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscriber Organization Details'), array('controller' => 'sbs_subscriber_organization_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber Organization Detail'), array('controller' => 'sbs_subscriber_organization_details', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Acr Clients'); ?></h3>
	<?php if (!empty($cpnCurrency['AcrClient'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Client No'); ?></th>
		<th><?php echo __('Client Name'); ?></th>
		<th><?php echo __('Billing Address Line1'); ?></th>
		<th><?php echo __('Billing Address Line2'); ?></th>
		<th><?php echo __('Billing City'); ?></th>
		<th><?php echo __('Billing State'); ?></th>
		<th><?php echo __('Billing Country'); ?></th>
		<th><?php echo __('Billing Zip'); ?></th>
		<th><?php echo __('Shiping Address Line1'); ?></th>
		<th><?php echo __('Shipping Address Line2'); ?></th>
		<th><?php echo __('Shipping City'); ?></th>
		<th><?php echo __('Shipping State'); ?></th>
		<th><?php echo __('Shipping Country'); ?></th>
		<th><?php echo __('Shipping Zip'); ?></th>
		<th><?php echo __('Website'); ?></th>
		<th><?php echo __('Business Phone'); ?></th>
		<th><?php echo __('Business Fax'); ?></th>
		<th><?php echo __('Notes'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Send Invoice By'); ?></th>
		<th><?php echo __('Cpn Language Id'); ?></th>
		<th><?php echo __('Cpn Currency Id'); ?></th>
		<th><?php echo __('Sbs Subscriber Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($cpnCurrency['AcrClient'] as $acrClient): ?>
		<tr>
			<td><?php echo $acrClient['id']; ?></td>
			<td><?php echo $acrClient['client_no']; ?></td>
			<td><?php echo $acrClient['client_name']; ?></td>
			<td><?php echo $acrClient['billing_address_line1']; ?></td>
			<td><?php echo $acrClient['billing_address_line2']; ?></td>
			<td><?php echo $acrClient['billing_city']; ?></td>
			<td><?php echo $acrClient['billing_state']; ?></td>
			<td><?php echo $acrClient['billing_country']; ?></td>
			<td><?php echo $acrClient['billing_zip']; ?></td>
			<td><?php echo $acrClient['shiping_address_line1']; ?></td>
			<td><?php echo $acrClient['shipping_address_line2']; ?></td>
			<td><?php echo $acrClient['shipping_city']; ?></td>
			<td><?php echo $acrClient['shipping_state']; ?></td>
			<td><?php echo $acrClient['shipping_country']; ?></td>
			<td><?php echo $acrClient['shipping_zip']; ?></td>
			<td><?php echo $acrClient['website']; ?></td>
			<td><?php echo $acrClient['business_phone']; ?></td>
			<td><?php echo $acrClient['business_fax']; ?></td>
			<td><?php echo $acrClient['notes']; ?></td>
			<td><?php echo $acrClient['status']; ?></td>
			<td><?php echo $acrClient['send_invoice_by']; ?></td>
			<td><?php echo $acrClient['cpn_language_id']; ?></td>
			<td><?php echo $acrClient['cpn_currency_id']; ?></td>
			<td><?php echo $acrClient['sbs_subscriber_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'acr_clients', 'action' => 'view', $acrClient['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'acr_clients', 'action' => 'edit', $acrClient['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'acr_clients', 'action' => 'delete', $acrClient['id']), null, __('Are you sure you want to delete # %s?', $acrClient['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Acr Client'), array('controller' => 'acr_clients', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Sbs Subscriber Organization Details'); ?></h3>
	<?php if (!empty($cpnCurrency['SbsSubscriberOrganizationDetail'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Organization Name'); ?></th>
		<th><?php echo __('Billing Address Line1'); ?></th>
		<th><?php echo __('Billing Address Line2'); ?></th>
		<th><?php echo __('Billing City'); ?></th>
		<th><?php echo __('Billing State'); ?></th>
		<th><?php echo __('Billing Country'); ?></th>
		<th><?php echo __('Billing Zip'); ?></th>
		<th><?php echo __('Shiping Address Line1'); ?></th>
		<th><?php echo __('Shipping Address Line2'); ?></th>
		<th><?php echo __('Shipping City'); ?></th>
		<th><?php echo __('Shipping State'); ?></th>
		<th><?php echo __('Shipping Country'); ?></th>
		<th><?php echo __('Shipping Zip'); ?></th>
		<th><?php echo __('Website'); ?></th>
		<th><?php echo __('Phone'); ?></th>
		<th><?php echo __('Fax'); ?></th>
		<th><?php echo __('Time Zone'); ?></th>
		<th><?php echo __('Logo'); ?></th>
		<th><?php echo __('Cpn Financial Year Id'); ?></th>
		<th><?php echo __('Cpn Currency Id'); ?></th>
		<th><?php echo __('Cpn Language Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($cpnCurrency['SbsSubscriberOrganizationDetail'] as $sbsSubscriberOrganizationDetail): ?>
		<tr>
			<td><?php echo $sbsSubscriberOrganizationDetail['id']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['organization_name']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['billing_address_line1']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['billing_address_line2']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['billing_city']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['billing_state']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['billing_country']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['billing_zip']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['shiping_address_line1']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['shipping_address_line2']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['shipping_city']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['shipping_state']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['shipping_country']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['shipping_zip']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['website']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['phone']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['fax']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['time_zone']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['logo']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['cpn_financial_year_id']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['cpn_currency_id']; ?></td>
			<td><?php echo $sbsSubscriberOrganizationDetail['cpn_language_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'sbs_subscriber_organization_details', 'action' => 'view', $sbsSubscriberOrganizationDetail['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'sbs_subscriber_organization_details', 'action' => 'edit', $sbsSubscriberOrganizationDetail['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'sbs_subscriber_organization_details', 'action' => 'delete', $sbsSubscriberOrganizationDetail['id']), null, __('Are you sure you want to delete # %s?', $sbsSubscriberOrganizationDetail['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Sbs Subscriber Organization Detail'), array('controller' => 'sbs_subscriber_organization_details', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
