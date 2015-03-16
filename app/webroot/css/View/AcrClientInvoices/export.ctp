<?php
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */
 
  //declare the xls helper
  $xls= new xlsHelper();
 
  //input the export file name
  $xls->setHeader('Invoices_'.date('Y_m_d'));
 
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Invoices');
   
  //1st row for columns name
  $xls->openRow();
  $xls->writeString('Invoice Date');
  $xls->writeString('Invoice ID');
  $xls->writeString('Invoice Number');
  $xls->writeString('Invoice Status');
  $xls->writeString('Customer Name');
  $xls->writeString('Customer ID');
  $xls->writeString('Due Date');
  $xls->writeString('Purchase Order Number');
  $xls->writeString('Currency Code');
  $xls->writeString('Exchange Rate');
  $xls->writeString('Item Name');
  $xls->writeString('Item Desc');
  $xls->writeString('Quantity');
  $xls->writeString('Item Price');
  $xls->writeString('Discount(%)');
  $xls->writeString('Tax Group');
  $xls->writeString('Tax');
  $xls->writeString('Item Total');
  $xls->writeString('Sub Total');
  $xls->writeString('Tax Total');
  $xls->writeString('Total');
  $xls->writeString('Balance');
  $xls->writeString('Payment Terms');
  $xls->writeString('Last Payment Date');
  $xls->writeString('Notes');
  $xls->writeString('Terms And Conditions');
 if($getCustomFields){
  	foreach($getCustomFields as $key => $getCustomField):
  		$xls->writeString($getCustomField);
  	endforeach;
  }
  $xls->closeRow();
   
  //rows for data
  foreach ($finalArray as $finalarray):
    $xls->openRow();
    $xls->writeString($finalarray['Invoice Date']);
    $xls->writeString($finalarray['Invoice ID']);
    $xls->writeString($finalarray['Invoice Number']);
    $xls->writeString($finalarray['Invoice Status']);
    $xls->writeString($finalarray['Customer Name']);
    $xls->writeString($finalarray['Customer ID']);
    $xls->writeString($finalarray['Due Date']);
    $xls->writeString($finalarray['Purchase Order']);
    $xls->writeString($finalarray['Currency Code']);
    $xls->writeString($finalarray['Exchange Rate']);
    $xls->writeString($finalarray['Item Name']);
    $xls->writeString($finalarray['Item Desc']);
    $xls->writeString($finalarray['Quantity']);
    $xls->writeString($finalarray['Item Price']);
    $xls->writeString($finalarray['Discount(%)']);
    $xls->writeString($finalarray['Tax Group']);
    $xls->writeString($finalarray['Tax']);
    $xls->writeString($finalarray['Item Total']);
    $xls->writeString($finalarray['Sub Total']);
    $xls->writeString($finalarray['Tax Total']);
    $xls->writeString($finalarray['Total']);
    $xls->writeString($finalarray['Balance']);
    $xls->writeString($finalarray['Payment Terms']);
    $xls->writeString($finalarray['Last Payment Date']);
    $xls->writeString($finalarray['Notes']);
    $xls->writeString($finalarray['Terms And Conditions']);
    foreach($getCustomFields as $fieldId=>$fieldVal):
    	 $xls->writeString($getCustomFieldsVal[$fieldId]);
    endforeach;
    $xls->closeRow();
	endforeach;
  
  
  $xls->addXmlFooter();
  
  
  exit();
?>