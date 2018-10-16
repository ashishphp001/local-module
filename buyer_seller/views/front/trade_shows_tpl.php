<style>
    #intState{
        display: unset;   
    }
    #intCity{
        display: unset;   
    }
</style>
<?php if ($_GET['msg'] == '1') { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).ready(function () {
                $('#flow-popup').modal({dismissible: false});
                $('#flow-popup').modal('open');
            });
        });
    </script>
<?php } ?>


<script type="text/javascript">
    $(document).ready(function () {
        $.validator.addMethod("greaterThan",
                function (value, element, params) {

                    if (value == 0) {
                        return true;
                    } else if (!/Invalid|NaN/.test(new Date(value))) {
                        return new Date(value) >= new Date($(params).val());
                    }

                    return isNaN(value) && isNaN($(params).val()) || (Number(value) > Number($(params).val()));
                }, 'Must be greater than issue date.');

        $("#FrmTradeShow").validate({
            ignore: [],
            rules: {
                varTradeShowName: {
                    required: true
                },
                varEndDate: {
                    greaterThan: "#varStartDate"
                }
            },
            errorPlacement: function (error, element) {

            },
            submitHandler: function (form) {
                var varTradeShowName = $('#varTradeShowName').val();
                if (varTradeShowName != '') {
                    submitform();
                }
            }
        });
    });

    function DeleteTradeshowdata(id)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo $this->common_model->getUrl("pages", "2", "95", '') . "/DeleteTradeshowdata"; ?>",
            data: {"int_id": id, csrf_indibizz: csrfHash},
            success: function (Data)
            {
                $("#addtradeshow").load(location.href + " #addtradeshow");
                M.toast({html: 'Trade shows and event sucessfully deleted.'});
                return false;
            }
        });
    }



    function deleteevent_photo(id) {
        document.getElementById('del_eve' + id).style.display = 'none';
        var url = "<?php echo $this->common_model->getUrl("pages", "2", "96", '') . '/delete_event_image?int_id='; ?>" + id;
        $.ajax({
            type: "GET",
            url: encodeURI(url),
            async: true,
            success: function (data) {
            }
        });
    }
    function removeeventfile(name) {
        document.getElementById('eventtmpimage').value = name + "," + document.getElementById('eventtmpimage').value;
        var divsToHide = document.getElementsByClassName("pipps" + name); //divsToHide is an array
        for (var i = 0; i < divsToHide.length; i++) {
            divsToHide[i].style.visibility = "hidden"; // or
            divsToHide[i].style.display = "none"; // depending on what you're doing
        }
    }
//    Event Images
    $(document).ready(function () {
        var j = 0;
        if (window.File && window.FileList && window.FileReader) {
            $("#varEventImages").on("change", function (e) {
                var files = e.target.files,
                        filesLength = files.length;
                var selection = document.getElementById('varEventImages');
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
                        $('<div class="upload-boxes pipps' + j + '">\n\
                                <div class="image-source card">\n\
                                    <a href="javascript:;" class="remove" onclick=\'return removeeventfile("' + j + '")\'><i class="far fa-times-circle"></i></a>\n\
                                    <img src="' + e.target.result + '" alt="' + file.name + '">\n\
                                </div>\n\
                            </div>').insertAfter("#eventimages");
                        j++;
                    });
                    fileReader.readAsDataURL(f);
                }
            });
        } else {
            alert("Your browser doesn't support to File API")
        }
    });
</script>
<div class="col l12 m12 s12">
    <div class="steps-profile">
        <!-- progressbar -->
        <ul id="progressbar">
            <li class="progress-active"><a href="<?php echo $this->common_model->getUrl("pages", "2", "95", ''); ?>"><span>1.</span>Account Setup</a></li>
            <li class="progress-active"><a href="<?php echo $this->common_model->getUrl("pages", "2", "96", ''); ?>"><span>2.</span>Company Information</a></li>
            <li class="progress-active"><a href="<?php echo $this->common_model->getUrl("pages", "2", "97", ''); ?>"><span>3.</span>Company Certificate</a></li>
            <li class="progress-active"><a href="<?php echo $this->common_model->getUrl("pages", "2", "108", ''); ?>"><span>4.</span>Banking Information</a></li>
            <li class="active"><span>5.</span>Trade Shows And Events</li>
        </ul>
    </div>
</div>
<div class="col l12 m12 s12">
    <div class="product-multi1 card">          
        <div class="form_detail">
            <?php
            $getUserdata = $this->Module_Model->getUserProfile(USER_ID);
            $attributes = array('name' => 'FrmTradeShow', 'id' => 'FrmTradeShow', 'enctype' => 'multipart/form-data', 'class' => 'padding-all', 'method' => 'post');
            $action = $this->common_model->getUrl("pages", "2", "96", '') . "/add_tradeshow";
            echo form_open($action, $attributes);
            $event_id = $this->input->get_post('id', TRUE);
            ?>
            <input type="hidden" id="intEvent" name="intEvent" value="<?php echo $event_id; ?>">    
            <input type="hidden" id="intUser" name="intUser" value="<?php echo USER_ID; ?>">    
            <fieldset>
                <div class="company-information">

                    <div class="col m12 s12 padding">
                        <div class="card display-bl">
                            <!--<h1 class="com-ph">Trade Shows And Events</h1>-->
                            <div class="col m12 s12 change-trade-show-input">
                                <div class="col m4 s12">
                                    <div class="requirment profiletrade change-padding">
                                        <div class="radio-style col m6 s6">
                                            <label>
                                                <input class="with-gap" name="varAttended" id="varAttendedY" value="Attended" type="radio">
                                                <span>Attended</span>
                                            </label>
                                        </div>
                                        <div class="radio-style col m6 s6"> 
                                            <label>
                                                <input checked="" class="with-gap" name="varAttended" id="varAttendedN" value="Participated" type="radio">
                                                <span>Participated</span>
                                            </label>
                                        </div>   
                                    </div>
                                </div>
                                <div class="col m4 s12">
                                    <div class="input-field add-main change-show-here">
                                        <input id="varTradeShowName" value="" name="varTradeShowName" type="text">
                                        <label for="varTradeShowName" class="">Name of Trade shows </label>
                                    </div>
                                </div>
                                <div class="col m4 s12">
                                    <div class="input-field add-main change-show-here">
                                        <input id="varOrganiser" value="" name="varOrganiser" type="text">
                                        <label for="varOrganiser" class="">Organiser</label>
                                    </div>
                                </div>
                                <div class="col s12 m12 padding">                         
                                    <div class="col m6 s12">
                                        <div class="input-field date-source loaction-find">
                                            <input type="text" value="" id="varStartDate" name="varStartDate" class="datepicker" placeholder="From">
                                            <label for="varStartDate" class="stick-label">Start Date</label>
                                        </div>
                                    </div> 
                                    <div class="col m6 s12 date-source loaction-find">
                                        <div class="input-field">
                                            <input type="text" id="varEndDate" name="varEndDate" class="datepicker">
                                            <label for="varEndDate" class="stick-label">End Date</label>
                                        </div>
                                    </div> 
                                </div> 

                                <div class="col m12 s12">
                                    <div class="input-field add-main space-changer">
                                        <input id="varLocation" name="varEventLocation" type="text">
                                        <label for="varLocation" class="stick-label">Trade Shows And Events Location</label>
                                    </div>
                                </div>
                                <div class="col m6 s12">
                                    <div class="input-field add-main street-address">
                                        <textarea name="varEventAddress" id="location" class="materialize-textarea"></textarea>
                                        <label for="location" class="stick-label">Address</label>
                                    </div>
                                </div> 
                                <div class="col m6 s12">
                                    <div class="input-field add-main2">
                                        <input class="label-fixed" id="locality" name="varEventCity" type="text">
                                        <label for="locality" class="stick-label">City</label>
                                    </div>
                                </div>

                                <input name="varEventState" id="administrative_area_level_1" type="hidden">
                                <input  name="varEventCountry" id="country" type="hidden">

                                <div class="col m6 s12">
                                    <div class="input-field add-main2">
                                        <input name="varEventPincode" id="varPincode" type="text">
                                        <label for="varPincode" class="stick-label">Pin Code</label>
                                    </div>
                                </div>
                                <input type="hidden" id="varLatitude" name="varEventLatitude">
                                <input type="hidden"  id="varLongitude" name="varEventLongitude">

                                <div class="col m12 s12 padding">
                                    <div class="col m12 s12">
                                        <div class="input-field field-custom area-height">
                                            <textarea id="varInformation" name="varInformation" class="materialize-textarea"></textarea>
                                            <label for="varInformation" class="">Information</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="eventtmpimage" name="eventtmpimage">
                                <div class="col m12 s12 product-up profile-company-multi tradeshow-gallery">
                                    <div class="product-upload-user mCustomScrollbar light" data-mcs-theme="minimal-dark">

                                        <div class="upload-btn-wrapper">
                                            <button class="btnupload">Upload Images</button>
                                            <input type="file" name="varEventImages[]" id="varEventImages" multiple="" />
                                            <!-- static box -->
                                            <div class="on-upload-image" id="eventimages">
                                                <?php
                                                $getEventPhoto = $this->Module_Model->getEventPhotos($event_id);
                                                foreach ($getEventPhoto as $row) {
                                                    $imagenames = $row['varImage'];
                                                    $imagepaths = 'upimages/company/eventgallery/' . $imagenames;
                                                    if (file_exists($imagepaths) && $imagenames != '') {
                                                        $image_thumbs = image_thumb($imagepaths, PRODUCTGALLERY_WIDTH, PRODUCTGALLERY_HEIGHT);
                                                        ?>
                                                        <div class="upload-boxes" id="del_eve<?php echo $row['int_id']; ?>">
                                                            <div class=" image-source card">
                                                                <a href="javascript:;" onclick="return deleteevent_photo(<?php echo $row['int_id']; ?>)"><i class="far fa-times-circle"></i></a>
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
                                <div class="col m12 s12">
                                    <input type="submit" name="next" class="next action-button" value="Save & Add more" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="<?php echo $this->common_model->getUrl("pages", "2", "108", ''); ?>" class="previous action-button" >Previous</a>
                <a href="<?php echo $this->common_model->getUrl("pages", "2", "109", '')."?msg=1"; ?>" name="next" class="next action-button"/>Finish</a>
            </fieldset>
            <?php echo form_close(); ?>
        </div>
    </div>           
</div>

<div class="col m12 s12">
    <div class="user-mini-info " id="addtradeshow">
        <div class="table-users card  free-event" >
            <?php
            $getTradeshowList = $this->Module_Model->getTradeshowEventsList(USER_ID);
            if (count($getTradeshowList) > 0) {
                ?>
                <table cellspacing="0">
                    <tr>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Organiser</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Location</th>
                        <th>Information</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    <?php foreach ($getTradeshowList as $row) { ?>
                        <tr>

                            <td><?php echo $row['varAttended']; ?></td>
                            <td><?php echo $row['varTradeShowName']; ?></td>
                            <td><?php echo $row['varOrganiser']; ?></td>
                            <?php
                            if ($row['varStartDate'] == '1970-01-01') {
                                $start_dates = "";
                            } else {
                                $start_dates = $row['varStartDate'];
                            }
                            ?>
                            <td><?php echo $start_dates; ?></td>
                            <?php
                            if ($row['varEndDate'] == '1970-01-01') {
                                $expiry_dates = "";
                            } else {
                                $expiry_dates = $row['varEndDate'];
                            }
                            ?>
                            <td><?php echo $expiry_dates; ?></td>
                            <?php if ($row['varEventLocation'] != '') { ?>
                                <td class="add-view"><a href="#personaladds<?php echo $row['int_id']; ?>" class="view-detail-add waves-effect waves-light btn modal-trigger">View Location</a></td>
                            <?php } else { ?>
                                <td></td>
                            <?php } ?>
                            <td style="text-align:left;"><?php echo $row['varInformation']; ?></td>
                            <td><a href="<?php echo $this->common_model->getUrl("pages", "2", "109", '') . "?id=" . $row['int_id']; ?>" class="view-detail-add waves-effect waves-light"><i class="fas fa-edit"></i></a></td>
                            <td><a href="javascript:;" onclick="return DeleteTradeshowdata(<?php echo $row['int_id']; ?>)" class="view-detail-add waves-effect waves-light"><i class="fas fa-trash-alt"></i></a></td>

                        </tr>
                        <div id="personaladds<?php echo $row['int_id']; ?>" class="modal modal-fixed-footer get-quot-popup useraddmain">
                            <div class="modal-content mCustomScrollbar light" data-mcs-theme="minimal-dark">
                                <div class="quot-content row user-pop-detail">
                                    <div>
                                        <ul>
                                            <li><b>Location: </b><?php echo $row['varEventLocation']; ?></li>
                                            <li><b>Address: </b><?php echo $row['varEventAddress']; ?></li>
                                            <li><b>City: </b><?php echo $row['varEventCity']; ?></li>
                                            <li><b>State: </b><?php echo $row['varEventState']; ?></li>
                                            <li><b>Country: </b><?php echo $row['varEventCountry']; ?></li>
                                            <li><b>Pincode: </b><?php echo $row['varEventPincode']; ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="close-outside"><a href="javascript:;" class="modal-close waves-effect waves-blue btn-flat"><i class="fas fa-times"></i></a></div>
                        </div>
                    <?php } ?>
                </table>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    //Second upload
    var secondUpload = new FileUploadWithPreview('mySecondImage')
</script>
<div id="flow-popup" class="modal modal-fixed-footer get-quot-popup flow-popup-all">
    <div class="modal-content">
        <?php
        if (TOTAL_PRODUCTS == '0') {
            $color = "blue";
        } else {
            $color = "grey";
        }
        ?>
        <div class="quot-content row">
            <div class="flow-find <?php echo $color; ?>">
                <div class="check_mark">
                    <div class="sa-icon sa-success animate">
                        <span class="sa-line sa-tip animateSuccessTip"></span>
                        <span class="sa-line sa-long animateSuccessLong"></span>
                        <div class="sa-placeholder"></div>
                    </div>
                </div>
            </div>
            <div class="flow-detail">
                <?php
                if (TOTAL_PRODUCTS == '0') {
                    $getUrls = $this->common_model->getUrl("pages", "2", "50", '');
                    ?>
                    <h6>Do you want to add your product? It is just easy as one click.</h6>
                    <?php
                } else {
                    $getUrls = $this->common_model->getUrl("pages", "2", "52", '');
                    ?>
                    <h6>Your business quote just beside one click. Do you want to add?</h6> 
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="modal-footer submit-footer flow-btn">
        <a href="<?php echo SITE_PATH; ?>" class="waves-effect waves-blue btn-flat get-submit-design <?php echo $color; ?>">No</a>
        <a href="<?php echo $getUrls; ?>" class="waves-effect waves-blue btn-flat get-submit-design <?php echo $color; ?>">Yes</a>
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

                }
            }
            document.getElementById('location').value = place.formatted_address;
            document.getElementById('varLatitude').value = place.geometry.location.lat();
            document.getElementById('varLongitude').value = place.geometry.location.lng();
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY; ?>&libraries=places&callback=initMap&region=in" async defer></script>