<div class="sbsSubscriberCpnCurrencyMappings index">
	<h2><?php echo __('Sbs Subscriber Cpn Currency Mappings'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('sbs_subscriber_id'); ?></th>
			<th><?php echo $this->Paginator->sort('cpn_currency_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($sbsSubscriberCpnCurrencyMappings as $sbsSubscriberCpnCurrencyMapping): ?>
	<tr>
		<td><?php echo h($sbsSubscriberCpnCurrencyMapping['SbsSubscriberCpnCurrencyMapping']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($sbsSubscriberCpnCurrencyMapping['SbsSubscriber']['name'], array('controller' => 'sbs_subscribers', 'action' => 'view', $sbsSubscriberCpnCurrencyMapping['SbsSubscriber']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($sbsSubscriberCpnCurrencyMapping['CpnCurrency']['name'], array('controller' => 'cpn_currencies', 'action' => 'view', $sbsSubscriberCpnCurrencyMapping['CpnCurrency']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $sbsSubscriberCpnCurrencyMapping['SbsSubscriberCpnCurrencyMapping']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $sbsSubscriberCpnCurrencyMapping['SbsSubscriberCpnCurrencyMapping']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $sbsSubscriberCpnCurrencyMapping['SbsSubscriberCpnCurrencyMapping']['id']), null, __('Are you sure you want to delete # %s?', $sbsSubscriberCpnCurrencyMapping['SbsSubscriberCpnCurrencyMapping']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Sbs Subscriber Cpn Currency Mapping'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Sbs Subscribers'), array('controller' => 'sbs_subscribers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber'), array('controller' => 'sbs_subscribers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cpn Currencies'), array('controller' => 'cpn_currencies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Currency'), array('controller' => 'cpn_currencies', 'action' => 'add')); ?> </li>
	</ul>
</div>
