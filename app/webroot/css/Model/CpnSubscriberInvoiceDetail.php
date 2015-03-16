<?php
App::uses('AppModel', 'Model');
/**
 * CpnSubscriberInvoiceDetail Model
 *
 * @property SbsSubscriber $SbsSubscriber
 * @property CpnRecurringInvoice $CpnRecurringInvoice
 */
class CpnSubscriberInvoiceDetail extends AppModel {


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
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CpnRecurringInvoice' => array(
			'className' => 'CpnRecurringInvoice',
			'foreignKey' => 'cpn_subscriber_invoice_detail_id',
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
	
	
	public function getInvoiceStatusBasedOnSubscriberId($subscriberId = null){
		if($subscriberId){
			$getInvoiceDetail = $this->find('first',array('conditions'=>array('CpnSubscriberInvoiceDetail.sbs_subscriber_id'=>$subscriberId,'CpnSubscriberInvoiceDetail.last_payment_date like'=>date('Y-m').'%')));
			if($getInvoiceDetail){
				return $getInvoiceDetail;
			}else{
				return false;
			}
		}
	}
	
	public function getLastMonthInvoiceStatusBasedOnSubscriberId($subscriberId = null){
		if($subscriberId){
		
			$getInvoiceDetail = $this->find('first',array('conditions'=>array('CpnSubscriberInvoiceDetail.sbs_subscriber_id'=>$subscriberId,'CpnSubscriberInvoiceDetail.last_payment_date like'=>date("Y-m", strtotime("-1 months")).'%')));
			if($getInvoiceDetail){
				return $getInvoiceDetail;
			}else{
				return false;
			}
		}
	}
	public function getSixMonthInvoiceValues(){
		for($i=0;$i<=5;$i++){
			$getInvoiceDetailPaid 																				= $this->find('all',array('conditions'=>array('CpnSubscriberInvoiceDetail.payment_status'=>'Completed','CpnSubscriberInvoiceDetail.last_payment_date like'=>date("Y-m",strtotime( date( 'Y-m-01' )." -$i months")).'%'),'fields'=>array('CpnSubscriberInvoiceDetail.id','CpnSubscriberInvoiceDetail.last_payment_amount')));
			$getInvoiceDetailPending 																			= $this->find('all',array('conditions'=>array('CpnSubscriberInvoiceDetail.payment_status'=>'Pending','CpnSubscriberInvoiceDetail.last_payment_date like'=>date("Y-m",strtotime( date( 'Y-m-01' )." -$i months")).'%'),'fields'=>array('CpnSubscriberInvoiceDetail.id','CpnSubscriberInvoiceDetail.last_payment_amount')));
			$getInvoiceDetailCancelled 																			= $this->find('all',array('conditions'=>array('OR'=>array('CpnSubscriberInvoiceDetail.payment_status'=>'Failed','CpnSubscriberInvoiceDetail.payment_status'=>'Refunded'),'CpnSubscriberInvoiceDetail.last_payment_date like'=>date("Y-m",strtotime( date( 'Y-m-01' )." -$i months")).'%'),'fields'=>array('CpnSubscriberInvoiceDetail.id','CpnSubscriberInvoiceDetail.last_payment_amount')));
			$finalArray[date("Y-M", strtotime("-$i months"))]['PaidInvoiceCount'] 								= count($getInvoiceDetailPaid);
			$finalArray[date("Y-M", strtotime("-$i months"))]['PendingInvoiceCount'] 							= count($getInvoiceDetailPending);
			$finalArray[date("Y-M", strtotime("-$i months"))]['CancelledInvoiceCount']  						= count($getInvoiceDetailCancelled);
			foreach($getInvoiceDetailPaid as $getInvoiceDetailPaidValue){
				$finalArray[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['Subscription'] 			= $finalArray[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['Subscription'] + $getInvoiceDetailPaidValue['CpnSubscriberInvoiceDetail']['last_payment_amount'] ;
			}
			foreach($getInvoiceDetailPending as $getInvoiceDetailPendingValue){
				$finalArray[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['Due Subscription'] 		= $finalArray[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['Due Subscription'] + $getInvoiceDetailPendingValue['CpnSubscriberInvoiceDetail']['last_payment_amount'] ;
			}
			foreach($getInvoiceDetailCancelled as $getInvoiceDetailCancelledValue){
				$finalArray[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['Cancelled Subscription'] 	= $finalArray[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['Cancelled Subscription'] + $getInvoiceDetailCancelled['CpnSubscriberInvoiceDetail']['last_payment_amount'] ;
			}
			$finalArray[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['Total'] 						= $finalArray[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['Subscription'] + $finalArray[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['Due Subscription'];
		}	
		return $finalArray;
	}

}
