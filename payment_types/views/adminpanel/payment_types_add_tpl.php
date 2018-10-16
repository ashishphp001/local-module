<link rel="stylesheet" href="<?php echo ADMIN_MEDIA_URL; ?>assets/skins/dropify/css/dropify.css">
<script type="text/javascript">

    $(document).ready(function () {
        $("#Frmpayment_types").validate({
            ignore: [],
            rules: {
                varName: {
                    required: true
                },
                varImage: {
                    accept: "jpg,png,jpeg,gif",
                    required: {
                        depends: function () {
                            if ($("#hidd_VarImage").val() == '' && $("#varImage").val() == '')
                            {
                                return true;
                            } else {
                                return false;
                            }
<?php if ($eid != '') { ?>
                                if ($("#hidd_VarImage").val() != '' && $("#varImage").val() == '')
                                {
                                    return true;
                                } else
                                {
                                    return false;
                                }
<?php } ?>
                        }
                    },
                    system_image_validation: true,
                    Chk_Image_Size: true
                }
            },
            messages: {
                varName: {
                    required: "Please enter name."
                },
                varImage: {
                    required: "Please upload image.",
                    accept: "Only *.jpg, *.jpeg, *.png or *.gif image formats are supported."
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
                    form.submit();
                }
            }
        });
    });

    function delete_image()
    {
        var conf = confirm("The selected image will be deleted. Press OK to confirm");
        if (conf == true)
        {
            document.getElementById('divdelbro').innerHTML = '';
            document.getElementById('hidd_VarImage').value = '';
            alert('Image is deleted successfully');
        }
    }

</script>
<div id="page_content_inner">
    <div id="page_content">
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                <li><a href="<?php echo MODULE_PAGE_NAME; ?>">Manage Payment Types</a></li>
                <li><span>
                        <?php
                        if (!empty($eid)) {
                            echo 'Edit Payment Types - ' . $Row['varName'];
                        } else {
                            echo 'Add Payment Types';
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
        $attributes = array('name' => 'Frmpayment_types', 'id' => 'Frmpayment_types', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
        echo form_open($action, $attributes);
        echo form_hidden('btnsaveandc_x', '');
        ?>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                if (!empty($eid)) {
                    echo form_hidden('ehintglcode', $eid);
                    echo form_hidden('eid', $Row['int_id']);
                }
                echo form_hidden('varImageHidden', $Row['varImage']);
                echo form_hidden('hidd_VarImage', $Row['varImage']);
                echo form_hidden('hidd_ImageFlag', $flag);
                ?>
                <div class="uk-form-row">
                    <div class="uk-width-medium-1-2">
                        <label>Name *</label>
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

                    <!------------------Image code start ------------------>

                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <label>&nbsp;</label>
                                <div class="clear"></div>
                                <?php
                                if (!empty($eid)) {
                                    if ($Row['chrImageFlag'] == 'S') {
                                        $SystemCheck = TRUE;
                                        $ExternalLinkCheck = FALSE;
                                        $NoneLinkCheck = FALSE;
                                        $SystemImagesDisplay = "style=''";
                                        $ExternalLinkImagesDisplay = "style='display:none;'";
                                    }
                                } else {
                                    $SystemCheck = TRUE;
                                    $ExternalLinkCheck = FALSE;
                                    $SystemImagesDisplay = "style=''";
                                    $ExternalLinkImagesDisplay = "style='display:none;'";
                                }
                                $AllChkBox = "";
                                ?> 
                            </div>
                        </div>
                        <div class="uk-form-file md-btn md-btn-primary">
                            Upload Image
                            <input id="varImage" name="varImage" type="file">
                        </div>
                        <div class="clear"></div>
                        <label class="error" for="varImage"></label>
                        <?php
                        $ImagePath = 'upimages/payment_types/images/' . $Row['varImage'];
                        if (file_exists($ImagePath) && $Row['varImage'] != '') {
                            $image_thumb = image_thumb($ImagePath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                            $image_detail_thumb = image_thumb($ImagePath, BUY_LEADS_WIDTH, BUY_LEADS_HEIGHT);
                        }
                        if (!empty($eid)) {
                            if (file_exists($ImagePath)) {
                                ?>
                                <?php
                                $ImageName = $Row['varImage'];
                                if ($ImageName != "") {
                                    ?>                               
                                    <?php
                                    $disp_div .= "<div class=\"gallery_grid_item md-card-content\" id=\"divdelbro\" >&nbsp;&nbsp;
                                                      <a href=\"" . $image_detail_thumb . "\" data-uk-lightbox=\"{group:'gallery'}\">
                                                            <img src=\"" . $image_thumb . "\" />
                                                      </a><a href=\"javascript:;\" onclick=\"delete_image('" . $Row['int_id'] . "','" . $Row['varImage'] . "',1);\"><div class=\"md-btn md-btn-wave\">Delete</div></a>
                                                    </div>";
                                    echo $disp_div;
                                }
                                ?>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="clear"></div>
                    <div class="uk-form-help-block" id="upload_note" <?php echo $NoneNoteeDisplay; ?>>
                        <span class="spannote">Upload Image file of format only *.jpg, *.jpeg, *.png or *.gif. Having maximum size of 5MB.<br>
                            (Recommended Image Dimension <?php echo BUY_LEADS_WIDTH; ?>px Width X <?php echo BUY_LEADS_HEIGHT; ?>px Height, Maximum Image Dimension 4000px Width X 4000px Height)</span> 
                    </div>   
                    <!---------------------------End Image Code--------------------------->    

                </div> 
                <label class="error" for="varName"></label>
            </div>
        </div>

        <div class="md-card">
            <div class="md-card-content">
                <div class="spacer10"></div>
                <div class="inquiry-form">

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
<script src="<?php echo ADMIN_MEDIA_URL; ?>bower_components/dropify/dist/js/dropify.min.js"></script>
<script src="<?php echo ADMIN_MEDIA_URL; ?>assets/js/pages/forms_file_input.min.js"></script>