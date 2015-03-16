<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php
	if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
	  $protocol_final = 'https';
	}else{
	  $protocol_final = 'http';
	}
	$http_hostname = '192.168.0.164';
	$webroot_name = 'cantorix/';
	$imgLink = "$protocol_final".'://'."$http_hostname/";
?>
<?php 
App::import('Vendor','xtcpdf');  
App::import('Vendor','class.bargraph');

  
$tcpdf = new XTCPDF();
$tcpdf->SetPrintHeader(false);

$tcpdf->AddPage(); 

/*** Table starts here **/ 
 
	if($quote['SlsQuotation']['expiry_date']) {
		$expiryDate = date($settings['SbsSubscriberSetting']['date_format'],strtotime($quote['SlsQuotation']['expiry_date']));
	} else {
		$expiryDate = '--';
	}
	
	/********Table content beings here ************/
	
	// for local server pls change the img path '/var/www/html/cantorix/app/webroot/img/logo.png' to '/home/cantorix/public_html/cantorix/app/webroot/img/logo.png'
	 if(!empty($settings['SbsSubscriberSetting']['invoice_logo'])) {
		//$for_image = $_SERVER['DOCUMENT_ROOT'].'app/webroot/'.$settings['SbsSubscriberSetting']['invoice_logo'];
		$for_image = $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/img/logo.png";
	 } else { 
		$for_image = $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/img/logo.png";
	 }
	$heading_part ='<table style="border-bottom: 1px solid #2E2E2E;">
					<tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;color:#0f6082;font-family:Arial;font-weight:Bold;text-align:left; font-size: 12pt;">
                   		<img src="'.$for_image.'" alt="test alt attribute" border="0" />
                   				
                    </td>
                    <td style="width:125;float:left;text-align:left;font-family: Arial; font-size: 30px; font-weight: bold;">
                    	'.nl2br("QUOTE\n").'<span style="font-family: Arial;">  Quote #</span><span style="font-family: Arial;font-weight: bold;">  '.$quote['SlsQuotation']['quotation_no'].'</span>
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
                   		From:
                    </td>
                    <td style="width:125px;float:left;text-align:left;font-family: Arial;  font-size: 10pt;font-weight: bold;">
                    	Quote To:
                    </td>' .
                    '<td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;font-weight:Bold;text-align:left;  font-size: 10pt;">
                   		'.$organisationDetails['SbsSubscriberOrganizationDetail']['organization_name'].'
                    </td>
                    <td style="width:125px;float:left;text-align:left;font-family: Arial;  font-size: 10pt; font-weight: bold;">
                    	'.$quote['AcrClient']['organization_name'].'
                    </td>' .
                    '<td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'].'  '.$organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'].'
                    </td>
                    <td style="width:125px;float:left;text-align:left;font-family: Arial; font-size: 10pt; ">
                    	'.$quote['AcrClient']['billing_address_line1'].'  '.$quote['AcrClient']['billing_address_line2'].'
                    </td>' .
                    '<td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'].'
                    </td>
                    <td style="width:125px;float:left;text-align:left;font-family: Arial; font-size: 10pt; ">
                    	'.$quote['AcrClient']['billing_city'].'
                    </td>' .
                    '<td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'].'
                    </td>
                    <td style="width:125px;float:left;text-align:left;font-family: Arial; font-size: 10pt;">
                    	'.$quote['AcrClient']['billing_state'].'
                    </td>' .
                    '<td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'].'
                    </td>
                    <td style="width:125px;float:left;text-align:left;font-family: Arial; font-size: 10pt;">
                    	'.$quote['AcrClient']['billing_country'].'
                    </td>' .
                    '<td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'].'
                    </td>
                    <td style="width:125px;float:left;text-align:left;font-family: Arial; font-size: 10pt;">
                    	'.$quote['AcrClient']['billing_zip'].'
                    </td>' .
                    '<td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:125px;float:left;text-align:left;font-family: Arial; font-size: 10pt;">
                    	
                    </td>' .
                    '<td style="width:23px;float:left;"></td>
                 </tr>
                 </table>'; 
	              
	
	$datepart ='<table>
					<tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:146px;float:left;color:#0f6082;"></td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:50px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:23px;float:left;"></td>
                 </tr>
					<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:146px;float:left;color:#0f6082;"></td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:100px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">
                   		Issue Date
                    </td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:100px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">
                   		Due Date 	
                    </td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:50px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">
                   		PO #
                    </td>
                    <td style="width:23px;float:left;"></td>
                 </tr>
                 
                 
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:146px;float:left;color:#0f6082;"></td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.date($settings['SbsSubscriberSetting']['date_format'],strtotime($quote['SlsQuotation']['issue_date'])).'
                    </td>
                    
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$expiryDate.'
                    </td>
                    <td style="width:50px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$quote['SlsQuotation']['purchase_order_no'].'
                    </td>
                    <td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;"><td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:146px;float:left;color:#0f6082;"></td>
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
	foreach($quoteProducts as $k=>$v){
		if(!$v['InvInventory']['name']){
			$v['InvInventory']['name']='Non Inventory Item';
		}
	$items.='<tr style="float:left;background-color:#FFFFFF;">
				<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;color: #4E68A1;">'.$v['InvInventory']['name'].'</td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$v['InvInventory']['description'].'
                    </td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$v['SlsQuotationProduct']['quantity'].'
                    </td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$this->Number->currency(($v['SlsQuotationProduct']['unit_rate']*$quote['SlsQuotation']['exchange_rate']),$quote['SlsQuotation']['invoice_currency_code']).'
                    </td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		'.$v['SlsQuotationProduct']['discount_percent'].'
                    </td>
                    <td style="border-bottom: 1px solid #2E2E2E;width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">'.$this->Number->currency(($v['SlsQuotationProduct']['line_total']*$quote['SlsQuotation']['exchange_rate']),$quote['SlsQuotation']['invoice_currency_code']).'</td>
                 </tr>';
	}          
        
	$payements=null;
	// Use for Payements
	
		$payements.='
				<tr style="float:left;background-color:#FFFFFF;">
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
                 
                <tr style="float:left;background-color:#FFFFFF;">
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
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-weight:Bold;font-size: 10pt;">'.$invoiceData['AcrClientInvoice']['sub_total'].'</td>
                 </tr>';
     foreach($taxCalcuations as $key=>$val){            
	$payements.='<tr style="float:left;background-color:#FFFFFF;">
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
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;">'.$this->Number->currency(($val['taxAmount']*$quote['SlsQuotation']['exchange_rate']),$quote['SlsQuotation']['invoice_currency_code']).'</td>
                 </tr>';
     }          
      
      
      $payements.='
                 <tr style="float:left;background-color:#FFFFFF;">
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
                 <tr style="float:left;background-color:#FFFFFF;">
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
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-weight:Bold;font-size: 10pt;">'.$this->Number->currency($quote['SlsQuotation']['invoice_amount'],$quote['SlsQuotation']['invoice_currency_code']).'</td>
                 </tr>
                 
                 <tr style="float:left;background-color:#FFFFFF;">
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
                    <td style="width:270px;float:left;font-family:Arial;text-align:left; font-weight:Bold; font-size: 14pt;">
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
                    <td style="width:420px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which do not look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc. 
                    </td>
                 </tr>
                
                 
                
                 </table>';                        
	
$html = <<<EOD
	$heading_part
	$addresspart
	$datepart
	<table  cellpadding="0">
		
	  <tr>
	    <th style="width:10px;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;"></th>
	    <th style="width:100px;border-bottom: 1px solid #2E2E2E;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Service</th>
	    <th style="width:175px;border-bottom: 1px solid #2E2E2E;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Description</th>
	    <th style="width:30px;border-bottom: 1px solid #2E2E2E;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Qty</th>
	    <th style="width:75px;border-bottom: 1px solid #2E2E2E;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Unit Price</th>
	    <th style="width:75px;border-bottom: 1px solid #2E2E2E;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Disc %</th>
	    <th style="width:75px;border-bottom: 1px solid #2E2E2E;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Amount</th>
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

$tmp = $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/files/uploads/quotes/Subscriber-".$subscriberID.'/';
$quoteNumber = $quote['SlsQuotation']['quotation_no'];
$tcpdf->Output($tmp."$quoteNumber.pdf", 'F');  

?>
