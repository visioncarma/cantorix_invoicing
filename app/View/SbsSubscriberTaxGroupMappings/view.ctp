<div class="sbsSubscriberTaxGroupMappings view">
<h2><?php echo __('Sbs Subscriber Tax Group Mapping'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($sbsSubscriberTaxGroupMapping['SbsSubscriberTaxGroupMapping']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Priority'); ?></dt>
		<dd>
			<?php echo h($sbsSubscriberTaxGroupMapping['SbsSubscriberTaxGroupMapping']['priority']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sbs Subscriber Tax'); ?></dt>
		<dd>
			<?php echo $this->Html->link($sbsSubscriberTaxGroupMapping['SbsSubscriberTax']['name'], array('controller' => 'sbs_subscriber_taxes', 'action' => 'view', $sbsSubscriberTaxGroupMapping['SbsSubscriberTax']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sbs Subscriber Tax Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($sbsSubscriberTaxGroupMapping['SbsSubscriberTaxGroup']['group_name'], array('controller' => 'sbs_subscriber_tax_groups', 'action' => 'view', $sbsSubscriberTaxGroupMapping['SbsSubscriberTaxGroup']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Sbs Subscriber Tax Group Mapping'), array('action' => 'edit', $sbsSubscriberTaxGroupMapping['SbsSubscriberTaxGroupMapping']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Sbs Subscriber Tax Group Mapping'), array('action' => 'delete', $sbsSubscriberTaxGroupMapping['SbsSubscriberTaxGroupMapping']['id']), null, __('Are you sure you want to delete # %s?', $sbsSubscriberTaxGroupMapping['SbsSubscriberTaxGroupMapping']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscriber Tax Group Mappings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber Tax Group Mapping'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscriber Taxes'), array('controller' => 'sbs_subscriber_taxes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber Tax'), array('controller' => 'sbs_subscriber_taxes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscriber Tax Groups'), array('controller' => 'sbs_subscriber_tax_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber Tax Group'), array('controller' => 'sbs_subscriber_tax_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
