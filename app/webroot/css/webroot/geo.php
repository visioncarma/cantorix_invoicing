<?php 
//echo $_SERVER['HTTP_CLIENT_IP'];
//echo $_SERVER['HTTP_X_FORWARDED_FOR'];
//echo $host= gethostname();
//echo $ip = gethostbyname($host);
//echo var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip)));
//$myPublicIP = trim(shell_exec("dig +short myip.opendns.com @resolver1.opendns.com"));
//echo "My public IP: ".$myPublicIP;



   $list = DateTimeZone::listAbbreviations();
    $idents = DateTimeZone::listIdentifiers();

    $data = $offset = $added = array();
    foreach ($list as $abbr => $info) {
        foreach ($info as $zone) {
            if ( ! empty($zone['timezone_id'])
                AND
                ! in_array($zone['timezone_id'], $added)
                AND 
                  in_array($zone['timezone_id'], $idents)) {
                $z = new DateTimeZone($zone['timezone_id']);
                $c = new DateTime(null, $z);
                $zone['time'] = $c->format('H:i a');
                $data[] = $zone;
                $offset[] = $z->getOffset($c);
                $added[] = $zone['timezone_id'];
            }
        }
    }

    array_multisort($offset, SORT_ASC, $data);
    $options = array();
    foreach ($data as $key => $row) {
        $options[$row['timezone_id']] = $row['time'] . ' - '
                                        . formatOffset($row['offset']) 
                                        . ' ' . $row['timezone_id'];
    }

    // now you can use $options;

function formatOffset($offset) {
        $hours = $offset / 3600;
        $remainder = $offset % 3600;
        $sign = $hours > 0 ? '+' : '-';
        $hour = (int) abs($hours);
        $minutes = (int) abs($remainder / 60);

        if ($hour == 0 AND $minutes == 0) {
            $sign = ' ';
        }
        return 'GMT' . $sign . str_pad($hour, 2, '0', STR_PAD_LEFT) 
                .':'. str_pad($minutes,2, '0');

}

print_r($options);
?>
