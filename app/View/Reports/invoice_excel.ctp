<?php
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */
 
  //declare the xls helper
  $xls= new xlsHelper();
 
  //input the export file name
  $xls->setHeader('Invoice Detail Report_'.date('Y_m_d'));
 
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Invoice Detail Report');
   
   
   
   
      foreach($invoice_Report as $key1=>$value1): 
		      $xls->openRow();
    		  $xls->writeString($key1);
	          $xls->closeRow();	 
	           foreach($value1 as $key=>$value): 
			          $xls->openRow(); 
			          $xls->writeString('Invoice #');
			          $xls->writeString('Invoice Date');
			          $xls->writeString('Invoice Status');
			          $xls->writeString('Item Description');
			          $xls->writeString('Tax Code');
			          $xls->writeString('Unit Cost');
			          $xls->writeString('Quality');
			          $xls->writeString('Amount');
			          $xls->closeRow();	 
	          
	          $loop=0;$total_amount = null;$paid_amount=null;
	          foreach($value['invoice_details'] as $k=>$v):  $loop++;
			          
			                  $xls->openRow(); 
			                  if($loop ==1){ 
				                  $xls->writeString($value['invoice_number']);
				                  $xls->writeString($value['invoice_date']);
				                  $xls->writeString($value['invoice_status']);
				        	  }else{
				                  $xls->writeString('');
					              $xls->writeString('');
					              $xls->writeString('');
			                  } 			               
			            
			                   $xls->writeString($v['item_description']);
			                   $xls->writeString($v['tax_code']); 
			                   $xls->writeString($this->Number->format($v['unit_cost'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','))); 
           	                   $xls->writeString($v['quantity']);
           	                   $xls->writeString($this->Number->format($v['amount'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
			                   $total_amount +=$v['amount'];
			                   $paid_amount = $v['paid_amount'];
			                   $xls->closeRow();
			                   	 
	            endforeach; 
	          
	          $xls->openRow(); 
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('Sub Total');
	          $xls->writeString($this->Number->format($total_amount,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
			  $xls->closeRow();   
	            
	          $xls->openRow(); 
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('Taxes');
	          $xls->writeString($this->Number->format($value['tax_total'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
			  $xls->closeRow(); 
	          
	           $xls->openRow(); 
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('Invoice Total');
	          $xls->writeString($this->Number->format($total_amount+$value['tax_total'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
	          $xls->closeRow();
               
                $xls->openRow(); 
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('Paid');
	          if(empty($paid_amount)){
                      	  $paid_Amount = '0.00';
                      }else{
                      	 $paid_Amount = $value['paid_amount'];
                      } 
	          $xls->writeString($this->Number->format($paid_Amount,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
	          $xls->closeRow();       
					 
                $xls->openRow(); 
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('Balance');
	          $balence = ($total_amount+$value['tax_total'])-$paid_amount;
	          $xls->writeString($this->Number->format($balence,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')));
	          
	          $xls->closeRow();   
	             
	        
            endforeach;              
                    
  endforeach; 
    $xls->openRow(); 
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->writeString('');
	          $xls->closeRow(); 

      


   
    
  $xls->addXmlFooter();
  exit();
?>