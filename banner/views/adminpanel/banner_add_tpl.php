<script type="text/javascript">
    $(document).ready(function () {

        $("#varExternalUrl").keydown(function () {
            $("#Var_Url_Image_notexisterr").remove();
        });

        $.validator.addMethod("Chk_Image_Size", function (event, value)
        {
            var flag = true;
            var selection = document.getElementById('varImage');
            for (var i = 0; i < selection.files.length; i++)
            {
                var file = selection.files[i].size;
                var FIVE_MB = Math.round(1024 * 1024 * 5);
                if (file > FIVE_MB)
                {
                    flag = false;
                }
            }
            return flag;
        }, IMAGE_INVALID_SIZE);

        $.validator.addMethod("UrlValidate_Logo", function (value, element)
        {
            var link_ext = value;
            var valid_extensions = /(\.jpg|\.jpeg|\.gif|\.png)$/i;
            if ($("#chrImageFlagE").is(':checked') && (valid_extensions.test(link_ext)))
            {
                var link = value;
                return checkurl(link);
            } else
            {
                return false;
            }

        }, GLOBAL_IMAGE_EXT_URL_MSG);

        var homecount = '<?php echo $homebanner_count; ?>';
        var id = '<?php echo $eid ?>';
        if (homecount > 5 && id == '') {
            $("#chr_inner_banner").click();
            showBannerType();
            $("#widthposition").html(<?php echo INNER_BANNER_WIDTH; ?>)
            $("#heightposition").html(<?php echo INNER_BANNER_HEIGHT; ?>)
        }
        $("#FrmBanner").validate({
            ignore: [],
            rules: {
                varTitle: {
                    required: true
                },
                varImage: {
                    required: {
                        depends: function () {
                            if ($("#hidd_VarImage").val() == '' && $("#varImage").val() == '')
                            {
                                if ($("#chrImageFlagS").is(":checked")) {
                                    return true;
                                } else {
                                    return false;
                                }
                            }
<?php if ($eid != '' && $Row['chrImageFlag'] == 'B') { ?>
                                if ($("#hidd_VarImage").val() != '' && $("#varImage").val() == '')
                                {
                                    if ($("#chrImageFlagS").is(":checked")) {
                                        return true;
                                    } else if ($("#chrImageFlagB").is(":checked")) {
                                        return false;
                                    } else if ($("#chrImageFlagE").is(":checked")) {
                                        return false;
                                    }
                                }
<?php } else if ($eid != '' && $Row['chrImageFlag'] == 'E') { ?>
                                if ($("#hidd_VarImage").val() != '' && $("#varImage").val() == '')
                                {
                                    if ($("#chrImageFlagS").is(":checked")) {
                                        return true;
                                    } else if ($("#chrImageFlagB").is(":checked")) {
                                        return false;
                                    } else if ($("#chrImageFlagB").is(":checked")) {
                                        return false;
                                    }
                                }
<?php } ?>
                        }
                    },
                    accept: "jpg,png,jpeg,gif",
                    Chk_Image_Size: {
                        depends: function () {
                            if ($("#chrImageFlagS").is(":checked")) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                VarDropboxImage: {
                    required: {
                        depends: function () {
                            if ($("#hidd_VarImage").val() == '' && $("#VarDropboxImage").val() == '')
                            {
                                if ($("#chrImageFlagB").is(":checked")) {
                                    return true;
                                } else {
                                    return false;
                                }
                            }
<?php if ($eid != '' && $Row['chrImageFlag'] == 'S') { ?>
                                if ($("#hidd_VarImage").val() != '' && $("#varImage").val() == '')
                                {
                                    if ($("#chrImageFlagS").is(":checked")) {
                                        return false;
                                    } else if ($("#chrImageFlagB").is(":checked")) {
                                        return true;
                                    } else if ($("#chrImageFlagE").is(":checked")) {
                                        return false;
                                    }

                                }
<?php } else if ($eid != '' && $Row['chrImageFlag'] == 'E') { ?>
                                if ($("#hidd_VarImage").val() != '' && $("#varImage").val() == '')
                                {
                                    if ($("#chrImageFlagS").is(":checked")) {
                                        return false;
                                    } else if ($("#chrImageFlagB").is(":checked")) {
                                        return true;
                                    } else if ($("#chrImageFlagE").is(":checked")) {
                                        return false;
                                    }

                                }
<?php } ?>
                        }
                    },
                    accept: "jpg,png,jpeg,gif"
                },
                varExternalUrl:
                        {
                            required:
                                    {
                                        depends: function ()
                                        {
                                            var Eid = '<?php echo $Row['int_id'] ?>';
                                            var PrevSelected = '<?php echo $Row['chrImageFlag'] ?>';
                                            if (Eid != '' && PrevSelected != 'E' && $("#chrImageFlagE").is(':checked'))
                                            {
                                                return true;
                                            } else
                                            {
                                                if ($("#chrImageFlagE").is(":checked") && $("#hidd_VarImage").val() == '')
                                                {
                                                    return true;
                                                } else
                                                {
                                                    return false;
                                                }
                                            }
                                        }
                                    },
                            UrlValidate_Logo:
                                    {
                                        depends: function ()
                                        {
                                            if ($("#chrImageFlagE").is(':checked'))
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
                    displayorder: ['intDisplayOrder']
                }

            },
            messages: {
                varTitle: {
                    required: "Please enter title."
                },
                varImage:
                        {
                            required: BILL_ATTACH_SYSTEM_IMAGE,
                            accept: IMAGE_VALID
                        },
                VarDropboxImage:
                        {
                            required: BILL_ATTACH_DROPBOX_IMAGE,
                            accept: IMAGE_VALID
                        },
                varExternalUrl:
                        {
                            required: BILL_ATTACH_EXTERNAL_IMAGE
                        },
                intDisplayOrder: {
                    required: GLOBAL_PROPER_DISPLAY_ORDER
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
//                    if ($(element).attr('id') == 'varTitle')
//                    {
//                        error.appendTo('#varTitleError');
//                    } else
//                    {
//                        error.insertAfter(element);
//                    }
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

    $('#varTitle').keypress(function (event)
    {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13')
        {
            $('#varTitle').blur();
        }
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
            url: "<?php echo base_url(); ?>adminpanel/banner/CheckRemoteFile",
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
<script>
//    $(document).ready(function () {
<?php
//$all_page_id = $this->Module_Model->GetAllPageIDS();
//$all_innerbanner_id = $this->Module_Model->GetInnerBannerID();
//$result = array_diff($all_page_id, $all_innerbanner_id);
//if (count($result) == 0 && $eid != '') {
?>
//            $('#chr_inner_banner').show();
//            $('#chr_inner_banner1').show();
<?php // }                             ?>
//    });
</script>
<script type="text/javascript">
    //show and hide diff upload option
    function Show_BG_Box(sel)
    {
        if (sel == 'S')
        {
            $("#SystemImagesDisplayDiv").show();
            $("#ExternalLinkImagesDisplayDiv").hide();
            $("#upload_note").show();
            $("#selectdiv").show();
            $("#selectdiv2").hide();

        } else if (sel == 'B')
        {
            $("#SystemImagesDisplayDiv").hide();
            $("#DropboxImagesDisplaydiv").show();
            $("#ExternalLinkImagesDisplayDiv").hide();
            $("#upload_note").show();
            $("#selectdiv1").show();
            $("#selectdiv").hide();
            $("#selectdiv2").hide();
        } else if (sel == 'E')
        {
            $("#SystemImagesDisplayDiv").hide();
            $("#ExternalLinkImagesDisplayDiv").show();
            $("#upload_note").show();
            $("#selectdiv2").show();
            $("#selectdiv").hide();
        }

    }
</script>
<script type="text/javascript">
    function showBannerType() {

        if (document.getElementById('chr_home_banner').checked == true)
        {
//            document.getElementById('pages_inner_home_banner').style.display = 'none';
            $("#size").html('<div style="float:left;clear:both;margin-top: 5px;"><span>(Recommended Images Dimension Width <?php echo HOME_BANNER_WIDTH; ?>pxX Height <?php echo HOME_BANNER_HEIGHT ?>px , Maximum Image Dimension Width 4000px X Height 4000px)</span></div>');
        } else if (document.getElementById('chr_supplier_banner').checked == true)
        {
//            document.getElementById('pages_inner_home_banner').style.display = 'none';
            $("#size").html('<div style="float:left;clear:both;margin-top: 5px;"><span>(Recommended Images Dimension Width <?php echo HOME_BANNER_WIDTH; ?>pxX Height <?php echo HOME_BANNER_HEIGHT ?>px , Maximum Image Dimension Width 4000px X Height 4000px)</span></div>');
        } else if (document.getElementById('chr_inner_banner').checked == true)
        {
//            document.getElementById('pages_inner_home_banner').style.display = '';
            $("#size").html('<div style="float:left;clear:both;margin-top: 5px;"><span>(Recommended Images Dimension Width <?php echo INNER_BANNER_WIDTH; ?>px X Height <?php echo INNER_BANNER_HEIGHT ?>px , Maximum Image Dimension Width 4000px X Height 4000px)</span></div>');
        }

    }
</script>

<div id="page_content_inner">
    <div id="page_content">
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                <li><a href="<?php echo MODULE_PAGE_NAME; ?>">Manage Banners</a></li>
                <li><span>
                        <?php
                        if (!empty($eid)) {
                            echo 'Edit Banner - ' . $Row['varTitle'];
                        } else {
                            echo 'Add Banner';
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
        $attributes = array('name' => 'FrmBanner', 'id' => 'FrmBanner', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');

        echo form_open($action, $attributes);
        ?>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                echo form_hidden('btnsaveandc_x', '');
                $flag = ($Row['chrImageFlag'] != '') ? $Row['chrImageFlag'] : 'S';
                echo form_hidden('chrImageFlag', $flag);
                echo form_hidden('hidd_VarImage', $Row['varImage']);
                echo form_hidden('hidd_ImageFlag', $flag);
                if (!empty($eid)) {
                    echo form_hidden('ehintglcode', $eid);
                    echo form_hidden('Old_DisplayOrder', $Row['intDisplayOrder'], '', 'id="Old_DisplayOrder"');
                    echo form_hidden('Old_fk_ParentPageGlCode', $Row['fk_ParentPageGlCode'], '', 'id="Old_fk_ParentPageGlCode"');
                    echo form_hidden('eid', $Row['int_id']);
                }
                ?>
                <div class="uk-form-row">
                    <div class="uk-width-medium-1-2">
                        <label>Title</label>
                        <?php
                        $titleBoxdata = array(
                            'name' => 'varTitle',
                            'id' => 'varTitle',
                            'value' => $Row['varTitle'],
                            'maxlength' => '100',
                            'class' => 'md-input'
                        );
                        echo form_input($titleBoxdata);
                        ?>
                        <div class="clear"></div>
                        <label class="error" for="varTitle"></label>
                    </div>
                </div>

                <div class="uk-form-row">
                    <label>Banner Type   :</label>
                    <input type="radio" name="Chr_Banner_Type" id="chr_home_banner" <?php echo $checked = $Row['Chr_Banner_Type'] == 'H' ? 'checked' : 'checked'; ?> value="H" onclick="showBannerType();" />
                    <label for="chr_home_banner" class="inline-label">Home Banner</label>
                    <input type="radio" name="Chr_Banner_Type" id="chr_inner_banner" <?php echo $checked = $Row['Chr_Banner_Type'] == 'I' ? 'checked' : ''; ?> value="I" onclick="showBannerType();" />
                    <label for="chr_inner_banner" class="inline-label">Inner Banner</label>
                    <input type="radio" name="Chr_Banner_Type" id="chr_supplier_banner" <?php echo $checked = $Row['Chr_Banner_Type'] == 'S' ? 'checked' : ''; ?> value="S" onclick="showBannerType();" />
                    <label for="chr_supplier_banner" class="inline-label">Supplier Banner</label>
                </div>


                <!------------------Image code start ------------------>
                <div class="uk-form-row">
                    <div class="uk-width-medium-1-2">
                        <label> Upload Image</label>
                        <div class="clear"></div>
                        <?php
                        if (!empty($eid)) {
                            if ($Row['chrImageFlag'] == 'S') {
                                $SystemCheck = TRUE;
                                $DropboxCheck = FALSE;
                                $ExternalLinkCheck = FALSE;
                                $NoneLinkCheck = FALSE;
                                $SystemImagesDisplay = "style=''";
                                $DropboxImagesDisplay = "style='display:none;'";
                                $ExternalLinkImagesDisplay = "style='display:none;'";
                            } else if ($Row['chrImageFlag'] == 'E') {
                                $SystemCheck = FALSE;
                                $DropboxCheck = FALSE;
                                $ExternalLinkCheck = TRUE;
                                $NoneLinkCheck = FALSE;
                                $SystemImagesDisplay = "style='display:none;'";
                                $DropboxImagesDisplay = "style='display:none;'";
                                $ExternalLinkImagesDisplay = "style=''";
                            }
                        } else {
                            $SystemCheck = TRUE;
                            $DropboxCheck = FALSE;
                            $ExternalLinkCheck = FALSE;
                            $SystemImagesDisplay = "style=''";
                            $DropboxImagesDisplay = "style='display:none;'";
                            $ExternalLinkImagesDisplay = "style='display:none;'";
                        }
                        $AllChkBox = "";

                        $ByPercentChkBox = array(
                            'name' => 'chrImageFlag',
                            'id' => 'chrImageFlagS',
                            'value' => 'S',
                            'class' => 'user-redio-button UploadFile',
                            'checked' => $SystemCheck,
                            'onclick' => 'Show_BG_Box(this.value);'
                        );
                        $AllChkBox .= form_input_ready($ByPercentChkBox, 'radio') . '<label for="chrImageFlagS"> System </label>';

                        $ByExternalChkBox = array(
                            'name' => 'chrImageFlag',
                            'id' => 'chrImageFlagE',
                            'value' => 'E',
                            'class' => 'user-redio-button',
                            'checked' => $ExternalLinkCheck,
                            'onclick' => 'Show_BG_Box(this.value);',
                        );
                        $AllChkBox .= form_input_ready($ByExternalChkBox, 'radio') . '<label for="chrImageFlagE"> External Link </label>';
                        $CBoxdata = array(
                            'extraDataInTD' => $AllChkBox
                        );
                        echo form_input_ready($CBoxdata);
                        ?> 

                        <div id="SystemImagesDisplayDiv" <?php echo $SystemImagesDisplay; ?>> 
                            <div class="uk-form-file md-btn md-btn-primary">
                                Upload
                                <input id="varImage" name="varImage" type="file">
                            </div>
                            <div class="clear"></div>
                            <label class="error" for="varImage"></label>
                        </div>
                        <div class="fl" id="ExternalLinkImagesDisplayDiv" <?php echo $ExternalLinkImagesDisplay; ?>> 
                            <?php
                            $UGCLabelData = array(
                                'label' => '',
                                'required' => ''
                            );
                            echo form_input_label($UGCLabelData);

                            $URLBoxdata = array(
                                'name' => 'varExternalUrl',
                                'id' => 'varExternalUrl',
                                'style' => 'width:345px',
                                'class' => 'md-input',
                                'value' => (!empty($Row['varExternalUrl']) ? $Row['varExternalUrl'] : 'http://www'),
                                'placeholder' => 'http://www.mywebsite.com'
                            );
                            echo form_input_ready($URLBoxdata);
                            ?>
                            <div class="clear"></div>
                            <label class="error" for="varExternalUrl"></label>
                        </div>
                        <?php
                        $ImagePath = 'upimages/banner/images/' . $Row['varImage'];
                        if (file_exists($ImagePath) && $Row['varImage'] != '') {
                            $image_thumb = image_thumb($ImagePath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                            if ($Row['Chr_Banner_Type'] == 'H' || $Row['Chr_Banner_Type'] == 'S') {
                                $image_thumb = image_thumb($ImagePath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                                $image_detail_thumb = image_thumb($ImagePath, HOME_BANNER_WIDTH, HOME_BANNER_HEIGHT);
//                                                    $image_detail_thumb = SITE_PATH . 'upimages/banner/images/' . $Row['varImage'];
                            } else {
                                $image_thumb = image_thumb($ImagePath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                                $image_detail_thumb = image_thumb($ImagePath, INNER_BANNER_WIDTH, INNER_BANNER_HEIGHT);
                            }
                        }
                        if (!empty($eid)) {
                            if (file_exists($ImagePath)) {
                                ?>
                                <div class="fl mgtm5" id="hide_div"> 
                                    <?php
                                    $ImageName = $Row['varImage'];
                                    if ($ImageName != "") {
                                        ?>                               
                                        <?php
//                                            if ($Row['chrImageFlag'] == 'S') {
//                                                $disp_div .= "<div class=\"title-form fl\" id='selectdiv'><strong></strong>&nbsp;&nbsp;";
//                                            } else {
//                                                $disp_div .= "<div class=\"title-form fl\" id='selectdiv2'><strong></strong>&nbsp;&nbsp;";
//                                            }


                                        if ($Row['Chr_Banner_Type'] == 'H') {
                                            $disp_div .= "<div class=\"gallery_grid_item md-card-content\">&nbsp;&nbsp;
                                                      <a href=\"" . $image_detail_thumb . "\" data-uk-lightbox=\"{group:'gallery'}\">
                                                            <img src=\"" . $image_thumb . "\" />
                                                        </a>
                                                    </div>";

                                            echo $disp_div;
                                        } else {
                                            $disp_div .= "<div class=\"gallery_grid_item md-card-content\">&nbsp;&nbsp;
                                                      <a href=\"" . $image_detail_thumb . "\" data-uk-lightbox=\"{group:'gallery'}\">
                                                            <img src=\"" . $image_thumb . "\" />
                                                        </a>
                                                    </div>";

                                            echo $disp_div;
                                        }
                                        ?> 

                                        <?php
                                    } else if ($Row['chrImageFlag'] == 'E') {
                                        echo '<span class="lbl-note">Sorry! The provided path of an external link is not found please try again.</span>';
                                    }
                                    ?> 
                                  
                                </div>      


                                <?php
                            }
                            ?>

                            <?php
                        }
                        if ($Row['Chr_Banner_Type'] == 'I') {
                            $Width = INNER_BANNER_WIDTH;
                            $Height = INNER_BANNER_HEIGHT;
                        } else {
                            $Width = HOME_BANNER_WIDTH;
                            $Height = HOME_BANNER_HEIGHT;
                        }
                        ?>
                    </div>
                </div>

                <div class="clear"></div>
                <div class="fl" id="upload_note" <?php echo $NoneNoteDisplay; ?>>
                    <span class="uk-form-help-block">Upload Image file of format only *.jpg, *.jpeg, *.png or *.gif. Having maximum size of 5MB.
                        <div id="size">(Recommended Image Dimension Width <b><?php echo $Width; ?>px</b>X&nbsp;Height <b><?php echo $Height; ?>px</b>, Maximum Image Dimension Width 4000px X Height 4000px) <br/>
                            The generated thumb of an uploaded image is greater than Width 4000px X  Height 4000px (in size), it may slow down the performance of the respective page and the time to load it would also increase.</div>
                    </span> 
                </div> 
                  <div class="spacer10"></div>



                <!---------------------------End Image Code--------------------------->         
            </div>
        </div>


        <div class="md-card">
            <div class="md-card-content">
                <div class="fix_width">
                    <div class="inquiry-form">
                        <label>Display Order</label>
                        <?php if ($eid != 1 && $Row['fk_ParentPageGlCode'] == 0) { ?>
                            <input type="text" class="md-input" name="intDisplayOrder" id="intDisplayOrder" value="<?php echo (!empty($eid) ? $Row['intDisplayOrder'] : '2'); ?>" onkeypress="return KeycheckOnlyNumeric(event);"/>
                        <?php } else {
                            ?>
                            <input type="text" class="md-input" name="intDisplayOrder" id="intDisplayOrder" value="<?php echo (!empty($eid) ? $Row['intDisplayOrder'] : '2'); ?>" onkeypress="return KeycheckOnlyNumeric(event);"/>
                        <?php } ?>

                        <?php
                        if ($CountChild > 0 || $Row['Noofrows'] > 0 || $Row['TotalPage'] > 0 || $Row['int_id'] == '1' || $Row['fk_ModuleGlCode'] > 2) {
                            $style = 'style="display:none"';
                        } else {
                            $style = '';
                        }
                        ?>
                        <div <?= $style; ?>> 
                            <label>Display</label> 

                            <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: Please select 'Yes' if you want to display / activate this record. Otherwise please select 'NO'"; ?>">help</i>
                            <?php
                            if (!empty($eid)) {
                                $publishYRadio = array(
                                    'name' => 'chrPublish',
                                    'id' => 'chrPublishY',
                                    'value' => 'Y',
                                    'class' => 'data-md-icheck',
                                    'checked' => ($Row['chrPublish'] == 'Y') ? TRUE : FALSE
                                );
                                echo form_input_ready($publishYRadio, 'radio');
                                ?>                                                    
                                <label for="chrPublishY" class="inline-label" onclick="if (document.getElementById('chrPublishY').checked != true)
                                        document.getElementById('chrPublishY').checked = true;">Yes</label>
                                       <?php
                                   } else {
                                       $publishYRadio = array(
                                           'name' => 'chrPublish',
                                           'id' => 'chrPublishY',
                                           'value' => 'Y',
                                           'class' => 'data-md-icheck',
                                           'checked' => TRUE
                                       );
                                       echo form_input_ready($publishYRadio, 'radio');
                                       ?>                                                    
                                <label for="chrPublishY" class="inline-label" onclick="if (document.getElementById('chrPublishY').checked != true)
                                        document.getElementById('chrPublishY').checked = true;">Yes</label>
                                       <?php
                                   }

                                   if (!empty($eid)) {
                                       $publishNRadio = array(
                                           'name' => 'chrPublish',
                                           'id' => 'chrPublishN',
                                           'value' => 'N',
                                           'class' => 'data-md-icheck',
                                           'checked' => ($Row['chrPublish'] == 'N') ? TRUE : FALSE
                                       );
                                       echo form_input_ready($publishNRadio, 'radio');
                                       ?>  
                                <label for="chrPublishN" class="inline-label" onclick="if (document.getElementById('chrPublishN').checked != true)
                                        document.getElementById('chrPublishN').checked = true;" >No</label>
                                       <?php
                                   } else {
                                       $publishNRadio = array(
                                           'name' => 'chrPublish',
                                           'id' => 'chrPublishN',
                                           'value' => 'N',
                                           'class' => 'data-md-icheck',
                                           'checked' => FALSE
                                       );
                                       echo form_input_ready($publishNRadio, 'radio');
                                       ?>
                                <label for="chrPublishN" class="inline-label" onclick="if (document.getElementById('chrPublishN').checked != true)
                                        document.getElementById('chrPublishN').checked = true;">No</label>
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