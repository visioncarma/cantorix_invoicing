<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php
	if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
	  $protocol_final = 'https';
	}else{
	  $protocol_final = 'http';
	}
	$http_hostname = $_SERVER['HTTP_HOST'];
	$webroot_name = $this->webroot;
	$imgLink = "$protocol_final".'://'."$http_hostname/";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width" />
<title>CantoriX</title>
</head>

<body style="margin:0 auto;padding:0;">
<table style="width:100%; height:100%; border:0; cellspacing:0;cellpadding:0; background:#f0f0f0;padding:10px 5px 0 20px;">
	<tr>
		<?php echo "Hello ".$customerDetails['AcrClient']['client_name'];?>
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
                                <td style="font-size:30px;width:110px;float:left;font-weight:bold;font-family:Arial;color:#4E68A1;padding-bottom: 5px; padding-left:0px;">QUOTE</td>                           
                            </tr> 
                            <tr>
                                <td style="float:left;width:85px;font-family:Arial; font-size: 14px;">
                                	Quote #
                                    <!--<span style="float:left;width:90px;font-family:Arial; font-size: 14px;">Quote #</span>
                                    <span style="font-weight:bold;font-family:Arial;font-size:14px;"><?php echo $data['AcrClientInvoice']['quote_no'];?></span>-->
                                </td>
                                <td style="font-weight:bold;font-family:Arial;font-size:14px;">
                                	<?php echo $data['AcrClientInvoice']['quote_no'];?>
                                </td>
                            </tr>
                            <tr>
                                <td style="float:left;width:85px;font-family:Arial;font-size:14px;">
                                	PO #
                                    <!--<span style="float:left;width:90px;font-family:Arial;font-size:14px;">PO #</span>
                                    <span style="font-weight:bold;font-family:Arial;font-size:14px;"><?php if($data['AcrClientInvoice']['purchase_order_no']){ echo $data['AcrClientInvoice']['purchase_order_no'];}else { echo '--'; }?></span>
                                	-->
                                </td>
                                <td style="font-weight:bold;font-family:Arial;font-size:14px;">
                                	<?php if($data['AcrClientInvoice']['purchase_order_no']){ echo $data['AcrClientInvoice']['purchase_order_no'];}else { echo ' '; }?>
                                </td>
                            </tr> 
                            <tr>
                                <td style="float:left;width:85px;font-family:Arial;font-size:14px;">
                                	Issue Date
                                   <!-- <span style="float:left;width:90px;font-family:Arial;font-size:14px;">Issue Date</span>
                                    <span style="font-weight:bold;font-family:Arial;font-size:15px;"><?php echo $data['AcrClientInvoice']['issueDate'];?></span>-->
                                </td>
                                <td style="font-weight:bold;font-family:Arial;font-size:15px;">
                                	<?php echo $data['AcrClientInvoice']['issueDate'];?>
                                </td>
                            </tr> 
                            <tr>
                                <td style="float:left;width:85px;font-family:Arial;font-size:14px;">
                                	Expiry Date
                                    <!--<span style="float:left;width:90px;font-family:Arial;font-size:14px;">Expiry Date</span>
                                    <span style="font-weight:bold;font-family:Arial;font-size:15px;"><?php if(!empty($data['AcrClientInvoice']['expiryDate'])) {echo $data['AcrClientInvoice']['expiryDate'];} else {echo '--';}?></span>
                                	-->
                                </td>
                                <td style="font-weight:bold;font-family:Arial;font-size:15px;">
                                	<?php if(!empty($data['AcrClientInvoice']['expiryDate'])) {echo $data['AcrClientInvoice']['expiryDate'];} else {echo ' ';}?>
                                </td>
                            </tr>  
                          </table>    
                        </td>
                           <td align="right" style="width:50%;border:0;padding: 30px 40px;border-bottom:1px solid #e9e9e9">
                               <?php if(!empty($settings['SbsSubscriberSetting']['invoice_logo'])) {?>
								<img src="<?php echo $imgLink.$settings['SbsSubscriberSetting']['invoice_logo'];?>" alt="Logo"/>
								
								<?php } else { ?>
									<img src="<?php echo $imgLink.$webroot_name.'img/logo.png';?>" alt="Cantorix Logo"/>
								<?php }?>
								<?php if(!empty($settings['SbsSubscriberSetting']['text_logo'])) {
	                              	echo '<div>'.$settings['SbsSubscriberSetting']['text_logo'].'</div>';
	                            }?>
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
                                <td style="font-size:14px;font-family:Arial;font-weight: bold;">Quote To:</td>
                             </tr> 
                             <?php if($customerDetails['AcrClient']['organization_name']){?>
                             <tr>
                                <td style="font-size:18px;font-weight:bold;font-family:Arial;"><?php echo $customerDetails['AcrClient']['organization_name'];?></td>        
                             </tr>
                             <?php } ?>
                             <?php if($customerDetails['AcrClient']['billing_address_line1']){?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_address_line1'];?></td>        
                             </tr>
                             <?php } ?>
                             <?php if($customerDetails['AcrClient']['billing_address_line2']){?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_address_line2'];?></td>        
                             </tr>
                             <?php } ?>
                             <?php if($customerDetails['AcrClient']['billing_city']){?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_city'];?></td>        
                             </tr> 
                             <?php } ?>
                             <?php if($customerDetails['AcrClient']['billing_state']){?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_state'];?></td>        
                             </tr> 
                             <?php } ?>
                             <?php if($customerDetails['AcrClient']['billing_country']){?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_country'];?></td>        
                             </tr>
                             <?php } ?>
                             <?php if($customerDetails['AcrClient']['billing_zip']){?>
                              <tr>
                              		<td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_zip'];?></td>     
                              </tr>
                              <?php } ?>
                          </table>
                           </td>
                           <td align="right" style="width:50%;border:0;padding: 10px 40px; vertical-align: top;">
                            <table style="width:60%; background:#4e68a1;color:#fff;padding: 0px 27px 0px 15px;text-align:right;" align="right">
                             <tr>
                                <td style="font-size:14px;font-family:Arial;">&nbsp;</td>
                             </tr>
                             <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['organization_name']){?>
                             <tr>
                                <td style="font-size:18px;font-weight:bold;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['organization_name'];?></td>        
                             </tr>
                             <?php } ?>
                             <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1']){?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'];?></td>        
                             </tr>
                             <?php } ?>
                             <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2']){?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'];?></td>        
                             </tr>
                             <?php } ?>
                             <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_city']){?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'];?></td>        
                             </tr> 
                             <?php } ?>
                             <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_state']){?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'];?></td>        
                             </tr> 
                             <?php } ?>
                             <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_country']){?>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'];?></td>        
                             </tr>  
                              <?php } ?>
                              <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip']){?>
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
                           <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;">Item</td>
                           <td style="width:20%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-bottom: 10px;padding-top:10px;">Description</td> 
                           <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Qty</td>
                            <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Unit Price</td>
                             <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Disc %</td>
                              <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Amount</td>  
                        </tr>
                   </table> 
                  </td>
                </tr>
                 <?php foreach($data['AcrClientInvoice']['inventory'] as $index => $inventory):?>
                <?php if($inventory):?>
                	<?php if(!$data['AcrClientInvoice']['conversionValue']){$data['AcrClientInvoice']['conversionValue'] = 1;}?>
                <tr>  
                  <td>
                   <table style="width:90%; height:100%; cellpadding:0; cellspacing:0;" align="center">
                        <tr>
                           <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;color:#4E68A1;"><?php if(!empty($inventories[$inventory])) { echo $inventories[$inventory];} else { echo "&nbsp;"; }?></td>
                           <td style="width:20%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-bottom: 10px;padding-top:10px;"><?php echo $data['AcrClientInvoice']['description'][$index];?></td> 
                           <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $data['AcrClientInvoice']['quantity'][$index];/*echo $data['AcrClientInvoice']['unitTypeofInventory'][$index];*/?></td>
                            <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($data['AcrClientInvoice']['unit_rate'][$index]/$data['AcrClientInvoice']['conversionValue']), '' /*$data['AcrClientInvoice']['invoice_currency_code']*/);?></td>
                             <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php if($data['AcrClientInvoice']['discount_percent'][$index]){echo $data['AcrClientInvoice']['discount_percent'][$index];} else {echo '0';}?>%</td>
                              <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($data['AcrClientInvoice']['line_total_hidden'][$index]/$data['AcrClientInvoice']['conversionValue']),''/*$data['AcrClientInvoice']['invoice_currency_code']*/);?></td>  
                        </tr>
                   </table> 
                  </td> 
                </tr>
                 <?php endif;?>
                <?php endforeach;?>
                
                <tr>  
                  <td>
                   <table style="width:90%; height:100%;padding-top:0px; background:#F5F5F5;border-bottom:1px solid #d8d8d8" align="center">
                        <tr>
                        <td>
                        <table  style="width:32%; height:100%;padding-top:10px; background:#F5F5F5;" align="right">
                        <tr>
                             <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Subtotal</td>
                              <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:13px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($data['AcrClientInvoice']['subTotal']/$data['AcrClientInvoice']['conversionValue']),$data['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                        <?php foreach($data['AcrClientInvoice']['taxValue'] as $taxID => $taxAmount):?>
                        <tr>
                             <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $taxes[$taxID];?></td>
                              <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:13px;padding-bottom: 10px;"><?php echo $this->Number->currency(($taxAmount/$data['AcrClientInvoice']['conversionValue']),$data['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                        <?php endforeach;?>
                        <tr>
                             <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Total</td>
                              <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:13px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($data['AcrClientInvoice']['invoicetotal'],$data['AcrClientInvoice']['invoice_currency_code']);?></td>  
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
                            <td  style="padding: 3px 0;font-size:15px;font-family:arial;font-weight:bold;">
                             Customer Notes
                            </td>
                        </tr>
                        <tr>
                            <td  style="padding: 3px 0;font-size:14px;font-family:arial;">
                             <?php echo $data['AcrClientInvoice']['notes'];?>
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
                             Terms and Conditions
                            </td>
                        </tr>
                        <tr>
                            <td  style="padding: 3px 0;font-size:14px;font-family:arial;text-align:justify;">
                            <?php echo $data['AcrClientInvoice']['terms'];?>
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
										<!--Yours Faithfully --><br>
										<?php echo '<pre>'.$signature.'</pre>'; ?>
								</td>
							</tr>  
            </table>
        </td>
    </tr>
    
</table>
</body>
</html>