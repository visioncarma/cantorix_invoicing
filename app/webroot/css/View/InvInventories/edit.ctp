<div class="invInventories form">
<?php echo $this->Form->create('InvInventory'); ?>
	<fieldset>
		<legend><?php echo __('Edit Inv Inventory'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('list_price');
		echo $this->Form->input('track_quantity');
		echo $this->Form->input('current_stock');
		echo $this->Form->input('sbs_subscriber_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('InvInventory.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('InvInventory.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Inv Inventories'), array('action' => 'index')); ?></li>
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
