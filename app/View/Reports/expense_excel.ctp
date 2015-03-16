<?php
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */
  $xls= new xlsHelper();
 
  //input the export file name
  $xls->setHeader('Expense Summary Report_'.date('Y_m_d'));
 
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Expense Summary Report');
   
  //1st row for columns name
  $xls->openRow();
  $xls->writeString('Status');
  $xls->writeString('Expense Date');
  $xls->writeString('Ref No');
  $xls->writeString('Customer Name');
  $xls->writeString('Category');
  $xls->writeString('Expense Amount');
  $xls->writeString('Tax Amount');
  $xls->writeString('Expense Amount (Incl Tax)');
  $xls->closeRow();
  
  
  foreach($expenseReport as $value):
    $xls->openRow();
    $xls->writeString($value['status']); 
    $xls->writeString($value['expense_date']);
    $xls->writeString($value['ref_no']);
    $xls->writeString($value['customer_name']);
    $xls->writeString($value['category']);
    
    $xls->writeString($this->Number->format($value['expense_amount'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','))); 
    $xls->writeString($this->Number->format($value['tax_amount'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','))); 
    $xls->writeString($this->Number->format($value['expense_amount_incl_tax'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','))); 
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
    $xls->writeString($this->Number->format($total_amount,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
    $xls->closeRow();
   
    
      $xls->openRow(); 
      $xls->writeString('');
      $xls->writeString('');
      $xls->writeString('');
      $xls->writeString('');
      $xls->writeString('');
      $xls->writeString('All Amounts Displayed in');
      $xls->writeString('');
      $xls->writeString($subscriberCurrencyCode);
      $xls->closeRow(); 
    
    
  $xls->addXmlFooter();
  exit();
?>