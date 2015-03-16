<div class="form-group marginleftrightzero relative">
	<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Currency Code'); ?></label>
		<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero labelerror">
			
			<?php echo $this -> Form -> hidden('AcrClientInvoice.defaultCurrencyId', array('value' => $defaultCurrency)); ?>
			<?php
				if($lockCurrency){
					echo $this -> Form -> hidden('AcrClientInvoice.cpn_currency_id', array('value' => $defaultCurrencyInfo['CpnCurrency']['id']));
					echo $this -> Form -> input('AcrClientInvoice.cpn_currency_id_1', array('id' => 'invoiceCurrencySelect', 'div' => false, 'label' => false, 'options' => array('' => 'Select Currency', $currencyList), 'default' => $defaultCurrencyInfo['CpnCurrency']['id'], 'class'=>'form-control invdrop','data-placeholder' => "Currency List",'disabled'=>'disabled'));
						$this -> Js -> get('#invoiceCurrencySelect') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'currencyInfo'), array('update' => '#invoiceCurrency', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
				} else{
					echo $this -> Form -> input('AcrClientInvoice.cpn_currency_id', array('id' => 'invoiceCurrencySelect', 'div' => false, 'label' => false, 'options' => array('' => 'Select Currency', $currencyList), 'default' => $getClientCurrency['AcrClient']['cpn_currency_id'], 'class'=>'form-control invdrop','data-placeholder' => "Currency List",'disabled'=>'disabled'));
						$this -> Js -> get('#invoiceCurrencySelect') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'currencyInfo'), array('update' => '#invoiceCurrency', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
				}
			?>
			
			<?php 
				$this -> Js -> get('#invoiceCurrencySelect') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'currencyChange',$getClientCurrency['AcrClient']['cpn_currency_id'],$defaultCurrency,$defaultCurrencyCodeChange), array('update' => '#currencyChange', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
			?>
			<?php
					$this->Js->get('#invoiceCurrencySelect')->event('change', $this->Js->request(array (
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
		<div id = "currencyChange">
		<?php if($defaultCurrency != $getClientCurrency['AcrClient']['cpn_currency_id']):?>
		<div class="col-xs-12 col-sm-2 col-lg-1  paddingleftrightzero">
						<sapn class="conversion">
							
							<?php 
							if($lockCurrency) {
																echo '1 ' .$currencyList[$defaultCurrencyInfo['CpnCurrency']['id']].' =';
															}else{
																echo '1 ' .$currencyList[$getClientCurrency['AcrClient']['cpn_currency_id']].' =';
							
								}?>
						</sapn>
					</div>
					<div class="col-xs-12 col-sm-1 col-lg-2 marginleftrightzero paddingleftrightzero">
						<?php echo $this->Form->input('AcrClientInvoice.conversionValue',array('id'=>'conversionValue','div'=>false,'label'=>false,'type'=>'text','class'=>'form-control specialborder','placeholder'=>'Enter conversion value','value'=>'1'));
							  	   $this->Js->get('#conversionValue')->event('change', $this->Js->request(array (
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
						<sapn class="conversion" id ="invoiceCurrency">
							<?php
								
								/*
								if($lockCurrency) {
																									echo $currencyList[$defaultCurrencyInfo['CpnCurrency']['id']];
																								}else{
																									echo $currencyList[$getClientCurrency['AcrClient']['cpn_currency_id']];
																								}*/
								
								
							 ?>
							  <?php echo $this -> Form -> hidden('defaultCurrencyId', array('value' => $defaultCurrency)); ?>
							<?php echo $defaultCurrencyCodeChange; ?>
							
						</sapn>
					</div>
		
		<?php endif; ?>
		</div>
</div>
<script type="text/javascript" >
$(document).ready(function() {
	    if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
    	} 
    	
    	/* choosen select*/
			var config = {
				  
				  '.invdrop' : {search_contains:true}
				}
				for (var selector in config) {
				  $(selector).chosen(config[selector]);
			}
		/* choosen select*/
 });
</script>
<?php echo $this -> Js -> writeBuffer(); ?>