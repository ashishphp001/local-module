<style>
    .gallery_grid_item img, .gallery_grid_item > a{
        display:unset !important;
    }    
</style>
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
        var Title = document.getElementById("varName").value;
        var Title1 = Title;
        var Meta_keyword = Title;
        document.getElementById("varMetaTitle").value = Title1;
        document.getElementById("varMetaKeyword").value = Meta_keyword;
        CountLeft(document.Frmplans.varMetaTitle, document.Frmplans.metatitle_left, 200);
//        CountLeft(document.Frmplans.varMetaDescription,document.Frmplans.metadescription_left,400);
        CountLeft(document.Frmplans.varMetaKeyword, document.Frmplans.metakeyword_left, 200);
    }
    function generate_seocontent(flag) {
        var title = trim(document.getElementById('varName').value);
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
        CountLeft(document.Frmplans.varMetaTitle, document.Frmplans.metatitle_left, 200);
        CountLeft(document.Frmplans.varMetaDescription, document.Frmplans.metadescription_left, 400);
        CountLeft(document.Frmplans.varMetaKeyword, document.Frmplans.metakeyword_left, 400);
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
            CountLeft(document.Frmplans.varMetaTitle, document.Frmplans.metatitle_left, 200);
            CountLeft(document.Frmplans.varMetaDescription, document.Frmplans.metadescription_left, 400);
            CountLeft(document.Frmplans.varMetaKeyword, document.Frmplans.metakeyword_left, 400);
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
    $(document).ready(function ()
    {
        $('#varAlias').bind("cut copy paste", function (e)
        {
            e.prplansDefault();
        });
        $('#varName').keypress(function (plans)
        {
            var keycode = (plans.keyCode ? plans.keyCode : plans.which);
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


        $.validator.addMethod("Chk_Image_Size", function (plans, value) {
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



        $("#Frmplans").validate({
            ignore: [],
            rules: {
                varName: {
                    required: true,
                    alphanumeric: true
                },
                varPrice: {
                    required: true
                },
                varAfterPrice: {
                    required: true
                },
                intCustomer: {
                    required: true
                },
                varBuylead: {
                    required: true
                },
                varYearlyPrice: {
                    required: true
                },
                intPerBuyLead: {
                    required: true
                },
                varSelllead: {
                    required: true
                },
                intCategory: {
                    required: true
                },
                varStorageSize: {
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
                }
            },
            messages: {
                varName: {
                    required: "Please enter plan name."
                },
                varPrice: {
                    required: "Please enter price name."
                },
                varYearlyPrice: {
                    required: "Please enter yearly price name."
                },
                intPerBuyLead: {
                    required: "Please enter extra buylead charge."
                },
                varAfterPrice: {
                    required: "Please enter after price."
                },
                intCustomer: {
                    required: "Please enter number of customer."
                },
                varBuylead: {
                    required: "Please enter buy lead count."
                },
                varSelllead: {
                    required: "Please enter sell lead count."
                },
                intCategory: {
                    required: "Please enter number of category."
                },
                varStorageSize: {
                    required: "Please enter storage size."
                },
                varImage: {
                    required: "Please select image.",
                    accept: "Only *.jpg, *.jpeg, *.png or *.gif image formats are supported."
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
<div id="page_content_inner">
    <div id="page_content">
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                <li><a href="<?php echo MODULE_PAGE_NAME; ?>">Manage Membership Plans</a></li>
                <li><span> <?php
                        $title1 = $Row_plans['varName'];
                        if (strlen($title1) > 80) {
                            $title = substr($Row_plans['varName'], 0, 80) . "...";
                        } else {
                            $title = $Row_plans['varName'];
                        }
                        if (!empty($eid)) {
                            echo 'Edit Plan - ' . $title;
                        } else {
                            echo 'Add Plan';
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
        $attributes = array('name' => 'Frmplans', 'id' => 'Frmplans', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
        if ($edit_record) {
            echo form_open($action, $attributes);
        }
        ?>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                echo form_hidden('btnsaveandc_x', '');
                echo form_hidden('varImageHidden', $Row_plans['varImage']);
                if (!empty($eid)) {
                    echo form_hidden('ehintglcode', $eid);
                    echo form_hidden('Alias_Id', $Row_plans['Alias_Id']);
                    echo form_hidden('eid', $Row_plans['int_id']);
                    echo form_hidden('Hid_varAlias', $Row_plans['varAlias']);
                }
                echo form_hidden('hidd_VarImage', $Row_plans['varImage']);
                echo form_hidden('hidd_ImageFlag', $flag);

                if (ADMIN_ID != 1) {
                    $style = 'style="display: none"';
                }
                ?>            
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label> Plan Name *</label>
                            <?php
                            if (!empty($eid)) {
                                $EditAlias = "Y";
                                $titleBoxdata = array(
                                    'name' => 'varName',
                                    'id' => 'varName',
                                    'value' => $Row_plans['varName'],
                                    'onblur' => ($alias_validation) ? "Auto_Alias('" . $EditAlias . "',this.id,'" . base64_encode($eid) . "','" . base64_encode(MODULE_ID) . "','N');" : "",
                                    'class' => 'md-input'
                                );
                            } else {
                                $EditAlias = "N";
                                $titleBoxdata = array(
                                    'name' => 'varName',
                                    'id' => 'varName',
                                    'value' => $Row_plans['varName'],
                                    'onblur' => ($alias_validation) ? "Auto_Alias('" . $EditAlias . "',this.id,'" . base64_encode($eid) . "','" . base64_encode(MODULE_ID) . "','N');" : "",
                                    'onkeyup' => 'getchanged()',
                                    'class' => 'md-input'
                                );
                            }

                            echo form_input($titleBoxdata);
                            ?>
                            <label class="error" for="varName"></label>
                        </div>
                    </div>
                </div>

                <?php if ($alias_validation) { ?>
                    <div class="uk-form-row">
                        <?php
                        $param = array(
                            "name" => "varAlias",
                            'value' => set_value('varAlias', $Row_plans['varAlias']),
                            "linkServices" => 'onclick="CheckingAlias(\'varAlias\',\'' . base64_encode($Row_plans['varAlias']) . '\',\'' . base64_encode(MODULE_ID) . '\',\'' . MODULE . '\')"',
                            "eid" => $eid,
                            'class' => 'md-input',
                            "edit_record" => $edit_record
                        );
                        echo $aliaText = $this->mylibrary->Alias_Textbox($param);
                        ?>
                    </div>
                <?php } ?>

                <!--<div class="clear"></div>--> 
                <div class="uk-form-row">
                    <div class="uk-grid">

                        <div class="uk-width-medium-1-4">
                            <div class="uk-input-group">
                                <span class="uk-input-group-addon">&#8377;</span>
                                <label>Monthly Price *</label>
                                <?php
                                $priceBoxdata = array(
                                    'name' => 'varPrice',
                                    'id' => 'varPrice',
                                    'value' => $Row_plans['varPrice'],
                                    'onkeypress' => 'return KeycheckOnlyNumeric(event)',
                                    'class' => 'md-input'
                                );

                                echo form_input($priceBoxdata);
                                ?>
                                <label class="error" for="varPrice"></label>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-4">
                            <div class="uk-input-group">
                                <span class="uk-input-group-addon">&#8377;</span>
                                <label>Monthly Original Price</label>
                                <?php
                                $priceOBoxdata = array(
                                    'name' => 'intMonthlyOriginalPrice',
                                    'id' => 'intMonthlyOriginalPrice',
                                    'value' => $Row_plans['intMonthlyOriginalPrice'],
                                    'onkeypress' => 'return KeycheckOnlyNumeric(event)',
                                    'class' => 'md-input'
                                );

                                echo form_input($priceOBoxdata);
                                ?>
                                <label class="error" for="intMonthlyOriginalPrice"></label>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-4">
                            <div class="uk-input-group">
                                <span class="uk-input-group-addon">&#8377;</span>
                                <label>Yearly Price *</label>
                                <?php
                                $priceYearBoxdata = array(
                                    'name' => 'varYearlyPrice',
                                    'id' => 'varYearlyPrice',
                                    'value' => $Row_plans['varYearlyPrice'],
                                    'onkeypress' => 'return KeycheckOnlyNumeric(event)',
                                    'class' => 'md-input'
                                );

                                echo form_input($priceYearBoxdata);
                                ?>
                                <label class="error" for="varYearlyPrice"></label>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-4">
                            <div class="uk-input-group">
                                <span class="uk-input-group-addon">&#8377;</span>
                                <label>Yearly Original Price</label>
                                <?php
                                $priceOYearBoxdata = array(
                                    'name' => 'intYearlyOriginalPrice',
                                    'id' => 'intYearlyOriginalPrice',
                                    'value' => $Row_plans['intYearlyOriginalPrice'],
                                    'onkeypress' => 'return KeycheckOnlyNumeric(event)',
                                    'class' => 'md-input'
                                );

                                echo form_input($priceOYearBoxdata);
                                ?>
                                <label class="error" for="intYearlyOriginalPrice"></label>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-grid">

                        <div class="uk-width-medium-1-3">
                            <div class="uk-input-group">
                                <span class="uk-input-group-addon">&#8377;</span>
                                <label>Special Offer Price</label>
                                <?php
                                $offerpriceBoxdata = array(
                                    'name' => 'intOfferPrice',
                                    'id' => 'intOfferPrice',
                                    'value' => $Row_plans['intOfferPrice'],
                                    'onkeypress' => 'return KeycheckOnlyNumeric(event)',
                                    'class' => 'md-input'
                                );

                                echo form_input($offerpriceBoxdata);
                                ?>
                                <label class="error" for="intOfferPrice"></label>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-3">
                            <div class="uk-input-group">
                                <!--<span class="uk-input-group-addon">&#8377;</span>-->
                                <label><nobr>Special Offer Validity (in Month)</nobr></label>
                                <?php
                                $monthBoxdata = array(
                                    'name' => 'intMonth',
                                    'id' => 'intMonth',
                                    'value' => $Row_plans['intMonth'],
                                    'onkeypress' => 'return KeycheckOnlyNumeric(event)',
                                    'class' => 'md-input'
                                );

                                echo form_input($monthBoxdata);
                                ?>
                                <label class="error" for="intMonth"></label>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-3">
                            <div class="uk-input-group">
                                <!--<span class="uk-input-group-addon">&#8377;</span>-->
                                <label><nobr>Extra BuyLead Charge *</nobr></label>
                                <?php
                                $buyleadBoxdata = array(
                                    'name' => 'intPerBuyLead',
                                    'id' => 'intPerBuyLead',
                                    'value' => $Row_plans['intPerBuyLead'],
                                    'onkeypress' => 'return KeycheckOnlyNumeric(event)',
                                    'class' => 'md-input'
                                );

                                echo form_input($buyleadBoxdata);
                                ?>
                                <label class="error" for="intPerBuyLead"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="uk-form-row">
                    <div class="uk-grid">

                        <div class="uk-width-medium-1-2">
                            <div class="uk-input-group">
                                <span class="uk-input-group-addon">&#8377;</span>
                                <label>After N number of cust. Price *</label>
                                <?php
                                $afterpriceBoxdata = array(
                                    'name' => 'varAfterPrice',
                                    'id' => 'varAfterPrice',
                                    'value' => $Row_plans['varAfterPrice'],
                                    'onkeypress' => 'return KeycheckOnlyNumeric(event)',
                                    'class' => 'md-input'
                                );

                                echo form_input($afterpriceBoxdata);
                                ?>
                                <label class="error" for="varAfterPrice"></label>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-input-group">
                                <span class="uk-input-group-addon"><i class="material-icons">wc</i></span>
                                <label>N number of customer *</label>
                                <?php
                                $customerBoxdata = array(
                                    'name' => 'intCustomer',
                                    'id' => 'intCustomer',
                                    'value' => $Row_plans['intCustomer'],
                                    'onkeypress' => 'return KeycheckOnlyNumeric(event)',
                                    'class' => 'md-input'
                                );

                                echo form_input($customerBoxdata);
                                ?>
                                <label class="error" for="intCustomer"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-4">
                            <label>Maximum Buy Lead *</label>
                            <?php
                            $storageBoxdata = array(
                                'name' => 'varBuylead',
                                'id' => 'varBuylead',
                                'value' => $Row_plans['varBuylead'],
                                'onkeypress' => 'return KeycheckOnlyNumeric(event)',
                                'class' => 'md-input'
                            );

                            echo form_input($storageBoxdata);
                            ?>
                            <label class="error" for="varBuylead"></label>
                        </div>
                        <div class="uk-width-medium-1-4">
                            <label>Maximum Sell Lead *</label>
                            <?php
                            $storageBoxdata = array(
                                'name' => 'varSelllead',
                                'id' => 'varSelllead',
                                'value' => $Row_plans['varSelllead'],
                                'onkeypress' => 'return KeycheckOnlyNumeric(event)',
                                'class' => 'md-input'
                            );

                            echo form_input($storageBoxdata);
                            ?>
                            <label class="error" for="varSelllead"></label>
                        </div>
                        <div class="uk-width-medium-1-4">
                            <label>Maximum Category for Leads *</label>
                            <?php
                            $storageBoxdata = array(
                                'name' => 'intCategory',
                                'id' => 'intCategory',
                                'value' => $Row_plans['intCategory'],
                                'onkeypress' => 'return KeycheckOnlyNumeric(event)',
                                'class' => 'md-input'
                            );

                            echo form_input($storageBoxdata);
                            ?>
                            <label class="error" for="intCategory"></label>
                        </div>
                        <div class="uk-width-medium-1-4">
                            <label>Users Storage Size (In MB) *</label>
                            <?php
                            $storageBoxdata = array(
                                'name' => 'varStorageSize',
                                'id' => 'varStorageSize',
                                'value' => $Row_plans['varStorageSize'],
                                'onkeypress' => 'return KeycheckOnlyNumeric(event)',
                                'class' => 'md-input'
                            );

                            echo form_input($storageBoxdata);
                            ?>
                            <label class="error" for="varStorageSize"></label>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <?php
                    if (empty($eid)) {
                        $catalogchecked = true;
                    } else {
                        $catalogchecked = ($Row_plans['chrCatalog'] == 'Y') ? TRUE : FALSE;
                    }
                    ?>
                    <label for="chrCatalog" class="inline-label">Product Catalog</label>
                    <input checked="<?php echo $catalogchecked; ?>" type="checkbox" name="chrCatalog" id="chrCatalog" data-md-icheck />
                    <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: Please select 'Yes' if you want to add catalog in membership plan in website. Otherwise please do not check."; ?>">help</i>
                </div>
                <div class="uk-form-row">
                    <?php
                    if (empty($eid)) {
                        $drawchecked = "checked";
                    } else {
                        $drawchecked = ($Row_plans['chrLuckyDraw'] == 'Y') ? "checked" : "";
                    }
                    ?>
                    <label for="chrLuckyDraw" class="inline-label">Lucky Draw</label>
                    <input <?php echo $drawchecked; ?> type="checkbox" name="chrLuckyDraw" id="chrLuckyDraw" data-md-icheck />
                    <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: Please select 'Yes' if you want to add lucky draw for this plan in website. Otherwise please do not check."; ?>">help</i>
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
                                if ($Row_plans['chrImageFlag'] == 'S') {
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
                        Upload Plan Image
                        <input id="varImage" name="varImage" type="file">
                    </div>
                    <div class="clear"></div>
                    <label class="error" for="varImage"></label>
                    <?php
                    $ImagePath = 'upimages/plans/images/' . $Row_plans['varImage'];
                    if (file_exists($ImagePath) && $Row_plans['varImage'] != '') {
                        $image_thumb = image_thumb($ImagePath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                        $image_detail_thumb = image_thumb($ImagePath, PLANS_WIDTH, PLANS_HEIGHT);
                    }
                    if (!empty($eid)) {
                        if (file_exists($ImagePath)) {
                            ?>
                            <?php
                            $ImageName = $Row_plans['varImage'];
                            if ($ImageName != "") {
                                ?>                               
                                <?php
                                $disp_div .= "<div class=\"gallery_grid_item md-card-content\" id=\"divdelbro\" >&nbsp;&nbsp;
                                                      <a href=\"" . $image_detail_thumb . "\" data-uk-lightbox=\"{group:'gallery'}\">
                                                            <img src=\"" . $image_thumb . "\" />
                                                      </a><a href=\"javascript:;\" onclick=\"delete_image('" . $Row_plans['int_id'] . "','" . $Row_plans['varImage'] . "',1);\"><div class=\"md-btn md-btn-wave\">Delete</div></a>
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
                        (Recommended Image Dimension <?php echo PLANS_WIDTH; ?>px Width X <?php echo PLANS_HEIGHT; ?>px Height, Maximum Image Dimension 4000px Width X 4000px Height)</span> 
                </div>   
                <!---------------------------End Image Code--------------------------->    

                <div class="uk-form-row">
                    <label>Description</label>
                    <?php
                    $value = (!empty($eid) ? $Row_plans['txtDescription'] : '');
                    echo $this->mylibrary->load_ckeditor('txtDescription', $this->mylibrary->Replace_Varible_with_Sitepath($value), '100%', '200px', 'Basic');
                    ?>
                </div>

            </div>
        </div>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                $val_metatitle = (!empty($eid) ? ($Row_plans['varMetaTitle']) : '');
                $val_metakeyword = (!empty($eid) ? ($Row_plans['varMetaKeyword']) : '');
                $val_metadescription = (!empty($eid) ? ($Row_plans['varMetaDescription']) : '');
                $param = array("varMetaTitle" => $val_metatitle, "varMetaKeyword" => $val_metakeyword, "varMetaDescription" => $val_metadescription);
                echo $this->mylibrary->seo_textdetails($param, '', $this->module_url, 'Frmplans');
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
                        'checked' => ($Row_plans['chrPublish'] == 'Y') ? TRUE : FALSE
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
                           'checked' => ($Row_plans['chrPublish'] == 'N') ? TRUE : FALSE
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