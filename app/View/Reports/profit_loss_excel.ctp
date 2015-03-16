<?php
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */

  //declare the xls helper
  $xls= new xlsHelper();
 
  //input the export file name
  $xls->setHeader('Profit and Loss Report_'.date('Y_m_d'));
 
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Profit and Loss');
   
 
  foreach($finalArray['Sales'] as $key=>$value):
    $xls->openRow();
    $xls->writeString('');
    $xls->writeString($key); 
    $xls->closeRow();
  endforeach;  
   
    $xls->openRow();
    $xls->writeString('');
    $xls->writeString('');
    $xls->writeString('');
    $xls->writeString('');
    $xls->writeString('');
    $xls->writeString('');
    $xls->writeString('Total');
    $xls->writeString($total_amount);
    $xls->closeRow();
   
  
  $xls->addXmlFooter();
  exit();
?>