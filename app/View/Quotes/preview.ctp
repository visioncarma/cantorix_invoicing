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
<?php if($data['AcrClientInvoice']['email_template'] == 'quote_product_classic'):?>

	
<table style="width:100%; height:100%; border:0; cellspacing:0;cellpadding:0; background:#f0f0f0;padding:30px 0px;">
	<tr>
    	<td>
        	<table cellspacing="0" style="width:900px;padding:0px; background:#fff; height:100%; border:1px solid #d8d8d8; margin:auto; align:center; cellpadding:0; cellspacing:0; bgcolor:#ffffff;">
            	<tr>
                   <td>
                   <table style="width:100%; height:100%;">
                       <tr>
                        <td align="left" style="width:50%;border:0;padding: 15px 27px;border-bottom:1px solid #e9e9e9">
                               <?php if(!empty($settings['SbsSubscriberSetting']['invoice_logo'])) { ?>
                              		<img src="<?php echo $imgLink.$settings['SbsSubscriberSetting']['invoice_logo'];?>" alt="Logo"/>
                              <?php } else { ?>
                              		<img src="<?php echo $imgLink.$webroot_name.'/img/logo.png';?>" alt="Cantorix Logo"/>	
                              <?php }?>
                              <?php if(!empty($settings['SbsSubscriberSetting']['text_logo'])) {
                              	echo '<div>'.$settings['SbsSubscriberSetting']['text_logo'].'</div>';
                              }?>
                        </td>
                        <td align="right" style="width:50%;border:0;padding: 15px 40px;border-bottom:1px solid #e9e9e9">
                          <table style="width:100%; height:100%;" align="right">
                             <tr>
                                <td style="font-size:30px;text-align: right;padding-right: 15px;font-weight:bold;font-family:Arial;">QUOTE</td>                           
                            </tr> 
                            <tr>
                                <td style="text-align: right;padding-right: 15px;">
                                    <span style="margin-right:15px;font-family:Arial;">Quote #</span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php echo $data['AcrClientInvoice']['quote_no'];?></span>
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
                                <td style="font-size:14px;font-weight:bold;font-family:Arial;">From:</td>                         
                             </tr> 
                             <tr >
                                <td style="font-size:18px;font-weight:bold;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['organization_name'];?></td>        
                             </tr>
                             <tr >
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'];?></td>        
                             </tr>
                             <tr>
	                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'];?></td>        
	                         </tr>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];?></td>        
                             </tr>
                          </table>  
                        </td>
                           <td align="right" style="width:50%;border:0;padding: 10px 40px;vertical-align: top;">
                            <table style="width:100%;" align="right">
                             <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-weight:bold;font-family:Arial;">Quote To:</td>
                             </tr> 
                             <tr>
                                <td style="font-size:18px;text-align: right;padding-right: 15px;font-weight:bold;font-family:Arial;"><?php echo $customerDetails['AcrClient']['organization_name'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_address_line1'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_address_line2'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_city'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_state'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_country'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_zip'];?></td>        
                             </tr>
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
                           <td style="width:33%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 5px;">Issue Date</td>
                           <td style="width:33%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:center;padding-bottom: 5px;">Expiry Date</td> 
                           <td style="width:33%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:center;padding-right:0px;padding-bottom: 5px;">PO #</td>  
                        </tr>
                   </table> 
                  </td>
                </tr>
                <tr>  
                  <td>
                   <table style="width:70%; height:100%; cellpadding:0; cellspacing:0;" align="center">
                        <tr>
                           <td style="width:33%;font-size:13px;font-family:Arial;text-align:left;padding-left:15px;padding-top: 5px;"><?php echo $data['AcrClientInvoice']['issueDate'];?></td>
                           <td style="width:33%;font-size:13px;font-family:Arial;text-align:center;padding-top: 5px;"><?php if($data['AcrClientInvoice']['expiryDate']) {echo $data['AcrClientInvoice']['expiryDate'];} else {echo '--';}?></td> 
                           <td style="width:33%;font-size:13px;font-family:Arial;text-align:center;padding-right:0px;padding-top: 5px;"><?php if($data['AcrClientInvoice']['purchase_order_no']){ echo $data['AcrClientInvoice']['purchase_order_no'];}else { echo '--'; }?></td>  
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
                           <td style="width:10%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;">Item</td>
                           <td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;">Description</td>
                            <td style="width:12%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Qty</td>
                            <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Unit Price</td>
                             <td style="width:12%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Disc %</td>
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
                           <td style="width:10%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;"><?php if(!empty($inventories[$inventory])) echo $inventories[$inventory]; else echo "&nbsp;";?></td>
                           <td style="width:25%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $data['AcrClientInvoice']['description'][$index];?></td>
                           <td style="width:12%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $data['AcrClientInvoice']['quantity'][$index];/*if(!empty($data['AcrClientInvoice']['unitTypeofInventory'][$index])) echo $data['AcrClientInvoice']['unitTypeofInventory'][$index]*/;?></td>
                            <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($data['AcrClientInvoice']['unit_rate'][$index]/$data['AcrClientInvoice']['conversionValue']),'');?></td>
                             <td style="width:12%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php if($data['AcrClientInvoice']['discount_percent'][$index]){echo $data['AcrClientInvoice']['discount_percent'][$index];} else {echo '0';}?>%</td>
                              <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($data['AcrClientInvoice']['line_total_hidden'][$index]/$data['AcrClientInvoice']['conversionValue']),'');?></td>  
                        </tr>
                   </table> 
                  </td> 
                </tr>
                <?php endif;?>
                <?php endforeach;?>
                
                             
                
                
                
                <tr>  
                  <td style="padding-right:30px;">
                   <table style="width:40%; height:100%;" align="right">
                        <tr>
                             <td style="width:55%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Subtotal</td>
                              <td style="width:45%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:32px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($data['AcrClientInvoice']['subTotal']/$data['AcrClientInvoice']['conversionValue']),$data['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                        <?php foreach($data['AcrClientInvoice']['taxValue'] as $taxID => $taxAmount):?>
                        <tr>
                             <td style="width:55%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $taxes[$taxID];?></td>
                              <td style="width:45%;font-size:13px;font-family:Arial;text-align:right;padding-right:32px;padding-bottom: 10px;"><?php echo $this->Number->currency(($taxAmount/$data['AcrClientInvoice']['conversionValue']),$data['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                        <?php endforeach;?>
                        <tr>
                             <td style="width:55%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Total</td>
                              <td style="width:45%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:32px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($data['AcrClientInvoice']['invoicetotal'],$data['AcrClientInvoice']['invoice_currency_code']);?></td>  
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
                            <td  style="padding: 3px 0;font-size:15px;font-family:arial;font-weight:bold;">
                             Customer Note
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
            </table>
        </td>
    </tr>
    
    
</table>
<?php endif;?>

<?php if($data['AcrClientInvoice']['email_template'] == 'quote_product_modern'):?>
	
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
                                <td style="font-size:30px;font-weight:bold;font-family:Arial;color:#4E68A1;">QUOTE</td>                           
                            </tr> 
                            <tr>
                                <td>
                                    <span style="float:left;width:90px;font-family:Arial;">Quote #</span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php echo $data['AcrClientInvoice']['quote_no'];?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="float:left;width:90px;font-family:Arial;">PO #</span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php if($data['AcrClientInvoice']['purchase_order_no']){ echo $data['AcrClientInvoice']['purchase_order_no'];}else { echo '--'; }?></span>
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    <span style="float:left;width:90px;font-family:Arial;">Issue Date</span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php echo $data['AcrClientInvoice']['issueDate'];?></span>
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    <span style="float:left;width:90px;font-family:Arial;">Expiry Date</span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php if($data['AcrClientInvoice']['expiryDate']) {echo $data['AcrClientInvoice']['expiryDate'];} else {echo '--';}?></span>
                                </td>
                            </tr>  
                          </table>    
                        </td>
                           <td align="right" style="width:50%;border:0;padding: 15px 30px;border-bottom:1px solid #e9e9e9">
                               <?php if(!empty($settings['SbsSubscriberSetting']['invoice_logo'])) { ?>
                              		<img src="<?php echo $imgLink.$settings['SbsSubscriberSetting']['invoice_logo'];?>" alt="Logo"/>
                              <?php } else { ?>
                              		<img src="<?php echo $imgLink.$webroot_name.'/img/logo.png';?>" alt="Cantorix Logo"/>	
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
                                <td style="font-size:14px;font-family:Arial;font-weight:bold;">Quote To:</td>
                             </tr> 
                             <tr >
                                <td style="font-size:18px;font-weight:bold;font-family:Arial;"><?php echo $customerDetails['AcrClient']['organization_name'];?></td>        
                             </tr>
                             <tr >
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_address_line1'];?></td>        
                             </tr>
                             <tr >
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_address_line2'];?></td>        
                             </tr>
                             <tr >
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_city'];?></td>        
                             </tr> 
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_state'];?></td>        
                             </tr> 
                             <tr >
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_country'];?></td>        
                             </tr>
                             <tr>
                             	<td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_zip'];?></td> 
                             </tr>    
                          </table>
                           </td>
                           <td align="right" style="width:50%;border:0;padding: 10px 40px;vertical-align: top;">
                            <table style="width:80%;  background:#4e68a1;color:#fff;text-align:right;" align="right">
                            	<tr>
	                                <td style="font-size:14px;font-family:Arial;font-weight:bold;">&nbsp;</td>
	                             </tr>
                             <tr >
                                <td style="font-size:18px;font-weight:bold;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['organization_name'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'];?></td>        
                             </tr> 
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'];?></td>        
                             </tr> 
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'];?></td>        
                             </tr>  
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];?></td>        
                             </tr>  
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
                           <td style="width:10%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;">Item</td>
                           <td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Description</td>
                            <td style="width:12%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Qty</td>
                            <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Unit Price</td>
                             <td style="width:12%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Disc %</td>
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
                           <td style="width:10%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;color:#4E68A1;"><?php if(!empty($inventories[$inventory])) echo $inventories[$inventory]; else echo "&nbsp;";?></td>
                           <td style="width:25%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $data['AcrClientInvoice']['description'][$index];?></td>
                           <td style="width:12%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $data['AcrClientInvoice']['quantity'][$index];/*if(!empty($data['AcrClientInvoice']['unitTypeofInventory'][$index])) echo $data['AcrClientInvoice']['unitTypeofInventory'][$index];*/?></td>
                            <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($data['AcrClientInvoice']['unit_rate'][$index]/$data['AcrClientInvoice']['conversionValue']),'');?></td>
                             <td style="width:12%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php if($data['AcrClientInvoice']['discount_percent'][$index]){echo $data['AcrClientInvoice']['discount_percent'][$index];} else {echo '0';}?>%</td>
                              <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($data['AcrClientInvoice']['line_total_hidden'][$index]/$data['AcrClientInvoice']['conversionValue']),'');?></td>  
                        </tr>
                   </table> 
                  </td> 
                </tr>
                 <?php endif;?>
                <?php endforeach;?>
                
                <tr>  
                  <td>
                   <table style="width:90%; height:100%;padding-top:10px; background:#F5F5F5;border-bottom:1px solid #d8d8d8" align="center">
                        <tr>
                        <td>
                        <table  style="width:40%; height:100%;padding-top:10px; background:#F5F5F5;" align="right">
                        <tr>
                        <td>
                        <tr>
                             <td style="width:55%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Subtotal</td>
                              <td style="width:45%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($data['AcrClientInvoice']['subTotal']/$data['AcrClientInvoice']['conversionValue']),$data['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                        <?php foreach($data['AcrClientInvoice']['taxValue'] as $taxID => $taxAmount):?>
                        <tr>
                             <td style="width:55%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $taxes[$taxID];?></td>
                              <td style="width:45%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $this->Number->currency(($taxAmount/$data['AcrClientInvoice']['conversionValue']),$data['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                        <?php endforeach;?>
                        <tr>
                             <td style="width:55%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Total</td>
                              <td style="width:45%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($data['AcrClientInvoice']['invoicetotal'],$data['AcrClientInvoice']['invoice_currency_code']);?></td>  
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
                            <td  style="padding: 3px 0;font-size:15px;font-family:arial;font-weight:bold;">
                             Customer Note
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
            </table>
        </td>
    </tr>
    
</table>

<?php endif;?>

<?php if($data['AcrClientInvoice']['email_template'] == 'quote_service_classic'):?>

<table style="width:100%; height:100%; border:0; cellspacing:0;cellpadding:0; background:#f0f0f0;padding:30px 0px;">
	<tr>
    	<td>
        	<table cellspacing="0" style="width:900px;padding:0px; background:#fff; height:100%; border:1px solid #d8d8d8; margin:auto; align:center; cellpadding:0; cellspacing:0; bgcolor:#ffffff;">
            	<tr>
                   <td>
                   <table style="width:100%; height:100%;">
                       <tr>
                        <td align="left" style="width:50%;border:0;padding: 15px 27px;;border-bottom:1px solid #e9e9e9">
                               <?php if(!empty($settings['SbsSubscriberSetting']['invoice_logo'])) { ?>
                              		<img src="<?php echo $imgLink.$settings['SbsSubscriberSetting']['invoice_logo'];?>" alt="Logo"/>
                              <?php } else { ?>
                              		<img src="<?php echo $imgLink.$webroot_name.'/img/logo.png';?>" alt="Cantorix Logo"/>	
                              <?php }?>
                        </td>
                        <td align="right" style="width:50%;border:0;padding: 15px 40px;border-bottom:1px solid #e9e9e9">
                          <table style="width:100%; height:100%;" align="right">
                             <tr>
                                <td style="font-size:30px;text-align: right;padding-right: 15px;font-weight:bold;font-family:Arial;">QUOTE</td>                           
                            </tr> 
                            <tr>
                                <td style="text-align: right;padding-right: 15px;">
                                    <span style="margin-right:15px;font-family:Arial;">Quote #</span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php echo $data['AcrClientInvoice']['quote_no'];?></span>
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
                                <td style="font-size:14px;font-weight:bold;font-family:Arial;">From:</td>                         
                             </tr> 
                             <tr>
                                <td style="font-size:18px;font-weight:bold;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['organization_name'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'];?></td>        
                             </tr>
                             <tr>
                            	<td style="font-size:14px;font-family:Arial;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];?></td>        
                             </tr>
                          </table>  
                        </td>
                           <td align="right" style="width:50%;border:0;padding: 10px 40px;vertical-align: top;">
                            <table style="width:100%;" align="right">
                             <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-weight:bold;font-family:Arial;">Quote To:</td>
                             </tr> 
                             <tr >
                                <td style="font-size:18px;text-align: right;padding-right: 15px;font-weight:bold;font-family:Arial;"><?php echo $customerDetails['AcrClient']['organization_name'];?></td>        
                             </tr>
                             <tr >
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_address_line1'];?></td>        
                             </tr>
                             <tr >
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_address_line2'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_city'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_state'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_country'];?></td>        
                             </tr> 
                              <tr>
                                <td style="font-size:14px;text-align: right;padding-right: 15px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_zip'];?></td>        
                              </tr> 
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
                           <td style="width:33%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 5px;">Issue Date</td>
                           <td style="width:33%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:center;padding-bottom: 5px;">Expiry Date</td> 
                           <td style="width:33%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:center;padding-right:0px;padding-bottom: 5px;">PO #</td>  
                        </tr>
                   </table> 
                  </td>
                </tr>
                <tr>  
                  <td>
                   <table style="width:70%; height:100%; cellpadding:0; cellspacing:0;" align="center">
                        <tr>
                           <td style="width:33%;font-size:13px;font-family:Arial;text-align:left;padding-left:15px;padding-top: 5px;"><?php echo $data['AcrClientInvoice']['issueDate'];?></td>
                           <td style="width:33%;font-size:13px;font-family:Arial;text-align:center;padding-top: 5px;"><?php if($data['AcrClientInvoice']['expiryDate']) {echo $data['AcrClientInvoice']['expiryDate'];} else {echo '--';}?></td> 
                           <td style="width:33%;font-size:13px;font-family:Arial;text-align:center;padding-right:0px;padding-top: 5px;"><?php if($data['AcrClientInvoice']['purchase_order_no']){ echo $data['AcrClientInvoice']['purchase_order_no'];}else { echo '--'; }?></td>  
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
                           <td style="width:10%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;">Service</td>
                           <td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-right:15px;padding-bottom: 10px;padding-top:10px;padding-left:8px;">Description</td>
                           <td style="width:12%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Qty</td>
                            <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Rate</td>
                             <td style="width:12%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Disc %</td>
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
                           <td style="width:10%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;color:#4E68A1;"><?php if(!empty($inventories[$inventory])) echo $inventories[$inventory]; else echo "&nbsp;";?></td>
                           <td style="width:25%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-right:15px;padding-bottom: 10px;padding-top:10px;padding-left:8px;"><?php echo $data['AcrClientInvoice']['description'][$index];?></td>
                           <td style="width:12%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $data['AcrClientInvoice']['quantity'][$index];/*if(!empty($data['AcrClientInvoice']['unitTypeofInventory'][$index])) echo $data['AcrClientInvoice']['unitTypeofInventory'][$index];*/?></td>
                            <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($data['AcrClientInvoice']['unit_rate'][$index]/$data['AcrClientInvoice']['conversionValue']),'');?></td>
                             <td style="width:12%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php if($data['AcrClientInvoice']['discount_percent'][$index]){echo $data['AcrClientInvoice']['discount_percent'][$index];} else {echo '0';}?>%</td>
                              <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($data['AcrClientInvoice']['line_total_hidden'][$index]/$data['AcrClientInvoice']['conversionValue']),'');?></td>  
                        </tr>
                   </table> 
                  </td> 
                </tr>
                <?php endif;?>
                <?php endforeach;?>
                <tr>  
                  <td style="padding-right:30px;">
                   <table style="width:40%; height:100%;padding-top:10px;padding-right:50px;" align="right">
                        <tr>
                             <td style="width:55%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Subtotal</td>
                              <td style="width:45%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:32px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($data['AcrClientInvoice']['subTotal']/$data['AcrClientInvoice']['conversionValue']),$data['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                        <?php foreach($data['AcrClientInvoice']['taxValue'] as $taxID => $taxAmount):?>
                        <tr>
                             <td style="width:55%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $taxes[$taxID];?></td>
                              <td style="width:45%;font-size:13px;font-family:Arial;text-align:right;padding-right:32px;padding-bottom: 10px;"><?php echo $this->Number->currency(($taxAmount/$data['AcrClientInvoice']['conversionValue']),$data['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                        <?php endforeach;?>
                        <tr>
                             <td style="width:55%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Total</td>
                              <td style="width:45%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:32px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($data['AcrClientInvoice']['invoicetotal'],$data['AcrClientInvoice']['invoice_currency_code']);?></td>  
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
                            <td  style="padding: 3px 0;font-size:15px;font-family:arial;font-weight:bold;">
                             Customer Note
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
            </table>
        </td>
    </tr>
    
    
</table>

<?php endif;?>
	
<?php if($data['AcrClientInvoice']['email_template'] == 'quote_service_modern'):?>
	<!doctype html>

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
                                <td style="font-size:30px;font-weight:bold;font-family:Arial;color:#4E68A1;">QUOTE</td>                           
                            </tr> 
                            <tr>
                                <td>
                                    <span style="float:left;width:90px;font-family:Arial;">Quote #</span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php echo $data['AcrClientInvoice']['quote_no'];?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="float:left;width:90px;font-family:Arial;">PO #</span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php if($data['AcrClientInvoice']['purchase_order_no']){ echo $data['AcrClientInvoice']['purchase_order_no'];}else { echo '--'; }?></span>
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    <span style="float:left;width:90px;font-family:Arial;">Issue Date</span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php echo $data['AcrClientInvoice']['issueDate'];?></span>
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    <span style="float:left;width:90px;font-family:Arial;">Expiry Date</span>
                                    <span style="font-weight:bold;font-family:Arial;"><?php if($data['AcrClientInvoice']['expiryDate']) {echo $data['AcrClientInvoice']['expiryDate'];} else {echo '--';}?></span>
                                </td>
                            </tr>  
                          </table>    
                        </td>
                           <td align="right" style="width:50%;border:0;padding: 15px 30px;border-bottom:1px solid #e9e9e9">
                               <?php if(!empty($settings['SbsSubscriberSetting']['invoice_logo'])) { ?>
                              		<img src="<?php echo $imgLink.$settings['SbsSubscriberSetting']['invoice_logo'];?>" alt="Logo"/>
                              <?php } else { ?>
                              		<img src="<?php echo $imgLink.$webroot_name.'/img/logo.png';?>" alt="Cantorix Logo"/>	
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
                                <td style="font-size:14px;font-family:Arial;font-weight: bold;">Quote To:</td>
                             </tr> 
                             <tr >
                                <td style="font-size:18px;font-weight:bold;font-family:Arial;"><?php echo $customerDetails['AcrClient']['organization_name'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_address_line1'];?></td>        
                             </tr>
                             <tr >
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_address_line2'];?></td>        
                             </tr>
                             <tr >
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_city'];?></td>        
                             </tr>
                             <tr >
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_state'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_country'];?></td>        
                             </tr>
                              <tr>
                                <td style="font-size:14px;font-family:Arial;"><?php echo $customerDetails['AcrClient']['billing_zip'];?></td>        
                             </tr>
                          </table>
                           </td>
                           <td align="right" style="width:50%;border:0;padding: 10px 40px;vertical-align: top;">
                            <table style="width:80%; background:#4e68a1;color:#fff;padding:15px;
                            text-align:right;" align="right">
                             	<tr>
	                                <td style="font-size:14px;font-family:Arial;font-weight:bold;">&nbsp;</td>
	                             </tr>
                             <tr >
                                <td style="font-size:18px;font-weight:bold;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['organization_name'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'];?></td>        
                             </tr>
                             <tr >
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'];?></td>        
                             </tr>
                             <tr >
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'];?></td>        
                             </tr>
                             <tr >
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'];?></td>        
                             </tr>
                             <tr>
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'];?></td>        
                             </tr>
                             	<tr >
                                <td style="font-size:14px;font-family:Arial;padding-left:20px;padding-right:20px;"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];?></td>        
                             </tr>
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
                           <td style="width:10%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;">Service</td>
                           <td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-right:15px;padding-bottom: 10px;padding-top:10px; padding-left:8px;">Description</td>
                           <td style="width:12%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Qty</td>
                           <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Rate</td>
                           <td style="width:12%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Disc %</td>
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
                           <td style="width:10%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;color:#4E68A1;"><?php if(!empty($inventories[$inventory])) echo $inventories[$inventory]; else echo "&nbsp;";?></td>
                           <td style="width:25%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-right:15px;padding-bottom: 10px;padding-top:10px; padding-left: 8px;"><?php echo $data['AcrClientInvoice']['description'][$index];?></td>
                           <td style="width:12%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $data['AcrClientInvoice']['quantity'][$index];/*if(!empty($data['AcrClientInvoice']['unitTypeofInventory'][$index])) echo $data['AcrClientInvoice']['unitTypeofInventory'][$index];*/?></td>
                            <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($data['AcrClientInvoice']['unit_rate'][$index]/$data['AcrClientInvoice']['conversionValue']),'');?></td>
                             <td style="width:12%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php if($data['AcrClientInvoice']['discount_percent'][$index]){echo $data['AcrClientInvoice']['discount_percent'][$index];} else {echo '0';}?>%</td>
                              <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($data['AcrClientInvoice']['line_total_hidden'][$index]/$data['AcrClientInvoice']['conversionValue']),'');?></td>  
                        </tr>
                   </table> 
                  </td> 
                </tr>
                
                 <?php endif;?>
                <?php endforeach;?>
                                
                <tr>  
                  <td>
                   <table style="width:90%; height:100%;padding-top:10px; background:#F5F5F5;border-bottom:1px solid #d8d8d8" align="center">
                        <tr>
                        <td>
                        <table  style="width:40%; height:100%;padding-top:10px; background:#F5F5F5;" align="right">
                        <tr>
                        <td>
                        <tr>
                             <td style="width:55%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Subtotal</td>
                              <td style="width:45%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency(($data['AcrClientInvoice']['subTotal']/$data['AcrClientInvoice']['conversionValue']),$data['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                        <?php foreach($data['AcrClientInvoice']['taxValue'] as $taxID => $taxAmount):?>
                        <tr>
                             <td style="width:55%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $taxes[$taxID];?></td>
                              <td style="width:45%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $this->Number->currency(($taxAmount/$data['AcrClientInvoice']['conversionValue']),$data['AcrClientInvoice']['invoice_currency_code']);?></td>  
                        </tr>
                        <?php endforeach;?>
                        <tr>
                             <td style="width:55%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Total</td>
                              <td style="width:45%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($data['AcrClientInvoice']['invoicetotal'],$data['AcrClientInvoice']['invoice_currency_code']);?></td>  
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
                            <td  style="padding: 3px 0;font-size:15px;font-family:arial;font-weight:bold;">
                             Customer Note
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
            </table>
        </td>
    </tr>
    
    
</table>


<?php endif;?>