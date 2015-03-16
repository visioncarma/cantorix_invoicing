<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php 
App::import('Vendor','xtcpdf'); 
  
$tcpdf = new XTCPDF();
$tcpdf->SetPrintHeader(false);
$options = array('zero'=>'0.00');
$tcpdf->AddPage(); 
$currentDate=date('Y-m-d');

	/********Table content beings here ************/
       
       $taxReportHeading ='<table  border="0" cellpadding="2" cellspacing="2" width="100%">
				 <tr>
				  <td colspan="3" align="center" style="color:#333;font-size:13.5pt;font-family:Arial;">Prepared on '.date($dateFormat,strtotime(date('Y-m-d'))).'</td>
				 </tr>
				 <tr>
				  <td colspan="3" align="center" style="color:#4F67A3;font-size:18pt;font-family:Arial;font-weight:bold;">'.$subscriber_organization.'</td>
				 </tr>
				 <tr>
				  <td colspan="3" align="center" style="color:#666;font-size:15pt;font-family:Arial;font-weight:normal;">Tax Summary Report</td>
				 </tr>
				 <tr>
				  <td colspan="3" align="center" style="color:#666;font-size:12pt;font-family:Arial;font-weight:normal;">For the Period '.' '.date($dateFormat,strtotime($from_date)).' to '. date($dateFormat,strtotime($to_date)).'</td>
				 </tr>
				</table>'; 
	  
	  $tableHeader = '<table  border="0" cellpadding="10" cellspacing="0" width="100%" style="border:1px solid #d8d8d8;">
						 <tr>
						  <td colspan="1" align="left" style="color:#333;font-size:12pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;">Group Type</td>
						  <td colspan="1" align="right" style="color:#333;font-size:12pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;">Tax Code</td>
						  <td colspan="1" align="right" style="color:#333;font-size:12pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;">Tax Name</td>
						  <td colspan="1" align="right" style="color:#333;font-size:12pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;">Tax Percentage</td>
						  <td colspan="1" align="right" style="color:#333;font-size:12pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;">Tax Amount</td>
						 </tr>';   
	 
	 $i=0;
	 foreach($final as $key=>$value){ $i++;
	 	 $l=0; foreach($value as $key1=>$value1){ $l++;
	 	  	   
				if($l == '1'){
					$tableContent.='<tr>
								<td colspan="1" align="left" style="color:#333;font-size:10.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.  $key .'</td>
								<td colspan="1" align="right" style="color:#333;font-size:10.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. $value1['code'] .'</td>
								<td colspan="1" align="right" style="color:#333;font-size:10.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. $value1['name'] .'</td>
								<td colspan="1" align="right" style="color:#333;font-size:10.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. $value1['percent'].'%' .'</td>
								<td colspan="1" align="right" style="color:#333;font-size:10.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. round($value1['amount'],2) .'</td>
							  </tr>';
				}else{
					$tableContent.='<tr>
								<td colspan="1" align="left" style="color:#333;font-size:10.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.  '' .'</td>
								<td colspan="1" align="right" style="color:#333;font-size:10.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. $value1['code'] .'</td>
								<td colspan="1" align="right" style="color:#333;font-size:10.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. $value1['name'] .'</td>
								<td colspan="1" align="right" style="color:#333;font-size:10.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. $value1['percent'].'%' .'</td>
								<td colspan="1" align="right" style="color:#333;font-size:10.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. round($value1['amount'],2) .'</td>
							  </tr>';
				}
				 $total = $value1['amount'];
                 $total_amount = $total + $total_amount;   				
				 
		  } 
          $tableContent.='<tr>
								<td colspan="1" align="left" style="color:#333;font-size:10.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.  '' .'</td>
								<td colspan="1" align="right" style="color:#333;font-size:10.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. '' .'</td>
								<td colspan="1" align="right" style="color:#333;font-size:10.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. '' .'</td>
								<td colspan="1" align="right" style="color:#333;font-size:10.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;font-weight:bold;">'. 'Total' .'</td>
								<td colspan="1" align="right" style="color:#333;font-size:10.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;font-weight:bold;">'. round($total_amount,2) .'</td>
		  </tr>';

          $total=$total_amount=null;
	 }
     $tableClose = '</table>';
	 
	 $lastrow ='<table>
				 <tr>
				   <td colspan="3" align="right" style="color:#333;font-size:10.5pt;font-family:Arial;">All amounts are displayed in <span style="color:red;">'.$subscriberCurrencyCode['CpnCurrency']['code'].'</span>.</td>
				 </tr>
				</table>'; 
                        
	
$html = <<<EOD
	  $taxReportHeading
	  $tableHeader
	  $tableContent
	  $tableClose
	  $lastrow
EOD;
$tcpdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);  
$tcpdf->Output("Tax Summary Report_$currentDate.pdf",'D');  

?>
