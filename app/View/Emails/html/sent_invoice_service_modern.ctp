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
<?php if($invoiceData['AcrClientInvoice']['exchange_rate']){
	$invoiceData['AcrClientInvoice']['exchange_rate'] = $invoiceData['AcrClientInvoice']['exchange_rate'];
}else{
	$invoiceData['AcrClientInvoice']['exchange_rate'] = 1;
}?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width" />
<title><?php echo __('CantoriX');?></title>
</head>

<body style="margin:0 auto;padding:0;">
<table style="width:100%; height:100%; border:0; cellspacing:0;cellpadding:0; background:#f0f0f0;padding:10px 5px 0 20px;">
	<tr>
		<?php echo "Hello ".$invoiceData['AcrClient']['client_name'];?>
	</tr>
	<tr>
		<?php echo '<pre style="float:left; width:90%;padding-left:4%; white-space: pre-wrap; white-space: -moz-pre-wrap; white-space: -pre-wrap;  white-space: -o-pre-wrap; word-wrap: break-word;">'.$content.'</pre>';?>
	</tr>
</table>
<table style="width:100%; height:100%; border:0; cellspacing:0;cellpadding:0; background:#f0f0f0;padding:5px 0px;">
	<tr>
    	<td>
        	<table cellspacing="0" style="width:1100px;padding:0px; background:#fff; height:100%; border:1px solid #d8d8d8; margin:auto; align:center; cellpadding:0; cellspacing:0; bgcolor:#ffffff;">
            	<tr>
                   <td>
                   <table style="width:100%; height:100%;">
                       <tr>                        
                           <td align="right" style="width:50%;border:0;padding: 30px 40px;border-bottom:1px solid #e9e9e9">
                          <table style="width:50%; height:100%;" align="left">
                             <tr>
                                <td style="font-size:30px;float:left;width:130px;font-weight:bold;font-family:Arial;color:#4E68A1;padding-left:0px;"><?php echo __('INVOICE');?></td>                           
                            </tr> 
                            <tr>
                                <td style="float:left;width:85px;font-family:Arial;font-size: 14px;">
                                	<?php echo __('Inv #');?>
                                    <!--<span style="float:left;width:100px;font-family:Arial;font-size: 14px;"><?php echo __('Inv #');?></span>
                                    <span style="font-weight:bold;font-family:Arial;font-size:14px;"><?php echo $invoiceData['AcrClientInvoice']['invoice_number']; ?></span>-->
                                </td>
                                <td style="font-weight:bold;font-family:Arial;font-size:14px;">
                                	<?php echo $invoiceData['AcrClientInvoice']['invoice_number']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="float:left;width:85px;font-family:Arial;font-size: 14px;">
                                	<?php echo __('PO #');?>
                                    <!--<span style="float:left;width:100px;font-family:Arial;font-size: 14px;"><?php echo __('PO #');?></span>
                                    <span style="font-weight:bold;font-family:Arial;font-size:14px;"><?php echo $invoiceData['AcrClientInvoice']['purchase_order_no']; ?></span>-->
                                </td>
                                <td style="font-weight:bold;font-family:Arial;font-size:14px;">
                                	<?php echo $invoiceData['AcrClientInvoice']['purchase_order_no']; ?>
                                </td>
                            </tr> 
                            <tr>
                                <td style="float:left;width:85px;font-family:Arial;font-size: 14px;">
                                	<?php echo __('Invoice Date');?>
                                    <!--<span style="float:left;width:100px;font-family:Arial;font-size: 14px;"><?php echo __('Invoiced Date');?></span>
                                    <span style="font-weight:bold;font-family:Arial;font-size:14px;"><?php echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['invoiced_date'])); ?></span>-->
                                </td>
                                <td style="font-weight:bold;font-family:Arial;font-size:14px;">
                                	<?php echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['invoiced_date'])); ?>
                                </td>
                            </tr> 
                            <tr>
                                <td style="float:left;width:85px;font-family:Arial;font-size: 14px;">
                                	<?php echo __('Due Date');?>
                                    <!--<span style="float:left;width:100px;font-family:Arial;font-size: 14px;"><?php echo __('Due Date');?></span>
                                    <span style="font-weight:bold;font-family:Arial;font-size:14px;"><?php  echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['due_date'])); ?></span>-->
                                </td>
                                <td style="font-weight:bold;font-family:Arial;font-size:14px;">
                                	<?php  echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['due_date'])); ?>
                                </td>
                            </tr>  
                          </table>    
                        </td>
                           <td align="right" style="width:50%;border:0;padding: 30px 40px;border-bottom:1px solid #e9e9e9">
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
                           <td align="left" style="width:50%;border:0;padding: 10px 40px; vertical-align: top;">                            
                               <table style="width:100%;" align="left">
                             <tr>
                                <td style="font-size:14px;font-family:Arial;font-weight:bold;"><?php echo __('Invoice To:');?></td>
                             </tr> 
                             <?php if($invoiceData['AcrClient']['organization_name']){?>
									<tr>
										<td style="font-size:18px;font-weight:bold;font-family:Arial;"><?php echo $invoiceData['AcrClient']['organization_name']; ?></td>
									</tr>
									<?php }else{ ?>
										<tr>
										<td style="font-size:18px;font-weight:bold;font-family:Arial;"><?php echo $invoiceData['AcrClient']['client_name']; ?></td>
									</tr>
							<?php } ?>
							<?php if($invoiceData['AcrClient']['billing_address_line1']){?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $invoiceData['AcrClient']['billing_address_line1']; ?></td>        
                             </tr>
                             <?php } ?>
                             <?php if($invoiceData['AcrClient']['billing_address_line2']){?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $invoiceData['AcrClient']['billing_address_line2']; ?></td>        
                             </tr>
                             <?php } ?>
                             <?php if($invoiceData['AcrClient']['billing_city']){?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $invoiceData['AcrClient']['billing_city']; ?></td>        
                             </tr>
                             <?php } ?> 
                             <?php if($invoiceData['AcrClient']['billing_state']){?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $invoiceData['AcrClient']['billing_state'];?></td>        
                             </tr> 
                             <?php } ?>
                             <?php if($invoiceData['AcrClient']['billing_country']){?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $invoiceData['AcrClient']['billing_country']; ?></td>        
                             </tr> 
                             <?php } ?>
                             <?php if($invoiceData['AcrClient']['billing_zip']){?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $invoiceData['AcrClient']['billing_zip']; ?></td>        
                             </tr>
                             <?php } ?>   
                          </table>
                           </td>
                           <td align="right" style="width:50%;border:0;padding: 10px 40px; vertical-align: top;">
                            <table style="width:60%; background:#4e68a1;color:#fff;padding:0px 25px 0px 15px;
                            text-align:right;" align="right">
                             <tr>
                                <td style="font-size:14px;font-family:Arial;font-weight:bold;">&nbsp;</td>
                             </tr> 
                             <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['organization_name']){ ?>
                             <tr>
                                <td style="font-size:18px;font-weight:bold;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['organization_name'];?></td>        
                             </tr>
                             <?php } ?>
                             <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1']){ ?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'];?></td>        
                             </tr>
                             <?php } ?>
                             <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2']){ ?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'];?></td>        
                             </tr>
                             <?php } ?>
                             <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_city']){ ?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'];?></td>        
                             </tr> 
                             <?php } ?>
                             <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_state']){ ?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'];?></td>        
                             </tr> 
                             <?php } ?>
                             <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_country']){ ?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'];?></td>        
                             </tr>
                             <?php } ?> 
                             <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip']){ ?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];?></td>        
                             </tr>  
                             <?php } ?> 
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
                           <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;"><?php echo __('Service');?></td>
                           <td style="width:20%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-bottom: 10px;padding-top:10px;"><?php echo __('Description');?></td> 
                           <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo __('Qty');?></td>
                            <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo __('Rate');?></td>
                             <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo __('Disc %');?></td>
                              <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo __('Amount');?></td>  
                        </tr>
                   </table> 
                  </td>
                </tr>
                <?php foreach($invoiceDetail as $k=>$v) { ?>
	                <tr>  
	                  <td>
	                   <table style="width:90%; height:100%; cellpadding:0; cellspacing:0;" align="center">
	                        <tr>
	                           <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;color:#4E68A1;"><?php echo $v['InvInventory']['name']; ?>&nbsp;</td>
	                           <td style="width:20%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['inventory_description']; ?>&nbsp;</td> 
	                           <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['quantity']; ?></td>
	                            <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($v['AcrInvoiceDetail']['unit_rate']/$invoiceData['AcrClientInvoice']['exchange_rate'],''); ?></td>
	                             <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['discount_percent']; ?>%</td>
	                              <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($v['AcrInvoiceDetail']['line_total']/$invoiceData['AcrClientInvoice']['exchange_rate'],''); ?></td>  
	                        </tr>
	                   </table> 
	                  </td> 
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
                             <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo __('Subtotal');?></td>
                              <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['sub_total']/$invoiceData['AcrClientInvoice']['exchange_rate'],$invoiceData['AcrClientInvoice']['invoice_currency_code']); ?></td>  
                        </tr>
                        <?php foreach($taxArray as $taxKey=>$taxVal){?>
	                        <tr>
	                             <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $taxVal['taxName'];?></td>
	                              <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $this->Number->currency($taxVal['taxAmount']/$invoiceData['AcrClientInvoice']['exchange_rate'],$invoiceData['AcrClientInvoice']['invoice_currency_code']);?></td>  
	                        </tr>
                        <?php } ?>
                        <tr>
                             <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo __('Invoice Total');?></td>
                              <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code']); ?></td>  
                        </tr>
                        <tr>
                             <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo __('Payments');?></td>
                              <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $this->Number->currency($paidAmount,$invoiceData['AcrClientInvoice']['invoice_currency_code']); ?></td>  
                        </tr>
                        <tr>
                             <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo __('Balanace Due');?></td>
                              <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;color:red;"><?php echo $this->Number->currency($balanceDue,$invoiceData['AcrClientInvoice']['invoice_currency_code']); ?></td>  
                        </tr>
                      
                        </td>
                        </tr>
                        </table>
                        </td>
                        </tr>
                   </table> 
                  </td> 
                </tr>
               <!--newly added--> 
                <tr>
                	<td>
						<table style="width:90%; height:100%;padding-top:10px;" align="center">
                        <tr>
                        <td>
                        <table  style="width:100%; height:100%;padding-top:10px;" align="left">
                        <tr>
                        <td>
                        <?php if($payPalLink):?>
                        <tr>
                          <td style="width:15%;font-size:15px;font-family:Arial;text-align:left;padding-right:15px;padding-bottom: 10px;">Pay now online via:</td>
                           <td style="width:85%;font-size:13px;font-family:Arial;text-align:left;padding-bottom: 10px;"><a href = "<?php echo $payPalLink?>"><img src="<?php echo $imgLink.$webroot_name.'img/Paypal.png';?>" alt="Pay Link"/></a></td>  
                        </tr>
                        <?php endif;?>
                        </td>
                        </tr>
                        </table>
                        </td>
                        </tr>
                   </table> </td>
                	
                </tr>
                <!--newly added--> 
                <tr>  
                  <td>
                   <table style="width:90%; height:100%;padding-top:15px;" align="center">  
                        <tr>
                            <td  style="padding: 3px 0;font-size:15px;font-family:arial;font-weight:bold;">
                             <?php echo __('Customer Note');?>
                            </td>
                        </tr>
                        <tr>
                            <td  style="padding: 3px 0;font-size:14px;font-family:arial;">
                            <?php echo $invoiceData['AcrClientInvoice']['notes']; ?>
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
                            <td  style="padding: 3px 0;font-size:14px;font-weight:bold;text-align:center;font-family:arial;color:#4e68a1">
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
                             <?php echo __('Terms and Conditions');?>
                            </td>
                        </tr>
                        <tr>
                            <td  style="padding: 3px 0;font-size:14px;font-family:arial;text-align:justify;">
                            <?php echo $invoiceData['AcrClientInvoice']['term_conditions']; ?>
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
						<table style="width:90%; height:100%;padding-top:15px;" align="center">
							<tr>
								<td  style="padding: 3px 0;font-size:15px;font-family:arial;font-weight:bold;"> 
										 <br>
										<?php echo '<pre>'.$signature.'</pre>'; ?>
								</td>
							</tr>
							
						</table></td>
					</tr>
            </table>
        </td>
    </tr>
    
    
</table>
</body>
</html>