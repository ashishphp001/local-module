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
        $.validator.addMethod("Chk_Image_Size", function (team, value)
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
        $("#FrmTeams").validate({
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
                            required: "Please select system image to upload.",
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
<div class="content-wrapper">
    <section class="content-header">
        <h1>

            <?php
            if (!empty($eid)) {
                echo 'Edit Team Member - ' . $Row['varName'];
            } else {
                echo 'Add Team Member';
            }
            ?>
            <!--<small>Home Page Images</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php
                echo '<a class="fr Editable-btn" href="' . MODULE_PAGE_NAME . '">
                <span><b class="icon-caret-left"></b>Manage Team Members</span>
            </a>';
                ?>
            </li>
        </ol>
    </section>
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
    <section class="content">
        <div class="content_top_btn">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="require-lbl">* Required Field</div>
                        <div class="spacer10"></div>
                        <div class="contact-title" style="cursor:pointer;" onclick="javascript:expandcollapsepanel('DIV_gen_info', 'Gen_Plus_Minus');">
                            General Details
                            <span id="Gen_Plus_Minus" class="minus-icn"></span> 
                        </div>
                        <div class="spacer10"></div>
                        <?php
                        $attributes = array('name' => 'FrmTeams', 'id' => 'FrmTeams', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
                        echo form_open($action, $attributes);
                        echo form_hidden('btnsaveandc_x', '');
                        echo form_hidden('hidd_VarImage', $Row['varImage']);
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
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label> Name</label> <span class="required"></span>
                                            <div class="clear"></div>  
                                            <?php
                                            $titleBoxdata = array(
                                                'name' => 'varName',
                                                'id' => 'varName',
                                                'value' => $Row['varName'],
                                                'maxlength' => '250',
                                                'class' => 'form-control'
                                            );
                                            echo form_input($titleBoxdata);
                                            ?>
                                        </div>
                                    </div> 
                                </div> 
                                <div class="spacer10"></div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label> Designation </label>
                                            <div class="clear"></div>  
                                            <?php
                                            $designationBoxdata = array(
                                                'name' => 'varDesignation',
                                                'id' => 'varDesignation',
                                                'value' => $Row['varDesignation'],
                                                'maxlength' => '250',
                                                'class' => 'form-control'
                                            );
                                            echo form_input($designationBoxdata);
                                            ?>
                                        </div>
                                    </div> 
                                </div> 
                                <div class="spacer10"></div>

                                <!------------------Image code start ------------------>

                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label> Upload Image</label><span class="required"></span>

                                            <div class="clear"></div>  

                                        </div>

                                        <div class="clear"></div>
                                        <div class="fl"> 
                                            <div class="fl" id="SystemImagesDisplayDiv" <?php echo $SystemImagesDisplay; ?>> 
                                                <?php
                                                $imageLabelData = array(
                                                    'label' => '',
                                                    'required' => '',
                                                );
                                                echo form_input_label($imageLabelData);
                                                $CFBoxdata = array(
                                                    'name' => 'varImage',
                                                    'id' => 'varImage',
                                                    'class' => 'fl brd-brows',
                                                );
                                                echo form_input_ready($CFBoxdata, 'upload');
                                                ?>
                                                <div class="clear"></div>
                                                <label class="fr error" for="varImage"></label>
                                            </div>
                                        </div>
                                        <?php
                                        $ImagePath = 'upimages/team/images/' . $Row['varImage'];
                                        if (file_exists($ImagePath) && $Row['varImage'] != '') {
                                            $image_thumb = image_thumb($ImagePath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                                            $image_detail_thumb = image_thumb($ImagePath, TEAM_WIDTH, TEAM_HEIGHT);
                                        }
                                        if (!empty($eid)) {
                                            if (file_exists($ImagePath)) {
                                                ?>
                                                <div id="hide_div"> 
                                                    <div class="fl">
                                                        <?php
                                                        $ImageName = $Row['varImage'];
                                                        if ($ImageName != "") {
                                                            $disp_div .= "<div class=\"title-form fl\" id='selectdiv'><strong></strong>&nbsp;&nbsp;";

                                                            $disp_div .= "<span id=\"divdelbro\" class=\"title-form fl\" >&nbsp;&nbsp;
                                                      <a href=\"#varMenuIconImage\" class=\"fancybox-buttons\" data-fancybox-group=\"button\">
                                                            <img title=\"" . htmlentities($this->common_model->GetImageNameOnly($Row['varImage'])) . "\" class=\"mgr15\" src=\"" . $image_thumb . "\" alt=\"View\"  border=\"0\" align=\"absmiddle\" id=\"myimage\" />
                                                                <span id=\"varMenuIconImage\" style=\"display:none\">
                                                                    <img title=\"" . htmlentities($this->common_model->GetImageNameOnly($Row['varImage'])) . "\" src=\"" . $image_detail_thumb . "\" alt=\"View\"  border=\"0\" align=\"absmiddle\" id=\"myimage\" />
                                                                </span>
                                                        </a>
                                                        <a href=\"javascript:;\" onclick=\"delete_image('" . $Row['int_id'] . "','" . $Row['varImage'] . "',1);\"><div class=\"btn btn-default\" style=\"margin-left: 20px;\">Delete</div></a>
                                                    </span>";
                                                            echo $disp_div;
                                                        }
                                                        ?> 
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <!--<div class="row">-->
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="fl" id="upload_note" <?php echo $NoneNoteeDisplay; ?>>
                                        <span class="spannote">Upload Image file of format only *.jpg, *.jpeg, *.png or *.gif. Having maximum size of 5MB.<br>
                                            (Recommended Image Dimension <?php echo TEAM_WIDTH; ?>px Width X <?php echo TEAM_HEIGHT; ?>px Height, Maximum Image Dimension 4000px Width X 4000px Height)</span> 
                                    </div>   
                                </div>   
                                <!---------------------------End Image Code--------------------------->  
                                <div class="clear"></div>
                                <div class="spacer10"></div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label> Short Description</label> <span class="required"></span>
                                        <div class="clear"></div> 
                                        <?php
                                        $titleLabelData = array(
                                        );
                                        echo form_input_label($titleLabelData);
                                        $Desccounter = array('id' => 'Desccountleft',
                                            'name' => 'Desccountleft',
                                            'value' => 400 - strlen($Row['varShortDesc']),
                                            'class' => 'form-control',
                                            'style' => 'text-align: center; display: inline ! important; width: 48px ! important; height: 33px;',
                                            'readonly' => 'readonly'
                                        );
                                        ?>
                                        <!--                                </div>
                                                                        <div class="col-md-6 col-sm-6 col-xs-12">-->
                                        <div class="form-group">
                                            <?php
                                            $short_descBoxdata = array(
                                                'name' => 'varShortDesc',
                                                'id' => 'varShortDesc',
                                                'maxlength' => '400',
                                                'style' => 'float: left; height: 100px; overflow: auto; max-width: 453px;',
                                                'onKeyDown' => 'CountLeft(this.form.varShortDesc,this.form.Desccountleft,400);',
                                                'class' => 'form-control',
                                                'onKeyUp' => 'CountLeft(this.form.varShortDesc,this.form.Desccountleft,400);',
                                                'value' => set_value('varShortDesc', htmlspecialchars($Row['varShortDesc'])),
                                                'extraDataInTD' => form_input_ready($Desccounter)
                                            );
                                            echo form_input_ready($short_descBoxdata, 'textarea');
                                            ?>
                                            <!--<div class="clear"></div>-->
                                            <label class="error" for="varShortDesc"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <?php
                    $DisplayInfoDivDisplay = 'style="display:none;"';
                    $Displayinfo_Plus_Minus = 'plus-icn';
                    if (!empty($eid)) {
                        $DisplayInfoDivDisplay = '';
                        $Displayinfo_Plus_Minus = 'minus-icn';
                    }
                    if ($eid == 1) {
                        $styledisplay = 'style="cursor:pointer;display:none;"';
                    } else {
                        $styledisplay = 'style="cursor:pointer;';
                    }
                    if (!empty($eid)) {
                        $DisplayInfoDivDisplay = '';
                        $Displayinfo_Plus_Minus = 'minus-icn';
                    }
                    ?>
                    <div class="spacer10"></div>
                    <?php if ($eid == 1) { ?>
                        <input type="hidden" name="intDisplayOrder" value=<?php echo $Row['intDisplayOrder']; ?>>
                    <?php } ?>
                    <div class="contact-title" style="cursor:pointer;" onclick="javascript:expandcollapsepanel('DIV_displayinfo', 'Displayinfo_Plus_Minus');">
                        Display Information
                        <span id="Displayinfo_Plus_Minus" class="<?php echo $Displayinfo_Plus_Minus; ?>"></span> 
                    </div>
                    <div class="spacer10"></div>
                    <div class="fix_width" id="DIV_displayinfo" <?php echo $DisplayInfoDivDisplay; ?>>
                        <div class="inquiry-form">
                            <div class="fl"> 
                                <div class="title-form fl">Display Order</div><span class="fl required"></span>
                                <div class="fl mgl10">
                                    <?php
                                    $DOBoxdata1 = array(
                                        'name' => 'intDisplayOrder',
                                        'id' => 'intDisplayOrder',
                                        'value' => (!empty($eid) ? $Row['intDisplayOrder'] : '1'),
                                        'maxlength' => '3',
                                        'class' => 'form-control',
                                        'onkeypress' => 'return KeycheckOnlyNumeric(team);',
                                    );
                                    echo form_input_ready($DOBoxdata1);
                                    ?>
                                </div>
                            </div>
                            <div class="spacer10"></div>
                            <div class="fl title-w" > 
                                <div class="title-form fl">Display</div> <span class="fl required"></span>
                                <div class="fl mgl50">
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
                                <div class="fl mgl5 tooltip" style="position: relative;" title="<strong><?php echo "Note: Please select 'Yes' if you want to display / activate this record. Otherwise please select 'NO'" ?></strong>" >
                                    <img style="vertical-align:middle;margin-left:5px" width="16" height="16" alt="" onmouseout="hidediv('dvhlpvarwebsite');" onmouseover="showDiv(team, 'dvhlpvarwebsite')" src="<?php echo GLOBAL_ADMIN_IMAGES_PATH; ?>/help.png">
                                </div>
                            </div>
                        </div>
                        <div class="spacer10"></div>
                    </div>
                    <div class="spacer10"></div>
                    <?php
                    $Form_Submit = array('name' => 'btnsaveandc', 'id' => 'btnsaveandc', 'value' => 'Save &amp; Keep Editing', 'class' => 'btn btn-primary btn-flat btn_blue');
                    echo form_submit($Form_Submit);
                    ?>
                    <?php
                    $Form_Submit = array('name' => 'btnsaveande', 'id' => 'btnsaveande', 'value' => 'Save &amp; Exit', 'class' => 'btn btn-primary btn-flat btn_blue');
                    echo form_submit($Form_Submit);
                    ?>

                    <a href="<?php echo MODULE_PAGE_NAME; ?>" title="Cancel">
                        <div  class="btn btn-default">
                            Cancel
                        </div>
                    </a>
                    <div class="spacer10"></div>
                    <?php echo form_close(); ?>
                </div>
                </section>
            </div>