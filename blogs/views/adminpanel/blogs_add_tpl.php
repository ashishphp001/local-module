<script>
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
        var Title = document.getElementById("varTitle").value;
        var Title1 = Title;
        var Meta_keyword = Title;
        document.getElementById("varMetaTitle").value = Title1;
        document.getElementById("varMetaKeyword").value = Meta_keyword;
        CountLeft(document.Frmblogs.varMetaTitle, document.Frmblogs.metatitle_left, 200);
//        CountLeft(document.Frmblogs.varMetaDescription,document.Frmblogs.metadescription_left,400);
        CountLeft(document.Frmblogs.varMetaKeyword, document.Frmblogs.metakeyword_left, 200);
    }
    function generate_seocontent(flag) {
        var title = trim(document.getElementById('varTitle').value);
        var abcd1 = CKEDITOR.instances.txtDescription.getData();
//        if (abcd1 != '')
//        {
//            var abcd = document.getElementById('varShortDesc').value;
//        } else {
        var abcd = CKEDITOR.instances.txtDescription.getData();
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
        CountLeft(document.Frmblogs.varMetaTitle, document.Frmblogs.metatitle_left, 200);
        CountLeft(document.Frmblogs.varMetaDescription, document.Frmblogs.metadescription_left, 400);
        CountLeft(document.Frmblogs.varMetaKeyword, document.Frmblogs.metakeyword_left, 400);
    }
    function fckfocus()
    {
        var oFCKeditor = FCKeditorAPI.GetInstance('txtDescription');
        oFCKeditor.Focus();
    }
</script>
<script type="text/javascript">
<?php if (!empty($eid) && $edit_record) { ?>
        $(document).ready(function ()
        {
            CountLeft(document.Frmblogs.varMetaTitle, document.Frmblogs.metatitle_left, 200);
            CountLeft(document.Frmblogs.varMetaDescription, document.Frmblogs.metadescription_left, 400);
            CountLeft(document.Frmblogs.varMetaKeyword, document.Frmblogs.metakeyword_left, 400);
        });
<?php } ?>
    function Show_BG_Box(sel)
    {
        if (sel == 'S')
        {
            $("#SystemImagesDisplayDiv").show();
            $("#ExternalLinkImagesDisplayDiv").hide();
            $("#selectdiv").show();
            $("#selectdiv1").hide();
            $("#selectdiv2").hide();
        }
    }
    $("#intDisplayOrder").removeClass("ignore");
    $(document).ready(function ()
    {
        $('#varAlias').bind("cut copy paste", function (e)
        {
            e.prblogsDefault();
        });
        $('#varTitle').keypress(function (blogs)
        {
            var keycode = (blogs.keyCode ? blogs.keyCode : blogs.which);
            if (keycode == '13')
            {
                $('#varTitle').blur();
            }
        });
    });
    function quickedit(Action)
    {
        var url = "<?php echo SITE_PATH ?>" + $("#varAlias").val();
        Quick_Edit_Alias_Ajax(Action, url, 'varTitle', encodeURIComponent('<?php echo $eid ?>'), encodeURIComponent('2'), '<?php echo COMMON_ALIAS_EXISTS_MSG ?>');
    }
    $(document).ready(function ()
    {


        $.validator.addMethod("Chk_Image_Size", function (blogs, value) {
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

        $.validator.addMethod("Chk_Image_Size1", function (blogs, value) {
            var flag = true;
            var selection = document.getElementById('varImage1');
            for (var i = 0; i < selection.files.length; i++) {
                var file = selection.files[i].size;
                var FIVE_MB = Math.round(1024 * 1024 * 5);
                if (file > FIVE_MB) {
                    flag = false;
                }
            }
            return flag;
        }, IMAGE_INVALID_SIZE);


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
                if (res == "jpg" || res == "jpeg" || res == "gif" || res == "png") {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }, 'Only .jpg, .jpeg, .png or .gif image formats are supported.');

        $.validator.addMethod("system_image_validation", function (value, element)
        {
            var selection = document.getElementById('varImage1').value;
            if (selection != '') {
                var res1 = selection.substring(selection.lastIndexOf(".") + 1);
                var res = res1.toLowerCase();
                if (res == "jpg" || res == "jpeg" || res == "gif" || res == "png") {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }, 'Only .jpg, .jpeg, .png or .gif image formats are supported.');


        $("#intDisplayOrder").removeClass("ignore");
        $("#Frmblogs").validate({
            ignore: [],
            rules: {
                varTitle: {
                    required: true,
                    alphanumeric: true
                },
                varType: {
                    required: true
                },
                varAuthor: {
                    required: true
                },
                varShortDesc: {
                    required: true
                },
                dtBlogDate: {
                    required: true
                },
                varImage: {
                    accept: "jpg,png,jpeg,gif",
                    required: {
                        depends: function () {
                            if ($("#hidd_VarImage").val() == '' && $("#varImage").val() == '')
                            {
                                return true;
                            } else
                            {
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
                    Chk_Image_Size: true
                },
                varImage1: {
                    accept: "jpg,png,jpeg,gif",
                    required: {
                        depends: function () {
                            if ($("#hidd_VarImage1").val() == '' && $("#varImage1").val() == '')
                            {
                                return true;
                            } else
                            {
                                return false;
                            }
<?php if ($eid != '') { ?>
                                if ($("#hidd_VarImage1").val() != '' && $("#varImage1").val() == '')
                                {
                                    return true;
                                } else
                                {
                                    return false;
                                }
<?php } ?>
                        }
                    },
                    Chk_Image_Size1: true
                },
                intDisplayOrder: {
                    displayorder: ['intDisplayOrder'],
                    maxlength: 3
                }
            },
            messages: {
                varTitle: {
                    required: NEWS_TITLE
                },
                varType: {
                    required: "Please enter type of blog."
                },
                varAuthor: {
                    required: "Please enter author."
                },
                varShortDesc: {
                    required: "Please enter short description."
                },
                varImage:
                        {
                            required: "Please select listing image.",
                            accept: "Only *.jpg, *.jpeg, *.png or *.gif image formats are supported."
                        },
                varImage1:
                        {
                            required: "Please select detail image.",
                            accept: "Only *.jpg, *.jpeg, *.png or *.gif image formats are supported."
                        },
                dtBlogDate: {
                    required: NEWS_REPORT_DATE
                },
                intDisplayOrder: {
                    required: GLOBAL_PROPER_DISPLAY_ORDER,
                    maxlength: GLOBAL_DISPLAYORDER_LIMIT
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
    function delete_image1()
    {
        var conf = confirm("The selected image will be deleted. Press OK to confirm");
        if (conf == true)
        {
            document.getElementById('divdelbro1').innerHTML = '';
            document.getElementById('hidd_VarImage1').value = '';
            alert('Image is deleted successfully');
        }
    }

//    function check_datediv()
//    {
//        if (document.getElementById('dt_enddate_expiry').checked == true)
//        {
//            document.getElementById('dtEndDate').style.display = 'none';
//        } else
//        {
//            document.getElementById('dtEndDate').style.display = '';
//        }
//    }
</script>
<div id="page_content_inner">
    <div id="page_content">
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                <li><a href="<?php echo MODULE_PAGE_NAME; ?>">Manage Blogs</a></li>
                <li><span> <?php
                        $title1 = $Row_blogs['varTitle'];
                        if (strlen($title1) > 80) {
                            $title = substr($Row_blogs['varTitle'], 0, 80) . "...";
                        } else {
                            $title = $Row_blogs['varTitle'];
                        }
                        if (!empty($eid)) {
                            echo 'Edit Blog - ' . $title;
                        } else {
                            echo 'Add Blog';
                        }
                        ?></span></li>
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
        $attributes = array('name' => 'Frmblogs', 'id' => 'Frmblogs', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
        if ($edit_record) {
            echo form_open($action, $attributes);
        }
        ?>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                echo form_hidden('btnsaveandc_x', '');
                echo form_hidden('varImageHidden', $Row_blogs['varImage']);
                echo form_hidden('varImageHidden1', $Row_blogs['varImage1']);
                if (!empty($eid)) {
                    echo form_hidden('ehintglcode', $eid);
                    echo form_hidden('Alias_Id', $Row_blogs['Alias_Id']);
                    echo form_hidden('eid', $Row_blogs['int_id']);
                    echo form_hidden('Hid_varAlias', $Row_blogs['varAlias']);
                    echo form_hidden('Old_DisplayOrder', $Row_blogs['intDisplayOrder'], '', 'id="Old_DisplayOrder"');
                }
                echo form_hidden('hidd_VarImage', $Row_blogs['varImage']);
                echo form_hidden('hidd_ImageFlag', $flag);

                echo form_hidden('hidd_VarImage1', $Row_blogs['varImage1']);
                echo form_hidden('hidd_ImageFlag1', $flag);
                if (ADMIN_ID != 1) {
                    $style = 'style="display: none"';
                }
                ?>            
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label> Title</label>
                            <?php
                            if (!empty($eid)) {
                                $EditAlias = "Y";
                                $titleBoxdata = array(
                                    'name' => 'varTitle',
                                    'id' => 'varTitle',
                                    'value' => $Row_blogs['varTitle'],
                                    'onblur' => ($alias_validation) ? "Auto_Alias('" . $EditAlias . "',this.id,'" . base64_encode($eid) . "','" . base64_encode(MODULE_ID) . "','N');" : "",
                                    'class' => 'md-input'
                                );
                            } else {
                                $EditAlias = "N";
                                $titleBoxdata = array(
                                    'name' => 'varTitle',
                                    'id' => 'varTitle',
                                    'value' => $Row_blogs['varTitle'],
                                    'onblur' => ($alias_validation) ? "Auto_Alias('" . $EditAlias . "',this.id,'" . base64_encode($eid) . "','" . base64_encode(MODULE_ID) . "','N');" : "",
                                    'onkeyup' => 'getchanged()',
                                    'class' => 'md-input'
                                );
                            }

                            echo form_input($titleBoxdata);
                            ?>
                            <label class="error" for="varTitle"></label>
                        </div>
                    </div>
                </div>

                <?php if ($alias_validation) { ?>
                    <div class="uk-form-row">
                        <?php
                        $param = array(
                            "name" => "varAlias",
                            'value' => set_value('varAlias', $Row_blogs['varAlias']),
                            "linkServices" => 'onclick="CheckingAlias(\'varAlias\',\'' . base64_encode($Row_blogs['varAlias']) . '\',\'' . base64_encode(MODULE_ID) . '\',\'' . MODULE . '\')"',
                            "eid" => $eid,
                            'class' => 'md-input',
                            "edit_record" => $edit_record
                        );
                        echo $aliaText = $this->mylibrary->Alias_Textbox($param);
                        ?>
                    </div>
                <?php } ?>

                <div class="clear"></div> 
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label> Type</label>
                            <?php
                            $tagBoxdata = array(
                                'name' => 'varType',
                                'id' => 'varType',
                                'value' => $Row_blogs['varType'],
                                'class' => 'md-input'
                            );

                            echo form_input($tagBoxdata);
                            ?>
                            <label class="error" for="varType"></label>
                        </div>

                        <!--                    </div>
                                        </div>
                                        <div class="uk-form-row">
                                            <div class="uk-grid" data-uk-grid-margin>-->
                        <div class="uk-width-medium-1-2">
                            <label> Author</label>
                            <?php
                            $tagBoxdata = array(
                                'name' => 'varAuthor',
                                'id' => 'varAuthor',
                                'value' => $Row_blogs['varAuthor'],
                                'class' => 'md-input'
                            );

                            echo form_input($tagBoxdata);
                            ?>
                            <label class="error" for="varAuthor"></label>
                        </div>

                    </div>
                </div>

                <div class="clear"></div> 
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label for="dtBlogDate">Blog Date</label>
                            <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: This is blog date for blog display."; ?>">help</i>
                            <div class="clear"></div>
                            <input type="hidden" name="dtBlogDate1" value="<?php echo $Row_blogs['dtBlogDate']; ?>">
                            <?php
                            if (!empty($eid))
                                $startDate = date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($Row_blogs['dtBlogDate']));
                            else
                                $startDate = date(str_replace('%', '', DEFAULT_DATEFORMAT));
                            $SdateBoxdata = array(
                                'name' => 'dtBlogDate',
                                'id' => 'dtBlogDate',
                                'class' => 'md-input',
                                'value' => set_value('dtBlogDate', $startDate),
                                'readonly' => 'readonly',
                                'data-uk-datepicker' => '{format:"DD.MM.YYYY"}'
                            );
                            echo form_input($SdateBoxdata);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <!------------------Image code start ------------------>

                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label>&nbsp;</label>
                            <div class="clear"></div>
                            <?php
                            if (!empty($eid)) {
                                if ($Row_blogs['chrImageFlag'] == 'S') {
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
                    $ImagePath = 'upimages/blogs/images/' . $Row_blogs['varImage'];
                    if (file_exists($ImagePath) && $Row_blogs['varImage'] != '') {
                        $image_thumb = image_thumb($ImagePath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                        $image_detail_thumb = image_thumb($ImagePath, BLOGS_WIDTH, BLOGS_HEIGHT);
                    }
                    if (!empty($eid)) {
                        if (file_exists($ImagePath)) {
                            ?>
                            <?php
                            $ImageName = $Row_blogs['varImage'];
                            if ($ImageName != "") {
                                ?>                               
                                <?php
                                $disp_div .= "<a href=\"" . $image_detail_thumb . "\" data-uk-lightbox=\"{group:'gallery'}\">
                                                            <img src=\"" . $image_thumb . "\" />
                                                      </a>&nbsp;&nbsp;
                                                        <a href=\"javascript:;\" onclick=\"delete_image('" . $Row_blogs['int_id'] . "','" . $Row_blogs['varImage'] . "',1);\"><div class=\"md-btn md-btn-wave\">Delete</div></a>
                                            ";
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
                        (Recommended Image Dimension <?php echo BLOGS_WIDTH; ?>px Width X <?php echo BLOGS_HEIGHT; ?>px Height, Maximum Image Dimension 4000px Width X 4000px Height)</span> 
                </div>   
                <!---------------------------End Image Code--------------------------->    

                <!------------------Image code start ------------------>

                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label>&nbsp;</label>

                            <div class="clear"></div>  
                            <?php
                            if (!empty($eid)) {
                                if ($Row_blogs['chrImageFlag1'] == 'S') {
                                    $SystemCheck = TRUE;
                                    $SystemImagesDisplay1 = "style=''";
                                }
                            } else {
                                $SystemCheck = TRUE;
                                $SystemImagesDisplay1 = "style=''";
                            }
                            $AllChkBox = "";
                            ?> 
                        </div>
                    </div>

                    <div class="clear"></div>
                    <div id="SystemImagesDisplayDiv1" <?php echo $SystemImagesDisplay1; ?>> 
                        <div class="uk-form-file md-btn md-btn-primary">
                            Upload Detail Image
                            <input id="varImage1" name="varImage1" type="file">
                        </div>
                        <div class="clear"></div>
                        <label class="error" for="varImage1"></label>
                    </div>
                    <?php
                    $ImagePath1 = 'upimages/blogs/images/' . $Row_blogs['varImage1'];
                    if (file_exists($ImagePath1) && $Row_blogs['varImage1'] != '') {
                        $image_thumb1 = image_thumb($ImagePath1, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                        $image_detail_thumb1 = image_thumb($ImagePath1, BLOGS_DETAIL_WIDTH, BLOGS_DETAIL_HEIGHT);
                    }
                    if (!empty($eid)) {
                        if (file_exists($ImagePath1)) {
                            ?>
                            <div id="hide_div"> 
                                <?php
                                $ImageName1 = $Row_blogs['varImage'];
                                if ($ImageName1 != "") {
                                    ?>                               
                                    <?php
                                    $disp_div1 .= "<a href=\"" . $image_detail_thumb1 . "\" data-uk-lightbox=\"{group:'gallery'}\">
                                                            <img src=\"" . $image_thumb1 . "\" />
                                                      </a>&nbsp;&nbsp;
                                                        <a href=\"javascript:;\" onclick=\"delete_image('" . $Row_blogs['int_id'] . "','" . $Row_blogs['varImage1'] . "',1);\"><div class=\"md-btn md-btn-wave\" >Delete</div></a>
                                                    ";
                                    echo $disp_div1;
                                }
                                ?> 
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>   
                <div class="clear"></div>
                <div class="uk-form-help-block" id="upload_note" <?php echo $NoneNoteeDisplay; ?>>
                    <span class="spannote">Upload Image file of format only *.jpg, *.jpeg, *.png or *.gif. Having maximum size of 5MB.<br>
                        (Recommended Image Dimension <?php echo BLOGS_DETAIL_WIDTH; ?>px Width X <?php echo BLOGS_DETAIL_HEIGHT; ?>px Height, Maximum Image Dimension 4000px Width X 4000px Height)</span> 
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
//                            'style' => 'float: left; height: 100px; overflow: auto; max-width: 453px;',
                            'onKeyDown' => 'CountLeft(this.form.varShortDesc,this.form.Desccountleft,200);',
                            'class' => 'md-input',
                            'onKeyUp' => 'CountLeft(this.form.varShortDesc,this.form.Desccountleft,200);',
                            'value' => set_value('varShortDesc', htmlspecialchars($Row_blogs['varShortDesc'])),
                            'extraDataInTD' => form_input_ready($Desccounter)
                        );
                        echo form_input_ready($short_descBoxdata, 'textarea');
                        ?>
                        <!--<div class="clear"></div>-->
                        <label class="error" for="varShortDesc"></label>
                    </div>
                    <!--</div>-->
                </div>
                <div class="uk-form-row">
                    <label>Description</label>
                    <?php
                    $value = (!empty($eid) ? $Row_blogs['txtDescription'] : '');
                    echo $this->mylibrary->load_ckeditor('txtDescription', $this->mylibrary->Replace_Varible_with_Sitepath($value), '100%', '200px', 'Basic');
                    ?>
                </div>

            </div>
        </div>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                $val_metatitle = (!empty($eid) ? ($Row_blogs['varMetaTitle']) : '');
                $val_metakeyword = (!empty($eid) ? ($Row_blogs['varMetaKeyword']) : '');
                $val_metadescription = (!empty($eid) ? ($Row_blogs['varMetaDescription']) : '');
                $param = array("varMetaTitle" => $val_metatitle, "varMetaKeyword" => $val_metakeyword, "varMetaDescription" => $val_metadescription);
                echo $this->mylibrary->seo_textdetails($param, '', $this->module_url, 'Frmblogs');
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
                <div class="uk-form-row">
                    <div class="uk-width-medium-1-2">
                        <label>Display Order<span class="req">*</span></label>
                        <?php
                        $DOBoxdata1 = array(
                            'name' => 'intDisplayOrder',
                            'id' => 'intDisplayOrder',
                            'value' => (!empty($eid) ? $Row_blogs['intDisplayOrder'] : '1'),
                            'maxlength' => '3',
                            'class' => 'md-input',
                            'onkeypress' => 'return KeycheckOnlyNumeric(clubs);',
                        );
                        echo form_input_ready($DOBoxdata1);
                        ?>
                    </div>
                </div>

                <div class="fl title-w"> 
                    <label>Display</label> 
                    <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: Please select 'Yes' if you want to display / activate this record. Otherwise please select 'NO'"; ?>">help</i></div>

                <?php
                if (!empty($eid)) {
                    $publishYRadio = array(
                        'name' => 'chrPublish',
                        'id' => 'chrPublishY',
                        'value' => 'Y',
                        'class' => 'form-rediobutton',
                        'checked' => ($Row_blogs['chrPublish'] == 'Y') ? TRUE : FALSE
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
                           'checked' => ($Row_blogs['chrPublish'] == 'N') ? TRUE : FALSE
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