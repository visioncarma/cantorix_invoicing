<?php
include("geoipcity.inc");
    include("geoipregionvars.php");
    include("timezone.php");
    
    class LocationCityComponent extends Component {
    	
    function getcity_info($ip) {
    	if($ip){
    		$ip = $ip;
    	}else{
    		//Get remote IP
   			$ip = $_SERVER['REMOTE_ADDR'];
    	}
    	//Open GeoIP database and query our IP
    	$gi = geoip_open("/home/cantorix/public_html/cantorix/app/Controller/Component/GeoLiteCity.dat", GEOIP_STANDARD);
   		$record = geoip_record_by_addr($gi, $ip);
    	//If we for some reason didnt find data about the IP, default to a preset location.
   		//You can also print an error here.
   		if(!isset($record)){
        	$record = new geoiprecord();
        	$record->latitude = 59.2;
        	$record->longitude = 17.8167;
        	$record->country_code = 'SE';
       		$record->region = 26;
    	}
    	//Calculate the timezone and local time
    	try{
			//Create timezone
			$user_timezone = new DateTimeZone(get_time_zone($record->country_code, ($record->region!='') ? $record->region : 0));
			//Create local time
			$user_localtime = new DateTime("now", $user_timezone);
			$user_timezone_offset = $user_localtime->getOffset();   
		}
		//Timezone and/or local time detection failed
		catch(Exception $e){
			$user_timezone_offset = 7200;
			$user_localtime = new DateTime("now");
		}
		debug($user_localtime);
		$timeZoneArray['localtime'] = $user_localtime->format('H:i:s') ;
		$timeZoneArray['timezone'] =  $user_localtime->timezone ;
		$timeZoneArray['user_timezone_offset'] = ($user_timezone_offset/3600).' Hours'. "+GMT";
		$timeZoneArray['sunrise'] = date_sunrise(time(), SUNFUNCS_RET_STRING, $record->latitude, $record->longitude, ini_get("date.sunrise_zenith"), ($user_timezone_offset/3600));
		$timeZoneArray['sunset'] = date_sunset(time(), SUNFUNCS_RET_STRING, $record->latitude, $record->longitude, ini_get("date.sunset_zenith"), ($user_timezone_offset/3600));
		return $timeZoneArray;
    }
    }
 
   
 
   
    
 
    
 ?>