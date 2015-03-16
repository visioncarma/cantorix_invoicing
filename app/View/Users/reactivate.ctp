<div class="full_container">
    <div class="container">
        <div class="row paddingtb40">
            <div class="col-xs-12">
                <!--signup box starts-->
                <div class="login-container login-container-message payment-container">
                    <div class="position-relative">
                        <div class="signup-box widget-box no-border login-box visible widget-box no-border ">
                            <div class="widget-body ">
                                <div class="widget-main fontbig15 ">
                                    <h2 class="successthank">Welcome back!</h2>
                                    <p class="successmessage"> Dear valued customer,</p>
                                    <p class="successmessage"> Your CantoriX subscription has been cancelled! You can continue service by reactivating your subscription in just few steps.</p>
                                    <label class="block clearfix">
                                        <div class="loginwrapper sendme pull-right login100 ">
                                            <div class="right-inner-addon">
                                                <?php $currentPlan = $plan['CpnSubscriptionPlan']['type'].'-'.$plan['CpnSubscriptionPlan']['id'];?>
                                                <?php echo $this->Form->postLink('Continue',array('action'=>'paymentDetailRenewal',base64_encode($currentPlan)),array('class'=>'login100 pull-right btn btn-sm btn-success sendme','title'=> 'Continue','escape'=>FALSE));?>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div><!-- /widget-body -->
                        </div><!-- /signup-box -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>