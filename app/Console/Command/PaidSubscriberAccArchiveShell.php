<?php
	App::uses('CakeEmail', 'Network/Email');
	class PaidSubscriberAccArchiveShell extends AppShell {
		public $components = array('RequestHandler','Session','Email');
		public function main() {
			Configure::write('debug',2);
			App::uses('CakeEmail', 'Network/Email');
			$this->loadModel('CpnSubscriberInvoiceDetail');
            $this->loadModel('CpnSubscriptionPlan');
            $this->loadModel('SbsSubscriber');
			$plan = $this->CpnSubscriptionPlan->find('list',array('conditions'=>array('NOT'=>array('type'=>'Free'))));
			$subscribers = $this->SbsSubscriber->find('all',array('conditions'=>array('SbsSubscriber.cpn_subscription_plan_id'=>$plan,'SbsSubscriber.status'=>array('Cancelled','Suspended'))));
            foreach ($subscribers as $subscriber) {
                debug($subscriber);
				if($subscriber['SbsSubscriber']['updation'] != '0000-00-00') {
					$today = strtotime(date('Y-m-d'));
					if($subscriber['SbsSubscriber']['status'] == 'Suspended') {
					    $updatedDate = $subscriber['SbsSubscriber']['updation'];
					} elseif($subscriber['SbsSubscriber']['status'] == 'Cancelled') {
					    $updatedDate = date("Y-m-t", strtotime($subscriber['SbsSubscriber']['updation']));
					}
                    debug($updatedDate);
					$deactivationDate = strtotime($updatedDate);
                    $daysCompleted = $today - $deactivationDate;
					$days = floor($daysCompleted/(60*60*24));
					$currentPlan =  $this->CpnSubscriptionPlan->find('first',array('conditions'=>array('CpnSubscriptionPlan.id'=>$subscriber['SbsSubscriber']['cpn_subscription_plan_id'])));
                    debug($days);
                    debug($currentPlan['CpnSubscriptionPlan']['archieve_days']);
					if($days > $currentPlan['CpnSubscriptionPlan']['archieve_days']) {
						$this->requestAction(array('controller'=>'pages','action'=>'archiveSubscriber',$subscriber['SbsSubscriber']['id']));
					}
				}
			}
		}
	}
?>