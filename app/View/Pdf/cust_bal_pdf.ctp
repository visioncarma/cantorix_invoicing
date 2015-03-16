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
				  <td colspan="3" align="center" style="color:#333;font-size:13.5pt;font-family:Arial;font-weight:normal;">Customer Balance</td>
				 </tr>
				 <tr>
				  <td colspan="3" align="center" style="color:#666;font-size:9pt;font-family:Arial;font-weight:normal;">As on '.$asonDate.'</td>
				 </tr>
				</table>'; 
	  
	  $tableHeader = '<table  border="0" cellpadding="10" cellspacing="0" width="100%" style="border:1px solid #d8d8d8;">
						 <tr>
						  <td colspan="2" align="left" style="color:#333;font-size:9pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;">Customer Name</td>
						  <td colspan="1" align="right" style="color:#333;font-size:9pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;">Invoice Balance</td>
						  <td colspan="1" align="right" style="color:#333;font-size:9pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;">Credit Balance</td>
						  <td colspan="1" align="right" style="color:#333;font-size:9pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;">Balance</td>
						 </tr>';   
	
	 foreach($final_array as $key=>$value){         					 
	 	$tableContent.='<tr>
						<td colspan="2" align="left" style="color:#333;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.  $value['organizationName'] .'</td>
						<td colspan="1" align="right" style="color:#333;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. $this->Number->currency($value['invoiceBalance'],$value['custCrncyCode']) .'</td>
						<td colspan="1" align="right" style="color:#333;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. $this->Number->currency($value['creditBalance'],$value['custCrncyCode']) .'</td>
						<td colspan="1" align="right" style="color:#333;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. $this->Number->currency($value['balance'],$value['custCrncyCode']) .'</td>
					  </tr>';
		          } 
		 $tableClose = '</table>';
                             
	
$html = <<<EOD
	  $custBalReportHeading
	  $tableHeader
	  $tableContent
	  $tableClose
EOD;
$tcpdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);  
$tcpdf->Output("Customer Balance Report_$asonDate.pdf",'D');  

?>
