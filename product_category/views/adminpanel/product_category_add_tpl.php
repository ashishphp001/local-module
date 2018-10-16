<link rel="stylesheet" href="<?php echo ADMIN_MEDIA_URL; ?>assets/skins/dropify/css/dropify.css">
<script>
    function approvaldiv(result)
    {
        if (result == 'Y') {
            var name = "Approved";
        } else {
            var name = "Disable";
        }
        UIkit.modal.confirm('Caution! This product will be ' + name + '. Press OK to confirm.', function () {

            var Eid = document.getElementById("ehintglcode").value;

            $.ajax({
                type: 'POST',
                data: {"csrf_indibizz": csrfHash, 'chrApprove': result, "Eid": Eid},
                url: '<?php echo ADMINPANEL_URL . 'product_category/approve_product_category/'; ?>',
                success: function (Result) {
                    location.reload();
                }
            });


        });
    }
    function checkurl1(url)
    {
        var RegExp = /^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.[a-zA-Z]+[a-zA-Z]+[a-zA-Z]*)/;
        if (RegExp.test(url)) {
            return true;
        } else {
            return false;
        }
    }
</script>
<script type="text/javascript">

    function getchanged()
    {
        var Title = document.getElementById("varName").value;
        var Title1 = Title;
        var Meta_keyword = Title;
        document.getElementById("varMetaTitle").value = Title1;
        document.getElementById("varMetaKeyword").value = Meta_keyword;
        CountLeft(document.Frmproduct_category.varMetaTitle, document.Frmproduct_category.metatitle_left, 200);
//        CountLeft(document.Frmproduct_category.varMetaDescription,document.Frmproduct_category.metadescription_left,400);
        CountLeft(document.Frmproduct_category.varMetaKeyword, document.Frmproduct_category.metakeyword_left, 200);
    }
    function generate_seocontent(flag) {
        var title = trim(document.getElementById('varName').value);
//        var abcd1 = CKEDITOR.instances.txtDescription.getData();
//        if (abcd1 != '')
//        {
        var abcd = document.getElementById('varName').value;
//        } else {
//        var abcd = CKEDITOR.instances.txtDescription.getData();
//        }
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
        CountLeft(document.Frmproduct_category.varMetaTitle, document.Frmproduct_category.metatitle_left, 200);
        CountLeft(document.Frmproduct_category.varMetaDescription, document.Frmproduct_category.metadescription_left, 400);
        CountLeft(document.Frmproduct_category.varMetaKeyword, document.Frmproduct_category.metakeyword_left, 400);
    }

<?php if (!empty($eid) && $edit_record) { ?>
        $(document).ready(function ()
        {
            CountLeft(document.Frmproduct_category.varMetaTitle, document.Frmproduct_category.metatitle_left, 200);
            CountLeft(document.Frmproduct_category.varMetaDescription, document.Frmproduct_category.metadescription_left, 400);
            CountLeft(document.Frmproduct_category.varMetaKeyword, document.Frmproduct_category.metakeyword_left, 400);
        });
<?php } ?>

    function Show_BG_Box(sel)
    {
        if (sel == 'S')
        {
            $("#SystemImagesDisplayDiv").show();
            $("#DropboxImagesDisplaydiv").hide();
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
            $("#DropboxImagesDisplaydiv").hide();
            $("#upload_note").show();
            $("#selectdiv2").show();
            $("#selectdiv").hide();
        }

    }

    $(document).ready(function () {
        document.getElementById("VarDropboxImage").addEventListener("DbxChooserSuccess",
                function (e) {
                    if ((parseInt(e.files[0].bytes) / 1048576) > 5) {
                        alert("Upload document file Having maximum size of 5MB.");
                        $("#VarDropboxImage").val('');
                        Dropbox.preventDefault();
                        return false;
                    }
                }, false);
    });
    $("#intDisplayOrder").removeClass("ignore");

    $(document).ready(function ()
    {
        $('#varAlias').bind("cut copy paste", function (e)
        {
            e.prblogsDefault();
        });
        $('#varName').keypress(function (blogs)
        {
            var keycode = (blogs.keyCode ? blogs.keyCode : blogs.which);
            if (keycode == '13')
            {
                $('#varName').blur();
            }
        });
    });

    function quickedit(Action)
    {
        var url = "<?php echo SITE_PATH ?>" + $("#varAlias").val();
            Quick_Edit_Alias_Ajax(Action, url, 'varName', encodeURIComponent('<?php echo $eid ?>'), encodeURIComponent('<?php echo MODULE_ID ?>'), '<?php echo COMMON_ALIAS_EXISTS_MSG ?>');
    }

    $(document).ready(function ()
    {


        $.validator.addMethod("Chk_Image_Size", function (product_category, value) {
            var flag = true;
            var selection = document.getElementById('varImage');
            for (var i = 0; i < selection.files.length; i++) {
                var file = selection.files[i].size;
                var FIVE_MB = Math.round(1024 * 1024 * 5);
                if (file > FIVE_MB) {
                    flag = false;
                }
            }
            return flag;
        }, IMAGE_INVALID_SIZE);

        $.validator.addMethod("UrlValidate_Logo", function (value, element)
        {
            var link_ext = value;
            var valid_extensions = /(\.png)$/i;
            if ($("#chrImageFlagE").is(':checked') && (valid_extensions.test(link_ext)))
            {
                var link = value;
                return checkurl(link);
            } else
            {
                return false;
            }

        }, GLOBAL_IMAGE_EXT_URL_MSG);

        $.validator.addMethod("alphanumeric", function (value, element) {
            if (value.replace(/[^A-Z]/gi, "").length >= 2) {
                return true;
            } else if (value.replace(/[^0-9]/gi, "").length >= 2) {
                return true;
            } else {
                return false;
            }
        }, GLOBAL_VALID_TITLE);
        $.validator.addMethod("system_image_validation", function (value, element)
        {
            var selection = document.getElementById('varImage').value;
            if (selection != '') {
                var res1 = selection.substring(selection.lastIndexOf(".") + 1);
                var res = res1.toLowerCase();
                if (res == "png") {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }, 'Only .png image formats are supported.');
        $("#intDisplayOrder").removeClass("ignore");
        $("#Frmproduct_category").validate({
            ignore: [],
            rules: {
                varName: {
                    required: true,
                    alphanumeric: true
                },
                varShortDesc: {
                    required: true
                },
                varImage: {
//                    required: {
//                        depends: function () {
//                            if ($("#hidd_VarImage").val() == '' && $("#varImage").val() == '')
//                            {
//                                if ($("#chrImageFlagS").is(":checked")) {
//                                    return true;
//                                } else {
//                                    return false;
//                                }
//                            }
//<?php // if ($eid != '' && $Row_product_category['chrImageFlag'] == 'B') { ?>
//                                if ($("#hidd_VarImage").val() != '' && $("#varImage").val() == '')
//                                {
//                                    if ($("#chrImageFlagS").is(":checked")) {
//                                        return true;
//                                    } else if ($("#chrImageFlagB").is(":checked")) {
//                                        return false;
//                                    } else if ($("#chrImageFlagE").is(":checked")) {
//                                        return false;
//                                    }
//                                }
//<?php // } else if ($eid != '' && $Row_product_category['chrImageFlag'] == 'E') { ?>
//                                if ($("#hidd_VarImage").val() != '' && $("#varImage").val() == '')
//                                {
//                                    if ($("#chrImageFlagS").is(":checked")) {
//                                        return true;
//                                    } else if ($("#chrImageFlagB").is(":checked")) {
//                                        return false;
//                                    } else if ($("#chrImageFlagB").is(":checked")) {
//                                        return false;
//                                    }
//                                }
//<?php // } ?>
//                        }
//                    },
                    accept: "png",
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
//                    required: {
//                        depends: function () {
//                            if ($("#hidd_VarImage").val() == '' && $("#VarDropboxImage").val() == '')
//                            {
//                                if ($("#chrImageFlagB").is(":checked")) {
//                                    return true;
//                                } else {
//                                    return false;
//                                }
//                            }
//<?php // if ($eid != '' && $Row_product_category['chrImageFlag'] == 'S') { ?>
//                                if ($("#hidd_VarImage").val() != '' && $("#varImage").val() == '')
//                                {
//                                    if ($("#chrImageFlagS").is(":checked")) {
//                                        return false;
//                                    } else if ($("#chrImageFlagB").is(":checked")) {
//                                        return true;
//                                    } else if ($("#chrImageFlagE").is(":checked")) {
//                                        return false;
//                                    }
//
//                                }
//<?php // } else if ($eid != '' && $Row_product_category['chrImageFlag'] == 'E') { ?>
//                                if ($("#hidd_VarImage").val() != '' && $("#varImage").val() == '')
//                                {
//                                    if ($("#chrImageFlagS").is(":checked")) {
//                                        return false;
//                                    } else if ($("#chrImageFlagB").is(":checked")) {
//                                        return true;
//                                    } else if ($("#chrImageFlagE").is(":checked")) {
//                                        return false;
//                                    }
//
//                                }
//<?php // } ?>
//                        }
//                    },
                    accept: "png"
                },
                varExternalUrl:
                        {
//                            required:
//                                    {
//                                        depends: function ()
//                                        {
//                                            var Eid = '<?php echo $Row_product_category['int_id'] ?>';
//                                            var PrevSelected = '<?php echo $Row_product_category['chrImageFlag'] ?>';
//                                            if (Eid != '' && PrevSelected != 'E' && $("#chrImageFlagE").is(':checked'))
//                                            {
//                                                return true;
//                                            } else
//                                            {
//                                                if ($("#chrImageFlagE").is(":checked") && $("#hidd_VarImage").val() == '')
//                                                {
//                                                    return true;
//                                                } else
//                                                {
//                                                    return false;
//                                                }
//                                            }
//                                        }
//                                    },
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
//                intDisplayOrder: {
//                    displayorder: ['intDisplayOrder'],
//                    maxlength: 3
//                }
            },
            messages: {
                varName: {
                    required: NEWS_TITLE
                },
                varShortDesc: {
                    required: "Please enter short description."
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
//                intDisplayOrder: {
//                    required: GLOBAL_PROPER_DISPLAY_ORDER,
//                    maxlength: GLOBAL_DISPLAYORDER_LIMIT
//                }
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
                <li><a href="<?php echo MODULE_PAGE_NAME; ?>">Manage Product Categories</a></li>
                <li><span>

                        <?php
                        $title1 = $Row_product_category['varName'];
                        if (strlen($title1) > 80) {
                            $title = substr($Row_product_category['varName'], 0, 80) . "...";
                        } else {
                            $title = $Row_product_category['varName'];
                        }
                        if (!empty($eid)) {
                            echo 'Edit Product Category - ' . $title;
                        } else {
                            echo 'Add Product Category';
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
        $attributes = array('name' => 'Frmproduct_category', 'id' => 'Frmproduct_category', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
        if ($edit_record) {
            echo form_open($action, $attributes);
        }
        ?>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                echo form_hidden('btnsaveandc_x', '');
                echo form_hidden('varImageHidden', $Row_product_category['varImage']);
                if (!empty($eid)) {
                    echo form_hidden('ehintglcode', $eid);
                    echo form_hidden('Alias_Id', $Row_product_category['Alias_Id']);
                    echo form_hidden('eid', $Row_product_category['int_id']);
                    echo form_hidden('Hid_varAlias', $Row_product_category['varAlias']);
                    echo form_hidden('Old_DisplayOrder', $Row_product_category['intDisplayOrder'], '', 'id="Old_DisplayOrder"');
                }
                echo form_hidden('hidd_VarImage', $Row_product_category['varImage']);
                echo form_hidden('hidd_ImageFlag', $flag);
                if (ADMIN_ID != 1) {
                    $style = 'style="display: none"';
                }
                ?>            
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-2-2">
                            <label>Select Product Category</label>
                            <?php
                            echo $pagetree;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label> Title*</label>
                            <?php
                            if (!empty($eid)) {
                                $EditAlias = "Y";
                                $titleBoxdata = array(
                                    'name' => 'varName',
                                    'id' => 'varName',
                                    'value' => $Row_product_category['varName'],
                                    'onblur' => ($alias_validation) ? "Auto_Alias('" . $EditAlias . "',this.id,'" . base64_encode($eid) . "','" . base64_encode(MODULE_ID) . "','N');" : "",
                                    'class' => 'md-input'
                                );
                            } else {
                                $EditAlias = "N";
                                $titleBoxdata = array(
                                    'name' => 'varName',
                                    'id' => 'varName',
                                    'value' => $Row_product_category['varName'],
                                    'onblur' => ($alias_validation) ? "Auto_Alias('" . $EditAlias . "',this.id,'" . base64_encode($eid) . "','" . base64_encode(MODULE_ID) . "','N');" : "",
                                    'onkeyup' => 'getchanged()',
                                    'class' => 'md-input'
                                );
                            }

                            echo form_input($titleBoxdata);
                            ?>
                            <div class="clear"></div>
                            <label class="error" for="varName"></label>
                        </div>
                    </div>
                </div>


                <div class="clear"></div>
                <?php if ($alias_validation) { ?>
                    <div class="uk-form-row">
                        <?php
                        $param = array(
                            "name" => "varAlias",
                            'value' => set_value('varAlias', $Row_product_category['varAlias']),
                            "linkServices" => 'onclick="CheckingAlias(\'varAlias\',\'' . base64_encode($Row_product_category['varAlias']) . '\',\'' . base64_encode(MODULE_ID) . '\',\'' . MODULE . '\')"',
                            "eid" => $eid,
                            'class' => 'md-input',
                            "edit_record" => $edit_record
                        );
                        echo $aliaText = $this->mylibrary->Alias_Textbox($param);
                        ?>
                    </div>
                <?php } ?>
                <div class="clear"></div>
                <!------------------Image code start ------------------>
                <div class="uk-form-row">
                    <div class="uk-width-medium-1-2">
                        <label> Upload Image</label>
                        <div class="clear"></div>
                        <?php
                        if (!empty($eid)) {
                            if ($Row_product_category['chrImageFlag'] == 'S') {
                                $SystemCheck = TRUE;
                                $DropboxCheck = FALSE;
                                $ExternalLinkCheck = FALSE;
                                $NoneLinkCheck = FALSE;
                                $SystemImagesDisplay = "style=''";
                                $DropboxImagesDisplay = "style='display:none;'";
                                $ExternalLinkImagesDisplay = "style='display:none;'";
                            } else if ($Row_product_category['chrImageFlag'] == 'B') {
                                $SystemCheck = FALSE;
                                $DropboxCheck = TRUE;
                                $ExternalLinkCheck = FALSE;
                                $NoneLinkCheck = FALSE;
                                $SystemImagesDisplay = "style='display:none;'";
                                $DropboxImagesDisplay = "style=''";
                                $ExternalLinkImagesDisplay = "style='display:none;'";
                            } else if ($Row_product_category['chrImageFlag'] == 'E') {
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

                        $ByPriceChkBox = array(
                            'name' => 'chrImageFlag',
                            'id' => 'chrImageFlagB',
                            'value' => 'B',
                            'class' => 'user-redio-button UploadFile',
                            'checked' => $DropboxCheck,
                            'onclick' => 'Show_BG_Box(this.value);'
                        );
                        $AllChkBox .= form_input_ready($ByPriceChkBox, 'radio') . '<label for="chrImageFlagB"> Dropbox </label>';

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

                        $ImagePath = 'upimages/product_category/images/' . $Row_product_category['varImage'];
                        if (file_exists($ImagePath) && $Row_product_category['varImage'] != '') {
                            $image_thumb = image_thumb($ImagePath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                            $image_detail_thumb = image_thumb($ImagePath, PRODUCTS_CATEGORY_WIDTH, PRODUCTS_CATEGORY_HEIGHT);
                        }
                        ?> 

                        <div class="clear"></div>

                        <div id="SystemImagesDisplayDiv" <?php echo $SystemImagesDisplay; ?>> 
                            <!--                            <div class="uk-form-file md-btn md-btn-primary">
                                                            Upload-->
                            <!--<div class="uk-width-medium-1-2">-->
                            <div class="md-card">
                                <div class="md-card-content">
                                    <h3 class="heading_a uk-margin-small-bottom">
                                        Min & Max Width / Min & Max Height <span class="sub-heading">min <?php echo PRODUCTS_CATEGORY_WIDTH; ?>px, max <?php echo PRODUCTS_CATEGORY_HEIGHT; ?>px</span>
                                    </h3>
                                    <input type="file" data-default-file="<?php echo $image_detail_thumb; ?>" name="varImage" id="varImage" class="dropify" data-min-width="<?php echo PRODUCTS_CATEGORY_WIDTH - 1; ?>" data-max-width="1200" data-min-height="<?php echo PRODUCTS_CATEGORY_HEIGHT - 1; ?>" data-max-height="1200" />
                                </div>
                            </div>
                            <!--</div>-->

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
                                'value' => (!empty($Row_product_category['varExternalUrl']) ? $Row_product_category['varExternalUrl'] : 'http://www'),
                                'placeholder' => 'http://www.mywebsite.com'
                            );
                            echo form_input_ready($URLBoxdata);
                            ?>
                            <div class="clear"></div>
                            <label class="error" for="varExternalUrl"></label>
                        </div>
                        <div id="DropboxImagesDisplaydiv" <?php echo $DropboxImagesDisplay; ?>> 
                            <?php
                            $UGCLabelData = array(
                                'label' => '',
                                'required' => '',
                            );
                            echo form_input_label($UGCLabelData);
                            $dropBoxdata = array(
                                'name' => 'VarDropboxImage',
                                'id' => 'VarDropboxImage',
                                'data-extensions' => '.png',
                                'type' => 'dropbox-chooser'
                            );
                            echo form_input_ready($dropBoxdata);
                            ?>
                            <div class="clear"></div>
                            <label class="fr error" for="VarDropboxImage"></label>
                        </div>
                        <?php
                        if (!empty($eid)) {
                            if (file_exists($ImagePath)) {
                                ?>
                                <div id="hide_div"> 
                                    <?php
                                    $ImageName = $Row_product_category['varImage'];
                                    if ($ImageName != "") {
                                        ?>                               
                                        <?php
                                        if ($Row_product_category['chrImageFlag'] != 'S') {
                                            $disp_div .= "<div class=\"gallery_grid_item md-card-content\">
                                                      <a href=\"" . $image_detail_thumb . "\" data-uk-lightbox=\"{group:'gallery'}\">
                                                            <img src=\"" . $image_thumb . "\" />
                                                        </a>
                                                    </div>";
                                            echo $disp_div;
                                        }
                                        ?>                   
                                        <?php
                                    } elseif ($Row_product_category['chrImageFlag'] == 'E') {
                                        echo '<span class="uk-form-help-block danger">Sorry! The provided path of an external link is not found please try again.</span>';
                                    }
                                    ?>                    
                                </div>

                                <?php
                            }
                            ?>
                            <?php
                        }
                        ?>
                    </div>

                </div>
                <div class="clear"></div>
                <div class="fl" id="upload_note" <?php echo $NoneNoteDisplay; ?>>
                    <span class="uk-form-help-block">Upload Image file of format only *.png. Having maximum size of 5MB.
                        <div id="size">(Recommended Image Dimension Width <b><?php echo PRODUCTS_CATEGORY_WIDTH; ?>px</b>X&nbsp;Height <b><?php echo PRODUCTS_CATEGORY_HEIGHT; ?>px</b>, Maximum Image Dimension Width 4000px X Height 4000px) <br/>
                            The generated thumb of an uploaded image is greater than Width 4000px X  Height 4000px (in size), it may slow down the performance of the respective page and the time to load it would also increase.</div>
                    </span> 
                </div> 



                <!---------------------------End Image Code--------------------------->     

                <div class="spacer10"></div>

            </div>
        </div>

        <div class="md-card">
            <div class="md-card-content">
                <?php
                $val_metatitle = (!empty($eid) ? ($Row_product_category['varMetaTitle']) : '');
                $val_metakeyword = (!empty($eid) ? ($Row_product_category['varMetaKeyword']) : '');
                $val_metadescription = (!empty($eid) ? ($Row_product_category['varMetaDescription']) : '');
                $param = array("varMetaTitle" => $val_metatitle, "varMetaKeyword" => $val_metakeyword, "varMetaDescription" => $val_metadescription);
                echo $this->mylibrary->seo_textdetails($param, '', $this->module_url, 'Frmproduct_category');
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
                <div class="fix_width">
                    <input type="hidden" id="intDisplayOrder" name="intDisplayOrder" value="<?php echo (!empty($eid) ? $Row_product_category['intDisplayOrder'] : '1'); ?>" >
                    <label>Display</label> 
                    <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: Please select 'Yes' if you want to display / activate this record. Otherwise please select 'NO'"; ?>">help</i>

                    <?php
                    if (!empty($eid)) {
                        $publishYRadio = array(
                            'name' => 'chrPublish',
                            'id' => 'chrPublishY',
                            'value' => 'Y',
                            'class' => 'form-rediobutton',
                            'checked' => ($Row_product_category['chrPublish'] == 'Y') ? TRUE : FALSE
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
                               'checked' => ($Row_product_category['chrPublish'] == 'N') ? TRUE : FALSE
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
                <div class="spacer10"></div>
                <?php
                if (($permissionArry['Approve'] == 'Y') && (ADMIN_ID == 1 || ADMIN_ID == 2)) {
                    ?>
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
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php if (!empty($eid)) { ?>
    <?php
    if (($permissionArry['Approve'] == 'Y')) {
        if ($Row_product_category['chrApprove'] == 'N') {
            ?>
            <div class="md-fab-wrapper">
                <a onclick="return approvaldiv('Y');" title="Click here to approve this product category." class="md-fab md-fab-success" href="javascript:;" >
                    <i class="material-icons">check_circle</i>
                </a>
            </div>
        <?php } else { ?>
            <div class="md-fab-wrapper">
                <a onclick="return approvaldiv('N');" title="Click here to disable this product category." class="md-fab md-fab-danger" href="javascript:;">
                    <i class="material-icons">highlight_off</i>
                </a>
            </div> 
            <?php
        }
    }
}
echo form_close();
?>

<?php $dropbox = DROPBOX_LIVE_KEY; ?>
<script type="text/javascript" src="https://www.dropbox.com/static/api/1/dropins.js" id="dropboxjs" data-app-key="<?php echo $dropbox ?>"></script>
<script src="<?php echo ADMIN_MEDIA_URL; ?>bower_components/dropify/dist/js/dropify.min.js"></script>
<script src="<?php echo ADMIN_MEDIA_URL; ?>assets/js/pages/forms_file_input.min.js"></script>