<script type="text/javascript">

    $(document).ready(function () {
        $("#Frmfaqs").validate({
            ignore: [],
            rules: {
                varName: {
                    required: true
                },
                intDisplayOrder: {
                    displayorder: ['intDisplayOrder']
                }

            },
            messages: {
                varName: {
                    required: "Please enter the question."
                },
                intDisplayOrder: {
                    required: GLOBAL_PROPER_DISPLAY_ORDER
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
                    if ($("#chrImageFlagE").is(":checked") == true && $("#varExternalUrl").val() != '') {
                        if (!check_remote_file_exist()) {

                            $('<label id="Var_Url_Image_notexisterr" class="error">Please Note that file is not available for the above link.</label>').insertAfter('#varExternalUrl');
                            $("#varExternalUrl").focus();
                            return false;
                        }
                    }
                    form.submit();
                }
            }
        });
    });
    function checkurl(url)
    {
        var RegExp = /^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/;

        if (RegExp.test(url)) {
            return true;
        } else {
            return false;
        }
    }
    function check_remote_file_exist() {
        var RemoteUri = $("#varExternalUrl").val();
        var resp = false;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>adminpanel/faqs/CheckRemoteFile",
            data: "Uri=" + encodeURI(RemoteUri),
            async: false,
            success: function (result)
            {
                if (result == '200') {
                    resp = true;
                } else {
                    resp = false;
                }
            }
        });
        return resp;
    }
</script>
<script type="text/javascript">
    function Show_BG_Box(sel)
    {
        if (sel == 'S')
        {
            $("#SystemImagesDisplayDiv").show();
            $("#ExternalLinkImagesDisplayDiv").hide();
            $("#upload_note").show();
            $("#selectdiv").show();
            $("#selectdiv1").hide();
            $("#selectdiv2").hide();
        } else if (sel == 'E')
        {
            $("#SystemImagesDisplayDiv").hide();
            $("#ExternalLinkImagesDisplayDiv").show();
            $("#upload_note").show();
            $("#selectdiv1").hide();
            $("#selectdiv2").show();
            $("#selectdiv").hide();
        }
    }

</script>

<div id="page_content_inner">
    <div id="page_content">
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                <li><a href="<?php echo MODULE_PAGE_NAME; ?>">Manage FAQ's</a></li>
                <li><span>
                        <?php
                        if (!empty($eid)) {
                            echo 'Edit FAQ - ' . $Row['varName'];
                        } else {
                            echo 'Add FAQ';
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
        if ($messagebox != '') {
            echo '<div class="md-card-list-wrapper"><div class="md-card-list"><ul class="hierarchical_slide uk-text-danger" id="hierarchical-slide"><li>';
            echo $messagebox;
            echo '</li></ul></div></div>';
        }
        ?>
        <div class="uk-text-danger" style="float:right;">* Required Field</div>
        <div class="clear"></div>
        <?php
        $attributes = array('name' => 'Frmfaqs', 'id' => 'Frmfaqs', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
        echo form_open($action, $attributes);
        echo form_hidden('btnsaveandc_x', '');
        ?>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                if (!empty($eid)) {
                    echo form_hidden('ehintglcode', $eid);
                    echo form_hidden('eid', $Row['int_id']);
                    echo form_hidden('Old_DisplayOrder', $Row['intDisplayOrder'], '', 'id="Old_DisplayOrder"');
                    echo form_hidden('Old_fk_ParentPageGlCode', $Row['fk_ParentPageGlCode'], '', 'id="Old_fk_ParentPageGlCode"');
                }
                ?>
                <div class="uk-form-row">
                    <div class="uk-width-medium-1-2">
                        <label>Question *</label>
                        <?php
                        $titleBoxdata = array(
                            'name' => 'varName',
                            'id' => 'varName',
                            'value' => $Row['varName'],
                            'maxlength' => '250',
                            'class' => 'md-input'
                        );
                        echo form_input($titleBoxdata);
                        ?>
                    </div>
                </div> 
                <label class="error" for="varName"></label>

                <div class="spacer10"></div>
                <div class="clear"></div> 
                <div class="uk-form-row">
                    <label>Answer *</label>
                    <?php
                    $value = (!empty($eid) ? $Row['txtDescription'] : '');
                    echo $this->mylibrary->load_ckeditor('txtDescription', $this->mylibrary->Replace_Varible_with_Sitepath($value), '100%', '200px', 'Basic');
                    ?>
                </div>
            </div>
        </div>

        <div class="md-card">
            <div class="md-card-content">
                <div class="spacer10"></div>
                <?php if ($eid == 1) { ?>
                    <input type="hidden" name="intDisplayOrder" value=<?php echo $Row['intDisplayOrder']; ?>>
                <?php } ?>
                <div class="spacer10"></div>

                <div class="inquiry-form">

                    <div class="uk-form-row">
                        <div class="uk-width-medium-1-2">
                            <label>Display Order<span class="req">*</span></label>
                            <?php
                            $DOBoxdata1 = array(
                                'name' => 'intDisplayOrder',
                                'id' => 'intDisplayOrder',
                                'value' => (!empty($eid) ? $Row['intDisplayOrder'] : '1'),
                                'maxlength' => '3',
                                'class' => 'md-input',
                                'onkeypress' => 'return KeycheckOnlyNumeric(faqs);',
                            );
                            echo form_input_ready($DOBoxdata1);
                            ?>
                        </div>
                    </div>
                    <div class="spacer10"></div>
                    <div class="uk-form-row">
                        <div class="uk-width-medium-1-2">
                            <label>Display</label>
                            <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: Please select 'Yes' if you want to display / activate this record. Otherwise please select 'NO'"; ?>">help</i></div>
                        <?php
                        if (!empty($eid)) {
                            $publishYRadio = array(
                                'name' => 'chrPublish',
                                'id' => 'chrPublishY',
                                'value' => 'Y',
                                'class' => 'form-rediobutton',
                                'checked' => ($Row['chrPublish'] == 'Y') ? TRUE : FALSE
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
                               <?php
                           }

                           if (!empty($eid)) {
                               $publishNRadio = array(
                                   'name' => 'chrPublish',
                                   'id' => 'chrPublishN',
                                   'value' => 'N',
                                   'class' => 'form-rediobutton',
                                   'checked' => ($Row['chrPublish'] == 'N') ? TRUE : FALSE
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
            <?php echo form_close(); ?>
        </div>
    </div>
</div>