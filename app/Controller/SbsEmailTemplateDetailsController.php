<?php
App::uses('AppController', 'Controller');
/**
 * SbsEmailTemplateDetails Controller
 *
 * @property SbsEmailTemplateDetail $SbsEmailTemplateDetail
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SbsEmailTemplateDetailsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','Email', 'RequestHandler', 'Session');
	
	public function beforeFilter() {
        parent::beforeFilter();
       $this->layout = "sbs_layout";
       $this->permission = $this->Session->read('Auth.AllPermissions.Email Configuration');
       $this->subscriber = $this->Session->read('Auth.User.SbsSubscriber.id');
       $emailTemplateActive = 'active';
	   $this->set(compact('emailTemplateActive'));
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$settingsActive = 'active';
		$menuActive = 'Email Configuration';
		$this->set(compact('settingsActive','menuActive'));
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->set(compact('permission'));
		$this->SbsEmailTemplateDetail->recursive = 0;
		$conditions 			= array('SbsEmailTemplateDetail.sbs_subscriber_id'=>$this->subscriber);
		$this->Paginator->settings = array('conditions'=>$conditions);
		$this->set('sbsEmailTemplateDetails', $this->Paginator->paginate('SbsEmailTemplateDetail'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$settingsActive = 'active';
		$menuActive = 'Email Configuration';
		$this->set(compact('settingsActive','menuActive'));
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->set(compact('permission'));
		$this->loadModel('SbsSubscriberSetting');
		if (!$this->SbsEmailTemplateDetail->exists($id)) {
			throw new NotFoundException(__('Invalid sbs email template detail'));
		}
		$options = array('conditions' => array('SbsEmailTemplateDetail.' . $this->SbsEmailTemplateDetail->primaryKey => $id));
		$this->set('sbsEmailTemplateDetail', $this->SbsEmailTemplateDetail->find('first', $options));
		$settings 		= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$signature		= $settings['SbsSubscriberSetting']['email_signature'];	
		$this->set(compact('signature'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($id = null) {
		
		$settingsActive = 'active';
		$menuActive = 'Email Configuration';
		$this->set(compact('settingsActive','menuActive'));
		$permission = $this->permission;
		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->set(compact('permission'));
		
		
		$this->loadModel('User');
		if($this->request->is('post')){
			if($this->data['report-writer']){
				if(($this->data['report-writer']['from_email_address']) && ($this->data['report-writer']['email_subject']) && ($this->data['report-writer']['myelement'])){
					$data = $this->data['report-writer'];
					$saveTemplate = $this->SbsEmailTemplateDetail->saveTemplate($this->subscriber,$data);
					if($saveTemplate){
						$this->Session->setFlash(__('<div class="alert alert-block alert-success">Email template updated.</div>'));
						return $this->redirect(array('action' => 'index'));
					}
				}elseif(!$this->data['report-writer']['from_email_address']){
					$this->Session->setFlash('<div class="alert alert-danger">From email address missing.</div>');
				}elseif(!$this->data['report-writer']['subject']){
					$this->Session->setFlash('<div class="alert alert-danger">Subject missing.</div>');
				}elseif(!$this->data['report-writer']['myelement']){
					$this->Session->setFlash('<div class="alert alert-danger">Content for the mail missing.</div>');
			}
			}elseif(!$this->data['report-writer']['from_email_address']){
				$this->Session->setFlash('<div class="alert alert-danger">From email address missing.</div>');
			}elseif(!$this->data['report-writer']['subject']){
				$this->Session->setFlash('<div class="alert alert-danger">Subject missing.</div>');
			}elseif(!$this->data['report-writer']['myelement']){
				$this->Session->setFlash('<div class="alert alert-danger">Content for the mail missing.</div>');
			}
			
		}
		$countTemplate = $this->SbsEmailTemplateDetail->getTemplateCount($this->subscriber);
		$subscriberInformation = $this->User->find('first',array('conditions'=>array('User.sbs_subscriber_id'=>$this->subscriber),'fields'=>array('User.email')));
		$organizationMail = $subscriberInformation['User']['email'];
		if($id){
			$getEmailTemplateDetail = $this->SbsEmailTemplateDetail->getTemplateDetail($id);
			$templateName = $getEmailTemplateDetail['SbsEmailTemplateDetail']['template_name'];
			$myelement = '<pre>'.$getEmailTemplateDetail['SbsEmailTemplateDetail']['body_content'].'</pre>';
			$subject = $getEmailTemplateDetail['SbsEmailTemplateDetail']['subject'];
			if($getEmailTemplateDetail['SbsEmailTemplateDetail']['include_letter_header'] == "Yes"){
				$report_header = 1;
			}else{
				$report_header = 0;
			}
			switch($getEmailTemplateDetail['SbsEmailTemplateDetail']['module_related']){
				case "Invoice" 				: 
												$leftWing 	= array('Balance','Balance Due','Invoice Date','Invoice No','PO Number','Invoice Description');
												$rightWing 	= array('Organization Name','Organization Website','Business Phone','Business Fax','Primary Contact Name','Primary Contact Surname');
												break;
				case "Quotation" 			: 	$leftWing 	= array('Quote No','Issue Date','Expiry Date','Reference No','Quote Amount','Quote Description','PO Number');
												$rightWing 	= array('Organization Name','Organization Website','Business Phone','Business Fax','Primary Contact Name','Primary Contact Surname');
												break;
				case "Payment"	 			:	$leftWing 	= array('Invoice No','Payment Date','Receipt Amount','Payment Reference','Balance','Balance Due','Invoice Date','PO Number','Invoice Description');
												$rightWing 	= array('Organization Name','Organization Website','Business Phone','Business Fax','Primary Contact Name','Primary Contact Surname');
												break;
				case "Payment Reminder"		:	$leftWing 	= array('Balance','Balance Due','Invoice Date','Invoice No','PO Number','Invoice Description');
												$rightWing 	= array('Organization Name','Organization Website','Business Phone','Business Fax','Primary Contact Name','Primary Contact Surname');
												break;
				case "Customer" 			: 
												break;
				case "Credit" 				:	$leftWing 	= array('Credit Number','Credit Amount','Balance');
												$rightWing 	= array('Organization Name','Organization Website','Business Phone','Business Fax','Primary Contact Name','Primary Contact Surname');
												break;
					
			}
			
		}
		$this->set(compact('organizationMail','report_header','subject','myelement','templateName','id','leftWing','rightWing'));
		if(($countTemplate == 6) && !$id){
			$this->Session->setFlash('<div class="alert alert-danger">You cannot add any more templates.</div>');
			return $this->redirect(array('action' => 'index'));
		}
			
		
		
		
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$permission = $this->permission;
		if($this->permission['_update'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->set(compact('permission'));
		$settingsActive = 'active';
		$menuActive = 'Email Configuration';
		$this->set(compact('settingsActive','menuActive'));
		if (!$this->SbsEmailTemplateDetail->exists($id)) {
			throw new NotFoundException(__('Invalid sbs email template detail'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SbsEmailTemplateDetail->save($this->request->data)) {
				$this->Session->setFlash(__('The sbs email template detail has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sbs email template detail could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SbsEmailTemplateDetail.' . $this->SbsEmailTemplateDetail->primaryKey => $id));
			$this->request->data = $this->SbsEmailTemplateDetail->find('first', $options);
		}
		
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->SbsEmailTemplateDetail->id = $id;
		if (!$this->SbsEmailTemplateDetail->exists()) {
			throw new NotFoundException(__('Invalid sbs email template detail'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->SbsEmailTemplateDetail->delete()) {
			$this->Session->setFlash(__('The sbs email template detail has been deleted.'));
		} else {
			$this->Session->setFlash(__('The sbs email template detail could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
