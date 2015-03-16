<?php
App::uses('AppController', 'Controller');
/**
 * SbsPaymentMethods Controller
 *
 * @property SbsPaymentMethod $SbsPaymentMethod
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SbsPaymentMethodsController extends AppController {

  

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');
    
    
    public function beforeFilter() {
	        parent::beforeFilter();
	      	$this->layout = "cpn_layout";
	  		$this->permission = $this->Session->read('Auth.AllPermissions.Manage Subscription');
	  		$subscriptionActive = 'active';
			$menuActive = 'Manage Subscribers';
			$this->set(compact('subscriptionActive','menuActive'));
	    }
    
    
/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		$this->SbsPaymentMethod->recursive = 0;
		$this->set('sbsPaymentMethods', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SbsPaymentMethod->exists($id)) {
			throw new NotFoundException(__('Invalid sbs payment method'));
		}
		$options = array('conditions' => array('SbsPaymentMethod.' . $this->SbsPaymentMethod->primaryKey => $id));
		$this->set('sbsPaymentMethod', $this->SbsPaymentMethod->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SbsPaymentMethod->create();
			if ($this->SbsPaymentMethod->save($this->request->data)) {
				$this->Session->setFlash(__('The sbs payment method has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sbs payment method could not be saved. Please, try again.'));
			}
		}
		$cpnPaymentMethods = $this->SbsPaymentMethod->CpnPaymentMethod->find('list');
		$this->set(compact('cpnPaymentMethods'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->SbsPaymentMethod->exists($id)) {
			throw new NotFoundException(__('Invalid sbs payment method'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SbsPaymentMethod->save($this->request->data)) {
				$this->Session->setFlash(__('The sbs payment method has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sbs payment method could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SbsPaymentMethod.' . $this->SbsPaymentMethod->primaryKey => $id));
			$this->request->data = $this->SbsPaymentMethod->find('first', $options);
		}
		$cpnPaymentMethods = $this->SbsPaymentMethod->CpnPaymentMethod->find('list');
		$this->set(compact('cpnPaymentMethods'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->SbsPaymentMethod->id = $id;
		if (!$this->SbsPaymentMethod->exists()) {
			throw new NotFoundException(__('Invalid sbs payment method'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->SbsPaymentMethod->delete()) {
			$this->Session->setFlash(__('The sbs payment method has been deleted.'));
		} else {
			$this->Session->setFlash(__('The sbs payment method could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	
	public function payment_settings(){
		 
		
		$menuActive = 'Payment Gateway Setup';
		$settingsActive = 'active';
		
		
		$permission = $this->Session->read('Auth.AllPermissions.Payment Gateway Setup');
		$this->set(compact('permission','menuActive','settingsActive'));
		$subscriber_id = $this->Session->read('Auth.User.SbsSubscriber.id');
	 
		 
		$this->layout = 'sbs_layout';
		$this->LoadModel('CpnPaymentMethod');
		$this->LoadModel('CpnPaymentMethodAttribute');
		$this->LoadModel('SbsPaymentMethodValue');
		$this->LoadModel('SbsPaymentMethod');
		
	 	$payment_methods  = $this->CpnPaymentMethod->find('list',array('conditions'=>array('CpnPaymentMethod.status'=>'Active'),'fields'=>array('id','payment_option_name')));
		$find_paymentlist = $this->CpnPaymentMethod->find('list',array('conditions'=>array('CpnPaymentMethod.status'=>'Active')));
		
	 	foreach($find_paymentlist as $key=>$value){
		 	    $payment_attributes = $this->CpnPaymentMethodAttribute->find('all',array('conditions'=>array('CpnPaymentMethodAttribute.cpn_payment_method_id'=>$key)));
		        
		        if(!empty($payment_attributes)){
		     	    foreach($payment_attributes as $k=>$v){
		     	            $final_pay[$value][$v['CpnPaymentMethodAttribute']['id']]=  $v['CpnPaymentMethodAttribute']['attribute'];
		     	    }
		        }
		 }
		 
		$find_payment_method_values =  $this->SbsPaymentMethodValue->find('all',array('conditions'=>array('SbsPaymentMethodValue.subscriber_id'=>$subscriber_id)));
		$find_active_methods        =  $this->SbsPaymentMethod->find('list',array('conditions'=>array('SbsPaymentMethod.subscriber_id'=>$subscriber_id,'SbsPaymentMethod.status'=>'Active'),'fields'=>array('cpn_payment_method_id','status')));
		
		foreach($find_payment_method_values as $key2=>$value2){
			$values_present[$value2['SbsPaymentMethodValue']['cpn_payment_method_id']][$value2['SbsPaymentMethodValue']['cpn_payment_attribute_id']] =$value2['SbsPaymentMethodValue']['value'];  
		}
	 
		 if(!empty($this->data)){
		 	foreach($this->data['attribute_values'] as $key=>$value){
		 		 foreach($value as $k=>$v){
		 		 	if(!empty($v)){
		 		 	     $find_duplicate_value = $this->SbsPaymentMethodValue->find('first',array('conditions'=>array('SbsPaymentMethodValue.subscriber_id'=>$subscriber_id,'SbsPaymentMethodValue.cpn_payment_method_id'=>$key,'SbsPaymentMethodValue.cpn_payment_attribute_id'=>$k)));
		 		 	    if($find_duplicate_value){
		 		 	       $update_method_value=null;
				  		   $update_method_value['SbsPaymentMethodValue']['id']          = $find_duplicate_value['SbsPaymentMethodValue']['id'];
				  		   $update_method_value['SbsPaymentMethodValue']['value']       = $v;
				  		   $this->SbsPaymentMethodValue->save($update_method_value);
		 		 	    }else{
		 		 	       $addSbValue=null;
						   $this->SbsPaymentMethodValue->create();
						   $addSbValue['SbsPaymentMethodValue']['subscriber_id']            = $subscriber_id;
						   $addSbValue['SbsPaymentMethodValue']['cpn_payment_method_id']    = $key;
						   $addSbValue['SbsPaymentMethodValue']['cpn_payment_attribute_id'] = $k;
						   $addSbValue['SbsPaymentMethodValue']['value']                    = $v;
						   $this->SbsPaymentMethodValue->save($addSbValue);		
		 		 	    }
		 		 	}
		 		 }
		 	}
		 	
		 
		 	foreach($this->data['check_box'] as $key1=>$value1){
	 
			 		$find_duplicate_method = $this->SbsPaymentMethod->find('first',array('conditions'=>array('SbsPaymentMethod.subscriber_id'=>$subscriber_id,'SbsPaymentMethod.cpn_payment_method_id'=>$key1)));
	                if($find_duplicate_method){
			 			 if($value1 =='1'){
				  		 	$status = 'Active';
				  		 }else{
				  		 	$status = 'Inactive';
				  		 }
				  		 $update_method=null;
				  		 $update_method['SbsPaymentMethod']['id']          = $find_duplicate_method['SbsPaymentMethod']['id'];
				  		 $update_method['SbsPaymentMethod']['status']      = $status;
				  		 $this->SbsPaymentMethod->save($update_method);
			 		}else{
			 			if($value1 =='1'){
			 		        $default_pay_gateway = null;
					 		$this->SbsPaymentMethod->create();
					 		$default_pay_gateway['SbsPaymentMethod']['subscriber_id']         = $subscriber_id;
					 		$default_pay_gateway['SbsPaymentMethod']['cpn_payment_method_id'] = $key1;
					 		$default_pay_gateway['SbsPaymentMethod']['status'] = 'Active';
					 	    $this->SbsPaymentMethod->save($default_pay_gateway);	
			 		    }
			 		}
		    	} $this->redirect(array('action'=>'payment_settings')); 
		  }
		
		 $this->set(compact('final_pay','payment_methods','values_present','find_active_methods'));		
	}
}
