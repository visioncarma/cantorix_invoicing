<div class="sbsCurrencies index">
	<h2><?php echo __('Sbs Currencies'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('code'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($sbsCurrencies as $sbsCurrency): ?>
	<tr>
		<td><?php echo h($sbsCurrency['SbsCurrency']['id']); ?>&nbsp;</td>
		<td><?php echo h($sbsCurrency['SbsCurrency']['name']); ?>&nbsp;</td>
		<td><?php echo h($sbsCurrency['SbsCurrency']['code']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $sbsCurrency['SbsCurrency']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $sbsCurrency['SbsCurrency']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $sbsCurrency['SbsCurrency']['id']), null, __('Are you sure you want to delete # %s?', $sbsCurrency['SbsCurrency']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Sbs Currency'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Acr Clients'), array('controller' => 'acr_clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Client'), array('controller' => 'acr_clients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscriber Organization Details'), array('controller' => 'sbs_subscriber_organization_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber Organization Detail'), array('controller' => 'sbs_subscriber_organization_details', 'action' => 'add')); ?> </li>
	</ul>
</div>
