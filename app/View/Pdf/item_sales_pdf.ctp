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
  <td colspan="3" align="center" style="color:#333;font-size:13.5pt;font-family:Arial;font-weight:normal;">Sales Analysis by Item</td>
 </tr>
 <tr>
  <td colspan="3" align="center" style="color:#666;font-size:9pt;font-family:Arial;font-weight:normal;">For the period '.$fromDate.' To '.$toDate.'</td>
 </tr>
</table>'; 
	  
	  $tableHeader = '<table  border="0" cellpadding="10" cellspacing="0" width="100%">
						 <tr>
  <td colspan="1" align="left" style="color:#000;font-size:8.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-left: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;">Item Name</td>
  <td colspan="3" align="left" style="color:#000;font-size:8.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;">Item Description</td>
  <td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;"># Item</td>
  <td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;">Amount</td>
   <td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;border-right: 1px solid #d8d8d8;">Average Price</td>
 </tr>';   
	
	 foreach($excelData as $key=>$value){
	 	if($value){         					 
	 	$tableContent.='<tr>
  <td colspan="1" align="left" style="color:#000;font-size:7.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;border-left: 1px solid #d8d8d8;">'.$value['Inventory Name'].'</td>
  <td colspan="3" align="left" style="color:#000;font-size:7.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.$value['Inventory Description'].'</td>
  <td colspan="1" align="right" style="color:#000;font-size:7.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.$this->Number->format($value['# Item'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
  <td colspan="1" align="right" style="color:#000;font-size:7.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.$this->Number->format($value['Amount'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
  <td colspan="1" align="right" style="color:#000;font-size:7.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;border-right: 1px solid #d8d8d8;">'.$this->Number->format($value['Average Price'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
 </tr>';
		          }
		   } 
		 $tableClose = '<tr>
  <td colspan="4" align="right" style="color:#000;font-size:7.5pt;font-family:Arial;font-weight:bold;">Total </td>
  <td colspan="1" align="right" style="color:#000;font-size:7.5pt;font-family:Arial;font-weight:bold;">'.$this->Number->format($totalData['Total Sold Item'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
   <td colspan="1" align="right" style="color:#000;font-size:7.5pt;font-family:Arial;font-weight:bold;">'.$this->Number->format($totalData['Total Amount'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
   <td colspan="1" align="right" style="color:#000;font-size:7.5pt;font-family:Arial;font-weight:bold;">'.$this->Number->format($totalData['Total Average Price'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
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
$tcpdf->Output("Items Sale Report_$toDate.pdf",'D');  

?>
