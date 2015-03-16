<?php
	if( isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
	  $protocol_final = 'https';
	}else{
	  $protocol_final = 'http';
	}
	$http_hostname = $_SERVER['HTTP_HOST'];
	$webroot_name = $this->webroot;
	$isp_address = $_SERVER['REMOTE_ADDR'];
	$encrypt_key = $details['resetlinkKey'];
	$resetLink = "$protocol_final".'://'."$http_hostname"."$webroot_name".'users/activateAccount?param='."$encrypt_key";
?>
<table style="width:100%; height:100%; border:0; cellspacing:0;cellpadding:0; background:#f0f0f0;padding:30px 0px;">
	<tr>
		<td>
		<table cellspacing="0" style="width:600px;padding:0px; background:#fff; height:100%; border:1px solid #d8d8d8; margin:auto; align:center; cellpadding:0; cellspacing:0; bgcolor:#ffffff;">
			<tr>
				<td  style="width:100%; border:0;padding: 10px 20px;background:#f9f9f9;"><img src="<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].'/'.$this->webroot;?>img/logo.png" /></td>
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
					<span style="font-size:14px;font-family:arial;color:#fff;font-weight:normal;">Action Required:</span></br>
					<span style="font-size:20px;font-family:arial;color:#fff;font-weight:bold;">Please Activate your Cantorix account.</span>
				</p></td>
			</tr>
			<tr>
				<td style="padding:0px 30px;font-size:14px;font-family:arial;color:#666666;font-weight:normal;"> Dear Valued Cantorix Customer, </td>
			</tr>
			<tr>
				<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
			</tr>
			<tr>
				<td style="padding:0px 30px;font-size:14px;font-family:arial;color:#666666;font-weight:normal;"> To activate your account,please click on the button below. You will then be asked to confirm your password. </td>
			</tr>
			<tr>
				<td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
			</tr>
			<tr>
				<td style="padding:0px 30px;">
				<p style="padding:10px;background:#2C83B8;width:200px;">
					<a style="font-size:16px;font-family:arial;color:#fff;font-weight:bold;text-decoration:none;" href="<?php echo $resetLink;?>">Activate account</a>
				</p></td>
			</tr>
			<tr>
				<td style="padding:0px 30px;font-size:14px;font-family:arial;color:#666666;font-weight:normal;"> or use the following url: </td>
			</tr>
			<tr>
				<td style="padding:0px 30px;font-size:14px;font-family:arial;color:#666666;font-weight:normal;"><a style="font-size:14px;font-family:arial;color:#7792D5;font-weight:normal;text-decoration:none;" href="<?php echo $resetLink;?>"><?php echo $resetLink;?></a></td>
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
				<td style="padding:0px 30px;font-size:14px;font-family:arial;color:#666666;font-weight:normal;"> Thank you for subscribing to Cantorix Invoicing </td>
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