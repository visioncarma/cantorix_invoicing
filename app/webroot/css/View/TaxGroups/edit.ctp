<div class="sbsSubscriberTaxGroups form">
<?php echo $this->Form->create('SbsSubscriberTaxGroup'); ?>
<?php $flag = 0;?>
	<fieldset>
		<legend><?php echo __('Edit Sbs Subscriber Tax Group'); ?></legend>
	<?php
		echo $this->Form->hidden('SbsSubscriberTaxGroup.taxGroupId',array('value'=>$id));
		echo $this->Form->input('SbsSubscriberTaxGroup.group_name');
	?>
	<?php foreach($groupTax as $groupTaxMapping):?>
	<?php $flag++;?>
	<div>
		<?php echo $this->Form->hidden('SbsSubscriberTaxGroup.groupMappingId.'.$flag,array('value'=>$groupTaxMapping['SbsSubscriberTaxGroupMapping']['id']))?>
		<span><?php echo $this->Form->input('SbsSubscriberTaxGroup.tax.'.$flag,array('options'=>array(''=>'Select Tax',$tax),'label'=>'Select Tax','default'=>$groupTaxMapping['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id'])); ?></span>	
		<span><?php echo $this->Form->input('SbsSubscriberTaxGroup.priority.'.$flag,array('type'=>'number','label'=>'Priority','style'=>('width : 50px;'),'value'=>$groupTaxMapping['SbsSubscriberTaxGroupMapping']['priority'])); ?></span>
	</div>
	 
	<?php endforeach;?>
	<div id = "addAnother-<?php echo $flag?>">
		<span>
			<?php echo $this->Js->link(__('Add Another'), array (
												'controller' => 'TaxGroups',
												'action' => 'addAnother',$flag
											), array (
												'div' => false,
												'update' => '#addAnother-'.$flag
											));
			?>
		</span>
	</div>
	<?php
		echo $this->Form->input('SbsSubscriberTaxGroup.compounded',array('options'=>array('Y'=>'Compound','N'=>'Simple'),'default'=>$groupTaxMapping['SbsSubscriberTaxGroup']['compounded']));
		echo $this->Form->input('SbsSubscriberTaxGroup.sbs_subscriber_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('SbsSubscriberTaxGroup.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('SbsSubscriberTaxGroup.id'))); ?></li>
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