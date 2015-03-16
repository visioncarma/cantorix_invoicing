<?php
	Class PaidSubscriberAccDeleteShell extends AppShell {
		var $uses = array('SbsSubscriber','CpnSubscriptionPlan','User');
		public function main() {
			$this->deleteSubscriber();
		}
		public function deleteSubscriber() {
			$plan = $this->CpnSubscriptionPlan->find('list',array('conditions'=>array('NOT'=>array('type'=>'Free'))));
			$subscribers = $this->SbsSubscriber->find('all',array('conditions'=>array('SbsSubscriber.cpn_subscription_plan_id'=>$plan,'SbsSubscriber.status'=>array('Cancelled','Suspended'))));
			foreach ($subscribers as $subscriber) {
				if($subscriber['SbsSubscriber']['updation'] != '0000-00-00') {
					$today = strtotime(date('Y-m-d'));
					$updatedDate = strtotime($subscriber['SbsSubscriber']['updation']);
					$endDayOfDate = date("Y-m-t", strtotime($subscriber['SbsSubscriber']['updation']));
					$deactivationDate = strtotime($endDayOfDate);
					$daysCompleted = $today - $deactivationDate;
					$days = floor($daysCompleted/(60*60*24));
					$currentPlan =  $this->CpnSubscriptionPlan->find('first',array('conditions'=>array('CpnSubscriptionPlan.id'=>$subscriber['SbsSubscriber']['cpn_subscription_plan_id'])));
					if($days >= $currentPlan['CpnSubscriptionPlan']['deletion_days']) {
						//$this->requestAction(array('controller'=>'pages','action'=>'deleteArchivedSubscriber',$subscriber['SbsSubscriber']['id']));
					}
				}
			}
		}
	}
?>