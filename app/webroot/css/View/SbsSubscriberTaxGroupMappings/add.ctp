<div class="sbsSubscriberTaxGroupMappings form">
<?php echo $this->Form->create('SbsSubscriberTaxGroupMapping'); ?>
	<fieldset>
		<legend><?php echo __('Add Sbs Subscriber Tax Group Mapping'); ?></legend>
	<?php
		echo $this->Form->input('priority');
		echo $this->Form->input('sbs_subscriber_tax_id');
		echo $this->Form->input('sbs_subscriber_tax_group_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Sbs Subscriber Tax Group Mappings'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Sbs Subscriber Taxes'), array('controller' => 'sbs_subscriber_taxes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber Tax'), array('controller' => 'sbs_subscriber_taxes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscriber Tax Groups'), array('controller' => 'sbs_subscriber_tax_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber Tax Group'), array('controller' => 'sbs_subscriber_tax_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
