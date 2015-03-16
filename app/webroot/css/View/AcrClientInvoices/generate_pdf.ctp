<?php
App::import('Vendor','xtcpdf'); 
$tcpdf = new XTCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
//$textfont = 'dejavusans'; // looks better, finer, and more condensed than 'dejavusans' 
$tcpdf->AddPage();
$tcpdf->SetFont( '', 'b',8 );
$tcpdf->setY(45);
$tcpdf->SetTextColor(13,73,97); 



$tcpdf->Cell(60, 3, 'INVOICE', 0, false, 'L', 0, '', 0, false, 'M', 'M');
$tcpdf->SetTextColor(0,0,0);
$tcpdf->Cell(60, 3, 'INVOICE#', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$tcpdf->Cell(60, 3, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$tcpdf->Ln();
$tcpdf->SetTextColor(0,0,0);
$tcpdf->Cell(60, 3, $customerInfo['AcrClient']['client_name'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
$tcpdf->SetTextColor(13,73,97);
$tcpdf->Cell(60, 3, $invoiceDetail['AcrClientInvoice']['id'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
$tcpdf->Cell(60, 3, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$tcpdf->Ln();
$tcpdf->Ln();
$tcpdf->Cell(60, 3, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
$tcpdf->SetTextColor(0,0,0);
$tcpdf->Cell(60, 3, 'INVOICE DATE', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$tcpdf->Cell(60, 3, 'Bill To:', 0, false, 'R', 0, '', 0, false, 'M', 'M');
$clientAddress;
$tcpdf->Ln();
$tcpdf->Ln();
$tcpdf->Cell(60, 3, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
$tcpdf->SetTextColor(13,73,97);
$tcpdf->Cell(60, 3, $invoiceDetail['AcrClientInvoice']['invoiced_date'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
$tcpdf->Cell(60, 3, $customerInfo['AcrClient']['organization_name'], 0, false, 'R', 0, '', 0, false, 'M', 'M');
$tcpdf->Ln();
$tcpdf->Ln();
$tcpdf->Cell(60, 3, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
$tcpdf->SetTextColor(0,0,0);
$tcpdf->Cell(60, 3, 'TERMS', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$tcpdf->Cell(60, 3, $invoiceDetail['AcrClientInvoice']['notes'], 0, false, 'R', 0, '', 0, false, 'M', 'M');
$tcpdf->Ln();
$tcpdf->Ln();
$tcpdf->Cell(60, 3, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
$tcpdf->SetTextColor(13,73,97);
$tcpdf->Cell(60, 3, $invoiceDetail['SbsSubscriberPaymentTerm']['term'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
$tcpdf->Ln();
$tcpdf->Ln();
$tcpdf->Cell(60, 3, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
$tcpdf->SetTextColor(0,0,0);
$tcpdf->Cell(60, 3, 'DUE DATE', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$tcpdf->Ln();
$tcpdf->Ln();
$tcpdf->Cell(60, 3, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
$tcpdf->SetTextColor(13,73,97);
$tcpdf->Cell(60, 3, $invoiceDetail['AcrClientInvoice']['due_date'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
$tcpdf->Ln();
$tcpdf->Ln();
$col = 20; // Column size
	$itemcol=3*$col;
	$wideCol = 2*$col;  // Description Column
	 
	$line = 3;  // Line height
	 
	// Table header
	 
	$tcpdf->SetFont( '', 'b',8 );
	$tcpdf->SetTextColor(255,255,255);
	$tcpdf->SetFillColor(13,73,97,'',false,''); 
	$tcpdf->Cell( $col, $line, 'Regno', 1, 0, 'L',1 );
	$tcpdf->Cell( $itemcol, $line, 'Item', 1, 0, 'L',1 );
	//$tcpdf->Cell( $wideCol, $line, 'Description', 1, 0, 'L',1 );
	$tcpdf->Cell( $col, $line, 'Qty', 1, 0, 'L',1 );
	$tcpdf->Cell( $col, $line, 'Rate', 1, 0, 'L',1 );
 	$tcpdf->Cell( $col, $line, 'Discount(%)', 1, 0, 'L',1 );
	$tcpdf->Cell( $wideCol, $line, 'Amount', 1, 0, 'L',1 );
	 
	$tcpdf->Ln(); // Adds Line break
	 
	// Table content beings here
	$tcpdf->SetTextColor(0,0,0);
	$tcpdf->SetFont( '', '',8);  // two parameters accept font-family and style. Passing blank sets default values
	 $i=1;
	foreach($invoiceDetail as $k=>$v)
	{
		$tcpdf->Cell( $col, $line, $i, 1, 0, 'L' );
		$tcpdf->Cell( $itemcol, $line, $v['InvInventory']['name'], 1, 0, 'L' );
		//$tcpdf->Cell( $wideCol, $line, $v['description'], 1, 0, 'L' );
		$tcpdf->Cell( $col, $line, $v['AcrInvoiceDetail']['quantity'], 1, 0, 'L' );
		$tcpdf->Cell( $col, $line, $symbol.' '.money_format('%!(.0n',$v['AcrInvoiceDetail']['unit_rate']), 1, 0, 'L' );
 		$tcpdf->Cell( $col, $line, $v['AcrInvoiceDetail']['discount_percent'], 1, 0, 'L' );
		$tcpdf->Cell( $wideCol, $line,$symbol.' '.money_format('%!(.0n',$v['AcrInvoiceDetail']['line_total']), 1, 0, 'L' );
	 
		$tcpdf->Ln(); // Adds Line break
		//$tcpdf->Ln();
		$i++;
	}
 $tcpdf->Ln(); 
 $tcpdf->Ln(); 
 $tcpdf->Ln(); 
 $tcpdf->SetFillColor(13,73,97,'',false,''); 
 $tcpdf->Cell(0,8, '','T',1,'C'); 
 $tcpdf->SetTextColor(13,73,97); 
 $tcpdf->Cell(150, 3, 'Sub Total   :', 0, false, 'R', 0, '', 0, false, 'M', 'M');
 $tcpdf->SetTextColor(0,0,0);
 $tcpdf->Cell(60, 3, $symbol.' '.money_format('%!(.0n',$invoiceDetail['AcrClientInvoice']['sub_total']), 0, false, 'C', 0, '', 0, false, 'M', 'M');
 $tcpdf->Ln();
 $tcpdf->SetTextColor(13,73,97); 
 $tcpdf->Cell(150, 3, 'Tax         :', 0, false, 'R', 0, '', 0, false, 'M', 'M');
 $tcpdf->SetTextColor(0,0,0);
 $tcpdf->Cell(60, 3, $symbol.' '.money_format('%!(.0n',$download_tax), 0, false, 'C', 0, '', 0, false, 'M', 'M');
  $tcpdf->Ln();
 $tcpdf->SetTextColor(13,73,97); 
 $tcpdf->Cell(150, 3, 'Unused Credit       :', 0, false, 'R', 0, '', 0, false, 'M', 'M');
 $tcpdf->SetTextColor(0,0,0);
 $tcpdf->Cell(60, 3, '(-)'.$symbol.' '.money_format('%!(.0n',$relaxation), 0, false, 'C', 0, '', 0, false, 'M', 'M');
 $tcpdf->Ln();
 $tcpdf->SetTextColor(13,73,97); 
 $tcpdf->Cell(150, 3, 'Total       :', 0, false, 'R', 0, '', 0, false, 'M', 'M');
 $tcpdf->SetTextColor(0,0,0);
 $tcpdf->Cell(60, 3, $symbol.' '.money_format('%!(.0n',$download_invoicedamount), 0, false, 'C', 0, '', 0, false, 'M', 'M');
 $tcpdf->Ln();
 $tcpdf->SetTextColor(13,73,97); 
 $tcpdf->Cell(150, 3, 'Payment Made:', 0, false, 'R', 0, '', 0, false, 'M', 'M');
 $tcpdf->SetTextColor(0,0,0);
 $tcpdf->Cell(60, 3, $symbol.' '.money_format('%!(.0n',$download_pay), 0, false, 'C', 0, '', 0, false, 'M', 'M');
 $tcpdf->Ln();
 $tcpdf->SetTextColor(13,73,97); 
 $tcpdf->Cell(150, 3, 'Balance Due :', 0, false, 'R', 0, '', 0, false, 'M', 'M');
 $tcpdf->SetTextColor(0,0,0);
 $tcpdf->Cell(60, 3,  $symbol.' '.money_format('%!(.0n',$download_due), 0, false, 'C', 0, '', 0, false, 'M', 'M');
 $tcpdf->Ln();
 $tcpdf->Ln();
 $tcpdf->SetFont( '', 'b',8 );
 $tcpdf->Cell(60, 3, 'Bank Information For Wire Transfer', 0, false, 'L', 0, '', 0, false, 'M', 'M');
 $tcpdf->Ln();
 $tcpdf->SetFont( '', '',8 );
 $tcpdf->Cell(60, 3, 'Bank Name: HDFC Bank Ltd', 0, false, 'L', 0, '', 0, false, 'M', 'M');
 $tcpdf->Ln();
 $tcpdf->SetTextColor(0,0,0);
 $tcpdf->Cell(60, 3, 'Bank Street Address: #9, Etema, Koramangala Industrial layout, Koramangala, Bangalore-560095, India', 0, false, 'L', 0, '', 0, false, 'M', 'M');
 $tcpdf->Ln();
 $tcpdf->Cell(60, 3, 'Branch Code: 0053', 0, false, 'L', 0, '', 0, false, 'M', 'M');
 $tcpdf->Ln();
 $tcpdf->Cell(60, 3, 'Branch State/Provience: Karnataka', 0, false, 'L', 0, '', 0, false, 'M', 'M');
 $tcpdf->Ln();
 $tcpdf->Cell(60, 3, 'Branch Country: India', 0, false, 'L', 0, '', 0, false, 'M', 'M');
 $tcpdf->Ln();
 $tcpdf->Cell(60, 3, 'HDFC Bank SWIFT Code: HDFCINBBBNG', 0, false, 'L', 0, '', 0, false, 'M', 'M');
 $tcpdf->Ln();
 $tcpdf->Cell(60, 3, 'Account Number: 005320000007356', 0, false, 'L', 0, '', 0, false, 'M', 'M');
 $tcpdf->Ln();
 $tcpdf->Cell(60, 3, 'Account Holder Name: Carmatec IT Solutions Pvt Ltd', 0, false, 'L', 0, '', 0, false, 'M', 'M');
 $tcpdf->Ln();
 $tcpdf->Cell(60, 3, 'IFSC: HDFC00000053', 0, false, 'L', 0, '', 0, false, 'M', 'M');
 $tcpdf->Ln();
 $tcpdf->Ln();
 $tcpdf->Cell(60, 3, 'Thank you very much for your business!', 0, false, 'L', 0, '', 0, false, 'M', 'M');
 $tcpdf->Ln();
/* $tmp = $_SERVER['DOCUMENT_ROOT']."accounts/app/webroot/files/uploads/invoice/";*/

$tmp = $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/files/uploads/invoice/";
if(!is_dir($folder_url)) {
	mkdir($tmp);
}
$download_invoice_id = $invoiceDetail['AcrClientInvoice']['id'];
debug($download_invoice_id);
debug($invoiceDetail['AcrClientInvoice']['id']);
$tcpdf->Output($tmp."$download_invoice_id.pdf", 'F');  





?>