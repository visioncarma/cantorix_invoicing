<?php
App::uses('AppModel', 'Model');
/**
 * CpnSetting Model
 *
 */
class CpnSetting extends AppModel {
	
	public function getAllSettings () {				
		$cpnSettings = $this->find('first');		
		return $cpnSettings; 
	}
	
}
