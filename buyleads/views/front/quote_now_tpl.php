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
</style>
<script>
    function counttotal()
    {
//        varTransportation
        var price = document.getElementById("varPrice").value;
        var tax = document.getElementById("intTax").value;
        $('#pricedata').html("&#x20B9;" + price);
        if (tax != '') {
//            $('#taxdata').html(tax + "%");
            var totalprice = (100 * parseFloat(tax)) / parseFloat(price);
            var totalprice = (parseFloat(tax) * parseFloat(price)) / 100;
            var Totalval = parseFloat(totalprice) + parseFloat(price);
            if (document.getElementById('TransportationE').checked == true) {
                var varTransportation = document.getElementById("varTransportation").value;
                if (varTransportation == '') {
                    varTransportation = 0;
                }
                Totalval = Totalval + parseFloat(varTransportation);
            }
            $('#totalpricedata').html("&#x20B9;" + Totalval);
        } else {
            var Totalval = parseFloat(price);
            if (document.getElementById('TransportationE').checked == true) {
                var varTransportation = document.getElementById("varTransportation").value;
                if (varTransportation == '') {
                    varTransportation = 0;
                }
                Totalval = Totalval + parseFloat(varTransportation);
            }
            $('#totalpricedata').html("&#x20B9;" + Totalval);
        }
    }
    function remove_moq_unitclass(id = "")
    {
        document.getElementById('intUnit').value = id;
        var element = document.getElementById("intPriceUniterror");
        element.classList.remove("intPriceUniterror");

        var element = document.getElementById("intMOQUniterror");
        element.classList.remove("intMOQUniterror");

    }
    function removeunitclass(id = "")
    {
        document.getElementById('intMOQUnit').value = id;

        var element = document.getElementById("intMOQUniterror");
        element.classList.remove("intMOQUniterror");

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
        document.getElementById('acceptTerms').addEventListener('click', function (e) {
            document.getElementById('sub1').disabled = !e.target.checked;
        })
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
        $("#FrmQuoteNow").validate({
            ignore: [],
            rules: {
                varName: {
                    required: true
                },
                txtDescription: {
                    required: true
                },
                varCurrency: {
                    required: true
                },
                varPrice: {
                    required: true
                },
                varMOQ: {
                    required: true
                },
                intUnit: {
                    required: true
                },
                intMOQUnit: {
                    required: true
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
                } else if ($(element).attr('id') == 'intUnit')
                {
                    $('#intPriceUniterror').addClass('intPriceUniterror');
                    error.appendTo('#intPriceUniterror');
                } else if ($(element).attr('id') == 'captchaimage1')
                {
                    error.insertAfter($(".replacecaptcha"));
                }
            },
            submitHandler: function (form) {

//                var $fields = $(this).find('input[name="intPaymentTerms"]:checked');
//                if (!$fields.length) {
                var fields = $("input[name='intPaymentTerms[]']").serializeArray();
                if (fields.length == 0)
                {
                    M.toast({html: 'You must check at least one payment terms.'});
                    return false; // The form will *not* submit
                }

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
    $(document).ready(function ()
    {
        $('.addss').click(function () {
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
    $attributes = array('name' => 'FrmQuoteNow', 'id' => 'FrmQuoteNow', 'enctype' => 'multipart/form-data', 'class' => 'register-form all-product-form', 'method' => 'post');
    $action = $this->common_model->getUrl("pages", "2", "100", '') . "/insert_quotenow";
    echo form_open($action, $attributes);
    $BuyLead = $this->input->get_post('buylead');
    if ($BuyLead != '') {
        $buylead = $BuyLead;
    } else {
        $buylead = "";
    }
    ?>
    <input type="hidden" id="tmpimage" name="tmpimage">
    <input type="hidden" value="<?php echo $buylead; ?>" id="buylead" name="buylead">
    <input type="hidden" value="<?php echo USER_ID; ?>" id="intUser" name="intUser">
    <input type="hidden" id="varMaterial" name="varMaterial">
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
    <?php
    $row = $this->Module_Model->getBuyLeadData();
    ?>
    <div class="register-inner top-card ">         
        <div class="col m12 s12 padding margin-maintain">
            <div class="other-info-user">
           
              <div class="basic-snap card">
                <div class="col m12 s12 padding"> 
                    <div class="col m12 s12">
                        <div class="basic-detail top-margin-none"><h2>Basic Details</h2></div>
                        <div class="col m6 s12 ">
                            <div class="input-field field-custom">
                                <input type="text" id="varName" name="varName" value="<?php echo $row['varName']; ?>" class="autocomplete">
                                <label for="varName">Product Name<sup>*</sup></label>
                            </div>
                        </div>
                        <div class="col m6 s12">
                            <div class="input-field field-custom">
                                <input id="varHSCode" type="text" name="varHSCode" value="<?php echo $row['varHSCode']; ?>">
                                <label for="varHSCode">HS Code</label>
                            </div>
                        </div>
                        <div class="col s12 m6 padding">
                            <div class="col m12 s12 clear-both padding get-bprder-mixed">
                                <div class="col m6 s6 more-info padding-right border-radius qty-paid">
                                    <div class="form-part margin-none">
                                        <div class="input-field field-custom">
                                            <input id="varMOQ" name="varMOQ" type="text">
                                            <label for="varMOQ">Qty<sup>*</sup></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col m6 s6 more-info padding-left border-radius">
                                    <div class="form-part margin-none">
                                        <div class="input-field field-custom" id="intMOQUniterror">
                                            <?php echo $getMOQUnitData; ?>
                                            <label for="intMOQUnit" class="stick-label">Select Measurement Unit<sup>*</sup></label> 
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="col m12 s12 other-second">
                                <div class="col m12 s12 mixed padding  currency-width-product">
                                    <div class="col l2 m3 s3 padding">
                                        <div class="input-field field-custom">
                                            <select  id="varCurrency" name="varCurrency"> 
                                                <option value="1" selected="">&#8377;</option>
                                                <option value="2">$</option>
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="col m5 s5 padding">
                                        <div class="input-field field-custom">
                                            <input id="varPrice" name="varPrice" onchange="return counttotal()" type="text" onkeypress="return KeycheckOnlyNumeric(event);">
                                            <label for="varPrice">Price<sup>*</sup></label>
                                        </div>
                                    </div> 
                                    <div class="col l5 m4 s4 padding">
                                        <div class="input-field field-custom" id="intPriceUniterror">
                                            <?php echo $getPriceUnitData; ?>
                                            <label for="intPriceUnit" class="stick-label">Select Unit<sup>*</sup></label> 
                                        </div>
                                    </div>
                                </div>
                            </div>   
                        </div>
                        <div class="col m6 s12 location-fill prefer-width heightcancle">
                            <div class="input-field field-custom">
                                <textarea id="txtDescription" name="txtDescription" class="materialize-textarea"></textarea>
                                <label for="txtDescription">Description <sup>*</sup></label>
                            </div>
                        </div>
                        <div class="col m12 s12">
                            <div class="col m12 s12 padding">
                                <div class="more-info height-chips get-quots-chips">
                                    <div class="form-part">
                                        <label for="varMaterials" class="stick-label set-addprod"><span class="hints">(Press Enter To Add Multiple keyword)</span></label>
                                        <div class="chips chips-autocomplete field-custom mCustomScrollbar light" id="varMaterials" name="varMaterials" data-mcs-theme="minimal-dark">
                                            <input class="custom-class" value=""  placeholder="Material">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="col m12 s12 padding">
                            <div class="col m6 s12 location-fill prefer-width">
                                <div class="input-field field-custom">
                                    <textarea id="txtUses" name="txtUses" class="materialize-textarea"></textarea>
                                    <label for="txtUses">Uses</label>
                                </div>
                            </div>
                            <div class="col m6 s12 location-fill prefer-width">
                                <div class="input-field field-custom">
                                    <textarea id="txtPackaging" name="txtPackaging" class="materialize-textarea"></textarea>
                                    <label for="txtPackaging">Packaging</label>
                                </div>
                            </div>

                        </div>
                        <input type="hidden" name="file_hd" id="file_hd" value="1">
                        <div class="col m12 s12 padding">
                            <h6 class="margin-none">Feature</h6>
                            <div class="col m12 s12 value-add padding">       
                                <div class="col m6 s5">
                                    <div class="input-field field-custom">
                                        <input id="varSTitle1" name="varSTitle1" type="text">
                                        <label for="varSTitle1" class="">Title</label>
                                    </div>
                                </div> 
                                <div class="col m5 s5">
                                    <div class="input-field field-custom">
                                        <input id="varSvalue1" name="varSvalue1" type="text">
                                        <label for="varSvalue1" class="">Value</label>
                                    </div>
                                </div> 
                            </div>
                            <div id="varFeaturesdiv"> 
                                <span id="adds"></span>
                                <div class="plus-icon">
                                    <a href="javascript:;" class="addss waves-effect waves-light btn"><i class="fas fa-plus-square"></i>Add Field</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
   
           <div class="other-click card">
                <div class="col m12 s12 basic-detail">
                    <h2>Other Details</h2>
                    <div class="col m3 s12 ">
                        <div class="requirment free-quotsreaq">
                            <label>Free Sample:</label>
                            <div class="radio-style col m4 s4">
                                <label>
                                    <input class="with-gap" name="chrSample" id="chrSampleY" value="Y"  type="radio">
                                    <span>Yes</span>
                                </label>
                            </div>
                            <div class="radio-style col m4 s4"> 
                                <label>
                                    <input class="with-gap" name="chrSample"  checked="" id="chrSampleN" value="N" type="radio">
                                    <span>No</span>
                                </label>
                            </div>   
                        </div>
                    </div>

                    <div class="col s12 m7 padding">
                        <h6 class="click-center">Delivery Time</h6>
                        <div class="col m4 s4">
                            <div class="input-field field-custom">
                                <input id="intDays" name="intDays" type="text" onkeypress="return KeycheckOnlyNumeric(event);">
                                <label for="intDays" class="">Days</label>
                            </div>
                        </div>  
                        <div class="linesource padding">After </div>
                        <div class="col l5 m4 s8">
                            <div class="input-field field-custom">
                                <select id="varSupplierDeliveryTime" name="varSupplierDeliveryTime">
                                    <option value="" disabled selected>Supplier Confirmed</option>
                                    <option value="1">Order</option>
                                    <option value="2">Initial Payment</option>
                                    <option value="3">Total Payment</option>
                                </select>
                                <!-- <label>Sub Category</label> -->
                            </div>
                        </div>

                    </div>
                </div>

            </div>


           <div class="logisticcard card">
                <div class="col m12 s12  basic-detail">
                    <h2>Logistic</h2>
                    <div class="col m6 s12  basic-detail padding">
                        <div class="requirment">
                            <label>Shipping method:</label>
                            <div class="radio-style col m2 s3">
                                <label>
                                    <input class="with-gap" name="varShipping" id="varShippingSea" type="radio">
                                    <span>Sea</span>
                                </label>
                            </div>
                            <div class="radio-style col m4 s6"> 
                                <label>
                                    <input class="with-gap" checked name="varShipping" id="varShippingLand" type="radio">
                                    <span>Land transport </span>
                                </label>
                            </div> 
                            <div class="radio-style col m2 s2"> 
                                <label>
                                    <input class="with-gap" name="varShipping" id="varShippingAir" type="radio">
                                    <span>Air</span>
                                </label>
                            </div>   
                        </div>
                    </div>
                </div>
       


                <?php
                $getSellername = $this->Module_Model->getUserName(USER_ID);
                $getBuyname = $this->Module_Model->getUserName($row['intUser']);
                ?>
                <div class="col m6 s12">
                    <!--<div class="col m6 s12 basic-detail">-->
                    <div class="requirment">
                        <label>Arrange By:</label>

                        <div class="radio-style col m4 s4">
                            <label>
                                <input checked class="with-gap" name="varArrangeBy" value="<?php echo USER_ID; ?>" id="varArrangeBySeller" type="radio">
                                <span><?php echo $getSellername; ?></span>
                            </label>
                        </div>
                        <div class="radio-style col m6 s6"> 
                            <label>
                                <input class="with-gap" name="varArrangeBy" value="<?php echo $row['intUser']; ?>" id="varArrangeByBuyer" type="radio">
                                <span><?php echo $getBuyname; ?></span>
                            </label>
                        </div> 

                    </div>
                    <!--</div>-->
                </div>
                <div class="col m6 s12">
                    <!--<div class="col m6 s12 basic-detail">-->
                    <div class="requirment">
                        <label>Paid By:</label>
                        <div class="radio-style col m4 s3">
                            <label>
                                <input checked class="with-gap" name="varPaidBy" value="<?php echo USER_ID; ?>" id="varPaidBySeller" type="radio">
                                <span><?php echo $getSellername; ?></span>
                            </label>
                        </div>
                        <div class="radio-style col m6 s6"> 
                            <label>
                                <input class="with-gap" name="varPaidBy" value="<?php echo $row['intUser']; ?>" id="varPaidByBuyer" type="radio">
                                <span><?php echo $getBuyname; ?></span>
                            </label>
                        </div> 

                    </div>
                    <!--</div>-->

                </div>
            </div>

              <div class="card paymentcard">
                <div class="col s12 m12">
                    <h5>Trade Information</h5>
                    <div class="col m12 s12 padding change-payment-view">
                        <h6>Payment Type</h6>
                        <?php
                        echo $getPaymentTypeData;
                        ?> 
                    </div>

                    <div class="col m12 s12 padding check-heading basic-detail">
                        <h6>Payment Terms</h6>
                        <?php
                        echo $getPaymentTermsData;
                        ?> 
                    </div>
             </div>
 </div>
              <div class="card paymentcard">
                    <div class="col s12 m12 basic-detail">
                        <h2>Special Note </h2>
                        <div class="col m12 s12 location-fill prefer-width">
                            <div class="input-field field-custom note-special">
                                <textarea id="txtNote"  name="txtNote" class="materialize-textarea"></textarea>
                                <label for="txtNote">Special Note</label>
                            </div>
                        </div>
                    </div>
                </div>


<div class="card total-paymrent">

                <div class="col s12 m12 padding">
                    <div class="total-value">
                        <div class="price-valuequote"><span>Net Amount:</span><span id="pricedata">&#x20B9;0</span></div>
                        <div class="price-valuequote">
                            <div class="col m12 s12 taxcopy">
                                <span id="taxdatas">Tax: </span>
                                <div class="input-field field-custom">
                                    <input id="intTax" name="intTax" type="text" maxlength="2" onchange="return counttotal()" onkeypress="return KeycheckOnlyNumeric(event);">
                                </div>
                                %
                            </div>
                            <!--<span id="taxdata"></span>-->
                        </div>
                        <div class="price-valuequote"><span style="float: left;">Transportation:</span>
                            <div class="trans-price">
                                <div class="radio-style col m3 s12">
                                    <label>
                                        <input class="with-gap" value="I" onclick="return counttotal();" checked="" name="chrTransportation" id="TransportationI" type="radio">
                                        <span>Include</span>
                                    </label>
                                </div>
                                <div class="radio-style col m3 s12"> 
                                    <label>
                                        <input class="with-gap" value="E" onclick="return counttotal();" name="chrTransportation" id="TransportationE" type="radio">
                                        <span>Exclude</span>
                                    </label>
                                </div>
                                <div class="col l12 m12 s12" id="TransportationTxt">
                                    <div class="input-field field-custom">
                                        <input onchange="return counttotal();" id="varTransportation" name="varTransportation" onkeypress="return KeycheckOnlyNumeric(event);" type="text">
                                        <label for="varTransportation">Transportation Amount</label>
                                    </div>      
                                </div>
                            </div>
                        </div>
                        <div class="price-valuequote"><span>Final Amount:</span><span id="totalpricedata">&#x20B9;0</span></div>
                    </div>
                </div>
</div>


                <div class="col m12 s12 accept-terms">
                    <div class="input-field field-custom">
                        <label>
                            <input type="checkbox" id="acceptTerms" class="filled-in" />
                            <span></span>            
                        </label>
                        <a href="#terms-condition-popup" class="accept-popup modal-trigger">I accept terms & condition<sup>*</sup></a>
                    </div>
                </div>
                <div class="col s12 m12">
                    <div class="contect-send">
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
                    <span class="msg-error error"></span>
                </div>
            </div>
        </div>
        <div class="col m12 s12">
            <div class="register-submit all-same product-page-btn">
                <button disabled=""  class="waves-effect waves-light btn same-btn" id="sub1">Quote Now</button>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<div id="terms-condition-popup" class="modal modal-fixed-footer get-quot-popup">
    <?php
    $content = $this->common_model->getContent(87);
    echo $content;
    ?>
    <div class="close-outside"><a href="javascript:;" class="modal-close waves-effect waves-blue btn-flat"><i class="fas fa-times"></i></a></div>
</div>
<script src="<?php echo FRONT_MEDIA_URL; ?>js/file-upload-with-preview.js"></script>
<script>
                                //Second upload
                                var secondUpload = new FileUploadWithPreview('mySecondImage')
//                                                var secondUploadInfoButton = document.querySelector('.upload-info-button--second');
//                                                secondUploadInfoButton.addEventListener('click', function () {
//                                            console.log('Second upload:', secondUpload, secondUpload.cachedFileArray)
//                                                })
</script>
