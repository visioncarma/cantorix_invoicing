<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php 
App::import('Vendor','xtcpdf'); 
  
$tcpdf = new XTCPDF();
$tcpdf->SetPrintHeader(false);
$options = array('zero'=>'0.00');
$tcpdf->AddPage(); 
$asonDate =  date($date_format,strtotime($toDate));	

	/********Table content beings here ************/
       
       $custBalReportHeading ='<table  border="0" cellpadding="2" cellspacing="2" width="100%">
				 <tr>
				  <td colspan="3" align="center" style="color:#4F67A3;font-size:18pt;font-family:Arial;font-weight:bold;">'.$sbsOrgName.'</td>
				 </tr>
				 <tr>
				  <td colspan="3" align="center" style="color:#333;font-size:13.5pt;font-family:Arial;font-weight:normal;">Sales Report</td>
				 </tr>
				 <tr>
				  <td colspan="3" align="center" style="color:#666;font-size:9pt;font-family:Arial;font-weight:normal;">As on '.$toDate.'</td>
				 </tr>
				</table>'; 
	  
	  $tableHeader = '<table  border="0" cellpadding="10" cellspacing="0" width="100%" style="border:1px solid #d8d8d8;">
						 <tr>
						  <td colspan="2" align="left" style="color:#333;font-size:9pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;">Customer Name</td>
						  <td colspan="1" align="right" style="color:#333;font-size:9pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;">No Invoices</td>
						  <td colspan="1" align="right" style="color:#333;font-size:9pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;">No Item Sold</td>
						  <td colspan="1" align="right" style="color:#333;font-size:9pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;">Sales</td>
						   <td colspan="1" align="right" style="color:#333;font-size:9pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;">Tax</td>
						    <td colspan="1" align="right" style="color:#333;font-size:9pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;">Total Sales</td>
						 </tr>';   
	
	 foreach($invoiceData as $key=>$value){
	 	if($value){         					 
	 	$tableContent.='<tr>
						<td colspan="2" align="left" style="color:#333;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.  $value['AcrClient']['organization_name'] .'</td>
						<td colspan="1" align="right" style="color:#333;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. $value['AcrClientInvoice']['count_id'] .'</td>
						<td colspan="1" align="right" style="color:#333;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. $value['AcrClientInvoice']['sold-items'] .'</td>
						<td colspan="1" align="right" style="color:#333;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. $this->Number->format($value['AcrClientInvoice']['sum_sub_total'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
						<td colspan="1" align="right" style="color:#333;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. $this->Number->format($value['AcrClientInvoice']['sum_tax_total'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
						<td colspan="1" align="right" style="color:#333;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. $this->Number->format($value['AcrClientInvoice']['sum_func_currency_total'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
					  </tr>';
					  $finalDetails['total-invoices'] = $finalDetails['total-invoices'] + $value['AcrClientInvoice']['count_id'];
					  $finalDetails['total-sold'] 	= $finalDetails['total-sold'] + $value['AcrClientInvoice']['sold-items'];
					  $finalDetails['total-sales'] 	= $finalDetails['total-sales'] + $value['AcrClientInvoice']['sum_sub_total'];
					  $finalDetails['total-taxes'] = $finalDetails['total-taxes'] + $value['AcrClientInvoice']['sum_tax_total'];
					  $finalDetails['total-total-sales'] = $finalDetails['total-total-sales'] + $value['AcrClientInvoice']['sum_func_currency_total'];
		          }
		   } 
		 $tableClose = '<tr>
		 <td colspan="2" align="left" style="color:#333;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8; font-weight:bold;">Total</td>
		 <td colspan="1" align="right" style="color:#333;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;font-weight:bold;">'.$finalDetails['total-invoices'].'</td>
		 <td colspan="1" align="right" style="color:#333;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;font-weight:bold;">'.$finalDetails['total-sold'].'</td>
		 <td colspan="1" align="right" style="color:#333;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;font-weight:bold;">'.$this->Number->format($finalDetails['total-sales'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
		 <td colspan="1" align="right" style="color:#333;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;font-weight:bold;">'.$this->Number->format($finalDetails['total-taxes'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
		 <td colspan="1" align="right" style="color:#333;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;font-weight:bold;">'.$this->Number->format($finalDetails['total-total-sales'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
		 </tr>
		 <tr>
  			<td colspan="7" align="right" style="color:#000;font-size:7.5pt;font-family:Arial;">All amounts displayed in<span style="color:#f00;">&nbsp;'.$subscriberCurrencyCode.'</span> </td>
 		</tr>
		 </table>';
                             
	
$html = <<<EOD
	  $custBalReportHeading
	  $tableHeader
	  $tableContent
	  $tableClose
EOD;
$tcpdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);  
$tcpdf->Output("Sale Report_$toDate.pdf",'D');  

?>
