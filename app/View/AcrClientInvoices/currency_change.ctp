<?php if($currencySelected != $defaultCurrency):?>
		<div class="col-xs-12 col-sm-2 col-lg-2  paddingleftrightzero">
						<sapn class="conversion">
							<?php echo $this -> Form -> hidden('defaultCurrencyId', array('value' => $defaultCurrency)); ?>
							<?php echo $defaultCurrencyCodeChange; ?>
						</sapn>
					</div>
					<div class="col-xs-12 col-sm-1 col-lg-2 marginleftrightzero paddingleftrightzero">
						<?php echo $this->Form->input('AcrClientInvoice.conversionValue',array('id'=>'conversionValue','div'=>false,'label'=>false,'type'=>'text','class'=>'form-control specialborder','placeholder'=>'Enter conversion value','value'=>'1'));
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
						<sapn class="conversion" id ="invoiceCurrency">
							<?php echo $currencyList[$currencySelected]; ?>
						</sapn>
					</div>
		
		<?php endif; ?>
<?php echo $this -> Js -> writeBuffer(); ?>