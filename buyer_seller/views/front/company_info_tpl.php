<style>

    #percentageError {
        display: none;
    }
</style>
<script type="text/javascript">
    function deletecompany_photo(id) {
        document.getElementById('del_com' + id).style.display = 'none';
        var url = "<?php echo $this->common_model->getUrl("pages", "2", "96", '') . '/delete_company_image?int_id='; ?>" + id;
        $.ajax({
            type: "GET",
            url: encodeURI(url),
            async: true,
            success: function (data) {
            }
        });
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode == 46) || (charCode <= 40 && charCode >= 37)) {
            return true;
        } else if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    function getProgress(val) {
        var ind = document.getElementById("varIndiaMarkets").value;
        if (ind == '') {
            ind = 0;
        } else {
            ind = parseInt(document.getElementById("varIndiaMarkets").value);
        }
        var asia = document.getElementById("varAsiaMarkets").value;
        if (asia == '') {
            asia = 0;
        } else {
            asia = parseInt(document.getElementById("varAsiaMarkets").value);
        }
        var euro = document.getElementById("varEuropeMarkets").value;
        if (euro == '') {
            euro = 0;
        } else {
            euro = parseInt(document.getElementById("varEuropeMarkets").value);
        }
        var afr = document.getElementById("varAfricaMarkets").value;
        if (afr == '') {
            afr = 0;
        } else {
            afr = parseInt(document.getElementById("varAfricaMarkets").value);
        }
        var mde = document.getElementById("varMiddleEastMarkets").value;
        if (mde == '') {
            mde = 0;
        } else {
            mde = parseInt(document.getElementById("varMiddleEastMarkets").value);
        }
        var noame = document.getElementById("varNorthAmericaMarkets").value;
        if (noame == '') {
            noame = 0;
        } else {
            noame = parseInt(document.getElementById("varNorthAmericaMarkets").value);
        }
        var soame = document.getElementById("varSouthAmericaMarkets").value;
        if (soame == '') {
            soame = 0;
        } else {
            soame = parseInt(document.getElementById("varSouthAmericaMarkets").value);
        }
        var aus = document.getElementById("varAustraliaMarkets").value;
        if (aus == '') {
            aus = 0;
        } else {
            aus = parseInt(document.getElementById("varAustraliaMarkets").value);
        }
        var newz = document.getElementById("varNewZealandMarkets").value;
        if (newz == '') {
            newz = 0;
        } else {
            newz = parseInt(document.getElementById("varNewZealandMarkets").value);
        }
        var total = ind + asia + euro + afr + mde + noame + soame + aus + newz;
        document.getElementById('percentage').value = total;
        if (total <= 100) {
            document.getElementById('percentagetxt').style.display = 'none';
            $('#getAvg').html(total + "%");
            var div = document.getElementById('determinate');
            div.setAttribute('style', '');
            div.removeAttribute('style');
            div.style.width = total + "%";
        } else {
            document.getElementById('percentagetxt').style.display = '';
            return false;
        }
    }
    function sameaddress() {
        var chrAddressSame = document.getElementById("chrAddressSame").checked;
        if (chrAddressSame == true) {
            document.getElementById("varLocation1").value = document.getElementById("varLocation").value;
            document.getElementById("location1").value = document.getElementById("location").value;
//            document.getElementById("route1").value = document.getElementById("route").value;
            document.getElementById("locality1").value = document.getElementById("locality").value;
            document.getElementById("administrative_area_level_11").value = document.getElementById("administrative_area_level_1").value;
            document.getElementById("country1").value = document.getElementById("country").value;
            document.getElementById("postal_code1").value = document.getElementById("postal_code").value;
            document.getElementById("varLatitude1").value = document.getElementById("varLatitude").value;
            document.getElementById("varLongitude1").value = document.getElementById("varLongitude").value;
        } else {
            document.getElementById("varLocation1").value = "";
            document.getElementById("location1").value = "";
//            document.getElementById("route1").value = "";
            document.getElementById("locality1").value = "";
            document.getElementById("administrative_area_level_11").value = "";
            document.getElementById("country1").value = "";
            document.getElementById("postal_code1").value = "";
            document.getElementById("varLatitude1").value = "";
            document.getElementById("varLongitude1").value = "";
        }
    }
    function removecompanyfile(name) {
        document.getElementById('companytmpimage').value = name + "," + document.getElementById('companytmpimage').value;
        var divsToHide = document.getElementsByClassName("pips" + name); //divsToHide is an array
        for (var i = 0; i < divsToHide.length; i++) {
            divsToHide[i].style.visibility = "hidden"; // or
            divsToHide[i].style.display = "none"; // depending on what you're doing
        }
    }
    $(document).ready(function () {
        var j = 0;
        if (window.File && window.FileList && window.FileReader) {
            $("#varCompanyImages").on("change", function (e) {
                var files = e.target.files,
                        filesLength = files.length;
                var selection = document.getElementById('varCompanyImages');
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
                        $('<div class="upload-boxes pips' + j + '">\n\
                                <div class="image-source card">\n\
                                    <a href="javascript:;" class="remove" onclick=\'return removecompanyfile("' + j + '")\'><i class="far fa-times-circle"></i></a>\n\
                                    <img src="' + e.target.result + '" alt="' + file.name + '">\n\
                                </div>\n\
                            </div>').insertAfter("#companyimages");
                        j++;
                    });
                    fileReader.readAsDataURL(f);
                }
            });
        } else {
            alert("Your browser doesn't support to File API")
        }
    });
    $(document).ready(function () {
        $.validator.addMethod("phonenumber", function (value, element) {
            var numberPattern = /\d+/g;
            var newVal = value.replace(/\D/g, '');
            if (parseInt(newVal) <= 0)
            {
                return false;
            } else
            {
                return true;
            }
        }, "Please enter a valid number.");
        $("#FrmCompanyInfo").validate({
            ignore: [],
            rules: {
                varCompany: {
                    required: true
                },
                varOwnerType: {
                    required: true
                },
                varBusinessType: {
                    required: true
                },
                varCompanyInfo: {
                    required: true
                },
                percentage: {
                    max: 100
                },
                varCompanyEmail: {
                    email: true,
                    required: true
                },
                varBranchLocationEmail: {
                    email: true
                },
                varBranchLocationPhone: {
                    maxlength: 20,
                    phonenumber: {
                        depends: function () {
                            if (($("#varBranchLocationPhone").val()) != '') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                varCompanyPhone: {
                    minlength: 5,
                    required: true,
                    maxlength: 20,
                    phonenumber: {
                        depends: function () {
                            if (($("#varCompanyPhone").val()) != '') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                }
            },
            errorPlacement: function (error, element) {
                if ($(element).attr('id') == 'percentage')
                {
                    error.appendTo('#percentageError');
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });


    $(document).ready(function ()
    {
        $('.addemob').click(function () {
            var mecounter = document.getElementById('addemobcount').value;
            var mecounter1 = Number(mecounter) + 1;
            document.getElementById('addemobcount').value = mecounter1;
            $("#addemobdiv").append('\n\
<div><div class="col m12 l6 s12">\n\
                                    <div class="input-field change-ipad first-varaa">\n\
                                        <input id="varCompanyEmail' + mecounter1 + '" name="varCompanyEmail' + mecounter1 + '" value="" type="email">\n\
                                        <label for="varCompanyEmail' + mecounter1 + '" class="">Company Email</label>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="col l1 m2 s2 padding-right">\n\
                                    <div class="input-field countrycode code-changes change-width-code field-custom">\n\
                                        <input id="intCountryCode' + mecounter1 + '"  maxlength="4 name="intCountryCode' + mecounter1 + '"" value="+91" autocomplete="off" type="text" onkeypress="return KeycheckOnlyNumeric(event);">\n\
                                    </div>\n\
                                </div>\n\
                                <div class="col m4 s12">\n\
                                    <div class="input-field first-varaa">\n\
                                        <input id="varCompanyPhone' + mecounter1 + '"  maxlength="10" value="" onkeypress="return KeycheckOnlyNumeric(event);" name="varCompanyPhone' + mecounter1 + '" type="text">\n\
                                        <label for="varCompanyPhone' + mecounter1 + '" class="">Mobile Number</label>\n\
                                    </div>\n\
                                </div>\n\
<div class="col m1 s2 delet-icon removeemob"><a href="javascript:;"><i class="fas fa-trash-alt"></i></a></div></div>');

        });

        $(document).on('click', '.removeemob', function () {
            $(this).parent('div').remove();
        });

        $('.add').click(function () {
            var counter = document.getElementById('brachcount').value;
            var counter1 = Number(counter) + 1;
            document.getElementById('brachcount').value = counter1;
            $("#brachadds").append('<hr><div class="col m4 s12 ">\n\
                                            <div class="requirment trad-mark">\n\
                                                <div class="radio-style col m3 s6">\n\
                                                    <label>\n\
                                                        <input class="with-gap" checked name="chrBranchFranchise' + counter1 + '" id="chrBranchFranchise' + counter1 + 'Y" type="radio" value="B" type="radio">\n\
                                                        <span>Branch</span>\n\
                                                    </label>\n\
                                                </div>\n\
                                                <div class="radio-style col m3 s6"> \n\
                                                    <label>\n\
                                                        <input class="with-gap" name="chrBranchFranchise' + counter1 + '" id="chrBranchFranchise' + counter1 + 'N" value="F" type="radio">\n\
                                                        <span>Franchise</span>\n\
                                                    </label>\n\
                                                </div>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col m4 s12">\n\
                                            <div class="input-field company-width">\n\
                                                <input id="varBranchCompanyName' + counter1 + '" name="varBranchCompanyName' + counter1 + '" type="text">\n\
                                                <label for="varBranchCompanyName' + counter1 + '" class="">Company Name</label>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col m4 s12">\n\
                                            <div class="input-field company-width">\n\
                                                <input id="varBranchPersonName' + counter1 + '" name="varBranchPersonName' + counter1 + '" type="text">\n\
                                                <label for="varBranchPersonName' + counter1 + '" class="">Contact Person Name</label>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="clear"></div>\n\
                                        <div class="col m6 s12">\n\
                                            <div class="input-field add-main company-width">\n\
                                                <input id="varBranchLocation' + counter1 + '" placeholder="" name="varBranchLocation' + counter1 + '" type="text">\n\
                                                <label for="varBranchLocation' + counter1 + '" class="">Branch Location</label>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col m6 s12">\n\
                                            <div class="input-field add-main company-width">\n\
                                                <input id="BranchLocation' + counter1 + '" name="varBranchAddress' + counter1 + '" type="text">\n\
                                                <label for="BranchLocation' + counter1 + '" class="">Street Address</label>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col m4 s12">\n\
                                            <div class="input-field add-main corporate-add-field">\n\
                                                <input id="varBranchCity' + counter1 + '" name="varBranchCity' + counter1 + '" type="text">\n\
                                                <label for="varBranchCity' + counter1 + '" class="">City</label>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col m4 s12">\n\
                                            <div class="input-field add-main corporate-add-field">\n\
                                                <input name="varBranchPostCode' + counter1 + '" id="varBranchPostCode' + counter1 + '" type="text">\n\
                                                <label for="varBranchPostCode' + counter1 + '" class="">Pincode</label>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col m4 s12 more-info">\n\
                                            <div class="form-part">\n\
                                                <div class="input-field field-custom">\n\
                                                    <input name="varBranchDesignation' + counter1 + '" id="varBranchDesignation' + counter1 + '" type="text">\n\
                                                    <label for="varBranchDesignation' + counter1 + '">Designation</label>\n\
                                                </div>\n\
                                            </div>\n\
                                        </div> \n\
                                        <div class="col l1 m1 s2 padding-right">\n\
                                            <div class="input-field countrycode code-changes field-custom company-minus">\n\
                                                <input id="intBranchCountryCode' + counter1 + '" name="intBranchCountryCode' + counter1 + '" value="+91"  maxlength="4" readonly="" autocomplete="off" type="text" onkeypress="return KeycheckOnlyNumeric(event);">\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col m3 s10 padding-left">\n\
                                            <div class="input-field mobile-minus">\n\
                                                <input id="varBranchLocationPhone' + counter1 + '" name="varBranchLocationPhone' + counter1 + '" type="text"  maxlength="10" onkeypress="return KeycheckOnlyNumeric(event);">\n\
                                                <label for="varBranchLocationPhone' + counter1 + '" class="">Mobile Number</label>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col m4 s12">\n\
                                            <div class="input-field loaction-find corporate-add-field1">\n\
                                                <input id="varBranchLocationEmail' + counter1 + '" name="varBranchLocationEmail' + counter1 + '" type="email">\n\
                                                <label for="varBranchLocationEmail' + counter1 + '" class="">Email</label>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col m4 s12">\n\
                                            <div class="input-field">\n\
                                                <input id="varBranchLocationTel' + counter1 + '" name="varBranchLocationTel' + counter1 + '" type="text" onkeypress="return KeycheckOnlyNumeric(event);">\n\
                                                <label for="varBranchLocationTel' + counter1 + '" class="">Telephone Number</label>\n\
                                            </div>\n\
                                        </div>');
        });


        $('.addTaxation').click(function () {
            var taxcounter = document.getElementById('taxationcount').value;
            var taxcounter1 = Number(taxcounter) + 1;
            document.getElementById('taxationcount').value = taxcounter1;
            $("#taxationadds").append('<div><hr><div class="col m5 s12">\n\
    <div class="input-field field-custom  three-combine corporate-add-field change-tax">\n\
        <input name="varTaxation' + taxcounter1 + '" type="text">\n\
        <label for="varTaxation' + taxcounter1 + '" class="">Title (eg. TAN No)</label>\n\
    </div>\n\
</div>\n\
<div class="col m6 s12">\n\
    <div class="input-field field-custom  three-combine corporate-add-field change-tax">\n\
        <input name="varTaxationAns' + taxcounter1 + '" type="text">\n\
        <label for="varTaxationAns' + taxcounter1 + '" class="">Value (eg. SAD110904GF)</label>\n\
    </div>\n\
</div><div class="col m1 s2 delet-icon removetax"><a href="javascript:;"><i class="fas fa-trash-alt"></i></a></div></div>');
        });



        $(document).on('click', '.removetax', function () {
            $(this).parent('div').remove();
        });
        $(document).on('click', '.remove', function () {
            $(this).parent('div').remove();
        });
    });


</script>




<div class="col l12 m12 s12">
    <div class="steps-profile">
        <!-- progressbar -->
        <ul id="progressbar">
            <li class="progress-active"><a href="<?php echo $this->common_model->getUrl("pages", "2", "95", ''); ?>"><span>1.</span>Account Setup</a></li>
            <li class="active"><span>2.</span>Company Information</li>
            <li><span>3.</span>Company Certificate</li>
            <li><span>4.</span>Banking Information</li>
            <li><span>5.</span>Trade Shows And Events</li>
        </ul>
    </div>
</div>
<div class="col l12 m12 s12">
    <div class="product-multi1 card">          
        <div class="form_detail">
            <?php
            $getUserdata = $this->Module_Model->getUserProfile(USER_ID);
            $attributes = array('name' => 'FrmCompanyInfo', 'id' => 'FrmCompanyInfo', 'enctype' => 'multipart/form-data', 'class' => 'padding-all', 'method' => 'post');
            $action = $this->common_model->getUrl("pages", "2", "96", '') . "/add_companyinfo";
            echo form_open($action, $attributes);
            ?>
            <fieldset>
                <div class="company-information">
                    <div class="col s12 m12 padding company-title">
                        <div class="card display-bl">
                            <h2>Company details</h2>
                            <div class="col m6 s12 padding">
                                <input type="hidden" id="intUser" name="intUser" value="<?php echo USER_ID; ?>">    
                                <div class="col m12 s12">
                                    <div class="input-field company-width   first-varaa">
                                        <input id="varCompany"  readonly="" name="varCompany" value="<?php echo $getUserdata['varCompany']; ?>" type="text">
                                        <label for="varCompany" class="">Company Name<sup>*</sup></label>
                                    </div>
                                </div>
                                <div class="col l12 m12 s12 more-info more-selection busyness-change">
                                    <h6>Business Type<sup>*</sup> &nbsp;&nbsp;<label for="varBusinessType" class="stick-label set-addprod"></label></h6>
                                    <div class="form-part">
                                        <div class="input-field field-custom">
                                            <?php echo $getBusinessType; ?>
                                            <!--varBusinessType-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col m12 l6 s12">
                                    <div class="input-field change-ipad first-varaa">
                                        <input id="varCompanyEmail" readonly="" name="varCompanyEmail" value="<?php echo $getUserProfile['varEmail']; ?>" type="email">
                                        <label for="varCompanyEmail" class="">Company Email<sup>*</sup></label>
                                    </div>
                                </div>
                                <div class="col l1 m2 s2 padding-right">
                                    <div class="input-field countrycode code-changes change-width-code field-custom">
                                        <input id="intCountryCode" name="intCountryCode" value="+91" autocomplete="off"   maxlength="4" type="text" onkeypress="return KeycheckOnlyNumeric(event);">
                                    </div>
                                </div>
                                <div class="col m4 s12">
                                    <div class="input-field first-varaa">
                                        <input id="varCompanyPhone" readonly="" value="<?php echo $getUserProfile['varPhone']; ?>"  maxlength="10" onkeypress="return KeycheckOnlyNumeric(event);" name="varCompanyPhone" type="text">
                                        <label for="varCompanyPhone" class="">Mobile Number<sup>*</sup></label>
                                    </div>
                                </div>
                                <?php $varCompanyMultiEmails = explode("__", $getCompanydata['varCompanyMultiEmails']);
                                ?>
                                <input type="hidden" id="addemobcount" name="addemobcount" value="<?php echo count($varCompanyMultiEmails); ?>">
                                <div class="col l1 m2 s2 delet-icon addemob"><a href="javascript:;"><i class="fas fa-plus-square"></i></a></div>
                                <?php
                                $intCountryMultiCode = explode("__", $getCompanydata['intCountryMultiCode']);
                                $varCompanyMultiPhone = explode("__", $getCompanydata['varCompanyMultiPhone']);
                                $t = 0;
                                $k = 0;
//                                foreach ($varCompanyMultiEmails as $emob) {
                                for ($k = 0; $k < count($varCompanyMultiEmails); $k++) {
                                    if ($varCompanyMultiEmails[$t] != '') {
                                        $EmailVal = 'varCompanyEmail' . $k . '';
                                        $CCVal = 'intCountryCode' . $k . '';
                                        $CPVal = 'varCompanyPhone' . $k . '';
                                        ?>
                                        <div>
                                            <div class="col m12 l6 s12">
                                                <div class="input-field change-ipad first-varaa">
                                                    <input id="<?php echo $EmailVal; ?>" name="<?php echo $EmailVal; ?>" value="<?php echo $varCompanyMultiEmails[$t]; ?>" type="text">
                                                    <label for="<?php echo $EmailVal; ?>" class="">Company Email</label>
                                                </div>
                                            </div>
                                            <div class="col l1 m2 s2">
                                                <div class="input-field countrycode code-changes field-custom">
                                                    <input id="<?php echo $CCVal; ?>" name="<?php echo $CCVal; ?>" value="<?php echo $intCountryMultiCode[$t]; ?>" autocomplete="off" type="text" onkeypress="return KeycheckOnlyNumeric(event);">
                                                </div>
                                            </div>
                                            <div class="col m4 s12">
                                                <div class="input-field first-varaa">
                                                    <input id="<?php echo $CPVal; ?>" value="<?php echo $varCompanyMultiPhone[$t]; ?>" onkeypress="return KeycheckOnlyNumeric(event);" name="<?php echo $CPVal; ?>" type="text">
                                                    <label for="<?php echo $CPVal; ?>" class="">Mobile Number</label>
                                                </div>
                                            </div>
                                            <div class="col m1 s2 delet-icon removeemob">
                                                <a href="javascript:;"><i class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </div>
                                        <?php
                                        $t++;
                                    }
                                }
                                ?>

                                <div id="addemobdiv"></div>
                                <div class="col m6 s12">
                                    <div class="input-field first-varaa">
                                        <input id="varTelephone" value="<?php echo $getCompanydata['varTelephone']; ?>" name="varTelephone" type="text" onkeypress="return KeycheckOnlyNumeric(event);">
                                        <label for="varTelephone" class="">Tel Number</label>
                                    </div>
                                </div>
                                <div class="col m6 s12">
                                    <div class="input-field first-varaa">
                                        <input id="varRegistration" value="<?php echo $getCompanydata['varRegistration']; ?>" onkeypress="return KeycheckOnlyNumeric(event);" name="varRegistration" maxlength="4" type="text">
                                        <label for="varRegistration"  class="">Year Of Registration</label>
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                            <div class="col s12 m6 padding">
                                <div class="col m12 s12 more-info">
                                    <div class="form-part">
                                        <div class="input-field field-custom">
                                            <select id="varOwnerType" name="varOwnerType">
                                                <?php $Ownershiptype = array('Public Limited Company', 'Private Limited Company', 'Partnership Firm', 'Sole Proprietorship firm', 'Limited Liability Partnership', 'Free Zone Establishment(FZE)'); ?>
                                                <option value="" disabled selected>Ownership Type</option>
                                                <?php
                                                foreach ($Ownershiptype as $ost) {
                                                    if ($ost == $getCompanydata['varOwnerType']) {
                                                        $ostsel = "selected";
                                                    } else {
                                                        $ostsel = "";
                                                    }
                                                    ?>
                                                    <option <?php echo $ostsel; ?> value="<?php echo $ost; ?>"><?php echo $ost; ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="varOwnerType" class="stick-label">Ownership Type<sup>*</sup></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col m12 s12">
                                    <div class="input-field field-custom area-height">
                                        <textarea id="varCompanyInfo" name="varCompanyInfo" class="materialize-textarea"><?php echo strip_tags($getCompanydata['varCompanyInfo']); ?></textarea>
                                        <label for="varCompanyInfo" class="">Company Introduction<sup>*</sup></label>
                                    </div>
                                </div>
                                <div class="col m12 s12">
                                    <div class="input-field field-custom area-height">
                                        <textarea id="varCompanyAdv" name="varCompanyAdv" class="materialize-textarea"><?php echo strip_tags($getCompanydata['varCompanyAdv']); ?></textarea>
                                        <label for="varCompanyAdv" class="">Company Advantages</label>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="col s12 m12 company-title padding">
                        <div class="card display-bl address-profile-add">
                            <ul class="collapsible change-add-profile-main">
                                <li>
                                    <div class="collapsible-header card" >
                                        <a href="javascript:;" onclick=""><i class="fas fa-map-marker-alt"></i> Address <span class="right-pro-ic"> <div class="circle-plus closed">
                                                    <div class="circle">
                                                        <div class="horizontal"></div>
                                                        <div class="vertical"></div>
                                                    </div>
                                                </div></span></a>
                                    </div>

                                    <?php
//                                    print_r($getCompanydata['varLocation']);
                                    if ($getCompanydata['varLocation'] != '') {
                                        $clocation = $getCompanydata['varLocation'];
                                        $caddress = $getCompanydata['varAddress1'];
                                        $ccity = $getCompanydata['varCity'];
                                        $cpostcode = $getCompanydata['varPostCode'];
                                        $cstate = $getCompanydata['varState'];
                                        $ccountry = $getCompanydata['varCountry'];
                                        $clat = $getCompanydata['varLatitude'];
                                        $clng = $getCompanydata['varLongitude'];
                                    } else {
                                        $clocation = $getUserProfile['varLocation'];
                                        $caddress = $getUserProfile['varAddress1'];
                                        $ccity = $getUserProfile['varCity'];
                                        $cpostcode = $getUserProfile['varZipcode'];
                                        $cstate = $getUserProfile['varState'];
                                        $ccountry = $getUserProfile['varCountry'];
                                        $clat = $getUserProfile['varLatitude'];
                                        $clng = $getUserProfile['varLongitude'];
                                    }
                                    ?>
                                    <div class="collapsible-body">
                                        <h2>Corporate Office Address</h2>
                                        <div class="col s12 m12 padding">
                                            <div class="col m12 s12">
                                                <div class="input-field add-main space-changer">
                                                    <input value="<?php echo $clocation; ?>" id="varLocation" name="varLocation" placeholder="" type="text">
                                                    <label for="varLocation" class="">Corporate Office Address</label>
                                                </div>
                                            </div>
                                            <div class="col m6 s12">
                                                <div class="input-field add-main">
                                                    <textarea id="location" name="varAddress1"  class="materialize-textarea"><?php echo $caddress; ?></textarea>
                                                    <label for="postal_code" class="">Address</label>
                                                </div>
                                            </div>
                                            <div class="col m6 s12">
                                                <div class="input-field add-main corporate-add-field company-city-pin">
                                                    <input value="<?php echo $ccity; ?>" id="locality" name="varCity" type="text">
                                                    <label for="locality" class="">City</label>
                                                </div>
                                            </div>
                                            <div class="col m6 s12">
                                                <div class="input-field add-main corporate-add-field company-city-pin">
                                                    <input type="text" value="<?php echo $cpostcode; ?>" name="varPostCode" id="postal_code" >
                                                    <label for="postal_code" class="">Pin Code</label>
                                                </div>
                                            </div>
                                            <input value="<?php echo $cstate; ?>" name="varState" placeholder="State" id="administrative_area_level_1" type="hidden">
                                            <input value="<?php echo $ccountry; ?>" name="varCountry" placeholder="Country" id="country" type="hidden">
                                            <input type="hidden" value="<?php echo $clat; ?>" name="varLatitude" id="varLatitude" >
                                            <input type="hidden" value="<?php echo $clng; ?>" name="varLongitude" id="varLongitude">
                                            <div class="col m12 s12 company-title1 padding">
                                                <div class="col m12 s12">
                                                    <div class="col s12 m3 l2 padding-left"><h2>Factory Address</h2></div>
                                                    <div class="col s12 m4">
                                                        <div class="center-not">
                                                            <label>
                                                                <input type="checkbox" onchange="return sameaddress();" id="chrAddressSame" name="chrAddressSame" class="filled-in" />
                                                                <span>Same As Above</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col m12 s12 padding">
                                                    <div class="col m12 s12">
                                                        <div class="input-field add-main space-changer">
                                                            <input id="varLocation1" value="<?php echo $getCompanydata['varFLocation']; ?>" name="varFLocation" placeholder="Factory Address" type="text">
                                                            <label for="varLocation1" class="stick-label">Factory Address</label>
                                                        </div>
                                                    </div>
                                                    <div class="col m6 s12">
                                                        <div class="input-field add-main ">
                                                            <textarea id="location1" name="varFAddress1" class="materialize-textarea"><?php echo $getCompanydata['varFAddress1']; ?></textarea>
                                                            <label for="location1" class="stick-label">Address</label>
                                                        </div>
                                                    </div>
                                                    <div class="col m6 s12">
                                                        <div class="input-field add-main corporate-add-field company-city-pin">
                                                            <input id="locality1" value="<?php echo $getCompanydata['varFCity']; ?>" name="varFCity" type="text">
                                                            <label for="locality1" class="stick-label">City</label>
                                                        </div>
                                                    </div>
                                                    <div class="col m6 s12">
                                                        <div class="input-field add-main corporate-add-field company-city-pin">
                                                            <input type="text" value="<?php echo $getCompanydata['varFPostCode']; ?>" name="varFPostCode" id="postal_code1" >
                                                            <label for="postal_code1" class="stick-label">Pin Code</label>
                                                        </div>
                                                    </div>
                                                    <input name="varFState" value="<?php echo $getCompanydata['varFState']; ?>" placeholder="State" id="administrative_area_level_11" type="hidden">
                                                    <input  name="varFCountry" value="<?php echo $getCompanydata['varFCountry']; ?>" placeholder="Country" id="country1" type="hidden">
                                                    <input type="hidden" value="<?php echo $getCompanydata['varFLatitude']; ?>" name="varFLatitude" id="varLatitude1" >
                                                    <input type="hidden" value="<?php echo $getCompanydata['varFLongitude']; ?>"  name="varFLongitude" id="varLongitude1">
                                                </div>   
                                            </div>
                                        </div>
                                        <h2>Branch or Franchise Details</h2>
                                        <div class="col m4 s12 ">
                                            <div class="requirment trad-mark">
                                                <!--<label>Type</label>-->

                                                <?php
                                                if ($getCompanydata['chrBranchFranchise'] == 'F') {
                                                    $classy = "";
                                                    $classn = "checked";
                                                } else {
                                                    $classy = "checked";
                                                    $classn = "";
                                                }
                                                ?>
                                                <div class="radio-style col m3 s6">
                                                    <label>
                                                        <input class="with-gap" <?php echo $classy; ?>  name="chrBranchFranchise" id="chrBranchFranchiseY" type="radio" value="B" type="radio">
                                                        <span>Branch</span>
                                                    </label>
                                                </div>
                                                <div class="radio-style col m3 s6"> 
                                                    <label>
                                                        <input class="with-gap" <?php echo $classn; ?> name="chrBranchFranchise" id="chrBranchFranchiseN" value="F" type="radio">
                                                        <span>Franchise</span>
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col m4 s12">
                                            <div class="input-field company-width">
                                                <input id="varBranchCompanyName" value="<?php echo $getCompanydata['varBranchCompanyName']; ?>" name="varBranchCompanyName" type="text">
                                                <label for="varBranchCompanyName" class="">Company Name</label>
                                            </div>
                                        </div>
                                        <div class="col m4 s12">
                                            <div class="input-field company-width">
                                                <input id="varBranchPersonName" value="<?php echo $getCompanydata['varBranchPersonName']; ?>" name="varBranchPersonName" type="text">
                                                <label for="varBranchPersonName" class="">Contact Person Name</label>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="col m6 s12">
                                            <div class="input-field add-main company-width">
                                                <input value="<?php echo $getCompanydata['varBranchLocation']; ?>" id="varBranchLocation" placeholder="" name="varBranchLocation" type="text">
                                                <label for="varBranchLocation" class="">Branch Location</label>
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="input-field add-main company-width">
                                                <input value="<?php echo $getCompanydata['varBranchAddress']; ?>" id="BranchLocation" name="varBranchAddress" type="text">
                                                <label for="BranchLocation" class="">Street Address</label>
                                            </div>
                                        </div>
                                        <div class="col m4 s12">
                                            <div class="input-field add-main corporate-add-field">
                                                <input value="<?php echo $getCompanydata['varBranchCity']; ?>" id="varBranchCity" name="varBranchCity" type="text">
                                                <label for="varBranchCity" class="">City</label>
                                            </div>
                                        </div>
                                        <div class="col m4 s12">
                                            <div class="input-field add-main corporate-add-field">
                                                <input value="<?php echo $getCompanydata['varBranchPostCode']; ?>" name="varBranchPostCode" id="varBranchPostCode" type="text">
                                                <label for="varBranchPostCode" class="">Pincode</label>
                                            </div>
                                        </div>
                                        <!--Branch Location End-->
                                        <div class="col m4 s12 more-info">
                                            <div class="form-part">
                                                <div class="input-field field-custom">
                                                    <!--intDesignation-->
                                                    <?php echo $getCompanyDesingnationList; ?>
                                                    <label for="intDesignation" class="stick-label">Designation</label>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col l1 m1 s2 padding-right">
                                            <div class="input-field countrycode code-changes field-custom company-minus">
                                                <input id="intCountryCode" name="intCountryCode" value="+91" readonly="" autocomplete="off" type="text" onkeypress="return KeycheckOnlyNumeric(event);">
                                            </div>
                                        </div>
                                        <div class="col m3 s10 padding-left">
                                            <div class="input-field mobile-minus">
                                                <input id="varBranchLocationPhone" value="<?php echo $getCompanydata['varBranchLocationPhone']; ?>" maxlength="10" name="varBranchLocationPhone" type="text" onkeypress="return KeycheckOnlyNumeric(event);">
                                                <label for="varBranchLocationPhone" class="">Mobile Number</label>
                                            </div>
                                        </div>
                                        <div class="col m4 s12">
                                            <div class="input-field loaction-find corporate-add-field1">
                                                <input id="varBranchLocationEmail" value="<?php echo $getCompanydata['varBranchLocationEmail']; ?>" name="varBranchLocationEmail" type="email">
                                                <label for="varBranchLocationEmail" class="">Email</label>
                                            </div>
                                        </div>
                                        <div class="col m4 s12">
                                            <div class="input-field">
                                                <input id="varBranchLocationTel" value="<?php echo $getCompanydata['varBranchLocationTel']; ?>" name="varBranchLocationTel" type="text" onkeypress="return KeycheckOnlyNumeric(event);">
                                                <label for="varBranchLocationTel" class="">Telephone Number</label>
                                            </div>
                                        </div>
                                        <input type="hidden" value="<?php echo $getCompanydata['varBranchPostCode']; ?>" name="varBranchPostCode" id="varBranchPostCode" >
                                        <input type="hidden" value="<?php echo $getCompanydata['varBranchLatitude']; ?>" name="varBranchLatitude" id="varBranchLatitude" >
                                        <input type="hidden" value="<?php echo $getCompanydata['varBranchLongitude']; ?>" name="varBranchLongitude" id="varBranchLongitude">

                                        <div class="clear"></div>
                                        <?php
                                        $getBranchData = $this->Module_Model->getBranchData(USER_ID);
                                        ?>
                                        <input type="hidden" name="brachcount" id="brachcount" value="<?php echo count($getBranchData); ?>">
                                        <div id="varBranchLocationdiv"> 



                                            <?php
                                            $i = 1;
                                            foreach ($getBranchData as $branch) {

                                                if ($branch['chrBranchFranchise'] == 'F') {
                                                    $sel1 = "";
                                                    $sel2 = "checked";
                                                } else {
                                                    $sel1 = "checked";
                                                    $sel2 = "";
                                                }
                                                ?>
                                                <hr><div class="col m4 s12 ">
                                                    <div class="requirment trad-mark">
                                                        <div class="radio-style col m3 s6">
                                                            <label>
                                                                <input class="with-gap" <?php echo $sel1; ?> name="chrBranchFranchise<?php echo $i; ?>" id="chrBranchFranchise<?php echo $i; ?>Y" type="radio" value="B" type="radio">
                                                                <span>Branch</span>
                                                            </label>
                                                        </div>
                                                        <div class="radio-style col m3 s6"> 
                                                            <label>
                                                                <input class="with-gap" <?php echo $sel2; ?>  name="chrBranchFranchise<?php echo $i; ?>" id="chrBranchFranchise<?php echo $i; ?>N" value="F" type="radio">
                                                                <span>Franchise</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col m4 s12">
                                                    <div class="input-field company-width">
                                                        <input id="varBranchCompanyName<?php echo $i; ?>" value="<?php echo $branch['varBranchCompanyName'] ?>" name="varBranchCompanyName<?php echo $i; ?>" type="text">
                                                        <label for="varBranchCompanyName<?php echo $i; ?>" class="">Company Name</label>
                                                    </div>
                                                </div>
                                                <div class="col m4 s12">
                                                    <div class="input-field company-width">
                                                        <input id="varBranchPersonName<?php echo $i; ?>" value="<?php echo $branch['varBranchPersonName'] ?>" name="varBranchPersonName<?php echo $i; ?>" type="text">
                                                        <label for="varBranchPersonName<?php echo $i; ?>" class="">Contact Person Name</label>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="col m6 s12">
                                                    <div class="input-field add-main company-width">
                                                        <input id="varBranchLocation<?php echo $i; ?>" value="<?php echo $branch['varBranchLocation'] ?>" placeholder="" name="varBranchLocation<?php echo $i; ?>" type="text">
                                                        <label for="varBranchLocation<?php echo $i; ?>" class="">Branch Location</label>
                                                    </div>
                                                </div>
                                                <div class="col m6 s12">
                                                    <div class="input-field add-main company-width">
                                                        <input id="BranchLocation<?php echo $i; ?>" value="<?php echo $branch['varBranchAddress'] ?>" name="varBranchAddress<?php echo $i; ?>" type="text">
                                                        <label for="BranchLocation<?php echo $i; ?>" class="">Street Address</label>
                                                    </div>
                                                </div>
                                                <div class="col m4 s12">
                                                    <div class="input-field add-main corporate-add-field">
                                                        <input id="varBranchCity<?php echo $i; ?>" value="<?php echo $branch['varBranchCity'] ?>" name="varBranchCity<?php echo $i; ?>" type="text">
                                                        <label for="varBranchCity<?php echo $i; ?>" class="">City</label>
                                                    </div>
                                                </div>
                                                <div class="col m4 s12">
                                                    <div class="input-field add-main corporate-add-field">
                                                        <input name="varBranchPostCode<?php echo $i; ?>" value="<?php echo $branch['varBranchPostCode'] ?>" id="varBranchPostCode<?php echo $i; ?>" type="text">
                                                        <label for="varBranchPostCode<?php echo $i; ?>" class="">Pincode</label>
                                                    </div>
                                                </div>
                                                <!--                                                <div class="col m4 s12">
                                                                                                    <div class="input-field add-main corporate-add-field">
                                                                                                        <input name="varBranchCountry<?php echo $i; ?>" value="<?php echo $branch['varBranchCountry'] ?>" id="varBranchCountry<?php echo $i; ?>" type="text">
                                                                                                        <label for="varBranchCountry<?php echo $i; ?>" class="">Country</label>
                                                                                                    </div>
                                                                                                </div>-->
                                                <div class="col m4 s12 more-info">
                                                    <div class="form-part">
                                                        <div class="input-field field-custom">
                                                            <input name="varBranchDesignation<?php echo $i; ?>" value="<?php echo $branch['varBranchDesignation'] ?>" id="varBranchDesignation<?php echo $i; ?>" type="text">
                                                            <label for="varBranchDesignation<?php echo $i; ?>">Designation</label>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col l1 m1 s2 padding-right">
                                                    <div class="input-field countrycode field-custom company-minus">
                                                        <input id="intBranchCountryCode<?php echo $i; ?>" value="<?php echo $branch['intBranchCountryCode'] ?>" name="intBranchCountryCode<?php echo $i; ?>" value="+91" readonly="" autocomplete="off" type="text" onkeypress="return KeycheckOnlyNumeric(event);">
                                                    </div>
                                                </div>
                                                <div class="col m3 s10 padding-left">
                                                    <div class="input-field mobile-minus">
                                                        <input id="varBranchLocationPhone<?php echo $i; ?>" value="<?php echo $branch['varBranchLocationPhone'] ?>" maxlength="10" name="varBranchLocationPhone<?php echo $i; ?>" type="text" onkeypress="return KeycheckOnlyNumeric(event);">
                                                        <label for="varBranchLocationPhone<?php echo $i; ?>" class="">Mobile Number</label>
                                                    </div>
                                                </div>
                                                <div class="col m4 s12">
                                                    <div class="input-field loaction-find corporate-add-field1">
                                                        <input id="varBranchLocationEmail<?php echo $i; ?>" value="<?php echo $branch['varBranchLocationEmail'] ?>" name="varBranchLocationEmail<?php echo $i; ?>" type="email">
                                                        <label for="varBranchLocationEmail<?php echo $i; ?>" class="">Email</label>
                                                    </div>
                                                </div>
                                                <div class="col m4 s12">
                                                    <div class="input-field">
                                                        <input id="varBranchLocationTel<?php echo $i; ?>" value="<?php echo $branch['varBranchLocationTel'] ?>" name="varBranchLocationTel<?php echo $i; ?>" type="text" onkeypress="return KeycheckOnlyNumeric(event);">
                                                        <label for="varBranchLocationTel<?php echo $i; ?>" class="">Telephone Number</label>
                                                    </div>
                                                </div>
                                                <?php
                                                $i++;
                                            }
                                            ?>

                                            <span id="brachadds"></span>
                                            <div class="plus-icon" style="text-align:right;">
                                                <a href="javascript:;" class="add waves-effect waves-light btn"><i class="fas fa-plus-square"></i>Add Branch Location</a>
                                            </div>
                                        </div>

                                        <!--Branch Location Start-->

                                        <!--Branch Location End-->





                                    </div>   
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--                    <div class="col s12 m12 company-title padding">
                                            <div class="card display-bl">
                                                                     
                                            </div>
                                        </div>-->
                    <div class="col s12 m12 company-title profile-persional clear-short padding">
                        <div class="col s12 m12 card display-bl">
                            <h2>Gallery</h2>
                            <!--<h2 class="com-intro">Gallery</h2>-->
                            <div class="col m12 s12">
                                <input type="hidden" id="hidd_varBrochure" name="hidd_varBrochure" value="<?php echo $getCompanydata['varBrochure']; ?>">
                                <div id="" class="col s12 m3 upload-attachment profile-attach">
                                    <?php
                                    $file = $getCompanydata['varBrochure'];
//                                    echo $file;
                                    $thumb = 'upimages/company/brochure/' . $file;
                                    $fileexntension = substr(strrchr($getCompanydata['varBrochure'], '.'), 1);
                                    $filetolowwer = strtolower($fileexntension);
//                            echo $filetolowwer;
                                    $p = explode('.', $getCompanydata['varBrochure']);
                                    if ($filetolowwer == 'doc' || $filetolowwer == 'DOC' || $filetolowwer == 'docx' || $filetolowwer == 'DOCX') {
                                        $t = 'images/icon/doc-icon.png';
                                    } else if ($filetolowwer == 'zip' || $filetolowwer == 'rar') {
                                        $t = 'images/icon/zip-icon.png';
                                    } else if ($filetolowwer == 'xls' || $filetolowwer == 'xlsx' || $filetolowwer == 'csv') {
                                        $t = "images/icon/excel-icon.png";
                                    } else {
                                        $t = 'images/icon/pdf-icon.png';
                                    }
                                    if ($file != '') {
                                        $img_name = FRONT_MEDIA_URL . $t;
                                        $file_imgclass = "imgshow";
                                        ?>
                                        <style>
                                            .imgshow{
                                                background-image:url(<?php echo $img_name; ?>) !important;
                                            }
                                        </style>
                                        <?php
                                    } else {
                                        $file_img = "";
                                        $file_imgclass = "";
                                    }
//                                    echo $file_img;
                                    ?>
                                    <div class="custom-file-container" data-upload-id="mySecondImage" >
                                        <h1>Attachment</h1>
                                        <label><a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image"></a></label>
                                        <label class="custom-file-container__custom-file" >
                                            <input type="file" name="varBrochure" id="varBrochure" class="custom-file-container__custom-file__custom-file-input" accept=".pdf, .doc, .docx, .csv, .xls, .xlsx, .ppt, .zip" >
                                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                                        </label>
                                        <div class="custom-file-container__image-preview <?php echo $file_imgclass; ?>" <?php echo $file_img; ?>></div>
                                    </div>
                                </div>
                                <div class="col m2 s12 profile-user-pic">
                                    <div class="profile-upload-user">
                                        <div class="user-photo1">      
                                            <h6>Company Logo</h6>
                                            <?php
//                                            $imagename = $getCompanydata['varCompanyLogo'];
                                            $imagename = $getUserProfile['varImage'];
                                            $imagepath = 'upimages/users/images/' . $imagename;
                                            if (file_exists($imagepath) && $imagename != '') {
                                                $image_thumb = image_thumb($imagepath, USERS_WIDTH, USERS_HEIGHT);
                                                $image_thumb_style = 'style="background:url(' . $image_thumb . ') no-repeat;background-size: cover;background-position: center;"';
                                            } else {
                                                $image_thumb_style = "";
                                            }
                                            ?>
                                            <input type="hidden" id="hidd_company_logo" name="hidd_company_logo" value="<?php echo $imagename; ?>">
                                            <div id="image-preview-profile-logo" <?php echo $image_thumb_style; ?>>
                                                <label for="profile-view-logo" id="image-label-logo"><i class="fas fa-camera"></i></label>
                                                <input type="file" name="varCompanyLogo" id="profile-view-logo" />
                                            </div>
                                        </div>             
                                    </div>
                                </div>
                                <div class="col s12 m7">
                                    <div class="col s12 m6 profile-user-pic">
                                        <div class="profile-upload-user">
                                            <div class="user-photo1">      
                                                <h6>Company Visiting Card Front</h6>
                                                <?php
                                                $imagenamea = $getCompanydata['varVisitingCardFront'];
                                                $imagepatha = 'upimages/company/images/' . $imagenamea;
                                                if (file_exists($imagepatha) && $imagenamea != '') {
                                                    $image_thumba = image_thumb($imagepatha, PRODUCTGALLERY_WIDTH, PRODUCTGALLERY_HEIGHT);
                                                    $image_thumb_stylea = 'style="background:url(' . $image_thumba . ') no-repeat;background-size: cover;background-position: center;"';
                                                } else {
                                                    $image_thumb_stylea = "";
                                                }
                                                ?>
                                                <input type="hidden" id="hidd_visiting_front" name="hidd_visiting_front" value="<?php echo $getCompanydata['varVisitingCardFront']; ?>">
                                                <div id="image-preview-profile-visiting" <?php echo $image_thumb_stylea; ?>>
                                                    <label for="profile-view-visit" id="image-label-visit"><i class="fas fa-camera"></i></label>
                                                    <input type="file" name="varVisitingCardFront" id="profile-view-visit" />
                                                </div>
                                            </div>             
                                        </div>
                                    </div>
                                    <div class="col s12 m6 profile-user-pic">
                                        <div class="profile-upload-user">
                                            <div class="user-photo1">      
                                                <h6>Company Visiting Card Back</h6>
                                                <?php
                                                $imagenames = $getCompanydata['varVisitingCardBack'];
                                                $imagepaths = 'upimages/company/images/' . $imagenames;
                                                if (file_exists($imagepaths) && $imagenames != '') {
                                                    $image_thumbs = image_thumb($imagepaths, PRODUCTGALLERY_WIDTH, PRODUCTGALLERY_HEIGHT);
                                                    $image_thumb_styles = 'style="background:url(' . $image_thumbs . ') no-repeat;background-size: cover;background-position: center;"';
                                                } else {
                                                    $image_thumb_styles = "";
                                                }
                                                ?>
                                                <input type="hidden" id="hidd_visiting_back" name="hidd_visiting_back" value="<?php echo $getCompanydata['varVisitingCardBack']; ?>">
                                                <div id="image-preview-profile-visiting-back" <?php echo $image_thumb_styles; ?>>
                                                    <label for="profile-view-visit-back" id="image-label-visit-back"><i class="fas fa-camera"></i></label>
                                                    <input type="file" name="varVisitingCardBack" id="profile-view-visit-back" />
                                                </div>
                                            </div>             
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="companytmpimage" name="companytmpimage">
                            <div class="col m12 s12 product-up profile-company-multi">
                                <div class="product-upload-user mCustomScrollbar light" data-mcs-theme="minimal-dark">
                                    <!--<h1 class="com-ph">Company Photo</h1>-->
                                    <div class="upload-btn-wrapper">
                                        <button class="btnupload">Upload Company Photos</button>
                                        <input type="file" id="varCompanyImages" name="varCompanyImages[]" multiple />
                                        <!-- static box -->
                                        <div class="on-upload-image" id='companyimages'>
                                            <?php
                                            $getCompanyPhoto = $this->Module_Model->getCompanyPhotos(USER_ID);
                                            foreach ($getCompanyPhoto as $row) {
                                                $imagenames = $row['varImage'];
                                                $imagepaths = 'upimages/company/companygallery/' . $imagenames;
                                                if (file_exists($imagepaths) && $imagenames != '') {
                                                    $image_thumbs = image_thumb($imagepaths, PRODUCTGALLERY_WIDTH, PRODUCTGALLERY_HEIGHT);
                                                    ?>
                                                    <div class="upload-boxes" id="del_com<?php echo $row['int_id']; ?>">
                                                        <div class=" image-source card">
                                                            <a href="javascript:;" onclick="return deletecompany_photo(<?php echo $row['int_id']; ?>)"><i class="far fa-times-circle"></i></a>
                                                            <img src="<?php echo $image_thumbs; ?>">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <!-- end static -->
                                    </div>             
                                </div>
                            </div>                         
                        </div>
                    </div>
                    <div class="col s12 m12 company-title padding">
                        <div class="card display-bl address-profile-add">
                            <ul class="collapsible change-add-profile-main">
                                <li>
                                    <div class="collapsible-header card" >
                                        <a href="javascript:;" onclick=""><i class="fas fa-user-tag"></i> Other details <span class="right-pro-ic"> <div class="circle-plus closed">
                                                    <div class="circle">
                                                        <div class="horizontal"></div>
                                                        <div class="vertical"></div>
                                                    </div>
                                                </div></span></a>
                                    </div>
                                    <div class="collapsible-body">
                                        <div class="col m6 s12">
                                            <div class="input-field margin-top-s">
                                                <select id="varTotalEmployees" name="varTotalEmployees">
                                                    <?php $varTotalEmployees = array('Fewer than 5 People', '5 - 10 People', '11 - 50 People', '51 - 100 People', '101 - 200 People', '201 - 300 People', '301 - 500 People', '501 - 1000 People', 'Above 1000 People'); ?>
                                                    <option value="" disabled selected>Total No of Employees</option>
                                                    <?php
                                                    foreach ($varTotalEmployees as $emp) {
                                                        if ($emp == $getCompanydata['varTotalEmployees']) {
                                                            $empsel = "selected";
                                                        } else {
                                                            $empsel = "";
                                                        }
                                                        ?>
                                                        <option <?php echo $empsel; ?> value="<?php echo $emp; ?>"><?php echo $emp; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <label for="varTotalEmployees" class="stick-label">Total No of Employees</label>
            <!--                                        <input id="varTotalEmployees" value="<?php echo $getCompanydata['varTotalEmployees']; ?>" name="varTotalEmployees" type="text">
                                      <label for="varTotalEmployees" class="">Total No of Employee</label>-->
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="input-field company-width ">
                                                <input id="varWebsite" name="varWebsite" value="<?php echo $getCompanydata['varWebsite']; ?>" type="text">
                                                <label for="varWebsite" class="">Company Website</label>
                                            </div>
                                        </div>
                                        <div class="col m6 s12 more-info">
                                            <div class="form-part">
                                                <div class="input-field field-custom">
                                                    <select id="varQCStaff" name="varQCStaff">
                                                        <?php $QCStaff = array('Fewer than 5 People', '5 - 10 People', '11 - 50 People', '51 - 100 People', '101 - 200 People', '201 - 300 People', '301 - 500 People', '501 - 1000 People', 'Above 1000 People'); ?>
                                                        <option value="" disabled selected>No Of. QC Staff</option>
                                                        <?php
                                                        foreach ($QCStaff as $staff) {
                                                            if ($staff == $getCompanydata['varQCStaff']) {
                                                                $qcsel = "selected";
                                                            } else {
                                                                $qcsel = "";
                                                            }
                                                            ?>
                                                            <option <?php echo $qcsel; ?> value="<?php echo $staff; ?>"><?php echo $staff; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <label for="varQCStaff" class="stick-label">No Of. QC Staff</label>
                                                    <!-- <label>Sub Category</label> -->
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="col m6 s12 more-info">
                                            <div class="form-part">
                                                <div class="input-field field-custom">
                                                    <select id="varRDStaff" name="varRDStaff">
                                                        <?php $RDStaff = array('Fewer than 5 People', '5 - 10 People', '11 - 50 People', '51 - 100 People', '101 - 200 People', '201 - 300 People', '301 - 500 People', '501 - 1000 People', 'Above 1000 People'); ?>
                                                        <option value="" disabled selected>No of R&D Staff</option>
                                                        <?php
                                                        foreach ($RDStaff as $rstaff) {
                                                            if ($rstaff == $getCompanydata['varRDStaff']) {
                                                                $rdsel = "selected";
                                                            } else {
                                                                $rdsel = "";
                                                            }
                                                            ?>
                                                            <option <?php echo $rdsel; ?> value="<?php echo $rstaff; ?>"><?php echo $rstaff; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <label for="varRDStaff" class="stick-label">No of R&D Staff</label>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col m6 s12 more-info">
                                            <div class="form-part">
                                                <div class="input-field field-custom">
                                                    <select id="varProductionLine" name="varProductionLine">
                                                        <?php $PLStaff = array('1 To 5', 'Above'); ?>
                                                        <option value="" disabled selected>Production line</option>
                                                        <?php
                                                        foreach ($PLStaff as $pltaff) {
                                                            if ($pltaff == $getCompanydata['varProductionLine']) {
                                                                $plsel = "selected";
                                                            } else {
                                                                $plsel = "";
                                                            }
                                                            ?>
                                                            <option <?php echo $plsel; ?> value="<?php echo $pltaff; ?>"><?php echo $pltaff; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <label for="varProductionLine" class="stick-label">Production line</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col m6 s12 mixed  currency-width-product">
                                            <div class="col l2 m2 s2 padding">
                                                <div class="input-field field-custom">
                                                    <?php
                                                    if ($getCompanydata['varCurrency'] == '2') {
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
                                                    <label for="varCurrency" class="stick-label">Currency</label>
                                                    <!-- <label>Sub Category</label> -->
                                                </div>
                                            </div>                               
                                            <div class="col m10 s10 padding">
                                                <div class="input-field anual-turnover change-turnovr">
                                                    <input id="varAnnualTurnover" name="varAnnualTurnover" type="text" value="<?php echo $getCompanydata['varAnnualTurnover']; ?>">
                                                    <label for="varAnnualTurnover" class="">Annual Turnover</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php
                    $total = $getCompanydata['varIndiaMarkets'] + $getCompanydata['varAsiaMarkets'] + $getCompanydata['varEuropeMarkets'] + $getCompanydata['varAfricaMarkets'] + $getCompanydata['varMiddleEastMarkets'] + $getCompanydata['varNorthAmericaMarkets'] + $getCompanydata['varSouthAmericaMarkets'] + $getCompanydata['varAustraliaMarkets'] + $getCompanydata['varNewZealandMarkets'];
                    ?>
                    <div class="col s12 m12 company-title padding">
                        <div class="card display-bl">
                            <h2>Main Markets and Distribution :&nbsp;<span id="getAvg"><?php echo $total . " %"; ?></span></h2>
                            <div class="col s12 m12 persantage-dist">
                                <div class="progress">
                                    <div class="determinate" id="determinate" style="width:<?php echo $total . "%"; ?>"></div>
                                </div>
                            </div>
                            <div class="col m4 s12">
                                <div class="input-field field-custom add-main corporate-add-field">
                                    <input id="varIndiaMarkets" maxlength="3" value="<?php echo $getCompanydata['varIndiaMarkets']; ?>" onchange="return getProgress(this.value)" name="varIndiaMarkets" type="text" onkeypress="return isNumber(event);">
                                    <label for="varIndiaMarkets" class="">India %</label>
                                </div>
                            </div> 
                            <div class="col m4 s12">
                                <div class="input-field field-custom add-main corporate-add-field">
                                    <input id="varAsiaMarkets" maxlength="3" onchange="return getProgress(this.value)" value="<?php echo $getCompanydata['varAsiaMarkets']; ?>" name="varAsiaMarkets" type="text" onkeypress="return isNumber(event);">
                                    <label for="varAsiaMarkets" class="">Asia %</label>
                                </div>
                            </div> 
                            <div class="col m4 s12">
                                <div class="input-field field-custom add-main corporate-add-field">
                                    <input id="varEuropeMarkets" maxlength="3" onchange="return getProgress(this.value)" value="<?php echo $getCompanydata['varEuropeMarkets']; ?>" name="varEuropeMarkets" type="text" onkeypress="return isNumber(event);">
                                    <label for="varEuropeMarkets" class="">Europe %</label>
                                </div>
                            </div> 
                            <div class="col m4 l2 s12">
                                <div class="input-field field-custom countri-tax">
                                    <input id="varAfricaMarkets" maxlength="3" onchange="return getProgress(this.value)" value="<?php echo $getCompanydata['varAfricaMarkets']; ?>" name="varAfricaMarkets" type="text" onkeypress="return isNumber(event);">
                                    <label for="varAfricaMarkets" class="">Africa %</label>
                                </div>
                            </div> 
                            <div class="col m4 l2 s12">
                                <div class="input-field field-custom countri-tax">
                                    <input id="varMiddleEastMarkets" maxlength="3" onchange="return getProgress(this.value)" value="<?php echo $getCompanydata['varMiddleEastMarkets']; ?>" name="varMiddleEastMarkets" type="text" onkeypress="return isNumber(event);">
                                    <label for="varMiddleEastMarkets" class="">Middle East %</label>
                                </div>
                            </div> 
                            <div class="col m4 l2 s12">
                                <div class="input-field field-custom countri-tax">
                                    <input id="varNorthAmericaMarkets" maxlength="3" onchange="return getProgress(this.value)" value="<?php echo $getCompanydata['varNorthAmericaMarkets']; ?>" name="varNorthAmericaMarkets" type="text" onkeypress="return isNumber(event);">
                                    <label for="varNorthAmericaMarkets" class="">North America %</label>
                                </div>
                            </div> 
                            <div class="col m4 l2 s12">
                                <div class="input-field field-custom countri-tax">
                                    <input id="varSouthAmericaMarkets" maxlength="3" onchange="return getProgress(this.value)" value="<?php echo $getCompanydata['varSouthAmericaMarkets']; ?>" name="varSouthAmericaMarkets" type="text" onkeypress="return isNumber(event);">
                                    <label for="varSouthAmericaMarkets" class="">South America %</label>
                                </div>
                            </div> 
                            <div class="col m4 l2 s12">
                                <div class="input-field field-custom countri-tax">
                                    <input id="varAustraliaMarkets" maxlength="3" onchange="return getProgress(this.value)" value="<?php echo $getCompanydata['varAustraliaMarkets']; ?>" name="varAustraliaMarkets" type="text" onkeypress="return isNumber(event);">
                                    <label for="varAustraliaMarkets" class="">Australia %</label>
                                </div>
                            </div> 
                            <div class="col m4 l2 s12">
                                <div class="input-field field-custom countri-tax">
                                    <input id="varNewZealandMarkets" maxlength="3" onchange="return getProgress(this.value)" value="<?php echo $getCompanydata['varNewZealandMarkets']; ?>" name="varNewZealandMarkets" type="text" onkeypress="return isNumber(event);">
                                    <label for="varNewZealandMarkets" class="">New Zealand %</label>
                                </div>
                            </div> 
                            <input type="hidden" id="percentage" name="percentage">
                            <div id="percentagetxt" style="display:none;" class="error-note">The sum of percentages must be 100.</div>
                            <div id="percentageError"></div>
                        </div>
                    </div>


                    <div class="card display-bl address-profile-add">
                        <ul class="collapsible change-add-profile-main">
                            <li>
                                <div class="collapsible-header card" >
                                    <a href="javascript:;" onclick=""><i class="fas fa-globe"></i>
                                        <span class="all-sets"> Social Links <div class="help-tooltip"><i class="fas fa-info-circle btn tooltipped" data-position="top" data-tooltip="Company Social Media Links"></i></div> </span>
                                        <span class="right-pro-ic"> <div class="circle-plus closed">
                                                <div class="circle">
                                                    <div class="horizontal"></div>
                                                    <div class="vertical"></div>
                                                </div>
                                            </div></span></a>
                                </div>
                                <div class="collapsible-body">
                                    <div class="col s12 m12 padding">                
                                        <div class="col s12 m12 company-title padding mobile-padding-social">
                                            <!--<div class="card display-bl">-->

                                            <div class="col m3 s12">
                                                <div class="input-field field-custom social-width">
                                                    <input id="varFacebook" value="<?php echo $getCompanydata['varFacebook']; ?>" name="varFacebook" type="text">
                                                    <label for="varFacebook" class="">Facebook</label>
                                                </div>
                                            </div> 
                                            <div class="col m3 s12">
                                                <div class="input-field field-custom social-width">
                                                    <input id="varLinkedIn" value="<?php echo $getCompanydata['varLinkedIn']; ?>" name="varLinkedIn" type="text">
                                                    <label for="varLinkedIn" class="">LinkedIn</label>
                                                </div>
                                            </div> 
                                            <div class="col m3 s12">
                                                <div class="input-field field-custom social-width">
                                                    <input id="varTwitter" value="<?php echo $getCompanydata['varTwitter']; ?>" name="varTwitter" type="text">
                                                    <label for="varTwitter" class="">Twitter</label>
                                                </div>
                                            </div> 
                                            <div class="col m3 s12">
                                                <div class="input-field field-custom social-width">
                                                    <input id="varGoogle" value="<?php echo $getCompanydata['varGoogle']; ?>" name="varGoogle" type="text">
                                                    <label for="varGoogle" class="">Google Plus</label>
                                                </div>
                                            </div> 
                                            <!--</div>-->
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card display-bl address-profile-add  mobile-tax">
                        <!--<div class="col m12 s12 company-title padding mobile-tax card display-bl">-->
                        <!--<div class="card display-bl">-->
                        <ul class="collapsible change-add-profile-main">
                            <li>
                                <div class="collapsible-header card" >
                                    <a href="javascript:;" onclick=""><i class="fas fa-percent"></i> Taxation details<span class="right-pro-ic"> <div class="circle-plus closed">
                                                <div class="circle">
                                                    <div class="horizontal"></div>
                                                    <div class="vertical"></div>
                                                </div>
                                            </div></span></a>
                                </div>
                                <div class="collapsible-body">
                                    <div class="col m12 s12 padding">
                                        <div class="col m3 s12">
                                            <div class="input-field field-custom social-width socio-set">
                                                <input id="varGST" name="varGST" value="<?php echo $getCompanydata['varGST']; ?>" type="text">
                                                <label for="varGST" class="">GSTIN No</label>
                                            </div>
                                        </div> 
                                        <div class="col m3 s12">
                                            <div class="input-field field-custom social-width socio-set">
                                                <input id="varPanNo" name="varPanNo" value="<?php echo $getCompanydata['varPanNo']; ?>" type="text">
                                                <label for="varPanNo" class="">Pan No</label>
                                            </div>
                                        </div> 
                                        <div class="col m3 s12">
                                            <div class="input-field field-custom three-combine socio-set">
                                                <input id="varUdyogAadhaarNo" value="<?php echo $getCompanydata['varUdyogAadhaarNo']; ?>" name="varUdyogAadhaarNo" type="text">
                                                <label for="varUdyogAadhaarNo" class="">Udhyog Aadhaar No</label>
                                            </div>
                                        </div> 
                                        <div class="col m3 s12">
                                            <div class="input-field field-custom  three-combine socio-set">
                                                <input id="varIECCode" value="<?php echo $getCompanydata['varIECCode']; ?>" name="varIECCode" type="text">
                                                <label for="varIECCode" class="">IEC Code</label>
                                            </div>
                                        </div>
                                        <div class="col m4 s12">
                                            <div class="input-field field-custom  three-combine  corporate-add-field">
                                                <input id="varCINNo" value="<?php echo $getCompanydata['varCINNo']; ?>" name="varCINNo" type="text">
                                                <label for="varCINNo" class="">CIN No.</label>
                                            </div>
                                        </div>
                                        <div class="col m4 s12">
                                            <div class="input-field field-custom  three-combine corporate-add-field">
                                                <input id="varSSINo" value="<?php echo $getCompanydata['varSSINo']; ?>" name="varSSINo" type="text">
                                                <label for="varSSINo" class="">SSI No.</label>
                                            </div>
                                        </div>
                                        <div class="col m4 s12">
                                            <div class="input-field field-custom  three-combine corporate-add-field">
                                                <input id="varTANNo" value="<?php echo $getCompanydata['varTANNo']; ?>" name="varTANNo" type="text">
                                                <label for="varTANNo" class="">TAN No.</label>
                                            </div>
                                        </div>





                                        <?php
                                        $varTaxation1 = $getCompanydata['varTaxFields'];
                                        $varTaxationAns1 = $getCompanydata['varTaxAns'];

                                        $varTaxation = explode("__", $varTaxation1);
                                        $varTaxationAns = explode("__", $varTaxationAns1);
//                                    $j = 1;
                                        ?>
                                        <input type="hidden" name="taxationcount" id="taxationcount" value="<?php echo count($varTaxation); ?>">
                                        <?php for ($j = 1; $j <= count($varTaxation); $j++) { ?>
                                            <?php if ($varTaxation[$j - 1] != '') { ?> 

                                                <div>
                                                    <hr>  
                                                    <div class="col m5 s12 text-lefts">
                                                        <!--<label for="varLocation" class="stick-label set-addprod"><span class="hints">(Press Enter To Add Multiple keyword)</span></label>-->
                                                        <div class="input-field field-custom  three-combine corporate-add-field change-tax">
                                                            <input name="varTaxation<?php echo $j; ?>" id="varTaxation<?php echo $j; ?>" type="text" value="<?php echo $varTaxation[$j - 1]; ?>">
                                                            <label for="varTaxation<?php echo $j; ?>" class="">Title (eg. TAN No)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col m6 s12 text-lefts">
                                                        <!--<label for="varLocation" class="stick-label set-addprod"><span class="hints">(Press Enter To Add Multiple keyword)</span></label>-->
                                                        <div class="input-field field-custom  three-combine corporate-add-field change-tax">
                                                            <input name="varTaxationAns<?php echo $j; ?>" id="varTaxationAns<?php echo $j; ?>" type="text" value="<?php echo $varTaxationAns[$j - 1]; ?>">
                                                            <label for="varTaxationAns<?php echo $j; ?>" class="">Value (eg. SAD110904GF)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col m1 s2 delet-icon removetax">
                                                        <a href="javascript:;"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </div>

                                                <?php
                                            }
                                        }
                                        ?>


                                        <span id="taxationadds"></span>
                                        <div class="plus-icon" style="text-align:right;">
                                            <a href="javascript:;" class="addTaxation waves-effect waves-light btn"><i class="fas fa-plus-square"></i>Add more taxation details</a>
                                        </div>


                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!--</div>-->
                </div>

                <a href="<?php echo $this->common_model->getUrl("pages", "2", "95", ''); ?>" class="previous action-button" >Previous</a>
                <input type="submit" class="next action-button" value="Save&nbsp;&&nbsp;Next" />
            </fieldset>
            <?php echo form_close(); ?>
        </div>
    </div>           
</div>
<div id="map"></div>
<div id="map1"></div>
<div id="map2"></div>
<script>
    function initMap() {
        initMap1();
        initMap2();
        initMap3();
    }

    function initMap3() {
        var map = new google.maps.Map(document.getElementById('map2'));
        var input = document.getElementById('varBranchLocation');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }
            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''), (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }
            for (var i = 0; i < place.address_components.length; i++) {
                if (place.address_components[i].types[0] == 'postal_code') {
                    document.getElementById('varBranchPostCode').value = place.address_components[i].long_name;
                }
                //                if (place.address_components[i].types[0] == 'administrative_area_level_1') {
                //                    document.getElementById('varBranchPostCode').value = place.address_components[i].long_name;
                //                }
                if (place.address_components[i].types[0] == 'locality') {
                    document.getElementById('varBranchCity').value = place.address_components[i].long_name;
                }
                //                if (place.address_components[i].types[0] == 'country') {
                //                    document.getElementById('varBranchCountry').value = place.address_components[i].long_name;
                //                }
            }
            document.getElementById('BranchLocation').value = place.formatted_address;
            document.getElementById('varBranchLatitude').value = place.geometry.location.lat();
            document.getElementById('varBranchLongitude').value = place.geometry.location.lng();
        });
    }
    function initMap2() {
        var map = new google.maps.Map(document.getElementById('map1'));
        var input = document.getElementById('varLocation1');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }
            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''), (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }
            for (var i = 0; i < place.address_components.length; i++) {
                if (place.address_components[i].types[0] == 'postal_code') {
                    document.getElementById('postal_code1').value = place.address_components[i].long_name;
                }
                if (place.address_components[i].types[0] == 'administrative_area_level_1') {
                    document.getElementById('administrative_area_level_11').value = place.address_components[i].long_name;
                }
                if (place.address_components[i].types[0] == 'locality') {
                    document.getElementById('locality1').value = place.address_components[i].long_name;
                }
                if (place.address_components[i].types[0] == 'country') {
                    document.getElementById('country1').value = place.address_components[i].long_name;
                }
            }
            document.getElementById('location1').value = place.formatted_address;
            document.getElementById('varLatitude1').value = place.geometry.location.lat();
            document.getElementById('varLongitude1').value = place.geometry.location.lng();
        });
    }
    function initMap1() {
        var map = new google.maps.Map(document.getElementById('map'));
        var input = document.getElementById('varLocation');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }
            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''), (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }
            for (var i = 0; i < place.address_components.length; i++) {
                if (place.address_components[i].types[0] == 'postal_code') {
                    document.getElementById('postal_code').value = place.address_components[i].long_name;
                }
                if (place.address_components[i].types[0] == 'administrative_area_level_1') {
                    document.getElementById('administrative_area_level_1').value = place.address_components[i].long_name;
                }
                if (place.address_components[i].types[0] == 'locality') {
                    document.getElementById('locality').value = place.address_components[i].long_name;
                }
                if (place.address_components[i].types[0] == 'country') {
                    document.getElementById('country').value = place.address_components[i].long_name;
                }
            }
            document.getElementById('location').value = place.formatted_address;
            document.getElementById('varLatitude').value = place.geometry.location.lat();
            document.getElementById('varLongitude').value = place.geometry.location.lng();
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY; ?>&libraries=places&callback=initMap&region=in" async defer></script>

<script src="<?php echo FRONT_MEDIA_URL; ?>js/file-upload-with-preview.js"></script>
<script>
    //Second upload
    var secondUpload = new FileUploadWithPreview('mySecondImage');
</script>

<script type="text/javascript">
    $('.collapsible-header').on('click', function () {
        $(this).toggleClass('opened');
    })
</script>