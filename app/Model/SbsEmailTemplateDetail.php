<?php
App::uses('AppModel', 'Model');
/**
 * SbsEmailTemplateDetail Model
 *
 * @property SbsSubscriber $SbsSubscriber
 */
class SbsEmailTemplateDetail extends AppModel {


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
	
	public function saveTemplate($subscriberId,$data){
		if($data && $subscriberId){
			$saveArray->data = null;
			if($data['templateId']){
				$saveArray->data['SbsEmailTemplateDetail']['id']				=	$data['templateId'];
			}else{
				$this->create();
			}
			$saveArray->data['SbsEmailTemplateDetail']['template_name'] 		= $data['email_template_name'];
			$saveArray->data['SbsEmailTemplateDetail']['from_email_address'] 	= $data['from_email_address'];
			$saveArray->data['SbsEmailTemplateDetail']['subject'] 				= $data['email_subject'];
			$saveArray->data['SbsEmailTemplateDetail']['body_content'] 			= $data['myelement'];
			//$saveArray->data['SbsEmailTemplateDetail']['module_related'] 		= "Quotation";
			if(($data['email_subject']) && ($data['myelement'])){
				$saveArray->data['SbsEmailTemplateDetail']['status'] 			= 'Configured';
			}else{
				$saveArray->data['SbsEmailTemplateDetail']['status'] 			= 'Not Configured';
			}
			
			if($data['include']['report_header'] == '1'){
				$saveArray->data['SbsEmailTemplateDetail']['include_letter_header'] = 'Yes';
			}else{
				$saveArray->data['SbsEmailTemplateDetail']['include_letter_header'] = 'No';
			}
			$saveArray->data['SbsEmailTemplateDetail']['sbs_subscriber_id'] 	= $subscriberId;
			if($this->save($saveArray->data)){
				if($data['templateId']){
					return $data['templateId'];
				}else{
					return $this->getLastInsertID();
				}
			}else{
				return false;
			}
		}
	}

	public function getTemplateDetail($emailTemplateId = null){
		if($emailTemplateId){
			$getTemplateDetail = $this->find('first',array('conditions'=>array('SbsEmailTemplateDetail.id'=>$emailTemplateId)));
			if($getTemplateDetail){
				return $getTemplateDetail;
			}else{
				return false;
			}
		}
	}
	
	public function getTemplateCount($subscriberId){
		if($subscriberId){
			$getTemplateDetail = $this->find('count',array('conditions'=>array('SbsEmailTemplateDetail.sbs_subscriber_id'=>$subscriberId)));
			if($getTemplateDetail){
				return $getTemplateDetail;
			}else{
				return false;
			}
		}
	}

	public function addTemplate($subscriberId,$tmplData){
		if($tmplData && $subscriberId){
			$saveArray->data = null;		
			$this->create();			
			$saveArray->data['SbsEmailTemplateDetail']['template_name'] 		= $tmplData['email_template_name'];
			$saveArray->data['SbsEmailTemplateDetail']['from_email_address'] 	= $tmplData['from_email_address'];
			$saveArray->data['SbsEmailTemplateDetail']['subject'] 				= $tmplData['email_subject'];			
			$saveArray->data['SbsEmailTemplateDetail']['module_related'] 		= $tmplData['module_related'];		
			$saveArray->data['SbsEmailTemplateDetail']['sbs_subscriber_id'] 	= $subscriberId;
			if($this->save($saveArray->data)){				
				return $this->getLastInsertID();				
			}else{
				return false;
			}
		}
	}


}
