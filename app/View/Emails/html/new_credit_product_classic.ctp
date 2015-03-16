<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php
    if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
      $protocol_final = 'https';
    }else{
      $protocol_final = 'http';
    }
    $http_hostname = $_SERVER['HTTP_HOST'];
    $webroot_name = $this->webroot;
    $imgLink = "$protocol_final".'://'."$http_hostname/";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width" />
<title>CantoriX</title>
</head>

<body style="margin:0 auto;padding:0;">
<table style="width:100%; height:100%; border:0; cellspacing:0;cellpadding:0; background:#f0f0f0;padding:10px 5px 0 20px">
    <tr>
        <?php echo "Hello ".$creditNote['AcrClient']['client_name'];?>
    </tr>
    <tr>
        <?php echo '<pre style="float:left; width:90%;padding-left:4%; white-space: pre-wrap; white-space: -moz-pre-wrap; white-space: -pre-wrap;  white-space: -o-pre-wrap; word-wrap: break-word;">'.$content.'</pre>';?>
    </tr>
</table>
<table style="width:100%; height:100%; border:0; cellspacing:0;cellpadding:0; background:#f0f0f0;padding:5px 0px;">
    <tr>
        <td>
            <table cellspacing="0" style="width:1100px;padding:0px; background:#fff; height:100%; border:1px solid #d8d8d8; margin:auto; align:center; cellpadding:0; cellspacing:0; bgcolor:#ffffff;">
                <tr>
                   <td>
                   <table style="width:100%; height:100%;">
                       <tr>
                        <td align="left" style="width:50%;border:0;padding: 30px 40px;border-bottom:1px solid #e9e9e9">
                               <?php if(!empty($settings['SbsSubscriberSetting']['invoice_logo'])) {?>
                                    <img src="<?php echo $imgLink.$settings['SbsSubscriberSetting']['invoice_logo'];?>" alt="Logo"/>
                                <?php } else {?>
                                    <img src="<?php echo $imgLink.$webroot_name.'img/logo.png';?>" alt="Cantorix Logo"/>
                                <?php }?>
                                <?php if(!empty($settings['SbsSubscriberSetting']['text_logo'])) {
                                    echo '<div>'.$settings['SbsSubscriberSetting']['text_logo'].'</div>';
                                }?>
                        </td>
                        <td align="right" style="width:50%;border:0;padding: 30px 40px;border-bottom:1px solid #e9e9e9">
                          <table style="width:100%; height:100%; text-align: right;padding-right: 25px;" align="right">
                             <tr>
                                <td style="font-size:30px;font-weight:bold;font-family:Arial;">CREDIT NOTE</td>                           
                            </tr> 
                            <tr>
                                <td>
                                    <span style="margin-right:15px;font-family:Arial;font-size: 14px;">Credit #</span>
                                    <span style="font-weight:bold;font-family:Arial;font-size: 14px;"><?php echo $creditNote['AcrClientCreditnote']['credit_no'];?></span>
                                </td>
                            </tr> 
                          </table>    
                        </td>
                        </tr>
                   </table> 
                  </td> 
                </tr>
                <tr>
                   <td>
                   <table style="width:100%; height:100%;">
                       <tr>
                           <td align="left" style="width:50%;border:0;padding: 10px 40px;vertical-align: top;">
                                <table style="width:100%;" align="left">
                                    <tr>
                                        <td style="font-size:14px;font-weight:bold;font-family:Arial;">From:</td>
                                    </tr>
                                    <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['organization_name']){?>
                                    <tr>
                                        <td style="font-size:18px;font-weight:bold;font-family:Arial;"><?php if($organisationDetails['SbsSubscriberOrganizationDetail']['organization_name']){ echo $organisationDetails['SbsSubscriberOrganizationDetail']['organization_name'];}else{echo "--";}?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1']){ ?>
                                    <tr>
                                        <td style="font-size:14px;font-family:Arial;"><?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1']){echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'];}else{ echo "--";}?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2']){?>
                                    <tr>
                                        <td style="font-size:14px;font-family:Arial;"><?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2']){echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'];}else{ echo "--";}?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_city']){?>
                                    <tr>
                                        <td style="font-size:14px;font-family:Arial;"><?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_city']){echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'];}else{ echo "--";}?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_state']){?>
                                    <tr>
                                        <td style="font-size:14px;font-family:Arial;"><?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_state']){echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'];}else{ echo "--";}?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_country']){ ?>
                                    <tr>
                                        <td style="font-size:14px;font-family:Arial;"><?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_country']){echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'];}else{echo "--";}?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip']){ ?> 
                                    <tr>
                                        <td style="font-size:14px;font-family:Arial;"><?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip']){echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];}?></td>
                                    </tr>
                                    <?php } ?>
                                </table>  
                        </td>
                           <td align="right" style="width:50%;border:0;padding: 10px 40px; vertical-align: top;">
                            <table style="width:100%;text-align:right;padding-right:22px;" align="right">
                                    <tr>
                                        <td style="font-size:14px;font-weight:bold;font-family:Arial;">Credit Note to:</td>
                                    </tr>
                                    <?php if($creditNote['AcrClient']['organization_name']){?>
                                    <tr>
                                        <td style="font-size:18px;font-weight:bold;font-family:Arial;"><?php echo $creditNote['AcrClient']['organization_name']; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if($creditNote['AcrClient']['billing_address_line1']){?>
                                    <tr>
                                        <td style="font-size:14px;font-family:Arial;"><?php echo $creditNote['AcrClient']['billing_address_line1']; ?></td>
                                    </tr>
                                    <?php }else{ ?>
                                        <tr>
                                            <td style="font-size:14px;font-family:Arial;"><?php echo "--"; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if($creditNote['AcrClient']['billing_address_line2']){?>
                                    <tr>
                                        <td style="font-size:14px;font-family:Arial;"><?php echo $creditNote['AcrClient']['billing_address_line2']; ?></td>
                                    </tr>
                                    <?php }else{ ?>
                                        <tr>
                                            <td style="font-size:14px;font-family:Arial;"><?php echo  "--"; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if($creditNote['AcrClient']['billing_city']){ ?>
                                    <tr>
                                        <td style="font-size:14px;font-family:Arial;"><?php echo $creditNote['AcrClient']['billing_city']; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if($creditNote['AcrClient']['billing_state']){?>
                                    <tr>
                                        <td style="font-size:14px;font-family:Arial;"><?php echo $creditNote['AcrClient']['billing_state'];?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if($creditNote['AcrClient']['billing_country']){?>
                                    <tr>
                                        <td style="font-size:14px;font-family:Arial;"><?php echo $creditNote['AcrClient']['billing_country']; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if($creditNote['AcrClient']['billing_zip']){?>
                                    <tr>
                                        <td style="font-size:14px;font-family:Arial;"><?php echo $creditNote['AcrClient']['billing_zip']; ?></td>
                                    </tr>
                                    <?php } ?>
                                </table>  
                        </td>
                        </tr>
                   </table> 
                  </td> 
                </tr>
                 <tr>
                    <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
                </tr>
                 <tr>
                    <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
                </tr>
                <tr>
                  <td>
                   <table style="width:70%; height:100%; cellpadding:0; cellspacing:0;" align="center">
                        <tr>
                           <td style="width:33%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 5px;">Issue Date</td>
                           <td style="width:33%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:center;padding-right:0px;padding-bottom: 5px;">Reference #</td>  
                        </tr>
                   </table> 
                  </td>
                </tr>
                <tr>  
                  <td>
                   <table style="width:70%; height:100%; cellpadding:0; cellspacing:0;" align="center">
                        <tr>
                           <td style="width:33%;font-size:13px;font-family:Arial;text-align:left;padding-left:15px;padding-top: 5px;"><?php echo $creditNote['AcrClientCreditnote']['date_created'];?></td>
                           <td style="width:33%;font-size:13px;font-family:Arial;text-align:center;padding-right:0px;padding-top: 5px;"><?php if($creditNote['AcrClientCreditnote']['reference_no']){ echo $creditNote['AcrClientCreditnote']['reference_no'];}else { echo ''; }?></td>  
                        </tr>
                   </table> 
                  </td> 
                </tr>
                 <tr>
                    <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
                </tr>
                 <tr>
                    <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
                </tr>
                <tr>
                  <td>
                   <table style="width:90%; height:100%;" align="center">
                        <tr>
                           <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;">Item</td>
                           <td style="width:20%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:left;padding-bottom: 10px;padding-top:10px;">Description</td> 
                           <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Qty</td>
                            <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Unit Price</td>
                             <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Disc %</td>
                              <td style="width:16%;font-size:15px;font-family:Arial;font-weight:bold;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Amount</td>  
                        </tr>
                   </table> 
                  </td>
                </tr>
               <?php foreach($productDetails as $productDetail):?>
                <?php if($productDetail):?>
                <tr>  
                  <td>
                   <table style="width:90%; height:100%; cellpadding:0; cellspacing:0;" align="center">
                        <tr>
                           <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-left:15px;padding-bottom: 10px;padding-top:10px;color:#4E68A1;">
                           	<?php if(!empty($inventories[$productDetail['AcrClientCreditnoteProduct']['inv_inventory_id']])) { echo $inventories[$productDetail['AcrClientCreditnoteProduct']['inv_inventory_id']];} else { echo "&nbsp;"; }?>
                           </td>
                           <td style="width:20%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:left;padding-bottom: 10px;padding-top:10px;">
                           	<?php
		                        if(empty($productDetail['AcrClientCreditnoteProduct']['inventory_description'])) {
		                            echo '&nbsp;';
		                        } else {
		                            echo $productDetail['AcrClientCreditnoteProduct']['inventory_description'];    
		                        }
		                    ?>
                           </td> 
                           <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">
                           	<?php echo $productDetail['AcrClientCreditnoteProduct']['quantity'];?>
                           </td>
                           <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">
                           	<?php echo $this->Number->currency(($productDetail['AcrClientCreditnoteProduct']['unit_rate']/$creditNote['AcrClientCreditnote']['exchange_rate']),''/*$creditNote['AcrClientCreditnote']['client_currency_code']*/);?>
                           	
                           </td>
                           <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">
                           <?php if(!empty($productDetail['AcrClientCreditnoteProduct']['discount_percent'])) {
                                     echo $productDetail['AcrClientCreditnoteProduct']['discount_percent'],'%';
			                    } else {
			                        echo "0%";
			                    } ?>
                           </td>
                           <td style="width:16%;font-size:13px;font-family:Arial;border-bottom:1px solid #d8d8d8;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">
                           	<?php echo $this->Number->currency(($productDetail['AcrClientCreditnoteProduct']['line_total']/$creditNote['AcrClientCreditnote']['exchange_rate']),''/*$creditNote['AcrClientCreditnote']['client_currency_code']*/);?>
                           </td>  
                        </tr>
                   </table> 
                  </td> 
                </tr>
                <?php endif;?>
                <?php endforeach;?>
                
                             
                
                
                
                <tr>  
                  <td style="padding-top:10px;padding-right:52px;">
                   <table style="width:34%; height:100%;" align="right">
                        <tr>
                             <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Subtotal</td>
                              <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:20px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($creditNote['AcrClientCreditnote']['func_sub_total']/$creditNote['AcrClientCreditnote']['exchange_rate'],$creditNote['AcrClientCreditnote']['client_currency_code']);?></td>  
                        </tr>
                        <?php foreach($taxes as $tax):?>
                        <tr>
                             <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;"><?php echo $tax['taxName'];?></td>
                              <td style="width:50%;font-size:13px;font-family:Arial;text-align:right;padding-right:20px;padding-bottom: 10px;"><?php echo $this->Number->currency($tax['taxAmount']/$creditNote['AcrClientCreditnote']['exchange_rate'],$creditNote['AcrClientCreditnote']['client_currency_code']);?></td>  
                        </tr>
                        <?php endforeach;?>
                        <tr>
                             <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:15px;padding-bottom: 10px;padding-top:10px;">Total</td>
                              <td style="width:50%;font-size:14px;font-weight:bold;font-family:Arial;text-align:right;padding-right:20px;padding-bottom: 10px;padding-top:10px;"><?php echo $this->Number->currency($creditNote['AcrClientCreditnote']['amount'],$creditNote['AcrClientCreditnote']['client_currency_code']);?></td>  
                        </tr>
                   </table> 
                  </td> 
                </tr>
                <tr>  
                  <td>
                   <table style="width:91%; height:100%;" align="center">                        
                        <tr>
                            <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;border-bottom:1px solid #d8d8d8;"></td>
                        </tr>                        
                   </table> 
                  </td> 
                </tr>
                 
                  <tr>
                    <td  style="padding: 7px 0; padding-left:10px;font-size:13px;font-family:arial;color:#ffffff;"></td>
                </tr>                  
                <tr>  
                  <td>
                   <table style="width:50%; height:100%;padding-top:15px;" align="center">  
                        <tr>
                            <td  style="padding: 3px 0;font-size:14px;font-weight:bold;text-align:center;font-family:arial;">
                            Thank you for your business
                            </td>
                        </tr>
                       
                    </table>
                  </td>
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
                        <td>
                        <table style="width:90%; height:100%;padding-top:15px;" align="center">
                            <tr>
                                <td  style="padding: 3px 0;font-size:15px;font-family:arial;font-weight:bold;"> 
                                       <!-- Yours Faithfully--> <br>
                                        <?php echo '<pre>'.$signature.'</pre>'; ?>
                                </td>
                            </tr>  
            </table>
        </td>
    </tr>
</table>
</body>
</html>