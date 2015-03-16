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
					<tr style="float:left;background-color:#FFFFFF;"><td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:387px;float:left;color:#0f6082;font-family:Arial;font-weight:Bold;text-align:left; font-size: 12pt;">
                   		<img src="'.$for_image.'" alt="test alt attribute" border="0" />'.$logoText.'
                   				
                    </td>
                    <td style="width:150;float:left;text-align:right;font-family: Arial;font-size:22.5pt; font-weight: normal;">
                    	'.nl2br("QUOTE\n").'<span style="font-family: Arial; font-size:10.5pt;">'.str_repeat("&nbsp;",5).'Quote #</span><span style="font-family: Arial;font-size:10.5pt;font-weight: bold;">  '.$quote['SlsQuotation']['quotation_no'].'</span>
                    </td>' .
                    '<td style="width:18px;float:left;"></td>
                 </tr>
                 </table>';  
				 
	$addresspart ='<table>
					<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:5px;float:left;color:#0f6082;"></td>
					<td style="width:380px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;"></td>
					<td style="width:132px;float:left;text-align:left;font-family: Arial;  font-size: 10pt;font-weight: bold;"></td><td style="width:18px;float:left;"></td>
                 	</tr>
					<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:5px;float:left;color:#0f6082;"></td>
					<td style="width:400px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">From:</td>
					<td style="width:132px;float:left;text-align:right;font-family: Arial;  font-size: 10pt;font-weight: bold;">Quote To:</td>
					<td style="width:18px;float:left;"></td>
					</tr>
					<tr style="float:left;background-color:#FFFFFF;">
					<td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:400px;float:left;font-family:Arial;font-weight:Bold;text-align:left;font-size: 15pt;">'.$organisationDetails['SbsSubscriberOrganizationDetail']['organization_name'].'</td>
                    <td style="width:132px;float:left;text-align:right;font-family: Arial;  font-size: 15pt; font-weight: bold;">'.$quote['AcrClient']['organization_name'].'</td>
                    <td style="width:18px;float:left;"></td>
                    </tr>
                    <tr style="float:left;background-color:#FFFFFF;">
                    <td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:400px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">'.$subscriberAddress.'</td>
                    <td style="width:132px;float:left;text-align:right;font-family: Arial; font-size: 10pt; ">'.$clientAddress.'</td>
                    <td style="width:18px;float:left;"></td>
                    </tr>
                    <tr style="float:left;background-color:#FFFFFF;">
                    <td style="width:5px;float:left;color:#0f6082;"></td>
                    <td style="width:380px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    <td style="width:132px;float:left;text-align:left;font-family: Arial; font-size: 10pt;"></td>
                    <td style="width:18px;float:left;"></td>
                    </tr>
                    </table>';              
	
	$datepart ='<table>
					<tr style="float:left;background-color:#FFFFFF;">
						
	                    <td style="width:150px;float:left;color:#0f6082;"></td>
	                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
	                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
	                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
	                    <td style="width:23px;float:left;"></td>
                    </tr>
					<tr style="float:left;background-color:#FFFFFF;">
						
						<td style="width:150px;float:left;color:#0f6082;"></td>
                    	<td style="border-bottom: 1px solid #d8d8d8;width:100px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Issue Date</td>
                    	<td style="border-bottom: 1px solid #d8d8d8;width:100px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">Expiry Date</td> 	
                    	<td style="border-bottom: 1px solid #d8d8d8;width:50px;float:left;font-family:Arial;font-weight:Bold;text-align:left; font-size: 10pt;">'.str_repeat("&nbsp;",2).'PO #</td>
                    	<td style="width:23px;float:left;"></td>
                    </tr>
                 
                 
                 <tr style="float:left;background-color:#FFFFFF;">
                 	
                    <td style="width:150px;float:left;color:#0f6082;"></td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 8pt;">'.date($settings['SbsSubscriberSetting']['date_format'],strtotime($quote['SlsQuotation']['issue_date'])).'
                    </td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 8pt;">'.$expiryDate.'
                    </td>
                    <td style="width:50px;float:left;font-family:Arial;text-align:left; font-size: 8pt;">'.$quote['SlsQuotation']['purchase_order_no'].'
                    </td>
                    <td style="width:23px;float:left;"></td>
                 </tr>
                 <tr style="float:left;background-color:#FFFFFF;">
                 	
                    <td style="width:150px;float:left;color:#0f6082;"></td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 8pt;"></td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 8pt;"></td>
                    <td style="width:100px;float:left;font-family:Arial;text-align:left; font-size: 8pt;"></td>
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
				<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:100px;font-family:Arial; font-size: 8pt;">'.$v['InvInventory']['name'].'</td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:175px;font-family:Arial; font-size: 8pt;text-align:left;">'.$v['SlsQuotationProduct']['inventory_description'].'
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:30px;font-family:Arial; font-size: 8pt;text-align:right;">'.$v['SlsQuotationProduct']['quantity'].'
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:75px;font-family:Arial;font-size: 8pt;text-align:right;">
                   		'.$this->Number->currency(($v['SlsQuotationProduct']['unit_rate']/$quote['SlsQuotation']['exchange_rate']),'').'
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:75px;font-family:Arial; font-size: 8pt;text-align:right;">
                   		'.$discount.'
                    </td>
                    <td style="border-bottom: 1px solid #d8d8d8;width:75px;font-family:Arial; font-size: 8pt;text-align:right;padding-right:10px;">'.$this->Number->currency(($v['SlsQuotationProduct']['line_total']/$quote['SlsQuotation']['exchange_rate']),'').'</td>
                 </tr>';
	}          
        
	$payements=null;
	// Use for Payements
	$payements.='<tr>
        <td width="10" style="background-color:#FFFFFF"></td>
        
        <td width="100%">
			<table border="0">
			<tr><td align="right" width="77%" style="font-size:8pt;font-weight:Bold;font-family:Arial;">SubTotal</td>
			<td align="right" width="23%" style="font-size:8pt;font-weight:bold;font-family:Arial;">'.$this->Number->currency(($quote['SlsQuotation']['sub_total']/$quote['SlsQuotation']['exchange_rate']),$quote['SlsQuotation']['invoice_currency_code']).'&nbsp;&nbsp;</td></tr>
			</table>
        </td>
	</tr>';
		
		/*$payements.='
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
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-weight:Bold;font-size: 10pt;">'.$this->Number->currency(($quote['SlsQuotation']['sub_total']/$quote['SlsQuotation']['exchange_rate']),$quote['SlsQuotation']['invoice_currency_code']).'</td>
                 </tr>';*/
                 
                 
                 
     foreach($taxCalcuations as $key=>$val){
     		
    				$payements.='<tr>
			            <td width="10" bgcolor="white"></td>
			            
			            <td width="100%">
							<table border="0">
							<tr><td align="right" width="77%" style="font-size:8pt;font-family:Arial;">'.$val['taxName'].'</td>
							    <td align="right" width="23%" style="font-size:8pt;font-family:Arial;">'.$this->Number->currency(($val['taxAmount']/$quote['SlsQuotation']['exchange_rate']),$quote['SlsQuotation']['invoice_currency_code']).'&nbsp;&nbsp;</td>
							</tr>
							</table>
			            </td>
					</tr>';
					 	            
	/*$payements.='<tr style="float:left;background-color:#FFFFFF;">
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
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-size: 8pt;">'.$this->Number->currency(($val['taxAmount']/$quote['SlsQuotation']['exchange_rate']),$quote['SlsQuotation']['invoice_currency_code']).'</td>
                 </tr>';*/
     }          
      
      $payements.='
		<tr>
            <td width="10" bgcolor="white"></td>
            
            <td width="100%">
				<table border="0">
				<tr>
				<td align="right" width="77%" style="font-size:8pt;font-weight:Bold;font-family:Arial;">Total</td>
				<td align="right" width="23%" style="font-size:8pt;font-weight:Bold;font-family:Arial;">'.$this->Number->currency($quote['SlsQuotation']['invoice_amount'],$quote['SlsQuotation']['invoice_currency_code']).'&nbsp;&nbsp;</td>
				</tr>
				</table>
            </td>
		</tr>';	
		
		
      /*$payements.='
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
                    <td style="width:75px;float:left;font-family:Arial;text-align:right;font-weight:Bold; font-size: 8pt;">
                   		Total
                    </td>
                    <td style="width:75px;float:left;font-family:Arial;text-align:right; font-weight:Bold;font-size: 8pt;">'.$this->Number->currency($quote['SlsQuotation']['invoice_amount'],$quote['SlsQuotation']['invoice_currency_code']).'</td>
                 </tr>
                 
               <!--  <tr style="float:left;background-color:#FFFFFF;">
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
                 </tr>-->
                 '; */
                 
                 
	
	// Section for popularised
	$popularised ='<table>
				<!--<tr style="float:left;background-color:#FFFFFF;">
				<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:523px;float:left;font-family:Arial;text-align:left; font-size: 10pt;"></td>
                    
                 </tr> -->
                <tr style="float:left;background-color:#FFFFFF;">
				<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:420px;float:left;font-family:Arial;text-align:left; font-weight:Bold;  font-size: 10pt;">Customer Notes
                    </td>
                    
                 </tr>
                <tr style="float:left;background-color:#FFFFFF;">
				<td style="width:10px;float:left;color:#0f6082;"></td>
                    <td style="width:523px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">'.$quote['SlsQuotation']['notes'].'</td>
                    
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
                    <td style="width:270px;float:left;font-family:Arial;text-align:left; font-weight:Bold; font-size: 8pt;">
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
                    <td style="width:420px;float:left;font-family:Arial;text-align:left; font-size: 10pt;">'.$quote['SlsQuotation']['term_conditions'].'</td>
                 </tr>
                
                 
                
                 </table>';                        
	
$html = <<<EOD
	$heading_part
	$addresspart
	$datepart
	<table  cellpadding="0">
		
	  <tr>
	    <th style="width:10px;font-family:Arial;font-weight:Bold; font-size:10pt;"></th>
	    <th style="width:100px;border-bottom: 1px solid #d8d8d8;font-family:Arial;font-weight:Bold; font-size: 10pt;">Item</th>
	    <th style="width:175px;border-bottom: 1px solid #d8d8d8;font-family:Arial;font-weight:Bold;font-size:10pt; text-align:left;">Description</th>
	    <th style="width:30px;border-bottom: 1px solid #d8d8d8;font-family:Arial;font-weight:Bold; font-size:10pt;text-align:right;">Qty</th>
	    <th style="width:75px;border-bottom: 1px solid #d8d8d8;font-family:Arial;font-weight:Bold; font-size:10pt;text-align:right;">Unit Price</th>
	    <th style="width:75px;border-bottom: 1px solid #d8d8d8;font-family:Arial;font-weight:Bold; font-size:10pt;text-align:right;">Disc %</th>
	    <th style="width:75px;border-bottom: 1px solid #d8d8d8;padding-right:15px;font-family:Arial;font-weight:Bold;font-size:10pt;text-align:right;padding-right:10px;">Amount</th>
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
