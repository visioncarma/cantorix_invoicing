<div class="sbsSubscriberCpnCurrencyMappings view">
<h2><?php echo __('Sbs Subscriber Cpn Currency Mapping'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($sbsSubscriberCpnCurrencyMapping['SbsSubscriberCpnCurrencyMapping']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sbs Subscriber'); ?></dt>
		<dd>
			<?php echo $this->Html->link($sbsSubscriberCpnCurrencyMapping['SbsSubscriber']['name'], array('controller' => 'sbs_subscribers', 'action' => 'view', $sbsSubscriberCpnCurrencyMapping['SbsSubscriber']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cpn Currency'); ?></dt>
		<dd>
			<?php echo $this->Html->link($sbsSubscriberCpnCurrencyMapping['CpnCurrency']['name'], array('controller' => 'cpn_currencies', 'action' => 'view', $sbsSubscriberCpnCurrencyMapping['CpnCurrency']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Sbs Subscriber Cpn Currency Mapping'), array('action' => 'edit', $sbsSubscriberCpnCurrencyMapping['SbsSubscriberCpnCurrencyMapping']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Sbs Subscriber Cpn Currency Mapping'), array('action' => 'delete', $sbsSubscriberCpnCurrencyMapping['SbsSubscriberCpnCurrencyMapping']['id']), null, __('Are you sure you want to delete # %s?', $sbsSubscriberCpnCurrencyMapping['SbsSubscriberCpnCurrencyMapping']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscriber Cpn Currency Mappings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber Cpn Currency Mapping'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscribers'), array('controller' => 'sbs_subscribers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber'), array('controller' => 'sbs_subscribers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cpn Currencies'), array('controller' => 'cpn_currencies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Currency'), array('controller' => 'cpn_currencies', 'action' => 'add')); ?> </li>
	</ul>
</div>
