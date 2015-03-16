<?php 
    echo $this -> Session -> flash();
    $homeLink = $this -> Breadcrumb -> getLink('Home');
    $dbFormat = array("d", "M", "Y");
    $scriptFormat   = array("dd", "mm", "yyyy");
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
        	
           <?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',$this->request->referer(),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
        </div>
    </div>
    <!-- /.page-header -->
    <?php echo $this->Form->create('AcrClientInvoice',array('id'=>'CreditNotes','class'=>'form-horizontal formdetails','role'=>'form','inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control')));?>
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
            <div class="row marginleftrightzero ">
                <div class="form-group filed-left drop-down marginleftrightzero form-dropdown relative">
                    <label id="customerLabel" class="col-sm-3 control-label marginleftrightzero paddingleftrightzero">Customer<em style="color:#ff0000;">&lowast;</em></label>
                    <div class="col-sm-6 marginleftrightzero paddingleftrightzero labelerror choosen_width">
                        <?php
                            if($apply && $invoiceIDDD) {
                              echo $this->Form->hidden('acr_client_id',array('value'=>$customerIDParam));  
                              echo $this->Form->input('acr_client_id',array('id'=>'customerID','class'=>'invdrop','options'=>array(''=>'',$customers),'data-placeholder'=>'Select Customers','data-live-search' => 'true','disabled'=>TRUE));
                            } else {
                               echo $this->Form->input('acr_client_id',array('id'=>'customerID','class'=>'invdrop','options'=>array(''=>'',$customers),'data-placeholder'=>'Select Customers','data-live-search' => 'true'));
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
                    <div id="currencyUpdatee" class="col-sm-2 col-xs-3 marginleftrightzero paddingleftrightzero">
                        <?php 
                            echo $this->Form->input('cpn_currency_id',array('id'=>'currencySelect','options'=>array(''=>'',$currencyList),'default'=>$defaultCurrency,'data-live-search' => 'true', 'class'=>'invdrop form-control','data-placeholder'=>"Select Currency",'disabled'=>TRUE));
                            $this->Js->get('#currencySelect')->event('change',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'currencyInfo'), array( 'update'=>'#invoiceCurrency', 'async'=>true, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>true,'inline'=>true)))));
                            $this->Js->get('#currencySelect')->event('change', $this->Js->request(array ('controller' => 'acr_client_invoices','action' => 'calculateTotal',1), array ('update' => '#calculateFinal','async' => true,'dataExpression' => true,'method' => 'post','data' => $this->Js->serializeForm(array ('isForm' => false,'inline' => true)))));
                        ?>
                    </div>
                        <div id="invoiceCurrency"> </div>
                <!-- </div> -->
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
    <div class="row marginleftrightzero table-responsive table-responsivenoscroll overflowvisible tablehidemobilee new_table_responsive">
        <table id="quote-table" class="table table-striped table-bordered table-hover editable-table margin-bottom-zero">
            <thead>
                <tr class="borderblue">
                    <th class="width180">Item</th>
                    <th class="width300">Item Description</th>
                    <th class="width120">Qty</th>
                    <th class="width120 ">Unit Price</th>
                    <th class="width120 ">Discount %</th>
                    <th class="width150">Tax</th>
                    <th class="width150 ">Amount</th>
                    <th class="width65"><?php echo __('Action'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr id="inventoryUpdateSelect-1">
                    <td id="td-inventoryUpdateSelect-1">
                        <div class="modal fade" id="addnewunittype-" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog addunittype">
                                <div class="modal-content">
                                    <div class="modal-header page-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                            <i class="icon-remove"></i>
                                        </button>
                                        <h1 class="modal-title" id="myModalLabel"><?php echo __('Add Inventory');?></h1>
                                    </div>
                                    <?php /*echo $this->Form->create('addInventory',array('id'=>'addInventory','role'=>'form','class'=>'form-horizontal popup'));*/?>
                                        <div class="modal-body">
                                            <div class="model-body-inner-content">
                                                <div class="addtype-wrapper">
                                                    <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Name');?> <em style="color:#ff0000;">∗</em></label>
                                            <div class="col-sm-8">
                                                <?php echo $this->Form->input('addInventory.name-',array('div'=>false,'label'=>false,'autocomplete'=>'off','class'=>'col-xs-10 env-name col-sm-5 form-control','type'=>'text','id'=>'form-field-1','Placeholder'=>'Inventory name'));?>
                                                <p class="popup-error1">Please enter inventory name.</p>
                                            </div>
                                        </div>
                                        <div class="space-4"></div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Description');?> </label>
                                            <div class="col-sm-8">
                                                <?php echo $this->Form->input('addInventory.description-',array('div'=>false,'label'=>false,'autocomplete'=>'off','type'=>'textarea','rows'=>'2','class'=>'form-control col-xs-10 env-desc col-sm-5 itemdescription','id'=>'form-field-2','Placeholder'=>'Description of the inventory','maxlength'=>'55'));?>
                                                
                                            </div>
                                        </div>
                                        <div class="space-4"></div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('List Price');?> <em style="color:#ff0000;">∗</em></label>
                                            <div class="col-sm-8">
                                                <span>
                                                    <?php echo $this->Form->hidden('addInventory.currency-',array('value'=>$defaultCurrency));?>
                                                    <?php echo $this->Form->input('addInventory.code-',array('label'=>false,'div'=>false,'type'=>'text','id'=>'form-field-3','class'=>'form-control width30 col-xs-10 col-sm-5','value'=>$defaultCurrencyCode,'readonly'=>'readonly'))?>
                                                </span>
                                                <span>
                                                    <?php echo $this->Form->input('addInventory.list_price-',array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-field-3','class'=>'col-xs-10 price-field env-price width70 col-sm-5 form-control','style'=>'width:37%','Placeholder'=>'Inventory price'));?>
                                                    
                                                </span>
                                                <p class="popup-error2">Please enter inventory price.</p>
                                            </div>
                                        </div>
                                        <div class="space-4"></div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo 'Tax/Tax Group';?> </label>
                                            <div class="col-sm-8 choosen_width">
                                                <?php echo $this->Form->input('addInventory.tax_inventory-',array('div'=>false,'label'=>false,'class'=>'form-control col-xs-10 col-sm-5 invdrop','data-placeholder'=>"Select Tax",'options'=>array(''=>'',$taxList)));?>
                                            </div>
                                        </div>
                                        <div class="space-4"></div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Unit Type');?> </label>
                                            <div class="col-sm-8 choosen_width" id ="unit-type">
                                                <?php echo $this->Form->input('addInventory.unitType-',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control invdrop','data-placeholder'=>"Select",'options'=>array(''=>'',$unitTypeList)));?>
                                            </div>
                                            
                                        </div>
                                        <div class="space-4"></div>
                                        <div class="form-group" >
                                            <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Track Item Quantities');?></label>
                                            <div class="col-sm-8">
                                                <label>
                                                    <?php echo $this->Form->checkbox('addInventory.track-',array('div'=>false,'label'=>false,'class'=>'ace','id'=>'inventoryCheckBox'));?>
                                                    <span class="lbl"></span> </label>
                                                <label class="maillabel">Yes</label>
                                            </div>
                                        </div>
                                        <div class="space-4"></div>
                                        <div class="form-group currentstock" style="display: none;">
                                            <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Current Stock');?>  <em style="color:#ff0000;">∗</em></label>
                                            <div class="col-sm-8">
                                                <?php echo $this->Form->input('addInventory.current_stock-',array('div'=>false,'label'=>false,'autocomplete'=>'off','type'=>'text','class'=>'form-control env-qty col-xs-10 col-sm-5','id'=>'form-field-4','Placeholder'=>'Quantity of inventory  in stock'));?>
                                            <p class="popup-error3">Please enter current Stock.</p>
                                            </div>
                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer paddingright8">
                                            <?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info close-submit4','url' => array('controller'=>'inventories','action'=>'addInventory'),'escape'=>false,'update' => '#td-inventoryUpdateSelect-1','tag'=>'<i class="icon-ok bigger-110"></i>'));?>
                                            <button class="btn close-popup btn-inverse" type="button">Cancel</button>
                                        </div>
                                        
                                        
                                        <script>
                                        $(document).ready(function() {
                                        	$(".invdrop option:contains('|--')").remove();
                                            $('#addnewunittype-<?php echo $rowId;?>').on('show.bs.modal', function (e) {
                                                    $('.env-name, .env-price, .env-desc, .env-qty').val('');
                                                    $('.popup-error1, .popup-error2, .popup-error3').hide();
                                                });
                                                $( ".env-name, .env-price, .env-qty" ).focus(function() {
                                                    $('.popup-error1, .popup-error2, .popup-error3').hide();
                                                });
                                                
                                                $('.close-submit4').click(function(evt){
                                                     
                                                     var value7 = $.trim($(".env-name").val());
                                                     
                                                     if(value7.length === 0) {
                                                        $('.popup-error1').show();
                                                        evt.preventDefault();
                                                        $('#field').value();
                                                     }                          
                                                   
                                                     var value9 = $.trim($(".env-price").val());
                                                     if(value9.length === 0) {
                                                        $('.popup-error2').show();
                                                        evt.preventDefault();
                                                        $('#field').value();
                                                     }
                                                     
                                                     if ($('#inventoryCheckBox').is(':checked')) {
                                                     var value10 = $.trim($(".env-qty").val());
                                                     if(value10.length === 0) {
                                                        $('.popup-error3').show();
                                                        evt.preventDefault();
                                                        $('#field').value();
                                                     }
                                                     }
                                                    $('#addnewunittype-').modal('hide');
                                                });
                                                });             
                                            </script>
                                    <?php /*echo $this->form->end();*/?>
                                </div>
                            </div>
                        </div>
                        <!--end of pop-->
                        
                    <div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero">
                        <div class="col-sm-10 marginleftrightzero paddingleftrightzero ">
                            <?php 
                                echo $this -> Form -> input('AcrClientInvoice.inventory.1', array('id' => 'inventory-1', 'div' => false, 'data-live-search'=>'true','label' => false, 'class'=>'invdrop form-control','data-placeholder'=>"Select inventory",'options' => array('' => '','-1'=>'Non Inventory Item', $inventoryList)));
                                $this -> Js -> get('#inventory-1') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getInventoryDetails', 1), array('update' => '#inventoryUpdateSelect-1', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
                            ?>
                            <?php $this->Js->get('#inventory-1')->event('change', $this->Js->request(array ('controller' => 'acr_client_invoices','action' => 'calculateTotal',1), array ('update' => '#calculateFinal','async' => true,'dataExpression' => true,'method' => 'post','data' => $this->Js->serializeForm(array ('isForm' => false,'inline' => true)))));?>
                        </div>
                        <div class="col-sm-2 marginleftrightzero paddingleftrightzero paddinglefttop4">
                                <div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype additem-to-select"  data-toggle="modal" data-target="#addnewunittype-">
                                <i class="icon-plus"></i>
                            </div>
                        </div>
                    </div></td>
                    <td>
                    <div class="form-group marginleftrightzero margin-bottom-zero">
                        <textarea class="col-sm-12 tabletextarea" disabled="disabled"></textarea>
                    </div></td>
                    <td>
                    <div class="form-group marginleftrightzero margin-bottom-zero">
                        <input type="text" class="col-xs-10 col-sm-5 form-control textright"  disabled="disabled"/>
                    </div></td>
                    <td>
                    <div class="form-group marginleftrightzero margin-bottom-zero">
                        <input type="text"  class="col-sm-10 form-control textright"  disabled="disabled"/>
                    </div></td>
                    <td>
                    <div class="form-group marginleftrightzero margin-bottom-zero">
                        <input type="text"  class=" col-xs-10 col-sm-5 form-control textright" disabled="disabled"/>
                    </div></td>
                    <td>
                    <div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero">
                        <div class="col-sm-12 marginleftrightzero paddingleftrightzero">
                            <select class="chosen-select"  data-placeholder="None" disabled="disabled">
                                <optgroup label="Taxes">
                                    <option>Select Tax</option>
                                    <option>PST[15%]</option>
                                </optgroup>
                                <optgroup label="TAx Group">
                                    <option>Test Tax Group1[15%]</option>
                                    <option>Test Tax Group2[25%]</option>
                                    <option>Test Tax Group3[35%]</option>
                                </optgroup>
                            </select>
                        </div>
                    </div></td>
                    <td>
                    <div class="form-group marginleftrightzero margin-bottom-zero">
                        <input type="text"  class="col-xs-10 col-sm-5 form-control textright"  disabled="disabled"/>
                    </div></td>
                </tr>

            </tbody>
        </table>
    </div>

    <div class="row marginleftrightzero paddingbottom20 credit_note_style">
        <div class="col-sm-8 no-padding-right no-padding-left paddingtop15 marginbottom2p">
            <div class="btn btn-sm btn-success pull-left addbutton addunitpadding add-row">
                <i class="icon-plus"></i>
            </div>
            <label class="addcontact">Add More</label>
        </div>
        <div id="calculateFinal" class="col-sm-4 no-padding-right no-padding-left subtotal newsubtotal">
            <div class="row marginleftrightzero borderon  padding_left_zero_subtotal ">
                <div class="row marginleftrightzero  padding_left12_subtotal_row padding_right11_subtotal_row">
                    <span class="left bold">Subtotal</span>
                    <span class="right bold">0.00</span>
                </div>
            </div>
            <div class="row marginleftrightzero borderon  padding_left_zero_subtotal">
                <div class="row marginleftrightzero padding_left12_subtotal_row padding_right11_subtotal_row">
                    <span class="left bold">Total</span>
                </div>
                <div class="row marginleftrightzero  padding_left12_subtotal_row padding_right11_subtotal_row">
                    <span class="left">In Invoice Currency</span>
                    <span class="right bold statusopn">0.00</span>
                </div>
            </div>
            <div class="row marginleftrightzero  padding_left_zero_subtotal">
                <div class="row marginleftrightzero  padding_left12_subtotal_row padding_right11_subtotal_row">
                    <span class="left bold">Total</span>
                </div>
                <div class="row marginleftrightzero  padding_left12_subtotal_row padding_right11_subtotal_row">
                    <span class="left">In Subscriber Currency</span>
                    <span class="right  bold statusopn">0.00</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row marginleftrightzero borderblue paddingbottom20 linewidth"></div>
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


    <div class="row marginleftrightzero paddingbottom20 bottom_button create_credit_btn">
        <div class="clearfix form-actions margintopzero paddingtopzero no-padding-left no-padding-right">
            <div class="col-md-offset-3 col-md-6">
                <button class="btn btn-info" title="Send Now" data-toggle="modal" data-target="#mail">
                    <i class="icon-share-alt bigger-110"></i> Send Now
                </button>
                <?php echo $this->Form->button('<i class="icon-save bigger-110"></i> Save Credit Note',array('escape'=>FALSE,'class'=>'btn btn-info saveQuote','type'=>'submit'));?>
                <button type="reset" class="btn btn-inverse">
                    <i class="icon-undo bigger-110"></i> Reset
                </button>
            </div>
        </div>
    </div>

</div>
<!-- /.page-content -->



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
	
	$('.btn-inverse').click(function(ev){
    ev.preventDefault();
	    $('#customerID_chosen .chosen-container-active').remove();
	    $('form').trigger('reset');
	    $('#customerID_chosen .chosen-drop ul li').remove();
	    $('#customerID_chosen span').text('Select');
  	});
  
	
	$('body').on('click','#inventoryCheckBox',function(){
		if($('#inventoryCheckBox').is(":checked"))
		{
			$('.currentstock').show();
		}
		else{
			$('.currentstock').hide();
		}
	});

});
    jQuery(function($) {
        $('#spinner1').ace_spinner({value:1,min:1,max:200,step:1, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
        .on('change', function(){});
         $('#spinner2').ace_spinner({value:1,min:1,max:200,step:1, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
        .on('change', function(){});        
         $('#spinner3').ace_spinner({value:1,min:1,max:200,step:1, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
        .on('change', function(){});        
         $('#spinner4').ace_spinner({value:1,min:1,max:200,step:1, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
        .on('change', function(){});                
    });
    jQuery(function($) {
        $(".chosen-select").chosen();
    });
    
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
                        $('#customerID').next().find('span').text(selectedtext);
                        $('#customerID_chosen').find('.chosen-drop');
                    }
                });
            });
        });
    <?php }?>
    $(document).ready(function(){
    	$('.popup-cancel').click(function(){
	     	$('.close').trigger('click');
	    });
    	$('.close-popup').click(function(){
	     	$('.close').trigger('click');
	    });
    	
    	
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
		                      $('#quote-table tbody').append(data).fadeIn('slow');
		            }
		        })
		        rowcount++;
		    });
    });
    
    $('body').on('click','.remove-row',function(){
      $(this).parents('tr').remove();
    });
</script>


<script type="text/javascript"> 
$(function() {
	$( "#customerID" ).change(function() {
		$('.labelerror .error').hide();
	});

	var config = {
	  '#customerID' : {search_contains:true},
	  '.invdrop' : {search_contains:true}
	}
	for (var selector in config) {
	  $(selector).chosen(config[selector]);
	}
});
    $(document).ready(function(){
        //alert("s");
        $('body').on('click','.selectitem .dropdown-menu li',function(){
          var thisvalue = $('.selectitem .btn .filter-option').text();
            if (thisvalue=="Customer")
               {
                 $(this).parents('.btn-group').siblings('label.error').show();
               }
               else{
                  $(this).parents('.btn-group').siblings('label.error').hide();
               }
         });    
            if($('.selectpicker').length){
                  $('.selectpicker').selectpicker({
                   });
           
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
                url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>CreditNotes/checkCreditNo/<?php echo $subscriberID;?>",
                type: 'POST',
                async: false,
                data: $("#CreditNotes").serialize()
             }).responseText;       
             if(x=="true") return false;
             else return true;
        },"Credit no already exist.");
         
        $('.selectpicker').selectpicker().change(function(){
        	$(this).valid()
		});
		
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
        $('.saveQuote').click(function(e){          
                    $("#SlsQuotation").validate().element('#conversionValue');
                    e.preventDefault();
        });     
    }); 
    
var goup;
$scrollup=function(){	
     var scrollHeight=$('.error:visible:first').css('top');
	 $('html, body').animate({scrollTop: scrollHeight}, "slow");
	 if($('.error').length>0){
	  clearInterval(goup);
     }			 
	}
	$(document).ready(function(){
	$('body').on('click','.saveQuote',function(){
	   goup =setInterval( $scrollup,1);
	  });
	});
</script>
<?php echo $this->Js->writeBuffer();?>