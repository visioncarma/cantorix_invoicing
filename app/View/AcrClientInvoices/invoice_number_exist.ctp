<?php 
if(empty($invoiceExist)){
	echo $this->Form->input('AcrClientInvoice.invoice_number',array('id'=>'invNumber','div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','placeholder'=>'Invoice no.','value'=>$invoiceNumber));
		$this->Js->get('#invNumber')->event('change',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'invoiceNumberExist'), array( 'update'=>'#invoiceNumber', 'async'=>true, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>false,'inline'=>true)))));
}else{ ?>
<?php	echo $this->Form->input('AcrClientInvoice.invoice_number',array('id'=>'invNumber','div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','placeholder'=>'Invoice no.','value'=>$invoiceNumber));
		$this->Js->get('#invNumber')->event('change',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'invoiceNumberExist'), array( 'update'=>'#invoiceNumber', 'async'=>true, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>false,'inline'=>true)))));
?>
<!--span style = "color:red"--><label class = "error"><?php echo $enteredInvoiceNumber." already exist."?></label><!--/span-->
<?php }?>
<?php echo $this->Js->writeBuffer();?>
