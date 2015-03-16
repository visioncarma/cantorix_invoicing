<?php
App::uses('CakeNumber', 'Utility');
App::uses('CakeEmail', 'Network/Email');
class PaymentReminderShell extends AppShell {
	var $uses = array('SbsSubscriber','SbsSubscriberSetting','SbsEmailTemplateDetail','AcrClientInvoice','AcrInvoicePaymentDetail','AcrClientContact','AcrInvoiceDetail','SbsSubscriberOrganizationDetail','SbsSubscriberTaxGroupMapping','SbsSubscriberTax','AcrInvoicePaymentDetail','CpnPaymentMethod','CpnPaymentMethodAttribute','SbsPaymentMethodValue');
	//public $components = array('RequestHandler','Session','Email');
	public function main(){
		$Email = new CakeEmail();
		$getAllActiveSubsciber = $this->getActiveSubscribers();
		$hostName = "https://www.cantorix.com";
		foreach($getAllActiveSubsciber as $subscriberId=>$subscriberName){
			$getMailTemplate = $this->getSubscriberMailTemplate($subscriberId);
			$organisationDetails	=	$this->organisationDetails($subscriberId);
			$subscriberSettings = $this->getSubscriberSettings($subscriberId);
			$dateFormat	=	$subscriberSettings['SbsSubscriberSetting']['date_format'];
			$logo		=	$subscriberSettings['SbsSubscriberSetting']['invoice_logo'];
			
			$getAllInvoices = $this->getAllInvoices($subscriberId,$subscriberSettings['SbsSubscriberSetting']['late_payment_reminder_days']);
			if($getAllInvoices && $getMailTemplate){
				foreach($getAllInvoices as $getAllInvoice){
					debug($getAllInvoice);
					$invoiceDetail = $this->getInvoiceDetail($getAllInvoice['AcrClientInvoice']['id']);
					$taxArray  = $this->getTaxCalculation($invoiceDetail);
					$paidAmount = $this->getInvoicePaymentDetails($getAllInvoice['AcrClientInvoice']['id'],$subscriberId);
					if(!$paidAmount){
						$paidAmount = 0;
					}
					$balanceDue = $getAllInvoice['AcrClientInvoice']['invoice_total'] - $paidAmount;
					$payPalLink = $this->generatePaypalLink($getAllInvoice['AcrClientInvoice']['invoice_total'],$getAllInvoice['AcrClientInvoice']['invoice_currency_code'],$getAllInvoice['AcrClientInvoice']['invoice_number'],$subscriberId);
					if($getMailTemplate){
						$getClientContact  = $this->AcrClientContact->getClientPrimaryContactDetail($getAllInvoice['AcrClientInvoice']['acr_client_id']);
						$invoiceCopyPath   = APP."webroot/files/uploads/invoice/Subscriber-".$subscriberId.'/'.$getAllInvoice['AcrClientInvoice']['invoice_number'].'.pdf';	
						
						
						$from = $getMailTemplate['SbsEmailTemplateDetail']['from_email_address'];
						$to	  = $getClientContact['AcrClientContact']['email'];
						
						$subject = $this->getBodyContent($getMailTemplate['SbsEmailTemplateDetail']['subject'],$getAllInvoice['AcrClientInvoice']['id']);
						$content = $this->getBodyContent($getMailTemplate['SbsEmailTemplateDetail']['body_content'],$getAllInvoice['AcrClientInvoice']['id']);
						if(file_exists($invoiceCopyPath)){
       						$Email->attachments("$invoiceCopyPath");
						}
						if($getAllInvoice['AcrClientInvoice']['email_format'] == "sent_invoice_service_classic"){
							$template = 'payment_reminder_service_classic';
						}elseif($getAllInvoice['AcrClientInvoice']['email_format'] == "sent_invoice_service_modern"){
							$template = 'payment_reminder_service_modern';
						}elseif($getAllInvoice['AcrClientInvoice']['email_format'] == "sent_invoice_modern"){
							$template = 'payment_reminder_product_modern';
						}else{
							$template = 'payment_reminder';
						}
						debug($logo);
						$Email->to($to);
						$Email->subject($subject);
						$Email->replyTo($from);
						$Email->from($from);
						$Email->template("$template");
						$Email->emailFormat('html');
						$Email->viewVars(array('content' => $content,'clientName'=>$getClientContact['AcrClientContact']['name'].' '.$getClientContact['AcrClientContact']['sur_name'],'sign'=>$subscriberSettings['SbsSubscriberSetting']['email_signature'],'invoiceData'=>$getAllInvoice,'invoiceDetail'=>$invoiceDetail,'dateFormat'=>$dateFormat,'logo'=>$logo,'organisationDetails'=>$organisationDetails,'taxArray'=>$taxArray,'paidAmount'=>$paidAmount,'balanceDue'=>$balanceDue,'hostName'=>$hostName,'payPalLink'=>$payPalLink));
						$Email->send();
						
					}
				}
			}
		}
	}
	public function getActiveSubscribers(){
		$activeSubscriberList = $this->SbsSubscriber->find('list',array('conditions'=>array('OR'=>array(array('SbsSubscriber.status'=>'Active'),array('SbsSubscriber.status'=>'pending'))),'fields'=>array('SbsSubscriber.id','SbsSubscriber.name')));
		if($activeSubscriberList){
			return $activeSubscriberList;
		}else{
			return false;
		}
	}
	public function getSubscriberSettings($subscriberId = null){
		if($subscriberId){
			$getSubscriberSetting = $this->SbsSubscriberSetting->find('first',array('conditions'=>array('SbsSubscriberSetting.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SbsSubscriberSetting.date_format','SbsSubscriberSetting.cpn_currency_id','SbsSubscriberSetting.late_payment_reminder_days','SbsSubscriberSetting.invoice_logo','SbsSubscriberSetting.email_signature')));
			if($getSubscriberSetting){
				return $getSubscriberSetting;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	public function organisationDetails($subscriberId = null){
		if($subscriberId){
			$subscriberInfo			=	$this->SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=> $subscriberId)));
			$organisationDetails	=	$this->SbsSubscriberOrganizationDetail->find('first',array('conditions'=>array('SbsSubscriberOrganizationDetail.id'=>$subscriberInfo['SbsSubscriber']['sbs_subscriber_organization_detail_id'])));
			return $organisationDetails;
		}else{
			return false;
		}
	}
	public function getSubscriberMailTemplate($subscriberId = null){
		if($subscriberId){
			$getReminderMailTemplate = $this->SbsEmailTemplateDetail->find('first',array('conditions'=>array('SbsEmailTemplateDetail.sbs_subscriber_id'=>$subscriberId,'SbsEmailTemplateDetail.module_related'=>'Payment Reminder','SbsEmailTemplateDetail.status'=>'Configured')));
			if($getReminderMailTemplate){
				return $getReminderMailTemplate;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	public function getAllInvoices($subscriberId = null,$lateReminderDay = null){
		if($subscriberId){
			$this->AcrClientInvoice->recursive = 0;
			$getAllInvoices = $this->AcrClientInvoice->find('all',array(
								'conditions'=>array(
									'OR'=>array(
											array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId,'AcrClientInvoice.status'=>'Sent','AcrClientInvoice.due_date <='=>date('Y-m-d', strtotime('-'.$lateReminderDay .' days'))),
											array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId,'AcrClientInvoice.status'=>'Open','AcrClientInvoice.due_date <='=>date('Y-m-d', strtotime('-'.$lateReminderDay .' days')))
									   )
								  )
								  )
							   );
		}else{
			return false;
		}
		return $getAllInvoices;
	}
	
	public function getInvoiceDetail($invoiceId){
		$this->AcrInvoiceDetail->recursive = 0;
		$invoiceDetail = $this->AcrInvoiceDetail->find('all',array('conditions'=>array('AcrInvoiceDetail.acr_client_invoice_id'=>$invoiceId)));
		return $invoiceDetail;
	}
	public function getBodyContent($bodyContent = null,$invoiceId = null){
		if($bodyContent){
			$this->AcrClientInvoice->recursive = 0;
			$invoiceData = $this->AcrClientInvoice->find('first',array('conditions'=>array('AcrClientInvoice.id'=>$invoiceId)));
			$total_paid_amount = $this->AcrInvoicePaymentDetail->find('first',array('conditions'=>array('AcrInvoicePaymentDetail.acr_client_invoice_id'=>$invoiceId, 'AcrInvoicePaymentDetail.is_deleted'=>'no'),'fields'=>array('sum(AcrInvoicePaymentDetail.paid_amount) as total_sum')));
			$invoicePayment = $total_paid_amount;
			if($invoicePayment){
				$balanceAmount = $invoiceData['AcrClientInvoice']['invoice_total'] - $invoicePayment['0']['total_sum'];
			}else{
				$balanceAmount = $invoiceData['AcrClientInvoice']['invoice_total'];
			}
			$getClientContact  = $this->AcrClientContact->getClientPrimaryContactDetail($invoiceData['AcrClientInvoice']['acr_client_id']);
			$swears = array(
						"[Balance]"  				=> CakeNumber::currency($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code']),
						"[Balance Due]"  			=> CakeNumber::currency($balanceAmount,$invoiceData['AcrClientInvoice']['invoice_currency_code']),
						"[Invoice Date]"  			=> $invoiceData['AcrClientInvoice']['invoiced_date'],
						"[Invoice No]"  			=> $invoiceData['AcrClientInvoice']['invoice_number'],
						"[PO Number]"  				=> $invoiceData['AcrClientInvoice']['purchase_order_no'],
						"[Invoice Description]" 	=> $invoiceData['AcrClientInvoice']['description'],
						"[Due Date]"  				=> $invoiceData['AcrClientInvoice']['due_date'],
						"[Invoice Amount]" 			=> CakeNumber::currency($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code']),
						"[Organization Name]"  		=> $invoiceData['AcrClient']['organization_name'],
						"[Organization Website]"	=> $invoiceData['AcrClient']['website'],
						"[Business Phone]"  		=> $invoiceData['AcrClient']['business_phone'],
						"[Business Fax]"  			=> $invoiceData['AcrClient']['business_fax'],
						"[Primary Contact Name]"	=> $getClientContact['AcrClientContact']['name'],
						"[Primary Contact Surname]"	=> $getClientContact['AcrClientContact']['sur_name']
						);
						$content = str_replace(array_keys($swears), array_values($swears), $bodyContent);
			return $content;
		}else{
			$content = $bodyContent;
			return $content;
		}
	}
	
	public function getTaxCalculation($invoiceDetail = null){
			
		if($invoiceDetail){
			$this->SbsSubscriberTaxGroupMapping->recursive = 0;
			foreach($invoiceDetail as $key=>$invoiceDetailValue){
				if($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']){
							$this->loadModel('SbsSubscriberTaxGroupMapping');
							/*$groupTaxMap = $this->SbsSubscriberTaxGroupMapping->getGroupMapping($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']);*/
							$groupTaxMap = $this->SbsSubscriberTaxGroupMapping->find('all',array('conditions'=>array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_group_id'=>$invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']),'order'=>array('SbsSubscriberTaxGroupMapping.priority Asc')));
							$product = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];
							$lineTotal = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];
							foreach($groupTaxMap as $key=>$val1){
								$taxArray[$val1['SbsSubscriberTax']['id']]['taxName'] = $val1['SbsSubscriberTax']['code'].'(@'.$val1['SbsSubscriberTax']['percent'].'%)';
								if($val1['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y'){
									debug($product);
									$taxAmount = ($product*$val1['SbsSubscriberTax']['percent'])/100;
									$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
									$product = $product + $taxAmount;
								}else{
									/*$product = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];*/
									$taxAmount = ($lineTotal * $val1['SbsSubscriberTax']['percent'])/100;
									$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
									//$product = $lineTotal + $taxAmount;
									debug($product);
									debug($taxAmount);
									$product = $product + $taxAmount;
									debug($product);
								}
							}
						}elseif($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_id']){
							$this->loadModel('SbsSubscriberTax');
							$product = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];
							/*$taxDetails = $this->SbsSubscriberTax->getTaxById($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_id']);*/
							$taxDetails = $this->SbsSubscriberTax->find('first',array('conditions'=>array('SbsSubscriberTax.id'=>$invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_id'])));
							if($taxDetails){
								$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxName'] = $taxDetails['SbsSubscriberTax']['code'].'(@'.$taxDetails['SbsSubscriberTax']['percent'].'%)';
								$taxAmount = ($product * $taxDetails['SbsSubscriberTax']['percent'])/100;
								$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
								//$product = $product + ($product * $taxDetails['SbsSubscriberTax']['percent'])/100;
							}
						}
			}

			return $taxArray;
		}
	}

	public function getInvoicePaymentDetails($invoiceId = null,$subscriberId = null){
		if($invoiceId){
			$this->loadModel('AcrInvoicePaymentDetail');
			$paidAmount = null;
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

	// create paypal link
	private function generatePaypalLink ($amount = null, $currency = null, $invoice_no = null,$subscriberId = null ) {
		
		$host		 = "http://192.168.0.165/";
		$root       =  WWW_ROOT; 
		$notify_url = "http://$host".WWW_ROOT.'sbs_ipn_listener.php';
		$custom		=  $subscriberId;
		$amount		=  money_format('%!(.2n',$amount);
		$businessEmail     = $this->payment_gateway_email($subscriberId);
		//$businessEmail       = "venugopal-facilitator@carmatec.com ";		
		if($amount && $currency && $invoice_no && $businessEmail) {
			$url           = 'https://www.paypal.com/cgi-bin/webscr?cmd=_xclick';
			
			$link 		   = $url."&business=$businessEmail&currency_code=$currency&amount=$amount&item_name=invoice&invoice=$invoice_no&custom=$custom&notify_url=$notify_url";
		}
		return $link;
	}

	public function payment_gateway_email($subscriberId = null){
			 
			
			
			$method = $this->CpnPaymentMethod->find('first',array('conditions'=>array('CpnPaymentMethod.payment_option_name'=>'Paypal'),'fields'=>array('id')));
			$methodAttribute = $this->CpnPaymentMethodAttribute->find('first',array('conditions'=>array('CpnPaymentMethodAttribute.cpn_payment_method_id'=>$method['CpnPaymentMethod']['id'],'CpnPaymentMethodAttribute.attribute'=>'PayPal Email'),'fields'=>array('id')));
			$methodValues    = $this->SbsPaymentMethodValue->find('first',array('conditions'=>array('SbsPaymentMethodValue.cpn_payment_method_id'=>$method['CpnPaymentMethod']['id'],'SbsPaymentMethodValue.subscriber_id'=>$subscriberId,'SbsPaymentMethodValue.cpn_payment_attribute_id'=>$methodAttribute['CpnPaymentMethodAttribute']['id']),'fields'=>array('SbsPaymentMethodValue.value')));
			if($methodValues['SbsPaymentMethodValue']['value']){
				return $methodValues['SbsPaymentMethodValue']['value'];
			}else{
				return false;
			}
			
		}
} 
?>
