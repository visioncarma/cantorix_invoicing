<div class="cpnSubscriptionPlans view">
<h2><?php echo __('Cpn Subscription Plan'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Validity'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['validity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('No Of Staffs'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['no_of_staffs']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('No Of Clients'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['no_of_clients']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('No Of Invoices'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['no_of_invoices']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cost'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['cost']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deletion Days'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['deletion_days']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Archieve Days'); ?></dt>
		<dd>
			<?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['archieve_days']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Cpn Subscription Plan'), array('action' => 'edit', $cpnSubscriptionPlan['CpnSubscriptionPlan']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Cpn Subscription Plan'), array('action' => 'delete', $cpnSubscriptionPlan['CpnSubscriptionPlan']['id']), null, __('Are you sure you want to delete # %s?', $cpnSubscriptionPlan['CpnSubscriptionPlan']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Cpn Subscription Plans'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cpn Subscription Plan'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscribers'), array('controller' => 'sbs_subscribers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber'), array('controller' => 'sbs_subscribers', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Sbs Subscribers'); ?></h3>
	<?php if (!empty($cpnSubscriptionPlan['SbsSubscriber'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Surname'); ?></th>
		<th><?php echo __('Subscribed Date'); ?></th>
		<th><?php echo __('Home Phone'); ?></th>
		<th><?php echo __('Mobile'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Cpn Subscription Plan Id'); ?></th>
		<th><?php echo __('Sbs Subscriber Organization Detail Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($cpnSubscriptionPlan['SbsSubscriber'] as $sbsSubscriber): ?>
		<tr>
			<td><?php echo $sbsSubscriber['id']; ?></td>
			<td><?php echo $sbsSubscriber['name']; ?></td>
			<td><?php echo $sbsSubscriber['surname']; ?></td>
			<td><?php echo $sbsSubscriber['subscribed_date']; ?></td>
			<td><?php echo $sbsSubscriber['home_phone']; ?></td>
			<td><?php echo $sbsSubscriber['mobile']; ?></td>
			<td><?php echo $sbsSubscriber['status']; ?></td>
			<td><?php echo $sbsSubscriber['cpn_subscription_plan_id']; ?></td>
			<td><?php echo $sbsSubscriber['sbs_subscriber_organization_detail_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'sbs_subscribers', 'action' => 'view', $sbsSubscriber['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'sbs_subscribers', 'action' => 'edit', $sbsSubscriber['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'sbs_subscribers', 'action' => 'delete', $sbsSubscriber['id']), null, __('Are you sure you want to delete # %s?', $sbsSubscriber['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Sbs Subscriber'), array('controller' => 'sbs_subscribers', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
