<?php
App::uses('AppModel', 'Model');
App::import('Component', 'SessionComponent'); 
/**
 * SbsSubscriber Model
 *
 * @property CpnSubscriptionPlan $CpnSubscriptionPlan
 * @property SbsSubscriberOrganizationDetail $SbsSubscriberOrganizationDetail
 * @property Aco $Aco
 * @property AcpExpenseCategory $AcpExpenseCategory
 * @property AcpExpense $AcpExpense
 * @property AcpInventoryExpense $AcpInventoryExpense
 * @property AcrClientCustomField $AcrClientCustomField
 * @property AcrClientInvoice $AcrClientInvoice
 * @property AcrClient $AcrClient
 * @property AcrInvoiceCustomField $AcrInvoiceCustomField
 * @property AcrInvoicePaymentDetail $AcrInvoicePaymentDetail
 * @property Aro $Aro
 * @property CpnSubscriberInvoiceDetail $CpnSubscriberInvoiceDetail
 * @property InvInventory $InvInventory
 * @property SbsSubscriberSetting $SbsSubscriberSetting
 * @property SbsSubscriberTaxGroup $SbsSubscriberTaxGroup
 * @property SbsSubscriberTax $SbsSubscriberTax
 * @property SlsQuotationCustomField $SlsQuotationCustomField
 * @property SlsQuotation $SlsQuotation
 * @property User $User
 */
class SbsSubscriber extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	public $virtualFields = array(
    	'fullname' => 'CONCAT(SbsSubscriber.name, " ", SbsSubscriber.surname)'
	);


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'CpnSubscriptionPlan' => array(
			'className' => 'CpnSubscriptionPlan',
			'foreignKey' => 'cpn_subscription_plan_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SbsSubscriberOrganizationDetail' => array(
			'className' => 'SbsSubscriberOrganizationDetail',
			'foreignKey' => 'sbs_subscriber_organization_detail_id',
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
		'Aco' => array(
			'className' => 'Aco',
			'foreignKey' => 'sbs_subscriber_id',
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
		'AcpExpenseCategory' => array(
			'className' => 'AcpExpenseCategory',
			'foreignKey' => 'sbs_subscriber_id',
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
		'AcpExpense' => array(
			'className' => 'AcpExpense',
			'foreignKey' => 'sbs_subscriber_id',
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
		'AcpInventoryExpense' => array(
			'className' => 'AcpInventoryExpense',
			'foreignKey' => 'sbs_subscriber_id',
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
		'AcrClientCustomField' => array(
			'className' => 'AcrClientCustomField',
			'foreignKey' => 'sbs_subscriber_id',
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
		'AcrClientInvoice' => array(
			'className' => 'AcrClientInvoice',
			'foreignKey' => 'sbs_subscriber_id',
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
		'AcrClient' => array(
			'className' => 'AcrClient',
			'foreignKey' => 'sbs_subscriber_id',
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
		'AcrInvoiceCustomField' => array(
			'className' => 'AcrInvoiceCustomField',
			'foreignKey' => 'sbs_subscriber_id',
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
		'AcrInvoicePaymentDetail' => array(
			'className' => 'AcrInvoicePaymentDetail',
			'foreignKey' => 'sbs_subscriber_id',
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
		'Aro' => array(
			'className' => 'Aro',
			'foreignKey' => 'sbs_subscriber_id',
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
		'CpnSubscriberInvoiceDetail' => array(
			'className' => 'CpnSubscriberInvoiceDetail',
			'foreignKey' => 'sbs_subscriber_id',
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
		'InvInventory' => array(
			'className' => 'InvInventory',
			'foreignKey' => 'sbs_subscriber_id',
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
		'SbsSubscriberSetting' => array(
			'className' => 'SbsSubscriberSetting',
			'foreignKey' => 'sbs_subscriber_id',
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
		'SbsSubscriberTaxGroup' => array(
			'className' => 'SbsSubscriberTaxGroup',
			'foreignKey' => 'sbs_subscriber_id',
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
		'SbsSubscriberTax' => array(
			'className' => 'SbsSubscriberTax',
			'foreignKey' => 'sbs_subscriber_id',
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
		'SlsQuotationCustomField' => array(
			'className' => 'SlsQuotationCustomField',
			'foreignKey' => 'sbs_subscriber_id',
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
		'SlsQuotation' => array(
			'className' => 'SlsQuotation',
			'foreignKey' => 'sbs_subscriber_id',
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'sbs_subscriber_id',
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

	
	public function addSubscriberDetails ($sbs_subscriber_organization_detail_id, $subsType = null){	
			
			$session = new SessionComponent(); 
			$name 					  				= $session->read('name');			
			$surname				  				= $session->read('surname');
			
			if($subsType == 'free'){
				$profile_id			= 'NA';
				$profile_status		= 'Active';	
				$profilestartdate	= 'NA'; 
			} else {
				$profile_id 		= $session->read('profile_id');	
				$profile_status		= $session->read('profile_status');
				$profilestartdate	= $session->read('profilestartdate');
			}	
			
			$cpn_subscription_plan_id 				= $session->read('cpn_subscription_plan_id');					
			$subscribed_date 						= date('Y-m-d');
							
			$saveSD->data = null;
			$this->create();			
			$saveSD->data['SbsSubscriber']['name']  								= $name;
			$saveSD->data['SbsSubscriber']['surname']  								= $surname;
			$saveSD->data['SbsSubscriber']['profileId']  							= $profile_id;
			$saveSD->data['SbsSubscriber']['status']  								= $profile_status;
			$saveSD->data['SbsSubscriber']['rp_startdate'] 							= $profilestartdate;
			$saveSD->data['SbsSubscriber']['subscribed_date'] 						= $subscribed_date;
			$saveSD->data['SbsSubscriber']['cpn_subscription_plan_id'] 				= $cpn_subscription_plan_id;
			$saveSD->data['SbsSubscriber']['sbs_subscriber_organization_detail_id']	= $sbs_subscriber_organization_detail_id;	
			if($this->save($saveSD->data)){
				$getLastInsertedId = $this->getLastInsertID();
				return $getLastInsertedId;
			} else {
				return 0;
			}
	}
	
	
	public function getSubscriberBySubscriptionPlan($subscriptionPlanId = null){
		$getData = $this->find('all',array('conditions'=>array('SbsSubscriber.cpn_subscription_plan_id'=>$subscriptionPlanId)));
		if($getData){
			return $getData;
		}else{
			return false;
		}
	}
	public function getSubscriberBySubscriptionPlanForCurrentMonth($subscriptionPlanId = null){
		$getData = $this->find('all',array('conditions'=>array('SbsSubscriber.cpn_subscription_plan_id'=>$subscriptionPlanId,'SbsSubscriber.subscribed_date like'=>date('Y-m').'%')));
		if($getData){
			return $getData;
		}else{
			return false;
		}
	}
	public function getSubscriberBySubscriptionPlanForLastMonth($subscriptionPlanId = null){
		$getData = $this->find('all',array('conditions'=>array('SbsSubscriber.cpn_subscription_plan_id'=>$subscriptionPlanId,'SbsSubscriber.subscribed_date like'=>date("Y-m",strtotime( date('Y-m-01' )." -1 months")).'%')));
		//$getData = $this->find('all',array('conditions'=>array('SbsSubscriber.cpn_subscription_plan_id'=>$subscriptionPlanId,'SbsSubscriber.subscribed_date <='=>date('Y-m-d', strtotime('last day of previous month')))));
		if($getData){
			return $getData;
		}else{
			return false;
		}
	}
	public function getSubscriberBySubscriptionPlanForLastSixMonth(){
		for($i=0;$i<=5;$i++){
			$getData = $this->find('all',array('conditions'=>array('SbsSubscriber.subscribed_date like'=>date("Y-m",strtotime( date( 'Y-m-01' )." -$i months")).'%')));
			/*$j = $i+1;*/
			$prevMonthSub = 0;
			for($j= $i+1;$j<=5;$j++){
				$prevMonthCount = $this->find('count',array('conditions'=>array('SbsSubscriber.subscribed_date like'=>date("Y-m",strtotime( date( 'Y-m-01' )." -$j months")).'%')));
				$cancelledSub = $this->find('count',array('conditions'=>array('SbsSubscriber.status'=>'Cancelled','SbsSubscriber.updation like '=>date("Y-m",strtotime( date( 'Y-m-01' )." -$j months")).'%')));
				$prevMonthSub = $prevMonthSub + $prevMonthCount - $cancelledSub;
			}
			$finalArray[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['Previous Month Subscribers'] = $prevMonthSub;
			$finalArray[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['New Subscribers'] = count($getData);
			$finalArray[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['CancelledInvoiceCount'] = $this->find('count',array('conditions'=>array('SbsSubscriber.status'=>'Cancelled','SbsSubscriber.updation like '=>date("Y-m",strtotime( date( 'Y-m-01' )." -$i months")).'%')));
			
		}
		return $finalArray;
	}
	
	public function getSubscriberPerSubscriptionForSixMonth($subscriptionPlanList = null){
		foreach($subscriptionPlanList as $key => $val){
			for($i=0;$i<=5;$i++){
				
				$getData[$val][date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))] = $this->find('count',array('conditions'=>array('SbsSubscriber.cpn_subscription_plan_id'=>$key,'SbsSubscriber.subscribed_date like'=>date("Y-m",strtotime( date( 'Y-m-01' )." -$i months")).'%')));
				$getData1[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))] = $getData1[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))] + $getData[$val][date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))];
			}
		}
		$getData['Total'] = $getData1;
		return $getData;
	}
	
   public function getOrganisationDetailIdBYSubscriber($subscriber=null){
   	   if($subscriber){
   	   	    $organisationId=$this->find('first',array('conditions'=>array('SbsSubscriber.id'=>$subscriber),'fields'=>array('SbsSubscriber.sbs_subscriber_organization_detail_id')));
   	        if($organisationId){
   	        	return $organisationId['SbsSubscriber']['sbs_subscriber_organization_detail_id'];
   	        }else{
   	        	return false;
   	        }
	   }else{
	   	  return false;
	   }	
   	   
   }
   
   
   
}
