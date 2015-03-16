<?php 
	echo $this->Form->input('AcrClientInvoice.cpn_currency_id',array(
		'div'=>FALSE,'label'=>FALSE,'id'=>'currencySelect','options'=>array(''=>'Select Currency',$currencyList),'default'=>$currencyID['AcrClient']['cpn_currency_id'],
		'class'=>'selectpicker form-control','data-placeholder'=>"Currency List"));
	
	$this->Js->get('#currencySelect')->event('change',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'currencyInfo'), 
		array( 'update'=>'#invoiceCurrency', 'async'=>true, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>FALSE,'inline'=>true)))));
								
	$this->Js->get('#currencySelect')->event('change', $this->Js->request(array ('controller' => 'acr_client_invoices','action' => 'calculateTotal',1), 
		array ('update' => '#calculateFinal','async' => true,'dataExpression' => true,
			'method' => 'post',
			'data' => $this->Js->serializeForm(array (
			'isForm' => FALSE,
			'inline' => true
		))
	)));	
?>		
<script type="text/javascript">
	$('document').ready(function(){
		if($('.selectpicker').length){
	      $('.selectpicker').selectpicker({
	       });
   
         }
	});
</script>
	<?php echo $this->Js->writeBuffer();?>