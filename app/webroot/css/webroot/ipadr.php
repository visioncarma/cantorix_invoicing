<?php 

echo $ipadr = get_client_ip();
echo '1'.$ipaddress = $_SERVER['HTTP_CLIENT_IP'];;
echo '2'. $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
echo '3'.$ipaddress = $_SERVER['HTTP_X_FORWARDED'];;
echo '4'.$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
echo '5'.$ipaddress = $_SERVER['HTTP_FORWARDED'];
echo  '6'.$ipaddress = $_SERVER['REMOTE_ADDR'];;

// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
	else if($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];    
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


?>
