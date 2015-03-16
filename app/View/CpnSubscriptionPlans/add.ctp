<div class="cpnSubscriptionPlans form">
<?php echo $this->Form->create('CpnSubscriptionPlan'); ?>
	<fieldset>
		<legend><?php echo __('Add Cpn Subscription Plan'); ?></legend>
	<?php
		echo $this->Form->input('type');
		echo $this->Form->input('validity');
		echo $this->Form->input('no_of_staffs');
		echo $this->Form->input('no_of_clients');
		echo $this->Form->input('no_of_invoices');
		echo $this->Form->input('cost');
		echo $this->Form->input('deletion_days');
		echo $this->Form->input('archieve_days');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Cpn Subscription Plans'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Sbs Subscribers'), array('controller' => 'sbs_subscribers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber'), array('controller' => 'sbs_subscribers', 'action' => 'add')); ?> </li>
	</ul>
</div>
