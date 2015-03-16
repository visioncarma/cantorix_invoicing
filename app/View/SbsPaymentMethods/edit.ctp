<div class="sbsPaymentMethods form">
<?php echo $this->Form->create('SbsPaymentMethod'); ?>
	<fieldset>
		<legend><?php echo __('Edit Sbs Payment Method'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('cpn_payment_method_id');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('SbsPaymentMethod.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('SbsPaymentMethod.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Sbs Payment Methods'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Cpn Payment Methods'), array('controller' => 'cpn_payment_methods', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Payment Method'), array('controller' => 'cpn_payment_methods', 'action' => 'add')); ?> </li>
	</ul>
</div>
