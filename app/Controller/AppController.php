<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $helpers = array('Js' => array('Jquery'),'Html','Session','Form','Breadcrumb','Number','CurrencySymbol');
	public $components = array('RequestHandler','Acl','Session','Email','Cookie','Paginator',
		'Auth' => array(
				'authenticate' => array(
            'Form' => array(
                'passwordHasher' => array(
                    'className' => 'Simple',
                    'hashType' => 'sha256'
                )
            )
        ),
		
        'loginAction' => array(
            'controller' => 'users',
            'action' => 'login'
        ),
        'loginRedirect' => array('controller' => 'users',
            'action' => 'dashboard'),
        'authError' => '<div class="col-md-8 col-md-offset-2 clear">
        					<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert">
									<i class="icon-remove"></i>
								</button>
								<strong>
									<i class="icon-remove"></i>												
								</strong>
								You\'re not authorized! Please login!
								<br>
				  			</div>
						</div>
						<div class="space-30"></div>
						<div class="space-30"></div>'
    )
	);
	
	
	/* PAYPAL API  DETAILS As Global Variable */
	var $API_UserName 	= 'fwhuman_api1.cantorix.com';
	var $API_Password 	= 'NB5DTXS3M5TX37PW';
	var $API_Signature      = 'A7WPJk90LOJHG4Lq6rszhLVMmv3qA8skKrmFQHVzvSICGcnTXZRuutT6';
	var $API_Endpoint 	= "https://api-3t.paypal.com/nvp";
    var $version		= '54.0';
	var $environment 	= 'live';
	var $businessEmail      = 'fwhuman@cantorix.com';
	
	// admin email for 'from' attribute in all email tempelate 
	var $EMAIL_FROM 	= 'admin@cantorix.com';
	
	public function isAuthorized($user){
    	return true;
    }
	
	public function beforeFilter() {
		
	}
	
	
	 function countryList () {
		
		$countries  = array(
		    'AF' => 'AFGHANISTAN',
		    'AL' => 'ALBANIA',
		    'DZ' => 'ALGERIA',
		    'AS' => 'AMERICAN SAMOA',
		    'AD' => 'ANDORRA',
		    'AO' => 'ANGOLA',
		    'AI' => 'ANGUILLA',
		    'AQ' => 'ANTARCTICA',
		    'AG' => 'ANTIGUA AND BARBUDA',
		    'AR' => 'ARGENTINA',
		    'AM' => 'ARMENIA',
		    'AW' => 'ARUBA',
		    'AU' => 'AUSTRALIA',
		    'AT' => 'AUSTRIA',
		    'AZ' => 'AZERBAIJAN',
		    'BS' => 'BAHAMAS',
		    'BH' => 'BAHRAIN',
		    'BD' => 'BANGLADESH',
		    'BB' => 'BARBADOS',
		    'BY' => 'BELARUS',
		    'BE' => 'BELGIUM',
		    'BZ' => 'BELIZE',
		    'BJ' => 'BENIN',
		    'BM' => 'BERMUDA',
		    'BT' => 'BHUTAN',
		    'BO' => 'BOLIVIA',
		    'BA' => 'BOSNIA AND HERZEGOVINA',
		    'BW' => 'BOTSWANA',
		    'BV' => 'BOUVET ISLAND',
		    'BR' => 'BRAZIL',
		    'IO' => 'BRITISH INDIAN OCEAN TERRITORY',
		    'BN' => 'BRUNEI DARUSSALAM',
		    'BG' => 'BULGARIA',
		    'BF' => 'BURKINA FASO',
		    'BI' => 'BURUNDI',
		    'KH' => 'CAMBODIA',
		    'CM' => 'CAMEROON',
		    'CA' => 'CANADA',
		    'CV' => 'CAPE VERDE',
		    'KY' => 'CAYMAN ISLANDS',
		    'CF' => 'CENTRAL AFRICAN REPUBLIC',
		    'TD' => 'CHAD',
		    'CL' => 'CHILE',
		    'CN' => 'CHINA',
		    'CX' => 'CHRISTMAS ISLAND',
		    'CC' => 'COCOS (KEELING) ISLANDS',
		    'CO' => 'COLOMBIA',
		    'KM' => 'COMOROS',
		    'CG' => 'CONGO',
		    'CD' => 'CONGO, THE DEMOCRATIC REPUBLIC OF THE',
		    'CK' => 'COOK ISLANDS',
		    'CR' => 'COSTA RICA',
		    'CI' => 'COTE D IVOIRE',
		    'HR' => 'CROATIA',
		    'CU' => 'CUBA',
		    'CY' => 'CYPRUS',
		    'CZ' => 'CZECH REPUBLIC',
		    'DK' => 'DENMARK',
		    'DJ' => 'DJIBOUTI',
		    'DM' => 'DOMINICA',
		    'DO' => 'DOMINICAN REPUBLIC',
		    'TP' => 'EAST TIMOR',
		    'EC' => 'ECUADOR',
		    'EG' => 'EGYPT',
		    'SV' => 'EL SALVADOR',
		    'GQ' => 'EQUATORIAL GUINEA',
		    'ER' => 'ERITREA',
		    'EE' => 'ESTONIA',
		    'ET' => 'ETHIOPIA',
		    'FK' => 'FALKLAND ISLANDS (MALVINAS)',
		    'FO' => 'FAROE ISLANDS',
		    'FJ' => 'FIJI',
		    'FI' => 'FINLAND',
		    'FR' => 'FRANCE',
		    'GF' => 'FRENCH GUIANA',
		    'PF' => 'FRENCH POLYNESIA',
		    'TF' => 'FRENCH SOUTHERN TERRITORIES',
		    'GA' => 'GABON',
		    'GM' => 'GAMBIA',
		    'GE' => 'GEORGIA',
		    'DE' => 'GERMANY',
		    'GH' => 'GHANA',
		    'GI' => 'GIBRALTAR',
		    'GR' => 'GREECE',
		    'GL' => 'GREENLAND',
		    'GD' => 'GRENADA',
		    'GP' => 'GUADELOUPE',
		    'GU' => 'GUAM',
		    'GT' => 'GUATEMALA',
		    'GN' => 'GUINEA',
		    'GW' => 'GUINEA-BISSAU',
		    'GY' => 'GUYANA',
		    'HT' => 'HAITI',
		    'HM' => 'HEARD ISLAND AND MCDONALD ISLANDS',
		    'VA' => 'HOLY SEE (VATICAN CITY STATE)',
		    'HN' => 'HONDURAS',
		    'HK' => 'HONG KONG',
		    'HU' => 'HUNGARY',
		    'IS' => 'ICELAND',
		    'IN' => 'INDIA',
		    'ID' => 'INDONESIA',
		    'IR' => 'IRAN, ISLAMIC REPUBLIC OF',
		    'IQ' => 'IRAQ',
		    'IE' => 'IRELAND',
		    'IL' => 'ISRAEL',
		    'IT' => 'ITALY',
		    'JM' => 'JAMAICA',
		    'JP' => 'JAPAN',
		    'JO' => 'JORDAN',
		    'KZ' => 'KAZAKSTAN',
		    'KE' => 'KENYA',
		    'KI' => 'KIRIBATI',
		    'KP' => 'KOREA DEMOCRATIC PEOPLES REPUBLIC OF',
		    'KR' => 'KOREA REPUBLIC OF',
		    'KW' => 'KUWAIT',
		    'KG' => 'KYRGYZSTAN',
		    'LA' => 'LAO PEOPLES DEMOCRATIC REPUBLIC',
		    'LV' => 'LATVIA',
		    'LB' => 'LEBANON',
		    'LS' => 'LESOTHO',
		    'LR' => 'LIBERIA',
		    'LY' => 'LIBYAN ARAB JAMAHIRIYA',
		    'LI' => 'LIECHTENSTEIN',
		    'LT' => 'LITHUANIA',
		    'LU' => 'LUXEMBOURG',
		    'MO' => 'MACAU',
		    'MK' => 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF',
		    'MG' => 'MADAGASCAR',
		    'MW' => 'MALAWI',
		    'MY' => 'MALAYSIA',
		    'MV' => 'MALDIVES',
		    'ML' => 'MALI',
		    'MT' => 'MALTA',
		    'MH' => 'MARSHALL ISLANDS',
		    'MQ' => 'MARTINIQUE',
		    'MR' => 'MAURITANIA',
		    'MU' => 'MAURITIUS',
		    'YT' => 'MAYOTTE',
		    'MX' => 'MEXICO',
		    'FM' => 'MICRONESIA, FEDERATED STATES OF',
		    'MD' => 'MOLDOVA, REPUBLIC OF',
		    'MC' => 'MONACO',
		    'MN' => 'MONGOLIA',
		    'MS' => 'MONTSERRAT',
		    'MA' => 'MOROCCO',
		    'MZ' => 'MOZAMBIQUE',
		    'MM' => 'MYANMAR',
		    'NA' => 'NAMIBIA',
		    'NR' => 'NAURU',
		    'NP' => 'NEPAL',
		    'NL' => 'NETHERLANDS',
		    'AN' => 'NETHERLANDS ANTILLES',
		    'NC' => 'NEW CALEDONIA',
		    'NZ' => 'NEW ZEALAND',
		    'NI' => 'NICARAGUA',
		    'NE' => 'NIGER',
		    'NG' => 'NIGERIA',
		    'NU' => 'NIUE',
		    'NF' => 'NORFOLK ISLAND',
		    'MP' => 'NORTHERN MARIANA ISLANDS',
		    'NO' => 'NORWAY',
		    'OM' => 'OMAN',
		    'PK' => 'PAKISTAN',
		    'PW' => 'PALAU',
		    'PS' => 'PALESTINIAN TERRITORY, OCCUPIED',
		    'PA' => 'PANAMA',
		    'PG' => 'PAPUA NEW GUINEA',
		    'PY' => 'PARAGUAY',
		    'PE' => 'PERU',
		    'PH' => 'PHILIPPINES',
		    'PN' => 'PITCAIRN',
		    'PL' => 'POLAND',
		    'PT' => 'PORTUGAL',
		    'PR' => 'PUERTO RICO',
		    'QA' => 'QATAR',
		    'RE' => 'REUNION',
		    'RO' => 'ROMANIA',
		    'RU' => 'RUSSIAN FEDERATION',
		    'RW' => 'RWANDA',
		    'SH' => 'SAINT HELENA',
		    'KN' => 'SAINT KITTS AND NEVIS',
		    'LC' => 'SAINT LUCIA',
		    'PM' => 'SAINT PIERRE AND MIQUELON',
		    'VC' => 'SAINT VINCENT AND THE GRENADINES',
		    'WS' => 'SAMOA',
		    'SM' => 'SAN MARINO',
		    'ST' => 'SAO TOME AND PRINCIPE',
		    'SA' => 'SAUDI ARABIA',
		    'SN' => 'SENEGAL',
		    'SC' => 'SEYCHELLES',
		    'SL' => 'SIERRA LEONE',
		    'SG' => 'SINGAPORE',
		    'SK' => 'SLOVAKIA',
		    'SI' => 'SLOVENIA',
		    'SB' => 'SOLOMON ISLANDS',
		    'SO' => 'SOMALIA',
		    'ZA' => 'SOUTH AFRICA',
		    'GS' => 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',
		    'ES' => 'SPAIN',
		    'LK' => 'SRI LANKA',
		    'SD' => 'SUDAN',
		    'SR' => 'SURINAME',
		    'SJ' => 'SVALBARD AND JAN MAYEN',
		    'SZ' => 'SWAZILAND',
		    'SE' => 'SWEDEN',
		    'CH' => 'SWITZERLAND',
		    'SY' => 'SYRIAN ARAB REPUBLIC',
		    'TW' => 'TAIWAN, PROVINCE OF CHINA',
		    'TJ' => 'TAJIKISTAN',
		    'TZ' => 'TANZANIA, UNITED REPUBLIC OF',
		    'TH' => 'THAILAND',
		    'TG' => 'TOGO',
		    'TK' => 'TOKELAU',
		    'TO' => 'TONGA',
		    'TT' => 'TRINIDAD AND TOBAGO',
		    'TN' => 'TUNISIA',
		    'TR' => 'TURKEY',
		    'TM' => 'TURKMENISTAN',
		    'TC' => 'TURKS AND CAICOS ISLANDS',
		    'TV' => 'TUVALU',
		    'UG' => 'UGANDA',
		    'UA' => 'UKRAINE',
		    'AE' => 'UNITED ARAB EMIRATES',
		    'GB' => 'UNITED KINGDOM',
		    'US' => 'UNITED STATES',
		    'UM' => 'UNITED STATES MINOR OUTLYING ISLANDS',
		    'UY' => 'URUGUAY',
		    'UZ' => 'UZBEKISTAN',
		    'VU' => 'VANUATU',
		    'VE' => 'VENEZUELA',
		    'VN' => 'VIET NAM',
		    'VG' => 'VIRGIN ISLANDS, BRITISH',
		    'VI' => 'VIRGIN ISLANDS, U.S.',
		    'WF' => 'WALLIS AND FUTUNA',
		    'EH' => 'WESTERN SAHARA',
		    'YE' => 'YEMEN',
		    'YU' => 'YUGOSLAVIA',
		    'ZM' => 'ZAMBIA',
		    'ZW' => 'ZIMBABWE',
		  );
		  $countries = array_map("strtolower", $countries);
		  $countries = array_map("ucwords", $countries);
		  return $countries;	
	}

    function getCountryNameByCode () {	
		
		
    }
	
	function getAllTimezones () {
	
		$time_zones  = array(
			'Pacific/Midway' => '(UTC-11:00) Midway Island',
		    'Pacific/Samoa' => '(UTC-11:00) Samoa',
		    'Pacific/Honolulu' => '(UTC-10:00) Hawaii',
		    'US/Alaska' => '(UTC-09:00) Alaska',
		    'America/Los_Angeles' => '(UTC-08:00) Pacific Time (US & Canada)',
		    'America/Tijuana' => '(UTC-08:00) Tijuana',
		    'US/Arizona' => '(UTC-07:00) Arizona',
		    'America/Chihuahua' => '(UTC-07:00) La Paz',
		    'America/Mazatlan' => '(UTC-07:00) Mazatlan',
		    'US/Mountain' => '(UTC-07:00) Mountain Time (US & Canada)',
		    'America/Managua' => '(UTC-06:00) Central America',
		    'US/Central' => '(UTC-06:00) Central Time (US & Canada)',
		    'America/Mexico_City' => '(UTC-06:00) Mexico City',
		    'America/Monterrey' => '(UTC-06:00) Monterrey',
		    'Canada/Saskatchewan' => '(UTC-06:00) Saskatchewan',
		    'America/Bogota' => '(UTC-05:00) Quito',
		    'US/Eastern' => '(UTC-05:00) Eastern Time (US & Canada)',
		    'US/East-Indiana' => '(UTC-05:00) Indiana (East)',
		    'America/Lima' => '(UTC-05:00) Lima',
		    'Canada/Atlantic' => '(UTC-04:00) Atlantic Time (Canada)',
		    'America/Caracas' => '(UTC-04:30) Caracas',
		    'America/La_Paz' => '(UTC-04:00) La Paz',
		    'America/Santiago' => '(UTC-04:00) Santiago',
		    'Canada/Newfoundland' => '(UTC-03:30) Newfoundland',
		    'America/Sao_Paulo' => '(UTC-03:00) Brasilia',
		    'America/Argentina/Buenos_Aires' => '(UTC-03:00) Georgetown',
		    'America/Godthab' => '(UTC-03:00) Greenland',
		    'America/Noronha' => '(UTC-02:00) Mid-Atlantic',
		    'Atlantic/Azores' => '(UTC-01:00) Azores',
		    'Atlantic/Cape_Verde' => '(UTC-01:00) Cape Verde Is.',
		    'Africa/Casablanca' => '(UTC+00:00) Casablanca',
		    'Europe/London' => '(UTC+00:00) London',
		    'Etc/Greenwich' => '(UTC+00:00) Greenwich Mean Time : Dublin',
		    'Europe/Lisbon' => '(UTC+00:00) Lisbon',
		    'Africa/Monrovia' => '(UTC+00:00) Monrovia',
		    'UTC' => '(UTC+00:00) UTC',
		    'Europe/Amsterdam' => '(UTC+01:00) Amsterdam',
		    'Europe/Belgrade' => '(UTC+01:00) Belgrade',
		    'Europe/Berlin' => '(UTC+01:00) Bern',
		    'Europe/Bratislava' => '(UTC+01:00) Bratislava',
		    'Europe/Brussels' => '(UTC+01:00) Brussels',
		    'Europe/Budapest' => '(UTC+01:00) Budapest',
		    'Europe/Copenhagen' => '(UTC+01:00) Copenhagen',
		    'Europe/Ljubljana' => '(UTC+01:00) Ljubljana',
		    'Europe/Madrid' => '(UTC+01:00) Madrid',
		    'Europe/Paris' => '(UTC+01:00) Paris',
		    'Europe/Prague' => '(UTC+01:00) Prague',
		    'Europe/Rome' => '(UTC+01:00) Rome',
		    'Europe/Sarajevo' => '(UTC+01:00) Sarajevo',
		    'Europe/Skopje' => '(UTC+01:00) Skopje',
		    'Europe/Stockholm' => '(UTC+01:00) Stockholm',
		    'Europe/Vienna' => '(UTC+01:00) Vienna',
		    'Europe/Warsaw' => '(UTC+01:00) Warsaw',
		    'Africa/Lagos' => '(UTC+01:00) West Central Africa',
		    'Europe/Zagreb' => '(UTC+01:00) Zagreb',
		    'Europe/Athens' => '(UTC+02:00) Athens',
		    'Europe/Bucharest' => '(UTC+02:00) Bucharest',
		    'Africa/Cairo' => '(UTC+02:00) Cairo',
		    'Africa/Harare' => '(UTC+02:00) Harare',
		    'Europe/Helsinki' => '(UTC+02:00) Kyiv',
		    'Europe/Istanbul' => '(UTC+02:00) Istanbul',
		    'Asia/Jerusalem' => '(UTC+02:00) Jerusalem',
		    'Africa/Johannesburg' => '(UTC+02:00) Pretoria',
		    'Europe/Riga' => '(UTC+02:00) Riga',
		    'Europe/Sofia' => '(UTC+02:00) Sofia',
		    'Europe/Tallinn' => '(UTC+02:00) Tallinn',
		    'Europe/Vilnius' => '(UTC+02:00) Vilnius',
		    'Asia/Baghdad' => '(UTC+03:00) Baghdad',
		    'Asia/Kuwait' => '(UTC+03:00) Kuwait',
		    'Europe/Minsk' => '(UTC+03:00) Minsk',
		    'Africa/Nairobi' => '(UTC+03:00) Nairobi',
		    'Asia/Riyadh' => '(UTC+03:00) Riyadh',
		    'Europe/Volgograd' => '(UTC+03:00) Volgograd',
		    'Asia/Tehran' => '(UTC+03:30) Tehran',
		    'Asia/Muscat' => '(UTC+04:00) Muscat',
		    'Asia/Baku' => '(UTC+04:00) Baku',
		    'Europe/Moscow' => '(UTC+04:00) St. Petersburg',
		    'Asia/Tbilisi' => '(UTC+04:00) Tbilisi',
		    'Asia/Yerevan' => '(UTC+04:00) Yerevan',
		    'Asia/Kabul' => '(UTC+04:30) Kabul',
		    'Asia/Karachi' => '(UTC+05:00) Karachi',
		    'Asia/Tashkent' => '(UTC+05:00) Tashkent',
		    'Asia/Calcutta' => '(UTC+05:30) Sri Jayawardenepura',
		    'Asia/Calcutta'  => '(UTC+05:30) New Delhi',		    
		    'Asia/Kolkata' => '(UTC+05:30) Kolkata',		    
		    'Asia/Katmandu' => '(UTC+05:45) Kathmandu',
		    'Asia/Almaty' => '(UTC+06:00) Almaty',
		    'Asia/Dhaka' => '(UTC+06:00) Dhaka',
		    'Asia/Yekaterinburg' => '(UTC+06:00) Ekaterinburg',
		    'Asia/Rangoon' => '(UTC+06:30) Rangoon',
		    'Asia/Bangkok' => '(UTC+07:00) Hanoi',
		    'Asia/Jakarta' => '(UTC+07:00) Jakarta',
		    'Asia/Novosibirsk' => '(UTC+07:00) Novosibirsk',
		    'Asia/Hong_Kong' => '(UTC+08:00) Hong Kong',
		    'Asia/Chongqing' => '(UTC+08:00) Chongqing',
		    'Asia/Krasnoyarsk' => '(UTC+08:00) Krasnoyarsk',
		    'Asia/Kuala_Lumpur' => '(UTC+08:00) Kuala Lumpur',
		    'Australia/Perth' => '(UTC+08:00) Perth',
		    'Asia/Singapore' => '(UTC+08:00) Singapore',
		    'Asia/Taipei' => '(UTC+08:00) Taipei',
		    'Asia/Ulan_Bator' => '(UTC+08:00) Ulaan Bataar',
		    'Asia/Urumqi' => '(UTC+08:00) Urumqi',
		    'Asia/Irkutsk' => '(UTC+09:00) Irkutsk',
		    'Asia/Tokyo' => '(UTC+09:00) Tokyo',
		    'Asia/Seoul' => '(UTC+09:00) Seoul',
		    'Australia/Adelaide' => '(UTC+09:30) Adelaide',
		    'Australia/Darwin' => '(UTC+09:30) Darwin',
		    'Australia/Brisbane' => '(UTC+10:00) Brisbane',
		    'Australia/Canberra' => '(UTC+10:00) Canberra',
		    'Pacific/Guam' => '(UTC+10:00) Guam',
		    'Australia/Hobart' => '(UTC+10:00) Hobart',
		    'Australia/Melbourne' => '(UTC+10:00) Melbourne',
		    'Pacific/Port_Moresby' => '(UTC+10:00) Port Moresby',
		    'Australia/Sydney' => '(UTC+10:00) Sydney',
		    'Asia/Yakutsk' => '(UTC+10:00) Yakutsk',
		    'Asia/Vladivostok' => '(UTC+11:00) Vladivostok',
		    'Pacific/Auckland' => '(UTC+12:00) Wellington',
		    'Pacific/Fiji' => '(UTC+12:00) Marshall Is.',
		    'Pacific/Kwajalein' => '(UTC+12:00) International Date Line West',
		    'Asia/Kamchatka' => '(UTC+12:00) Kamchatka',
		    'Asia/Magadan' => '(UTC+12:00) Solomon Is.',
		    'Pacific/Tongatapu' => '(UTC+13:00) Nuku alof',
		  );	
	
		  return $time_zones;	
		
	}

	
	/*Acl Check*/
	public function refreshPermission() {
		if ($user = $this->Auth->user()) {
			$this->Acl->Aro->recursive = -1;
		    $aro = $this->Acl->Aro->find('first', array(
		        'conditions' => array(
		            'Aro.model' => 'Usergroup',
		            'Aro.id' => $user['user_role'],
		        ),
		        'fields' => array('Aro.id')
		    ));
			$this->Acl->Aco->recursive = -1;
		    $acos = $this->Acl->Aco->find('all',array(
		    	'fields' => array('Aco.id'),
		    	'order' => array('Aco.order ASC')
			));
			$this->Acl->Aro->Permission->recursive = 0;$ii=0;
		    foreach($acos as $aco){
		    	
		    $permission = $this->Acl->Aro->Permission->find('first', array(
		        'conditions' => array(
		            'Permission.aro_id' => $aro['Aro']['id'],
		            'Permission.aco_id' => $aco['Aco']['id'],
		        ),
		    ));
		    if(isset($permission['Permission']['id'])){
		        if ($permission['Permission']['_create'] == 1 ||
		            $permission['Permission']['_read'] == 1 ||
		            $permission['Permission']['_update'] == 1 ||
		            $permission['Permission']['_delete'] == 1) {
		            	$ii++;
		            	$this->Session->write(
		                    'Auth.Permissions.'.$ii,$permission['Aco']['url']
		                );
						$this->Session->write(
		                    'Auth.AllPermissions.'.$permission['Aco']['alias'],
		                    $permission['Permission']
		                );
		            	if(!empty($permission['Aco']['parent_id'])){
		            		$parentAco = $this->Acl->Aco->find('first', array(
		                        'conditions' => array(
		                            'id' => $permission['Aco']['parent_id']
		                        )	
		                    ));
		                }
		            }
		        }
		    }
		}
	}

	public function getMenus($userType) {
		if ($user = $this->Auth->user()) {
			$this->Acl->Aro->recursive = -1;
		    $aro = $this->Acl->Aro->find('first', array(
		        'conditions' => array(
		            'Aro.model' => 'Usergroup',
		            'Aro.id' => $user['user_role'],
		        ),
		        'fields' => array('Aro.id')
		    ));
			$this->Acl->Aco->recursive = -1;
		    $acos = $this->Acl->Aco->find('all',array(
		    	'conditions' => array('Aco.user_type'=>$userType,'Aco.parent_id' => NULL),
		    	'fields' => array('Aco.id','Aco.alias','Aco.url'),
		    	'order' => array('Aco.order ASC')
			));
			foreach ($acos as $key => $menu) {
				 $permission = $this->Acl->Aro->Permission->find('first', array(
			        'conditions' => array(
			            'Permission.aro_id' => $aro['Aro']['id'],
			            'Permission.aco_id' => $menu['Aco']['id'],
			        ),
			    ));
				if(isset($permission['Permission']['id'])) {
					if ($permission['Permission']['_create'] == 1 || $permission['Permission']['_read'] == 1 || $permission['Permission']['_update'] == 1 || $permission['Permission']['_delete'] == 1) {
						$final['Menus'][$key] = $menu;
						$childMenus = $this->Acl->Aco->find('all',array(
							'conditions'=>array('Aco.user_type'=>$userType,'Aco.parent_id'=>$menu['Aco']['id']),
							'fields' => array('Aco.id','Aco.alias','Aco.url'),
							'order'=> array('Aco.order ASC')
						)); 
						foreach($childMenus as $index => $childMenu) {
							$childPermission = $this->Acl->Aro->Permission->find('first', array(
					        	'conditions' => array(
					            	'Permission.aro_id' => $aro['Aro']['id'],
					            	'Permission.aco_id' => $childMenu['Aco']['id'],
					        	),
					   		));
							if(isset($childPermission)) {
								if ($childPermission['Permission']['_create'] == 1 || $childPermission['Permission']['_read'] == 1 || $childPermission['Permission']['_update'] == 1 || $childPermission['Permission']['_delete'] == 1) {
									$final['Menus'][$key]['childMenu'][$index] = $childMenu;
								}
							}
						}
					}
				}
			}
			$this->Session->write('Auth.User.Menus',$final);
		}
	}
	/**
	 * To get tax tree structure
	 * @Fri Jul 18,2014 10:04:30 AM
	 * by Saurabh
	 * 
	 */
	public function taxTree(){
		//Tree For Taxes
		$this->subscriber = $this->Session->read('Auth.User.SbsSubscriber.id');
		$this->loadModel('SbsSubscriberTaxGroup');		
		$this->loadModel('SbsSubscriberTaxGroupMapping');
		$this->loadModel('SbsSubscriberTax');								
		$tax_groups_details = $this->SbsSubscriberTaxGroup->find('list', array ('conditions'=>array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$this->subscriber),'fields' => array ('SbsSubscriberTaxGroup.id','SbsSubscriberTaxGroup.group_name')));
		if($tax_groups_details){
			foreach ($tax_groups_details as $t1 => $t2) {
				$tax_mappings = $this->SbsSubscriberTaxGroupMapping->find('all', array ('conditions' => array ('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_group_id' => $t1),'order'=>array('SbsSubscriberTaxGroupMapping.priority ASC')));
				foreach($tax_mappings as $m1 => $m2){
					$taxname = $this->SbsSubscriberTax->find('all',array('conditions'=>array('SbsSubscriberTax.id'=>$m2['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id'],'SbsSubscriberTax.sbs_subscriber_id'=>$this->subscriber),'order' => 'SbsSubscriberTax.name ASC'));
					foreach($taxname as $name1 => $name2){
						$final_taxes2[$t2.'-'.$t1][$m2['SbsSubscriberTaxGroupMapping']['id']][$m2['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id']] = $name2['SbsSubscriberTax']['code'].'-'.$name2['SbsSubscriberTax']['percent'].'%';
						$final_taxes[$name2['SbsSubscriberTax']['id']]= $name2['SbsSubscriberTax']['code'].'-'.$name2['SbsSubscriberTax']['percent'].'%';
						$final_taxes[$t2.'-'.$t1][$m2['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_group_id']][$m2['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id']] = $name2['SbsSubscriberTax']['code'].'-'.$name2['SbsSubscriberTax']['percent'].'%';
					}
				}
			}
		}
			$final_taxesList = $this->SbsSubscriberTax->find('list',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$this->subscriber),'order' => 'SbsSubscriberTax.name ASC','fields'=>array('SbsSubscriberTax.id','SbsSubscriberTax.code')));
		foreach($final_taxesList as $taxId=>$taxName){
				$final_taxes[$taxId] = $taxName;
			}
		ksort($final_taxes);
		$var = 0;		
		foreach($final_taxes as $f1 => $f2){
			if(is_array($f2)){
				$name_exp = explode('-',$f1);
				$list[$f1] = $name_exp[0];
			/*	foreach($f2 as $v1 => $v2){
					foreach($v2 as $id1 => $name1){
						$list[$f1.$id1]='|--'.$name1;
					}
				}*/
			}else{
				$list[$f1] = $f2;
			}
		}
		return $list;
		//Tree For Tax Types Ends Here
	}
/**	
	* uploads files to the server
 * @params:
 *		$folder 	= the folder to upload the files e.g. 'img/files'
 *		$formdata 	= the array containing the form files
 *		$itemId 	= id of the item (optional) will create a new sub folder
 * @return:
 *		will return an array with the success of each file upload
 */
	public function uploadFiles($folder, $formdata, $itemId = null) {
		// setup dir names absolute and relative
		$folder_url = WWW_ROOT.$folder;
		$rel_url = $folder;
		
		
		// create the folder if it does not exist
		if(!is_dir($folder_url)) {
			mkdir($folder_url);
		}
		
		// if itemId is set create an item folder
		if($itemId) {
			// set new absolute folder
			$folder_url = WWW_ROOT.$folder.'/'.$itemId; 
			// set new relative folder
			$rel_url = $folder.'/'.$itemId;
			// create directory
			if(!is_dir($folder_url)) {
				mkdir($folder_url);
			}
		}
	
		// list of permitted file types, this is only images but documents can be added
		$permitted = array('image/gif','image/jpeg','image/jpg','image/pjpeg','image/png','text/csv','text/xls','application/vnd.ms-excel','application/pdf','application/octet-stream','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    
		// loop through and deal with the files
		
		foreach($formdata as $file) {
			
			// replace spaces with underscores
			$filename = str_replace(' ', '_', $file['name']);
			
			
			// assume filetype is false
				$typeOK = false;
			// check filetype is ok
			foreach($permitted as $type) {
                if($type == $file['type']) {
				   $typeOK = true;
				   break;
			    }
			}
		
		// if file type ok upload the file
			if($typeOK) {
				// switch based on error code
				switch($file['error']) {
					case 0:
						// check filename already exists
						if(!file_exists($folder_url.'/'.$filename)) {
							// create full filename
							$full_url = $folder_url.'/'.$filename;
							$url = $rel_url.'/'.$filename;
							// upload the file
								
							$success = move_uploaded_file($file['tmp_name'], $url);
							chmod($url, 0444);
						
						} else {
							// create unique filename and upload file
							ini_set('date.timezone', 'Europe/London');
							$now = date('Y-m-d-His');
							$full_url = $folder_url.'/'.$now.$filename;
							$url = $rel_url.'/'.$now.$filename;
							
							
							$success = move_uploaded_file($file['tmp_name'], $url);
							chmod($url, 0444);
						}
						// if upload was successful
						if($success) {
							// save the url of the file
							$result['urls'][] = $url;
						} else {
							$result['errors'][] = "Error uploaded $filename. Please try again.";
						}
						break;
					case 3:
						// an error occured
						$result['errors'][] = "Error uploading $filename. Please try again.";
						break;
					default:
						// an error occured
						$result['errors'][] = "System error uploading $filename. Contact webmaster.";
						break;
				}
			} elseif($file['error'] == 4) {
				// no file was selected for upload
				$result['nofiles'][] = "No file Selected";
			} else {
				// unacceptable file type
				$result['errors'][] = "Please upload image. Acceptable file types: gif, jpg, png.";
			}
		}
		return $result;
	} 
	
	/*
	public function generateInvoiceNumber($subscriberId = null) {
			$this->loadModel('SbsSubscriberSetting');
			$this->loadModel('AcrClientInvoice');
			$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($subscriberId);
			if($settings['SbsSubscriberSetting']['invoice_sequence_number']){
				$invoiceNumberStart  = $settings['SbsSubscriberSetting']['invoice_sequence_number'];
			}else{
				$invoiceNumberStart = "0001";
			}
			$invoiceFormat		 = $settings['SbsSubscriberSetting']['invoice_number_prefix'];
			//$totalInvoice		 = $this->AcrClientInvoice->getTotalInvoice($subscriberId);
			$totalInvoice		 = $this->AcrClientInvoice->getTotalInvoicePatternBased($subscriberId,$invoiceFormat);
			//$totalInvoice++;
			if($invoiceNumberStart){
				$totalInvoice = $totalInvoice + $invoiceNumberStart ;
			}
			$newInvoiceNumber	 = $invoiceFormat.$totalInvoice;
			return $newInvoiceNumber;
		}*/
	
	public function generateInvoiceNumber($subscriberId = null) {
	    $this->loadModel('SbsSubscriberSetting');
        $this->loadModel('AcrClientInvoice');
		$settings			= $this->SbsSubscriberSetting->defaultSettings($subscriberId);
		$quoteFormat 		= $settings['SbsSubscriberSetting']['invoice_number_prefix'];
		if(empty($settings['SbsSubscriberSetting']['invoice_number_prefix'])) $quoteFormat = 'INV-';
		$quoteInitalNumber = $settings['SbsSubscriberSetting']['invoice_sequence_number'];
		if(empty($quoteInitalNumber)) $quoteInitalNumber = '0001';
		$lastQuote 			= $this->AcrClientInvoice->find('first',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId,'AcrClientInvoice.invoice_number LIKE'=>$quoteFormat.'%'),'fields'=>array('invoice_number'),'order'=>array('invoice_number'=>'Desc')));
		preg_match_all('!\d+!', $lastQuote['AcrClientInvoice']['invoice_number'], $final);
		$fTotalQuote 		= $this->AcrClientInvoice->find('count',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId,'AcrClientInvoice.invoice_number LIKE'=>$quoteFormat.'%')));
		if($fTotalQuote == 0) {
			$newQuoteNumber	     = $quoteFormat.$quoteInitalNumber;
		} else {
			$totalQuote 		= $final[0][0];
			do {
				$totalQuote++;
				$digitsCount = strlen($final[0][0]);
				$formattedNumber     = sprintf('%0'.$digitsCount.'d', $totalQuote);
				$newQuoteNumber	     = $quoteFormat.$formattedNumber;
				$quoteExist = $this->AcrClientInvoice->find('first',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId,'AcrClientInvoice.invoice_number'=>$newQuoteNumber),'fields'=>array('id')));
			} while (!empty($quoteExist));
		}
		return $newQuoteNumber;
	}
	public function generateRecurringInvoiceNumber($subscriberId = null) {
	    $this->loadModel('SbsSubscriberSetting');
        $this->loadModel('AcrClientInvoice');
		$settings			= $this->SbsSubscriberSetting->defaultSettings($subscriberId);
		$quoteFormat 		= $settings['SbsSubscriberSetting']['recurring_invoice_format'];
		if(empty($settings['SbsSubscriberSetting']['recurring_invoice_format'])) $quoteFormat = 'RINV-';
		$quoteInitalNumber = "0001";
		
		$lastQuote 			= $this->AcrClientInvoice->find('first',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId,'AcrClientInvoice.invoice_number LIKE'=>$quoteFormat.'%','AcrClientInvoice.recurring'=>'Y'),'fields'=>array('invoice_number'),'order'=>array('invoice_number'=>'Desc')));
		preg_match_all('!\d+!', $lastQuote['AcrClientInvoice']['invoice_number'], $final);
		$fTotalQuote 		= $this->AcrClientInvoice->find('count',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId,'AcrClientInvoice.invoice_number LIKE'=>$quoteFormat.'%','AcrClientInvoice.recurring'=>'Y')));
		if($fTotalQuote == 0) {
			$newQuoteNumber	     = $quoteFormat.$quoteInitalNumber;
		} else {
			$totalQuote 		= $final[0][0];
			do {
				$totalQuote++;
				$digitsCount = strlen($final[0][0]);
				$formattedNumber     = sprintf('%0'.$digitsCount.'d', $totalQuote);
				$newQuoteNumber	     = $quoteFormat.$formattedNumber;
				$quoteExist = $this->AcrClientInvoice->find('first',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId,'AcrClientInvoice.invoice_number'=>$newQuoteNumber,'AcrClientInvoice.recurring'=>'Y'),'fields'=>array('id')));
			} while (!empty($quoteExist));
		}
		return $newQuoteNumber;
	}
	/*
	public function generateRecurringInvoiceNumber($subscriberId = null) {
			$this->loadModel('SbsSubscriberSetting');
			$this->loadModel('AcrClientInvoice');
			$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($subscriberId);
			$invoiceFormat 		 = $settings['SbsSubscriberSetting']['recurring_invoice_format'];
			$totalInvoice		 = $this->AcrClientInvoice->getTotalInvoice($subscriberId);
			$totalInvoice++;
			$newInvoiceNumber	 = $invoiceFormat.$totalInvoice;
			return $newInvoiceNumber;
		}*/
	
	
	public function getAdminSetting(){
		$this->loadModel('CpnSetting');
		$getSetting = $this->CpnSetting->getAllSettings();
		if($getSetting){
			return $getSetting;
		}else{
			return false;
		}	
		
	}
	
	public function dateFormatGeneralization($dateFormat,$date){
		switch($dateFormat){
			case "DD/MM/YYYY"	:	$dateFormatExplode = explode('/',$date);
									$date = $dateFormatExplode['2'].'-'.$dateFormatExplode['1'].'-'.$dateFormatExplode['0'];
									break;
			
		}
		return $date;
	}
	
}
