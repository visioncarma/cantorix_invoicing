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
  $xls->writeString('Customer Name');
  $xls->writeString('Last Payment Date');
  $xls->writeString('Last Payment Amount');
  foreach($bucketList as $bucketId=>$bucketValue):
  $xls->writeString($bucketValue); 
  endforeach;
  $xls->writeString('Total'); 
  $xls->closeRow();
   
  //rows for data
  foreach($excelData as $value):
	  if($value):
    $xls->openRow();
    $xls->writeString($value['organizationName']);    
	if($value['lastPaymentDate']){
		$xls->writeString(date($dateFormat,strtotime($value['lastPaymentDate'])));
	}else{
		$xls->writeString();
	}
    $xls->writeNumber($this->Number->format($value['Paid'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
	foreach($bucketList as $bucketId1=>$bucketValue1):
	$xls->writeNumber($this->Number->format($value[$bucketValue1],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
	$column[$bucketId1] += $value[$bucketValue1];
	endforeach;
	$xls->writeNumber($this->Number->format($value['rowTotal'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
    $xls->closeRow();
	  endif;
  endforeach;
  $xls->openRow();
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('Total');
  foreach($bucketList as $bucketId=>$bucketValue):
  $xls->writeNumber($this->Number->format($column[$bucketId],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
  $totalValue += $column[$bucketId];
  endforeach;
  $xls->writeNumber($this->Number->format($totalValue,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
  $xls->closeRow();
  $xls->addXmlFooter();
  exit();
?>