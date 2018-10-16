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

    function getchanged()
    {
        var Title = document.getElementById("varCompany").value;
        var Title1 = Title;
        var Meta_keyword = Title;
        document.getElementById("varMetaTitle").value = Title1;
        document.getElementById("varMetaKeyword").value = Meta_keyword;
        CountLeft(document.FrmBuyer.varMetaTitle, document.FrmBuyer.metatitle_left, 200);
        CountLeft(document.FrmBuyer.varMetaDescription, document.FrmBuyer.metadescription_left, 400);
        CountLeft(document.FrmBuyer.varMetaKeyword, document.FrmBuyer.metakeyword_left, 200);
    }
    function generate_seocontent(flag) {
        var title = trim(document.getElementById('varCompany').value);

        var abcd = document.getElementById('varCompany').value;

        var def = abcd.replace(/<a(\s[^>]*)?>.*?<\/a>/ig, "")
        var abc = def.replace(/^(\s*)|(\s*)$/g, '').replace(/\s+/g, ' ');
        var outString1 = abc.replace(/(<([^>]+)>)/ig, "");
        var outString2 = outString1;
        var outString = outString2.replace(/&nbsp;/g, '');
        var new_maintext1 = outString.replace(/&amp;/g, '&');
        var new_maintext2 = new_maintext1.replace(/&quot;/g, '"');
        var new_maintext3 = new_maintext2.replace(/&#39;/g, "'");
        var maintext = new_maintext3.replace(/[`~!@#$%^*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
        if (flag == 'a')
        {
            document.getElementById('varMetaTitle').value = title.substr(0, 200);
            document.getElementById('varMetaDescription').value = maintext.substr(0, 400);
            document.getElementById('varMetaKeyword').value = title;
        } else
        {
            document.getElementById('varMetaTitle').value = title.substr(0, 200);
            document.getElementById('varMetaDescription').value = maintext.substr(0, 400);
            document.getElementById('varMetaKeyword').value = title;
        }
        CountLeft(document.FrmBuyer.varMetaTitle, document.FrmBuyer.metatitle_left, 200);
        CountLeft(document.FrmBuyer.varMetaDescription, document.FrmBuyer.metadescription_left, 400);
        CountLeft(document.FrmBuyer.varMetaKeyword, document.FrmBuyer.metakeyword_left, 400);
    }

<?php if (!empty($eid) && $edit_record) { ?>
        $(document).ready(function ()
        {
            CountLeft(document.FrmBuyer.varMetaTitle, document.FrmBuyer.metatitle_left, 200);
            CountLeft(document.FrmBuyer.varMetaDescription, document.FrmBuyer.metadescription_left, 400);
            CountLeft(document.FrmBuyer.varMetaKeyword, document.FrmBuyer.metakeyword_left, 400);
        });
<?php } ?>

    $(document).ready(function ()
    {
        $('#varAlias').bind("cut copy paste", function (e)
        {
            e.prblogsDefault();
        });
        $('#varCompany').keypress(function (blogs)
        {
            var keycode = (blogs.keyCode ? blogs.keyCode : blogs.which);
            if (keycode == '13')
            {
                $('#varCompany').blur();
            }
        });
    });


    function quickedit(Action)
    {
        var url = "<?php echo SITE_PATH ?>" + $("#varAlias").val();
        Quick_Edit_Alias_Ajax(Action, url, 'varCompany', encodeURIComponent('<?php echo $eid ?>'), encodeURIComponent('2'), '<?php echo COMMON_ALIAS_EXISTS_MSG ?>');
    }

    $(document).ready(function () {
        $.validator.addMethod("Chk_Image_Size", function (users, value)
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
        $("#FrmBuyer").validate({
            ignore: [],
            rules: {
                varName: {
                    required: true
                },
                varAlias: {
                    required: true
                },
                varCompany: {
                    required: true
                },
                varPhone: {
                    minlength: 5,
                    required: true,
                    maxlength: 20,
                    phonenumber: {
                        depends: function () {
                            if (($("#varPhone").val()) != '') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                varLocation: {
                    required: true
                },
                varEmail: {
                    email: true,
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
                }

            },
            messages: {
                varName: {
                    required: "Please enter name."
                },
                varAlias: {
                    required: "Please enter alias."
                },
                varCompany: {
                    required: "Please enter company name."
                },
                varLocation: {
                    required: "Please enter location."
                },
                varPhone: {
                    required: "Please enter contact number.",
                    minlength: "<div class='fl mgt5 mgr20'><?php echo CONTACTINFO_MINIMUM_PHONE_MSG ?></div>",
                    maxlength: "<div class='fl mgt5 mgr20'><?php echo CONTACTINFO_MAXIMUM_PHONE_MSG ?></div>"
                },
                varEmail: {
                    email: "Please enter valid email address.",
                    required: "Please enter the email."
                },
                varImage: {
                    required: "Please upload system image.",
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
                <li><a href="<?php echo MODULE_PAGE_NAME; ?>">Manage Buyer / Seller</a></li>
                <li><span>
                        <?php
                        if (!empty($eid)) {
                            echo 'Edit Buyer / Seller - ' . $Row['varName'];
                        } else {
                            echo 'Add Buyer / Seller';
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
        $attributes = array('name' => 'FrmBuyer', 'id' => 'FrmBuyer', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
        echo form_open($action, $attributes);
        ?>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                echo form_hidden('btnsaveandc_x', '');
                echo form_hidden('hidd_VarImage', $Row['varImage']);
                if (!empty($eid)) {
                    echo form_hidden('ehintglcode', $eid);
                    echo form_hidden('eid', $Row['int_id']);
                    echo form_hidden('Hid_varAlias', $Row['varAlias']);
//                    echo form_hidden('Old_fk_ParentPageGlCode', $Row['fk_ParentPageGlCode'], '', 'id="Old_fk_ParentPageGlCode"');
                }
                ?>
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
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
                            <label class="error" for="varName"></label>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <label> Company Name *</label>
                            <?php
                            if (!empty($eid)) {
                                $EditAlias = "Y";
                                $titleBoxdata = array(
                                    'name' => 'varCompany',
                                    'id' => 'varCompany',
                                    'value' => $Row['varCompany'],
                                    'onblur' => ($alias_validation) ? "Auto_Alias('" . $EditAlias . "',this.id,'" . base64_encode($eid) . "','" . base64_encode(MODULE_ID) . "','N');" : "",
                                    'class' => 'md-input'
                                );
                            } else {
                                $EditAlias = "N";
                                $titleBoxdata = array(
                                    'name' => 'varCompany',
                                    'id' => 'varCompany',
                                    'value' => $Row['varCompany'],
                                    'onblur' => ($alias_validation) ? "Auto_Alias('" . $EditAlias . "',this.id,'" . base64_encode($eid) . "','" . base64_encode(MODULE_ID) . "','N');" : "",
                                    'onkeyup' => 'getchanged()',
                                    'class' => 'md-input'
                                );
                            }

                            echo form_input($titleBoxdata);
                            ?>
                            <label class="error" for="varCompany"></label>
                        </div>
                    </div> 
                </div>
                <div class="clear"></div>
                <?php if ($alias_validation) { ?>
                    <div class="uk-form-row">
                        <?php
                        $param = array(
                            "name" => "varAlias",
                            'value' => set_value('varAlias', $Row['varAlias']),
                            "linkServices" => 'onclick="CheckingAlias(\'varAlias\',\'' . base64_encode($Row['varAlias']) . '\',\'' . base64_encode(MODULE_ID) . '\',\'' . MODULE . '\')"',
                            "eid" => $eid,
                            'class' => 'md-input',
                            "edit_record" => $edit_record
                        );
                        echo $aliaText = $this->mylibrary->Alias_Textbox($param);
                        ?>
                    </div>
                <?php }
                echo  $Row['varSubdomain'];
                ?>
                
                <div class="clear"></div> 
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label>Email *</label>
                            <?php
                            $emailBoxdata = array(
                                'name' => 'varEmail',
                                'id' => 'varEmail',
                                'value' => $Row['varEmail'],
                                'maxlength' => '250',
                                'class' => 'md-input'
                            );
                            echo form_input($emailBoxdata);
                            ?>
                            <label class="error" for="varEmail"></label>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <label> Contact Number *</label>
                            <?php
                            $phoneBoxdata = array(
                                'name' => 'varPhone',
                                'id' => 'varPhone',
                                'value' => $Row['varPhone'],
                                'class' => 'md-input'
                            );
                            echo form_input($phoneBoxdata);
                            ?>
                            <label class="error" for="varPhone"></label>
                        </div>
                    </div> 
                </div>
                <div class="uk-form-row">
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <?php
                            $decrypted_password = $this->mylibrary->decryptPass($Row['varPassword']);
                            ?>
                            <input class="md-input" type="password" id="varPassword" value="<?php echo $decrypted_password; ?>" name="varPassword"/>
                            <a href="" class="uk-form-password-toggle" data-uk-form-password>show</a>
                        </div>
                    </div>
                </div>
                <!------------------Image code start ------------------>

                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <!--<label>&nbsp;</label>-->
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
                    $ImagePath = 'upimages/users/images/' . $Row['varImage'];
                    if (file_exists($ImagePath) && $Row['varImage'] != '') {
                        $image_thumb = image_thumb($ImagePath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                        $image_detail_thumb = image_thumb($ImagePath, USERS_WIDTH, USERS_HEIGHT);
                    }
                    if (!empty($eid)) {
                        if (file_exists($ImagePath)) {

                            $ImageName = $Row['varImage'];

                            if ($ImageName != "") {
                                ?>                               
                                <div class="gallery_grid_item md-card-content">
                                    <a href="<?php echo $image_detail_thumb; ?>" data-uk-lightbox="{group:'gallery'}">
                                        <img src="<?php echo $image_thumb; ?>" title="<?php echo $Row['varName']; ?>" alt="<?php echo $Row['varName']; ?>">
                                    </a>  
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
                <div class="clear"></div>
                <div class="uk-form-help-block" id="upload_note" <?php echo $NoneNoteeDisplay; ?>>
                    <span class="spannote">Upload Image file of format only *.jpg, *.jpeg, *.png or *.gif. Having maximum size of 5MB.<br>
                        (Recommended Image Dimension <?php echo USERS_WIDTH; ?>px Width X <?php echo USERS_HEIGHT; ?>px Height, Maximum Image Dimension 4000px Width X 4000px Height)</span> 
                </div>   
                <!---------------------------End Image Code--------------------------->    
            </div>
        </div>
        <div class="md-card">
            <div class="md-card-content">

                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-2-2">
                            <label >Search Location *</label>
                            <?php
                            $companyBoxdata = array(
                                'name' => 'varLocation',
                                'id' => 'varLocation',
                                'value' => $Row['varLocation'],
                                'class' => 'md-input label-fixed'
                            );
                            echo form_input($companyBoxdata);
                            ?>
                            <label class="error" for="varLocation"></label>
                        </div>
                    </div> 
                </div>
                <!--<table id="address">-->
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-1">
                            <label> Address </label>
                            <input class="md-input label-fixed" name="varAddress1" value="<?php echo $Row['varAddress1']; ?>" id="location">
                        </div>
<!--                        <div class="uk-width-medium-1-2">
                            <label> Street address 2</label>
                            <input class="md-input label-fixed" name="varAddress2" value="<?php echo $Row['varAddress2']; ?>" id="route">
                        </div>-->
                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-4">
                            <label> City</label>
                            <input class="md-input label-fixed" id="locality" name="varCity" value="<?php echo $Row['varCity']; ?>">
                        </div>
                        <div class="uk-width-medium-1-4">
                            <label> State</label>
                            <input class="md-input label-fixed" name="varState" id="administrative_area_level_1" value="<?php echo $Row['varState']; ?>">
                        </div>
                        <div class="uk-width-medium-1-4">
                            <label> Zip code</label>
                            <input class="md-input label-fixed" name="varZipcode" id="postal_code" value="<?php echo $Row['varZipcode']; ?>">
                        </div>
                        <div class="uk-width-medium-1-4">
                            <label> Country</label>
                            <input class="md-input label-fixed" name="varCountry" id="country" value="<?php echo $Row['varCountry']; ?>">
                            <input class="md-input label-fixed" type="hidden" name="varLatitude" id="varLatitude" value="<?php echo $Row['varLatitude']; ?>">
                            <input class="md-input label-fixed" type="hidden"  name="varLongitude" id="varLongitude" value="<?php echo $Row['varLongitude']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>


        <div class="md-card">
            <div class="md-card-content">
                <?php
                $val_metatitle = (!empty($eid) ? ($Row['varMetaTitle']) : '');
                $val_metakeyword = (!empty($eid) ? ($Row['varMetaKeyword']) : '');
                $val_metadescription = (!empty($eid) ? ($Row['varMetaDescription']) : '');
                $param = array("varMetaTitle" => $val_metatitle, "varMetaKeyword" => $val_metakeyword, "varMetaDescription" => $val_metadescription);
                echo $this->mylibrary->seo_textdetails($param, '', $this->module_url, 'FrmBuyer');
                $DisplayInfoDivDisplay = 'style="display:none;"';
                $Displayinfo_Plus_Minus = 'plus-icn';
                if (!empty($eid)) {
                    $DisplayInfoDivDisplay = '';
                    $Displayinfo_Plus_Minus = 'minus-icn';
                }
                ?>  
            </div>
        </div>

        <div class="md-card">
            <div class="md-card-content">
                <div class="fl title-w" > 
                    <label>Display</label> 
                    <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: Please select 'Yes' if you want to display / activate this record. Otherwise please select 'NO'"; ?>">help</i></div>
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
                    <a style="text-decoration:none;" onclick="if (document.getElementById('chrPublishY').checked != true)
                                    document.getElementById('chrPublishY').checked = true;" href="javascript:">Yes</a>
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
                    <a style="text-decoration:none;" onclick="if (document.getElementById('chrPublishY').checked != true)
                                    document.getElementById('chrPublishY').checked = true;" href="javascript:">Yes</a>
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
                    <a style="text-decoration:none;" onclick="if (document.getElementById('chrPublishN').checked != true)
                                    document.getElementById('chrPublishN').checked = true;" href="javascript:">No</a>
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
                    <a style="text-decoration:none;" onclick="if (document.getElementById('chrPublishN').checked != true)
                                    document.getElementById('chrPublishN').checked = true;" href="javascript:">No</a>
                       <?php
                   }
                   ?>

            </div>  


            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-form-row">
                        <button class="md-btn md-btn-primary md-btn-wave-light" value="btnsaveandc" name="btnsaveandc" id="btnsaveandc">Save &amp; Keep Editing</button>
                        <button class="md-btn md-btn-primary md-btn-wave-light" name="btnsaveande" id="btnsaveande">Save &amp; Exit</button>
                        <a href="<?php echo MODULE_PAGE_NAME; ?>" title="Cancel">
                            <div class="md-btn md-btn-wave">
                                Cancel
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="spacer10"></div>
    <?php echo form_close(); ?>
</div>
<div id="map"></div>
<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'));
        var input = document.getElementById('varLocation');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }


            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }

        for (var i = 0; i < place.address_components.length; i++) {
                if (place.address_components[i].types[0] == 'postal_code') {
                    document.getElementById('postal_code').value = place.address_components[i].long_name;
                }
                if (place.address_components[i].types[0] == 'administrative_area_level_1') {
                    document.getElementById('administrative_area_level_1').value = place.address_components[i].long_name;
                }
                if (place.address_components[i].types[0] == 'locality') {
                    document.getElementById('locality').value = place.address_components[i].long_name;
                }
                if (place.address_components[i].types[0] == 'country') {
                    document.getElementById('country').value = place.address_components[i].long_name;
                }
            }
            document.getElementById('location').value = place.formatted_address;
            document.getElementById('lat').value = place.geometry.location.lat();
            document.getElementById('lon').value = place.geometry.location.lng();
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY; ?>&libraries=places&callback=initMap&region=in" async defer></script>