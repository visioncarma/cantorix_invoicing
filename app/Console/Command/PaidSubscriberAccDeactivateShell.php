<?php
	App::uses('CakeEmail', 'Network/Email');
	class PaidSubscriberAccDeactivateShell extends AppShell {
		var $uses = array('SbsSubscriber','CpnSubscriptionPlan','User','ServerDetail');
		
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
            $Email = new CakeEmail();
            $plan = $this->CpnSubscriptionPlan->find('list',array('conditions'=>array('NOT'=>array('type'=>'Free'))));
			$subscribers = $this->SbsSubscriber->find('all',array('conditions'=>array('SbsSubscriber.cpn_subscription_plan_id'=>$plan,'SbsSubscriber.status'=>'Cancelled')));
            debug($subscribers);
		    $serverdetails = $this->ServerDetail->getServerDetail();
			foreach ($subscribers as $subscriber) {
			    if(!empty($subscriber['SbsSubscriber']['id'])) {
			        /*$usersOfSubscriber = $this->User->find('all',array('conditions'=>array('User.sbs_subscriber_id' => $subscriber['SbsSubscriber']['id'],'User.user_type'=>'Subscriber')));
                    foreach ($usersOfSubscriber as $UserToInactive) {
                        if(!empty($UserToInactive)) {
                            $userUpdateDetail['User']['id'] = $UserToInactive['User']['id'];
                            $userUpdateDetail['User']['active'] = 'N';
                            $this->User->save($userUpdateDetail);
                        }
                    }*/
			        //$this->User->updateAll(array('User.active' => "'N'"),array('User.sbs_subscriber_id' => $subscriber['SbsSubscriber']['id'],'User.user_type'=>'Subscriber'));
			    }
                $Email->viewVars(array('http_hostname' => $serverdetails['ServerDetail']['server_name'],'webroot_name' => $serverdetails['ServerDetail']['app_folder_name']));
                $UserDetails = $this->User->find('first', array('conditions' => array('User.sbs_subscriber_id' => $subscriber['SbsSubscriber']['id']), 'order' => array('User.id'=>'Asc')));
			    $Email->template('paid_subscriber_deactivation');
                $Email->emailFormat('html');
                $Email->from(array('admin@cantorix.com' => 'CantoriX Invoicing'));
                $Email->to($UserDetails['User']['email']);
                $Email->subject('CantoriX Subscription deactivation');
                $Email->send();
			}
		}
	}
?>