<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'php-excel-reader/excel_reader2');
Class ExpensesController extends AppController {
	
	public $uses = array('AcpExpense','AcpExpenseCategory','AcpInventoryExpense','SbsSubscriberSetting','AcpVendor');
	public $components = array('RequestHandler');
	var $helpers = array('Xls');
	
	public $permission;
	
	
	/**
	 * @method Constructor method
	 *
	 * */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->layout = "sbs_layout";
		$this->permission = $this->Session->read('Auth.AllPermissions.Manage Expenses');
		$this->subscriber = $this->Session->read('Auth.User.SbsSubscriber.id');
		$expensesActive = 'active';
		$this->set(compact('expensesActive'));
	}
	
	
	public function index($expenseNo = 0,$vendorName = 0,$customerName = 0,$status = 0) {
		
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$menuActive = 'Manage Expenses';
		$this->set(compact('menuActive'));
		$this->AcpExpense->recursive = 0;
		$this->AcpExpense->unbindModel(array('belongsTo'=>array('SbsSubscriber')));
		
		$settings 		= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$this->loadModel('CpnCurrency');
		$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$limit 			= $settings['SbsSubscriberSetting']['lines_per_page'];
		$conditions 	= array('AcpExpense.sbs_subscriber_id'=>$this->subscriber);
		
		/**Filter Section*/
		if($expenseNo) {
			$this->request->data['Filter']['expense_no'] = $expenseNo;
		}
		if($vendorName) {
			$this->request->data['Filter']['vendor_name'] = $vendorName;
		}
		if($customerName) {
			$this->request->data['Filter']['customer_name'] = $customerName;
		}
        $fromDate = $this->params->query['fromDate'];
		if($fromDate) {
			$this->request->data['Filter']['from_date'] = $fromDate;
		}
        $toDate = $this->params->query['toDate'];
		if($toDate) {
			$this->request->data['Filter']['to_date'] = $toDate;
		}
		if($status) {
			$this->request->data['Filter']['status'] = $status;
		}
		if(!empty($this->data['Filter'])) {
			if(empty($this->request->data['Filter']['expense_no']) && empty($this->request->data['Filter']['vendor_name']) && empty($this->request->data['Filter']['customer_name']) && empty($this->request->data['Filter']['from_date']) && empty($this->request->data['Filter']['to_date']) && empty($this->request->data['Filter']['status'])) {
				$this->Session->setFlash('<div class="alert alert-info">Please enter atleast one search term.</div>');
				$this->redirect(array('action'=>'index'));
			}
			if(!empty($this->request->data['Filter']['expense_no'])) {
				$expenseNo = trim($this->request->data['Filter']['expense_no']);
				if($expenseNo) {
					$expenseNoCondtn = array('AcpExpense.expense_no LIKE'=>'%'.$expenseNo.'%');
				}
			}
			if(!empty($this->request->data['Filter']['vendor_name'])) {
				$vendorName = trim($this->request->data['Filter']['vendor_name']);
				if($vendorName) {
					$vendorNameCondtn = array('AcpVendor.vendor_name LIKE'=>'%'.$vendorName.'%');
				}
			}
			if(!empty($this->request->data['Filter']['customer_name'])) {
				$customerName = trim($this->request->data['Filter']['customer_name']);
				if($customerName) {
					$customerNameCondtn = array('AcrClient.organization_name LIKE' =>'%'.$customerName.'%');
				}
			}
			if(!empty($this->request->data['Filter']['from_date'])) {
				$fromDate = trim($this->request->data['Filter']['from_date']);
			}
			if(!empty($this->request->data['Filter']['to_date'])) {
				$toDate = trim($this->request->data['Filter']['to_date']);
			}
			if($fromDate && $toDate) {
				$dateCondtn = array('AcpExpense.date BETWEEN ? AND ?'=>array(date('Y-m-d',strtotime(str_replace('/', '-', $fromDate))),date('Y-m-d',strtotime(str_replace('/', '-', $toDate)))));
			} elseif($fromDate && !$toDate) {
				$dateCondtn = array('AcpExpense.date >='=>date('Y-m-d',strtotime(str_replace('/', '-', $fromDate))));
			} elseif(!$fromDate && $toDate) {
				$dateCondtn = array('AcpExpense.date <='=>date('Y-m-d',strtotime(str_replace('/', '-', $toDate)))); 
			}
			if(!empty($this->request->data['Filter']['status'])) {
				$status = trim($this->request->data['Filter']['status']);
				$statusCondtn = array('AcpExpense.status'=>$status);
			}
			$subscriberCondtn = array('AcpExpense.sbs_subscriber_id' => $this->subscriber); 
			$conditions = array($subscriberCondtn,$expenseNoCondtn,$vendorNameCondtn,$customerNameCondtn,$dateCondtn,$statusCondtn);
		}	
		/**End Filter Section*/
		$fields = array('AcpExpense.expense_no','AcpExpense.date','AcpExpense.acp_vendor_id','AcpExpense.amount','AcpExpense.status','acr_client_id','sbs_subscriber_id',
		         'AcrClient.id','AcrClient.organization_name','AcrClient.cpn_currency_id','AcpVendor.id','AcpVendor.vendor_name'
        );
		$this->AcpExpense->unbindModel(array('belongsTo'=>array('AcpExpenseCategory','AcrClientInvoice')));
		$this->Paginator->settings = array('fields'=>$fields,'conditions'=>$conditions,'limit' => $limit,'order'=>array('AcpExpense.id' => 'Desc'));
		$expenses = $this->Paginator->paginate('AcpExpense');
        
		$this->set(compact('expenses','expenseNo','vendorName','customerName','fromDate','toDate','status','settings','defaultCurrencyInfo','permission'));
	}
	
	public function add() {
		$permission = $this->permission;
		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$menuActive = 'Manage Expenses';
		$this->set(compact('menuActive'));
		$this->loadModel('SbsSubscriberCpnCurrencyMapping');
		$this->loadModel('InvInventory');
		$this->loadModel('AcrClient');
		$this->loadModel('CpnCurrency');
		$this->loadModel('AcpExpenseCustomField');
		$inventoryList	 	 = $this->InvInventory->getListOfInventory($this->subscriber);
		$customers 		 	 = $this->AcrClient->getActiveCustomerList($this->subscriber);
		$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$defaultCurrency 	 = $settings['SbsSubscriberSetting']['cpn_currency_id'];
		$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$defaultCurrencyCode = $defaultCurrencyInfo['CpnCurrency']['code'];
		$expenseCategories   = $this->AcpExpenseCategory->getList($this->subscriber);
		$taxList = $this->taxTree();
		$expenseFields = $this->AcpExpenseCustomField->getListOfFields($this->subscriber);
		$this->loadModel('InvInventoryUnitType');
		$unitTypeList = $this->InvInventoryUnitType->getUnitTypeList($this->subscriber);
		$this->set(compact('inventoryList','customers','settings','defaultCurrencyCode','expenseCategories','taxList','expenseFields','unitTypeList','defaultCurrency'));
		if ($this->request->is('ajax')) {
			$this->loadModel('AcpVendor');
			$term = $this->request->query('term');
			$vendorNames = $this->AcpVendor->getVendorNames($term);
			$this->set(compact('vendorNames'));
			$this->set('_serialize', 'vendorNames');
		}
		if(!empty($this->data)) {
			if($this->data['AcpExpense']['items'] == 'Non-Inventory') {
				$isInve ='N';
				$inventoryID = NULL;
			} else {
				$isInve = 'Y';
				$inventoryID = $this->data['AcpExpense']['items'];
			}
			$taxes = explode('-', $this->data['AcpExpense']['tax_inventory']);
			if($taxes[1]) {
				$taxgroup = $taxes[1]; 
			} else {
				$tax  = $this->data['AcpExpense']['tax_inventory'];
			}
			
			if(!empty($this->data['AcpExpense']['acr_client_id'])) {
				$status ='Billable';
			} else {
				$status ='Non Billable';
			}
			
			$expense = NULL;
			$expense['AcpExpense']['date'] 						= date('Y-m-d',strtotime(str_replace('/', '-', $this->data['AcpExpense']['expenseDate'])));
			$expense['AcpExpense']['expense_no'] 				= $this->data['AcpExpense']['reference_no'];
			$expense['AcpExpense']['acp_vendor_id'] 			= $this->AcpVendor->getIDbyName($this->data['AcpExpense']['vendor_name']);
			$expense['AcpExpense']['amount'] 					= $this->data['AcpExpense']['total'];
			$expense['AcpExpense']['notes'] 					= $this->data['AcpExpense']['notes'];
			$expense['AcpExpense']['sub_total'] 				= $this->data['AcpExpense']['subTotal'];
			$expense['AcpExpense']['tax_total'] 				= $this->data['AcpExpense']['taxtotal'];
			if($this->data['AcpExpense']['tax_inclusive'] == 'tax excluded') {
				$expense['AcpExpense']['tax_included'] 				= 'N';
			} else {
				$expense['AcpExpense']['tax_included'] 				= 'Y';
			}
			$expense['AcpExpense']['status'] 					= $status;
			$expense['AcpExpense']['acp_expense_category_id'] 	= $this->data['AcpExpense']['acp_expense_categories'];
			$expense['AcpExpense']['sbs_subscriber_id'] 		= $this->subscriber;
			$expense['AcpExpense']['acr_client_id'] 			= $this->data['AcpExpense']['acr_client_id'];
			
			$dir = $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/files/uploads/expenses/Subscriber-".$this->subscriber."/";
            $createDir = "files/uploads/expenses/Subscriber-".$this->subscriber."/";
			if (!file_exists($dir) && !is_dir($dir)) {
				$tmp = $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/files/uploads/expenses/Subscriber-".$this->subscriber."/";
				if(!file_exists($tmp) && !is_dir($tmp)) {
					mkdir($tmp);
					chmod($tmp, 0755);
				}
				mkdir($dir);
			    chmod($dir, 0755);     
			}
			if($_FILES['file']['name'] && ($this->data['AcpExpense']['Imageupload'] == 'true')) {
				$success = move_uploaded_file($_FILES['file']['tmp_name'], $dir.$_FILES['file']['name']);
			}
			if(!empty($success)) {
				if(!$success['errors'] && $_FILES['file']['name'] && ($this->data['AcpExpense']['Imageupload'] == 'true')) {
					$expense['AcpExpense']['reciept_upload'] = $this->webroot.'app/webroot/files/uploads/expenses/Subscriber-'.$this->subscriber.'/'.$_FILES['file']['name']; 
				}
			}
			
			$this->AcpExpense->create();
			if($this->AcpExpense->save($expense)) {
				$lastExpenseID = $this->AcpExpense->getLastInsertId();
				$this->loadModel('AcpInventoryExpense');
				$saveProductInfo['AcpInventoryExpense']['quantity'] 			= $this->data['AcpExpense']['qty'];
				$saveProductInfo['AcpInventoryExpense']['cost_price'] 			= $this->data['AcpExpense']['unit_amount'];
				$saveProductInfo['AcpInventoryExpense']['total_amount'] 		= $this->data['AcpExpense']['total'];
				$saveProductInfo['AcpInventoryExpense']['inv_inventory_id'] 	= $inventoryID;
				$saveProductInfo['AcpInventoryExpense']['inventory_description']= $this->data['AcpExpense']['inventory_description'];
				$saveProductInfo['AcpInventoryExpense']['acp_expense_id'] 		= $lastExpenseID;
				$saveProductInfo['AcpInventoryExpense']['sbs_subscriber_id'] 	= $this->subscriber;
				
				$saveProductInfo['AcpInventoryExpense']['sbs_subscriber_tax_id'] 		= $tax;
				$saveProductInfo['AcpInventoryExpense']['sbs_subscriber_tax_group_id'] 	= $taxgroup;
				$this->AcpInventoryExpense->create();
				$this->AcpInventoryExpense->save($saveProductInfo);
				
				if(!empty($inventoryID)) {
					$this->loadModel('InvInventory');
					$inventoryDetails = $this->InvInventory->findById($inventoryID,array('id','track_quantity','current_stock'));
					if($inventoryDetails['InvInventory']['track_quantity'] == 'Y') {
						$inventoryUpdate['InvInventory']['id'] = $inventoryID;
						$inventoryUpdate['InvInventory']['current_stock'] = $inventoryDetails['InvInventory']['current_stock'] + $this->data['AcpExpense']['qty'];
						$this->InvInventory->save($inventoryUpdate);
					}
				}
				
				if(!empty($this->data['AcpExpense']['custom_field'])) {
					$this->loadModel('AcpExpenseCustomFieldValue');
					foreach ($this->data['AcpExpense']['custom_field'] as $customFieldID => $value) {
						$saveCustomValues = NULL;
						$saveCustomValues['AcpExpenseCustomFieldValue']['data']							= $value;
						$saveCustomValues['AcpExpenseCustomFieldValue']['acp_expense_id']				= $lastExpenseID;
						$saveCustomValues['AcpExpenseCustomFieldValue']['acp_expense_custom_field_id']	= $customFieldID;
						$this->AcpExpenseCustomFieldValue->create();
						$this->AcpExpenseCustomFieldValue->save($saveCustomValues);
					}
				}
				
				if(!empty($this->data['AcpExpense']['ConvertToInvoice'])) {
					$invoiceIDD = $this->convertToInvoice($lastExpenseID);
					if($invoiceIDD) {
						
						$updateExpense['AcpExpense']['id'] 			= $lastExpenseID;
						$updateExpense['AcpExpense']['status'] 		= 'Billed';
						$this->AcpExpense->save($updateExpense);
						$this->Session->setFlash('<div class="alert alert-block alert-success">Expense has been created and has been converted to an invoice.</div>');
						$this->redirect(array('controller'=>'acr_client_invoices','action'=>'edit',$invoiceIDD));
					} else {
						$this->Session->setFlash('<div class="alert alert-block alert-success">Expense has been created and error occurred while converting invoice.</div>');
					}
				} else {
					$this->Session->setFlash('<div class="alert alert-block alert-success">Expense has been created.</div>');
				}
			} else {
				$this->Session->setFlash('<div class="alert alert-danger">Error occurred. Expense couldn\'t save.</div>');
			}
			$this->redirect(array('action'=>'index'));
		}
	}

    public function inventoryDesc() {
       $this->loadModel('InvInventory');
       $itemDesc = $this->InvInventory->findById($this->data['AcpExpense']['items'],array('id','description'));
       $this->set(compact('itemDesc'));
    }
    
    public function inventoryTax() {
       $this->loadModel('InvInventory');
       $this->loadModel('SbsSubscriberTaxGroup');
       $taxList = $this->taxTree();
       $itemTax = $this->InvInventory->findById($this->data['AcpExpense']['items'],array('id','sbs_subscriber_tax_id','sbs_subscriber_tax_group_id'));
       if(!empty($itemTax['InvInventory']['sbs_subscriber_tax_id'])) {
            $taxID = $itemTax['InvInventory']['sbs_subscriber_tax_id'];
        } elseif(!empty($itemTax['InvInventory']['sbs_subscriber_tax_group_id'])) {
            $taxfroupName = $this->SbsSubscriberTaxGroup->getGroupInfo($itemTax['InvInventory']['sbs_subscriber_tax_group_id'],$this->subscriber);
           
            $taxID = $taxfroupName['SbsSubscriberTaxGroup']['group_name'].'-'.$itemTax['InvInventory']['sbs_subscriber_tax_group_id'];
        }
       $this->set(compact('taxID','taxList'));
    }
	
	public function edit($id = NULL,$expenseNo = NULL,$vendorName = NULL,$customerName = NULL,$status = NULL,$page = 1) {
		$permission = $this->permission;
		if($this->permission['_update'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
        if (!$this->AcpExpense->_checkFraud($id)) {
            $this->redirect(array('controller' => 'users', 'action' => 'accessDenied'));
        }
		$menuActive = 'Manage Expenses';
		$this->set(compact('menuActive'));
		$fromDate = $this->params->query['fromDate'];
		$toDate   = $this->params->query['toDate'];
		$this->loadModel('SbsSubscriberCpnCurrencyMapping');
		$this->loadModel('InvInventory');
		$this->loadModel('AcrClient');
		$this->loadModel('CpnCurrency');
		$this->loadModel('AcpExpenseCustomField');
		$this->loadModel('AcpExpenseCustomFieldValue');
		$inventoryList	 	 = $this->InvInventory->getListOfInventory($this->subscriber);
		$customers 		 	 = $this->AcrClient->getActiveCustomerList($this->subscriber);
		$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$defaultCurrency 	 = $settings['SbsSubscriberSetting']['cpn_currency_id'];
		$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$defaultCurrencyCode = $defaultCurrencyInfo['CpnCurrency']['code'];
		$expenseCategories   = $this->AcpExpenseCategory->getList($this->subscriber);
		$taxList = $this->taxTree();
		$expenseFields = $this->AcpExpenseCustomField->getListOfFields($this->subscriber);
		$this->AcpExpense->recursive = 0;
		$this->AcpExpense->unbindModel(array('belongsTo'=>array('SbsSubscriber','AcpExpenseCategory','AcrClient')));
		$currentExpenseDetails = $this->AcpExpense->find('first',array('joins'=>array(array('table'=>'acp_inventory_expenses','alias'=>'AcpInventoryExpense','type'=>'LEFT','conditions'=>array('AcpInventoryExpense.acp_expense_id = AcpExpense.id'))),'conditions'=>array('AcpExpense.id'=>$id,'AcpExpense.sbs_subscriber_id'=>$this->subscriber),'fields'=>array('AcpExpense.*','AcpInventoryExpense.*','AcpVendor.id','AcpVendor.vendor_name')));
		
		if(!empty($currentExpenseDetails['AcpInventoryExpense']['sbs_subscriber_tax_id'])) {
			$taxID = $currentExpenseDetails['AcpInventoryExpense']['sbs_subscriber_tax_id'];
		} elseif(!empty($currentExpenseDetails['AcpInventoryExpense']['sbs_subscriber_tax_group_id'])) {
			$taxfroupName = $this->SbsSubscriberTaxGroup->getGroupInfo($currentExpenseDetails['AcpInventoryExpense']['sbs_subscriber_tax_group_id'],$this->subscriber);
			$taxID = $taxfroupName['SbsSubscriberTaxGroup']['group_name'].'-'.$currentExpenseDetails['AcpInventoryExpense']['sbs_subscriber_tax_group_id'];
		}
		$expenseCustomFields = $this->AcpExpenseCustomField->find('list',array('conditions'=>array('sbs_subscriber_id'=>$this->subscriber),'fields'=>array('id','field_name')));
		foreach ($expenseCustomFields as $fieldId => $fieldName) {
			$customFields[$fieldId]['AcpExpenseCustomField']['id']			= $fieldId;
			$customFields[$fieldId]['AcpExpenseCustomField']['field_name']	= $fieldName;
			$valueDetailss = $this->AcpExpenseCustomFieldValue->find('first',array('fields'=>array('AcpExpenseCustomFieldValue.id','AcpExpenseCustomFieldValue.data'),'conditions'=>array('AcpExpenseCustomFieldValue.acp_expense_custom_field_id'=>$fieldId,'AcpExpenseCustomFieldValue.acp_expense_id'=>$id)));
			$customFields[$fieldId]['AcpExpenseCustomFieldValue']['id']		= $valueDetailss['AcpExpenseCustomFieldValue']['id'];
			$customFields[$fieldId]['AcpExpenseCustomFieldValue']['data']	= $valueDetailss['AcpExpenseCustomFieldValue']['data'];
		}
		$this->set(compact('id','inventoryList','customers','settings','defaultCurrencyCode','expenseCategories','taxList','expenseFields','currentExpenseDetails','customFields','taxID','expenseNo','vendorName','customerName','fromDate','toDate','status','page'));
		if(!empty($this->data)) {
			if($this->data['AcpExpense']['items'] == 'Non-Inventory') {
				$isInve ='N';
				$inventoryID = NULL;
			} else {
				$isInve = 'Y';
				$inventoryID = $this->data['AcpExpense']['items'];
			}
			$taxes = explode('-', $this->data['AcpExpense']['tax_inventory']);
			if($taxes[1]) {
				$taxgroup = $taxes[1]; 
			} else {
				$tax  = $this->data['AcpExpense']['tax_inventory'];
			}
			if(!empty($this->data['AcpExpense']['acr_client_id'])) {
				$statusUpdate ='Billable';
			} else {
				$statusUpdate ='Non Billable';
			}
			$expense = NULL;
			$expense['AcpExpense']['id'] 						= $this->data['AcpExpense']['id'];
			$expense['AcpExpense']['date'] 						= date('Y-m-d',strtotime(str_replace('/', '-', $this->data['AcpExpense']['expenseDate'])));
			$expense['AcpExpense']['expense_no'] 				= $this->data['AcpExpense']['reference_no'];
			$expense['AcpExpense']['acp_vendor_id'] 			= $this->AcpVendor->getIDbyName($this->data['AcpExpense']['vendor_name']);
			$expense['AcpExpense']['amount'] 					= $this->data['AcpExpense']['total'];
			$expense['AcpExpense']['notes'] 					= $this->data['AcpExpense']['notes'];
			$expense['AcpExpense']['sub_total'] 				= $this->data['AcpExpense']['subTotal'];
			$expense['AcpExpense']['tax_total'] 				= $this->data['AcpExpense']['taxtotal'];
			if($this->data['AcpExpense']['tax_inclusive'] == 'tax excluded') {
				$expense['AcpExpense']['tax_included'] 				= 'N';
			} else {
				$expense['AcpExpense']['tax_included'] 				= 'Y';
			}
			$expense['AcpExpense']['status'] 					= $statusUpdate;
			$expense['AcpExpense']['acp_expense_category_id'] 	= $this->data['AcpExpense']['acp_expense_categories'];
			$expense['AcpExpense']['sbs_subscriber_id'] 		= $this->subscriber;
			$expense['AcpExpense']['acr_client_id'] 			= $this->data['AcpExpense']['acr_client_id'];
			
			$dir = $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/files/uploads/expenses/Subscriber-".$this->subscriber."/";
			$createDir = "files/uploads/expenses/Subscriber-".$this->subscriber."/";
			if (!file_exists($dir) && !is_dir($dir)) {
				$tmp = $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/files/uploads/expenses/";
				if(!file_exists($tmp) && !is_dir($tmp)) {
					mkdir($tmp);
				}
				mkdir($dir);        
			}
			if($_FILES['file']['name'] && ($this->data['AcpExpense']['Imageupload'] == 'true')) {
				$success = move_uploaded_file($_FILES['file']['tmp_name'], $dir.$_FILES['file']['name']);
			}
			
			if(!$success['errors'] && $_FILES['file']['name'] && ($this->data['AcpExpense']['Imageupload'] =='true')) {
				$expense['AcpExpense']['reciept_upload'] = $this->webroot.'app/webroot/files/uploads/expenses/Subscriber-'.$this->subscriber.'/'.$_FILES['file']['name']; 
			}

			$inventoryDetails = $this->InvInventory->findById($inventoryID,array('id','track_quantity','current_stock'));
			
			
			if($inventoryID == $currentExpenseDetails['AcpInventoryExpense']['inv_inventory_id']) {
				if($inventoryDetails['InvInventory']['track_quantity'] == 'Y') {
					$finalQuantity = $this->data['AcpExpense']['qty'] - $currentExpenseDetails['AcpInventoryExpense']['quantity'];
					$afterUpdate = $inventoryDetails['InvInventory']['current_stock'] + $finalQuantity;
					if($afterUpdate < 0) {
						$this->Session->setFlash('<div class="alert alert-danger">Error occurred.</div>');
						$this->redirect(array('action'=>'index',$expenseNo,$vendorName,$customerName,'?'=>array('fromDate'=>$fromDate,'toDate'=>$toDate),$status,$page));
					}
				}
			} else {
				$currentStock = $this->InvInventory->find('first',array('conditions'=>array('InvInventory.id'=>$currentExpenseDetails['AcpInventoryExpense']['inv_inventory_id'])));
				if(($currentStock['InvInventory']['track_quantity'] == 'Y') && ($currentStock['InvInventory']['current_stock'] < $currentExpenseDetails['AcpInventoryExpense']['quantity'])) {
					$this->Session->setFlash('<div class="alert alert-danger">Error occurred.</div>');
					$this->redirect(array('action'=>'index',$expenseNo,$vendorName,$customerName,'?'=>array('fromDate'=>$fromDate,'toDate'=>$toDate),$status,$page));
				}
			}
			
			if($this->AcpExpense->save($expense)) {
				$this->loadModel('AcpInventoryExpense');
				$saveProductInfo['AcpInventoryExpense']['id'] 							= $this->data['AcpExpense']['AcpInventoryExpenseID'];
				$saveProductInfo['AcpInventoryExpense']['quantity'] 					= $this->data['AcpExpense']['qty'];
				$saveProductInfo['AcpInventoryExpense']['cost_price'] 					= $this->data['AcpExpense']['unit_amount'];
				$saveProductInfo['AcpInventoryExpense']['total_amount'] 				= $this->data['AcpExpense']['total'];
				$saveProductInfo['AcpInventoryExpense']['inv_inventory_id'] 			= $inventoryID;
				$saveProductInfo['AcpInventoryExpense']['inventory_description']		= $this->data['AcpExpense']['inventory_description'];
				$saveProductInfo['AcpInventoryExpense']['acp_expense_id'] 				= $this->data['AcpExpense']['id'];
				$saveProductInfo['AcpInventoryExpense']['sbs_subscriber_id'] 			= $this->subscriber;
				$saveProductInfo['AcpInventoryExpense']['sbs_subscriber_tax_id'] 		= $tax;
				$saveProductInfo['AcpInventoryExpense']['sbs_subscriber_tax_group_id'] 	= $taxgroup;
				$this->AcpInventoryExpense->save($saveProductInfo);
				if(!empty($inventoryID)) {
					$this->loadModel('InvInventory');
					$inventoryDetails = $this->InvInventory->findById($inventoryID,array('id','track_quantity','current_stock'));
					if($inventoryID == $currentExpenseDetails['AcpInventoryExpense']['inv_inventory_id']) {
						if($inventoryDetails['InvInventory']['track_quantity'] == 'Y') {
							$inventoryUpdate['InvInventory']['id'] = $inventoryID;
							$inventoryUpdate['InvInventory']['current_stock'] = $afterUpdate;
							$this->InvInventory->save($inventoryUpdate);
						}
					} else {
						if($inventoryDetails['InvInventory']['track_quantity'] == 'Y') {
							$update['InvInventory']['id'] = $inventoryDetails['InvInventory']['id'];
							$update['InvInventory']['current_stock'] = $inventoryDetails['InvInventory']['current_stock'] + $this->data['AcpExpense']['qty'] ;
							$this->InvInventory->save($update);
							
							$update1['InvInventory']['id'] = $currentStock['InvInventory']['id'];
							$update1['InvInventory']['current_stock'] = $currentStock['InvInventory']['current_stock'] - $currentExpenseDetails['AcpInventoryExpense']['quantity'];
							$this->InvInventory->save($update1);
							
						}
					}
				}
				if(!empty($this->data['AcpExpense']['custom_field'])) {
					$this->loadModel('AcpExpenseCustomFieldValue');
					foreach ($this->data['AcpExpense']['custom_field'] as $customFieldID => $value) {
						if(!empty($value['id'])) {
							$saveCustomValues['AcpExpenseCustomFieldValue']['id']					   = $value['id'];
						} else {
							$this->AcpExpenseCustomFieldValue->create();
						}
						$saveCustomValues['AcpExpenseCustomFieldValue']['data']							= $value['value'];
						$saveCustomValues['AcpExpenseCustomFieldValue']['acp_expense_id']				= $this->data['AcpExpense']['id'];
						$saveCustomValues['AcpExpenseCustomFieldValue']['acp_expense_custom_field_id']	= $customFieldID;
						$this->AcpExpenseCustomFieldValue->save($saveCustomValues);
					}
				}
				if(!empty($this->data['AcpExpense']['ConvertToInvoice'])) {
					$invoiceIDD = $this->convertToInvoice($this->data['AcpExpense']['id']);
					if($invoiceIDD) {
						$updateExpense['AcpExpense']['id'] 			= $this->data['AcpExpense']['id'];
						$updateExpense['AcpExpense']['status'] 		= 'Billed';
						$this->AcpExpense->save($updateExpense);
						$this->Session->setFlash('<div class="alert alert-block alert-success">Expense has been updated and has been converted to an invoice.</div>');
						$this->redirect(array('controller'=>'acr_client_invoices','action'=>'edit',$invoiceIDD));
					} else {
						$this->Session->setFlash('<div class="alert alert-block alert-success">Expense has been updated and error occurred while converting invoice.</div>');
					}
				} else {
					$this->Session->setFlash('<div class="alert alert-block alert-success">Expense has been updated.</div>');
				}
			} else {
				$this->Session->setFlash('<div class="alert alert-danger">Error occurred. Expense couldn\'t update.</div>');
			}
			$this->redirect(array('action'=>'index',$expenseNo,$vendorName,$customerName,'?'=>array('fromDate'=>$fromDate,'toDate'=>$toDate),$status,$page));
		}
	}
	
	public function view($id = NULL,$expenseNo = 0,$vendorName = 0,$customerName = 0,$status = 0,$page = 1) {
		if(!$this->AcpExpense->_checkFraud($id)) {
			$this->redirect(array('controller'=>'users','action'=>'accessDenied'));
		}
		$title_for_layout = 'View Expense';
		$this->set(compact('title_for_layout'));
        $fromDate   = $this->params->query['fromDate'];
        $toDate     = $this->params->query['toDate'];
		$this->AcpExpense->recursive = 0;
		$this->AcpExpense->unbindModel(array('belongsTo'=>array('SbsSubscriber')));
		$expenseDetails = $this->AcpExpense->findById($id);
		$this->AcpInventoryExpense->recursive = 0;
		$this->AcpInventoryExpense->unbindModel(array('belongsTo'=>array('SbsSubscriber','AcpExpense')));
		$expenseProducts = $this->AcpInventoryExpense->find('first',array('fields'=>array('AcpInventoryExpense.*','InvInventory.name'),'conditions'=>array('acp_expense_id'=>$id,'AcpInventoryExpense.sbs_subscriber_id'=>$expenseDetails['AcpExpense']['sbs_subscriber_id'])));
		$this->loadModel('CpnCurrency');
		$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$defaultCurrency 	 = $settings['SbsSubscriberSetting']['cpn_currency_id'];
		$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$customFields 		 = $this->getCustomValues($id);
		$invoiceArray[0] = $expenseProducts;
		$taxCalcuations = $this->getTaxCalculation($invoiceArray,$expenseDetails['AcpExpense']['sub_total']);
		$this->set(compact('expenseDetails','expenseProducts','settings','defaultCurrencyInfo','customFields','taxCalcuations','expenseNo','vendorName','customerName','fromDate','toDate','status','page'));
	}
	
	public function delete($id = NULL,$expenseNo = 0,$vendorName = 0,$customerName = 0,$status = 0,$page = 1) {
		$permission = $this->permission;
		if($this->permission['_delete'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
        $fromDate   = $this->params->query['fromDate'];
        $toDate     = $this->params->query['toDate'];
		$this->loadModel('AcpExpenseCustomFieldValue');
		$this->loadModel('AcpInventoryExpense');
		$expenseDetail = $this->AcpExpense->findById($id,array('expense_no'));
		$this->AcpExpenseCustomFieldValue->deleteAll(array('AcpExpenseCustomFieldValue.acp_expense_id'=> $id), FALSE);
		$this->AcpInventoryExpense->deleteAll(array('AcpInventoryExpense.acp_expense_id'=> $id), FALSE);
		$deleted = $this->AcpExpense->deleteAll(array('AcpExpense.id'=> $id), FALSE);
		if($deleted) {
			$this->Session->setFlash('<div class="alert alert-block alert-success">Expense #'.$expenseDetail['AcpExpense']['expense_no'].' has been deleted.</div>');
		} else {
			$this->Session->setFlash('<div class="alert alert-danger">Internal error occurred. Please try again later.</div>');
		}
		$this->set(compact('expenseNo','vendorName','customerName','fromDate','toDate','status','permission'));
		$this->redirect(array('action'=>'index',$expenseNo,$vendorName,$customerName,'?'=>array('fromDate'=>$fromDate,'toDate'=>$toDate),$status,$page));
	}

	public function deleteAll() {
		if(!empty($this->data['Expense']['Delete'])) {
			$count = 0;
			foreach($this->data['Expense']['Delete'] as $id => $delete) {
				if($delete) {
					$deletionIDS[$id] = $id;
				}
			}
			$this->loadModel('AcpExpense');
			$DeleteIDS = $this->AcpExpense->find('list',array(
				'conditions'=>array('AcpExpense.id'=>$deletionIDS,'AcpExpense.sbs_subscriber_id'=>$this->subscriber)
			));
			$count = count($DeleteIDS);
			$this->loadModel('AcpExpenseCustomFieldValue');
			$this->loadModel('AcpInventoryExpense');
			if($count >= 1) {
				$this->AcpExpenseCustomFieldValue->deleteAll(array('AcpExpenseCustomFieldValue.acp_expense_id'=> $DeleteIDS), FALSE);
				$this->AcpInventoryExpense->deleteAll(array('AcpInventoryExpense.acp_expense_id'=> $DeleteIDS), FALSE);
				$this->AcpExpense->deleteAll(array('AcpExpense.id'=> $DeleteIDS), FALSE);
				if($count == 1) {
					$this->Session->setFlash('<div class="alert alert-block alert-success">1 Expense has been deleted.</div>');
				} else {
					$this->Session->setFlash('<div class="alert alert-block alert-success">'.$count.' Expenses has been deleted.</div>');
				}
			} else {
				$this->Session->setFlash('<div class="alert alert-danger">Internal error occurred. Please try again later.</div>');
			}
		} else {
			$this->Session->setFlash('<div class="alert alert-danger">Please select atlease any one expense to delete.</div>');
		}
		$this->redirect(array('action'=>'index'));
	}

	public function vendor() {
		if ($this->request->is('ajax')) {
			$this->loadModel('AcpVendor');
			$term = $this->request->query('term');
			$vendorNames = $this->AcpVendor->getVendorNames($term);
			//$this->set(compact('vendorNames'));
			//$this->set('_serialize', 'vendorNames');
		}
	}

	public function calculateLineTotal() {
		$lineTotal = 0;
		if(!empty($this->data['AcpExpense']['qty']) && !empty($this->data['AcpExpense']['unit_amount'])) {
			$lineTotal = $this->data['AcpExpense']['qty']*$this->data['AcpExpense']['unit_amount'];
		}
		$this->set(compact('lineTotal'));
	}
	public function calculateGrandTotal($qty = NULL, $unitAmount = NULL, $taxincluded = NULL, $taxId = NULL, $taxGroupId = NULL, $currency_code = null) {
		$final['subTotal'] 	= 0;
		$final['tax'] 		= NULL;
		$final['total']		= 0;
        if($currency_code) $this->request->data['AcpExpense']['qty'] = $currency_code;
        if($qty) $this->request->data['AcpExpense']['qty'] = $qty;
		if($unitAmount) $this->request->data['AcpExpense']['unit_amount'] = $unitAmount;
		if($taxId) $this->request->data['AcpExpense']['tax_inventory'] = $taxId;
		if($taxGroupId) $this->request->data['AcpExpense']['tax_inventory'] = $taxGroupId;
		if($taxincluded) $this->request->data['AcpExpense']['tax_inclusive'] = $taxincluded;
        $final['currency_code'] = $this->data['AcpExpense']['currency_code'];
		if(!empty($this->data['AcpExpense']['qty']) && !empty($this->data['AcpExpense']['unit_amount'])) {
			$lineTotal = $this->data['AcpExpense']['qty']*$this->data['AcpExpense']['unit_amount'];
			if($this->data['AcpExpense']['tax_inclusive'] == 'tax included') {
				$this->loadModel('SbsSubscriberTax');
				$taxID = explode('-', $this->data['AcpExpense']['tax_inventory']);
				if(empty($taxID[1])) {
					$taxDetails = $this->SbsSubscriberTax->getTaxById($taxID[0]);
					$final['subTotal'] 	= ($lineTotal*100)/(100+$taxDetails['SbsSubscriberTax']['percent']);
					if(!empty($this->data['AcpExpense']['tax_inventory'])) {
						$totalTaxAmount = $lineTotal - $final['subTotal'];
						$final['tax'][$taxDetails['SbsSubscriberTax']['id']]['taxName'] = $taxDetails['SbsSubscriberTax']['code'].' (@'.$taxDetails['SbsSubscriberTax']['percent'].'%)';
						$final['tax'][$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] = $totalTaxAmount;
					}
				} else {
					$subtotal = 1;$q1=1;$taxAmount1=0;$taxArrayCount=0;
					$this->loadModel('SbsSubscriberTaxGroupMapping');
					$groupTaxMap = $this->SbsSubscriberTaxGroupMapping->getGroupMapping($taxID[1]);
					$compounded = FALSE;
					foreach($groupTaxMap as $key=>$val1) {
						$taxArrayCount++;$taxAmount = 0;
						if($val1['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y') {
							$taxAmount1 = $taxAmount1 + (($taxAmount1/100)*($val1['SbsSubscriberTax']['percent']/100))*100 + $val1['SbsSubscriberTax']['percent'];
							$compounded = TRUE;
							
						} else {
							$taxAmount1 += $val1['SbsSubscriberTax']['percent'];
						}
					}
					if($compounded || $compoundedPos > 1) {
						$final['subTotal'] 	= (($lineTotal*0.01)/(($taxAmount1+100)/100)*100);
					} else {
						$final['subTotal'] 	= ($lineTotal*100)/($taxAmount1+100);
					}
					$tempSubTotal = $final['subTotal'];
					$taxTTotal=0;
					foreach ($groupTaxMap as $key2 => $val2) {
						$final['tax'][$val2['SbsSubscriberTax']['id']]['taxName'] = $val2['SbsSubscriberTax']['code'].' (@'.$val2['SbsSubscriberTax']['percent'].'%)';
						if($val2['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y') {
							$tempSubTotal += $taxTTotal;
							$final['tax'][$val2['SbsSubscriberTax']['id']]['taxAmount'] = $tempSubTotal*($val2['SbsSubscriberTax']['percent']/100);
							$tempSubTotal += $final['tax'][$val2['SbsSubscriberTax']['id']]['taxAmount'];
						} else {
							$final['tax'][$val2['SbsSubscriberTax']['id']]['taxAmount'] = $final['subTotal']*($val2['SbsSubscriberTax']['percent']/100);
							$taxTTotal += $final['tax'][$val2['SbsSubscriberTax']['id']]['taxAmount'];
						}
					}
				}
				$final['total'] =  $lineTotal;
			} else {
				$final['total'] = $lineTotal;
				if(!empty($this->data['AcpExpense']['tax_inventory'])) {
					$this->loadModel('SbsSubscriberTax');
					$taxID = explode('-', $this->data['AcpExpense']['tax_inventory']);
					if(empty($taxID[1])) {
						$taxDetails = $this->SbsSubscriberTax->getTaxById($taxID[0]);
						if($taxDetails){
							$final['tax'][$taxDetails['SbsSubscriberTax']['id']]['taxName'] = $taxDetails['SbsSubscriberTax']['code'].' (@'.$taxDetails['SbsSubscriberTax']['percent'].'%)';
							$taxAmount = ($lineTotal * $taxDetails['SbsSubscriberTax']['percent'])/100;
							$final['tax'][$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] = $final['tax'][$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
							$totalTaxAmount += $taxAmount;
						}
					} else {
						$this->loadModel('SbsSubscriberTaxGroupMapping');
						$groupTaxMap = $this->SbsSubscriberTaxGroupMapping->getGroupMapping($taxID[1]);
						$tempLineTotal = $lineTotal;
						foreach($groupTaxMap as $key=>$val1){
							$final['tax'][$val1['SbsSubscriberTax']['id']]['taxName'] = $val1['SbsSubscriberTax']['code'].' (@'.$val1['SbsSubscriberTax']['percent'].'%)';
							if($val1['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y') {
								$taxAmount = ($tempLineTotal*$val1['SbsSubscriberTax']['percent'])/100;
								$final['tax'][$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
								$totalTaxAmount += $taxAmount;
							} else {
								$taxAmount = ($lineTotal * $val1['SbsSubscriberTax']['percent'])/100;
								$final['tax'][$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
								$totalTaxAmount += $taxAmount;
							}
							$tempLineTotal += $taxAmount;
						}
					}
					$final['subTotal'] 	= $lineTotal;
				} else {
					$final['subTotal'] 	= $lineTotal;
				}
				$final['total'] =  $final['subTotal'] + $totalTaxAmount;
				$final['taxx_total'] = $totalTaxAmount;
			}
		}
		$this->set(compact('final'));
		return $final;
	}


	public function convertToInvoice($expenseID = NULL, $return = NULL,$expenseNo = NULL,$vendorName = NULL,$customerName = NULL,$fromDate = NULL,$toDate = NULL,$status = NULL,$page = 1) {
		$permission = $this->permission;
		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->loadModel('CpnSubscriptionPlan');
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('InvInventory');
		$cpn_subscription_plan_id = $this->Session->read('Auth.User.SbsSubscriber.cpn_subscription_plan_id');
		$noOfInvoices = $this->CpnSubscriptionPlan->getSubscriptionNameById($cpn_subscription_plan_id);
		$presentCustCount = $this->AcrClientInvoice->find('count',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.status !='=>'Canceled')));
		if(($noOfInvoices['CpnSubscriptionPlan']['no_of_invoices'] > $presentCustCount) || $noOfInvoices['CpnSubscriptionPlan']['no_of_invoices'] == -1) {
			$expenseDetails = $this->AcpExpense->find('first',array('conditions'=>array('AcpExpense.id'=>$expenseID,'AcpExpense.sbs_subscriber_id'=>$this->subscriber)));
            if(!empty($expenseDetails) && !empty($expenseDetails['AcpExpense']['acr_client_id'])) {
				$this->loadModel('AcrClientInvoice');
				$this->loadModel('SbsSubscriberPaymentTerm');
				$paymentTerm = $this->SbsSubscriberPaymentTerm->getDefaultTerm($this->subscriber);
				$enddate = $this->requestAction('/acr_client_invoices/findEndDate/'.date('d M Y').'/'.$paymentTerm['SbsSubscriberPaymentTerm']['id']);
				$this->loadModel('SbsSubscriberSetting');
				$this->loadModel('CpnCurrency');
				$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
				$defaultCurrency 	 = $settings['SbsSubscriberSetting']['cpn_currency_id'];
				$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
				$defaultCurrencyCode = $defaultCurrencyInfo['CpnCurrency']['code'];
				$productDetails = $this->AcpInventoryExpense->find('first',array('conditions'=>array('acp_expense_id'=>$expenseDetails['AcpExpense']['id'])));
				$inventory = $this->InvInventory->findById($productDetails['AcpInventoryExpense']['inv_inventory_id']);
				if((!empty($inventory)) && ($inventory['InvInventory']['track_quantity'] == 'Y') && ($inventory['InvInventory']['current_stock'] < $productDetails['AcpInventoryExpense']['quantity'])) {
					if($return) {
						return FALSE;
					} else {
						$this->Session->setFlash('<div class="alert alert-danger">Error occurred. Not enough stock to create invoice.</div>');
						$this->redirect(array('controller'=>'acr_client_invoices','action'=>'edit',$invID));
					}
				}
				$this->loadModel('AcrClient');
                $this->loadModel('CpnCurrency');
                $clientCurrencyId   = $this->AcrClient->getClientCurrency($expenseDetails['AcpExpense']['acr_client_id']);
                $clientCurrencyCode = $this->CpnCurrency->findById($clientCurrencyId['AcrClient']['cpn_currency_id']);
                $createInvoice    = NULL;
				$createInvoice['AcrClientInvoice']['invoice_number']    = $this->generateInvoiceNumber($this->subscriber);
				$createInvoice['AcrClientInvoice']['invoiced_date']     = date('Y-m-d');
				$createInvoice['AcrClientInvoice']['due_date']          = $enddate;
				$createInvoice['AcrClientInvoice']['status']            = 'Draft';
				$createInvoice['AcrClientInvoice']['notes']             = $expenseDetails['AcpExpense']['notes'];
				$createInvoice['AcrClientInvoice']['sub_total']         = round($expenseDetails['AcpExpense']['sub_total'],2);
				$createInvoice['AcrClientInvoice']['tax_total']         = round($expenseDetails['AcpExpense']['tax_total'],2);
				$createInvoice['AcrClientInvoice']['sbs_subscriber_id'] = $this->subscriber;
				$createInvoice['AcrClientInvoice']['acr_client_id']     = $expenseDetails['AcpExpense']['acr_client_id'];
				$createInvoice['AcrClientInvoice']['invoice_total']     = round($expenseDetails['AcpExpense']['amount'],2);
				$createInvoice['AcrClientInvoice']['func_currency_total']   = round($expenseDetails['AcpExpense']['amount'],2);
				$createInvoice['AcrClientInvoice']['invoice_currency_code'] = $clientCurrencyCode['CpnCurrency']['code'];
				$createInvoice['AcrClientInvoice']['updated_date']          = date('Y-m-d');
				$createInvoice['AcrClientInvoice']['sbs_subscriber_payment_term_id'] = $paymentTerm['SbsSubscriberPaymentTerm']['id'];
                $createInvoice['AcrClientInvoice']['notes']                 = $settings['SbsSubscriberSetting']['notes'];
                $createInvoice['AcrClientInvoice']['term_conditions']       = $settings['SbsSubscriberSetting']['terms_conditions'];
				$this->AcrClientInvoice->create();
				if($this->AcrClientInvoice->save($createInvoice)) {
					$invID = $this->AcrClientInvoice->getLastInsertId();
					$update = NULL;
					$update['AcpExpense']['id'] = $expenseDetails['AcpExpense']['id'];
					$update['AcpExpense']['status'] = 'Billed';
					$update['AcpExpense']['acr_client_invoice_id'] = $invID;
					$this->AcpExpense->save($update);
					
					if(!empty($inventory) && $inventory['InvInventory']['track_quantity'] == 'Y') {
						$updateInventory = NULL;
						$updateInventory['InvInventory']['id'] 				= $inventory['InvInventory']['id'];
						$updateInventory['InvInventory']['current_stock'] 	= $inventory['InvInventory']['current_stock'] - $productDetails['AcpInventoryExpense']['quantity'];
						$this->InvInventory->save($updateInventory);
					}
					
					
					
					
					$invProduct = NULL;
					if($expenseDetails['AcpExpense']['tax_included'] == 'Y') {
						$abcccc = NULL;
						$abcccc 													= ($expenseDetails['AcpExpense']['sub_total'] / $productDetails['AcpInventoryExpense']['quantity']);
						$invProduct['AcrInvoiceDetail']['unit_rate'] 				= round($abcccc,2);
						$invProduct['AcrInvoiceDetail']['line_total'] 				= round($expenseDetails['AcpExpense']['sub_total'],2);
					} else {
						$invProduct['AcrInvoiceDetail']['unit_rate'] 				= round($productDetails['AcpInventoryExpense']['cost_price'],2);
						$invProduct['AcrInvoiceDetail']['line_total'] 				= round($expenseDetails['AcpExpense']['sub_total'],2);
					}
					$invProduct['AcrInvoiceDetail']['quantity'] 					= $productDetails['AcpInventoryExpense']['quantity'];
					
					$invProduct['AcrInvoiceDetail']['acr_client_invoice_id'] 		= $invID;
                    $invProduct['AcrInvoiceDetail']['inventory_description']        = $productDetails['AcpInventoryExpense']['inventory_description'];
                    if(empty($productDetails['AcpInventoryExpense']['inv_inventory_id'])) {
                        $productDetails['AcpInventoryExpense']['inv_inventory_id'] = -1;
                    }
					$invProduct['AcrInvoiceDetail']['inv_inventory_id'] 			= $productDetails['AcpInventoryExpense']['inv_inventory_id'];
					$invProduct['AcrInvoiceDetail']['sbs_subscriber_tax_id'] 		= $productDetails['AcpInventoryExpense']['sbs_subscriber_tax_id'];
					$invProduct['AcrInvoiceDetail']['sbs_subscriber_tax_group_id'] 	= $productDetails['AcpInventoryExpense']['sbs_subscriber_tax_group_id'];
					$this->loadModel('AcrInvoiceDetail');
					$this->AcrInvoiceDetail->create();
					$this->AcrInvoiceDetail->save($invProduct);
					if($return) {
						return $invID;
					} else {
						$this->Session->setFlash('<div class="alert alert-block alert-success">Expense has been converted to invoice.</div>');
						$this->redirect(array('controller'=>'acr_client_invoices','action'=>'edit',$invID));
					}
				} else {
					if($return) {
						return FALSE;
					} else {
						$this->Session->setFlash('<div class="alert alert-danger">Error occurred couldn\'t convert to invoice.</div>');
						$this->redirect(array('action'=>'index',$expenseNo,$vendorName,$customerName,$fromDate,$toDate,$status,'page:'.$page));
					}
				}
			} else {
				if($return) {
					return FALSE;
				} else {
					$this->Session->setFlash('<div class="alert alert-danger">Internal server error occurred couldn\'t convert to invoice.</div>');
					$this->redirect(array('action'=>'index',$expenseNo,$vendorName,$customerName,$fromDate,$toDate,$status,'page:'.$page));
				}
			}
		} else {
			$this->Session->setFlash('<div class="alert alert-danger">Invoice limit is over couldn\'t convert to invoice. Please upgrade plan to create new invoice.</div>');
			$this->redirect(array('action'=>'index',$customer, $min, $max, $status, $from, $to, 'page:'.$page));
		}
	}

	public function getCustomValues($id	= NULL) {
		$this->loadModel('AcpExpenseCustomField');
		return $this->AcpExpenseCustomField->find('all',array(
			'joins'=>array(array(
				'table'=>'acp_expense_custom_field_values',
				'alias' =>'AcpExpenseCustomFieldValue',
				'type' =>'RIGHT',
				'conditions' =>array('AcpExpenseCustomField.id = AcpExpenseCustomFieldValue.acp_expense_custom_field_id','AcpExpenseCustomFieldValue.acp_expense_id'=>$id)
			)),
			'fields' =>array('AcpExpenseCustomField.*','AcpExpenseCustomFieldValue.*'),
			'conditions'=>array('AcpExpenseCustomField.sbs_subscriber_id'=>$this->subscriber)
		));
	}
	
	public function getTaxCalculation($invoiceDetail = null,$subTotalParameter = NULL){
		if($invoiceDetail){
			foreach($invoiceDetail as $key=>$invoiceDetailValue){
				if($invoiceDetailValue['AcpInventoryExpense']['sbs_subscriber_tax_group_id']) {
					$this->loadModel('SbsSubscriberTaxGroupMapping');
					$groupTaxMap = $this->SbsSubscriberTaxGroupMapping->getGroupMapping($invoiceDetailValue['AcpInventoryExpense']['sbs_subscriber_tax_group_id']);
					$tempLineTotal = $subTotalParameter;
					foreach($groupTaxMap as $key=>$val1){
						$taxArray[$val1['SbsSubscriberTax']['id']]['taxName'] = $val1['SbsSubscriberTax']['code'].' (@'.$val1['SbsSubscriberTax']['percent'].'%)';
						if($val1['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y') {
							$taxAmount = ($tempLineTotal*$val1['SbsSubscriberTax']['percent'])/100;
							$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
							$totalTaxAmount += $taxAmount;
						} else {
							$taxAmount = ($subTotalParameter * $val1['SbsSubscriberTax']['percent'])/100;
							$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
							$totalTaxAmount += $taxAmount;
						}
						$tempLineTotal += $taxAmount;
					}
				} elseif($invoiceDetailValue['AcpInventoryExpense']['sbs_subscriber_tax_id']) {
					
					$this->loadModel('SbsSubscriberTax');
					$product = $subTotalParameter;
					$taxDetails = $this->SbsSubscriberTax->getTaxById($invoiceDetailValue['AcpInventoryExpense']['sbs_subscriber_tax_id']);
					if($taxDetails){
						$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxName'] = $taxDetails['SbsSubscriberTax']['code'].' (@'.$val1['SbsSubscriberTax']['percent'].'%)';
						$taxAmount = ($product * $taxDetails['SbsSubscriberTax']['percent'])/100;
						$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
					}
				}
			}
			return $taxArray;
		}
	}

	public function export() {
		$export = FALSE;
		$menuActive = 'Manage Expenses';
		$this->set(compact('menuActive'));
		if(!empty($this->data)) {
			$export = TRUE;
			$settings 	= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
			$defaultCurrency 	 = $settings['SbsSubscriberSetting']['cpn_currency_id'];
			$this->loadModel('CpnCurrency');
			$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
			$defaultCurrencyCode = $defaultCurrencyInfo['CpnCurrency']['code'];
			
			$this->AcpExpense->recursive = 0;
			$this->AcpExpense->unbindModel(array('belongsTo'=>array('SbsSubscriber')));
			if(!empty($this->request->data['Filter']['expense_no'])) {
				$expenseNo = trim($this->request->data['Filter']['expense_no']);
				if($expenseNo) {
					$expenseNoCondtn = array('AcpExpense.expense_no LIKE'=>'%'.$expenseNo.'%');
				}
			}
			if(!empty($this->request->data['Filter']['vendor_name'])) {
				$vendorName = trim($this->request->data['Filter']['vendor_name']);
				if($vendorName) {
					$vendorNameCondtn = array('AcpVendor.vendor_name LIKE'=>'%'.$vendorName.'%');
				}
			}
			if(!empty($this->request->data['Filter']['customer_name'])) {
				$customerName = trim($this->request->data['Filter']['customer_name']);
				if($customerName) {
					$customerNameCondtn = array('AcrClient.organization_name LIKE' =>'%'.$customerName.'%');
				}
			}
			if(!empty($this->request->data['Filter']['from_date'])) {
				$fromDate = trim($this->request->data['Filter']['from_date']);
			}
			if(!empty($this->request->data['Filter']['to_date'])) {
				$toDate = trim($this->request->data['Filter']['to_date']);
			}
			if($fromDate && $toDate) {
				$dateCondtn = array('AcpExpense.date BETWEEN ? AND ?'=>array(date('Y-m-d',strtotime(str_replace('/', '-', $fromDate))),date('Y-m-d',strtotime(str_replace('/', '-', $toDate)))));
			} elseif($fromDate && !$toDate) {
				$dateCondtn = array('AcpExpense.date >='=>date('Y-m-d',strtotime(str_replace('/', '-', $fromDate))));
			} elseif(!$fromDate && $toDate) {
				$dateCondtn = array('AcpExpense.date <='=>date('Y-m-d',strtotime(str_replace('/', '-', $toDate)))); 
			}
			if(!empty($this->request->data['Filter']['status'])) {
				$status = trim($this->request->data['Filter']['status']);
				$statusCondtn = array('AcpExpense.status'=>$status);
			}
			$subscriberCondtn = array('AcpExpense.sbs_subscriber_id' => $this->subscriber); 
			$conditions = array($subscriberCondtn,$expenseNoCondtn,$vendorNameCondtn,$customerNameCondtn,$dateCondtn,$statusCondtn);
			
			$expenses = $this->AcpExpense->find('all',array(
				'joins'=>array(
					array('table'=>'acp_inventory_expenses','alias'=>'AcpInventoryExpense','type'=>'LEFT','conditions'=>array('AcpInventoryExpense.acp_expense_id = AcpExpense.id','AcpInventoryExpense.sbs_subscriber_id'=>$this->subscriber)),
					array('table'=>'inv_inventories','alias'=>'InvInventory','type'=>'LEFT','conditions'=>array('InvInventory.id = AcpInventoryExpense.inv_inventory_id','InvInventory.sbs_subscriber_id'=>$this->subscriber)),
					array('table'=>'sbs_subscriber_taxes','alias'=>'SbsSubscriberTax','type'=>'LEFT','conditions'=>array('AcpInventoryExpense.sbs_subscriber_tax_id = SbsSubscriberTax.id')),
					array('table'=>'sbs_subscriber_tax_groups','alias'=>'SbsSubscriberTaxGroup','type'=>'LEFT','conditions'=>array('AcpInventoryExpense.sbs_subscriber_tax_group_id = SbsSubscriberTaxGroup.id'))
				),
				'conditions'=>$conditions,
				'fields'=>array('AcpExpense.*','AcpExpenseCategory.id','AcpExpenseCategory.category_name','AcrClient.organization_name','AcrClient.id','AcpVendor.*','AcpInventoryExpense.*','SbsSubscriberTax.id','SbsSubscriberTax.name','SbsSubscriberTaxGroup.id','SbsSubscriberTaxGroup.group_name','InvInventory.id','InvInventory.name')
			));
			$this->loadModel('AcpExpenseCustomField');
			$expenseFields = $this->AcpExpenseCustomField->getListOfFields($this->subscriber);
			$this->loadModel('AcpExpenseCustomFieldValue');
			foreach($expenses as $key => $expense) {
				$expenses[$key] = $expense;
				$expenses[$key]['CustomValues'] = $this->AcpExpenseCustomFieldValue->find('all',array('conditions'=>array('AcpExpenseCustomFieldValue.acp_expense_id'=>$expense['AcpExpense']['id'])));
			}
			$this->set(compact('export','expenses','settings','defaultCurrencyCode','expenseFields'));
		}
	}


	public function import() {
		$permission = $this->permission;
		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		if(!empty($this->data)) {
			$this->loadModel('SbsSubscriberTax');
			$this->loadModel('SbsSubscriberTaxGroup');
			$this->loadModel('SbsSubscriberTaxGroupMapping');
			$this->loadModel('AcrInvoiceDetail');
			$this->loadModel('InvInventory');
			$this->loadModel('AcpExpenseCustomField');
			$this->loadModel('AcpExpenseCustomFieldValue');
			if((($_FILES['file']['type'] == 'application/vnd.ms-excel') || ($_FILES['file']['type'] == 'application/octet-stream'))){
				$fileOK = $this->uploadFiles('files', $_FILES);
				if($fileOK['urls']['0']){
					$settings 	= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
					$dateFormat = $settings['SbsSubscriberSetting']['date_format'];
					$fileUploadSuccess = TRUE;
					$excel = new Spreadsheet_Excel_Reader;
					$excel->read($fileOK['urls']['0']);
					$nr_sheets = count($excel->sheets);
					$excel_data = '';
					$sheetOrderProvided = array('0'=>'Instruction Sheet','1'=>'Expense Informations');
					$wrongOrder = FALSE;
					foreach($sheetOrderProvided as $key1=>$val1) {
						if($excel->boundsheets[$key1]['name'] != $val1) {
							$wrongOrder = TRUE;
						}
					}
					if($wrongOrder) {
						$documentPath = WWW_ROOT.$fileOK['urls']['0'];
						unlink($documentPath);
						$this->Session->setFlash(('<div class="alert alert-danger">'.__('Please use the default excel format,sheet name and sheet order').'</div>'));
						$this->redirect(array('action'=>'import'));
					}
					$totalCountAfterImport = $presentCustCount + $excel->sheets['1']['numRows'] -1;
					for($i=1; $i<$nr_sheets; $i++) {
						if($excel->boundsheets[$i]['name'] == 'Expense Informations'){
							$expenseInformation = $this->sheetData($excel->sheets[$i],$excel->boundsheets[$i]['name']) ;
						}
					}
					
					$invoiceImportCount = 0;
					foreach($expenseInformation as $key => $expenseDetail) {
						$proceed = TRUE;
						if(empty($expenseDetail['Expense Date'])) {
							$proceed = FALSE;
							$errorMessage[$key]['Reference Number'] =  $expenseDetail['Reference Number *'];
							$errorMessage[$key]['Expense Date']  =  $expenseDetail['Expense Date'];
							$errorMessage[$key]['Error Message']  =  'Please enter a valid expense date.';
						} elseif(empty($expenseDetail['Category Name'])) {
							$proceed = FALSE;
							$errorMessage[$key]['Reference Number'] =  $expenseDetail['Reference Number *'];
							$errorMessage[$key]['Expense Date']  =  $expenseDetail['Expense Date'];
							$errorMessage[$key]['Error Message']  =  'Please enter a valid category name.';
						} elseif(empty($expenseDetail['Reference Number *'])) {
							$proceed = FALSE;
							$errorMessage[$key]['Reference Number'] =  $expenseDetail['Reference Number *'];
							$errorMessage[$key]['Expense Date']  =  $expenseDetail['Expense Date'];
							$errorMessage[$key]['Error Message']  =  'Please enter a reference number.';
						} elseif(empty($expenseDetail['Vendor Name'])) {
							$proceed = FALSE;
							$errorMessage[$key]['Reference Number'] =  $expenseDetail['Reference Number *'];
							$errorMessage[$key]['Expense Date']  =  $expenseDetail['Expense Date'];
							$errorMessage[$key]['Error Message']  =  'Please enter a vendor name';
						} elseif(empty($expenseDetail['Vendor Name'])) {
							$proceed = FALSE;
							$errorMessage[$key]['Reference Number'] =  $expenseDetail['Reference Number *'];
							$errorMessage[$key]['Expense Date']  =  $expenseDetail['Expense Date'];
							$errorMessage[$key]['Error Message']  =  'Please enter a vendor name';
						} elseif(empty($expenseDetail['Quantity *'])) {
							$expenseDetail['Quantity'] = 1;
						} elseif(empty($expenseDetail['Unit Rate *'])) {
							$expenseDetail['Unit Rate'] = 1;
						}
						
						/*if(empty($expenseDetail['Item'])) {
							$proceed = FALSE;
							$errorMessage[$key]['Reference Number'] =  $expenseDetail['Reference Number *'];
							$errorMessage[$key]['Expense Date']  =  $expenseDetail['Expense Date'];
							$errorMessage[$key]['Error Message']  =  'Inventory not found';
						}*/
						
						$exist = $this->AcpExpense->find('first',array('fields'=>array('id'),'conditions'=>array('AcpExpense.expense_no'=>$expenseDetail['Reference Number *'],'sbs_subscriber_id'=>$this->subscriber)));
						if(!empty($exist)) {
							$proceed = FALSE;
							$errorMessage[$key]['Reference Number'] =  $expenseDetail['Reference Number *'];
							$errorMessage[$key]['Expense Date']  =  $expenseDetail['Expense Date'];
							$errorMessage[$key]['Error Message']  =  'Reference Number already exist';
						}
						
						if($proceed) {
							$save = NULL;
							$save['AcpExpense']['expense_no'] = $expenseDetail['Reference Number *'];
							$save['AcpExpense']['date'] = $expenseDetail['Expense Date'];
							$save['AcpExpense']['acp_vendor_id'] = $expenseDetail['Vendor Name'];
							$finalDetail = $this->calculateGrandTotal($expenseDetail['Quantity *'], $expenseDetail['Unit Rate *'], $expenseDetail['Tax included *'], $expenseDetail['Tax Name'], $expenseDetail['Tax Group Name']);
							$save['AcpExpense']['sub_total'] = $finalDetail['subTotal'];
							$save['AcpExpense']['tax_total'] = $finalDetail['taxx_total'];
							$save['AcpExpense']['amount'] = $finalDetail['total'];
							$save['AcpExpense']['notes'] = $expenseDetail['Notes'];
							$save['AcpExpense']['tax_included'] = $expenseDetail['Tax included *'];
							if($expenseDetail['Customer Organization Name']) $status = 'Billable'; else $status = 'Non Billable';
							$save['AcpExpense']['status'] = $status;
							$save['AcpExpense']['acp_expense_category_id'] = $expenseDetail['Category Name'];
							$save['AcpExpense']['sbs_subscriber_id'] = $this->subscriber;
							$save['AcpExpense']['acr_client_id'] = $expenseDetail['Customer Organization Name'];
							$this->AcpExpense->create();
							if($this->AcpExpense->save($save)) {
								$invoiceImportCount++;
								$saveUpdate = NULL;
								$lastInsertId = $this->AcpExpense->getlastInsertId();
								$saveUpdate['AcpInventoryExpense']['quantity'] = $expenseDetail['Quantity *'];
								$saveUpdate['AcpInventoryExpense']['cost_price'] = $expenseDetail['Unit Rate *'];
								$saveUpdate['AcpInventoryExpense']['total_amount'] = $finalDetail['subTotal'];
								$saveUpdate['AcpInventoryExpense']['inv_inventory_id'] = $expenseDetail['Item'];
								$saveUpdate['AcpInventoryExpense']['inventory_description'] = $expenseDetail['Item Description'];
								$saveUpdate['AcpInventoryExpense']['acp_expense_id'] = $lastInsertId;
								$saveUpdate['AcpInventoryExpense']['sbs_subscriber_id'] = $this->subscriber;
								$saveUpdate['AcpInventoryExpense']['sbs_subscriber_tax_id'] = $expenseDetail['Tax Name'];
								$saveUpdate['AcpInventoryExpense']['sbs_subscriber_tax_group_id'] = $expenseDetail['expense_groupid'];
								$this->AcpInventoryExpense->create();
								$this->AcpInventoryExpense->save($saveUpdate);
								$ids = $this->AcpExpenseCustomField->find('all',array('conditions'=>array('AcpExpenseCustomField.sbs_subscriber_id'=>$this->subscriber),'fields'=>array('id'),'order'=>array('AcpExpenseCustomField.id'=>'Asc')));
								for($ci = 1;$ci<= 5; $ci++) {
									if($expenseDetail['Custom Field '.$ci]) {
										if(!empty($ids[$ci-1]['AcpExpenseCustomField']['id']) && !empty($lastInsertId)) {
											$saveCustomValues = NULL;
											$saveCustomValues['AcpExpenseCustomFieldValue']['data']							= $expenseDetail['Custom Field '.$ci];
											$saveCustomValues['AcpExpenseCustomFieldValue']['acp_expense_id']				= $lastInsertId;
											$saveCustomValues['AcpExpenseCustomFieldValue']['acp_expense_custom_field_id']	= $ids[$ci-1]['AcpExpenseCustomField']['id'];
											$this->AcpExpenseCustomFieldValue->create();
											$this->AcpExpenseCustomFieldValue->save($saveCustomValues);
										}	
									}
								}
							}
						}
					}
					$this->set(compact('invoiceImportCount','errorMessage','fileUploadSuccess','dateFormat'));
				}
			} else {
				$this->Session->setFlash('<div class="alert alert-danger">Please upload the excel file</div>');
			}
			$documentPath = WWW_ROOT.$fileOK['urls']['0'];
			unlink($documentPath);	
		}
	}

	
	public function sheetData($sheet,$sheetName) {
		$this->loadModel('AcrClient');
		$this->loadModel('InvInventory');
		$this->loadModel('SbsSubscriberTax');
		$this->loadModel('SbsSubscriberTaxGroup');
		$fieldsArray = $sheet['cells']['1'];
		$countRecords = count($sheet['cells']);
		foreach($fieldsArray as $key => $val) {
			for($i=2;$i<=$countRecords;$i++) {
				if($sheetName == 'Expense Informations') {
					if($sheet['cells'][$i][$key]){
					switch ($val) {
						case 'Expense Date *':
							if(!empty($sheet['cells'][$i][$key])) {
								$expenseDataArray[$i]['Expense Date'] = date('Y-m-d',strtotime(str_replace('/', '-', $sheet['cells'][$i][$key])));
							}
							break;
						case 'Category Name *':
							$expenseDataArray[$i]['Category Name'] = $this->AcpExpenseCategory->getCategoryIdByName($sheet['cells'][$i][$key]);
							break;
						case 'Vendor Name *':
							if(!empty($sheet['cells'][$i][$key])) {
								$vendorName = $this->AcpVendor->getIDbyName($sheet['cells'][$i][$key]);
								if(!empty($vendorName)) $expenseDataArray[$i]['Vendor Name'] = $vendorName; else $expenseDataArray[$i]['Vendor Name'] = NULL;
							} 
							break;
						case 'Customer Organization Name':
							$expenseDataArray[$i][$val] = $this->AcrClient->getClientIdByOrganisationName($sheet['cells'][$i][$key],$this->subscriber);
							break;
						case 'Item Name *':
							$itemIDD = $this->InvInventory->getInventoryByName($sheet['cells'][$i][$key],$this->subscriber);
							if(!empty($itemIDD)) $expenseDataArray[$i]['Item'] = $itemIDD; else $expenseDataArray[$i]['Item'] = NULL;
							break;
						case 'Tax Name':
							$expenseDataArray[$i][$val] = $this->SbsSubscriberTax->getTaxByName($sheet['cells'][$i][$key],$this->subscriber);
							break;
						case 'Tax Group Name':
							if(!empty($sheet['cells'][$i][$key])) {
								$taxgroupIDD = $this->SbsSubscriberTaxGroup->getTaxGroupByName($sheet['cells'][$i][$key],$this->subscriber);
								if(!empty($taxgroupIDD)) {$expenseDataArray[$i][$val] = $sheet['cells'][$i][$key].'-'.$taxgroupIDD;$expenseDataArray[$i]['expense_groupid'] = $taxgroupIDD;} else {$expenseDataArray[$i][$val] = null;$expenseDataArray[$i]['expense_groupid'] = NULL;}
							}
							break;
						default:
							$expenseDataArray[$i][$val] = $sheet['cells'][$i][$key];
							break;
					}
				}
				}
			}
		}
		return $expenseDataArray;
	}

	public function downloadSampleSheet() {
		$this->viewClass = 'Media';
    	$params = array('id'=>'expenses.xls','name'=> 'expenses','download'=>true,'extension'=>'xls','path'=>'files'.DS);
    	$this->set($params);
	}
	
	public function downloadFile($filePath = NULL) {
		$fullPath = $_SERVER['DOCUMENT_ROOT'].$this->params->query['url']; // change the path to fit your websites document structure
		$fd = fopen ($fullPath, "r");
		$fsize = filesize($fullPath);
	    $path_parts = pathinfo($fullPath);
	    $ext = strtolower($path_parts["extension"]);
		$this->viewClass = 'Media';
	    $params = array('id'=>$path_parts["basename"],'name'=> $path_parts["filename"],'download'=>true,'extension'=>$ext,'path'=>$path_parts['dirname'].DS);
	    $this->set($params);
	}
	
	
	public function checkReferenceNumber($id = NULL) {
		$this->autoRender = FALSE;
		$referenceNumber = trim($this->data['AcpExpense']['reference_no']);
		$exist = NULL;
		if($id) {
			$exist = $this->AcpExpense->find('first',array('fields'=>array('id'),'conditions'=>array('AcpExpense.expense_no'=>$referenceNumber,'sbs_subscriber_id'=>$this->subscriber,'NOT'=>array('id'=>$id))));
		} else {
			$exist = $this->AcpExpense->find('first',array('fields'=>array('id'),'conditions'=>array('AcpExpense.expense_no'=>$referenceNumber,'sbs_subscriber_id'=>$this->subscriber)));
		}
		if(empty($exist)) {
			return 'false';
		} else {
			return 'true';
		}
	}
	
	public function delete_receipt($id=null,$expenseNo=null,$vendorName=null,$customerName=null,$fromDate=null,$toDate=null,$status=null,$page=1){
		
		$this->loadModel('AcpExpense');
		$subscriber_id = $this->subscriber;
		$expense_detail=$this->AcpExpense->find('first',array('conditions'=>array('AcpExpense.id'=>$id)));
		if($expense_detail['AcpExpense']['id'] == $id){
			    	
		    $delete_receipt=null;
			$delete_receipt['AcpExpense']['id']             = $id;
			$delete_receipt['AcpExpense']['reciept_upload'] = NULL;
			if($this->AcpExpense->save($delete_receipt)){
				
				 
				 $file= WWW_ROOT.'files/uploads/expenses/Subscriber-'.$subscriber_id.'/'.$expense_detail['AcpExpense']['reciept_upload'];
				 unlink($file);
				 $this->Session->setFlash(__('<div class="alert alert-block alert-success">
														<button type="button" class="close" data-dismiss="alert">
															<i class="icon-remove"></i>
														</button>
			
														<p>
															<strong>
																<i class="icon-ok"></i>
																Done!
															</strong>Receipt has been deleted successfully.</p>
													</div>'));
				$this->redirect(array('action'=>'edit',$id,$expenseNo,$vendorName,$customerName,$fromDate,$toDate,$status,$page));								
			}else{
				$this->Session->setFlash(__('<div class="alert alert-danger">
													<button type="button" class="close" data-dismiss="alert">
														<i class="icon-remove"></i>
													</button>
		
													<strong>
														<i class="icon-remove"></i>												
													</strong>Receipt cannot be deleted.<br />
												  </div>'));
			 $this->redirect(array('action'=>'edit',$id,$expenseNo,$vendorName,$customerName,$fromDate,$toDate,$status,$page));											  
			}
		}else{
			$this->Session->setFlash(__('<div class="alert alert-danger">
													<button type="button" class="close" data-dismiss="alert">
														<i class="icon-remove"></i>
													</button>
		
													<strong>
														<i class="icon-remove"></i>												
													</strong>Receipt cannot be deleted.<br />
												  </div>'));
			$this->redirect(array('action'=>'edit',$id,$expenseNo,$vendorName,$customerName,$fromDate,$toDate,$status,$page));									  
		}
		
		
	}
}
?>