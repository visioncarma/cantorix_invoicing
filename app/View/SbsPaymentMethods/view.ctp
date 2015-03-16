<div class="sbsPaymentMethods view">
<h2><?php echo __('Sbs Payment Method'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($sbsPaymentMethod['SbsPaymentMethod']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cpn Payment Method'); ?></dt>
		<dd>
			<?php echo $this->Html->link($sbsPaymentMethod['CpnPaymentMethod']['id'], array('controller' => 'cpn_payment_methods', 'action' => 'view', $sbsPaymentMethod['CpnPaymentMethod']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($sbsPaymentMethod['SbsPaymentMethod']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Sbs Payment Method'), array('action' => 'edit', $sbsPaymentMethod['SbsPaymentMethod']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Sbs Payment Method'), array('action' => 'delete', $sbsPaymentMethod['SbsPaymentMethod']['id']), null, __('Are you sure you want to delete # %s?', $sbsPaymentMethod['SbsPaymentMethod']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Payment Methods'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Payment Method'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cpn Payment Methods'), array('controller' => 'cpn_payment_methods', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Payment Method'), array('controller' => 'cpn_payment_methods', 'action' => 'add')); ?> </li>
	</ul>
</div>
