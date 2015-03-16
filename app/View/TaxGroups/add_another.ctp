<span><?php echo $this->Form->input('SbsSubscriberTaxGroup.tax.'.$flag,array('options'=>array(''=>'Select Tax',$tax),'label'=>'Select Tax')); ?></span>	
<span><?php echo $this->Form->input('SbsSubscriberTaxGroup.priority.'.$flag,array('type'=>'number','label'=>'Priority','style'=>('width : 50px;'))); ?></span>
</div>
<div id = "addAnother-<?php echo $flag;?>">
		<span>
			<?php echo $this->Js->link(__('Add Another'), array (
												'controller' => 'TaxGroups',
												'action' => 'addAnother',$flag
											), array (
												'update' => '#addAnother-'.$flag
											));
			?>
		</span>
		
<?php echo  $this->Js->writeBuffer();?>