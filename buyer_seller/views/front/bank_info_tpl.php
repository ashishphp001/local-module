<script type="text/javascript">
    $(document).ready(function () {
        $("#FrmBankInfo").validate({
            ignore: [],
            rules: {
                varReAccountNo: {
                    equalTo: "#varAccountNo"
                },
                varReIntAccountNo: {
                    equalTo: "#varIntAccountNo"
                }
            },
            errorPlacement: function (error, element) {

            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>

<div class="col l12 m12 s12">
    <div class="steps-profile">
        <!-- progressbar -->
        <ul id="progressbar">
            <li class="progress-active"><a href="<?php echo $this->common_model->getUrl("pages", "2", "95", ''); ?>"><span>1.</span>Account Setup</a></li>
            <li class="progress-active"><a href="<?php echo $this->common_model->getUrl("pages", "2", "96", ''); ?>"><span>2.</span>Company Information</a></li>
            <li class="progress-active"><a href="<?php echo $this->common_model->getUrl("pages", "2", "97", ''); ?>"><span>3.</span>Company Certificate</a></li>
            <li class="active"><span>4.</span>Banking Information</li>
            <li><span>5.</span>Trade Shows And Events</li>
        </ul>
    </div>
</div>
<div class="col l12 m12 s12">
    <div class="product-multi1 card">          
        <div class="form_detail">
            <?php
            $getUserdata = $this->Module_Model->getUserProfile(USER_ID);
            $attributes = array('name' => 'FrmBankInfo', 'id' => 'FrmBankInfo', 'enctype' => 'multipart/form-data', 'class' => 'padding-all', 'method' => 'post');
            $action = $this->common_model->getUrl("pages", "2", "96", '') . "/add_bankinfo";
            echo form_open($action, $attributes);
            ?>
            <input type="hidden" id="intUser" name="intUser" value="<?php echo USER_ID; ?>">    
            <fieldset>
                <div class="company-information">
                    <div class="col s12 m12 padding company-title">
                        <div class="card display-bl">
                            <div class="col s12 m12 padding company-title">
                                <div class="col m12 s12 mobile-padding-social">
                                    <div class="indian-bank">
                                        <div class=" display-bl">
                                            <h2>Indian Bank</h2>
                                            <div class="col m6 s12">
                                                <div class="input-field field-custom account-small same-account">
                                                    <input id="varAccountName" value="<?php echo $getCompanydata['varAccountName']; ?>" name="varAccountName" type="text">
                                                    <label for="varAccountName" class="">Account Name</label>
                                                </div>
                                            </div>
                                            <div class="col m6 s12">
                                                <div class="input-field field-custom account-small same-account">
                                                    <input id="varBankName" value="<?php echo $getCompanydata['varBankName']; ?>" name="varBankName" type="text">
                                                    <label for="varBankName" class="">Bank Name</label>
                                                </div>
                                            </div>
                                            <div class="col m6 s12">
                                                <div class="input-field field-custom bank-detail same-account">
                                                    <input id="varAccountNo" value="<?php echo $getCompanydata['varAccountNo']; ?>" name="varAccountNo" type="text">
                                                    <label for="varAccountNo" class="">Account Number</label>
                                                </div>
                                            </div>
                                            <div class="col m6 s12">
                                                <div class="input-field field-custom bank-detail same-account">
                                                    <input id="varReAccountNo" value="<?php echo $getCompanydata['varAccountNo']; ?>" name="varReAccountNo" type="text">
                                                    <label for="varReAccountNo" class="">Re-enter Account Number</label>
                                                </div>
                                            </div>
                                            <div class="col m6 s12">
                                                <div class="input-field field-custom bank-detail same-account">
                                                    <input id="varIFSCCode" value="<?php echo $getCompanydata['varIFSCCode']; ?>" name="varIFSCCode" type="text">
                                                    <label for="varIFSCCode" class="">IFSC Code</label>
                                                </div>
                                            </div>
                                            <div class="col m6 s12">
                                                <div class="input-field field-custom bank-detail same-account">
                                                    <input id="varAccountType" value="<?php echo $getCompanydata['varAccountType']; ?>" name="varAccountType" type="text">
                                                    <label for="varAccountType" class="">A/C Type</label>
                                                </div>
                                            </div>
                                            <div class="col m6 s12">
                                                <div class="input-field field-custom bank-detail same-account">
                                                    <input id="varMICRCode" value="<?php echo $getCompanydata['varMICRCode']; ?>" name="varMICRCode" type="text">
                                                    <label for="varMICRCode" class="">MICR Code</label>
                                                </div>
                                            </div>
                                            <div class="col m6 s12">
                                                <div class="input-field field-custom bank-detail same-account">
                                                    <input id="varBranchCode" value="<?php echo $getCompanydata['varBranchCode']; ?>" name="varBranchCode" type="text">
                                                    <label for="varBranchCode" class="">Branch Code</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                        <div class="col m12 s12 mobile-tax company-title padding">
                            <div class="card display-bl address-profile-add">
                                <ul class="collapsible change-add-profile-main">
                                    <li>
                                        <div class="collapsible-header card" >
                                            <a href="javascript:;" onclick=""><i class="fas fa-money-check-alt"></i> International Bank Details <span class="right-pro-ic"> <div class="circle-plus closed">
                                                        <div class="circle">
                                                            <div class="horizontal"></div>
                                                            <div class="vertical"></div>
                                                        </div>
                                                    </div></span></a>
                                        </div>
                                        <div class="collapsible-body">
                                            <!--<div class="col m12 s12 mobile-tax">-->
                                            <div class="indian-bank">
                                                <div class="display-bl">
                                                    <div class="col m6 s12">
                                                        <div class="input-field field-custom account-small same-account">
                                                            <input id="varIntAccountName" value="<?php echo $getCompanydata['varIntAccountName']; ?>" name="varIntAccountName" type="text">
                                                            <label for="varIntAccountName" class="">Account Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col m6 s12">
                                                        <div class="input-field field-custom account-small same-account">
                                                            <input id="varIntBankName" value="<?php echo $getCompanydata['varIntBankName']; ?>" name="varIntBankName" type="text">
                                                            <label for="varIntBankName" class="">Bank Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col m4 s12">
                                                        <div class="input-field field-custom three-combine same-account">
                                                            <input id="varIntAccountNo" value="<?php echo $getCompanydata['varIntAccountNo']; ?>" name="varIntAccountNo" type="text">
                                                            <label for="varIntAccountNo" class="">Account Number</label>
                                                        </div>
                                                    </div>
                                                    <div class="col m4 s12">
                                                        <div class="input-field field-custom three-combine same-account">
                                                            <input id="varReIntAccountNo" value="<?php echo $getCompanydata['varIntAccountNo']; ?>" name="varReIntAccountType" type="text">
                                                            <label for="varReIntAccountNo" class="">Re-enter Account Number</label>
                                                        </div>
                                                    </div>
                                                    <div class="col m4 s12">
                                                        <div class="input-field field-custom three-combine same-account">
                                                            <input id="varIntIFSCCode" value="<?php echo $getCompanydata['varIntIFSCCode']; ?>" name="varIntIFSCCode" type="text">
                                                            <label for="varIntIFSCCode" class="">IFSC Code</label>
                                                        </div>
                                                    </div>
                                                    <div class="col m4 s12">
                                                        <div class="input-field field-custom three-combine same-account">
                                                            <input id="varIntAccountType" value="<?php echo $getCompanydata['varIntAccountType']; ?>" name="varIntAccountType" type="text">
                                                            <label for="varIntAccountType" class="">A/C Type</label>
                                                        </div>
                                                    </div>
                                                    <div class="col m4 s12">
                                                        <div class="input-field field-custom three-combine same-account">
                                                            <input id="varIntMICRCode" value="<?php echo $getCompanydata['varIntMICRCode']; ?>" name="varIntMICRCode" type="text">
                                                            <label for="varIntMICRCode" class="">MICR Code</label>
                                                        </div>
                                                    </div>
                                                    <div class="col m4 s12">
                                                        <div class="input-field field-custom three-combine same-account">
                                                            <input id="varIntBranchCode" value="<?php echo $getCompanydata['varIntBranchCode']; ?>" name="varIntBranchCode" type="text">
                                                            <label for="varIntBranchCode" class="">Branch Code</label>
                                                        </div>
                                                    </div>
                                                    <div class="col m6 s12">
                                                        <div class="input-field field-custom bank-detail same-account">
                                                            <input id="varIBANNo" value="<?php echo $getCompanydata['varIBANNo']; ?>" name="varIBANNo" type="text">
                                                            <label for="varIBANNo" class="">IBAN No</label>
                                                        </div>
                                                    </div>
                                                    <div class="col m6 s12">
                                                        <div class="input-field field-custom bank-detail same-account">
                                                            <input id="varRoutingCode" value="<?php echo $getCompanydata['varRoutingCode']; ?>" name="varRoutingCode" type="text">
                                                            <label for="varRoutingCode" class="">Routing Code</label>
                                                        </div>
                                                    </div>
                                                    <div class="col m6 s12">
                                                        <div class="input-field field-custom bank-detail same-account">
                                                            <input id="varSortCode" value="<?php echo $getCompanydata['varSortCode']; ?>" name="varSortCode" type="text">
                                                            <label for="varSortCode" class="">Sort Code</label>
                                                        </div>
                                                    </div>
                                                    <div class="col m6 s12">
                                                        <div class="input-field field-custom bank-detail same-account">
                                                            <input id="varABANo" value="<?php echo $getCompanydata['varABANo']; ?>" name="varABANo" type="text">
                                                            <label for="varABANo" class="">ABA Number</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="<?php echo $this->common_model->getUrl("pages", "2", "97", ''); ?>" class="previous action-button" >Previous</a>
                <input type="submit" class="next action-button" value="Save&nbsp;&&nbsp;Next" />
            </fieldset>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script>
    //Second upload
    var secondUpload = new FileUploadWithPreview('mySecondImage');
</script>
<script type="text/javascript">
    $('.collapsible-header').on('click', function () {
        $(this).toggleClass('opened');
    })
</script>