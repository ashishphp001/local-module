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

        }, "Please enter a valid number.");
        $("#FrmContactUs").validate({
            ignore: [],
            rules: {
                varName: {
                    required: true
                },
                varEmailId: {
                    email: true,
                    required: true
                },
                varPhone: {
                    minlength: 5,
                    required: true,
                    maxlength: 20,
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
                txtMessage: {
                    required: true
                }
            },
            errorPlacement: function (error, element)
            {
            },
            submitHandler: function (form) {
                var $captcha = $('#recaptcha'),
                        response = grecaptcha.getResponse();

                if (response.length === 0) {
                    $('.msg-error').text("<?php echo GLOBAL_CAPTCHA_MSG; ?>");
                    if (!$captcha.hasClass("error")) {
                        $captcha.addClass("error");
                    }
                    return false;
                } else {
                    form.submit();
                }
            }
        });
    });

</script>
<?php $this->common_model->get_contactusdata(); ?>
<div class="register-main contact-us-indi" style="background: url(<?php echo FRONT_MEDIA_URL; ?>images/contact-bannerid.jpg) repeat-x scroll center top #fff !important;">
    <div class="container">
        <div class="row">
            <div class="contact-start-all card">
                <div class="contact-inner-info-indi">
                    <div class="col s12 m3">
                        <div class="contact-firm">
                            <div class="contact-ic">
                                <i class="material-icons">call</i>
                            </div>
                            <div class="unit-body">
                                <h6>Phone</h6>
                                <div class="p">
                                    <?php
                                    if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile') || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'android')) {
                                        ?><a chref="tel:<?php echo CONTACT_PHONE; ?>"><?php echo CONTACT_PHONE; ?></a>
                                    <?php } else { ?>
                                        <?php
                                        echo CONTACT_PHONE;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m3">
                        <div class="contact-firm">
                            <div class="contact-ic">
                                <i class="far fa-envelope-open"></i>
                            </div>
                            <div class="unit-body">
                                <h6>Email</h6>
                                <div class="p"><a href="<?php echo "mailto:" . EMAIL_ADD; ?>    "><?php echo EMAIL_ADD; ?></a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m3">
                        <div class="contact-firm">
                            <div class="contact-ic">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="unit-body">
                                <h6>Address</h6>
                                <div class="p"><?php echo nl2br(ADDRESS_ADD); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m3">
                        <div class="contact-firm">
                            <div class="contact-ic">
                                <i class="fab fa-facebook"></i>
                            </div>
                            <div class="unit-body">
                                <h6>Chat With Us</h6>
                                <div class="p"><a href="<?php echo MESSENGER_LINK; ?>" target="_blank">Indibizz B2B</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="map-orgen row">
        <div class="col s12 m6 padding">
            <div class="contact-add-set">
                <div class="contact-heading">
                    <h5>Contact Us</h5>
                </div>

                <?php
                $attributes = array('name' => 'FrmContactUs', 'id' => 'FrmContactUs', 'enctype' => 'multipart/form-data', 'class' => 'register-form all-product-form', 'method' => 'post');
                $action = $this->common_model->getUrl("pages", "2", "45", '') . "/insert";
                echo form_open($action, $attributes);
                ?>
                <div class="contact-fill-id">
                    <div class="col s12 m12 padding">
                        <div class="col m6 s12 ">
                            <div class="input-field field-custom">
                                <input type="text" id="varName" name="varName" class="autocomplete">
                                <label for="varName">Name<sup>*</sup></label>
                            </div>
                        </div>
                        <div class="col m6 s12 ">
                            <div class="input-field field-custom">
                                <input type="text" id="varEmailId" name="varEmailId">
                                <label for="varEmailId">Email<sup>*</sup></label>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m12 padding">
                        <div class="col m6 s12 ">
                            <div class="input-field field-custom">
                                <input type="text" id="varPhone" name="varPhone" onkeypress="return KeycheckOnlyNumeric(event);">
                                <label for="varPhone">Phone<sup>*</sup></label>
                            </div>
                        </div>
                        <div class="col m6 s12 ">
                            <div class="input-field field-custom">
                                <input type="text" id="varCompanyName" name="varCompanyName">
                                <label for="varCompanyName">Website / Company Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m12 padding">
                        <div class="col m12 s12 ">
                            <div class="input-field field-custom contact-textarea">
                                <textarea id="txtMessage" name="txtMessage" class="materialize-textarea"></textarea>
                                <label for="txtMessage">Message</label>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m12">
                        <div class="contect-send">
                            <div class="contact-captcha">
                                <div id="recaptcha" class="g-recaptcha" data-sitekey="6LdlHm0UAAAAAIDnRedU_CbGJ1LGX_BS0OoPl74F"></div>
                            </div>

                            <div class="contact-btn-status">
                                <input type="submit" class="contact-send-last waves-effect waves-light btn" value="Send">
                            </div>

                        </div>
                        <span class="msg-error error"></span>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
        <div class="col s12 m6 padding">
            <div class="map-set-contact">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3692.186680155349!2d70.77858481429935!3d22.270917249590298!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3959ca443d8a97db%3A0xcb0a581a247c173f!2sIndibizz!5e0!3m2!1sen!2sin!4v1535528836370"  width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
