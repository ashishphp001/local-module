<style>
    .varReqTypeerror .select2-selection {
        border: 1px solid red;
    }
    .intUniterror .select2-selection {
        border: 1px solid red;
    }
    .ProductCatList .select2-selection {
        border: 1px solid red;
    }
    select{
        display:unset !important;
    }
    .error{
        color:#ce0000; 
    }
</style>
<script>
//    $(document).ready(function ()
//    {
//        $(function () {
//            setTimeout(loadajax, 2000);
//        });
//    });

//    function loadajax() {
//        $.ajax({
//            type: "POST",
//            data: {"csrf_indibizz": csrfHash},
//            url: "<?php echo $this->common_model->getUrl("pages", "2", "52", ''); ?>" + "/getSubCategoryData",
//            async: false,
//            success: function (Data)
//            {
//                $(".chosen-select").append(Data);
//            }
//        });
//        $(".chosen-select").chosen();
//    }

    var i = 0;
    var a = 0;
    function changeCategory(intCategory) {
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
    $(document).ready(function () {
        $("#varProduct").keyup(function () {
            document.getElementById('ProductCatList').style.display = '';
        });
    });


    function removefile() {
        $(document).ready(function ()
        {
            $("#input_doc").val('');
//            $("#input_doc").remove();
            $('#element').html('');
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
<script type="text/javascript">
    $(document).ready(function ()
    {
//        $('.cancelfile').click(function () {
//            alert("asdasd");
//            $("#input_doc").remove();
////            $("#containerof_inputfile").append("<input type=\"file\" id=\"inputfile\"/>");
//            $('#element').html('');
//        });

        $('#input_doc').change(function (event) {
            var file = URL.createObjectURL(event.target.files[0]);
//            $('#element').html('');
            $('#element').html('<a href="' + file + '" target="_blank">' + event.target.files[0].name + '</a><a href="javascript:;" class="cancelfile" onclick="return removefile()"><i class="far fa-times-circle" style="padding-left:0px;"></i></a>');
        });

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
        $("#Frmbuyleads").validate({
            ignore: [],
            rules: {
                intUser: {
                    required: true
                },
                varProduct: {
                    required: true
                },
//                intParentCategory: {
//                    required: true
//                },
                varReqType: {
                    required: true
                },
                varQuantity: {
                    required: "#varStartPrice:blank"
                },
                varStartPrice: {
                    required: "#varQuantity:blank"
                },
                intUnit: {
                    required: {
                        depends: function () {
                            if ($("#varQuantity").val() == '')
                            {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    }
                },
//                varQuantity: {
//                    required: true
//                },
//                txtDescription: {
//                    required: true
//                },
//                intUnit: {
//                    required: true
//                },
//                varStartPrice: {
//                    required: true,
//                    greaterThanEnd: true
//                },
                varEndPrice: {
                    required: {
                        depends: function () {
                            if ($("#varStartPrice").val() == '')
                            {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    }
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
                if ($(element).attr('id') == 'varReqType')
                {
                    $('#varReqTypeerror').addClass('varReqTypeerror');
                    error.appendTo('#varReqTypeerror');
                } else if ($(element).attr('id') == 'intUnit')
                {
                    $('#intUniterror').addClass('intUniterror');
                    error.appendTo('#intUniterror');
                } else if ($(element).attr('id') == 'intParentCategory')
                {
                    $('#ProductCatList').addClass('ProductCatList');
                    error.appendTo('#ProductCatList');
                } else if ($(element).attr('id') == 'captchaimage1')
                {
                    error.insertAfter($(".replacecaptcha"));
                }
            },
            submitHandler: function (form) {

                form.submit();
            }

        });
    });
    function removeunitclass()
    {
        var element = document.getElementById("intUniterror");
        element.classList.remove("intUniterror");
    }
    function removeerrorclass()
    {
        var element = document.getElementById("varStartPrice");
        element.classList.remove("error");
    }
    function removeerrorclassstart()
    {
        var element = document.getElementById("varQuantity");
        element.classList.remove("error");

        var elements = document.getElementById("varEndPrice");
        elements.classList.remove("error");
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
        if ((KeyID == 43) || (KeyID == 45) || (KeyID == 32) || (KeyID >= 97 && KeyID <= 122) || (KeyID >= 65 && KeyID <= 90) || (KeyID >= 33 && KeyID <= 39) || (KeyID == 42) || (KeyID >= 58 && KeyID <= 64) || (KeyID >= 91 && KeyID <= 96) || (KeyID >= 123 && KeyID <= 126))
        {
            return false;
        }
        return true;
    }
</script>
<script>

    function refreshcaptcha(base) {
<?php $url = $this->common_model->getUrl("pages", "2", '52', ''); ?>
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

<div class="container">
    <div class="row position-maintain" >         
        <div class="category-describe"><h1>Get Quote Now</h1></div>
    </div>
</div>
<div class="product-info col m12 s12 get-quots">
    <?php
//    echo MODULE_ID;
    $attributes = array('name' => 'Frmbuyleads', 'id' => 'Frmbuyleads', 'enctype' => 'multipart/form-data', 'class' => 'register-form', 'method' => 'post');
    $action = $this->common_model->getUrl("pages", "2", "52", '') . "/insert_rfq";
    echo form_open($action, $attributes);
    ?>

<!--    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.min.css">-->

    <!-- HTML !-->


    <!--<form class="register-form" action="otpsend.php" method="post">-->
    <div class="product-multi card">
        <div class="col m12 s12 multi-top">
            <!--            <div id="" class="col s12 m3 upload-attachment">
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
                        </div>-->
            <div class="col m3 s12 profile-up buyleadimg">

                <div class="profile-upload-user">

                    <div class="user-photo1">                     

                        <div id="image-preview1" class="buylead-img">

                            <label for="varImage" id="image-label1"><i class="fas fa-camera"></i></label>

                            <input type="file" name="varImage" id="varImage" accept=".png, .jpg, .jpeg, .gif" />

                        </div>

                    </div>  

                    <div id="varimageerror"></div>

                </div>

            </div>
            <div class="col m9 s12 product-up">
                <div class="upload-btn-wrapper">
                    <button class="btnsmart"><i class="fas fa-cloud-upload-alt"></i>Upload a file<a href="">Browse</a></button>
                    <input id="input_doc" name="files" type="file" class="multi" accept=".pdf, .doc, .docx, .csv, .xls, .xlsx, .ppt, .zip"/>
                </div>
                <div class="img-note"><p>Upload Files of format Only *.doc, *.docx, *.pdf, *.xls, *.xlsx, *.ppt *.zip and *.pptx file formats are supported.<br>Having maximum size of 10MB.</div>
                <div id="element"></div>
            </div>

        </div>
    </div>
    <div class="register-inner top-card card">         
        <div class="col m12 s12 padding margin-maintain">
            <div class="other-info-user">
                <div class="col m12 s12 padding"> 
                    <div class="col m12 s12">
                        <div class="basic-detail top-margin-none"><h2>Basic Information</h2></div>
                        <input type="hidden" id="intUser" name="intUser" value="<?php echo USER_ID; ?>">
                        <input type="hidden" id="intParentCategory" name="intParentCategory">
                        <div class="col m6 s12 ">
                            <div class="input-field field-custom">
                             <!-- <i class="material-icons prefix">textsms</i> -->
                                <input type="text" id="varProduct" autocomplete="off" name="varProduct" value="<?php echo $_REQUEST['varProduct']; ?>" class="autocomplete">
                                <label for="autocomplete-product-get">Product Name<sup>*</sup></label>
                            </div>
                        </div>
                        <div class="col m6 s12">
                            <div class="form-part">
                                <div class="input-field field-custom" id="varReqTypeerror">
                                    <?php echo $getReqType; ?>
                                    <label for="varReqType" class="stick-label">Requirement Type *</label>
                                </div>
                            </div>
                        </div>
                        <div class="col m12 s12 padding border-radius-none">
                            <div class="col m12 s12 ">
                                <div class="cat-note"><span>Category:  </span><span id="category_list"></span></div>
                                <div class="input-field field-custom" id="ProductCatList">
                                    <span class="product-category left" id="product-category"></span>
                                    <!--<iframe name="categorySelectIfram" scrolling="no" class="product-category-optional-iframe" style="overflow: hidden; position: static; left: auto;" marginwidth="0" marginheight="0" hspace="0" vspace="0" src="//mysourcing.alibaba.com/buyrequest/buyrequest_cate_iframe.htm?iframe_delete=true&amp;domain=alibaba.com&amp;iframe_delete=true" data-spm-anchor-id="a2700.8073620.2025477.i1.72a22b6fAKBoiA" data-spm-act-id="a2700.8073620.2025477.i1.72a22b6fAKBoiA" width="100%" height="294px" frameborder="0"></iframe>-->
                                    <?php echo $getParentCategory; ?>
<!--                                    <select  class="chosen-select" onchange="return getSubCategory(this.value);">
                                        <option>Select Category</option>
                                    </select>-->
                                </div>
                            </div>
                        </div>
                        <div class="spacer10"></div>
                        <div class="col s12 m12 padding">
                            <div class="col m6 s12 location-fill prefer-width">
                                <div class="input-field field-custom get-auto-change-size">
                                    <textarea id="txtDescription" name="txtDescription" class="materialize-textarea"><?php echo $_REQUEST['txtDescription']; ?></textarea>
                                    <label for="txtDescription">Description</label>
                                </div>
                            </div>
                            <div class="col m6 s12 padding get-bprder-mixed">
                                <div class="col m6 s6 more-info padding-right border-radius qty-paid">
                                    <div class="form-part margin-none">
                                        <div class="input-field field-custom">
                                            <input id="varQuantity" onkeypress="return removeerrorclass(), KeycheckOnlyNumeric(event);" name="varQuantity" value="<?php echo $_REQUEST['varQuantity']; ?>" type="text">
                                            <label for="varQuantity" class="">Qty</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col m6 s6 more-info padding-left border-radius">
                                    <div class="form-part margin-none">
                                        <div class="input-field field-custom" id="intUniterror">
                                            <?php echo $getUnitData; ?>
                                            <label for="intUnit" class="stick-label">Measurement Unit</label>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="col m6 s12 approx-time-get mixed margin-bottom-money">
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
                                        <input id="varStartPrice" value="<?php echo $_REQUEST['varStartPrice']; ?>" name="varStartPrice" onkeypress="return removeerrorclassstart(), KeycheckOnlyNumeric(event);" type="text">
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
                            <div class="col m6 s12  clear-both">
                                <div class="requirment">
                                    <label>Requirement Time :</label>
                                    <div class="radio-style col m3 s6">
                                        <label>
                                            <input class="with-gap" name="chrRequirement" id="chrUrgentRequirement" value="U" onclick="showDays();" type="radio" checked />
                                            <span>Urgent</span>
                                        </label>
                                    </div>
                                    <div class="radio-style col m5 s6"> 
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
                        </div>
                    </div>
                    <div class="col m12 s12 other-second basic-detail">
                        <h2>Other Details</h2>
                        <div class="col m6 s12 padding">
                            <!--<div class="col m12 s12 padding">-->
                            <div class="col m12 s12 more-info">
                                <div class="form-part margin-none">
                                    <div class="input-field field-custom">
                                        <input id="varLocation" name="varLocation" value="<?php echo $_REQUEST['varLocation']; ?>" type="text">
                                        <label for="varLocation" class="stick-label">Preferred Supplier Location 1</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col m12 s12 more-info">
                                <div class="form-part margin-none">
                                    <div class="input-field field-custom">
                                        <input id="varLocation2" name="varLocation2" value="<?php echo $_REQUEST['varLocation2']; ?>" type="text">
                                        <label for="varLocation2" class="stick-label">Preferred Supplier Location 2</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col m12 s12 more-info">
                                <div class="form-part margin-none">
                                    <div class="input-field field-custom">
                                        <input id="varLocation3" name="varLocation3" value="<?php echo $_REQUEST['varLocation3']; ?>" type="text">
                                        <label for="varLocation3" class="stick-label">Preferred Supplier Location 3</label>
                                    </div>
                                </div>
                            </div>
                            <input  type="hidden" name="varLatitude" id="varLatitude" value="<?php echo $_REQUEST['varLatitude']; ?>" >
                            <input type="hidden"  name="varLongitude" id="varLongitude" value="<?php echo $_REQUEST['varLongitude']; ?>">
                            <input  type="hidden" name="varLatitude2" id="varLatitude2" value="<?php echo $_REQUEST['varLatitude2']; ?>">
                            <input type="hidden"  name="varLongitude2" id="varLongitude2" value="<?php echo $_REQUEST['varLongitude2']; ?>">
                            <input  type="hidden" name="varLatitude3" id="varLatitude3" value="<?php echo $_REQUEST['varLatitude3']; ?>">
                            <input type="hidden"  name="varLongitude3" id="varLongitude3" value="<?php echo $_REQUEST['varLongitude3']; ?>">
                            <div class="col l12 m12 s12 more-info more-selection supplier-set-on">
                                <h6>Preffered Supplier Type</h6>
                                <div class="form-part">
                                    <div class="input-field field-custom">
                                        <?php echo $getBusinessType; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col s12 m6 padding">

                            <div class="col m12 s12">
                                <div class="input-field field-custom packing">
                                    <input id="varPackaging" value="<?php echo $_REQUEST['varPackaging']; ?>" name="varPackaging" type="text">
                                    <label for="varPackaging">Packing</label>
                                </div>
                            </div>
                            <div class="col m12 s12 padding">
                                <div class="col m12 s12 approx-time-get mixed ">
                                    <div class="col l2 m2 s2 more-info padding-right padding-left">
                                        <div class="form-part">
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
                                    </div>
                                    <div class="col l5 m5 s5 padding-right padding-left">
                                        <div class="input-field field-custom">
                                            <input id="varExpectedPrice" onkeypress="return KeycheckOnlyNumeric(event);" name="varExpectedPrice" value="<?php echo $_REQUEST['varExpectedPrice']; ?>" type="text">
                                            <label for="varExpectedPrice" class="">Expected Price</label>
                                        </div>
                                    </div>
                                    <div class="col l5 m5 s5 padding-right padding-left">
                                        <div class="input-field field-custom"  id="intEUnit">
                                            <?php echo $getExpUnitData; ?>
                                            <label for="intEUnit" class="stick-label">Unit Type</label>
                                        </div>
                                    </div> 
                                </div>    
                            </div>
                            <div class="col m12 s12 padding">
                                <div class="col m12 s12">
                                    <div class="input-field field-custom days-up change-get-day">
                                        <input id="varDestination" value="<?php echo $_REQUEST['varDestination']; ?>" type="text" name="varDestination">
                                        <label for="varDestination">Destination Port</label>
                                    </div>      
                                </div>
                            </div>
                            <div class="col m12 s12">
                                <div class="requirment change-to-top ">
                                    <label>Want To Import :</label>
                                    <div class="radio-style col m3 s6">
                                        <label>
                                            <input class="with-gap" name="chrImport" id="chrYImport" type="radio" value="Y"  />
                                            <span>Yes</span>
                                        </label>
                                    </div>
                                    <div class="radio-style col m5 s6"> 
                                        <label>
                                            <input class="with-gap" name="chrImport" id="chrNImport" type="radio" checked value="N"/>
                                            <span>No</span>
                                        </label>
                                    </div> 
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div class="col s12 m12">
            <div class="code" id="captchaImage"> 

                <input type="button" class="no-click" readonly id="pin_img" value="<?php echo $generated_pin; ?>">
                <a onclick="return refreshcaptcha('<?= base_url(); ?>');" title="Refresh" class="Refresh" href="javascript:;"><i class="fas fa-sync-alt"></i></a>
                <div class="col m2 s5 captcha-note">
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
        <div class="col m12 s12">
            <div class="register-submit all-same product-page-btn">
                <button class="waves-effect waves-light btn same-btn" type="submit">Submit</button>
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
