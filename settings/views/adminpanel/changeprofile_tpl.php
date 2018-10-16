<script type="text/javascript" src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>js/jquery.passstrength.js"></script>
<script type="text/javascript">
    $(document).ready(function ()
    {
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

        }, "<div class='fl mgt5 mgr20'>Please enter a valid number.</div>");

        $('#varPassword').passStrengthify({
            element: $("#pass-strength")
        });
        $.validator.addMethod("ExistEmail", function (value, element) {
            var Chkdata = Check_User_Email();
            if (Chkdata > 0)
            {
                return false;
            } else
            {
                return true;
            }

        }, "<div class='fl mgt5'><?php echo EXIST_EMAIL_ID ?></div>");

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
        }, "<div class='fl mgt5'><?php echo PASSWORD_VALID_VALIDATION ?></div>");

        $.validator.addMethod("noSpace", function (value, element) {
            return value.indexOf(" ") < 0 && value != "";
        }, "<div class='fl mgt5'><?php echo SPACE_PASSWORD_VALIDATION ?></div>");

        $.validator.addMethod('checkmultipleemail', function (value, element)
        {
            var Email = value.split(",");
            var count = Email.length;
            var flag = true;
            var i;
            for (i = 0; i < count; i++)
            {
                if (!checkemail(Email[i]))
                {
                    flag = false;
                }
            }
            return flag;
        },
                'Please enter valid email id.');

        $("#FrmChangeProfile").validate({
            rules: {
                varName: "required",
                varLoginEmail: {
                    required: true,
                    email: true,
                    ExistEmail: true
                },
                varPersonalEmail: {
                    required: true,
                    email: true
                },
                varPhoneNo: {
                    required: true,
                    minlength: 5,
                    maxlength: 20,
                    phonenumber: {
                        depends: function () {
                            if (($("#varPhoneNo").val()) != '') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                //                varDefaultMailid: {
                //                    required:true,
                //                    checkmultipleemail : true
                //                        
                //                } ,
                varcontactusleadMailid: {
                    required: true,
                    checkmultipleemail: true
                },
                varnewsletterleadsmailid: {
                    required: true,
                    checkmultipleemail: true
                },
                varapplynowleadMailid: {
                    required: true,
                    checkmultipleemail: true
                },
                varbillpaymentleadMailid: {
                    required: true,
                    checkmultipleemail: true
                },
                varPassword:
                        {
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
                            minlength: 8,
                            maxlength: 20,
                            equalTo: "#varPassword"
                        }
            },
            messages: {
                varName: '<?php echo CP_NAME ?>',
                varLoginEmail: {
                    required: '<?php echo CP_EMAIL ?>',
                    email: '<?php echo CP_EMAIL_VALID ?>'
                },
                varPersonalEmail: {
                    required: '<?php echo CP_PEMAIL ?>',
                    email: '<?php echo CP_PEMAIL_VALID ?>'
                },
                //                varDefaultMailid: {
                //                    required: '<?php // echo CP_DEFAULT_EMAIL                                               ?>',
                //                    email: '<?php // echo CP_DEFAULT_EMAIL_VALID                                               ?>'
                //                },
                varNewsletterMailid: {
                    required: '<?= CP_NEWS_EMAIL ?>',
                    email: '<?php echo CP_NEWS_EMAIL_VALID ?>'
                },
                varcontactusleadMailid: {
                    required: '<?= CONTACTUS_LEAD_EMAIL ?>'
//                    email: '<?php echo CP_CUST_SERVICE_EMAIL_VALID ?>'
                },
                varPassword: {
                    required: "<?= PROFILE_PASSWORD ?>",
                    minlength: "<?php echo PASSWORD_LIMIT ?>",
                    maxlength: "<?php echo PASSWORD_MAX_LIMIT ?>"

                },
                PwdConfirmPassword: {
                    required: "<?= PROFILE_CONF_PASSWORD ?>",
                    minlength: "<?php echo PASSWORD_LIMIT ?>",
                    maxlength: "<?php echo PASSWORD_MAX_LIMIT ?>",
                    equalTo: "<?php echo CONF_PASSWORD_EQUAL ?>"
                },
                varPhoneNo: {
                    required: "Please enter phone.",
                    minlength: "<div class='fl mgt5 mgr20'><?php echo CONTACTINFO_MINIMUM_PHONE_MSG ?></div>",
                    maxlength: "<div class='fl mgt5 mgr20'><?php echo CONTACTINFO_MAXIMUM_PHONE_MSG ?></div>"
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr('id') == 'txtemail1') {
                    error.insertAfter($("#personal_tooltip"));
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form)
            {
                var Check_Session = Check_Session_Expire();
                if (Check_Session == 'N')
                {
                    var SessUserEmailId = '<?php echo USER_EMAILID; ?>'
                    SessionUpdatePopUp(SessUserEmailId);
                } else
                {
                    form.submit();
                }
            }
        });
    });

    function Check_User_Email()
    {
        var Eid = $('#Hid_intGlCode').val();
        var User_Email = $('#varLoginEmail').val();
        var User_Email_Exits;

        $.ajax({
            type: "GET",
            url: "<?php echo MODULE_PAGE_NAME ?>/Check_Email?User_Email=" + User_Email + "&Eid=" + Eid,
            async: false,
            success: function (Data)
            {
                if (Data == 1)
                {
                    User_Email_Exits = 1;
                } else
                {
                    User_Email_Exits = 0;
                }
            }
        });
        return User_Email_Exits;
    }

    function KeycheckOnlyPhone(e)
    {
        var _dom = 0;
        _dom = document.all ? 3 : (document.getElementById ? 1 : (document.layers ? 2 : 0));
        if (document.all)
            e = window.event; // for IE
        var ch = '';
        var KeyID = '';
        if (_dom == 2) { // for NN4
            if (e.which > 0)
                ch = '(' + String.fromCharCode(e.which) + ')';
            KeyID = e.which;
        } else
        {
            if (_dom == 3) { // for IE
                KeyID = (window.event) ? event.keyCode : e.which;
            } else { // for Mozilla
                if (e.charCode > 0)
                    ch = '(' + String.fromCharCode(e.charCode) + ')';
                KeyID = e.charCode;
            }
        }
        if ((KeyID >= 33 && KeyID <= 39) || (KeyID == 42) || (KeyID == 44) || (KeyID >= 47 && KeyID <= 47) || (KeyID >= 58 && KeyID <= 64) || (KeyID >= 91 && KeyID <= 96) || (KeyID >= 123 && KeyID <= 126))
        {
            return false;
        }
        return true;
    }

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


</script>

<div id="page_content">
    <div id="page_content_inner">

     <?php
        if (validation_errors() != '') {
            echo '<div class="md-card-list-wrapper"><div class="md-card-list"><ul class="hierarchical_slide uk-text-danger" id="hierarchical-slide"><li>';
            echo validation_errors();
            echo '</li></ul></div></div>';
        }
        if ($messagebox != '') {
            echo '<div class="md-card-list-wrapper"><div class="md-card-list"><ul class="hierarchical_slide uk-text-danger" id="hierarchical-slide"><li>';
            echo $messagebox;
            echo '</li></ul></div></div>';
        }
        ?>

        <?php
        $action = MODULE_URL . 'Insert_ChangeProfile';
        $attributes = array('name' => 'FrmChangeProfile', 'id' => 'FrmChangeProfile', 'enctype' => 'multipart/form-data', 'class' => 'uk-form-stacked');
        echo form_open($action, $attributes);
        echo form_hidden('Hid_varPassword', $ProfileData->varPassword);
        echo form_hidden('Hid_varLoginEmail', $ProfileData->varLoginEmail);
        echo form_hidden('Hid_intGlCode', $ProfileData->int_id);
        ?>
        <!--<form action="" class="uk-form-stacked" id="user_edit_form">-->
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-large-10-10">
                <div class="md-card">
                    <div class="user_heading" data-uk-sticky="{ top: 48, media: 960 }">
                        <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                                <img src="<?php echo ADMIN_MEDIA_URL; ?>assets/img/avatars/user.png" alt="user avatar"/>
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            <div class="user_avatar_controls">
<!--                                <span class="btn-file">
                                    <span class="fileinput-new"><i class="material-icons">&#xE2C6;</i></span>
                                    <span class="fileinput-exists"><i class="material-icons">&#xE86A;</i></span>
                                    <input type="file" name="user_edit_avatar_control" id="user_edit_avatar_control">
                                </span>-->
                                <a href="#" class="btn-file fileinput-exists" data-dismiss="fileinput"><i class="material-icons">&#xE5CD;</i></a>
                            </div>
                        </div>
                        <div class="user_heading_content">
                            <h2 class="heading_b"><span class="uk-text-truncate" id="user_edit_uname"><?php echo $ProfileData->varName; ?></span><span class="sub-heading" id="varLoginEmail_email"><?php echo $ProfileData->varLoginEmail; ?></span></h2>
                        </div>
                    </div>
                    <div class="user_content">
                        <ul id="user_edit_tabs" class="uk-tab" data-uk-tab="{connect:'#user_edit_tabs_content'}">
                            <li class="uk-active"><a href="#">Basic</a></li>
                            <?php
                            if (ADMIN_ID == '1' || ADMIN_ID == '2') {
                                ?>
                                <li><a href="#">E-mail Detail</a></li>
                                <?php
                            }
                            ?>
                            <!--<li><a href="#">Todo</a></li>-->
                        </ul>
                        <ul id="user_edit_tabs_content" class="uk-switcher uk-margin">
                            <li>
                                <div class="uk-margin-top">
                                    <h3 class="full_width_in_card heading_c">
                                        Personal Information
                                    </h3>
                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-2">
                                            <label for="varName">Name *</label>
                                            <?php
                                            $Name = array(
                                                'name' => 'varName',
                                                'id' => 'varName',
                                                'maxlength' => '100',
                                                'value' => $ProfileData->varName,
                                                'class' => 'md-input'
                                            );
                                            echo form_input($Name);
                                            ?>
                                            <label class="error" for="varName"></label>
                                        </div>
                                        <div class="uk-width-medium-1-2">
                                            <label for="varLoginEmail">Login ID *</label>
                                            <?php
                                            $LoginEmail = array(
                                                'name' => 'varLoginEmail',
                                                'id' => 'varLoginEmail',
                                                'maxlength' => '100',
                                                'value' => $ProfileData->varLoginEmail,
                                                'class' => 'md-input'
                                            );
                                            echo form_input($LoginEmail);
                                            ?>
                                            <label class="error" for="varLoginEmail"></label>
                                        </div>
                                    </div>
                                    <div class="uk-grid">
                                        <div class="uk-width-1-1">
                                            <label for="varPersonalEmail">Personal Email ID *</label>
                                            <?php
                                            $PersonalEmail = array(
                                                'name' => 'varPersonalEmail',
                                                'id' => 'varPersonalEmail',
                                                'maxlength' => '100',
                                                'value' => $ProfileData->varPersonalEmail,
                                                'class' => 'md-input'
                                            );
                                            echo form_input($PersonalEmail);
                                            ?>
                                        </div>
                                        <label class="error" for="varPersonalEmail"></label>

                                    </div>
                                    <div style="color: #012150;font-size: 10;font-weight: bold;"><i> Note: You need to enter email id to get forgot password email.</i></div>
                                    <div class="spacer10"></div>
                                    <div class="uk-grid">
                                        <div class="uk-width-1-2">
                                            <label for="varPassword">Password</label>
                                            <?php
                                            $Password = array(
                                                'name' => 'varPassword',
                                                'id' => 'varPassword',
                                                'type' => 'password',
                                                'maxlength' => '20',
                                                'class' => 'md-input'
                                            );
                                            echo form_input($Password);
                                            ?>
                                            <label class="error" for="varPassword"></label>
                                        </div>
                                        <div class="uk-width-1-2">
                                            <label for="PwdConfirmPassword">Confirm Password</label>
                                            <?php
                                            $CnfPassword = array(
                                                'name' => 'PwdConfirmPassword',
                                                'id' => 'PwdConfirmPassword',
                                                'type' => 'password',
                                                'maxlength' => '20',
                                                'class' => 'md-input'
                                            );
                                            echo form_input($CnfPassword);
                                            ?>
                                            <label class="error" for="PwdConfirmPassword"></label>
                                        </div>
                                        <span id="pass-strength"></span>
                                    </div>
                                    <div class="uk-grid">
                                        <div class="uk-width-1-2">
                                            <label for="varPhoneNo">Phone# *</label>
                                            <?php
                                            $varPhoneNo = array(
                                                'name' => 'varPhoneNo',
                                                'id' => 'varPhoneNo',
                                                'maxlength' => '20',
                                                'value' => trim($ProfileData->varPhoneNo),
                                                'class' => 'md-input',
                                                'onkeypress' => 'return spaceCheck(event)',
                                                'onkeypress' => 'return KeycheckOnlyPhone(event)',
                                                'onkeypress' => 'return KeycheckOnlyNumeric(event)'
                                            );
                                            echo form_input($varPhoneNo);
                                            ?>
                                        </div>
                                        <label class="error" for="varPhoneNo"></label>

                                    </div>
                                </div>
                            </li>
                            <?php
                            if (ADMIN_ID == '1' || ADMIN_ID == '2') {
                                ?>
                                <li>
                                    <div class="spacer10"></div>
                                    <div class="uk-grid">
                                        <div class="uk-width-1-1">
                                            <label for="varcontactusleadMailid">Contact Us Lead Email ID *</label>
                                            <?php
                                            $ContactusEmailData = array(
                                                'name' => 'varcontactusleadMailid',
                                                'id' => 'varcontactusleadMailid',
                                                'maxlength' => '100',
                                                'value' => $SettingsData['varcontactusleadMailid'],
                                                'class' => 'md-input'
                                            );
                                            echo form_input_ready($ContactusEmailData);
                                            ?>
                                        </div>
                                        <label class="error" for="varcontactusleadMailid"></label>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>

                        <div class="uk-form-row">
                            <button class="md-btn md-btn-primary md-btn-wave-light" value="btnsaveandc" name="btnsaveandc" id="btnsaveandc">Save &amp; Keep Editing</button>
                            <a href="<?php echo MODULE_PAGE_NAME; ?>" title="Cancel">
                                <div  class="md-btn md-btn-wave">
                                    Cancel
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            </form>

        </div>
    </div>
    <script src="<?php echo ADMIN_MEDIA_URL; ?>assets/js/pages/page_user_edit.min.js"></script>