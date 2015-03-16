<?php /*echo $defaultCurrencyCode;*/?>
<?php echo $this->Form->hidden('AcrClientInvoice.invoice_currency_code',array('value'=>$defaultCurrencyCode));?>
<?php if($defaultCurrencyCode != $subscriberCurrencyCode):?>
<div class="col-xs-12 col-sm-2 col-lg-2  paddingleftrightzero">
	<span class="conversion">
		<?php echo '1 '.$defaultCurrencyCode.' =';?>
	</span>
</div>
<div class="col-xs-12 col-sm-1 col-lg-2 marginleftrightzero paddingleftrightzero">
	<?php echo $this->Form->input('AcrClientInvoice.conversionValue',array('id'=>'conversionValue','div'=>false,'label'=>false,'type'=>'text','class'=>'form-control specialborder','placeholder'=>'Enter conversion value','value'=>1));
											 $this->Js->get('#conversionValue')->event('keyup', $this->Js->request(array (
									        'controller' => 'acr_client_invoices',
									        'action' => 'calculateTotal'
				), array (
									       'update' => '#calculateFinal',
									       'async' => true,
									       'dataExpression' => true,
									       'method' => 'post',
									       'data' => $this->Js->serializeForm(array (
									             'isForm' => false,
									             'inline' => true
								            ))
			)));	
	?>
</div>
<div class="col-xs-12 col-sm-2 col-lg-1 marginleftrightzero paddingleftrightzero">
	<span class="conversion" >
			<?php echo $subscriberCurrencyCode;?>
			<?php echo $this->Form->hidden('AcrClientInvoice.defaultCurrencyId',array('value'=>$defaultCurrency));?>
	</span>
</div>
<?php endif;?>
<script>
	$(function() {
	$('#conversionValue').keyup(function () {
	    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
	       this.value = this.value.replace(/[^0-9\.]/g, '');
	    }
	    var str = this.value;
	    if(/^[0-9- ]*$/.test(str) == false) {
    		$(this).attr( "maxlength", "7" );
		} else {
			$(this).attr( "maxlength", "4" );
		}
	});
	});
</script>
<?php echo $this -> Js -> writeBuffer(); ?>