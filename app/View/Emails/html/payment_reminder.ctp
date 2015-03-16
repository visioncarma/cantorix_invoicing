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
								<td align="left" style="width:50%;border:0;padding: 30px 40px;border-bottom:1px solid #e9e9e9">
								<?php if($logo) {?>
										<img src="<?php echo $hostName.$logo;?>" alt="Logo"/>
										
									<?php } else { ?>
											<img src="<?php echo $hostName.'invoicing/app/webroot/img/logo.png';?>" alt="Cantorix Logo"/ >
									<?php }?>
								</td>
								<td align="right" style="width:50%;border:0;padding: 30px 40px;border-bottom:1px solid #e9e9e9">
								<table style="width:100%; height:100%;text-align: right;padding-right:22px;" align="right">
									<tr>
										<td style="font-size:30px;font-weight:bold;font-family:Arial;margin-bottom:10px;">INVOICE</td>
									</tr>
									<tr>
										<td><span style="margin-right:20px;font-family:Arial;font-size: 14px;">Inv #</span><span style="font-weight:bold;font-family:Arial;font-family: 13px;"><?php echo $invoiceData['AcrClientInvoice']['invoice_number']; ?></span></td>
									</tr>
								</table></td>
							</tr>
						</table></td>
					</tr>
					<tr>
						<td>
						<table style="width:100%; height:100%;">
							
							<tr>
								<td align="left" style="width:50%;border:0;padding:10px 40px;vertical-align: top;">
								<table style="width:100%;" align="left">
									
									<tr>
										<td style="font-size:14px;font-weight:bold;font-family:Arial;">From:</td>
									</tr>
									<?php if($organisationDetails['SbsSubscriberOrganizationDetail']['organization_name']){?>
									<tr>
										<td style="font-size:18px;font-weight:bold;font-family:Arial;"><?php if($organisationDetails['SbsSubscriberOrganizationDetail']['organization_name']){ echo $organisationDetails['SbsSubscriberOrganizationDetail']['organization_name'];}else{echo "--";}?></td>
									</tr>
									<?php } ?>
									<?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1']){ ?>
									<tr>
										<td style="font-size:14px;font-family:Arial;"><?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1']){echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'];}else{ echo "--";}?></td>
									</tr>
									<?php } ?>
									<?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2']){?>
									<tr>
										<td style="font-size:14px;font-family:Arial;"><?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2']){echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'];}else{ echo "--";}?></td>
									</tr>
									<?php } ?>
									<?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_city']){?>
									<tr>
										<td style="font-size:14px;font-family:Arial;"><?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_city']){echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'];}else{ echo "--";}?></td>
									</tr>
									<?php } ?>
									<?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_state']){?>
									<tr>
										<td style="font-size:14px;font-family:Arial;"><?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_state']){echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'];}else{ echo "--";}?></td>
									</tr>
									<?php } ?>
									<?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_country']){ ?>
									<tr>
										<td style="font-size:14px;font-family:Arial;"><?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_country']){echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'];}else{echo "--";}?></td>
									</tr>
									<?php } ?>
									<?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip']){ ?> 
									<tr>
										<td style="font-size:14px;font-family:Arial;"><?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip']){echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];}?></td>
									</tr>
									<?php } ?>
								</table></td>
								<td align="right" style="width:50%;border:0;padding: 10px 40px; vertical-align: top;">
								<table style="width:100%;text-align: right;padding-right: 20px;" align="right">
									<tr>
										<td style="font-size:14px;font-weight:bold;font-family:Arial;">Invoice To:</td>
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
									<?php if($invoiceData['AcrClient']['billing_city']){ ?>
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
								</table></td>
							</tr>
						</table></td>
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
								<td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 5px;">Invoice Date</td>
								<td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 5px;">Terms</td>
								<td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:center;padding-bottom: 5px;">Due Date</td>
								<td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:25px;padding-bottom: 5px;">PO #</td>
							</tr>
						</table></td>
					</tr>
					<tr>
						<td>
						<table style="width:70%; height:100%; cellpadding:0; cellspacing:0;" align="center">
							<tr>
								<td style="width:25%;font-size:13px;font-family:Arial;text-align:left;padding-left:15px;padding-top: 5px;"><?php echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['invoiced_date'])); ?></td>
								<td style="width:25%;font-size:13px;font-family:Arial;text-align:left;padding-left:15px;padding-top: 5px;"><?php echo $invoiceData['SbsSubscriberPaymentTerm']['term']; ?></td>
								<td style="width:25%;font-size:13px;font-family:Arial;text-align:center;padding-top: 5px;"><?php echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['due_date'])); ?></td>
								<td style="width:25%;font-size:13px;font-family:Arial;text-align:right;padding-right:25px;padding-top: 5px;"><?php echo $invoiceData['AcrClientInvoice']['purchase_order_no']; ?></td>
							</tr>
						</table></td>
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
						</table></td>
					</tr>
					<?php foreach($invoiceDetail as $k=>$v) { ?>
					<tr>
						<td>
						<table style="width:90%; height:100%; cellpadding:0; cellspacing:0;" align="center">
							<tr>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['InvInventory']['name']; ?>&nbsp;</td>
								<td style="width:20%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['inventory_description']; ?>&nbsp;</td>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['quantity']; ?></td>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($v['AcrInvoiceDetail']['unit_rate']/$invoiceData['AcrClientInvoice']['exchange_rate'],''); ?> </td>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['discount_percent']; ?>%</td>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($v['AcrInvoiceDetail']['line_total']/$invoiceData['AcrClientInvoice']['exchange_rate'],''); ?></td>
							</tr>
						</table></td>
					</tr>
					<?php } ?>
					<tr>
						<td style="padding-top:10px;padding-right:54px;">
						<table style="width:34%; height:100%;" align="right">
							<tr>
								<td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Subtotal</td>
								<td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['sub_total']/$invoiceData['AcrClientInvoice']['exchange_rate'],$invoiceData['AcrClientInvoice']['invoice_currency_code']); ?></td>
							</tr>
							 <?php foreach($taxArray as $taxKey=>$taxVal){?>
		                        <tr>
		                             <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $taxVal['taxName'];?></td>
		                              <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $this->Number->currency($taxVal['taxAmount']/$invoiceData['AcrClientInvoice']['exchange_rate'],$subscriberCurrencyCode);?></td>  
		                        </tr>
                        	<?php } ?>
							<tr>
								<td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo __('Invoice Total');?></td>
								<td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code']); ?></td>
							</tr>
							<tr>
								<td style="width:50%;font-size:13px;border-bottom:1px solid #d8d8d8;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo __('Payments');?></td>
								<td style="width:50%;font-size:13px;border-bottom:1px solid #d8d8d8;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $this->Number->currency($paidAmount,$invoiceData['AcrClientInvoice']['invoice_currency_code']); ?></td>
							</tr>
							<tr>
								<td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo __('Balance Due');?></td>
								<td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($balanceDue,$invoiceData['AcrClientInvoice']['invoice_currency_code']); ?></td>
						</table></td>
					</tr>
					<tr>
						<td>
						<table style="width:91%; height:100%;" align="center">
							<tr>
								<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;border-bottom:1px solid #d8d8d8;"></td>
							</tr>
						</table></td>
					</tr>
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
                           <td style="width:85%;font-size:13px;font-family:Arial;text-align:left;padding-bottom: 10px;"><a href = "<?php echo $payPalLink?>"><img src="<?php echo $hostName.'invoicing/app/webroot/img/Paypal.png';?>" alt="Pay Link"/></a></td>  
                        </tr>
                        <?php endif;?>
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
								<td  style="padding: 3px 0;font-size:15px;font-family:arial;font-weight:bold;"> Customer Note </td>
							</tr>
							<tr>
								<td  style="padding: 3px 0;font-size:14px;font-family:arial;"> <?php echo $invoiceData['AcrClientInvoice']['notes']; ?> </td>
							</tr>
							

						</table></td>
					</tr>
					<tr>
						<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
					</tr>
					<tr>
						<td>
						<table style="width:50%; height:100%;padding-top:15px;" align="center">
							<tr>
								<td  style="padding: 3px 0;font-size:14px;font-weight:bold;text-align:center;font-family:arial;"> Thank you for your business </td>
							</tr>

						</table></td>
					</tr>
					<tr>
						<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
					</tr>
					<tr>
						<td>
						<table style="width:90%; height:100%;padding-top:15px;" align="center">
							<tr>
								<td  style="padding: 3px 0;font-size:15px;font-family:arial;font-weight:bold;"> Terms and Conditions </td>
							</tr>
							<tr>
								<td  style="padding: 3px 0;font-size:14px;font-family:arial;text-align:justify;"> <?php echo $invoiceData['AcrClientInvoice']['term_conditions']; ?> </td>
							</tr>
						</table></td>
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
										<?php echo '<pre>'.$sign.'</pre>'; ?>
								</td>
							</tr>
							
						</table></td>
					</tr>
				</table></td>
			</tr>

		</table>
		
	</body>
</html>
