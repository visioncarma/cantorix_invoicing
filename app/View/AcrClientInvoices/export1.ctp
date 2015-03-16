<?php
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */
 
  //declare the xls helper
  $xls= new xlsHelper();
 
  //input the export file name
  $xls->setHeader('Account Aging Report_'.date('Y_m_d'));
 
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Account Aging Report');
  $xls->openRow();
  $xls->writeString('Customer Name');
  $xls->writeString('Last Payment Date');
  $xls->writeString('Last Payment Amount');
  $xls->closeRow();
  $xls->addXmlFooter();
  exit();
?>