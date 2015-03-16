<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php 
App::import('Vendor','xtcpdf'); 
  
$tcpdf = new XTCPDF();
$tcpdf->SetPrintHeader(false);
$options = array('zero'=>'0.00');
$tcpdf->AddPage(); 




   $custBalReportHeading ='<table  border="0" cellpadding="2" cellspacing="2" width="100%">
<tr>
  <td colspan="3" align="center" style="color:#666;font-size:9pt;font-family:Arial;font-weight:normal;">Prepared on '.$todayDate.'</td>
 </tr>
 <tr>
  <td colspan="3" align="center" style="color:#4F67A3;font-size:18pt;font-family:Arial;font-weight:bold;">'.$organizationName.'</td>
 </tr>
 <tr>
  <td colspan="3" align="center" style="color:#333;font-size:13.5pt;font-family:Arial;font-weight:normal;">Invoice Detail Report</td>
 </tr>
 <tr>
  <td colspan="3" align="center" style="color:#666;font-size:9pt;font-family:Arial;font-weight:normal;">Till '.$toDate.'</td>
 </tr>
</table>'; 
	 
   foreach($invoice_Report as $key1=>$value1): 
     
      $tableContent .='<table  border="0" cellpadding="2" cellspacing="2" width="100%">
							<tr>
								  <td colspan="3" align="left" style="color:#4F67A3;font-size:22.5pt;font-family:Arial;font-weight:normal;">'.$key1.'</td>
					        </tr>
						</table>'; 
       
      $tableContent .='<table  border="0" border-style: "solid"; cellpadding="2" cellspacing="1" width="100%">
							<tr>
								  <td colspan="2" align="left" style="color:#333;font-size:8.25pt;font-family:Arial;font-weight:bold;border-top: 1px solid #E4E4E4;border-left: 1px solid #E4E4E4;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.'Invoice #'.'</td>
								  <td colspan="3" align="left" style="color:#333;font-size:8.25pt;font-family:Arial;font-weight:bold;border-top: 1px solid #E4E4E4;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.'Invoice Date'.'</td>
								  <td colspan="3" align="left" style="color:#333;font-size:8.25pt;font-family:Arial;font-weight:bold;border-top: 1px solid #E4E4E4;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.'Invoice Status'.'</td>
								  <td colspan="3" align="left" style="color:#333;font-size:8.25pt;font-family:Arial;font-weight:bold;border-top: 1px solid #E4E4E4;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.'Item Description'.'</td>
								  <td colspan="2" align="left" style="color:#333;font-size:8.25pt;font-family:Arial;font-weight:bold;border-top: 1px solid #E4E4E4;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.'Tax Code'.'</td>
								  <td colspan="2" align="right" style="color:#333;font-size:8.25pt;font-family:Arial;font-weight:bold;border-top: 1px solid #E4E4E4;border-bottom: 1px solid #E4E4E4;pading : 3px 2px;">'.'Unit Cost'.'</td>
								  <td colspan="2" align="right" style="color:#333;font-size:8.25pt;font-family:Arial;font-weight:bold;border-top: 1px solid #E4E4E4;border-bottom: 1px solid #E4E4E4;pading : 3px 2px;" >'.'Quantity'.'</td>
								  <td colspan="2" align="right" style="color:#333;font-size:8.25pt;font-family:Arial;font-weight:bold;border-top: 1px solid #E4E4E4;border-right: 1px solid #E4E4E4;border-bottom: 1px solid #E4E4E4;pading : 3px 2px; text-align:right; ">'.'Amount'.'</td>
					        </tr>
						</table>';
						foreach($value1 as $key=>$value): 
	   $loop=0;	$total_amount =0;$paid_amount=null;			
       foreach($value['invoice_details'] as $k=>$v): $loop++;
       	          if($loop =='1'){   
					       $tableContent .='<table  border="0" border-style: "solid"; cellpadding="2" cellspacing="1" width="100%">
												<tr> 
													  <td colspan="2" align="left" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;border-left: 1px solid #E4E4E4;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.$value['invoice_number'].'</td>
													  <td colspan="3" align="left" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.$value['invoice_date'].'</td>
													  <td colspan="3" align="left" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.$value['invoice_status'].'</td>
													  <td colspan="3" align="left" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.$v['item_description'].'</td>
													  <td colspan="2" align="left" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.$v['tax_code'].'</td>
													  <td colspan="2" align="right" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;border-bottom: 1px solid #E4E4E4;pading : 3px 2px;text-align:right; ">'.$this->Number->format($v['unit_cost'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
													  <td colspan="2" align="right" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;border-bottom: 1px solid #E4E4E4;pading : 3px 2px;text-align:right; ">'.$this->Number->format($v['quantity'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
													  <td colspan="2" align="right" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;border-right: 1px solid #E4E4E4;border-bottom: 1px solid #E4E4E4;pading : 3px 2px;text-align:right; ">'.$this->Number->format($v['amount'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
										        </tr>
											</table>';
					    }else{
					    	 $tableContent .='<table  border="0" border-style: "solid"; cellpadding="2" cellspacing="1" width="100%">
												<tr> 
													  <td colspan="2" align="left" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;border-left: 1px solid #E4E4E4;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.' '.'</td>
													  <td colspan="3" align="left" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.''.'</td>
													  <td colspan="3" align="left" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.''.'</td>
													  <td colspan="3" align="left" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.$v['item_description'].'</td>
													  <td colspan="2" align="left" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.$v['tax_code'].'</td>
													  <td colspan="2" align="right" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.$this->Number->format($v['unit_cost'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
													  <td colspan="2" align="right" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.$this->Number->format($v['quantity'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
													  <td colspan="2" align="right" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;border-right: 1px solid #E4E4E4;border-bottom: 1px solid #E4E4E4;pading : 3px 2px ">'.$this->Number->format($v['amount'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
										        </tr>
											</table>';
					    }
					    $total_amount +=$v['amount'];
					    $paid_amount = $v['paid_amount'];
			endforeach; 
			
			 $tableContent .='<table  border="0" border-style: "solid"; cellpadding="2" cellspacing="1" width="100%">
												<tr> 
													  <td colspan="15" align="right" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;pading : 3px 2px ;border-left: 1px solid #E4E4E4;">'.'Sub Total'.'</td>
													  <td colspan="4"  align="right" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;pading : 3px 2px ;border-right: 1px solid #E4E4E4;">'.$value['currency_code'].' '.$this->Number->format($total_amount,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
										        </tr>
											</table>';
											
             $tableContent .='<table  border="0" border-style: "solid"; cellpadding="2" cellspacing="1" width="100%">
												<tr> 
													  <td colspan="15" align="right" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;pading : 3px 2px ;border-left: 1px solid #E4E4E4;">'.'Taxes'.'</td>
													  <td colspan="4"  align="right" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;pading : 3px 2px ;border-right: 1px solid #E4E4E4;">'.$value['currency_code'].' '.$this->Number->format($value['tax_total'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
										        </tr>
											</table>';
			
			 $tableContent .='<table  border="0" border-style: "solid"; cellpadding="2" cellspacing="1" width="100%">
												<tr> 
													  <td colspan="15" align="right" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:bold;pading : 3px 2px ;border-left: 1px solid #E4E4E4;">'.'Invoice Total'.'</td>
													  <td colspan="4"  align="right" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:bold;pading : 3px 2px ;border-right: 1px solid #E4E4E4;">'.$value['currency_code'].' '.$this->Number->format($total_amount+$value['tax_total'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
										        </tr>
											</table>'; 							
			$tableContent .='<table  border="0" border-style: "solid"; cellpadding="2" cellspacing="1" width="100%">
												<tr> 
													  <td colspan="15" align="right" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;pading : 3px 2px ;border-left: 1px solid #E4E4E4;">'.'paid'.'</td>
													  <td colspan="4"  align="right" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:normal;pading : 3px 2px ;border-right: 1px solid #E4E4E4;">'.$value['currency_code'].' '.$this->Number->format($paid_amount,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
										        </tr>
											</table>';
	                 if(empty($paid_amount)){
	                    	$paid_amount = '0.00';
	                    }
	        $tableContent .='<table  border="0" border-style: "solid"; cellpadding="2" cellspacing="1" width="100%">
												<tr> 
													  <td colspan="15" align="right" style="color:#333;font-size:7.5pt;font-family:Arial;font-weight:bold;pading : 3px 2px ;border-left: 1px solid #E4E4E4;border-bottom: 1px solid #E4E4E4;">'.'Balance'.'</td>
													  <td colspan="4"  align="right" style="color:#333;font-size:7.5ptt;font-family:Arial;font-weight:bold;pading : 3px 2px ;border-right: 1px solid #E4E4E4;border-bottom: 1px solid #E4E4E4;">'.$value['currency_code'].' '.$this->Number->format(($total_amount+$value['tax_total'])-$paid_amount,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>',')).'</td>
										        </tr>
											</table>'; 										 									
																	
			 	  endforeach; 		
    endforeach;  
 	
	         
	
$html = <<<EOD
	  $custBalReportHeading
	  $headerContent
	  $tableHeader
	  $tableContent
	  $tableClose
EOD;
$tcpdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);  
$tcpdf->Output("Invoice_Detail_Report_$toDate.pdf",'D');  



 

?>
