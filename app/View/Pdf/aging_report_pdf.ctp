<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php 
App::import('Vendor','xtcpdf'); 
  
$tcpdf = new XTCPDF();
$tcpdf->SetPrintHeader(false);
$options = array('zero'=>'0.00');
$tcpdf->AddPage(); 


	/********Table content beings here ************/
       
       $custBalReportHeading ='<table  border="0" cellpadding="2" cellspacing="2" width="100%">
<tr>
  <td colspan="3" align="center" style="color:#666;font-size:9pt;font-family:Arial;font-weight:normal;">Prepared on '.$todayDate.'</td>
 </tr>
 <tr>
  <td colspan="3" align="center" style="color:#4F67A3;font-size:18pt;font-family:Arial;font-weight:bold;">'.$organizationName.'</td>
 </tr>
 <tr>
  <td colspan="3" align="center" style="color:#333;font-size:13.5pt;font-family:Arial;font-weight:normal;">Account Aging Report</td>
 </tr>
 <tr>
  <td colspan="3" align="center" style="color:#666;font-size:9.5pt;font-family:Arial;font-weight:normal;">Till '.$toDate.'</td>
 </tr>
</table>'; 
	  foreach($bucketList as $bucketKey=>$bucketValue){
		$headerContent.='<td  align="right" style="color:#000;font-size:8.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;">'.$bucketValue.'</td>';
	}
	  $tableHeader = '<table  border="0" cellpadding="10" cellspacing="0" width="100%">
						 <tr>
  <td align="left" style="color:#000;font-size:8.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-left: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;">Customer Name</td>
  <td align="left" style="color:#000;font-size:8.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;">Last Payment Date</td>
  <td align="right" style="color:#000;font-size:8.25pt;;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;">Last Payment Amount</td>
  '.$headerContent.'
  <td align="right" style="color:#000;font-size:8.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;border-right: 1px solid #d8d8d8;">Total Due</td>
 </tr>';   
	
	 foreach($excelData as $key=>$val){
	 	if($val){
	 		if($val['lastPaymentDate']){
									 $paidOn = date($date_format,strtotime($val['lastPaymentDate']));
								  }else{
							 		$paidOn = "--";
								  } 
	 	$tableContent.='<tr>
  <td  align="left" style="color:#000;font-size:4.5pt;font-family:Arial;border-bottom: 0.75pt solid #d8d8d8;border-left: 1px solid #d8d8d8;">'.$val['organizationName'].'</td>
  <td  align="left" style="color:#000;font-size:4.5pt;font-family:Arial;border-bottom: 0.75px solid #d8d8d8;">'.$paidOn.'</td>
  <td  align="right" style="color:#000;font-size:4.5pt;font-family:Arial;border-bottom: 0.75pt solid #d8d8d8;">'.$this->Number->format($val['Paid'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
  <td  align="right" style="color:#000;font-size:4.5pt;font-family:Arial;border-bottom: 0.75pt solid #d8d8d8;">'.$this->Number->format($bucketAmount[$key]['1'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
  <td  align="right" style="color:#000;font-size:4.5pt;font-family:Arial;border-bottom: 0.75pt solid #d8d8d8;">'.$this->Number->format($bucketAmount[$key]['2'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
  <td  align="right" style="color:#000;font-size:4.5pt;font-family:Arial;border-bottom: 0.75pt solid #d8d8d8;">'.$this->Number->format($bucketAmount[$key]['3'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
  <td  align="right" style="color:#000;font-size:4.5pt;font-family:Arial;border-bottom: 0.75pt solid #d8d8d8;">'.$this->Number->format($bucketAmount[$key]['4'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
  <td  align="right" style="color:#000;font-size:4.5pt;font-family:Arial;border-bottom: 0.75pt solid #d8d8d8;border-right: 1px solid #d8d8d8;">'.$this->Number->format($val['rowTotal'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
 </tr>';
		          }
		   } 
		 $tableClose = '<tr>
  <td colspan="3" align="right" style="color:#000;font-size:4.5pt;font-family:Arial;font-weight:bold;">Total </td>
  <td  align="right" style="color:#000;font-size:4.5pt;font-family:Arial;font-weight:bold;">'.$this->Number->format($totalColumn['1'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
   <td  align="right" style="color:#000;font-size:4.5pt;font-family:Arial;font-weight:bold;">'.$this->Number->format($totalColumn['2'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
   <td  align="right" style="color:#000;font-size:4.5pt;font-family:Arial;font-weight:bold;">'.$this->Number->format($totalColumn['3'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
   <td  align="right" style="color:#000;font-size:4.5pt;font-family:Arial;font-weight:bold;">'.$this->Number->format($totalColumn['4'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
   <td  align="right" style="color:#000;font-size:4.5pt;font-family:Arial;font-weight:bold;">'.$this->Number->format(($totalColumn['1'] + $totalColumn['2'] + $totalColumn['3'] + $totalColumn['4']),array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
 </tr>
 <tr>
  <td colspan="10" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;">All amounts displayed in<span style="color:#f00;">&nbsp;'.$subscriberCurrencyCode.'</span> </td>
 </tr>
</table>';
                             
	
$html = <<<EOD
	  $custBalReportHeading
	  $tableHeader
	  $tableContent
	  $tableClose
EOD;
$tcpdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);  
$tcpdf->Output("Account Aging Report_$toDate.pdf",'D');  

?>
