<?php
	
	echo $this->Form->input('AcpExpense.lineTotal',array('value'=>$this->Number->currency($lineTotal, ' '),'class'=>'form-control text-right','disabled'=>'disabled','label'=>FALSE,'div'=>FALSE));
?>