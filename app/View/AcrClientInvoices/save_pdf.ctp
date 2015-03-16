<?php if($pdf == "Yes"){
			echo $this->Html->link('<i class="icon-save bigger-120"></i>',array('controller'=>'acr_client_invoices','action'=>'downloadLink',$invoiceId,$invoiceNumber),array('class'=>'btn btn-xs delete pull-right','escape'=>FALSE,'title'=>'Download PDF'));
	  }else{
			echo $this -> Js -> link(' <i class="icon-fighter-jet bigger-120"></i> ', 
				array('controller' => 'acr_client_invoices', 'action' => 'savePdf',$invoiceId,$invoiceNumber),
				array('escape' => FALSE, 'update' => '#li-'.$invoiceId,'title'=>'Save Pdf','confirm'=>'A pdf of the invoice will be generated and saved in the system,so that you can download.'));
}?>
<?php echo $this->Js->writeBuffer();?>