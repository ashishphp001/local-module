<script type="text/javascript">
    function verify(id = "") {

        if (id == '') {
            var CheckedLength = $("input[type='checkbox'][name='chkgrow']:checked").length;
            if (CheckedLength == 0) {
                UIkit.modal.alert('Please select atleast one record to be deleted.');
                return false;
            }
            UIkit.modal.confirm('Caution! The selected records will be deleted. Press OK to confirm.', function () {
                if (CheckedLength > 0) {
                    SendGridBindRequest('<?php echo $this->Module_Model->DeleteCarrierName ?>', 'gridbody', 'D', 'chkgrow');
                    location.reload();
                }
            });
    }
    }
</script>

<script type="text/javascript">

    $(document).ready(function () {
        $("#FrmEmails").validate({
            ignore: [],
            rules: {
                varEmails: {
                    required: {
                        depends: function () {
                            if ($("#chrCustom").is(":checked")) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                varSubject: {
                    required: true
                },
                txtDescription: {
                    required: true
                }
            },
            messages: {
                varEmails: {
                    required: "Please enter email."
                },
                varSubject: {
                    required: "Please enter subject."
                },
                txtDescription: {
                    required: "Please enter description."
                },
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
    });</script>

<script type="text/javascript">
    function showUsers(type) {
        if (type == 'C')
        {
            document.getElementById('showusers').style.display = '';
        } else {
            document.getElementById('showusers').style.display = 'none';
        }
    }
</script>

<div class="content-wrapper">

    <div id="page_content">
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                <li><span>Manage Bulk Email</span></li>
            </ul>
        </div>
        <div class="spacer10"></div>

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
            <div class="md-card">
                <div class="md-card-content">

                    <form id="FrmEmails" name="FrmEmails" action="<?php echo MODULE_URL . "send_emails"; ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <div class="uk-margin-medium-bottom">
                            <label>Select User :</label>
                            <table>
                                <tr>
                                    <td>
                                        <input checked="" type="radio" name="chrUser" id="chrCustom" data-md-icheck value="C" onclick="showUsers('C');" />
                                        <label for="chrCustom" class="inline-label" onclick="showUsers('C');">Custom</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="chrUser" id="chrAll" data-md-icheck value="A" onclick="showUsers('A');" />
                                        <label for="chrAll" class="inline-label" onclick="showUsers('A');">All User</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="chrUser" id="chrFree" data-md-icheck value="F" onclick="showUsers('F');" />
                                        <label for="chrFree" class="inline-label" onclick="showUsers('F');">Free User</label>
                                    </td>
                                    <!--                        </tr>
                                                            <tr>-->
                                    <td>
                                        <input type="radio" name="chrUser" id="chrPaid" data-md-icheck value="P" onclick="showUsers('P');" />
                                        <label for="chrPaid" class="inline-label" onclick="showUsers('P');">Paid User</label>
                                    </td> 
                                    <td>
                                        <input type="radio" name="chrUser" id="chrNewsletter" data-md-icheck value="N" onclick="showUsers('N');" />
                                        <label for="chrNewsletter" class="inline-label" onclick="showUsers('N');">Newsletter Subscription User</label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="uk-margin-medium-bottom" id="showusers">

                            <div class="uk-form-file md-btn md-btn-primary">
                                <i class="material-icons">cloud_download</i>
                                Import
                                <input id="varFileUpload" name="varFileUpload"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" type="file">
                            </div>
                        </div>
                        <div class="uk-margin-medium-bottom">

                            <div class="uk-form-row">
                                <label for="varSubject">Subject</label>
                                <input type="text" id="varSubject" name="varSubject" class="md-input"/>
                            </div>
                            <label class="error" for="varSubject"></label>
                        </div>

                        <div class="uk-margin-large-bottom">
                            <label for="txtDescription">Message</label>
                            <?php
                            echo $this->mylibrary->load_ckeditor('txtDescription', "", '100%', '200px', 'Basic');
                            ?>
                        </div>

                        <div id="mail_upload-drop" class="uk-file-upload">
                            <p class="uk-text">Drop file to upload</p>
                            <p class="uk-text-muted uk-text-small uk-margin-small-bottom">or</p>
                            <a class="uk-form-file md-btn">choose file<input id="mail_upload-select" name="varFile" type="file"></a>
                        </div>
                        <div id="mail_progressbar" class="uk-progress uk-hidden">
                            <div class="uk-progress-bar" style="width:0">0%</div>
                        </div>
                        <div class="spacer10"></div>
                        <button type="submit" class="md-btn md-btn-primary md-btn-wave-light">Send Email</button>

                        <div class="spacer10"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


