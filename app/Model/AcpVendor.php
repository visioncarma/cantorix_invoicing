<?php 
App::uses('AppModel','Model');
Class AcpVendor extends AppModel {
	public $belongsTo = array(
		'SbsSubscriber' => array(
			'className' => 'SbsSubscriber',
			'foreignKey' => 'sbs_subscriber_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function getVendorNames ($term = null) {
      if(!empty($term)) {
      	$session = new SessionComponent();
        $vendors = $this->find('list', array(
       		'fields' =>array('id','vendor_name'),
          'conditions' => array(
            'vendor_name LIKE' => '%'.trim($term) .'%','sbs_subscriber_id'=>$session->read('Auth.User.sbs_subscriber_id')
          )
        ));
        return $vendors;
      } else{
      	return false;
      }
      
    }
	
	public function getIDbyName($value = NULL) {
		$session = new SessionComponent();
		$exist = $this->find('first',array('fields'=>array('id'),'conditions'=>array('sbs_subscriber_id'=>$session->read('Auth.User.sbs_subscriber_id'),'vendor_name LIKE'=>$value)));
		if(!empty($exist)) {
			return $exist['AcpVendor']['id'];
		} else {
			$save['AcpVendor']['sbs_subscriber_id'] 	= $session->read('Auth.User.sbs_subscriber_id');
			$save['AcpVendor']['vendor_name']			= $value;
			$this->create();
			if($this->save($save)) {
				return $this->getLastInsertID();
			} else {
				return FALSE;
			}
		}
	}
	
}
?>