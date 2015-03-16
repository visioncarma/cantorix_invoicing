<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php 
App::import('Vendor','xtcpdf'); 
  
$tcpdf = new XTCPDF();
$tcpdf->SetPrintHeader(false);
$options = array('zero'=>'0.00');
$tcpdf->AddPage(); 


	/********Table content beings here ************/
       
       $custBalReportHeading ='<table  border="0" cellpadding="2" cellspacing="2" width="100%">
								<tr>
								      <td colspan="3" align="center" style="color:#666;font-size:8pt;font-family:Arial;font-weight:normal;">Prepared on '.$todayDate.'</td>
								</tr>
								<tr>
								     <td colspan="3" align="center" style="color:#4F67A3;font-size:24px;font-family:Arial;font-weight:bold;">'.$organizationName.'</td>
								</tr>
								<tr>
								     <td colspan="3" align="center" style="color:#333;font-size:18px;font-family:Arial;font-weight:normal;">Profit Loss Report</td>
								</tr>
								<tr>
								    <td colspan="3" align="center" style="color:#666;font-size:8pt;font-family:Arial;font-weight:normal;">For the Period Ending '.$EndDate.'</td>
								</tr>
							</table><br />'; 
								
	    
	 
	       
			  $i=1; 
			  foreach($finalArray['Sales'] as $key=>$value){
					if($i=='1'){
						$headerContent.='<td colspan="1" align="left" style="color:#000;font-size:8.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;border-left: 1px solid #d8d8d8;">'.' '.'</td>';
					}
					if($i==count($finalArray['Sales'])){
						$headerContent.='<td colspan="1" align="right" style="color:#000;font-size:7.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;border-right: 1px solid #d8d8d8;">'.$key.'</td>';
					}else{
					    $headerContent.='<td colspan="1" align="right" style="color:#000;font-size:7.25pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-top: 1px solid #d8d8d8;">'.$key.'</td>';	
					}
					
					$i++;
			  } 	         
			  $tableHeader = '<table  border="0" cellpadding="2" cellspacing="0" width="100%">
			  <tr>'.$headerContent.'</tr></table>';
			  
			  $tableHeader.= '<table  border="0" cellpadding="2" cellspacing="0" width="100%">
			                  <tr><td colspan="1" align="left" style="color:#2B83B7;font-size:8.00pt;font-family:Arial;font-weight:bold;border-bottom: 1px solid #d8d8d8;border-left: 1px solid #d8d8d8;border-right: 1px solid #d8d8d8;">Income</td></tr></table>';
              
	         
	          $i=1; 
			  foreach($finalArray['Sales'] as $key=>$value){
					if(empty($value)) $value = '0.00';
					
					if($i=='1'){
						$headerContent1.='<td colspan="1" align="left" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;border-left: 1px solid #d8d8d8;">'.'Sales'.'</td>';
					}
					if($i==count($finalArray['Sales'])){
						$headerContent1.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;border-right: 1px solid #d8d8d8;">'.$this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>';
					}else{
					    $headerContent1.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.$this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>';	
					}
					$i++;
			  }
	         
	         $tableHeader .= '<table  border="0" cellpadding="2" cellspacing="0" width="100%">
			                 <tr>'.$headerContent1.'</tr></table>';
	  
	        
	         
	          $i=1; 
			  foreach($finalArray['GoodsSold'] as $key=>$value){
					if(empty($value)) $value = '0.00';
					
					if($i=='1'){
						$headerContent2.='<td colspan="1" align="left" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;border-left: 1px solid #d8d8d8;">'.'Cost of Goods Sold'.'</td>';
					}
					if($i==count($finalArray['GoodsSold'])){
						$headerContent2.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;border-right: 1px solid #d8d8d8;">'.$this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>';
					}else{
					    $headerContent2.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1px solid #d8d8d8;">'.$this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>';	
					}
					$i++;
			  }
	         
	         $tableHeader .= '<table  border="0" cellpadding="2" cellspacing="0" width="100%">
			                 <tr>'.$headerContent2.'</tr></table>';
	  
	         
	         $i=1; 
			 foreach($finalArray['Total'] as $key=>$value){
					if(empty($value)) $value = '0.00';
					
					if($i=='1'){
						$headerContent3.='<td colspan="1" align="left" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;border-left: 1px solid #d8d8d8;">'.'Gross Profit'.'</td>';
					}
					if($i==count($finalArray['Total'])){
						$headerContent3.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;border-right: 1px solid #d8d8d8;">'.$this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>';
					}else{
					    $headerContent3.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;">'.$this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>';	
					}
					$i++;
			  }
	         
	          $tableHeader .= '<table  border="0" cellpadding="2" cellspacing="0" width="100%">
			                 <tr>'.$headerContent3.'</tr></table>';
			                 
			 //Empty Row               
			 $i=1; 
			 foreach($finalArray['Total'] as $key=>$value){
					if(empty($value)) $value = '0.00';
					
					if($i=='1'){
						$headerContentEmpty.='<td colspan="1" align="left" style="color:#864C50;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;border-left: 1px solid #d8d8d8;">'.''.'</td>';
					}
					if($i==count($finalArray['Total'])){
						$headerContentEmpty.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;border-right: 1px solid #d8d8d8;">'.''.'</td>';
					}else{
					    $headerContentEmpty.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;">'.''.'</td>';	
					}
					$i++;
			  }
	         
	          $tableHeader .= '<table  border="0" cellpadding="2" cellspacing="0" width="100%">
			                 <tr>'.$headerContentEmpty.'</tr></table>';                
		

              
             $i=1; 
			 foreach($finalArray['Total'] as $key=>$value){
					if(empty($value)) $value = '0.00';
					
					if($i=='1'){
						$headerContentLessExpense.='<td colspan="1" align="left" style="color:#2B83B7;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;border-left: 1px solid #d8d8d8;">'.'Less Expense'.'</td>';
					}
					if($i==count($finalArray['Total'])){
						$headerContentLessExpense.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;border-right: 1px solid #d8d8d8;">'.''.'</td>';
					}else{
					    $headerContentLessExpense.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;">'.''.'</td>';	
					}
					$i++;
			  }
	         
	          $tableHeader .= '<table  border="0" cellpadding="2" cellspacing="0" width="100%">
			                   <tr>'.$headerContentLessExpense.'</tr></table>';
			                   
			         
			                                         
	         
	         
	   //Categrory List
	    $i=0;       
	   foreach($expenseCategory as $exp1=>$exp2){   
		        
		   	   $headerContentCategory.='<table  border="0" cellpadding="2" cellspacing="0" width="100%">
			                   <tr><td colspan="1" align="left" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;border-left: 1px solid #d8d8d8;">'.$exp2.'</td>';
		   	  
		   	  
		  	  foreach($lessexp[$exp1] as $lexp1=>$lexp2 ){ $i++; $valueEmpty =  $value = null; 
		          if($lexp2 =='-'){
		          	   $valueEmpty = $lexp2;
     			  }else{
     			  	  $value = $lexp2;
     			  } 	  	
     			  
     			  if($valueEmpty){
     			  	  if($i == count($finalArray['Total'])){
     			  	       $headerContentCategory.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;border-right: 1pt solid #d8d8d8;">'.$valueEmpty.'</td>';
	     			  }else{
	     			      $headerContentCategory.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;">'.$valueEmpty.'</td>';	
	     			  }
     			  	
     			  }else{
     			       if($i == count($finalArray['Total'])){
     			  	       $headerContentCategory.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;border-right: 1pt solid #d8d8d8;">'.$this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>';
	     			  }else{
	     			      $headerContentCategory.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;">'.$this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>';	
	     			  }	
     			  }
     			  
     			  
     			  
		   	  }
		   	  $i=0;
		      $headerContentCategory .='</tr></table>';
		 }   
	     $tableHeader .=  $headerContentCategory ;                  
			                                         
	     
	      $i=1; 
		  foreach($finalArray['TotalExpenses'] as $key=>$value){
					if(empty($value)) $value = '0.00';
					
					if($i=='1'){
						$headerContentTotalExpense.='<td colspan="1" align="left" style="color:#000;font-size:8.25pt;font-family:Arial;font-weight:bold;border-bottom: 1pt solid #d8d8d8;border-left: 1px solid #d8d8d8;">'.'Total Expense'.'</td>';
					}
					if($i==count($finalArray['TotalExpenses'])){
						$headerContentTotalExpense.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;border-right: 1px solid #d8d8d8;">'.$this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>';
					}else{
					    $headerContentTotalExpense.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;">'.$this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>';	
					}
					$i++;
			}
	         
	        $tableHeader .= '<table  border="0" cellpadding="2" cellspacing="0" width="100%">
			                   <tr>'.$headerContentTotalExpense.'</tr></table>';
			                   
		
		  $i=1; 
		  foreach($finalArray['NetProfit'] as $key=>$value){
					if(empty($value)) $value = '0.00';
					
					if($i=='1'){
						$headerContentNetProfit.='<td colspan="1" align="left" style="color:#000;font-size:8.25pt;font-family:Arial;font-weight:bold;border-bottom: 1pt solid #d8d8d8;border-left: 1px solid #d8d8d8;">'.'Net Profit'.'</td>';
					}
					if($i==count($finalArray['NetProfit'])){
						$headerContentNetProfit.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;border-right: 1px solid #d8d8d8;">'.$this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>';
					}else{
					    $headerContentNetProfit.='<td colspan="1" align="right" style="color:#000;font-size:8.25pt;font-family:Arial;border-bottom: 1pt solid #d8d8d8;">'.$this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>';	
					}
					$i++;
			}
	         
	        $tableHeader .= '<table  border="0" cellpadding="2" cellspacing="0" width="100%">
			                   <tr>'.$headerContentNetProfit.'</tr></table>';
			                   
			      
			      
			      
	       $tableClose .='<table  border="0" cellpadding="2" cellspacing="2" width="100%">
						<tr>
						      <td colspan="3" align="right" style="color:#666;font-size:8pt;font-family:Arial;font-weight:normal;"> All Amounts Displayed in '.$subscriberCurrencyCode.'</td>
						</tr>
			            </table><br />';              
	         
	       
	
$html = <<<EOD
	  $custBalReportHeading
      $tableHeader
	  $tableContent
	  $tableClose
EOD;
$tcpdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);  
$tcpdf->Output("Profit Loss Report_$toDate.pdf",'D');  

?>
