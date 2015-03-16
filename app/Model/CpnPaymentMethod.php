<?php
App::uses('AppModel', 'Model');
/**
 * CpnPaymentMethod Model
 *
 */
class CpnPaymentMethod extends AppModel {
	
	// fetch active records
	public function getManualPaymentOptions () {				
		$manualPaymentOptions = $this->find('all',array('conditions'=>array('CpnPaymentMethod.online_payment_option'=>'No','CpnPaymentMethod.status'=>'Active'),
		'fields'=>array('CpnPaymentMethod.id','CpnPaymentMethod.payment_option_name')));
		return $manualPaymentOptions; 
	}
	
	// fetch active records
	public function getOnlinePaymentOptions () {				
		$onlinePaymentOptions = $this->find('all',array('conditions'=>array('CpnPaymentMethod.online_payment_option'=>'Yes','CpnPaymentMethod.status'=>'Active'),
		'fields'=>array('CpnPaymentMethod.id','CpnPaymentMethod.payment_option_name')));
		return $onlinePaymentOptions; 
	}
	
	// fetch active records
	public function getAllPaymentOptions () {				
		$allPaymentOptions = $this->find('list',array('conditions'=>array('CpnPaymentMethod.status'=>'Active'),
		'fields'=>array('CpnPaymentMethod.id','CpnPaymentMethod.payment_option_name')));		
		return $allPaymentOptions; 
	}
	
	// fetch active records
	public function getManualPaymentOptionsList () {				
		$manualPaymentOptionsList = $this->find('list',array('conditions'=>array('CpnPaymentMethod.online_payment_option'=>'No','CpnPaymentMethod.status'=>'Active'),
		'fields'=>array('CpnPaymentMethod.id','CpnPaymentMethod.payment_option_name')));
		return $manualPaymentOptionsList; 
	}
	//fetch Payment Method Id
	public function getPaymentMethodByname($paymentMethod){
		$getpaymentMethod = $this->find('first',array('conditions'=>array('CpnPaymentMethod.payment_option_name'=>$paymentMethod)));
		if($getpaymentMethod){
			return $getpaymentMethod['CpnPaymentMethod']['id'];
		}else{
			return false;
		}
	}
	//add a new payment method
	public function addNewPaymentMethod($paymentMethodName = null,$paymentMethodOnline = "No"){
		if($paymentMethodName){
			$newPaymentMethod->data = null;
			$this->create();
			$newPaymentMethod->data['CpnPaymentMethod']['payment_option_name']   = $paymentMethodName;
			$newPaymentMethod->data['CpnPaymentMethod']['online_payment_option'] = $paymentMethodOnline;
			$newPaymentMethod->data['CpnPaymentMethod']['status'] 				 = 'Active';
			$newPaymentMethod->data['CpnPaymentMethod']['updated'] 				 = date('Y-m-d H:i:s');
			if($this->save($newPaymentMethod->data)){
				return $this->getLastInsertId();
			}else{
				return false;
			}
		}
	}
}
?>