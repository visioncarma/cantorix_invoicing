<?php
    /*if( isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
      $protocol_final = 'https';
    }else{*/
      $protocol_final = 'https';
    /*}
    $explodededed = explode(' ', $_SERVER['SSH_CONNECTION']);
    $hostname = gethostbyaddr($explodededed[2]);
    $webroot_name = 'cantorix/';*/
    $resetLink = "$protocol_final".'://'."$http_hostname/"."$webroot_name";
?>
<table style="width:100%; height:100%; border:0; cellspacing:0;cellpadding:0; background:#f0f0f0;padding:30px 0px;">
    <tr>
        <td>
        <table cellspacing="0" style="width:600px;padding:0px; background:#fff; height:100%; border:1px solid #d8d8d8; margin:auto; align:center; cellpadding:0; cellspacing:0; bgcolor:#ffffff;">
            <tr>
                <td  style="width:100%; border:0;padding: 10px 20px;background:#f9f9f9;"><img src="<?php echo $protocol_final.'://'.$http_hostname.'/'.$webroot_name.'/';?>img/logo.png" /></td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
            <tr>
                <td style="padding:0px 30px;">
                <p style="padding:20px 10px;background:#86B559;">
                    <span style="font-size:14px;font-family:arial;color:#fff;font-weight:normal;">Notification:</span></br>
                    <span style="font-size:20px;font-family:arial;color:#fff;font-weight:bold;">Downgrade.</span>
                </p></td>
            </tr>
            <tr>
                <td style="padding:0px 30px;font-size:14px;font-family:arial;color:#666666;font-weight:normal;"> Dear Valued Cantorix Customer, </td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
            <tr>
                <td style="padding:0px 30px;font-size:14px;font-family:arial;color:#666666;font-weight:normal;">Your CantoriX application subscription has been downgraded to <?php echo $plan;?> plan. To upgrade a plan in future Login to application and Settings -> Change Subscription -> upgrade.</td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
            <tr>
                <td style="padding:0px 30px;font-size:14px;font-family:arial;color:#666666;font-weight:normal;"> Thank you for choosing to Cantorix Invoicing </td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
            <tr>
                <td style="padding:0px 30px;font-size:14px;font-family:arial;color:#666666;font-weight:normal;"> Sincerely, </td>
            </tr>
            <tr>
                <td style="padding:0px 30px;font-size:14px;font-family:arial;color:#666666;font-weight:normal;"> Cantorix Team </td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
            <tr>
                <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
            </tr>
        </table></td>
    </tr>
    <tr>
        <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
    </tr>
    <tr>
        <td style="padding:0px 30px;font-size:12px;font-family:arial;color:#666666;font-weight:normal;text-align:center;"> &copy; Copyright Cantorix 2014, All Rights Reserved. </td>
    </tr>
</table>