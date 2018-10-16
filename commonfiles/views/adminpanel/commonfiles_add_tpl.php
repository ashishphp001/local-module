<?php $dropbox = "3qsvvnxqcgtwcv1"; ?>
<script type="text/javascript" src="https://www.dropbox.com/static/api/1/dropins.js" id="dropboxjs" data-app-key="<?php echo $dropbox ?>"></script>
<script type="text/javascript">
    function Show_BG_Box(sel)
    {
        if (sel == 'S')
        {
            $("#SystemFilesDisplayDiv").show();
            $("#ExternalLinkFilesDisplayDiv").hide();
            $("#DropboxFilesDisplaydiv").hide();
            $("#selectdiv").show();
            $("#selectdiv1").hide();
            $("#selectdiv2").hide();
        } else if (sel == 'B')
        {
            $("#SystemFilesDisplayDiv").hide();
            $("#DropboxFilesDisplaydiv").show();
            $("#ExternalLinkFilesDisplayDiv").hide();
            $("#selectdiv").hide();
            $("#selectdiv1").show();
            $("#selectdiv2").hide();
        } else if (sel == 'E')
        {
            $("#SystemFilesDisplayDiv").hide();
            $("#DropboxFilesDisplaydiv").hide();
            $("#ExternalLinkFilesDisplayDiv").show();
            $("#selectdiv").hide();
            $("#selectdiv1").hide();
            $("#selectdiv2").show();
        }
    }
    $(document).ready(function ()
    {
        $("#varExternalUrl").keydown(function () {
            $("#Var_Url_File_notexisterr").remove();
        });
        $.validator.addMethod("Chk_File_Size", function (event, value) {
            var flag = true;
            var selection = document.getElementById('varFile');
            for (var i = 0; i < selection.files.length; i++) {
                var file = selection.files[i].size;
                var FIVE_MB = Math.round(1024 * 1024 * 10);
                if (file > FIVE_MB) {
                    flag = false;
                }
            }
            return flag;
        }, 'Upload file having maximum size of 10MB.');
        $.validator.addMethod("UrlValidate_File", function (value, element) {
            var link_ext = value;
            var valid_extensions = /(\.pdf|\.doc|\.ppt|\.pptx|\.docx|\.rar\.zip|\.xls|\.xlsx|\.PDF|\.DOC|\.PPT|\.PPTX|\.DOCX|\.RAR\.ZIP|\.XLS|\.XLSX)$/i;
            if ($("#chrFileFlagE").is(':checked') && (valid_extensions.test(link_ext)))
            {
                var link = value;
                return checkurl(link);
            } else
            {
                return false;
            }
        }, "Please enter the valid link. (Eg. http://www.mywebsite.com/mydocument.pdf)");
        $.validator.addMethod("alphanumeric", function (value, element) {
            if (value.replace(/[^A-Z]/gi, "").length >= 2) {
                return true;
            } else if (value.replace(/[^0-9]/gi, "").length >= 2) {
                return true;
            } else {
                return false;
            }
        }, GLOBAL_VALID_TITLE);
        $("#intDisplayOrder").removeClass("ignore");
        $("#Frmcommonfiles").validate({
            ignore: [],
            rules: {
                fk_Category: {
                    required: true
                },
                varTitle: {
                    required: true,
                    alphanumeric: true
                },
                varShortDesc: {
                    required: true
                },
                varFile: {
                    required: {
                        depends: function ()
                        {
                            var Eid = '<?php echo $Row_commonfiles['int_id'] ?>';
                            var PrevSelected = '<?php echo $Row_commonfiles['chrFileFlag'] ?>';
                            if (Eid != '' && PrevSelected != 'S' && $("#chrFileFlagS").is(':checked'))
                            {
                                return true;
                            } else
                            {
                                if ($("#chrFileFlagS").is(':checked') && $("#varFileHidden").val() == '')
                                {
                                    return true;
                                } else
                                {
                                    return false;
                                }
                            }
                        }
                    },
                    Chk_File_Size:
                            {
                                depends: function ()
                                {
                                    if ($("#chrFileFlagS").is(":checked"))
                                    {
                                        return true;
                                    } else
                                    {
                                        return false;
                                    }
                                }
                            },
                    extension: "pdf,doc,docx,xls,xlsx,ppt,pptx,zip"
                },
                varExternalUrl: {
                    required: {
                        depends: function ()
                        {
                            var Eid = '<?php echo $Row_commonfiles['int_id'] ?>';
                            var PrevSelected = '<?php echo $Row_commonfiles['chrFileFlag'] ?>';
                            if (Eid != '' && PrevSelected != 'E' && $("#chrFileFlagE").is(':checked'))
                            {
                                return true;
                            } else
                            {
                                if ($("#chrFileFlagE").is(':checked') && $("#varFileHidden").val() == '')
                                {
                                    return true;
                                } else
                                {
                                    return false;
                                }
                            }
                        }
                    },
                    UrlValidate_File:
                            {
                                depends: function ()
                                {
                                    if ($("#chrFileFlagE").is(':checked'))
                                    {
                                        return true;
                                    } else
                                    {
                                        return false;
                                    }
                                }
                            }
                },
                intDisplayOrder: {
                    displayorder: ['intDisplayOrder'],
                    maxlength: 3
                }
            },
            errorPlacement: function (error, element)
            {
                if ($(element).attr('id') == 'varFile')
                {
                    error.appendTo('#varimageerror');
                } else if ($(element).attr('id') == 'varExternalUrl')
                {
                    error.appendTo('#varexternalurlerror');
                } else
                {
                    error.insertAfter(element);
                }
            },
            messages: {
                fk_Category: {
                    required: "Please select category."
                },
                varTitle: {
                    required: "Please enter title."
                },
                varFile: {
                    required: "Please select system file to upload.",
                    extension: "Only *.doc, *.docx, *.pdf, *.xls, *.xlsx, *.ppt, *.zip and *.pptx file formats are supported."
                },
                varExternalUrl: {
                    required: "Please enter the link of file file like http://www.example.com/abc.pdf."
                },
                intDisplayOrder: {
                    required: GLOBAL_PROPER_DISPLAY_ORDER,
                    maxlength: GLOBAL_DISPLAYORDER_LIMIT
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
                    if ($("#chrFileFlagE").is(":checked") == true && $("#varExternalUrl").val() != '') {
                        if (!check_remote_file_exist()) {
                            $('<label id="Var_Url_File_notexisterr" class="error">Please Note that file is not available for the above link.</label>').insertAfter('#varExternalUrl');
                            $("#varExternalUrl").focus();
                            return false;
                        }
                    }
                    form.submit();
                }
            }
        });
    });
    function check_remote_file_exist() {
        var RemoteUri = $("#varExternalUrl").val();
        var resp = false;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>adminpanel/commonfiles/CheckRemoteFile",
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
    function checkurl(url) {
        var RegExp = /^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/;
        if (RegExp.test(url)) {
            return true;
        } else {
            return false;
        }
    }
    $(document).ready(function () {
        $('#VarDropboxFile').on("DbxChooserSuccess",
                function (e) {
                    if ((parseInt(e.files[0].bytes) / 1048576) > 5) {
                        alert("Upload document file Having maximum size of 5MB.");
                        $("#VarDropboxFile").val('');
                        Dropbox.preventDefault();
                        return false;
                    }
                }, false);
    });
</script>
<div id="page_content_inner">
    <div id="page_content">
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                <li><a href="<?php echo MODULE_PAGE_NAME; ?>">Common Files</a></li>
                <li><span> 
                        <?php
                        if (!empty($eid)) {
                            echo 'Edit Common File - ' . $Row_commonfiles['varTitle'];
                        } else {
                            echo 'Add Common File';
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
        $attributes = array('name' => 'Frmcommonfiles', 'id' => 'Frmcommonfiles', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
        if ($edit_record) {
            echo form_open($action, $attributes);
        }
        ?>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                echo form_hidden('btnsaveandc_x', '');
                echo form_hidden('varFileHidden', $Row_commonfiles['varFile']);
                echo form_hidden('FlagHidden', $Row_commonfiles['chrFileFlag']);
                if (!empty($eid)) {
                    echo form_hidden('ehintglcode', $eid);
                    echo form_hidden('eid', $Row_commonfiles['int_id']);
                    echo form_hidden('varFileHidden', $Row_commonfiles['varFile']);
                    echo form_hidden('Hid_varMenuIcon', $Row_commonfiles['varMenuIcon']);
                    echo form_hidden('Hid_varDropdownFile', $Row_commonfiles['varDropdownFile']);
                    echo form_hidden('Old_DisplayOrder', $Row_commonfiles['intDisplayOrder'], '', 'id="Old_DisplayOrder"');
                }
                if (ADMIN_ID != 1) {
                    $style = 'style="display: none"';
                }
                ?>            
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label> Title*</label>
                            <?php
                            $titleBoxdata = array(
                                'name' => 'varTitle',
                                'id' => 'varTitle',
                                'maxlength' => '100',
                                'value' => $Row_commonfiles['varTitle'],
                                'class' => 'md-input'
                            );
                            echo form_input($titleBoxdata);
                            ?>
                            <label class="error" for="varTitle"></label>
                        </div>
                    </div>
                </div>

                <div class="clear"></div>
                <div class="uk-form-row">
                    <div class="uk-width-medium-1-2">
                        <label> Upload Image</label>
                        <div class="clear"></div>
                        <?php
                        if (!empty($eid)) {
                            if ($Row_commonfiles['chrFileFlag'] == 'S') {
                                $SystemCheck = TRUE;
                                $DropboxCheck = FALSE;
                                $ExternalLinkCheck = FALSE;
                                $SystemFilesDisplay = "style=''";
                                $DropboxFilesDisplay = "style='display:none;'";
                                $ExternalLinkFilesDisplay = "style='display:none;'";
                            } else if ($Row_commonfiles['chrFileFlag'] == 'B') {
                                $SystemCheck = FALSE;
                                $DropboxCheck = TRUE;
                                $ExternalLinkCheck = FALSE;
                                $SystemFilesDisplay = "style='display:none;'";
                                $DropboxFilesDisplay = "style=''";
                                $ExternalLinkFilesDisplay = "style='display:none;'";
                            } else if ($Row_commonfiles['chrFileFlag'] == 'E') {
                                $SystemCheck = FALSE;
                                $DropboxCheck = FALSE;
                                $ExternalLinkCheck = TRUE;
                                $SystemFilesDisplay = "style='display:none;'";
                                $DropboxFilesDisplay = "style='display:none;'";
                                $ExternalLinkFilesDisplay = "style=''";
                            }
                        } else {
                            $SystemCheck = TRUE;
                            $DropboxCheck = FALSE;
                            $ExternalLinkCheck = FALSE;
                            $SystemFilesDisplay = "style=''";
                            $DropboxFilesDisplay = "style='display:none;'";
                            $ExternalLinkFilesDisplay = "style='display:none;'";
                        }
                        $AllChkBox = "";
                        $ByPercentChkBox = array(
                            'name' => 'chrFileFlag',
                            'id' => 'chrFileFlagS',
                            'value' => 'S',
//                                                    'class' => 'user-redio-button UploadFile',
                            'checked' => $SystemCheck,
                            'style' => 'margin: 7px 7px 0px 3px;',
                            'onclick' => 'Show_BG_Box(this.value);'
                        );
                        $AllChkBox .= form_input_ready($ByPercentChkBox, 'radio') . '<label for="chrFileFlagS"> System </label>';

                        $ByPriceChkBox = array(
                            'name' => 'chrFileFlag',
                            'id' => 'chrImageFlagB',
                            'value' => 'B',
                            'class' => 'user-redio-button UploadFile',
                            'checked' => $DropboxCheck,
                            'onclick' => 'Show_BG_Box(this.value);'
                        );
                        $AllChkBox .= form_input_ready($ByPriceChkBox, 'radio') . '<label for="chrImageFlagB"> Dropbox </label>';


                        $ByExternalChkBox = array(
                            'name' => 'chrFileFlag',
                            'id' => 'chrFileFlagE',
                            'value' => 'E',
                            'checked' => $ExternalLinkCheck,
                            'style' => 'margin: 7px 7px 0px 3px;',
                            'onclick' => 'Show_BG_Box(this.value);',
                        );
                        $AllChkBox .= form_input_ready($ByExternalChkBox, 'radio') . '<label for="chrFileFlagE"> External Link </label>';
                        $CBoxdata = array(
                            'extraDataInTD' => $AllChkBox
                        );
                        echo form_input_ready($CBoxdata);
                        ?> 
                        <div class="clear"></div>
                        <div id="SystemFilesDisplayDiv" <?php echo $SystemFilesDisplay; ?>> 
                            <div class="uk-form-file md-btn md-btn-primary">
                                Upload
                                <input id="varFile" name="varFile" type="file">
                            </div>
                            <div class="clear"></div>
                            <label class="error" for="varFile"></label>
                            <div class="clear"></div>
                            <div id="varimageerror"></div>
                        </div>


                        <div id="ExternalLinkFilesDisplayDiv" <?php echo $ExternalLinkFilesDisplay; ?>> 
                            <?php
                            $UGCLabelData = array(
                                'label' => '',
                                'required' => ''
                            );
                            echo form_input_label($UGCLabelData);
                            $LogoLink = ($Row_commonfiles['varExternalUrl'] != '') ? $Row_commonfiles['varExternalUrl'] : 'http://www.';
                            $URLBoxdata = array(
                                'name' => 'varExternalUrl',
                                'id' => 'varExternalUrl',
                                'class' => 'md-input',
//                                                    'style' => 'width:345px',
                                'class' => 'md-input',
                                'value' => set_value('varExternalUrl', $LogoLink)
                            );
                            echo form_input_ready($URLBoxdata);
                            ?> <div class="clear"></div>
                            <div id="varexternalurlerror"></div>
                        </div>

                        <div id="DropboxFilesDisplaydiv" <?php echo $DropboxFilesDisplay; ?>> 
                            <?php
                            $UGCLabelData = array(
                                'label' => '',
                                'required' => '',
                            );
                            echo form_input_label($UGCLabelData);
                            $dropBoxdata = array(
                                'name' => 'VarDropboxFile',
                                'id' => 'VarDropboxFile',
                                'data-extensions' => '.doc .docx .pdf .xls .xlsx .ppt .zip .pptx',
                                'type' => 'dropbox-chooser'
                            );
                            echo form_input_ready($dropBoxdata);
                            ?>
                            <div class="clear"></div>
                            <label class="fr error" for="VarDropboxFile"></label>
                        </div>
                        <?php
                        $imagename = $Row_commonfiles['varFile'];
                        if ($imagename != "") {
                            ?>
                            <div class="highslide-gallery">
                                <?php
                                if ($Row_commonfiles['chrFileFlag'] == 'S') {
                                    echo "<div id='selectdiv' style=\"float:left;margin-top: 18px;\">&nbsp;&nbsp;";
                                } else if ($Row_commonfiles['chrFileFlag'] == 'B') {
                                    echo "<div id='selectdiv1' style=\"float:left;margin-top: 18px;\">&nbsp;&nbsp;";
                                } else {
                                    echo "<div id='selectdiv2' style=\"float:left;margin-top: 18px;\">&nbsp;&nbsp;";
                                }
                                ?> 
                                <?php
                                $filetolowwer = substr(strrchr($Row_commonfiles['varFile'], '.'), 1);
                                $fileexntension = strtolower($filetolowwer);
                                $p = explode('.', $row['varFile']);
                                if ($fileexntension == 'doc' || $fileexntension == 'docx') {
                                    $t = 'WORD.png';
                                } else if ($fileexntension == 'zip' || $fileexntension == 'rar') {
                                    $t = 'mime_zip.png';
                                } else if ($fileexntension == 'ppt' || $fileexntension == 'pptx') {
                                    $t = "ppt-icon.png";
                                } else if ($fileexntension == 'xls' || $fileexntension == 'xlsx') {
                                    $t = "xls-icon.png";
                                } else {
                                    $t = 'acrobate-readericon.png';
                                }
                                ?>                            
                                <a href="<?php echo MODULE_PAGE_NAME; ?>/download?file=<?= $Row_commonfiles['varFile'] ?>">
                                    <img id="pdficon" height="16" width="16"  title="<?= $Row_commonfiles['varFile'] ?>" src="<?= ADMIN_MEDIA_URL; ?>images/<?= $t ?>" style="vertical-align:middle;cursor:pointer;">
                                </a>                  
                            </div>                    
                        <?php } ?>
                    </div>
                    <!--</div>-->
                </div>
                <div class="clear"></div>
                <div class="spacer10"></div>
                <span class="uk-form-help-block">Upload Files of format Only *.doc, *.docx, *.pdf, *.xls, *.xlsx, *.ppt *.zip and *.pptx file formats are supported. Having maximum size of 10MB.</span> 
                <div class="clear"></div> 
            </div>
        </div>


        <div class="md-card">
            <div class="md-card-content">
                <div class="fix_width">
                    <div class="inquiry-form">
                        <label>Display Order*</label>
                        <?php if ($eid != 1 && $Row_commonfiles['fk_ParentPageGlCode'] == 0) { ?>
                            <?php
                            $DOBoxdata = array(
                                'name' => 'intDisplayOrder',
                                'id' => 'intDisplayOrder',
                                'value' => (!empty($eid) ? $Row_commonfiles['intDisplayOrder'] : '2'),
                                'class' => 'md-input',
                                'maxlength' => '3',
                                'onkeypress' => 'return KeycheckOnlyNumeric(event);',
                            );
                            echo form_input_ready($DOBoxdata);
                            ?>
                        <?php } else { ?>
                            <?php
                            $DOBoxdata1 = array(
                                'name' => 'intDisplayOrder',
                                'id' => 'intDisplayOrder',
                                'value' => (!empty($eid) ? $Row_commonfiles['intDisplayOrder'] : '1'),
                                'maxlength' => '3',
                                'class' => 'md-input',
                                'onkeypress' => 'return KeycheckOnlyNumeric(event);',
                            );
                            echo form_input_ready($DOBoxdata1);
                            ?>
                        <?php } ?>
                        <div class="spacer10"></div>
                        <div <?= $style; ?>> 
                            <label>Display</label> 
                            <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: Please select 'Yes' if you want to display / activate this record. Otherwise please select 'NO'"; ?>">help</i>
                            <?php
                            if (!empty($eid)) {
                                $publishYRadio = array(
                                    'name' => 'chrPublish',
                                    'id' => 'chrPublishY',
                                    'value' => 'Y',
                                    'style' => 'margin-top: -2px',
                                    'class' => 'form-rediobutton',
                                    'checked' => ($Row_commonfiles['chrPublish'] == 'Y') ? TRUE : FALSE
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
//                                                            'style' => 'margin-bottom: 10px;',
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
                                       'style' => 'margin-top: -2px',
                                       'class' => 'form-rediobutton',
                                       'checked' => ($Row_commonfiles['chrPublish'] == 'N') ? TRUE : FALSE
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
                                       'style' => 'margin-top: -2px',
//                                                            'style' => 'margin-bottom: 10px;',
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
                            <button class="md-btn md-btn-primary md-btn-wave-light" value="btnsaveandc" name="btnsaveandc" id="btnsaveandc">Save &amp; Keep Editing</button>
                            <button class="md-btn md-btn-primary md-btn-wave-light" name="btnsaveande" id="btnsaveande">Save &amp; Exit</button>
                            <a href="<?php echo MODULE_PAGE_NAME; ?>" title="Cancel">
                                <div  class="md-btn md-btn-wave">
                                    Cancel
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <?php
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>