<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
if (USER_ID != '') {
    $UserData = $this->common_model->getUserData(USER_ID);
} else {
    $UserData = array();
}
?>

<div class="detail-wrapper rfq-detail">

    <div class="row">
        <div class="col s12 m12">
            <div class="col s12 m12">
                <div id="breadcum-spot">  

                    <ul>
                        <?php $getbuyleads = $this->common_model->getUrl("pages", "2", "28", ''); ?>
                        <li><a href="<?php echo $getbuyleads; ?>" class="waves-effect waves-light btn">RFQ</a></li>

                        <li><a href="<?php echo SITE_PATH; ?>" class="waves-effect waves-light btn"><i class="fa fa-home"></i></a></li>

                    </ul>

                </div>
            </div>



            <div class="rfq-all-info">
                <div class="col s12 m9">
                    <div class="rfq-info-detail">
                        <div class="rfq-list-quots card">
                            <div class="col s12 m9">
                                <div class="rfq-message">
                                    accessories come with original box and accessories come with original box and accessories box and accessories come with original box and accessories.
                                </div>
                            </div>
                            <div class="col s12 m3">
                                <div class="rfq-click-quot">
                                    <?php
                                    if (USER_ID != '') {
                                        if ($UserData['chrPayment'] == 'Y') {
                                            if ($UserData['intQuoteLeft'] == '0') {
                                                ?>
                                                <!--150rs popup-->
                                                <a href="javascript:;" class="quots-accement waves-effect waves-light btn">Access By Lead</a>
                                            <?php } else { ?>
                                                <a href="javascript:;" class="quots-accement waves-effect waves-light btn" onclick="openaccesslead()">Quote Now</a>
                                                <div id="panel">
                                                    <a href="#accesslead" class="quots-accement change-one waves-effect waves-light btn modal-trigger">Upload</a>
                                                    <?php $getQuoteNowUrl = $this->common_model->getUrl("pages", "2", "100", '') . "?buylead=" . RECORD_ID; ?>
                                                    <a href="<?php echo $getQuoteNowUrl; ?>" class="quots-accement change-one waves-effect waves-light btn">Quote Now</a>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            $getMembershipUrl = $this->common_model->getUrl("pages", "2", "44", '');
                                            ?>
                                            <a href="<?php echo $getMembershipUrl; ?>" class="quots-accement waves-effect waves-light btn">Access By Lead</a>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                    <!--<a id="loginclick" class="waves-effect waves-light btn modal-trigger" href="#home-login-popup"><i class="fas fa-user"></i>Login</a>-->
                                        <a id="loginclick" href="#home-login-popup" class="quots-accement waves-effect waves-light btn modal-trigger">Quote Now</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="rfq-list-information card">
                            <div class="user-pro-info">
                                <span class="com-introcor">RFQ Information</span>
                            </div>
                            <div class="profile-match">

                                <div class="col s12 m3 l3 card com-name-main">

                                    <?php
                                    $ImagePath = 'upimages/buyleads/images/' . $ShowAllPagesRecords['varImage'];
                                    if (file_exists($ImagePath) && $ShowAllPagesRecords['varImage'] != '') {
                                        $image_thumb = image_thumb($ImagePath, BUY_LEADS_WIDTH, BUY_LEADS_HEIGHT);
                                    } else {
                                        $image_thumb = FRONT_MEDIA_URL . "images/no_img/ib_no_image.jpg";
                                    }
                                    ?>
                                    <div class="info-img-pro">
                                        <img src="<?php echo $image_thumb; ?>">

                                    </div>
                                    <div class="img-rl-cont">
                                        <h6><?php echo $ShowAllPagesRecords['CompanyName']; ?></h6>
                                        <?php echo date('d', strtotime($ShowAllPagesRecords['dtCreateDate'])) . " " . date('M, Y', strtotime($ShowAllPagesRecords['dtCreateDate'])); ?>
                                    </div>
                                </div>
                                <div class="col s12 m9 l9 all-padding-main">

                                    <div class="col s12 m12 l12 all-info-support">
                                        <h6>Basic Detail</h6>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td aria-label="Job Title" colspan="3">
                                                        <b>Product Name:</b> 
                                                    </td>
                                                    <td aria-label="Location" colspan="2"><?php echo $ShowAllPagesRecords['varName']; ?></td>
                                                    <td aria-label="Department"><b>Requirement Type:</b></td>
                                                    <td aria-label="Posted"><?php echo $ShowAllPagesRecords['varReqType']; ?></td>

                                                </tr>
                                                <tr>


                                                </tr>
                                                <tr>
                                                    <td aria-label="Department"><b>Description</b></td>
                                                    <td aria-label="Posted" colspan="6"><?php echo $ShowAllPagesRecords['txtDescription']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td aria-label="Job Title">
                                                        <b>Quantity</b>
                                                    </td>
                                                    <td aria-label="Location"><?php echo $ShowAllPagesRecords['varQuantity']; ?></td>
                                                    <td aria-label="Department" colspan="2"><b>Measurement unit</b></td>
                                                    <td aria-label="Posted" colspan="0"><?php echo $ShowAllPagesRecords['PriceUnit']; ?></td>
                                                    <td aria-label="Job Title">
                                                        <b>Select Industry Type</b>
                                                    </td>
                                                    <td aria-label="Location"><?php echo $ShowAllPagesRecords['ProductCategory']; ?></td>
                                                </tr>
                                                <tr>

                                                    <td aria-label="Department" colspan="3"><b>Preferred Supplier Location  <?php
                                                            if ($ShowAllPagesRecords['varLocation2'] != '') {
                                                                echo "1";
                                                            }
                                                            ?></b></td>

                                                    <td aria-label="Posted" colspan="5"><?php
                                                        if ($ShowAllPagesRecords['varLocation'] != '') {
                                                            echo $ShowAllPagesRecords['varLocation'];
                                                        } else {
                                                            echo "-";
                                                        }
                                                        ?></td>
                                                </tr>
                                                <?php if ($ShowAllPagesRecords['varLocation2'] != '') { ?>
                                                    <tr>

                                                        <td aria-label="Department" colspan="3"><b>Preferred Supplier Location 2</b></td>
                                                        <td aria-label="Posted" colspan="5"><?php echo $ShowAllPagesRecords['varLocation2']; ?></td>
                                                    </tr>
                                                <?php } if ($ShowAllPagesRecords['varLocation3'] != '') { ?>
                                                    <tr>

                                                        <td aria-label="Department" colspan="3"><b>Preferred Supplier Location 3</b></td>
                                                        <td aria-label="Posted" colspan="5"><?php echo $ShowAllPagesRecords['varLocation3']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <a class="read-more-show waves-effect waves-light btn" href="#" id="1">Read More...</a>
                                    <div class="user-other-detail read-more-content hide01">
                                        <div class="col s12 m12 l12 all-info-support">
                                            <h6>Other Details</h6>
                                            <table> 
                                                <tbody>
                                                    <?php
                                                    if ($ShowAllPagesRecords['varBusinessType'] != '') {
                                                        $businessname = $this->Module_Model->getBusinessTypeName($ShowAllPagesRecords['varBusinessType']);
                                                        ?>
                                                        <tr>
                                                            <td aria-label="Job Title" colspan="1"> 
                                                                <b>Preffered Supplier Type:</b> 
                                                            </td>
                                                            <td aria-label="Location" colspan="1"><?php echo $businessname; ?></td> 
                                                        </tr>
                                                    <?php } ?>
                                                    <tr>
                                                        <td aria-label="Department"  colspan="1"><b>Requirement Time:</b></td>
                                                        <td aria-label="Posted"  colspan="4">
                                                            <?php if ($ShowAllPagesRecords['chrRequirement'] == 'U') { ?>
                                                                Urgent
                                                            <?php } else { ?>
                                                                With in <?php
                                                                echo $ShowAllPagesRecords['varDays'] . " Days";
                                                            }
                                                            ?></td>

                                                    </tr>
                                                    <tr>

                                                    </tr>
                                                    <tr>
                                                        <?php if ($ShowAllPagesRecords['varStartPrice'] != 0) { ?>
                                                            <td aria-label="Department"><b>Approx Order Value(From)-(To):</b></td>
                                                            <td aria-label="Posted"> <?php
                                                                if ($ShowAllPagesRecords['varApproxCurrency'] == '1') {
                                                                    $aorder = "&#8377;";
                                                                } else {
                                                                    $aorder = "$";
                                                                }
                                                                echo $aorder . $ShowAllPagesRecords['varStartPrice'] . " - " . $aorder . $ShowAllPagesRecords['varEndPrice'];
                                                                ?></td>

                                                            <td aria-label="Posted"></td>
                                                        <?php } ?>
                                                        <td aria-label="Department"><b>Want To Import:</b></td>
                                                        <td aria-label="Posted"><?php
                                                            if ($ShowAllPagesRecords['chrImport'] == 'Y') {
                                                                echo "Yes";
                                                            } else {
                                                                echo "No";
                                                            }
                                                            ?></td>


                                                    </tr>

                                                    <tr>

                                                    </tr>
                                                    <tr>
                                                        <?php if ($ShowAllPagesRecords['varExpectedPrice'] != '') { ?>
                                                            <td aria-label="Department"><b>Expected Price:</b></td>
                                                            <td aria-label="Posted"><?php
                                                                if ($ShowAllPagesRecords['varCurrency'] == '1') {
                                                                    echo "&#8377;";
                                                                } else {
                                                                    echo "$";
                                                                }
                                                                echo $ShowAllPagesRecords['varExpectedPrice'];
                                                            }
                                                            if ($ShowAllPagesRecords['EUnit'] != '') {
                                                                ?></td>
                                                            <td aria-label="Department"><b>Unit Type:</b></td>
                                                            <td aria-label="Posted"><?php echo $ShowAllPagesRecords['EUnit']; ?></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <?php if ($ShowAllPagesRecords['varPackaging'] != '') { ?>
                                                        <tr> 
                                                            <td aria-label="Department" ><b>Packing:</b>
                                                            </td>
                                                            <td aria-label="Posted" colspan="5"><?php echo $ShowAllPagesRecords['varPackaging']; ?>
                                                            </td>    
                                                        </tr>
                                                    <?php } ?>



                                                </tbody>
                                            </table>

                                        </div>


                                        <a class="read-more-hide waves-effect waves-light btn" href="javascript:;" more-id="1">Read Less...</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="rfq-list-information contact-info-rfq card">
                            <div class="profile-match">

                                <div class="col s12 m12 l12 padding">
                                    <div class="user-pro-info">
                                        <span class="com-introcor">Contact Information</span>
                                    </div>

                                    <?php
//                                    echo $ShowAllPagesRecords['chrPayment'].$ShowAllPagesRecords['intQuoteLeft'].USER_ID;
                                    if ($UserData['chrPayment'] == 'Y' && $UserData['intQuoteLeft'] != '0' && USER_ID != '') {
                                        $username = $ShowAllPagesRecords['Username'];
                                        $companyname = $ShowAllPagesRecords['CompanyName'];
                                        $email = $ShowAllPagesRecords['UserEmail'];
                                        $phone = $ShowAllPagesRecords['UserPhone'];
                                        $tel = $ShowAllPagesRecords['UserTel'];
                                        if ($tel == '') {
                                            $tel = "-";
                                        }
                                        $city = $ShowAllPagesRecords['varCity'];
                                        if ($city == '') {
                                            $city = "-";
                                        }
                                        $state = $ShowAllPagesRecords['varState'];
                                        if ($state == '') {
                                            $state = "-";
                                        }
                                        $country = $ShowAllPagesRecords['varCountry'];
                                        if ($country == '') {
                                            $country = "-";
                                        }
                                        $website = $this->common_model->getUrl("buyer_seller", "136", $ShowAllPagesRecords['intUser'], '');
                                    } else {
                                        $username = "XXXXX XXXXX";
                                        $companyname = "XXXXX XXXXX";
                                        $email = "XXXXX XXXXX";
                                        $phone = "XXXXX XXXXX";
                                        $tel = "XXXXX XXXXX";
                                        $country = "XXXXX XXXXX";
                                        $state = "XXXXX XXXXX";
                                        $city = "XXXXX XXXXX";
                                        $website = "XXXXX XXXXX";
                                    }
                                    ?>


                                    <div class="col s12 m12 l12 all-info-support">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td aria-label="Job Title">
                                                        <b>Full Name:</b> 
                                                    </td>
                                                    <td aria-label="Location"><?php echo $username; ?></td>
                                                    <td aria-label="Department"><b>Email:</b></td>
                                                    <td aria-label="Posted"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td aria-label="Job Title">
                                                        <b>Phone No:</b>
                                                    </td>
                                                    <td aria-label="Location"><?php echo $phone; ?></td>
                                                    <td aria-label="Department"><b>Tel No:</b></td>
                                                    <td aria-label="Posted" width="300px"><?php echo $tel; ?></td>
                                                </tr>
                                                <tr>
                                                    <td aria-label="Job Title">
                                                        <b>Country:</b>
                                                    </td>
                                                    <td aria-label="Location"> <?php echo $country; ?></td>
                                                    <td aria-label="Department"><b>State:</b></td>
                                                    <td aria-label="Posted"><?php echo $state; ?></td>
                                                </tr>
                                                <tr>

                                                    <td aria-label="Department"><b>City:</b></td>
                                                    <td aria-label="Posted"><?php echo $city; ?></td>

                                                </tr>
                                                <tr>

                                                    <td aria-label="Department"><b>Company Name:</b></td>
                                                    <td aria-label="Posted"><?php echo $companyname; ?></td>
                                                    <td aria-label="Department"><b>Website:</b></td>
                                                    <td aria-label="Posted"><a href="<?php echo $website; ?>" target="_blank"><?php echo $website; ?></a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                <?php
                $getSideBuyleadsData = $this->Module_Model->getSideSupplier($ShowAllPagesRecords['intProduct']);
                foreach ($getSideBuyleadsData as $row) {
                    ?>
                    <div class="col s12 m3">
                        <div class="related-rfq card">
                            <div class="supplier-detail-right-side">
                                <div class="right-list">
                                    <div class="related-head-image">
                                        <div class="rfq-related-image">
                                            <?php
                                            $imagename = $row['varImage'];
                                            $imagepath = 'upimages/users/images/' . $imagename;

                                            $subdomain = str_replace("___", $row['varSubdomain'], SUB_DOMAIN);

                                            if (file_exists($imagepath) && $row['varImage'] != '') {
                                                $image_thumb = image_thumb($imagepath, USERS_WIDTH, USERS_HEIGHT);
                                            } else {
                                                $image_thumb = FRONT_MEDIA_URL . "images/no_img/ib_no_image.jpg";
                                            }
//                                            $website =$row['varAlias'];
                                            ?>
                                            <img title="<?php echo $row['varName']; ?>" name="<?php echo $row['varName']; ?>" src="<?php echo $image_thumb; ?>"> 

                                            <div class="companyname trade-asurence city-code-rfq">
                                                <a href="<?php echo SITE_PATH . $row['varAlias']; ?>"><i class="far fa-calendar-alt"></i>&nbsp;<?php echo date('d F, Y', strtotime($row['dtCreateDate'])); ?></a>
                                            </div>   
                                            <div class="heading-rfq-sort"><a href="<?php echo SITE_PATH . $row['varAlias']; ?>" class="comp-name company-name-list"><?php echo $row['varName']; ?></a></div>
                                        </div>

                                    </div>

                                    <div class="companyname business-rate rfq-desc">                                       
                                        <span><?php
                                            $data = strip_tags($row['txtDescription']);
                                            $desc = substr($data, 0, 60);
                                            if (strlen($data) > 60) {
                                                $pro_desc = $desc . "...";
                                            } else {
                                                $pro_desc = $desc;
                                            }
                                            echo $pro_desc;
                                            ?></span>
                                        <div class="varify-certi-rfq">
                                            <i class="fas fa-certificate"></i>
                                        </div>
                                    </div>
                                    <div class="companyname trade-asurence three-combine">
                                        <?php if ($row['varLocation'] != '') { ?>
                                            <i class="fas fa-map-marker-alt"></i>&nbsp;<?php echo $row['varLocation']; ?>
                                        <?php } if ($row['varLocation2'] != '') { ?>
                                            <i class="fas fa-map-marker-alt"></i>&nbsp;<?php echo $row['varLocation2']; ?>
                                        <?php } if ($row['varLocation3'] != '') { ?>
                                            <i class="fas fa-map-marker-alt"></i>&nbsp;<?php echo $row['varLocation3']; ?>
                                        <?php } ?>
                                    </div> 
                                    <div class="companyname near-to rfq-moq-price">
                                        <?php if ($row['varExpectedPrice'] != '') { ?>
                                            <div class="response-rate">
                                                <p>Price : &nbsp;</p>
                                                <span><?php
                                                    if ($row['varExpectedPrice'] != '') {
                                                        if ($row['varCurrency'] == '1') {
                                                            echo "&#8377;";
                                                        } else {
                                                            echo "$";
                                                        }
                                                        echo $row['varExpectedPrice'];
                                                    }
                                                    ?></span>
                                            </div>
                                        <?php } ?>
                                        <?php if ($row['varQuantity'] != '') { ?>
                                            <div class="response-rate">
                                                <p>MOQ: &nbsp;</p>
                                                <span><?php echo $row['varQuantity'] . " " . $row['PriceUnit']; ?></span>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="rfq-button-bottom">
                                        <div class="hub-pro">
                                            <div class="rfq-accesslead">
                                                <a href="<?php echo SITE_PATH . $row['varAlias']; ?>" class="waves-effect waves-light btn"><i class="far fa-comments"></i>Access Buy Lead</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                <?php } ?>
            </div>

        </div>
    </div>
</div>


<div id="accesslead" class="modal modal-fixed-footer get-quot-popup rfq-detail-popp">

    <div class="modal-content mCustomScrollbar light" data-mcs-theme="minimal-dark">

        <div class="rfq-detail-access row">

            <h5>Upload Quotation</h5>
            <div class="col s12 m12 center-all">
                <div class="col m4 s12">
                    <div class="rfq-inner-popup-detail">
                        <div class="rfq-attachment  upload-attachment">
                            <div class="custom-file-container" data-upload-id="mySecondImage">

                                <h1>File Attachment</h1>

                                <label><a href="javascript:;" class="custom-file-container__image-clear" title="Clear Image"></a></label>

                                <label class="custom-file-container__custom-file" >

                                    <input type="file" class="custom-file-container__custom-file__custom-file-input" accept="*" >

                                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />

                                    <span class="custom-file-container__custom-file__custom-file-control"></span>

                                </label>

                                <div class="custom-file-container__image-preview"></div>

                            </div>
                        </div>
                    </div> 
                </div>
                <div class="col m8 s12 download-attach">
                    <h6>You can download sample sheet for upload quotation</h6>
                    <a href="" class="option-choose waves-effect waves-light btn">Download</a>
                </div>
            </div>

            <a href="" class="uploaded-quots">Upload Quotation</a>   

        </div>

    </div>

    <!--  <div class="modal-footer submit-footer">
    
      <a href="#" class="waves-effect waves-blue btn-flat">Submit</a>      
    
    </div> -->

    <div class="close-outside"><a href="#!" class="modal-close waves-effect waves-blue btn-flat"><i class="fas fa-times"></i></a></div>

</div>
<!-- rfq-readmore -->
<script type="text/javascript">
    // Hide the extra content initially, using JS so that if JS is disabled, no problemo:
    $('.read-more-content').addClass('hide01')
    $('.read-more-show, .read-more-hide').removeClass('hide01')

    // Set up the toggle effect:
    $('.read-more-show').on('click', function (e) {
        $(this).next('.read-more-content').removeClass('hide01');
        $(this).addClass('hide01');
        e.preventDefault();
    });

    $('.read-more-hide').on('click', function (e) {
        $(this).parent('.read-more-content').addClass('hide01');
        var moreid = $(this).attr("more-id");
        $('.read-more-show#' + moreid).removeClass('hide01');
        e.preventDefault();
    });
</script>
<script src="<?php echo FRONT_MEDIA_URL; ?>js/file-upload-with-preview.js"></script>



<script>



    //Second upload

    var secondUpload = new FileUploadWithPreview('mySecondImage')

    var secondUploadInfoButton = document.querySelector('.upload-info-button--second');

    secondUploadInfoButton.addEventListener('click', function () {

        console.log('Second upload:', secondUpload, secondUpload.cachedFileArray)

    })

</script>



<script>

    $(window).on('load', function () {
        $(".loadingmainoverlay1").hide();
    });

</script>
<script>
    function openaccesslead() {
        document.getElementById("panel").style.display = "block";
    }
</script>
<!-- end -->