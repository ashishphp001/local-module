<script type="text/javascript">

    function checkurl1(url)
    {
        var RegExp = /^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.[a-zA-Z]+[a-zA-Z]+[a-zA-Z]*)/;
        if (RegExp.test(url)) {
            return true;
        } else {
            return false;
        }
    }
    $(document).ready(function () {

        $.validator.addMethod("ExistEmail", function (value, element) {
            var Chkdata = Check_User_Email();
            if (Chkdata > 0)
            {
                return false;
            } else
            {
                return true;
            }

        }, "<?php echo EXIST_EMAIL_ID ?>");

        $.validator.addMethod('lowercasesymbols', function (value) {
             return value.match(/^[1-9a-z\\/\]]+$/);
//            return value.match(/^[^A-Z0-9]+$/);
        }, 'You must use only lowercase letters in subdomain name.');

        $("#FrmPayment").validate({
            ignore: [],
            rules: {
                varPaymentDate: {
                    required: true
                },
                intPayment: {
                    required: true
                },
                intPlan: {
                    required: true
                },
                varSubdomain: {
                    required: true,
                    ExistEmail: true,
                    lowercasesymbols: true
                }
            },
            messages: {
                varPaymentDate: {
                    required: "Please select payment date time."
                },
                intPayment: {
                    required: "Please select payment type."
                },
                intPlan: {
                    required: "Please select membership plan."
                },
                varSubdomain: {
                    required: "Please enter subdomain name."
                }
            },
            errorPlacement: function (error, element)
            {
                error.insertAfter(element);
            },
            submitHandler: function (form) {
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
        var User_Email = $('#varSubdomain').val();
        var User_Email_Exits;

        $.ajax({
            type: "GET",
            url: "<?php echo MODULE_PAGE_NAME ?>/Check_subdomain?varSubDomain=" + User_Email + "&Eid=" + Eid,
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
</script>
<div id="page_content_inner">
    <div id="page_content">
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                <li><a href="<?php echo MODULE_PAGE_NAME; ?>">Manage Buyer / Seller</a></li>
                <li><span>
                        <?php
                        if (!empty($eid)) {
                            echo 'Add Payment for ' . $Row['varName'];
                        }
                        ?>

                    </span></li>
            </ul>
        </div>
        <div class="uk-text-danger" style="float:right;">* Required Field</div>
        <div class="clear"></div>

        <?php
        $attributes = array('name' => 'FrmPayment', 'id' => 'FrmPayment', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
        echo form_open($action, $attributes);
        ?>
        <div class="md-card">
            <div class="md-card-content">
                <input type="hidden" id="Hid_intGlCode" name="Hid_intGlCode" value="<?php echo $eid; ?>">
                <input type="hidden" id="intUser" name="intUser" value="<?php echo $eid; ?>">
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-large-1-2">
                            <div class="uk-input-group">
                                <label for="varPaymentDate">Payment At</label>
                                <div class="clear"></div>
                                <input  name="varPaymentDate" type="text" id="varPaymentDate">
                            </div>
                            <div class="clear"></div>
                            <label class="error" for="varPaymentDate"></label>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">

                            <select id="intPayment" name="intPayment" class="md-input">
                                <?php echo $getPaymentTypes; ?>
                            </select>
                            <div class="clear"></div>
                            <label class="error" for="intPayment"></label>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <select id="intPlan" name="intPlan" class="md-input">
                                <?php echo $getAllPlans; ?>
                            </select>
                            <div class="clear"></div>
                            <label class="error" for="intPlan"></label>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-width-medium-1-2">
                        <label>Sub Domain</label>
                        <?php
                        $titleBoxdata = array(
                            'name' => 'varSubdomain',
                            'id' => 'varSubdomain',
                            'maxlength' => '100',
                            'class' => 'md-input',
                            'required' => 'required'
                        );
                        echo form_input($titleBoxdata);
                        ?><label>.indibizz.com</label>
                        <div class="clear"></div>
                        <label class="error" for="varSubdomain"></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="md-card">



            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-form-row">
                        <button class="md-btn md-btn-primary md-btn-wave-light" name="btnsaveande" id="btnsaveande">Do Payment</button>
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
    <div class="spacer10"></div>
    <?php echo form_close(); ?>
</div>
