<?php $this->CurrencySymbol->getAllCurrencies();?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width" />
		<title><?php echo __('CantoriX');?></title>
	</head>

	<body style="margin:0 auto;padding:0;">
		<table style="width:100%; height:100%; border:0; cellspacing:0;cellpadding:0; background:#f0f0f0;padding:30px 0px;">
			<tr>
				<td>
				<table cellspacing="0" style="width:1100px;padding:0px; background:#fff; height:100%; border:1px solid #d8d8d8; margin:auto; align:center; cellpadding:0; cellspacing:0; bgcolor:#ffffff;">
					<tr>
						<td>
						<table style="width:100%; height:100%;">
							<tr>
								<td align="left" style="width:50%;border:0;padding: 30px 40px;border-bottom:1px solid #e9e9e9"><?php echo $this->Html->image('logo.png',array('alt'=>'logo'));?></td>
								<td align="right" style="width:50%;border:0;padding: 30px 40px;border-bottom:1px solid #e9e9e9">
								<table style="width:40%; height:100%;" align="right">
									<tr>
										<td style="font-size:30px;font-weight:bold;font-family:Arial;">INVOICE</td>
									</tr>
									<tr>
										<td><span style="margin-right:15px;font-family:Arial;">Inv #</span><span style="font-weight:bold;font-family:Arial;"><?php echo $invoiceData['AcrClientInvoice']['invoice_number']; ?></span></td>
									</tr>
								</table></td>
							</tr>
						</table></td>
					</tr>
					<tr>
						<td>
						<table style="width:100%; height:100%;">
							<tr>
								<td align="left" style="width:50%;border:0;padding: 10px 40px;">
								<table style="width:100%; height:100%;" align="left">
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
								</table></td>
								<td align="right" style="width:50%;border:0;padding: 10px 40px;">
								<table style="width:40%; height:100%;" align="right">
									<tr>
										<td style="font-size:14px;font-weight:bold;font-family:Arial;">Invoice To:</td>
									</tr>
									<tr>
										<td style="font-size:18px;font-weight:bold;font-family:Arial;"><?php echo $customerInfo['AcrClient']['client_name']; ?></td>
									</tr>
									<tr>
										<td style="font-size:14px;font-family:Arial;"><?php echo $invoiceData['AcrClient']['billing_address_line1']; ?></td>
									</tr>
									<tr>
										<td style="font-size:14px;font-family:Arial;"><?php echo $invoiceData['AcrClient']['billing_address_line2']; ?></td>
									</tr>
									<tr>
										<td style="font-size:14px;font-family:Arial;"><?php echo $invoiceData['AcrClient']['billing_city']; ?></td>
									</tr>
									<tr>
										<td style="font-size:14px;font-family:Arial;"><?php echo $invoiceData['AcrClient']['billing_state'];?></td>
									</tr>
									<tr>
										<td style="font-size:14px;font-family:Arial;"><?php echo $invoiceData['AcrClient']['billing_country']; ?></td>
									</tr>
									<tr>
										<td style="font-size:14px;font-family:Arial;"><?php echo $invoiceData['AcrClient']['billing_zip']; ?></td>
									</tr>
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
								<td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 5px;">Issue Date</td>
								<td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 5px;">Terms</td>
								<td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:center;padding-bottom: 5px;">Due Date</td>
								<td style="width:25%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 5px;">PO #</td>
							</tr>
						</table></td>
					</tr>
					<tr>
						<td>
						<table style="width:70%; height:100%; cellpadding:0; cellspacing:0;" align="center">
							<tr>
								<td style="width:25%;font-size:15px;font-family:Arial;text-align:left;padding-left:15px;padding-top: 5px;"><?php echo $invoiceData['AcrClientInvoice']['invoiced_date']; ?></td>
								<td style="width:25%;font-size:15px;font-family:Arial;text-align:left;padding-left:15px;padding-top: 5px;"><?php echo $invoiceData['SbsSubscriberPaymentTerm']['term']; ?></td>
								<td style="width:25%;font-size:15px;font-family:Arial;text-align:center;padding-top: 5px;"><?php echo $invoiceData['AcrClientInvoice']['due_date']; ?></td>
								<td style="width:25%;font-size:15px;font-family:Arial;text-align:right;padding-right:15px;padding-top: 5px;"><?php echo $invoiceData['AcrClientInvoice']['purchase_order_no']; ?></td>
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
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['InvInventory']['name']; ?></td>
								<td style="width:20%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-bottom: 10px;padding-top:10px;"><?php echo $v['InvInventory']['description']; ?></td>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['quantity']; ?></td>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($v['AcrInvoiceDetail']['unit_rate']*$invoiceData['AcrClientInvoice']['exchange_rate'],$invoiceData['AcrClientInvoice']['invoice_currency_code']); ?> </td>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $v['AcrInvoiceDetail']['discount_percent']; ?> </td>
								<td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($v['AcrInvoiceDetail']['line_total']*$invoiceData['AcrClientInvoice']['exchange_rate'],$invoiceData['AcrClientInvoice']['invoice_currency_code']); ?></td>
							</tr>
						</table></td>
					</tr>
					<?php } ?>
					<tr>
						<td>
						<table style="width:34%; height:100%;padding-top:10px;padding-right:50px;" align="right">
							<tr>
								<td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Subtotal</td>
								<td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['sub_total']*$invoiceData['AcrClientInvoice']['exchange_rate'],$invoiceData['AcrClientInvoice']['invoice_currency_code']); ?></td>
							</tr>
							 <?php foreach($taxArray as $taxKey=>$taxVal){?>
		                        <tr>
		                             <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $taxVal['taxName'];?></td>
		                              <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $this->Number->currency($taxVal['taxAmount']*$invoiceData['AcrClientInvoice']['exchange_rate'],$subscriberCurrencyCode);?></td>  
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
                        <table  style="width:32%; height:100%;padding-top:10px;" align="right">
                        <tr>
                        <td>
                        <tr>
                          <td style="width:50%;font-size:15px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;">Pay now online via:</td>
                           <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-bottom: 10px;"><a href = "<?php echo $payPalLink?>"><?php echo $this->Html->image('Paypal.png');?></a></td>  
                        </tr>
                       <tr>
                          <td style="width:50%;font-size:15px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;">Link:</td>
                           <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-bottom: 10px;"><?php echo $payPalLink?></td>  
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
								<td  style="padding: 3px 0;font-size:14px;font-family:arial;"> It was popularised in the 1960s with. </td>
							</tr>
							<tr>
								<td  style="padding: 3px 0;font-size:14px;font-family:arial;"> It was popularised in the 1960. </td>
							</tr>
							<tr>
								<td  style="padding: 3px 0;font-size:14px;font-family:arial;"> It was popularised in the 1960s with the release of Letraset sheets. </td>
							</tr>
							<tr>
								<td  style="padding: 3px 0;font-size:14px;font-family:arial;"> It was popularised. </td>
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
								<td  style="padding: 3px 0;font-size:20px;font-weight:bold;text-align:center;font-family:arial;"> Thank you for your business </td>
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
				</table></td>
			</tr>

		</table>
	</body>
</html>
