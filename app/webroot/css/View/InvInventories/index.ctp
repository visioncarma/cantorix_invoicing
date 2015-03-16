<div class="invInventories index">
	<h2><?php echo __('Inv Inventories'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('list_price'); ?></th>
			<th><?php echo $this->Paginator->sort('track_quantity'); ?></th>
			<th><?php echo $this->Paginator->sort('current_stock'); ?></th>
			<th><?php echo $this->Paginator->sort('sbs_subscriber_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($invInventories as $invInventory): ?>
	<tr>
		<td><?php echo h($invInventory['InvInventory']['id']); ?>&nbsp;</td>
		<td><?php echo h($invInventory['InvInventory']['name']); ?>&nbsp;</td>
		<td><?php echo h($invInventory['InvInventory']['description']); ?>&nbsp;</td>
		<td><?php echo h($invInventory['InvInventory']['list_price']); ?>&nbsp;</td>
		<td><?php echo h($invInventory['InvInventory']['track_quantity']); ?>&nbsp;</td>
		<td><?php echo h($invInventory['InvInventory']['current_stock']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($invInventory['SbsSubscriber']['name'], array('controller' => 'sbs_subscribers', 'action' => 'view', $invInventory['SbsSubscriber']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $invInventory['InvInventory']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $invInventory['InvInventory']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $invInventory['InvInventory']['id']), null, __('Are you sure you want to delete # %s?', $invInventory['InvInventory']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Inv Inventory'), array('action' => 'add')); ?></li>
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
