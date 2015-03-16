<?php
	App::uses('CakeEmail', 'Network/Email');
	class FreeSubscriptionAccDeletionShell extends AppShell {
		var $uses = array('SbsSubscriber','CpnSubscriptionPlan','Aro','User');
		
		public $components = array('RequestHandler','Session','Email');
		public $Controller;
 
		public function main() {
			$this->freeSubscriberCheck();
		}
		
		public function freeSubscriberCheck() {
			Configure::write('debug',2);
			App::uses('CakeEmail', 'Network/Email');
			$Email = new CakeEmail();
			$this->loadModel('SbsUpgradeNotification');
			$freePlan = $this->CpnSubscriptionPlan->find('first',array('conditions'=>array('type'=>'Free')));
			$freeSubscribers = $this->SbsSubscriber->find('all',array('conditions'=>array('SbsSubscriber.cpn_subscription_plan_id'=>$freePlan['CpnSubscriptionPlan']['id'])));
			debug($freeSubscribers);
			foreach ($freeSubscribers as $subscriber) {
				$days = 0;$daysOver = null;
				$today = strtotime(date('Y-m-d'));
			    $subscribed_date = strtotime($subscriber['SbsSubscriber']['subscribed_date']);
			   	$daysOver = $today - $subscribed_date;
				$days = floor($daysOver/(60*60*24));
				$this->Aro->recursive = -1;
				$adminUserGroup = $this->Aro->find('first',array('conditions'=>array('Aro.sbs_subscriber_id'=>$subscriber['SbsSubscriber']['id'],'Aro.alias'=>'Admin'),'order'=>array('Aro.id'=>'ASC')));
				$adminUser = $this->Aro->find('first',array('conditions'=>array('Aro.parent_id'=>$adminUserGroup['Aro']['id']),'order'=>array('Aro.id'=>'ASC')));
				$UserDetails = $this->User->findById($adminUser['Aro']['foreign_key']);
				$explodededed = explode(' ', $_SERVER['SSH_CONNECTION']);
				$hostname = gethostbyaddr($explodededed[2]);
				if($days == ($freePlan['CpnSubscriptionPlan']['validity'] - 5)) {
					debug('1');
					$Email->template('inactive_notification1');
					$Email->emailFormat('html');
					$Email->from(array('admin@cantorix.com' => 'CantoriX Accounting System'));
					$Email->to($UserDetails['User']['email']);
					$Email->cc(array('ganesh@carmatec.com','venugopal@carmatec.com'));
					$Email->subject('CantoriX subscription upgradation');
					$Email->send();
				}
				if($days == ($freePlan['CpnSubscriptionPlan']['validity'] + 30)) {
					debug('1');
					$Email->template('inactive_notification2');
					$Email->emailFormat('html');
					$Email->from(array('admin@cantorix.com' => 'CantoriX Accounting System'));
					$Email->to($UserDetails['User']['email']);
					$Email->cc(array('ganesh@carmatec.com','venugopal@carmatec.com'));
					$Email->subject('CantoriX subscription upgradation');
					$Email->send();
				}
				if($days == ($freePlan['CpnSubscriptionPlan']['validity'] + 55)) {
					$Email->template('inactive_notification3');
					$Email->emailFormat('html');
					$Email->from(array('admin@cantorix.com' => 'CantoriX Accounting System'));
					$Email->to($UserDetails['User']['email']);
					$Email->cc(array('ganesh@carmatec.com','venugopal@carmatec.com'));
					$Email->subject('CantoriX subscription upgradation');
					$Email->send();
				}
				if($days > ($freePlan['CpnSubscriptionPlan']['validity'] + 60)) {
					debug($UserDetails['User']['email'].' Delete Account');
					 $this->requestAction(array('controller'=>'pages','action'=>'deleteSubscriber',$subscriber['SbsSubscriber']['id']));
				}
			}
		}		
	}
?>