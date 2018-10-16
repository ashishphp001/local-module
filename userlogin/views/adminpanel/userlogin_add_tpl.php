<script type="text/javascript">
    function check_datediv()

    {

        if (document.getElementById('dt_enddate_expiry').checked == true)

        {

            document.getElementById('dtEndDate').style.display = 'none';

        } else

        {

            document.getElementById('dtEndDate').style.display = '';

        }

    }
</script>
<script type="text/javascript">



    $(function () {

        $('#dtStartDate').datepicker({

            changeMonth: true,

            changeYear: true,

            maxDate: 0,

            dateFormat: '<?php echo str_replace('Y', 'yy', str_replace('%', '', DEFAULT_DATEFORMAT)) ?>',

            onSelect: function (selectedDate) {

                var option = "minDate";

                var instance = $('#dtEndDate').data("datepicker");

                var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);

                date.setDate(date.getDate() + 1);

                $('#dtEndDate').datepicker("option", option, date);

            }

        });





        var fdate2 = $("#dtStartDate").datepicker("getDate");

        fdate2.setDate(fdate2.getDate() + 1);

        $('#dtEndDate').datepicker({

            changeMonth: true,

            changeYear: true,

            minDate: fdate2,

            dateFormat: '<?php echo str_replace('Y', 'yy', str_replace('%', '', DEFAULT_DATEFORMAT)) ?>',

            onSelect: function (selectedDate) {

                $("#dtEndDate").next('label').hide();

                $("#dtEndDate").removeClass('error');

            }

        });

    });

</script>

<script>
    function getchanged()
    {
        var Title = document.getElementById("varTitle").value;
        var Title1 = Title;
        var Meta_keyword = Title;
        document.getElementById("varMetaTitle").value = Title1;
        document.getElementById("varMetaKeyword").value = Meta_keyword;

        CountLeft(document.Frmblog.varMetaTitle, document.Frmblog.metatitle_left, 200);
//        CountLeft(document.Frmblog.varMetaDescription,document.Frmblog.metadescription_left,400);
        CountLeft(document.Frmblog.varMetaKeyword, document.Frmblog.metakeyword_left, 200);
    }

    function generate_seocontent(flag) {
        var title = trim(document.getElementById('varTitle').value);
        var abcd1 = CKEDITOR.instances.txtDescription.getData();
        if (abcd1 == '')
        {
            var abcd = document.getElementById('varShortDesc').value;
        } else {
            var abcd = CKEDITOR.instances.txtDescription.getData();
        }
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
        CountLeft(document.Frmblog.varMetaTitle, document.Frmblog.metatitle_left, 200);
        CountLeft(document.Frmblog.varMetaDescription, document.Frmblog.metadescription_left, 400);
        CountLeft(document.Frmblog.varMetaKeyword, document.Frmblog.metakeyword_left, 400);
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
            CountLeft(document.Frmblog.varMetaTitle, document.Frmblog.metatitle_left, 200);
            CountLeft(document.Frmblog.varMetaDescription, document.Frmblog.metadescription_left, 400);
            CountLeft(document.Frmblog.varMetaKeyword, document.Frmblog.metakeyword_left, 400);
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
        } else if (sel == 'E')
        {
            $("#SystemImagesDisplayDiv").hide();

            $("#ExternalLinkImagesDisplayDiv").show();
            $("#selectdiv").hide();
            $("#selectdiv1").hide();
            $("#selectdiv2").show();
        }
    }
    $("#intDisplayOrder").removeClass("ignore");
    $(document).ready(function ()
    {
        $('#varAlias').bind("cut copy paste", function (e)
        {
            e.preventDefault();
        });
        $('#varTitle').keypress(function (event)
        {
            var keycode = (event.keyCode ? event.keyCode : event.which);
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
        $("#varExternalUrl").keydown(function () {
            $("#Var_Url_Image_notexisterr").remove();
        });
        $.validator.addMethod("Chk_Image_Size", function (event, value) {
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

        $.validator.addMethod("UrlValidate_Logo", function (value, element) {

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

        $("#intDisplayOrder").removeClass("ignore");
        $("#Frmblog").validate({
            ignore: [],
            rules: {
                varTitle: {
                    required: true,
                    alphanumeric: true
                },

                varShortDesc: {
                    required: true
                },
                varEmailId: {
                    required: false,
                    email: true
                },
                dtStartDate: {
                    required: true
                },
                dtEndDate: {

                    required: {

                        depends: function () {

                            if ($("#dt_enddate_expiry").is(':checked') == false)
                                return true;

                            else
                                return false;

                        }

                    }

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
<?php if ($eid != '' && $Row_blog['chrImageFlag'] == 'B') { ?>
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
<?php } else if ($eid != '' && $Row_blog['chrImageFlag'] == 'E') { ?>
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

                    system_image_validation:
                            {
                                depends: function ()
                                {
                                    if ($("#chrImageFlagS").is(':checked'))
                                    {
                                        return true;
                                    } else
                                    {
                                        return false;
                                    }
                                }
                            },
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
                varExternalUrl:
                        {
                            required:
                                    {
                                        depends: function ()
                                        {
                                            var Eid = '<?php echo $Row_blog['int_id'] ?>';
                                            var PrevSelected = '<?php echo $Row_blog['chrImageFlag'] ?>';
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
                    displayorder: ['intDisplayOrder'],
                    maxlength: 3
                }
            },
            messages: {
                varTitle: {
                    required: NEWS_TITLE
                },
                varShortDesc: {
                    required: NEWS_SHORTDESC
                },
                dtStartDate: {
                    required: NEWS_REPORT_DATE
                },
                dtEndDate: {

                    required: COMMON_EXPIRYDATE_MSG

                },
                varImage: {
                    required: NEWS_SYSTEM_IMAGE,
                    accept: IMAGE_VALID
                },
                varExternalUrl: {
                    required: NEWS_EXTERNAL_IMAGE
                },
                intDisplayOrder: {
                    required: GLOBAL_PROPER_DISPLAY_ORDER,
                    maxlength: GLOBAL_DISPLAYORDER_LIMIT
                }
            },
            errorPlacement: function (error, element)
            {
                if ($(element).attr('id') == 'varImage')
                {
                    error.appendTo('#varimageerror');
                } else if ($(element).attr('id') == 'varExternalUrl')
                {
                    error.appendTo('#varExternalerror');
                } else
                {
                    error.insertAfter(element);
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
                    if ($("#chrImageFlagE").is(":checked") == true && $("#varExternalUrl").val() != '') {
                        if (!check_remote_file_exist()) {

                            $('<label id="Var_Url_Image_notexisterr" class="error">Please note that file is not available for the above link.</label>').insertAfter('#varExternalUrl');
                            $("#varExternalUrl").focus();

                            return false;
                        }
                    }
                    if (CheckingAlias('varAlias', '<?php echo $Row_blog['Alias_Id']; ?>', '<?php echo base64_encode(MODULE_ID) ?>', '<?php echo MODULE ?>') == '0')
                    {
                        return false;
                    } else
                    {
                        generate_seocontent
                        form.submit();
                    }
                }
            }
        });
    });

    function check_remote_file_exist() {

        var RemoteUri = $("#varExternalUrl").val();
        var resp = false;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>adminpanel/blog/CheckRemoteFile",
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

    function checkurl(url)
    {
        var RegExp = /^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/;

        if (RegExp.test(url)) {
            return true;
        } else {
            return false;
        }
    }

    function check_datediv()

    {

        if (document.getElementById('dt_enddate_expiry').checked == true)

        {

            document.getElementById('dtEndDate').style.display = 'none';

        } else

        {

            document.getElementById('dtEndDate').style.display = '';

        }

    }
</script>

<div class="content">
    <section class="MiddleSection"> 
        <div class="spacer10"></div>
        <div class="fl"> 
            <h1>
                <b class="icon-list-ul"></b>
                <?php
                $title1 = $Row_blog['varTitle'];
                if (strlen($title1) > 80) {
                    $title = substr($Row_blog['varTitle'], 0, 80) . "...";
                } else {
                    $title = $Row_blog['varTitle'];
                }
                if (!empty($eid)) {
                    echo 'Edit Blog - ' . $title;
                } else {
                    echo 'Add New Blog';
                }
                ?>
            </h1>
        </div>
        <div class="fr"> 
            <a class="fr Editable-btn" href="<?php echo MODULE_PAGE_NAME; ?>">
                <span><b class="icon-caret-left"></b> Back To Manage <?php echo MODULE_TITLE; ?></span>
            </a>
        </div>
        <div class="spacer10"></div>
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

        <div class="main-form-box">
            <div class="require-lbl">* Required Field</div>
            <div class="spacer5"></div>
            <div class="contact-title" style="cursor:pointer;" onclick="javascript:expandcollapsepanel('DIV_gen_info', 'Gen_Plus_Minus');">
                General Details
                <span id="Gen_Plus_Minus" class="minus-icn"></span> 
            </div>
            <div class="spacer10"></div>
            <?php
            $attributes = array('name' => 'Frmblog', 'id' => 'Frmblog', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
            if ($edit_record) {
                echo form_open($action, $attributes);
            }
            echo form_hidden('btnsaveandc_x', '');
            echo form_hidden('varImageHidden', $Row_blog['varImage']);
            if (!empty($eid)) {

                echo form_hidden('ehintglcode', $eid);
                echo form_hidden('Alias_Id', $Row_blog['Alias_Id']);
                echo form_hidden('eid', $Row_blog['int_id']);
                echo form_hidden('Hid_varAlias', $Row_blog['varAlias']);

                echo form_hidden('Old_DisplayOrder', $Row_blog['intDisplayOrder'], '', 'id="Old_DisplayOrder"');
            }
            $flag = ($Row_blog['chrImageFlag'] != '') ? $Row_blog['chrImageFlag'] : 'S';
            echo form_hidden('chrImageFlag', $flag);
            echo form_hidden('hidd_VarImage', $Row_blog['varImage']);
            if (ADMIN_ID != 1) {
                $style = 'style="display: none"';
            }
            ?>            
            <div class="fix_width" id="DIV_gen_info">
                <div class="inquiry-form">
                    <div class="fl title-w"> 
                        <div class="title-form fl">Title</div> <span class="required"></span>
                        <div class="clear"></div>  
                        <?php
                        if (!empty($eid)) {
                            $EditAlias = "Y";
                        } else {
                            $EditAlias = "N";
                        }
                        $titleBoxdata = array(
                            'name' => 'varTitle',
                            'id' => 'varTitle',
                            'value' => $Row_blog['varTitle'],
                            'onblur' => ($alias_validation) ? "Auto_Alias('" . $EditAlias . "',this.id,'" . base64_encode($eid) . "','" . base64_encode(MODULE_ID) . "','N');" : "",
                            'onkeyup' => 'getchanged()',
                            'class' => 'frist-name input input-bg01'
                        );
                        echo form_input($titleBoxdata);
                        ?>
                    </div>
                </div>
                <div class="spacer"></div>
                <?php if ($alias_validation) { ?>
                    <div class="inquiry-form"> 
                        <?php
                        $param = array(
                            "name" => "varAlias",
                            'value' => set_value('varAlias', $Row_blog['varAlias']),
                            "linkEvent" => 'onclick="CheckingAlias(\'varAlias\',\'' . base64_encode($Row_blog['varAlias']) . '\',\'' . base64_encode(MODULE_ID) . '\',\'' . MODULE . '\')"',
                            "eid" => $eid,
                            "edit_record" => $edit_record
                        );
                        echo $aliaText = $this->mylibrary->Alias_Textbox($param);
                        ?>
                    </div>
                    <div class="spacer10"></div>
                <?php } ?>

                <div class="clear"></div>
                <div class="inquiry-form">
                    <div class="fl" style="margin:0 10px 8px 0"> 
                        <div class="fl"> 
                            <div class="title-form fl">Upload Image</div><span class="required"></span>
                            <div class="clear"></div>  
                            <?php
                            if (!empty($eid)) {
                                if ($Row_blog['chrImageFlag'] == 'S') {
                                    $SystemCheck = TRUE;

                                    $ExternalLinkCheck = FALSE;
                                    $SystemImagesDisplay = "style=''";

                                    $ExternalLinkImagesDisplay = "style='display:none;'";
                                } else if ($Row_blog['chrImageFlag'] == 'B') {
                                    $SystemCheck = FALSE;
                                    $ExternalLinkCheck = FALSE;
                                    $SystemImagesDisplay = "style='display:none;'";
                                    $ExternalLinkImagesDisplay = "style='display:none;'";
                                } else if ($Row_blog['chrImageFlag'] == 'E') {
                                    $SystemCheck = FALSE;
                                    $ExternalLinkCheck = TRUE;
                                    $SystemImagesDisplay = "style='display:none;'";
                                    $ExternalLinkImagesDisplay = "style=''";
                                }
                            } else {
                                $SystemCheck = TRUE;
                                $ExternalLinkCheck = FALSE;
                                $SystemImagesDisplay = "style=''";
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
                        </div>
                        <div class="spacer10"></div>
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
                                'accept' => '.png,.jpg,.jpeg,.gif',
                                'class' => 'fl brd-brows',
                                'style' => 'width:354px;',
                            );
                            echo form_input_ready($CFBoxdata, 'upload');
                            ?><div class="clear"></div>
                            <div id="varimageerror"></div>
                        </div>
                        <div class="fl" id="ExternalLinkImagesDisplayDiv" <?php echo $ExternalLinkImagesDisplay; ?>> 
                            <?php
                            $UGCLabelData = array(
                                'label' => '',
                                'required' => ''
                            );
                            echo form_input_label($UGCLabelData);
                            $LogoLink = ($Row_blog['varExternalUrl'] != '') ? $Row_blog['varExternalUrl'] : 'http://www';
                            $URLBoxdata = array(
                                'name' => 'varExternalUrl',
                                'id' => 'varExternalUrl',
                                'class' => 'brd-brows',
                                'style' => 'width:345px',
                                'class' => 'frist-name input input-bg01',
                                'value' => set_value('varExternalUrl', $LogoLink),
                                'placeholder' => 'http://www.mywebsite.com'
                                    //'value' => (!empty($Row_blog['varExternalUrl']) ? $Row_blog['varExternalUrl'] : '')
                            );
                            echo form_input_ready($URLBoxdata);
                            ?>
                            <div class="clear"></div>
                            <div id="varExternalerror"></div>
                        </div>

                        <div class="fl mgtm15">
                            <?php
                            $ImagePath = 'upimages/blog/' . $Row_blog['varImage'];
                            if (file_exists($ImagePath) && $Row_blog['varImage'] != '') {
                                $image_thumb = image_thumb($ImagePath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                                $image_detail_thumb = image_thumb($ImagePath, BLOGALBUM_WIDTH, BLOGALBUM_HEIGHT);
                            }
                            if (!empty($eid)) {
                                if (file_exists($ImagePath)) {
                                    ?>
                                    <div class="fl"> 
                                        <div class="fl mgt10">
                                            <?php
                                            $ImageName = $Row_blog['varImage'];
                                            if ($ImageName != "") {
                                                ?>

                                                <?php
                                                if ($Row_blog['chrImageFlag'] == 'S') {
                                                    $disp_div .= "<div class=\"title-form fl\" id='selectdiv'>&nbsp;&nbsp;";
                                                } else {
                                                    $disp_div .= "<div class=\"title-form fl\" id='selectdiv2'>&nbsp;&nbsp;";
                                                }

                                                $disp_div .= "<span id=\"divdelbro\" class=\"title-form fl\" >&nbsp;&nbsp;
                                          <a href=\"#varMenuIconImage\" class=\"fancybox-buttons\" data-fancybox-group=\"button\">
                                                <img title=\"" . htmlentities($this->common_model->GetImageNameOnly($Row_blog['varImage'])) . "\" style=\"margin-top:10px\" class=\"mgr15\" src=\"" . $image_thumb . "\" alt=\"View\"  border=\"0\" align=\"absmiddle\" id=\"myimage\" />
                                                    <span id=\"varMenuIconImage\" style=\"display:none\">
                                                        <img title=\"" . htmlentities($this->common_model->GetImageNameOnly($Row_blog['varImage'])) . "\" src=\"" . $image_detail_thumb . "\" alt=\"View\"  border=\"0\" align=\"absmiddle\" id=\"myimage\" Width=\"" . BLOGALBUM_WIDTH . "\"  Heitht=\"" . BLOGALBUM_HEIGHT . "\" />
                                                    </span>
                                            </a>


                                        </span>";
                                                echo $disp_div;
                                                ?> 
                                            </div> 
                                        </div>
                                        <?php
                                    } elseif ($Row_blog['chrImageFlag'] == 'E') {
                                        echo '<span style="color:red"><strong>Sorry! The provided path of an external link is not found please try again.</strong></span>';
                                    }
                                    ?>                    
                                </div> 

                                <?php
                            }
                        }
                        ?>                    
                    </div>
                </div> 
            </div> 
            <div class="clear"></div>
            <div class="fl">
                <span class="spannote">Upload Image file of format only *.jpg, *.jpeg, *.png or *.gif. Having maximum size of 5MB.
                    (Recommended Image Dimension <?php echo BLOGALBUM_WIDTH; ?>px X <?php echo BLOGALBUM_HEIGHT; ?>px, Maximum Image Dimension 4000px X 4000px).
                </span> 
            </div>
            <div class="clear"></div> 
            <!---------------Short Description ---------------------->
            <div class="inquiry-form"> 
                <div class="title-form fl">Short Description</div><span class="required"></span>
                <div class="clear"></div> 
                <?php
                $titleLabelData = array(
                );
                echo form_input_label($titleLabelData);
                $Desccounter = array('id' => 'Desccountleft',
                    'name' => 'Desccountleft',
                    'value' => 500 - strlen($Row_blog['varShortDesc']),
                    'class' => 'frist-name input input-bg01 fl ignore mgl10',
                    'style' => 'width:35px !important; text-align: center; display:inline !important;',
                    'readonly' => 'readonly'
                );
                $short_descBoxdata = array(
                    'name' => 'varShortDesc',
                    'id' => 'varShortDesc',
                    'maxlength' => '500',
                    'style' => 'width:400px;height:80px;float:left;margin-right:5px;',
                    'onKeyDown' => 'CountLeft(this.form.varShortDesc,this.form.Desccountleft,500);',
                    'onKeyUp' => 'CountLeft(this.form.varShortDesc,this.form.Desccountleft,500);',
                    'value' => htmlspecialchars($Row_blog['varShortDesc']),
                    'extraDataInTD' => form_input_ready($Desccounter)
                );
                echo form_input_ready($short_descBoxdata, 'textarea');
                ?>
                <div class="clear"></div>
                <label class="fr error" for="varShortDesc"></label>
            </div>  
            <div class="spacer10"></div>                
            <div class="clear"></div>
            <div class="inquiry-form"> 
                <div class="fl title-w"> 
                    <div class="title-form fl">Start Date</div><span class="required"></span>
                    <div class="fl mgl5 tooltip" title="<strong><?php echo "Note: This is start date for blog display." ?></strong>" >
                        <img style="vertical-align:middle;margin-left:5px" width="16" height="16" alt="" onmouseout="hidediv('dvhlpvarwebsite');" onmouseover="showDiv(rate, 'dvhlpvarwebsite')" src="<?php echo GLOBAL_ADMIN_IMAGES_PATH; ?>/help.png">
                    </div> 
                    <div class="clear"></div>
                    <?php
                    if (!empty($eid))
                        $startDate = date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($Row_blog['dtStartDate']));
                    else
                        $startDate = date(str_replace('%', '', DEFAULT_DATEFORMAT));

                    $SdateBoxdata = array(
                        'name' => 'dtStartDate',
                        'id' => 'dtStartDate',
                        'class' => 'frist-name input input-bg01',
                        'style' => 'width:412px;float:left;margin-right:5px;',
                        'value' => set_value('dtStartDate', $startDate),
                        'readonly' => 'readonly',
                    );
                    echo form_input($SdateBoxdata);
                    ?>
                </div>
            </div>

            <div class="spacer10"></div>
            <div class="inquiry-form"> 
                <div class="fl title-w"> 
                    <div class="title-form fl">End Date</div><span class="required fl"></span>
                    <?php
                    $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
                    if (!empty($eid)) {
                        if ($Row_blog['dtEndDate'] == '0000-00-00') {
                            $EndDate = date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($Row_blog['dtStartDate'] . ' +1 day'));
                        } else {
                            $EndDate = $Row_blog['dtEndDate'] == '0000-00-00' ? date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($startDate . ' +1 day')) : date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($Row_blog['dtEndDate']));
                        }
                    }
                    if (!empty($eid)) {
                        $CheckedNoExpiry = $Row_blog['chrExpiryDate'] == 'N' ? TRUE : FALSE;
                    } else {
                        $CheckedNoExpiry = TRUE;
                    }
                    $data = array(
                        'name' => 'dt_enddate_expiry',
                        'id' => 'dt_enddate_expiry',
                        'value' => 'Y',
                        'checked' => $CheckedNoExpiry,
                        'onclick' => 'javascript : check_datediv()',
                    );
                    echo form_checkbox($data) . '<label for="dt_enddate_expiry">No Expiry</label>';
                    if ($Row_blog['chrExpiryDate'] == 'Y') {
                        $a = '';
                    } else {
                        $a = 'display:none';
                    }
                    ?>
                    <?php
                    $SdateBoxdata = array(
                        'name' => 'dtEndDate',
                        'id' => 'dtEndDate',
                        'style' => $a,
                        'class' => 'frist-name input input-bg01',
                        'value' => set_value('dtEndDate', (!empty($eid) ? $EndDate : date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($date . ' +1 day')))),
                        'readonly' => 'readonly',
                    );
                    echo form_input($SdateBoxdata);
                    ?>
                    <label class="fl error" for="dtEndDate" style="margin-left: 5px;"></label>
                </div>
                <div class="clear"></div>  
            </div>
            <div class="spacer10"></div>
            <div class="inquiry-form">
                <div> 
                    <div class="title-form fl">Description</div>
                    <div class="clear"></div> 
                    <?php
                    $value = (!empty($eid) ? $Row_blog['txtDescription'] : '');
                    echo $this->mylibrary->load_ckeditor('txtDescription', stripcslashes(htmlspecialchars_decode($this->mylibrary->Replace_Varible_with_Sitepath($value))), '98%');
                    ?>
                </div>
            </div>
            <div class="clear"></div> 
        </div>
        <div class="clear"></div>
        <div class="spacer10"></div>

        <?php
        $val_metatitle = (!empty($eid) ? ($Row_blog['varMetaTitle']) : '');
        $val_metakeyword = (!empty($eid) ? ($Row_blog['varMetaKeyword']) : '');
        $val_metadescription = (!empty($eid) ? ($Row_blog['varMetaDescription']) : '');
        $param = array("varMetaTitle" => $val_metatitle, "varMetaKeyword" => $val_metakeyword, "varMetaDescription" => $val_metadescription);
        echo $this->mylibrary->seo_textdetails($param, '', $this->module_url, 'Frmblog');

        $DisplayInfoDivDisplay = 'style="display:none;"';
        $Displayinfo_Plus_Minus = 'plus-icn';
        if (!empty($eid)) {
            $DisplayInfoDivDisplay = '';
            $Displayinfo_Plus_Minus = 'minus-icn';
        }
        ?>  
        <div class="spacer10"></div>
        <div class="contact-title" style="cursor:pointer;" onclick="javascript:expandcollapsepanel('DIV_displayinfo', 'Displayinfo_Plus_Minus');">
            Display Information
            <span id="Displayinfo_Plus_Minus" class="<?php echo $Displayinfo_Plus_Minus; ?>"></span> 
        </div>

        <div class="spacer10"></div>
        <div class="fix_width" id="DIV_displayinfo" <?php echo $DisplayInfoDivDisplay; ?>>
            <div class="inquiry-form">

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
                                'checked' => ($Row_blog['chrPublish'] == 'Y') ? TRUE : FALSE
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
                                'checked' => ($Row_blog['chrPublish'] == 'N') ? TRUE : FALSE
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
                    <div class="fl mgl5 tooltip" title="<strong><?php echo "Note: Please select 'Yes' if you want to display / activate this record. Otherwise please select 'NO'" ?></strong>" >
                        <img style="vertical-align:middle;margin-left:5px" width="16" height="16" alt="" onmouseout="hidediv('dvhlpvarwebsite');" onmouseover="showDiv(event, 'dvhlpvarwebsite')" src="<?php echo GLOBAL_ADMIN_IMAGES_PATH; ?>/help.png">
                    </div>
                </div>
            </div>
            <div class="spacer10"></div>
        </div>
        <div class="spacer10"></div>
        <?php
        if ($edit_record) {
            ?>
            <div class="pos-rel">
                <?php
                $Form_Submit = array('name' => 'btnsaveandc', 'id' => 'btnsaveandc', 'value' => 'Save &amp; Keep Editing', 'class' => 'submit');
                echo form_submit($Form_Submit);
                ?>
            </div>
            <div class="pos-rel">
                <?php
                $Form_Submit = array('name' => 'btnsaveande', 'id' => 'btnsaveande', 'value' => 'Save &amp; Exit', 'class' => 'submit');
                echo form_submit($Form_Submit);
                ?>
            </div>
            <div class="fl">
                <a href="<?php echo MODULE_PAGE_NAME; ?>" title="Cancel">
                    <div  class="btn btn-default">
                        Cancel
                    </div>
                </a>
            </div>  
            <div class="spacer10"></div>
            <?php
            echo form_close();
        }
        ?>
</div> 
</div>
</section>
</div>      