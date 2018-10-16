<style>
    .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
    }
    .remove:hover {
        background: white;
        color: black;
    }
    .intParentCategoryError .select2-selection {
        border: 1px solid red;
    }
    .intMOQUniterror .select2-selection {
        border: 1px solid red;
    }
    .intPriceUniterror .select2-selection {
        border: 1px solid red;
    }
    label.error {
        display: none !important;
    }
    select{
        display:unset !important;
    }
    .error{
        color:#ce0000; 
    }
</style>
<script>

    function delete_image(name) {
        var url = "<?php echo $this->common_model->getUrl("pages", "2", "50", '') . '/delete_image_by_name?imagename='; ?>" + name;
        $.ajax({
            type: "GET",
            url: encodeURI(url),
            async: true,
            success: function (data) {
            }
        });
    }

    var a = 0;
    function getSubCategory(intCategory, id) {
        var element = document.getElementById("ProductCatList");
        document.getElementById("intParentCategory").value = intCategory;
        element.classList.remove("ProductCatList");

        $.ajax({
            type: "POST",
            data: {"csrf_indibizz": csrfHash, "intCategory": intCategory},
            url: "<?php echo $this->common_model->getUrl("pages", "2", "52", ''); ?>" + "/getCategoryNames",
            async: false,
            success: function (Data)
            {
                $('#category_list').html(Data);
            }
        });
    }
    function otherdiv()
    {
        var checkval = document.getElementById("chrOther").checked;
        if (checkval == true) {
            document.getElementById('showOtherDiv').style.display = '';
        } else {
            document.getElementById('showOtherDiv').style.display = 'none';
        }
    }
    function changeCategory(intCategory) {
//        alert(intCategory);
        var element = document.getElementById("intParentCategoryError");
        element.classList.remove("intParentCategoryError");
        document.getElementById("intParentCategory").value = intCategory;
        $.ajax({
            type: "POST",
            data: {"csrf_indibizz": csrfHash, "intCategory": intCategory},
            url: "<?php echo $this->common_model->getUrl("pages", "2", "52", ''); ?>" + "/getCategoryNames",
            async: false,
            success: function (Data)
            {
                $('#category_list').html(Data);
            }
        });
    }
    function remove_moq_unitclass()
    {
        var element = document.getElementById("intMOQUniterror");
        element.classList.remove("intMOQUniterror");
    }
    function removeunitclass()
    {
        var element = document.getElementById("intPriceUniterror");
        element.classList.remove("intPriceUniterror");
    }
    function removefile(name) {
//        alert(name);
        document.getElementById('tmpimage').value = name + "," + document.getElementById('tmpimage').value;
//        document.getElementById('pips'+name).style.display = 'none';
//        element.classList.remove("pips"+name);
        var divsToHide = document.getElementsByClassName("pips" + name); //divsToHide is an array
        for (var i = 0; i < divsToHide.length; i++) {
            divsToHide[i].style.visibility = "hidden"; // or
            divsToHide[i].style.display = "none"; // depending on what you're doing
        }
//        "pips"+name;
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
                    M.toast({html: 'Sorry! you reached maximum limit, Please upload up to 5 image only.'});
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
                        M.toast({html: 'Sorry! you reached maximum limit, Please upload up to 5 image only.'});
                        return false;
                    }
                    if (file > FIVE_MB) {
                        M.toast({html: 'Sorry! you reached maximum limit, Please upload up to 5 MB only.'});
                        return false;
                    }
                    //image end
                    if (ext !== ".jpg" && ext !== "jpeg" && ext !== ".png" && ext !== ".gif") {
                        M.toast({html: 'Only image files (JPG, JPEG, GIF, PNG) are allowed.'});
                        return false;
                    }
                }
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i];
                    var fileReader = new FileReader();
                    fileReader.onload = (function (e) {
                        var file = e.target;
                        $('<div class="upload-boxes pips' + j + '">\n\
                                <div class="image-source card">\n\
                                    <a href="javascript:;" class="remove" onclick=\'return removefile("' + j + '")\'><i class="far fa-times-circle"></i></a>\n\
                                    <img src="' + e.target.result + '" alt="' + file.name + '">\n\
                                </div>\n\
                            </div>').insertAfter("#productimages");
//                        $(".remove").click(function () {
//                            $(this).parent(".pip").remove();
//                        });
                        j++;
                    });
                    fileReader.readAsDataURL(f);
                }
            });
        } else {
            M.toast({html: "Your browser doesn't support to File API"});
        }
    });
    $(document).ready(function ()
    {
        $("#FrmProduct").validate({
            ignore: [],
            rules: {
                varName: {
                    required: true
                },
                varCurrency: {
                    required: true
                },
                intParentCategory: {
                    required: true
                },
                varPrice: {required: "#varMOQ:blank"},
                varMOQ: {required: "#varPrice:blank"},
//                varPrice: {
//                    required: true
//                },
//                varUnit: {
//                    required: true
//                },
                intPriceUnit: {
                    required: {
                        depends: function () {
                            if ($("#varPrice").val() == '')
                            {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    }
                },
//                varMOQ: {
//                    require_from_group: [1, ".send"]
//                },
//                varMOQ: {
//                    required: true
//                },
                intMOQUnit: {
                    required: {
                        depends: function () {
                            if ($("#varMOQ").val() == '')
                            {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    }
                },
                captchaimage1: {
                    required: {
                        depends: function () {
                            if (!/Android|iPhone|BlackBerry/i.test(navigator.userAgent))
                            {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    },
                    equalTo: {
                        param: "#h_code",
                        depends: function () {
                            if (!/Android|iPhone|BlackBerry/i.test(navigator.userAgent))
                            {
                                return true;
                            } else
                            {
                                return false;
                            }
                        }
                    }
                }
            },
            messages: {
                captchaimage1: {
                    required: "Please enter the captcha code."
                }
            },
            errorPlacement: function (error, element)
            {
                if ($(element).attr('id') == 'intMOQUnit')
                {
                    $('#intMOQUniterror').addClass('intMOQUniterror');
                    error.appendTo('#intMOQUniterror');
                } else if ($(element).attr('id') == 'intPriceUnit')
                {
                    $('#intPriceUniterror').addClass('intPriceUniterror');
                    error.appendTo('#intPriceUniterror');
                } else if ($(element).attr('id') == 'intParentCategory')
                {
                    $('#intParentCategoryError').addClass('intParentCategoryError');
                    error.appendTo('#intParentCategoryError');
                } else if ($(element).attr('id') == 'captchaimage1')
                {
                    error.insertAfter($(".replacecaptcha"));
                }
            },
            submitHandler: function (form) {
                var chipInstance = M.Chips.getInstance($("#varKeywords"));
                var keychips = '';
                var chipsObjectValue = chipInstance.chipsData;
                $.each(chipsObjectValue, function (key, value) {
                    keychips += value.tag + ",";
                });
                document.getElementById("varKeyword").value = keychips;
                var chipInstances = M.Chips.getInstance($("#varMaterials"));
                var keymaterialchips = '';
                var chipsObjectValues = chipInstances.chipsData;
                $.each(chipsObjectValues, function (key, value) {
                    keymaterialchips += value.tag + ",";
                });
                document.getElementById("varMaterial").value = keymaterialchips;
                form.submit();
            }
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
    $(document).ready(function ()
    {
        $('.add').click(function () {
            var counter = document.getElementById('file_hd').value;
            var counter1 = Number(counter) + 1;
            document.getElementById('file_hd').value = counter1;
            $("#adds").append('<div class="col m12 s12 value-add padding">\n\
                <div class="col m6 s5">\n\
                    <div class="input-field field-custom">\n\
                        <input type="text" name="varSTitle' + counter1 + '" id="varSTitle' + counter1 + '">\n\
                        <label for="varSTitle' + counter1 + '">Title</label>\n\
                    </div>\n\
            </div>\n\
        <div class="col m5 s5">\n\
            <div class="input-field field-custom">\n\
                <input type="text" name="varSvalue' + counter1 + '" id="varSvalue' + counter1 + '">\n\
                <label for="varSvalue' + counter1 + '" >Value</label>\n\
            </div>\n\
        </div>\n\
        <div class="col m1 s2 delet-icon remove"><a href="javascript:;"><i class="fas fa-trash-alt"></i></a></div>\n\
    </div>');
        });
        $(document).on('click', '.remove', function () {
            $(this).parent('div').remove();
        });
    });
</script>

<script>

    function refreshcaptcha(base) {
<?php $url = $this->common_model->getUrl("pages", "2", '50', ''); ?>
        var newdata;
        $.ajax({
            type: "GET",
            url: "<?php echo $url ?>/refershcaptcha",
            async: false,
            success: function (data)
            {
                var newdata = data.split("#");
                var src = newdata[0];
                $("#captchaImage img").attr('src', newdata[0]);
                $("#pin_img").val(newdata[1]);
                $("#h_code").val(newdata[1]);
            }
        });
    }
</script>

<div class="product-info col m12 s12">
    <?php
    $attributes = array('name' => 'FrmProduct', 'id' => 'FrmProduct', 'enctype' => 'multipart/form-data', 'class' => 'register-form all-product-form', 'method' => 'post');
    $action = $this->common_model->getUrl("pages", "2", "50", '') . "/insert_product";
    echo form_open($action, $attributes);
    ?>
    <div class="product-multi card">
        <div class="col m12 s12 multi-top">
            <div class="col m9 s12 product-up">
                <div class="product-upload-user mCustomScrollbar light" data-mcs-theme="minimal-dark">
                    <div class="upload-btn-wrapper">
                        <button class="btnupload">Upload Product Images</button>
                        <input type="file" id="varImages" name="varImages[]" multiple />
                        <div class="img-note"><p>Upload image file of format only .jpg, .jpeg, .png or .gif. Having maximum size of 5MB.
                            <br>(Recommended images is in square - Maximum Image Dimension 4000px X 4000px )</div>
                        <div class="on-upload-image" id='productimages'></div>
                        <?php
                        if (!empty($product)) {
                            $product_id = $this->mylibrary->decryptPass($product);
                            $photosArr = $this->Module_Model->getPhotosByAlbum($product_id);
//                            print_R($photosArr);
                            foreach ($photosArr as $key => $photo) {
                                $photo_thumb = $photo['varImage'];
                                $thumb = 'upimages/productgallery/images/' . $photo_thumb;
                                if (file_exists($thumb) && $photo_thumb != '') {
                                    $thumbphoto1 = image_thumb($thumb, PHOTOGALLERY_WIDTH, PHOTOGALLERY_HEIGHT);
                                }
                                ?>
                                <div class="upload-boxes pips<?php echo $photo['int_id']; ?>">
                                    <div class="image-source card">
                                        <a href="javascript:;" class="remove" onclick='return delete_image(<?= $photo['int_id'] ?>)'><i class="far fa-times-circle"></i></a>
                                        <img src="<?php echo $thumbphoto1 ?>" alt="<?php echo $photo['varName']; ?>">
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div id="" class="col s12 m3 upload-attachment">
                <div class="custom-file-container" data-upload-id="mySecondImage">
                    <h1>Attachment</h1>
                    <label><a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image"></a></label>
                    <label class="custom-file-container__custom-file" >
                        <input type="file" name="varBrochure" id="varBrochure" class="custom-file-container__custom-file__custom-file-input" accept=".pdf, .doc, .docx, .csv, .xls, .xlsx, .ppt, .zip" >
                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                    </label>
                    <div class="custom-file-container__image-preview"></div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="varhidd_Brochure" name="varhidd_Brochure" value="<?php echo $Row_product['varBrochure']; ?>">
    <input type="hidden" id="varKeyword" name="varKeyword">
    <input type="hidden" id="varMaterial" name="varMaterial">
    <input type="hidden" id="tmpimage" name="tmpimage">
    <input type="hidden" value="<?php echo USER_ID; ?>" id="intUser" name="intUser">
    <input type="hidden" id="intParentCategory" name="intParentCategory"  value="<?php echo $Row_product['intParentCategory']; ?>">
    <input type="hidden" id="product" name="product" value="<?php echo $product; ?>">
    <div class="register-inner top-card card">         
        <div class="col m12 s12 padding margin-maintain product-input-width">
            <div class="other-info-user">
                <div class="col m12 s12 padding"> 
                    <div class="col m12 s12 padding">
                        <div class="basic-detail top-margin-none"><h2>Basic Details</h2></div>
                        <div class="col m6 s12">
                            <div class="input-field field-custom">
                                <input id="varName" name="varName" value="<?php echo $Row_product['varName']; ?>" type="text">
                                <label for="varName">Product Name<sup>*</sup></label>
                            </div>
                        </div>
                        <div class="col m6 s12">
                            <div class="input-field field-custom">
                                <input id="varHSCode" name="varHSCode" value="<?php echo $Row_product['varHSCode']; ?>" type="text">
                                <label for="varHSCode">HS Code</label>
                            </div>
                        </div>
                        <div class="col m12 s12 border-radius-none">
                            <?php
                            if ($Row_product['intParentCategory'] != '') {
                                $pro_Cate = $this->Module_Model->getCategoryListNames($Row_product['intParentCategory']);
                            }
                            ?>
                            <div class="cat-note"><span>Category:  </span><span id="category_list"><?php echo $pro_Cate; ?></span></div>
                            <div class="form-part">
                                <div class="input-field field-custom" id="intParentCategoryError">
                                    <select id="myselect" onchange="return changeCategory(this.value);"></select>

                                    <script type="text/javascript" charset="utf-8">
                                        $.ajax({
                                            url: '<?php echo $this->common_model->getUrl("pages", "2", "51", "") . "/FrontBindpageshierarchy" ?>',
                                            type: 'POST',
//                                            data: '<?php // echo $myJSON;              ?>',
                                            dataType: 'json',
                                            success: function (json) {
//                                                 $('#myselect').append(json);
                                                $.each(json, function (i, value) {
//                                                    alert(value['treename']);return false;
//                                                    var value = replaceNbsps(value1);
                                                    var id = value['id'];
                                                    var value = value['treename'].replace(/&nbsp;/g, '');
//                                                    var id = value['id'];

                                                    $('#myselect').append($('<option>').text(value).attr('value', id));
                                                });
                                            }
                                        });

//                                        function replaceNbsps(str) {
//                                            var re = new RegExp(String.fromCharCode(160), "g");
//                                            return str.replace(re, " ");
//                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col m12 s12 location-fill prefer-width hegiht-main">
                            <label for="varKeywords" class="stick-label set-addprod"><span class="hints">(Press Enter To Add Multiple keyword)</span></label>
                            <div class="chips chips-keyword chips-autocomplete field-custom mCustomScrollbar light" id="varKeywords" data-mcs-theme="minimal-dark">
                                <input class="custom-class" placeholder="Keywords" autocomplete="off">

                            </div>
                        </div>

                        <div class="col m12 s12 basic-detail">
                            <h2 class="product-desc">Product Description</h2>
                            <div class="input-field field-custom poster-main-text">
                                <?php
                                $pdesc = (!empty($product) ? $Row_product['txtDescription'] : '');
                                echo $this->mylibrary->load_ckeditor('txtDescription', $pdesc, '100%', '200px', 'Basic');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col m6 s12 other-second basic-detail margin-lesee-pro padding">
                        <h2>Product Details</h2>
                        <div class="col m12 s12 padding product-brand">
                            <div class="col m6 s12">
                                <div class="input-field field-custom">
                                    <input id="varModelNo" name="varModelNo" value="<?php echo $Row_product['varModelNo']; ?>" type="text">
                                    <label for="varModelNo" class="">Model Number</label>
                                </div>
                            </div> 
                            <div class="col m6 s12">
                                <div class="input-field field-custom">
                                    <input id="varBrand" name="varBrand" value="<?php echo $Row_product['varBrand']; ?>" type="text">
                                    <label for="varBrand" class="">Brand Name</label>
                                </div>
                            </div> 
                        </div>
                        <div class="col m12 s12 location-fill prefer-width material-type-product">
                            <label for="varMaterials" class="stick-label set-addprod  slide-down"><span class="hints">(Press Enter To Add Multiple keyword)</span></label>
                            <div class="chips chips-material chips-autocomplete field-custom mCustomScrollbar light" data-mcs-theme="minimal-dark" id="varMaterials">
                                <input class="custom-class" placeholder="Material Type">
                            </div>
                        </div>
                        <?php
                        $getproductKeys = explode(",", $Row_product['varKeyword']);
                        $keyhtml = "";
                        foreach ($getproductKeys as $keys) {
                            $keyhtml .= "'" . $keys . "'" . ",";
                        }
                        $keyhtmls = rtrim($keyhtml, ",");

                        $getmaterialKeys = explode(",", $Row_product['varMaterial']);
                        $materialhtml = "";
                        foreach ($getmaterialKeys as $keys) {
                            $materialhtml .= "'" . $keys . "'" . ",";
                        }
                        $materialhtmls = rtrim($materialhtml, ",");
                        ?>
                        <script>

                            $(document).ready(function () {
                                var tags_keyword = [];
                                var tags_keyword_val = [<?php echo $keyhtmls; ?>];

                                for (i = 0; i < tags_keyword_val.length; i++) {
                                    tags_keyword.push({tag: tags_keyword_val[i]});
                                }

                                $('.chips-keyword').chips({
                                    data: tags_keyword
                                });

                                var tags_material = [];
                                var tags_material_val = [<?php echo $materialhtmls; ?>];

                                for (i = 0; i < tags_material_val.length; i++) {
                                    tags_material.push({tag: tags_material_val[i]});
                                }

                                $('.chips-material').chips({
                                    data: tags_material
                                });



                            });
                        </script>
                        <div class="col m12 s12">
                            <div class="input-field field-custom area-height">
                                <textarea id="varUse" name="varUse" class="materialize-textarea"><?php echo $Row_product['varUse']; ?></textarea>
                                <label for="varUse" class="">Use of Product</label>
                            </div>
                        </div>
                    </div>
                    <div class="col m6 s12 basic-detail padding">
                        <h2 class="spacess"></h2>
                        <div class="col m12 s12 padding">
                            <div class="col m12 s12">
                                <div class="input-field field-custom material-packingdetail-change">
                                    <input type="text" id="varPacking" name="varPacking" value="<?php echo $Row_product['varPacking']; ?>">
                                    <label for="varPacking" class="">Packing Detail</label>
                                </div>
                            </div>
                        </div>
                        <br class="nana">
                        <br class="nana">
                        <br class="nana">
                        <br class="nana">
                        <div class="col m12 s12">
                            <div class="input-field field-custom area-height services-change-product">
                                <input type="text" id="varService" name="varService" class="materialize-textarea" value="<?php echo $Row_product['varService']; ?>">
                                <label for="varService" class="">After Sales Service</label>
                            </div>
                        </div>
                        <div class="col m12 s12 ">
                            <div class="requirment">
                                <label>Free Sample :</label>
                                <div class="radio-style col m4 s6">
                                    <label>
                                        <?php
                                        $fcheck1 = $Row_product['chrSample'] == 'Y' ? TRUE : FALSE;
                                        $fcheck2 = $Row_product['chrSample'] == 'Y' ? TRUE : FALSE;
                                        ?>
                                        <input class="with-gap" name="chrSample" checked="<?php echo $fcheck1; ?>" id="chrSampleY" value="Y" type="radio">
                                        <span>Yes</span>
                                    </label>
                                </div>
                                <div class="radio-style col m4 s6"> 
                                    <label>
                                        <input checked="" class="with-gap" checked="<?php echo $fcheck2; ?>" name="chrSample" id="chrSampleN" value="N" type="radio">
                                        <span>No</span>
                                    </label>
                                </div>   
                            </div>
                        </div>
                        <div class="col m12 s12 padding mixed product-gap-mass">
                            <div class="col m4 s5 padding-right">
                                <div class="input-field field-custom">
                                    <input id="varProduction" name="varProduction" type="text" value="<?php echo $Row_product['varProduction']; ?>">
                                    <label for="varProduction" class="">Production Capacity</label>
                                </div>
                            </div> 
                            <div class="col m4 s3 padding-right padding-left">
                                <div class="input-field field-custom">
                                    <?php echo $getUnitData; ?>
                                    <label for="intUnit" class="stick-label">Select Unit</label>
                                </div>
                            </div>
                            <div class="col m4 s4 padding-left">
                                <div class="input-field field-custom">
                                    <?php echo $getTimeData; ?>
                                    <label for="intTime" class="stick-label">Select Time</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--                    <div class="clear"></div>-->

                    <div class="col m12 s12 padding">
                        <h6 class="margin-lesee-pro">Product Features</h6>
                        <?php if ($product == '') { ?>
                            <div class="col m6 s5">
                                <div class="input-field field-custom">
                                    <input type="text" name="varSTitle1" id="varSTitle1">
                                    <label for="varSTitle1">Title</label>
                                </div>
                            </div>
                            <div class="col m5 s5">
                                <div class="input-field field-custom">
                                    <input type="text" name="varSvalue1" id="varSvalue1">
                                    <label for="varSvalue1" >Value</label>
                                </div>
                            </div>
                            <?php
                        }
                        if ($product != "") {
                            $varSTitle = explode("__", $Row_product['varSTitle']);
                            $varSvalue = explode("__", $Row_product['varSvalue']);
                            $t = 0;
                            $j = 1;
                            foreach ($varSvalue as $txt) {
                                $ColornamVal = 'varSTitle' . $j . '';
                                $namVal = 'varSvalue' . $j . '';
                                ?>
                                <div class="col m6 s5">
                                    <div class="input-field field-custom">
                                        <input type="text" name="<?php echo $ColornamVal; ?>" id="<?php echo $ColornamVal; ?>" value="<?php echo $varSTitle[$t]; ?>">
                                        <label for="<?php echo $ColornamVal; ?>">Title</label>
                                    </div>
                                </div>
                                <div class="col m5 s5">
                                    <div class="input-field field-custom">
                                        <input type="text" name="<?php echo $namVal; ?>" id="<?php echo $namVal; ?>" value="<?php echo $varSvalue[$t]; ?>">
                                        <label for="varSvalue1" >Value</label>
                                    </div>
                                </div>
                                <?php
                                $t++;
                                $j++;
                            }
                        }
                        ?>
                        <div id="varFeaturesdiv"> 
                            <span id="adds"></span>

                        </div>
                        <div class="plus-icon">
                            <a href="javascript:;" class="add waves-effect waves-light btn"><i class="fas fa-plus-square"></i>Add Field</a>
                        </div>
                    </div>
                    <?php $varSvalue = explode("__", $Row_product['varSvalue']); ?>
                    <input type="hidden" name="file_hd" id="file_hd" value="<?php echo count($varSvalue); ?>">
                    <!--                    <div class="col m12 s12 basic-detail margin-space">
                                            
                                        </div>-->
                    <div class="col m12 s12 basic-detail margin-space padding">
                        <h2>Trade Information</h2>
                        <div class="col m6 s12 mixed  currency-width-product">
                            <div class="col l2 m2 s3 padding">
                                <div class="input-field field-custom">
                                    <?php
                                    if ($Row_product['varCurrency'] == '2') {
                                        $sel1 = "";
                                        $sel2 = "selected='selected'";
                                    } else {
                                        $sel1 = "selected='selected'";
                                        $sel2 = "";
                                    }
                                    ?>
                                    <select id="varCurrency" name="varCurrency"> 
                                        <option value="1" <?php echo $sel1; ?>>&#8377;</option>
                                        <option value="2" <?php echo $sel2; ?>>$</option>
                                    </select>
                                    <!-- <label>Sub Category</label> -->
                                </div>
                            </div> 
                            <div class="col m4 l5 s5 padding">
                                <div class="input-field field-custom">
                                    <input id="varPrice" name="varPrice" value="<?php echo $Row_product['varPrice']; ?>" type="text" onkeypress="return KeycheckOnlyNumeric(event);">
                                    <label for="varPrice" class="">Price</label>
                                </div>
                            </div> 
                            <div class="col l5 m4 s4 padding">
                                <div class="input-field field-custom" id="intPriceUniterror">
                                    <?php echo $getPriceUnitData; ?>
                                    <label for="intPriceUnit" class="stick-label">Select Unit</label> 
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6">
                            <div class="col m6 s6 padding radiousnone moq-width moq-width-product">
                                <div class="input-field field-custom">
                                    <input id="varMOQ" name="varMOQ" type="text" value="<?php echo $Row_product['varMOQ']; ?>">
                                    <label for="varMOQ" class="">MOQ<sup>*</sup></label>
                                </div>
                            </div>     
                            <div class="col m6 s6 padding radiousnone">
                                <div class="input-field field-custom" id="intMOQUniterror">
                                    <?php echo $getMOQUnitData; ?>
                                    <label for="intMOQUnit" class="stick-label">Select MOQ Unit<sup>*</sup></label> 
                                </div>
                            </div> 
                        </div>
                        <div class="col m6 s12  clear-both">
                            <div class="requirment none-delvery-border" style="margin-bottom:unset;">
                                <label class="delivery-spart">Delivery Time :</label>
                                <div class="radio-style col m9 s6 padding"> 
                                    <label>
                                        <div class="input-field field-custom days-up days-change-div">
                                            With in <input id="varDays" value="<?php echo $Row_product['varDays']; ?>" onkeypress="return KeycheckOnlyNumeric(event);" name="varDays" type="text">
                                            <span> Days</span>
                                        </div> 
                                    </label>
                                </div>   
                            </div>
                        </div> 

                        <div class="col m6 s12">
                            <div class="input-field field-custom">
                                <input id="varPort" name="varPort" type="text" value="<?php echo $Row_product['varPort']; ?>">
                                <label for="varPort" class="">Nearest Port</label>
                            </div>
                        </div>


                        <div class="col s12 m12">
                            <div class="card display-bl address-profile-add">
                                <ul class="collapsible change-add-profile-main">
                                    <li>
                                        <div class="collapsible-header card" >
                                            <a href="javascript:;" onclick=""><i class="fas fa-user-tag"></i>Payment Terms <span class="right-pro-ic"> <div class="circle-plus closed">
                                                        <div class="circle">
                                                            <div class="horizontal"></div>
                                                            <div class="vertical"></div>
                                                        </div>
                                                    </div></span></a>
                                        </div>
                                        <div class="collapsible-body">
                                            <div class="col m12 s12 padding">
                                                <h6 class="margin-lesee-pro">Delivery Terms</h6>
                                                <?php
                                                echo $getDeliveryTermsData;
                                                ?> 
                                            </div>
                                            <div class="col m12 s12 padding change-payment-view">
                                                <h6 class="margin-lesee-pro">Payment Type</h6>
                                                <?php
                                                echo $getPaymentTypeData;
                                                ?> 
                                            </div>
                                            <div class="col m12 s12 padding">
                                                <h6 class="margin-lesee-pro">Payment Terms</h6>
                                                <?php
                                                echo $getPaymentTermsData;
                                                ?> 
                                            </div>
                                        </div>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <?php
                    if ($Row_product['varOther'] == '') {
                        $otherstyle = "display: none;";
                    } else {
                        $otherstyle = "";
                    }
                    ?>
                    <div class="col m12 s12"  id='showOtherDiv' style="<?php echo $otherstyle; ?>">
                        <div class="input-field field-custom days-up">
                            <input id="varOther" name="varOther" type="text" <?php echo $Row_product['varOther']; ?>>
                            <label for="varOther">Other Payment Terms</label>
                        </div>      
                    </div> 
                    <div class="col s12 m12">
                        <div class="code" id="captchaImage"> 

                            <input type="button" class="no-click" readonly id="pin_img" value="<?php echo $generated_pin; ?>">
                            <a onclick="return refreshcaptcha('<?= base_url(); ?>');" title="Refresh" class="Refresh" href="javascript:;"><i class="fas fa-sync-alt"></i></a>
                            <div class="col m2 s4 captcha-note">
                                <div class="input-field field-custom"> 
                                    <input type="text" autocomplete="off" maxlength="4" type="text" id="captchaimage1" name="captchaimage1" value="<?php echo set_value('captchaimage1'); ?>">
                                    <label for="captchaimage1">Captcha</label>
                                </div>
                            </div>
                            <div class="col m2 s2"><div class="help-tooltip"><i class="fas fa-info-circle btn tooltipped" data-position="top" data-tooltip="Note: Please enter the captcha code exactly as mentioned in order to verify and continue."></i></div></div>
                            <input type="hidden" name="h_code" id="h_code" value="<?php echo $generated_pin; ?>" />

                            <div class="replacecaptcha" style="clear: both;"></div>

                            <?php echo form_error('captchaimage1', '<label class="error" for="captchaimage1">', '</label>') ?>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col m12 s12">
                <div class="register-submit all-same product-page-btn">
                    <button type="submit" id="showvalues" class="waves-effect waves-light btn same-btn">Add Product</button>
                    <button class="waves-effect waves-light btn same-btn" type="reset">Reset</button>
                </div>
            </div>

        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script src="<?php echo FRONT_MEDIA_URL; ?>js/file-upload-with-preview.js"></script>
<script>
                                var secondUpload = new FileUploadWithPreview('mySecondImage');
</script>

<script type="text/javascript">
    $('.collapsible-header').on('click', function () {
        $(this).toggleClass('opened');
    })
</script>