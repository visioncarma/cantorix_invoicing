<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php if($invoiceData['AcrClientInvoice']['exchange_rate']){
	$invoiceData['AcrClientInvoice']['exchange_rate'] = $invoiceData['AcrClientInvoice']['exchange_rate'];
}else{
	$invoiceData['AcrClientInvoice']['exchange_rate'] = 1;
}?>
<?php 
App::import('Vendor','xtcpdf');  
  
$tcpdf = new XTCPDF();
$tcpdf->SetPrintHeader(false);

$tcpdf->AddPage(); 

/*** Table starts here **/ 
 
	
	/********Table content beings here ************/
	
	// for local server pls change the img path '/var/www/html/cantorix/app/webroot/img/logo.png' to '/home/cantorix/public_html/cantorix/app/webroot/img/logo.png'
	if($logo){
		$explodeImg = explode('/', $logo);
		 foreach ($explodeImg as $keyIndexInArray => $explodedValue) {
			 $imageName = $explodedValue;
		 }
		$for_image = $_SERVER['DOCUMENT_ROOT'].'/'.$this->webroot.'/app/webroot/files/uploads/logo-subscriber'.$invoiceData['AcrClientInvoice']['sbs_subscriber_id'].'/'.$explodedValue;
	}else{
		$for_image = $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/img/logo.png";
	}
   $heading_part ='<table style="border-bottom: 1px solid #2E2E2E;"><tr style="float:left;background-color:#FFFFFF;"><td style="width:380px;float:left;color:#4E68A1;font-family:Arial;font-weight:Bold;text-align:left; font-size: 22.5pt;">INVOICE</td><td style="width:125;float:left;text-align:left;font-family: Arial; font-size: 30px; font-weight: bold;"></td>'.'<td style="width:23px;float:left;"></td></tr><tr style="float:left;background-color:#FFFFFF;"><td style="width:380px;float:left;color:#00000A;font-family:Arial;text-align:left; font-size: 9.5pt;"><table width="150"><tr><td style="font-family: Arial;">Inv #</td><td style="font-family: Arial;font-weight: bold;">'.$invoiceData['AcrClientInvoice']['invoice_number'].'</td></tr><tr><td style="font-family: Arial;">PO #</td><td style="font-family: Arial;font-weight: bold;">'.$invoiceData['AcrClientInvoice']['purchase_order_no'].'</td></tr><tr><td style="font-family: Arial;">Invoice Date</td><td style="font-family: Arial;font-weight: bold;">'.date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['invoiced_date'])).'</td></tr><tr><td style="font-family: Arial;">Due Date</td><td style="font-family: Arial;font-weight: bold;">'.date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['due_date'])).'</td></tr></table>
   </td><td style="width:125;float:left;text-align:left;font-family: Arial; font-size: 30px; font-weight: bold;"><img src="'.$for_image.'" alt="test alt attribute" border="0" /></td><td style="width:23px;float:left;"></td></tr></table>'; 
   
   
   $addresspart ='<table>
   <tr style="float:left;background-color:#FFFFFF;">
   <td style="width:5px;float:left;color:#0f6082;"></td>
   <td style="width:400px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;"></td>
   <td style="width:118px;float:left;text-align:left;font-family: Arial;  font-size: 10pt;font-weight: bold;"></td>
   <td style="width:23px;float:left;"></td>
   </tr>
   <tr style="float:left;background-color:#FFFFFF;">
   <td style="width:5px;float:left;color:#0f6082;"></td>
   <td style="width:400px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Invoice To:</td>
   <td style="width:118px;float:left;text-align:right; background-color:#4E68A1; border-bottom: 1px solid #4E68A1; font-family: Arial;  font-size: 10pt;font-weight: bold;"></td>
   <td style="width:10px;float:left;text-align:right; background-color:#4E68A1; border-left: 1px solid #4E68A1; border-right: 1px solid #4E68A1;  border-bottom: 1px solid #4E68A1; font-family: Arial; font-size: 10pt;"></td>
   <td style="width:23px;float:left;"></td>
   </tr>
   <tr style="float:left;background-color:#FFFFFF;">
   <td style="width:5px;float:left;color:#0f6082;"></td>
   <td style="width:400px;float:left;font-family:Arial;font-weight:Bold;text-align:left;color:#000000;font-size: 13.5pt;">'.$invoiceData['AcrClient']['organization_name'].'</td>
   <td style="width:118px;float:left;text-align:right; background-color:#4E68A1; color:#ffffff; border-bottom: 1px solid #4E68A1; left;font-family: Arial;  font-size: 13.5pt; font-weight: bold;">'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['organization_name'].'</td>
   <td style="width:10px;float:left;text-align:right; background-color:#4E68A1;  border-left: 1px solid #4E68A1; border-right: 1px solid #4E68A1; border-bottom: 1px solid #4E68A1; font-family: Arial; font-size: 10pt;"></td>
   <td style="width:23px;float:left;"></td>
   </tr>
   <tr style="float:left;background-color:#FFFFFF;">
   <td style="width:5px;float:left;color:#0f6082;"></td>
   <td style="width:400px;float:left;font-family:Arial;text-align:left; font-size: 10pt; color:#000000;">'.$clientAddress.'</td>
   <td style="width:118px;float:left;text-align:right; background-color:#4E68A1;color:#ffffff;  border-bottom: 1px solid #4E68A1; font-family: Arial; font-size: 10pt; ">'.$subscriberAddress.'</td>
   <td style="width:10px;float:left;text-align:right; background-color:#4E68A1; border-left: 1px solid #4E68A1; border-right: 1px solid #4E68A1; font-family: Arial; font-size: 10pt;"></td>
   <td style="width:23px;float:left;"></td>
   </tr>
   <tr style="float:left;background-color:#FFFFFF;">
   <td style="width:5px;float:left;color:#0f6082;"></td>
   <td style="width:400px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
   <td style="width:118px;float:left;text-align:right; background-color:#4E68A1; border-bottom: 1px solid #4E68A1; font-family: Arial; font-size: 10pt;"></td>
   <td style="width:10px;float:left;text-align:right; background-color:#4E68A1;border-left: 1px solid #4E68A1; border-right: 1px solid #4E68A1; border-bottom: 1px solid #4E68A1; font-family: Arial; font-size: 10pt;"></td>
   <td style="width:23px;float:left;"></td>
   </tr>
   <tr style="float:left;background-color:#FFFFFF;">
   <td style="width:5px;float:left;color:#0f6082;"></td>
   <td style="width:400px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
   <td style="width:118px;float:left;text-align:right;font-family: Arial; font-size: 10pt;"></td>
   <td style="width:10px;float:left;text-align:right;font-family: Arial; font-size: 10pt;"></td>
   <td style="width:23px;float:left;"></td>
   </tr>
   </table>'; 
	              
	
	
	
	$items=null;
		
	// Use for each For all items
	foreach($invoiceDetail as $k=>$v){
	$items.='<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:85px; color: #4E68A1; font-family:Arial;text-align:left; font-size: 8pt;">'.$v['InvInventory']['name'].'&nbsp;</td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:175px;font-family:Arial;text-align:left; font-size: 8pt;">'.$v['AcrInvoiceDetail']['inventory_description'].'
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:30px;font-family:Arial;text-align:right; font-size: 8pt;">
                   		'.$v['AcrInvoiceDetail']['quantity'].'&nbsp;
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:75px;font-family:Arial;text-align:right; font-size: 8pt;">
                   		'.$this->Number->currency($v['AcrInvoiceDetail']['unit_rate']/$invoiceData['AcrClientInvoice']['exchange_rate'],'').'
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:75px;font-family:Arial;text-align:right; font-size: 8pt;">
                   		'.$v['AcrInvoiceDetail']['discount_percent'].'
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:75px;font-family:Arial;text-align:right; font-size: 8pt;">'.$this->Number->currency($v['AcrInvoiceDetail']['line_total']/$invoiceData['AcrClientInvoice']['exchange_rate'],'').'</td>
                	<td style="width:15px;border-bottom: 1px solid #d8d8d8;float:left;"></td>
				 </tr>';
	}
	$items.='<!--<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:86px; color: #4E68A1; float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:15px;float:left;"></td>
                 </tr>-->';          
        
				$payements=null;
				// Use for Payements
				$payements.='<tr>
			        <td width="10" style="background-color:#FFFFFF"></td>
			        
			        <td width="100%">
						<table border="0">
						<tr><td align="right" width="77%" style="font-size:8pt;font-weight:Bold;font-family:Arial;">SubTotal</td>
						<td align="right" width="23%" style="font-size:8pt;font-weight:bold;font-family:Arial;">'.$this->Number->currency($invoiceData['AcrClientInvoice']['sub_total']/$invoiceData['AcrClientInvoice']['exchange_rate'],$subscriberCurrencyCode).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
						</table>
			        </td>
				</tr>';


		/*$payements.='
				<tr style="float:left;">
					<td style="background-color:#ffffff;width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:86px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:15px;flaot:left;"></td>
                 </tr>
                 
                <tr style="float:left;">
					<td style="background-color:#ffffff;width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:86px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	</td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    
                    <td style="width:75px;float:left;font-family:Arial;text-align:right;font-weight:Bold; font-size: 10pt;">
                    Subtotal
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-weight:Bold;font-size: 10pt;">'.$this->Number->currency($invoiceData['AcrClientInvoice']['sub_total']/$invoiceData['AcrClientInvoice']['exchange_rate'],$subscriberCurrencyCode).'</td>
                 	<td style="width:15px;flaot:left;"></td>
                 </tr>';*/
                 
			     foreach($taxArray as $key=>$val){
			     		
			     $payements.='<tr>
			            <td width="10" bgcolor="white"></td>
			            
			            <td width="100%">
							<table border="0">
							<tr><td align="right" width="77%" style="font-size:8pt;font-family:Arial;">'.$val['taxName'].'</td>
							    <td align="right" width="23%" style="font-size:8pt;font-family:Arial;">'.$this->Number->currency($val['taxAmount']/$invoiceData['AcrClientInvoice']['exchange_rate'],$subscriberCurrencyCode).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							</tr>
							</table>
			            </td>
					</tr>';	
		
			            
	/*$payements.='<tr style="float:left;">
					<td style="background-color:#ffffff;width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:86px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;">
                   		'.$val['taxName'].'
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;">'.$this->Number->currency($val['taxAmount']/$invoiceData['AcrClientInvoice']['exchange_rate'],$subscriberCurrencyCode).'</td>
                 	<td style="width:15px;flaot:left;"></td>
                 </tr>';*/
     }          
      
      if(!$download_pay){
      	$download_pay=0;
      }
      if(!$download_due){
      	$download_due=$invoiceData['AcrClientInvoice']['invoice_total']-$download_pay;
      }

$payements.='
		<tr>
            <td width="10" bgcolor="white"></td>
            
            <td width="100%">
				<table border="0">
				<tr>
				<td align="right" width="77%" style="font-size:8pt;font-weight:Bold;font-family:Arial;">Total</td>
				<td align="right" width="23%" style="font-size:8pt;font-weight:Bold;font-family:Arial;">'.$this->Number->currency($invoiceData['AcrClientInvoice']['invoice_total'],$subscriberCurrencyCode).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
				</table>
            </td>
		</tr>
		
		<tr>
            <td width="10" bgcolor="white"></td>
            
            <td width="100%">
				<table border="0">
				<tr><td align="right" width="77%" style="font-size:8pt;font-family:Arial;">Payment</td>
				<td align="right" width="23%" style="font-size:8pt;font-family:Arial;">'.$this->Number->currency($download_pay,$subscriberCurrencyCode).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
				</table>
            </td>
		</tr>
		
		<tr>
            <td width="10" bgcolor="white"></td>
            
            <td width="100%">
				<table border="0">
				<tr>
				  <td align="right" width="77%" style="font-size:8pt;font-weight:bold;font-family:Arial;">Balance Due</td>
				    <td align="right" width="23%" style="font-size:8pt;font-weight:Bold;color:#FF0000;font-family:Arial;">'.$this->Number->currency($download_due,$subscriberCurrencyCode).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  </td>
				</tr>
				</table>
            </td>
            <td width="10" bgcolor="white"></td>
		</tr>';	

      /*$payements.='
                <!-- <tr style="float:left;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;"></td>
                 </tr>-->
                 <tr style="float:left;">
					<td style="background-color:#ffffff;width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:86px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    
                   <td style="width:75px;float:left;font-family:Arial;text-align:right;font-weight:Bold; font-size: 10pt;">
                   		Total
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-weight:Bold;font-size: 10pt;">'.$this->Number->currency($invoiceData['AcrClientInvoice']['invoice_total'],$subscriberCurrencyCode).'</td>
				      <td style="width:15px;flaot:left;"></td>         
				</tr>
                 <tr style="float:left;">
					<td style="background-color:#ffffff;width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:86px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;">
                   		Payments
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;">'.$this->Number->currency($download_pay,$subscriberCurrencyCode).'</td>
                 	<td style="width:15px;flaot:left;"></td>
                 </tr>
                 <tr style="float:left;">
					<td style="background-color:#ffffff;width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:86px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    
                    <td style="width:75px;float:left;font-family:Arial;text-align:right;font-weight:Bold; font-size: 10pt;">
                   		Balance Due 	
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-weight:Bold;font-size: 10pt; color:#FF0000;">'.$this->Number->currency($download_due,$subscriberCurrencyCode).'</td>
                 	<td style="width:15px;flaot:left;"></td>
                 </tr>
                <tr style="float:left;">
					<td style="background-color:#ffffff;border-bottom: 1px solid #ffffff;width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:86px;border-bottom: 1px solid #d8d8d8;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:175px;border-bottom: 1px solid #d8d8d8;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	</td>
                    <td style="width:30px;border-bottom: 1px solid #d8d8d8;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:75px;border-bottom: 1px solid #d8d8d8;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;border-bottom: 1px solid #d8d8d8;float:left;font-family:Arial;text-align:right; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;border-bottom: 1px solid #d8d8d8;float:left;font-family:Arial;text-align:right; font-size: 10pt;"></td>
                    <td style="width:15px;border-bottom: 1px solid #d8d8d8;flaot:left;"></td>
                 </tr>
                 '; */
	
	// Section for popularised
	$popularised ='<table>
				<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:523px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    
                 </tr>
                <tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:523px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    
                 </tr>
                <tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:523px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">'.
                      $invoiceData['AcrClientInvoice']['notes'].' 
                    </td>
                    
                 </tr>
                 
                    
                 
                
                 </table>'; 
                 
       // Thanks and terms
       
       $thanks ='<table>
       			<!--<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:150px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                   
                    <td style="width:270px;float:left;font-family:Arial;text-align:left; font-size: 15pt;">
                   		
                    </td>
                 </tr>
					<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:150px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    
                    <td style="width:270px;float:left;font-family:Arial;text-align:left; font-size: 15pt;">
                   		
                    </td>
                 </tr>-->
					<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:150px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:270px;float:left;font-family:Arial;text-align:left; font-weight:Bold; color: #4E68A1; font-size: 14pt;">
                   		
                    </td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:150px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:270px;float:left;font-family:Arial;text-align:left; font-weight:Bold; color: #4E68A1; font-size: 14pt;">
                   		Thank you for your business
                    </td>
                 </tr>
               <!-- <tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:150px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:270px;float:left;font-family:Arial;text-align:left; font-size: 15pt;">
                   		
                    </td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:150px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:270px;float:left;font-family:Arial;text-align:left; font-size: 15pt;">
                   		
                    </td>
                 </tr>-->
                
                 </table>';    
       $terms ='<table>
       			<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:420px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                 </tr>
					<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:420px;float:left;font-family:Arial;text-align:left; font-weight:Bold;  font-size: 10pt;">Terms and Conditions 
                    </td>
                 </tr>
					<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:420px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">'.$invoiceData['AcrClientInvoice']['term_conditions']. 
                    '</td>
                 </tr>
                
                 
                
                 </table>';                        
	
$html = <<<EOD
	$heading_part
	$addresspart
	
	<table  cellpadding="0">
		
	  <tr>
	    <th style="width:10px;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;"></th>
	    <th style="width:85px;border-bottom: 1px solid #d8d8d8;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Item</th>
	    <th style="width:175px;border-bottom: 1px solid #d8d8d8;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Description</th>
	    <th style="width:30px;border-bottom: 1px solid #d8d8d8;font-family:Arial;font-weight:Bold;text-align:right; font-size: 10pt;">Qty</th>
	    <th style="width:75px;border-bottom: 1px solid #d8d8d8;font-family:Arial;font-weight:Bold;text-align:right; font-size: 10pt;">Unit Price</th>
	    <th style="width:75px;border-bottom: 1px solid #d8d8d8;font-family:Arial;font-weight:Bold;text-align:right; font-size: 10pt;">Disc %</th>
	    <th style="width:75px;border-bottom: 1px solid #d8d8d8;font-family:Arial;font-weight:Bold;text-align:right; font-size: 10pt;">Amount</th>
	    <th style="width:15px;border-bottom: 1px solid #d8d8d8;float:left;"></th>
	  </tr>
	  $items
	  </table>
	  <table  style="background-color: #F5F5F5;" cellpadding="0">
	  $payements
	  </table>
	  
	  $popularised
	  $thanks
	  $terms
EOD;

$tcpdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);  

//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
//$tcpdf->writeHTML($html, true, false, true, false, '');
/* $tmp = $_SERVER['DOCUMENT_ROOT']."accounts/app/webroot/files/uploads/invoice/";*/

$tmp = $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/files/uploads/invoice/";
//$tmp = "/var/www/html/cantorix/app/webroot/files/uploads/invoice/";
if(!is_dir($folder_url)) {
	mkdir($tmp);
}
$download_invoice_id = $invoiceData['AcrClientInvoice']['invoice_number'];
$tcpdf->Output($tmp."$download_invoice_id.pdf", 'D');  

?>
