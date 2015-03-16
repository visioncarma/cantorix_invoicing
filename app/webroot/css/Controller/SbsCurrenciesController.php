<?php
App::uses('AppController', 'Controller');

/**
 * SbsCurrencies Controller
 *
 * @property SbsCurrency $SbsCurrency
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SbsCurrenciesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');
	
	
	
	
	/**
	 * Below actions are related to maxmind location and currency pull based on Ip.
	 * Methods for currency conversion is also included.
	 */
	
	//the geoPlugin server
	var $host = 'http://www.geoplugin.net/php.gp?ip={IP}&base_currency={CURRENCY}';
		
	//the default base currency
	var $currency = 'USD';
	
	//initiate the geoPlugin vars
	var $ip = null;
	var $city = null;
	var $region = null;
	var $areaCode = null;
	var $dmaCode = null;
	var $countryCode = null;
	var $countryName = null;
	var $continentCode = null;
	var $latitude = null;
	var $longitude = null;
	var $currencyCode = null;
	var $currencySymbol = null;
	var $currencyConverter = null;

	function locate($ip = null) {
		global $_SERVER;
		if ( is_null( $ip ) ) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$host = str_replace( '{IP}', $ip, $this->host );
		$host = str_replace( '{CURRENCY}', $this->currency, $host );
		$data = array();
		$response = $this->fetch($host);
		$data = unserialize($response);
		return $data;
	}
	
	function fetch($host) {

		if ( function_exists('curl_init') ) {
						
			//use cURL to fetch data
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $host);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, 'geoPlugin PHP Class v1.0');
			$response = curl_exec($ch);
			curl_close ($ch);
			
		} else if ( ini_get('allow_url_fopen') ) {
			
			//fall back to fopen()
			$response = file_get_contents($host, 'r');
			
		} else {

			trigger_error ('geoPlugin class Error: Cannot retrieve data. Either compile PHP with cURL support or enable allow_url_fopen in php.ini ', E_USER_ERROR);
			return;
		
		}
		
		return $response;
	}
	
	function convert($amount, $float=2, $symbol=true) {
		
		//easily convert amounts to geolocated currency.
		if ( !is_numeric($this->currencyConverter) || $this->currencyConverter == 0 ) {
			trigger_error('geoPlugin class Notice: currencyConverter has no value.', E_USER_NOTICE);
			return $amount;
		}
		if ( !is_numeric($amount) ) {
			trigger_error ('geoPlugin class Warning: The amount passed to geoPlugin::convert is not numeric.', E_USER_WARNING);
			return $amount;
		}
		if ( $symbol === true ) {
			return $this->currencySymbol . round( ($amount * $this->currencyConverter), $float );
		} else {
			return round( ($amount * $this->currencyConverter), $float );
		}
	}
	function nearby($radius=10, $limit=null) {

		if ( !is_numeric($this->latitude) || !is_numeric($this->longitude) ) {
			trigger_error ('geoPlugin class Warning: Incorrect latitude or longitude values.', E_USER_NOTICE);
			return array( array() );
		}
		
		$host = "http://www.geoplugin.net/extras/nearby.gp?lat=" . $this->latitude . "&long=" . $this->longitude . "&radius={$radius}";
		
		if ( is_numeric($limit) )
			$host .= "&limit={$limit}";
			
		return unserialize( $this->fetch($host) );

	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->SbsCurrency->recursive = 0;
		$this->set('sbsCurrencies', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SbsCurrency->exists($id)) {
			throw new NotFoundException(__('Invalid sbs currency'));
		}
		$options = array('conditions' => array('SbsCurrency.' . $this->SbsCurrency->primaryKey => $id));
		$this->set('sbsCurrency', $this->SbsCurrency->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		configure::write('debug',2);
		if ($this->request->is('post')) {
			$this->SbsCurrency->create();
			if ($this->SbsCurrency->save($this->request->data)) {
				$this->Session->setFlash(__('The sbs currency has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sbs currency could not be saved. Please, try again.'));
			}
		}
		if($_SERVER['SERVER_ADDR']=='192.168.0.164'){
			$ip="182.73.165.90";
		}else{
			//$ip= $_SERVER['REMOTE_ADDR'];
			$ip = CakeRequest::clientIp(true);
		}	
		$locationDetails = $this->locate($ip);
		debug($locationDetails);
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->SbsCurrency->exists($id)) {
			throw new NotFoundException(__('Invalid sbs currency'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SbsCurrency->save($this->request->data)) {
				$this->Session->setFlash(__('The sbs currency has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sbs currency could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SbsCurrency.' . $this->SbsCurrency->primaryKey => $id));
			$this->request->data = $this->SbsCurrency->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->SbsCurrency->id = $id;
		if (!$this->SbsCurrency->exists()) {
			throw new NotFoundException(__('Invalid sbs currency'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->SbsCurrency->delete()) {
			$this->Session->setFlash(__('The sbs currency has been deleted.'));
		} else {
			$this->Session->setFlash(__('The sbs currency could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	/*public function ipCheck(){ 
		configure::write('debug',2);
		if($_SERVER['SERVER_ADDR']=='192.168.0.164'){
			$ip="182.73.165.90";
		}else{
			//$ip= $_SERVER['REMOTE_ADDR'];
			$ip = CakeRequest::clientIp(true);
		}	
		$locationDetails = $this->locate($ip);
		debug($locationDetails);
	}*/
	
}
