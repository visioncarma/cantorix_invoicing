<?php
    if(empty($currencyID['AcrClient']['cpn_currency_id'])) {
        $currencyID['AcrClient']['cpn_currency_id'] = $defaultCurrency;
    } 
	echo $this->Form->input('AcrClientInvoice.cpn_currency_id_idd',array(
		'div'=>FALSE,'label'=>FALSE,'id'=>'currencySelect','options'=>array(''=>'Select Currency',$currencyList),'default'=>$currencyID['AcrClient']['cpn_currency_id'],'disabled'=>true,
		'class'=>'selectpicker form-control','data-placeholder'=>"Currency List"));
	echo $this->Form->hidden('AcrClientInvoice.cpn_currency_id',array('value'=>$currencyID['AcrClient']['cpn_currency_id']));
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
	/*echo $this -> Form -> hidden('AcrClientInvoice.defaultCurrencyId', array('value' => $defaultCurrency));
	echo $this -> Form -> hidden('invoice_currency_code', array('value' => $defaultCurrencyCode));
	echo $this -> Form -> hidden('conversionValue',array('value'=>'1'));*/
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