<style>
    .uk-grid-width-medium-1-4 > * {
        width: 16%;
        float: left !important;
        position: inherit !important;
        left: inherit !important;
        top: inherit !important;
    }

    input[type="file"] {
        display: block;
    }
    .imageThumb {
        border: 2px solid;
        padding: 1px;
        cursor: pointer;
    }
    .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
    }
    .remove:hover {
        background: white;
        color: black;
    }
    .gallery_grid_item.md-card-content {
        width: 120px;
    }
</style>
<script type="text/javascript">

    function removefile(name) {
        document.getElementById('tmpimage').value = name + "," + document.getElementById('tmpimage').value;
        var divsToHide = document.getElementsByClassName("pips" + name); //divsToHide is an array
        for (var i = 0; i < divsToHide.length; i++) {
            divsToHide[i].style.visibility = "hidden"; // or
            divsToHide[i].style.display = "none"; // depending on what you're doing
        }
    }


    $(document).ready(function () {
        var j = 0;
        if (window.File && window.FileList && window.FileReader) {
            $("#varImages").on("change", function (e) {
                var files = e.target.files,
                        filesLength = files.length;

                var selection = document.getElementById('varImages');
                var file_length = selection.files.length;
                var FIVE_MB = Math.round(1024 * 1024 * 5);
                if (file_length > 5) {
                    alert('Sorry! you reached maximum limit, Please upload up to 5 image only');
                    return false;
                }

                for (var i = 0; i < selection.files.length; i++) {
                    var ext1 = selection.files[i].name.substr(-4);
                    var ext = ext1.toLowerCase();
                    var file = selection.files[i].size;
                    //image upload validation
                    var file_length = selection.files.length;
                    var FIVE_MB = Math.round(1024 * 1024 * 5);
                    if (file_length > 5) {
                        alert('Sorry! you reached maximum limit, Please upload up to 5 image only');
                        return false;
                    }
                    if (file > FIVE_MB) {
                        alert('Sorry! you reached maximum limit, Please upload up to 5 MB only');
                        return false;
                    }
                    //image end
                    if (ext !== ".jpg" && ext !== "jpeg" && ext !== ".png" && ext !== ".gif") {
                        alert('Only image files (JPG, JPEG, GIF, PNG) are allowed.');
                        return false;
                    }
                }

                for (var i = 0; i < filesLength; i++) {
                    var f = files[i];
                    var fileReader = new FileReader();

                    fileReader.onload = (function (e) {
                        var file = e.target;
                        $('<span class=\"pip\"><div class="md-card md-card-hover">\n\
                <div class="gallery_grid_item md-card-content">\n\
                    <i class="remove md-icon material-icons" onclick=\'return removefile("' + j + '")\' style="float:right;">highlight_off</i>\n\
                    <img src="' + e.target.result + '" alt="' + file.name + '"></a>\n\
                    </div>\n\
                    </div>').insertAfter("#productimages");

                        $(".remove").click(function () {
                            $(this).parent(".pip").remove();
                        });
                        j++;
                    });

                    fileReader.readAsDataURL(f);
                }

            });
        } else {
            alert("Your browser doesn't support to File API")
        }
    });

    function delete_bro()
    {
        UIkit.modal.confirm('Caution! This brochure will be deleted. Press OK to confirm.', function () {


            document.getElementById('divdelbrochure').innerHTML = '';
            document.getElementById('hidd_VarBrochure').value = '';
//            alert('Brochure is deleted successfully');
        });
    }


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
                data: {"csrf_indibizz": csrfHash, 'chrPublish': result, "Eid": Eid},
                url: '<?php echo ADMINPANEL_URL . 'product/approve_product/'; ?>',
                success: function (Result) {
                    location.reload();
                }
            });


        });
    }
    function featuresupdate()
    {
        var features = document.getElementById('chrFeaturesDisplay').checked;
        if (features == 1) {
            document.getElementById('varFeaturesdiv').style.display = '';
        } else {
            document.getElementById('varFeaturesdiv').style.display = 'none';
        }
    }

    function getchanged()
    {
        var Title = document.getElementById("varName").value;
        var Title1 = Title;
        var Meta_keyword = Title;
        document.getElementById("varMetaTitle").value = Title1;
        document.getElementById("varMetaKeyword").value = Meta_keyword;
        CountLeft(document.FrmProduct.varMetaTitle, document.FrmProduct.metatitle_left, 200);
        CountLeft(document.FrmProduct.varMetaDescription, document.FrmProduct.metadescription_left, 400);
        CountLeft(document.FrmProduct.varMetaKeyword, document.FrmProduct.metakeyword_left, 200);
    }

    function delete_image(name) {
        var url = "<?php echo ADMINPANEL_URL . 'product/delete_image_by_name?imagename='; ?>" + name;
        $.ajax({
            type: "GET",
            url: encodeURI(url),
            async: true,
            success: function (data) {
            }
        });
    }
    function generate_seocontent(flag) {
        var title = trim(document.getElementById('varName').value);
        var abcd1 = CKEDITOR.instances.txtDescription.getData();
        if (abcd1 == '')
        {
            var abcd = document.getElementById('varName').value;
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
        CountLeft(document.FrmProduct.varMetaTitle, document.FrmProduct.metatitle_left, 200);
        CountLeft(document.FrmProduct.varMetaDescription, document.FrmProduct.metadescription_left, 400);
        CountLeft(document.FrmProduct.varMetaKeyword, document.FrmProduct.metakeyword_left, 400);
    }

<?php if (!empty($eid) && $edit_record) { ?>
        $(document).ready(function ()
        {
            CountLeft(document.FrmProduct.varMetaTitle, document.FrmProduct.metatitle_left, 200);
            CountLeft(document.FrmProduct.varMetaDescription, document.FrmProduct.metadescription_left, 400);
            CountLeft(document.FrmProduct.varMetaKeyword, document.FrmProduct.metakeyword_left, 400);
        });
<?php } ?>

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

        if (document.getElementById('chrFeaturesDisplay').checked == true)
        {
            document.getElementById('varFeaturesdiv').style.display = '';
        }

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
        $.validator.addMethod("Chk_File_Size", function (product, value) {
            var flag = true;
            var selection = document.getElementById('varBrochure');
            for (var i = 0; i < selection.files.length; i++) {
                var file = selection.files[i].size;
                var FIVE_MB = Math.round(1024 * 1024 * 5);
                if (file > FIVE_MB) {
                    flag = false;
                }
            }
            return flag;
        }, 'Upload brochure having maximum size of 5MB.');
        if (document.getElementById('chrFeaturesDisplay').checked == true)
        {
            document.getElementById('varFeaturesdiv').style.display = '';
        } else {
            document.getElementById('varFeaturesdiv').style.display = 'none';
        }

        $('#FrmProduct').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
        $.validator.addMethod("alphanumeric", function (value, element) {
            if (value.replace(/[^A-Z]/gi, "").length >= 2) {
                return true;
            } else if (value.replace(/[^0-9]/gi, "").length >= 2) {
                return true;
            } else {
                return false;
            }
        }, "Please enter valid product name.");
        $(":hidden").addClass("ignore");
        $("#FrmProduct").validate({
            ignore: [],
            rules: {
                varName: {
                    required: true,
                    alphanumeric: true
                },
                varAlias: {
                    required: true
                },
                intSupplier: {
                    required: true
                },
                varCurrency: {
                    required: true
                },
                intParentCategory: {
                    required: true
                },
//                varPrice: {
//                    required: true
//                },
//                varUnit: {
//                    required: true
//                },
//                intPriceUnit: {
//                    required: true
//                },
//                varMOQ: {
//                    required: true
//                },
//                intMOQUnit: {
//                    required: true
//                },
                varBrochure: {
                    accept: "jpg,png,jpeg,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,csv",
                    Chk_File_Size: true
                },
//                varKeyword: {
//                    required: true
//                }
            },
            messages: {
                varName: {
                    required: "Please enter product name"
                },
                varAlias: {
                    required: "Please enter alias."
                },
                varCurrency: {
                    required: "Please select currency."
                },
                intParentCategory: {
                    required: "Please select product category."
                },
//                varPrice: {
//                    required: "Please enter price."
//                },
                intSupplier: {
                    required: "Please select supplier."
                },
//                varUnit: {
//                    required: "Please select unit."
//                },
//                intMOQUnit: {
//                    required: "Please select MOQ unit."
//                },
//                varMOQ: {
//                    required: "Please enter MOQ."
//                },
//                varKeyword: {
//                    required: "Please enter product keyword."
//                },
//                intPriceUnit: {
//                    required: "Please select price unit."
//                },
                varBrochure: {
                    required: "Please upload brochure.",
                    accept: "Only *.jpg, *.jpeg, *.png , *.gif, *.doc, *.docx, *.pdf, *.xls, *.xlsx, *.ppt, *.zip and *.pptx image formats are supported."
                }
            }
        });
    });</script>

<script type="text/javascript">

    function deletealbumphoto(photoID, intProject)
    {
        var intProject = document.getElementById('eid').value;
        UIkit.modal.confirm('Are you sure you want to delete this photo?', function () {
            var url = "../product/delete_photo/" + photoID + "/" + intProject;
            $.ajax({
                type: "GET",
                url: url,
                async: true,
                start: SetBackground(),
                success: function (data) {
//                    UIkit.modal.alert('Photo deleted successfully.');

//                    $(".removes")(function () {
//                        $(this).parent(".pip").remove();
//                    });
                    $('.pip' + photoID).hide();

                    return false;
                }
            });
        });
        return false;
    }

    $(document).ready(function ()
    {

        $('.add').click(function () {
            var counter = document.getElementById('file_hd').value;
            var counter1 = Number(counter) + 1;
            document.getElementById('file_hd').value = counter1;
            $("#adds").append('<div class="block">\n\
                <div class="uk-form-row">\n\
                    <div class="uk-grid" data-uk-grid-margin>\n\
                        <div class="uk-width-medium-2-5">\n\
                            <input type="text" name="varSTitle' + counter1 + '" id="varSTitle' + counter1 + '" value="" placeHolder="Title" maxlength="100" class="md-input" />\n\
                        </div>\n\
                        <div class="uk-width-medium-2-5">\n\
                            <input type="text" name="varSvalue' + counter1 + '" id="varSvalue' + counter1 + '" value="" placeHolder="Value" class="md-input"/>\n\
                        </div>\n\
                        <div class="uk-width-medium-1-5 remove">\n\
                            <a href="javascript:;" class="btnSectionRemove "><i class="material-icons md-24">delete</i></a>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
</div>');
        });
        $(document).on('click', '.remove', function () {
            $(this).parent('div').remove();
        });
    });
    function KeycheckOnlyNumeric(e)
    {
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

        if ((KeyID >= 97 && KeyID <= 122) || (KeyID >= 65 && KeyID <= 90) || (KeyID >= 33 && KeyID <= 39) || (KeyID == 42) || (KeyID >= 58 && KeyID <= 64) || (KeyID >= 91 && KeyID <= 96) || (KeyID >= 123 && KeyID <= 126))
        {
            return false;
        }
        return true;
    }

</script>

<?php
if ($permissionArry['Approve'] == 'Y') {
    if (ADMIN_ID != 1 && ADMIN_ID != 2) {
        ?>
        <script type="text/javascript">
            $(document).ready(function ()
            {
                $('.remove').remove();
            });
        </script>
        <?php
    }
}
?>


<div id="page_content_inner">
    <div id="page_content">
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                <li><a href="<?php echo MODULE_PAGE_NAME; ?>">Manage Products</a></li>
                <li><span>

                        <?php
                        $title1 = $Row_product['varName'];
                        if (strlen($title1) > 80) {
                            $title = substr($Row_product['varName'], 0, 80) . "...";
                        } else {
                            $title = $Row_product['varName'];
                        }
                        if (!empty($eid)) {
                            echo 'Edit Products - ' . $title;
                        } else {
                            echo 'Add Products';
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
        $attributes = array('name' => 'FrmProduct', 'id' => 'FrmProduct', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form uk-form-stacked');
        if ($edit_record) {
            echo form_open($action, $attributes);
        }
        ?>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                echo form_hidden('btnsaveandc_x', '');
                if (!empty($eid)) {
                    echo form_hidden('ehintglcode', $eid);
                    echo form_hidden('Alias_Id', $Row_product['Alias_Id']);
                    echo form_hidden('eid', $eid);
                    echo form_hidden('Hid_varAlias', $Row_product['varAlias']);

                    echo form_hidden('hidd_VarBrochure', $Row_product['varBrochure']);
                }
                if (ADMIN_ID != 1) {
                    $style = 'style="display: none"';
                }
                ?>     
                <input type="hidden" id="tmpimage" name="tmpimage">
                <div class="field uk-file-upload">
                    <!--<h3>Upload  images</h3>-->
                    <div class="uk-form-file md-btn ">
                        Upload Product Images
                        <input type="file" id="varImages" name="varImages[]" multiple>
                    </div>
                    <div class="gallery_grid uk-grid-width-medium-1-4 uk-grid-width-large-1-5" id='productimages' >

                    </div>
                    <div class="uk-form-help-block" id="upload_note" <?php echo $NoneNoteeDisplay; ?>>
                        <span class="spannote">Upload image file of format only *.jpg, *.jpeg, *.png or *.gif. Having maximum size of 5MB.
                            <br>(Recommended images is in square - Maximum Image Dimension 4000px X 4000px )</span> 
                    </div>   

                    <?php
                    if (!empty($eid)) {
                        $photosArr = $this->Module_Model->getPhotosByAlbum($eid);
                        foreach ($photosArr as $key => $photo) {
                            $photo_thumb = $photo['varImage'];
                            $thumb = 'upimages/productgallery/images/' . $photo_thumb;
                            if (file_exists($thumb) && $photo_thumb != '') {
                                $thumbphoto1 = image_thumb($thumb, PHOTOGALLERY_WIDTH, PHOTOGALLERY_HEIGHT);
                            }
                            ?>
                            <span class="<?php echo "pip pip" . $photo['int_id']; ?>">
                                <div>
                                    <div class="md-card md-card-hover">
                                        <div class="gallery_grid_item md-card-content">
                                            <i class="removes md-icon material-icons"  onclick="deletealbumphoto('<?= $photo['int_id'] ?>', '<?= $intProject ?>')" style="float:right;">highlight_off</i>
                                            <a href="<?php echo $thumbphoto1 ?>" data-uk-lightbox="{group:'gallery'}">
                                                <img src="<?php echo $thumbphoto1 ?>" alt="<?php echo $photo['varName']; ?>">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </span>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class='clear'></div>
        <hr>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-2-2">
                            <?php
                            echo $pagetree;
                            ?>
                            <label class="error" for="intParentCategory"></label>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-2-2">
                            <?php
                            echo $getSupplierList;
                            ?>
                            <label class="error" for="intSupplier"></label>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label>Product Name *</label>
                            <?php
                            if (!empty($eid)) {
                                $EditAlias = "Y";
                                $titleBoxdata = array(
                                    'name' => 'varName',
                                    'id' => 'varName',
                                    'value' => $Row_product['varName'],
                                    'onblur' => ($alias_validation) ? "Auto_Alias('" . $EditAlias . "',this.id,'" . base64_encode($eid) . "','" . base64_encode(MODULE_ID) . "','N');" : "",
                                    'class' => 'md-input'
                                );
                            } else {
                                $EditAlias = "N";
                                $titleBoxdata = array(
                                    'name' => 'varName',
                                    'id' => 'varName',
                                    'value' => $Row_product['varName'],
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
                            'value' => set_value('varAlias', $Row_product['varAlias']),
                            "linkEvent" => 'onclick="CheckingAlias(\'varAlias\',\'' . base64_encode($Row_product['varAlias']) . '\',\'' . base64_encode(MODULE_ID) . '\',\'' . MODULE . '\')"',
                            "eid" => $eid,
                            'class' => 'md-input'
                        );
                        echo $aliaText = $this->mylibrary->Alias_Textbox($param);
                        ?>
                    </div>
                <?php } ?>
                <div class="clear"></div> 

                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-2-2">
                            <label>Product Keyword </label>
                            <input  type="text" id="varKeyword" name="varKeyword"  class="md-input label-fixed" value="<?php echo $Row_product['varKeyword']; ?>" data-role="tagsinput" />
                            <label class="error" for="varKeyword"></label>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label>HS Code</label>
                            <input type="text" id="varHSCode" name="varHSCode" class="md-input" value="<?php echo $Row_product['varHSCode']; ?>" />
                            <label class="error" for="varHSCode"></label>
                        </div>
                    </div>
                </div>

                <div class="clear"></div> 
                <div class="uk-form-row">
                    <label>Description</label>
                    <?php
                    $value = (!empty($eid) ? $Row_product['txtDescription'] : '');
                    echo $this->mylibrary->load_ckeditor('txtDescription', $this->mylibrary->Replace_Varible_with_Sitepath($value), '100%', '200px', 'Basic');
                    ?>
                    <label class="error" for="txtDescription"></label>
                </div>
                <div class="spacer10"></div>
            </div>
        </div>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-form-row">    
                    <?php
//                    if (empty($eid)) {
//                        $checked = true;
//                    } else {
//                        $checked = ($Row_product['chrTradeSecurity'] == 'Y') ? "checked" : "";
//                    }
                    ?>
                    <label for="chrTradeSecurity" class="inline-label" >Trade Security *</label>
                    <?php
                    $chrTradeSecurityY = array('name' => 'chrTradeSecurity', 'id' => 'chrTradeSecurityY', 'value' => 'Y', 'checked' => $Row_product['chrTradeSecurity'] == 'Y' ? TRUE : FALSE, 'class' => 'form-rediobutton ignore');
                    $chrTradeSecurityN = array('name' => 'chrTradeSecurity', 'id' => 'chrTradeSecurityN', 'value' => 'N', 'checked' => $Row_product['chrTradeSecurity'] == 'N' || empty($eid) ? TRUE : FALSE, 'class' => 'form-rediobutton ignore');
                    ?>
                    <?php
                    echo form_radio($chrTradeSecurityY);
                    echo form_label('&nbsp;Yes&nbsp;', 'chrTradeSecurityY');
                    echo form_radio($chrTradeSecurityN);
                    echo form_label('&nbsp;No', 'chrTradeSecurityN');
                    ?>  
                </div>
                <div class="uk-form-row">    
                    <?php
                    if (empty($eid)) {
                        $checked = true;
                    } else {
                        $checked = ($Row_product['chrFeaturesDisplay'] == 'Y') ? "checked" : "";
                    }
                    ?>
                    <label for="chrFeaturesDisplay" class="inline-label" onclick="return featuresupdate()" >Display Features</label>
                    <input <?php echo $checked; ?> type="checkbox" onclick="return featuresupdate()" name="chrFeaturesDisplay" id="chrFeaturesDisplay" />
                    <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: Please select 'Yes' if you want to display features in website. Otherwise please select 'No'"; ?>">help</i>
                </div>
                <div class="uk-form-row" id="varFeaturesdiv">
                    <?php $varSvalue = explode("__", $Row_product['varSvalue']); ?>

                    <div class="label-name">
                        <label> Features</label>
                        <?php if (count($varSvalue) > 0) {
                            ?>
                            <div class="uk-width-medium add add-btn">
                                <span class="uk-input-group-addon">
                                    <a href="javascript:;" class="btnSectionClone"><i class="material-icons md-24">&#xE146;</i></a>
                                </span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="form-group">




                        <input type="hidden" name="file_hd" id="file_hd"  value="<?php echo count($varSvalue); ?>">
                        <?php
                        if ($eid != "") {
                            $varSvalue = explode("__", $Row_product['varSvalue']);
                            $varSTitle = explode("__", $Row_product['varSTitle']);
                            $t = 0;
                            $j = 1;
                            foreach ($varSvalue as $txt) {
                                ?>
                                <div class="fix_width">
                                    <div class="inquiry-form">
                                        <?php if ($t == 0) {
                                            ?>
                                            <div class="form-group">
                                                <div class="clear"></div>  
                                                <?php
                                            }
                                            ?>

                                            <div class="spacer10"></div>
                                            <div class="uk-form-row">
                                                <div class="uk-grid" data-uk-grid-margin>
                                                    <div class="uk-width-medium-2-5">
                                                        <?php
                                                        $ColornamVal = 'varSTitle' . $j . '';
                                                        $colorNameBoxdata = array(
                                                            'name' => $ColornamVal,
                                                            'id' => $ColornamVal,
                                                            'value' => $varSTitle[$t],
                                                            'placeHolder' => 'Title',
                                                            'class' => 'md-input'
                                                        );
                                                        echo form_input($colorNameBoxdata);
                                                        ?> 
                                                    </div>
                                                    <div class="uk-width-medium-2-5">
                                                        <?php
                                                        $namVal = 'varSvalue' . $j . '';
                                                        $colorBoxdata = array(
                                                            'name' => $namVal,
                                                            'id' => $namVal,
                                                            'value' => $txt,
                                                            'placeHolder' => 'Value',
                                                            'class' => 'md-input'
                                                        );
                                                        echo form_input($colorBoxdata);
                                                        ?> 
                                                    </div>
                                                    <?php if ($j != 1) { ?>
                                                        <div class="uk-width-medium-1-5 remove">
                                                            <a href="javascript:;" class="btnSectionRemove "><i class="material-icons md-24">delete</i></a>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <?php
                                            if ($t == 0) {
                                                ?>
                                            </div>   
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <?php
                                $t++;
                                $j++;
                            }
                        } else {
                            ?> 
                            <div class="block">
                                <div class="uk-form-row">
                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-2-5">
                                            <?php
                                            $colorNameBoxdata = array(
                                                'name' => 'varSTitle1',
                                                'id' => 'varSTitle1',
                                                'value' => set_value('varSTitle1', $Row_product['varSTitle1']),
                                                'placeHolder' => 'Title',
                                                'class' => 'md-input'
                                            );
                                            echo form_input($colorNameBoxdata);
                                            ?> 
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <?php
                                            $colorBoxdata = array(
                                                'name' => 'varSvalue1',
                                                'id' => 'varSvalue1',
                                                'value' => set_value('varSvalue1', $Row_product['varSvalue1']),
                                                'placeHolder' => 'Value',
                                                'class' => 'md-input'
                                            );
                                            echo form_input($colorBoxdata);
                                            ?> 
                                        </div>  
                                        <!--                                        <div class="uk-width-medium-1-5 add">
                                                                                    <span class="uk-input-group-addon">
                                                                                        <a href="javascript:;" class="btnSectionClone"><i class="material-icons md-24">&#xE146;</i></a>
                                                                                    </span>
                                                                                </div>-->
                                    </div>
                                </div>
                            </div>

                            <div class="spacer10"></div>
                            <?php
                        }
                        ?>
                        <span id="adds"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-small-1-3">
                            <label>Currency *</label>
                            <select class="md-input" id="varCurrency" name="varCurrency">
                                <?php
                                if ($Row_product['varCurrency'] == '2') {
                                    $sel1 = "";
                                    $sel2 = "selected='selected'";
                                } else {
                                    $sel1 = "selected='selected'";
                                    $sel2 = "";
                                }
                                ?>
                                <option value="1" <?php echo $sel1; ?>>&#8377;</option>
                                <option value="2" <?php echo $sel2; ?>>$</option>
                            </select>
                        </div>

                        <div class="uk-width-small-1-3">
                            <label>Price</label>
                            <?php
                            $unitData = array(
                                'name' => 'varPrice',
                                'id' => 'varPrice',
                                'value' => $Row_product['varPrice'],
                                'onkeypress' => 'return KeycheckOnlyNumeric(event);',
                                'class' => 'md-input'
                            );
                            echo form_input($unitData);
                            ?> 
                            <label class="error" for="varPrice"></label>
                        </div>

                        <div class="uk-width-small-1-3">
                            <label>Unit</label>
                            <?php echo $getPriceUnitData; ?>
                            <label class="error" for="intPriceUnit"></label>
                        </div>
                    </div>

                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-small-1-3">
                                <label>MOQ</label>
                                <?php
                                $moqData = array(
                                    'name' => 'varMOQ',
                                    'id' => 'varMOQ',
                                    'value' => $Row_product['varMOQ'],
                                    'class' => 'md-input'
                                );
                                echo form_input($moqData);
                                ?> 
                                <label class="error" for="varMOQ"></label>
                            </div>
                            <div class="uk-width-small-1-3">
                                <label>Unit</label>
                                <?php echo $getMOQUnitData; ?>
                                <label class="error" for="intMOQUnit"></label>
                            </div>
                            <div class="uk-width-medium-1-3">
                                <label> Free Sample :</label>
                                <?php
                                $chrSampleY = array('name' => 'chrSample', 'id' => 'chrSampleY', 'value' => 'Y', 'checked' => $Row_product['chrSample'] == 'Y' ? TRUE : FALSE, 'class' => 'form-rediobutton ignore');
                                $chrSampleN = array('name' => 'chrSample', 'id' => 'chrSampleN', 'value' => 'N', 'checked' => $Row_product['chrSample'] == 'N' || empty($eid) ? TRUE : FALSE, 'class' => 'form-rediobutton ignore');
                                ?>
                                <?php
                                echo form_radio($chrSampleY);
                                echo form_label('&nbsp;Yes&nbsp;', 'chrSampleY');
                                echo form_radio($chrSampleN);
                                echo form_label('&nbsp;No', 'chrSampleN');
                                ?>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <label>Model Number</label>
                                <?php
                                $modelData = array(
                                    'name' => 'varModelNo',
                                    'id' => 'varModelNo',
                                    'value' => $Row_product['varModelNo'],
                                    'class' => 'md-input'
                                );
                                echo form_input($modelData);
                                ?> 
                            </div>
                            <div class="uk-width-medium-1-2">
                                <label>Brand Name</label>
                                <?php
                                $modelData = array(
                                    'name' => 'varBrand',
                                    'id' => 'varBrand',
                                    'value' => $Row_product['varBrand'],
                                    'class' => 'md-input'
                                );
                                echo form_input($modelData);
                                ?> 
                            </div>

                        </div>
                    </div>
                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium">
                                <label>Material Type</label>
                                <input type="text" id="varMaterial" name="varMaterial" value="<?php echo $Row_product['varMaterial']; ?>" class="md-input label-fixed"  data-role="tagsinput" />
                                <label class="error" for="varMaterial"></label>
                            </div>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <div class="uk-grid"  data-uk-grid-margin>
                            <div class="uk-width-medium">
                                <label>Use Of Product</label>
                                <textarea cols="30" rows="4" id="varUse" name="varUse" class="md-input no_autosize"><?php echo $Row_product['varUse']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-small-1-3">
                                <label>Production Capacity</label>
                                <?php
                                $ProductionData = array(
                                    'name' => 'varProduction',
                                    'id' => 'varProduction',
                                    'value' => $Row_product['varProduction'],
                                    'class' => 'md-input'
                                );
                                echo form_input($ProductionData);
                                ?> 
                            </div>
                            <div class="uk-width-small-1-3">
                                <label>Unit</label>
                                <?php echo $getUnitData; ?>
                            </div>
                            <div class="uk-width-small-1-3">
                                <label>Time</label>
                                <?php echo $getTimeData; ?>
                            </div>

                        </div>
                    </div>
                    <div class="uk-form-row">
                        <div class="uk-grid">
                            <div class="uk-width-medium-1-2">
                                <label>Packing Detail</label>
                                <textarea cols="30" rows="4" id="varPacking" name="varPacking" class="md-input"><?php echo $Row_product['varPacking']; ?></textarea>
                                <label class="error" for="varPacking"></label>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <label>After Sales Service</label>
                                <textarea cols="30" rows="4" id="varService" name="varService" class="md-input"><?php echo $Row_product['varService']; ?></textarea>
                                <label class="error" for="varService"></label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-2-2">
                                <label>Delivery Terms: </label>
                                <?php
                                echo $getDeliveryTermsData;
                                ?> 
                            </div>
                        </div>
                    </div>
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
                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-2-2">
                                <label>Payment Type: </label>
                                <?php
                                echo $getPaymentTypeData;
                                ?> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-2-2">
                            <div class="uk-form-file md-btn md-btn-primary">
                                Upload Brochure
                                <input id="varBrochure" name="varBrochure" type="file">

                            </div>
                            <?php
                            if ($Row_product['varBrochure'] != '') {
                                $filepath = $Row_product['varBrochure'];
                                $filepath1 = 'upimages/product/brochure/' . $filepath;


                                $fileexntension = substr(strrchr($Row_product['varBrochure'], '.'), 1);
                                $filetolowwer = strtolower($fileexntension);
                                $p = explode('.', $Row_product['varBrochure']);
                                if ($filetolowwer == 'doc' || $filetolowwer == 'DOC' || $filetolowwer == 'docx' || $filetolowwer == 'DOCX') {
                                    $t = 'WORD.png';
                                } else if ($filetolowwer == 'zip' || $filetolowwer == 'rar') {
                                    $t = 'mime_zip.png';
                                } else if ($filetolowwer == 'ppt' || $filetolowwer == 'pptx') {
                                    $t = "ppt-icon.png";
                                } else if ($filetolowwer == 'xls' || $filetolowwer == 'xlsx') {
                                    $t = "xls-icon.png";
                                } else {
                                    $t = 'acrobate-readericon.png';
                                }
                                if (file_exists($filepath1)) {
                                    ?>
                                    <?php // echo MODULE_PAGE_NAME;    ?>
                                    <div id="divdelbrochure">
                                        &nbsp;&nbsp;<a href="<?php echo MODULE_PAGE_NAME; ?>/download?file=<?= $Row_product['varBrochure'] ?>">
                                            <img id="pdficon" height="16" width="16"  title="<?php echo htmlentities($Row_product['varBrochure']); ?>" src="<?= ADMIN_MEDIA_URL; ?>images/<?= $t ?>" style="vertical-align:middle;cursor:pointer;">
                                        </a>
                                        <a href="javascript:;" onclick="return delete_bro();"><div class="md-btn md-btn-wave">Delete</div></a>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <label class="error" for="varBrochure"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md-card">
            <div class="md-card-content">
                <?php
                $val_metatitle = (!empty($eid) ? ($Row_product['varMetaTitle']) : '');
                $val_metakeyword = (!empty($eid) ? ($Row_product['varMetaKeyword']) : '');
                $val_metadescription = (!empty($eid) ? ($Row_product['varMetaDescription']) : '');
                $param = array("varMetaTitle" => $val_metatitle, "varMetaKeyword" => $val_metakeyword, "varMetaDescription" => $val_metadescription);
                echo $this->mylibrary->seo_textdetails($param, '', $this->module_url, 'FrmProduct');
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
                    <input type="hidden" id="intDisplayOrder" name="intDisplayOrder" value="<?php echo "1"; ?>">
                    <label>Display</label> 
                    <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: Please select 'Yes' if you want to display / activate this record. Otherwise please select 'NO'"; ?>">help</i>

                    <?php
                    if (!empty($eid)) {
                        $publishYRadio = array(
                            'name' => 'chrPublish',
                            'id' => 'chrPublishY',
                            'value' => 'Y',
                            'class' => 'form-rediobutton',
                            'checked' => ($Row_product['chrPublish'] == 'Y') ? TRUE : FALSE
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
                               'checked' => ($Row_product['chrPublish'] == 'N') ? TRUE : FALSE
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
<?php
if (!empty($eid)) {
    if (($permissionArry['Approve'] == 'Y')) {
        if ($Row_product['chrPublish'] == 'N') {
            ?>
            <div class="md-fab-wrapper">
                <a onclick="return approvaldiv('Y');" title="Click here to approve this product." class="md-fab md-fab-success" href="javascript:;" >
                    <i class="material-icons">check_circle</i>
                </a>
            </div>
        <?php } else { ?>
            <div class="md-fab-wrapper">
                <a onclick="return approvaldiv('N');" title="Click here to disable this product." class="md-fab md-fab-danger" href="javascript:;">
                    <i class="material-icons">highlight_off</i>
                </a>
            </div> 
            <?php
        }
    }
}
echo form_close();
?>