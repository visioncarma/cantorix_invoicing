<div class="modal-header page-header">
    <?php echo $this->Html->link('<i class="icon-remove"></i>',array('action'=>'index', $customerName, $creditNo, $creditNoteStatus, $min, $max, '?'=>array('fromFilter'=>$from, 'toFilter'=>$to), 'page:'.$page),array('class'=>'close','escape'=>FALSE));?>
    <h1 class="modal-title" id="myModalLabel">Apply credits from <?php echo $creditNoteDetails['AcrClientCreditnote']['credit_no'];?> </h1>
</div>

<div class="modal-body">
    <div class="model-body-inner-content">
        <?php echo $this->Session->flash();?>
        <div class="row margin-twenty-zero expensemargin">
            <div class="col-md-8 ">
                <div class="form-group popupfilter">
                    <?php 
                        echo $this->Form->create('CreditApply',array('inputDefaults'=>array('div'=>FALSE,'label'=>FALSE)));
                        echo $this->Form->input('invoice_filter',array('class'=>'form-control width120','placeholder'=>'Invoice #'));
                        echo $this->Js->submit('Filter',array('url'=>array('action'=>'applyCredit',$id),'class'=>'btn btn-sm btn-primary filter-btn','update'=>'#applyCreditUpdate','escape'=>false,'div'=>FALSE));
                        echo $this->Js->link('Reset',array('action'=>'applyCredit',$id),array('class'=>'btn btn-sm btn-primary filter-btn','update'=>'#applyCreditUpdate'));
                        echo $this->Form->end();
                    ?>
                </div>
            </div>
            <div class="col-md-4  creditbalance">
                <lable>
                    Balance :
                </lable>
                <span class="bold"><?php echo $this->Number->currency($creditNoteDetails['AcrClientCreditnote']['balance_amount'],$creditNoteDetails['AcrClientCreditnote']['client_currency_code']);?></span>
            </div>
        </div>
        <?php echo $this->Form->create('ApplyToInvoice',array('inputDefaults'=>array('div'=>FALSE,'label'=>FALSE)));?>
        <div class="roles-table-wrapper-inner apply_credit_table">
            <?php foreach($dueInvoices as $invoice):?>
            <table class="table table-striped roles-table apply_roles_table">
                <tr>
                    <td class="title bold width-100-new blue">Invoice Number</td>
                    <td class="title bold width-100-new blue">Invoice Date</td>
                    <td class="title bold width-100-new textright blue">Invoice Amount</td>
                    <td class="title bold width-100-new textright blue">Invoice Balance</td>
                    <td class="title bold width120 textright blue">Amount to Credit</td>
                </tr>
                <tr class="even-strip">
                    <td class="title width-100-new"><?php echo $invoice['AcrClientInvoice']['invoice_number'];?></td>
                    <td class="title width-100-new"><?php echo date($settings['SbsSubscriberSetting']['date_format'],strtotime($invoice['AcrClientInvoice']['invoiced_date']));?></td>
                    <td class="title width-100-new textright"><?php echo $this->Number->currency($invoice['AcrClientInvoice']['invoice_total'],$invoice['AcrClientInvoice']['invoice_currency_code']);?></td>
                    <td class="title width-100-new textright"><?php echo $this->Number->currency(($invoice['AcrClientInvoice']['invoice_total'] - $invoice[0]['paid_amount']),$invoice['AcrClientInvoice']['invoice_currency_code']);?></td>
                    <td class="title width120 textright">
                    <?php
                        echo $this->Form->hidden('credit_apply.'.$invoice['AcrClientInvoice']['id'].'.invoice_number',array('value'=>$invoice['AcrClientInvoice']['invoice_number'])); 
                        echo $this->Form->hidden('credit_apply.'.$invoice['AcrClientInvoice']['id'].'.invoice_balance',array('value'=>($invoice['AcrClientInvoice']['invoice_total'] - $invoice[0]['paid_amount'])));
                        echo $this->Form->input('credit_apply.'.$invoice['AcrClientInvoice']['id'].'.credit_amount',array('class'=>'textright creditinput'));
                    ?>
                    <span style="display: none"><?php echo ($invoice['AcrClientInvoice']['invoice_total'] - $invoice[0]['paid_amount']);?></span>
                    </td>
                </tr>
            </table>
            <?php endforeach;?>
            <div id="totalCredit">
                <table class="table table-striped roles-table totalcredit">
                    <tr></tr>
                    <tr class="even-strip">
                        <td colspan="4" class="title textright width-100-new">Amount to Credit</td>
                        <td class="title textright width120"><?php echo $this->Number->currency(0,$creditNoteDetails['AcrClientCreditnote']['client_currency_code']);?></td>
                    </tr>
                </table>
                <table class="table table-striped roles-table totalcredit remanining_credit">
                    <tr></tr>
                    <tr class="even-strip">
                        <td colspan="4" class="title textright width-100-new">Remaining credits</td>
                        <td class="title textright width120 bold"><?php echo $this->Number->currency($creditNoteDetails['AcrClientCreditnote']['balance_amount'],$creditNoteDetails['AcrClientCreditnote']['client_currency_code']);?></td>
                    </tr>
                </table>    
            </div>
            <div class="modal-footer">
	            <?php echo $this->Js->submit('Apply', array('div'=>false,'class'=>'btn btn-info close-submit4','url' => array('action'=>'applyCredit', $id, $customerName, $creditNo, $creditNoteStatus, $min, $max, '?'=>array('fromFilter'=>$from, 'toFilter'=>$to), $page),'escape'=>FALSE,'update' => '#applyCreditUpdate','tag'=>'<i class="icon-ok bigger-110"></i>'));?>
	            <?php echo $this->Html->link('<i class="icon-remove bigger-110"></i>Cancel',array('action'=>'index', $customerName, $creditNo, $creditNoteStatus, $min, $max, '?'=>array('fromFilter'=>$from, 'toFilter'=>$to), 'page:'.$page),array('class'=>'btn btn-inverse','escape'=>FALSE));?>
            </div>
            <?php echo $this->Form->end();?>        
    <!-- <button class="btn btn-inverse" type="button" data-dismiss="modal">
        <i class="icon-remove bigger-110"></i>
        Cancel
    </button> -->
        </div>
    </div>
</div>

    

<script type="text/javascript">
    deleteselected = function() {
        //alert($('.roles-table input[type="checkbox"]:checked').length);
        if ($('.roles-table input[type="checkbox"]:checked').length > 0) {
            $('.delete-all-trash').fadeIn();
        } else {
            $('.delete-all-trash').fadeOut();

        }
    };
    select_each_row_mobile = function(that) {
        if ((that).is(":checked")) {
            $(that).parents('table').find('.select-each input[type="checkbox"]').prop('checked', true);
        } else {
            $(that).parents('table').find('.select-each input[type="checkbox"]').prop('checked', false);
        }
    }

    $(document).ready(function() {
        var totalVal = parseFloat(0);
        $('.creditinput').change(function(){
           var maxVal = $(this).next().text();
           var actualVal = parseFloat($(this).val());
           totalVal = totalVal + actualVal;
           var creditBalance = parseFloat(<?php echo $creditNoteDetails['AcrClientCreditnote']['balance_amount']?>);
           
           if(actualVal > maxVal) {
               alert('Credit cannot use more than invoice amount');
               $(this).val('');
               totalVal = totalVal - actualVal;
           } else if(totalVal > creditBalance) {
                alert('Credit balance not sufficent to use more than invoice amount');
                $(this).val('');
                totalVal = totalVal - actualVal;
           } else {
               <?php echo $this->Js->request(array('action' => 'calculateTotalCredit',$creditNoteDetails['AcrClientCreditnote']['balance_amount'],$creditNoteDetails['AcrClientCreditnote']['client_currency_code']), array('update'=>'#totalCredit','async'=>true,'dataExpression'=>true,'method'=>'post','data'=>$this->Js->serializeForm(array('isForm'=>false,'inline'=>true))));?>
           }
        });
        
        //table mobile view script//
        if ($('.roles-table-wrapper-inner.apply_credit_table').length) {
            var winsize = 1;
            if ($('.roles-table.apply_roles_table').length) {
                var i = 1;
                $('.roles-table.apply_roles_table').each(function() {
                    $(this).addClass("role-table-" + i);
                    i++;
                });
            }
            $('.roles-table.apply_roles_table').not('.role-table-1').find('tr:first').addClass("hidden-row");

            $('#applycredit').on('show.bs.modal', function(e) {
                //$(this).find('tr:first').removeClass("hidden-row");
                $(this).find('table:first').addClass("popuptable");
                $('.popuptable').find('tr:first').removeClass("hidden-row");
            });

            $changeTableView = function() {
                $(".table").each(function() {
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
                    $('.roles-table.apply_roles_table').not('.role-table-1').find('tr:first').addClass("hidden-row");
                    $('.popuptable').find('tr:first').removeClass("hidden-row");
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

        //for alternative row colors

        $('.roles-table.apply_roles_table input[type="checkbox"]').click(function() {
            select_each_row_mobile($(this));
        });

        //delete all trash fadein and fadeout

        //select all check boxes
        $('.select-all-mobile input[type="checkbox"]').click(function() {
            if ($(this).is(":checked")) {
                $('.roles-table .select-all').find('input[type="checkbox"]').prop('checked', true);
            } else {
                $('.roles-table .select-all').find('input[type="checkbox"]').prop('checked', false);
            }
        });

        $('.select-all input[type="checkbox"]').click(function() {
            if ($(this).is(":checked")) {
                $('.select-all-mobile').find('input[type="checkbox"]').prop('checked', true);
                $('.select-each').find('input[type="checkbox"]').prop('checked', true);
                $('.select-all').find('input[type="checkbox"]').prop('checked', true);
            } else {
                $('.select-all-mobile').find('input[type="checkbox"]').prop('checked', false);
                $('.select-each').find('input[type="checkbox"]').prop('checked', false);
                $('.select-all').find('input[type="checkbox"]').prop('checked', false);
            }
            deleteselected();
        });

        $('.select-each input[type="checkbox"]').click(function() {
            if ($(this).find('input[type="checkbox"]').prop('checked', true)) {
                if ($('.select-all').find('input[type="checkbox"]').prop('checked', true)) {
                    $('.select-all').find('input[type="checkbox"]').prop('checked', false);
                    $('.select-all-mobile').find('input[type="checkbox"]').prop('checked', false);
                }
            }
            if ($('.select-each input[type="checkbox"]').length == $('.select-each input[type="checkbox"]:checked').length) {
                $('.select-all').find('input[type="checkbox"]').prop('checked', true);
                $('.select-all-mobile').find('input[type="checkbox"]').prop('checked', true);
            }
            deleteselected();
        });

        $('.select-each-mobile input[type="checkbox"]').click(function() {
            if ($('.select-each-mobile input[type="checkbox"]').length == $('.select-each-mobile input[type="checkbox"]:checked').length) {
                $('.select-all').find('input[type="checkbox"]').prop('checked', true);
                $('.select-all-mobile').find('input[type="checkbox"]').prop('checked', true);
            }
            deleteselected();
        });

    });

</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.date-picker').datepicker({
            autoclose : true
        }).next().on(ace.click_event, function() {
            $(this).prev().focus();
        });
        if ($('.selectpicker').length) {
            $('.selectpicker').selectpicker({
            });
        }
        $(".chosen-select").chosen();

    });
    
    

</script>
<?php echo $this->Js->writeBuffer();?>