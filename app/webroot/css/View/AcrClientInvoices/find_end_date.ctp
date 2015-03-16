<?php if($dueDate){
	echo $this->Form->input('AcrClientInvoice.due_date',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','disabled'=>'disabled','value'=>date('M d ,Y',strtotime($dueDate))));
}else{
	echo $this->Form->input('AcrClientInvoice.due_date',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','disabled'=>'disabled'));
}
 ?>