<div class="cpnPaymentMethodAttributes form">
<?php echo $this->Form->create('CpnPaymentMethodAttribute'); ?>
	<fieldset>
		<legend><?php echo __('Add Cpn Payment Method Attribute'); ?></legend>
	<?php
		echo $this->Form->input('cpn_payment_method_id');
		echo $this->Form->input('attribute');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Cpn Payment Method Attributes'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Cpn Payment Methods'), array('controller' => 'cpn_payment_methods', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Payment Method'), array('controller' => 'cpn_payment_methods', 'action' => 'add')); ?> </li>
	</ul>
</div>
