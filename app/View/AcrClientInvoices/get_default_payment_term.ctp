<?php echo $this -> Form -> input('AcrClientInvoice.sbs_subscriber_payment_term_id', array('id' => 'paymentTems', 'div' => false, 'label' => false, 'options' => array('' => 'Select Term', $paymentTerm), 'class'=>'form-control selectpicker','selected'=>$defaultPaymentTermId));
	$this -> Js -> get('#paymentTems') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'findEndDate'), array('update' => '#dueDateUpdate', 'async' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
?>
<script>
	$('.selectpicker').selectpicker();
</script>
<?php echo $this -> Js -> writeBuffer(); ?>