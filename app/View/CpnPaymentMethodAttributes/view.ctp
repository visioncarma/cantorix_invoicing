<div class="cpnPaymentMethodAttributes view">
<h2><?php echo __('Cpn Payment Method Attribute'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($cpnPaymentMethodAttribute['CpnPaymentMethodAttribute']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cpn Payment Method'); ?></dt>
		<dd>
			<?php echo $this->Html->link($cpnPaymentMethodAttribute['CpnPaymentMethod']['id'], array('controller' => 'cpn_payment_methods', 'action' => 'view', $cpnPaymentMethodAttribute['CpnPaymentMethod']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Attribute'); ?></dt>
		<dd>
			<?php echo h($cpnPaymentMethodAttribute['CpnPaymentMethodAttribute']['attribute']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Cpn Payment Method Attribute'), array('action' => 'edit', $cpnPaymentMethodAttribute['CpnPaymentMethodAttribute']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Cpn Payment Method Attribute'), array('action' => 'delete', $cpnPaymentMethodAttribute['CpnPaymentMethodAttribute']['id']), null, __('Are you sure you want to delete # %s?', $cpnPaymentMethodAttribute['CpnPaymentMethodAttribute']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Cpn Payment Method Attributes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Payment Method Attribute'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cpn Payment Methods'), array('controller' => 'cpn_payment_methods', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Payment Method'), array('controller' => 'cpn_payment_methods', 'action' => 'add')); ?> </li>
	</ul>
</div>
