<script type="text/javascript" src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>js/jquery.passstrength.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        if (document.getElementById('varUserType').value == 'S')
        {
            document.getElementById('district_div').style.display = '';
            document.getElementById('showDisctrict').style.display = 'none';
        } else if (document.getElementById('varUserType').value == 'D' || document.getElementById('varUserType').value == 'E')
        {
            document.getElementById('district_div').style.display = '';
            document.getElementById('showDisctrict').style.display = '';
        }


        $('#varPassword').passStrengthify({
            element: $("#pass-strength")
        });

        $.validator.addMethod("PassWordMethod", function (value, element) {
            if ($("#varPassword").val() == "") {
                return true;
            }
            var digitString = value.replace(/[^0-9]/g, "").length;
            var charString = value.replace(/[^A-Za-z]/g, "").length;

            if (digitString > 0 && charString > 0) {
                return true;
            } else {
                return false;
            }

        }, User_Password_Error_Rules);

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

        $("#User_FRM").validate({
            ignore: [],
            rules: {
                varName: {
                    required: true
                },
                varLoginEmail: {
                    required: true,
                    email: true,
                    ExistEmail: true
                },
                varPhoneNo: {
                    required: true
                },
                varUserType: {
                    required: true
                },
                varStates: {
                    required: {
                        depends: function () {
                            if ($("#varUserType").val() == 'D') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                varState: {
                    required: {
                        depends: function () {
                            if ($("#varUserType").val() != 'D' || $("#varUserType").val() != '') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                varDistrict: {
                    required: {
                        depends: function () {
                            if ($("#varUserType").val() == 'D' || $("#varUserType").val() == 'E')
                            {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                varPassword: {
                    minlength: 8,
                    PassWordMethod: true,
                    required: function () {
                        if ($("#varPassword").val() == '' && $("#varConfPassword").val() == '' && $('#ehintglcode').val() != '')
                        {
                            return false;
                        } else
                        {
                            return true;
                        }
                    }
                },
                varConfPassword: {
                    minlength: 8,
                    equalTo: "#varPassword",
                    required: function () {
                        if ($("#varPassword").val() != '')
                        {
                            return true;
                        } else
                        {
                            return false;
                        }
                    }
                }

            },
            messages: {
                varName: {
                    required: "Please enter name."
                },
                varUserType: {
                    required: "Please select user role."
                },
                varLoginEmail: {
                    required: "Please enter login email id."
                },
                varState: {
                    required: "Please select state."
                },
                varDistrict: {
                    required: "Please select district."
                },
                varPhoneNo: {
                    required: "Please enter phone number."
                },
                varPassword: {
                    required: "Please enter the password."
                },
                varConfPassword: {
                    required: "Please enter the confirm password."
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

    function UpdateLocation(role)
    {
        if (role == 'S') {
            $("#state_div").show();
            $("#district_div").hide();
        } else if (role == 'D' || role == 'E') {
            $("#state_div").hide();
            $("#district_div").show();
            $("#showDisctrict").show();

            $.ajax({
                type: "GET",
                url: "<?php echo MODULE_PAGE_NAME ?>/getStates",
                async: false,
                success: function (Data)
                {
                    $('#showState').html(Data);
                }
            });
        }
    }
    function getDistricts(state)
    {
//        alert(state);
//        if (role == 'S') {
//            $("#district_div").hide();
//        } else if (role == 'D') {
//            $("#district_div").hide();

//            var state = $("#varState").val();
        $.ajax({
            type: "GET",
            url: "<?php echo MODULE_PAGE_NAME ?>/getDisctricts?varState=" + state,
            async: false,
            success: function (Data)
            {
                $('#showDisctrict').html(Data);
            }
        });

//        } else if (role == 'E') {
//            $("#district_div").hide();
//        }
    }
</script>
<div id="links-modal" name="links-modal"></div>  

<div id="page_content_inner">
    <div id="page_content">
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                <li><a href="<?php echo MODULE_PAGE_NAME; ?>">User Management</a></li>
                <li>
                    <span>
                        <?php
                        if (!empty($Eid)) {
                            echo 'Edit User';
                        } else {
                            echo 'Add User';
                        }
                        ?>
                    </span>
                </li>
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
        <?php
        $attributes = array('name' => 'User_FRM', 'id' => 'User_FRM', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off');
        echo form_open($action, $attributes);
        ?>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                echo form_hidden('ehintglcode', $Eid);
                echo form_hidden('hid_Password', $row['varPassword']);
                echo form_hidden('Hid_intGlCode', $row['int_id']);
                echo form_hidden('Hid_varLoginEmail', $row['varLoginEmail']);
                ?>

                <div class="fix_width" id="DIV_gen_info">
                    <div class="box-body">
                        <div class="uk-form-row">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <label> Name *</label>
                                    <?php
                                    $Name = array(
                                        'name' => 'varName',
                                        'id' => 'varName',
                                        'maxlength' => '55',
                                        'value' => (!empty($Eid) ? $row['varName'] : ''),
                                        'class' => 'md-input'
                                    );
                                    echo form_input($Name);
                                    ?>
                                    <label class="error" for="varName"></label>
                                </div>
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <label> Select Role *</label>
                                    <?php
//                                    echo $row['varUserType'];
                                    if ($row['varUserType'] == 'S') {
                                        $state_select = "selected='selected'";
                                        $exe_selected = "";
                                        $dis_selected = "";
                                    } else if ($row['varUserType'] == 'D') {
                                        $dis_selected = "selected='selected'";
                                        $exe_selected = "";
                                        $state_select = "";
                                    } else if ($row['varUserType'] == 'E') {
                                        $exe_selected = "selected='selected'";
                                        $state_select = "";
                                        $dis_selected = "";
                                    }
                                    ?>
                                    <select id="varUserType" onchange="return UpdateLocation(this.value)" name="varUserType" class="md-input label-fixed">
                                        <option value="">--Select Role--</option>

                                        <option <?php echo $state_select; ?> value="S">State</option>
                                        <option <?php echo $dis_selected; ?> value="D">District</option>
                                        <option <?php echo $exe_selected; ?> value="E">Executive</option>
                                    </select>
                                    <label class="error" for="varUserType"></label>
                                </div>
                            </div>
                        </div>

                        <div class="uk-form-row" id="state_div" style="display: none;">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">

                                    <?php echo $getStateName; ?>
                                    <label class="error" for="varStates"></label>
                                </div>
                            </div>
                        </div>

                        <div id="district_div">

                            <div class="uk-form-row">
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-2" id="showState">
                                        <?php
                                        $getStateNames = $this->module_model->getStatesName($row['varState']);
                                        echo $getStateNames;
                                        ?>
                                        <label class="error" for="varState"></label>
                                    </div>
                                    <div class="uk-width-medium-1-2" id="showDisctrict">
                                        <?php
                                        $getDistrictNamea = $this->module_model->getDisctrictsName($row['varState'], $row['varDistrict']);
                                        echo $getDistrictNamea;
                                        ?>
                                        <label class="error" for="varDistrict"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="spacer10"></div>
                        <div class="uk-form-row">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <label> Login Email ID *</label>
                                    <?php
                                    $LoginEmail = array(
                                        'name' => 'varLoginEmail',
                                        'id' => 'varLoginEmail',
                                        'maxlength' => '55',
                                        'value' => (!empty($Eid) ? $row['varLoginEmail'] : ''),
                                        'class' => 'md-input'
                                    );
                                    echo form_input($LoginEmail);
                                    ?>
                                    <label class="error" for="varLoginEmail"></label>
                                </div>

                                <div class="uk-width-medium-1-2">
                                    <label>Phone# *</label>
                                    <?php
                                    $varPhone = array(
                                        'name' => 'varPhoneNo',
                                        'id' => 'varPhoneNo',
                                        'maxlength' => '20',
                                        'value' => (!empty($Eid) ? $row['varPhoneNo'] : ''),
                                        'class' => 'md-input',
                                        'onkeypress' => 'return KeycheckOnlyPhonenumber(event)'
                                    );
                                    echo form_input($varPhone);
                                    ?>
                                    <label class="error" for="varPhoneNo"></label>
                                </div>

                            </div>
                        </div>
                        <div class="spacer10"></div> 
                        <div class="uk-form-row">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <label> Gender</label>
                                    <?php
                                    $chrGenderM = array('name' => 'chrGender', 'id' => 'chrGenderM', 'value' => 'M', 'checked' => $row['chrGender'] == 'M' || empty($Eid) ? TRUE : FALSE, 'class' => 'form-rediobutton ignore');
                                    $chrGenderF = array('name' => 'chrGender', 'id' => 'chrGenderF', 'value' => 'F', 'checked' => $row['chrGender'] == 'F' ? TRUE : FALSE, 'class' => 'form-rediobutton ignore');
                                    ?>
                                    <div class="fl mgl10">  
                                        <?php
                                        echo form_radio($chrGenderM);
                                        echo form_label('Male', 'chrGenderM');
                                        echo form_radio($chrGenderF);
                                        echo form_label('Female', 'chrGenderF');
                                        ?>    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <label> Password</label>
                                    <?php
                                    $Password = array(
                                        'name' => 'varPassword',
                                        'id' => 'varPassword',
                                        'maxlength' => 20,
                                        'class' => 'md-input'
                                    );
                                    echo form_password($Password);
                                    ?>
                                    <label class="error" for="varPassword"></label>
                                    <div class="clear"></div>
                                    <span id="pass-strength"></span>
                                </div>

                                <div class="uk-width-medium-1-2">
                                    <label> Confirm Password</label>
                                    <?php
                                    $varConfPassword = array(
                                        'name' => 'varConfPassword',
                                        'id' => 'varConfPassword',
                                        'maxlength' => 20,
                                        'class' => 'md-input'
                                    );
                                    echo form_password($varConfPassword);
                                    ?>

                                    <label class="error" for="varConfPassword"></label>
                                </div>
                            </div>
                        </div>

                        <span  class="uk-form-help-block"><i> Note: <?php echo PASSWORD_VALID_VALIDATION; ?></i></span>

                        <div class="spacer10"></div>
                        <div class="uk-form-row">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <label for="varAadharCard">Aadhar Card *</label>
                                    <?php
                                    $varAddress = array(
                                        'name' => 'varAadharCard',
                                        'id' => 'varAadharCard',
                                        'maxlength' => '14',
                                        'data-inputmask' => "'mask': '999 - 999 999 999'",
                                        'data-inputmask-showmaskonhover' => "false",
                                        'value' => (!empty($Eid) ? $row['varAadharCard'] : ''),
                                        'class' => 'md-input masked_input'
                                    );
                                    echo form_input($varAddress);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--        <div class="md-card">
                    <div class="md-card-content">
        
                        <div class="uk-form-row">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-2-2">
                                    <label > Location *</label>
        <?php
        $companyBoxdata = array(
            'name' => 'varLocation',
            'id' => 'varLocation',
            'value' => $row['varLocation'],
            'class' => 'md-input label-fixed'
        );
        echo form_input($companyBoxdata);
        ?>
                                    <label class="error" for="varLocation"></label>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>-->
        <div class="md-card">
            <div class="md-card-content">
                <!--                        <div class="uk-form-row">
                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-medium-1-2">
                                                    <label>Address</label>
                <?php
                $varAddress = array(
                    'name' => 'varAddress',
                    'id' => 'varAddress',
                    'maxlength' => '255',
                    'value' => (!empty($Eid) ? $row['varAddress'] : ''),
                    'class' => 'md-input'
                );
                echo form_input($varAddress);
                ?>
                                                </div>
                
                                                <div class="uk-width-medium-1-2">
                                                    <label>City Name</label> 
                <?php
                $VarCity = array(
                    'name' => 'varCity',
                    'id' => 'varCity',
                    'maxlength' => '50',
                    'value' => (!empty($Eid) ? $row['varCity'] : ''),
                    'class' => 'md-input'
                );
                echo form_input($VarCity);
                ?>
                                                </div>
                                            </div>
                                        </div>-->


                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label>Approve</label>
                            <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: Please select 'Yes' if you want to display / activate this record. Otherwise please select 'NO'" ?>">help</i>

                            <?php
                            if (!empty($Eid)) {
                                $publishYRadio = array(
                                    'name' => 'chrPublish',
                                    'id' => 'chrPublishY',
                                    'value' => 'Y',
                                    'class' => 'form-rediobutton',
                                    'checked' => ($row['chrPublish'] == 'Y') ? TRUE : FALSE
                                );
                                echo form_input_ready($publishYRadio, 'radio');
                                ?>                                                    
                                <a style="text-decoration:none;" onclick="if (document.getElementById('chrPublishY').checked != true)
                                                document.getElementById('chrPublishY').checked = true;" href="javascript:">Yes</a>
                                   <?php
                               } else {
                                   $publishYRadio = array(
                                       'name' => 'chrPublish',
                                       'id' => 'chrPublishY',
                                       'value' => 'Y',
                                       'class' => 'form-rediobutton',
                                       'checked' => TRUE
                                   );
                                   echo form_input_ready($publishYRadio, 'radio');
                                   ?>                                                    
                                <a style="text-decoration:none;" onclick="if (document.getElementById('chrPublishY').checked != true)
                                                document.getElementById('chrPublishY').checked = true;" href="javascript:">Yes</a>
                               <?php }
                               ?>
                               <?php
                               if (!empty($Eid)) {
                                   $publishNRadio = array(
                                       'name' => 'chrPublish',
                                       'id' => 'chrPublishN',
                                       'value' => 'N',
                                       'class' => 'form-rediobutton',
                                       'checked' => ($row['chrPublish'] == 'N') ? TRUE : FALSE
                                   );
                                   echo form_input_ready($publishNRadio, 'radio');
                                   ?>                                                    
                                <a style="text-decoration:none;" onclick="if (document.getElementById('chrPublishN').checked != true)
                                                document.getElementById('chrPublishN').checked = true;" href="javascript:">No</a>
                                   <?php
                               } else {
                                   $publishNRadio = array(
                                       'name' => 'chrPublish',
                                       'id' => 'chrPublishN',
                                       'value' => 'N',
                                       'class' => 'form-rediobutton',
                                       'checked' => FALSE
                                   );
                                   echo form_input_ready($publishNRadio, 'radio');
                                   ?>
                                <a style="text-decoration:none;" onclick="if (document.getElementById('chrPublishN').checked != true)
                                                document.getElementById('chrPublishN').checked = true;" href="javascript:">No</a>
                                   <?php
                               }
                               ?> 
                        </div>
                    </div>
                </div>

                <div class="spacer10"></div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-form-row">
                        <button class="md-btn md-btn-primary md-btn-wave-light" value="btnsaveande" name="btnsaveande" id="btnsaveande">Save &amp; Add Access</button>
                        <button class="md-btn md-btn-primary md-btn-wave-light" value="btnsaveandc" name="btnsaveandc" id="btnsaveandc">Save &amp; Keep Editing</button>
                        <button class="md-btn md-btn-primary md-btn-wave-light" name="btnsaveande" id="btnsaveande">Save &amp; Exit</button>
                        <a href="<?php echo MODULE_PAGE_NAME; ?>" title="Cancel">
                            <div  class="md-btn md-btn-wave">
                                Cancel
                            </div>
                        </a>
                    </div>
                </div>
                <div class="spacer10"></div>
            </div>
        </div>
        <?php echo form_close(); ?>    
    </div>
</div>
