<?php
App::uses('AppModel', 'Model');
/**
 * SbsSubscriberTaxGroupMapping Model
 *
 * @property SbsSubscriberTax $SbsSubscriberTax
 * @property SbsSubscriberTaxGroup $SbsSubscriberTaxGroup
 */
class SbsSubscriberTaxGroupMapping extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'sbs_subscriber_tax_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'sbs_subscriber_tax_group_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
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
	
	public function checkMappingForTax($taxId = null){
		$mappingExists = $this->find('first',array('conditions'=>array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_id'=>$taxId)));
		return $mappingExists;
	}
	
	public function getGroupMapping($groupId = null){
		$this->recursive = 0;
		$mappingInfo = $this->find('all',array('conditions'=>array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_group_id'=>$groupId),'order'=>array('SbsSubscriberTaxGroupMapping.priority Asc')));
		return $mappingInfo;
	}
	
	public function getGroupMappingByTaxname($groupId = null,$tax_name=null,$subscriber=null){
		
		$taxList= $this->SbsSubscriberTax->find('list',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber,'SbsSubscriberTax.name like'=>'%'.$tax_name.'%'),'fields'=>array('SbsSubscriberTax.id')));
		$mappingInfo = $this->find('all',array('conditions'=>array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_group_id'=>$groupId,'SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_id'=>$taxList)));
		return $mappingInfo;
	}
	
	public function add_tax_group_mapping($priority=null,$tax_id=null,$compounded=null,$group_id=null){
		
		if($compounded == '1'){
		$status = 'Y';	
		}else{
		$status = 'N';	
		}
		//$mapping_exists=$this->find('first',array('conditions'=>array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_id'=>$tax_id,'SbsSubscriberTaxGroupMapping.priority'=>$priority,'SbsSubscriberTaxGroupMapping.compounded'=>$status)));
		//if(empty($mapping_exists)){
			    $addTaxMapping=null;
				$this->create();
				$addTaxMapping['SbsSubscriberTaxGroupMapping']['priority']                    = $priority;
				$addTaxMapping['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id']       = $tax_id;
				$addTaxMapping['SbsSubscriberTaxGroupMapping']['compounded']                  = $status;
				$addTaxMapping['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_group_id'] = $group_id;
				debug($addTaxMapping);
				if($this->save($addTaxMapping)){
					return true;
				}else{
					return false;
				}	
		//}
	}
	public function sameGroupingExist($subscriber_id = null,$taxId = null,$groupId = null){
		if($subscriber_id && $taxId && $groupId){
			$mapping = $this->find('first',array('conditions'=>array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_group_id'=>$groupId,'SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_id'=>$taxId)));
			if($mapping){
				return true;
			}else{
				return false;
			}
		}
	}
	public function updateTaxGroup($group_id=null){
		
		$lastMappingId=$this->find('first',array('conditions'=>array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_group_id'=>$group_id),'order'=>array('SbsSubscriberTaxGroupMapping.id DESC'),'fields'=>array('SbsSubscriberTaxGroupMapping.compounded','SbsSubscriberTaxGroupMapping.id')));
		if($lastMappingId['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y'){
			    $updateGroup=null;
				$updateGroup['SbsSubscriberTaxGroup']['id']         = $group_id;
				$updateGroup['SbsSubscriberTaxGroup']['compounded'] = $lastMappingId['SbsSubscriberTaxGroupMapping']['compounded'];
				if($this->SbsSubscriberTaxGroup->save($updateGroup)){
					return true;
				}else{
					return false;
				}
		}
		
	}
	
	
}
