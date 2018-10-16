<style>

    .error{

        color:#ce0000; 

    }

</style>



<script type="text/javascript">



    $(document).ready(function () {



        document.getElementById('acceptTerms').addEventListener('click', function (e) {

            document.getElementById('sub1').disabled = !e.target.checked;

        });



        $.validator.addMethod("passwordvalidation", function (value, element) {

            var myString = trim(document.getElementById('varPassword').value);

            if (myString != '') {

                var digitString = myString.replace(/[^0-9]/g, "").length;

                var charCapString = myString.replace(/[^a-z]/g, "").length;

                var charSmaString = myString.replace(/[^A-Z]/g, "").length;

                if (digitString < 1 || (charCapString < 1 && charSmaString < 1)) {

                    return false;

                } else {

                    return true;

                }

            } else {

                return true;

            }

        }, "<?php echo PASSWORD_VALID_VALIDATION ?>");



        $.validator.addMethod("Chk_Image_Size", function (users, value)

        {

            var flag = true;

            var selection = document.getElementById('varImage');

            for (var i = 0; i < selection.files.length; i++)

            {

                var file = selection.files[i].size;

                var FIVE_MB = Math.round(1024 * 1024 * 5);

                if (file > FIVE_MB)

                {

                    flag = false;

                }

            }

            return flag;

        }, 'Image size invalid');



        $.validator.addMethod("phonenumber", function (value, element) {

            var numberPattern = /\d+/g;

            var newVal = value.replace(/\D/g, '');

            if (parseInt(newVal) <= 0)

            {

                return false;

            } else

            {

                return true;

            }



        }, "Please enter a valid number.");



        $.validator.addMethod("noSpace", function (value, element) {

            return value.indexOf(" ") < 0 && value != "";

        }, "Please space is not allowed.");



        $("#FrmBuyerSeller").validate({

            ignore: [],

            rules: {

                varName: {

                    required: true

                },

                varCompany: {

                    required: true

                },

                varPhone: {

                    minlength: 5,

                    required: true,

                    maxlength: 10,

                    phonenumber: {

                        depends: function () {

                            if (($("#varPhone").val()) != '') {

                                return true;

                            } else {

                                return false;

                            }

                        }

                    }

                },

                varLocation: {

                    required: true

                },

                varAddress1: {

                    required: true

                },

//                varAddress2: {

//                    required: true

//                },

                varPassword:

                        {

                            required: true,

                            minlength: 8,

                            maxlength: 20,

                            passwordvalidation:

                                    {

                                        depends: function () {

                                            if ($("#varPassword").val() == '' && $("#PwdConfirmPassword").val() == '')

                                            {

                                                return false;

                                            } else

                                            {

                                                return true;

                                            }

                                        }

                                    }

                            //                    noSpace:true

                        },

                PwdConfirmPassword:

                        {

                            required: true,

                            minlength: 8,

                            maxlength: 20,

                            equalTo: "#varPassword"

                        },

                varEmail: {

                    email: true,

                    required: true

                },

                varImage: {

                    accept: "jpg,png,jpeg,gif",

//                    required: true,

                    Chk_Image_Size: {

                        depends: function () {

                            return true;

                        }

                    }

                },

                captchaimage1: {

                    required: {

                        depends: function () {

                            if (!/Android|iPhone|BlackBerry/i.test(navigator.userAgent))

                            {

                                return true;

                            } else {

                                return false;

                            }

                        }

                    },

                    equalTo: {

                        param: "#h_code",

                        depends: function () {

                            if (!/Android|iPhone|BlackBerry/i.test(navigator.userAgent))

                            {

                                return true;

                            } else

                            {

                                return false;

                            }

                        }

                    }

                }



            },

            messages: {

                captchaimage1: {

                    required: "Please enter the captcha code."

                }

            },

            errorPlacement: function (error, element) {

                if ($(element).attr('id') == 'varImage') {

                    error.appendTo('#varimageerror');

                } else if ($(element).attr('id') == 'captchaimage1')

                {

                    error.insertAfter($(".replacecaptcha"));

                }

            },

            submitHandler: function (form) {



                var User_Email = $('#varEmail').val();

                var User_Phone = $('#varPhone').val();

                $.ajax({

                    type: "GET",

                    url: "<?php echo $this->common_model->getUrl("pages", "2", "89", ''); ?>/Check_Email_Phone?User_Email=" + User_Email + "&User_Phone=" + User_Phone,

                    success: function (Data)

                    {

                        if (Data == 1) {

                            form.submit();

                        } else {

                            M.toast({html: 'Email/mobile you entered is already registered with Indibzz.'});

                            return false;

                        }

                    }

                });

            }

        });

    });

    function KeycheckOnlyNumeric(e)

    {

        var _dom = 0;

        _dom = document.all ? 3 : (document.getElementById ? 1 : (document.layers ? 2 : 0));

        if (document.all)

            e = window.event;

        var ch = '';

        var KeyID = '';

        if (_dom == 2) {

            if (e.which > 0)

                ch = '(' + String.fromCharCode(e.which) + ')';

            KeyID = e.which;

        } else

        {

            if (_dom == 3) {

                KeyID = (window.event) ? event.keyCode : e.which;

            } else {

                if (e.charCode > 0)

                    ch = '(' + String.fromCharCode(e.charCode) + ')';

                KeyID = e.charCode;

            }

        }

        if ((KeyID >= 97 && KeyID <= 122) || (KeyID >= 65 && KeyID <= 90) || (KeyID >= 33 && KeyID <= 39) || (KeyID == 42) || (KeyID >= 58 && KeyID <= 64) || (KeyID >= 91 && KeyID <= 96) || (KeyID >= 123 && KeyID <= 126))

        {

            return false;

        }

        return true;

    }





    function send_mobile_email()

    {

        var User_Email = $('#varEmail').val();

        var User_Phone = $('#varPhone').val();

        $.ajax({

            type: "GET",

            url: "<?php echo $this->common_model->getUrl("pages", "2", "89", ''); ?>/Check_Email_Phone?User_Email=" + User_Email + "&User_Phone=" + User_Phone,

            success: function (Data)

            {

                if (Data == 1) {

                    return 1;

                } else {

                    M.toast({html: 'Email/mobile you entered is already registered with Indibzz.'});

                    return 0;

                }

            }

        });

    }

</script>





<script>



    function refreshcaptcha(base) {

<?php $url = $this->common_model->getUrl("pages", "2", '89', ''); ?>

        var newdata;

        $.ajax({

            type: "GET",

            url: "<?php echo $url ?>/refershcaptcha",

            async: false,

            success: function (data)

            {

                var newdata = data.split("#");

                var src = newdata[0];

                $("#captchaImage img").attr('src', newdata[0]);

                $("#pin_img").val(newdata[1]);

                $("#h_code").val(newdata[1]);

            }

        });

    }

</script>



<div class="register-info">

    <div class="register-inner card"> 

        <?php

        $attributes = array('name' => 'FrmBuyerSeller', 'id' => 'FrmBuyerSeller', 'enctype' => 'multipart/form-data', 'class' => 'register-form', 'method' => 'post');

        $action = $this->common_model->getUrl("pages", "2", "89", '') . "/register_buyer";

        echo form_open($action, $attributes);

        ?>

        <div class="row">

            <div class="col m12 s12">

                <div class="col m4 s12 profile-up">

                    <div class="profile-upload-user">

                        <div class="user-photo1">                     

                            <div id="image-preview1">

                                <label for="varImage" id="image-label1"><i class="fas fa-camera"></i></label>

                                <input type="file" name="image" id="varImage" />

                            </div>

                        </div>  

                        <div id="varimageerror"></div>

                    </div>

                </div>



                <div class="col m8 s12 padding">

                    <h1>Supplier / Buyer</h1>

                    <div class="col m7 s7 full-name padding-left">

                        <div class="input-field field-custom">

                            <input id="varName" name="varName" type="text" value='<?php echo $_POST['varName']; ?>'  autocomplete="off">

                            <label for="varName" class="">Full Name<sup>*</sup></label>

                        </div>

                    </div>

                    <div class="col m5 s5 full-name padding">

                        <div class="input-field referralcode field-custom">

                            <input id="varReferralCode" name="varReferralCode" type="text" value='<?php echo $_POST['varReferralCode']; ?>'  autocomplete="off">

                            <label for="varReferralCode" class="">Referral Code</label>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col m12 s12 padding">

            <div class="other-info-user">

                <div class="col m12 s12">

                    <div id="regsiter_message"></div>

                </div>

                <div class="col m12 s12 padding password-fields"> 



                    <div class="col m6 s12 ">

                        <div class="input-field field-custom">

                            <input id="varCompany" name="varCompany" value='<?php echo $_POST['varCompany']; ?>' type="text" autocomplete="off">

                            <label for="varCompany" class="">Company Name<sup>*</sup></label>

                        </div>

                    </div>

                    <div class="col m6 s12">

                        <div class="input-field field-custom">

                            <input id="varEmail" name="varEmail" value="<?php echo $_POST['varEmail']; ?>" type="text" autocomplete="off">

                            <label for="varEmail">Email<sup>*</sup></label>

                        </div>

                    </div>  





                    <div class="col m6 s12">

                        <div class="input-field field-custom">

                            <input id="varPassword" name="varPassword" value="<?php echo $_POST['varPassword']; ?>" autocomplete="off" type="password">

                            <label for="varPassword">Password<sup>*</sup></label>

                        </div>

                        <div id="varPasswordError"></div>

                    </div> 

                    <div class="col m6 s12">

                        <div class="input-field field-custom">

                            <input id="PwdConfirmPassword" autocomplete="off" value="<?php echo $_POST['PwdConfirmPassword']; ?>" name="PwdConfirmPassword" type="password">

                            <label for="PwdConfirmPassword">Confirm Password<sup>*</sup></label>

                        </div>

                        <div id="PwdConfirmPasswordError"></div>

                    </div>

                    <div class="password-note"><strong>Note:</strong>&nbsp;Password should be in between 8 to 20 characters long and must contain at least one alpha bet and numeric.</div>

                </div>



                <div class="col m12 s12 padding street-add">

                    <div class="col m12 s12 location-fill">

                        <div class="input-field field-custom">

                            <input id="varLocation" placeholder="Search Location" autocomplete="off" name="varLocation" type="text">

                            <!--<label for="varLocation" class="">Location<sup>*</sup>-->

                            </label>

                        </div>

                    </div>

                    <div class="col m6 s12">

                        <div class="input-field field-custom area-height">

                            <textarea id="location" placeholder="Address*" name="varAddress1" class="materialize-textarea"></textarea>

                        </div>

                    </div>

                    <!--                    <div class="col m6 s12">

                                            <div class="input-field field-custom area-height">

                                                <textarea id="route" name="varAddress2"  placeholder="Street Address 2*" class="materialize-textarea"></textarea>

                                            </div>

                                        </div>-->

                    <div class="col m6 s12">

                        <div class="input-field field-custom">

                            <input id="locality" name="varCity" placeholder="City*" type="text">

                        </div>

                    </div>

                    <div class="col m6 s12">

                        <div class="input-field field-custom">

                            <input  name="varZipcode" id="postal_code" placeholder="Pincode*" type="text">

                            <!--<label for="postal_code">Pincode</label>-->

                        </div>

                    </div>



                    <div class="countrycode-mobile">

                        <div class="col m1 s2 padding-right">

                            <div class="input-field countrycode mobile-codec field-custom">

                                <input id="intCountryCode" name="intCountryCode" value="+91" readonly="" autocomplete="off" type="text" onkeypress="return KeycheckOnlyNumeric(event);">

                            </div>

                        </div>

                        <div class="col m5 s10 padding-left">

                            <div class="input-field field-custom register-phone">

                                <input id="varPhone" name="varPhone" value="<?php echo $_POST['varPhone']; ?>" maxlength="10" autocomplete="off" type="text" onkeypress="return KeycheckOnlyNumeric(event);">

                                <label for="varPhone">Mobile No<sup>*</sup></label>

                            </div>

                        </div>

                    </div>

                    <div class="col m6 s12">

                        <div class="input-field field-custom register-phone">

                            <input id="varTel" name="varTel" value="<?php echo $_POST['varTel']; ?>" autocomplete="off" type="text" onkeypress="return KeycheckOnlyNumeric(event);">

                            <label for="varTel">Telephone No</label>

                        </div>

                    </div> 



                    <input type="hidden" name="varState" id="administrative_area_level_1" >

                    <input type="hidden" name="varCountry" id="country" >

                    <input type="hidden" name="varLatitude" id="lat" >

                    <input type="hidden"  name="varLongitude" id="lon">



                    <!--<div class="col s12 m12">-->

                    <!--<div class="contect-send">-->

                    <div class="code" id="captchaImage"> 



                        <input type="button" class="no-click" readonly id="pin_img" value="<?php echo $generated_pin; ?>">

                        <a onclick="return refreshcaptcha('<?= base_url(); ?>');" title="Refresh" class="Refresh" href="javascript:;"><i class="fas fa-sync-alt"></i></a>

                        <div class="col m2 s4 captcha-note">

                            <div class="input-field field-custom"> 

                                <input type="text" autocomplete="off" maxlength="4" type="text" id="captchaimage1" name="captchaimage1" value="<?php echo set_value('captchaimage1'); ?>">

                                <label for="captchaimage1">Captcha</label>

                            </div>

                        </div>

                        <div class="col m2 s2"><div class="help-tooltip"><i class="fas fa-info-circle btn tooltipped" data-position="top" data-tooltip="Note: Please enter the captcha code exactly as mentioned in order to verify and continue."></i></div></div>

                        <input type="hidden" name="h_code" id="h_code" value="<?php echo $generated_pin; ?>" />



                        <div class="replacecaptcha" style="clear: both;"></div>



                        <?php echo form_error('captchaimage1', '<label class="error" for="captchaimage1">', '</label>') ?>



                        <div class="clearfix"></div>

                    </div>



                    <div class="col m6 s12 accept-terms">

                        <div class="input-field field-custom">

                            <label>

                                <input type="checkbox" id="acceptTerms" class="filled-in" />

                                <span></span>            

                            </label>

                            <a href="#terms-condition-popup" class="accept-popup modal-trigger">I accept terms & condition<sup>*</sup></a>

                        </div>

                    </div> 

                </div>

            </div>

        </div>



        <div class="col m12 s12">

            <div class="register-submit all-same">

                <button type="submit" disabled="" class="waves-effect waves-light btn same-btn" id="sub1">Submit</button>

            </div>

        </div>

        <?php echo form_close(); ?>

    </div>

</div>



<!-- on load popup -->

<div id="on_load_boxes" style="display:none;">

    <div id="dialog" class="window"><h5>Error</h5><hr>

        <div id="lorem">

            <p>Email/Mobile already registered with <?php echo SITE_NAME; ?>.</p>

        </div>

        <div id="popupfoot">

            <a href="javascript:;" class="close agree waves-effect waves-blue btn-flat"><i class="fas fa-times"></i></a> 

        </div>

    </div>

    <div class="onload-black" id="mask"></div>

</div>

<!-- end popup -->



<div id="terms-condition-popup" class="modal modal-fixed-footer get-quot-popup">

    <?php

    $content = $this->common_model->getContent(87);

    echo $content;

    ?>

    <div class="close-outside"><a href="javascript:;" class="modal-close waves-effect waves-blue btn-flat"><i class="fas fa-times"></i></a></div>

</div>



<div id="error-popup" class="modal modal-fixed-footer get-quot-popup">

    <h5>Email/Mobile No already registered.</h5>

    <div class="close-outside"><a href="javascript:;" class="modal-close waves-effect waves-blue btn-flat"><i class="fas fa-times"></i></a></div>

</div>

<div id="map"></div>

<script>

    function initMap() {

        var map = new google.maps.Map(document.getElementById('map'));

        var input = document.getElementById('varLocation');

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);



        var autocomplete = new google.maps.places.Autocomplete(input);



        autocomplete.addListener('place_changed', function () {

            var place = autocomplete.getPlace();

            if (!place.geometry) {

                window.alert("Autocomplete's returned place contains no geometry");

                return;

            }





            var address = '';

            if (place.address_components) {

                address = [

                    (place.address_components[0] && place.address_components[0].short_name || ''),

                    (place.address_components[1] && place.address_components[1].short_name || ''),

                    (place.address_components[2] && place.address_components[2].short_name || '')

                ].join(' ');

            }



            for (var i = 0; i < place.address_components.length; i++) {

                if (place.address_components[i].types[0] == 'postal_code') {

                    document.getElementById('postal_code').value = place.address_components[i].long_name;

                }

                if (place.address_components[i].types[0] == 'administrative_area_level_1') {

                    document.getElementById('administrative_area_level_1').value = place.address_components[i].long_name;

                }

                if (place.address_components[i].types[0] == 'locality') {

                    document.getElementById('locality').value = place.address_components[i].long_name;

                }

                if (place.address_components[i].types[0] == 'country') {

                    document.getElementById('country').value = place.address_components[i].long_name;







                    $.ajax({

                        type: "POST",

                        url: "<?php echo $this->common_model->getUrl("pages", "2", "89", '') . "/getcountrycode"; ?>",

                        data: {"country_id": place.address_components[i].short_name, csrf_indibizz: csrfHash},

                        success: function (Data)

                        {

                            document.getElementById("intCountryCode").value = Data;

                        }

                    });

                }

            }

            document.getElementById('location').value = place.formatted_address;

            document.getElementById('lat').value = place.geometry.location.lat();

            document.getElementById('lon').value = place.geometry.location.lng();

        });

    }

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY; ?>&libraries=places&callback=initMap&region=in" async defer></script>