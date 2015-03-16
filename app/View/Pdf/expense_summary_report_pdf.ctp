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
  <td colspan="3" align="center" style="color:#666;font-size:8pt;font-family:Arial;font-weight:normal;">Prepared on '.$todayDate.'</td>
 </tr>
 <tr>
  <td colspan="3" align="center" style="color:#4F67A3;font-size:24px;font-family:Arial;font-weight:bold;">'.$organizationName.'</td>
 </tr>
 <tr>
  <td colspan="3" align="center" style="color:#333;font-size:18px;font-family:Arial;font-weight:normal;">Expense Summary Report</td>
 </tr>
 
</table>'; 
	  
	  
$tableHeader = '<table  border="0" cellpadding="10" cellspacing="0" width="100%">
<tr>
  <td colspan="1" align="left" style="color:#000;font-size:8pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-left: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;">Status</td>
  <td colspan="1" align="left" style="color:#000;font-size:8pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;border-right: 1px solid #d8d8d8;border-left: 1px solid #d8d8d8;">Expense Date</td>
  <td colspan="1" align="right" style="color:#000;font-size:8pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;border-right: 1px solid #d8d8d8;">Ref No</td>
  <td colspan="2" align="right" style="color:#000;font-size:8pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;border-right: 1px solid #d8d8d8;">Customer Name</td>
  <td colspan="1" align="right" style="color:#000;font-size:8pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;border-right: 1px solid #d8d8d8;">Category</td>
  <td colspan="1" align="right" style="color:#000;font-size:8pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;border-right: 1px solid #d8d8d8;">Expense Amount</td>
  <td colspan="1" align="right" style="color:#000;font-size:8pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;border-right: 1px solid #d8d8d8;">Tax Amount</td>
  <td colspan="1" align="right" style="color:#000;font-size:8pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;border-right: 1px solid #d8d8d8;">Expense Amount( Incl Tax)</td>
</tr>';   
	
	 foreach($report_details as $key=>$val){
	 	if($val){
	 	 
	 	$tableContent.='<tr>
  <td colspan="1" align="left" style="color:#000;font-size:7pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;border-left: 1px solid #d8d8d8;">'.$val['status'].'</td>
  <td colspan="1" align="left" style="color:#000;font-size:7pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.$val['expense_date'].'</td>
  <td colspan="1" align="right" style="color:#000;font-size:7pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.$val['ref_no'].'</td>
  <td colspan="2" align="right" style="color:#000;font-size:7pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.$val['customer_name'].'</td>
  <td colspan="1" align="right" style="color:#000;font-size:7pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.$val['category'].'</td>
  <td colspan="1" align="right" style="color:#000;font-size:7pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.$this->Number->format($val['expense_amount'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
  <td colspan="1" align="right" style="color:#000;font-size:7pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.$this->Number->format($val['tax_amount'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
  <td colspan="1" align="right" style="color:#000;font-size:7pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;border-right: 1px solid #d8d8d8;">'.$this->Number->format($val['expense_amount_incl_tax'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
 </tr>';
		    $finalTotal += $val['expense_amount_incl_tax'];      
		          }
		          
		   } 
		 $tableClose = '<tr>
  <td colspan="8" align="right" style="color:#000;font-size:7pt;font-family:Arial;font-weight:bold;">Total </td>
     <td colspan="1" align="right" style="color:#000;font-size:7pt;font-family:Arial;font-weight:bold;">'.$this->Number->format($finalTotal,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
 </tr>
 <tr>
  <td colspan="10" align="right" style="color:#000;font-size:6pt;font-family:Arial;">All amounts displayed in'.$subscriberCurrencyCode.'</td>
 </tr>
</table>';
                             
	
$html = <<<EOD
	  $custBalReportHeading
	  $tableHeader
	  $tableContent
	  $tableClose
EOD;
$tcpdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);  
$tcpdf->Output("Expense Summary Report_$toDate.pdf",'D');  

?>
