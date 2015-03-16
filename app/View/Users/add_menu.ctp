<div class="sbsSubscriberTaxes form">
<?php echo $this->Form->create('Aco'); ?>
	<fieldset>
		<legend><?php echo __('Add Menu'); ?></legend>
	<?php
		echo $this->Form->input('parent_id',array('options'=>array(''=>'--Select--',$options)));
		echo $this->Form->input('model');
		echo $this->Form->input('alias');
		echo $this->Form->input('url');
		echo $this->Form->input('order');
		echo $this->Form->input('user_type',array('options'=>array('Super Admin'=>'Super Admin', 'Subscriber'=>'Subscriber')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
