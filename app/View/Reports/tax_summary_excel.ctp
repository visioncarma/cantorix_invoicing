<?php
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */
 
  //declare the xls helper
  $xls= new xlsHelper();
  
  //input the export file name
  $xls->setHeader('Tax Summary Report');
  $options = array('zero'=>'0.00');
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Tax Summary Report');
   
  //1st row for columns name
  $xls->openRow();
  $xls->writeString('Group Type');
  $xls->writeString('Tax Code');
  $xls->writeString('Tax Name');
  $xls->writeString('Tax Percentage'); 
  $xls->writeString('Tax Amount'); 
  $xls->closeRow();
   
  //rows for data
  $i=0; foreach($final as $key=>$value){ $i++;
	  
	$l=0;	foreach($value as $key1=>$value1){   $l++;
			    $xls->openRow();
			    if($l =='1'){
			    $xls->writeString($key); 
			    }else{
			    $xls->writeString(''); 	
			    }
			    $xls->writeString($value1['code']);    
			    $xls->writeString($value1['name']);     
			    $xls->writeString($value1['percent'].'%');  
				$xls->writeString(round($value1['amount'],2));  
				  
			    $xls->closeRow();
				
				$total =$value1['amount'];
	            $total_amount = $total + $total_amount ;	
		} 
	    $xls->openRow();
	    $xls->writeString('');    
	    $xls->writeString('');     
	    $xls->writeString('');  
		$xls->writeString("Total"); 
		$xls->writeString(round($total_amount,2)); 
	    $xls->closeRow();
		
		$xls->openRow();
	    $xls->writeString('');    
	    $xls->writeString('');     
	    $xls->writeString('');  
		$xls->writeString(''); 
		$xls->writeString(''); 
	    $xls->closeRow();
		$total = $total_amount=null;
   }
    $xls->openRow();
	$xls->writeString('');    
	$xls->writeString('');     
	$xls->writeString('');  
	$xls->writeString("All amounts displayed in"); 
	$xls->writeString($subscriberCurrencyCode['CpnCurrency']['code']); 
	$xls->closeRow();
  
  $xls->addXmlFooter();
  exit();
?>