<?php echo $this->Form->input('AcrClient.cpn_currency_id',array('id'=>'currencySelect','options'=>array(''=>'Select Currency',$currencyList),'default'=>$currencyID['AcrClient']['cpn_currency_id'],'class'=>'selectpicker form-control','data-placeholder'=>"Currency List"));?>