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
   
  $i =1;
  foreach($finalArray['Sales'] as $key=>$value):
  
     if($i==1) {
       $xls->openRow();
       $xls->writeString('');	
     }
     $xls->writeString($key);
     if($i == count($finalArray['Sales'])){
     	$xls->closeRow();
     }
     $i++;
  endforeach;  
   
  $i =1;
  foreach($finalArray['Sales'] as $key=>$value):
  
     if($i==1) {
       $xls->openRow();
       $xls->writeString('Income');	
     }
     $xls->writeString('');
     if($i == count($finalArray['Sales'])){
     	$xls->closeRow();
     }
     $i++;
  endforeach;   
   
  $i =1;
  foreach($finalArray['Sales'] as $key=>$value):
  
     if($i==1) {
       $xls->openRow();
       $xls->writeString('Sales');	
     }
     $xls->writeNumber($this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
     if($i == count($finalArray['Sales'])){
     	$xls->closeRow();
     }
     $i++;
  endforeach; 
  
  
  $i =1;
  foreach($finalArray['GoodsSold'] as $key=>$value):
     if($i==1) {
       $xls->openRow();
       $xls->writeString('Cost of Goods Sold');	
     }
     $xls->writeNumber($this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
     if($i == count($finalArray['GoodsSold'])){
     	$xls->closeRow();
     }
     $i++;
  endforeach; 
  
  $i =1;
  foreach($finalArray['Total'] as $key=>$value):
     if($i==1) {
       $xls->openRow();
       $xls->writeString('Gross Profit');	
     }
     $xls->writeNumber($this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
     if($i == count($finalArray['Total'])){
     	$xls->closeRow();
     }
     $i++;
  endforeach; 
  
  $i =1;
  foreach($finalArray['Total'] as $key=>$value):
     if($i==1) {
       $xls->openRow();
       $xls->writeString('');	
     }
     $xls->writeString('');
     if($i == count($finalArray['Total'])){
     	$xls->closeRow();
     }
     $i++;
  endforeach;
   
   $i =1;
  foreach($finalArray['Total'] as $key=>$value):
     if($i==1) {
       $xls->openRow();
       $xls->writeString('Less Expenses');	
     }
     $xls->writeString('');
     if($i == count($finalArray['Total'])){
     	$xls->closeRow();
     }
     $i++;
  endforeach;
  
   
  foreach($expenseCategory as $exp1=>$exp2):
       $xls->openRow();
       $xls->writeString($exp2);	
       foreach($lessexp[$exp1] as $lexp1=>$lexp2 ):
           if($lexp2 =='-'){
 			 	 $xls->writeString($lexp2);
 			 }else{
  			 	 $xls->writeNumber($this->Number->format($lexp2,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
             }
       endforeach;
       $xls->closeRow();
  endforeach;
  
  $i =1;
  foreach($finalArray['TotalExpenses'] as $key=>$value):
     if($i==1) {
       $xls->openRow();
       $xls->writeString('Total Expenses');	
     }
      $xls->writeNumber($this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
     if($i == count($finalArray['TotalExpenses'])){
     	
     	$xls->closeRow();
     }
     $i++;
  endforeach;
  
  $i =1;
  foreach($finalArray['NetProfit'] as $key=>$value):
     if($i==1) {
       $xls->openRow();
       $xls->writeString('Net Profit');	
     }
      $xls->writeNumber($this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
     if($i == count($finalArray['NetProfit'])){
     	$xls->closeRow();
     }
     $i++;
  endforeach;
  
  
  
  $i =1;
  foreach($finalArray['Total'] as $key=>$value):
     if($i==1) {
        $xls->openRow();
       
     }
       $xls->writeString('');	
     if($i == count($finalArray['Total'])){
     	$xls->writeString('');	
     	$xls->writeString('All Amounts Displayed in');
     	$xls->writeString($subscriberCurrencyCode);
     	$xls->closeRow();
     }
     $i++;
  endforeach;
  
  $xls->addXmlFooter();
  exit();
?>