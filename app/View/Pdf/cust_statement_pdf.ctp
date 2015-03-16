<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php 
App::import('Vendor','xtcpdf'); 
  
$tcpdf = new XTCPDF();
$tcpdf->SetPrintHeader(false);
$tcpdf->AddPage(); 

$options = array('zero'=>'0.00');
$total_amount			=	$final['totalAmount'];
$date_format			=	$final['date_format'];
$subscriberCurrencyCode	=	$final['subscriberCurrencyCode'];
$customerCurrencyCode	=	$final['custCrncyCode'];
$orgname				=	$final['orgname'];
$init_bal_due           =   $final['init_bal_due'];	
$initial_balance_due 	= 	$init_bal_due;
$toDate   =  date($date_format,strtotime($toDate));	
$fromDate =  date($date_format,strtotime($fromDate));
$tdydate  =  date($date_format);

$prev_date = date($date_format, strtotime($fromDate .' -1 day'));	

/********Table content beings here ************/

$custstmtReportHeading = '<table  border="0" cellpadding="2" cellspacing="2" width="100%">
	<tr>
		<td colspan="3" align="center" style="color:#666;font-size:8pt;font-family:Arial;font-weight:normal;">Prepared on '.$tdydate.'</td>
	</tr>
	<tr>
		<td colspan="3" align="center" style="color:#4F67A3;font-size:17pt;font-family:Arial;font-weight:bold;">'.$orgname.'</td>
	</tr>
	<tr>
		<td colspan="3" align="center" style="color:#333;font-size:12.5pt;font-family:Arial;font-weight:normal;">Customer Statements</td>
	</tr>
	<tr>
		<td colspan="3" align="center" style="color:#666;font-size:8pt;font-family:Arial;font-weight:normal;">Invoice, Payment and Credit for the period '.$fromDate.' To '.$toDate.'</td>
	</tr>
</table>';

$tableHeader = '<table  border="0" cellpadding="5" cellspacing="0" width="100%">
	<tr>
		<td  align="left" style="width:80px;color:#000;font-size:7.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-left: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;">Date</td>
		<td  align="left" style="width:80px;color:#000;font-size:7.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;">Document Type</td>
		<td  align="left" style="width:80px;color:#000;font-size:7.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;">Document No</td>
		<td  align="left" style="width:120px;color:#000;font-size:7.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;">Description</td>
		<td  align="right" style="width:86px;color:#000;font-size:7.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;">Amount</td>
		<td  align="right" style="width:87px;color:#000;font-size:7.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;border-right: 1px solid #d8d8d8;">Balance Due</td>
	</tr>';

foreach($final as $key1=>$value1) { 
	foreach($value1 as $key=>$value) {

		if($value['doc_type'] == 'Payment' || $value['doc_type'] == 'Credit') {
			$bal_due   = $initial_balance_due - $value['amount'];
			$initial_balance_due = $bal_due;
			$sign = '-';
			$colr = '#587322';						
		} 
		if($value['doc_type'] == 'Invoice') {
			$bal_due   = $initial_balance_due + $value['amount'];
			$initial_balance_due = $bal_due;
			$sign = '';
			$colr = '#000';
		}
		if($value['doc_type'] == 'Payment') {
			$ref = 'Ref';			
		} else {
			$ref = '';
		}			
		$tableContent.=	'<tr>
				<td  align="left" style="width:80px;color:#000;font-size:6.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;border-left: 1px solid #d8d8d8;">'.  date($date_format,strtotime($key1)) .'</td>
				<td  align="left" style="width:80px;color:#000;font-size:6.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'. $value['doc_type'] .'</td>
				<td  align="left" style="width:80px;color:#000;font-size:6.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.  $value['doc_no'] .'</td>
				<td  align="left" style="width:120px;color:#000;font-size:6.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.  $value['doc_type'].' '.$ref.' No: '.$value['doc_no'].', '. $orgname .'</td>
				<td  align="right" style="width:86px;color:'.$colr.';font-size:6.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.  $sign.$this->Number->currency($value['amount'],'',$options) .'</td>
				<td  align="right" style="width:87px;color:#000;font-size:6.5pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;border-right: 1px solid #d8d8d8;">'. $this->Number->currency($bal_due,'',$options) .'</td>
			</tr>';
			}
		}
	
$intBalDue ='<table  border="0" cellpadding="5" cellspacing="0" width="100%">
				<tr>
					<td colspan="6" align="right" style="color:#000;font-size:6.5pt;font-family:Arial;font-weight:bold;">Initial balance due (As of '.$prev_date.')</td>
					<td colspan="1" align="right" style="color:#000;font-size:6.5pt;font-family:Arial;font-weight:bold;">'.$this->Number->currency($init_bal_due,'',$options).'</td>
				</tr>
				
			</table>';

$total ='<tr>
		<td colspan="5" align="right" style="color:#000;font-size:6.5pt;font-family:Arial;font-weight:bold;">Total </td>
		<td colspan="1" align="right" style="color:#000;font-size:6.5pt;font-family:Arial;font-weight:bold;">'.$this->Number->currency($total_amount,'',$options).'</td>
		<td colspan="1" align="right" style="color:#000;font-size:6.5pt;font-family:Arial;font-weight:bold;"></td>
	</tr>';
	
$curncy ='<tr>
		<td colspan="7" align="right" style="color:#000;font-size:6.5pt;font-family:Arial;">All amounts displayed in<span style="color:#f00;">&nbsp;'. $customerCurrencyCode .'</span></td>
	</tr>';
	
$tableClose = '</table>';

$html = <<<EOD
	  
	  $custstmtReportHeading
	  $intBalDue
	  $tableHeader
	  $tableContent	  
	  $total
	  $curncy
	  $tableClose
EOD;
$tcpdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);  
$tcpdf->Output("Customer Statement Report_$tdydate.pdf",'D'); 

?>

