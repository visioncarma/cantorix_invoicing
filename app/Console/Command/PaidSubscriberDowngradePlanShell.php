<?php
    App::uses('CakeEmail', 'Network/Email');
    Class PaidSubscriberDowngradePlanShell extends AppShell {
        var $uses = array('SbsDowngradeRequest','SbsSubscriber','CpnSubscriptionPlan','User','ServerDetail');
        
        public function main() {
           // Configure::write('debug',2);
            $today = strtotime(date('Y-m-d'));
            $lastday = strtotime(date('Y-m-t'));
            debug(strtotime(date('Y-m-t')));
            debug(strtotime('2015-01-31'));
            if($today == $lastday) {
                $this->downgradePlan();
            }
        }
        
        public function downgradePlan() {
            $Email = new CakeEmail();
            $changeRequests = $this->SbsDowngradeRequest->find('all',array('conditions' => array('SbsDowngradeRequest.status'=>'Active')));
            $serverdetails = $this->ServerDetail->getServerDetail();
            debug($serverdetails); 
            foreach ($changeRequests as $changeRequestDetail) {
                $planUpdated = $this->SbsSubscriber->save(array('id'=>$changeRequestDetail['SbsDowngradeRequest']['sbs_subscriber_id'],'cpn_subscription_plan_id'=>$changeRequestDetail['SbsDowngradeRequest']['cpn_subscription_plan_id']));
                if($planUpdated) {
                    $planDetails = $this->CpnSubscriptionPlan->find('first',array('conditions'=>array('id'=>$changeRequestDetail['SbsDowngradeRequest']['cpn_subscription_plan_id'])));
                    $UserDetails = $this->User->find('first', array('conditions' => array('User.sbs_subscriber_id' => $changeRequestDetail['SbsDowngradeRequest']['sbs_subscriber_id']), 'order' => array('User.id'=>'Asc')));
                    $this->SbsDowngradeRequest->save(array('id'=>$changeRequestDetail['SbsDowngradeRequest']['id'],'status'=>'Inactive'));
                    $Email->viewVars(array('plan' => $planDetails['CpnSubscriptionPlan']['type'],'http_hostname' => $serverdetails['ServerDetail']['server_name'],'webroot_name' => $serverdetails['ServerDetail']['app_folder_name']));
                    $Email->template('paid_subscriber_downgrade');
                    $Email->emailFormat('html');
                    $Email->from(array('admin@cantorix.com' => 'CantoriX Invoicing'));
                    $Email->to($UserDetails['User']['email']);
                    $Email->subject('CantoriX Subscription notification');
                    $Email->send(); 
                }
            }
        }
    }
?>