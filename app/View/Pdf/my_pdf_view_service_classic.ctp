<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php if($invoiceData['AcrClientInvoice']['exchange_rate']){
	$invoiceData['AcrClientInvoice']['exchange_rate'] = $invoiceData['AcrClientInvoice']['exchange_rate'];
}else{
	$invoiceData['AcrClientInvoice']['exchange_rate'] = 1;
}?>
<?php 
App::import('Vendor','xtcpdf');  
App::import('Vendor','class.bargraph');

  
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
	$heading_part ='<table>
					<tr style="border-bottom: 1px solid #888888;float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="border-bottom: 1px solid #888888;width:400px;float:left;color:#0f6082;font-family:Arial;font-weight:Bold;text-align:left; font-size: 12pt;">
                   		<img src="'.$for_image.'" alt="test alt attribute" border="0" />
                   				
                    </td>
                    <td style="border-bottom: 1px solid #888888;width:125;float:left;text-align:right;font-family: Arial; font-size: 22.5pt; font-weight: bold;">
                    	'.nl2br("INVOICE\n").'<span style="font-family: font-weight: normal; Arial;font-size:10.5pt;">'.str_repeat("&nbsp;",5).'Inv #</span><span style="font-family: Arial;font-weight: bold;font-size:10.5pt;">  '.$invoiceData['AcrClientInvoice']['invoice_number'].'</span>
                    </td>' .
                    '<td style="border-bottom: 1px solid #888888;width:18px;float:left;"></td>
                 </tr>
                 </table>'; 
                 
  
                 
   $addresspart ='<table>
   <tr style="float:left;background-color:#FFFFFF;">
   <td style="width:5px;float:left;color:#0f6082;"></td>
   <td style="width:380px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;"></td>
   <td style="width:118px;float:left;text-align:left;font-family: Arial;  font-size: 10pt;font-weight: bold;"></td>
   <td style="width:18px;float:left;"></td>
   </tr>
   <tr style="float:left;background-color:#FFFFFF;">
   <td style="width:5px;float:left;color:#0f6082;"></td>
   <td style="width:400px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">From:</td>
   <td style="width:118px;float:left;text-align:right;font-family: Arial;  font-size: 10pt;font-weight: bold;">Invoice To:</td>
   <td style="width:18px;float:left;"></td>
   </tr>
   <tr style="float:left;background-color:#FFFFFF;">
   <td style="width:5px;float:left;color:#0f6082;"></td>
   <td style="width:400px;float:left;font-family:Arial;font-weight:Bold;text-align:left;  font-size:12pt;">'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['organization_name'].'</td>
   <td style="width:118px;float:left;text-align:right;font-family: Arial;  font-size: 12pt; font-weight: bold;">'.$invoiceData['AcrClient']['organization_name'].'</td>
   <td style="width:18px;float:left;"></td>
   </tr>
   <tr style="float:left;background-color:#FFFFFF;">
   <td style="width:5px;float:left;color:#0f6082;"></td>
   <td style="width:400px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">'.$subscriberAddress.'</td>
   <td style="width:118px;float:left;text-align:right;font-family: Arial; font-size: 10pt; ">'.$clientAddress.'</td>
   <td style="width:18px;float:left;"></td>
   </tr>
   <tr style="float:left;background-color:#FFFFFF;">
   <td style="width:5px;float:left;color:#0f6082;"></td>
   <td style="width:400px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
   <td style="width:118px;float:left;text-align:right;font-family: Arial; font-size: 10pt;"></td>
   <td style="width:18px;float:left;"></td>
   </tr>
   </table>'; 
	              
	
	$datepart ='<table>
					<tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:46px;float:left;color:#0f6082;"></td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:50px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:23px;float:left;"></td>
                 </tr>
					<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:50px;float:left;color:#0f6082;"></td>
                    <td style="border-bottom: 1px solid #eee;width:100px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">
                   		Invoice Date
                    </td>
                    <td style="border-bottom: 1px solid #eee;width:100px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">
                   		Terms
                    </td>
                    <td style="border-bottom: 1px solid #eee;width:100px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">
                   		Due Date 	
                    </td>
                    <td style="border-bottom: 1px solid #eee;width:100px;float:left;font-family:Arial;font-weight:Bold;text-align:center; font-size: 10pt;">
                   		PO #
                    </td>
                    <td style="width:23px;float:left;"></td>
                 </tr>
                 
                 
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:46px;float:left;color:#0f6082;"></td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['invoiced_date'])).'
                    </td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$invoiceData['SbsSubscriberPaymentTerm']['term'].'
                    </td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['due_date'])).'
                    </td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:center; font-size: 10pt;">
                   		'.$invoiceData['AcrClientInvoice']['purchase_order_no'].'
                    </td>
                    <td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:46px;float:left;color:#0f6082;"></td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:50px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:23px;float:left;"></td>
                 </tr>		
                 </table>'; 
	
	$items=null;
		
	// Use for each For all items
	foreach($invoiceDetail as $k=>$v){
		
	if(empty($v['AcrInvoiceDetail']['discount_percent'])) {
		$discount = 0 .'%';
	}else{
		$discount = $v['AcrInvoiceDetail']['discount_percent'].'%';
	}	
	$items.='<tr style="float:left;background-color:#FFFFFF;">
				<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="border-bottom: 1px solid #888888;width:100px;font-family:Arial;text-align:left; font-size: 8pt;">'.$v['InvInventory']['name'].'&nbsp;</td>
                    <td style="border-bottom: 1px solid #888888;width:195px;font-family:Arial;text-align:left; font-size: 8pt;">'.$v['AcrInvoiceDetail']['inventory_description'].'&nbsp;
                    </td>
                    <td style="border-bottom: 1px solid #888888;width:30px;font-family:Arial;text-align:right; font-size: 8pt;">
                   		'.$v['AcrInvoiceDetail']['quantity'].'
                    </td>
                    <td style="border-bottom: 1px solid #888888;width:75px;font-family:Arial;text-align:right; font-size: 8pt;">
                   		'.$this->Number->currency($v['AcrInvoiceDetail']['unit_rate']/$invoiceData['AcrClientInvoice']['exchange_rate'],'').'
                    </td>
                    <td style="border-bottom: 1px solid #888888;width:40px;font-family:Arial;text-align:right; font-size: 8pt;">
                   		'.$discount.'
                    </td>
                    <td style="border-bottom: 1px solid #888888;width:75px;font-family:Arial;text-align:right; font-size: 8pt;">'.$this->Number->currency($v['AcrInvoiceDetail']['line_total']/$invoiceData['AcrClientInvoice']['exchange_rate'],'').'</td>
                 	<td style="border-bottom: 1px solid #ffffff;width:18px;float:left;"></td>
                 </tr>';
	}          
        
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
				<tr style="float:left;background-color:#FFFFFF;">
				<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:60px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:160px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:115px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:18px;float:left;"></td>
                 </tr>
                 
                <tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:60px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:160px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:115px;float:left;font-family:Arial;text-align:right;font-weight:Bold; font-size: 10pt;">
                   		Subtotal
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-weight:Bold;font-size: 10pt;">'.$this->Number->currency($invoiceData['AcrClientInvoice']['sub_total']/$invoiceData['AcrClientInvoice']['exchange_rate'],$subscriberCurrencyCode).'</td>
                 	<td style="width:18px;float:left;"></td>
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
     	            
	/*$payements.='<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:60px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:160px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:115px;float:left;font-family:Arial;text-align:right; font-size: 10pt;">
                   		'.$val['taxName'].'
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;">'.$this->Number->currency($val['taxAmount']/$invoiceData['AcrClientInvoice']['exchange_rate'],$subscriberCurrencyCode).'</td>
                 	<td style="width:18px;float:left;"></td>
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
		
		<tr style="background-color:#FFFFFF;">
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
                 <tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:60px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:160px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:115px;float:left;font-family:Arial;text-align:right; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;"></td>
                    <td style="width:18px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:60px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:160px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:115px;float:left;font-family:Arial;text-align:right;font-weight:Bold; font-size: 10pt;">
                   		Total
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-weight:Bold;font-size: 10pt;">'.$this->Number->currency($invoiceData['AcrClientInvoice']['invoice_total'],$subscriberCurrencyCode).'</td>
                 	<td style="width:18px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:60px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:160px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="border-bottom: 1px solid #888888;width:115px;float:left;font-family:Arial;text-align:right; font-size: 10pt;">
                   		Payments
                    </td>
                    <td style="border-bottom: 1px solid #888888;width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;">'.$this->Number->currency($download_pay,$subscriberCurrencyCode).'</td>
                 	<td style="width:18px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:60px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:160px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="border-bottom: 1px solid #888888;width:115px;float:left;font-family:Arial;text-align:right;font-weight:Bold; font-size: 10pt;">
                   		Balance Due 	
                    </td>
                    <td style="border-bottom: 1px solid #888888;width:75px;float:left;font-family:Arial;text-align:right; font-weight:Bold;font-size: 10pt;">'.$this->Number->currency($download_due,$subscriberCurrencyCode).'</td>
                 	<td style="width:18px;float:left;"></td>
                 </tr>
                <!-- <tr style="float:left;background-color:#FFFFFF;">
				<td style="border-bottom: 1px solid #d8d8d8;width:10px;float:left;color:#0f6082;"></td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;">
                   		
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;"></td>
                 </tr>-->
                 '; */
	
	// Section for popularised
	$popularised ='<table>
				<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:523px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    
                 </tr>
                <tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:420px;float:left;font-family:Arial;text-align:left; font-weight:Bold;  font-size: 10pt;">Customer Note</td>
                    
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
                    <td style="width:270px;float:left;font-family:Arial;text-align:left; font-weight:Bold; font-size: 14pt;">
                   	
                    </td>
                 </tr>
					<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:150px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:270px;float:left;font-family:Arial;text-align:left; font-weight:Bold; font-size: 14pt;">
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
                    <td style="width:420px;float:left;font-family:Arial;text-align:left; font-weight:Bold;  font-size: 10pt;">Terms and Conditions</td>
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
	$datepart
	<table  cellpadding="0">
		
	  <tr>
	    <th style="width:10px;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;"></th>
	    <th style="width:100px;border-bottom: 1px solid #888888;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Service</th>
	    <th style="width:195px;border-bottom: 1px solid #888888;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Description</th>
	    <th style="width:30px;border-bottom: 1px solid #888888;font-family:Arial;font-weight:Bold;text-align:right; font-size: 10pt;">Qty</th>
	    <th style="width:75px;border-bottom: 1px solid #888888;font-family:Arial;font-weight:Bold;text-align:right; font-size: 10pt;">Rate</th>
	    <th style="width:40px;border-bottom: 1px solid #888888;font-family:Arial;font-weight:Bold;text-align:right; font-size: 10pt;">Disc %</th>
	    <th style="width:75px;border-bottom: 1px solid #888888;font-family:Arial;font-weight:Bold;text-align:right; font-size: 10pt;">Amount</th>
	  	<th style="border-bottom: 1px solid #ffffff;width:18px;float:left;"></th>
	  </tr>
	  $items
	  </table>
	  <table  cellpadding="0">
	  $payements
	  </table>
	  
	  $popularised
	  $thanks
	  $terms
EOD;

$tcpdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);  
$tmp = $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/files/uploads/invoice/Subscriber-".$subscriberId;
//$tmp = "/var/www/html/cantorix/app/webroot/files/uploads/invoice/";
if (!is_dir($tmp)) {
	mkdir($tmp);
	chmod($tmp,0777);
}
$download_invoice_id = $invoiceData['AcrClientInvoice']['invoice_number'];
chmod($tmp."/$download_invoice_id.pdf",0777);
$tcpdf->Output($tmp."/$download_invoice_id.pdf", 'F');  

?>
