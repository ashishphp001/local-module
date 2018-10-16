<?php
$actions = $this->common_model->getUrl("pages", "2", "96", '');
?>
<style>
    .intDesignationError .select2-selection {
        border: 1px solid red;
    }
    label.error {
        display: none !important;
    }
    select{
        display:unset;
    }
</style>
<script type="text/javascript">
    function remove_designation_class()
    {
        var element = document.getElementById("intDesignationError");
        element.classList.remove("intDesignationError");
    }
    function delete_member(id)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo $this->common_model->getUrl("pages", "2", "95", '') . "/delete_member"; ?>",
            data: {"int_id": id, csrf_indibizz: csrfHash},
            success: function (Data)
            {
                $("#addmember").load(location.href + " #addmember");
                M.toast({html: 'Member sucessfully deleted.'});
                return false;
            }
        });
    }
    function update_member(id)
    {

        document.getElementById('savecenter').style.display = '';
        $('html, body').animate({
            scrollTop: $("#FrmPartner").offset().top
        }, 2000);
        $.ajax({
            type: "POST",
            url: "<?php echo $this->common_model->getUrl("pages", "2", "95", '') . "/get_partner"; ?>",
            data: {"int_id": id, csrf_indibizz: csrfHash},
            success: function (Data)
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->common_model->getUrl("pages", "2", "95", '') . "/DesingnationList"; ?>",
                    data: {"intDesignation": Data.intDesignation, csrf_indibizz: csrfHash},
                    success: function (Datas) {
                        $('#intDesignationError').html(Datas);
                    }
                });
                document.getElementById('intPartner').value = id;
                document.getElementById('varName').value = Data.varName;
                document.getElementById('intUser').value = Data.intUser;
                document.getElementById('intDesignation').value = Data.intDesignation;
                document.getElementById('varEmail').value = Data.varEmail;
                document.getElementById('varPhone').value = Data.varPhone;
                document.getElementById('varImageName').value = Data.varImage;
                if (Data.varImage != '') {
                    $("#image-preview-profile").css({"background": "url(" + site_path + "upimages/member/images/" + Data.varImage + ") no-repeat", "background-size": "cover", "background-position": "center"});
                }
                
                document.getElementById('txtDescription').value = Data.txtDescription;
                document.getElementById('varAdharNumber').value = Data.varAdharNumber;
                document.getElementById('varBlog').value = Data.varBlog;
                document.getElementById('intCountryCode').value = Data.intCountryCode;
                document.getElementById('varLocation').value = Data.varLocation;
                document.getElementById('location').value = Data.varStreetAddress1;
                document.getElementById('locality').value = Data.varCity;
                document.getElementById('administrative_area_level_1').value = Data.varState;
                document.getElementById('country').value = Data.varCountry;
                document.getElementById('varPincode').value = Data.varPincode;
                document.getElementById('varLatitude').value = Data.varLatitude;
                document.getElementById('varLongitude').value = Data.varLongitude;
            }
        });
    }
    $(document).ready(function () {
        $.validator.addMethod("Chk_Image_Size", function (users, value)
        {
            var flag = true;
            var selection = document.getElementById('varImage');
            for (var i = 0; i < selection.files.length; i++)
            {
                var file = selection.files[i].size;
                var FIVE_MB = Math.round(1024 * 1024 * 5);
                if (file > FIVE_MB)
                {
                    flag = false;
                }
            }
            return flag;
        }, 'Image size invalid');
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
        }, "<div class='fl mgt5 mgr20'>Please enter a valid number.</div>");
        $("#FrmPartner").validate({
            ignore: [],
            rules: {
                varName: {
                    required: true
                },
                intDesignation: {
                    required: true
                },
                varPhone: {
                    minlength: 5,
                    maxlength: 20,
                    phonenumber: {
                        depends: function () {
                            if (($("#varPhone").val()) != '') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                varEmail: {
                    email: true
                }
            },
            errorPlacement: function (error, element) {
                if ($(element).attr('id') == 'intDesignation')
                {
                    $('#intDesignationError').addClass('intDesignationError');
//                    varReqTypeerror
                    error.appendTo('#intDesignationError');
                }
            },
            submitHandler: function (form) {
//                alert($(this).val());
//                return false;
                var User_Name = $('#varName').val();
                if (User_Name != '') {
                    submitform();
                }
            }
        });
    });

    function submitform(id = 1) {
        var formData = new FormData($('form')[0]);
        $.ajax({
            type: "POST",
            url: "<?php echo $this->common_model->getUrl("pages", "2", "95", '') . "/add_partner"; ?>",
            data: formData,
            contentType: false,
            processData: false,
            async: false,
            success: function (Data)
            {

                if (id == 2) {
//company-introduction
                    window.location.href = "<?php echo $actions; ?>";
                } else {
                    $("#addmember").load(location.href + " #addmember");
                    if (document.getElementById('intPartner').value == '') {
                        M.toast({html: 'Congratulation! Member successfully added to your company profile.'});
                    } else {
                        M.toast({html: 'Congratulation! Member successfully updated.'});
                    }
                    $('input[type="text"],textarea').val('');
                    document.getElementById('intPartner').value = '';
                    $('#image-preview-profile').removeAttr('style');
                    return false;
                }
            },
//            complete: function (data) {
//                $('html, body').animate({
//                    scrollTop: $("#addmember").offset().top
//                }, 2000);
//            }
        });
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
        if ((KeyID >= 97 && KeyID <= 122) || (KeyID >= 65 && KeyID <= 90) || (KeyID >= 33 && KeyID <= 39) || (KeyID == 42) || (KeyID >= 58 && KeyID <= 64) || (KeyID >= 91 && KeyID <= 96) || (KeyID >= 123 && KeyID <= 126))
        {
            return false;
        }
        return true;
    }
</script>
<div class="col l12 m12 s12">
    <div class="steps-profile">
        <!-- progressbar -->
        <ul id="progressbar">
            <li class="active"><span>1.</span>Account Setup</li>
            <li><span>2.</span>Company Information</li>
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
            $attributes = array('name' => 'FrmPartner', 'id' => 'FrmPartner', 'enctype' => 'multipart/form-data', 'class' => 'padding-all', 'method' => 'post');
            $action = $this->common_model->getUrl("pages", "2", "95", '') . "/add_partner";
            echo form_open($action, $attributes);
            $getUserList = $this->Module_Model->getCompanyMemberList(USER_ID);
            if (count($getUserList) == 0) {
                $getUserdata = $this->Module_Model->getUserProfile(USER_ID);
                $name = $getUserdata['varName'];
//                $email = $getUserdata['varEmail'];
                $phone = $getUserdata['varPhone'];
                $location = $getUserdata['varLocation'];
                $add1 = $getUserdata['varAddress1'];
                $add2 = $getUserdata['varAddress2'];
                $city = $getUserdata['varCity'];
                $state = $getUserdata['varState'];
                $country = $getUserdata['varCountry'];
                $zipcode = $getUserdata['varZipcode'];
                $lat = $getUserdata['varLatitude'];
                $lng = $getUserdata['varLongitude'];
                $imagename = $getUserdata['varImage'];
                $imagepath = 'upimages/users/images/' . $imagename;
                if (file_exists($imagepath) && $imagename != '') {
                    $image_thumb = image_thumb($imagepath, USERS_WIDTH, USERS_HEIGHT);
                } else {
                    $image_thumb = "";
                }
            } else {
                $name = "";
                $email = "";
                $phone = "";
                $location = "";
                $add1 = "";
                $add2 = "";
                $city = "";
                $state = "";
                $country = "";
                $zipcode = "";
                $lat = "";
                $lng = "";
                $image_thumb = "";
            }
            ?>
            <fieldset>
                <div class="profile-persional card display-bl">
                    <div class="col m4 s12 profile-user-pic">
                        <div class="profile-upload-user">
                            <div class="user-photo1">      
                                <h6>Upload Member Photo</h6>
                                <div id="image-preview-profile" >
                                    <label for="profile-view" id="image-label1"><i class="fas fa-camera"></i></label>
                                    <input type="file" name="varImage" id="profile-view" />
                                </div>
                            </div>             
                        </div>
                    </div>
                    <input type="hidden" id="intPartner" name="intPartner">
                    <input type="hidden" id="varImageName" name="varImageName">
                    <input type="hidden" id="intUser" name="intUser" value="<?php echo USER_ID; ?>">
                    <div class="col m8 s12 personal-data">
                        <div class="col m12 s12 padding">
                            <div class="col m6 s12">
                                <div class="input-field first-varaa">
                                    <input id="varName" name="varName" value="<?php echo $name; ?>" type="text">
                                    <label for="varName" class="stick-label">Name<sup>*</sup></label>
                                </div>
                            </div> 
                            <div class="col l6 m6 s12">
                                <div class="input-field margin-desg"  id="intDesignationError">

                                    <?php echo $getDesingnationList; ?>

                                </div>
                            </div> 
                        </div>     
                        <div class="col m12 s12 padding">                    
                            <div class="col m6 s12">
                                <div class="input-field  first-varaa">
                                    <input id="varEmail" name="varEmail"  value="<?php echo $email; ?>"  type="text">
                                    <label for="varEmail" class="stick-label">Personal Email ID</label>
                                </div>
                            </div> 
                            <div class="countrycode-mobile">
                                <div class="col l1 m2 s2 padding-right">
                                    <div class="input-field countrycode field-custom">
                                        <input id="intCountryCode" name="intCountryCode" value="+91" readonly="" autocomplete="off" type="text" onkeypress="return KeycheckOnlyNumeric(event);">
                                    </div>
                                </div>
                                <div class="col m4 l5 s10 padding-left">
                                    <div class="input-field field-custom register-phone">
                                        <input id="varPhone" name="varPhone" value="<?php echo $phone; ?>" autocomplete="off" type="text" onkeypress="return KeycheckOnlyNumeric(event);">
                                        <label for="varPhone" class="stick-label">Mobile Number</label>
                                    </div>
                                </div>
                            </div>
                            <!--                            <div class="col m6 s12">
                                                            <div class="input-field">
                                                                <input id="varPhone" name="varPhone"  value="<?php echo $phone; ?>"  type="text">
                                                                <label for="varPhone" class="">Mobile Number<sup>*</sup></label>
                                                            </div>
                                                        </div> -->
                        </div>
                        <div class="col m12 s12 padding">
                            <div class="col m12 s12">
                                <div class="input-field field-custom area-height">
                                    <textarea id="txtDescription" name="txtDescription" class="materialize-textarea"></textarea>
                                    <label for="txtDescription" class="stick-label">Personal Details</label>
                                </div>
                            </div>
                        </div>
                        <div class="col m12 s12 padding">
                            <div class="col m6 s12">
                                <div class="input-field   first-varaa">
                                    <input id="varAdharNumber" name="varAdharNumber" maxlength="12" minlength="12" onkeypress="return KeycheckOnlyNumeric(event);" type="text">
                                    <label for="varAdharNumber" class="stick-label">Aadhaar Number</label>
                                </div>
                            </div>
                            <div class="col m6 s12">
                                <div class="input-field  first-varaa">
                                    <input id="varBlog" name="varBlog" type="text">
                                    <label for="varBlog" class="stick-label">Blog</label>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col m12 s12">
                        <div class="col m12 s12">
                            <div class="input-field add-main">
                                <input id="varLocation" value="<?php echo $location; ?>" name="varLocation" type="text">
                                <label for="varLocation" class="stick-label">Location</label>
                            </div>
                        </div>
                        <div class="col m6 s12">
                            <div class="input-field add-main street-address">
                                <textarea name="varStreetAddress1" id="location" class="materialize-textarea"><?php echo $add1; ?></textarea>
                                <label for="location" class="stick-label">Address<sup>*</sup></label>
                            </div>
                        </div>
                        <div class="col m6 s12">
                            <div class="input-field add-main2">
                                <input class="label-fixed" value="<?php echo $city; ?>" id="locality" name="varCity" type="text">
                                <label for="locality" class="stick-label">City</label>
                            </div>
                        </div>
                        <input name="varState" value="<?php echo $state; ?>" id="administrative_area_level_1" type="hidden">
                        <input  name="varCountry" value="<?php echo $country; ?>" id="country" type="hidden">
                        <div class="col m6 s12">
                            <div class="input-field add-main2">
                                <input name="varPincode" value="<?php echo $zipcode; ?>" id="varPincode" type="text">
                                <label for="varPincode" class="stick-label">Pin Code</label>
                            </div>
                        </div>
                        <input type="hidden" value="<?php echo $lat; ?>" id="varLatitude" name="varLatitude">
                        <input type="hidden" value="<?php echo $lng; ?>"  id="varLongitude" name="varLongitude">
                    </div>                       
                </div>

                <button type="submit" class="same-btn1 waves-effect waves-light btn " value="SA">Save & Add More Partner</button>
                <button type="button" id="savecenter" style="display:none;" class="center-btn same-btn1 waves-effect waves-light btn " onclick="return submitform(2)" value="SN">Save & Next</button>
                <a href="<?php echo $actions; ?>" class="next action-button" />Skip & Next</a>
                <div class="col s12 m12 padding">
                    <div class="trading-design" id='addmember'>
                        <?php $getUserList = $this->Module_Model->getCompanyMemberList(USER_ID); ?>
                        <?php
                        $i = 1;
                        foreach ($getUserList as $row) {
                            $imagename = $row['varImage'];
                            $imagepath = 'upimages/member/images/' . $imagename;
                            if (file_exists($imagepath) && $row['varImage'] != '') {
                                $image_thumb = image_thumb($imagepath, USERS_WIDTH, USERS_HEIGHT);
                            } else {
                                $image_thumb = FRONT_MEDIA_URL . "images/no_img/ib_no_image.jpg";
                            }
                            ?>
                            <div class="col s12 m4 l3" id='delete_member<?php echo $row['int_id']; ?>'>
                                <div class="card display-bl">
                                    <div class="card-smell">
                                        <div class="box-image-s">
                                            <img src="<?php echo $image_thumb; ?>" alt="<?php echo $row['varName']; ?>" name='<?php echo $row['varName']; ?>' >
                                        </div>
                                        <div class="id-boxes-detail">
                                            <div class="caption-smell"><p class="shortlist-id">ID: <?php echo USER_ID . $i; ?></p> </div> 
                                            <div class="name-define">
                                                <h1><?php echo $row['varName']; ?></h1>
                                                <p class="title"><?php echo $row['DesignationName']; ?></p>
                                            </div>
                                            <span class="all-btn">
                                                <a href="javascript:;" onclick="return update_member(<?php echo $row['int_id']; ?>)"><i class="fas fa-user-edit card"></i></a>
                                                <a href="javascript:;" onclick="return delete_member(<?php echo $row['int_id']; ?>)"><i class="far fa-trash-alt card"></i></a>
                                            </span>
                                        </div>                                       
                                    </div>
                                </div>
                            </div>
                            <?php
                            $i++;
                        }
                        ?>
                    </div>
                </div>
            </fieldset>
            <?php
            echo form_close();
            ?>
        </div>
    </div>
</div>
<div id="map"></div>
<script>
    function initMap() {
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
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }
            for (var i = 0; i < place.address_components.length; i++) {
                if (place.address_components[i].types[0] == 'postal_code') {
                    document.getElementById('varPincode').value = place.address_components[i].long_name;
                }
                if (place.address_components[i].types[0] == 'administrative_area_level_1') {
                    document.getElementById('administrative_area_level_1').value = place.address_components[i].long_name;
                }
                if (place.address_components[i].types[0] == 'locality') {
                    document.getElementById('locality').value = place.address_components[i].long_name;
                }
                if (place.address_components[i].types[0] == 'country') {
                    document.getElementById('country').value = place.address_components[i].long_name;
                    $.ajax({
                        type: "POST",
                        url: "<?php echo $this->common_model->getUrl("pages", "2", "89", '') . "/getcountrycode"; ?>",
                        data: {"country_id": place.address_components[i].short_name, csrf_indibizz: csrfHash},
                        success: function (Data)
                        {
                            document.getElementById("intCountryCode").value = Data;
                        }
                    });
                }
            }
            document.getElementById('location').value = place.formatted_address;
            document.getElementById('varLatitude').value = place.geometry.location.lat();
            document.getElementById('varLongitude').value = place.geometry.location.lng();
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY; ?>&libraries=places&callback=initMap&region=in" async defer></script>