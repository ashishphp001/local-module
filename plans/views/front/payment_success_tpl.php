<script type="text/javascript">
    $(document).ready(function () {

//        $("#varSubdomain").keyup(function () {
//            $("#subdomainvalue").html($(this).val());
//        });

        $.validator.addMethod("noSpace", function (value, element) {
            return value.indexOf(" ") < 0 && value != "";
        }, "Please space is not allowed.");

        $('#varSubdomain').keyup(function ()
        {
            var yourInput = $(this).val();
            var re = /[`~!@#$%^&*()_|+\=?;:'",.<>\{\}\[\]\\\/]/gi;
            var isSplChar = re.test(yourInput);
            if (isSplChar)
            {

                var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\=?;:'",.<>\{\}\[\]\\\/]/gi, '');
                $(this).val(no_spl_char);
            }
            $("#subdomainvalue").html($(this).val());

        });

        $("#FrmSubdomain").validate({
            ignore: [],
            rules: {
                varSubdomain: {
                    required: true,
                    noSpace: true
                }
            },
            errorPlacement: function (error, element)
            {

            },
            submitHandler: function (form) {

                var subdomain = $('#varSubdomain').val();
                $.ajax({
                    type: "POST",
                    data: {"csrf_indibizz": csrfHash, "varSubdomain": subdomain},
                    url: "<?php echo $this->common_model->getUrl("pages", "2", "44", ''); ?>" + "/Check_subdomain",
                    async: false,
                    success: function (Data)
                    {
//                        alert(Data);
//                        return false;
                        if (Data == 1) {
                            M.toast({html: 'Subdomain you entered is already used with Indibzz.'});
                            return false;
                        } else {
                            form.submit();
                        }
                    }
                });
            }
        });
    });


</script>

<div class="register-main thank-you-back thanks-impliment" >
    <div class="container">
        <div class="row">
            <div class="register-info">
                <div class="register-inner card">         
                    <div class="thankyou">
                        <div class="thanks-detail">
                            <div class="check-thanks">
                                <div class="check_mark">
                                    <div class="sa-icon sa-success animate">
                                        <span class="sa-line sa-tip animateSuccessTip"></span>
                                        <span class="sa-line sa-long animateSuccessLong"></span>
                                        <div class="sa-placeholder"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="thanks-info info-fill">
                                <h6>Thank you for choosing Indibizz's <?php echo $plan_data['varName']; ?></h6>
                                <p>Your invoice will be sent your registered email.</p>
                                <!--<form class="subdomail-filed">-->
                                <?php
                                $attributes = array('name' => 'FrmSubdomain', 'id' => 'FrmSubdomain', 'enctype' => 'multipart/form-data', 'class' => 'subdomail-filed', 'method' => 'post');
                                $action = $this->common_model->getUrl("pages", "2", "44", '') . "/update_subdomain";
                                echo form_open($action, $attributes);
                                ?>

                                <div class="thanks-text-box col s12 m8">
                                    <div class="col m8 s12 ">
                                        <div class="input-field field-custom">

                                            <input type="text" autocomplete="off" id="varSubdomain" name="varSubdomain" class="autocomplete">
                                            <label for="varSubdomain">Subdomain</label>

                                        </div>
                                    </div>
                                    <div class="col m4 s12">
                                        <div class="subdomain-button">
                                            <button type="submit" class="domain-set">Submit</button>
                                        </div>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                                <div class="subdomain-title">http://<b id="subdomainvalue">subdomain</b>.indibizz.com </div>
                                <div class="membership-price-info none-heading-change">
                                    <span>User Plan</span>
                                    <div class="surprice-price-name">
                                        <b><?php echo $plan_data['varName']; ?></b>
                                    </div>
                                    <div class="surprice-price-name">
                                        <b>&#8377;<?php echo $plan_data['varPrice']; ?>/</b><?php echo $plan_data['intMonth']; ?> Months
                                    </div>
                                </div>
                                <div class="back-to-home all-same">
                                    <a href="<?php echo SITE_PATH; ?>" class="same-btn waves-effect waves-light btn">Back To Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>