<div class="sbsSubscriberTaxGroupMappings index">
	<h2><?php echo __('Sbs Subscriber Tax Group Mappings'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('priority'); ?></th>
			<th><?php echo $this->Paginator->sort('sbs_subscriber_tax_id'); ?></th>
			<th><?php echo $this->Paginator->sort('sbs_subscriber_tax_group_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($sbsSubscriberTaxGroupMappings as $sbsSubscriberTaxGroupMapping): ?>
	<tr>
		<td><?php echo h($sbsSubscriberTaxGroupMapping['SbsSubscriberTaxGroupMapping']['id']); ?>&nbsp;</td>
		<td><?php echo h($sbsSubscriberTaxGroupMapping['SbsSubscriberTaxGroupMapping']['priority']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($sbsSubscriberTaxGroupMapping['SbsSubscriberTax']['name'], array('controller' => 'sbs_subscriber_taxes', 'action' => 'view', $sbsSubscriberTaxGroupMapping['SbsSubscriberTax']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($sbsSubscriberTaxGroupMapping['SbsSubscriberTaxGroup']['group_name'], array('controller' => 'sbs_subscriber_tax_groups', 'action' => 'view', $sbsSubscriberTaxGroupMapping['SbsSubscriberTaxGroup']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $sbsSubscriberTaxGroupMapping['SbsSubscriberTaxGroupMapping']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $sbsSubscriberTaxGroupMapping['SbsSubscriberTaxGroupMapping']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $sbsSubscriberTaxGroupMapping['SbsSubscriberTaxGroupMapping']['id']), null, __('Are you sure you want to delete # %s?', $sbsSubscriberTaxGroupMapping['SbsSubscriberTaxGroupMapping']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Sbs Subscriber Tax Group Mapping'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Sbs Subscriber Taxes'), array('controller' => 'sbs_subscriber_taxes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber Tax'), array('controller' => 'sbs_subscriber_taxes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscriber Tax Groups'), array('controller' => 'sbs_subscriber_tax_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber Tax Group'), array('controller' => 'sbs_subscriber_tax_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
