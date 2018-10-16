<?php
//$actions = $this->common_model->getUrl("pages", "2", "97", '');
?>
<!--<script type="text/javascript">
                                $(function () {
                                    $('#varCertificateIssueDate').datepicker({
                                        onSelect: function (selectedDate) {
                                            var option = "minDate";
                                            var instance = $('#varCertificateExpiryDate').data("datepicker");
                                            var date = $.datepicker.parseDate(instance.settings.format || $.datepicker._defaults.format, selectedDate, instance.settings);
                                            date.setDate(date.getDate() + 1);
                                            $('#varCertificateExpiryDate').datepicker("option", option, date);
                                        }
                                    });
                                    var fdate2 = $("#varCertificateIssueDate").datepicker("getDate");
                                    fdate2.setDate(fdate2.getDate() + 1);
                                    $('#varCertificateExpiryDate').datepicker({
                                        minDate: fdate2,
                                        onSelect: function (selectedDate) {
                                            $("#varCertificateExpiryDate").next('label').hide();
                                            $("#varCertificateExpiryDate").removeClass('error');
                                        }
                                    });
                                });
                            </script>-->
<script>

    function DeleteEventdata(id)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo $this->common_model->getUrl("pages", "2", "95", '') . "/DeleteEventdata"; ?>",
            data: {"int_id": id, csrf_indibizz: csrfHash},
            success: function (Data)
            {
                $("#addcertificate").load(location.href + " #addcertificate");
                M.toast({html: 'Company certificate sucessfully deleted.'});
                return false;
            }
        });
    }

    function DeleteTrademarkdata(id)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo $this->common_model->getUrl("pages", "2", "95", '') . "/DeleteTrademarkdata"; ?>",
            data: {"int_id": id, csrf_indibizz: csrfHash},
            success: function (Data)
            {
                $("#addtrademark").load(location.href + " #addtrademark");
                M.toast({html: 'Trademark sucessfully deleted.'});
                return false;
            }
        });
    }

    function getcertificatedata(id) {
        $('html, body').animate({
            scrollTop: $("#FrmCompanyCerti").offset().top
        }, 2000);

        $.ajax({
            type: "POST",
            url: "<?php echo $this->common_model->getUrl("pages", "2", "95", '') . "/getCertificate"; ?>",
            data: {"int_id": id, csrf_indibizz: csrfHash},
            success: function (Data)
            {
                document.getElementById('intCertificate').value = id;
                document.getElementById('hidd_company_certi').value = Data.varCertificateImage;
                document.getElementById('varCertificateName').value = Data.varCertificateName;
                document.getElementById('varCertificateRegistration').value = Data.varCertificateRegistration;
                document.getElementById('varCertificateIssue').value = Data.varCertificateIssue;
                document.getElementById('varCertificateStatus').value = Data.varCertificateStatus;
                document.getElementById('varCertificateIssueDate').value = Data.varCertificateIssueDate;
                document.getElementById('varCertificateExpiryDate').value = Data.varCertificateExpiryDate;
                document.getElementById('txtPersonalDetails').value = Data.txtPersonalDetails.replace(/<\/?[^>]+(>|$)/g, "");
            }
        });
    }

    function gettrademarkdata(id) {
        $('html, body').animate({
            scrollTop: $("#FrmCompanyTrade").offset().top
        }, 2000);

        $.ajax({
            type: "POST",
            url: "<?php echo $this->common_model->getUrl("pages", "2", "95", '') . "/getTrademark"; ?>",
            data: {"int_id": id, csrf_indibizz: csrfHash},
            success: function (Data)
            {
                document.getElementById('intTrademark').value = id;
                document.getElementById('hidd_company_trade_certi').value = Data.varTrademarkImage;
                document.getElementById('varTrademarkName').value = Data.varTrademarkName;
                document.getElementById('varRegistrationNo').value = Data.varRegistrationNo;
                document.getElementById('varTrademarkStatus').value = Data.varTrademarkStatus;
                document.getElementById('varClass').value = Data.varClass;
                document.getElementById('varTrademarkIssueDate').value = Data.varTrademarkIssueDate;
                document.getElementById('varTrademarkExpiryDate').value = Data.varTrademarkExpiryDate;
                document.getElementById('txtGoodsDescription').value = Data.txtGoodsDescription.replace(/<\/?[^>]+(>|$)/g, "");
            }
        });
    }

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

        $("#FrmCompanyCerti").validate({
            ignore: [],
            rules: {
                varCertificateName: {
                    required: true
                },
                varCertificateExpiryDate: {
                    greaterThan: "#varCertificateIssueDate"
                }
//                varCertificateIssueDate:{
//                    
//                }

            },
            errorPlacement: function (error, element) {

            },
            submitHandler: function (form) {
                var varCertificateName = $('#varCertificateName').val();
                if (varCertificateName != '') {
                    submitform();
                }
            }
        });

//        $(document).ready(function(){

//	});

        $.validator.addMethod("greaterThan1",
                function (value, element, params) {

                    if (value == 0) {
                        return true;
                    } else if (!/Invalid|NaN/.test(new Date(value))) {
                        return new Date(value) >= new Date($(params).val());
                    }

                    return isNaN(value) && isNaN($(params).val()) || (Number(value) > Number($(params).val()));
                }, 'Must be greater than issue date.');

        $("#FrmCompanyTrade").validate({
            ignore: [],
            rules: {
                varTrademarkName: {
                    required: true 
                },
                varTrademarkExpiryDate: {
                    greaterThan1: "#varTrademarkIssueDate"
                }
            },
            errorPlacement: function (error, element) {

            },
            submitHandler: function (form) {
                var varTrademarkName = $('#varTrademarkName').val();
                if (varTrademarkName != '') {
                    submittradeform();
                }
            }
        });
    });

    function submittradeform(id = 1) {
        var formData = new FormData($('form')[1]);
        $.ajax({
            type: "POST",
            url: "<?php echo $this->common_model->getUrl("pages", "2", "97", '') . "/add_company_trademark"; ?>",
            data: formData,
            contentType: false,
            processData: false,
            async: false,
            success: function (Data)
            {
                $("#addtrademark").load(location.href + " #addtrademark");
                if (document.getElementById('intTrademark').value == '') {
                    M.toast({html: 'Congratulation! Trademark successfully added to your company profile.'});
                } else {
                    M.toast({html: 'Congratulation! Trademark successfully updated.'});
                }
                $('input[type="text"],textarea').val('');
                document.getElementById('intTrademark').value = '';
                return false;
            },
            complete: function (data) {
                $('html, body').animate({
                    scrollTop: $("#addtrademark").offset().top
                }, 2000);
            }
        });
    }
    function submitform(id = 1) {
        var formData = new FormData($('form')[0]);
        $.ajax({
            type: "POST",
            url: "<?php echo $this->common_model->getUrl("pages", "2", "97", '') . "/add_company_certificate"; ?>",
            data: formData,
            contentType: false,
            processData: false,
            async: false,
            success: function (Data)
            {
                $("#addcertificate").load(location.href + " #addcertificate");
                if (document.getElementById('intCertificate').value == '') {
                    M.toast({html: 'Congratulation! Company Certificate successfully added to your company profile.'});
                } else {
                    M.toast({html: 'Congratulation! Company Certificate successfully updated.'});
                }
                $('input[type="text"],textarea').val('');
                document.getElementById('intCertificate').value = '';
                return false;
            },
            complete: function (data) {
                $('html, body').animate({
                    scrollTop: $("#addcertificate").offset().top
                }, 2000);
            }
        });
    }
</script>

<div class="col l12 m12 s12">
    <div class="steps-profile">
        <!-- progressbar -->
        <ul id="progressbar">
            <li class="progress-active"><a href="<?php echo $this->common_model->getUrl("pages", "2", "95", ''); ?>"><span>1.</span>Account Setup</a></li>
            <li class="progress-active"><a href="<?php echo $this->common_model->getUrl("pages", "2", "96", ''); ?>"><span>2.</span>Company Information</a></li>
            <li class="active"><span>3.</span>Company Certificate</li>
            <li><span>4.</span>Banking Information</li>
            <li><span>5.</span>Trade Shows And Events</li>
        </ul>
    </div>
</div>
<div class="col l12 m12 s12">
    <div class="product-multi1 card">          
        <div class="form_detail">

            <fieldset>
                <div class="certificate-small card display-bl">
                    <div class="profile-title">
                        <i class="fas fa-certificate"></i>
                        <h2 class="fs-title">Company Certificate</h2>
                    </div>
                    <div class="profile-persional">
                        <?php
                        if ($getCompanyCertidata['varCompanyPhone'] == '' && $getCompanyCertidata['varCompanyEmail'] == '') {
                            redirect($this->common_model->getUrl("pages", "2", "96", ''));
                        }
                        $attributes = array('name' => 'FrmCompanyCerti', 'id' => 'FrmCompanyCerti', 'enctype' => 'multipart/form-data', 'class' => 'padding-all', 'method' => 'post');
                        $action = $this->common_model->getUrl("pages", "2", "97", '') . "/add_company_certificate";
                        echo form_open($action, $attributes);
                        ?>
                        <input type="hidden" id="intCertificate" name="intCertificate" value="">
                        <input type="hidden" id="intUser" name="intUser" value="<?php echo USER_ID; ?>">
                        <div class="col m4 s12 profile-user-pic">
                            <div class="profile-upload-user">
                                <div class="user-photo1">      
                                    <h6>Upload Certificate</h6>
                                    <?php
//                                    $imagename = $getCompanyCertidata['varCertificateImage'];
//                                    $imagepath = 'upimages/company/certificate/' . $imagename;
//                                    if (file_exists($imagepath) && $imagename != '') {
//                                        $image_thumb = image_thumb($imagepath, PRODUCTGALLERY_WIDTH, PRODUCTGALLERY_HEIGHT);
//                                        $image_thumb_style = 'style="background:url(' . $image_thumb . ') no-repeat;background-size: cover;background-position: center;"';
//                                    } else {
//                                        $image_thumb_style = "";
//                                    }
                                    ?>
                                    <input type="hidden" id="hidd_company_certi" name="hidd_company_certi">
                                    <div id="image-preview-profile-certificate">
                                        <label for="profile-view-certificate" id="image-label-certificate"><i class="fas fa-camera"></i></label>
                                        <input type="file" name="varCertificateImage"  id="profile-view-certificate" />
                                    </div>
                                </div>             
                            </div>
                        </div>
                        <div class="col m8 s12 personal-data">
                            <div class="col m12 s12 padding">
                                <div class="col m6 s12">
                                    <div class="input-field first-varaa">
                                        <input id="varCertificateName" name="varCertificateName" type="text">
                                        <label for="varCertificateName" class="stick-label">Certificate Name</label>
                                    </div>
                                </div> 
                                <div class="col m6 s12">
                                    <div class="input-field first-varaa">
                                        <input id="varCertificateRegistration" name="varCertificateRegistration" type="text">
                                        <label for="varCertificateRegistration" class="stick-label">Registration Number</label>
                                    </div>
                                </div> 
                            </div>     
                            <div class="col m12 s12 padding">                    
                                <div class="col m6 s12">
                                    <div class="input-field first-varaa">
                                        <input id="varCertificateIssue" name="varCertificateIssue" type="text">
                                        <label for="varCertificateIssue" class="stick-label">Issue By (Govt. Body Name)</label>
                                    </div>
                                </div> 
                                <div class="col m6 s12">
                                    <div class="input-field margin-bottoms">
                                        <select id="varCertificateStatus" name="varCertificateStatus">
                                            <?php $status_list = array('Approved', 'Rejected', 'Pending'); ?>
                                            <option value="" selected>Select Status</option>
                                            <?php
                                            foreach ($status_list as $status) {
                                                ?>
                                                <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="varCertificateStatus" class="stick-label">Status</label>
                                    </div>
                                </div> 
                            </div>
                            <div class="col s12 m12 padding">                         
                                <div class="col m6 s12">
                                    <div class="input-field date-source first-varaa ">

                                        <input type="text" class="datepicker" id="varCertificateIssueDate" name="varCertificateIssueDate">
                                        <label for="varCertificateIssueDate" class="stick-label">Issue Date</label>
                                    </div>
                                </div> 
                                <div class="col m6 s12 date-source">
                                    <div class="input-field first-varaa">

                                        <input type="text" class="datepicker" id="varCertificateExpiryDate" value="" name="varCertificateExpiryDate">
                                        <label for="varCertificateExpiryDate" class="stick-label">Expiry Date</label>
                                    </div>
                                </div> 
                            </div>


                            <div class="col m12 s12 padding">
                                <div class="col m12 s12">
                                    <div class="input-field field-custom area-height">
                                        <textarea id="txtPersonalDetails" name="txtPersonalDetails" class="materialize-textarea"></textarea>
                                        <label for="txtPersonalDetails" class="stick-label">Certificate Description</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col m12 s12">
                                <input type="submit" name="next" class="next action-button" value="Save Certificate" />
                            </div>
                        </div>
                        <?php echo form_close(); ?>

                    </div>
                </div>
                <div class="user-mini-info " id="addcertificate">
                    <div class="table-users card free-event" >
                        <?php
                        $getCertificateList = $this->Module_Model->getCertificateList(USER_ID);
                        if (count($getCertificateList) > 0) {
                            ?>
                            <table cellspacing="0">
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Registration Number</th>
                                    <th>Issue By</th>
                                    <th>Status</th>
                                    <th>Issue Date</th>
                                    <th>Expiry Date</th>
                                    <th>Description</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                <?php foreach ($getCertificateList as $row) { ?>
                                    <tr>
                                        <?php
                                        $imagename = $row['varCertificateImage'];
                                        $imagepath = 'upimages/company/certificate/' . $imagename;
                                        if (file_exists($imagepath) && $imagename != '') {
                                            $image_thumbs = image_thumb($imagepath, PRODUCTGALLERY_WIDTH, PRODUCTGALLERY_HEIGHT);
                                        } else {
                                            $image_thumbs = "";
                                        }
                                        ?>
                                        <td class="img-all-info">
                                            <div class="in-callimg">
                                                <div class="place-img"></div>
                                                <div class="cate-img1 card imageGallery">
                                                    <div class="in-changeimg galleryItem">
                                                        <a href="javascript:;" tabindex="0">
                                                            <img src="<?php echo $image_thumbs; ?>">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td><?php echo $row['varCertificateName']; ?></td>
                                        <td><?php echo $row['varCertificateRegistration']; ?></td>
                                        <td><?php echo $row['varCertificateIssue']; ?></td>
                                        <td><?php
                                            if ($row['varCertificateStatus'] != '0') {
                                                echo $row['varCertificateStatus'];
                                            }
                                            ?></td>
                                        <?php
                                        if ($row['varCertificateIssueDate'] == '1970-01-01') {
                                            $start_date = "";
                                        } else {
                                            $start_date = $row['varCertificateIssueDate'];
                                        }
                                        ?>
                                        <td><?php echo $start_date; ?></td>
                                        <?php
                                        if ($row['varCertificateExpiryDate'] == '1970-01-01') {
                                            $expiry_date = "";
                                        } else {
                                            $expiry_date = $row['varCertificateExpiryDate'];
                                        }
                                        ?>
                                        <td><?php echo $expiry_date; ?></td>
                                        <?php if ($row['txtPersonalDetails'] != '') { ?>
                                            <td class="add-view"><a href="#personaldetailadd<?php echo $row['int_id']; ?>" class="view-detail-add waves-effect waves-light btn modal-trigger">View Description</a></td>
                                        <?php } else { ?>
                                            <td></td>
                                        <?php } ?>
                                        <td><a href="javascript:;" onclick="return getcertificatedata(<?php echo $row['int_id']; ?>)" class="view-detail-add waves-effect waves-light"><i class="fas fa-edit"></i></a></td>
                                        <td><a href="javascript:;" onclick="return DeleteEventdata(<?php echo $row['int_id']; ?>)" class="view-detail-add waves-effect waves-light"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>
                                    <div id="personaldetailadd<?php echo $row['int_id']; ?>" class="modal modal-fixed-footer get-quot-popup useraddmain">
                                        <div class="modal-content mCustomScrollbar light" data-mcs-theme="minimal-dark">
                                            <div class="quot-content row user-pop-detail">
                                                <h5>Description</h5>
                                                <div style="text-align:left;">
                                                    <?php echo $row['txtPersonalDetails']; ?>
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

                <div class="trade-small card display-bl">
                    <div class="profile-title">
                        <i class="fas fa-trademark"></i>
                        <h2 class="fs-title">Trademark</h2>
                    </div>
                    <?php
                    $attributess = array('name' => 'FrmCompanyTrade', 'id' => 'FrmCompanyTrade', 'enctype' => 'multipart/form-data', 'class' => 'padding-all', 'method' => 'post');
                    $actions = $this->common_model->getUrl("pages", "2", "97", '') . "/add_company_trademark";
                    echo form_open($actions, $attributess);
                    ?>
                    <input type="hidden" id="intTUser" name="intTUser" value="<?php echo USER_ID; ?>">
                    <input type="hidden" id="intTrademark" name="intTrademark" value="">
                    <div class="profile-persional">
                        <div class="col m4 s12 profile-user-pic">
                            <div class="profile-upload-user">
                                <div class="user-photo1">      
                                    <h6>Upload Trademark</h6>
                                    <?php
//                                    $timagename = $getCompanyCertidata['varTrademarkImage'];
//                                    $timagepath = 'upimages/company/certificate/' . $timagename;
//                                    if (file_exists($timagepath) && $timagename != '') {
//                                        $timage_thumb = image_thumb($timagepath, PRODUCTGALLERY_WIDTH, PRODUCTGALLERY_HEIGHT);
//                                        $timage_thumb_style = 'style="background:url(' . $timage_thumb . ') no-repeat;background-size: cover;background-position: center;"';
//                                    } else {
//                                        $timage_thumb_style = "";
//                                    }
                                    ?>
                                    <input type="hidden" id="hidd_company_trade_certi" name="hidd_company_trade_certi" value="">
                                    <div id="image-preview-profile-trade">
                                        <label for="profile-view-trade" id="image-label-trade"><i class="fas fa-camera"></i></label>
                                        <input type="file" name="varTrademarkImage" id="profile-view-trade" />
                                    </div>
                                </div>             
                            </div>
                        </div>
                        <div class="col m8 s12 personal-data">
                            <div class="col m12 s12 padding">
                                <div class="col m6 s12">
                                    <div class="input-field first-varaa">
                                        <input id="varTrademarkName" name="varTrademarkName" type="text">
                                        <label for="varTrademarkName" class="stick-label">Trademark Name</label>
                                    </div>
                                </div> 
                                <div class="col m6 s12">
                                    <div class="input-field first-varaa">
                                        <input id="varRegistrationNo" name="varRegistrationNo" type="text">
                                        <label for="varRegistrationNo" class="stick-label">Registration Number</label>
                                    </div>
                                </div> 
                            </div>
                            <div class="col s12 m12 padding">
                                <div class="col m6 s12">
                                    <div class="input-field field-custom area-height margin-bottoms">
                                        <select id="varTrademarkStatus" name="varTrademarkStatus">
                                            <?php $statuss_list = array('Approved', 'Rejected', 'Pending'); ?>
                                            <option value="" selected>Select Status</option>
                                            <?php
                                            foreach ($statuss_list as $statuss) {
                                                if ($statuss == $getCompanyCertidata['varTrademarkStatus']) {
                                                    $stsels = "selected";
                                                } else {
                                                    $stsels = "";
                                                }
                                                ?>
                                                <option <?php echo $stsels; ?> value="<?php echo $statuss; ?>"><?php echo $statuss; ?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="varTrademarkStatus" class="stick-label">Status</label>
                                    </div>
                                </div>

                                <div class="col m6 s12 position-make">
                                    <div class="help-tooltip"><i class="fas fa-info-circle btn tooltipped" data-position="top" data-tooltip="Provide Certificate Class"></i></div>
                                    <div class="input-field first-varaa">
                                        <input id="varClass" name="varClass" type="text">
                                        <label for="varClass" class="stick-label">Class</label>
                                    </div>
                                </div>
                                <div class="col s12 m12 padding">                         
                                    <div class="col m6 s12">
                                        <div class="input-field date-source first-varaa">
                                            <input type="text" id="varTrademarkIssueDate" name="varTrademarkIssueDate" class="datepicker">
                                            <label for="varTrademarkIssueDate" class="stick-label">Issue Date</label>
                                        </div>
                                    </div> 
                                    <div class="col m6 s12">
                                        <div class="input-field date-source first-varaa">
                                            <div class="input-field date-source ">
                                                <input type="text" class="datepicker" id="varTrademarkExpiryDate" name="varTrademarkExpiryDate">
                                                <label for="varTrademarkExpiryDate" class="stick-label">Expiry Date</label>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col m12 s12">
                                        <div class="input-field field-custom area-height">
                                            <textarea id="txtGoodsDescription" name="txtGoodsDescription" class="materialize-textarea"></textarea>
                                            <label for="txtGoodsDescription" class="stick-label">Goods Description</label>
                                        </div>
                                    </div>
                                </div>   
                                <div class="col m12 s12">
                                    <input type="submit" name="next" class="next action-button" value="Save Trademark" />
                                </div>   
                            </div>   
                        </div>  

                    </div>  
                    <?php echo form_close(); ?>
                </div>  

                <div class="user-mini-info " id="addtrademark">
                    <div class="table-users card free-event" >
                        <?php
                        $getTrademarkList = $this->Module_Model->getTrademarkList(USER_ID);
                        if (count($getTrademarkList) > 0) {
                            ?>
                            <table cellspacing="0">
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Registration Number</th>
                                    <th>Status</th>
                                    <th>Class</th>
                                    <th>Issue Date</th>
                                    <th>Expiry Date</th>
                                    <th>Description</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                <?php foreach ($getTrademarkList as $row) { ?>
                                    <tr>
                                        <?php
                                        $imagename = $row['varTrademarkImage'];
                                        $imagepath = 'upimages/company/certificate/' . $imagename;
                                        if (file_exists($imagepath) && $imagename != '') {
                                            $image_thumbs = image_thumb($imagepath, PRODUCTGALLERY_WIDTH, PRODUCTGALLERY_HEIGHT);
                                        } else {
                                            $image_thumbs = FRONT_MEDIA_URL . "images/no_img/ib_no_image.jpg";
                                        }
                                        ?>
                                        <td class="img-all-info">
                                            <div class="in-callimg">
                                                <div class="place-img"></div>
                                                <div class="cate-img1 card imageGallery">
                                                    <div class="in-changeimg galleryItem">
                                                        <a href="javascript:;" tabindex="0">
                                                            <img src="<?php echo $image_thumbs; ?>">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td><?php echo $row['varTrademarkName']; ?></td>
                                        <td><?php echo $row['varRegistrationNo']; ?></td>

                                        <td><?php
                                            if ($row['varTrademarkStatus'] != '0') {
                                                echo $row['varTrademarkStatus'];
                                            }
                                            ?></td>
                                        <td><?php echo $row['varClass']; ?></td>
                                        <?php
                                        if ($row['varTrademarkIssueDate'] == '1970-01-01') {
                                            $start_dates = "";
                                        } else {
                                            $start_dates = $row['varTrademarkIssueDate'];
                                        }
                                        ?>
                                        <td><?php echo $start_dates; ?></td>
                                        <?php
                                        if ($row['varTrademarkExpiryDate'] == '1970-01-01') {
                                            $expiry_dates = "";
                                        } else {
                                            $expiry_dates = $row['varTrademarkExpiryDate'];
                                        }
                                        ?>
                                        <td><?php echo $expiry_dates; ?></td>
                                        <?php if ($row['txtGoodsDescription'] != '') { ?>
                                            <td class="add-view"><a href="#personaldetailadds<?php echo $row['int_id']; ?>" class="view-detail-add waves-effect waves-light btn modal-trigger">View Goods Description</a></td>
                                        <?php } else { ?>
                                            <td></td>
                                        <?php } ?>
                                        <td><a href="javascript:;" onclick="return gettrademarkdata(<?php echo $row['int_id']; ?>)" class="view-detail-add waves-effect waves-light"><i class="fas fa-edit"></i></a></td>
                                        <td><a href="javascript:;" onclick="return DeleteTrademarkdata(<?php echo $row['int_id']; ?>)" class="view-detail-add waves-effect waves-light"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>
                                    <div id="personaldetailadds<?php echo $row['int_id']; ?>" class="modal modal-fixed-footer get-quot-popup useraddmain">
                                        <div class="modal-content mCustomScrollbar light" data-mcs-theme="minimal-dark">
                                            <div class="quot-content row user-pop-detail">
                                                <h5>Description</h5>
                                                <div style="text-align:left;">
                                                    <?php echo $row['txtGoodsDescription']; ?>
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

            </fieldset>
            <a href="<?php echo $this->common_model->getUrl("pages", "2", "96", ''); ?>" class="previous action-button" >Previous</a>
            <!--<input type="submit" name="next" class="next action-button" value="Save & Next" />-->
            <a href="<?php echo $this->common_model->getUrl("pages", "2", "108", ''); ?>" class="next action-button" />Skip & Next</a>

        </div>
    </div>           
</div>
