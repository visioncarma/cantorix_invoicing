<div class="sbsSubscriberTaxGroups form">
<?php echo $this->Form->create('SbsSubscriberTaxGroup'); ?>
	<fieldset>
		<legend><?php echo __('Add Sbs Subscriber Tax Group'); ?></legend>
	<?php
		echo $this->Form->input('SbsSubscriberTaxGroup.group_name');
	?>
	<div>
		<span><?php echo $this->Form->input('SbsSubscriberTaxGroup.tax.1',array('options'=>array(''=>'Select Tax',$tax),'label'=>'Select Tax')); ?></span>	
		<span><?php echo $this->Form->input('SbsSubscriberTaxGroup.priority.1',array('type'=>'number','label'=>'Priority','style'=>('width : 50px;'))); ?></span>
	</div>
	<div id = "addAnother-1">
		<span>
			<?php echo $this->Js->link(__('Add Another'), array (
												'controller' => 'TaxGroups',
												'action' => 'addAnother',1
											), array (
												'div' => false,
												'update' => '#addAnother-1'
											));
			?>
		</span>
	</div>
	<?php	echo $this->Form->input('SbsSubscriberTaxGroup.compounded',array('options'=>array('Y'=>'Compound','N'=>'Simple')));
		    echo $this->Form->input('SbsSubscriberTaxGroup.sbs_subscriber_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Sbs Subscriber Tax Groups'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Sbs Subscribers'), array('controller' => 'sbs_subscribers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber'), array('controller' => 'sbs_subscribers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acr Invoice Details'), array('controller' => 'acr_invoice_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acr Invoice Detail'), array('controller' => 'acr_invoice_details', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sbs Subscriber Tax Group Mappings'), array('controller' => 'sbs_subscriber_tax_group_mappings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber Tax Group Mapping'), array('controller' => 'sbs_subscriber_tax_group_mappings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sls Quotation Products'), array('controller' => 'sls_quotation_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sls Quotation Product'), array('controller' => 'sls_quotation_products', 'action' => 'add')); ?> </li>
	</ul>
</div>
<?php echo  $this->Js->writeBuffer();?>
