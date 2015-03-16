<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php
	if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
	  $protocol_final = 'https';
	}else{
	  $protocol_final = 'http';
	}
	$http_hostname = $_SERVER['SERVER_NAME'];
	$webroot_name = $this->webroot;
	$imgLink = "$protocol_final".'://'."$http_hostname/";
?>
<?php
	/*
	if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
		  $protocol_final = 'https';
		}else{
		  $protocol_final = 'http';
		}
		$http_hostname = '192.168.0.164';
		$webroot_name = 'cantorix/';
		$imgLink = "$protocol_final".'://'."$http_hostname/";*/
	
?>
<?php if($mailTemplate == 'sent_invoice'):?>

<table style="width:100%; height:100%; border:0; cellspacing:0;cellpadding:0; background:#f0f0f0;padding:30px 0px;">
	<tr>
    	<td>
        	<table cellspacing="0" style="width:900px;padding:0px; background:#fff; height:100%; border:1px solid #d8d8d8; margin:auto; align:center; cellpadding:0; cellspacing:0; bgcolor:#ffffff;">
            	<tr>
                   <td>
                   <table style="width:100%; height:100%;">
                       <tr>
                        <td align="left" style="width:50%;border:0;padding: 15px 27px;border-bottom:1px solid #e9e9e9">
                               <?php if($logo) {?>
										<img src="<?php echo $imgLink.$logo;?>" alt="Logo"/>
										
									<?php } else { ?>
											<img src="<?php echo $imgLink.$webroot_name.'img/logo.png';?>" alt="Cantorix Logo"/>
									<?php }?>
                        </td>
                        <td align="right" style="width:50%;border:0;padding: 15px 40px;border-bottom:1px solid #e9e9e9">
                          <table style="width:100%; height:100%;" align="right">
                             <tr>
                                <td style="font-size:30px;font-weight:bold;font-family:Arial;text-align: right;padding-right:15px;"><?php echo __('INVOICE');?></td>                           
                            </tr> 
                            <tr>
                                <td style="text-align: right;padding-right: 15px;">
                                    <span style="margin-right:15px;font-family:Arial;"><?php echo ('Inv #') ?></span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php echo $invoiceData['AcrClientInvoice']['invoice_number'];?></span>
                                </td>
                            </tr> 
                          </table>    
                        </td>
                        </tr>
                   </table> 
                  </td> 
                </tr>
                <tr>
                   <td>
                   <table style="width:100%; height:100%;">
                       <tr>
                           <td align="left" style="width:50%;border:0;padding: 10px 40px;vertical-align: top;">
                          <table style="width:100%;" align="left">
                             <tr>
                                <td style="font-size:14px;font-weight:bold;font-family:Arial;"><?php echo ('From:');?></td>                         
                             </tr> 
                             <tr>
                                <td style="font-size:18px;font-weight:bold;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['organization_name'];?></td>        
                             </tr>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'])):?>
                             	<tr>
	                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'];?></td>        
	                             </tr>
	                         <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'])):?> 
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'])):?> 
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];?></td>        
                             </tr>
                             <?php endif;?>   
                          </table>  
                        </td>
                           <td align="right" style="width:50%;border:0;padding: 10px 40px;vertical-align: top;">
                            <table style="width:100%;" align="right">
                             <tr>
                                <td style="font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right: 15px;"><?php echo ('Invoice To:');?></td>
                             </tr> 
                             <tr>
                                <td style="font-size:18px;font-weight:bold;font-family:Arial;text-align:right;padding-right: 15px;"><?php echo $customerDetails['AcrClient']['client_name'];?></td>        
                             </tr>
                             <?php if(!empty($customerDetails['AcrClient']['billing_address_line1'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;text-align:right;padding-right: 15px;"><?php echo $customerDetails['AcrClient']['billing_address_line1'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($customerDetails['AcrClient']['billing_address_line2'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;text-align:right;padding-right: 15px;"><?php echo $customerDetails['AcrClient']['billing_address_line2'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($customerDetails['AcrClient']['billing_city'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;text-align:right;padding-right: 15px;"><?php echo $customerDetails['AcrClient']['billing_city'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($customerDetails['AcrClient']['billing_state'])):?> 
                             <tr>
                                <td style="font-size:14px;font-family:Arial;text-align:right;padding-right: 15px;"><?php echo $customerDetails['AcrClient']['billing_state'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($customerDetails['AcrClient']['billing_country'])):?> 
                             <tr>
                                <td style="font-size:14px;font-family:Arial;text-align:right;padding-right: 15px;"><?php echo $customerDetails['AcrClient']['billing_country'];?></td>        
                             </tr>
                             <?php endif;?>   
                             <?php if(!empty($customerDetails['AcrClient']['billing_zip'])):?> 
                             <tr>
                                <td style="font-size:14px;font-family:Arial;text-align:right;padding-right: 15px;"><?php echo $customerDetails['AcrClient']['billing_zip'];?></td>        
                             </tr>
                             <?php endif;?>
                          </table>  
                        </td>
                        </tr>
                   </table> 
                  </td> 
                </tr>
                 <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                 <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                <tr>
                  <td>
                   <table style="width:70%; height:100%; cellpadding:0; cellspacing:0;" align="center">
                        <tr>
                           <td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 5px;"><?php echo __('Invoice Date');?></td>
                            <td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 5px;"><?php echo __('Term');?></td>
                           <td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:0px;padding-bottom: 5px;"><?php echo __('Due Date');?></td> 
                           <td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:center;padding-right:0px;padding-bottom: 5px;"><?php echo __('PO#');?></td>  
                        </tr>
                   </table> 
                  </td>
                </tr>
                <tr>  
                  <td>
                   <table style="width:70%; height:100%; cellpadding:0; cellspacing:0;" align="center">
                        <tr>
                           <td style="width:25%;font-size:13px;font-family:Arial;text-align:left;padding-left:15px;padding-top: 5px;"><?php echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['invoiced_date']));?></td>
                           <td style="width:25%;font-size:13px;font-family:Arial;text-align:left;padding-left:15px;padding-top: 5px;"><?php echo $invoiceData['SbsSubscriberPaymentTerm']['no_of_days'].' Days Net';?></td>
                           <td style="width:25%;font-size:13px;font-family:Arial;text-align:left;padding-left:2px;padding-top: 5px;"><?php if($invoiceData['AcrClientInvoice']['due_date']){echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['due_date']));}else{echo '--';}?></td> 
                           <td style="width:25%;font-size:13px;font-family:Arial;text-align:center;padding-right:0;padding-top: 5px;"><?php if($invoiceData['AcrClientInvoice']['purchase_order_no']){ echo $invoiceData['AcrClientInvoice']['purchase_order_no'];}else { echo '--'; }?></td>  
                        </tr>
                   </table> 
                  </td> 
                </tr>
                 <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                 <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                <tr>
                  <td>
                   <table style="width:90%; height:100%;" align="center">
                        <tr>
                           <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;">Item</td>
                           <td style="width:32%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;">Description</td>
                           <td style="width:8%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Qty</td>
                            <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Unit Price</td>
                             <td style="width:8%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Disc %</td>
                              <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Amount</td>  
                        </tr>
                   </table> 
                  </td>
                </tr>
                <?php foreach($invoiceDetail as $k=>$v) { ?>
					<tr>
						<td>
						<table style="width:90%; height:100%; cellpadding:0; cellspacing:0;" align="center">
							<tr>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['InvInventory']['name']; ?></td>
								<td style="width:32%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['inventory_description']; ?></td>
								<td style="width:8%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['quantity']; ?></td>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($v['AcrInvoiceDetail']['unit_rate']/$conversionValue,''); ?> </td>
								<td style="width:8%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['discount_percent']; ?> </td>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($v['AcrInvoiceDetail']['line_total']/$conversionValue,''); ?></td>
							</tr>
						</table></td>
					</tr>
				<?php } ?>
                <tr>  
                  <td style="padding-right:30px;">
                   <table style="width:35%; height:100%;padding-top:10px;padding-right:50px;" align="right">
                        <tr>
                             <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Subtotal</td>
                              <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:30px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['sub_total']/$conversionValue,$invoiceData['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                        <?php foreach($taxArray as $taxKey=>$taxVal){?>
		                        <tr>
		                             <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $taxVal['taxName'];?></td>
		                              <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:30px;padding-bottom: 10px;"><?php echo $this->Number->currency($taxVal['taxAmount']/$conversionValue,$invoiceData['AcrClientInvoice']['invoice_currency_code']);?></td>  
		                        </tr>
                        	<?php } ?>
                        <tr>
                             <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Total</td>
                              <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:30px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                   </table> 
                  </td> 
                </tr>
                <tr>  
                  <td>
                   <table style="width:91%; height:100%;" align="center">                        
                        <tr>
					        <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;border-bottom:1px solid #d8d8d8;"></td>
				        </tr>                        
                   </table> 
                  </td> 
                </tr>
                <tr>  
                  <td>
                   <table style="width:90%; height:100%;padding-top:15px;" align="center">  
                        <tr>
                            <td  style="padding: 3px 0;font-size:14px;font-family:arial;">
                             <?php echo $invoiceData['AcrClientInvoice']['notes'];?>
                            </td>
                        </tr>
                       
                        
                    </table>
                  </td>
               </tr> 
                  <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>                  
                <tr>  
                  <td>
                   <table style="width:50%; height:100%;padding-top:15px;" align="center">  
                        <tr>
                            <td  style="padding: 3px 0;font-size:20px;font-weight:bold;text-align:center;font-family:arial;">
                            Thank you for your business
                            </td>
                        </tr>
                       
                    </table>
                  </td>
               </tr>  
                  <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                <tr>  
                  <td>
                   <table style="width:90%; height:100%;padding-top:15px;" align="center">  
                        <tr>
                            <td  style="padding: 3px 0;font-size:15px;font-family:arial;font-weight:bold;">
                             Term and Conditions
                            </td>
                        </tr>
                        <tr>
                            <td  style="padding: 3px 0;font-size:14px;font-family:arial;text-align:justify;">
                            <?php echo $invoiceData['AcrClientInvoice']['term_conditions'];?>
                            </td>
                        </tr>
                    </table>
                  </td>
               </tr>
                  <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                  <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>  
            </table>
        </td>
    </tr>
    
    
</table>

<?php endif;?>

<?php if($mailTemplate == 'sent_invoice_modern'):?>
	
<table style="width:100%; height:100%; border:0; cellspacing:0;cellpadding:0; background:#f0f0f0;padding:30px 0px;">
	<tr>
    	<td>
        	<table cellspacing="0" style="width:900px;padding:0px; background:#fff; height:100%; border:1px solid #d8d8d8; margin:auto; align:center; cellpadding:0; cellspacing:0; bgcolor:#ffffff;">
            	<tr>
                   <td>
                   <table style="width:100%; height:100%;">
                       <tr>                        
                           <td align="right" style="width:50%;border:0;padding: 15px 40px;border-bottom:1px solid #e9e9e9">
                          <table style="width:100%; height:100%;" align="left">
                             <tr>
                                <td style="font-size:30px;font-weight:bold;font-family:Arial;color:#4E68A1;"><?php echo __('INVOICE');?></td>                           
                            </tr> 
                            <tr>
                                <td>
                                    <span style="float:left;width:100px;font-family:Arial;"><?php echo __('Inv #');?></span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php echo $invoiceData['AcrClientInvoice']['invoice_number'];?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="float:left;width:100px;font-family:Arial;"><?php echo __('PO #');?></span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php if($invoiceData['AcrClientInvoice']['purchase_order_no']){ echo $invoiceData['AcrClientInvoice']['purchase_order_no'];}else { echo '--'; }?></span>
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    <span style="float:left;width:100px;font-family:Arial;"><?php echo __('Invoiced Date');?></span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['invoiced_date']));?></span>
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    <span style="float:left;width:100px;font-family:Arial;"><?php echo __('Due Date')?></span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php if($invoiceData['AcrClientInvoice']['due_date']){echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['due_date']));}else{echo '--';}?></span>
                                </td>
                            </tr>  
                          </table>    
                        </td>
                           <td align="right" style="width:50%;border:0;padding: 15px 40px;border-bottom:1px solid #e9e9e9">
                               <?php if($logo) {?>
										<img src="<?php echo $imgLink.$logo;?>" alt="Logo"/>
										
									<?php } else { ?>
											<img src="<?php echo $imgLink.$webroot_name.'img/logo.png';?>" alt="Cantorix Logo"/>
									<?php }?>
                           </td>
                       </tr>
                   </table> 
                  </td> 
                </tr>
                <tr>
                   <td>
                   <table style="width:100%; height:100%;">
                       <tr>
                           <td align="left" style="width:50%;border:0;padding: 10px 40px;vertical-align: top;">                            
                               <table style="width:100%;" align="left">
                             <tr>
                                <td style="font-size:14px;font-family:Arial;font-weight: bold;"><?php echo ('Invoice To:');?></td>
                             </tr> 
                             <tr>
                                <td style="font-size:18px;font-weight:bold;font-family:Arial;"><?php echo $customerDetails['AcrClient']['client_name'];?></td>        
                             </tr>
                             <?php if(!empty($customerDetails['AcrClient']['billing_address_line1'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_address_line1'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($customerDetails['AcrClient']['billing_address_line2'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_address_line2'];?></td>        
                             </tr>
                              <?php endif;?>
                               <?php if(!empty($customerDetails['AcrClient']['billing_city'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_city'];?></td>        
                             </tr> 
                              <?php endif;?>
                              <?php if(!empty($customerDetails['AcrClient']['billing_state'])):?> 
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_state'];?></td>        
                             </tr> 
                              <?php endif;?>
                              <?php if(!empty($customerDetails['AcrClient']['billing_country'])):?> 
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_country'];?></td>        
                             </tr>
                              <?php endif;?>
                              <?php if(!empty($customerDetails['AcrClient']['billing_zip'])):?> 
                              		<td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_zip'];?></td>     
                              <?php endif;?>
                          </table>
                           </td>
                           <td align="right" style="width:50%;border:0;padding: 10px 40px;vertical-align: top;">
                            <table style="width:80%;  background:#4e68a1;color:#fff;padding:15px;text-align:right;" align="right">
                             <tr><td>&nbsp;&nbsp;</td>
                             </tr>
                             <tr>
                                <td style="font-size:18px;font-weight:bold;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['organization_name'];?></td>        
                             </tr>
                              <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'];?></td>        
                             </tr> 
                             <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'];?></td>        
                             </tr> 
                             <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'])):?> 
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'];?></td>        
                             </tr>  
                              <?php endif;?>
                              <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'])):?>
                              	<tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];?></td>        
                             </tr>  
                             <?php endif;?>
                            </table> 
                           </td>
                        </tr>
                   </table> 
                  </td> 
                </tr>
                 <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                 <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                 <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                 <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                <tr>
                  <td>
                   <table style="width:90%; height:100%;" align="center">
                        <tr>
                           <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;">Item</td>
                           <td style="width:32%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;">Description</td>
                           <td style="width:8%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Qty</td>
                            <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Unit Price</td>
                             <td style="width:8%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Disc %</td>
                              <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Amount</td>  
                        </tr>
                   </table> 
                  </td>
                </tr>
                <?php foreach($invoiceDetail as $k=>$v) { ?>
					<tr>
						<td>
						<table style="width:90%; height:100%; cellpadding:0; cellspacing:0;" align="center">
							<tr>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['InvInventory']['name']; ?></td>
								<td style="width:32%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['inventory_description']; ?></td>
								<td style="width:8%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['quantity']; ?></td>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($v['AcrInvoiceDetail']['unit_rate']/$conversionValue,''); ?> </td>
								<td style="width:8%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['discount_percent']; ?> </td>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($v['AcrInvoiceDetail']['line_total']/$conversionValue,''); ?></td>
							</tr>
						</table></td>
					</tr>
				<?php } ?>
                <tr>  
                  <td>
                   <table style="width:90%; height:100%;padding-top:10px; background:#F5F5F5;border-bottom:1px solid #d8d8d8" align="center">
                        <tr>
                        <td>
                        <table  style="width:32%; height:100%;padding-top:10px; background:#F5F5F5;" align="right">
                        <tr>
                        <td>
                        <tr>
                        	
                             <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Subtotal</td>
                              <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($invoiceData['AcrClientInvoice']['sub_total']/$conversionValue),$invoiceData['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                       <?php foreach($taxArray as $taxKey=>$taxVal){?>
		                        <tr>
		                             <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $taxVal['taxName'];?></td>
		                              <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $this->Number->currency($taxVal['taxAmount']/$conversionValue,$invoiceData['AcrClientInvoice']['invoice_currency_code']);?></td>  
		                        </tr>
                        <?php } ?>
                        <tr>
                             <td style="width:50%;font-size:14px;forightnt-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Total</td>
                              <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                        </td>
                        </tr>
                        </table>
                        </td>
                        </tr>
                   </table> 
                  </td> 
                </tr>
                
                <tr>  
                  <td>
                   <table style="width:90%; height:100%;padding-top:15px;" align="center">  
                        <tr>
                            <td  style="padding: 3px 0;font-size:14px;font-family:arial;">
                             <?php echo $invoiceData['AcrClientInvoice']['notes'];?>
                            </td>
                        </tr>
                    </table>
                  </td>
               </tr> 
                  <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>                  
                <tr>  
                  <td>
                   <table style="width:50%; height:100%;padding-top:15px;" align="center">  
                        <tr>
                            <td  style="padding: 3px 0;font-size:20px;font-weight:bold;text-align:center;font-family:arial;color:#4e68a1">
                            Thank you for your business
                            </td>
                        </tr>
                       
                    </table>
                  </td>
               </tr> 
                <tr>  
                  <td>
                   <table style="width:90%; height:100%;padding-top:15px;" align="center">  
                        <tr>
                            <td  style="padding: 3px 0;font-size:15px;font-family:arial;font-weight:bold;">
                             Term and Conditions
                            </td>
                        </tr>
                        <tr>
                            <td  style="padding: 3px 0;font-size:14px;font-family:arial;text-align:justify;">
                            <?php echo $invoiceData['AcrClientInvoice']['term_conditions'];?>
                            </td>
                        </tr>
                    </table>
                  </td>
               </tr>
                  <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                  <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>  
            </table>
        </td>
    </tr>
    
</table>

<?php endif;?>

<?php if($mailTemplate == 'sent_invoice_service_classic'):?>

<table style="width:100%; height:100%; border:0; cellspacing:0;cellpadding:0; background:#f0f0f0;padding:30px 0px;">
	<tr>
    	<td>
        	<table cellspacing="0" style="width:900px;padding:0px; background:#fff; height:100%; border:1px solid #d8d8d8; margin:auto; align:center; cellpadding:0; cellspacing:0; bgcolor:#ffffff;">
            	<tr>
                   <td>
                   <table style="width:100%; height:100%;">
                       <tr>
                        <td align="left" style="width:50%;border:0;padding: 15px 27px;border-bottom:1px solid #e9e9e9">
							<?php if($logo) {?>
										<img src="<?php echo $imgLink.$logo;?>" alt="Logo"/>
										
									<?php } else { ?>
											<img src="<?php echo $imgLink.$webroot_name.'img/logo.png';?>" alt="Cantorix Logo"/>
									<?php }?>                       </td>
                        <td align="right" style="width:50%;border:0;padding: 30px 40px;border-bottom:1px solid #e9e9e9">
                          <table style="width:100%; height:100%;" align="right">
                             <tr>
                                <td style="font-size:30px;font-weight:bold;font-family:Arial;text-align: right;padding-right: 15px;">INVOICE</td>                           
                            </tr> 
                            <tr>
                                <td style="text-align: right;padding-right: 15px;">
                                    <span style="margin-right:15px;font-family:Arial;">Inv #</span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php echo $invoiceData['AcrClientInvoice']['invoice_number'];?></span>
                                </td>
                            </tr> 
                          </table>    
                        </td>
                        </tr>
                   </table> 
                  </td> 
                </tr>
                <tr>
                   <td>
                   <table style="width:100%; height:100%;">
                       <tr>
                           <td align="left" style="width:50%;border:0;padding: 10px 40px; vertical-align: top;">
                          <table style="width:100%;" align="left">
                             <tr>
                                <td style="font-size:14px;font-weight:bold;font-family:Arial;">From:</td>                         
                             </tr> 
                             <tr>
                                <td style="font-size:18px;font-weight:bold;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['organization_name'];?></td>        
                             </tr>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'];?></td>        
                             </tr>
                              <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'])):?> 
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'])):?>
                             <tr>
                            	<td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];?></td>        
                             </tr>
                             <?php endif;?>
                          </table>  
                        </td>
                           <td align="right" style="width:50%;border:0;padding: 10px 40px;vertical-align: top;">
                            <table style="width:100%;" align="right">
                             <tr>
                                <td style="font-size:14px;font-weight:bold;font-family:Arial;text-align: right;padding-right: 15px;">Invoice To:</td>
                             </tr> 
                             <tr>
                                <td style="font-size:18px;text-align: right;padding-right: 15px;font-weight:bold;font-family:Arial;"><?php echo $customerDetails['AcrClient']['client_name'];?></td>        
                             </tr>
                              <?php if(!empty($customerDetails['AcrClient']['billing_address_line1'])):?>
                             <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_address_line1'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($customerDetails['AcrClient']['billing_address_line2'])):?>
                             <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_address_line2'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($customerDetails['AcrClient']['billing_city'])):?>
                             <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_city'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($customerDetails['AcrClient']['billing_state'])):?> 
                             <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_state'];?></td>        
                             </tr>
                              <?php endif;?>
                              <?php if(!empty($customerDetails['AcrClient']['billing_country'])):?>
                             <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_country'];?></td>        
                             </tr> 
                               <?php endif;?>
                              <?php if(!empty($customerDetails['AcrClient']['billing_zip'])):?>
                              <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_zip'];?></td>        
                              </tr> 
                               <?php endif;?>
                          </table>  
                        </td>
                        </tr>
                   </table> 
                  </td> 
                </tr>
                 <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                 <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                <tr>
                  <td>
                   <table style="width:70%; height:100%; cellpadding:0; cellspacing:0;" align="center">
                        <tr>
                           <td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 5px;">Invoiced Date</td>
                           <td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 5px;">Term</td>
                           <td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-bottom: 5px;">Due Date</td> 
                           <td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:center;padding-right:0px;padding-bottom: 5px;">PO #</td>  
                        </tr>
                   </table> 
                  </td>
                </tr>
                <tr>  
                  <td>
                   <table style="width:70%; height:100%; cellpadding:0; cellspacing:0;" align="center">
                        <tr>
                           <td style="width:25%;font-size:13px;font-family:Arial;text-align:left;padding-left:15px;padding-top: 5px;"><?php echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['invoiced_date']));;?></td>
                           <td style="width:25%;font-size:13px;font-family:Arial;text-align:left;padding-left:15px;padding-top: 5px;"><?php echo $invoiceData['SbsSubscriberPaymentTerm']['no_of_days'].' Days Net';?></td>
                           <td style="width:25%;font-size:13px;font-family:Arial;text-align:left;padding-top: 5px;"><?php if($invoiceData['AcrClientInvoice']['due_date']){echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['due_date']));}else{echo '--';}?></td> 
                           <td style="width:25%;font-size:13px;font-family:Arial;text-align:center;padding-right:0px;padding-top: 5px;"><?php if($invoiceData['AcrClientInvoice']['purchase_order_no']){ echo $invoiceData['AcrClientInvoice']['purchase_order_no'];}else { echo '--'; }?></td>  
                        </tr>
                   </table> 
                  </td> 
                </tr>
                 <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                 <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                <tr>
                  <td>
                   <table style="width:90%; height:100%;" align="center">
                        <tr>
                           <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;">Service</td>
                           <td style="width:32%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;">Description</td>
                           <td style="width:8%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Qty</td>
                            <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Rate</td>
                             <td style="width:8%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Disc %</td>
                              <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Amount</td>  
                        </tr>
                   </table> 
                  </td>
                </tr>
                <?php foreach($invoiceDetail as $k=>$v) { ?>
                	
					<tr>
						<td>
						<table style="width:90%; height:100%; cellpadding:0; cellspacing:0;" align="center">
							<tr>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['InvInventory']['name']; ?></td>
								<td style="width:32%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['inventory_description']; ?></td>
								<td style="width:8%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['quantity']; ?></td>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($v['AcrInvoiceDetail']['unit_rate']/$conversionValue,''); ?> </td>
								<td style="width:8%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['discount_percent']; ?> </td>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($v['AcrInvoiceDetail']['line_total']/$conversionValue,''); ?></td>
							</tr>
						</table></td>
					</tr>
				<?php } ?>
                <tr>  
                  <td style="padding-right:30px;">
                   <table style="width:35%; height:100%;padding-top:10px;padding-right:50px;" align="right">
                        <tr>
                             <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Subtotal</td>
                              <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:30px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($invoiceData['AcrClientInvoice']['sub_total']/$conversionValue),$invoiceData['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                        <?php foreach($taxArray as $taxKey=>$taxVal){?>
		                        <tr>
		                             <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $taxVal['taxName'];?></td>
		                              <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:30px;padding-bottom: 10px;"><?php echo $this->Number->currency($taxVal['taxAmount']/$conversionValue,$invoiceData['AcrClientInvoice']['invoice_currency_code']);?></td>  
		                        </tr>
                        <?php } ?>
                        <tr>
                             <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Total</td>
                              <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:30px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                   </table> 
                  </td> 
                </tr>
                <tr>  
                  <td>
                   <table style="width:91%; height:100%;" align="center">                        
                        <tr>
					        <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;border-bottom:1px solid #d8d8d8;"></td>
				        </tr>                        
                   </table> 
                  </td> 
                </tr>
                <tr>  
                  <td>
                   <table style="width:90%; height:100%;padding-top:15px;" align="center">  
                        <tr>
                            <td  style="padding: 3px 0;font-size:14px;font-family:arial;">
                             <?php echo $invoiceData['AcrClientInvoice']['notes'];?>                            </td>
                        </tr>
                    </table>
                  </td>
               </tr> 
                  <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>                  
                <tr>  
                  <td>
                   <table style="width:50%; height:100%;padding-top:15px;" align="center">  
                        <tr>
                            <td  style="padding: 3px 0;font-size:20px;font-weight:bold;text-align:center;font-family:arial;">
                            Thank you for your business
                            </td>
                        </tr>
                       
                    </table>
                  </td>
               </tr>  
                  <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                <tr>  
                  <td>
                   <table style="width:90%; height:100%;padding-top:15px;" align="center">  
                        <tr>
                            <td  style="padding: 3px 0;font-size:15px;font-family:arial;font-weight:bold;">
                             Term and Conditions
                            </td>
                        </tr>
                        <tr>
                            <td  style="padding: 3px 0;font-size:14px;font-family:arial;text-align:justify;">
                            <?php echo $invoiceData['AcrClientInvoice']['term_conditions'];?>
                            </td>
                        </tr>
                    </table>
                  </td>
               </tr>
                  <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                  <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>  
            </table>
        </td>
    </tr>
    
    
</table>

<?php endif;?>
	
<?php if($mailTemplate == 'sent_invoice_service_modern'):?>
	
<table style="width:100%; height:100%; border:0; cellspacing:0;cellpadding:0; background:#f0f0f0;padding:30px 0px;">
	<tr>
    	<td>
        	<table cellspacing="0" style="width:900px;padding:0px; background:#fff; height:100%; border:1px solid #d8d8d8; margin:auto; align:center; cellpadding:0; cellspacing:0; bgcolor:#ffffff;">
            	<tr>
                   <td>
                   <table style="width:100%; height:100%;">
                       <tr>                        
                           <td align="right" style="width:50%;border:0;padding: 15px 40px;border-bottom:1px solid #e9e9e9">
                          <table style="width:100%; height:100%;" align="left">
                             <tr>
                                <td style="font-size:30px;font-weight:bold;font-family:Arial;color:#4E68A1;">INVOICE</td>                           
                            </tr> 
                            <tr>
                                <td>
                                    <span style="float:left;width:100px;font-family:Arial;">Inv #</span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php echo $invoiceData['AcrClientInvoice']['invoice_number'];?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="float:left;width:100px;font-family:Arial;">PO #</span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php if($invoiceData['AcrClientInvoice']['purchase_order_no']){ echo $invoiceData['AcrClientInvoice']['purchase_order_no'];}else { echo '--'; }?></span>
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    <span style="float:left;width:100px;font-family:Arial;">Invoiced Date</span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['invoiced_date']));;?></span>
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    <span style="float:left;width:100px;font-family:Arial;">Due Date</span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php if($invoiceData['AcrClientInvoice']['due_date']){echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['due_date']));}else{echo '--';}?></span>
                                </td>
                            </tr>  
                          </table>    
                        </td>
                           <td align="right" style="width:50%;border:0;padding: 15px 40px;border-bottom:1px solid #e9e9e9">
                               <?php if($logo) {?>
										<img src="<?php echo $imgLink.$logo;?>" alt="Logo"/>
										
									<?php } else { ?>
											<img src="<?php echo $imgLink.$webroot_name.'img/logo.png';?>" alt="Cantorix Logo"/>
									<?php }?>
                           </td>
                       </tr>
                   </table> 
                  </td> 
                </tr>
                <tr>
                   <td>
                   <table style="width:100%; height:100%;">
                       <tr>
                           <td align="left" style="width:50%;border:0;padding: 10px 40px;vertical-align: top;">                            
                               <table style="width:100%;" align="left">
                             <tr>
                                <td style="font-size:14px;font-family:Arial;font-weight: bold;">Invoice To:</td>
                             </tr> 
                             <tr>
                                <td style="font-size:18px;font-weight:bold;font-family:Arial;"><?php echo $customerDetails['AcrClient']['client_name'];?></td>        
                             </tr>
                             <?php if(!empty($customerDetails['AcrClient']['billing_address_line1'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_address_line1'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($customerDetails['AcrClient']['billing_address_line2'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_address_line2'];?></td>        
                             </tr>
                             <?php endif;?>
                               <?php if(!empty($customerDetails['AcrClient']['billing_city'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_city'];?></td>        
                             </tr>
                              <?php endif;?>
                              <?php if(!empty($customerDetails['AcrClient']['billing_state'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_state'];?></td>        
                             </tr>
                              <?php endif;?>
                              <?php if(!empty($customerDetails['AcrClient']['billing_country'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_country'];?></td>        
                             </tr>
                              <?php endif;?>
                              <?php if(!empty($customerDetails['AcrClient']['billing_zip'])):?>
                              <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_zip'];?></td>        
                             </tr>
                              <?php endif;?>	
                          </table>
                           </td>
                           <td align="right" style="width:50%;border:0;padding: 10px 40px;vertical-align: top;">
                            <table style="width:80%;  background:#4e68a1;color:#fff;padding:15px;
                            text-align:right;" align="right">
                             <tr><td>&nbsp;&nbsp;</td>
                             </tr>
                             <tr>
                                <td style="font-size:18px;font-weight:bold;font-family:Arial;padding-left:20px;padding-right:20px"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['organization_name'];?></td>        
                             </tr>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'];?></td>        
                             </tr>
                              <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'];?></td>        
                             </tr>
                              <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'])):?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'];?></td>        
                             </tr>
                             <?php endif;?>
                             <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'])):?>
                             	<tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];?></td>        
                             </tr>
                             <?php endif;?>   
                            </table> 
                           </td>
                        </tr>
                   </table> 
                  </td> 
                </tr>
                 <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                 <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                 <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                 <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                <tr>
                  <td>
                   <table style="width:90%; height:100%;" align="center">
                        <tr>
                           <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;">Service</td>
                           <td style="width:32%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;">Description</td>
                           <td style="width:8%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Qty</td>
                            <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Rate</td>
                             <td style="width:8%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Disc %</td>
                              <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Amount</td>  
                        </tr>
                   </table> 
                  </td>
                </tr>
                 <?php foreach($invoiceDetail as $k=>$v) { ?>
					<tr>
						<td>
						<table style="width:90%; height:100%; cellpadding:0; cellspacing:0;" align="center">
							<tr>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['InvInventory']['name']; ?></td>
								<td style="width:32%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['inventory_description']; ?></td>
								<td style="width:8%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['quantity']; ?></td>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($v['AcrInvoiceDetail']['unit_rate']/$conversionValue,''); ?> </td>
								<td style="width:8%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['discount_percent']; ?> </td>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($v['AcrInvoiceDetail']['line_total']/$conversionValue,''); ?></td>
							</tr>
						</table></td>
					</tr>
				<?php } ?>
                <tr>  
                  <td>
                   <table style="width:90%; height:100%;padding-top:10px; background:#F5F5F5;border-bottom:1px solid #d8d8d8" align="center">
                        <tr>
                        <td>
                        <table  style="width:32%; height:100%;padding-top:10px; background:#F5F5F5;" align="right">
                        <tr>
                        <td>
                        <tr>
                             <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Subtotal</td>
                              <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($invoiceData['AcrClientInvoice']['sub_total']/$conversionValue),$invoiceData['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                        <?php foreach($taxArray as $taxKey=>$taxVal){?>
		                        <tr>
		                             <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $taxVal['taxName'];?></td>
		                              <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $this->Number->currency($taxVal['taxAmount']/$conversionValue,$invoiceData['AcrClientInvoice']['invoice_currency_code']);?></td>  
		                        </tr>
                        <?php } ?>
                        <tr>
                             <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Total</td>
                              <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                        </td>
                        </tr>
                        </table>
                        </td>
                        </tr>
                   </table> 
                  </td> 
                </tr>
                
                <tr>  
                  <td>
                   <table style="width:90%; height:100%;padding-top:15px;" align="center">  
                        <tr>
                            <td  style="padding: 3px 0;font-size:14px;font-family:arial;">
                            <?php echo $invoiceData['AcrClientInvoice']['notes'];?>
                            </td>
                        </tr>
                    </table>
                  </td>
               </tr> 
                  <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>                  
                <tr>  
                  <td>
                   <table style="width:50%; height:100%;padding-top:15px;" align="center">  
                        <tr>
                            <td  style="padding: 3px 0;font-size:20px;font-weight:bold;text-align:center;font-family:arial;color:#4e68a1">
                            Thank you for your business
                            </td>
                        </tr>
                       
                    </table>
                  </td>
               </tr> 
                <tr>  
                  <td>
                   <table style="width:90%; height:100%;padding-top:15px;" align="center">  
                        <tr>
                            <td  style="padding: 3px 0;font-size:15px;font-family:arial;font-weight:bold;">
                             Term and Conditions
                            </td>
                        </tr>
                        <tr>
                            <td  style="padding: 3px 0;font-size:14px;font-family:arial;text-align:justify;">
                            <?php echo $invoiceData['AcrClientInvoice']['term_conditions'];?>
                            </td>
                        </tr>
                    </table>
                  </td>
               </tr>
                  <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>
                  <tr>
					<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
				</tr>  
            </table>
        </td>
    </tr>
    
    
</table>
</body>
</html>

<?php endif;?>