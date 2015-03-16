<?php
App::uses('AppController', 'Controller');
/**
 * SbsSubscriberTaxes Controller
 *
 * @property SbsSubscriberTax $SbsSubscriberTax
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TaxesController extends AppController {

    public $components = array('Paginator', 'Session');
	public function beforeFilter() {
		    
	        parent::beforeFilter();
	      	$this->layout = "sbs_layout";
	      	$this->permission = $this->Session->read('Auth.AllPermissions.Taxes');
	        $this->subscriber = $this->Session->read('Auth.User.SbsSubscriber.id');
			$settingsActive = 'active';
			$menuActive = 'Taxes';
			$this->set(compact('settingsActive','menuActive'));
	}


	public function index($taxname = null,$taxcode = null,$pages = 1) {
	    
	    $permission = $this->permission;
		$this->set(compact('permission'));
	    if($this->permission['_read'] != 1) {
	       $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->set(compact('permission'));
	    $this->loadModel('SbsSubscriberTax');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('SbsSubscriberTaxGroup');
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('SlsQuotationProduct');
		
	    if($taxname){
			$this->request->data['SbsSubscriberTax']['name']=$taxname;
		
		}elseif($taxcode){
			$this->request->data['SbsSubscriberTax']['code']=$taxcode;
		
		}elseif($taxname && $taxcode){
			$this->request->data['SbsSubscriberTax']['name']=$taxname;
			$this->request->data['SbsSubscriberTax']['code']=$taxcode;
		}
		$subscriber_id=$this->subscriber;
		$settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$limit = $settings['SbsSubscriberSetting']['lines_per_page'];
		
	    if($this->data){
	    		
			if(empty($this->data['SbsSubscriberTax']['name']) && (empty($this->data['SbsSubscriberTax']['code']))){ 
			       $this->Session->setFlash('<div class="alert alert-danger">Please enter the search term.</div>');
			       $this->redirect(array('controller'=>'taxes','action' => 'index'));
		
			}elseif(($this->data['SbsSubscriberTax']['name']) && (empty($this->data['SbsSubscriberTax']['code']))){ 
			      $conditions=array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber_id,'SbsSubscriberTax.name like'=>'%'.trim($this->data['SbsSubscriberTax']['name']).'%');
		          $taxname=$this->data['SbsSubscriberTax']['name'];
		          $this->set(compact('taxname'));
		
			}elseif(empty($this->data['SbsSubscriberTax']['name']) && (($this->data['SbsSubscriberTax']['code']))){
				$conditions=array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber_id,'SbsSubscriberTax.code like'=>'%'.trim($this->data['SbsSubscriberTax']['code']).'%');
			    $taxcode=$this->data['SbsSubscriberTax']['code'];
			    $this->set(compact('taxcode'));
			  
			}elseif(($this->data['SbsSubscriberTax']['name']) && (($this->data['SbsSubscriberTax']['code']))){
				$conditions=array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber_id,'SbsSubscriberTax.code like'=>'%'.$this->data['SbsSubscriberTax']['code'].'%','SbsSubscriberTax.name like'=>'%'.trim($this->data['SbsSubscriberTax']['name']).'%');
			    $taxcode=$this->data['SbsSubscriberTax']['code'];
			    $taxname=$this->data['SbsSubscriberTax']['name'];
			    $this->set(compact('taxname'));
			    $this->set(compact('taxcode'));
			
			}
	    }
	    
		else{
			$conditions=array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber_id);
		}
		
	    $this->Paginator->settings = array('conditions'=>$conditions,'limit'=>$limit,'order' => array('name' => 'ASC'));
	    $this->set('sbsSubscriberTaxes', $this->Paginator->paginate('SbsSubscriberTax'));
		
		$activeTaxes=$this->SbsSubscriberTax->getTaxesBySubscriber($subscriber_id);
		$activeTaxPercents=$this->SbsSubscriberTax->getTaxPercentBySubscriber($subscriber_id);
		$this->set(compact('activeTaxes','activeTaxPercents','val'));
		
		
	}

    public function getTaxByGroupId($groupId=null,$tax_name=null){
        
        $subscriber_id=$this->subscriber;
        $this->loadModel('SbsSubscriberTaxGroupMapping');
        if($tax_name){
        	$taxGroupMapping=$this->SbsSubscriberTaxGroupMapping->getGroupMappingByTaxname($groupId,$tax_name,$subscriber_id);
        }else{
        	$taxGroupMapping=$this->SbsSubscriberTaxGroupMapping->getGroupMapping($groupId);
        }
    	return $taxGroupMapping;
    } 

    public function getTaxByGroupIdForCheck($groupId=null,$tax_name=null){
        
        $subscriber_id=$this->subscriber;
        $this->loadModel('SbsSubscriberTaxGroupMapping');
        if($tax_name){
        	$taxGroupMapping=$this->SbsSubscriberTaxGroupMapping->getGroupMappingByTaxname($groupId,$tax_name,$subscriber_id);
        }else{
        	$taxGroupMappingCheck=$this->SbsSubscriberTaxGroupMapping->getCompoundGroupMapping($groupId);
        }
    	return $taxGroupMappingCheck;
    } 
    	
    
   public function add() {
		if($this->permission['_create'] != 1) {
	            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->loadModel('SbsSubscriberTax');
		$subscriber_id=$this->subscriber;
		
		if($this->request->is('post')) {
			
			$taxNameExist = $this->SbsSubscriberTax->checkTaxExists($this->data['SbsSubscriberTax']['name'],$subscriber_id);
			$taxCodeExist = $this->SbsSubscriberTax->checkTaxCodeExists($this->data['SbsSubscriberTax']['code'],$subscriber_id);  
			if($taxNameExist){
				   $this->Session->setFlash('<div class="alert alert-danger">Sorry! Tax name already exists.</div>');
			       $this->redirect(array('controller'=>'taxes','action' => 'index'));
			
			}elseif($taxCodeExist){
			      $this->Session->setFlash('<div class="alert alert-danger">Sorry! Tax code already exists.</div>');
			      $this->redirect(array('controller'=>'taxes','action' => 'index'));
			
			}else{
				    $this->SbsSubscriberTax->create();
					$this->request->data['SbsSubscriberTax']['sbs_subscriber_id'] =  $subscriber_id;
					if($this->SbsSubscriberTax->save($this->request->data)) {
						$this->Session->setFlash(__('<div class="alert alert-block alert-success">Tax has been saved!</div>'));
						$this->redirect(array('action' => 'index'));
					
					} else {
						$this->Session->setFlash('<div class="alert alert-danger">Sorry! The tax could not be saved. Please, try again!</div>');
						$this->redirect(array('action' => 'index'));
					}
			}
		}
	}
   
    public function edit($id = null) {
		if($this->permission['_update'] != 1) {
	        $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$permission = $this->permission;
		$this->set(compact('permission'));
		$this->loadModel('SbsSubscriberTax');
		$this->loadModel('InvInventory');
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('SlsQuotationProduct');
		$this->loadModel('SbsSubscriberTaxGroupMapping');
		$subscriber_id=$this->subscriber;
		
		if($this->data){
			    
			    $InvoiceExistTax=$this->AcrInvoiceDetail->checkInvoiceExistForTax($id);
			    $QuotaExistTax=$this->SlsQuotationProduct->checkQuotationExistForTax($id,$subscriber_id);
				$InventoryExistTax=$this->InvInventory->checkInventoryExistTax($id,$subscriber_id);
			    $MappingExists=$this->SbsSubscriberTaxGroupMapping->checkMappingForTax($id);
			   
			    $taxIdDetail=$this->SbsSubscriberTax->find('first',array('conditions'=>array('SbsSubscriberTax.id'=>$id)));
			    $taxName=$this->SbsSubscriberTax->find('first',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber_id,'SbsSubscriberTax.name'=>trim($this->data['tax_name'][$id]))));
			    $taxCode=$this->SbsSubscriberTax->find('first',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber_id,'SbsSubscriberTax.code'=>trim($this->data['tax_code'][$id]))));
			    
				if((empty($this->data['tax_name'][$id])) || (empty($this->data['tax_code'][$id])) || (empty($this->data['tax_percent'][$id])) || (($taxIdDetail['SbsSubscriberTax']['name'] != ($this->data['tax_name'][$id])) && ($taxName)) || (($taxIdDetail['SbsSubscriberTax']['code'] != ($this->data['tax_code'][$id])) && ($taxCode))){
					 $this->set(compact('id'));	
				}else{
					    $edit_tax=null;
					 	$edit_tax['SbsSubscriberTax']['id']      = $id;
					 	$edit_tax['SbsSubscriberTax']['name']    = $this->data['tax_name'][$id];
					 	$edit_tax['SbsSubscriberTax']['code']    = $this->data['tax_code'][$id];
					 	
					 	if((empty($InvoiceExistTax)) && (empty($QuotaExistTax)) && (empty($MappingExists)) && (empty($InventoryExistTax))){
					 	   $edit_tax['SbsSubscriberTax']['percent'] = $this->data['tax_percent'][$id];
					 	}
					 	if($this->SbsSubscriberTax->save($edit_tax,array('validate'=>false))) {
					 		
							$this->SbsSubscriberTax->cacheQueries = FALSE;
					 		$getTaxDetails = $this->SbsSubscriberTax->getTaxById($id);
					 		$taxName1 = $getTaxDetails['SbsSubscriberTax']['name'];
					 		$taxCode1 = $getTaxDetails['SbsSubscriberTax']['code'];
					 		$percentage1 = $getTaxDetails['SbsSubscriberTax']['percent'];
					 		$this->set(compact('taxName','taxCode','percentage','id'));
					 		
					 		if((empty($InvoiceExistTax)) && (empty($QuotaExistTax)) && (empty($MappingExists))){
						 	   //$this->Session->setFlash(__('<div class="alert alert-block alert-success">Tax has been updated!</div>'));	
						 	}else{
						 	   //$this->Session->setFlash(__('<div class="alert alert-block alert-success">Tax name and code has been updated but percentage cannot be altered !</div>'));	
						 	}
					 	}
				}
		}
        $taxIdDetails=$this->SbsSubscriberTax->find('first',array('conditions'=>array('SbsSubscriberTax.id'=>$id)));
        $this->set(compact('taxIdDetails'));
	}


	public function delete($id = null) {
		if($this->permission['_delete'] != 1) {
	        $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->loadModel('InvInventory');
		$this->loadModel('SbsSubscriberTax');
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('SlsQuotationProduct');
		$this->loadModel('SbsSubscriberTaxGroupMapping');
		$subscriber_id=$this->subscriber;
		
		$taxInfo=$this->SbsSubscriberTax->getTaxById($id);
		$InventoryExistTax=$this->InvInventory->checkInventoryExistTax($id,$subscriber_id);
		$InvoiceExistTax=$this->AcrInvoiceDetail->checkInvoiceExistForTax($id);
	    $QuotaExistTax=$this->SlsQuotationProduct->checkQuotationExistForTax($id,$subscriber_id);
	    $MappingExists=$this->SbsSubscriberTaxGroupMapping->checkMappingForTax($id);
		
		//$this->autoRender=false;
		if(!empty($taxInfo)){
			if((empty($InvoiceExistTax)) && (empty($QuotaExistTax)) && (empty($MappingExists)) && (empty($InventoryExistTax))){
				 if($this->SbsSubscriberTax->delete($id)){
				 	 $this->Session->setFlash(__('<div class="alert alert-block alert-success">The tax has been deleted!</div>'));
				 }
			}else{
				 $this->Session->setFlash('<div class="alert alert-danger">Sorry! The tax could not be deleted. Please, try again!</div>');
			}
		} else {
			$this->Session->setFlash('<div class="alert alert-danger">Sorry! The tax could not be deleted. Please, try again!</div>');
		}
		//return $this->redirect(array('action' => 'index'));
	}
	
	public function multi_tax_delete($value = null) {
		$this->autoRender = false;	
		$this->loadModel('InvInventory');
		$this->loadModel('SbsSubscriberTax');
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('SlsQuotationProduct');
		$this->loadModel('SbsSubscriberTaxGroupMapping');
		$subscriber_id=$this->subscriber;
		
		$i = 0;
		if($this->data['Delete']){
			  $check_row=array_sum($this->data['Delete']);
			  if($value == 'delete'){
				    if($check_row){ 	
					     foreach($this->data['Delete'] as $del_id => $del_val):
						        if($del_val){
						        	
						        	    $InvoiceExistTax=$this->AcrInvoiceDetail->checkInvoiceExistForTax($del_id);
									    $QuotaExistTax=$this->SlsQuotationProduct->checkQuotationExistForTax($del_id,$subscriber_id);
									    $MappingExists=$this->SbsSubscriberTaxGroupMapping->checkMappingForTax($del_id);
									    $InventoryExistTax=$this->InvInventory->checkInventoryExistTax($id,$subscriber_id);
									    if((empty($InvoiceExistTax)) && (empty($QuotaExistTax)) && (empty($MappingExists)) && (empty($InventoryExistTax))){ 
									    	    $this->SbsSubscriberTax->delete($del_id);
							                    $i++;
									    }
						        	   
						        }
						 endforeach;
					     if ($i == 1) {
						      $this->Session->setFlash(__('<div class="alert alert-block alert-success">The tax has been deleted!</div>'));
					     }else {
					     	  $this->Session->setFlash(__('<div class="alert alert-block alert-success">The '.$i .' taxes have been deleted!</div>'));
						 }
					     $this->redirect(array('controller'=>'taxes','action' => 'index'));
				  }
			      else{
			      	 $this->Session->setFlash('<div class="alert alert-danger">Select tax to delete!</div>');
			  	     $this->redirect(array('controller'=>'taxes','action' => 'index'));
			      }
			 }
	  }else{
			  	$this->Session->setFlash('<div class="alert alert-danger">Please select taxes to delete!</div>');
			  	$this->redirect(array('controller'=>'taxes','action' => 'index'));
		   }
	}
	
	
	public function taxnamecheck(){
		 
		  $this->autoRender = false;	
		  $this->loadModel('SbsSubscriberTax');
		  $subscriber_id=$this->subscriber;
		  
		  $taxnameExist=$this->SbsSubscriberTax->find('first',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber_id,'SbsSubscriberTax.name'=>trim($this->params->query['name'])),'fields'=>array('SbsSubscriberTax.name')));
		  if($taxnameExist){
		  	echo 1;
		  }else{
		  	echo 0;
		  }
	}
	
	public function taxcodecheck(){
		 
		  $this->autoRender = false;	
		  $this->loadModel('SbsSubscriberTax');
		  $subscriber_id=$this->subscriber;
		  
		  $taxcodeExist=$this->SbsSubscriberTax->find('first',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber_id,'SbsSubscriberTax.code'=>trim($this->params->query['code'])),'fields'=>array('SbsSubscriberTax.code')));
		  if($taxcodeExist){
		  	echo 1;
		  }else{
		  	echo 0;
		  }
	}	
	
	public function taxPercentChange($id=null){
		
		$this->autoRender=false;
		$subscriber_id=$this->subscriber;
		$this->loadModel('InvInventory');
		$this->loadModel('SbsSubscriberTax');
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('SlsQuotationProduct');
		$this->loadModel('SbsSubscriberTaxGroupMapping');
		
		$InvoiceExistTax=$this->AcrInvoiceDetail->checkInvoiceExistForTax($id);
	    $QuotaExistTax=$this->SlsQuotationProduct->checkQuotationExistForTax($id,$subscriber_id);
	    $InventoryExistTax=$this->InvInventory->checkInventoryExistTax($id,$subscriber_id);
	    $MappingExists=$this->SbsSubscriberTaxGroupMapping->checkMappingForTax($id);
		if((empty($InvoiceExistTax)) && (empty($QuotaExistTax)) && (empty($MappingExists)) && (empty($InventoryExistTax))){
			return true;
		}else{
			return false;
		}	
		exit;
	}
	
}
