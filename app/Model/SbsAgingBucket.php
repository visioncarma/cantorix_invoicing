<?php
App::uses('AppModel', 'Model');
/**
 * SbsAgingBucket Model
 *
 * @property SbsAgingBucket $SbsAgingBucket
 */
class SbsAgingBucket extends AppModel {
		
		
		public function getBucketsForSubscriber($subscriberId,$conditions){
			if($subscriberId && $conditions){
				$buckets = $this->find('all',array('conditions'=>$conditions));
				if($buckets){
					return $buckets;
				}else{
					return false;
				}
			}
		}
}		
	