<?php if($dueDate){
	echo $this->Form->input('AcrClientInvoice.due_date',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','disabled'=>'disabled','value'=>$dueDate));
}else{
	echo $this->Form->input('AcrClientInvoice.due_date',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','disabled'=>'disabled'));
}
 ?>