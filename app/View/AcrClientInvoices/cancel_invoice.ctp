<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php if(!$invoiceLogged){?>

<td class="title_role width-120-new"><span class="on-load statusopn"><?php echo $acrClientInvoice['AcrClientInvoice']['invoice_number'];?></span>

</td>
<td class="title width-150-new"><span class="on-load"><?php echo $acrClientInvoice['AcrClient']['client_name'];?></span>
</td>
<td class="title width-120-new"><span class="on-load"><?php echo date($dateFormat,strtotime($acrClientInvoice['AcrClientInvoice']['invoiced_date']));?></span>							
</td>
<td class="width-120-new textright padding-right-25">
	<span class="on-load">
		<?php echo $this->Number->currency($acrClientInvoice['AcrClientInvoice']['invoice_total'],$acrClientInvoice['AcrClientInvoice']['invoice_currency_code']);?>
	</span>
</td>
<td class="width-120-new textright padding-right-25">
	<span class="on-load">
		<?php echo $this->Number->currency($balance,$acrClientInvoice['AcrClientInvoice']['invoice_currency_code']);?>
	</span>
</td>
<td class="title width-120-new"><span class="on-load "><?php echo $acrClientInvoice['AcrClientInvoice']['status'];?></span>
</td>
<td class="title width-100-new">
<div class="btn-group visible-md visible-lg visible-sm visible-xs">
								<div>
									<div class="inline position-relative">
										<button class="btn btn-minier btn-warning dropdown-toggle" data-toggle="dropdown">
											<i class="icon-caret-down bigger-110"></i>
										</button>
										<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
											<li>
												<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('controller'=>'acr_client_invoices','action'=>'view',$acrClientInvoice['AcrClientInvoice']['id']),array('class'=>'btn btn-xs btn-success view on-load pull-right','escape'=>FALSE,'title'=>'View'));?>
											</li>											
											<li id ="li-<?php echo $acrClientInvoice['AcrClientInvoice']['id']; ?>">	
												<?php if($acrClientInvoice['AcrClientInvoice']['pdf_generated']=="Yes"){
														echo $this->Html->link('<i class="icon-save bigger-120"></i>',array('controller'=>'acr_client_invoices','action'=>'downloadLink',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['invoice_number']),array('class'=>'btn btn-xs delete on-load pull-right','escape'=>FALSE,'title'=>'Download PDF'));
													}else{
														echo $this -> Js -> link(' <i class="icon-fighter-jet bigger-120"></i>', 
															array('controller' => 'acr_client_invoices', 'action' => 'savePdf',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['invoice_number']),
												    		array('escape' => FALSE, 'update' => '#li-'.$acrClientInvoice['AcrClientInvoice']['id'],'title'=>'Save Pdf','confirm'=>'A pdf of the invoice will be generated and saved in the system,so that you can download.'));
													}								
												?>
											</li>
											<?php if($acrClientInvoice['AcrClientInvoice']['status'] !="Canceled"){?>
												<li>
													<?php echo $this -> Js -> link('<i class="icon-trash bigger-120"></i>', 
													array('controller' => 'acr_client_invoices', 'action' => 'cancelInvoice',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['status']),
												    array('escape' => FALSE, 'update' => '#tr-'.$acrClientInvoice['AcrClientInvoice']['id'],'title'=>'Cancel Invoice','confirm'=>'Are you sure to Cancel the selected Invoice ?'));?>
												</li>		
											<?php } ?>									
										</ul>
									</div>
								
								<!--button class="btn btn-xs edit on-load pull-right" title="Send Invoice" data-toggle="modal" data-target="#mail-<?php /*echo $acrClientInvoice['AcrClientInvoice']['id']*/?>"> <i class=" icon-envelope-alt  bigger-120"></i> </button!-->
								<?php 
								if($acrClientInvoice['AcrClientInvoice']['status'] == "Sent"){
									echo $this->Html->link('<i class="icon-credit-card  bigger-120"></i>',array('controller'=>'acr_invoice_payment_details','action'=>'add',$acrClientInvoice['AcrClientInvoice']['id']),array('class'=>'btn btn-xs btn-success edit on-load pull-right','escape'=>FALSE,'title'=>'Capture Payment'));
								}
								?>
								<?php if(($acrClientInvoice['AcrClientInvoice']['status'] !="Canceled") ){?>
									<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('controller'=>'acr_client_invoices','action'=>'edit',$acrClientInvoice['AcrClientInvoice']['id']),array('class'=>'btn btn-xs btn-info edit on-load borderwidth','escape'=>FALSE,'title'=>'Edit'));?>
								<?php } ?>
							</div>
							</div>
							</td>
<?php }else{
	echo '<div class="alert alert-danger">Sorry!You can not cancel the Invoice# '.$invoiceno.'. Please delete the payment against invoice# '.$invoiceno.' to cancel.</div>';
} ?>
<?php echo $this -> Js -> writeBuffer(); ?> 