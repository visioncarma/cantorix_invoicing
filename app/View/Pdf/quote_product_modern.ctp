<?php $this->CurrencySymbol->getAllCurrencies();?>
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
		$expiryDate = ' ';
	}
	/********Table content beings here ************/
	// for local server pls change the img path '/var/www/html/cantorix/app/webroot/img/logo.png' to '/home/cantorix/public_html/cantorix/app/webroot/img/logo.png'
	  if(!empty($settings['SbsSubscriberSetting']['invoice_logo'])) {
		$explodeImg = explode('/', $settings['SbsSubscriberSetting']['invoice_logo']);
		 foreach ($explodeImg as $keyIndexInArray => $explodedValue) {
			 $imageName = $explodedValue;
		 }
		$for_image = $_SERVER['DOCUMENT_ROOT'].'/'.$this->webroot.'/app/webroot/files/uploads/logo-subscriber'.$quote['SlsQuotation']['sbs_subscriber_id'].'/'.$explodedValue;
	 } else { 
		$for_image = $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/img/logo.png";
	 }
	 if(!empty($settings['SbsSubscriberSetting']['text_logo'])) {
		$logoText = '<div>'.$settings['SbsSubscriberSetting']['text_logo'].'</div>';
	 }
	$heading_part ='<table style="border-bottom: 1px solid #2E2E2E;">
						<tr style="float:left;background-color:#FFFFFF;">
	                    	<td style="width:405px;float:left;color:#4E68A1;font-family:Arial;font-weight:Bold;text-align:left; font-size: 14pt;">'.str_repeat("&nbsp;", 1).'Quote</td>
	                    	<td style="width:125;float:left;text-align:left;font-family: Arial; font-size: 30px; font-weight: bold;"></td>
	                    	
	                 	</tr>
						<tr style="float:left;background-color:#FFFFFF;">
                    		<td style="width:405px;float:left;color:#00000A;font-family:Arial;text-align:left; font-size: 9.5pt;">
                   				<span style="font-family: Arial;">Quote #'.str_repeat("&nbsp;", 10).'</span><span style="font-family: Arial;font-weight: bold;">'.$quote['SlsQuotation']['quotation_no'].'</span>		
                    	'.nl2br("\n").'<span style="font-family: Arial;">'.str_repeat("&nbsp;", 2).'PO #'.str_repeat("&nbsp;", 13).'</span><span style="font-family: Arial;font-weight: bold;">  '.$quote['SlsQuotation']['purchase_order_no'].'</span>
                    	'.nl2br("\n\t").'<span style="font-family: Arial;">'.str_repeat("&nbsp;", 2).'Issue Date'.str_repeat("&nbsp;", 4).'</span><span style="font-family: Arial;font-weight: bold;">  '.date($settings['SbsSubscriberSetting']['date_format'],strtotime($quote['SlsQuotation']['issue_date'])).'</span>
                    	'.nl2br("\n\t").'<span style="font-family: Arial;">'.str_repeat("&nbsp;", 2).'Expiry Date'.str_repeat("&nbsp;", 5).'</span><span style="font-family: Arial;font-weight: bold;">'.$expiryDate.'</span>
                    </td>
                    
					
					
                    <td style="width:125;float:left;text-align:left;font-family: Arial; font-size: 30px; font-weight: bold;">
                    	<img src="'.$for_image.'" alt="test alt attribute" border="0" />'.$logoText.'
                    </td>' .
                    '
                 </tr>
                 </table>'; 
                 
  
                 
   $addresspart ='<table>
   <tr style="float:left;background-color:#FFFFFF;">
   <td style="width:5px;float:left;color:#0f6082;"></td>
   <td style="width:400px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;"></td>
   <td style="width:118px;float:left;text-align:left;font-family: Arial;  font-size: 10pt;font-weight: bold;"></td>
   <td style="width:23px;float:left;"></td>
   </tr>
   <tr style="float:left;background-color:#FFFFFF;">
   <td style="width:5px;float:left;color:#0f6082;"></td>
   <td style="width:400px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Quote To:</td>
   <td style="width:118px;float:left;text-align:right; background-color:#4E68A1; border-bottom: 1px solid #4E68A1; font-family: Arial;  font-size: 10pt;font-weight: bold;"></td>
   <td style="width:10px;float:left;text-align:right; background-color:#4E68A1; border-left: 1px solid #4E68A1; border-right: 1px solid #4E68A1;  border-bottom: 1px solid #4E68A1; font-family: Arial; font-size: 10pt;"></td>
   <td style="width:23px;float:left;"></td>
   </tr>
   <tr style="float:left;background-color:#FFFFFF;">
   <td style="width:5px;float:left;color:#0f6082;"></td>
   <td style="width:400px;float:left;font-family:Arial;font-weight:Bold;text-align:left;color:#000000;font-size: 13.5pt;">'.$quote['AcrClient']['organization_name'].'</td>
   <td style="width:118px;float:left;text-align:right; background-color:#4E68A1; color:#ffffff; border-bottom: 1px solid #4E68A1; left;font-family: Arial;  font-size: 13.5pt; font-weight: bold;">'.$organisationDetails['SbsSubscriberOrganizationDetail']['organization_name'].'</td>
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
	foreach($quoteProducts as $k=>$v){
	if(!$quote['SlsQuotation']['exchange_rate']){$quote['SlsQuotation']['exchange_rate'] = 1;}
	if(empty($v['SlsQuotationProduct']['discount_percent'])) {
		$discount = 0 .'%';
	}else{
		$discount = $v['SlsQuotationProduct']['discount_percent'].'%';
	}	
	$items.='<tr style="float:left;background-color:#FFFFFF;">
				<td style="width:10px;color:#0f6082;"></td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:85px; color: #4E68A1;font-family:Arial;text-align:left; font-size: 8pt;">'.$v['InvInventory']['name'].'</td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:175px;font-family:Arial;text-align:left; font-size: 8pt;">'.$v['SlsQuotationProduct']['inventory_description'].'
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:30px;font-family:Arial;text-align:right; font-size: 8pt;">
                   		'.$v['SlsQuotationProduct']['quantity'].'
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:75px;font-family:Arial;text-align:right; font-size: 8pt;">
                   		'.$this->Number->currency(($v['SlsQuotationProduct']['unit_rate']/$quote['SlsQuotation']['exchange_rate']),'').'
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:75px;font-family:Arial;text-align:right; font-size: 8pt;">
                   		'.$discount.'
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:75px;font-family:Arial;text-align:right; font-size: 8pt;">'.$this->Number->currency(($v['SlsQuotationProduct']['line_total']/$quote['SlsQuotation']['exchange_rate']),'').'</td>
                 	<td style="width:15px;border-bottom: 1px solid #d8d8d8;float:left;"></td>
                 </tr>';
	}
	$items.=' <!--<tr style="float:left;background-color:#FFFFFF;">
				<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:85px; color: #4E68A1; float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
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
                 </tr> -->';         
        
	$payements=null;
	// Use for Payements
	$payements.='<tr>
        <td width="10" style="background-color:#FFFFFF"></td>
        
        <td width="100%">
			<table border="0">
			<tr><td align="right" width="77%" style="font-size:8pt;font-weight:Bold;font-family:Arial;">SubTotal</td>
			<td align="right" width="23%" style="font-size:8pt;font-weight:bold;font-family:Arial;">'.$this->Number->currency(($quote['SlsQuotation']['sub_total']/$quote['SlsQuotation']['exchange_rate']),$quote['SlsQuotation']['invoice_currency_code']).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
			</table>
        </td>
	</tr>';
	
		/*$payements.='
				<tr style="float:left;">
					<td style="background-color:#FFFFFF;width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:85px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
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
                 </tr>
                 
                <tr style="float:left;">
					<td style="background-color:#FFFFFF;width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:85px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right;font-weight:Bold; font-size: 8pt;">
                   		Subtotal
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-weight:Bold;font-size: 8pt;">'.$this->Number->currency(($quote['SlsQuotation']['sub_total']/$quote['SlsQuotation']['exchange_rate']),$quote['SlsQuotation']['invoice_currency_code']).'</td>
                 	<td style="width:15px;float:left;"></td>
                 </tr>';*/
                 
     foreach($taxCalcuations as $key=>$val){
     $payements.='<tr>
            <td width="10" bgcolor="white"></td>
            
            <td width="100%">
				<table border="0">
				<tr><td align="right" width="77%" style="font-size:8pt;font-family:Arial;">'.$val['taxName'].'</td>
				    <td align="right" width="23%" style="font-size:8pt;font-family:Arial;">'.$this->Number->currency(($val['taxAmount']/$quote['SlsQuotation']['exchange_rate']),$quote['SlsQuotation']['invoice_currency_code']).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
				</table>
            </td>
		</tr>';		
     	            
	/*$payements.='<tr style="float:left;">
					<td style="background-color:#FFFFFF;width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:85px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-size: 8pt;">
                   		'.$val['taxName'].'
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-size: 8pt;">'.$this->Number->currency(($val['taxAmount']/$quote['SlsQuotation']['exchange_rate']),$quote['SlsQuotation']['invoice_currency_code']).'</td>
                 	<td style="width:15px;float:left;"></td>
                 </tr>';*/
     }          
      
	  $payements.='
		<tr>
            <td width="10" bgcolor="white"></td>
            
            <td width="100%">
				<table border="0">
				<tr>
				<td align="right" width="77%" style="font-size:8pt;font-weight:Bold;font-family:Arial;">Total</td>
				<td align="right" width="23%" style="font-size:8pt;font-weight:Bold;font-family:Arial;">'.$this->Number->currency($quote['SlsQuotation']['invoice_amount'],$quote['SlsQuotation']['invoice_currency_code']).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
				</table>
            </td>
		</tr>';	
		
      /*$payements.='
                 <tr style="float:left;">
					<td style="background-color:#FFFFFF;width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:85px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;"></td>
                    <td style="width:15px;float:left;"></td>
                 </tr>
                 <tr style="float:left;">
				<td style="background-color:#FFFFFF;width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:85px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right;font-weight:Bold; font-size: 8pt;">
                   		Total
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-weight:Bold;font-size: 8pt;">'.$this->Number->currency($quote['SlsQuotation']['invoice_amount'],$quote['SlsQuotation']['invoice_currency_code']).'</td>
                 	<td style="width:15px;float:left;"></td>
                 </tr>
                 
                 <tr style="float:left;">
					<td style="background-color:#FFFFFF;border-bottom: 0px solid #d8d8d8;width:10px;float:left;color:#0f6082;"></td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:85px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:175px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   	
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:30px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:75px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;">
                   		
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:75px;float:left;font-family:Arial;text-align:right; font-size: 10pt;"></td>
                 	<td style="width:15px;border-bottom: 1px solid #d8d8d8;float:left;"></td>
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
                    <td style="width:523px;float:left;font-family:Arial;text-align:left; font-weight:Bold;  font-size: 10pt;">Customer Notes
                    </td>
                    
                 </tr>
                <tr style="float:left;background-color:#FFFFFF;">
				<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:523px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">'.$quote['SlsQuotation']['notes'].' 
                    </td>
                 </tr></table>'; 
                 
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
                    <td style="width:270px;float:left;font-family:Arial;text-align:left; font-weight:Bold; color: #4E68A1; font-size:8pt;">
                   		Thank you for your business
                    </td>
                 </tr>
              <!--  <tr style="float:left;background-color:#FFFFFF;">
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
                 </tr> -->
                
                 </table>';    
       $terms ='<table>
       			<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:523px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">
                   		
                    </td>
                 </tr>
					<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:523px;float:left;font-family:Arial;text-align:left; font-weight:Bold;  font-size: 10pt;">Terms and Conditions 
                    </td>
                 </tr>
					<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:523px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">'.$quote['SlsQuotation']['term_conditions'].'
                   		 
                    </td>
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
	  <table  style="background-color: #f5f5f5;" cellpadding="0">
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