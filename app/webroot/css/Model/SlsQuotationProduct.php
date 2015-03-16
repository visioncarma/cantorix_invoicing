<?php
App::uses('AppModel', 'Model');
/**
 * SlsQuotationProduct Model
 *
 * @property SlsQuotation $SlsQuotation
 * @property InvInventory $InvInventory
 * @property SbsSubscriberTax $SbsSubscriberTax
 * @property SbsSubscriberTaxGroup $SbsSubscriberTaxGroup
 */
class SlsQuotationProduct extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'SlsQuotation' => array(
			'className' => 'SlsQuotation',
			'foreignKey' => 'sls_quotation_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'InvInventory' => array(
			'className' => 'InvInventory',
			'foreignKey' => 'inv_inventory_id',
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
		)
	);
	
	public function checkQuotationExistForTax($id=null,$subscriber_id=null){
		$quotation = $this->SlsQuotation->find('first',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$subscriber_id)));
		if($quotation){
			$quotationDetail=$this->find('first',array('conditions'=>array('SlsQuotationProduct.sbs_subscriber_tax_id'=>$id,'SlsQuotationProduct.sls_quotation_id'=>$quotation1['SlsQuotation']['id'])));
		    return $quotationDetail;
		}
		
	}
	
	public function checkQuotationExistForTaxGroup($group_id=null,$subscriber_id=null){
		$quotation = $this->SlsQuotation->find('first',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$subscriber_id)));
		if($quotation){
			$quotationDetail1=$this->find('first',array('conditions'=>array('SlsQuotationProduct.sbs_subscriber_tax_group_id'=>$group_id,'SlsQuotationProduct.sls_quotation_id'=>$quotation['SlsQuotation']['id'])));
		    return $quotationDetail1;
		}
		
	}

	public function getQuotationForInventory($inventoryId = null){
		if($inventoryId){
			$quotationDetail=$this->find('first',array('conditions'=>array('SlsQuotationProduct.inv_inventory_id'=>$inventoryId)));
			return $quotationDetail;
		}
	}
}
