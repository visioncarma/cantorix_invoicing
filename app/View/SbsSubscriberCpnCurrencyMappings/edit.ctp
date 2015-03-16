<div class="sbsSubscriberCpnCurrencyMappings form">
<?php echo $this->Form->create('SbsSubscriberCpnCurrencyMapping'); ?>
	<fieldset>
		<legend><?php echo __('Edit Sbs Subscriber Cpn Currency Mapping'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('sbs_subscriber_id');
		echo $this->Form->input('cpn_currency_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('SbsSubscriberCpnCurrencyMapping.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('SbsSubscriberCpnCurrencyMapping.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Sbs Subscriber Cpn Currency Mappings'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Sbs Subscribers'), array('controller' => 'sbs_subscribers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber'), array('controller' => 'sbs_subscribers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cpn Currencies'), array('controller' => 'cpn_currencies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Currency'), array('controller' => 'cpn_currencies', 'action' => 'add')); ?> </li>
	</ul>
</div>
