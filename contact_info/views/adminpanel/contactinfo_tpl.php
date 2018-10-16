<script type="text/javascript">
    $(document).ready(function () {
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
        $.validator.addMethod("CheckAllEmail", function (value, element) {
            var ValidEmail = true;
            $(".EmailField").each(function () {
                if (trim($(this).val()) != '' && !checkemail($(this).val())) {
                    $("label[for='" + $(this).attr("id") + "']").show();
                    ValidEmail = false;
                }
            });
            return ValidEmail;
        }, "<div class='fl mgt5 mgr20'><?php echo CONTACT_EMAIL_VALID ?></div>");
        $("#contactinfo").validate({
            ignore: [],
            rules: {
                varEmail: {
                    required: true,
                    email: true
                },
                varPhone: {
                    required: true,
                    minlength: 5,
                    maxlength: 20,
//                    phonenumber: {
//                        depends: function () {
//                            if (($("#varPhone").val()) != '') {
//                                return true;
//                            } else {
//                                return false;
//                            }
//                        }
                }
            },
            messages: {
                varEmail: {
                    required: "<?php echo CONTACT_EMAIL ?>",
                    email: "<?php echo CONTACT_EMAIL_VALID ?>"
                },
                varPhone: {
                    required: "Please enter phone number."
                }
//                varPhone: {
//                    minlength: "<div class='fl mgt5 mgr20'><?php echo CONTACTINFO_MINIMUM_PHONE_MSG ?></div>",
//                    maxlength: "<div class='fl mgt5 mgr20'><?php echo CONTACTINFO_MAXIMUM_PHONE_MSG ?></div>"
//                }
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
        return false;
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
</script> 
<div id="page_content_inner">
    <div id="page_content">
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                <li><span>Manage Contact Information</span></li>
            </ul>
        </div>
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
        <div class="uk-text-danger" style="float:right;">* Required Field</div>
        <div class="clear"></div>
        <?php echo form_open(MODULE_URL . "update", array('id' => 'contactinfo', 'name' => 'contactinfo', 'class' => 'enquiry_form')); ?>

<!--<form method="post" name="contactinfo" id="contactinfo" action ="<?php echo MODULE_URL ?>update" class="enquiry_form ">-->
        <?php
        if (!empty($eid)) {
            ?>
            <input type="hidden" name="ehintglcode" id="ehintglcode" value="<?= $eid; ?>" />
            <?php
        }
        ?>
<!--<input type="hidden" name="<?php // echo $this->security->get_csrf_token_name();         ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">-->
        <input type="hidden" name="eid" id="eid" value="<?php echo $Row->int_id; ?>" />
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-grid">
                    <div class="uk-width-large-2-3 uk-width-1-1">
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon"><i class="material-icons md-24">&#xE554;</i></span>
                            <input class="md-input" type="email" name="varEmail" maxlength="100" id="varEmail" value="<?php echo $Row->varEmail; ?>">
                            <label class="error" for="varEmail"></label>
                        </div>
                    </div>
                </div>

                <div class="clear"></div> 
                <div class="uk-grid">
                    <div class="uk-width-large-2-3 uk-width-1-1">
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon"><i class="material-icons md-24">phone</i></span>
                            <input class="md-input" type="text" name="varPhone" onkeypress="return KeycheckOnlyNumeric(event);" maxlength="100" placeholder="Phone" id="varPhone" value="<?php echo $Row->varPhone; ?>">
                            <label class="error" for="varPhone"></label>
                        </div>
                    </div>
                </div>
                <div class="clear"></div> 
                <div class="uk-grid">
                    <div class="uk-width-large-2-3 uk-width-1-1">
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon"><i class="material-icons md-24">help</i></span>
                            <input class="md-input" type="text" name="varMessenger" placeholder="Messenger" id="varMessenger" value="<?php echo $Row->varMessenger; ?>">
                            <label class="error" for="varMessenger"></label>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>  
                <div class="uk-grid">
                    <div class="uk-width-large-2-3 uk-width-1-1">
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon"><i class="material-icons md-24">location_on</i></span>
                            <textarea class="md-input" name="varAddress" maxlength="100" id="varAddress" placeholder="Address"><?php echo $Row->varAddress; ?></textarea>
                            <label class="error" for="varAddress"></label>
                        </div>
                    </div>
                </div>

                <!--                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Ahmedabad Office Address</label>
                                            <div class="clear"></div>
                                            <textarea name="varAddress1" id="varAddress1" class="md-input" style="min-height:120px;"><?php echo $Row->varAddress1; ?></textarea>
                                        </div>
                                    </div>-->
                <div class="spacer10"></div>
            </div>

            <div class="spacer10"></div>
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-form-row">
                        <button class="md-btn md-btn-primary md-btn-wave-light" name="btnsaveandc" value="btnsaveandc" id="btnsaveandc">Save &amp; Keep Editing</button>
                        <button class="md-btn md-btn-primary md-btn-wave-light" name="btnsaveande" id="btnsaveande">Save &amp; Exit</button>
                        <a href="<?php echo MODULE_PAGE_NAME; ?>" title="Cancel">
                            <div  class="md-btn md-btn-wave">
                                Cancel
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 