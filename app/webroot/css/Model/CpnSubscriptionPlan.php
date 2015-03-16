<?php
App::uses('AppModel', 'Model');
/**
 * CpnSubscriptionPlan Model
 *
 * @property SbsSubscriber $SbsSubscriber
 */
class CpnSubscriptionPlan extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'SbsSubscriber' => array(
			'className' => 'SbsSubscriber',
			'foreignKey' => 'cpn_subscription_plan_id',
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
	
/**
 * Validation
 * 
 * @Saurabh-May 23 2014
 * validation rule for Subscription Plan
 * */
 /* public $validate = array(
  		'type' => array(
            'rule1' => array('rule' => array('notEmpty'),
                'message' => 'Plan type is mandatory'
            ),
        ),
         'validity' => array(
        	'rule1' =>array('rule'=>array('notEmpty'),
        		'message' => 'Validity is required'),
        	'rule2' => array('rule'=> array('numeric'),
        		'message' => 'Please enter the numeric value'
        	)
        ),
		'no_of_staffs' => array(
            'rule1' => array('rule' => array('notEmpty'),
                'message' => 'Enter number of staffs allowed'
            ),
            'rule2' => array('rule'=> array('numeric'),
        		'message' => 'Please enter the numeric value'
        	)
        ),
		'no_of_clients' => array(
            'rule1' => array('rule' => array('notEmpty'),
                'message' => 'Enter number of clients'
            ),
            'rule2' => array('rule'=> array('numeric'),
        		'message' => 'Please enter the numeric value'
        	)
        ),
        'no_of_invoices' => array( 
            'rule1' => array('rule' => array('notEmpty'),
                'message' => 'Enter number of invoices'
            ),
            'rule2' => array('rule'=> array('numeric'),
        		'message' => 'Please enter the numeric value'
        	)
        ),
		 'cost' => array(
            'rule1' => array('rule' => array('decimal',2),
                'message' => 'Enter Cost for the plan'
            ),
            'rule2' => array('rule'=> array('numeric'),
        		'message' => 'Please enter the numeric value'
        	),
        	'rule3' => array('rule'=> array('money', 'left'),
        		'message' => 'Please supply a valid monetary amount.'
        	)
        	
        ),
        'deletion_days' => array(
            'rule1' => array('rule' => array('numeric'),
            	'required'   => true,
                'message' => 'Please enter the numeric value'
            ),
        ),
        'archieve_days' => array(
            'rule1' => array('rule' => array('numeric'),
            	'required'   => true,
                'message' => 'Please enter the numeric value'
            ),
        )
 );*/

 	public function getAllSubscriptions () {				
		$subscriptions = $this->find('all');		
		return $subscriptions; 
	}

 	public function getSubscriptionNameById ($id) {	
		return $this->findById($id); 
	}
	
	public function getSubscriptionByType ($type) {
				
		$subscriptionDetail = $this->find('first', array (
			'conditions' => array (
				'CpnSubscriptionPlan.type' => trim($type)
			)
		));	
		return $subscriptionDetail; 
	}
	
	public function getSubscriptionPlanList() {
		return $this->find('list',array('fields'=>array('id','type')));
	}
	
/**
 * @Author Ganesh
 * @Since 20 Aug 2014
 * @Version v.1
 * @Method get Plan details for Subscriber Dashboard
 * **/
 	public function getPlanDetails($id) {
 		return $this->findById($id,array('type','no_of_staffs','no_of_clients','no_of_invoices'));
 	}
}
