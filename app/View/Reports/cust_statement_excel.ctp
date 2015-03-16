<?php
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */
 	
    $options = array('zero'=>'0.00');
	$total_amount			=	$final['totalAmount'];
	$date_format			=	$final['date_format'];
	$subscriberCurrencyCode	=	$final['subscriberCurrencyCode'];
	$customerCurrencyCode	=	$final['custCrncyCode'];
	$orgname				=	$final['orgname'];
	$init_bal_due           =   $final['init_bal_due'];	
	$initial_balance_due 	= 	$init_bal_due;
	
	$toDate   =  date($date_format,strtotime($toDate));	
	$fromDate =  date($date_format,strtotime($fromDate));
	$tdydate  =  date($date_format);	
	
    $prev_date = date($date_format, strtotime($fromDate .' -1 day'));					
	
  //declare the xls helper
  $xls= new xlsHelper();  	
  //input the export file name
  $xls->setHeader('Customer Statement Report_'.$tdydate); 
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Customer Statement Report');
   
  $xls->openRow();
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->closeRow();
   
  $xls->openRow();
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('Initial balance due (As of '.$prev_date.')');
  $xls->writeString($this->Number->currency($init_bal_due,'',$options)); 
  $xls->closeRow(); 
   
  $xls->openRow();
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->closeRow();
   
  //1st row for columns name
  $xls->openRow();
  $xls->writeString('Date');
  $xls->writeString('Document Type');
  $xls->writeString('Document No');
  $xls->writeString('Description'); 
  $xls->writeString('Amount');
  $xls->writeString('Balance Due');  
  $xls->closeRow();   

  //rows for data
  foreach ($final as $key1=>$value1):
   foreach($value1 as $key=>$value):
	   if($value['doc_type'] == 'Payment' || $value['doc_type'] == 'Credit') {
			$bal_due   = $initial_balance_due - $value['amount'];
			$initial_balance_due = $bal_due;
			$sign = '-';
			$colr = '#587322;';						
		} 
		if($value['doc_type'] == 'Invoice') {
			$bal_due   = $initial_balance_due + $value['amount'];
			$initial_balance_due = $bal_due;
			$sign = '';
			$colr = '#d8d8d8;';
		}
		if($value['doc_type'] == 'Payment') {
			$ref = 'Ref';			
		} else {
			$ref = '';
		}		
    $xls->openRow();
    $xls->writeString(date($date_format,strtotime($key1)));    
    $xls->writeString($value['doc_type']);    
    $xls->writeString($value['doc_no']);
	$xls->writeString($value['doc_type'].' '.$ref.' No: '.$value['doc_no'].', '. $orgname);
	$xls->writeString($this->Number->currency($sign.$value['amount'],'',$options));
	$xls->writeString($this->Number->currency($bal_due,'',$options));
    $xls->closeRow();
   endforeach;
  endforeach;
  
  $xls->openRow();
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->closeRow();
  
  $xls->openRow();
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('Total');
  $xls->writeString($this->Number->currency($total_amount,'',$options));  
  $xls->closeRow();
  
  $xls->openRow();
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->closeRow();
  
  $xls->openRow();
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('');
  $xls->writeString('All amounts displayed in');
  $xls->writeString($customerCurrencyCode);
  $xls->closeRow();
  
  $xls->addXmlFooter();
  exit();
?>