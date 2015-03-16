<?php
App::uses('AppController', 'Controller');
class CreditNotesController extends AppController {
    /**
     * @uses uses variable contains models array required for this controller
     * */
    public $uses = array('AcrClientCreditnote', 'AcrClientInvoice', 'AcrClient', 'CpnCurrency', 'SbsSubscriberSetting', 'InvInventory');
    public $components = array('RequestHandler');

    /**
     * @method method calls before executing any of the methods in this controller
     * */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = "sbs_layout";
        $this->permission = $this->Session->read('Auth.AllPermissions.Manage Credits');
        $this->subscriber = $this->Session->read('Auth.User.SbsSubscriber.id');
        $invoicesActive = 'active';
        $this->set(compact('invoicesActive'));
    }

    /**
     * @author Ganesh
     * @method List page for credit notes
     * @param  Filter parameters
     * */
    public function index($customerName = 0, $creditNo = 0, $status = 0, $min = 0, $max = 0, $from = 0, $to = 0) {
        
        $permission = $this->permission;
        if ($this->permission['_read'] != 1) {
            $this->redirect(array('controller' => 'users', 'action' => 'noaccess'));
        }
        $menuActive = 'Manage Credits';
        $this->set(compact('menuActive', 'permission'));
        $this->AcrClientCreditnote->recursive = 0;
        $this->AcrClientCreditnote->unbindModel(array('belongsTo' => array('AcrClientInvoice', 'AcrInvoicePaymentDetail', 'SbsSubscriber')));
        $fields = array('AcrClientCreditnote.id', 'AcrClientCreditnote.credit_no', 'AcrClientCreditnote.acr_client_invoice_id', 'AcrClientCreditnote.reference_no', 'AcrClientCreditnote.status', 'AcrClientCreditnote.date_created', 'AcrClient.organization_name', 'AcrClientCreditnote.amount', 'AcrClientCreditnote.balance_amount', 'AcrClient.cpn_currency_id');
        $title_for_layout = 'Manage Credits';
        $settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
        $limit = $settings['SbsSubscriberSetting']['lines_per_page'];
        $subscriberCondition = array('AcrClientCreditnote.sbs_subscriber_id' => $this->subscriber);
        /**Filter Section*/
        if ($customerName) { $this->request->data['Filter']['customerName'] = $customerName;
        }
        if ($creditNo) { $this->request->data['Filter']['creditNo'] = $creditNo;
        }
        if ($status) { $this->request->data['Filter']['status'] = $status;
        }
        if ($min) { $this->request->data['Filter']['minAmount'] = $min;
        }
        if ($max) { $this->request->data['Filter']['maxAmount'] = $max;
        }
        $from = $this->params->query['fromFilter'];
        if ($from) { $this->request->data['Filter']['from'] = $from;
        }
        $to = $this->params->query['toFilter'];
        if ($to) { $this->request->data['Filter']['to'] = $to;
        }
        if (!empty($this->data['Filter'])) {
            if (!empty($this->request->data['Filter']['customerName'])) { $customerName = trim($this->request->data['Filter']['customerName']);
            }
            if (!empty($this->request->data['Filter']['creditNo'])) { $creditNo = trim($this->request->data['Filter']['creditNo']);
            }
            if (!empty($this->request->data['Filter']['status'])) { $status = trim($this->request->data['Filter']['status']);
            }
            if (!empty($this->request->data['Filter']['minAmount'])) { $min = trim($this->request->data['Filter']['minAmount']);
            }
            if (!empty($this->request->data['Filter']['maxAmount'])) { $max = trim($this->request->data['Filter']['maxAmount']);
            }
            if (!empty($this->request->data['Filter']['from'])) { $from = trim($this->request->data['Filter']['from']);
            }
            if ($this->request->data['Filter']['to']) { $to = trim($this->request->data['Filter']['to']);
            }
            if (empty($customerName) && empty($creditNo) && empty($status) && empty($min) && empty($max) && empty($from) && empty($to)) {
                $this->Session->setFlash('<div class="alert alert-info">Please enter atleast one search term.</div>');
                $this->redirect(array('action' => 'index'));
            }
            if ($customerName) {
                $customerNameCondition = array('AcrClient.organization_name LIKE' => '%' . $customerName . '%');
            }
            if ($creditNo) {
                $creditNoCondition = array('AcrClientCreditnote.credit_no LIKE' => '%' . $creditNo . '%');
            }
            if ($status) {
                $statusCondition = array('AcrClientCreditnote.status' => $status);
            }
            if ($min && !$max) {
                $price_array = array('AcrClientCreditnote.amount >=' => $min);
            }
            if (!$min && $max) {
                $price_array = array('AcrClientCreditnote.amount <=' => $max);
            }
            if ($min && $max) {
                $price_array = array('AcrClientCreditnote.amount BETWEEN ? and ?' => array($min, $max));
            }
            if ($from && !$to) {
                $date_array = array('AcrClientCreditnote.date_created >=' => date('Y-m-d', strtotime(str_replace('/', '-', $from))));
            }
            if ($to && !$from) {
                $date_array = array('AcrClientCreditnote.date_created <=' => date('Y-m-d', strtotime(str_replace('/', '-', $to))));
            }
            if ($from && $to) {
                $date_array = array('AcrClientCreditnote.date_created BETWEEN ? and ?' => array(date('Y-m-d', strtotime(str_replace('/', '-', $from))), date('Y-m-d', strtotime(str_replace('/', '-', $to)))));
            }
        }
        /**End Filter Section*/
        $conditions = array($subscriberCondition, $customerNameCondition, $creditNoCondition, $statusCondition, $price_array, $date_array);
        $this->Paginator->settings = array('conditions' => $conditions, 'limit' => $limit, 'fields' => $fields, 'order' => array('AcrClientCreditnote.id' => 'Desc'));
        if ($this->Paginator->paginate('AcrClientCreditnote')) {
            $creditNotes = $this->Paginator->paginate('AcrClientCreditnote');
        }
        $currencyList = $this->CpnCurrency->find('list', array('fields' => array('id', 'code')));
        $this->set(compact('creditNotes', 'title_for_layout', 'permission', 'currencyList', 'settings', 'customerName', 'creditNo', 'status', 'min', 'max', 'from', 'to'));
    }

    public function add($apply = false, $invoiceIDDD = null, $customerIDParam = null, $customerName = 0, $creditNoFilter = 0, $status = 0, $min = 0, $max = 0, $from = 0, $to = 0, $page = 1) {
	  
        if ($invoiceIDDD)
		{
			$invoiceIDDD = base64_decode($invoiceIDDD);
		}
		 if ($customerIDParam)
		{
			$customerIDParam = base64_decode($customerIDParam);
		}
		
        $permission = $this->permission;
        if ($this->permission['_create'] != 1) {
            $this->redirect(array('controller' => 'users', 'action' => 'noaccess'));
        }
	    if($invoiceIDDD) {
            if (!$this->AcrClientInvoice->_checkFraud($invoiceIDDD)) {
                $this->redirect(array('controller' => 'users', 'action' => 'accessDenied'));
            }
        }
        $menuActive = 'Manage Credits';
        $title_for_layout = 'Add Credit Note';
        $this->set(compact('menuActive', 'permission', 'title_for_layout', 'apply', 'invoiceIDDD','customerIDParam'));
        $this->loadModel('SbsSubscriberCpnCurrencyMapping');
        $this->loadModel('SbsSubscriberPaymentTerm');
        $this->loadModel('InvInventoryUnitType');
        $creditNo = $this->AcrClientCreditnote->generateCreditNumber($this->subscriber);
        $settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
        $inventoryList = $this->InvInventory->getListOfInventory($this->subscriber);
        $customers = $this->AcrClient->getActiveCustomerList($this->subscriber);
        $defaultCurrency = $settings['SbsSubscriberSetting']['cpn_currency_id'];
        $defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
        $defaultCurrencyCode = $defaultCurrencyInfo['CpnCurrency']['code'];
        $subsCriberCurrency = $this->SbsSubscriberCpnCurrencyMapping->getCurrencyList($this->subscriber);
        $paymentTerm = $this->SbsSubscriberPaymentTerm->getPaymentTermsBySubscriber($this->subscriber);
        foreach ($subsCriberCurrency as $subkey => $subscriberCurrencyMap) {
            if ($subscriberCurrencyMap['CpnCurrency']['code']) {
                $currencyList[$subscriberCurrencyMap['CpnCurrency']['id']] = $subscriberCurrencyMap['CpnCurrency']['code'];
            }
        }
        $taxList = $this->taxTree();
        $unitTypeList = $this->InvInventoryUnitType->getUnitTypeList($this->subscriber);
        $subscriberID = $this->subscriber;
        $this->set(compact('unitTypeList', 'creditNo', 'customers', 'inventoryList', 'currencyList', 'defaultCurrency', 'paymentTerm', 'taxList', 'defaultCurrencyCode', 'customFields', 'settings'));
        $this->set(compact('customer', 'creditNoFilter', 'min', 'max', 'status', 'from', 'to', 'page', 'subscriberID'));
        if (!empty($this->data)) {
            $proceeddd = false;
            foreach ($this->data['AcrClientInvoice']['inventory'] as $key => $value) {
                if (!empty($value)) {
                    $proceeddd = true;
                }
            }
            if (!$proceeddd) {
                $this->Session->setFlash('<div class="alert alert-danger">No inventory selected for the credit note.</div>');
                return;
            }
            $addCredit = $this->AcrClientCreditnote->addCredit($this->subscriber, $this->data);
            $sentSuccess = false;
            if ($addCredit) {
                if ($this->data['quotation_status'] == 'Open') {
                    $sentSuccess = $this->sendEmailCreditNote($addCredit, $this->data);
                    if ($sentSuccess) {
                        $this->Session->setFlash(__('<div class="alert alert-block alert-success">Credit note has been sent.</div>'));
                    } else {
                        $this->Session->setFlash(__('<div class="alert alert-warning">Credit note has been saved and error occurred while sending an email.</div>'));
                    }
                } else {
                    $this->Session->setFlash('<div class="alert alert-success">Credit note has been created.</div>');
                }
                if ($apply && $invoiceIDDD) {
                    $filterAction   = $this->params->query['filterAction'];
                    $filterValue    = $this->params->query['filterValue'];
                    $filterValue1   = $this->params->query['filterValue1'];
                    $filterValue2   = $this->params->query['filterValue2'];
                    $isRecurring    = $this->params->query['isRecurring'];
                    $invoiceStatus  = $this->params->query['status'];
                    $fromDate       = $this->params->query['fromDate'];
                    $toDate         = $this->params->query['toDate'];
                    $page           = $this->params->query['page'];
                    $this->applyCreditFromInvoice($addCredit, $invoiceIDDD, $sentSuccess, $filterAction, $filterValue, $filterValue1, $filterValue2, $isRecurring, $invoiceStatus, $fromDate, $toDate, $page);
                }
                $this->redirect(array('action' => 'index'));
            } else {
                if ($this->data['AcrClientInvoice']['quotation_status'] == 'Open') {
                    $this->Session->setFlash('<div class="alert alert-danger">Credit note couldn\'t send.</div>');
                    return;
                } else {
                    $this->Session->setFlash('<div class="alert alert-danger">Error occurred. Credit note couldnot been created.</div>');
                    return;
                }
            }
            $this->redirect(array('action' => 'index'));
        }
        if($this->request->is('mobile')){
            $this->render('/CreditNotes/m_add');
        }
    }

    public function customerDetails($clientId = null) {
        if (!$clientId)
            $clientId = $this->data['AcrClientInvoice']['acr_client_id'];
        if ($clientId) {
            $this->loadModel('AcrClientContact');
            $clientInfo = $this->AcrClientContact->find('first', array('conditions' => array('AcrClientContact.acr_client_id' => $clientId, 'AcrClientContact.is_primary' => 'Y')));
            if (empty($clientInfo)) {
                $clientInfo = $this->AcrClientContact->find('first', array('conditions' => array('AcrClientContact.acr_client_id' => $clientId)));
            }
            if (!empty($clientInfo)) {
                $contactPersonName = $clientInfo['AcrClientContact']['name'];
                $contactSurName = $clientInfo['AcrClientContact']['sur_name'];
                $contactEmail = $clientInfo['AcrClientContact']['email'];
                $contactMobile = $clientInfo['AcrClientContact']['mobile'];
                $contactHomePhone = $clientInfo['AcrClientContact']['home_phone'];
                $contactWorkPhone = $clientInfo['AcrClientContact']['work_phone'];
                $this->set(compact('contactPersonName', 'contactEmail', 'contactMobile', 'contactHomePhone', 'contactWorkPhone', 'contactSurName'));
            }
            return $clientInfo;
        }
    }

    public function checkCreditNo($subscriberID = null, $creditID = null) {
        $this->autoRender = false;
        $creditNoteNumber = trim($this->data['AcrClientInvoice']['credit_no']);
        if (!$creditID) {
            $conditions = array('AcrClientCreditnote.credit_no' => $creditNoteNumber, 'AcrClientCreditnote.sbs_subscriber_id' => $subscriberID);
        } elseif ($creditID) {
            $conditions = array('NOT' => array('AcrClientCreditnote.id' => $creditID), 'AcrClientCreditnote.credit_no' => $creditNoteNumber, 'AcrClientCreditnote.sbs_subscriber_id' => $subscriberID);
        }
        $creditRecordExist = $this->AcrClientCreditnote->find('first', array('conditions' => $conditions));
        if (empty($creditRecordExist)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    public function customerCurrency($currencyList = null) {
        $this->loadModel('SbsSubscriberCpnCurrencyMapping');
        $currencyID = $this->AcrClient->findById($this->data['AcrClientInvoice']['acr_client_id'], array('cpn_currency_id'));
        $subsCriberCurrency = $this->SbsSubscriberCpnCurrencyMapping->getCurrencyList($this->subscriber);
        foreach ($subsCriberCurrency as $subkey => $subscriberCurrencyMap) {
            if ($subscriberCurrencyMap['CpnCurrency']['code']) {
                $currencyList[$subscriberCurrencyMap['CpnCurrency']['id']] = $subscriberCurrencyMap['CpnCurrency']['code'];
            }
        }
        $settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
        $defaultCurrency = $settings['SbsSubscriberSetting']['cpn_currency_id'];
        $defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
        $this->set(compact('currencyID', 'currencyList', 'defaultCurrency', 'defaultCurrencyInfo'));
    }

    public function preview() {
        $data = $this->data;
        $this->loadModel('SbsSubscriberOrganizationDetail');
        $this->loadModel('AcrClient');

        $this->loadModel('SbsSubscriberTax');
        $this->loadModel('SbsSubscriberSetting');
        $organisationDetails = $this->SbsSubscriberOrganizationDetail->findById($this->Session->read('Auth.User.SbsSubscriber.sbs_subscriber_organization_detail_id'), array('id', 'organization_name', 'billing_address_line1', 'billing_address_line2', 'billing_city', 'billing_state', 'billing_country', 'billing_zip', 'logo'));
        $customerDetails = $this->AcrClient->findById($this->data['AcrClientInvoice']['acr_client_id'], array('organization_name', 'client_name', 'billing_address_line1', 'billing_address_line2', 'billing_city', 'billing_state', 'billing_country', 'billing_zip'));
        $inventories = $this->InvInventory->getListOfInventory($this->subscriber);
        $taxes = $this->SbsSubscriberTax->getTaxesBySubscriber($this->subscriber);
		$settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
        $this->set(compact('data', 'organisationDetails', 'customerDetails', 'inventories', 'taxes', 'settings'));
    }

    public function preview_send($creditID=null) {
    	//configure::write('debug',2); 
    	//echo $creditID;
        $this->loadModel('AcrClient');
        $this->loadModel('InvInventory');
        $this->loadModel('SbsSubscriberTax');
        $this->loadModel('AcrClientContact');
        $this->loadModel('SbsSubscriberSetting');
		$this->loadModel('SbsEmailTemplateDetail');
		$this->loadModel('AcrClientCreditnoteProduct');
		$this->loadModel('SbsSubscriberOrganizationDetail');
		
		$this->AcrClientCreditnote->recursive = 0;
        $this->AcrClientCreditnote->unbindModel(array('SbsSubscriber', 'AcrInvoicePaymentDetail', 'AcrClientInvoice'));
        $creditNote = $this->AcrClientCreditnote->find('first', array('conditions' => array('AcrClientCreditnote.id' => $creditID), 'fields' => array('AcrClientCreditnote.*', 'AcrClient.organization_name', 'AcrClient.client_name', 'AcrClient.billing_address_line1', 'AcrClient.billing_address_line2', 'AcrClient.billing_city', 'AcrClient.billing_state', 'AcrClient.billing_country', 'AcrClient.billing_zip')));
        $productDetails = $this->AcrClientCreditnoteProduct->find('all', array('conditions' => array('AcrClientCreditnoteProduct.acr_client_creditnote_id' => $creditID)));
        $defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
        foreach($productDetails as $key => $value) {
            $InvoiceArray[$key]['AcrInvoiceDetail'] = $value['AcrClientCreditnoteProduct'];
        }
        $taxes = $this->getTaxCalculation($InvoiceArray);
		$settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
        $signature = $settings['SbsSubscriberSetting']['email_signature'];
        $template = $this->data['MailTemplate']['template'];
        $inventories = $this->InvInventory->getListOfInventory($this->subscriber);
		$organisationDetails = $this->SbsSubscriberOrganizationDetail->findById($this->Session->read('Auth.User.SbsSubscriber.sbs_subscriber_organization_detail_id'), array('id', 'organization_name', 'billing_address_line1', 'billing_address_line2', 'billing_city', 'billing_state', 'billing_country', 'billing_zip', 'logo'));
		
        $this->set(compact('content', 'signature','organisationDetails','inventories','productDetails', 'creditNote', 'defaultCurrencyInfo', 'settings', 'taxes'));
			
        

        
    }

    public function NewSendEmailCreditNote($creditID = null,$customerName = 0, $creditNo = 0, $status = 0, $min = 0, $max = 0, $page = 1) {
       
		$this->loadModel('AcrClient');
        $this->loadModel('InvInventory');
        $this->loadModel('SbsSubscriberTax');
        $this->loadModel('AcrClientContact');
        $this->loadModel('SbsSubscriberSetting');
		$this->loadModel('SbsEmailTemplateDetail');
		$this->loadModel('AcrClientCreditnoteProduct');
		$this->loadModel('SbsSubscriberOrganizationDetail');
		
		$this->AcrClientCreditnote->recursive = 0;
        $this->AcrClientCreditnote->unbindModel(array('SbsSubscriber', 'AcrInvoicePaymentDetail', 'AcrClientInvoice'));
        $creditNote = $this->AcrClientCreditnote->find('first', array('conditions' => array('AcrClientCreditnote.id' => $creditID), 'fields' => array('AcrClientCreditnote.*', 'AcrClient.organization_name', 'AcrClient.client_name', 'AcrClient.billing_address_line1', 'AcrClient.billing_address_line2', 'AcrClient.billing_city', 'AcrClient.billing_state', 'AcrClient.billing_country', 'AcrClient.billing_zip')));
        $productDetails = $this->AcrClientCreditnoteProduct->find('all', array('conditions' => array('AcrClientCreditnoteProduct.acr_client_creditnote_id' => $creditID)));
        $defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
        foreach($productDetails as $key => $value) {
            $InvoiceArray[$key]['AcrInvoiceDetail'] = $value['AcrClientCreditnoteProduct'];
        }
        $taxes = $this->getTaxCalculation($InvoiceArray);
		
		
        $getEmailTemplateDetail = $this->SbsEmailTemplateDetail->find('first', array('conditions' => array('SbsEmailTemplateDetail.module_related' => 'Credit', 'SbsEmailTemplateDetail.sbs_subscriber_id' => $this->subscriber)));
        $settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
        $signature = $settings['SbsSubscriberSetting']['email_signature'];
        $template = $this->data['MailTemplate']['template'];
        $emailDetails = $this->AcrClientContact->getClientPrimaryContactDetail($creditNote['AcrClientCreditnote']['acr_client_id']);
        $inventories = $this->InvInventory->getListOfInventory($this->subscriber);
		$organisationDetails = $this->SbsSubscriberOrganizationDetail->findById($this->Session->read('Auth.User.SbsSubscriber.sbs_subscriber_organization_detail_id'), array('id', 'organization_name', 'billing_address_line1', 'billing_address_line2', 'billing_city', 'billing_state', 'billing_country', 'billing_zip', 'logo'));
		
        $filePath = $_SERVER['DOCUMENT_ROOT'] . $this->webroot . "app/webroot/files/uploads/credits/Subscriber-" . $this->subscriber . '/';
        $this->new_generatePdf($template, $creditID);
        $file = $creditNote['AcrClientCreditnote']['credit_no'] . '.pdf';
        
		if($getEmailTemplateDetail) {
        	
            $subject = $this->getBodyContent($getEmailTemplateDetail['SbsEmailTemplateDetail']['subject'], 'Credits', $creditID);
            $from = $getEmailTemplateDetail['SbsEmailTemplateDetail']['from_email_address'];
            $bodyContent = $getEmailTemplateDetail['SbsEmailTemplateDetail']['body_content'];
            $content = $this->getBodyContent($bodyContent, 'Credits', $creditID);
            $this->set(compact('content', 'signature','organisationDetails','inventories','productDetails', 'creditNote', 'defaultCurrencyInfo', 'settings', 'taxes'));
			
        }

        $this->set(compact('data', 'organisationDetails', 'customerDetails', 'inventories', 'taxes'));
        $this->Email->filePaths = array($filePath);
        $this->Email->attachments = array($file);
        $EMAILfrom = $this->EMAIL_FROM;
        $this->Email->to = $emailDetails['AcrClientContact']['email'];
        $this->Email->subject = $subject;
        $this->Email->replyTo = $from;
        $this->Email->from = $from;
        $this->Email->template = $template;
        $this->Email->sendAs = 'html';
        if($this->Email->send()) {
            $this->Session->setFlash(__('<div class="alert alert-block alert-success">Credit note has been sent.</div>'));
			$this->redirect(array('action' => 'index', $customerName, $creditNo, $status, $min, $max, '?'=>array('fromFilter' => $from, 'toFilter' => $to), 'page:' . $page));
                    
        }
    }

    public function sendEmailCreditNote($creditID = null, $data = null) {
        $data = $this->data;
        $this->loadModel('SbsSubscriberOrganizationDetail');
        $this->loadModel('AcrClient');
        $this->loadModel('InvInventory');
        $this->loadModel('SbsSubscriberTax');
        $this->loadModel('AcrClientContact');
        $this->loadModel('SbsEmailTemplateDetail');
        $this->loadModel('SbsSubscriberSetting');
        $getEmailTemplateDetail = $this->SbsEmailTemplateDetail->find('first', array('conditions' => array('SbsEmailTemplateDetail.module_related' => 'Credit', 'SbsEmailTemplateDetail.sbs_subscriber_id' => $this->subscriber)));
        $settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
        $signature = $settings['SbsSubscriberSetting']['email_signature'];
        $template = $data['AcrClientInvoice']['email_template'];
        $organisationDetails = $this->SbsSubscriberOrganizationDetail->findById($this->Session->read('Auth.User.SbsSubscriber.sbs_subscriber_organization_detail_id'), array('id', 'organization_name', 'billing_address_line1', 'billing_address_line2', 'billing_city', 'billing_state', 'billing_country', 'billing_zip', 'logo'));
        $customerDetails = $this->AcrClient->findById($this->data['AcrClientInvoice']['acr_client_id'], array('client_name', 'organization_name', 'billing_address_line1', 'billing_address_line2', 'billing_city', 'billing_state', 'billing_country', 'billing_zip'));
        $emailDetails = $this->AcrClientContact->getClientPrimaryContactDetail($data['AcrClientInvoice']['acr_client_id']);
        $inventories = $this->InvInventory->getListOfInventory($this->subscriber);
        $taxes = $this->SbsSubscriberTax->getTaxesBySubscriber($this->subscriber);
        $taxesByPercent = $this->SbsSubscriberTax->getTaxesPercentBySubscriber($this->subscriber);
        
        $filePath = $_SERVER['DOCUMENT_ROOT'] . $this->webroot . "app/webroot/files/uploads/credits/Subscriber-" . $this->subscriber . '/';
        $this->generatePdf($template, $creditID);
        $file = $data['AcrClientInvoice']['credit_no'] . '.pdf';

        if ($getEmailTemplateDetail) {
            $subject = $this->getBodyContent($getEmailTemplateDetail['SbsEmailTemplateDetail']['subject'], 'Credits', $creditID);
            $from = $getEmailTemplateDetail['SbsEmailTemplateDetail']['from_email_address'];
            $bodyContent = $getEmailTemplateDetail['SbsEmailTemplateDetail']['body_content'];
            $content = $this->getBodyContent($bodyContent, 'Credits', $creditID);
            $this->set(compact('content', 'signature'));
        }

        $this->set(compact('data', 'organisationDetails', 'customerDetails', 'inventories', 'taxes','taxesByPercent'));
        $this->Email->filePaths = array($filePath);
        $this->Email->attachments = array($file);
        $EMAILfrom = $this->EMAIL_FROM;
        $this->Email->to = $emailDetails['AcrClientContact']['email'];
        $this->Email->subject = $subject;
        $this->Email->replyTo = $from;
        $this->Email->from = $from;
        $this->Email->template = $template;
        $this->Email->sendAs = 'html';
        if ($this->Email->send()) {
            return 'Open';
        } else {
            return 'Draft';
        }
    }

    public function new_generatePdf($template = null, $id = null) {
        try {
            $dir = $_SERVER['DOCUMENT_ROOT'] . $this->webroot . "app/webroot/files/uploads/credits/Subscriber-" . $this->subscriber . "/";
            $createDir = "files/uploads/credits/Subscriber-" . $this->subscriber . "/";
            if (!file_exists($dir) && !is_dir($dir)) {
                $tmp = $_SERVER['DOCUMENT_ROOT'] . $this->webroot . "app/webroot/files/uploads/credits/";
                if (!file_exists($tmp) && !is_dir($tmp)) {
                    mkdir($tmp);
                    chmod($tmp, 0755);
                }
                mkdir($dir);
                chmod($dir, 0755);
            }
            $this->set('subscriberID', $this->subscriber);
            $this->loadModel('SbsSubscriberOrganizationDetail');
            $this->loadModel('SbsSubscriberSetting');
            $this->loadModel('CpnCurrency');
            $this->loadModel('AcrClientCreditnoteProduct');
            $this->AcrClientCreditnote->recursive = 0;
            $this->AcrClientCreditnote->unbindModel(array('belongsTo' => array('SbsSubscriber', 'AcrClientInvoice', 'AcrInvoicePaymentDetail')));
            $credit = $this->AcrClientCreditnote->findById($id, array('AcrClientCreditnote.*', 'AcrClient.id', 'AcrClient.client_no', 'AcrClient.client_name', 'AcrClient.organization_name', 'AcrClient.billing_address_line1', 'AcrClient.billing_address_line2', 'AcrClient.billing_city', 'AcrClient.billing_state', 'AcrClient.billing_country', 'AcrClient.billing_zip'));
            $organisationDetails = $this->SbsSubscriberOrganizationDetail->findById($this->Session->read('Auth.User.SbsSubscriber.sbs_subscriber_organization_detail_id'), array('id', 'organization_name', 'billing_address_line1', 'billing_address_line2', 'billing_city', 'billing_state', 'billing_country', 'billing_zip', 'logo'));
            $settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
            $this->AcrClientCreditnoteProduct->recursive = 0;
            $this->AcrClientCreditnoteProduct->unbindModel(array('belongsTo' => array('AcrClientCreditnote')));
            $this->AcrClientCreditnoteProduct->bindModel(array('belongsTo' => array('InvInventory', 'SbsSubscriberTax', 'SbsSubscriberTaxGroup')));
            $creditProducts = $this->AcrClientCreditnoteProduct->find('all', array('conditions' => array('AcrClientCreditnoteProduct.acr_client_creditnote_id' => $credit['AcrClientCreditnote']['id']), 'fields' => array('AcrClientCreditnoteProduct.*', 'InvInventory.name', 'InvInventory.description', 'InvInventory.list_price', 'SbsSubscriberTax.id', 'SbsSubscriberTaxGroup.id')));
            $defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
            foreach ($creditProducts as $key => $value) {
                $InvoiceArray[$key]['AcrInvoiceDetail'] = $value['AcrClientCreditnoteProduct'];
            }
            $taxCalcuations = $this->getTaxCalculation($InvoiceArray);
            /*
            if ($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'] && $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2']) {
                            $subscriberAddress = $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];
                        } elseif ($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1']) {
                            $subscriberAddress = $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];
                        } else {
                            $subscriberAddress = $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];
                        }
                        if ($credit['AcrClient']['billing_address_line1'] && $credit['AcrClient']['billing_address_line2']) {
                            $clientAddress = $credit['AcrClient']['billing_address_line1'] . '<br />' . $credit['AcrClient']['billing_address_line2'] . '<br />' . $credit['AcrClient']['billing_city'] . '<br />' . $credit['AcrClient']['billing_state'] . '<br />' . $credit['AcrClient']['billing_country'] . '<br />' . $credit['AcrClient']['billing_zip'];
                        } elseif ($credit['AcrClient']['billing_address_line1']) {
                            $clientAddress = $credit['AcrClient']['billing_address_line1'] . '<br />' . $credit['AcrClient']['billing_city'] . '<br />' . $credit['AcrClient']['billing_state'] . '<br />' . $credit['AcrClient']['billing_country'] . '<br />' . $credit['AcrClient']['billing_zip'];
                        } else {
                            $clientAddress = $credit['AcrClient']['billing_address_line2'] . '<br />' . $credit['AcrClient']['billing_city'] . '<br />' . $credit['AcrClient']['billing_state'] . '<br />' . $credit['AcrClient']['billing_country'] . '<br />' . $credit['AcrClient']['billing_zip'];
                        }*/
            
            
	        if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1']){$subscriberAddress .=$organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'].'<br />';}
			if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2']){$subscriberAddress .=$organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'].'<br />';}
			if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_city']){$subscriberAddress .=$organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'].'<br />';}
			if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_state']){$subscriberAddress .=$organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'].'<br />';}
			if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_country']){$subscriberAddress .=$organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'].'<br />';}
			if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip']){$subscriberAddress .=$organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'].'<br />';}
			
			
			if($credit['AcrClient']['billing_address_line1']){$clientAddress .= $credit['AcrClient']['billing_address_line1'].'<br />';}
			if($credit['AcrClient']['billing_address_line2']){$clientAddress .= $credit['AcrClient']['billing_address_line2'].'<br />';}
			if($credit['AcrClient']['billing_city']){$clientAddress .= $credit['AcrClient']['billing_city'].'<br />';}
			if($credit['AcrClient']['billing_state']){$clientAddress .= $credit['AcrClient']['billing_state'].'<br />';}
			if($credit['AcrClient']['billing_country']){$clientAddress .= $credit['AcrClient']['billing_country'].'<br />';}
			if($credit['AcrClient']['billing_zip']){$clientAddress .= $credit['AcrClient']['billing_zip'].'<br />';}
            
            $this->set(compact('credit', 'organisationDetails', 'creditProducts', 'settings', 'defaultCurrencyInfo', 'taxCalcuations', 'subscriberAddress', 'clientAddress'));
            $this->layout = '/pdf/default';
            $this->render('/Pdf/'.$template);
            return $credit['AcrClientCreditnote']['credit_no'] . 'pdf';
        } catch(Exception $e) {
            return false;
        }
    }
    public function getBodyContent($bodyContent = null, $module = null, $creditID = null) {
        $this->loadModel('AcrClientContact');
        if ($bodyContent && $module) {
            $this->AcrClientCreditnote->recursive = 0;
            $creditData = $this->AcrClientCreditnote->findById($creditID);
            $getClientContact = $this->AcrClientContact->getClientPrimaryContactDetail($creditData['AcrClientCreditnote']['acr_client_id']);

            $swears = array("[Credit Number]" => $creditData['AcrClientCreditnote']['credit_no'], "[Balance]" => CakeNumber::currency($creditData['AcrClientCreditnote']['balance_amount'],$creditData['AcrClientCreditnote']['client_currency_code']), "[Credit Amount]" => CakeNumber::currency($creditData['AcrClientCreditnote']['amount'],$creditData['AcrClientCreditnote']['client_currency_code']),
            //"[Quote Description]"       => $creditData['AcrClientCreditnote']['description'],
            //"[PO Number]"               => $creditData['AcrClientCreditnote']['purchase_order_no'],
            "[Organization Name]" => $creditData['AcrClient']['organization_name'], "[Organization Website]" => $creditData['AcrClient']['website'], "[Business Phone]" => $creditData['AcrClient']['business_phone'], "[Business Fax]" => $creditData['AcrClient']['business_fax'], "[Primary Contact Name]" => $getClientContact['AcrClientContact']['name'], "[Primary Contact Surname]" => $getClientContact['AcrClientContact']['sur_name']);
            $content = str_replace(array_keys($swears), array_values($swears), $bodyContent);
            return $content;
        } else {
            $content = $bodyContent;
            return $content;
        }
    }

    public function generatePdf($template = null, $id = null) {
        try {
            $dir = $_SERVER['DOCUMENT_ROOT'] . $this->webroot . "app/webroot/files/uploads/credits/Subscriber-" . $this->subscriber . "/";
            $createDir = "files/uploads/credits/Subscriber-" . $this->subscriber . "/";
            if (!file_exists($dir) && !is_dir($dir)) {
                $tmp = $_SERVER['DOCUMENT_ROOT'] . $this->webroot . "app/webroot/files/uploads/credits/";
                if (!file_exists($tmp) && !is_dir($tmp)) {
                    mkdir($tmp);
                    chmod($tmp, 0755);
                }
                mkdir($dir);
                chmod($dir, 0755);
            }
            $this->set('subscriberID', $this->subscriber);
            $this->loadModel('SbsSubscriberOrganizationDetail');
            $this->loadModel('SbsSubscriberSetting');
            $this->loadModel('CpnCurrency');
            $this->loadModel('AcrClientCreditnoteProduct');
            $this->AcrClientCreditnote->recursive = 0;
            $this->AcrClientCreditnote->unbindModel(array('belongsTo' => array('SbsSubscriber', 'AcrClientInvoice', 'AcrInvoicePaymentDetail')));
            $credit = $this->AcrClientCreditnote->findById($id, array('AcrClientCreditnote.*', 'AcrClient.id', 'AcrClient.client_no', 'AcrClient.client_name', 'AcrClient.organization_name', 'AcrClient.billing_address_line1', 'AcrClient.billing_address_line2', 'AcrClient.billing_city', 'AcrClient.billing_state', 'AcrClient.billing_country', 'AcrClient.billing_zip'));
            $organisationDetails = $this->SbsSubscriberOrganizationDetail->findById($this->Session->read('Auth.User.SbsSubscriber.sbs_subscriber_organization_detail_id'), array('id', 'organization_name', 'billing_address_line1', 'billing_address_line2', 'billing_city', 'billing_state', 'billing_country', 'billing_zip', 'logo'));
            $settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
            $this->AcrClientCreditnoteProduct->recursive = 0;
            $this->AcrClientCreditnoteProduct->unbindModel(array('belongsTo' => array('AcrClientCreditnote')));
            $this->AcrClientCreditnoteProduct->bindModel(array('belongsTo' => array('InvInventory', 'SbsSubscriberTax', 'SbsSubscriberTaxGroup')));
            $creditProducts = $this->AcrClientCreditnoteProduct->find('all', array('conditions' => array('AcrClientCreditnoteProduct.acr_client_creditnote_id' => $credit['AcrClientCreditnote']['id']), 'fields' => array('AcrClientCreditnoteProduct.*', 'InvInventory.name', 'InvInventory.description', 'InvInventory.list_price', 'SbsSubscriberTax.id', 'SbsSubscriberTaxGroup.id')));
            $defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
            foreach ($creditProducts as $key => $value) {
                $InvoiceArray[$key]['AcrInvoiceDetail'] = $value['AcrClientCreditnoteProduct'];
            }
            $taxCalcuations = $this->getTaxCalculation($InvoiceArray);
            /*
            if ($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'] && $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2']) {
                            $subscriberAddress = $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];
                        } elseif ($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1']) {
                            $subscriberAddress = $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];
                        } else {
                            $subscriberAddress = $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'] . '<br />' . $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];
                        }
                        if ($credit['AcrClient']['billing_address_line1'] && $credit['AcrClient']['billing_address_line2']) {
                            $clientAddress = $credit['AcrClient']['billing_address_line1'] . '<br />' . $credit['AcrClient']['billing_address_line2'] . '<br />' . $credit['AcrClient']['billing_city'] . '<br />' . $credit['AcrClient']['billing_state'] . '<br />' . $credit['AcrClient']['billing_country'] . '<br />' . $credit['AcrClient']['billing_zip'];
                        } elseif ($credit['AcrClient']['billing_address_line1']) {
                            $clientAddress = $credit['AcrClient']['billing_address_line1'] . '<br />' . $credit['AcrClient']['billing_city'] . '<br />' . $credit['AcrClient']['billing_state'] . '<br />' . $credit['AcrClient']['billing_country'] . '<br />' . $credit['AcrClient']['billing_zip'];
                        } else {
                            $clientAddress = $credit['AcrClient']['billing_address_line2'] . '<br />' . $credit['AcrClient']['billing_city'] . '<br />' . $credit['AcrClient']['billing_state'] . '<br />' . $credit['AcrClient']['billing_country'] . '<br />' . $credit['AcrClient']['billing_zip'];
                        }*/
            if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1']){$subscriberAddress .=$organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'].'<br />';}
			if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2']){$subscriberAddress .=$organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'].'<br />';}
			if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_city']){$subscriberAddress .=$organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'].'<br />';}
			if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_state']){$subscriberAddress .=$organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'].'<br />';}
			if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_country']){$subscriberAddress .=$organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'].'<br />';}
			if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip']){$subscriberAddress .=$organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'].'<br />';}
			
			
			if($credit['AcrClient']['billing_address_line1']){$clientAddress .= $credit['AcrClient']['billing_address_line1'].'<br />';}
			if($credit['AcrClient']['billing_address_line2']){$clientAddress .= $credit['AcrClient']['billing_address_line2'].'<br />';}
			if($credit['AcrClient']['billing_city']){$clientAddress .= $credit['AcrClient']['billing_city'].'<br />';}
			if($credit['AcrClient']['billing_state']){$clientAddress .= $credit['AcrClient']['billing_state'].'<br />';}
			if($credit['AcrClient']['billing_country']){$clientAddress .= $credit['AcrClient']['billing_country'].'<br />';}
			if($credit['AcrClient']['billing_zip']){$clientAddress .= $credit['AcrClient']['billing_zip'].'<br />';}
            $this->set(compact('credit', 'organisationDetails', 'creditProducts', 'settings', 'defaultCurrencyInfo', 'taxCalcuations', 'subscriberAddress', 'clientAddress'));
            $this->layout = '/pdf/default';
            $this->render('/Pdf/' . $template);
            return $credit['AcrClientCreditnote']['credit_no'] . 'pdf';
        } catch(Exception $e) {
            return false;
        }
    }

    public function edit($id = null, $customerName = 0, $creditNo = 0, $status = 0, $min = 0, $max = 0, $page = 1) {
	   
	    $permission = $this->permission;
        if ($this->permission['_update'] != 1) {
            $this->redirect(array('controller' => 'users', 'action' => 'noaccess'));
        }
        if (!$this->AcrClientCreditnote->_checkFraud($id)) {
            $this->redirect(array('controller' => 'users', 'action' => 'accessDenied'));
        }
        $from   = $this->params->query['fromFilter'];
        $to     = $this->params->query['toFilter'];
        $menuActive = 'Manage Credits';
        $title_for_layout = 'Edit Credit Note';
        $settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
        $defaultCurrency = $settings['SbsSubscriberSetting']['cpn_currency_id'];
        $creditNote = $this->AcrClientCreditnote->find('first', array('conditions' => array('id' => $id)));
        $this->loadModel('SbsSubscriberCpnCurrencyMapping');
        $this->loadModel('SbsSubscriberPaymentTerm');
        $this->loadModel('AcrClientCreditnoteProduct');
        $this->loadModel('SbsSubscriberTaxGroup');
        $inventoryList = $this->InvInventory->getListOfInventory($this->subscriber);
        $customers = $this->AcrClient->getActiveCustomerList($this->subscriber);
        $settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
        $defaultCurrency = $settings['SbsSubscriberSetting']['cpn_currency_id'];
        $defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
        $defaultCurrencyCode = $defaultCurrencyInfo['CpnCurrency']['code'];
        $subsCriberCurrency = $this->SbsSubscriberCpnCurrencyMapping->getCurrencyList($this->subscriber);
        $paymentTerm = $this->SbsSubscriberPaymentTerm->getPaymentTermsBySubscriber($this->subscriber);
        $customerDetails = $this->customerDetails($creditNote['AcrClientCreditnote']['acr_client_id']);
        $taxGroupNames = $this->SbsSubscriberTaxGroup->find('list',array('fields'=>array('id','group_name'),'conditions'=>array('sbs_subscriber_id'=>$this->subscriber)));
        foreach ($subsCriberCurrency as $subkey => $subscriberCurrencyMap) {
            if ($subscriberCurrencyMap['CpnCurrency']['code']) {
                $currencyList[$subscriberCurrencyMap['CpnCurrency']['id']] = $subscriberCurrencyMap['CpnCurrency']['code'];
            }
        }
        $subscriberCurrencyIDD = $this->CpnCurrency->getCurrencyIdByCurrencyCode($creditNote['AcrClientCreditnote']['client_currency_code']);
        $taxList = $this->taxTree();
        $this->loadModel('InvInventoryUnitType');
        $unitTypeList = $this->InvInventoryUnitType->getUnitTypeList($this->subscriber);
        $creditProducts = $this->AcrClientCreditnoteProduct->find('all', array('conditions' => array('AcrClientCreditnoteProduct.acr_client_creditnote_id' => $creditNote['AcrClientCreditnote']['id'])));
        foreach ($creditProducts as $key => $value) {
            $InvoiceArray[$key]['AcrInvoiceDetail'] = $value['AcrClientCreditnoteProduct'];
        }
        $taxCalcuations = $this->getTaxCalculation($InvoiceArray);
        $this->loadModel('AcrCreditnotePaymentMapping');
        $this->AcrCreditnotePaymentMapping->recursive = 0;
        $this->AcrCreditnotePaymentMapping->unbindModel(array('belongsTo' => array('AcrClientCreditnote', 'SbsSubscriber')));
        $paymentHistory = $this->AcrCreditnotePaymentMapping->find('all', array('fields' => array('AcrCreditnotePaymentMapping.*', 'AcrInvoicePaymentDetail.id', 'AcrInvoicePaymentDetail.paid_amount', 'AcrInvoicePaymentDetail.payment_date', 'AcrClientInvoice.id', 'AcrClientInvoice.invoice_number', 'AcrClientInvoice.invoice_currency_code', 'AcrClientInvoice.invoice_total'), 'conditions' => array('AcrCreditnotePaymentMapping.acr_client_creditnote_id' => $id)));
        $this->loadModel('AcrInvoicePaymentDetail');
        foreach ($paymentHistory as $index => $paymentHistoryDetails) {
            $paymentHistory[$index] = $paymentHistoryDetails;
            $paymentHistory[$index]['OverAllPayment'] = $this->AcrInvoicePaymentDetail->find('first', array('fields' => array('SUM(paid_amount) as paid_amount'), 'conditions' => array('AcrInvoicePaymentDetail.acr_client_invoice_id' => $paymentHistoryDetails['AcrCreditnotePaymentMapping']['acr_client_invoice_id'], 'AcrInvoicePaymentDetail.is_deleted' => 'no')));
        }
        if ($creditNote['AcrClientCreditnote']['status'] != 'Void') {
            $activeStatus = 'Active';
        } else {
            $activeStatus = 'Void';
        }
        $subscriberID = $this->subscriber;
        $this->set(compact('menuActive', 'taxGroupNames', 'permission', 'title_for_layout', 'creditNote', 'activeStatus', 'subscriberID', 'taxList', 'unitTypeList', 'paymentHistory', 'creditProducts', 'taxCalcuations', 'customers', 'customerDetails', 'subscriberCurrencyIDD', 'defaultCurrency', 'defaultCurrencyCode', 'subsCriberCurrency', 'currencyList', 'settings', 'inventoryList'));
        $this->set(compact('customerName', 'creditNo', 'status', 'min', 'max', 'from', 'to', 'page'));
        if (!empty($this->data)) {
            $this->loadModel('AcrCreditnotePaymentMapping');
            $paymentHistory = $this->AcrCreditnotePaymentMapping->find('first', array('fields' => array('AcrCreditnotePaymentMapping.id'), 'conditions' => array('AcrCreditnotePaymentMapping.acr_client_creditnote_id' => $this->data['AcrClientInvoice']['creditID'])));
            if (!empty($paymentHistory) && $this->data['AcrClientInvoice']['status'] == 'Void') {
                $this->Session->setFlash('<div class="alert alert-danger">Error occurred. Credit note couldnot be made inactive. Please unapply credit note and try again.</div>');
                $this->redirect(array($id, $customerName, $creditNo, $status, $min, $max, '?'=>array('fromFilter' => $from, 'toFilter' => $to), $page));
            }
            $inventoryExist = false;
            foreach ($this->data['AcrClientInvoice']['inventory'] as $indexRowID => $inventoryID) {
                if (!empty($inventoryID)) {
                    $inventoryExist = true;
                }
            }
            if (!$inventoryExist) {
                $this->Session->setFlash('<div class="alert alert-danger">Error occurred. Please select any one inventory atleast and try again.</div>');
                $this->redirect(array($id, $customerName, $creditNo, $status, $min, $max, '?'=>array('fromFilter' => $from, 'toFilter' => $to), $page));
            }
            $usedCredit = round(($creditNote['AcrClientCreditnote']['amount'] - $creditNote['AcrClientCreditnote']['balance_amount']), 2);
            $ACTUALAMOUNT = round($this->data['AcrClientInvoice']['invoicetotal'], 2);
            if (!empty($paymentHistory) && ($ACTUALAMOUNT < $usedCredit)) {
                $this->Session->setFlash('<div class="alert alert-danger">Error occurred. Credit note applied amount is less than actual amount.</div>');
                $this->redirect(array($id, $customerName, $creditNo, $status, $min, $max, '?'=>array('fromFilter' => $from, 'toFilter' => $to), $page));
            }
            $updated = $this->AcrClientCreditnote->updateCreditNotes($this->data, $usedCredit);

            $sentSuccess = false;
            if ($updated) {
                if ($this->data['quotation_status'] == 'Open') {
                    $sentSuccess = $this->sendEmailCreditNote($updated, $this->data);
                    if ($sentSuccess) {
                        $this->Session->setFlash(__('<div class="alert alert-block alert-success">Credit note has been sent.</div>'));
                    } else {
                        $this->Session->setFlash(__('<div class="alert alert-warning">Credit note has been updated and error occurred while sending an email.</div>'));
                    }
                } else {
                    $this->Session->setFlash('<div class="alert alert-success">Credit note has been updated.</div>');
                }
                $this->redirect(array('action' => 'index', $customerName, $creditNo, $status, $min, $max, '?'=>array('fromFilter' => $from, 'toFilter' => $to), 'page:' . $page));
            } else {
                if ($this->data['AcrClientInvoice']['quotation_status'] == 'Open') {
                    $this->Session->setFlash('<div class="alert alert-danger">Credit note couldn\'t send.</div>');
                    return;
                } else {
                    $this->Session->setFlash('<div class="alert alert-danger">Error occurred. Credit note could not been updated.</div>');
                    return;
                }
            }

           $this->redirect(array('action' => 'index', $customerName, $creditNo, $status, $min, $max, '?'=>array('fromFilter' => $from, 'toFilter' => $to), 'page:' . $page));
        }
        if($this->request->is('mobile')){
            $this->render('/CreditNotes/m_edit');
        }
    }

    public function deleteRow($rowID = null, $creditProdID = null, $creditID = null) {
        $this->set(compact('rowID','creditProdID','creditID'));
    }

    public function removeCreditNote($paymentID = null, $paymentMappingID = null, $id = null) {
        $this->loadModel('AcrInvoicePaymentDetail');
        $this->loadModel('AcrCreditnotePaymentMapping');
        $balanceAmount = 0;
        if ($paymentID && $paymentMappingID && $id) {
            $paymentUpdated = $this->AcrInvoicePaymentDetail->save(array('id' => $paymentID, 'is_deleted' => 'yes'));
            if ($paymentUpdated) {
                $mappingDeleted = $this->AcrCreditnotePaymentMapping->delete($paymentMappingID);
                if ($mappingDeleted) {
                    $creditAmount = $this->params->query['creditAmount'];
                    $creditDetails = $this->AcrClientCreditnote->find('first', array('conditions' => array('id' => $id), 'fields' => array('id', 'balance_amount')));
                    $balanceAmount = $creditDetails['AcrClientCreditnote']['balance_amount'] + $this->params->query['creditAmount'];
                    if ($this->params->query['creditStatus'] == 'Void') {
                        $Creditstatus = 'Void';
                    } else {
                        $exist = $this->AcrCreditnotePaymentMapping->find('first', array('conditions' => array('AcrCreditnotePaymentMapping.acr_client_creditnote_id' => $id), 'fields' => array('id')));
                        if (!empty($exist)) {
                            $Creditstatus = 'Partially Applied';
                        } else {
                            $Creditstatus = 'Open';
                        }
                        $creditAmountReverted = $this->AcrClientCreditnote->save(array('id' => $id, 'status' => $Creditstatus, 'balance_amount' => $balanceAmount));
                        if ($creditAmountReverted) {
                            $paymentForInvoice = $this->AcrInvoicePaymentDetail->find('first', array('conditions' => array('AcrInvoicePaymentDetail.acr_client_invoice_id' => $this->params->query['invoiceID'], 'AcrInvoicePaymentDetail.is_deleted' => 'no')));
                            if (!empty($paymentForInvoice)) {
                                $invoiceStatus = 'Partially Paid';
                            } else {
                                $invoiceStatus = 'Open';
                            }
                            $this->AcrClientInvoice->save(array('id' => $this->params->query['invoiceID'], 'status' => $invoiceStatus));
                        }
                    }
                }
            }
        }
        $this->AcrCreditnotePaymentMapping->recursive = 0;
        $this->AcrCreditnotePaymentMapping->unbindModel(array('belongsTo' => array('AcrClientCreditnote', 'SbsSubscriber')));
        $paymentHistory = $this->AcrCreditnotePaymentMapping->find('all', array('fields' => array('AcrCreditnotePaymentMapping.*', 'AcrInvoicePaymentDetail.id', 'AcrInvoicePaymentDetail.paid_amount', 'AcrInvoicePaymentDetail.payment_date', 'AcrClientInvoice.id', 'AcrClientInvoice.invoice_number', 'AcrClientInvoice.invoice_currency_code', 'AcrClientInvoice.invoice_total'), 'conditions' => array('AcrCreditnotePaymentMapping.acr_client_creditnote_id' => $id)));
        foreach ($paymentHistory as $index => $paymentHistoryDetails) {
            $paymentHistory[$index] = $paymentHistoryDetails;
            $paymentHistory[$index]['OverAllPayment'] = $this->AcrInvoicePaymentDetail->find('first', array('fields' => array('SUM(paid_amount) as paid_amount'), 'conditions' => array('AcrInvoicePaymentDetail.acr_client_invoice_id' => $paymentHistoryDetails['AcrCreditnotePaymentMapping']['acr_client_invoice_id'], 'AcrInvoicePaymentDetail.is_deleted' => 'no')));
        }
        $creditNote = $this->AcrClientCreditnote->find('first', array('conditions' => array('id' => $id)));
        $settings['SbsSubscriberSetting']['date_format'] = $this->params->query['date'];
        $this->set(compact('paymentHistory', 'creditNote', 'settings'));
    }

    /**
     * @author Ganesh
     * @method View credit note details
     * @param $id, $customerName, $creditNo, $status, $min, $max, $from, $to, $page
     * */
    public function view($id = null, $customerName = 0, $creditNo = 0, $status = 0, $min = 0, $max = 0, $page = 1) {
        $from   = $this->params->query['fromFilter'];
        $to     = $this->params->query['toFilter'];
        $permission = $this->permission;
        if ($this->permission['_update'] != 1) {
            $this->redirect(array('controller' => 'users', 'action' => 'noaccess'));
        }
        if (!$this->AcrClientCreditnote->_checkFraud($id)) {
            $this->redirect(array('controller' => 'users', 'action' => 'accessDenied'));
        }
        $menuActive = 'Manage Credits';
        $title_for_layout = 'View Credit Note';
        $this->loadModel('AcrClientCreditnoteProduct');

        $settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
        $defaultCurrency = $settings['SbsSubscriberSetting']['cpn_currency_id'];
        $this->set(compact('menuActive', 'permission', 'title_for_layout'));
        $this->AcrClientCreditnote->recursive = 0;
        $this->AcrClientCreditnote->unbindModel(array('SbsSubscriber', 'AcrInvoicePaymentDetail', 'AcrClientInvoice'));
        $creditNote = $this->AcrClientCreditnote->find('first', array('conditions' => array('AcrClientCreditnote.id' => $id), 'fields' => array('AcrClientCreditnote.*', 'AcrClient.organization_name', 'AcrClient.client_name', 'AcrClient.billing_address_line1', 'AcrClient.billing_address_line2', 'AcrClient.billing_city', 'AcrClient.billing_state', 'AcrClient.billing_country', 'AcrClient.billing_zip')));
        $productDetails = $this->AcrClientCreditnoteProduct->find('all', array('conditions' => array('AcrClientCreditnoteProduct.acr_client_creditnote_id' => $id)));
        $defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
        foreach($productDetails as $key => $value) {
            $InvoiceArray[$key]['AcrInvoiceDetail'] = $value['AcrClientCreditnoteProduct'];
        }
        $taxes = $this->getTaxCalculation($InvoiceArray);
        $this->loadModel('AcrCreditnotePaymentMapping');
        $this->AcrCreditnotePaymentMapping->recursive = 0;
        $this->AcrCreditnotePaymentMapping->unbindModel(array('belongsTo' => array('AcrClientCreditnote', 'SbsSubscriber')));
        $paymentHistory = $this->AcrCreditnotePaymentMapping->find('all', array('fields' => array('AcrCreditnotePaymentMapping.*', 'AcrInvoicePaymentDetail.id', 'AcrInvoicePaymentDetail.paid_amount', 'AcrInvoicePaymentDetail.payment_date', 'AcrClientInvoice.id', 'AcrClientInvoice.invoice_number', 'AcrClientInvoice.invoice_currency_code', 'AcrClientInvoice.invoice_total'), 'conditions' => array('AcrCreditnotePaymentMapping.acr_client_creditnote_id' => $id)));
        $this->loadModel('AcrInvoicePaymentDetail');
        foreach ($paymentHistory as $index => $paymentHistoryDetails) {
            $paymentHistory[$index] = $paymentHistoryDetails;
            $paymentHistory[$index]['OverAllPayment'] = $this->AcrInvoicePaymentDetail->find('first', array('fields' => array('SUM(paid_amount) as paid_amount'), 'conditions' => array('AcrInvoicePaymentDetail.acr_client_invoice_id' => $paymentHistoryDetails['AcrCreditnotePaymentMapping']['acr_client_invoice_id'], 'AcrInvoicePaymentDetail.is_deleted' => 'no')));
        }
        $this->set(compact('productDetails', 'creditNote', 'defaultCurrencyInfo', 'settings', 'taxes', 'paymentHistory', 'customerName', 'creditNo', 'status', 'min', 'max', 'from', 'to', 'page'));
    }

    public function getTaxCalculation($invoiceDetail = null) {
        if ($invoiceDetail) {
            foreach ($invoiceDetail as $key => $invoiceDetailValue) {
                if ($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']) {
                    $this->loadModel('SbsSubscriberTaxGroupMapping');
                    $groupTaxMap = $this->SbsSubscriberTaxGroupMapping->getGroupMapping($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']);
                    $product = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];
                    $lineTotal = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];
                    foreach ($groupTaxMap as $key => $val1) {
                        $taxArray[$val1['SbsSubscriberTax']['id']]['taxName'] = $val1['SbsSubscriberTax']['code'] . ' (@' . $val1['SbsSubscriberTax']['percent'] . '%)';
                        if ($val1['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y') {
                            $taxAmount = ($product * $val1['SbsSubscriberTax']['percent']) / 100;
                            $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
                            $product = $product + $taxAmount;
                        } else {
                            /*$product = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];*/
                            $taxAmount = ($lineTotal * $val1['SbsSubscriberTax']['percent']) / 100;
                            $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
                            /*$product = $lineTotal + $taxAmount;*/
                            $product = $product + $taxAmount;
                        }
                    }
                } elseif ($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_id']) {
                    $this->loadModel('SbsSubscriberTax');
                    $product = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];
                    $taxDetails = $this->SbsSubscriberTax->getTaxById($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_id']);
                    if ($taxDetails) {
                        $taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxName'] = $taxDetails['SbsSubscriberTax']['code'] . ' (@' . $taxDetails['SbsSubscriberTax']['percent'] . '%)';
                        $taxAmount = ($product * $taxDetails['SbsSubscriberTax']['percent']) / 100;
                        $taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
                        //$product = $product + ($product * $taxDetails['SbsSubscriberTax']['percent'])/100;
                    }
                }
            }
            return $taxArray;
        }
    }

    public function applyCreditFromInvoice($creditID = null, $invoiceID = null, $sentSuccess = null, $filterAction = null, $filterValue = null, $filterValue1 = null, $filterValue2 = null, $isRecurring = null, $invoiceStatus = null, $fromDate = null, $toDate = null, $page = null) {
        if(!$this->AcrClientInvoice->_checkFraud($invoiceID)) {
            $this->redirect(array('controller'=>'users','action'=>'accessDenied'));
        }
        $this->loadModel('CpnPaymentMethod');
        $this->loadModel('AcrCreditnotePaymentMapping');
        $this->loadModel('AcrInvoicePaymentDetail');
        $payMentMethod = 'Credit Note';
        $getPaymentMethodId = $this->CpnPaymentMethod->getPaymentMethodByname($payMentMethod);
        if (!$getPaymentMethodId) {
            $getPaymentMethodId = $this->CpnPaymentMethod->addNewPaymentMethod($payMentMethod);
        }
        $appliedCreditNoteAmount = 0;
        $creditNoteDetails = $this->AcrClientCreditnote->findById($creditID);
        $invoiceDetails = $this->AcrClientInvoice->findById($invoiceID, array('id', 'invoice_total', 'invoice_currency_code','invoice_number'));
        $paymentsMade = $this->AcrInvoicePaymentDetail->find('first', array('fields' => array('SUM(paid_amount) as paid_amount'), 'conditions' => array('acr_client_invoice_id' => $invoiceID, 'is_deleted' => 'no')));
        $invoiceBalance = round($invoiceDetails['AcrClientInvoice']['invoice_total'], 2) - round($paymentsMade['0']['paid_amount'], 2);
        $invoiceBalance = floatval($invoiceBalance);
        if ($invoiceBalance == $creditNoteDetails['AcrClientCreditnote']['balance_amount']) {
            $amountCredit['credit_amount'] = $invoiceBalance;
        } elseif ($invoiceBalance < $creditNoteDetails['AcrClientCreditnote']['balance_amount']) {
            $amountCredit['credit_amount'] = $invoiceBalance;
        } elseif ($invoiceBalance > $creditNoteDetails['AcrClientCreditnote']['balance_amount']) {
            $amountCredit['credit_amount'] = $creditNoteDetails['AcrClientCreditnote']['balance_amount'];
        }
        if ($amountCredit['credit_amount'] > 0) {
            $paymentDetail['AcrInvoicePaymentDetail']['paid_amount'] = $amountCredit['credit_amount'];
            $paymentDetail['AcrInvoicePaymentDetail']['cpn_payment_method_id'] = $getPaymentMethodId;
            $paymentDetail['AcrInvoicePaymentDetail']['payment_date'] = date('Y-m-d');
            $paymentDetail['AcrInvoicePaymentDetail']['reference_no'] = 'Payment Recorded against Inv#' . $invoiceDetails['AcrClientInvoice']['invoice_number'] . ' from credit note #'.$creditNoteDetails['AcrClientCreditnote']['credit_no'];
            $paymentDetail['AcrInvoicePaymentDetail']['notes']          = 'Credit applied.';
            $paymentDetail['AcrInvoicePaymentDetail']['send_payment_note'] = 'N';
            $paymentDetail['AcrInvoicePaymentDetail']['acr_client_id'] = $creditNoteDetails['AcrClientCreditnote']['acr_client_id'];
            $paymentDetail['AcrInvoicePaymentDetail']['acr_client_invoice_id'] = $invoiceID;
            $paymentDetail['AcrInvoicePaymentDetail']['sbs_subscriber_id'] = $this->subscriber;
            $this->AcrInvoicePaymentDetail->create();
            if ($this->AcrInvoicePaymentDetail->save($paymentDetail)) {
                $appliedCreditNoteAmount += $amountCredit['credit_amount'];
                $lastPaymentId = $this->AcrInvoicePaymentDetail->getLastInsertId();
                $updateInvoiceStatus = null;
                if ($amountCredit['credit_amount'] >= $invoiceBalance) {
                    $updateInvoiceStatus['AcrClientInvoice']['status'] = 'Paid';
                } else {
                    $updateInvoiceStatus['AcrClientInvoice']['status'] = 'Partially Paid';
                }
                $updateInvoiceStatus['AcrClientInvoice']['id'] = $invoiceID;
                $this->AcrClientInvoice->save($updateInvoiceStatus);
                $updateCreditNoteMapping = null;
                $updateCreditNoteMapping['AcrCreditnotePaymentMapping']['acr_client_creditnote_id'] = $creditNoteDetails['AcrClientCreditnote']['id'];
                $updateCreditNoteMapping['AcrCreditnotePaymentMapping']['acr_invoice_payment_detail_id'] = $lastPaymentId;
                $updateCreditNoteMapping['AcrCreditnotePaymentMapping']['sbs_subscriber_id'] = $this->subscriber;
                $updateCreditNoteMapping['AcrCreditnotePaymentMapping']['acr_client_invoice_id'] = $invoiceID;
                $this->AcrCreditnotePaymentMapping->addMapping($updateCreditNoteMapping);
            }
        }
        if ($appliedCreditNoteAmount == $creditNoteDetails['AcrClientCreditnote']['balance_amount']) {
            $status = "Applied";
        } elseif ($appliedCreditNoteAmount == 0) {
            $status = $creditNoteDetails['AcrClientCreditnote']['status'];
        } elseif ($appliedCreditNoteAmount < $creditNoteDetails['AcrClientCreditnote']['balance_amount']) {
            $status = "Partially Applied";
        }
        $balanceAmount = floatval($creditNoteDetails['AcrClientCreditnote']['balance_amount']) - $appliedCreditNoteAmount;
        $creditNoteApplied = $this->AcrClientCreditnote->save(array('id' => $creditNoteDetails['AcrClientCreditnote']['id'], 'status' => $status, 'balance_amount' => $balanceAmount));
        if ($appliedCreditNoteAmount != 0 && $creditNoteApplied) {
            if($sentSuccess) {
                $this->Session->setFlash('<div class="alert alert-success">Credit note has been applied and email has been sent to customer.</div>');                
            } else {
                $this->Session->setFlash('<div class="alert alert-success">Credit note has been applied.</div>');    
            }
        } else {
            $this->Session->setFlash('<div class="alert alert-danger">Internal error occurred.</div>');
        }
        $this->redirect(array('controller' => 'acr_client_invoices', 'action' => 'index', $filterAction, $filterValue, $filterValue1, $filterValue2, $isRecurring, $invoiceStatus, $fromDate, $toDate, 'page:' . $page));
    }

    public function applyCredit($id = null, $customerName = 0, $creditNo = 0, $creditNoteStatus = 0, $min = 0, $max = 0, $page = 1) {
        $from   = $this->params->query['fromFilter'];
        $to     = $this->params->query['toFilter'];
        $creditNoteDetails = $this->AcrClientCreditnote->find('first', array('conditions' => array('AcrClientCreditnote.id' => $id)));
        $settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
        if (!empty($this->data)) {
            $filter = trim($this->data['CreditApply']['invoice_filter']);
            $dueInvoices = $this->AcrClientInvoice->find('all', array('joins' => array( array('table' => 'acr_invoice_payment_details', 'alias' => 'AcrInvoicePaymentDetail', 'type' => 'LEFT', 'conditions' => array('AcrInvoicePaymentDetail.acr_client_invoice_id = AcrClientInvoice.id', 'AcrInvoicePaymentDetail.is_deleted' => 'no'))), 'conditions' => array('NOT' => array('AcrClientInvoice.status' => array('Paid', 'Marked as paid', 'Canceled', 'Draft')), 'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber, 'AcrClientInvoice.acr_client_id' => $creditNoteDetails['AcrClientCreditnote']['acr_client_id'], 'AcrClientInvoice.invoice_number LIKE' => '%' . $filter . '%'), 'fields' => array('AcrClientInvoice.id', 'AcrClientInvoice.invoice_number', 'AcrClientInvoice.invoiced_date', 'AcrClientInvoice.invoice_total', 'AcrClientInvoice.invoice_currency_code', 'SUM(AcrInvoicePaymentDetail.paid_amount) as paid_amount'), 'group' => array('AcrClientInvoice.id')));
            $this->loadModel('CpnPaymentMethod');
            $this->loadModel('AcrCreditnotePaymentMapping');
            $this->loadModel('AcrInvoicePaymentDetail');
            $payMentMethod = 'Credit Note';
            $getPaymentMethodId = $this->CpnPaymentMethod->getPaymentMethodByname($payMentMethod);
            if (!$getPaymentMethodId) {
                $getPaymentMethodId = $this->CpnPaymentMethod->addNewPaymentMethod($payMentMethod);
            }
            $appliedCreditNoteAmount = 0;
            foreach ($this->data['credit_apply'] as $invoiceID => $amountCredit) {
                if (is_numeric($amountCredit['credit_amount']) && ($amountCredit['credit_amount'] > 0)) {
                    $paymentDetail['AcrInvoicePaymentDetail']['paid_amount'] = $amountCredit['credit_amount'];
                    $paymentDetail['AcrInvoicePaymentDetail']['cpn_payment_method_id'] = $getPaymentMethodId;
                    $paymentDetail['AcrInvoicePaymentDetail']['payment_date'] = date('Y-m-d');
                    $paymentDetail['AcrInvoicePaymentDetail']['reference_no'] = 'Payment Recorded against Inv#'.$amountCredit['invoice_number'].' from credit note #'.$creditNoteDetails['AcrClientCreditnote']['credit_no'];
                    $paymentDetail['AcrInvoicePaymentDetail']['notes'] = 'Credit applied.';
                    $paymentDetail['AcrInvoicePaymentDetail']['send_payment_note'] = 'N';
                    $paymentDetail['AcrInvoicePaymentDetail']['acr_client_id'] = $creditNoteDetails['AcrClientCreditnote']['acr_client_id'];
                    $paymentDetail['AcrInvoicePaymentDetail']['acr_client_invoice_id'] = $invoiceID;
                    $paymentDetail['AcrInvoicePaymentDetail']['sbs_subscriber_id'] = $this->subscriber;
                    $this->AcrInvoicePaymentDetail->create();
                    if ($this->AcrInvoicePaymentDetail->save($paymentDetail)) {
                        $appliedCreditNoteAmount += $amountCredit['credit_amount'];
                        $lastPaymentId = $this->AcrInvoicePaymentDetail->getLastInsertId();
                        $updateInvoiceStatus = null;
                        if ($amountCredit['credit_amount'] >= $amountCredit['invoice_balance']) {
                            $updateInvoiceStatus['AcrClientInvoice']['status'] = 'Paid';
                        } else {
                            $updateInvoiceStatus['AcrClientInvoice']['status'] = 'Partially Paid';
                        }
                        $updateInvoiceStatus['AcrClientInvoice']['id'] = $invoiceID;
                        $this->AcrClientInvoice->save($updateInvoiceStatus);

                        $updateCreditNoteMapping = null;
                        $updateCreditNoteMapping['AcrCreditnotePaymentMapping']['acr_client_creditnote_id'] = $creditNoteDetails['AcrClientCreditnote']['id'];
                        $updateCreditNoteMapping['AcrCreditnotePaymentMapping']['acr_invoice_payment_detail_id'] = $lastPaymentId;
                        $updateCreditNoteMapping['AcrCreditnotePaymentMapping']['sbs_subscriber_id'] = $this->subscriber;
                        $updateCreditNoteMapping['AcrCreditnotePaymentMapping']['acr_client_invoice_id'] = $invoiceID;
                        $this->AcrCreditnotePaymentMapping->addMapping($updateCreditNoteMapping);
                    }
                }
            }
            if ($appliedCreditNoteAmount == $creditNoteDetails['AcrClientCreditnote']['balance_amount']) {
                $status = "Applied";
            } elseif ($appliedCreditNoteAmount == 0) {
                $status = $creditNoteDetails['AcrClientCreditnote']['status'];
            } elseif ($appliedCreditNoteAmount < $creditNoteDetails['AcrClientCreditnote']['balance_amount']) {
                $status = "Partially Applied";
            }
            $balanceAmount = $creditNoteDetails['AcrClientCreditnote']['balance_amount'] - $appliedCreditNoteAmount;
            $this->AcrClientCreditnote->save(array('id' => $creditNoteDetails['AcrClientCreditnote']['id'], 'status' => $status, 'balance_amount' => $balanceAmount));
            if ($appliedCreditNoteAmount != 0) {
                $this->Session->setFlash('<div class="alert alert-success">Credit note has been applied.</div>');
                $this->redirect(array('action' => 'applyCredit', $creditNoteDetails['AcrClientCreditnote']['id'],$customerName,$creditNo,$creditNoteStatus,$min,$max,$from,$to,$page));
            }
        } else {
            $dueInvoices = $this->AcrClientInvoice->find('all', array('joins' => array( array('table' => 'acr_invoice_payment_details', 'alias' => 'AcrInvoicePaymentDetail', 'type' => 'LEFT', 'conditions' => array('AcrInvoicePaymentDetail.acr_client_invoice_id = AcrClientInvoice.id', 'AcrInvoicePaymentDetail.is_deleted' => 'no'))), 'conditions' => array('NOT' => array('AcrClientInvoice.status' => array('Paid', 'Marked as paid', 'Canceled','Draft')), 'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber, 'AcrClientInvoice.acr_client_id' => $creditNoteDetails['AcrClientCreditnote']['acr_client_id']), 'fields' => array('AcrClientInvoice.id', 'AcrClientInvoice.invoice_number', 'AcrClientInvoice.invoiced_date', 'AcrClientInvoice.invoice_total', 'AcrClientInvoice.invoice_currency_code', 'SUM(AcrInvoicePaymentDetail.paid_amount) as paid_amount'), 'group' => array('AcrClientInvoice.id')));
        }
        $this->set(compact('creditNoteDetails', 'dueInvoices', 'settings', 'id','customerName', 'creditNo', 'creditNoteStatus', 'min', 'max', 'from', 'to', 'page'));
    }

    public function calculateTotalCredit($creditBalance = 0, $currencyCode = null) {
        $totalAmount = 0;
        foreach ($this->data['credit_apply'] as $invoiceID => $value) {
            if (is_numeric($value['credit_amount'])) {
                $totalAmount += $value['credit_amount'];
            }
        }
        $this->set(compact('creditBalance', 'currencyCode', 'totalAmount'));
    }

    public function delete($id = null, $customerName = 0, $creditNo = 0, $status = 0, $min = 0, $max = 0, $from = 0, $to = 0, $page = 1) {
        $permission = $this->permission;
        if ($this->permission['_delete'] != 1) {
            $this->redirect(array('controller' => 'users', 'action' => 'noaccess'));
        }
        if (!$this->AcrClientCreditnote->_checkFraud($id)) {
            $this->redirect(array('controller' => 'users', 'action' => 'accessDenied'));
        }
        $this->loadModel('AcrClientCreditnoteProduct');
        $deleteProduct = $this->AcrClientCreditnoteProduct->deleteAll(array('AcrClientCreditnoteProduct.acr_client_creditnote_id' => $id), false);
        if ($deleteProduct) {
            if ($this->AcrClientCreditnote->delete($id)) {
                $this->Session->setFlash(__('<div class="alert alert-block alert-success">Credit note has been deleted.</div>'));
            } else {
                $this->Session->setFlash('<div class="alert alert-danger">Error occurred. Credit note couldnot been deleted.</div>');
            }
        } else {
            $this->Session->setFlash('<div class="alert alert-danger">Error occurred. Credit note couldnot been deleted.</div>');
        }
        $this->redirect(array('action' => 'index', $customerName, $creditNo, $status, $min, $max, $from, $to, 'page:' . $page));
    }

    public function deleteAll() {
        $this->autoRender = false;
        if ($this->permission['_delete'] != 1) {
            $this->redirect(array('controller' => 'users', 'action' => 'noaccess'));
        }
        if (!empty($this->data['CreditNote']['Delete'])) {
            $count = 0;
            foreach ($this->data['CreditNote']['Delete'] as $creditID => $delete) {
                if ($delete == 1) {
                    $this->loadModel('AcrClientCreditnoteProduct');
                    $deleteProduct = $this->AcrClientCreditnoteProduct->deleteAll(array('AcrClientCreditnoteProduct.acr_client_creditnote_id' => $creditID), false);
                    if ($deleteProduct) {
                        if ($this->AcrClientCreditnote->delete($creditID)) {
                            $count++;
                        }
                    }
                }
            }
            if ($count == 1 || $count == 0) {
                $this->Session->setFlash('<div class="alert alert-block alert-success">' . $count . ' Credit note has been deleted.</div>');
            } else {
                $this->Session->setFlash('<div class="alert alert-block alert-success">' . $count . ' Credit notes has been deleted.</div>');
            }
        }
        $this->redirect(array('action' => 'index'));
    }

}
?>