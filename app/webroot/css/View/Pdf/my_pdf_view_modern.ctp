<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php 
App::import('Vendor','xtcpdf');  
App::import('Vendor','class.bargraph');

  
$tcpdf = new XTCPDF();
$tcpdf->SetPrintHeader(false);

$tcpdf->AddPage(); 

/*** Table starts here **/ 
 
	
	/********Table content beings here ************/
	
	// for local server pls change the img path '/var/www/html/cantorix/app/webroot/img/logo.png' to '/home/cantorix/public_html/cantorix/app/webroot/img/logo.png'
	$for_image = $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/img/logo.png";
	$heading_part ='<table style="border-bottom: 1px solid #2E2E2E;">
					
					<tr style="float:left;background-color:#FFFFFF;">
	                    <td style="width:380px;float:left;color:#4E68A1;font-family:Arial;font-weight:Bold;text-align:left; font-size: 14pt;">
	                   		INVOICE
	                   				
	                    </td>
	                    <td style="width:125;float:left;text-align:left;font-family: Arial; font-size: 30px; font-weight: bold;">
	                    	
	                    </td>' .
	                    '<td style="width:23px;float:left;"></td>
	                 </tr>
									
					<tr style="float:left;background-color:#FFFFFF;">
                    <td style="width:380px;float:left;color:#00000A;font-family:Arial;text-align:left; font-size: 11pt;">
                   		
                   		               <span style="font-family: Arial;">Inv #'.str_repeat("&nbsp;", 14).'</span><span style="font-family: Arial;font-weight: bold;">  '.$invoiceData['AcrClientInvoice']['invoice_number'].'</span>		
                    	'.nl2br("\n").'<span style="font-family: Arial;">'.str_repeat("&nbsp;", 2).'PO #'.str_repeat("&nbsp;", 14).'</span><span style="font-family: Arial;font-weight: bold;">  '.$invoiceData['AcrClientInvoice']['purchase_order_no'].'</span>
                    	'.nl2br("\n\t").'<span style="font-family: Arial;">'.str_repeat("&nbsp;", 2).'Issue Date'.str_repeat("&nbsp;", 5).'</span><span style="font-family: Arial;font-weight: bold;">  '.$invoiceData['AcrClientInvoice']['invoiced_date'].'</span>
                    	'.nl2br("\n\t").'<span style="font-family: Arial;">'.str_repeat("&nbsp;", 2).'Due'.str_repeat("&nbsp;", 17).'</span><span style="font-family: Arial;font-weight: bold;">'.$invoiceData['AcrClientInvoice']['due_date'].'</span>
                    </td>
                    <td style="width:125;float:left;text-align:left;font-family: Arial; font-size: 30px; font-weight: bold;">
                    	<img src="'.$for_image.'" alt="test alt attribute" border="0" />
                    </td>' .
                    '<td style="width:23px;float:left;"></td>
                 </tr>
                 </table>'; 
                 
  
                 
   $addresspart ='<table>
					<tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:125px;float:left;text-align:left;font-family: Arial;  font-size: 10pt;font-weight: bold;">
                    	
                    </td>' .
                    '<td style="width:23px;float:left;"></td>
                 	</tr>
					<tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">
                   		Invoice To:
                    </td>
                    <td style="width:122px;float:left;text-align:right; background-color:#4E68A1; border-bottom: 1px solid #4E68A1; font-family: Arial;  font-size: 10pt;font-weight: bold;">
                    	
                    </td><td style="width:10px;float:left;text-align:right; background-color:#4E68A1; border-left: 1px solid #4E68A1; border-right: 1px solid #4E68A1;  border-bottom: 1px solid #4E68A1; font-family: Arial; font-size: 10pt;">
                    	
                    </td><td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;font-weight:Bold;text-align:left;  font-size: 10pt;">
                   		'.$invoiceData['AcrClient']['organization_name'].'
                    </td>
                    <td style="width:122px;float:left;text-align:right; background-color:#4E68A1;  border-bottom: 1px solid #4E68A1; left;font-family: Arial;  font-size: 10pt; font-weight: bold;">
                    	'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['organization_name'].'
                    </td><td style="width:10px;float:left;text-align:right; background-color:#4E68A1;  border-left: 1px solid #4E68A1; border-right: 1px solid #4E68A1; border-bottom: 1px solid #4E68A1; font-family: Arial; font-size: 10pt;">
                    	
                    </td><td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$invoiceData['AcrClient']['billing_address_line1'].'  '.$invoiceData['AcrClient']['billing_address_line2'].'
                    </td>
                    <td style="width:122px;float:left;text-align:right; background-color:#4E68A1;  border-bottom: 1px solid #4E68A1; font-family: Arial; font-size: 10pt; ">
                    	'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'].'  '.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'].'
                    </td><td style="width:10px;float:left;text-align:right; background-color:#4E68A1; border-left: 1px solid #4E68A1; border-right: 1px solid #4E68A1; font-family: Arial; font-size: 10pt;">
                    	
                    </td><td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$invoiceData['AcrClient']['billing_city'].'
                    </td>
                    <td style="width:122px;float:left;text-align:right; background-color:#4E68A1;  border-bottom: 1px solid #4E68A1; font-family: Arial; font-size: 10pt; ">
                    	'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'
                    </td><td style="width:10px;float:left;text-align:right; background-color:#4E68A1; border-left: 1px solid #4E68A1; border-right: 1px solid #4E68A1; border-bottom: 1px solid #4E68A1; font-family: Arial; font-size: 10pt;">
                    	
                    </td><td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$invoiceData['AcrClient']['billing_state'].'
                    </td>
                    <td style="width:122px;float:left;text-align:right; background-color:#4E68A1;  border-bottom: 1px solid #4E68A1; font-family: Arial; font-size: 10pt;">
                    	'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'
                    </td><td style="width:10px;float:left;text-align:right; background-color:#4E68A1; border-left: 1px solid #4E68A1; border-right: 1px solid #4E68A1; border-bottom: 1px solid #4E68A1;font-family: Arial; font-size: 10pt;">
                    	
                    </td><td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$invoiceData['AcrClient']['billing_country'].'
                    </td>
                    <td style="width:122px;float:left;text-align:right; background-color:#4E68A1;  border-bottom: 1px solid #4E68A1; font-family: Arial; font-size: 10pt;">
                    	'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'
                    </td><td style="width:10px;float:left;text-align:right; background-color:#4E68A1; border-left: 1px solid #4E68A1; border-right: 1px solid #4E68A1; border-bottom: 1px solid #4E68A1;font-family: Arial; font-size: 10pt;">
                    	
                    </td><td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$invoiceData['AcrClient']['shipping_zip'].'
                    </td>
                    <td style="width:122px;float:left;text-align:right; background-color:#4E68A1; border-bottom: 1px solid #4E68A1; font-family: Arial; font-size: 10pt;">
                    	'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'].'
                    </td>
                    <td style="width:10px;float:left;text-align:right; background-color:#4E68A1; border-left: 1px solid #4E68A1; border-right: 1px solid #4E68A1; border-bottom: 1px solid #4E68A1; font-family: Arial; font-size: 10pt;">
                    	
                    </td>
                    <td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:122px;float:left;text-align:right; background-color:#4E68A1; border-bottom: 1px solid #4E68A1; font-family: Arial; font-size: 10pt;">
                    	
                    </td><td style="width:10px;float:left;text-align:right; background-color:#4E68A1;border-left: 1px solid #4E68A1; border-right: 1px solid #4E68A1; border-bottom: 1px solid #4E68A1; font-family: Arial; font-size: 10pt;">
                    	
                    </td><td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:122px;float:left;text-align:right;font-family: Arial; font-size: 10pt;">
                    	
                    </td><td style="width:10px;float:left;text-align:right;font-family: Arial; font-size: 10pt;">
                    	
                    </td><td style="width:23px;float:left;"></td>
                 </tr>
                 </table>'; 
	              
	
	
	
	$items=null;
		
	// Use for each For all items
	foreach($invoiceDetail as $k=>$v){
	if(!$v['InvInventory']['name']){
		$v['InvInventory']['name']='Non Inventory Item';
	}
		
	$items.='<tr style="float:left;background-color:#FFFFFF;">
				<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:100px; color: #4E68A1; float:left;font-family:Arial;text-align:left; font-size: 10pt;">'.$v['InvInventory']['name'].'</td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$v['InvInventory']['description'].'
                    </td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$v['AcrInvoiceDetail']['quantity'].'
                    </td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$this->Number->currency($v['AcrInvoiceDetail']['unit_rate']*$invoiceData['AcrClientInvoice']['exchange_rate'],$subscriberCurrencyCode).'
                    </td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$v['AcrInvoiceDetail']['discount_percent'].'
                    </td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">'.$this->Number->currency($v['AcrInvoiceDetail']['line_total']*$invoiceData['AcrClientInvoice']['exchange_rate'],$subscriberCurrencyCode).'</td>
                 </tr>';
	}
	$items.='<tr style="float:left;background-color:#FFFFFF;">
				<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:100px; color: #4E68A1; float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                 </tr>';          
        
	$payements=null;
	// Use for Payements
	
		$payements.='
				<tr style="float:left;">
				<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                 </tr>
                 
                <tr style="float:left;">
				<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right;font-weight:Bold; font-size: 10pt;">
                   		Subtotal
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-weight:Bold;font-size: 10pt;">'.$this->Number->currency($invoiceData['AcrClientInvoice']['sub_total'],$subscriberCurrencyCode).'</td>
                 </tr>';
     foreach($taxArray as $key=>$val){            
	$payements.='<tr style="float:left;">
				<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;">
                   		'.$val['taxName'].'
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;">'.$this->Number->currency($val['taxAmount']*$invoiceData['AcrClientInvoice']['exchange_rate'],$subscriberCurrencyCode).'</td>
                 </tr>';
     }          
      
      if(!$download_pay){
      	$download_pay=0;
      }
      if(!$download_due){
      	$download_due=$invoiceData['AcrClientInvoice']['invoice_total']-$download_pay;
      }
      $payements.='
                 <tr style="float:left;">
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
                 </tr>
                 <tr style="float:left;">
				<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
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
                 </tr>
                 <tr style="float:left;">
				<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
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
                 </tr>
                 <tr style="float:left;">
				<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
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
                 </tr>
                 <tr style="float:left;">
				<td style="border-bottom: 1px solid #2E2E2E;width:10px;float:left;color:#0f6082;"></td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;">
                   		
                    </td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;"></td>
                 </tr>
                 '; 
	
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
                    <td style="width:523px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                    	It was popularised in the 1960s with. 
                    </td>
                    
                 </tr>
                 <td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:523px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                    	It was popularised in the 1960. 
                    </td>
                    
                 </tr>
                 <td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:523px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                    	It was popularised in the 1960s with the release of Letraset sheets. 
                    </td>
                    
                 </tr>
                 <td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:523px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                    	It was popularised. 
                    </td>
                    
                 </tr>
                 
                
                 </table>'; 
                 
       // Thanks and terms
       
       $thanks ='<table>
       			<tr style="float:left;background-color:#FFFFFF;">
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
                 </tr>
					<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:150px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:270px;float:left;font-family:Arial;text-align:left; font-weight:Bold; color: #4E68A1; font-size: 14pt;">
                   		Thank you for your business
                    </td>
                 </tr>
                <tr style="float:left;background-color:#FFFFFF;">
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
                 </tr>
                
                 </table>';    
       $terms ='<table>
       			<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:420px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                 </tr>
					<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:420px;float:left;font-family:Arial;text-align:left; font-weight:Bold;  font-size: 10pt;">
                   		Terms and Conditions 
                    </td>
                 </tr>
					<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:420px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">'
                   		.$invoiceData['AcrClient']['term_conditions']. 
                    '</td>
                 </tr>
                
                 
                
                 </table>';                        
	
$html = <<<EOD
	$heading_part
	$addresspart
	
	<table  cellpadding="0">
		
	  <tr>
	    <th style="width:10px;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;"></th>
	    <th style="width:100px;border-bottom: 1px solid #2E2E2E;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Item</th>
	    <th style="width:175px;border-bottom: 1px solid #2E2E2E;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Description</th>
	    <th style="width:30px;border-bottom: 1px solid #2E2E2E;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Qty</th>
	    <th style="width:75px;border-bottom: 1px solid #2E2E2E;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Unit Price</th>
	    <th style="width:75px;border-bottom: 1px solid #2E2E2E;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Disc %</th>
	    <th style="width:75px;border-bottom: 1px solid #2E2E2E;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Amount</th>
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
$tcpdf->Output($tmp."$download_invoice_id.pdf", 'F');  

?>
