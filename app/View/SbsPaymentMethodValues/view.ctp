<div class="sbsPaymentMethodValues view">
<h2><?php echo __('Sbs Payment Method Value'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($sbsPaymentMethodValue['SbsPaymentMethodValue']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subscriber Id'); ?></dt>
		<dd>
			<?php echo h($sbsPaymentMethodValue['SbsPaymentMethodValue']['subscriber_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cpn Payment Method Id'); ?></dt>
		<dd>
			<?php echo h($sbsPaymentMethodValue['SbsPaymentMethodValue']['cpn_payment_method_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cpn Payment Attribute Id'); ?></dt>
		<dd>
			<?php echo h($sbsPaymentMethodValue['SbsPaymentMethodValue']['cpn_payment_attribute_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Value'); ?></dt>
		<dd>
			<?php echo h($sbsPaymentMethodValue['SbsPaymentMethodValue']['value']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Sbs Payment Method Value'), array('action' => 'edit', $sbsPaymentMethodValue['SbsPaymentMethodValue']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Sbs Payment Method Value'), array('action' => 'delete', $sbsPaymentMethodValue['SbsPaymentMethodValue']['id']), null, __('Are you sure you want to delete # %s?', $sbsPaymentMethodValue['SbsPaymentMethodValue']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Payment Method Values'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Payment Method Value'), array('action' => 'add')); ?> </li>
	</ul>
</div>
