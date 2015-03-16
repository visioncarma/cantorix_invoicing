<div class="sbsCurrencies form">
<?php echo $this->Form->create('SbsCurrency'); ?>
	<fieldset>
		<legend><?php echo __('Add Sbs Currency'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('code');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Sbs Currencies'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Acr Clients'), array('controller' => 'acr_clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Client'), array('controller' => 'acr_clients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscriber Organization Details'), array('controller' => 'sbs_subscriber_organization_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber Organization Detail'), array('controller' => 'sbs_subscriber_organization_details', 'action' => 'add')); ?> </li>
	</ul>
</div>
