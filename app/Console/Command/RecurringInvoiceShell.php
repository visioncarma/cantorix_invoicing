<?php
	App::uses('CakeEmail', 'Network/Email');
	App::uses('View', 'Core');
	
	
	class RecurringInvoiceShell extends AppShell {
		var $uses = array('SbsSubscriber','AcrClientInvoice','AcrClientRecurringInvoice','InvInventory','AcrInvoiceCustomValue','AcrInvoiceCustomField','AcrClientInvoiceDetail','SbsSubscriberSetting','SbsSubscriberPaymentTerm','SbsSubscriberOrganizationDetail','AcrClient','AcrClientContact','AcrInvoiceDetail');
		public $components = array('RequestHandler','Session','Email');
		public $Controller;
		var $EMAIL_FROM 	= 'admin@cantorix.com';
		public function main() {
			$getRecurrenceForToday = $this->getAllRecurrence();
			if($getRecurrenceForToday){
				foreach($getRecurrenceForToday as $index=>$recurrenceDetail){
					$generateInvoice = $this->addInvoice($recurrenceDetail['AcrClientInvoice']);
					if($generateInvoice){
						$getRecurringInvoiceDetail = $this->getInvoiceDetail($recurrenceDetail['AcrClientRecurringInvoice']['acr_client_invoice_id']);
						if($getRecurringInvoiceDetail){
							foreach($getRecurringInvoiceDetail as $getRecurringInvoiceDetail){
								$generateInvoiceDetail	= $this->addInvoiceDetail($getRecurringInvoiceDetail['AcrInvoiceDetail'],$generateInvoice);
								if($generateInvoiceDetail){
									$updateInventory	=	$this->updateStock($getRecurringInvoiceDetail['AcrInvoiceDetail']['inv_inventory_id'],$getRecurringInvoiceDetail['AcrInvoiceDetail']['quantity']);
								}
							}
						}
						$getCustomFields = $this->getFieldList($recurrenceDetail['AcrClientInvoice']['sbs_subscriber_id']);
						foreach($getCustomFields as $customFieldKey=>$getCustomField){
							$getCustomFieldValue = $this->AcrInvoiceCustomValue->find('first',array('conditions'=>array('AcrInvoiceCustomValue.acr_invoice_custom_field_id'=>$customFieldKey,'AcrInvoiceCustomValue.acr_client_invoice_id'=>$recurrenceDetail['AcrClientInvoice']['id'])));
							$addCustomFieldValue	=	$this->addCustomValue($customFieldKey,$generateInvoice,$getCustomFieldValue['AcrInvoiceCustomValue']['data']);
						}
						
					}
					$status	=	$this->getInvoiceStatus($recurrenceDetail['AcrClientInvoice']['sbs_subscriber_id']);
					if($status == 'Sent'){
						$clientInformation = $this->AcrClientContact->find('first',array('conditions'=>array('AcrClientContact.acr_client_id'=>$recurrenceDetail['AcrClientInvoice']['acr_client_id'])));
						if($clientInformation['AcrClientContact']['email']){
							$to 		= $clientInformation['AcrClientContact']['email'];
							$from 		=  $this->EMAIL_FROM;
							$subject 	= "Invoice";
							$template 	= "sent_invoice";
							$send 		= $this->sentInvoice($generateInvoice,$clientInformation,$template,$from,$to,$subject,$recurrenceDetail['AcrClientInvoice']['sbs_subscriber_id']);
						}
					}
					$updateRecurrence = $this->updateRecurrenceValue($recurrenceDetail['AcrClientRecurringInvoice']);
				}
				
			}
		}
		public function updateRecurrenceValue($data){
			if($data['id']){
				$lastInvoiceDate = date('Y-m-d');
				$nextInvoiceDate = $this->getNextInvoiceDate($lastInvoiceDate,$data['billing_period'],$data['billing_frequency']);
				$update->data['AcrClientRecurringInvoice']['id'] 				= $data['id'];
				$update->data['AcrClientRecurringInvoice']['next_invoice_date'] = $nextInvoiceDate;
				$update->data['AcrClientRecurringInvoice']['last_invoice_date'] = $lastInvoiceDate;
				if(strtotime($nextInvoiceDate) > strtotime($data['invoice_end_date'])){
					$update->data['AcrClientRecurringInvoice']['status'] = 'Inactive';
				}
				if($this->AcrClientRecurringInvoice->save($update->data)){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
			
		}
		public function getNextInvoiceDate($lastInvoiceDate = null,$recuringPeriod = null,$recuringFrequency = null){
			if($lastInvoiceDate && $recuringPeriod && $recuringFrequency){
				$nextInvoiceDate = date('Y-m-d', strtotime($lastInvoiceDate. ' + '.$recuringFrequency.$recuringPeriod));
				return $nextInvoiceDate;
			}
		}
		public function addCustomValue($customFieldId = null,$invoiceId = null,$customFieldValue = null){
			if($customFieldId && $invoiceId && $customFieldValue){
				$add->data = null;
				$this->AcrInvoiceCustomValue->create();
				$add->data['AcrInvoiceCustomValue']['acr_client_invoice_id'] 			= $invoiceId;
				$add->data['AcrInvoiceCustomValue']['data'] 							= $customFieldValue;
				$add->data['AcrInvoiceCustomValue']['acr_invoice_custom_field_id'] 		= $customFieldId;
				if($this->AcrInvoiceCustomValue->save($add->data)){
					return $this->AcrInvoiceCustomValue->getLastInsertId();
				}else{
					return false;
				}
			}else{
				return false;
			}
			
		}
		public function getAllRecurrence(){
			$todayDate = date('Y-m-d');
			$this->AcrClientRecurringInvoice->recursive = 0;
			$getAllRecurrenceForToday = $this->AcrClientRecurringInvoice->find('all',array('conditions'=>array('OR'=>array(
															array('AcrClientRecurringInvoice.next_invoice_date'=>$todayDate,
															'AcrClientRecurringInvoice.status'=>'Active'),
															array(
															'AcrClientRecurringInvoice.invoice_start_date'=>$todayDate,
															'AcrClientRecurringInvoice.status'=>'Active'
															)))));
			if($getAllRecurrenceForToday){
				return $getAllRecurrenceForToday;
			}
		}
		public function getInvoiceDetail($invoiceId){
			if($invoiceId){
				$getDetail = $this->AcrInvoiceDetail->find('all',array('conditions'=>array('AcrInvoiceDetail.acr_client_invoice_id'=>$invoiceId)));
				if($getDetail){
					return $getDetail;
				}else{
					return false;
				}
			}else{
				return false;
			}
			
		}
		
		public function addInvoice($data){
			if($data){
				$add->data = null;
				$this->AcrClientInvoice->create();
				$status	=	$this->getInvoiceStatus($data['sbs_subscriber_id']);
				$add->data['AcrClientInvoice']['invoice_number']					=	$this->getInvoiceNumber($data['sbs_subscriber_id']);
				$add->data['AcrClientInvoice']['description']						=	$data['description'];
				$add->data['AcrClientInvoice']['invoiced_date']						=	date('Y-m-d');
				$add->data['AcrClientInvoice']['purchase_order_no']					=	$data['purchase_order_no'];
				$add->data['AcrClientInvoice']['due_date']							=	$this->findEndDate(date('Y-m-d'),$data['sbs_subscriber_payment_term_id']);
				$add->data['AcrClientInvoice']['discount_percent']					=	$data['discount_percent'];
				$add->data['AcrClientInvoice']['status']							=	$status;
				$add->data['AcrClientInvoice']['notes']								=	$data['notes'];
				$add->data['AcrClientInvoice']['term_conditions']					=	$data['term_conditions'];
				$add->data['AcrClientInvoice']['sub_total']							=	$data['sub_total'];
				$add->data['AcrClientInvoice']['tax_total']							=	$data['tax_total'];
				$add->data['AcrClientInvoice']['func_currency_total']				=	$data['func_currency_total'];
				$add->data['AcrClientInvoice']['exchange_rate']						=	$data['exchange_rate'];
				$add->data['AcrClientInvoice']['recurring']							=	'N';
				$add->data['AcrClientInvoice']['pdf_generated']						=	'N';
				$add->data['AcrClientInvoice']['acr_client_id']						=	$data['acr_client_id'];
				$add->data['AcrClientInvoice']['sbs_subscriber_id']					=	$data['sbs_subscriber_id'];
				$add->data['AcrClientInvoice']['sbs_subscriber_payment_term_id']	=	$data['sbs_subscriber_payment_term_id'];
				$add->data['AcrClientInvoice']['invoice_total']						=	$data['invoice_total'];
				$add->data['AcrClientInvoice']['invoice_currency_code']				=	$data['invoice_currency_code'];
				$add->data['AcrClientInvoice']['updated_date']						=	date('Y-m-d');
				if($this->AcrClientInvoice->save($add->data)){
					$saveInvoice	=	$this->AcrClientInvoice->getLastInsertId();
					return $this->AcrClientInvoice->getLastInsertId();
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
		public function sentInvoice ($invoiceId = null, $customerInfo = null, $template = null, $from = null, $to = null, $subject = null,$subscriberId = null) {
			$view = new View();		
			$generate      			= $this->generatePdf($invoiceId,$subscriberId);
			if($generate){
							$updatePdfGenerated = $this->pdfGen($invoiceId,$subscriberId);
						}
			$clientCurrencyCode 	= $generate['clientCurrencyCode'];
			$subscriberCurrencyCode = $generate['subscriberCurrencyCode'];
			$options 				= $generate['options'];
			$invoiceData 			= $generate['invoiceData'];
			$invoiceDetail 			= $generate['invoiceDetail'];
			$taxArray 				= $generate['taxArray'];
			$getSubscriberInfo = $this->SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=>$subscriberId),'fields'=>array('SbsSubscriber.sbs_subscriber_organization_detail_id')));
			$organisationDetails  = $this->SbsSubscriberOrganizationDetail->find('first',array('conditions'=>array('SbsSubscriberOrganizationDetail.id'=>$getSubscriberInfo['SbsSubscriber']['sbs_subscriber_organization_detail_id'])),
					array('id','organization_name','billing_address_line1','billing_address_line2','billing_city','billing_state','billing_country','billing_zip','logo'));		
			$settings 			 	= $this->SbsSubscriberSetting->find('first',array('conditions'=>array('SbsSubscriberSetting.sbs_subscriber_id'=>$invoiceData['AcrClientInvoice']['sbs_subscriber_id'])));
			$dateFormat				=	$settings['SbsSubscriberSetting']['date_format'];
			$logo					=	$settings['SbsSubscriberSetting']['invoice_logo'];
			$signature				=	$settings['SbsSubscriberSetting']['email_signature'];
			$paidAmount = $this->getInvoicePaymentDetails($invoiceId,$subscriberId);
			if(!$paidAmount){
				$paidAmount = 0;
			}
			$balanceDue = $invoiceData['AcrClientInvoice']['invoice_total'] - $paidAmount;
			$payPalLink = $this->generatePaypalLink($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code'],$invoiceData['AcrClientInvoice']['invoice_number']);
			/*$payPalLink = $this->generatePaypalLink('10000','USD',$invoiceData['AcrClientInvoice']['invoice_number']);*/
			
			$Email = new CakeEmail(); 
			//$Email->filePaths(array($_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/files/uploads/invoice/"));
	       //	$Email->attachments(array($invoiceData['AcrClientInvoice']['invoice_number'].'.pdf'));
			
			
			$Email->attachments(array (
											array('file'=>APP.'webroot/files/uploads/invoice/Subscriber-'.$invoiceData['AcrClientInvoice']['sbs_subscriber_id'].'/'.$invoiceData['AcrClientInvoice']['invoice_number'].'.pdf',
												  'mimetype'=>'application/pdf'
												 ),
											));
			
			
	       	$from 	= $this->EMAIL_FROM;
			$Email->to($to);
			$Email->cc($cc);
	        $Email->subject($subject);
	   		$Email->replyTo($from);
	    	$Email->from($from);
			$Email->viewVars(array('dateFormat'=>$dateFormat,'logo'=>$logo,'signature'=>$signature,'payPalLink'=>$payPalLink,'balanceDue'=>$balanceDue,'paidAmount'=>$paidAmount,'customerInfo'=>$customerInfo, 'clientCurrencyCode'=>$clientCurrencyCode, 'subscriberCurrencyCode'=>$subscriberCurrencyCode, 'options'=>$options, 'invoiceData'=>$invoiceData, 'invoiceDetail'=>$invoiceDetail, 'taxArray'=>$taxArray,'organisationDetails'=>$organisationDetails,'payPalLink'=>$payPalLink));
	    	$Email->template($template);
	   		$Email->emailFormat('html');
	   		if($Email->send()) {
	   			return 1;
	   		} else {
				return 0;
			}
			
		}
	
		
		
		
		
		
		
		public function generatePdf($invoiceId = null,$subscriberId = null){
			$this->loadModel('AcrInvoiceDetail');
			$this->loadModel('SbsSubscriberSetting');
			$this->loadModel('CpnCurrency');
			$this->loadModel('SbsSubscriberOrganizationDetail');
			$this->AcrClientInvoice->recursive = 0;
			$this->AcrInvoiceDetail->recursive = 0;
			$view = new View();
			ob_start();
			$invoiceData   = $this->AcrClientInvoice->find('first',array('conditions'=>array('AcrClientInvoice.id'=>$invoiceId)));
			$invoiceDetail = $this->AcrInvoiceDetail->find('all',array('conditions'=>array('AcrInvoiceDetail.acr_client_invoice_id'=>$invoiceId)));
			$view->layout = '/pdf/default';
			$view->set(compact('invoiceData','invoiceDetail','subscriberId'));
			$taxArray  = $this->getTaxCalculation($invoiceDetail);
			$settings 			 	= $this->SbsSubscriberSetting->find('first',array('conditions'=>array('SbsSubscriberSetting.sbs_subscriber_id'=>$invoiceData['AcrClientInvoice']['sbs_subscriber_id'])));
			$dateFormat				= $settings['SbsSubscriberSetting']['date_format'];
			$logo					= $settings['SbsSubscriberSetting']['invoice_logo'];
			/*$defaultCurrencyInfo 	= $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);*/
			$subscriberCurrencyCode = $invoiceData['AcrClientInvoice']['invoice_currency_code'];
			$clientCurrencyCode 	= $invoiceData['AcrClientInvoice']['invoice_currency_code'];
			$options = array('zero'=>'Free','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');
			$getSubscriberInfo = $this->SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=>$invoiceData['AcrClientInvoice']['sbs_subscriber_id']),'fields'=>array('SbsSubscriber.sbs_subscriber_organization_detail_id')));
			$subscriberOrganisationDetail = $this->SbsSubscriberOrganizationDetail->getOrganizationDetailById($getSubscriberInfo['SbsSubscriber']['sbs_subscriber_organization_detail_id']);
			if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'] && $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2']){
				$subscriberAddress = $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'];
			}elseif($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1']){
				$subscriberAddress = $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'];
			}else{
				$subscriberAddress = $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'];
			}
			if($invoiceData['AcrClient']['billing_address_line1'] && $invoiceData['AcrClient']['billing_address_line2']){
				$clientAddress = $invoiceData['AcrClient']['billing_address_line1'].'<br />'.$invoiceData['AcrClient']['billing_address_line2'].'<br />'.$invoiceData['AcrClient']['billing_city'].'<br />'.$invoiceData['AcrClient']['billing_state'].'<br />'.$invoiceData['AcrClient']['billing_country'].'<br />'.$invoiceData['AcrClient']['billing_zip'];
			}elseif($invoiceData['AcrClient']['billing_address_line1']){
				$clientAddress = $invoiceData['AcrClient']['billing_address_line1'].'<br />'.$invoiceData['AcrClient']['billing_city'].'<br />'.$invoiceData['AcrClient']['billing_state'].'<br />'.$invoiceData['AcrClient']['billing_country'].'<br />'.$invoiceData['AcrClient']['billing_zip'];
			}else{
				$clientAddress = $invoiceData['AcrClient']['billing_address_line2'].'<br />'.$invoiceData['AcrClient']['billing_city'].'<br />'.$invoiceData['AcrClient']['billing_state'].'<br />'.$invoiceData['AcrClient']['billing_country'].'<br />'.$invoiceData['AcrClient']['billing_zip'];
			}
			$view->set(compact('subscriberOrganisationDetail','dateFormat','subscriberAddress','clientAddress'));
			$view->set(compact('taxArray','clientCurrencyCode','subscriberCurrencyCode','options','logo'));
			$view->render('/Pdf/my_pdf_view');
			$returnResponse = array('clientCurrencyCode'=>$clientCurrencyCode, 'subscriberCurrencyCode'=>$subscriberCurrencyCode, 'options'=>$options, 'invoiceData'=>$invoiceData, 'invoiceDetail'=>$invoiceDetail, 'taxArray'=>$taxArray);
			return $returnResponse;
		}
		
		public function getTaxCalculation($invoiceDetail = null){
			if($invoiceDetail){
				foreach($invoiceDetail as $key=>$invoiceDetailValue){
					if($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']){
								$this->loadModel('SbsSubscriberTaxGroupMapping');
								$groupTaxMap = $this->SbsSubscriberTaxGroupMapping->getGroupMapping($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']);
								$product = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];
								$lineTotal = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];
								foreach($groupTaxMap as $key=>$val1){
									$taxArray[$val1['SbsSubscriberTax']['id']]['taxName'] = $val1['SbsSubscriberTax']['name'];
									if($val1['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y'){
										$taxAmount = ($product*$val1['SbsSubscriberTax']['percent'])/100;
										$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
										$product = $product + $taxAmount;
									}else{
										/*$product = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];*/
										$taxAmount = ($lineTotal * $val1['SbsSubscriberTax']['percent'])/100;
										$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
										$product = $lineTotal + $taxAmount;
									}
								}
							}elseif($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_id']){
								$this->loadModel('SbsSubscriberTax');
								$product = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];
								$taxDetails = $this->SbsSubscriberTax->getTaxById($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_id']);
								if($taxDetails){
									$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxName'] = $taxDetails['SbsSubscriberTax']['name'];
									$taxAmount = ($product * $taxDetails['SbsSubscriberTax']['percent'])/100;
									$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
									//$product = $product + ($product * $taxDetails['SbsSubscriberTax']['percent'])/100;
								}
							}
				}
				return $taxArray;
			}
		}
		
		public function addInvoiceDetail($data,$invoiceId){
			$add->data = null;
			$this->AcrInvoiceDetail->create();
			$add->data['AcrInvoiceDetail']['quantity']						=	$data['quantity'];
			$add->data['AcrInvoiceDetail']['inventory_description']			=	$data['inventory_description'];
			$add->data['AcrInvoiceDetail']['inv_inventory_id']				=	$data['inv_inventory_id'];
			$add->data['AcrInvoiceDetail']['unit_rate']						=	$data['unit_rate'];
			$add->data['AcrInvoiceDetail']['discount_percent']				=	$data['discount_percent'];
			$add->data['AcrInvoiceDetail']['line_total']					=	$data['line_total'];
			$add->data['AcrInvoiceDetail']['acr_client_invoice_id']			=	$invoiceId;
			$add->data['AcrInvoiceDetail']['sbs_subscriber_tax_id']			=	$data['sbs_subscriber_tax_id'];
			$add->data['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']	=	$data['sbs_subscriber_tax_group_id'];
			if($this->AcrInvoiceDetail->save($add->data)){
				return $this->AcrInvoiceDetail->getLastInsertId();
			}else{
				return false;
			}
		}
		
		
		
		public function getInvoiceNumber($subscriberId = null) {
	    $this->loadModel('SbsSubscriberSetting');
        $this->loadModel('AcrClientInvoice');
		$settings			= $this->SbsSubscriberSetting->defaultSettings($subscriberId);
		$quoteFormat 		= $settings['SbsSubscriberSetting']['invoice_number_prefix'];
		if(empty($settings['SbsSubscriberSetting']['invoice_number_prefix'])) $quoteFormat = 'INV-';
		$quoteInitalNumber = $settings['SbsSubscriberSetting']['invoice_sequence_number'];
		if(empty($quoteInitalNumber)) $quoteInitalNumber = '0001';
		$lastQuote 			= $this->AcrClientInvoice->find('first',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId,'AcrClientInvoice.invoice_number LIKE'=>$quoteFormat.'%'),'fields'=>array('invoice_number'),'order'=>array('invoice_number'=>'Desc')));
		preg_match_all('!\d+!', $lastQuote['AcrClientInvoice']['invoice_number'], $final);
		$fTotalQuote 		= $this->AcrClientInvoice->find('count',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId,'AcrClientInvoice.invoice_number LIKE'=>$quoteFormat.'%')));
		if($fTotalQuote == 0) {
			$newQuoteNumber	     = $quoteFormat.$quoteInitalNumber;
		} else {
			$totalQuote 		= $final[0][0];
			do {
				$totalQuote++;
				$digitsCount = strlen($final[0][0]);
				$formattedNumber     = sprintf('%0'.$digitsCount.'d', $totalQuote);
				$newQuoteNumber	     = $quoteFormat.$formattedNumber;
				$quoteExist = $this->AcrClientInvoice->find('first',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId,'AcrClientInvoice.invoice_number'=>$newQuoteNumber),'fields'=>array('id')));
			} while (!empty($quoteExist));
		}
		return $newQuoteNumber;
	}
		
		
		public function getTotalInvoice($subscriberId = null){
			if($subscriberId){
				$invoiceCount = $this->AcrClientInvoice->find('count',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId)));
				if($invoiceCount){
					return $invoiceCount;
				}else{
					return '0';
				}
			}else{
				return false;
			}
		}
		public function findEndDate($invoiced_date = null,$termId = null){
			if($invoiced_date && $termId){
				$getPaymentTermDetail = $this->getTermsById($termId);
				if($getPaymentTermDetail){
					$dueDate = date('Y-m-d', strtotime($invoiced_date. ' + '.$getPaymentTermDetail.' days'));
					return $dueDate;
				}
			}
		}
		public function getTermsById($termId = null){
			$paymentTerms=$this->SbsSubscriberPaymentTerm->find('first',array('conditions'=>array('SbsSubscriberPaymentTerm.id'=>$termId),'fields'=>array('SbsSubscriberPaymentTerm.id','SbsSubscriberPaymentTerm.no_of_days')));
		    if($paymentTerms){
		    	return $paymentTerms['SbsSubscriberPaymentTerm']['no_of_days'];
		    }else{
		    	return false;
		    }
		    
		}
		public function getInvoiceStatus($subscriberId = null){
			$getStatus = $this->SbsSubscriberSetting->find('first',array('conditions'=>array('SbsSubscriberSetting.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SbsSubscriberSetting.recurring_status')));
			if($getStatus){
				return $getStatus['SbsSubscriberSetting']['recurring_status'];
			}else{
				return "Draft";
			}
		}
		public function updateStock($inventoryId = null,$quantity = null){
			if($inventoryId){
				$getInventoryDetail = $this->getInventory($inventoryId);
				if(($getInventoryDetail['InvInventory']['track_quantity'] == 'Y') && ($getInventoryDetail['InvInventory']['current_stock']>0)){
					$save->data = null;
					$save->data['InvInventory']['id'] = $inventoryId;
					$save->data['InvInventory']['current_stock'] = $getInventoryDetail['InvInventory']['current_stock'] - $quantity;
					$save->data['InvInventory']['track_quantity'] = "Y";
					if($this->InvInventory->save($save->data)){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}
			
		}
		public function getInventory($inventoryId = null){
			if($inventoryId){
				$inventory = $this->InvInventory->find('first',array('conditions'=>array('InvInventory.id'=>$inventoryId)));
				return $inventory;
			}
		}
		public function getFieldList($subscriberId){
			if($subscriberId){
				$fieldList = $this->AcrInvoiceCustomField->find('list',array('conditions'=>array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrInvoiceCustomField.id','AcrInvoiceCustomField.field_name')));
				return $fieldList;
			}
		}
		public function pdfGen($invoiceId = null){
			if($invoiceId){
				$saveArray->data = null;
				$saveArray->data['AcrClientInvoice']['id'] = $invoiceId;
				$saveArray->data['AcrClientInvoice']['pdf_generated'] = 'Yes';
				if($this->AcrClientInvoice->save($saveArray->data)){
					return true;
				}else{
					return false;
				}
			}
			
		}
		public function getInvoicePaymentDetails($invoiceId = null,$subscriberId = null){
			if($invoiceId){
				$this->loadModel('AcrInvoicePaymentDetail');
				$this->AcrInvoicePaymentDetail->recursive = 0;
				$this->AcrInvoicePaymentDetail->unbindModel(array('belongsTo'=>array('AcrClient','SbsSubscriber')));		
				$getPaymentForInvoice = $this->AcrInvoicePaymentDetail->find('all',array('conditions'=>array('AcrInvoicePaymentDetail.acr_client_invoice_id'=>$invoiceId, 'AcrInvoicePaymentDetail.sbs_subscriber_id'=>$subscriberId, 'AcrInvoicePaymentDetail.is_deleted'=>'no'),'fields'=>array('CpnPaymentMethod.payment_option_name'
									,'AcrInvoicePaymentDetail.payment_date','AcrInvoicePaymentDetail.reference_no','AcrInvoicePaymentDetail.notes','AcrClientInvoice.invoice_number','AcrClientInvoice.status'
									,'AcrClientInvoice.invoice_total','AcrClientInvoice.invoice_currency_code','CpnPaymentMethod.payment_option_name','AcrInvoicePaymentDetail.paid_amount')));
				foreach($getPaymentForInvoice as $index=>$paymentDetails){
					$paidAmount = $paidAmount + $paymentDetails['AcrInvoicePaymentDetail']['paid_amount'];
				}
				return $paidAmount;
			}
			
		}
		private function generatePaypalLink ($amount = null, $currency = null, $invoice_no = null ) {
				
			$businessEmail     = $this->getPaymentOptionDetails('PayPal');
			//$businessEmail     = "venugopal@carmatec.com";
			if($amount && $currency && $invoice_no && $businessEmail) {
				$url           = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick';
				$link 		   = $url."&business=$businessEmail&currency_code=$currency&amount=$amount&item_name=invoice&invoice=$invoice_no";
			}
			return $link;
		}
		
	} 
?>