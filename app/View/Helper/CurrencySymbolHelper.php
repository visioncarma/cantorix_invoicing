<?php
App::uses('AppHelper', 'View/Helper');
class CurrencySymbolHelper extends AppHelper {
	public $helpers = array('Number');
	public function getAllCurrencies() {
		//$this->Number->addFormat('INR', array('zero'=>'&#x20b9;0.00','before' => '&#x20b9;', 'thousands' => ',', 'decimals' => '.','escape'=>FALSE));
		//$this->Number->addFormat('JYP', array('zero'=>'&#xa5;0.00','before' => '&#xa5;', 'thousands' => ',', 'decimals' => '.','escape'=>FALSE));
	}
}
?>
