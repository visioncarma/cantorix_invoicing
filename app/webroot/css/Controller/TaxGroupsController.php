<?php
App::uses('AppController', 'Controller');
/**
 * SbsSubscriberTaxGroups Controller
 *
 * @property SbsSubscriberTaxGroup $SbsSubscriberTaxGroup
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TaxGroupsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('RequestHandler','Paginator', 'Session');
	public $helpers = array('Js' => array('Jquery'),'Html','Session','Form');
	public function beforeFilter() {
				
	        parent::beforeFilter();
	        $this->loadModel('SbsSubscriberTaxGroup');
	      	$this->layout = "sbs_layout";
	      	$this->permission = $this->Session->read('Auth.AllPermissions.Taxes');
	        $this->subscriber = $this->Session->read('Auth.User.SbsSubscriber.id');
	}


	/**
 * index method
 *
 * @return void
 */
	public function index($taxGroupName = null,$page=1) {
		$permission = $this->permission;
	    if($this->permission['_read'] != 1) {
	            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->set(compact('permission'));
		
		$this->loadModel('SbsSubscriberTax');
		if($taxGroupName){
			$this->request->data['SbsSubscriberTaxGroup']['group_name']=$taxGroupName;
		
		}
		$this->Paginator->settings = array(
       		 'SbsSubscriberTaxGroup' => array(
            		'page'	=> $page,
            		'order' => array('group_name' => 'ASC'),
            		'limit' =>'10'
       		 )
    		);
		$this->set(compact('page'));
		$this->CpnCurrency->recursive = 0;
		$this->SbsSubscriberTaxGroup->recursive = 0;
		
		if($this->data){
			 if($this->request->data['SbsSubscriberTaxGroup']['group_name']){
				$conditions = array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$this->subscriber,'SbsSubscriberTaxGroup.group_name like'=>'%'.trim($this->request->data['SbsSubscriberTaxGroup']['group_name']).'%');
				$taxGroupName = $this->request->data['SbsSubscriberTaxGroup']['group_name'];
				$this->set(compact('taxGroupName'));
			 }elseif(empty($this->request->data['SbsSubscriberTaxGroup']['group_name'])){
			 	$conditions = array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$this->subscriber);
			 }
		}
		else{ 
			$conditions = array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$this->subscriber);
		}
		
		$this->set('sbsSubscriberTaxGroups', $this->Paginator->paginate('SbsSubscriberTaxGroup',$conditions));
		$activeTaxes = $this->SbsSubscriberTax->getActiveTaxes($this->subscriber);
		$groupList = $this->SbsSubscriberTaxGroup->getTaxGroupListBySubscriber($this->subscriber);
		$activeTaxPercents=$this->SbsSubscriberTax->getTaxPercentBySubscriber($this->subscriber);
		$this->set(compact('taxGroupMappingList','activeTaxes','activeTaxPercents','groupList'));
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
	
	
	public function taxGroupUsed($groupId=null){
	    	
        $this->loadModel('InvInventory');
	    $this->loadModel('AcrInvoiceDetail');
	    $this->loadModel('SlsQuotationProduct');
		$subscriber_id=$this->subscriber;
		
		$InventoryGroup=$this->InvInventory->checkInventoryExistGroup($groupId,$subscriber_id);
	    $InvoiceExistTax=$this->AcrInvoiceDetail->checkInvoiceExistForTaxGroup($groupId,$subscriber_id);
	    $QuotaExistTax=$this->SlsQuotationProduct->checkQuotationExistForTaxGroup($groupId,$subscriber_id);
		if($InvoiceExistTax || $QuotaExistTax || $InventoryGroup){
			return "yes";
		}else{
			return "No";
		}
    	
    } 
	
	public function add_group(){
		
		if($this->permission['_create'] != 1) {
	            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->loadModel('SbsSubscriberTax');
		$this->loadModel('SbsSubscriberTaxGroup');
		$this->loadModel('SbsSubscriberTaxGroupMapping');
		$subscriber_id=$this->subscriber;
		
		if($this->request->is('post')) {
			
			$taxGroupExist = $this->SbsSubscriberTaxGroup->checkTaxGroupExists($this->data['SbsSubscriberTaxGroup']['group_name'],$subscriber_id);
			if($taxGroupExist){
				$this->Session->setFlash('<div class="alert alert-danger">Sorry! Tax group already exists.</div>');
			    $this->redirect(array('controller'=>'tax_groups','action' => 'index'));
				
			}else{
					$this->SbsSubscriberTaxGroup->create();
					$this->request->data['SbsSubscriberTaxGroup']['sbs_subscriber_id'] =  $subscriber_id;
					if($this->SbsSubscriberTaxGroup->save($this->request->data)){
						     
						      $lastInsertedId=$this->SbsSubscriberTaxGroup->getLastInsertId();
						      foreach($this->data['sbs_subscriber_tax_id'] as $key=>$value){
						      	      if($value){
						      	      	   $addTaxgroupping=$this->SbsSubscriberTaxGroupMapping->add_tax_group_mapping($this->data['priority'][$key],$key,$this->data['compounded'][$key],$lastInsertedId);
						      	      }
						      }
						      $updateGroupCompounded=$this->SbsSubscriberTaxGroupMapping->updateTaxGroup($lastInsertedId);
					}
					//$this->Session->setFlash(__('<div class="alert alert-block alert-success">Tax Group has been saved!</div>'));
					$this->redirect(array('controller'=>'tax_groups','action' => 'index'));
		 }
		}
		$taxList=$this->SbsSubscriberTax->getTaxesBySubscriber($subscriber_id);
		
		$count=count($taxList);
		$this->set(compact('taxList','count'));
	}
	
	
	
	public function edit_group($id=null){
		//Configure::write('debug',2);	
		//debug($this->data);
		if($this->permission['_update'] != 1) {
	        $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->loadModel('InvInventory');
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('SlsQuotationProduct');
		$this->loadModel('SbsSubscriberTax');
		$this->loadModel('SbsSubscriberTaxGroupMapping');
		$subscriber_id=$this->subscriber;
		
		
		$InvoiceExistTaxGroup=$this->AcrInvoiceDetail->checkInvoiceExistForTaxGroup($id);
	    $QuotaExistTaxGroup=$this->SlsQuotationProduct->checkQuotationExistForTaxGroup($id,$subscriber_id);
		$InventoryGroup=$this->InvInventory->checkInventoryExistGroup($id,$subscriber_id);
		
		if($this->request->is(array('post', 'put'))) {
        	
			    //$taxGroupExist = $this->SbsSubscriberTaxGroup->checkTaxGroupExists($this->data['SbsSubscriberTaxGroup']['group'.$id],$subscriber_id);
				//if($taxGroupExist){
					//$this->Session->setFlash('<div class="alert alert-danger">Sorry! Tax group already exists.</div>');
				    //$this->redirect(array('controller'=>'tax_groups','action' => 'index'));
					
				 //}else{
				 	  $edit_group=null;
                      $edit_group['SbsSubscriberTaxGroup']['id']          = $id;
                      $edit_group['SbsSubscriberTaxGroup']['group_name']  = $this->data['SbsSubscriberTaxGroup']['group'.$id];
                      if($this->SbsSubscriberTaxGroup->save($edit_group)){
                      	     $this->SbsSubscriberTaxGroup->cacheQueries = FALSE;
						     
                             foreach($this->data['priority'] as $k=>$v){
                                        	    	
                                                $tax_mapping_split=explode('/',$k);
								                $taxId=$tax_mapping_split[0];
												$taxmappingId=$tax_mapping_split[1];
                                        	    
                                        	    $checkGrouping = $this->SbsSubscriberTaxGroupMapping->sameGroupingExist($subscriber_id,$taxId,$id);
		                                        $edit_taxGroupMapping=null;
		                                        $edit_taxGroupMapping['SbsSubscriberTaxGroupMapping']['id']                          = $taxmappingId;
		                                        if((empty($InvoiceExistTaxGroup)) && (empty($QuotaExistTaxGroup)) && (empty($InventoryGroup))){
		                                           
		                                            $edit_taxGroupMapping['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id']   = $taxId;
		                                            $edit_taxGroupMapping['SbsSubscriberTaxGroupMapping']['priority']                = $v;
													$edit_taxGroupMapping['SbsSubscriberTaxGroupMapping']['compounded']              = $this->data['compounded'][$taxId];
		                                        }
												
		                                        if($this->SbsSubscriberTaxGroupMapping->save($edit_taxGroupMapping,array('validate'=>false))){
		                                        	  $this->SbsSubscriberTaxGroupMapping->cacheQueries = FALSE;
		                                        }
                                       
                              }
                              
                      //}	
				 }
        	          
		}	        
        
		
        $groupTaxInfo=$this->SbsSubscriberTaxGroup->getGroupInfo($id,$subscriber_id);
        $groupName = $groupTaxInfo['SbsSubscriberTaxGroup']['group_name'];
        
        $activeTaxes = $this->SbsSubscriberTax->getActiveTaxes($this->subscriber);
		$activeTaxPercents=$this->SbsSubscriberTax->getTaxPercentBySubscriber($this->subscriber);
		$this->set(compact('id','taxGroupMappingList','activeTaxes','activeTaxPercents','groupName'));
		
	}
	
	public function delete_group($id = null) {
		//Configure::write('debug',2);
		if($this->permission['_delete'] != 1) {
	        $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		//$this->autoRender=false;
		$this->loadModel('InvInventory');
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('SlsQuotationProduct');
		$this->loadModel('SbsSubscriberTaxGroup');
		$this->loadModel('SbsSubscriberTaxGroupMapping');
		$subscriber_id=$this->subscriber;
		
		$groupTaxMap	=	$this->SbsSubscriberTaxGroupMapping->getGroupMapping($id);
		$InvoiceExistTaxGroup=$this->AcrInvoiceDetail->checkInvoiceExistForTaxGroup($id);
	    $QuotaExistTaxGroup=$this->SlsQuotationProduct->checkQuotationExistForTaxGroup($id,$subscriber_id);
		$InventoryGroup=$this->InvInventory->checkInventoryExistGroup($id,$subscriber_id);
		
		if((empty($InvoiceExistTaxGroup)) && (empty($QuotaExistTaxGroup)) && (empty($InventoryGroup))){
			
			if($groupTaxMap){
				$this->SbsSubscriberTaxGroupMapping->deleteAll(array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_group_id' =>$id));
			}
			if($this->SbsSubscriberTaxGroup->delete($id)) {
				$this->Session->setFlash(__('<div class="alert alert-block alert-success">The tax group has been deleted.</div>'));
			}else{
			    $this->Session->setFlash('<div class="alert alert-danger">The tax group could not be deleted. Please, try again.</div>');
		    }
			
		}else{
			$this->Session->setFlash('<div class="alert alert-danger">The tax group could not be deleted. Please, try again.</div>');
		}
	}
    
    public function multi_group_delete($value = null) {
		$this->autoRender = false;	
		
		$this->loadModel('InvInventory');
		$this->loadModel('SlsQuotationProduct');
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('SbsSubscriberTaxGroup');
		$this->loadModel('SbsSubscriberTaxGroupMapping');
		$subscriber_id=$this->subscriber;
		
		$i = 0;
		if($this->data['Delete']){
			  $check_row=array_sum($this->data['Delete']);
			  if($value == 'delete'){
				    if($check_row){ 	
					     foreach($this->data['Delete'] as $del_id => $del_val):
						        if($del_val){
						        	 
						        	 $groupTax	=	$this->SbsSubscriberTaxGroupMapping->getGroupMapping($del_id);
						        	 $InvoiceExistTax=$this->AcrInvoiceDetail->checkInvoiceExistForTaxGroup($del_id);
	                                 $QuotaExistTax=$this->SlsQuotationProduct->checkQuotationExistForTaxGroup($del_id,$subscriber_id);
									 $InventoryGroup=$this->InvInventory->checkInventoryExistGroup($id,$subscriber_id);
									 
									 if((empty($InvoiceExistTaxGroup)) && (empty($QuotaExistTaxGroup)) && (empty($InventoryGroup))){
									 	
									 	     if($groupTax){
											 	
												$this->SbsSubscriberTaxGroupMapping->deleteAll(array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_group_id' =>$del_id));
											 }
											 $this->SbsSubscriberTaxGroup->delete($del_id);
									         $i++;
									 }
									 
									 
						        }
						 endforeach;
					     if ($i == 1) {
						      $this->Session->setFlash(__('<div class="alert alert-block alert-success">The  tax group has been deleted.</div>'));
					     }else {
					     	  $this->Session->setFlash(__('<div class="alert alert-block alert-success">The '.$i .' tax group have been deleted.</div>'));
						 }
					     $this->redirect(array('controller'=>'taxes','action' => 'index','grp'));
				  }
			      else{
			      	 $this->Session->setFlash('<div class="alert alert-danger">Select tax group to delete.</div>');
			  	     $this->redirect(array('controller'=>'taxes','action' => 'index','grp'));
			      }
			 }
	  }else{
			  	$this->Session->setFlash('<div class="alert alert-danger">Please select tax group to delete.</div>');
			  	$this->redirect(array('controller'=>'taxes','action' => 'index','grp'));
		   }
	}
	
	public function groupcheck(){
		//Configure::write('debug',2);
		
		$this->autoRender=false;
		$this->loadModel('SbsSubscriberTaxGroup');
		$subscriber_id=$this->subscriber;
		$taxGroup=$this->SbsSubscriberTaxGroup->find('first',array('conditions'=>array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$subscriber_id,'SbsSubscriberTaxGroup.group_name'=>trim($this->params->query['group_name']))));
	    
	    if(!$taxGroup){
		  	echo 1;
		  }else{
		  	echo 0;
		  }
	}
	
}
