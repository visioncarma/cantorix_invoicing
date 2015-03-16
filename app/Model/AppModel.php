<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');
App::import('Component', 'SessionComponent');
/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	public $recursive = -1;
	
	/**
	 * @author Ganesh
	 * @method Identifies whether given id blongsTo same subscriber or not
	 * @since 23 Sep 2014
	 * @param id
	 * */
	public function _checkFraud($id = NULL) {
		$session = new SessionComponent();
		$loadedModel = Classregistry::init($this->alias);
		$ifExist = $loadedModel->find('first',array('fields'=>array($this->alias.'.id'),'conditions'=>array($this->alias.'.id'=>$id,$this->alias.'.sbs_subscriber_id'=>$session->read('Auth.User.sbs_subscriber_id'))));
		if(!empty($ifExist)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
