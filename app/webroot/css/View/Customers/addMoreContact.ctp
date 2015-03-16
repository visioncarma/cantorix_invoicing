<div class="col-sm-12 contactdetails paddingleftrightzero">
          <h5>Contact 1 Details</h5>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Contact Name </label>

            <div class="col-sm-10">
                <?php echo $this->Form->input('name',array('id'=>'form-field-1','div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-10 col-sm-5'));?>  
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Contact Surname </label>

            <div class="col-sm-10">
                <?php echo $this->Form->input('sur_name',array('id'=>'form-field-1','div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-10 col-sm-5'));?>  
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Contact Email </label>

            <div class="col-sm-10">
                <?php echo $this->Form->input('cpn_language_id',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-10 col-sm-5','options'=>array(''=>'Select',$languages)));?>  
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Mobile </label>

            <div class="col-sm-10">
                <?php echo $this->Form->input('cpn_language_id',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-10 col-sm-5','options'=>array(''=>'Select',$languages)));?>  
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Home Phone </label>

            <div class="col-sm-10">
                <?php echo $this->Form->input('cpn_language_id',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-10 col-sm-5','options'=>array(''=>'Select',$languages)));?>  
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Work Phone </label>

            <div class="col-sm-10">
                <?php echo $this->Form->input('cpn_language_id',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-10 col-sm-5','options'=>array(''=>'Select',$languages)));?>  
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Primary</label>        
            <div class="col-sm-10">
                <label>
                     <input class="ace" type="checkbox">
                       <span class="lbl"></span>
                 </label>
                 <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Please specify -1 for Unlimited" >?</span>
                 
            </div>
        </div>
        <div class="col-sm-12 borderline"></div>
        <div class="col-sm-12 paddingtopbottom2">
            <div class="col-sm-7"></div>
            <div class="col-sm-5">
            <a class="btn btn-sm btn-success pull-left addbutton" href="#">
                      <i class="icon-plus"></i>                                               
            </a>
            <label class="addcontact">Add Contact</label>
        </div>
        </div>