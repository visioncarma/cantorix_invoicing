<?php
App::uses('AppModel', 'Model');
/**
 * InvInventory Model
 *
 * @property SbsSubscriber $SbsSubscriber
 * @property AcpInventoryExpense $AcpInventoryExpense
 * @property AcrClientInvoice $AcrClientInvoice
 * @property SlsQuotationProduct $SlsQuotationProduct
 */
class InvInventory extends AppModel {
/** Validation rules
 *
 * @var array
 */
	/*public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Inventory should have a name',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'Inventory with same name exists',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'list_price' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Inventory should have a price',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'money' => array(
				'rule' => array('money', 'left'),
				'message' => 'Price should be an amount value',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'decimal' => array(
				'rule' => array('decimal',2),
				'message' => 'Price should be an amount value',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);*/
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'SbsSubscriber' => array(
			'className' => 'SbsSubscriber',
			'foreignKey' => 'sbs_subscriber_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SbsSubscriberTax' => array(
			'className' => 'SbsSubscriberTax',
			'foreignKey' => 'sbs_subscriber_tax_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SbsSubscriberTaxGroup' => array(
			'className' => 'SbsSubscriberTaxGroup',
			'foreignKey' => 'sbs_subscriber_tax_group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'InvInventoryUnitType' => array(
			'className' => 'InvInventoryUnitType',
			'foreignKey' => 'inv_inventory_unit_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CpnCurrency' => array(
			'className' => 'CpnCurrency',
			'foreignKey' => 'cpn_currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'AcpInventoryExpense' => array(
			'className' => 'AcpInventoryExpense',
			'foreignKey' => 'inv_inventory_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'AcrInvoiceDetail' => array(
			'className' => 'AcrInvoiceDetail',
			'foreignKey' => 'inv_inventory_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SlsQuotationProduct' => array(
			'className' => 'SlsQuotationProduct',
			'foreignKey' => 'inv_inventory_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	public function checkDuplicateInventory($inventoryName = null,$subscriberId = null){
		if($inventoryName && $subscriberId){
			$inventory = $this->find('first',array('conditions'=>array('InvInventory.name'=>$inventoryName,'InvInventory.sbs_subscriber_id'=>$subscriberId)));
			return $inventory;
		}
	}
	public function getListOfInventory($subscriberId = null){
		if($subscriberId){
			$inventory = $this->find('list',array('conditions'=>array('InvInventory.sbs_subscriber_id'=>$subscriberId,'InvInventory.current_stock >='=>'1'),'fields'=>array('InvInventory.id','InvInventory.name'),'order'=>array('InvInventory.name ASC')));
			return $inventory;
		}
	}
	public function getInventory($inventoryId = null){
		$this->recursive = 0;
		if($inventoryId){
			$inventory = $this->find('first',array('conditions'=>array('InvInventory.id'=>$inventoryId)));
			return $inventory;
		}
	}
	
	public function updateStock($inventoryId = null,$quantity = null,$oldQuantity = null){
		if($inventoryId){
			$getInventoryDetail = $this->getInventory($inventoryId);
			if($getInventoryDetail['InvInventory']['track_quantity'] == 'Y'){
				$save->data = null;
				$save->data['InvInventory']['id'] = $inventoryId;
				$save->data['InvInventory']['current_stock'] = $getInventoryDetail['InvInventory']['current_stock'] + $oldQuantity - $quantity;
				$save->data['InvInventory']['track_quantity'] = "Y";
				if($this->save($save->data)){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
	}
	public function getInventoryByName($inventoryName = null,$subscriberId = null){
		if($inventoryName){
			$getInventory = $this->find('first',array('conditions'=>array('InvInventory.name'=>$inventoryName,'InvInventory.sbs_subscriber_id'=>$subscriberId)));
			if($getInventory){
				return $getInventory['InvInventory']['id'];
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	public function addInventory($data = null,$subscriberId = null){
		if($data && $subscriberId){
			$addInventory->data = null;
			$this->create();
			$addInventory->data['InvInventory']['name'] 						= $data['name'];
			$addInventory->data['InvInventory']['description'] 					= $data['description'];
			$addInventory->data['InvInventory']['list_price'] 					= $data['list_price'];
			if($data['track']){
				$addInventory->data['InvInventory']['track_quantity'] 			= "Y";
			}else{
				$addInventory->data['InvInventory']['track_quantity'] 			= "N";
			}
			$addInventory->data['InvInventory']['current_stock'] 				= $data['current_stock'];
			$addInventory->data['InvInventory']['sbs_subscriber_id'] 			= $subscriberId;
			$addInventory->data['InvInventory']['inv_inventory_unit_type_id'] 	= $data['unitType'];
			$addInventory->data['InvInventory']['cpn_currency_id'] 				= $data['currency'];
			if($data['tax_inventory']){
				$taxGroupId = explode('-',$data['tax_inventory']);
				if($taxGroupId['1']){
					$addInventory->data['InvInventory']['sbs_subscriber_tax_group_id'] 	= $taxGroupId['1'];
				}else{
					$addInventory->data['InvInventory']['sbs_subscriber_tax_id'] 		= $data['tax_inventory'];
				}
			}
			if($this->save($addInventory->data)){
				$lastInventoryId  = $this->getLastInsertID();
				return $lastInventoryId;
			}else{
				return false;
			}
		}
	}
	
	public function updateInventory($inventoryId = null,$data = null,$subscriberId = null){
		if($inventoryId){
			$updateInventory->data = null;
			$updateInventory->data['InvInventory']['id'] = $inventoryId;
			$updateInventory->data['InvInventory']['name'] = $data['name'];
			$updateInventory->data['InvInventory']['description'] = $data['description'];
			$updateInventory->data['InvInventory']['list_price'] = $data['list_price'];
			$updateInventory->data['InvInventory']['current_stock'] = $data['current_stock'];
			$updateInventory->data['InvInventory']['inv_inventory_unit_type_id'] = $data['unitType'];
			$updateInventory->data['InvInventory']['sbs_subscriber_id'] = $subscriberId;
			if($data['track']){
				$updateInventory->data['InvInventory']['track_quantity'] = "Y";
			}else{
				$updateInventory->data['InvInventory']['track_quantity'] = "N";
			}
			$taxApplied = explode('-',$data['tax_inventory']);
			if($taxApplied['1']){
				$updateInventory->data['InvInventory']['sbs_subscriber_tax_group_id'] = $taxApplied['1'];
			}elseif($data['tax_inventory']){
				$updateInventory->data['InvInventory']['sbs_subscriber_tax_group_id'] = 'null';
				$updateInventory->data['InvInventory']['sbs_subscriber_tax_id'] = $data['tax_inventory'];
			}
			$updateInventory->data['InvInventory']['cpn_currency_id'] = $data['currency'];
			if($this->save($updateInventory->data,array('validate'=>false))){
				return $inventoryId;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	public function import($data = null,$currencyId = null,$subscriberId = null,$unitTypeId = null,$taxId = null,$groupTaxId = null){
		if(($data) && ($currencyId) && ($subscriberId)){
			$addInventory->data = null;
			$this->create();
			$addInventory->data['InvInventory']['name'] 						= $data['Inventory Name'];
			$addInventory->data['InvInventory']['description'] 					= $data['Inventory Description'];
			$addInventory->data['InvInventory']['list_price'] 					= $data['Inventory Price'];
			if(($data['Track Item Quantity'] == 'Y') || (($data['Track Item Quantity'] == 'y') ||(($data['Track Item Quantity'] == 'Yes')) || ($data['Track Item Quantity'] == 'yes'))){
				$addInventory->data['InvInventory']['track_quantity'] 			= "Y";
			}else{
				$addInventory->data['InvInventory']['track_quantity'] 			= "N";
			}
			$addInventory->data['InvInventory']['current_stock'] 				= $data['Current Stock'];
			$addInventory->data['InvInventory']['sbs_subscriber_id'] 			= $subscriberId;
			$addInventory->data['InvInventory']['inv_inventory_unit_type_id'] 	= $unitTypeId;
			$addInventory->data['InvInventory']['cpn_currency_id'] 				= $currencyId;
			if($groupTaxId){
				$addInventory->data['InvInventory']['sbs_subscriber_tax_group_id'] 	= $groupTaxId;
			}elseif($taxId){
				$addInventory->data['InvInventory']['sbs_subscriber_tax_id'] 		= $taxId;
			}
			if($this->save($addInventory->data,array('validate'=>false))){
				$lastInventoryId  = $this->getLastInsertID();
				return $lastInventoryId;
			}else{
				return false;
			}
		}
		
	}

    public function checkInventoryExistGroup($groupId=null,$subscriberId=null){
    	$inventoryInfo = $this->find('first',array('conditions'=>array('InvInventory.sbs_subscriber_tax_group_id'=>$groupId,'InvInventory.sbs_subscriber_id'=>$subscriberId)));
        return $inventoryInfo;
    }
	
	public function checkInventoryExistTax($taxId=null,$subscriberId=null){
    	$inventoryInfo1 = $this->find('first',array('conditions'=>array('InvInventory.sbs_subscriber_tax_id'=>$taxId,'InvInventory.sbs_subscriber_id'=>$subscriberId)));
        return $inventoryInfo1;
    }
}
