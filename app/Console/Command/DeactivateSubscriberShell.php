<?php
	App::uses('CakeEmail', 'Network/Email');
	class DeactivateSubscriberShell extends AppShell {
		var $uses = array('SbsSubscriber','CpnSubscriptionPlan','User');
		
		public $components = array('RequestHandler','Session','Email');
		public $Controller;
		public function main() {
			$today = strtotime(date('Y-m-d'));
			$lastday = strtotime(date('Y-m-t'));
			if($today == $lastday) {
				$this->deactivate();
			}
		}
		
		public function deactivate() {
			$plan = $this->CpnSubscriptionPlan->find('list',array('conditions'=>array('NOT'=>array('type'=>'Free'))));
			$subscribers = $this->SbsSubscriber->find('all',array('conditions'=>array('SbsSubscriber.cpn_subscription_plan_id'=>$plan,'NOT'=>array('SbsSubscriber.status'=>array('Active','Pending')))));
			foreach ($subscribers as $subscriber) {
				$this->User->updateAll(array('User.active' => "'N'"),array('User.sbs_subscriber_id' => $subscriber['SbsSubscriber']['id']));
			}
		}
	}
?>