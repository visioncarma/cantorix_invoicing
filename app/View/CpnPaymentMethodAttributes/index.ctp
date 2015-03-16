<div class="cpnPaymentMethodAttributes index">
	<h2><?php echo __('Cpn Payment Method Attributes'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('cpn_payment_method_id'); ?></th>
			<th><?php echo $this->Paginator->sort('attribute'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($cpnPaymentMethodAttributes as $cpnPaymentMethodAttribute): ?>
	<tr>
		<td><?php echo h($cpnPaymentMethodAttribute['CpnPaymentMethodAttribute']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($cpnPaymentMethodAttribute['CpnPaymentMethod']['id'], array('controller' => 'cpn_payment_methods', 'action' => 'view', $cpnPaymentMethodAttribute['CpnPaymentMethod']['id'])); ?>
		</td>
		<td><?php echo h($cpnPaymentMethodAttribute['CpnPaymentMethodAttribute']['attribute']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $cpnPaymentMethodAttribute['CpnPaymentMethodAttribute']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $cpnPaymentMethodAttribute['CpnPaymentMethodAttribute']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $cpnPaymentMethodAttribute['CpnPaymentMethodAttribute']['id']), null, __('Are you sure you want to delete # %s?', $cpnPaymentMethodAttribute['CpnPaymentMethodAttribute']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Cpn Payment Method Attribute'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Cpn Payment Methods'), array('controller' => 'cpn_payment_methods', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Payment Method'), array('controller' => 'cpn_payment_methods', 'action' => 'add')); ?> </li>
	</ul>
</div>
