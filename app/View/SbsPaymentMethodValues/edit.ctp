<div class="sbsPaymentMethodValues form">
<?php echo $this->Form->create('SbsPaymentMethodValue'); ?>
	<fieldset>
		<legend><?php echo __('Edit Sbs Payment Method Value'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('subscriber_id');
		echo $this->Form->input('cpn_payment_method_id');
		echo $this->Form->input('cpn_payment_attribute_id');
		echo $this->Form->input('value');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('SbsPaymentMethodValue.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('SbsPaymentMethodValue.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Sbs Payment Method Values'), array('action' => 'index')); ?></li>
	</ul>
</div>
