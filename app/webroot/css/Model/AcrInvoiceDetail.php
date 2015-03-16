<?php
App::uses('AppModel', 'Model');
/**
 * AcrInvoiceDetail Model
 *
 * @property AcrClientInvoice $AcrClientInvoice
 * @property SbsSubscriberTax $SbsSubscriberTax
 * @property SbsSubscriberTaxGroup $SbsSubscriberTaxGroup
 */
class AcrInvoiceDetail extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'AcrClientInvoice' => array(
			'className' => 'AcrClientInvoice',
			'foreignKey' => 'acr_client_invoice_id',
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
		'InvInventory' => array(
			'className' => 'InvInventory',
			'foreignKey' => 'inv_inventory_id',
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
	
	
	public function checkInvoiceExistForTax($id=null){
			$invoiceDetail=$this->find('first',array('conditions'=>array('AcrInvoiceDetail.sbs_subscriber_tax_id'=>$id)));
			return $invoiceDetail;
	}
	
	public function checkInvoiceExistForTaxGroup($group_id=null){
			$invoiceDetail1=$this->find('first',array('conditions'=>array('AcrInvoiceDetail.sbs_subscriber_tax_group_id'=>$group_id)));
			return $invoiceDetail1;
	}
	
	
	public function getInvoiceDetails($invoiceId = null){
		$this->recursive = 0;
		$invoceDetails = $this->find('all',array('conditions'=>array('AcrInvoiceDetail.acr_client_invoice_id'=>$invoiceId)));
		return $invoceDetails;
	}
	public function addInvoiceDetail($data){
		if($data){
			$saveDetail->data = null;
			$this->create();
			$saveDetail->data['quantity'] 							= $data['quantity'];
			$saveDetail->data['inventory_description']				= $data['inventory_description'];
			$saveDetail->data['unit_rate'] 							= $data['unit_rate'];
			$saveDetail->data['discount_percent'] 					= $data['discount_percent'];
			$saveDetail->data['line_total'] 						= $data['line_total'];
			$saveDetail->data['acr_client_invoice_id'] 				= $data['acr_client_invoice_id'];
			$saveDetail->data['inv_inventory_id'] 					= $data['inv_inventory_id'];
			if($data['sbs_subscriber_tax_id']){
				$saveDetail->data['sbs_subscriber_tax_id'] 			= $data['sbs_subscriber_tax_id'];
			}elseif($data['sbs_subscriber_tax_group_id']){
				$saveDetail->data['sbs_subscriber_tax_group_id'] 	= $data['sbs_subscriber_tax_group_id'];
			}
			if($this->save($saveDetail->data)){
				return $this->getLastInsertId();
			}else{
				false;
			}
		}
		
	}
	
	public function updateInvoiceDetail($data){
		if($data){
			$saveDetail->data = null;
			$saveDetail->data['id'] 								= $data['id'];
			$saveDetail->data['quantity'] 							= $data['quantity'];
			$saveDetail->data['inventory_description']				= $data['inventory_description'];
			$saveDetail->data['unit_rate'] 							= $data['unit_rate'];
			$saveDetail->data['discount_percent'] 					= $data['discount_percent'];
			$saveDetail->data['line_total'] 						= $data['line_total'];
			$saveDetail->data['acr_client_invoice_id'] 				= $data['acr_client_invoice_id'];
			$saveDetail->data['inv_inventory_id'] 					= $data['inv_inventory_id'];
			if($data['sbs_subscriber_tax_id']){
				$saveDetail->data['sbs_subscriber_tax_id'] 			= $data['sbs_subscriber_tax_id'];
			}elseif($data['sbs_subscriber_tax_group_id']){
				$saveDetail->data['sbs_subscriber_tax_group_id'] 	= $data['sbs_subscriber_tax_group_id'];
			}
			if($this->save($saveDetail->data)){
				return $data['id'];
			}else{
				return false;
			}
		}
	}
	public function getInvoiceForInventory($inventoryId = null){
		if($inventoryId){
			$this->recursive = 0;
			$clientInvoice=$this->find('first',array('conditions'=>array('AcrInvoiceDetail.inv_inventory_id'=>$inventoryId)));
			return $clientInvoice;
		}
	}
	
}
