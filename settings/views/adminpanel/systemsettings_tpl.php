<style>
    .user_heading {
        width: auto !important;
    }
</style>

<script type="text/javascript">
    function SetMailSettings()
    {
        if (document.getElementById('varMailer').value != 'smtp')
        {
            $('#SmtpFields').css('display', 'none');
        } else
        {
            $('#SmtpFields').css('display', 'block');
        }
    }
    $(document).ready(function ()
    {
        if ($('#p').val() == 'gen')
        {
            $.validator.addMethod("UrlValidate", function (value, element)
            {
                var fisrtchar = value.substr(0, 7);
                var fisrtchar1 = value.substr(0, 8);
                if (fisrtchar != 'http://' && fisrtchar1 != 'https://')
                {
                    return false;
                } else
                {
                    return true;
                }
            }, '<?php echo SET_VALID_URL_MSG ?>');
            $.validator.addMethod("pagesizecheck", function (value, element) {
                if (value > 50 || value < 10) {
                    return false;
                } else
                {
                    return true;
                }
            }, '<?php echo SET_VALID_PAGESIZE_MSG ?>');
            $.validator.addMethod("PercentCheck", function (value, element)
            {
                if (value > 100 || value < 0)
                {
                    return false;
                } else
                {
                    return true;
                }
            }, '<?php echo SET_VALID_PERG_MSG ?>');
            $("#frmgeneralsetting").validate({
                rules: {
                    varSiteName: "required",
                    varSitePath: {
                        required: true,
                        UrlValidate: true
                    },
                    varAdminpanelPagesize: {
                        required: true
                    },
                    varFrontPagesize: {
                        required: true
                    },
                    varDropboxBetaSk: {
                        required: true,
                        PercentCheck: true
                    },
                    varDropboxLiveSk: {
                        required: true,
                        PercentCheck: true
                    }
                },
                messages: {
                    varSiteName: '<?php echo SET_SITENAME_MSG ?>',
                    varSitePath: {
                        required: '<?php echo SET_SITEPATH_MSG ?>'
                    },
                    varAdminpanelPagesize: {
                        required: '<?php echo SET_ADMINPANEL_PAGESIZE_MSG ?>'
                    },
                    varFrontPagesize: {
                        required: '<?php echo SET_FRONT_PAGESIZE_MSG ?>'
                    },
                    varDropboxBetaSk: {
                        required: '<?php echo DROP_BETA ?>'
                    },
                    varDropboxLiveSk: {
                        required: '<?php echo DROP_LIVE ?>'
                    }
                },
                errorPlacement: function (error, element) {
                    if (element.attr('name') == 'chrDropboxBeta') {
                        error.insertAfter($("#dropboxerr"));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        } else if ($('#p').val() == 'ser')
        {
            $("#frmgeneralsetting").validate({
                rules: {
                    varMailer: "required",
                    varSmtpServer: "required",
                    varSmtpUserName: {
                        required: true,
                        email: true
                    },
                    varSmtpPassword: {
                        required: true,
                        minlength: 5
                    },
                    varSmtpPort: "required",
                    varSenderName: "required",
                    varSenderEmail: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    varMailer: '<?php echo SET_MAILER_MSG ?>',
                    varSmtpServer: '<?php echo SET_SMTP_SERVER_MSG ?>',
                    varSmtpUserName: {
                        required: '<?php echo SET_SMTP_USERNAME_MSG ?>',
                        email: '<?php echo SET_SMTP_USERNAME_MSG_VALID ?>'
                    },
                    varSmtpPassword: {
                        required: '<?php echo SET_SMTP_PWD_MSG ?>',
                        minlength: '<?php echo SET_SMTP_PWD_MSG_LENTH ?>'
                    },
                    varSmtpPort: '<?php echo SET_SMTP_PORT ?>',
                    varSenderName: '<?php echo SET_SENDER_NAME_MSG ?>',
                    varSenderEmail: {
                        required: '<?php echo SET_SENDER_EMAIL_MSG ?>',
                        email: '<?php echo SET_SENDER_EMAIL_VALID_MSG ?>'
                    }
                }
            });
        } else if ($('#p').val() == 'soc')
        {
            $.validator.addMethod("UrlValidateForLink", function (value, element) {
                var fisrtchar = value.substr(0, 11);
                var fisrtchar1 = value.substr(0, 12);
                var fisrtchar2 = value.substr(0, 7);
                var fisrtchar3 = value.substr(0, 8);
                var valid_extensions = /(\.com|\.in|\.au|\.info\.biz|\.nz|\.org|\.net|\.int|\.edu|\.gov|\.mil)$/i;
                if ((fisrtchar == 'http://www.' || fisrtchar1 == 'https://www.' || fisrtchar2 == 'http://' || fisrtchar3 == 'https://' || fisrtchar1 == ''))
                {
                    var varFacebookLink = document.getElementById('varFacebookLink').value;
                    var varGooglePlusLink = document.getElementById('varGooglePlusLink').value;
                    var varTwitterLink = document.getElementById('varTwitterLink').value;
                    var varLinkedInLink = document.getElementById('varLinkedInLink').value;
                    var varInstagramLink = document.getElementById('varInstagramLink').value;
                    var varGithubLink = document.getElementById('varGithubLink').value;
                    if (varFacebookLink == 'http://' || varFacebookLink == '' || varFacebookLink == 'http://www.') {
                        return true;
                    }
                    if (varGithubLink == 'http://' || varGithubLink == '' || varGithubLink == 'http://www.') {
                        return true;
                    }
                    if (varInstagramLink == 'http://' || varInstagramLink == '' || varInstagramLink == 'http://www.') {
                        return true;
                    }
                    if (varGooglePlusLink == 'http://' || varGooglePlusLink == '' || varGooglePlusLink == 'http://www.') {
                        return true;
                    }
                    if (varTwitterLink == 'http://' || varTwitterLink == '' || varTwitterLink == 'http://www.') {
                        return true;
                    }
                    if (varLinkedInLink == 'http://' || varLinkedInLink == '' || varLinkedInLink == 'http://www.') {
                        return true;
                    } else {
                        return checkurl1(varFacebookLink, varGooglePlusLink, varTwitterLink, varLinkedInLink, varGithubLink);
                    }
                } else
                {
                    return false;
                }
            }, '<div class="fl mgt5"><?php echo SET_VALID_URL_MSG ?></div>');
            $("#frmgeneralsetting").validate({
                rules: {
                    varFacebookLink:
                            {
                                UrlValidateForLink: {
                                    depends: function ()
                                    {
                                        if (document.getElementById('varFacebookLink').value != '')
                                        {
                                            return true;
                                        } else
                                        {
                                            return false;
                                        }
                                    }
                                }
                            },
                    varTwitterLink:
                            {
                                UrlValidateForLink:
                                        {
                                            depends: function ()
                                            {
                                                if (document.getElementById('varTwitterLink').value != '')
                                                {
                                                    return true;
                                                } else
                                                {
                                                    return false;
                                                }
                                            }
                                        }
                            },
                    varGithubLink:
                            {
                                UrlValidateForLink:
                                        {
                                            depends: function ()
                                            {
                                                if (document.getElementById('varGithubLink').value != '')
                                                {
                                                    return true;
                                                } else
                                                {
                                                    return false;
                                                }
                                            }
                                        }
                            },
                    varInstagramLink:
                            {
                                UrlValidateForLink:
                                        {
                                            depends: function ()
                                            {
                                                if (document.getElementById('varInstagramLink').value != '')
                                                {
                                                    return true;
                                                } else
                                                {
                                                    return false;
                                                }
                                            }
                                        }
                            },
                    varLinkedInLink: {
                        UrlValidateForLink:
                                {
                                    depends: function ()
                                    {
                                        if (document.getElementById('varLinkedInLink').value != '')
                                        {
                                            return true;
                                        } else
                                        {
                                            return false;
                                        }
                                    }
                                }
                    },
                    varGooglePlusLink: {
                        UrlValidateForLink:
                                {
                                    depends: function ()
                                    {
                                        if (document.getElementById('varGooglePlusLink').value != '')
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
                    varFacebookLink: {required: '<div class="fl mgt5"><?php echo VALID_LINK_MSG ?></div>'},
                    varInstagramLink: {required: '<div class="fl mgt5"><?php echo VALID_LINK_MSG ?></div>'},
                    varGithubLink: {required: '<div class="fl mgt5"><?php echo VALID_LINK_MSG ?></div>'},
                    varGooglePlusLink: {required: '<div class="fl mgt5"><?php echo VALID_LINK_MSG ?></div>'},
                    varTwitterLink: {required: '<div class="fl mgt5"><?php echo VALID_LINK_MSG ?></div>'},
                    varLinkedInLink: {required: '<div class="fl mgt5"><?php echo VALID_LINK_MSG ?></div>'}
                }
            });
        } else if ($('#p').val() == 'seo') {
            $("#frmgeneralsetting").validate({
                rules: {
                    VarMetaTitle: "required",
                    VarMetaKeyword: "required",
                    VarMetaDescription: "required"
                },
                messages: {
                    VarMetaTitle: 'Please enter meta title.',
                    VarMetaKeyword: 'Please enter meta keyword.',
                    VarMetaDescription: 'Please enter meta description.'
                }
            });
        } else if ($('#p').val() == 'thumb') {
            $("#frmgeneralsetting").validate({
                rules: {
                    varHomeBannerThumb: "required",
                    varInnerBannerThumb: "required",
                    varBlogThumb: "required",
                    varBlogDetailThumb: "required",
                    varCareerThumb: "required",
                    varProductCategoryThumb: "required",
                    varProductThumb: "required",
                    varPlanThumb: "required",
                    varBuyLeadThumb: "required",
                    varSellLeadThumb: "required",
                    varServiceThumb: "required",
                    varUserThumb: "required",
                    varTestimonialsThumb: "required"
                },
                messages: {
                    varHomeBannerThumb: 'Please enter home banner thumb size.',
                    varInnerBannerThumb: "Please enter inner banner thumb size.",
                    varBlogThumb: "Please enter blog thumb size.",
                    varBlogDetailThumb: "Please enter blog detail thumb size.",
                    varCareerThumb: "Please enter career thumb size.",
                    varProductCategoryThumb: "Please enter product category thumb size.",
                    varProductThumb: "Please enter product thumb size.",
                    varBuyLeadThumb: "Please enter buy lead thumb size.",
                    varSellLeadThumb: "Please enter sell lead thumb size.",
                    varServiceThumb: "Please enter service thumb size.",
                    varUserThumb: "Please enter user thumb size.",
                    varTestimonialsThumb: "Please enter testimonial thumb size."
                }
            });
        }
    });
    function CheckDropBoxkey(flag)
    {
        if (flag == 'DB')
        {
            document.getElementById('chrDropboxBeta1').checked = true;
            $('#PercTag').css('display', 'none');
            $('#PriceTag').css('display', '');
        } else
        {
            document.getElementById('chrDropboxBeta2').checked = true;
            $('#PriceTag').css('display', 'none');
            $('#PercTag').css('display', '');
        }
    }
    function ConForm(Type) {
        var appendurl;
        var conf = jConfirm("Are you sure you want to run this cron. Press OK to confirm.", 'Confirmation Dialog', function (r) {
            if (r) {
                if (Type == 'PageHit') {
                    var CronName = "Page Hit";
                    var url = SITE_PATH + 'cron/PageHit';
                }
                if (Type == 'EmailLog') {
                    var CronName = "Email Log";
                    var url = SITE_PATH + 'cron/EmailLog_Del';
                }
                if (Type == 'LoginDetail') {
                    var CronName = "Login Detail";
                    var url = SITE_PATH + 'cron/LoginDetail';
                }
                if (Type == 'LogmanagerLog') {
                    var CronName = "Logmanager Logs";
                    var url = SITE_PATH + 'cron/LogmanagerLog';
                }
                /* if (Type == 'paymentReport'){
                 var CronName = "Payment Report";
                 var url = SITE_PATH + 'cron';
                 } */
                appendurl = '';
                $.ajax({
                    type: "POST",
                    url: url,
                    data: appendurl,
                    async: false,
                    success: function (data) {
                        if (data == '1') {
                            jAlert('Cron successfully run.');
                        } else {
                            jAlert(CronName + ' Cron run was unsuccessful.');
                        }
                    }
                });
            } else {
                return false;
            }
        });
    }
</script>
<script>
    function Delete_hits(id) {
        UIkit.modal.confirm('Caution! The hits will be deleted. Press OK to confirm.', function () {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>adminpanel/settings/HitDelete?",
                data: "&hitsid=" + id + "&" + csrfName + "=" + csrfHash,
                async: true,
                success: function (values) {
                    UIkit.modal.alert('Congratulation hits are deleted successfully.');
                    return false;
                }
            });
        });
    }
</script>

<div id="page_content_inner">
    <div id="page_content">
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                <li><span>  <?php
                        if (!empty($eid)) {
                            echo 'Edit - ' . $Row_Pages['varTitle'];
                        } else {
                            echo 'Settings';
                        }
                        ?>
                    </span></li>
            </ul>
        </div>

       <?php
        if (validation_errors() != '') {
            echo '<div class="md-card-list-wrapper"><div class="md-card-list"><ul class="hierarchical_slide uk-text-danger" id="hierarchical-slide"><li>';
            echo validation_errors();
            echo '</li></ul></div></div>';
        }
        ?>
        <div class="uk-text-danger" style="float:right;">* Required Field</div>
        <div class="clear"></div>
        <?php
        if ($this->input->get_post('p') == "gen") {
            $Gen = $this->input->get_post('p');
        } else {
            $Gen = 'gen';
        }
        $Action = MODULE_URL . 'savesystemsettings';
        $Attributes = array('name' => 'frmgeneralsetting', 'id' => 'frmgeneralsetting', 'enctype' => 'multipart/form-data');
        echo form_open($Action, $Attributes);
        ?>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                echo $Gridtabs;
                /* ------------------------PART OF GENERAL SETTINGS *----------------------- */
                if ($this->input->get_post('p') == "gen" || $this->input->get_post('p') == "") {
                    $hd_arr = array('p' => $Gen);
                    echo form_hidden($hd_arr);
                    ?>
                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <label>Site Name *</label>
                                <?php
                                $SiteNameData = array(
                                    'name' => 'varSiteName',
                                    'id' => 'varSiteName',
                                    'value' => htmlspecialchars($Row['varSiteName']),
                                    'class' => 'md-input'
                                );
                                echo form_input($SiteNameData);
                                ?>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <label>Site Path *</label>
                                <?php
                                $SitePath = array(
                                    'name' => 'varSitePath',
                                    'id' => 'varSitePath',
                                    'value' => $Row['varSitePath'],
                                    'class' => 'md-input'
                                );
                                echo form_input($SitePath);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <label> Default AdminPanel Page Size</label>
                                <?php
                                $selected_idsT = Array();
                                array_push($selected_idsT, $Row['varAdminpanelPagesize']);
                                $optionsT = Array('5' => ' 5 ', '10' => ' 10 ', '15' => ' 15 ', '30' => ' 30 ', 'All' => 'All');
                                echo form_dropdown('varAdminpanelPagesize', $optionsT, $selected_idsT, 'class="md-input"');
                                ?>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <?php
                                $selected_idsFront = Array();
                                array_push($selected_idsFront, $Row['varFrontPagesize']);
                                $options = Array('5' => ' 5 ', '10' => ' 10 ', '15' => ' 15 ', '30' => ' 30 ');
                                echo form_dropdown('varFrontPagesize', $options, $selected_idsFront, 'class="md-input"');
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <label> Front Date Format <?php echo DEFAULT_FRONT_DATEFORMAT; ?></label>
                                <?php
                                $selected_idsF = Array();
                                array_push($selected_idsF, $Row['varFrontDateFormat']);
                                $optionsF = Array('%d/%m/%Y' => 'd/m/Y (Eg.: 29/12/2014)', '%m/%d/%Y' => 'm/d/Y (Eg.: 12/29/2014)', '%Y/%m/%d' => 'Y/m/d (Eg.: 2014/12/29)', '%Y/%d/%m' => 'Y/d/m (Eg.: 2014/29/12)', '%M/%d/%Y' => 'M/d/Y (Eg.: Dec/29/2014)');
                                echo form_dropdown('varFrontDateFormat', $optionsF, $selected_idsF, 'class="md-input" id="varFrontDateFormat"');
                                ?>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <label>Admin Panel Date Format</label>
                                <?php
                                $selected_idsP = Array();
                                array_push($selected_idsP, $Row['varAdminpanelDateFormat']);
                                $optionsP = Array('%d/%m/%Y' => 'd/m/Y (Eg.: 29/12/2014)', '%m/%d/%Y' => 'm/d/Y (Eg.: 12/29/2014)', '%Y/%m/%d' => 'Y/m/d (Eg.: 2014/12/29)', '%Y/%d/%m' => 'Y/d/m (Eg.: 2014/29/12)', '%M %d %Y' => 'M/d/Y (Eg.: Dec 29 2014)');
                                echo form_dropdown('varAdminpanelDateFormat', $optionsP, $selected_idsP, 'class="md-input" id="varAdminpanelDateFormat"');
                                ?>
                            </div>
                        </div>
                    </div>


                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <label>AdminPanel Time Format</label>
                                <?php
                                $selected_idsT = Array();
                                array_push($selected_idsT, $Row['varAdminpanelTimeFormat']);
                                $optionsT = Array('%h:%i %p' => '12 Hours', '%H:%i' => '24 Hours');
                                echo form_dropdown('varAdminpanelTimeFormat', $optionsT, $selected_idsT, 'class="md-input" id="varAdminpanelTimeFormat"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <label>Dropbox Beta Key *</label>
                                <?php
                                $dropbox_key = array(
                                    'name' => 'varDropboxBetaSk',
                                    'id' => 'varDropboxBetaSk',
                                    'value' => $Row['varDropboxBetaSk'],
                                    'class' => 'md-input'
                                );
                                echo form_input($dropbox_key);
                                ?>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <label>Dropbox Live Key *</label>
                                <?php
                                $dropbox_live_key = array(
                                    'name' => 'varDropboxLiveSk',
                                    'id' => 'varDropboxLiveSk',
                                    'value' => $Row['varDropboxLiveSk'],
                                    'class' => 'md-input'
                                );
                                echo form_input($dropbox_live_key);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="md-card-content">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-form-row">
                            <a href="javascript:;" onclick="return Delete_hits('A')" id="allhits" class="md-btn md-btn-wave">Clear All Hits</a>
                            <a href="javascript:;" onclick="return Delete_hits('W')" id="webhits" class="md-btn md-btn-wave">Clear Web Hits</a>
                            <a href="javascript:;" onclick="return Delete_hits('M')" id="mobhits" class="md-btn md-btn-wave">Clear Device Hits</a>
                        </div>
                    </div>
                </div>
                <!--<div class="spacer10"></div>-->
                <?php
            }
            /* ----------------------------PART OF EMAIL SETTINGS --------------------------- */
            if ($this->input->get_post('p') == "ser") {
                if ($Row['varMailer'] == 'sendmail') {
                    $Style = "style='display:none;'";
                }
                ?>
                <div class="contact-title" >Email Settings</div>
                <div class="spacer10"></div>
                <?php
                echo form_hidden('p', $this->input->get_post('p'));
                ?>
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label>Mailer *</label>
                            <?php
                            $selected_idsMailer = Array();
                            array_push($selected_idsMailer, $Row['varMailer']);
                            $OptionsMailer = Array('sendmail' => 'Send Mail', 'smtp' => 'SMTP');
                            echo form_dropdown('varMailer', $OptionsMailer, $selected_idsMailer, 'class="md-input" id="varMailer" onchange="return SetMailSettings();" ');
                            ?>
                        </div>
                    </div>
                </div> 
                <div class="spacer10"></div>
                <div id="SmtpFields" <?php echo $Style ?>>
                    <div class="uk-form-row" >
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <label>SMTP Server Name *</label>
                                <?php
                                $SmtpServerdata = array(
                                    'name' => 'varSmtpServer',
                                    'id' => 'varSmtpServer',
                                    'value' => htmlspecialchars($Row['varSmtpServer']),
                                    'class' => 'md-input'
                                );
                                echo form_input($SmtpServerdata);
                                ?>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <label>SMTP User Name</label>
                                <?php
                                $SmtpUserNamedata = array(
                                    'name' => 'varSmtpUserName',
                                    'id' => 'varSmtpUserName',
                                    'value' => htmlspecialchars($Row['varSmtpUserName']),
                                    'class' => 'md-input'
                                );
                                echo form_input($SmtpUserNamedata);
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <label>SMTP Password *</label>
                                <?php
                                $SmtpPossdata = array(
                                    'name' => 'varSmtpPassword',
                                    'id' => 'varSmtpPassword',
                                    'value' => $this->mylibrary->decryptPass($Row['varSmtpPassword']),
                                    'maxlength' => '30',
                                    'class' => 'md-input'
                                );
                                echo form_password($SmtpPossdata, 'password');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <label>MTP Authentication *</label>
                                <input type="radio" class="form-rediobutton" id="Y" <?php echo $Row['chrSmtpAuthentication'] == 'Y' ? 'checked="checked"' : '' ?> value="Y" name="chrSmtpAuthentication">   
                                &nbsp; <a href="javascript:" onclick="if (document.getElementById('Y').checked != true)
                                            document.getElementById('Y').checked = true;" style="text-decoration: none;"> Yes</a> &nbsp;&nbsp;&nbsp;
                                <input type="radio" class="form-rediobutton" id="N" <?php echo $Row['chrSmtpAuthentication'] == 'N' ? 'checked="checked"' : '' ?> value="N" name="chrSmtpAuthentication">                                                
                                &nbsp; <a style="text-decoration: none;" onclick="if (document.getElementById('N').checked != true)
                                            document.getElementById('N').checked = true;" href="javascript:"> No</a>
                            </div>
                        </div>
                    </div>

                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <label>SMTP Port *</label>
                                <?php
                                $SmtpPortdata = array(
                                    'name' => 'varSmtpPort',
                                    'id' => 'varSmtpPort',
                                    'value' => $Row['varSmtpPort'],
                                    'maxlength' => '10',
                                    'tdoption' => Array('TDDisplay' => 'Y'),
                                    'class' => 'md-input'
                                );
                                echo form_input($SmtpPortdata);
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <label>SMTP Name *</label>
                                <?php
                                $SeNBoxdata = array(
                                    'name' => 'varSenderName',
                                    'id' => 'varSenderName',
                                    'value' => $Row['varSenderName'],
                                    'class' => 'md-input'
                                );
                                echo form_input($SeNBoxdata);
                                ?>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <label>SMTP Email ID *</label>
                                <?php
                                $SEmailBoxdata = array(
                                    'name' => 'varSenderEmail',
                                    'id' => 'varSenderEmail',
                                    'value' => $Row['varSenderEmail'],
                                    'class' => 'md-input'
                                );
                                echo form_input($SEmailBoxdata);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-2-2">
                            <label>Email Signature</label>
                            <?php
                            $sendClientDetail = stripcslashes(htmlspecialchars_decode($Row['varEmailSignature']));
                            echo $this->mylibrary->load_ckeditor('varEmailSignature', $sendClientDetail, '', '', 'OnlyBasic');
                            ?>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <!--</div>-->
            <!--PART OF SOCIAlS-->
            <?php
        } if ($this->input->get_post('p') == "soc") {
            ?>
            <div class="contact-title" > Social Settings</div>
            <div class="spacer10"></div>
            <div class="inquiry-form">
                <div class="clear"></div>
                <?php
                echo form_hidden('p', $this->input->get_post('p'));
                ?>   

                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label>Facebook Link</label>
                            <?php
                            $FacebookLinkdata = array(
                                'name' => 'varFacebookLink',
                                'id' => 'varFacebookLink',
                                'value' => htmlspecialchars($Row['varFacebookLink']),
                                'class' => 'md-input'
                            );
                            echo form_input($FacebookLinkdata);
                            ?>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <label>Twitter Link</label>
                            <?php
                            $TwitterLinkdata = array(
                                'name' => 'varTwitterLink',
                                'id' => 'varTwitterLink',
                                'value' => htmlspecialchars($Row['varTwitterLink']),
                                'class' => 'md-input'
                            );
                            echo form_input($TwitterLinkdata);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label>Google+ Link</label>
                            <?php
                            $GooglePlusLinkdata = array(
                                'name' => 'varGooglePlusLink',
                                'id' => 'varGooglePlusLink',
                                'value' => htmlspecialchars($Row['varGooglePlusLink']),
                                'class' => 'md-input'
                            );
                            echo form_input($GooglePlusLinkdata);
                            ?>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <label>Linked In Link</label>
                            <?php
                            $Linkedindata = array(
                                'name' => 'varLinkedInLink',
                                'id' => 'varLinkedInLink',
                                'value' => htmlspecialchars($Row['varLinkedInLink']),
                                'class' => 'md-input'
                            );
                            echo form_input($Linkedindata);
                            ?>
                        </div>
                    </div>
                </div>

                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label for="varInstagramLink">Instagram Link</label>
                            <?php
                            $Instagramdata = array(
                                'name' => 'varInstagramLink',
                                'id' => 'varInstagramLink',
                                'value' => htmlspecialchars($Row['varInstagramLink']),
                                'class' => 'md-input'
                            );
                            echo form_input($Instagramdata);
                            ?>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <label>Github Link</label>
                            <?php
                            $varGithubLinkdata = array(
                                'name' => 'varGithubLink',
                                'id' => 'varGithubLink',
                                'value' => htmlspecialchars($Row['varGitHubLink']),
                                'class' => 'md-input'
                            );
                            echo form_input($varGithubLinkdata);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>  
            </div>
            <div class="clear"></div> 
            <!--END SOCIALS-->
            <?php
        }
        if ($this->input->get_post('p') == 'seo' && $this->session->userdata('UserId') == 1) {
            ?>
            <div class="contact-title" > SEO Settings</div>
            <div class="spacer10"></div>
            <?php
            echo form_hidden('p', $this->input->get_post('p'));
            ?>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-2-2">
                        <label>Google Analytic Code</label>
                        <?php
                        $data = array(
                            'name' => 'varGoogleanAlyticcode',
                            'id' => 'varGoogleanAlyticcode',
                            'rows' => '4',
                            'class' => "md-input",
                            'value' => trim($Row['varGoogleanAlyticcode']),
                        );
                        echo form_textarea($data);
                        ?>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label>Meta Title</label>

                        <?php
                        $data = array(
                            'name' => 'VarMetaTitle',
                            'id' => 'VarMetaTitle',
                            'value' => trim($Row['VarMetaTitle']),
                            'maxlength' => '100',
                            'class' => 'md-input'
                        );
                        echo form_input($data);
                        ?>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <label>Meta Keyword</label>
                        <?php
                        $data = array(
                            'name' => 'VarMetaKeyword',
                            'id' => 'VarMetaKeyword',
                            'value' => trim($Row['VarMetaKeyword']),
                            'maxlength' => '100',
                            'class' => 'md-input'
                        );
                        echo form_input($data);
                        ?>
                    </div>
                </div>
            </div>

            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label>Meta Description</label>
                        <?php
                        $data = array(
                            'name' => 'VarMetaDescription',
                            'id' => 'VarMetaDescription',
                            'class' => "textarea",
                            'value' => trim($Row['VarMetaDescription']),
                            'cols' => '160',
                            'rows' => '4',
                            'class' => 'md-input'
                        );
                        echo form_textarea($data);
                        ?>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <label>Meta Tag</label>
                        <?php
                        $data = array(
                            'name' => 'varCommonMetatags',
                            'id' => 'varCommonMetatags',
                            'class' => "textarea",
                            'value' => trim($Row['varCommonMetatags']),
                            'cols' => '160',
                            'rows' => '4',
                            'class' => 'md-input'
                        );
                        echo form_textarea($data);
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
        /* -----------------------------------PART FOR FAC--------------------------- */
        ?>
        <div class="clear"></div>    
        <!-- ----- Part of Thumb Start -------- -->
        <?php
        if ($this->input->get_post('p', true) == 'thumb' && $this->session->userdata('UserId', true) == '1') {
            ?>
            <div class="contact-title">Thumb Settings</div>
            <?php
            echo form_hidden('p', $this->input->get_post('p'));
            ?>
            <div class="spacer10"></div>

            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label>Home Banner Thumb Size *</label>
                        <?php
                        $data = array(
                            'name' => 'varHomeBannerThumb',
                            'id' => 'varHomeBannerThumb',
                            'value' => $Row['varHomeBannerThumb'],
                            'maxlength' => '20',
                            'class' => 'md-input'
                        );
                        echo form_input($data);
                        ?>
                        <label class="error" for="varHomeBannerThumb"></label>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <label>Inner Banner Thumb Size *</label>
                        <?php
                        $data = array(
                            'name' => 'varInnerBannerThumb',
                            'id' => 'varInnerBannerThumb',
                            'value' => $Row['varInnerBannerThumb'],
                            'maxlength' => '20',
                            'class' => 'md-input'
                        );
                        echo form_input($data);
                        ?>
                        <label class="error" for="varInnerBannerThumb"></label>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label>Blogs Thumb Size *</label>
                        <?php
                        $data = array(
                            'name' => 'varBlogThumb',
                            'id' => 'varBlogThumb',
                            'value' => $Row['varBlogThumb'],
                            'maxlength' => '20',
                            'class' => 'md-input'
                        );
                        echo form_input($data);
                        ?>
                        <label class="error" for="varBlogThumb"></label>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <label>Blogs Detail Thumb Size *</label>
                        <?php
                        $data = array(
                            'name' => 'varBlogDetailThumb',
                            'id' => 'varBlogDetailThumb',
                            'value' => $Row['varBlogDetailThumb'],
                            'maxlength' => '20',
                            'class' => 'md-input'
                        );
                        echo form_input($data);
                        ?>
                        <label class="error" for="varBlogDetailThumb"></label>
                    </div>
                </div>
            </div>

            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label>Career Thumb Size *</label>
                        <?php
                        $data = array(
                            'name' => 'varCareerThumb',
                            'id' => 'varCareerThumb',
                            'value' => $Row['varCareerThumb'],
                            'maxlength' => '20',
                            'class' => 'md-input'
                        );
                        echo form_input($data);
                        ?>
                        <label class="error" for="varCareerThumb"></label>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <label>Product Category Thumb Size *</label>
                        <?php
                        $data = array(
                            'name' => 'varProductCategoryThumb',
                            'id' => 'varProductCategoryThumb',
                            'value' => $Row['varProductCategoryThumb'],
                            'maxlength' => '20',
                            'class' => 'md-input'
                        );
                        echo form_input($data);
                        ?>
                        <label class="error" for="varProductCategoryThumb"></label>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label>Product Thumb Size *</label>
                        <?php
                        $data = array(
                            'name' => 'varProductThumb',
                            'id' => 'varProductThumb',
                            'value' => $Row['varProductThumb'],
                            'maxlength' => '20',
                            'class' => 'md-input'
                        );
                        echo form_input($data);
                        ?>
                        <label class="error" for="varProductThumb"></label>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <label>Plan Thumb Size *</label>
                        <?php
                        $data = array(
                            'name' => 'varPlanThumb',
                            'id' => 'varPlanThumb',
                            'value' => $Row['varPlanThumb'],
                            'maxlength' => '20',
                            'class' => 'md-input'
                        );
                        echo form_input($data);
                        ?>
                        <label class="error" for="varPlanThumb"></label>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label>Buy Lead Thumb Size *</label>
                        <?php
                        $data = array(
                            'name' => 'varBuyLeadThumb',
                            'id' => 'varBuyLeadThumb',
                            'value' => $Row['varBuyLeadThumb'],
                            'maxlength' => '20',
                            'class' => 'md-input'
                        );
                        echo form_input($data);
                        ?>
                        <label class="error" for="varBuyLeadThumb"></label>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <label>Sell Lead Thumb Size *</label>
                        <?php
                        $data = array(
                            'name' => 'varSellLeadThumb',
                            'id' => 'varSellLeadThumb',
                            'value' => $Row['varSellLeadThumb'],
                            'maxlength' => '20',
                            'class' => 'md-input'
                        );
                        echo form_input($data);
                        ?>
                        <label class="error" for="varSellLeadThumb"></label>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label>Service Thumb Size *</label>
                        <?php
                        $data = array(
                            'name' => 'varServiceThumb',
                            'id' => 'varServiceThumb',
                            'value' => $Row['varServiceThumb'],
                            'maxlength' => '20',
                            'class' => 'md-input'
                        );
                        echo form_input($data);
                        ?>
                        <label class="error" for="varServiceThumb"></label>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <label>User Thumb Size *</label>
                        <?php
                        $data = array(
                            'name' => 'varUserThumb',
                            'id' => 'varUserThumb',
                            'value' => $Row['varUserThumb'],
                            'maxlength' => '20',
                            'class' => 'md-input'
                        );
                        echo form_input($data);
                        ?>
                        <label class="error" for="varUserThumb"></label>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label>Testimonial Thumb Size *</label>
                        <?php
                        $data = array(
                            'name' => 'varTestimonialsThumb',
                            'id' => 'varTestimonialsThumb',
                            'value' => $Row['varTestimonialsThumb'],
                            'maxlength' => '20',
                            'class' => 'md-input'
                        );
                        echo form_input($data);
                        ?>
                        <label class="error" for="varTestimonialsThumb"></label>
                    </div>
                    <!--                        <div class="uk-width-medium-1-2">
                                                <label>User Thumb Size *</label>
                    <?php
//                            $data = array(
//                                'name' => 'varUserThumb',
//                                'id' => 'varUserThumb',
//                                'value' => $Row['varUserThumb'],
//                                'maxlength' => '20',
//                                'class' => 'md-input'
//                            );
//                            echo form_input($data);
                    ?>
                                                <label class="error" for="varUserThumb"></label>
                                            </div>-->
                </div>
            </div>

            <div class="spacer10"></div> 
        </div>
        <div class="spacer10"></div>
    <?php } ?>
    <!-- ----- Part of Thumb Done -------- -->
    <?php
    /* ------------------------PART OF Cron ------------------------ */
    if ($this->input->get_post('p', true) == 'cron' && $this->session->userdata('UserId', true) == '1') {
        ?>
        <div class="contact-title">Cron</div>
        <?php
        echo form_hidden('p', $this->input->get_post('p'));
        ?>
        <div class="spacer10"></div>
        <div class="fix_width" id="dvpersonalinformation">
            <div class="inquiry-form">
                <div class="fl title-w"> 
                    <div class="title-form fl">Page Hit Cron:</div>
                    <div class="fl">
                        <a href="javascript:;" onClick="ConForm('PageHit')">&nbsp;&nbsp;&nbsp;<strong>Execute</strong></a>
                    </div>                        
                    <span class="fl spannote">Please take a note that page hits will be set Zero once cron is executed.</span>
                </div>
                <div class="clear"></div>  
                <div class="fl title-w"> 
                    <div class="title-form fl">Log Manager Cron:</div>
                    <div class="fl">
                        <a href="javascript:;"  onClick="ConForm('LogmanagerLog')">&nbsp;&nbsp;&nbsp;<strong>Execute</strong></a>
                    </div>        
                    <span class="fl spannote">Please take a note that all the 2 months earlier records will be deleted from Log Manager once cron is executed.</span>
                </div>
                <div class="clear"></div>  
                <div class="fl title-w"> 
                    <div class="title-form fl">Email Log Cron:</div>
                    <div class="fl">
                        <a href="javascript:;"  onClick="ConForm('EmailLog')">&nbsp;&nbsp;&nbsp;<strong>Execute</strong></a>
                    </div>  
                    <span class="fl spannote">Please take a note that all the 1 month earlier Email Logs will be deleted once the cron is executed.</span>
                </div>
                <div class="clear"></div>  
                <div class="fl title-w"> 
                    <div class="title-form fl">Login Detail Cron:</div>
                    <div class="fl">
                        <a href="javascript:;"  onClick="ConForm('LoginDetail')">&nbsp;&nbsp;&nbsp;<strong>Execute</strong></a>
                    </div> 
                    <span class="fl spannote">Please take a note that all the 1 month earlier Login Logs of (Front and AdminPanel) Users will be deleted once the cron is executed.</span>
                </div>
                <div class="clear"></div>
                <!--                    <div class="fl title-w"> 
                                        <div class="title-form fl">Payment Report Cron:</div>
                                        <div class="fl">
                                            <a href="javascript:;"  onClick="ConForm('paymentReport')">&nbsp;&nbsp;&nbsp;<strong>Execute</strong></a>
                                        </div> 
                                        <span class="fl spannote">Please take a note that the cron will be automatically executed once in a day and if in case the cron runs again, it will overwrite last generated file of the day.</span>
                                    </div>
                                    <div class="clear"></div>-->
            </div>
        </div>
        <div class="spacer10"></div>   
        <?php
    }
    if ($this->input->get_post('p', true) != 'cron') {
        ?> 
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-form-row">
                    <input name="h_save" type="hidden" id="h_save" value="T" />
                    <button class="md-btn md-btn-primary md-btn-wave-light" name="btnsaveandc_x" value="btnsaveandc_x" id="btnsaveandc">Save &amp; Keep Editing</button>
                    <a href="<?php echo ADMINPANEL_URL . 'settings/systemsettings'; ?>" title="Cancel">
                        <div  class="md-btn md-btn-wave">
                            Cancel
                        </div>
                    </a>

                    <div class="spacer10"></div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
</div>
</div>
</div>

<?php echo form_close(); ?>    
<div class="spacer20"></div> 