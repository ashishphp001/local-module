<style>
    .gallery_grid_item img, .gallery_grid_item > a{
        display:unset !important;
    }    
</style>
<script>
    function update_qunatity() {
        var chkQuantity = document.getElementById("chrQuantity");
        if (chkQuantity.checked) {
            document.getElementById('quantity_div1').style.display = '';
            document.getElementById('quantity_div2').style.display = '';
        } else {
            document.getElementById('quantity_div1').style.display = 'none';
            document.getElementById('quantity_div2').style.display = 'none';
        }
    }
    function update_approx_order() {
        var chkApproxOrder = document.getElementById("chrApproxOrder");
        if (chkApproxOrder.checked) {
            document.getElementById('approx_order_div1').style.display = '';
            document.getElementById('approx_order_div2').style.display = '';
        } else {
            document.getElementById('approx_order_div1').style.display = 'none';
            document.getElementById('approx_order_div2').style.display = 'none';
        }
    }
    function selectproduct(pid) {
        $.ajax({
            type: "GET",
            url: "<?php echo MODULE_PAGE_NAME ?>/getProductData?intProduct=" + pid,
            async: false,
            success: function (Data)
            {
                updatepc(Data.intParentCategory);
            }
        });
    }

    function updatepc(catid)
    {
        $.ajax({
            type: "GET",
            url: "<?php echo MODULE_PAGE_NAME ?>/getProductCategory?intProductProduct=" + catid,
            async: false,
            success: function (Datas)
            {
                $("#procat").html(Datas);
                document.getElementById('procatbox').style.display = 'none';
            }
        });
    }

    function getchanged()
    {
        var Title = document.getElementById("varName").value + " - Sell Lead";
        var Title1 = Title;
        var Meta_keyword = Title;
        document.getElementById("varMetaTitle").value = Title1;
        document.getElementById("varMetaKeyword").value = Meta_keyword;
        CountLeft(document.Frmsellleads.varMetaTitle, document.Frmsellleads.metatitle_left, 200);
        CountLeft(document.Frmsellleads.varMetaKeyword, document.Frmsellleads.metakeyword_left, 200);
    }

    function generate_seocontent(flag) {
        var title = trim(document.getElementById('varName').value) + " - Sell Lead";
        var abcd1 = CKEDITOR.instances.txtDescription.getData();
        var abcd = CKEDITOR.instances.txtDescription.getData();
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
        CountLeft(document.Frmsellleads.varMetaTitle, document.Frmsellleads.metatitle_left, 200);
        CountLeft(document.Frmsellleads.varMetaDescription, document.Frmsellleads.metadescription_left, 400);
        CountLeft(document.Frmsellleads.varMetaKeyword, document.Frmsellleads.metakeyword_left, 400);
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
            CountLeft(document.Frmsellleads.varMetaTitle, document.Frmsellleads.metatitle_left, 200);
            CountLeft(document.Frmsellleads.varMetaDescription, document.Frmsellleads.metadescription_left, 400);
            CountLeft(document.Frmsellleads.varMetaKeyword, document.Frmsellleads.metakeyword_left, 400);
        });
<?php } ?>
    $(document).ready(function ()
    {
        $('#varAlias').bind("cut copy paste", function (e)
        {
            e.prsellleadsDefault();
        });
        $('#varName').keypress(function (sellleads)
        {
            var keycode = (sellleads.keyCode ? sellleads.keyCode : sellleads.which);
            if (keycode == '13')
            {
                $('#varName').blur();
            }
        });
    });
    function quickedit(Action)
    {
        var url = "<?php echo SITE_PATH ?>" + $("#varAlias").val() + "-buylead";
        Quick_Edit_Alias_Ajax(Action, url, 'varName', encodeURIComponent('<?php echo $eid ?>'), encodeURIComponent('150'), '<?php echo COMMON_ALIAS_EXISTS_MSG ?>');
    }
    $(document).ready(function ()
    {

        var chkApproxOrder = document.getElementById("chrApproxOrder");
        if (chkApproxOrder.checked) {
            document.getElementById('approx_order_div1').style.display = '';
            document.getElementById('approx_order_div2').style.display = '';
        } else {
            document.getElementById('approx_order_div1').style.display = 'none';
            document.getElementById('approx_order_div2').style.display = 'none';
        }

        var chkQuantity = document.getElementById("chrQuantity");
        if (chkQuantity.checked) {
            document.getElementById('quantity_div1').style.display = '';
            document.getElementById('quantity_div2').style.display = '';
        } else {
            document.getElementById('quantity_div1').style.display = 'none';
            document.getElementById('quantity_div2').style.display = 'none';
        }


        if (document.getElementById('chrDaysRequirement').checked == true)
        {
            document.getElementById('showDaysDiv').style.display = '';
        } else {
            document.getElementById('showDaysDiv').style.display = 'none';
        }

        $.validator.addMethod("Chk_Image_Size", function (sellleads, value) {
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
        $.validator.addMethod("greaterThanEnd", function (value, element) {
            var startprice = document.getElementById('varStartPrice').value;
            var endprice = document.getElementById('varEndPrice').value;
            if (startprice != '') {
                if (startprice <= endprice) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }, "Start price less than end price.");
        $("#Frmsellleads").validate({
            ignore: [],
            rules: {
                intUser: {
                    required: true
                },
                varName: {
                    required: true
                },
//                intParentCategory: {
//                    required: true
//                },
                varReqType: {
                    required: true
                },
                varQuantity: {
                    required: {
                        depends: function () {
                            if ($("#chrQuantity").is(":checked")) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                intUnit: {
                    required: {
                        depends: function () {
                            if ($("#chrQuantity").is(":checked")) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                varStartPrice: {
                    required: {
                        depends: function () {
                            if ($("#chrApproxOrder").is(":checked")) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    },
                    greaterThanEnd: true
                },
                varEndPrice: {
                    required: {
                        depends: function () {
                            if ($("#chrApproxOrder").is(":checked")) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                varDays: {
                    required: {
                        depends: function () {
                            if ($("#chrDRequirement").is(":checked")) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
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
                intUser: {
                    required: "Please select customer."
                },
                varName: {
                    required: "Please enter product name."
                },
                intParentCategory: {
                    required: "Please select industry type."
                },
                varReqType: {
                    required: "Please select requirement type."
                },
                varStartPrice: {
                    required: "Please enter start price."
                },
                varEndPrice: {
                    required: "Please enter end price."
                },
                varDays: {
                    required: "Please enter days."
                },
                intUnit: {
                    required: "Please select unit type."
                },
                varQuantity: {
                    required: "Please enter quantity."
                },
                varImage: {
                    required: "Please select selllead image.",
                    accept: "Only *.jpg, *.jpeg, *.png or *.gif image formats are supported."
                }
            },
            errorPlacement: function (error, element)
            {
                if ($(element).attr('id') == 'intUser')
                {
                    error.appendTo('#intUsererror');
                } else if ($(element).attr('id') == 'intParentCategory')
                {
                    error.appendTo('#intParentCategoryerror');
                } else
                {
                    error.insertAfter(element);
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

    function KeycheckOnlyNumeric(e)
    {
        var _dom = 0;
        _dom = document.all ? 3 : (document.getElementById ? 1 : (document.layers ? 2 : 0));
        if (document.all)
            e = window.event;
        var ch = '';
        var KeyID = '';
        if (_dom == 2) {
            if (e.which > 0)
                ch = '(' + String.fromCharCode(e.which) + ')';
            KeyID = e.which;
        } else
        {
            if (_dom == 3) {
                KeyID = (window.event) ? event.keyCode : e.which;
            } else {
                if (e.charCode > 0)
                    ch = '(' + String.fromCharCode(e.charCode) + ')';
                KeyID = e.charCode;
            }
        }
//        alert(KeyID);
        if ((KeyID == 43) || (KeyID == 45) || (KeyID == 32) || (KeyID >= 97 && KeyID <= 122) || (KeyID >= 65 && KeyID <= 90) || (KeyID >= 33 && KeyID <= 39) || (KeyID == 42) || (KeyID >= 58 && KeyID <= 64) || (KeyID >= 91 && KeyID <= 96) || (KeyID >= 123 && KeyID <= 126))
        {

            return false;
        }
        return true;
    }

</script>
<script type="text/javascript">



    function showDays() {

        if (document.getElementById('chrUrgentRequirement').checked == true)
        {
            document.getElementById('showDaysDiv').style.display = 'none';
        } else if (document.getElementById('chrDaysRequirement').checked == true)
        {
            document.getElementById('showDaysDiv').style.display = '';
        }

    }
</script>
<div id="page_content_inner">
    <div id="page_content">
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                <li><a href="<?php echo MODULE_PAGE_NAME; ?>">Manage Sell Leads</a></li>
                <li><span> <?php
                        $title1 = $Row_sellleads['varName'];
                        if (strlen($title1) > 80) {
                            $title = substr($Row_sellleads['varName'], 0, 80) . "...";
                        } else {
                            $title = $Row_sellleads['varName'];
                        }
                        if (!empty($eid)) {
                            echo 'Edit Sell Lead - ' . $title;
                        } else {
                            echo 'Add Sell Lead';
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
        $attributes = array('name' => 'Frmsellleads', 'id' => 'Frmsellleads', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
        if ($edit_record) {
            echo form_open($action, $attributes);
        }
        ?>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                echo form_hidden('btnsaveandc_x', '');
                echo form_hidden('varImageHidden', $Row_sellleads['varImage']);
                if (!empty($eid)) {
                    echo form_hidden('ehintglcode', $eid);
                    echo form_hidden('Alias_Id', $Row_sellleads['Alias_Id']);
                    echo form_hidden('eid', $Row_sellleads['int_id']);
                    echo form_hidden('Hid_varAlias', $Row_sellleads['varAlias']);
                }
                echo form_hidden('hidd_VarImage', $Row_sellleads['varImage']);
                echo form_hidden('hidd_ImageFlag', $flag);

                if (ADMIN_ID != 1) {
                    $style = 'style="display: none"';
                }
                ?>            
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>

                        <div class="uk-width-large-1-2">
                            <div class="uk-form-row">
                                <label>Select Customer *</label>
                                <?php
                                echo $CustomerList;
                                ?>
                                <div id="intUsererror"></div>
                            </div>
                        </div>

                        <div class="uk-width-large-1-2">
                            <div class="uk-form-row">
                                <label for="varName" class="uk-form-label">Product Name *</label>
                                <?php
                                if (!empty($eid)) {
                                    $EditAlias = "Y";
                                    $titleBoxdata = array(
                                        'name' => 'varName',
                                        'id' => 'varName',
                                        'value' => $Row_sellleads['varName'],
                                        'onblur' => ($alias_validation) ? "Auto_Alias('" . $EditAlias . "',this.id,'" . base64_encode($eid) . "','" . base64_encode(MODULE_ID) . "','N');" : "",
                                        'class' => 'uk-width-1-1'
                                    );
                                } else {
                                    $EditAlias = "N";
                                    $titleBoxdata = array(
                                        'name' => 'varName',
                                        'id' => 'varName',
                                        'value' => $Row_sellleads['varName'],
                                        'onblur' => ($alias_validation) ? "Auto_Alias('" . $EditAlias . "',this.id,'" . base64_encode($eid) . "','" . base64_encode(MODULE_ID) . "','N');" : "",
                                        'onkeyup' => 'getchanged()',
                                        'class' => 'uk-width-1-1'
                                    );
                                }

                                echo form_input($titleBoxdata);
                                ?>

                                <!--<input id="varName" onkeyup="getchanged();" name='varName' value="<?php echo $Row_sellleads['varName']; ?>" class="uk-width-1-1" />-->
                                <label class="error" for="varName"></label>

                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($alias_validation) { ?>
                    <div class="uk-form-row">
                        <?php
                        $param = array(
                            "name" => "varAlias",
                            'value' => set_value('varAlias', $Row_sellleads['varAlias']),
                            "linkServices" => 'onclick="CheckingAlias(\'varAlias\',\'' . base64_encode($Row_sellleads['varAlias']) . '\',\'' . base64_encode(MODULE_ID) . '\',\'' . MODULE . '\')"',
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
                    <div class="uk-width-small-2-2">
                        <label>Industry *</label>
                        <div id="procatbox">
                            <?php
                            echo $pagetree;
                            ?>
                        </div>
                        <div id="procat"></div>
                        <div id="intParentCategoryerror"></div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <label>Description</label>
                    <?php
                    $value = (!empty($eid) ? $Row_sellleads['txtDescription'] : '');
                    echo $this->mylibrary->load_ckeditor('txtDescription', $this->mylibrary->Replace_Varible_with_Sitepath($value), '100%', '200px', 'Basic');
                    ?>
                </div>
                <div class="uk-form-row">
                    <div class="uk-grid">
                        <div class="uk-width-medium-2-4">
                            <label>Requirement Type *</label>
                            <?php echo $RequirementType; ?>
                            <label class="error" for="varReqType"></label>
                        </div>

                        <!--</div>-->

                    </div>
                </div>

                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-small-1-4">
                            <?php
                            if (empty($eid)) {
                                $checked = "checked";
                            } else {
                                $checked = ($Row_sellleads['chrQuantity'] == 'Y') ? "checked" : "";
                            }
                            ?>
                            <label for="chrQuantity" onclick="update_qunatity()" class="inline-label">Display in Quantity</label>
                            <input <?php echo $checked; ?>  type="checkbox" name="chrQuantity" onclick="update_qunatity()" id="chrQuantity" />
                        </div>
                        <!--<span id="quantity_div">-->
                        <div class="uk-width-small-1-4" id="quantity_div1">
                            <label>MOQ *</label>
                            <?php
                            $QuantityBoxdata = array(
                                'name' => 'varQuantity',
                                'id' => 'varQuantity',
                                'value' => $Row_sellleads['varQuantity'],
                                'class' => 'md-input'
                            );

                            echo form_input($QuantityBoxdata);
                            ?>
                            <label class="error" for="varQuantity"></label>
                        </div>
                        <div class="uk-width-small-1-4"  id="quantity_div2">
                            <label>Unit Type *</label>
                            <?php echo $getUnitData; ?>
                            <label class="error" for="intUnit"></label>
                        </div>
                        <!--</span>-->
                    </div>
                </div>

                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-small-1-4">
                            <?php
                            if (empty($eid)) {
                                $checked = "";
                            } else {
                                $checked = ($Row_sellleads['chrApproxOrder'] == 'Y') ? "checked" : "";
                            }
                            ?>
                            <label for="chrApproxOrder" onclick="update_approx_order()" class="inline-label">Display Approx Order</label>
                            <input <?php echo $checked; ?>  type="checkbox" name="chrApproxOrder" onclick="update_approx_order()" id="chrApproxOrder" />
                        </div>
                        <div class="uk-width-small-1-4" id="approx_order_div1">
                            <label>Currency *</label>
                            <?php
                            if ($Row_sellleads['varApproxCurrency'] == '2') {
                                $sel1 = "";
                                $sel2 = "selected='selected'";
                            } else {
                                $sel1 = "selected='selected'";
                                $sel2 = "";
                            }
                            ?>
                            <select class="md-input" id="varApproxCurrency" name="varApproxCurrency">
                                <option value="1" <?php echo $sel1; ?>>&#8377;</option>
                                <option value="2" <?php echo $sel2; ?>>$</option>
                            </select>
                        </div>
                        <div class="uk-width-small-1-2" id="approx_order_div2">
                            <label>Approx Order Value *</label>
                            <div class="uk-form-row">

                                <input id="varStartPrice" name='varStartPrice' type="number" class="uk-form-width-medium" value="<?php echo $Row_sellleads['varStartPrice']; ?>" min="0" />
                                -
                                <input id="varEndPrice" name='varEndPrice' type="number" class="uk-form-width-medium" value="<?php echo $Row_sellleads['varEndPrice']; ?>" min="0" />
                                <label class="error" for="varStartPrice"></label>
                                <label class="error" for="varEndPrice"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-grid">
                        <div class="uk-width-small-1-2">
                            <label>Requirement Time :</label>
                            <input type="radio" name="chrRequirement" id="chrUrgentRequirement" <?php echo $checked = $Row_sellleads['chrRequirement'] == 'U' ? 'checked' : 'checked'; ?> value="U" onclick="showDays();" />
                            <label for="chrUrgentRequirement" class="inline-label">Urgent</label>
                            <input type="radio" name="chrRequirement" id="chrDaysRequirement" <?php echo $checked = $Row_sellleads['chrRequirement'] == 'D' ? 'checked' : ''; ?> value="D" onclick="showDays();" />
                            <label for="chrDaysRequirement" class="inline-label">With in Days</label>

                        </div>
                    </div>
                </div>

                <div class="uk-width-small-1-2"  id='showDaysDiv'>
                    <label>Days *</label>
                    <?php
                    $daysBoxdata = array(
                        'name' => 'varDays',
                        'id' => 'varDays',
                        'value' => $Row_sellleads['varDays'],
                        'class' => 'md-input'
                    );

                    echo form_input($daysBoxdata);
                    ?>
                    <label class="error" for="varDays"></label>
                    <!--</div>-->
                </div>
                <!--</div>-->

                <!------------------Image code start ------------------>

                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label>&nbsp;</label>
                            <div class="clear"></div>
                            <?php
                            if (!empty($eid)) {
                                if ($Row_sellleads['chrImageFlag'] == 'S') {
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
                        Upload Sell Lead Image
                        <input id="varImage" name="varImage" type="file">
                    </div>
                    <div class="clear"></div>
                    <label class="error" for="varImage"></label>
                    <?php
                    $ImagePath = 'upimages/sellleads/images/' . $Row_sellleads['varImage'];
                    if (file_exists($ImagePath) && $Row_sellleads['varImage'] != '') {
                        $image_thumb = image_thumb($ImagePath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                        $image_detail_thumb = image_thumb($ImagePath, BUY_LEADS_WIDTH, BUY_LEADS_HEIGHT);
                    }
                    if (!empty($eid)) {
                        if (file_exists($ImagePath)) {
                            ?>
                            <?php
                            $ImageName = $Row_sellleads['varImage'];
                            if ($ImageName != "") {
                                ?>                               
                                <?php
                                $disp_div .= "<div class=\"gallery_grid_item md-card-content\" id=\"divdelbro\" >&nbsp;&nbsp;
                                                      <a href=\"" . $image_detail_thumb . "\" data-uk-lightbox=\"{group:'gallery'}\">
                                                            <img src=\"" . $image_thumb . "\" />
                                                      </a><a href=\"javascript:;\" onclick=\"delete_image('" . $Row_sellleads['int_id'] . "','" . $Row_sellleads['varImage'] . "',1);\"><div class=\"md-btn md-btn-wave\">Delete</div></a>
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
                <div class='spacer10'></div>

            </div>
        </div>


        <div class="md-card">
            <div class="md-card-content">

                <div class="uk-form-row">
                    <div class="uk-grid">
                        <div class="uk-width-small-1-3">
                            <label>Currency</label>
                            <?php
                            if ($Row_sellleads['varCurrency'] == '2') {
                                $sel1 = "";
                                $sel2 = "selected='selected'";
                            } else {
                                $sel1 = "selected='selected'";
                                $sel2 = "";
                            }
                            ?>
                            <select class="md-input" id="varCurrency" name="varCurrency">
                                <option value="1" <?php echo $sel1; ?>>&#8377;</option>
                                <option value="2" <?php echo $sel2; ?>>$</option>
                            </select>
                        </div>
                        <div class="uk-width-small-1-3">
                            <label>Price</label>
                            <?php
                            $Expectedprice = array(
                                'name' => 'varExpectedPrice',
                                'id' => 'varExpectedPrice',
                                'value' => $Row_sellleads['varExpectedPrice'],
                                'class' => 'md-input'
                            );

                            echo form_input($Expectedprice);
                            ?>
                            <label class="error" for="varExpectedPrice"></label>
                        </div>
                        <div class="uk-width-small-1-3">
                            <label>Unit Type</label>
                            <?php echo $getEUnitData; ?>
                            <label class="error" for="intEUnit"></label>
                        </div>
                        <!--</div>-->

                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>

                        <div class="uk-form-row">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-2-2">
                                    <label>Payment Terms: </label>
                                    <?php
                                    echo $getPaymentTermsData;
                                    ?> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                $val_metatitle = (!empty($eid) ? ($Row_sellleads['varMetaTitle']) : '');
                $val_metakeyword = (!empty($eid) ? ($Row_sellleads['varMetaKeyword']) : '');
                $val_metadescription = (!empty($eid) ? ($Row_sellleads['varMetaDescription']) : '');
                $param = array("varMetaTitle" => $val_metatitle, "varMetaKeyword" => $val_metakeyword, "varMetaDescription" => $val_metadescription);
                echo $this->mylibrary->seo_textdetails($param, '', $this->module_url, 'Frmsellleads');
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
                        'checked' => ($Row_sellleads['chrPublish'] == 'Y') ? TRUE : FALSE
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
                           'checked' => ($Row_sellleads['chrPublish'] == 'N') ? TRUE : FALSE
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