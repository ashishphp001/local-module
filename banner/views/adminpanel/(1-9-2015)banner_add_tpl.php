<script type="text/javascript">
    $(document).ready(function(){
        
        if (document.getElementById('chr_inner_banner').checked == true)   
        {
            document.getElementById('pages_inner_home_banner').style.display = '';
            document.getElementById('varShortDesc_Hide').style.display = 'none';
        }
        
        $('#select_all').click(function() {
            $('#Fk_Pages_Inner option:enabled').prop('selected', true);
        });
        
        $("#varExternalUrl").keydown(function(){
            $("#Var_Url_Image_notexisterr").remove() ;
        });
         
        $.validator.addMethod("Chk_Image_Size", function(event, value) 
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
        
        $.validator.addMethod("UrlValidate_Logo", function(value, element)
        {
            var link_ext = value;
            var valid_extensions = /(\.jpg|\.jpeg|\.gif|\.png)$/i;
            if ($("#chrImageFlagE").is(':checked') && (valid_extensions.test(link_ext)))
            {
                var link = value;
                return checkurl(link);
            }
            else
            {
                return false;
            }

        }, GLOBAL_IMAGE_EXT_URL_MSG);
        
        $.validator.addMethod("UrlValidateForLink", function(value, element) {

            var fisrtchar = value.substr(0, 11);
            var fisrtchar1 = value.substr(0, 12);
            var fisrtchar2 = value.substr(0, 7);
            var fisrtchar3 = value.substr(0, 8);
            var valid_extensions = /(\.com|\.in|\.au|\.info\.biz|\.nz|\.org|\.net|\.int|\.edu|\.gov|\.mil)$/i;
            if ((fisrtchar == 'http://www.' || fisrtchar1 == 'https://www.' || fisrtchar2 == 'http://' || fisrtchar3 == 'https://' || fisrtchar1 == ''))
            {
                var link = document.getElementById('varExternalUrl').value;
                if (link == 'http://' || link == '' || link == 'http://www.') {
                    return true;
                }
                else {
                    return checkurl1(link);

                }
            }
            else
            {
                return false;
            }
        }, '<div class="fl mgt5"><?php echo "Please enter the link of image file like http://www.example.com/abc.jpg." ?></div>');
        
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
                varShortDesc: {
                    required: {
                        depends: function() {
                            if ($("#chr_home_banner").is(":checked")) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                varShortDesc2: {
                    required: {
                        depends: function() {
                            if ($("#chr_home_banner").is(":checked")) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                'Fk_Pages_Inner[]': {
                    required: {
                        depends: function() {
                            if ($("#chr_inner_banner").is(":checked")) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                
                varImage:{
                    required: {
                        depends:function(){                                          
                            if($("#hidd_VarImage").val() == '' && $("#varImage").val() == '')
                            {
                                if($("#chrImageFlagS").is(":checked")){  
                                    return true;
                                } else {
                                    return false;
                                }
                            }  
<?php if ($eid != '' && $Row['chrImageFlag'] == 'B') { ?>
                                if($("#hidd_VarImage").val() != '' && $("#varImage").val() == '')
                                { 
                                    if($("#chrImageFlagS").is(":checked")){
                                        return true;
                                    } else if($("#chrImageFlagB").is(":checked")){                               
                                        return false;
                                    } else if($("#chrImageFlagE").is(":checked")){                              
                                        return false;
                                    } 
                                }
<?php } else if ($eid != '' && $Row['chrImageFlag'] == 'E') { ?>
                                if($("#hidd_VarImage").val() != '' && $("#varImage").val() == '')
                                {
                                    if($("#chrImageFlagS").is(":checked")){
                                        return true;
                                    } else if($("#chrImageFlagB").is(":checked")){                               
                                        return false;
                                    } else if($("#chrImageFlagB") .is(":checked")){                               
                                        return false;
                                    } 
                                }
<?php } ?>
                        }
                    },
                    accept:"jpg,png,jpeg,gif",
                    Chk_Image_Size: {
                        depends: function() {
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
                    UrlValidateForLink: {
                        depends: function() {
                            if ($("#varExternalUrl")) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    },
                    
                    required : 
                        {
                        depends : function()
                        {
                            var Eid = '<?php echo $Row['int_id'] ?>';
                            var PrevSelected = '<?php echo $Row['chrImageFlag'] ?>';
                            if(Eid!='' && PrevSelected!='E' && $("#chrImageFlagE").is(':checked'))
                            {
                                return true;
                            }
                            else
                            {
                                if($("#chrImageFlagE").is(":checked") && $("#hidd_VarImage").val()=='')
                                {
                                    return true;
                                }
                                else
                                {
                                    return false;
                                }
                            }
                        }
                    },
                    UrlValidate_Logo:
                        {
                        depends : function()
                        {
                            if($("#chrImageFlagE").is(':checked'))
                            {
                                return true;
                            }
                            else
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
                varShortDesc: {
                    required: "Please enter short description 1."
                },
                varShortDesc2: {
                    required: "Please enter short description 2."
                },
                'Fk_Pages_Inner[]': {
                    required: "Please select inner pages."
                },
                varImage: 
                    {
                    required: BILL_ATTACH_SYSTEM_IMAGE,
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
            submitHandler: function(form)
            {
                var Check_Session = Check_Session_Expire();  
               
                if(Check_Session == 'N')
                {
                    var SessUserEmailId = '<?php echo USER_EMAILID; ?>'
                    SessionUpdatePopUp(SessUserEmailId);
                }
                else
                {
                    if($("#chrImageFlagE").is(":checked")==true && $("#varExternalUrl").val()!=''){
                        if(!check_remote_file_exist()){

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
    
    $('#varTitle').keypress(function(event)
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
            data: "Uri="+encodeURI(RemoteUri),
            async: false,
            success: function(result)
            {
                if(result == '200'){
                    resp = true;
                }else{
                    resp = false;
                }                
            }
        });        
        return resp;
    }   
</script>
<script>
    $(document).ready(function(){ 
<?php
$all_page_id = $this->Module_Model->GetAllPageIDS();
$all_innerbanner_id = $this->Module_Model->GetInnerBannerID();
$result = array_diff($all_page_id, $all_innerbanner_id);

if (count($result) == 0 && $eid != '') {
    ?>
                $('#chr_inner_banner').show();
                $('#chr_inner_banner1').show(); 
<?php } ?>
    });
</script>
<script type="text/javascript">
    //show and hide diff upload option
    function Show_BG_Box(sel)
    {
        if(sel=='S')
        {
            $("#SystemImagesDisplayDiv").show();
            $("#ExternalLinkImagesDisplayDiv").hide();
            $("#upload_note").show();
            $("#selectdiv").show();
            $("#selectdiv2").hide();
            
        }
        else if(sel=='E')
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
            document.getElementById('pages_inner_home_banner').style.display = 'none';
            document.getElementById('varShortDesc_Hide').style.display = '';
            $("#size").html('<div style="float:left;clear:both;margin-top: 5px;"><span>(Recommended Images Dimension Width <?php echo HOME_BANNER_WIDTH; ?>pxX Height <?php echo HOME_BANNER_HEIGHT ?>px , Maximum Image Dimension Width 4000px X Height 4000px)</span></div>');
        }
        else if (document.getElementById('chr_inner_banner').checked == true)   
        {
            document.getElementById('pages_inner_home_banner').style.display = '';
            document.getElementById('varShortDesc_Hide').style.display = 'none';
            $("#size").html('<div style="float:left;clear:both;margin-top: 5px;"><span>(Recommended Images Dimension Width <?php echo INNER_BANNER_WIDTH; ?>px X Height <?php echo INNER_BANNER_HEIGHT ?>px , Maximum Image Dimension Width 4000px X Height 4000px)</span></div>');
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
                if (!empty($eid)) {
                    echo 'Edit Banner - ' . $Row['varTitle'];
                } else {
                    echo 'Add New Banner';
                }
                ?>
            </h1>
        </div>
        <div class="fr"> 
            <a class="fr Editable-btn" href="<?php echo MODULE_PAGE_NAME; ?>">
                <span><b class="icon-caret-left"></b> Back To Manage Banners</span>
            </a>
        </div>
        <div class="spacer10"></div>
        <?php
        if (validation_errors() != '') {
            echo '<div class="dverrorcustom">
                <ul style="list-style-type: none;">' . validation_errors() . '<ul>
            </div><div class="spacer10"></div>';
        }
        if ($messagebox != '') {
            echo $messagebox;
            echo '<div class="spacer10"></div>';
        }
        ?>
        <div class="main-form-box">
            <div class="require-lbl">* Required Field</div>
            <div class="spacer5"></div>
            <div class="contact-title" style="cursor:pointer;" onclick="javascript:expandcollapsepanel('DIV_gen_info','Gen_Plus_Minus');">
                General Details
                <span id="Gen_Plus_Minus" class="minus-icn"></span> 
            </div>

            <div class="spacer10"></div>
            <?php
            $attributes = array('name' => 'FrmBanner', 'id' => 'FrmBanner', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');

            echo form_open($action, $attributes);
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
            <div class="fix_width" id="DIV_gen_info">
                <div class="spacer10"></div>
                <div class="clear"></div>
                <div class="inquiry-form">
                    <div class="fl title-w"> 
                        <div class="title-form fl">Title</div> <span class="required"></span>
                        <div class="clear"></div>  
                        <?php
                        $titleBoxdata = array(
                            'name' => 'varTitle',
                            'id' => 'varTitle',
                            'value' => $Row['varTitle'],
                            'maxlength' => '100',
                            'class' => 'frist-name input input-bg01',
                        );
                        echo form_input($titleBoxdata);
                        ?>
                    </div>
                </div>
                <div class="spacer10"></div>
                <div class="inquiry-form">
                    <div class="fl title-w"> 
                        <tr>
                        <div class="title-form fl">Banner Type </div>
                        <td align="left">
                            <input type="radio" name="Chr_Banner_Type"  <?php echo $checked = $Row['Chr_Banner_Type'] == 'H' ? 'checked' : 'checked'; ?> id="chr_home_banner" class="user-redio-button" value="H" onclick="showBannerType();">
                            <label for="chr_home_banner" id="chr_home_banner1">Home banner</label>
                            <input type="radio" name="Chr_Banner_Type" <?php echo $checked = $Row['Chr_Banner_Type'] == 'I' ? 'checked' : ''; ?> id="chr_inner_banner" class="user-redio-button" value="I"  onclick="showBannerType();">
                            <label for="chr_inner_banner" id="chr_inner_banner1" style="<?=$rdstyle_IB?>">Inner banner</label>
                        </td>
                        </tr>
                    </div>
                </div>
                <div class="clear"></div>
                <div id="varShortDesc_Hide">
                    <div class="inquiry-form">
                        <div class="title-form fl">Short Description 1</div><span class="required"></span>
                        <div class="clear"></div> 
                        <?php
                        $titleLabelData = array(
                        );
                        echo form_input_label($titleLabelData);
                        $Desccounter = array('id' => 'Desccountleft',
                            'name' => 'Desccountleft',
                            'value' => 55 - strlen($Row['varShortDesc']),
                            'class' => 'frist-name input input-bg01 fl ignore mgl10',
                            'style' => 'width:35px !important; text-align: center; display:inline !important;',
                            'readonly' => 'readonly'
                        );
                        $short_descBoxdata = array(
                            'name' => 'varShortDesc',
                            'id' => 'varShortDesc',
                            'maxlength' => '55',
                            'style' => 'width:462px;height:80px;float:left;margin-right:5px;overflow:auto;',
                            'onKeyDown' => 'CountLeft(this.form.varShortDesc,this.form.Desccountleft,55);',
                            'onKeyUp' => 'CountLeft(this.form.varShortDesc,this.form.Desccountleft,55);',
                            'value' => set_value('varShortDesc', htmlspecialchars($Row['varShortDesc'])),
                            'extraDataInTD' => form_input_ready($Desccounter)
                        );
                        echo form_input_ready($short_descBoxdata, 'textarea');
                        ?>
                        <div class="clear"></div>
                        <label class="fr error" for="varShortDesc"></label>
                    </div>
                    <div class="spacer10"></div>
                    <div class="inquiry-form">
                        <div class="title-form fl">Short Description 2</div><span class="required"></span>
                        <div class="clear"></div> 
                        <?php
                        $titleLabelData = array(
                        );
                        echo form_input_label($titleLabelData);
                        $Desccounter2 = array('id' => 'Desccountleft2',
                            'name' => 'Desccountleft2',
                            'value' => 77 - strlen($Row['varShortDesc2']),
                            'class' => 'frist-name input input-bg01 fl ignore mgl10',
                            'style' => 'width:35px !important; text-align: center; display:inline !important;',
                            'readonly' => 'readonly'
                        );
                        $short_descBoxdata = array(
                            'name' => 'varShortDesc2',
                            'id' => 'varShortDesc2',
                            'maxlength' => 77,
                            'style' => 'width:462px;height:80px;float:left;margin-right:5px;',
                            'onKeyDown' => 'CountLeft(this.form.varShortDesc2,this.form.Desccountleft2,77);',
                            'onKeyUp' => 'CountLeft(this.form.varShortDesc2,this.form.Desccountleft2,77);',
                            'value' => set_value('varShortDesc2', htmlspecialchars($Row['varShortDesc2'])),
                            'extraDataInTD' => form_input_ready($Desccounter2)
                        );
                        echo form_input_ready($short_descBoxdata, 'textarea');
                        ?>
                        <div class="clear"></div>
                        <label class="fr error" for="varShortDesc2"></label>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="inquiry-form">
                    <div id="pages_inner_home_banner" style="<?php echo $style = $Row['Chr_Banner_Type'] == 'I' ? '' : 'display:none'; ?>">
                        <tr>
                        <div class="title-form fl">Pages:<span class="required"></span></div> 
                        <div class="clear"></div>
                        <td valign="top" align="left">
                            <?php echo $Pages_Combo; ?>
                            <label for="Fk_Pages_Inner" generated="true" class="error" style="margin-left:16px"></label>
                        </td>
                        <?php
                        if (empty($eid)) {
                            ?>
                            <div>
                                <input type="button" id="select_all" class="btn-green" name="select_all" value="Select All" style="margin-left:14px;">
                                <br><br><span class="spannote" style="margin-left:13px;">Use Ctrl+Click for multiple selction </span>
                            </div>
                            <?php
                        }
                        ?>
                        </tr>
                    </div>
                </div>

                <div class="spacer10"></div> 

                <!------------------Image code start ------------------>

                <div class="fl title-w"> 
                    <div class="fl"> 
                        <div class="title-form fl">Upload Image</div><span class="required"></span>
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
                        $AllChkBox.=form_input_ready($ByPercentChkBox, 'radio') . '<label for="chrImageFlagS"> System </label>';
                        $ByExternalChkBox = array(
                            'name' => 'chrImageFlag',
                            'id' => 'chrImageFlagE',
                            'value' => 'E',
                            'class' => 'user-redio-button',
                            'checked' => $ExternalLinkCheck,
                            'onclick' => 'Show_BG_Box(this.value);',
                        );
                        $AllChkBox.=form_input_ready($ByExternalChkBox, 'radio') . '<label for="chrImageFlagE"> External Link </label>';
                        $CBoxdata = array(
                            'extraDataInTD' => $AllChkBox
                        );
                        echo form_input_ready($CBoxdata);
                        ?> 
                    </div>
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
                            'class' => 'frist-name input input-bg01',
                            'value' => (!empty($Row['varExternalUrl']) ? $Row['varExternalUrl'] : ''),
                            'placeholder' => 'http://www.'
                        );
                        echo form_input_ready($URLBoxdata);
                        ?>
                        <div class="clear"></div>
                        <label class="fr error" for="varExternalUrl"></label>
                    </div>
                </div>
                <?php
                $ImagePath = 'upimages/banner/images/' . $Row['varImage'];
                if (file_exists($ImagePath) && $Row['varImage'] != '') {
                    $image_thumb = image_thumb($ImagePath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                    if ($Row['Chr_Banner_Type'] == 'H') {
                        $image_detail_thumb = image_thumb($ImagePath, HOME_BANNER_WIDTH, HOME_BANNER_HEIGHT);
                    } else {
                        $image_detail_thumb = image_thumb($ImagePath, INNER_BANNER_WIDTH, INNER_BANNER_HEIGHT);
                    }
                }
                if (!empty($eid)) {
                    if (file_exists($ImagePath)) {
                        ?>
                        <div class="fl mgtm5" id="hide_div"> 
                            <div class="fl">
                                <?php
                                $ImageName = $Row['varImage'];
                                if ($ImageName != "") {
                                    ?>                               
                                    <?php
                                    if ($Row['chrImageFlag'] == 'S') {
                                        $disp_div .= "<div class=\"title-form fl\" id='selectdiv'><strong></strong>&nbsp;&nbsp;";
                                    } else {
                                        $disp_div .= "<div class=\"title-form fl\" id='selectdiv2'><strong></strong>&nbsp;&nbsp;";
                                    }


                                    if ($Row['Chr_Banner_Type'] == 'H') {
                                        $disp_div .= "<span id=\"divdelbro\" class=\"title-form fl\" >&nbsp;&nbsp;
                                                      <a href=\"#varMenuIconImage\" class=\"fancybox-buttons\" data-fancybox-group=\"button\">
                                                            <img title=\"" . htmlentities($this->common_model->GetImageNameOnly($Row['varImage'])) . "\" style=\"margin-top:10px\" class=\"mgr15\" src=\"" . $image_thumb . "\" alt=\"View\"  border=\"0\" align=\"absmiddle\" id=\"myimage\" />
                                                                <span id=\"varMenuIconImage\" style=\"display:none\">
                                                                    <img title=\"" . htmlentities($this->common_model->GetImageNameOnly($Row['varImage'])) . "\" src=\"" . $image_detail_thumb . "\" alt=\"View\"  border=\"0\" align=\"absmiddle\" id=\"myimage\" Width=\"" . HOME_BANNER_WIDTH . "\"  Height=\"" . HOME_BANNER_HEIGHT . "\" />
                                                                    
                                                                </span>
                                                        </a>
                                                        
                                                    </span>";

                                        echo $disp_div;
                                    } else {
                                        $disp_div .= "<span id=\"divdelbro\" class=\"title-form fl\" >&nbsp;&nbsp;
                                                      <a href=\"#varMenuIconImage\" class=\"fancybox-buttons\" data-fancybox-group=\"button\">
                                                            <img title=\"" . htmlentities($this->common_model->GetImageNameOnly($Row['varImage'])) . "\" style=\"margin-top:10px\" class=\"mgr15\" src=\"" . $image_thumb . "\" alt=\"View\"  border=\"0\" align=\"absmiddle\" id=\"myimage\" />
                                                                <span id=\"varMenuIconImage\" style=\"display:none\">
                                                                    <img title=\"" . htmlentities($this->common_model->GetImageNameOnly($Row['varImage'])) . "\" src=\"" . $image_detail_thumb . "\" alt=\"View\"  border=\"0\" align=\"absmiddle\" id=\"myimage\" Width=\"" . INNER_BANNER_WIDTH . "\"  Height=\"" . INNER_BANNER_HEIGHT . "\" />
                                                                    
                                                                </span>
                                                        </a>
                                                        
                                                    </span>";

                                        echo $disp_div;
                                    }
                                    ?> 
                                </div>                    
                                <?php
                            } elseif ($Row['chrImageFlag'] == 'E') {
                                echo '<span class="lbl-note">Sorry! The provided path of an external link is not found please try again.</span>';
                            }
                            ?>                    
                        </div>

                        <?php
                    }
                    ?>
                </div>
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
            <div class="clear"></div>
            <div class="fl" id="upload_note" <?php echo $NoneNoteDisplay; ?>>
                <span class="spannote">Upload Image file of format only *.jpg, *.jpeg, *.png or *.gif. Having maximum size of 5MB.
                    <div id="size">(Recommended Image Dimension Width <label id="widthposition"><?php echo $Width; ?>px</label>X&nbsp;Height <label id="heightposition"><?php echo $Height; ?>px</label>,Maximum Image Dimension Width 4000px X Height 4000px)<br/>
                        The generated thumb of an uploaded image is greater than Width 4000px X  Height 4000px (in size), it may slow down the performance of the respective page and the time to load it would also increase.</div></span> 
            </div>     

            <!---------------------------End Image Code--------------------------->         

            <div class="spacer10"></div> 
        </div>
        <?php
        $DisplayInfoDivDisplay = 'style="display:none;"';
        $Displayinfo_Plus_Minus = 'plus-icn';
        if (!empty($eid)) {
            $DisplayInfoDivDisplay = '';
            $Displayinfo_Plus_Minus = 'minus-icn';
        }
        ?>  
        <div class="spacer10"></div>
        <div class="contact-title" style="cursor:pointer;" onclick="javascript:expandcollapsepanel('DIV_displayinfo','Displayinfo_Plus_Minus');">
            Display Information
            <span id="Displayinfo_Plus_Minus" class="<?php echo $Displayinfo_Plus_Minus; ?>"></span> 
        </div>
        <div class="spacer10"></div>
        <div class="fix_width" id="DIV_displayinfo" <?php echo $DisplayInfoDivDisplay; ?>>
            <div class="inquiry-form">
                <div class="fl title-w" > 
                    <div class="fl"> 
                    </div>
                    <div class="title-form fl">Display Order</div><span class="fl required"></span>
                    <div class="fl mgl10">
                        <?php
                        $DOBoxdata = array(
                            'name' => 'intDisplayOrder',
                            'id' => 'intDisplayOrder',
                            'value' => (!empty($eid) ? $Row['intDisplayOrder'] : '1'),
                            'maxlength' => '3',
                            'class' => 'frist-name input input-bg01 fl',
                            'onkeypress' => 'return KeycheckOnlyNumeric(event);',
                        );
                        echo form_input_ready($DOBoxdata);
                        ?>
                    </div>
                    <div class="clear"></div>
                    <div class="spacer10"></div>
                    <div class="fl"> 
                    </div>
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
                            <a style="text-decoration:none;" onclick="if(document.getElementById('chrPublishY').checked!=true) document.getElementById('chrPublishY').checked=true;" href="javascript:">Yes</a>
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
                            <a style="text-decoration:none;" onclick="if(document.getElementById('chrPublishY').checked!=true) document.getElementById('chrPublishY').checked=true;" href="javascript:">Yes</a>
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
                            <a style="text-decoration:none;" onclick="if(document.getElementById('chrPublishN').checked!=true) document.getElementById('chrPublishN').checked=true;" href="javascript:">No</a>
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
                            <a style="text-decoration:none;" onclick="if(document.getElementById('chrPublishN').checked!=true) document.getElementById('chrPublishN').checked=true;" href="javascript:">No</a>
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
            <div class="submit-btn">
                <?php echo anchor(MODULE_PAGE_NAME, 'Cancel', array('title' => 'Cancel')); ?>
            </div>
        </div>  
        <div class="spacer10"></div>
        <?php echo form_close(); ?>
    </section>
</div>
<?php $dropbox = DROPBOX_LIVE_KEY; ?>
<script type="text/javascript" src="https://www.dropbox.com/static/api/1/dropins.js" id="dropboxjs" data-app-key="<?php echo $dropbox ?>"></script>