<?php
App::uses('AppController', 'Controller');
class CustomFieldsController extends AppController {
	/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','Email', 'RequestHandler', 'Session');
	public $uses = array('AcrClientCustomField');
	public function beforeFilter() {
        parent::beforeFilter();
      		 $this->layout = "sbs_layout";
      		 $this->permission = $this->Session->read('Auth.AllPermissions.CustomFields');
       		 $this->subscriber = $this->Session->read('Auth.User.SbsSubscriber.id');
      		 $customFieldActive = 'active';
			 $this->set(compact('invoicesActive'));
    }
    
    public function add(){
    	if ($this->request->is('post')) {
    		if($this->data['CustomField']['module']){
    			$module = $this->data['CustomField']['module'];
    			$this->loadModel($module);
    			if($module){
		    		/*$getCustomFields = $this->$module->getListOfFields($this->subscriber);
		    		if($getCustomFields){
		    			$countCustomField = count($getCustomFields);
		    			$this->set(compact('getCustomFields','countCustomField'));
		    		}*/
		    	}
		    	foreach($this->data['CustomField']['fieldOld'] as $keyOld=>$valOld){
					if($valOld){
						$dataUpdate['id']					=	$keyOld;
						$dataUpdate['sbs_subscriber_id']	=	$this->subscriber;
						$dataUpdate['field_name']			=	$valOld;
						$addCustomField = $this->$module->updateField($dataUpdate);
					}else{
						$this->$module->id = $keyOld;
						$this->$module->delete();
					}
				}  
				foreach($this->data['CustomField']['field'] as $key=>$val){
					if($val){
						$dataAdd['sbs_subscriber_id']	=	$this->subscriber;
						$dataAdd['field_name']			=	$val;
						$addCustomField = $this->$module->addField($dataAdd);
					}
				}  
				if($addCustomField){
							$this->Session->setFlash(__('<div class="alert alert-block alert-success">Custom Fields added.</div>'));
				}else{
					$this->Session->setFlash('<div class="alert alert-danger">Sorry!Mandatory field cannot be left empty.</div>');
				}  			
    		}else{
    			$this->Session->setFlash('<div class="alert alert-danger">Sorry! There are no module selected.</div>');
    		}
    		return $this->redirect(array('action' => 'add'));
    	}
    	
    }
    
    public function listFields(){
    	configure::write('debug',2);
    	
    	if($this->data['CustomField']['module']){
    		$module = $this->data['CustomField']['module'];
    		$this->loadModel($module);
    		$getCustomFields = $this->$module->getListOfFields($this->subscriber);
    		$countCustomField = count($getCustomFields);
		    $this->set(compact('getCustomFields','countCustomField','module'));
    	}
    }
    public function remove($customFieldKey,$module){
    	$this->loadModel($module);
    	/*$this->autoRender = false;*/
    	$this->$module->id = $customFieldKey;
		$this->$module->delete();
    	$getCustomFields = $this->$module->getListOfFields($this->subscriber);
    	$countCustomField = count($getCustomFields);
		$this->set(compact('getCustomFields','countCustomField','module'));
    }
}
?>