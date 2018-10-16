<script type="text/javascript">
    function resend_otp() {
        $.ajax({
            type: "POST",
            data: {"<?php echo $this->security->get_csrf_token_name(); ?>": csrfHash},
            url: "<?php echo $this->common_model->getUrl("pages", "2", "94", ''); ?>/resend_otp",
            success: function (Data)
            {
                $('#otpmsg').html("OTP sent again!");
            }
        });

    }
    $(document).ready(function () {

        $('#show_modal').click(function () {
            $('#flow-popup').modal({dismissible: true});
            $('#flow-popup1').modal('open');
        });


        $("#Frmotp").validate({
            ignore: [],
            rules: {
                varOTP: {
                    required: true
                }
            },
            messages: {
                varOTP: {
                    required: "Please enter otp."
                }
            },
            errorPlacement: function (error, element) {
//                if ($(element).attr('id') == 'varOTP') {
//                    error.appendTo('#varOTPError');
//                }
//                else {
//                    error.insertAfter(element);
//                }
            },
            submitHandler: function (form) {
                var varOTP = $('#varOTP').val();
                $.ajax({
                    type: "POST",
                    data: {"<?php echo $this->security->get_csrf_token_name(); ?>": csrfHash, 'varOTP': varOTP},
                    url: "<?php echo $this->common_model->getUrl("pages", "2", "94", ''); ?>/send_otp",
                    success: function (Data)
                    {
                        if (Data == 1) {
//                            form.submit();
                            $('#flow-popup').modal({dismissible: false});
                            $('#flow-popup').modal('open');
//                            document.getElementById('close-all').style.display = 'none';

                        } else {
                            $('#otpmsg').html("Oops! you entered wrong OTP.");
                        }
                    }
                });
            }
        });
    });


//    function openmodel() {

//    }

</script>

<div class="register-info">
    <div class="register-inner card">      
        <?php
        $attributes = array('name' => 'Frmotp', 'id' => 'Frmotp', 'enctype' => 'multipart/form-data', 'class' => 'register-form', 'method' => 'post');
        $action = $this->common_model->getUrl("pages", "2", "89", '') . "/update_verification";
        echo form_open($action, $attributes);
        $UserData = $this->common_model->getUserData(USER_ID);
        ?>

        <div class="col m12 s12 padding">
            <div class="other-info-user">
                <div class="col m6 s12 padding margin-bottom"> 
                    <h1>OTP Verification</h1>
                    <div class="col m12 s12"><h6>Please enter the OTP sent to your Mobile Number<sup>*</sup></h6></div> 

                    <div class="col m12 s12">
                        <div class="input-field field-custom">

                            <input id="varOTP" name='varOTP' type="text" value="<?php echo $UserData['varOTP']; ?>">
                            <label for="varOTP">OTP<sup>*</sup></label>
                        </div>
                        <div id='otpmsg'></div>
                    </div>

                    <div class="col m12 s12">
                        <div class="register-submit all-same">
                            <a href="javascript:;" onclick="return resend_otp();" class="waves-effect waves-light btn same-btn">Resend Otp</a>
                            <button class="waves-effect waves-light btn same-btn">Submit</button>
                        </div>
                    </div> 

                </div>
                <div class="col m6 s12">
                    <div class="otp-image">
                        <img src="<?php echo FRONT_MEDIA_URL; ?>images/otp.png" alt="otp-send">
                    </div>
                </div>
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>


<div id="flow-popup" class="modal modal-fixed-footer get-quot-popup flow-popup-all">

    <div class="modal-content">

        <div class="quot-content row">
            <div class="flow-find">
                <div class="check_mark">
                    <div class="sa-icon sa-success animate">
                        <span class="sa-line sa-tip animateSuccessTip"></span>
                        <span class="sa-line sa-long animateSuccessLong"></span>
                        <div class="sa-placeholder"></div>
                    </div>
                </div>
            </div>
            <div class="flow-detail">
                <h6 style="font-size: 15px;">Hello, <?php echo $getUserData['varName']; ?>. Welcome aboard.<br>To Create Presence of your business among millions of others, let's build an amazing virtual profile.</h6>
            </div>
        </div>
    </div>
    <div class="modal-footer submit-footer flow-btn">
        <?php $getProfileUrl = $this->common_model->getUrl("pages", "2", "95", ''); ?>
        <a href="<?php echo $getProfileUrl; ?>" class="waves-effect waves-blue btn-flat get-submit-design">Complete my profile</a>
        <a href="javascript:;" id="show_modal" class="waves-effect waves-blue btn-flat get-submit-design">Skip for Now</a>
    </div>
</div>

<div id="flow-popup1" class="modal modal-fixed-footer get-quot-popup flow-popup-all">

    <div class="modal-content">

        <div class="quot-content row">
            <div class="flow-find red">
                <div class="check_mark">
                    <div class="sa-icon sa-success animate">
                        <span class="sa-line sa-tip animateSuccessTip"></span>
                        <span class="sa-line sa-long animateSuccessLong"></span>
                        <div class="sa-placeholder"></div>
                    </div>
                </div>
            </div>
            <div class="flow-detail">
                <h6 style="font-size: 15px;">Your company profile is not ready yet!<br>
                    A genuine company profile with necessary information can increase the possibility of higher priority of your company name in search results and listings.</h6>
            </div>
        </div>
    </div>
    <div class="modal-footer submit-footer flow-btn">
        <?php $getProfileUrl = $this->common_model->getUrl("pages", "2", "95", ''); ?>
        <a href="<?php echo $getProfileUrl; ?>" class="waves-effect waves-blue btn-flat get-submit-design red">Complete my profile</a>
        <a href="<?php echo SITE_PATH; ?>" class="waves-effect waves-blue btn-flat get-submit-design red">Take Me Home</a>
    </div>
</div>