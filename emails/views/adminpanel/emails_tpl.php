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

<div id="top_bar">
    <div class="md-top-bar">

        <div class="uk-width-large-10-10 uk-container-center">
            <div class="uk-clearfix">
                <!--<div class="spacer10"></div>-->
                <?php // if ($permissionArry['Delete'] == 'Y' && $this->Module_Model->NumOfRows > 0) {   ?>             


                <?php
//        }
                ?>
                <div class="md-top-bar-actions-left">
                    <div class="md-top-bar-checkbox">
                        <input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value="">
                        <!--<input type="checkbox" name="mailbox_select_all" id="mailbox_select_all" data-md-icheck />-->
                    </div>
                    <!--                    <div class="md-btn-group">
                                            <a href="#" class="md-btn md-btn-flat md-btn-small md-btn-wave" data-uk-tooltip="{pos:'bottom'}" title="Archive"><i class="material-icons">&#xE149;</i></a>
                                            <a href="#" class="md-btn md-btn-flat md-btn-small md-btn-wave" data-uk-tooltip="{pos:'bottom'}" title="Spam"><i class="material-icons">&#xE160;</i></a>
                                            <a href="#" class="md-btn md-btn-flat md-btn-small md-btn-wave" data-uk-tooltip="{pos:'bottom'}" title="Delete"><i class="material-icons">&#xE872;</i></a>
                                        </div>-->
                    <!--                    <div class="uk-button-dropdown" data-uk-dropdown="{mode: 'click'}">
                                            <button class="md-btn md-btn-flat md-btn-small md-btn-wave" data-uk-tooltip="{pos:'top'}" title="Move to"><i class="material-icons">&#xE2C7;</i> <i class="material-icons">&#xE313;</i></button>
                                            <div class="uk-dropdown">
                                                <ul class="uk-nav uk-nav-dropdown">
                                                    <li><a href="#">Forward</a></li>
                                                    <li><a href="#">Reply</a></li>
                                                    <li><a href="#">Offers</a></li>
                                                    <li class="uk-nav-divider"></li>
                                                    <li><a href="#">Trash</a></li>
                                                    <li><a href="#">Spam</a></li>
                                                </ul>
                                            </div>
                                        </div>-->
                </div>
                <div class="md-top-bar-actions-right">
                    <div class="md-top-bar-icons">
                        <i id="mailbox_list_split" class=" md-icon material-icons">&#xE8EE;</i>
                        <i id="mailbox_list_combined" class="md-icon material-icons">&#xE8F2;</i>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php if ($this->Module_Model->ajax != 'Y') { ?>
    <div id="gridbody" class="content-wrapper">
    <?php } ?>

    <div id="page_content">

        <?php if ($permissionArry['Delete'] == 'Y' && $this->Module_Model->NumOfRows > 0) { ?>             
            <a href="javascript:;"  onclick="return verify();" class="md-btn md-btn-primary md-btn-wave-light md-btn-icon" style="margin: 10px;float:right;"> <i class="material-icons">delete</i>Delete</a>
            <?php
        }
        ?>
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

            <div class="md-card-list-wrapper" id="mailbox">
                <div class="uk-width-large-10-10 uk-container-center">
                    <?php if (!empty($ShowAllEmailsRecords)) { ?>

                        <div class="md-card-list" >
                            <div class="md-card-list-header heading_list">Today</div>
                            <div class="md-card-list-header md-card-list-header-combined heading_list" style="display: none">All Messages</div>
                            <ul class="hierarchical_slide">
                                <?php
                                foreach ($ShowAllEmailsRecords as $Row_Email) {
                                    ?>


                                    <div class="uk-modal" id="mailbox_new_message<?php echo $Row_Email['int_id']; ?>">
                                        <div class="uk-modal-dialog">
                                            <button class="uk-modal-close uk-close" type="button"></button>
                                            <form id="FrmEmails<?php echo $Row_Email['int_id']; ?>" name="FrmEmails" action="<?php echo MODULE_URL . "reply_send_emails"; ?>" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                <div class="uk-modal-header">
                                                    <h3 class="uk-modal-title">Reply to Message: <?php echo $Row_Email['txtTo']; ?></h3>
                                                </div>
                                                <div class="uk-margin-medium-bottom">
                                                    <label for="mail_new_to">To</label>
                                                    <div class="uk-form-row">
                                                        <input required="" type="text" value="<?php echo $Row_Email['txtTo']; ?>" id="varEmails<?php echo $Row_Email['int_id']; ?>" name="varEmails" class="md-input uk-width-1-1"/>
                                                        <label class="error" for="varEmails<?php echo $Row_Email['int_id']; ?>"></label>
                                                    </div>
                                                </div>
                                                <div class="uk-margin-medium-bottom">
                                                    <label for="varSubject<?php echo $Row_Email['int_id']; ?>">Subject</label>
                                                    <div class="uk-form-row">
                                                        <input required="" type="text"  value="Re: <?php echo $Row_Email['txtSubject']; ?>" id="varSubject<?php echo $Row_Email['int_id']; ?>" name="varSubject" class="md-input"/>
                                                    </div>
                                                    <label class="error" for="varSubject<?php echo $Row_Email['int_id']; ?>"></label>
                                                </div>

                                                <div class="uk-margin-large-bottom">
                                                    <label for="txtDescription<?php echo $Row_Email['int_id']; ?>">Message</label>
                                                    <textarea required="" name="txtDescription" id="txtDescription<?php echo $Row_Email['int_id']; ?>" cols="30" rows="6" class="md-input"></textarea>
                                                    <label class="error" for="txtDescription<?php echo $Row_Email['int_id']; ?>"></label>
                                                </div>

                                                <div id="mail_upload-drop" class="uk-file-upload">
                                                    <p class="uk-text">Drop file to upload</p>
                                                    <p class="uk-text-muted uk-text-small uk-margin-small-bottom">or</p>
                                                    <a class="uk-form-file md-btn">choose file<input id="mail_upload-select" name="varFile" type="file"></a>
                                                </div>
                                                <div id="mail_progressbar" class="uk-progress uk-hidden">
                                                    <div class="uk-progress-bar" style="width:0">0%</div>
                                                </div>
                                                <div class="uk-modal-footer">
                                                    <button type="submit" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary">Send</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                    <li>
                                        <!--                                    <div class="md-card-list-item-menu" data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                                                                                <a href="#" class="md-icon material-icons">&#xE5D4;</a>
                                                                                <div class="uk-dropdown uk-dropdown-small">
                                                                                    <ul class="uk-nav">
                                                                                        <li><a href="#mailbox_new_message<?php echo $Row_Email['int_id']; ?>" data-uk-modal="{center:true}"><i class="material-icons">&#xE15E;</i> Reply</a></li>
                                                                                        <li><a href="#"><i class="material-icons">&#xE149;</i> Archive</a></li>
                                                                                        <li><a href="javascript:;" onclick="return verify(<?php echo $Row_Email['int_id']; ?>)"><i class="material-icons">&#xE872;</i> Delete</a></li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>-->
                                        <span class="md-card-list-item-date"><?php echo date('d M', strtotime($Row_Email['dtCreateDate'])); ?></span>
                                        <div class="md-card-list-item-select">
                                            <input type="checkbox" value="<?php echo $Row_Email['int_id']; ?>" id="chkgrow" name="chkgrow">
                                            <!--<input type="checkbox" data-md-icheck />-->
                                        </div>
                                        <div class="md-card-list-item-avatar-wrapper">
                                            <span class="md-card-list-item-avatar md-bg-grey"><?php echo mb_substr($Row_Email['txtTo'], 0, 2); ?></span>
                                        </div>
                                        <div class="md-card-list-item-sender">
                                            <span><?php echo $Row_Email['txtTo']; ?></span>
                                        </div>
                                        <div class="md-card-list-item-subject">
                                            <div class="md-card-list-item-sender-small">
                                                <span><?php echo $Row_Email['txtTo']; ?></span>
                                            </div>
                                            <span><?php echo $Row_Email['txtSubject']; ?></span>
                                        </div>
                                        <div class="md-card-list-item-content-wrapper">
                                            <div class="md-card-list-item-content">
                                                <?php echo $Row_Email['txtBody']; ?>                         
                                            </div>
                                            <!--                                        <form class="md-card-list-item-reply">
                                                                                        <label for="mailbox_reply_<?php echo $Row_Email['int_id']; ?>">Reply to <span><?php echo $Row_Email['txtTo']; ?></span></label>
                                                                                        <textarea class="md-input md-input-full" name="mailbox_reply_<?php echo $Row_Email['int_id']; ?>" id="mailbox_reply_<?php echo $Row_Email['int_id']; ?>" cols="30" rows="4"></textarea>
                                                                                        <button type="button" class="md-btn md-btn-flat md-btn-flat-primary">Send</button>
                                                                                    </form>-->
                                        </div>
                                    </li>
                                <?php }
                                ?>

                            </ul>
                        </div>

                        <?php
                    }
                    if (!empty($YesShowAllEmailsRecords)) {
                        ?>
                        <div class="md-card-list">
                            <div class="md-card-list-header heading_list">Yesterday</div>
                            <ul class="hierarchical_slide">
                                <?php
                                foreach ($YesShowAllEmailsRecords as $Row_Email) {
                                    ?>


                                    <div class="uk-modal" id="mailbox_new_message<?php echo $Row_Email['int_id']; ?>">
                                        <div class="uk-modal-dialog">
                                            <button class="uk-modal-close uk-close" type="button"></button>
                                            <form id="FrmEmails<?php echo $Row_Email['int_id']; ?>" name="FrmEmails" action="<?php echo MODULE_URL . "reply_send_emails"; ?>" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                <div class="uk-modal-header">
                                                    <h3 class="uk-modal-title">Reply to Message: <?php echo $Row_Email['txtTo']; ?></h3>
                                                </div>
                                                <div class="uk-margin-medium-bottom">
                                                    <label for="mail_new_to">To</label>
                                                    <div class="uk-form-row">
                                                        <input required="" type="text" value="<?php echo $Row_Email['txtTo']; ?>" id="varEmails<?php echo $Row_Email['int_id']; ?>" name="varEmails" class="md-input uk-width-1-1"/>
                                                        <label class="error" for="varEmails<?php echo $Row_Email['int_id']; ?>"></label>
                                                    </div>
                                                </div>
                                                <div class="uk-margin-medium-bottom">
                                                    <label for="varSubject<?php echo $Row_Email['int_id']; ?>">Subject</label>
                                                    <div class="uk-form-row">
                                                        <input required="" value="Re: <?php echo $Row_Email['txtSubject']; ?>" type="text" id="varSubject<?php echo $Row_Email['int_id']; ?>" name="varSubject" class="md-input"/>
                                                    </div>
                                                    <label class="error" for="varSubject<?php echo $Row_Email['int_id']; ?>"></label>
                                                </div>

                                                <div class="uk-margin-large-bottom">
                                                    <label for="txtDescription<?php echo $Row_Email['int_id']; ?>">Message</label>
                                                    <textarea required="" name="txtDescription" id="txtDescription<?php echo $Row_Email['int_id']; ?>" cols="30" rows="6" class="md-input"></textarea>
                                                    <label class="error" for="txtDescription<?php echo $Row_Email['int_id']; ?>"></label>
                                                </div>

                                                <div id="mail_upload-drop" class="uk-file-upload">
                                                    <p class="uk-text">Drop file to upload</p>
                                                    <p class="uk-text-muted uk-text-small uk-margin-small-bottom">or</p>
                                                    <a class="uk-form-file md-btn">choose file<input id="mail_upload-select" name="varFile" type="file"></a>
                                                </div>
                                                <div id="mail_progressbar" class="uk-progress uk-hidden">
                                                    <div class="uk-progress-bar" style="width:0">0%</div>
                                                </div>
                                                <div class="uk-modal-footer">
                                                    <button type="submit" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary">Send</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                    <li>
                                        <!--                                    <div class="md-card-list-item-menu" data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                                                                                <a href="#" class="md-icon material-icons">&#xE5D4;</a>
                                                                                <div class="uk-dropdown uk-dropdown-small">
                                                                                    <ul class="uk-nav">
                                                                                        <li><a href="#mailbox_new_message<?php echo $Row_Email['int_id']; ?>" data-uk-modal="{center:true}"><i class="material-icons">&#xE15E;</i> Reply</a></li>
                                                                                        <li><a href="#"><i class="material-icons">&#xE149;</i> Archive</a></li>
                                                                                        <li><a href="javascript:;"  onclick="return verify(<?php echo $Row_Email['int_id']; ?>)"><i class="material-icons">&#xE872;</i> Delete</a></li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>-->
                                        <span class="md-card-list-item-date"><?php echo date('d M', strtotime($Row_Email['dtCreateDate'])); ?></span>
                                        <div class="md-card-list-item-select">
                                            <input type="checkbox" value="<?php echo $Row_Email['int_id']; ?>" id="chkgrow" name="chkgrow">
                                            <!--<input type="checkbox" data-md-icheck />-->
                                        </div>
                                        <div class="md-card-list-item-avatar-wrapper">
                                            <span class="md-card-list-item-avatar md-bg-grey"><?php echo mb_substr($Row_Email['txtTo'], 0, 2); ?></span>
                                        </div>
                                        <div class="md-card-list-item-sender">
                                            <span><?php echo $Row_Email['txtTo']; ?></span>
                                        </div>
                                        <div class="md-card-list-item-subject">
                                            <div class="md-card-list-item-sender-small">
                                                <span><?php echo $Row_Email['txtTo']; ?></span>
                                            </div>
                                            <span><?php echo $Row_Email['txtSubject']; ?></span>
                                        </div>
                                        <div class="md-card-list-item-content-wrapper">
                                            <div class="md-card-list-item-content">
                                                <?php echo $Row_Email['txtBody']; ?>                         
                                            </div>
                                            <!--                                        <form class="md-card-list-item-reply">
                                                                                        <label for="mailbox_reply_<?php echo $Row_Email['int_id']; ?>">Reply to <span><?php echo $Row_Email['txtTo']; ?></span></label>
                                                                                        <textarea class="md-input md-input-full" name="mailbox_reply_<?php echo $Row_Email['int_id']; ?>" id="mailbox_reply_<?php echo $Row_Email['int_id']; ?>" cols="30" rows="4"></textarea>
                                                                                        <button type="button" class="md-btn md-btn-flat md-btn-flat-primary">Send</button>
                                                                                    </form>-->
                                        </div>
                                    </li>
                                <?php }
                                ?>

                            </ul>
                        </div>

                    <?php } if (!empty($OldShowAllEmailsRecords)) { ?>
                        <div class="md-card-list">
                            <div class="md-card-list-header heading_list">Older Message</div>
                            <ul class="hierarchical_slide">
                                <?php
                                foreach ($OldShowAllEmailsRecords as $Row_Email) {
                                    ?>


                                    <div class="uk-modal" id="mailbox_new_message<?php echo $Row_Email['int_id']; ?>">
                                        <div class="uk-modal-dialog">
                                            <button class="uk-modal-close uk-close" type="button"></button>

                                            <form id="FrmEmails<?php echo $Row_Email['int_id']; ?>" name="FrmEmails" action="<?php echo MODULE_URL . "reply_send_emails"; ?>" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                <div class="uk-modal-header">
                                                    <h3 class="uk-modal-title">Reply to Message: <?php echo $Row_Email['txtTo']; ?></h3>
                                                </div>
                                                <div class="uk-margin-medium-bottom">
                                                    <label for="mail_new_to">To</label>
                                                    <div class="uk-form-row">
                                                        <input required="" type="text" value="<?php echo $Row_Email['txtTo']; ?>" id="varEmails<?php echo $Row_Email['int_id']; ?>" name="varEmails" class="md-input uk-width-1-1"/>
                                                        <label class="error" for="varEmails<?php echo $Row_Email['int_id']; ?>"></label>
                                                    </div>
                                                </div>
                                                <div class="uk-margin-medium-bottom">
                                                    <label for="varSubject<?php echo $Row_Email['int_id']; ?>">Subject</label>
                                                    <div class="uk-form-row">
                                                        <input required="" type="text" value="Re: <?php echo $Row_Email['txtSubject']; ?>" id="varSubject<?php echo $Row_Email['int_id']; ?>" name="varSubject" class="md-input"/>
                                                    </div>
                                                    <label class="error" for="varSubject<?php echo $Row_Email['int_id']; ?>"></label>
                                                </div>

                                                <div class="uk-margin-large-bottom">
                                                    <label for="txtDescription<?php echo $Row_Email['int_id']; ?>">Message</label>
                                                    <textarea required="" name="txtDescription" id="txtDescription<?php echo $Row_Email['int_id']; ?>" cols="30" rows="6" class="md-input"></textarea>
                                                    <label class="error" for="txtDescription<?php echo $Row_Email['int_id']; ?>"></label>
                                                </div>

                                                <div id="mail_upload-drop" class="uk-file-upload">
                                                    <p class="uk-text">Drop file to upload</p>
                                                    <p class="uk-text-muted uk-text-small uk-margin-small-bottom">or</p>
                                                    <a class="uk-form-file md-btn">choose file<input id="mail_upload-select" name="varFile" type="file"></a>
                                                </div>
                                                <div id="mail_progressbar" class="uk-progress uk-hidden">
                                                    <div class="uk-progress-bar" style="width:0">0%</div>
                                                </div>
                                                <div class="uk-modal-footer">
                                                    <button type="submit" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary">Send</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                    <li>
                                        <!--                                    <div class="md-card-list-item-menu" data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                                                                                <a href="#" class="md-icon material-icons">&#xE5D4;</a>
                                                                                <div class="uk-dropdown uk-dropdown-small">
                                                                                    <ul class="uk-nav">
                                                                                        <li><a href="#mailbox_new_message<?php echo $Row_Email['int_id']; ?>" data-uk-modal="{center:true}"><i class="material-icons">&#xE15E;</i> Reply</a></li>
                                                                                        <li><a href="#"><i class="material-icons">&#xE149;</i> Archive</a></li>
                                                                                        <li><a href="javascript:;"  onclick="return verify(<?php echo $Row_Email['int_id']; ?>)"><i class="material-icons">&#xE872;</i> Delete</a></li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>-->
                                        <span class="md-card-list-item-date"><?php echo date('d M', strtotime($Row_Email['dtCreateDate'])); ?></span>
                                        <div class="md-card-list-item-select">
                                            <input type="checkbox" value="<?php echo $Row_Email['int_id']; ?>" id="chkgrow" name="chkgrow">
                                            <!--<input type="checkbox" data-md-icheck />-->
                                        </div>
                                        <div class="md-card-list-item-avatar-wrapper">
                                            <span class="md-card-list-item-avatar md-bg-grey"><?php echo mb_substr($Row_Email['txtTo'], 0, 2); ?></span>
                                        </div>
                                        <div class="md-card-list-item-sender">
                                            <span><?php echo $Row_Email['txtTo']; ?></span>
                                        </div>
                                        <div class="md-card-list-item-subject">
                                            <div class="md-card-list-item-sender-small">
                                                <span><?php echo $Row_Email['txtTo']; ?></span>
                                            </div>
                                            <span><?php echo $Row_Email['txtSubject']; ?></span>
                                        </div>
                                        <div class="md-card-list-item-content-wrapper">
                                            <div class="md-card-list-item-content">
                                                <?php echo $Row_Email['txtBody']; ?>                         
                                            </div>
                                            <!--                                        <form class="md-card-list-item-reply">
                                                                                        <label for="mailbox_reply_<?php echo $Row_Email['int_id']; ?>">Reply to <span><?php echo $Row_Email['txtTo']; ?></span></label>
                                                                                        <textarea class="md-input md-input-full" name="mailbox_reply_<?php echo $Row_Email['int_id']; ?>" id="mailbox_reply_<?php echo $Row_Email['int_id']; ?>" cols="30" rows="4"></textarea>
                                                                                        <button type="button" class="md-btn md-btn-flat md-btn-flat-primary">Send</button>
                                                                                    </form>-->
                                        </div>
                                    </li>
                                <?php }
                                ?>

                            </ul>
                        </div>
                        <?php // else {
                        ?>
                        <!--                    <div class="md-card-list">
                                                <center> No Emails</center>
                                            </div>-->
                    <?php }
                    ?>
                </div>
            </div>


<!--<a href="javascript:;"  onclick="return verify();" class="md-btn md-btn-primary md-btn-wave-light md-btn-icon" style="margin-left:10px;margin-top: 10px;"> <i class="material-icons">delete</i>Delete</a>-->

        </div>
    </div>

    <div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent md-fab-wave" href="#mailbox_new_message" data-uk-modal="{center:true}">
            <i class="material-icons">&#xE150;</i>
        </a>
    </div>

    <div class="uk-modal" id="mailbox_new_message">
        <div class="uk-modal-dialog">
            <button class="uk-modal-close uk-close" type="button"></button>
            <form id="FrmEmails" name="FrmEmails" action="<?php echo MODULE_URL . "send_emails"; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">Compose Message</h3>
                </div>
                <div class="uk-margin-medium-bottom">
                    <!--<div class="uk-form-row">-->
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
                    <label for="mail_new_to">To</label>
                    <div class="uk-form-row">
                        <input required="" type="text" id="varEmails" name="varEmails" class="md-input uk-width-1-1"/>
                        <label class="error" for="varEmails"></label>
                    </div>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="varSubject">Subject</label>
                    <div class="uk-form-row">
                        <input type="text" id="varSubject" name="varSubject" class="md-input"/>
                    </div>
                    <label class="error" for="varSubject"></label>
                </div>

                <div class="uk-margin-large-bottom">
                    <label for="txtDescription">Message</label>
                    <textarea name="txtDescription" id="txtDescription" cols="30" rows="6" class="md-input"></textarea>
                    <label class="error" for="txtDescription"></label>
                </div>

                <div id="mail_upload-drop" class="uk-file-upload">
                    <p class="uk-text">Drop file to upload</p>
                    <p class="uk-text-muted uk-text-small uk-margin-small-bottom">or</p>
                    <a class="uk-form-file md-btn">choose file<input id="mail_upload-select" name="varFile" type="file"></a>
                </div>
                <div id="mail_progressbar" class="uk-progress uk-hidden">
                    <div class="uk-progress-bar" style="width:0">0%</div>
                </div>
                <div class="uk-modal-footer">
                    <button type="submit" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary">Send</button>
                </div>
            </form>
        </div>
    </div>

    <div class="uk-modal" id="mailbox_new_message">
        <div class="uk-modal-dialog">
            <button class="uk-modal-close uk-close" type="button"></button>

            <form id="FrmEmails" name="FrmEmails" action="<?php echo MODULE_URL . "send_emails"; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">Compose Message</h3>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="mail_new_to">To</label>
                    <div class="uk-form-row">
                        <input required="" type="text" id="varEmails" name="varEmails" class="md-input uk-width-1-1"/>
                        <label class="error" for="varEmails"></label>
                    </div>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="varSubject">Subject</label>
                    <div class="uk-form-row">
                        <input type="text" id="varSubject" name="varSubject" class="md-input"/>
                    </div>
                    <label class="error" for="varSubject"></label>
                </div>

                <div class="uk-margin-large-bottom">
                    <label for="txtDescription">Message</label>
                    <textarea name="txtDescription" id="txtDescription" cols="30" rows="6" class="md-input"></textarea>
                    <label class="error" for="txtDescription"></label>
                </div>

                <div id="mail_upload-drop" class="uk-file-upload">
                    <p class="uk-text">Drop file to upload</p>
                    <p class="uk-text-muted uk-text-small uk-margin-small-bottom">or</p>
                    <a class="uk-form-file md-btn">choose file<input id="mail_upload-select" name="varFile" type="file"></a>
                </div>
                <div id="mail_progressbar" class="uk-progress uk-hidden">
                    <div class="uk-progress-bar" style="width:0">0%</div>
                </div>
                <div class="uk-modal-footer">
                    <button type="submit" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary">Send</button>
                </div>
            </form>

        </div>

    </div>

    <input type="hidden" value="<?php echo $this->Module_Model->Appendfk_Country_Site; ?>" id="App_country_site" name="App_country_site">    
    <input type="hidden" value="<?php echo $this->Module_Model->PageNumber; ?>" id="PageNumber" name="PageNumber">
    <input type="hidden" value="<?php echo $this->Module_Model->PageSize; ?>" id="PageSize" name="PageSize">
    <input type="hidden" value="<?php echo $RowCountPgaes; ?>" id="ptrecords" name="ptrecords">

    <?php if ($this->Module_Model->ajax != 'Y') { ?>
    </div>
<?php } ?>