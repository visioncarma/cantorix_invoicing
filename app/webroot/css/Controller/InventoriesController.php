<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'php-excel-reader/excel_reader2');
/**
 * InvInventories Controller
 *
 * @property InvInventory $InvInventory
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class InventoriesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');
	var $helpers = array('Xls');
	public function beforeFilter() {
      	 parent::beforeFilter();
	      	$this->layout = "sbs_layout";
	      		$this->Auth->allow();
	      		$this->loadModel('InvInventory');
	      		$this->permission = $this->Session->read('Auth.AllPermissions.Inventories');
	        	$this->subscriber = $this->Session->read('Auth.User.SbsSubscriber.id');
    }
/**
 * index method
 *
 * @return void
 */
	public function index($itemName = null,$minPrice = null,$maxPrice = null,$inHand = null,$pages=1) {
		
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		
		
		$this->loadModel('InvInventory');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('InvInventoryCustomField');
		$this->loadModel('InvInventoryCustomValue');
		$this->InvInventory->recursive = 0;
		if($itemName){
			if($itemName !="null"){
				$this->request->data['InventoryFilter']['item_name'] = $itemName;
			}
			
		}if($minPrice && ($minPrice!="null")){
			$this->request->data['InventoryFilter']['price_min'] = $minPrice;
		}if($maxPrice && ($maxPrice!="null")){
			$this->request->data['InventoryFilter']['price_max'] = $maxPrice;
		}if($inHand && ($inHand!="null")){
			$this->request->data['InventoryFilter']['quantity'] = $inHand;
		}
		$settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$limit = $settings['SbsSubscriberSetting']['lines_per_page'];
		if($this->data['InventoryFilter']){
			if($this->data['InventoryFilter']['item_name']){
				$itemName = $this->request->data['InventoryFilter']['item_name'];
				$this->set(compact('itemName'));
			}if($this->data['InventoryFilter']['price_min']){
				$minPrice = $this->data['InventoryFilter']['price_min'];
				$this->set(compact('minPrice'));
			}if($this->data['InventoryFilter']['price_max']){
				$maxPrice = $this->data['InventoryFilter']['price_max'];
				$this->set(compact('maxPrice'));
			}if($this->data['InventoryFilter']['quantity']){
				$inHand = $this->data['InventoryFilter']['quantity'];
				$this->set(compact('inHand'));
			}
			
			
			if(($this->request->data['InventoryFilter']['item_name']) && ($this->request->data['InventoryFilter']['price_min'] && ($this->request->data['InventoryFilter']['price_max']) && ($this->request->data['InventoryFilter']['quantity']))){
				if($this->request->data['InventoryFilter']['quantity'] == "in-stock"){
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.name like'=>'%'.$this->request->data['InventoryFilter']['item_name'].'%','InvInventory.list_price BETWEEN ? and ?'=>array($this->request->data['InventoryFilter']['price_min'],$this->request->data['InventoryFilter']['price_max']),'InvInventory.current_stock >'=>0);
				}else{
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.name like'=>'%'.$this->request->data['InventoryFilter']['item_name'].'%','InvInventory.list_price BETWEEN ? and ?'=>array($this->request->data['InventoryFilter']['price_min'],$this->request->data['InventoryFilter']['price_max']),'InvInventory.current_stock <'=>1);
				}
			}elseif(($this->request->data['InventoryFilter']['item_name']) && (!$this->request->data['InventoryFilter']['price_min'] && ($this->request->data['InventoryFilter']['price_max']) && ($this->request->data['InventoryFilter']['quantity']))){
				if($this->request->data['InventoryFilter']['quantity'] == "in-stock"){
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.name like'=>'%'.$this->request->data['InventoryFilter']['item_name'].'%','InvInventory.list_price <='=>$this->request->data['InventoryFilter']['price_max'],'InvInventory.current_stock >'=>0);
				}else{
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.name like'=>'%'.$this->request->data['InventoryFilter']['item_name'].'%','InvInventory.list_price <='=>$this->request->data['InventoryFilter']['price_max'],'InvInventory.current_stock <'=>1);
				}
			}elseif(($this->request->data['InventoryFilter']['item_name']) && (!$this->request->data['InventoryFilter']['price_min'] && ($this->request->data['InventoryFilter']['price_max']) && (!$this->request->data['InventoryFilter']['quantity']))){
				$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.name like'=>'%'.$this->request->data['InventoryFilter']['item_name'].'%','InvInventory.list_price <='=>$this->request->data['InventoryFilter']['price_max']);
			}elseif(($this->request->data['InventoryFilter']['item_name']) && (!$this->request->data['InventoryFilter']['price_min'] && (!$this->request->data['InventoryFilter']['price_max']) && ($this->request->data['InventoryFilter']['quantity']))){
				if($this->request->data['InventoryFilter']['quantity'] == "in-stock"){
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.name like'=>'%'.$this->request->data['InventoryFilter']['item_name'].'%','InvInventory.current_stock >'=>0);
				}else{
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.name like'=>'%'.$this->request->data['InventoryFilter']['item_name'].'%','InvInventory.current_stock <'=>1);
				}
			}elseif(($this->request->data['InventoryFilter']['item_name']) && (!$this->request->data['InventoryFilter']['price_min'] && (!$this->request->data['InventoryFilter']['price_max']) && (!$this->request->data['InventoryFilter']['quantity']))){
				$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.name like'=>'%'.$this->request->data['InventoryFilter']['item_name'].'%');
			}elseif((!$this->request->data['InventoryFilter']['item_name']) && (!$this->request->data['InventoryFilter']['price_min'] && (!$this->request->data['InventoryFilter']['price_max']) && ($this->request->data['InventoryFilter']['quantity']))){
				if($this->request->data['InventoryFilter']['quantity'] == "in-stock"){
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.current_stock >'=>0);
				}else{
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.current_stock <'=>1);
				}
			}elseif((!$this->request->data['InventoryFilter']['item_name']) && ($this->request->data['InventoryFilter']['price_min'] && ($this->request->data['InventoryFilter']['price_max']) && (!$this->request->data['InventoryFilter']['quantity']))){
				$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.list_price BETWEEN ? and ?'=>array($this->request->data['InventoryFilter']['price_min'],$this->request->data['InventoryFilter']['price_max']));
			}elseif((!$this->request->data['InventoryFilter']['item_name']) && ($this->request->data['InventoryFilter']['price_min'] && (!$this->request->data['InventoryFilter']['price_max']) && ($this->request->data['InventoryFilter']['quantity']))){
				if($this->request->data['InventoryFilter']['quantity'] == "in-stock"){
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.list_price  >='=>$this->request->data['InventoryFilter']['price_min'],'InvInventory.current_stock >'=>0);
				}else{
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.list_price  >='=>$this->request->data['InventoryFilter']['price_min'],'InvInventory.current_stock <'=>1);
				}
			}elseif((!$this->request->data['InventoryFilter']['item_name']) && ($this->request->data['InventoryFilter']['price_min'] && (!$this->request->data['InventoryFilter']['price_max']) && (!$this->request->data['InventoryFilter']['quantity']))){
				$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.list_price  >='=>$this->request->data['InventoryFilter']['price_min']);
			}elseif((!$this->request->data['InventoryFilter']['item_name']) && (!$this->request->data['InventoryFilter']['price_min'] && ($this->request->data['InventoryFilter']['price_max']) && ($this->request->data['InventoryFilter']['quantity']))){
				if($this->request->data['InventoryFilter']['quantity'] == "in-stock"){
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.list_price <='=>$this->request->data['InventoryFilter']['price_max'],'InvInventory.current_stock >'=>0);
				}else{
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.list_price <='=>$this->request->data['InventoryFilter']['price_max'],'InvInventory.current_stock <'=>1);
				}
			}elseif((!$this->request->data['InventoryFilter']['item_name']) && (!$this->request->data['InventoryFilter']['price_min'] && ($this->request->data['InventoryFilter']['price_max']) && (!$this->request->data['InventoryFilter']['quantity']))){
				$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.list_price <='=>$this->request->data['InventoryFilter']['price_max']);
			}elseif((!$this->request->data['InventoryFilter']['item_name']) && (!$this->request->data['InventoryFilter']['price_min'] && (!$this->request->data['InventoryFilter']['price_max']) && ($this->request->data['InventoryFilter']['quantity']))){
				if($this->request->data['InventoryFilter']['quantity'] == "in-stock"){
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.current_stock >'=>0);
				}else{
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.current_stock <'=>1);
				}
			}elseif((!$this->request->data['InventoryFilter']['item_name']) && ($this->request->data['InventoryFilter']['price_min'] && ($this->request->data['InventoryFilter']['price_max']) && ($this->request->data['InventoryFilter']['quantity']))){
					if($this->request->data['InventoryFilter']['quantity'] == "in-stock"){
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.list_price BETWEEN ? and ?'=>array($this->request->data['InventoryFilter']['price_min'],$this->request->data['InventoryFilter']['price_max']),'InvInventory.current_stock >'=>0);
				}else{
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.list_price BETWEEN ? and ?'=>array($this->request->data['InventoryFilter']['price_min'],$this->request->data['InventoryFilter']['price_max']),'InvInventory.current_stock <'=>1);
				}
			}elseif(($this->request->data['InventoryFilter']['item_name']) && ($this->request->data['InventoryFilter']['price_min'] && (!$this->request->data['InventoryFilter']['price_max']) && (!$this->request->data['InventoryFilter']['quantity']))){
				$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.name like'=>'%'.$this->request->data['InventoryFilter']['item_name'].'%','InvInventory.list_price >='=>$this->request->data['InventoryFilter']['price_min']);
			}elseif(($this->request->data['InventoryFilter']['item_name']) && ($this->request->data['InventoryFilter']['price_min'] && (!$this->request->data['InventoryFilter']['price_max']) && ($this->request->data['InventoryFilter']['quantity']))){
				if($this->request->data['InventoryFilter']['quantity'] == "in-stock"){
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.name like'=>'%'.$this->request->data['InventoryFilter']['item_name'].'%','InvInventory.list_price >='=>$this->request->data['InventoryFilter']['price_min'],'InvInventory.current_stock >'=>0);
				}else{
					$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.name like'=>'%'.$this->request->data['InventoryFilter']['item_name'].'%','InvInventory.list_price >='=>$this->request->data['InventoryFilter']['price_min'],'InvInventory.current_stock <'=>1);
				}
			}elseif(($this->request->data['InventoryFilter']['item_name']) && ($this->request->data['InventoryFilter']['price_min'] && ($this->request->data['InventoryFilter']['price_max']) && (!$this->request->data['InventoryFilter']['quantity']))){
				$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber,'InvInventory.name like'=>'%'.$this->request->data['InventoryFilter']['item_name'].'%','InvInventory.list_price BETWEEN ? and ?'=>array($this->request->data['InventoryFilter']['price_min'],$this->request->data['InventoryFilter']['price_max']));
			}else{
				$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber);
			}
		}else{
			$conditions=array('InvInventory.sbs_subscriber_id'=>$this->subscriber);
		}
		$this->Paginator->settings = array('conditions'=>$conditions,'limit'=>$limit,'page'	=> $pages,'order' => array('name' => 'ASC'));
		$inVentoryList = $this->Paginator->paginate('InvInventory');
		
		$this->set('invInventories',$inVentoryList );
		$customFields = $this->InvInventoryCustomField->getListOfFields($this->subscriber);
		foreach($inVentoryList as $key=>$val){
			$customValue[$val['InvInventory']['id']] = $this->InvInventoryCustomValue->getCustomValueList($val['InvInventory']['id']);
		}
		
		$this->set(compact('customFields','customValue','permission'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->loadModel('InvInventory');
		if (!$this->InvInventory->exists($id)) {
			throw new NotFoundException(__('Invalid  inventory'));
		}
		$options = array('conditions' => array('InvInventory.' . $this->InvInventory->primaryKey => $id));
		$this->set('invInventory', $this->InvInventory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		$permission = $this->permission;
		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$title_for_layout = 'Add Item';
		$this->set(compact('title_for_layout'));
		$this->loadModel('InvInventoryUnitType');
		$this->loadModel('CpnCurrency');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('InvInventoryCustomField');
		if ($this->request->is('post') && ($this->data['InvInventory']['name'])) {
			$inventoryExist = $this->InvInventory->checkDuplicateInventory(trim($this->data['InvInventory']['name']),$this->subscriber);
			if(empty($inventoryExist)){
				$newInventory = $this->InvInventory->addInventory($this->data['InvInventory'],$this->subscriber);
				if($newInventory){
					$customFields = $this->InvInventoryCustomField->getListOfFields($this->subscriber);
					if($customFields){
						$this->loadModel('InvInventoryCustomValue');
						$customQueue = 1;
						foreach($customFields as $fieldId=>$fieldName){
							$addCustomValue = $this->InvInventoryCustomValue->addCustomValue($fieldId,$this->data['InvInventory']['customField'.$fieldId],$newInventory);
							$customQueue++;
						}
					}
					$this->Session->setFlash(__('<div class="alert alert-block alert-success">Inventory added succesfully.</div>'));
					return $this->redirect(array('action' => 'index'));
				}else{
					$this->Session->setFlash(__('<div class="alert alert-danger">Data error.</div>'));
				}
			}else{
				$this->Session->setFlash(__('<div class="alert alert-danger">The inventory you tried to add already exists.</div>'));
			}
		}
		$customFields = $this->InvInventoryCustomField->getListOfFields($this->subscriber);
		$settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$unitTypeList = $this->InvInventoryUnitType->getUnitTypeList($this->subscriber);
		$defaultCurrency = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$list = $this->taxTree();
		$this->set(compact('unitTypeList','list','currencyList','defaultCurrency','customFields','permission'));
		
	}

	public function editInventory($id = null,$pages = null,$itemName = null,$minPrice = null,$maxPrice = null,$inHand= null){
		$permission = $this->permission;
		if($this->permission['_update'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$title_for_layout = 'Update Item';
		$this->set(compact('title_for_layout'));
		
		$this->loadModel('InvInventoryUnitType');
		$this->loadModel('CpnCurrency');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('InvInventoryCustomField');
		$this->loadModel('InvInventoryCustomValue');
		
		if ($this->request->is(array('post', 'put'))) {
			if(($this->data['InvInventory']['name']) && ($this->data['InvInventory']['list_price']) && ($this->data['InvInventory']['current_stock'])){
				$inventoryExist = $this->InvInventory->checkDuplicateInventory(trim($this->data['InvInventory']['name']),$this->subscriber);
				if(empty($inventoryExist) || ($inventoryExist['InvInventory']['id']==$id)){
					$updateInventory = $this->InvInventory->updateInventory($id,$this->data['InvInventory'],$this->subscriber);
					if($updateInventory){
						if($this->data['InvInventory']['itemName']){$itemName = $this->data['InvInventory']['itemName'];}
						if($this->data['InvInventory']['minPrice']){$minPrice = $this->data['InvInventory']['minPrice'];}
						if($this->data['InvInventory']['maxPrice']){$maxPrice = $this->data['InvInventory']['maxPrice'];}
						if($this->data['InvInventory']['inHand']){$inHand = $this->data['InvInventory']['inHand'];}
						if($this->data['InvInventory']['pages']){$pages = $this->data['InvInventory']['pages'];}
						if($this->data['InvInventory']['customField']){
							foreach($this->data['InvInventory']['customField'] as $customFieldId => $customFieldValue){
								$getCustomFieldValueId = $this->InvInventoryCustomValue->getCustomValueId($updateInventory,$customFieldId);
								if($getCustomFieldValueId){
									$updateCustomValue = $this->InvInventoryCustomValue->updateCustomValue($getCustomFieldValueId['InvInventoryCustomValue']['id'],$customFieldValue,$updateInventory);
								}else{
									$addCustomValue = $this->InvInventoryCustomValue->addCustomValue($customFieldId,$customFieldValue,$updateInventory);
								}
							}
						}
						$this->Session->setFlash(__('<div class="alert alert-block alert-success">Inventory updated succesfully.</div>'));
						return $this->redirect(array('action' => 'index',$itemName,$minPrice,$maxPrice,$inHand,$pages));
					}else{
						$this->Session->setFlash(__('<div class="alert alert-danger">Mandatory data missing.</div>'));
					}
				}else{
					$this->Session->setFlash(__('<div class="alert alert-danger">The inventory you tried to add already exists.</div>'));
				}
			}
		}
		if(!$itemName){$itemName = "null";}
		if(!$minPrice){$minPrice = "null";}
		if(!$maxPrice){$maxPrice = "null";}
		if(!$inHand){$inHand = "null";}
		
		$invInventory = $this->InvInventory->getInventory($id);
		$customFields = $this->InvInventoryCustomField->getListOfFields($this->subscriber);
		$customFieldValues = $this->InvInventoryCustomValue->getCustomValueList($id);
		$settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$unitTypeList = $this->InvInventoryUnitType->getUnitTypeList($this->subscriber);
		$defaultCurrency = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$list = $this->taxTree();
		$this->set(compact('unitTypeList','list','currencyList','defaultCurrency','customFields','customFieldValues','id'));
		$this->set(compact('invInventory','itemName','minPrice','maxPrice','inHand'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	/*public function edit($id = null,$itemName = null,$minPrice = null,$maxPrice = null,$inHand= null,$pages) {
		
		if ($this->request->is(array('post', 'put'))) {
			if(($this->data['InvInventory'][$id]['name']) && ($this->data['InvInventory'][$id]['list_price']) && ($this->data['InvInventory'][$id]['current_stock'])){
				$inventoryExist = $this->InvInventory->checkDuplicateInventory(trim($this->data['InvInventory'][$id]['name']));
				if(empty($inventoryExist) || ($inventoryExist['InvInventory']['id']==$id)){
					$updateInventory = $this->InvInventory->updateInventory($id,$this->data['InvInventory'][$id],$this->subscriber);
					if($updateInventory){
						$this->Session->setFlash(__('<div class="alert alert-block alert-success">Inventory updated succesfully.</div>'));
						return $this->redirect(array('action' => 'index',$itemName,$minPrice,$maxPrice,$inHand,$pages));
					}else{
						$this->Session->setFlash(__('<div class="alert alert-danger">Mandatory data missing.</div>'));
					}
				}else{
					$this->Session->setFlash(__('<div class="alert alert-danger">The inventory you tried to add already exists.</div>'));
				}
				
			}
		}
		$invInventory = $this->InvInventory->getInventory($id);
		$this->set(compact('invInventory'));
	}*/

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null,$pages = null,$itemName = null,$minPrice = null,$maxPrice = null,$inHand= null) {
		
		$permission = $this->permission;
		if($this->permission['_delete'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		
		
		$this->loadModel('InvInventory');
		$this->InvInventory->id = $id;
		if (!$this->InvInventory->exists()) {
			throw new NotFoundException(__('Invalid  inventory'));
		}
		/*$this->request->onlyAllow('post', 'delete');*/
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('SlsQuotationProduct');
		$invoiceRaised = $this->AcrInvoiceDetail->getInvoiceForInventory($id);
		$quotationRaised = $this->SlsQuotationProduct->getQuotationForInventory($id);
		if(empty($invoiceRaised) && empty($quotationRaised)){
			$this->loadModel('InvInventoryCustomValue');
			$getCustomValueList = $this->InvInventoryCustomValue->getCustomValueList($id);
			foreach($getCustomValueList as $customValueId=>$customValue){
				$this->InvInventoryCustomValue->delete($customValueId);
			}
			if ($this->InvInventory->delete($id)) {
				$this->Session->setFlash(__('<div class="alert alert-block alert-success">The  inventory has been removed.</div>'));
			} else {
				$this->Session->setFlash(__('<div class="alert alert-danger">The  inventory could not be removed. Please, try again.</div>'));
			}
		}elseif($invoiceRaised){
			$this->Session->setFlash(__('<div class="alert alert-danger">The  inventory could not be removed. A invoice is raised with this inventory.</div>'));
		}elseif($quotationRaised){
			$this->Session->setFlash(__('<div class="alert alert-danger">The  inventory could not be removed. A quotation is generated with this inventory.</div>'));
		}
		if(!$itemName){$itemName = "null";}
		if(!$minPrice){$minPrice = "null";}
		if(!$maxPrice){$maxPrice = "null";}
		if(!$inHand){$inHand = "null";}
		return $this->redirect(array('action' => 'index',$itemName,$minPrice,$maxPrice,$inHand,$pages));
	}
	
	
	public function addUnit(){
		
		$this->loadModel('InvInventoryUnitType');
		if($this->data['unit_type']){
			foreach($this->data['unit_type'] as $key=>$unitType){
				if($unitType){
					$addUnitType = $this->InvInventoryUnitType->addUnitType($this->subscriber,$unitType);
				}
			}
		}
		$unitTypeList = $this->InvInventoryUnitType->getUnitTypeList($this->subscriber);
		$this->set(compact('unitTypeList'));
	}
	public function addInventory($rowId = null){
		$permission = $this->permission;
		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->loadModel('InvInventoryUnitType');
		if (($this->data['addInventory']['name']) && $rowId) {
			$inventoryExist = $this->InvInventory->checkDuplicateInventory(trim($this->data['addInventory']['name']),$this->subscriber);
			if(empty($inventoryExist)){
				$this->loadModel('SbsSubscriberSetting');
				$settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
				$this->request->data['addInventory']['currency'] = $settings['SbsSubscriberSetting']['cpn_currency_id'];
				$newInventory = $this->InvInventory->addInventory($this->data['addInventory'],$this->subscriber);
				$this->set(compact('newInventory'));
			}
		}
		$inventoryList	 	 = $this->InvInventory->getListOfInventory($this->subscriber);
		$unitTypeList = $this->InvInventoryUnitType->getUnitTypeList($this->subscriber);
		$this->set(compact('unitTypeList','inventoryList','rowId'));
	}
	public function downloadLink(){
			$this->viewClass = 'Media';
        	$params = array(
            	'id'        => 'inventories.xls',
           	 	'name'      => 'inventories',
            	'download'  => true,
            	'extension' => 'xls',
            	'path'      => 'files'.DS
        	);
        	$this->set($params);
		}
	public function show_excel() {
		$permission = $this->permission;
		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$title_for_layout = 'Import Items';
		$this->set(compact('title_for_layout'));
			$this->loadModel('SbsSubscriberSetting');
	   		$this->loadModel('CpnCurrency');
	   		$settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
	   		if($settings['SbsSubscriberSetting']['cpn_currency_id']){
	   			$defaultCurrency = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
	   			$this->set(compact('defaultCurrency'));
	   		}else{
	   			$this->Session->setFlash(('<div class="alert alert-danger">'.__('Please select a default currency.').'</div>'));
	   		}
			if($this->data){
			debug($_FILES['file']['type']);
				if((($_FILES['file']['type'] == 'application/vnd.ms-excel') || ($_FILES['file']['type'] == 'application/octet-stream'))){
					$fileOK = $this->uploadFiles('files', $_FILES);
					if($fileOK['urls']['0']){
	   					//$excel = new PhpExcelReader;
	   						$excel = new Spreadsheet_Excel_Reader;
	   						$excel->read($fileOK['urls']['0']);
	   						$nr_sheets = count($excel->sheets);
	   						$excel_data = '';
	   						$sheetOrderProvided = array(
	   							'0'=>'Instructions',
	   							'1'=>'Inventories'
	   						);
	   						
	   						foreach($sheetOrderProvided as $key1=>$val1){
	   							if($excel->boundsheets[$key1]['name'] != $val1){
	   								$sheetNameOrder = 1;
	   							}
	   						}
	   						if(!($sheetNameOrder)){
	   							$inventorySuccessCount = null;
	   							$this->loadModel('InvInventoryUnitType');
	   							$this->loadModel('SbsSubscriberTax');
	   							$this->loadModel('SbsSubscriberTaxGroup');
	   							for($i=1; $i<$nr_sheets; $i++) {
	   									
	   									if($excel->boundsheets[$i]['name'] == $sheetOrderProvided[$i]){
	   										if($excel->boundsheets[$i]['name'] == 'Inventories'){
												$inventoryInformation = $this->sheetData($excel->sheets[$i],$excel->boundsheets[$i]['name']) ;
												if($inventoryInformation){
													foreach($inventoryInformation as $keyId=>$valInfo){
														$getUnitTypeId = $this->InvInventoryUnitType->importUnitType($valInfo['Unit Type'],$this->subscriber);
														if($valInfo['Tax']){
															$taxId = $this->SbsSubscriberTax->checkTaxExists(trim($valInfo['Tax']),$this->subscriber);
															if($taxId){
																$inventoryExist = $this->InvInventory->checkDuplicateInventory(trim($valInfo['Inventory Name']),$this->subscriber);
																if(empty($inventoryExist)){
																	if($valInfo['Inventory Name']){
																		if($valInfo['Inventory Price']){
																			if($valInfo['Current Stock']){
																				$importInventory = $this->InvInventory->import($valInfo,$settings['SbsSubscriberSetting']['cpn_currency_id'],$this->subscriber,$getUnitTypeId,$taxId['SbsSubscriberTax']['id'],0);
																				if($importInventory){
																						$this->loadModel('InvInventoryCustomField');
																						$customFields = $this->InvInventoryCustomField->getListOfFields($this->subscriber);
																						if($customFields){
																							$this->loadModel('InvInventoryCustomValue');
																							$customQueue = 1;
																							foreach($customFields as $fieldId=>$fieldName){
																								$addCustomValue = $this->InvInventoryCustomValue->addCustomValue($fieldId,$valInfo['Custom Field'.$customQueue],$importInventory);
																								$customQueue++;
																							}
																						}
																						$inventorySuccessCount++;
																					}
																			}else{
																				$errorMessage[$keyId]['Inventory Name'] 		=  $valInfo['Inventory Name'];
																				if($valInfo['Tax']){
																					$errorMessage[$keyId]['Tax']				=  $valInfo['Tax'];
																				}
																				$errorMessage[$keyId]['Unit Type'] 				=  $valInfo['Unit Type'];
																				$errorMessage[$keyId]['Error Message'] 			=  "Stock quantity missing";
																			}
																		}else{
																			$errorMessage[$keyId]['Inventory Name'] 		=  $valInfo['Inventory Name'];
																				if($valInfo['Tax']){
																					$errorMessage[$keyId]['Tax']				=  $valInfo['Tax'];
																				}
																				$errorMessage[$keyId]['Unit Type'] 				=  $valInfo['Unit Type'];
																				$errorMessage[$keyId]['Error Message'] 			=  "Item price is missing";
																		}
																	}else{
																		$errorMessage[$keyId]['Inventory Name'] 		=  $valInfo['Inventory Name'];
																				if($valInfo['Tax']){
																					$errorMessage[$keyId]['Tax']				=  $valInfo['Tax'];
																				}
																				$errorMessage[$keyId]['Unit Type'] 				=  $valInfo['Unit Type'];
																				$errorMessage[$keyId]['Error Message'] 			=  "Item name is missing";
																	}
																	
																}else{
																	$errorMessage[$keyId]['Inventory Name'] 		=  $valInfo['Inventory Name'];
																	if($valInfo['Tax']){
																		$errorMessage[$keyId]['Tax']				=  $valInfo['Tax'];
																	}
																	$errorMessage[$keyId]['Unit Type'] 				=  $valInfo['Unit Type'];
																	$errorMessage[$keyId]['Error Message'] 			=  "Inventory already exists.";
																}
															}else{
																$errorMessage[$keyId]['Inventory Name'] 		=  $valInfo['Inventory Name'];
																if($valInfo['Tax']){
																	$errorMessage[$keyId]['Tax']				=  $valInfo['Tax'];
																	$message                                    =  "Tax does not exist in the system.";
																}elseif($valInfo['Tax Group']){
																	$errorMessage[$keyId]['Tax Group'] 			=  $valInfo['Tax Group'];
																	$message                                    =  "Tax Group does not exist in the system.";
																}
																$errorMessage[$keyId]['Unit Type'] 				=  $valInfo['Unit Type'];
																$errorMessage[$keyId]['Error Message'] 			=  $message;
															}
															
															
														}elseif($valInfo['Tax Group']){
															$groupTax = $this->SbsSubscriberTaxGroup->checkTaxGroupExists($valInfo['Tax Group'],$this->subscriber);
															if($groupTax){
																$inventoryExist = $this->InvInventory->checkDuplicateInventory(trim($valInfo['Inventory Name']),$this->subscriber);
																if(empty($inventoryExist)){
																	
																	if($valInfo['Inventory Name']){
																		if($valInfo['Inventory Price']){
																			if($valInfo['Current Stock']){
																				$importInventory = $this->InvInventory->import($valInfo,$settings['SbsSubscriberSetting']['cpn_currency_id'],$this->subscriber,$getUnitTypeId,0,$groupTax['SbsSubscriberTaxGroup']['id']);
																				if($importInventory){
																					$inventorySuccessCount++;
																				}
																			}else{
																				$errorMessage[$keyId]['Inventory Name'] 		=  $valInfo['Inventory Name'];
																				if($valInfo['Tax']){
																					$errorMessage[$keyId]['Tax']				=  $valInfo['Tax'];
																				}
																				$errorMessage[$keyId]['Unit Type'] 				=  $valInfo['Unit Type'];
																				$errorMessage[$keyId]['Error Message'] 			=  "Stock quantity missing";
																			}
																		}else{
																			$errorMessage[$keyId]['Inventory Name'] 		=  $valInfo['Inventory Name'];
																				if($valInfo['Tax']){
																					$errorMessage[$keyId]['Tax']				=  $valInfo['Tax'];
																				}
																				$errorMessage[$keyId]['Unit Type'] 				=  $valInfo['Unit Type'];
																				$errorMessage[$keyId]['Error Message'] 			=  "Item price is missing";
																		}
																	}else{
																		$errorMessage[$keyId]['Inventory Name'] 		=  $valInfo['Inventory Name'];
																				if($valInfo['Tax']){
																					$errorMessage[$keyId]['Tax']				=  $valInfo['Tax'];
																				}
																				$errorMessage[$keyId]['Unit Type'] 				=  $valInfo['Unit Type'];
																				$errorMessage[$keyId]['Error Message'] 			=  "Item name is missing";
																	}
																	
																	
																	
																	
																	
																	
																	if($importInventory){
																		$this->loadModel('InvInventoryCustomField');
																		$customFields = $this->InvInventoryCustomField->getListOfFields($this->subscriber);
																		if($customFields){
																			$this->loadModel('InvInventoryCustomValue');
																			$customQueue = 1;
																			foreach($customFields as $fieldId=>$fieldName){
																				$addCustomValue = $this->InvInventoryCustomValue->addCustomValue($fieldId,$valInfo['Custom Field'.$customQueue],$importInventory);
																				$customQueue++;
																			}
																		}
																		$inventorySuccessCount++;
																	}
																}else{
																	$errorMessage[$keyId]['Inventory Name'] 	=  $valInfo['Inventory Name'];
																	if($valInfo['Tax Group']){
																		$errorMessage[$keyId]['Tax Group']		=  $valInfo['Tax'];
																	}
																	$errorMessage[$keyId]['Unit Type'] 			=  $valInfo['Unit Type'];
																	$errorMessage[$keyId]['Error Message'] 		=  "Inventory already exists.";
																}
															}else{
																$errorMessage[$keyId]['Inventory Name'] 		=  $valInfo['Inventory Name'];
																if($valInfo['Tax']){
																	$errorMessage[$keyId]['Tax']				=  $valInfo['Tax'];
																	$message                                    =  "Tax does not exist in the system.";
																}elseif($valInfo['Tax Group']){
																	$errorMessage[$keyId]['Tax Group'] 			=  $valInfo['Tax Group'];
																	$message                                    =  "Tax Group does not exist in the system.";
																}
																$errorMessage[$keyId]['Unit Type'] 				=  $valInfo['Unit Type'];
																$errorMessage[$keyId]['Error Message'] 			=  $message;
															}
														}else{
															$inventoryExist = $this->InvInventory->checkDuplicateInventory(trim($valInfo['Inventory Name']),$this->subscriber);
																if(empty($inventoryExist)){
																	if($valInfo['Inventory Name']){
																		if($valInfo['Inventory Price']){
																			if($valInfo['Current Stock']){
																				$importInventory = $this->InvInventory->import($valInfo,$settings['SbsSubscriberSetting']['cpn_currency_id'],$this->subscriber,$getUnitTypeId,"null","null");
																				if($importInventory){
																						$this->loadModel('InvInventoryCustomField');
																						$customFields = $this->InvInventoryCustomField->getListOfFields($this->subscriber);
																						if($customFields){
																							$this->loadModel('InvInventoryCustomValue');
																							$customQueue = 1;
																							foreach($customFields as $fieldId=>$fieldName){
																								$addCustomValue = $this->InvInventoryCustomValue->addCustomValue($fieldId,$valInfo['Custom Field'.$customQueue],$importInventory);
																								$customQueue++;
																							}
																						}
																						$inventorySuccessCount++;
																					}
																			}else{
																				$errorMessage[$keyId]['Inventory Name'] 		=  $valInfo['Inventory Name'];
																				if($valInfo['Tax']){
																					$errorMessage[$keyId]['Tax']				=  $valInfo['Tax'];
																				}
																				$errorMessage[$keyId]['Unit Type'] 				=  $valInfo['Unit Type'];
																				$errorMessage[$keyId]['Error Message'] 			=  "Stock quantity missing";
																			}
																		}else{
																			$errorMessage[$keyId]['Inventory Name'] 		=  $valInfo['Inventory Name'];
																				if($valInfo['Tax']){
																					$errorMessage[$keyId]['Tax']				=  $valInfo['Tax'];
																				}
																				$errorMessage[$keyId]['Unit Type'] 				=  $valInfo['Unit Type'];
																				$errorMessage[$keyId]['Error Message'] 			=  "Item price is missing";
																		}
																	}else{
																		$errorMessage[$keyId]['Inventory Name'] 		=  $valInfo['Inventory Name'];
																				if($valInfo['Tax']){
																					$errorMessage[$keyId]['Tax']				=  $valInfo['Tax'];
																				}
																				$errorMessage[$keyId]['Unit Type'] 				=  $valInfo['Unit Type'];
																				$errorMessage[$keyId]['Error Message'] 			=  "Item name is missing";
																	}
																	
																	
																	if($importInventory){
																		$this->loadModel('InvInventoryCustomField');
																		$customFields = $this->InvInventoryCustomField->getListOfFields($this->subscriber);
																		if($customFields){
																			$this->loadModel('InvInventoryCustomValue');
																			$customQueue = 1;
																			foreach($customFields as $fieldId=>$fieldName){
																				$addCustomValue = $this->InvInventoryCustomValue->addCustomValue($fieldId,$valInfo['Custom Field'.$customQueue],$importInventory);
																				$customQueue++;
																			}
																		}
																		$inventorySuccessCount++;
																	}
																}else{
																	$errorMessage[$keyId]['Inventory Name'] 		=  $valInfo['Inventory Name'];
																	if($valInfo['Tax Group']){
																		$errorMessage[$keyId]['Tax Group']			=  $valInfo['Tax'];
																	}
																	$errorMessage[$keyId]['Unit Type'] 				=  $valInfo['Unit Type'];
																	$errorMessage[$keyId]['Error Message'] 			=  "Inventory already exists.";
																}
														}
													}
												}
											}
											
	   									}else{
	   											$this->Session->setFlash(('<div class="alert alert-danger">'.__('Please use the default excel format,sheet name and sheet order').'</div>'));
										}
	   							}
	   							$this->set(compact('inventorySuccessCount','errorMessage'));
	   						}else{
	   							$this->Session->setFlash(('<div class="alert alert-danger">'.__('Please use the default excel format,sheet name and sheet order').'</div>'));
	   						}
	   				}else{
	   					$this->Session->setFlash(('<div class="alert alert-danger">'.__('Data import failed.Please save the excel with .xls').'</div>'));
	  				}
				}elseif(($_FILES['file']['type']) && ($_FILES['file']['type'] != 'application/vnd.ms-excel')){
						$this->Session->setFlash(('<div class="alert alert-danger">'.__('File you tried to import is invalid').'</div>'));
				}elseif(empty($_FILES['file']['type'])){
						$this->Session->setFlash(('<div class="alert alert-danger">'.__('File you tried to import has no file type.Please try uploading a new excel sheet').'</div>'));
				}
				/*$fileUploadSuccess = 1;*/
				$documentPath = WWW_ROOT.$fileOK['urls']['0'];
				unlink($documentPath);
				$this->set(compact('fileUploadSuccess'));
			}
		}
		
		public function sheetData($sheet,$sheetName) {
		 	$fieldsArray = $sheet['cells']['1'];
		 	$countRecords = count($sheet['cells']);
		 	foreach($fieldsArray as $key=>$val){
		 		for($i=2;$i<=$countRecords;$i++){
		 			if($sheetName == 'Inventories'){
		 				//arrayFor Customer
		 				if($val=='Inventory Name'){
		 					$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Inventory Description'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Inventory Price'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Tax'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Tax Group'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Unit Type'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Track Item Quantity'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Current Stock'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Custom Field1'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Custom Field2'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Custom Field3'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Custom Field4'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Custom Field5'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}else{
			 				$dataClient[$i]['fieldMissing'] = '1';
			 			}
		 			}
		 		}
		 	}
		 	if($dataClient){
		 		return $dataClient;
		 	}else{
		 		return false;
		 	}
		}
		
		public function exportItems(){
			
		}
		public function export(){
			$title_for_layout = 'Export Items';
		$this->set(compact('title_for_layout'));
			$this->InvInventory->recursive = 0;
			$this->loadModel('InvInventoryCustomField');
			$this->loadModel('InvInventoryCustomValue');
			if(($this->data['InventoryFilter']['item_name']) || ($this->data['InventoryFilter']['price_min']) || ($this->data['InventoryFilter']['price_max']) || ($this->data['InventoryFilter']['quantity'])){
				$itemName = $this->data['InventoryFilter']['item_name'];
				$minPrice = $this->data['InventoryFilter']['price_min'];
				$maxPrice = $this->data['InventoryFilter']['price_max'];
				$stock    = $this->data['InventoryFilter']['quantity'];
				debug($minPrice);
				debug($maxPrice);
				if($minPrice && $maxPrice){
					if($stock == 'in-stock'){
						if($itemName){
							$conditions = array('InvInventory.name'=>$itemName,'InvInventory.list_price BETWEEN ? and ?'=>array($minPrice,$maxPrice),'InvInventory.current_stock >='=>'1','InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}else{
							$conditions = array('InvInventory.list_price BETWEEN ? and ?'=>array($minPrice,$maxPrice),'InvInventory.current_stock >='=>'1','InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}
						
					}elseif($stock == 'out-stock'){
						if($itemName){
							$conditions = array('InvInventory.name'=>$itemName,'InvInventory.list_price BETWEEN ? and ?'=>array($minPrice,$maxPrice),'InvInventory.current_stock <='=>'0','InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}else{
							$conditions = array('InvInventory.list_price BETWEEN ? and ?'=>array($minPrice,$maxPrice),'InvInventory.current_stock <='=>'0','InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}
					}else{
						if($itemName){
							$conditions = array('InvInventory.name'=>$itemName,'InvInventory.list_price BETWEEN ? and ?'=>array($minPrice,$maxPrice),'InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}else{
							$conditions = array('InvInventory.list_price BETWEEN ? and ?'=>array($minPrice,$maxPrice),'InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}
					}
				}elseif($minPrice){
					if($stock == 'in-stock'){
						if($itemName){
							$conditions = array('InvInventory.list_price >='=>$minPrice,'InvInventory.current_stock >='=>'1','InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}else{
							$conditions = array('InvInventory.name'=>$itemName,'InvInventory.list_price >='=>$minPrice,'InvInventory.current_stock >='=>'1','InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}
						
					}elseif($stock == 'out-stock'){
						if($itemName){
							$conditions = array('InvInventory.name'=>$itemName,'InvInventory.list_price >='=>$minPrice,'InvInventory.current_stock <='=>'0','InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}else{
							$conditions = array('InvInventory.list_price >='=>$minPrice,'InvInventory.current_stock <='=>'0','InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}
						
					}else{
						if($itemName){
							$conditions = array('InvInventory.name'=>$itemName,'InvInventory.list_price >='=>$minPrice);
						}else{
							$conditions = array('InvInventory.list_price >='=>$minPrice);
						}
					}
				}elseif($maxPrice){
					if($stock == 'in-stock'){
						if($itemName){
							$conditions = array('InvInventory.name'=>$itemName,'InvInventory.list_price <='=>$maxPrice,'InvInventory.current_stock >='=>'1','InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}else{
							$conditions = array('InvInventory.list_price <='=>$maxPrice,'InvInventory.current_stock >='=>'1','InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}
						
					}elseif($stock == 'out-stock'){
						if($itemName){
							$conditions = array('InvInventory.name'=>$itemName,'InvInventory.list_price <='=>$maxPrice,'InvInventory.current_stock <='=>'0','InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}else{
							$conditions = array('InvInventory.list_price <='=>$maxPrice,'InvInventory.current_stock <='=>'0','InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}
						
					}else{
						if($itemName){
							$conditions = array('InvInventory.name'=>$itemName,'InvInventory.list_price <='=>$maxPrice,'InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}else{
							$conditions = array('InvInventory.list_price <='=>$maxPrice,'InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}
					}
				}else{
					if($stock == 'in-stock'){
						if($itemName){
							$conditions = array('InvInventory.name'=>$itemName,'InvInventory.current_stock >='=>'1','InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}else{
							$conditions = array('InvInventory.current_stock >='=>'1','InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}
						
					}elseif($stock == 'out-stock'){
						if($itemName){
							$conditions = array('InvInventory.name'=>$itemName,'InvInventory.current_stock <='=>'0','InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}else{
							$conditions = array('InvInventory.current_stock <='=>'0','InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}
						
					}else{
						if($itemName){
							$conditions = array('InvInventory.name'=>$itemName,'InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}else{
							$conditions = array('InvInventory.sbs_subscriber_id'=>$this->subscriber);
						}
						
					}
				}
			}else{
				$conditions = array('InvInventory.sbs_subscriber_id'=>$this->subscriber);
			}
			debug($conditions);
			$invInventory = $this->InvInventory->find('all',array('conditions'=>$conditions,'order'=>array('InvInventory.name ASC','InvInventory.list_price ASC','InvInventory.current_stock ASC')));
			debug($invInventory);
			$invCustomFields = $this->InvInventoryCustomField->find('all',array('conditions'=>array('InvInventoryCustomField.sbs_subscriber_id'=>$this->subscriber)));
			$this->set(compact('invInventory'));
			foreach($invInventory as $key=>$val){
				$getCustomValue = $this->InvInventoryCustomValue->find('all',array('conditions'=>array('InvInventoryCustomValue.inv_inventory_id'=>$val['InvInventory']['id'])));
				foreach($getCustomValue as $key1=>$val1){
					$customValue[$val['InvInventory']['id']][$val1['InvInventoryCustomValue']['inv_inventory_custom_field_id']] = $val1['InvInventoryCustomValue']['data'];
				}
			}
			$this->set(compact('customValue','invCustomFields'));
			
		}
}