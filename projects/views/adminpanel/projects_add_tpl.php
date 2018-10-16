
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
        var Title = document.getElementById("varShortName").value;
        var Title1 = Title;
        var Meta_keyword = Title;
        document.getElementById("varMetaTitle").value = Title1;
        document.getElementById("varMetaKeyword").value = Meta_keyword;
        CountLeft(document.Frmprojects.varMetaTitle, document.Frmprojects.metatitle_left, 200);
//        CountLeft(document.Frmprojects.varMetaDescription,document.Frmprojects.metadescription_left,400);
        CountLeft(document.Frmprojects.varMetaKeyword, document.Frmprojects.metakeyword_left, 200);
    }
    function generate_seocontent(flag) {
        var title = trim(document.getElementById('varShortName').value);
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
        CountLeft(document.Frmprojects.varMetaTitle, document.Frmprojects.metatitle_left, 200);
        CountLeft(document.Frmprojects.varMetaDescription, document.Frmprojects.metadescription_left, 400);
        CountLeft(document.Frmprojects.varMetaKeyword, document.Frmprojects.metakeyword_left, 400);
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
            CountLeft(document.Frmprojects.varMetaTitle, document.Frmprojects.metatitle_left, 200);
            CountLeft(document.Frmprojects.varMetaDescription, document.Frmprojects.metadescription_left, 400);
            CountLeft(document.Frmprojects.varMetaKeyword, document.Frmprojects.metakeyword_left, 400);
        });
<?php } ?>

    $("#intDisplayOrder").removeClass("ignore");
    $(document).ready(function ()
    {

        $('#varAlias').bind("cut copy paste", function (e)
        {
            e.prprojectsDefault();
        });
        $('#varShortName').keypress(function (projects)
        {
            var keycode = (projects.keyCode ? projects.keyCode : projects.which);
            if (keycode == '13')
            {
                $('#varShortName').blur();
            }
        });
    });
    function quickedit(Action)
    {
        var url = "<?php echo SITE_PATH ?>" + $("#varAlias").val();
        Quick_Edit_Alias_Ajax(Action, url, 'varShortName', encodeURIComponent('<?php echo $eid ?>'), encodeURIComponent('2'), '<?php echo COMMON_ALIAS_EXISTS_MSG ?>');
    }
    $(document).ready(function ()
    {


        $.validator.addMethod("Chk_Image_Size", function (projects, value) {
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
        $("#Frmprojects").validate({
            ignore: [],
            rules: {
                varShortName: {
                    required: true,
                    alphanumeric: true
                },
                varShortDesc: {
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
                intDisplayOrder: {
                    displayorder: ['intDisplayOrder'],
                    maxlength: 3
                }
            },
            messages: {
                varShortName: {
                    required: NEWS_TITLE
                },
                varShortDesc: {
                    required: "Please enter technologies."
                },
                varImage:
                        {
                            required: "Please select image.",
                            accept: "Only *.jpg, *.jpeg, *.png or *.gif image formats are supported."
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
    $(document).ready(function ()
    {
        $('.add').click(function () {
            var counter = document.getElementById('file_hd').value;
            var counter1 = Number(counter) + 1;
            document.getElementById('file_hd').value = counter1;
            $(this).before('<div class="block">\n\
   <div class="form-group">\n\
 <div class="spacer10"></div><div class="col-md-5 col-sm-5 col-xs-5">\n\
<input type="text" name="varSTitle' + counter1 + '" id="varSTitle' + counter1 + '" value="" placeHolder="Title" maxlength="100" class="form-control" />\n\
</div>\n\
<div class="col-md-5 col-sm-5 col-xs-5">\n\
<input type="text" name="varSvalue' + counter1 + '" id="varSvalue' + counter1 + '" value="" placeHolder="Value" class="form-control"/>\n\
 </div>\n\
<span class="remove"></span>\n\
</div>');
            MC.ColorPicker.reload();
        });

        $(document).on('click', '.remove', function () {
            $(this).parent('div').remove();
        });
    });
</script>


<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <b class="icon-list-ul"></b>
            <?php
            $title1 = $Row_projects['varShortName'];
            if (strlen($title1) > 80) {
                $title = substr($Row_projects['varShortName'], 0, 80) . "...";
            } else {
                $title = $Row_projects['varShortName'];
            }
            if (!empty($eid)) {
                echo 'Edit Project - ' . $title;
            } else {
                echo 'Add Project';
            }
            ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php
                echo '
                    <a class="fr Editable-btn" href="' . MODULE_PAGE_NAME . '">
                <span><b class="icon-caret-left"></b>Manage Projects</span>
            </a>';
                ?>
            </li>
        </ol>
    </section>
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
                        $attributes = array('name' => 'Frmprojects', 'id' => 'Frmprojects', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
                        if ($edit_record) {
                            echo form_open($action, $attributes);
                        }
                        echo form_hidden('btnsaveandc_x', '');
                        echo form_hidden('varImageHidden', $Row_projects['varImage']);
                        if (!empty($eid)) {
                            echo form_hidden('ehintglcode', $eid);
                            echo form_hidden('Alias_Id', $Row_projects['Alias_Id']);
                            echo form_hidden('eid', $Row_projects['int_id']);
                            echo form_hidden('Hid_varAlias', $Row_projects['varAlias']);
                            echo form_hidden('Old_DisplayOrder', $Row_projects['intDisplayOrder'], '', 'id="Old_DisplayOrder"');
                        }
                        echo form_hidden('hidd_VarImage', $Row_projects['varImage']);
                        echo form_hidden('hidd_ImageFlag', $flag);
                        if (ADMIN_ID != 1) {
                            $style = 'style="display: none"';
                        }
                        ?>            
                        <div class="fix_width" id="DIV_gen_info">
                            <div class="clear"></div> 
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label> Select Project Type</label>
                                    <select class="form-control" id="intProject" name="intProject">
                                        <?php
                                        $type = array("App", "Web", "Game");
                                        foreach ($type as $row) {
                                            if ($row == $Row_projects['intProject']) {
                                                $sel = "selected='selected'";
                                            } else {
                                                $sel = "";
                                            }
                                            echo '<option value="' . $row . '" ' . $sel . '>' . $row . '</option>';
                                        }
                                        ?>
                                        <!--<option value="">App</option>-->
                                    </select>
                                    <?php // echo $TechnologyList;  ?>
                                </div>
                            </div>
                            <div class="clear"></div> 
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label> Select Technology</label>
                                    <?php echo $TechnologyList; ?>
                                </div>
                            </div>
                            <div class="clear"></div> 
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label> Title</label><span class="required"></span>
                                    <?php
                                    if (!empty($eid)) {
                                        $EditAlias = "Y";
                                        $titleBoxdata = array(
                                            'name' => 'varShortName',
                                            'id' => 'varShortName',
                                            'value' => $Row_projects['varShortName'],
                                            'onblur' => ($alias_validation) ? "Auto_Alias('" . $EditAlias . "',this.id,'" . base64_encode($eid) . "','" . base64_encode(MODULE_ID) . "','N');" : "",
                                            'class' => 'form-control'
                                        );
                                    } else {
                                        $EditAlias = "N";
                                        $titleBoxdata = array(
                                            'name' => 'varShortName',
                                            'id' => 'varShortName',
                                            'value' => $Row_projects['varShortName'],
                                            'onblur' => ($alias_validation) ? "Auto_Alias('" . $EditAlias . "',this.id,'" . base64_encode($eid) . "','" . base64_encode(MODULE_ID) . "','N');" : "",
                                            'onkeyup' => 'getchanged()',
                                            'class' => 'form-control'
                                        );
                                    }

                                    echo form_input($titleBoxdata);
                                    ?>
                                </div>
                            </div>
                            <?php if ($alias_validation) { ?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <?php
                                        $param = array(
                                            "name" => "varAlias",
                                            'value' => set_value('varAlias', $Row_projects['varAlias']),
                                            "linkServices" => 'onclick="CheckingAlias(\'varAlias\',\'' . base64_encode($Row_projects['varAlias']) . '\',\'' . base64_encode(MODULE_ID) . '\',\'' . MODULE . '\')"',
                                            "eid" => $eid,
                                            'class' => 'form-control',
                                            "edit_record" => $edit_record
                                        );
                                        echo $aliaText = $this->mylibrary->Alias_Textbox($param);
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="clear"></div>  
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label> Specification</label>
                                <div class="form-group">
                                    <?php $varSvalue = explode("__", $Row_projects['varSvalue']); ?>
                                    <input type="hidden" name="file_hd" id="file_hd"  value="<?php echo count($varSvalue); ?>">
                                    <?php
                                    if ($eid != "") {
                                        $varSvalue = explode("__", $Row_projects['varSvalue']);
                                        $varSTitle = explode("__", $Row_projects['varSTitle']);
                                        $t = 0;
                                        $j = 1;
                                        foreach ($varSvalue as $txt) {
                                            ?>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <?php if ($t == 0) {
                                                    ?>
                                                    <div class="form-group">
                                                        <div class="clear"></div>  
                                                        <?php
                                                    }
                                                    ?>

                                                    <div>
                                                        <div class="spacer10"></div>
                                                        <div class="col-md-5 col-sm-5 col-xs-5">
                                                            <?php
                                                            $ColornamVal = 'varSTitle' . $j . '';
                                                            $colorNameBoxdata = array(
                                                                'name' => $ColornamVal,
                                                                'id' => $ColornamVal,
                                                                'value' => $varSTitle[$t],
                                                                'placeHolder' => 'Title',
                                                                'class' => 'form-control'
                                                            );
                                                            echo form_input($colorNameBoxdata);
                                                            ?> 
                                                        </div>
                                                        <div class="col-md-5 col-sm-5 col-xs-5">
                                                            <?php
                                                            $namVal = 'varSvalue' . $j . '';
                                                            $colorBoxdata = array(
                                                                'name' => $namVal,
                                                                'id' => $namVal,
                                                                'value' => $txt,
                                                                'placeHolder' => 'Value',
                                                                'class' => 'form-control'
                                                            );
                                                            echo form_input($colorBoxdata);
                                                            ?> 
                                                        </div>
                                                        <?php if ($j != 1) { ?>
                                                            <span class="remove"></span>
                                                        <?php } ?>
                                                    </div>
                                                    <?php
                                                    if ($j == count($varSvalue)) {
                                                        ?>
                                                        <div class="block">
                                                            <span class="add"></span>
                                                            <div class="spacer10"></div>
                                                        </div>
                                                        <?php
                                                    }
                                                    if ($t == 0) {
                                                        ?>
                                                    </div>   
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="clear"></div>
                                            <?php
                                            $t++;
                                            $j++;
                                        }
                                    } else {
                                        ?> 
                                        <div class="block">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                                        <div class="clear"></div> 

                                                        <?php
                                                        $colorNameBoxdata = array(
                                                            'name' => 'varSTitle1',
                                                            'id' => 'varSTitle1',
                                                            'value' => set_value('varSTitle1', $Row_projects['varSTitle1']),
                                                            'placeHolder' => 'Title',
                                                            'class' => 'form-control'
                                                        );
                                                        echo form_input($colorNameBoxdata);
                                                        ?> 
                                                    </div>
                                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                                        <?php
                                                        $colorBoxdata = array(
                                                            'name' => 'varSvalue1',
                                                            'id' => 'varSvalue1',
                                                            'value' => set_value('varSvalue1', $Row_projects['varSvalue1']),
                                                            'placeHolder' => 'Value',
                                                            'class' => 'form-control'
                                                        );
                                                        echo form_input($colorBoxdata);
                                                        ?> 
                                                    </div>  
                                                    <div class="block">
                                                        <span class="add"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="spacer10"></div>
                        <div class="clear"></div> 
                        <!------------------Image code start ------------------>

                        <div class="">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label> Listing Image</label><span class="required"></span>

                                    <div class="clear"></div>  
                                    <?php
                                    if (!empty($eid)) {
                                        if ($Row_projects['chrImageFlag'] == 'S') {
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
                                        <label class="error" for="varImage"></label>
                                    </div>

                                </div>

                                <?php
                                $ImagePath = 'upimages/projects/images/' . $Row_projects['varImage'];
                                if (file_exists($ImagePath) && $Row_projects['varImage'] != '') {
                                    $image_thumb = image_thumb($ImagePath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                                    $image_detail_thumb = image_thumb($ImagePath, PROJECTS_WIDTH, PROJECTS_HEIGHT);
                                }
                                if (!empty($eid)) {
                                    if (file_exists($ImagePath)) {
                                        ?>
                                        <div id="hide_div"> 
                                            <div class="fl">
                                                <?php
                                                $ImageName = $Row_projects['varImage'];
                                                if ($ImageName != "") {
                                                    ?>                               
                                                    <?php
                                                    $disp_div .= "<div class=\"title-form fl\" id='selectdiv'><strong></strong>&nbsp;&nbsp;";

                                                    $disp_div .= "<span id=\"divdelbro\" class=\"title-form fl\" >&nbsp;&nbsp;
                                                      <a href=\"#varMenuIconImage\" class=\"fancybox-buttons\" data-fancybox-group=\"button\">
                                                            <img title=\"" . htmlentities($this->common_model->GetImageNameOnly($Row_projects['varImage'])) . "\" class=\"mgr15\" src=\"" . $image_thumb . "\" alt=\"View\"  border=\"0\" align=\"absmiddle\" id=\"myimage\" />
                                                                <span id=\"varMenuIconImage\" style=\"display:none\">
                                                                    <img title=\"" . htmlentities($this->common_model->GetImageNameOnly($Row_projects['varImage'])) . "\" src=\"" . $image_detail_thumb . "\" alt=\"View\"  border=\"0\" align=\"absmiddle\" id=\"myimage\" />
                                                                </span>
                                                        </a>
                                                        <a href=\"javascript:;\" onclick=\"delete_image('" . $Row_projects['int_id'] . "','" . $Row_projects['varImage'] . "',1);\"><div class=\"btn btn-default\" style=\"margin-left: 20px;\">Delete</div></a>
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
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="fl" id="upload_note" <?php echo $NoneNoteeDisplay; ?>>
                                <span class="spannote">Upload Image file of format only *.jpg, *.jpeg, *.png or *.gif. Having maximum size of 5MB.<br>
                                    (Recommended Image Dimension <?php echo PROJECTS_WIDTH; ?>px Width X <?php echo PROJECTS_HEIGHT; ?>px Height, Maximum Image Dimension 4000px Width X 4000px Height)</span> 
                            </div>   
                        </div>   
                        <!---------------------------End Image Code--------------------------->  
                        <div class="spacer10"></div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label> Technologies / Short Description</label> <span class="required"></span>
                            <div class="clear"></div> 
                            <?php
                            $titleLabelData = array(
                            );
                            echo form_input_label($titleLabelData);
                            $Desccounter = array('id' => 'Desccountleft',
                                'name' => 'Desccountleft',
                                'value' => 100 - strlen($Row_projects['varShortDesc']),
                                'class' => 'form-control',
                                'style' => 'text-align: center; display: inline ! important; width: 48px ! important; height: 33px;',
                                'readonly' => 'readonly'
                            );
                            ?>
                            <!--                        </div>
                            
                                                    <div class="col-md-6 col-sm-6 col-xs-12">-->
                            <div class="form-group">
                                <?php
                                $short_descBoxdata = array(
                                    'name' => 'varShortDesc',
                                    'id' => 'varShortDesc',
                                    'maxlength' => '100',
                                    'style' => 'float: left; height: 100px; overflow: auto; max-width: 453px;',
                                    'onKeyDown' => 'CountLeft(this.form.varShortDesc,this.form.Desccountleft,100);',
                                    'class' => 'form-control',
                                    'onKeyUp' => 'CountLeft(this.form.varShortDesc,this.form.Desccountleft,100);',
                                    'value' => set_value('varShortDesc', htmlspecialchars($Row_projects['varShortDesc'])),
                                    'extraDataInTD' => form_input_ready($Desccounter)
                                );
                                echo form_input_ready($short_descBoxdata, 'textarea');
                                ?>
                                <!--<div class="clear"></div>-->
                                <label class="error" for="varShortDesc"></label>
                            </div>
                            <!--</div>-->
                        </div>
                        <div class="spacer10"></div>
   <!--                    <script type="text/javascript">
                           CKEDITOR.replace('txtDescription');
                       </script>-->


                        <!--                    <div class="">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>Specification</label>
                        <?php
//                                $sendClientDetail = stripcslashes(htmlspecialchars_decode($Row_projects['txtSpecification']));
//                                echo $this->mylibrary->load_ckeditor('txtSpecification', $sendClientDetail, '', '', 'OnlyBasic');
                        ?>
                                                    </div>
                                                </div>
                                            </div>-->
                        <div class="clear"></div> 
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label> Play store Link - Android</label>
                                <?php
                                $andBoxdata = array(
                                    'name' => 'varAndroidName',
                                    'id' => 'varAndroidName',
                                    'value' => htmlspecialchars($Row_projects['varAndroidName']),
                                    'class' => 'form-control'
                                );

                                echo form_input($andBoxdata);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label> App Store Link - iOS</label>
                                <?php
                                $iosBoxdata = array(
                                    'name' => 'varIOSName',
                                    'id' => 'varIOSName',
                                    'value' => htmlspecialchars($Row_projects['varIOSName']),
                                    'class' => 'form-control'
                                );

                                echo form_input($iosBoxdata);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label> Website Link</label>
                                <?php
                                $webBoxdata = array(
                                    'name' => 'varWebsiteName',
                                    'id' => 'varWebsiteName',
                                    'value' => htmlspecialchars($Row_projects['varWebsiteName']),
                                    'class' => 'form-control'
                                );

                                echo form_input($webBoxdata);
                                ?>
                            </div>
                        </div>
                        <div class="">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <?php
                                    $value = (!empty($eid) ? $Row_projects['txtDescription'] : '');
                                    echo $this->mylibrary->load_ckeditor('txtDescription', $this->mylibrary->Replace_Varible_with_Sitepath($value), '100%', '200px', 'Basic');
                                    ?>
                                </div>
                            </div>
                        </div>
    <!--                    <script type="text/javascript">
                            window.onload = function ()
                            {
                                CKEDITOR.replace('txtDescription');
                            };
                        </script>-->
                        <div class="spacer10"></div>

                    </div>
                    <div class="clear"></div>
                    <div class="spacer10"></div>
                    <?php
                    $val_metatitle = (!empty($eid) ? ($Row_projects['varMetaTitle']) : '');
                    $val_metakeyword = (!empty($eid) ? ($Row_projects['varMetaKeyword']) : '');
                    $val_metadescription = (!empty($eid) ? ($Row_projects['varMetaDescription']) : '');
                    $param = array("varMetaTitle" => $val_metatitle, "varMetaKeyword" => $val_metakeyword, "varMetaDescription" => $val_metadescription);
                    echo $this->mylibrary->seo_textdetails($param, '', $this->module_url, 'Frmprojects');
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
                            <div class="fl" > 
                                <div class="title-form fl">Display Order</div><span class="fl required"></span>
                                <div class="fl mgl10">
                                    <?php
                                    $DOBoxdata1 = array(
                                        'name' => 'intDisplayOrder',
                                        'id' => 'intDisplayOrder',
                                        'value' => (!empty($eid) ? $Row_projects['intDisplayOrder'] : '1'),
                                        'maxlength' => '3',
                                        'class' => 'form-control',
                                        'onkeypress' => 'return KeycheckOnlyNumeric(clubs);',
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
                                            'checked' => ($Row_projects['chrPublish'] == 'Y') ? TRUE : FALSE
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
                                               'checked' => ($Row_projects['chrPublish'] == 'N') ? TRUE : FALSE
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
                                <div class="fl mgl5 tooltip" style="position:relative" title="<strong><?php echo "Note: Please select 'Yes' if you want to display / activate this record. Otherwise please select 'NO'" ?></strong>" >
                                    <img style="vertical-align:middle;margin-left:5px" width="16" height="16" alt="" onmouseout="hidediv('dvhlpvarwebsite');" onmouseover="showDiv(projects, 'dvhlpvarwebsite')" src="<?php echo GLOBAL_ADMIN_IMAGES_PATH; ?>/help.png">
                                </div>
                            </div>
                        </div>
                        <div class="spacer10"></div>
                    </div>
                    <div class="spacer10"></div>
                    <?php
                    if ($edit_record) {
                        ?>
                        <?php
                        $Form_Submit = array('name' => 'btnsaveandc', 'id' => 'btnsaveandc', 'value' => 'Save &amp; Keep Editing', 'class' => 'btn btn-primary btn-flat btn_blue');
                        echo form_submit($Form_Submit);
                        echo "&nbsp;";
                        $Form_Submit = array('name' => 'btnsaveande', 'id' => 'btnsaveande', 'value' => 'Save &amp; Exit', 'class' => 'btn btn-primary btn-flat btn_blue');
                        echo form_submit($Form_Submit);
                        ?>
                        <a href="<?php echo MODULE_PAGE_NAME; ?>" title="Cancel">
                            <div  class="btn btn-default">
                                Cancel
                            </div>
                        </a>
                        <div class="spacer10"></div>
                        <?php
                        echo form_close();
                    }
                    ?>
                </div> 
            </div>
        </div>
</div>
