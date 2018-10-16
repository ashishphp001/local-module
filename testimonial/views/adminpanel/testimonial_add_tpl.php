<script type="text/javascript">

    function checkurl1(url)
    {
        var RegExp = /^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.[a-zA-Z]+[a-zA-Z]+[a-zA-Z]*)/;
        if (RegExp.test(url)) {
            return true;
        } else {
            return false;
        }
    }
    $(document).ready(function () {
        $.validator.addMethod("Chk_Image_Size", function (testimonial, value)
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
        }, 'Image size invalid');
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
        }, 'file extention not valid');
        $.validator.addMethod("system_image_validation", function (value, element)
        {
            var selection = document.getElementById('varImage').value;
            if (selection != '') {
                var res1 = selection.substring(selection.lastIndexOf(".") + 1);
                var res = res1.toLowerCase();
                if (res == "jpg" || res == "jpeg" || res == "gif" || res == "png" || res == "JPG" || res == "JPEG" || res == "GIF" || res == "PNG") {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }, 'Only .jpg, .jpeg, .png or .gif image formats are supported.');
        $("#FrmTestimonials").validate({
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
                        }
                    },
                    Chk_Image_Size: {
                        depends: function () {
                            return true;
                        }
                    }
                },
                intDisplayOrder: {
                    displayorder: ['intDisplayOrder']
                }

            },
            messages: {
                varName: {
                    required: "Please enter the name."
                },
                varImage:
                        {
                            required: "Please select image to upload.",
                            accept: "Only *.jpg, *.jpeg, *.png or *.gif image formats are supported."
                        },
                intDisplayOrder: {
                    required: GLOBAL_PROPER_DISPLAY_ORDER
                }
            },

            errorPlacement: function (error, element)
            {
                if ($(element).attr('id') == 'varFile')
                {
                    error.appendTo('#varimageerror');
                } else
                {
                    error.insertAfter(element);
                }
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
    function checkurl(url)
    {
        var RegExp = /^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/;

        if (RegExp.test(url)) {
            return true;
        } else {
            return false;
        }
    }
</script>
<script type="text/javascript">
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
                <li><a href="<?php echo MODULE_PAGE_NAME; ?>">Manage Testimonials</a></li>
                <li><span>
                        <?php
                        if (!empty($eid)) {
                            echo 'Edit Testimonial - ' . $Row['varName'];
                        } else {
                            echo 'Add Testimonial';
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
        $attributes = array('name' => 'FrmTestimonials', 'id' => 'FrmTestimonials', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
        echo form_open($action, $attributes);
        echo form_hidden('btnsaveandc_x', '');
        echo form_hidden('hidd_VarImage', $Row['varImage']);
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
                <div class="fix_width" id="DIV_gen_info">
                    <div class="box-body">
                        <!--<div class="inquiry-form">-->
                        <div class="uk-form-row">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <label> Name *</label>
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
                                    <label class="error" for="varName"></label>
                                </div>
                            </div> 
                        </div> 
                        <!--<div class="spacer10"></div>-->
                        <div class="uk-form-row">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <label> Designation </label>
                                    <?php
                                    $designationBoxdata = array(
                                        'name' => 'varDesignation',
                                        'id' => 'varDesignation',
                                        'value' => $Row['varDesignation'],
                                        'maxlength' => '250',
                                        'class' => 'md-input'
                                    );
                                    echo form_input($designationBoxdata);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="spacer10"></div>

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
                                Upload Listing Image
                                <input id="varImage" name="varImage" type="file">
                            </div>
                            <div class="clear"></div>
                            <label class="error" for="varImage"></label>
                            <?php
                            $ImagePath = 'upimages/testimonial/images/' . $Row['varImage'];
                            if (file_exists($ImagePath) && $Row['varImage'] != '') {
                                $image_thumb = image_thumb($ImagePath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                                $image_detail_thumb = image_thumb($ImagePath, TESTIMONIALS_WIDTH, TESTIMONIALS_HEIGHT);
                            }
                            if (!empty($eid)) {
                                if (file_exists($ImagePath)) {
                                    ?>
                                    <?php
                                    $ImageName = $Row['varImage'];
                                    if ($ImageName != "") {
                                        ?>                               
                                        <?php
                                        $disp_div .= "<div class=\"gallery_grid_item md-card-content\">&nbsp;&nbsp;
                                                      <a href=\"" . $image_detail_thumb . "\" data-uk-lightbox=\"{group:'gallery'}\">
                                                            <img src=\"" . $image_thumb . "\" />
                                                      </a>
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
                                (Recommended Image Dimension <?php echo TESTIMONIALS_WIDTH; ?>px Width X <?php echo TESTIMONIALS_HEIGHT; ?>px Height, Maximum Image Dimension 4000px Width X 4000px Height)</span> 
                        </div>   
                        <!---------------------------End Image Code--------------------------->   

                        <div class="spacer10"></div>
                        <div class="uk-form-row">
                            <div class="uk-width-medium-1-2">
                                <label> Short Description</label>
                                <?php
                                $short_descBoxdata = array(
                                    'name' => 'varShortDesc',
                                    'id' => 'varShortDesc',
                                    'maxlength' => '200',
                                    'cols' => '30',
                                    'rows' => '4',
                                    'onKeyDown' => 'CountLeft(this.form.varShortDesc,this.form.Desccountleft,200);',
                                    'class' => 'md-input',
                                    'onKeyUp' => 'CountLeft(this.form.varShortDesc,this.form.Desccountleft,200);',
                                    'value' => set_value('varShortDesc', htmlspecialchars($Row['varShortDesc'])),
                                    'extraDataInTD' => form_input_ready($Desccounter)
                                );
                                echo form_input_ready($short_descBoxdata, 'textarea');
                                ?>
                                <label class="error" for="varShortDesc"></label>
                            </div>
                        </div>



                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        
        <div class="spacer10"></div>
        <?php if ($eid == 1) { ?>
            <input type="hidden" name="intDisplayOrder" value=<?php echo $Row['intDisplayOrder']; ?>>
        <?php } ?>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-form-row">
                    <div class="uk-width-medium-1-2">
                        <label>Display Order *</label>
                        <?php
                        $DOBoxdata1 = array(
                            'name' => 'intDisplayOrder',
                            'id' => 'intDisplayOrder',
                            'value' => (!empty($eid) ? $Row['intDisplayOrder'] : '1'),
                            'maxlength' => '3',
                            'class' => 'md-input',
                            'onkeypress' => 'return KeycheckOnlyNumeric(testimonial);',
                        );
                        echo form_input_ready($DOBoxdata1);
                        ?>
                        <label class="error" for="intDisplayOrder"></label>
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
        </div> 
    </div>
</div>
