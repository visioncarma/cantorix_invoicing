<?php
	App::uses('CakeEmail', 'Network/Email');
	class FreeSubscriptionAccountDeletionShell extends AppShell {
		var $uses = array('SbsSubscriber','CpnSubscriptionPlan','Aro','User','ServerDetail');
		
		public $components = array('RequestHandler','Session','Email');
		public $Controller;
 
		public function main() {
		    Configure::write('debug',2);
            $this->freeSubscriberCheck();
		}
		
		public function freeSubscriberCheck() {
			App::uses('CakeEmail', 'Network/Email');
			$Email = new CakeEmail(); 
            $serverdetails = $this->ServerDetail->getServerDetail();
            debug($serverdetails); 
			$freePlan = $this->CpnSubscriptionPlan->find('first',array('conditions'=>array('type'=>'Free')));
			$freeSubscribers = $this->SbsSubscriber->find('all',array('conditions'=>array('SbsSubscriber.cpn_subscription_plan_id'=>$freePlan['CpnSubscriptionPlan']['id'])));
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
                if($days == ($freePlan['CpnSubscriptionPlan']['validity'] - 5)) {
				    $Email->viewVars(array('http_hostname' => $serverdetails['ServerDetail']['server_name'],'webroot_name' => $serverdetails['ServerDetail']['app_folder_name']));
					$Email->template('inactive_notification1');
					$Email->emailFormat('html');
					$Email->from(array('admin@cantorix.com' => 'CantoriX Invoicing'));
					$Email->to($UserDetails['User']['email']);
					$Email->subject('CantoriX subscription upgradation');
					$Email->send();
				}
                if($days == $freePlan['CpnSubscriptionPlan']['validity']) {
                    $Email->viewVars(array('http_hostname' => $serverdetails['ServerDetail']['server_name'],'webroot_name' => $serverdetails['ServerDetail']['app_folder_name']));
                    $Email->template('deactivate_subscription');
                    $Email->emailFormat('html');
                    $Email->from(array('admin@cantorix.com' => 'CantoriX Invoicing'));
                    $Email->to($UserDetails['User']['email']);
                    $Email->subject('CantoriX subscription deactivation');
                    $Email->send();
                }
				if($days == ($freePlan['CpnSubscriptionPlan']['validity'] + 30)) {
				    $Email->viewVars(array('http_hostname' => $serverdetails['ServerDetail']['server_name'],'webroot_name' => $serverdetails['ServerDetail']['app_folder_name']));
					$Email->template('inactive_notification2');
					$Email->emailFormat('html');
					$Email->from(array('admin@cantorix.com' => 'CantoriX Invoicing'));
					$Email->to($UserDetails['User']['email']);
					$Email->subject('CantoriX subscription is queued for Deletion');
					$Email->send();
				}
				if($days == ($freePlan['CpnSubscriptionPlan']['validity'] + 55)) {
				    $Email->viewVars(array('http_hostname' => $serverdetails['ServerDetail']['server_name'],'webroot' => $serverdetails['ServerDetail']['app_folder_name']));
					$Email->template('inactive_notification3');
					$Email->emailFormat('html');
					$Email->from(array('admin@cantorix.com' => 'CantoriX Invoicing'));
					$Email->to($UserDetails['User']['email']);
					$Email->subject('CantoriX subscription is queued for Deletion');
					$Email->send();
				}
				if($days >= ($freePlan['CpnSubscriptionPlan']['validity'] + 60)) {
					 $this->requestAction(array('controller'=>'pages','action'=>'deleteSubscriber',$subscriber['SbsSubscriber']['id']));
				}
			}
		}		
	}
?>