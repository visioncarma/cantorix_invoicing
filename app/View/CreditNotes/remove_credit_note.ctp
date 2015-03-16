<div class="row marginleftrightzero  paddingtop15">
    <div class="row marginleftrightzero additionalinfo">

        <div class="headernew col-lg-6 col-md-8 col-sm-4 col-xs-12">
            <h5 class="no-border-bottom">Payments History</h5>
        </div>
        <div class="col-lg-3 col-md-2 col-xs-12 col-sm-3 pull-right">
            <label class="bold pull-right"><?php echo $this->Number->currency(($creditNote['AcrClientCreditnote']['amount'] - $creditNote['AcrClientCreditnote']['balance_amount']),$creditNote['AcrClientCreditnote']['client_currency_code']);?> </label>
            <label class="pull-right">Total Applied :&nbsp; </label>
        </div>
        <div class="col-lg-3 col-md-2 col-xs-12 col-sm-3 pull-right">

            <label class="bold pull-right"><?php echo $this->Number->currency($creditNote['AcrClientCreditnote']['balance_amount'],$creditNote['AcrClientCreditnote']['client_currency_code']);?></label>
            <label class="pull-right">Credit Balance :&nbsp; </label>
        </div>
    </div>
</div>
<div class="roles-table-wrapper-inner">
    <?php foreach($paymentHistory as $paymentDetail):?>
    <table id="sample-table-1" class="table credit_table table-striped roles-table">
        <tr>
            <td class="width-120-new bold">Date</td>
            <td class="width-120-new bold ">Invoice Number</td>
            <td class="width-120-new bold textright">Invoice Amount</td>
            <td class="width-120-new bold textright">Amount Credit</td>
            <td class="width-120-new bold textright padding-right-25">Invoice Balance</td>
            <td class="width-120-new bold textright">Action</td>
        </tr>
        <tr>
            <td class="width-120-new "><?php echo date($settings['SbsSubscriberSetting']['date_format'],strtotime($paymentDetail['AcrInvoicePaymentDetail']['payment_date']));?></td>
            <td class="width-120-new "><?php echo $paymentDetail['AcrClientInvoice']['invoice_number'];?></td>
            <td class="width-120-new textright"><?php echo $this->Number->currency($paymentDetail['AcrClientInvoice']['invoice_total'],$creditNote['AcrClientCreditnote']['client_currency_code']);?></td>
            <td class="width-120-new textright"><?php echo $this->Number->currency($paymentDetail['AcrInvoicePaymentDetail']['paid_amount'],$creditNote['AcrClientCreditnote']['client_currency_code']);?></td>
            <td class="width-120-new textright padding-right-25"><?php echo $this->Number->currency(($paymentDetail['AcrClientInvoice']['invoice_total'] - $paymentDetail['OverAllPayment']['0']['paid_amount']),$paymentDetail['AcrClientInvoice']['invoice_currency_code']);?></td>
            <td class="width-120-new bold textright">
                <?php echo $this->Js->link('<i class="icon-trash bigger-120"></i>',array('action'=>'removeCreditNote',$paymentDetail['AcrInvoicePaymentDetail']['id'],$paymentDetail['AcrCreditnotePaymentMapping']['id'],$creditNote['AcrClientCreditnote']['id'],'?'=>array('date'=>$settings['SbsSubscriberSetting']['date_format'],'creditAmount'=>$paymentDetail['AcrInvoicePaymentDetail']['paid_amount'],'invoiceID'=>$paymentDetail['AcrCreditnotePaymentMapping']['acr_client_invoice_id'])),array('class'=>'btn btn-xs btn-danger delete on-load delete-row','title'=>'Delete','escape'=>FALSE,'update'=>'#paymentHistory','confirm'=>'Are you sure want to delete ?'));?>
            </td>
        </tr>
    </table>
    <?php endforeach;?>
</div>
<script>
    $(document).ready(function() {
        //table mobile view script//
        if ($('.roles-table-wrapper-inner').length) {
            var winsize = 1;
            if ($('.roles-table').length) {
                var i = 1;
                $('.roles-table').each(function() {
                    $(this).addClass("role-table-" + i);
                    i++;
                });
            }
            $('.roles-table').not('.role-table-1').find('tr:first').addClass("hidden-row");

            $changeTableView = function() {
                $(".table.credit_table").each(function() {
                    var $this = $(this);
                    var newrows = [];
                    $this.find("tr").each(function() {
                        var i = 0;
                        $(this).find("td").each(function() {
                            i++;
                            if (newrows[i] === undefined) {
                                newrows[i] = $("<tr></tr>");
                            }
                            newrows[i].append($(this));
                        });
                    });
                    $this.find("tr").remove();
                    $.each(newrows, function() {
                        $this.append(this);
                    });
                });

            };

            if ($(window).width() < 992) {
                $changeTableView();
                winsize = 0;
            }

            $(window).on("resize", function() {

                if (Math.floor($(window).width() / 992) != winsize) {
                    $changeTableView();
                    winsize = Math.floor($(window).width() / 992);
                }
                if ($(window).width() > 992) {
                    $('.roles-table').not('.role-table-1').find('tr:first').addClass("hidden-row");
                }
            });
        }
        //table mobile view script//

        //for alternative row colors
        var i = 0;
        $('.even-strip').each(function() {
            if (i % 2 != 0) {
                $(this).addClass("coloredrow");
            }
            i++;
        });
    }); 
</script>
<?php echo $this->Js->writeBuffer();?>