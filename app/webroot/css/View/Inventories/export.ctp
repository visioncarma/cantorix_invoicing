<?php
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */
 
  //declare the xls helper
  $xls= new xlsHelper();
 
  //input the export file name
  $xls->setHeader('Items_'.date('Y_m_d'));
 
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Items');
   
  //1st row for columns name
  $xls->openRow();
  $xls->writeString('Inventory Name');
  $xls->writeString('Inventory Description');
  $xls->writeString('Inventory Price');
  $xls->writeString('Tax');
  $xls->writeString('Tax Group');
  $xls->writeString('Unit Type');
  $xls->writeString('Track Item Quantity');
  $xls->writeString('Current Stock');
  foreach($invCustomFields as $invCustomField):
    $xls->writeString($invCustomField['InvInventoryCustomField']['field_name']);
  endforeach;
  $xls->closeRow();
   
  //rows for data
  foreach ($invInventory as $invInventoryVal):
    $xls->openRow();
    $xls->writeString($invInventoryVal['InvInventory']['name']);
    $xls->writeString($invInventoryVal['InvInventory']['description']);
    $xls->writeNumber($invInventoryVal['InvInventory']['list_price']);
    $xls->writeString($invInventoryVal['SbsSubscriberTax']['name']);
    $xls->writeString($invInventoryVal['SbsSubscriberTaxGroup']['group_name']);
    $xls->writeString($invInventoryVal['InvInventoryUnitType']['type_name']);
    $xls->writeString($invInventoryVal['InvInventory']['track_quantity']);
    $xls->writeNumber($invInventoryVal['InvInventory']['current_stock']);
    foreach($invCustomFields as $invCustomField):
    	$xls->writeString($customValue[$invInventoryVal['InvInventory']['id']][$invCustomField['InvInventoryCustomField']['id']]);
    endforeach;
    $xls->closeRow();
  endforeach;
  
  $xls->addXmlFooter();
  exit();
?>