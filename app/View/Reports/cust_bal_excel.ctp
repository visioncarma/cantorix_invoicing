<?php
$this->CurrencySymbol->getAllCurrencies();
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */
 
  //declare the xls helper
  $xls= new xlsHelper();
  $asonDate =  date($date_format,strtotime($toDate));	
  //input the export file name
  $xls->setHeader('Customer Balance Report_'.$asonDate);
  $options = array('zero'=>'0.00');
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Customer Balance Report');
   
  //1st row for columns name
  $xls->openRow();
  $xls->writeString('Customer Name');
  $xls->writeString('Invoice Balance');
  $xls->writeString('Credit balance');
  $xls->writeString('Balance'); 
  $xls->closeRow();
   
  //rows for data
  foreach ($final_array as $key=>$value):
    $xls->openRow();
    $xls->writeString($value['organizationName']);    
    $xls->writeString($this->Number->currency($value['invoiceBalance'],$value['custCrncyCode']));    
    $xls->writeString($this->Number->currency($value['creditBalance'],$value['custCrncyCode']));
	$xls->writeString($this->Number->currency($value['balance'],$value['custCrncyCode']));   
    $xls->closeRow();
  endforeach;
  
  $xls->addXmlFooter();
  exit();
?>