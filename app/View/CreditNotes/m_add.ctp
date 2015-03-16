<?php 
    echo $this -> Session -> flash();
    $homeLink = $this -> Breadcrumb -> getLink('Home');
    //$dbFormat = array("d", "M", "Y");
    //$scriptFormat   = array("dd", "mm", "yyyy");
?>
<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try {
            ace.settings.check('breadcrumbs', 'fixed')
        } catch(e) {
        }
    </script>
    <ul class="breadcrumb">
        <li>
            <?php echo $this -> Html -> link('<i class="icon-home home-icon"></i>Home', "$homeLink", array('escape' => FALSE)); ?>
        </li>
        <li>
            <?php echo $this -> Html -> link('Manage Credits', array('action' => 'index')); ?>
        </li>
        <li class="active">
            Create Credit Note
        </li>
    </ul>
    <!-- .breadcrumb -->
</div>
<div class="page-content">
    <div class="page-header">
        <h1>Create Credit Note</h1>
        <div class="col-lg-2 paddingleftrightzero">
            <?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i> Back',array('action'=>'index', $customerName, $creditNoFilter, $status, $min, $max, $from, $to, 'page:'.$page),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
        </div>
    </div>
    <!-- /.page-header -->
    <?php echo $this->Form->create('AcrClientInvoice',array('id'=>'CreditNotes','class'=>'form-horizontal formdetails','role'=>'form','inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control')));?>
    <?php echo $this->Form->hidden('creditID',array('value'=>$creditNote['AcrClientCreditnote']['id']));?>
    <div class="row marginleftrightzero create_credit_note">
        <div class="col-lg-8 paddingleftrightzero">
            <div class="row marginleftrightzero">
                <div class="form-group marginleftrightzero filed-left width100">
                    <label  class="col-sm-3 control-label marginleftrightzero paddingleftrightzero">Credit No<em style="color:#ff0000;">&lowast;</em></label>
                    <div class="col-sm-2 marginleftrightzero paddingleftrightzero">
                        <?php echo $this->Form->input('credit_no',array('value'=>$creditNo));?>
                    </div>
                </div>
            </div>

            <div class="row marginleftrightzero">
                <div class="form-group filed-left drop-down marginleftrightzero form-dropdown relative">
                    <label id="customerLabel" class="col-sm-3 control-label marginleftrightzero paddingleftrightzero">Customer<em style="color:#ff0000;">&lowast;</em></label>
                    <div class="col-sm-6 marginleftrightzero paddingleftrightzero labelerror choosen_width">
                        <?php
                            if($apply && $invoiceIDDD) {
                              echo $this->Form->hidden('acr_client_id',array('value'=>$customerIDParam));  
                              echo $this->Form->input('acr_client_id',array('id'=>'customerID','class'=>'invdrop form-control selectitem','options'=>array(''=>'',$customers),'data-placeholder'=>'Select','data-live-search' => 'true','disabled'=>TRUE));
                            } else {
                               echo $this->Form->input('acr_client_id',array('id'=>'customerID','class'=>'invdrop form-control selectitem','options'=>array(''=>'',$customers),'data-placeholder'=>'Select','data-live-search' => 'true'));
                                $this->Js->get('#customerID')->event('change',$this->Js->request(array('action'=>'customerDetails'), array( 'update'=>"#updateCustomerDetail", 'async'=>FALSE, 'dataExpression'=>true, 'method'=>'post',
                                    'data'=>$this->Js->serializeForm(array('isForm'=>true,'inline'=>true))
                            )));
                            $this->Js->get('#customerID')->event('change',$this->Js->request(array('action'=>'customerCurrency'), array( 'update'=>"#currencyUpdatee", 'async'=>FALSE, 'dataExpression'=>true, 'method'=>'post',
                                    'data'=>$this->Js->serializeForm(array('isForm'=>true,'inline'=>true))
                            )));
                            $this->Js->get('#customerID')->event('change',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'currencyInfo'), 
                                array( 'update'=>'#invoiceCurrency', 'async'=>FALSE, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>FALSE,'inline'=>true)))));
                            $this->Js->get('#customerID')->event('change', $this->Js->request(array ('controller' => 'acr_client_invoices','action' => 'calculateTotal',1), 
                                array ('update' => '#calculateFinal','async' => true,'dataExpression' => true,
                                        'method' => 'post',
                                        'data' => $this->Js->serializeForm(array (
                                        'isForm' => false,
                                        'inline' => true
                                    ))
                                )));    
                            } 
                            echo $this -> Form -> hidden('defaultCurrencyId', array('value' => $defaultCurrency));
                            echo $this -> Form -> hidden('defaultCurrencyCodee', array('value' => $defaultCurrencyCode));
                            echo $this -> Form -> hidden('invoice_currency_code', array('value' => $defaultCurrencyCode));
                            echo $this -> Form -> hidden('conversionValue',array('value'=>1));
                        ?>
                    </div>
                </div>
            </div>
            <div class="row marginleftrightzero">
                <div class="form-group filed-left drop-down marginleftrightzero form-dropdown">
                    <label  class="col-sm-3 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Currency</label>
                    <div id="currencyUpdatee" class="col-sm-2 col-xs-12 marginleftrightzero paddingleftrightzero choosen_width">
                        <?php
                            echo $this->Form->input('cpn_currency_id',array('id'=>'currencySelect','options'=>array(''=>'',$currencyList),'default'=>$defaultCurrency,'data-live-search' => 'true', 'class'=>'invdrop form-control','data-placeholder'=>"Select Currency",'disabled'=>TRUE));
                            $this->Js->get('#currencySelect')->event('change',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'currencyInfo'), array( 'update'=>'#invoiceCurrency', 'async'=>true, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>true,'inline'=>true)))));
                            $this->Js->get('#currencySelect')->event('change', $this->Js->request(array ('controller' => 'acr_client_invoices','action' => 'calculateTotal',1), array ('update' => '#calculateFinal','async' => true,'dataExpression' => true,'method' => 'post','data' => $this->Js->serializeForm(array ('isForm' => false,'inline' => true)))));
                        ?>
                    </div>
                    <div id="invoiceCurrency">
                        
                    </div>
                </div>
            </div>
            <div class="row marginleftrightzero">
                <div class="form-group marginleftrightzero">
                    <label  class="col-sm-3 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Issue Date<em style="color:#ff0000;">&lowast;</em></label>
                    <div class="col-sm-2 col-xs-12 marginleftrightzero paddingleftrightzero">
                        <div class="input-group custom-datepicker datewidth">
                            <?php echo $this->Form->input('issueDate',array('label'=>false,'div'=>false,'class'=>'form-control date-picker','data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$settings['SbsSubscriberSetting']['date_format']),'default'=>date($settings['SbsSubscriberSetting']['date_format'])));?>
                            <span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row marginleftrightzero">
                <div class="form-group marginleftrightzero filed-left width100">
                    <label  class="col-sm-3 control-label marginleftrightzero paddingleftrightzero">Reference No</label>
                    <div class="col-sm-2 marginleftrightzero paddingleftrightzero">
                        <?php echo $this->Form->input('reference_no');?>
                    </div>
                </div>
            </div>
            
        </div>
        <div id="updateCustomerDetail" class="col-lg-4 no-padding-right  no-padding-left">
            <div class="widget-box">
                <div class="widget-header">
                    <h5>Credit Note To</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main paddingleftrightzero">
                        <div class="form-horizontal">
                            <div class="form-group borderline marginleftrightzero">
                                <div class="row marginleftrightzero">
                                    <div class="col-sm-12 col-xs-12 no-padding-right no-padding-left">
                                        <div class="col-sm-5 col-xs-5 control-label no-padding-right  " >
                                            Contact Name
                                        </div>
                                        <div class="col-sm-7 col-xs-7 control-label no-padding-right bold no-padding-left " >
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group borderline marginleftrightzero">
                                <div class="row marginleftrightzero">
                                    <div class="col-sm-12 col-xs-12 no-padding-right no-padding-left">
                                        <div class="col-sm-5 col-xs-5 control-label no-padding-right  " >
                                            Contact Surname
                                        </div>
                                        <div class="col-sm-7 col-xs-7 control-label no-padding-right bold no-padding-left " >
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group borderline marginleftrightzero">
                                <div class="row marginleftrightzero">
                                    <div class="col-sm-12 col-xs-12 no-padding-right no-padding-left">
                                        <div class="col-sm-5 col-xs-5 control-label no-padding-right  " >
                                            Contact Email
                                        </div>
                                        <div class="col-sm-7 col-xs-7 control-label no-padding-right bold no-padding-left wordwrap" >
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group borderline marginleftrightzero">
                                <div class="row marginleftrightzero">
                                    <div class="col-sm-12 col-xs-12 no-padding-right no-padding-left">
                                        <div class="col-sm-5 col-xs-5 control-label no-padding-right  " >
                                            Mobile
                                        </div>
                                        <div class="col-sm-7 col-xs-7 control-label no-padding-right bold no-padding-left " >
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group  marginleftrightzero borderline">
                                <div class="row marginleftrightzero">
                                    <div class="col-sm-12 col-xs-12 no-padding-right no-padding-left">
                                        <div class="col-sm-5 col-xs-5 control-label no-padding-right  " >
                                            Home Phone
                                        </div>
                                        <div class="col-sm-7 col-xs-7 control-label no-padding-right bold no-padding-left " >
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group  marginleftrightzero lastrow">
                                <div class="row marginleftrightzero">
                                    <div class="col-sm-12 col-xs-12 no-padding-right no-padding-left">
                                        <div class="col-sm-5 col-xs-5 control-label no-padding-right  " >
                                            Work Phone
                                        </div>
                                        <div class="col-sm-7 col-xs-7 control-label no-padding-right bold no-padding-left " >
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--   start table part   -->
   <?php $i=1;?>
    <div id ="inventoryUpdateSelect-<?php echo $i;?>" class="table-small-view  new-table-small  new_table_small_view new_table_small_view_new new-table-small" >
        <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
            <div class="col-xs-5 bold font13">
                Item
            </div>
            <div id ="td-inventoryUpdateSelect-<?php echo $i;?>" class="col-xs-7 font13  mobileClientName">
                <div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero" >
                    <div class="col-xs-10 marginleftrightzero paddingleftrightzero">
                        <?php 
                            echo $this->Form->input('AcrClientInvoice.inventory.'.$i, array('default'=>$product['AcrClientCreditnoteProduct']['inv_inventory_id'],'id' => 'inventory-'.$i, 'div' => false, 'label' => false, 'data-live-search'=>'true','class'=>'invdrop form-control','data-placeholder'=>"Select inventory",'options' => array('' => '','-1'=>'Non Inventory Item', $inventoryList)));
                            $this->Js->get('#inventory-'.$i)->event('change', $this->Js->request(array('controller' => 'acr_client_invoices', 'action' => 'getInventoryDetails', $i,$product['AcrClientCreditnoteProduct']['id'],TRUE,TRUE), array('update' => '#inventoryUpdateSelect-'.$i, 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
                            $this->Js->get('#inventory-'.$i)->event('change', $this->Js->request(array ('controller' => 'acr_client_invoices','action' => 'calculateTotal',$i),array ('update' => '#calculateFinal','async' => true,'dataExpression' => true,'method' => 'post','data' => $this->Js->serializeForm(array ('isForm' => false,'inline' => true)))));    
                            echo $this -> Form -> hidden('AcrClientInvoice.line_total_hidden.'.$i,array('value'=>$product['AcrClientCreditnoteProduct']['line_total']));
                            echo $this -> Form -> hidden('AcrClientInvoice.product_id.'.$i,array('value'=>$product['AcrClientCreditnoteProduct']['id']));
                        ?>
                    </div>

                    <div class="col-xs-2 marginleftrightzero paddingleftrightzero paddinglefttop4">
                        <div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype additem-to-select" data-toggle="modal" data-target="#addnewunittype-<?php echo $i?>">
                            <i class="icon-plus"></i>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
            <div class="col-xs-5 bold font13">
                Item Description
            </div>
            <div class="col-xs-7 font13  mobileClientName">
                <div class="form-group marginleftrightzero margin-bottom-zero">
                    <?php echo $this -> Form -> input('AcrClientInvoice.description.'.$i, array('rows'=>2,'value'=>$product['AcrClientCreditnoteProduct']['inventory_description'],'div' => false, 'label' => false, 'class' => 'col-sm-10 col-xs-10 tabletextarea', 'type' => 'textarea', 'placeholder' => 'Inventory description')); ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
            <div class="col-xs-5 bold font13">
                Qty
            </div>
            <div class="col-xs-7 font13  mobileClientName">

                <div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
                    <?php echo $this -> Form -> input('AcrClientInvoice.quantity.'.$i, array('id'=>'quantity-'.$i,'value'=>$product['AcrClientCreditnoteProduct']['quantity'],'div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5 form-control text-right','type'=>'text')); ?>
                </div>
                <div class="col-xs-2 marginleftrightzero paddingleftrightzero paddinglefttop4">
                    <label class="quotemeasurement">
                        <?php 
                                //echo $this->Form->hidden('AcrClientInvoice.unitTypeofInventory.'.$i,array('value'=>$unitTypeList[$inventoryUnitTypeList[$product['AcrClientCreditnoteProduct']['inv_inventory_id']]]));                            
                                $this -> Js -> get('#quantity-'.$i) -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getLineTotal', $i), array('update' => '#lineTotal-'.$i, 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
                                $this->Js->get('#quantity-'.$i)->event('change', $this->Js->request(array ('controller' => 'acr_client_invoices','action' => 'calculateTotal',$i), array ('update' => '#calculateFinal','async' => true,'dataExpression' => true,'method' => 'post','data' => $this->Js->serializeForm(array ('isForm' => false,'inline' => true)))));    
                        ?>
                   </label>
                </div>
            </div>
        </div>
        <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
            <div class="col-xs-5 bold font13">
                Unit Price
            </div>
            <div class="col-xs-7 font13  mobileClientName">
                <div class="form-group marginleftrightzero margin-bottom-zero">

                    <div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
                        <?php 
                                echo $this -> Form -> input('AcrClientInvoice.unit_rate.'.$i, array('id'=>'unit_rate-'.$i,'value'=>$product['AcrClientCreditnoteProduct']['unit_rate'],'div' => false, 'label' => false, 'class' => 'col-sm-10 form-control text-right','type'=>'text'));
                                $this -> Js -> get('#unit_rate-'.$i) -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getLineTotal', $i), array('update' => '#lineTotal-'.$i, 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
                                $this->Js->get('#unit_rate-'.$i)->event('change', $this->Js->request(array ('controller' => 'acr_client_invoices','action' => 'calculateTotal',$i), array ('update' => '#calculateFinal','async' => true,'dataExpression' => true,'method' => 'post','data' => $this->Js->serializeForm(array ('isForm' => false,'inline' => true)))));    
                                ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
            <div class="col-xs-5 bold font13">
                Discount %
            </div>
            <div class="col-xs-7 font13  mobileClientName">
                <div class="form-group marginleftrightzero margin-bottom-zero">
                    <div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
                        <?php 
                            echo $this -> Form -> input('AcrClientInvoice.discount_percent.'.$i, array('id'=>'discount_percent-'.$i,'value'=>$product['AcrClientCreditnoteProduct']['discount_percent'],'div' => false, 'label' => false, 'class' => 'col-sm-10 form-control black text-right','onkeyup'=>'this.value = minmax(this.value, 0, 100)','type'=>"text"));
                            $this -> Js -> get('#discount_percent-'.$i) -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getLineTotal', $i), array('update' => '#lineTotal-'.$i, 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
                            $this->Js->get('#discount_percent-'.$i)->event('change', $this->Js->request(array ('controller' => 'acr_client_invoices','action' => 'calculateTotal',$i), array ('update' => '#calculateFinal','async' => true,'dataExpression' => true,'method' => 'post','data' => $this->Js->serializeForm(array ('isForm' => false,'inline' => true)))));    
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
            <div class="col-xs-5 bold font13">
                Tax
            </div>
            <div class="col-xs-7 font13  mobileClientName">
                <div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero">

                    <div class="col-xs-10 marginleftrightzero paddingleftrightzero choosen_width">
                        <?php if(!empty($product['AcrClientCreditnoteProduct']['sbs_subscriber_tax_group_id'])):
                            $taxGroupID = $taxGroupNames[$product['AcrClientCreditnoteProduct']['sbs_subscriber_tax_group_id']].'-'.$product['AcrClientCreditnoteProduct']['sbs_subscriber_tax_group_id'];
                        ?>
                        <?php echo $this -> Form -> input('AcrClientInvoice.tax_inventory.'.$i, array('id'=>'tax_inventory-a'.$i,'default'=>$taxGroupID,'div' => false, 'label' => false, 'class' => 'invdrop form-control', 'data-placeholder'=>"Select Tax",'options' => array('' => '', $taxList))); ?>
                        <?php elseif(!empty($product['AcrClientCreditnoteProduct']['sbs_subscriber_tax_id'])):?>
                        <?php echo $this -> Form -> input('AcrClientInvoice.tax_inventory.'.$i, array('id'=>'tax_inventory-a'.$i,'default'=>$product['AcrClientCreditnoteProduct']['sbs_subscriber_tax_id'],'div' => false, 'label' => false, 'class' => 'invdrop form-control','data-placeholder'=>"Select tax", 'options' => array('' => '', $taxList))); ?>
                        <?php else:?>
                        <?php echo $this -> Form -> input('AcrClientInvoice.tax_inventory.'.$i, array('id'=>'tax_inventory-a'.$i,'div' => false, 'label' => false, 'class' => 'invdrop form-control','data-placeholder'=>"Select Tax", 'options' => array('' => '', $taxList))); ?>
                        <?php endif;?>
                        <?php
                            $this -> Js -> get('#tax_inventory-a'.$i) -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getLineTotal', $i), array('update' => '#lineTotal-'.$i, 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
                            $this->Js->get('#tax_inventory-a'.$i)->event('change', $this->Js->request(array ('controller' => 'acr_client_invoices','action' => 'calculateTotal',$i), array ('update' => '#calculateFinal','async' => true,'dataExpression' => true,'method' => 'post','data' => $this->Js->serializeForm(array ('isForm' => false,'inline' => true)))));    
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
            <div class="col-xs-5 bold font13">
                Amount
            </div>
            <div class="col-xs-7 font13  mobileClientName">
                <div class="form-group marginleftrightzero margin-bottom-zero">

                    <div id="lineTotal-<?php echo $i;?>" class="col-xs-10 marginleftrightzero paddingleftrightzero ">
                        <?php echo $this->Form->input('AcrClientInvoice.line_total.'.$i,array('value'=>$product['AcrClientCreditnoteProduct']['line_total'],'div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control text-right black','type'=>'text','disabled'=>'disabled','readonly'=>'readonly'));?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
            <div class="col-xs-5 bold font13">
                Action
            </div>
            <div class="col-xs-7 font13  mobileClientName">
                <div class="form-group marginleftrightzero margin-bottom-zero">

                    <div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Popup add  Inventory-->
                    <div class="modal fade popupbind" id="addnewunittype-<?php echo $i?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog addunittype">
                            <div class="modal-content">
                                <div class="modal-header page-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        <i class="icon-remove"></i>
                                    </button>
                                    <h1 class="modal-title" id="myModalLabel"><?php echo __('Add Inventory');?></h1>
                                </div>
                                    <div class="modal-body">
                                        <div class="model-body-inner-content">
                                            <div class="addtype-wrapper">
                                                <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Name');?> <em style="color:#ff0000;">&lowast;</em></label>
                                        <div class="col-sm-8">
                                            <?php echo $this->Form->input('addInventory.name.'.$i,array('div'=>false,'autocomplete'=>'off','label'=>false,'class'=>'col-xs-10 col-sm-5 env-name'.$i.' form-control','type'=>'text','id'=>'orm-field-1','Placeholder'=>'Inventory name'));?>
                                            <p class="popup-error1">Please enter inventory name.</p>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Description');?></label>
                                        <div class="col-sm-8">
                                            <?php echo $this->Form->input('addInventory.description.'.$i,array('div'=>false,'label'=>false,'autocomplete'=>'off','type'=>'textarea','rows'=>'2','class'=>'form-control col-xs-10 col-sm-5 itemdescription','id'=>'form-field-2','Placeholder'=>'Description of the inventory'));?>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('List Price');?><em style="color:#ff0000;">&lowast;</em></label>
                                        <div class="col-sm-8">
                                            <span>
                                                <?php echo $this->Form->hidden('addInventory.currency.'.$i,array('value'=>$defaultCurrency));?>
                                                <?php echo $this->Form->input('addInventory.code.'.$i,array('label'=>false,'div'=>false,'type'=>'text','id'=>'form-field-3','class'=>'form-control width30 col-xs-10 col-sm-5','value'=>$defaultCurrencyCode,'readonly'=>'readonly'))?>
                                            </span>
                                            <span>
                                                <?php echo $this->Form->input('addInventory.list_price.'.$i,array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-field-3','class'=>'col-xs-10 env-price'.$i.' width70 col-sm-5 form-control','style'=>'width:37%','Placeholder'=>'Inventory price'));?>
                                                <p class="popup-error2">Please enter inventory price.</p>
                                                <p class="popup-error3">Only numbers allowed</p>
                                                
                                            </span>
                                            
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo 'Tax/Tax Group';?> </label>
                                        <div class="col-sm-8 choosen_width">
                                            <?php echo $this->Form->input('addInventory.tax_inventory.'.$i,array('div'=>false,'label'=>false,'class'=>'form-control col-xs-10 col-sm-5 invdrop','data-placeholder'=>"Select Tax",'options'=>array(''=>'',$taxList)));?>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Unit Type');?> </label>
                                        <div class="col-sm-8 choosen_width" id ="unit-type">
                                            <?php echo $this->Form->input('addInventory.unitType.'.$i,array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control invdrop','data-placeholder'=>"Select Unit Type",'options'=>array(''=>'',$unitTypeList)));?>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Track Item Quantities');?></label>
                                        <div class="col-sm-8">
                                            <label>
                                                <?php echo $this->Form->checkbox('addInventory.track.'.$i,array('id'=>'inventoryCheckBox','div'=>false,'label'=>false,'class'=>'ace checkboxclass'));?>
                                                <span class="lbl"></span> </label>
                                            <label class="maillabel">Yes</label>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="form-group currentstock" style="display: none;">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Current Stock');?> </label>
                                        <div class="col-sm-8">
                                            <?php echo $this->Form->input('addInventory.current_stock.'.$i,array('div'=>false,'autocomplete'=>'off','label'=>false,'type'=>'text','class'=>'form-control env-qty'.$i.' col-xs-10 col-sm-5','id'=>'form-field-4','Placeholder'=>'Quantity of inventory  in stock'));?>
                                            <p class="popup-error4">Please enter current Stock.</p>
                                        </div>
                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer paddingright8">
                                        <?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info close-submit2','url' => array('controller'=>'inventories','action'=>'addInventoryFromEditQuote',$i),'escape'=>false,'update' => '#td-inventoryUpdateSelect-'.$i));?>
                                        <button class="btn close-popup btn-inverse" type="button">
                                            <i class="icon-remove bigger-110"></i>
                                            Cancel
                                        </button>
                                    </div>
                                    <script>
                                $(document).ready(function(){
                                	$(".invdrop option:contains('|--')").remove();
                                    $('#addnewunittype-<?php echo $i?>').on('show.bs.modal', function (e) {
                                        $('.env-name<?php echo $i?>, .env-price<?php echo $i?>, .env-qty<?php echo $i?>').val('');
                                        $('.popup-error1, .popup-error2, .popup-error3, .popup-error4').hide();
                                        $('.currentstock').hide();
                                        
                                        $('#inventoryCheckBox').attr('checked', false); // Unchecks it
                                        $('#addInventoryEditTrack-<?php echo $i?>').attr('checked', false); // Unchecks it
                                    });
                                    $( ".env-name<?php echo $i?>, .env-price<?php echo $i?>, .env-qty<?php echo $i?>" ).focus(function() {
                                        $('.popup-error1, .popup-error2, .popup-error3, .popup-error4').hide();
                                    });
                                    
                                    $('.close-submit2').click(function(evt){
                                         var value10 = $.trim($(".env-name<?php echo $i?>").val());
                                         if(value10.length === 0) {
                                            $('.popup-error1').show();
                                            evt.preventDefault();
                                         }
                                                                   
                                         var value12 = $.trim($(".env-price<?php echo $i?>").val());
                                         if(value12.length === 0) {
                                            $('.popup-error2').show();
                                            evt.preventDefault();
                                         }
                                         
                                         var value12 = $.trim($(".env-price<?php echo $i?>").val());
                                         if(!$.isNumeric(value12)) {
                                            $('.popup-error3').show();
                                            evt.preventDefault();
                                        }
                                        
                                         if ($('#addInventoryEditTrack-<?php echo $i?>').is(':checked')) {
                                             var value13 = $.trim($(".env-qty<?php echo $i?>").val());
                                             if(value13.length === 0) {
                                                $('.popup-error4').show();
                                                evt.preventDefault();
                                             }
                                         }
                                         
                                        $('#addnewunittype-<?php echo $i?>').modal('hide');
                                    });
                                    });             
                                </script>
                            </div>
                        </div>
                    </div>
            <!--end of pop-->
        
    <div id="newappend"></div>  
   <!--   End table part   -->
   
    <!--start of subtotal area -->
        <div class="row marginleftrightzero paddingbottom20 credit_note_style">
            <div class="col-sm-8 no-padding-right no-padding-left paddingtop15 marginright45new">
                <div class="btn btn-sm btn-success pull-left addbutton addunitpadding add-row">
                    <i class="icon-plus"></i>
                </div>
                <label class="addcontact">Add More</label>
            </div>
               <div class="col-sm-12 no-padding-right no-padding-left subtotal" id = "calculateFinal"> 
                <div class="row marginleftrightzero borderon padding_right5 padding_left_zero_subtotal">
                 <div class="row marginleftrightzero padding_right5 padding_left12_subtotal_row padding_right11_subtotal_row">
                   <span class="left bold">Subtotal</span>
                   <span class="right bold"><?php echo $this->Number->currency($creditNote['AcrClientCreditnote']['func_sub_total'], $defaultCurrencyCode); ?></span>
                    <?php echo $this->Form->hidden('subTotal',array('value'=>$creditNote['AcrClientCreditnote']['func_sub_total']));?>
                 </div>
                 <?php foreach($taxCalcuations as $key=>$val):?>
                    <div class="row marginleftrightzero padding_right5 padding_left12_subtotal_row padding_right11_subtotal_row">
                        <span class="left"><?php echo $val['taxName'];?></span>
                        <span class="right">
                            <?php echo $this->Number->currency($val['taxAmount'],$defaultCurrencyCode);?>
                            <?php echo $this->Form->hidden('AcrClientInvoice.taxValue.'.$key,array('value'=>$val['taxAmount']))?>
                        </span>
                    </div>
                <?php endforeach; ?>
                </div> 
                
                <div class="row marginleftrightzero borderon padding_right5 padding_left_zero_subtotal">
                 <div class="row marginleftrightzero padding_left12_subtotal_row padding_right11_subtotal_row">
                   <span class="left bold">Total</span>
                 </div>
                 <div class="row marginleftrightzero padding_right5 padding_left12_subtotal_row padding_right11_subtotal_row">
                   <span class="left">In Invoice Currency</span>
                   <span class="right bold statusopn">
                        <?php echo $this->Number->currency($creditNote['AcrClientCreditnote']['amount'],$creditNote['AcrClientCreditnote']['client_currency_code']);?>
                        <?php echo $this->Form->hidden('invoicetotal',array('value'=>$creditNote['AcrClientCreditnote']['amount']));?>
                        <?php echo $this->Form->hidden('invoice_currency_code',array('value'=>$creditNote['AcrClientCreditnote']['client_currency_code']));?>
                   </span>
                 </div>
                </div>
                <div class="row marginleftrightzero padding_right5 padding_left_zero_subtotal">
                 <div class="row marginleftrightzero padding_right5 padding_left12_subtotal_row padding_right11_subtotal_row">
                   <span class="left bold">Total</span>
                 </div>
                 <div class="row marginleftrightzero padding_right5 padding_left12_subtotal_row padding_right11_subtotal_row">
                   <span class="left">In Subscriber Currency</span>
                   <span class="right  bold statusopn">
                        <?php echo $this->Number->currency($creditNote['AcrClientCreditnote']['func_total'], $defaultCurrencyCode);?>
                        <?php echo $this->Form->hidden('subscribertotalEditQuote',array('value'=>$creditNote['AcrClientCreditnote']['func_total']));?>
                   </span>
                 </div>
                </div>
              </div>
           </div>
           
           <!--end of subtotal area -->
           
           <!--Popup mail items  -->
    <div class="modal fade" id="mail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog model-quotes">
            <div class="modal-content">
                <div class="modal-header page-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="icon-remove"></i>
                    </button>
                    <h1 class="modal-title bold" id="myModalLabel">Send Credit Note</h1>
                </div>
                    <div class="form-horizontal popup">
                    <div class="modal-body">
                        <div class="model-body-inner-content">
                            <div class="form-group login-form-group">
                                <p>
                                    Please select the Template to continue
                                </p>
                            </div>
                            <div class="form-group filed-left margin-bottom-zero drop-down choosen_width">
                                <?php echo $this->Form->input('email_template',array('class'=>'form-control invdrop','data-placeholder'=>'Email Templates','options'=>array('credit_product_classic'=>'Product Classic','credit_product_modern'=>'Product Modern','credit_service_classic'=>'Service Classic','credit_service_modern'=>'Service Modern'),'div'=>FALSE,'label'=>FALSE));?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success addbutton left marginleftzero  marginright4 padding0 sendnow" title="Preview" data-toggle="modal" data-target="#preview">
                            <i class="icon-zoom-in bigger-110"></i> Preview
                        </button> 
                        <?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'previewpopup btn btn-success addbutton left marginleftzero marginright4 padding0','url' => array('controller'=>'CreditNotes','action'=>'preview'),'style'=>'display:none;','escape'=>false,'update' => '#preview-template'));?>
                        <?php echo $this->Form->button('<i class="icon-share-alt bigger-110"></i> Send',array('escape'=>FALSE,'class'=>'btn btn-info left marginleftzero marginright4 padding0','type'=>'submit', 'name' => 'quotation_status', 'value' => 'Open'));?>
                        <?php echo $this->Form->button('<i class="icon-remove bigger-110"></i> Cancel',array('escape'=>FALSE,'class'=>'btn left marginleftzero popup-cancel marginright4 padding0','type'=>'button'));?>
                    </div>
                    </div>
            </div>
        </div>
    </div>
    <!--end of pop-->
            
        <div class="row marginleftrightzero paddingbottom20 footerbutton">
            <div class="clearfix form-actions margintopzero paddingtopzero no-padding-left no-padding-right">
                <div class="col-md-offset-0 col-md-12">
                    <button class="btn btn-info button_mobile" title="Send Now" data-toggle="modal" data-target="#mail">
                        <i class="icon-share-alt bigger-110"></i> Send Now
                    </button>
                    <?php echo $this->Form->button('<i class="icon-save bigger-110"></i> Save Credit Note',array('escape'=>FALSE,'class'=>'btn btn-info saveQuote button_mobile','type'=>'submit'));?>
                    <div class="btn btn-inverse anchaorcolor button_mobile">
                        <?php echo $this->Html->link('<i class="icon-remove bigger-110"></i> Cancel',array('Controller'=>'CreditNotes','action'=>'index',$customer, $min, $max, $status, $from, $to, 'page:'.$page),array('class'=>'','escape'=>FALSE));?>
                    </div>
                </div>
            </div>
        </div>
</div>
<!--Popup preview items  -->
<div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div  class="modal-dialog model-quotes" style="width:927px;">
         <div class="modal-content">
            <div class="modal-header page-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
            </div>
            <div id="preview-template" style="float:left;width:100%;">
                
            </div>
        </div>  
     </div>
</div>
<!--end of pop-->
<script>
    $(document).ready(function(){
        if($('.selectpicker').length){
             $('.selectpicker').selectpicker({
            });     
        } 
    });
</script>
<script>
    <?php if($apply && $invoiceIDDD) {?>
        
        $(window).load(function(){
            $("#customerLabel").trigger('click');
            $("#customerID").trigger('click');
        });
        jQuery(function($) {
            <?php $this->Js->get('#customerID')->event('click',$this->Js->request(array('action'=>'customerDetails'), array( 'update'=>"#updateCustomerDetail", 'async'=>FALSE, 'dataExpression'=>true, 'method'=>'post',
                        'data'=>$this->Js->serializeForm(array('isForm'=>false,'inline'=>true))
                )));
                $this->Js->get('#customerID')->event('click',$this->Js->request(array('action'=>'customerCurrency'), array( 'update'=>"#currencyUpdatee", 'async'=>FALSE, 'dataExpression'=>true, 'method'=>'post',
                        'data'=>$this->Js->serializeForm(array('isForm'=>false,'inline'=>true))
                )));
                $this->Js->get('#customerID')->event('click',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'currencyInfo'), 
                    array( 'update'=>'#invoiceCurrency', 'async'=>FALSE, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>FALSE,'inline'=>true)))));
             ?>
            
            $('#customerLabel').click(function(){
                $('#customerID').find('option').each(function(){
                    if($(this).val()==<?php echo $customerIDParam;?>) {
                        $(this).attr('selected','selected');
                        var selectedtext = $(this).text();
                        $('#customerID').next().find('span.filter-option').text(selectedtext);
                        $('#customerID_chosen').find('.chosen-drop');
                    }
                });
            });
        });
    <?php }?>
</script>
<script type="text/javascript">

    $(document).ready(function(){
    	
    	/* choosen select*/
			var config = {
				  
				  '.invdrop' : {search_contains:true}
				}
				for (var selector in config) {
				  $(selector).chosen(config[selector]);
			}
		/* choosen select*/
    	
        //$('#customerID option').find('12124');
        
        //$('#customerID option').val('12124').attr('selected','selected');
        
        var rowcount = 2;
        $('body').on('click','.addcontact',function(){
        $( ".add-row" ).trigger( "click" );
        });
        $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
        $(this).prev().focus();
        });
        
        $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
         
         $('body').on('click','.add-row',function(){
            var d = new Date();
            var n = d.getTime();
            $.ajax({
                    type: "POST",
                    dataType: 'html',
                    cache: false,
                    url: "<?php echo $this->webroot; ?>acr_client_invoices/addmore?rowcount="+rowcount,
                    data: {
                        rowcount: rowcount,
                    },
                    success: function (data) {               
                              $('#newappend').append(data).fadeIn('slow');
                    }
                })
                rowcount++;
            });
    });

 
    $(document).ready(function(){
        $('body').on('click','.selectitem .dropdown-menu li',function(){
            var thisvalue = $('.selectitem .btn .filter-option').text();
            if (thisvalue=="Customer"){
                 $(this).parents('.btn-group').siblings('label.error').show();
               }
               else{
                  $(this).parents('.btn-group').siblings('label.error').hide();
               }
        });    
        if($('.selectpicker').length){
            $('.selectpicker').selectpicker({ });
        }
        $('.sendnow').click(function(){
            $('.previewpopup').trigger('click')
        });
        
        <?php if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
            $protocol_final = 'https';
        } else {
            $protocol_final = 'http';
        } ?>
        
        
        $.validator.addMethod("checkCreditNoAvailability",function(value,element){               
            var x= $.ajax({
                url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>CreditNotes/checkCreditNo/<?php echo $subscriberID.'/'.$creditNote['AcrClientCreditnote']['id'];?>/",
                type: 'POST',
                async: false,
                data: $("#CreditNotes").serialize()
             }).responseText;       
             if(x=="true") return false;
             else return true;
        },"Credit no already exist.");
        
        $("#CreditNotes").validate({
            onkeyup: false,
            ignore:[],          
            rules: {
                'data[AcrClientInvoice][credit_no]' : {
                    required : true,
                    checkCreditNoAvailability : true
                },
                'data[AcrClientInvoice][acr_client_id]': { 
                   required : true
                 }, 
                 'data[AcrClientInvoice][issueDate]' : {
                    required : true
                 },
                 'data[AcrClientInvoice][conversionValue]':{
                    required : true,
                    number   : true
                }
                 
            },
            messages: {
                'data[AcrClientInvoice][credit_no]' : {
                    required : 'Please enter credit no.'
                },
                'data[AcrClientInvoice][acr_client_id]':  { 
                   required : 'Please select a customer.'
                 }, 
                 'data[AcrClientInvoice][issueDate]' : {
                    required : 'Please enter invoice date.'
                 },
                 'data[AcrClientInvoice][conversionValue]':{
                    required : 'Please enter a conversion value.',
                    number   : 'Conversion value should be numeric.'
                }
            }
        });
        /*$('.saveQuote').click(function(e){          
                    $("#SlsQuotation").validate().element('#conversionValue');
                    e.preventDefault();
        });*/ 
            
    }); 
    
</script>
<?php echo $this->Js->writeBuffer();?>