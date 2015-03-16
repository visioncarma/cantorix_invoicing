<?php
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */
 
  //declare the xls helper
  $xls= new xlsHelper();
 
  //input the export file name
  $xls->setHeader('Sales Report_'.date('Y_m_d'));
 
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Sales Report');
   
  //1st row for columns name
  $xls->openRow();
  $xls->writeString('Customer Name');
  $xls->writeString('No Invoices');
  $xls->writeString('No Item Sold');
  $xls->writeString('Sales'); 
  $xls->writeString('Tax'); 
  $xls->writeString('Total Sales'); 
  $xls->closeRow();
   
  //rows for data
  foreach($invoiceData as $value):
	  if($value):
    $xls->openRow();
    $xls->writeString($value['AcrClient']['organization_name']);    
    $xls->writeNumber($value['AcrClientInvoice']['count_id']);    
    $xls->writeNumber($value['AcrClientInvoice']['sold-items']);
	$xls->writeNumber($this->Number->format($value['AcrClientInvoice']['sum_sub_total'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
	$xls->writeNumber($this->Number->format($value['AcrClientInvoice']['sum_tax_total'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
	$xls->writeNumber($this->Number->format($value['AcrClientInvoice']['sum_func_currency_total'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));   
    $xls->closeRow();
	$invoiceCountTotal 		+=	$value['AcrClientInvoice']['count_id'];
	$soldItemsTotal 		+=	$value['AcrClientInvoice']['sold-items'];
	$sumSubTotal 			+=  $value['AcrClientInvoice']['sum_sub_total'];
	$sumTaxtTotal 			+=	$value['AcrClientInvoice']['sum_tax_total'];
	$sumFunctionalCurrency  +=	$value['AcrClientInvoice']['sum_func_currency_total'];
	  endif;
  endforeach;
   $xls->openRow();
   $xls->writeString('Total');
   $xls->writeNumber($invoiceCountTotal);  
   $xls->writeNumber($soldItemsTotal); 
   $xls->writeNumber($sumSubTotal); 
   $xls->writeNumber($sumTaxtTotal); 
   $xls->writeNumber($sumFunctionalCurrency); 
   $xls->closeRow();
   $xls->openRow();
  $xls->closeRow();
  $xls->openRow();
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('All Amounts Displayed in '.$subscriberCurrencyCode);
  $xls->closeRow();
  $xls->addXmlFooter();
  exit();
?>