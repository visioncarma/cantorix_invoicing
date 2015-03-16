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
	
	
	/*
	public $virtualFields = array(
											'count_invoice_detail_id' => 'count(`AcrInvoiceDetail.id`)',
										);*/
	
	
	
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
		debug($invoiceId);
		//$this->unbindModel(array('belongsTo' => array('SbsSubscriberTax','InvInventory','SbsSubscriberTaxGroup','AcrClientInvoice')));
		$invoceDetails = $this->find('all',array('conditions'=>array('AcrInvoiceDetail.acr_client_invoice_id'=>$invoiceId)));
		debug($invoceDetails);
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
	public function getDetailByID($invoiceDetailId = null){
		if($invoiceDetailId){
			$invoceDetails = $this->find('first',array('conditions'=>array('AcrInvoiceDetail.id'=>$invoiceDetailId),));
			return $invoceDetails;
		}
	}
	public function getInvoiceForInventory($inventoryId = null){
		if($inventoryId){
			$this->recursive = 0;
			$clientInvoice=$this->find('first',array('conditions'=>array('AcrInvoiceDetail.inv_inventory_id'=>$inventoryId)));
			return $clientInvoice;
		}
	}
	
	public function detailGroupedByClient($subscriberId = null,$fromDate = null,$toDate = null){
		if($subscriberId){
			$this->recursive = 0;
			$this->virtualFields = array(
											'count_invoice_detail_id' => 'sum(`AcrInvoiceDetail.quantity`)',
										);
			$this->unbindModel(array('belongsTo' => array('SbsSubscriberTax','InvInventory','SbsSubscriberTaxGroup')));
			$options = array(
								'conditions' =>array(
									'AND'=>array(
										array(
										'AcrClientInvoice.sbs_subscriber_id'=>$subscriberId,
										'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime($fromDate)),date('Y-m-d',strtotime($toDate))),
										'AcrClientInvoice.status !='=>'Draft','AcrClientInvoice.recurring'=>'N'
										),
										array(
											'AcrClientInvoice.sbs_subscriber_id'=>$subscriberId,
											'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime($fromDate)),date('Y-m-d',strtotime($toDate))),
											'AcrClientInvoice.status !='=>'Canceled','AcrClientInvoice.recurring'=>'N'
										)
									)
									
								),
								'fields' => array(
									'AcrClientInvoice.acr_client_id',
									'AcrClientInvoice.status',
									'AcrInvoiceDetail.count_invoice_detail_id',
									'AcrClientInvoice.invoiced_date'
								),
								'group' => array(
									'AcrClientInvoice.acr_client_id'
								),
						);
			$getDetails = $this->find('all', $options);
			return $getDetails;
		}
		
	}
	
	public function getDetailGroupedByItem($options){
		if($options){
			$this->recursive = 0;
			$this->virtualFields = array(
									'sum_quantity' 	 => 'sum(`AcrInvoiceDetail.quantity`)',
									'sum_line_total' => 'sum(`AcrInvoiceDetail.unit_rate`)',
									'price_prod'	 =>'sum(`AcrInvoiceDetail.quantity` * `AcrInvoiceDetail.unit_rate`)',
									'avg_price'		 =>'('.'sum(`AcrInvoiceDetail.quantity` * `AcrInvoiceDetail.unit_rate )'.')/'.'sum(`AcrInvoiceDetail.quantity`)'
								);
			$this->unbindModel(array('belongsTo' => array('SbsSubscriberTax','SbsSubscriberTaxGroup')));
			$getAllItems = $this->find('all', $options);
			return $getAllItems;
		}
	}
	
	public function check_tax_exist($subscriber_id=null,$tax_id=null){
			
		$invoice_tax_exist = $this->find('first',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriber_id,'AcrInvoiceDetail.sbs_subscriber_tax_id'=>$tax_id),'contain'=>array('AcrClientInvoice.sbs_subscriber_id'),'fields'=>array('AcrInvoiceDetail.acr_client_invoice_id','AcrInvoiceDetail.sbs_subscriber_tax_id','AcrInvoiceDetail.id'))); 
		if($invoice_tax_exist){
			return $invoice_tax_exist;
		}else{
			return false;
		}
	}
	
}
