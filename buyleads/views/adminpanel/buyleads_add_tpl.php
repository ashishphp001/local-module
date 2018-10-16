<style>
    .gallery_grid_item img, .gallery_grid_item > a{
        display:unset !important;
    }    
    .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
        width: 15%;
    }
</style>


<script>
    function approvaldiv(result)
    {
        if (result == 'Y') {
            var name = "Approved";
        } else {
            var name = "Disable";
        }
        UIkit.modal.confirm('Caution! This buylead will be ' + name + '. Press OK to confirm.', function () {

            var Eid = document.getElementById("ehintglcode").value;

            $.ajax({
                type: 'POST',
                data: {"csrf_indibizz": csrfHash, 'chrPublish': result, "Eid": Eid},
                url: '<?php echo ADMINPANEL_URL . 'buyleads/approve_buylead/'; ?>',
                success: function (Result) {
                    location.reload();
                }
            });


        });
    }

    window.onload = function () {

        //Check File API support
        if (window.File && window.FileList && window.FileReader)
        {
            var filesInput = document.getElementById("files");

            filesInput.addEventListener("change", function (event) {

                var files = event.target.files; //FileList object
                var output = document.getElementById("result");

                for (var i = 0; i < files.length; i++)
                {
                    var file = files[i];
                    var ext1 = file.name.substr(-4);
//                    alert(ext1);
                    var picReader = new FileReader();
//                    picReader.addEventListener("load", function (event) {
                    var picFile = event.target;
                    var div = document.createElement("span");
                    var getimg = "";
                    getimg = addExtensionClass(ext1);
//                    alert(getimg);
                    div.innerHTML = "<span class=\"pip\"><div class=\"md-card md-card-hover\">\n\
                <div class=\"gallery_grid_item md-card-content\">\n\
                    <img src='" + site_path + "front-media/images/" + getimg + "'" +
                            " title='" + file.name + "'/></div></div></div>";
                    output.insertBefore(div, null);
//                    });

                    picReader.readAsDataURL(file);
                }

            });
        } else
        {
            console.log("Your browser does not support File API");
        }
    }


    function addExtensionClass(extension) {
//            alert(extension);
        switch (extension) {
            case '.doc':
                return "icon/doc-icon.png";
            case 'docx':
                return "icon/docx.png";
            case '.xls':
                return "icon/xls.png";
            case 'xlsx':
                return "icon/excel-icon.png";
            case '.csv':
                return "icon/excel-icon.png";
            case '.pdf':
                return "icon/pdf-icon.png";
            case '.zip':
                return "icon/zip-icon.png";
            case '.ppt':
                return "icon/ppt.png";
            case 'pptx':
                return "icon/pptx.png";
            case '.rar':
                return "icon/rar.png";
            default:
                return "default-file";
        }
    }


</script>

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
        var Title = document.getElementById("varName").value + " - Buy Lead";
        var Title1 = Title;
        var Meta_keyword = Title;
        document.getElementById("varMetaTitle").value = Title1;
        document.getElementById("varMetaKeyword").value = Meta_keyword;
        CountLeft(document.Frmbuyleads.varMetaTitle, document.Frmbuyleads.metatitle_left, 200);
        CountLeft(document.Frmbuyleads.varMetaKeyword, document.Frmbuyleads.metakeyword_left, 200);
    }

    function generate_seocontent(flag) {
        var title = trim(document.getElementById('varName').value) + " - Buy Lead";
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
        CountLeft(document.Frmbuyleads.varMetaTitle, document.Frmbuyleads.metatitle_left, 200);
        CountLeft(document.Frmbuyleads.varMetaDescription, document.Frmbuyleads.metadescription_left, 400);
        CountLeft(document.Frmbuyleads.varMetaKeyword, document.Frmbuyleads.metakeyword_left, 400);
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
            CountLeft(document.Frmbuyleads.varMetaTitle, document.Frmbuyleads.metatitle_left, 200);
            CountLeft(document.Frmbuyleads.varMetaDescription, document.Frmbuyleads.metadescription_left, 400);
            CountLeft(document.Frmbuyleads.varMetaKeyword, document.Frmbuyleads.metakeyword_left, 400);
        });
<?php } ?>
    $(document).ready(function ()
    {
        $('#varAlias').bind("cut copy paste", function (e)
        {
            e.prbuyleadsDefault();
        });
        $('#varName').keypress(function (buyleads)
        {
            var keycode = (buyleads.keyCode ? buyleads.keyCode : buyleads.which);
            if (keycode == '13')
            {
                $('#varName').blur();
            }
        });
    });
    function quickedit(Action)
    {
        var url = "<?php echo SITE_PATH ?>" + $("#varAlias").val() + "-buylead";
            Quick_Edit_Alias_Ajax(Action, url, 'varName', encodeURIComponent('<?php echo $eid ?>'), encodeURIComponent('<?php echo MODULE_ID ?>'), '<?php echo COMMON_ALIAS_EXISTS_MSG ?>');
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

        $.validator.addMethod("Chk_Image_Size", function (buyleads, value) {
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
        $("#Frmbuyleads").validate({
            ignore: [],
            rules: {
                intUser: {
                    required: true
                },
                varAlias: {
                    required:<?php echo ($alias_validation) ? 'true' : 'false'; ?>,
                    minlength: 2
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
//                varQuantity: {
//                    required: {
//                        depends: function () {
//                            if ($("#chrQuantity").is(":checked")) {
//                                return true;
//                            } else {
//                                return false;
//                            }
//                        }
//                    }
//                },
//                intUnit: {
//                    required: {
//                        depends: function () {
//                            if ($("#chrQuantity").is(":checked")) {
//                                return true;
//                            } else {
//                                return false;
//                            }
//                        }
//                    }
//                },
//                varStartPrice: {
//                    required: {
//                        depends: function () {
//                            if ($("#chrApproxOrder").is(":checked")) {
//                                return true;
//                            } else {
//                                return false;
//                            }
//                        }
//                    },
//                    greaterThanEnd: true
//                },
//                varEndPrice: {
//                    required: {
//                        depends: function () {
//                            if ($("#chrApproxOrder").is(":checked")) {
//                                return true;
//                            } else {
//                                return false;
//                            }
//                        }
//                    }
//                },
//                varLocation: {
//                    required: true
//                },
                varDays: {
                    required: {
                        depends: function () {
                            if ($("#chrDaysRequirement").is(":checked")) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                varImage: {
                    accept: "jpg,png,jpeg,gif",
//                    required: {
//                        depends: function () {
//                            if ($("#hidd_VarImage").val() == '' && $("#varImage").val() == '')
//                            {
//                                return true;
//                            } else {
//                                return false;
//                            }
//<?php // if ($eid != '') { ?>
//                                if ($("#hidd_VarImage").val() != '' && $("#varImage").val() == '')
//                                {
//                                    return true;
//                                } else
//                                {
//                                    return false;
//                                }
//<?php // } ?>
//                        }
//                    },
                    system_image_validation: true,
                    Chk_Image_Size: true
                }
            },
            messages: {
                intUser: {
                    required: "Please select customer."
                },
                varAlias: {
                    required: '<div class="uk-text-danger"><?php echo COMMON_ALIAS_MSG ?></div>',
                    minlength: "<div class='uk-text-danger'>" + ALIAS_LIMIT + "</div>"
                },
                varName: {
                    required: "Please enter product name."
                },
                intParentCategory: {
                    required: "Please select industry type."
                },
//                varReqType: {
//                    required: "Please select requirement type."
//                },
//                varStartPrice: {
//                    required: "Please enter start price."
//                },
//                varEndPrice: {
//                    required: "Please enter end price."
//                },
//                varLocation: {
//                    required: "Please enter location."
//                },
                varDays: {
                    required: "Please enter days."
                },
//                intUnit: {
//                    required: "Please select unit type."
//                },
//                varQuantity: {
//                    required: "Please enter quantity."
//                },
                varImage: {
                    required: "Please select buylead image.",
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
                <li><a href="<?php echo MODULE_PAGE_NAME; ?>">Manage Buy Leads</a></li>
                <li><span> <?php
                        $title1 = $Row_buyleads['varName'];
                        if (strlen($title1) > 80) {
                            $title = substr($Row_buyleads['varName'], 0, 80) . "...";
                        } else {
                            $title = $Row_buyleads['varName'];
                        }
                        if (!empty($eid)) {
                            echo 'Edit Buy Lead - ' . $title;
                        } else {
                            echo 'Add Buy Lead';
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
        $attributes = array('name' => 'Frmbuyleads', 'id' => 'Frmbuyleads', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
        if ($edit_record) {
            echo form_open($action, $attributes);
        }
        ?>

        <?php
        echo form_hidden('btnsaveandc_x', '');
        echo form_hidden('varImageHidden', $Row_buyleads['varImage']);
        if (!empty($eid)) {
            echo form_hidden('ehintglcode', $eid);
            echo form_hidden('Alias_Id', $Row_buyleads['Alias_Id']);
            echo form_hidden('eid', $Row_buyleads['int_id']);
            echo form_hidden('Hid_varAlias', $Row_buyleads['varAlias']);
        }
        echo form_hidden('hidd_VarImage', $Row_buyleads['varImage']);
        echo form_hidden('hidd_ImageFlag', $flag);

        if (ADMIN_ID != 1) {
            $style = 'style="display: none"';
        }
        ?>     

        <div class="md-card">
            <div class="md-card-content">
                <div class="field uk-file-upload">
                    <!--<h3>Upload  images</h3>-->
                    <div class="uk-form-file md-btn ">
                        Upload Files
                        <input id="files" multiple name="files[]" type="file"   accept=".pdf, .doc, .docx, .xls, .xlsx, .ppt">
                    </div>
                    <div class="gallery_grid uk-grid-width-medium-1-4 uk-grid-width-large-1-5" id='result' >

                    </div>



                    <?php
                    if (!empty($eid)) {
                        $DocArr = $this->Module_Model->getBuyLeadDoc($eid);
//                        print_R($DocArr);
                        foreach ($DocArr as $Row) {
                            $file = $Row['varFile'];
                            $thumb = 'upimages/buyleads/file/' . $file;
                            $fileexntension = substr(strrchr($Row['varFile'], '.'), 1);
                            $filetolowwer = strtolower($fileexntension);
//                            echo $filetolowwer;
                            $p = explode('.', $Row['varFile']);
                            if ($filetolowwer == 'doc' || $filetolowwer == 'DOC' || $filetolowwer == 'docx' || $filetolowwer == 'DOCX') {
                                $t = 'images/icon/doc-icon.png';
                            } else if ($filetolowwer == 'zip' || $filetolowwer == 'rar') {
                                $t = 'images/icon/zip-icon.png';
                            } else if ($filetolowwer == 'xls' || $filetolowwer == 'xlsx' || $filetolowwer == 'csv') {
                                $t = "images/icon/excel-icon.png";
                            } else {
                                $t = 'images/icon/pdf-icon.png';
                            }
                            ?>
                            <span class="pip">
                                <div>
                                    <div class="md-card md-card-hover">
                                        <div class="gallery_grid_item md-card-content">
                                            <!--<i class="removes md-icon material-icons" style="float:right;">highlight_off</i>-->
                                            <a href="<?php echo MODULE_PAGE_NAME; ?>/download?file=<?= $Row['varFile'] ?>" target="_blank">
                                                <img src="<?php echo FRONT_MEDIA_URL . $t ?>" alt="<?php echo $photo['varName']; ?>">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </span>
                            <?php
                        }
                    }
                    ?>

                    <div class="uk-form-help-block">
                        <span class="spannote">Upload image file of format only *.pdf, *.doc, *.docx, .csv, *.xls, *.xlsx, *.ppt or *.zip Having maximum size of 5MB.</span> 
                    </div>   


                </div>
            </div>
        </div>
        <div class="md-card">
            <div class="md-card-content">

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
                                        'value' => $Row_buyleads['varName'],
                                        'onblur' => ($alias_validation) ? "Auto_Alias('" . $EditAlias . "',this.id,'" . base64_encode($eid) . "','" . base64_encode(MODULE_ID) . "','N');" : "",
                                        'class' => 'uk-width-1-1'
                                    );
                                } else {
                                    $EditAlias = "N";
                                    $titleBoxdata = array(
                                        'name' => 'varName',
                                        'id' => 'varName',
                                        'value' => $Row_buyleads['varName'],
                                        'onblur' => ($alias_validation) ? "Auto_Alias('" . $EditAlias . "',this.id,'" . base64_encode($eid) . "','" . base64_encode(MODULE_ID) . "','N');" : "",
                                        'onkeyup' => 'getchanged()',
                                        'class' => 'uk-width-1-1'
                                    );
                                }

                                echo form_input($titleBoxdata);
                                ?>

                                <!--<input id="varName" onkeyup="getchanged();" name='varName' value="<?php echo $Row_buyleads['varName']; ?>" class="uk-width-1-1" />-->
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
                            'value' => set_value('varAlias', $Row_buyleads['varAlias']),
                            "linkServices" => 'onclick="CheckingAlias(\'varAlias\',\'' . base64_encode($Row_buyleads['varAlias']) . '\',\'' . base64_encode(MODULE_ID) . '\',\'' . MODULE . '\')"',
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
                    $value = (!empty($eid) ? $Row_buyleads['txtDescription'] : '');
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
                                $checked = ($Row_buyleads['chrQuantity'] == 'Y') ? "checked" : "";
                            }
                            ?>
                            <label for="chrQuantity" onclick="update_qunatity()" class="inline-label">Display in Quantity</label>
                            <input <?php echo $checked; ?>  type="checkbox" name="chrQuantity" onclick="update_qunatity()" id="chrQuantity" />
                        </div>
                        <!--<span id="quantity_div">-->
                        <div class="uk-width-small-1-4" id="quantity_div1">
                            <label>Quantity *</label>
                            <?php
                            $QuantityBoxdata = array(
                                'name' => 'varQuantity',
                                'id' => 'varQuantity',
                                'value' => $Row_buyleads['varQuantity'],
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
                                $checked = ($Row_buyleads['chrApproxOrder'] == 'Y') ? "checked" : "";
                            }
                            ?>
                            <label for="chrApproxOrder" onclick="update_approx_order()" class="inline-label">Display Approx Order</label>
                            <input <?php echo $checked; ?>  type="checkbox" name="chrApproxOrder" onclick="update_approx_order()" id="chrApproxOrder" />
                        </div>
                        <div class="uk-width-small-1-4" id="approx_order_div1">
                            <label>Currency *</label>
                            <?php
                            if ($Row_buyleads['varApproxCurrency'] == '2') {
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

                                <input id="varStartPrice" name='varStartPrice' type="number" class="uk-form-width-medium" value="<?php echo $Row_buyleads['varStartPrice']; ?>" min="0" />
                                -
                                <input id="varEndPrice" name='varEndPrice' type="number" class="uk-form-width-medium" value="<?php echo $Row_buyleads['varEndPrice']; ?>" min="0" />
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
                            <input type="radio" name="chrRequirement" id="chrUrgentRequirement" <?php echo $checked = $Row_buyleads['chrRequirement'] == 'U' ? 'checked' : 'checked'; ?> value="U" onclick="showDays();" />
                            <label for="chrUrgentRequirement" class="inline-label">Urgent</label>
                            <input type="radio" name="chrRequirement" id="chrDaysRequirement" <?php echo $checked = $Row_buyleads['chrRequirement'] == 'D' ? 'checked' : ''; ?> value="D" onclick="showDays();" />
                            <label for="chrDaysRequirement" class="inline-label">With in Days</label>

                        </div>
                    </div>
                </div>
                <!--<div class="uk-form-row">-->
                <!--<div class="uk-grid">-->
                <div class="uk-width-small-1-2"  id='showDaysDiv'>
                    <label>Days *</label>
                    <?php
                    $daysBoxdata = array(
                        'name' => 'varDays',
                        'id' => 'varDays',
                        'value' => $Row_buyleads['varDays'],
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
                                if ($Row_buyleads['chrImageFlag'] == 'S') {
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
                        Upload Buy Lead Image
                        <input id="varImage" name="varImage" type="file">
                    </div>
                    <div class="clear"></div>
                    <label class="error" for="varImage"></label>
                    <?php
                    $ImagePath = 'upimages/buyleads/images/' . $Row_buyleads['varImage'];
                    if (file_exists($ImagePath) && $Row_buyleads['varImage'] != '') {
                        $image_thumb = image_thumb($ImagePath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                        $image_detail_thumb = image_thumb($ImagePath, BUY_LEADS_WIDTH, BUY_LEADS_HEIGHT);
                    }
                    if (!empty($eid)) {
                        if (file_exists($ImagePath)) {
                            ?>
                            <?php
                            $ImageName = $Row_buyleads['varImage'];
                            if ($ImageName != "") {
                                ?>                               
                                <?php
                                $disp_div .= "<div class=\"gallery_grid_item md-card-content\" id=\"divdelbro\" >&nbsp;&nbsp;
                                                      <a href=\"" . $image_detail_thumb . "\" data-uk-lightbox=\"{group:'gallery'}\">
                                                            <img src=\"" . $image_thumb . "\" />
                                                      </a><a href=\"javascript:;\" onclick=\"delete_image('" . $Row_buyleads['int_id'] . "','" . $Row_buyleads['varImage'] . "',1);\"><div class=\"md-btn md-btn-wave\">Delete</div></a>
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
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-3">
                            <label > Location 1*</label>
                            <?php
                            $companyBoxdata = array(
                                'name' => 'varLocation',
                                'id' => 'varLocation',
                                'value' => $Row_buyleads['varLocation'],
                                'class' => 'md-input label-fixed'
                            );
                            echo form_input($companyBoxdata);
                            ?>
                            <label class="error" for="varLocation"></label>
                        </div>
                        <div class="uk-width-medium-1-3">
                            <label > Location 2*</label>
                            <?php
                            $varLocation2Boxdata = array(
                                'name' => 'varLocation2',
                                'id' => 'varLocation2',
                                'value' => $Row_buyleads['varLocation2'],
                                'class' => 'md-input label-fixed'
                            );
                            echo form_input($varLocation2Boxdata);
                            ?>
                            <label class="error" for="varLocation2"></label>
                        </div>
                        <div class="uk-width-medium-1-3">
                            <label > Location 3*</label>
                            <?php
                            $varLocation3Boxdata = array(
                                'name' => 'varLocation3',
                                'id' => 'varLocation3',
                                'value' => $Row_buyleads['varLocation3'],
                                'class' => 'md-input label-fixed'
                            );
                            echo form_input($varLocation3Boxdata);
                            ?>
                            <label class="error" for="varLocation3"></label>
                        </div>

                        <input  type="hidden" name="varLatitude" id="varLatitude" value="<?php echo $Row_buyleads['varLatitude']; ?>" >
                        <input type="hidden"  name="varLongitude" id="varLongitude" value="<?php echo $Row_buyleads['varLongitude']; ?>">
                        <input  type="hidden" name="varLatitude2" id="varLatitude2" value="<?php echo $Row_buyleads['varLatitude2']; ?>">
                        <input type="hidden"  name="varLongitude2" id="varLongitude2" value="<?php echo $Row_buyleads['varLongitude2']; ?>">
                        <input  type="hidden" name="varLatitude3" id="varLatitude3" value="<?php echo $Row_buyleads['varLatitude3']; ?>">
                        <input type="hidden"  name="varLongitude3" id="varLongitude3" value="<?php echo $Row_buyleads['varLongitude3']; ?>">


                    </div> 
                </div>


            </div>
            <div class="clear"></div>
        </div>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-large">
                        <label for="varBusinessType" class="uk-form-label">Preferred Supplier Type</label>
                        <?php echo $getBusinessType; ?>
                        <label class="error" for="varBusinessType"></label>
                    </div>
                </div>
                <div class='spacer10'></div>
                <div class="uk-form-row">
                    <div class="uk-width-medium-1-2">
                        <label> Packaging</label>
                        <?php
                        $PackageBoxdata = array(
                            'name' => 'varPackaging',
                            'id' => 'varPackaging',
                            'value' => $Row_buyleads['varPackaging'],
                            'class' => 'md-input'
                        );
                        echo form_input($PackageBoxdata);
                        ?>
                        <label class="error" for="varPackaging"></label>
                    </div>
                </div>

                <div class="uk-form-row">
                    <div class="uk-grid">
                        <div class="uk-width-small-1-3">
                            <label>Currency</label>
                            <?php
                            if ($Row_buyleads['varCurrency'] == '2') {
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
                            <label>Expected Price</label>
                            <?php
                            $Expectedprice = array(
                                'name' => 'varExpectedPrice',
                                'id' => 'varExpectedPrice',
                                'value' => $Row_buyleads['varExpectedPrice'],
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
                        <div class="uk-width-medium-1-2">
                            <label>Destination Port *</label>
                            <?php
                            $Destinationdata = array(
                                'name' => 'varDestination',
                                'id' => 'varDestination',
                                'value' => $Row_buyleads['varDestination'],
                                'class' => 'md-input'
                            );
                            echo form_input($Destinationdata);
                            ?>
                            <label class="error" for="varDestination"></label>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <label>Want to Import: </label>
                            <input type="radio" name="chrImport" id="chrYImport" <?php echo $checked = $Row_buyleads['chrImport'] == 'Y' ? 'checked' : 'checked'; ?> value="Y"/>
                            <label for="chrYImport" class="inline-label">Yes</label>
                            <input type="radio" name="chrImport" id="chrNImport" <?php echo $checked = $Row_buyleads['chrImport'] == 'N' ? 'checked' : ''; ?> value="N"/>
                            <label for="chrNImport" class="inline-label">No</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                $val_metatitle = (!empty($eid) ? ($Row_buyleads['varMetaTitle']) : '');
                $val_metakeyword = (!empty($eid) ? ($Row_buyleads['varMetaKeyword']) : '');
                $val_metadescription = (!empty($eid) ? ($Row_buyleads['varMetaDescription']) : '');
                $param = array("varMetaTitle" => $val_metatitle, "varMetaKeyword" => $val_metakeyword, "varMetaDescription" => $val_metadescription);
                echo $this->mylibrary->seo_textdetails($param, '', $this->module_url, 'Frmbuyleads');
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
                    <label>Approve</label> 
                    <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: Please select 'Yes' if you want to display / activate this record. Otherwise please select 'NO'"; ?>">help</i></div>

                <?php
                if (!empty($eid)) {
                    $publishYRadio = array(
                        'name' => 'chrPublish',
                        'id' => 'chrPublishY',
                        'value' => 'Y',
                        'class' => 'form-rediobutton',
                        'checked' => ($Row_buyleads['chrPublish'] == 'Y') ? TRUE : FALSE
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
                           'checked' => ($Row_buyleads['chrPublish'] == 'N') ? TRUE : FALSE
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

<script>
    // This example displays an address form, using the autocomplete feature
    // of the Google Places API to help users fill in the information.

    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

    var placeSearch, autocomplete;
    var componentForm = {
        //        street_number: 'short_name',
        //        route: 'long_name',
        //        locality: 'long_name',
        //        administrative_area_level_1: 'long_name',
        //        country: 'long_name',
        //        postal_code: 'long_name'
    };
    function initAutocomplete() {
        var input = document.getElementById('varLocation');
        var opts = {
            types: ['(cities)']
        };
        autocomplete = new google.maps.places.Autocomplete(input, opts);
        autocomplete.addListener('place_changed', fillInAddress1);


        var input1 = document.getElementById('varLocation2');
        var opts1 = {
            types: ['(cities)']
        };
        autocomplete1 = new google.maps.places.Autocomplete(input1, opts1);
        autocomplete1.addListener('place_changed', fillInAddress2);

        var input2 = document.getElementById('varLocation3');
        var opts2 = {
            types: ['(cities)']
        };
        autocomplete2 = new google.maps.places.Autocomplete(input2, opts2);
        autocomplete2.addListener('place_changed', fillInAddress3);
    }

    function fillInAddress1() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
        document.getElementById("varLatitude").value = place.geometry.location.lat();
        document.getElementById("varLongitude").value = place.geometry.location.lng();
        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding md-input on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
    }

    function fillInAddress2() {
        // Get the place details from the autocomplete object.
        var place = autocomplete1.getPlace();
        document.getElementById("varLatitude2").value = place.geometry.location.lat();
        document.getElementById("varLongitude2").value = place.geometry.location.lng();
        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding md-input on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
    }
    function fillInAddress3() {
        // Get the place details from the autocomplete object.
        var place = autocomplete2.getPlace();
        document.getElementById("varLatitude3").value = place.geometry.location.lat();
        document.getElementById("varLongitude3").value = place.geometry.location.lng();
        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding md-input on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
    }


</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY; ?>&libraries=places&callback=initAutocomplete&region=in" async defer></script>
<?php
if (!empty($eid)) {
    if (($permissionArry['Approve'] == 'Y')) {
        if ($Row_buyleads['chrPublish'] == 'N') {
            ?>
            <div class="md-fab-wrapper">
                <a onclick="return approvaldiv('Y');" title="Click here to approve this buylead." class="md-fab md-fab-success" href="javascript:;" >
                    <i class="material-icons">check_circle</i>
                </a>
            </div>
        <?php } else { ?>
            <div class="md-fab-wrapper">
                <a onclick="return approvaldiv('N');" title="Click here to disable this buylead." class="md-fab md-fab-danger" href="javascript:;">
                    <i class="material-icons">highlight_off</i>
                </a>
            </div> 
            <?php
        }
    }
}
?>
