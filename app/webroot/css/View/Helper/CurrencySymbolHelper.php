<?php
App::uses('AppHelper', 'View/Helper');
class CurrencySymbolHelper extends AppHelper {
	public $helpers = array('Number');
	public function getAllCurrencies() {
		$this->Number->addFormat('INR', array('before' => '&#8377;', 'thousands' => ',', 'decimals' => '.','escape'=>FALSE,'fractionSymbol'=>'Paise'));
		$this->Number->addFormat('JYP', array('before' => '&#xa5;', 'thousands' => ',', 'decimals' => '.','escape'=>FALSE));
	}
}
?>
