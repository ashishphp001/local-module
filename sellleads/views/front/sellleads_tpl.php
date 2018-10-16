<style>
    .varReqTypeerror .select2-selection {
        border: 1px solid red;
    }
    .intUniterror .select2-selection {
        border: 1px solid red;
    }
    .intParentCategoryError .select2-selection {
        border: 1px solid red;
    }
</style>
<script>
    var i = 0;
    function changeCategory(intCategory) {
        var element = document.getElementById("intParentCategoryError");
        element.classList.remove("intParentCategoryError");

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

<script>
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
                    var div = document.createElement("div");
                    var getimg = "";
                    getimg = addExtensionClass(ext1);
                    div.innerHTML = "<div class='upload-boxes'>\n\
                <div class='image-source card'><img src='" + site_path + "front-media/images/" + getimg + "'" +
                            "title='" + picFile.name + "'/></div></div>";
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
            case '.docx':
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
<script type="text/javascript">

    $(document).ready(function ()
    {


        if (document.getElementById('chrDaysRequirement').checked == true)
        {
            document.getElementById('showDaysDiv').style.display = '';
        } else {
            document.getElementById('showDaysDiv').style.display = 'none';
        }

        $.validator.addMethod("greaterThanEnd", function (value, element) {
            var startprice = document.getElementById('varStartPrice').value;
            var endprice = document.getElementById('varEndPrice').value;
            if (startprice != '' && endprice != '') {
                if (startprice <= endprice) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }, "Start price less than end price.");

        $.validator.messages.required = "";

        $("#Frmsellleads").validate({
            ignore: [],
            rules: {
                intUser: {
                    required: true
                },
                varProduct: {
                    required: true
                },
                intParentCategory: {
                    required: true
                },
                varReqType: {
                    required: true
                },
                varQuantity: {
                    required: true},
                txtDescription: {
                    required: true
                },
                intUnit: {
                    required: true
                },
                varStartPrice: {
                    required: true,
                    greaterThanEnd: true
                },
                varEndPrice: {
                    required: true
                },
                varLocation: {
                    required: true
                },
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
                varFile: {
                    accept: "pdf,doc,docx,xls,xlsx,ppt,pptx,zip,csv",
                    Chk_File_Size: true
                }
            },
            messages: {
//                intUser: {
//                    required: "Please select customer."
//                },
//                varName: {
//                    required: "Please enter product name."
//                },
//                intParentCategory: {
//                    required: "Please select industry type."
//                },
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
//                varDays: {
//                    required: "Please enter days."
//                },
//                varAddress1: {
//                    required: "Please enter street address 1."
//                },
//                varAddress2: {
//                    required: "Please enter street address 2."
//                },
//                intUnit: {
//                    required: "Please select unit type."
//                },
//                varQuantity: {
//                    required: "Please enter quantity."
//                },
//                varImage: {
//                    required: "Please select buylead image.",
                //                    accept: "Only *.jpg, *.jpeg, *.png or *.gif image formats are supported."
//                }
            },
            errorPlacement: function (error, element)
            {
                if ($(element).attr('id') == 'varReqType')
                {
                    $('#varReqTypeerror').addClass('varReqTypeerror');
//                    varReqTypeerror
                    error.appendTo('#varReqTypeerror');
                } else if ($(element).attr('id') == 'intUnit')
                {
                    $('#intUniterror').addClass('intUniterror');
//                    varReqTypeerror
                    error.appendTo('#intUniterror');
                } else if ($(element).attr('id') == 'intParentCategory')
                {
                    $('#intParentCategoryError').addClass('intParentCategoryError');
//                    varReqTypeerror
                    error.appendTo('#intParentCategoryError');
                }
//                else if ($(element).attr('id') == 'intParentCategory')
//                {
//                    error.appendTo('#intParentCategoryerror');
//                } else
//                {
                //                    error.insertAfter(element);
                //                }
            }
        });
    });

    function removeunitclass()
    {
        var element = document.getElementById("intUniterror");
        element.classList.remove("intUniterror");
    }
    function removereqtypeclass()
    {
        var element = document.getElementById("varReqTypeerror");
        element.classList.remove("varReqTypeerror");
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
<div class="product-info col m12 s12 get-quots">
    <?php
//    echo MODULE_ID;
    $attributes = array('name' => 'Frmsellleads', 'id' => 'Frmsellleads', 'enctype' => 'multipart/form-data', 'class' => 'register-form', 'method' => 'post');
    $action = $this->common_model->getUrl("pages", "2", "27", '') . "/insert_sell_leads";
    echo form_open($action, $attributes);
    ?>
    <!--<form class="register-form" action="otpsend.php" method="post">-->
    <div class="product-multi card">
        <div class="col m12 s12 multi-top">
            <div id="" class="col s12 m3 upload-attachment">
                <div class="custom-file-container" data-upload-id="mySecondImage">
                    <h1>Product Image</h1>
                    <label><a href="javascript:;" class="custom-file-container__image-clear" title="Clear Image"></a></label>
                    <label class="custom-file-container__custom-file" >
                        <input type="file" id="varImage" name="varImage" class="custom-file-container__custom-file__custom-file-input" accept=".png, .jpg, .jpeg, .gif" >
                        <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                    </label>
                    <div class="custom-file-container__image-preview"></div>
                </div>
            </div>
            <div class="col m9 s12 product-up">
                <div class="product-upload-user mCustomScrollbar light" data-mcs-theme="minimal-dark">
                    <div class="upload-btn-wrapper">
                        <button class="btnupload">Upload Attachments</button>
                        <input id="files" name="files[]" type="file" class="multi" multiple accept=".pdf, .doc, .docx, .csv, .xls, .xlsx, .ppt, .zip"/>
                        <div class="img-note"><p>Upload Files of format Only *.doc, *.docx, *.pdf, *.xls, *.xlsx, *.ppt *.zip and *.pptx file formats are supported.<br>Having maximum size of 10MB.</div>
                        <div class="on-upload-image" id="result">
                        </div>
                        <!-- end static -->
                    </div>             
                </div>
            </div>

        </div>
    </div>


    <div class="register-inner top-card card">         


        <div class="col m12 s12 padding margin-maintain">
            <div class="other-info-user">
                <div class="col m12 s12 padding"> 
                    <div class="col m12 s12">
                        <div class="basic-detail top-margin-none"><h2>Basic Details</h2></div>
                        <input type="hidden" id="intUser" name="intUser" value="<?php echo USER_ID; ?>">
                        <div class="col m6 s12 ">
                            <div class="input-field field-custom">
                             <!-- <i class="material-icons prefix">textsms</i> -->
                                <input type="text" id="varProduct" autocomplete="off" name="varProduct" value="<?php echo $_REQUEST['varProduct']; ?>" class="autocomplete">
                                <label for="autocomplete-product-get">Product Name</label>
                            </div>
                        </div>
                        <div class="col m6 s12">
                            <div class="form-part">
                                <div class="input-field field-custom" id="varReqTypeerror">
                                    <?php echo $getReqType; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col m12 s12 padding border-radius-none">
                            <div class="col m12 s12 more-info">
                                <div class="cat-note"><span>Category:  </span><span id="category_list"></span></div>
                                <div class="form-part">
                                    <div class="input-field field-custom"  id="intParentCategoryError">
                                        <?php echo $getParentCategory; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col m12 s12 location-fill prefer-width">
                            <div class="input-field field-custom">
                                <textarea id="txtDescription" name="txtDescription" class="materialize-textarea"><?php echo $_REQUEST['txtDescription']; ?></textarea>
                                <label for="txtDescription">Description</label>
                            </div>
                        </div>
                        <div class="col s12 m6 padding">
                            <div class="col m12 s12 clear-both padding get-bprder-mixed">
                                <div class="col m6 s6 more-info padding-right border-radius qty-paid">
                                    <div class="form-part margin-none">
                                        <div class="input-field field-custom">
                                            <input id="varQuantity" onkeypress="return KeycheckOnlyNumeric(event);" name="varQuantity" value="<?php echo $_REQUEST['varQuantity']; ?>" type="text">
                                            <label for="varQuantity" class="">Qty</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col m6 s6 more-info padding-left border-radius">
                                    <div class="form-part margin-none">
                                        <div class="input-field field-custom" id="intUniterror">
                                            <?php echo $getUnitData; ?>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                        <div class="col m6 s12 approx-time-get mixed ">
                            <div class="col l2 m3 s3 padding">
                                <div class="input-field field-custom">
                                    <?php
                                    if ($_REQUEST['varCurrency'] == '2') {
                                        $sel1 = "";
                                        $sel2 = "selected='selected'";
                                    } else {
                                        $sel1 = "selected='selected'";
                                        $sel2 = "";
                                    }
                                    ?>
                                    <select id="varCurrency" name="varCurrency">
                                        <option value="1" <?php echo $sel1; ?>>&#x20B9;</option>
                                        <option value="2" <?php echo $sel2; ?>>&#x24;</option>
                                    </select>
                                    <!-- <label>Sub Category</label> -->
                                </div>
                            </div>
                            <div class="col m5 s5 padding">
                                <div class="input-field field-custom">
                                    <input id="varExpectedPrice" onkeypress="return KeycheckOnlyNumeric(event);" name="varExpectedPrice" value="<?php echo $_REQUEST['varExpectedPrice']; ?>" type="text">
                                    <label for="varExpectedPrice" class="">Expected Price</label>
                                </div>
                            </div>
                            <div class="col l5 m4 s4 padding">
                                <div class="input-field field-custom">
                                    <?php echo $getExpUnitData; ?>
                                </div>
                            </div> 
                        </div>
                    </div>


                    <div class="col m12 s12 other-second basic-detail">
                        <h2>Other Details</h2>
                        <div class="col m6 s12 approx-time-get mixed ">
                            <div class="col l2 m2 s2 more-info padding-right padding-left">
                                <div class="form-part">
                                    <div class="input-field field-custom">
                                        <?php
                                        if ($_REQUEST['varApproxCurrency'] == '2') {
                                            $sel1 = "";
                                            $sel2 = "selected='selected'";
                                        } else {
                                            $sel1 = "selected='selected'";
                                            $sel2 = "";
                                        }
                                        ?>
                                        <select id="varApproxCurrency" name="varApproxCurrency">
                                            <option value="1" <?php echo $sel1; ?>>&#x20B9;</option>
                                            <option value="2" <?php echo $sel2; ?>>&#x24;</option>
                                        </select>
                                        <!-- <label>Sub Category</label> -->
                                    </div>
                                </div>
                            </div>

                            <div class="col l5 m5 s5 padding-right padding-left">
                                <div class="input-field field-custom">
                                    <input id="varStartPrice" value="<?php echo $_REQUEST['varStartPrice']; ?>" name="varStartPrice" onkeypress="return KeycheckOnlyNumeric(event);" type="text">
                                    <label for="varStartPrice">Approx Order Value(From)</label>
                                </div>      
                            </div>
                            <div class="col l5 m5 s5 padding-left padding-right">
                                <div class="input-field field-custom">
                                    <input id="varEndPrice"  value="<?php echo $_REQUEST['varEndPrice']; ?>" name="varEndPrice" onkeypress="return KeycheckOnlyNumeric(event);" type="text">
                                    <label for="varEndPrice">Approx Order Value(To)</label>
                                </div>      
                            </div>
                        </div>
                        <div class="col m6 s12 clear-both">
                            <div class="requirment">
                                <label>Selling Time</label>
                                <div class="radio-style col m3 s6">
                                    <label>
                                        <input class="with-gap" name="chrRequirement" id="chrUrgentRequirement" value="U" onclick="showDays();" type="radio" checked />
                                        <span>Urgent</span>
                                    </label>
                                </div>
                                <div class="radio-style col m9 s6"> 
                                    <label>
                                        <input class="with-gap" name="chrRequirement" value="D" onclick="showDays();" id="chrDaysRequirement" type="radio"  />
                                        <span>With in Days</span>
                                    </label>
                                </div>   
                            </div>
                        </div>
                        <div class="col m6 s12 padding-right"  id='showDaysDiv' style="display: none;">
                            <div class="input-field field-custom days-up">
                                <input id="varDays" value="<?php echo $_REQUEST['varDays']; ?>" onkeypress="return KeycheckOnlyNumeric(event);" name="varDays" type="text">
                                <label for="varDays">Days</label>
                            </div>      
                        </div>
                        <div class="col m12 s12 padding check-heading basic-detail">
                            <h2>Payment Terms</h2>
                            <?php
                            echo $getPaymentTermsData;
                            ?> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col m12 s12">
            <div class="register-submit all-same product-page-btn">
                <button class="waves-effect waves-light btn same-btn">Submit</button>
                <button class="waves-effect waves-light btn same-btn" type="reset">Reset</button>
            </div>
        </div>
    </div>


</div>
<?php echo form_close(); ?>


<script src="<?php echo FRONT_MEDIA_URL; ?>js/file-upload-with-preview.js"></script>

<script>

                                    //Second upload
                                    var secondUpload = new FileUploadWithPreview('mySecondImage')
                                    //                                        var secondUploadInfoButton = document.querySelector('.upload-info-button--second');
                                    //                                        secondUploadInfoButton.addEventListener('click', function () {
                                    //                                            console.log('Second upload:', secondUpload, secondUpload.cachedFileArray)
                                    //                                        })
</script>
