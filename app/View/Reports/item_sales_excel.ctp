<?php
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */
 
  //declare the xls helper
  $xls= new xlsHelper();
 
  //input the export file name
  $xls->setHeader('Items Sale Report_'.date('Y_m_d'));
 
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Items Sale Report');
   
  //1st row for columns name
  $xls->openRow();
  $xls->writeString('Item Name');
  $xls->writeString('Item Description');
  $xls->writeString('# Items');
  $xls->writeString('Amount'); 
  $xls->writeString('Average Price'); 
  $xls->closeRow();
   
  //rows for data
  foreach($excelData as $value):
	  if($value):
    $xls->openRow();
    $xls->writeString($value['Inventory Name']);    
    $xls->writeString($value['Inventory Description']);    
    $xls->writeNumber($this->Number->format($value['# Item'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
	$xls->writeNumber($this->Number->format($value['Amount'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
	$xls->writeNumber($this->Number->format($value['Average Price'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
    $xls->closeRow();
	  endif;
  endforeach;
  $xls->openRow();
  $xls->writeString('Total');
  $xls->writeString('');
  $xls->writeNumber($this->Number->format($totalData['Total Sold Item'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
  $xls->writeNumber($this->Number->format($totalData['Total Amount'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
  $xls->writeNumber($this->Number->format($totalData['Total Average Price'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
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