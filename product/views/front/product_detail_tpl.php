<?php if ($_GET['contact'] == '1' && USER_ID == '') { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).ready(function () {
                $('#home-login-popup').modal({dismissible: false});
                $('#home-login-popup').modal('open');
                document.getElementById('close-all').style.display = 'none';
            });
        });
    </script>
<?php } else if ($_GET['contact'] == '1') { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).ready(function () {
                $('#contact-suppliermain').modal();
                $('#contact-suppliermain').modal('open');
            });
        });
    </script>
<?php } ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="row  less-marg">
    <div class="col s12 m12">
        <div class="col s12 m12 padding">
            <div class="row main-empire">
                <div class="col s12 m9 l9">
                    <div class="deatil-main-info card">
                        <div class="col s12 m4 l4">
                            <div class="detail-images">
                                <div class="supplier-fav">
                                    <a href="javascript:;" onclick="return addtofav(<?php echo RECORD_ID; ?>);" class="list-heart">
                                        <?php if (USER_ID == '') { ?>
                                            <i class="far fa-heart" id="<?php echo "fav_class_" . RECORD_ID; ?>"></i>
                                            <?php
                                        } else {
                                            $checkfav = $this->common_model->checkProductFav(RECORD_ID, USER_ID);
                                            if ($checkfav == '0') {
                                                ?>
                                                <i class="far fa-heart" id="<?php echo "fav_class_" . RECORD_ID; ?>"></i>
                                            <?php } else { ?>
                                                <i class="fas fa-heart" id="<?php echo "fav_class_" . RECORD_ID; ?>"></i>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </a>
                                </div>
                                <div class="xzoom-container">
                                    <?php
                                    $getProductImage = $this->Module_Model->getProductImage(RECORD_ID);
                                    $photo_thumbs = $getProductImage['varImage'];
                                    $thumbs = 'upimages/productgallery/images/' . $photo_thumbs;
                                    if (file_exists($thumbs) && $photo_thumbs != '') {
                                        $thumbphoto1 = image_thumb($thumbs, PHOTOGALLERY_WIDTH, PHOTOGALLERY_HEIGHT);
                                        $original_thumb = SITE_PATH . $thumbs;
                                        ?>
                                        <div class="in-callimg">
                                            <div class="place-img"></div>
                                            <div class="cate-img1">
                                                <div class="in-changeimg">
                                                    <img title="<?php echo $getProductImage['varName']; ?>" alt="<?php echo $getProductImage['varName']; ?>" class="xzoom" id="xzoom-default" src="<?php echo $thumbphoto1; ?>" xoriginal="<?php echo $thumbphoto1; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <ul class="detail-logos slider">
                                        <?php
                                        $getProductImages = $this->Module_Model->getProductListingImageData(RECORD_ID);
                                        foreach ($getProductImages as $row) {
                                            $photo_thumb = $row['varImage'];
                                            $thumb = 'upimages/productgallery/images/' . $photo_thumb;
                                            if (file_exists($thumb) && $photo_thumb != '') {
                                                $thumbphoto1 = image_thumb($thumb, PHOTOGALLERY_WIDTH, PHOTOGALLERY_HEIGHT);
                                                $originalthumb = SITE_PATH . $thumb;
                                                ?>
                                                <li class="slide">
                                                    <div class="in-callimg">
                                                        <div class="place-img"></div>
                                                        <div class="cate-img1">
                                                            <div class="in-changeimg">
                                                                <a href="<?php echo $thumbphoto1; ?>">
                                                                    <img class="xzoom-gallery" width="80" src="<?php echo $thumbphoto1; ?>"  xpreview="<?php echo $thumbphoto1; ?>" title="<?php echo $ShowAllPagesRecords['varName']; ?>"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m8 l8">
                            <div class="detail-open">
                                <div class="heading-detail">
                                    <h6><?php echo $ShowAllPagesRecords['varName']; ?></h6>
                                </div>
                                <?php if ($ShowAllPagesRecords['varPrice'] != '0') { ?>
                                    <div class="inner-detail detail-price">
                                        <div class="detail-sort-heading">Price</div>
                                        <div class="brand-detail"><?php
                                            if ($ShowAllPagesRecords['varCurrency'] == '1') {
                                                echo "&#8377;";
                                            } else {
                                                echo "$";
                                            }
                                            ?><?php echo $ShowAllPagesRecords['varPrice']; ?> / <?php echo $ShowAllPagesRecords['PriceUnit']; ?></div>
                                    </div>
                                <?php } if ($ShowAllPagesRecords['varMOQ'] != '0') { ?>
                                    <div class="inner-detail detail-price">
                                        <div class="detail-sort-heading">MOQ</div>
                                        <div class="brand-detail"><?php echo $ShowAllPagesRecords['varMOQ']; ?> <?php echo $ShowAllPagesRecords['MOQUnit']; ?></div>
                                    </div>
                                <?php } if ($ShowAllPagesRecords['varHSCode'] != '') { ?>
                                    <div class="inner-detail detail-price">
                                        <div class="detail-sort-heading">HS Code</div>
                                        <div class="brand-detail"><?php echo $ShowAllPagesRecords['varHSCode']; ?></div>
                                    </div>
                                    <?php
                                }
                                if ($ShowAllPagesRecords['varModelNo'] != '') {
                                    ?>
                                    <div class="inner-detail detail-price">
                                        <div class="detail-sort-heading">Model Number</div>
                                        <div class="brand-detail"><?php echo $ShowAllPagesRecords['varModelNo']; ?></div>
                                    </div>
                                <?php } ?>
                                <?php if ($ShowAllPagesRecords['varBrand'] != '') { ?>
                                    <div class="inner-detail detail-price">
                                        <div class="detail-sort-heading">Brand Name</div>
                                        <div class="brand-detail"><?php echo $ShowAllPagesRecords['varBrand']; ?></div>
                                    </div>
                                    <?php
                                }
                                if ($ShowAllPagesRecords['txtDescription'] != '') {
                                    ?>
                                    <div class="inner-detail">
                                        <div class="detail-sort-heading">Description</div>
                                        <?php
                                        $data = $ShowAllPagesRecords['txtDescription'];
                                        $desc = substr($data, 0, 300);
                                        if (strlen($data) > 300) {
                                            $pro_desc = $desc . "...";
                                        } else {
                                            $pro_desc = $desc;
                                        }
                                        ?>
                                        <div class="brand-detail"><?php echo strip_tags($pro_desc); ?></div>
                                    </div>
                                <?php } ?>
                                <div class="deatil-sending">
                                    <div class="hub-pro">
                                        <?php if (USER_ID != "") { ?>
                                            <a class="waves-effect waves-light btn modal-trigger" href="#contact-suppliermain"><i class="far fa-envelope-open"></i> Contact Supplier</a>
                                        <?php } else { ?>
                                            <a class="waves-effect waves-light btn modal-trigger" href="#home-login-popup"><i class="far fa-envelope-open"></i> Contact Supplier</a>
                                        <?php } ?>

                                        <?php
                                        if ($ShowAllPagesRecords['varBrochure'] != '') {
                                            $download_product = $this->common_model->getUrl("pages", "2", "51", '') . "/download?file=" . $ShowAllPagesRecords['varBrochure'];
                                            ?>
                                            <a href="<?php echo $download_product; ?>" class="waves-effect waves-light btn"><i class="far fa-envelope-open"></i>Attachment</a>
                                        <?php } if ($ShowAllPagesRecords['chrSample'] == 'Y') {
                                            ?>
                                            <a href="#" class="waves-effect waves-light btn"><i class="fas fa-cube"></i>Get Free Sample</a>
                                        <?php } ?>
                                        <a href="#" class="waves-effect waves-light btn"><i class="far fa-comments"></i>Chat</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m3 l3">
                    <div class="card right-detail">
                        <div class="supplier-detail-right-side">
                            <div class="right-list">
                                <?php
                                $getUserProductLink = $this->common_model->getUserData($ShowAllPagesRecords['intSupplier']);
                                if ($getUserProductLink['varSubdomain'] != '') {
                                    $subdomain = str_replace("___", $getUserProductLink['varSubdomain'], SUB_DOMAIN);
                                } else {
                                    $subdomain = $this->common_model->getUrl("buyer_seller", "136", $ShowAllPagesRecords['intSupplier'], '');
                                }
                                ?>
                                <div class="companyname enlarge">
                                    <?php
                                    if ($ShowAllPagesRecords['intPlan'] == '1') {
                                        $plan_img = "ibase.png";
                                    } else if ($ShowAllPagesRecords['intPlan'] == '2') {
                                        $plan_img = "istanderd.png";
                                    } else {
                                        $plan_img = "freee.png";
                                    }
                                    ?>

                                    <a target="_blank" href="<?php echo $subdomain; ?>" class="comp-name company-name-list"><img src="<?php echo FRONT_MEDIA_URL; ?>images/<?php echo $plan_img; ?>" alt="<?php echo $ShowAllPagesRecords['CompanyName']; ?>"><?php echo $ShowAllPagesRecords['CompanyName']; ?>
                                        <span>
                                            <div class="call-image">
                                                <img src="<?php echo FRONT_MEDIA_URL; ?>images/<?php echo $plan_img; ?>" alt="<?php echo $ShowAllPagesRecords['CompanyName']; ?>" title="<?php echo $ShowAllPagesRecords['CompanyName']; ?>">
                                            </div>
                                        </span>
                                    </a> 
                                </div>
                                <?php if ($ShowAllPagesRecords['varCity'] != '') { ?>
                                    <div class="companyname trade-asurence special-none">
                                        <i class="fas fa-map-marker-alt"></i>&nbsp;<?php echo $ShowAllPagesRecords['varCity']; ?> (<?php echo $ShowAllPagesRecords['varCountry']; ?>)
                                    </div>
                                <?php } if ($ShowAllPagesRecords['varBusinessType'] != '') { ?>
                                    <div class="companyname business-rate special-none">                                                
                                        <span><?php
                                            $getBusinessType = $this->Module_Model->getBusinessType($ShowAllPagesRecords['varBusinessType']);
                                            echo rtrim($getBusinessType, ", ");
                                            ?></span>
                                    </div>
                                <?php } if ($ShowAllPagesRecords['varOwnerType'] != '') { ?>
                                    <div class="companyname near-to">
                                        <div class="response-rate">
                                            <p>Ownership Type : &nbsp;</p>
                                            <span><?php echo $ShowAllPagesRecords['varOwnerType']; ?></span>
                                        </div>
                                    </div>
                                <?php } if ($ShowAllPagesRecords['varRegistration'] != '') { ?>
                                    <div class="companyname near-to">
                                        <div class="response-rate">
                                            <p>Year of registration : &nbsp;</p>
                                            <span><?php echo $ShowAllPagesRecords['varRegistration']; ?></span>
                                        </div>
                                    </div>
                                <?php } if ($ShowAllPagesRecords['ftResponseRate'] != '0' && $ShowAllPagesRecords['ftResponseRate'] != '') { ?>
                                    <div class="companyname near-to">
                                        <div class="response-rate">
                                            <p>Response Rate : &nbsp;</p>
                                            <span><?php echo $ShowAllPagesRecords['ftResponseRate'] . "%"; ?></span>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($ShowAllPagesRecords['varTotalEmployees'] != '') { ?>
                                    <div class="companyname near-to">
                                        <div class="response-rate">
                                            <p>Total no of employee : &nbsp;</p>
                                            <span><?php echo $ShowAllPagesRecords['varTotalEmployees']; ?></span>
                                        </div>
                                    </div>
                                <?php } if ($ShowAllPagesRecords['chrTradeSecurity'] == 'Y') { ?>
                                    <div class="companyname mode-define special-none">
                                        <a href=""><img src="<?php echo FRONT_MEDIA_URL; ?>images/trade-security.png" alt=""> Trade Security</a>
                                        <span><i class="fas fa-circle"></i>Online</span>
                                    </div>
                                <?php } ?>
                                <?php
                                if ($ShowAllPagesRecords['chrPayment'] == 'Y') {
                                    $payment = 100;
                                } else {
                                    $payment = 60;
                                }
                                ?>
                                <div class="companyname near-to">
                                    <div class="user-rating-all">
                                        <div class="star-ratings-sprite"><span style="width:<?php echo $payment; ?>%" class="star-ratings-sprite-rating"></span></div>
                                    </div>
                                </div>
                                <div class="supplier-detail-btn">
                                    <div class="hub-pro">

                                        <?php // if ($ShowAllPagesRecords['usersite'] != '') {    ?>
                                        <a href="<?php echo $subdomain; ?>" target="_blank" class="waves-effect waves-light btn fill-blue"><img src="<?php echo FRONT_MEDIA_URL; ?>images/world.png" alt="world">Website</a>													
                                        <a href="<?php echo $subdomain . "/contact"; ?>" class="waves-effect waves-light btn" target="_blank" ><i class="far fa-comments"></i>Contact</a>
                                        <?php // }    ?>
                                        <a href="javascript:;" class="waves-effect waves-light btn video-change"><i class="material-icons dp48">videocam</i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row less-marg">
            <div class="col s12 m12 padding">
                <div class="detail-view-all">
                    <div class="col s12 m6 l6">
                        <div class="detail-tabs">
                            <div class="row">
                                <div class="col s12 padding">
                                    <ul class="tabs">
                                        <li class="tab"><a class="active" href="#basic-detail">Basic Detail</a></li>
                                        <li class="tab"><a href="#packing">Product Detail</a></li>
                                        <li class="tab"><a href="#tradeinfo">Trade Information</a></li>
                                    </ul>
                                </div>
                                <div class="card tab-withdetail">
                                    <div id="basic-detail" class="col s12">
                                        <div class="basic-detail-info">

                                            <?php if ($ShowAllPagesRecords['txtDescription'] != '') { ?>
                                                <div class="inner-detail detail-price">
                                                    <div class="detail-sort-heading">Description</div>
                                                    <div class="brand-detail"><?php echo $ShowAllPagesRecords['txtDescription']; ?></div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($ShowAllPagesRecords['varUse'] != '') { ?>
                                                <div class="inner-detail detail-price">
                                                    <div class="detail-sort-heading">Use of Product</div>
                                                    <div class="brand-detail"><?php echo $ShowAllPagesRecords['varUse']; ?></div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div id="packing" class="col s12">
                                        <div class="basic-detail-info">
                                            <?php if ($ShowAllPagesRecords['varProduction'] != '') { ?>
                                                <div class="inner-detail detail-price">
                                                    <div class="detail-sort-heading">Production Capacity</div>
                                                    <div class="brand-detail"><?php echo $ShowAllPagesRecords['varProduction']; ?></div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($ShowAllPagesRecords['PUnitName'] != '') { ?>
                                                <div class="inner-detail detail-price">
                                                    <div class="detail-sort-heading">Unit</div>
                                                    <div class="brand-detail"><?php echo $ShowAllPagesRecords['PUnitName']; ?></div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($ShowAllPagesRecords['varUse'] != '') { ?>
                                                <div class="inner-detail detail-price">
                                                    <div class="detail-sort-heading">Time</div>
                                                    <div class="brand-detail"><?php echo $ShowAllPagesRecords['intTime']; ?></div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($ShowAllPagesRecords['varPacking'] != '') { ?>
                                                <div class="inner-detail detail-price">
                                                    <div class="detail-sort-heading">Packing Detail</div>
                                                    <div class="brand-detail"><?php echo $ShowAllPagesRecords['varPacking']; ?></div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($ShowAllPagesRecords['varMaterial'] != '') { ?>
                                                <div class="inner-detail detail-price">
                                                    <div class="detail-sort-heading">Material Type</div>
                                                    <div class="brand-detail"><?php echo $ShowAllPagesRecords['varMaterial']; ?></div>
                                                </div>
                                            <?php } ?>
                                            <?php
                                            if ($ShowAllPagesRecords['varSTitle'] != '') {
                                                $featuresTitle = explode("__", $ShowAllPagesRecords['varSTitle']);
                                                $featuresAnswer = explode("__", $ShowAllPagesRecords['varSvalue']);
                                                for ($i = 0; $i <= count($featuresTitle); $i++) {
                                                    if ($featuresTitle[$i] != '') {
                                                        ?>
                                                        <div class="inner-detail detail-price">
                                                            <div class="detail-sort-heading"><?php echo $featuresTitle[$i]; ?></div>
                                                            <div class="brand-detail"><?php echo $featuresAnswer[$i]; ?></div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div id="tradeinfo" class="col s12">
                                        <div class="basic-detail-info">
                                            <?php if ($ShowAllPagesRecords['intDeliveryTerms'] != '') { ?>
                                                <div class="inner-detail detail-price">
                                                    <div class="detail-sort-heading">Delivery Terms</div>
                                                    <?php $getdeliveryterms = $this->Module_Model->getDeliveryTermsLists($ShowAllPagesRecords['intDeliveryTerms']); ?>
                                                    <div class="brand-detail"><?php echo $getdeliveryterms; ?></div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($ShowAllPagesRecords['intPaymentType'] != '') { ?>
                                                <div class="inner-detail detail-price">
                                                    <div class="detail-sort-heading">Payment Type</div>
                                                    <?php $getpaymentType = $this->Module_Model->getPaymentTypeLists($ShowAllPagesRecords['intPaymentType']); ?>
                                                    <div class="brand-detail"><?php echo $getpaymentType; ?></div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($ShowAllPagesRecords['intPaymentTerms'] != '') { ?>
                                                <div class="inner-detail detail-price">
                                                    <div class="detail-sort-heading">Payment Terms</div>
                                                    <?php $getpaymentTerms = $this->Module_Model->getPaymentTermsLists($ShowAllPagesRecords['intPaymentTerms']); ?>
                                                    <div class="brand-detail"><?php echo $getpaymentTerms; ?></div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <div class="detaile-review-title">
                            <h6>Supplier's Review</h6>
                        </div>
                        <div class="riview-supplier-all">
                            <div class="row less-marg">           
                                <div class="card enter-review">
                                    <div class="col s12 m12">
                                        <div class="col s12 m12">
                                            <!-- <div class="about-mini company-info-user">
                                                <h5>Review & Rating</h5>
                                              </div> -->
                                            <?php
                                            $getAvgFeedback = $this->common_model->getAvgFeedback($ShowAllPagesRecords['intSupplier']);
                                            $total = 0;
                                            $avgtotalrating = 0;
                                            $totalrating = 0;
                                            $totalreview = 0;
                                            $rate5 = 0;
                                            $rate4 = 0;
                                            $rate3 = 0;
                                            $rate2 = 0;
                                            $rate1 = 0;
                                            foreach ($getAvgFeedback as $fb) {
                                                if ($fb['intRating'] == '4.5' || $fb['intRating'] == '5') {
                                                    $rate5++;
                                                } else if ($fb['intRating'] == '3.5' || $fb['intRating'] == '4') {
                                                    $rate4++;
                                                } else if ($fb['intRating'] == '2.5' || $fb['intRating'] == '3') {
                                                    $rate3++;
                                                } else if ($fb['intRating'] == '1.5' || $fb['intRating'] == '2') {
                                                    $rate2++;
                                                } else if ($fb['intRating'] == '0.5' || $fb['intRating'] == '1') {
                                                    $rate1++;
                                                }
                                                $avgtotalrating = $avgtotalrating + $fb['intRating'];
                                                if ($fb['intRating'] != '') {
                                                    $totalrating++;
                                                }
                                                if ($fb['txtComment'] != '') {
                                                    $totalreview++;
                                                }
                                                $total++;
                                            }
                                            $avg_rating = $avgtotalrating / $total;
                                            $avg5 = $rate5 * 100 / $total;
                                            $avg4 = $rate4 * 100 / $total;
                                            $avg3 = $rate3 * 100 / $total;
                                            $avg2 = $rate2 * 100 / $total;
                                            $avg1 = $rate1 * 100 / $total;
                                            ?>
                                            <div class="col s12 m3 center-rating padding">
                                                <div class="main-rating-all">
                                                    <div class="row less-marg">
                                                        <div class="col-12-12 all-rate-point">
                                                            <div class="rating-points"><?php echo round($avg_rating, 2); ?></div>
                                                            <div class="rating-star">&#9733;</div>
                                                        </div>
                                                    </div>
                                                    <div class="row  change-points">
                                                        <div class="col-12-12">
                                                            <span><?php echo $totalrating; ?> Ratings &amp;</span>
                                                        </div>
                                                    </div>
                                                    <div class="row change-points">
                                                        <div class="col-12-12">
                                                            <span><?php echo $totalreview; ?> Reviews</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col s12 m5 l5">
                                                <div class="rating-percentage">
                                                    <div class="col s2 m3 l3 padding">
                                                        <div class="rating-points">4.5 / 5</div>
                                                        <div class="rating-star">&#9733;</div>
                                                    </div>
                                                    <div class="col s8 m7 l7">
                                                        <div class="col s12 m12 persantage-dist padding">
                                                            <div class="progress">
                                                                <div class="determinate" id="determinate" style="width: <?php echo $avg5; ?>%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s2 m2 l2 padding">
                                                        <div class="CamDho">&nbsp;<?php echo $rate5; ?></div>
                                                    </div>
                                                </div>
                                                <div class="rating-percentage">
                                                    <div class="col s2 m3 l3 padding">
                                                        <div class="rating-points">3.5 / 4</div>
                                                        <div class="rating-star">&#9733;</div>
                                                    </div>
                                                    <div class="col s8 m7 l7">
                                                        <div class="col s12 m12 persantage-dist padding">
                                                            <div class="progress">
                                                                <div class="determinate" id="determinate" style="width:  <?php echo $avg4; ?>%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s2 m2 l2 padding">
                                                        <div class="CamDho">&nbsp;<?php echo $rate4; ?></div>
                                                    </div>
                                                </div>
                                                <div class="rating-percentage">
                                                    <div class="col s2 m3 l3 padding">
                                                        <div class="rating-points">2.5 / 3</div>
                                                        <div class="rating-star">&#9733;</div>
                                                    </div>
                                                    <div class="col s8 m7 l7">
                                                        <div class="col s12 m12 persantage-dist padding">
                                                            <div class="progress">
                                                                <div class="determinate" id="determinate" style="width: <?php echo $avg3; ?>%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s2 m2 l2 padding">
                                                        <div class="CamDho">&nbsp;<?php echo $rate3; ?></div>
                                                    </div>
                                                </div>
                                                <div class="rating-percentage">
                                                    <div class="col s2 m3 l3 padding">
                                                        <div class="rating-points">1.5 / 2</div>
                                                        <div class="rating-star">&#9733;</div>
                                                    </div>
                                                    <div class="col s8 m7 l7">
                                                        <div class="col s12 m12 persantage-dist padding">
                                                            <div class="progress">
                                                                <div class="determinate" id="determinate" style="width: <?php echo $avg2; ?>%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s2 m2 l2 padding">
                                                        <div class="CamDho">&nbsp;<?php echo $rate2; ?></div>
                                                    </div>
                                                </div>
                                                <div class="rating-percentage">
                                                    <div class="col s2 m3 l3 padding">
                                                        <div class="rating-points">0.5 / 1</div>
                                                        <div class="rating-star">&#9733;</div>
                                                    </div>
                                                    <div class="col s8 m7 l7">
                                                        <div class="col s12 m12 persantage-dist padding">
                                                            <div class="progress">
                                                                <div class="determinate" id="determinate" style="width: <?php echo $avg1; ?>%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s2 m2 l2 padding">
                                                        <div class="CamDho">&nbsp;<?php echo $rate1; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="rating-all col s12 m4 l4">
                                                <div class="reting-click">
                                                    <?php
                                                    if (USER_ID != "") {
                                                        $checkUniqueWebsiteFeedback = $this->common_model->checkUniqueSupplierFeedback(USER_ID, $ShowAllPagesRecords['intSupplier']);
                                                        if (USER_ID == $ShowAllPagesRecords['intSupplier']) {
                                                            ?>
                                                            <h6 style="color:#00326d;">You can not give own rating!!</h6>
                                                        <?php } else if ($checkUniqueWebsiteFeedback == 0) {
                                                            ?>
                                                            <a href="#rating-pop" class="rating-click-text modal-trigger waves-effect waves-light btn" type="submit">
                                                                <span>Rate this Company</span>
                                                            </a>
                                                        <?php } else { ?>
                                                            <h6 style="color:#00326d;">You Reviewed this Supplier!!</h6>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <a href="#home-login-popup" class="rating-click-text modal-trigger waves-effect waves-light btn" type="submit">
                                                            <span>Rate this Company</span>
                                                        </a>
                                                    <?php } ?>
                                                    <!-- get a quot model -->
                                                    <div id="rating-pop" class="modal modal-fixed-footer get-quot-popup ratting-give">
                                                        <div class="modal-content mCustomScrollbar light" data-mcs-theme="minimal-dark">
                                                            <div class="quot-content row ratings-poup">
                                                                <div class="rating-menualy">
                                                                    <?php
                                                                    $attributes = array('name' => 'FrmFeedbackWebsite', 'id' => 'FrmFeedbackWebsite', 'enctype' => 'multipart/form-data', 'class' => 'padding-all', 'method' => 'post');
                                                                    $action = $this->common_model->getUrl("pages", "2", "96", '') . "/addfeedback";
                                                                    echo form_open($action, $attributes);
                                                                    ?>
                                                                    <input type="hidden" id="intProduct" name="intProduct" value="<?php echo RECORD_ID; ?>">
                                                                    <input type="hidden" id="intSupplier" name="intSupplier" value="<?php echo USER_ID; ?>">
                                                                    <input type="hidden" id="intWebsite" name="intWebsite" value="<?php echo $ShowAllPagesRecords['intSupplier']; ?>">
                                                                    <div class="row only-give-rate">
                                                                        <h6 id="rating_2"></h6>
                                                                        <fieldset class="rate">
                                                                            <input id="star5" type="radio" name="rating" value="5" onclick="getStar(5);"/><label for="star5" title="Awesome">5</label>
                                                                            <input id="star4half" type="radio" name="rating" value="4.5" onclick="getStar(4.5);" /><label class="star-half" for="star4half" title="Excellent">4.5</label>
                                                                            <input id="star4" type="radio" name="rating" value="4" onclick="getStar(4);"/><label for="star4" title="Pretty good - 4 stars">4</label>
                                                                            <input id="star3half" type="radio" name="rating" value="3.5" onclick="getStar(3.5);" /><label class="star-half" for="star3half" title="Good">3.5</label>
                                                                            <input id="star3" type="radio" name="rating" value="3" onclick="getStar(3);"/><label for="star3" title="Average - Good">3</label>
                                                                            <input id="star2half" type="radio" name="rating" value="2.5" onclick="getStar(2.5);" /><label class="star-half" for="star2half" title="Average">2.5</label>
                                                                            <input id="star2" type="radio" name="rating" value="2" onclick="getStar(2);"/><label for="star2" title="Low Average">2</label>
                                                                            <input id="star1half" type="radio" name="rating" value="1.5" onclick="getStar(1.5);" /><label class="star-half" for="star1half" title="Not Good">1.5</label>
                                                                            <input id="star1" type="radio" name="rating" value="2" onclick="getStar(1);"/><label for="star1" title="Bad">1</label>
                                                                            <input id="star0half" type="radio" name="rating" value="0.5" onclick="getStar(0.5);" /><label class="star-half" for="star0half" title="Very Bad">0.5</label>
                                                                        </fieldset>
                                                                    </div>
                                                                    <div class="review-text-field row">
                                                                        <h6>Review this Supplier</h6>
                                                                        <div class="enter-review1">
                                                                            <div class="col m12 s12 padding">
                                                                                <div class="input-field field-custom">
                                                                                    <textarea name="txtComment" id="txtComment" class="materialize-textarea"></textarea>
                                                                                    <label for="txtComment">Description<sup>*</sup></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="submit-rating">
                                                                        <button type="submit" class="ratesend waves-effect waves-light btn">
                                                                            Submit
                                                                        </button>
                                                                    </div>
                                                                    <?php
                                                                    echo form_close();
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--  <div class="modal-footer submit-footer">
                                                        
                                                          <a href="#" class="waves-effect waves-blue btn-flat">Submit</a>      
                                                        
                                                        </div> -->
                                                        <div class="close-outside"><a href="javascript:;" class="modal-close waves-effect waves-blue btn-flat"><i class="fas fa-times"></i></a></div>
                                                    </div>
                                                    <!-- end model -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 m12 l12 change-rating-riview">
                                            <div class="rating-list">
                                                <?php
                                                $getWebsiteFeedback = $this->common_model->getSupplierFeedback($ShowAllPagesRecords['intSupplier']);
                                                foreach ($getWebsiteFeedback as $feedback) {
                                                    ?>
                                                    <div class="user-rate-here">
                                                        <div class="ratinf-count">
                                                            <div class="rating-formate">
                                                                <?php echo $feedback['intRating']; ?> &#9733;
                                                            </div>
                                                            <?php
                                                            if ($feedback['intRating'] == '5') {
                                                                $title = "Awesome";
                                                            } else if ($feedback['intRating'] == '4.5') {
                                                                $title = "Excellent";
                                                            } else if ($feedback['intRating'] == '4') {
                                                                $title = "Pretty good";
                                                            } else if ($feedback['intRating'] == '3.5') {
                                                                $title = "Good";
                                                            } else if ($feedback['intRating'] == '3') {
                                                                $title = "Average - Good";
                                                            } else if ($feedback['intRating'] == '2.5') {
                                                                $title = "Average";
                                                            } else if ($feedback['intRating'] == '2') {
                                                                $title = "Low Average";
                                                            } else if ($feedback['intRating'] == '1.5') {
                                                                $title = "Not Good";
                                                            } else if ($feedback['intRating'] == '1') {
                                                                $title = "Bad";
                                                            } else if ($feedback['intRating'] == '0.5') {
                                                                $title = "Very Bad";
                                                            } else {
                                                                $title = "";
                                                            }
                                                            ?>
                                                            <p><?php echo $title; ?></p>
                                                        </div>
                                                        <div class="rating-comments">
                                                            <span><?php echo $feedback['txtComment']; ?></span>
                                                        </div>
                                                        <div class="ratings-customer">
                                                            <p><?php echo $feedback['Username'] . ", " . $feedback['varCompany']; ?></p>
                                                            <p><?php echo date("d M, Y", strtotime($feedback['dtCreateDate'])); ?></p>
                                                        </div>
                                                    </div>
                                                <?php } if (count($getWebsiteFeedback) >= 5) { ?>
                                                    <div class="rating-more-view">
                                                        <div class="hub-pro">
                                                            <a href="#" class="waves-effect waves-light btn fill-blue"><i class="material-icons dp48">stars</i>View All Ratings</a>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $getCompanyProduct = $this->Module_Model->getCompanyProductsData($ShowAllPagesRecords['intSupplier']);
            if (count($getCompanyProduct) > 0) {
                ?>
                <div class="col s12 m12 padding product-supplier-detail">

                    <div class="supplier-product card">
                        <div class="supplier-heading">
                            <div class="sup-head">
                                <h1 class="wow fadeIn animated animated inline" data-wow-duration="2s" data-wow-delay="500ms">Company Products</h1>
                            </div>
                            <div class="sup-view-all">
                                <?php
                                $getUserProductLink = $this->common_model->getUserData($ShowAllPagesRecords['intSupplier']);
                                if ($getUserProductLink['varSubdomain'] != '') {
                                    $subdomain = str_replace("___", $getUserProductLink['varSubdomain'], SUB_DOMAIN);
                                } else {
                                    $subdomain = $this->common_model->getUrl("buyer_seller", "136", $ShowAllPagesRecords['intSupplier'], '');
                                }
                                ?>
                                <a href="<?php echo $subdomain . "/product"; ?>" target="_blank" class="waves-effect waves-light btn wow fadeIn animated animated inline" data-wow-duration="2s" data-wow-delay="500ms">View All</a>
                            </div>
                        </div>
                        <div class="slider-effect list-group change-detail-slide list-group-item">

                            <section class="customer-logos slider1">
                                <?php foreach ($getCompanyProduct as $pro) { ?>


                                    <div class="slide card wow fadeIn animated animated inline">
                                        <div class="fixed-width padding-right">
                                            <div class="slider-container">
                                                <div class="slider">
                                                    <?php
                                                    $getProductImage = $this->Module_Model->getProductListingImageData($pro['int_id']);
//                                                    print_R($getProductImage);
                                                    foreach ($getProductImage as $pro_img) {
                                                        $photo_thumb = $pro_img['varImage'];
                                                        $thumb = 'upimages/productgallery/images/' . $photo_thumb;
                                                        if (file_exists($thumb) && $photo_thumb != '') {
                                                            $thumbphoto1 = image_thumb($thumb, PHOTOGALLERY_WIDTH, PHOTOGALLERY_HEIGHT);
                                                            ?>

                                                            <div class="slider__item">
                                                                <div class="in-callimg">
                                                                    <div class="place-img"></div>
                                                                    <div class="cate-img1">

                                                                        <div class="in-changeimg">
                                                                            <img src="<?php echo $thumbphoto1; ?>" alt="<?php echo $pro['varName']; ?>" title="<?php echo $pro['varName']; ?>"> 
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                            <div class="list-related-button">
                                                <ul class="list-inline">
                                                    <li>
                                                        <a href="javascript:;"  onclick="return addtofav(<?php echo $pro['int_id']; ?>);" class="list-heart similar-like">
                                                            <?php if (USER_ID == '') { ?>
                                                                <i class="far fa-heart" id="<?php echo "fav_class_" . $pro['int_id']; ?>"></i>
                                                                <?php
                                                            } else {
                                                                $checkfav = $this->common_model->checkProductFav($pro['int_id'], USER_ID);
                                                                if ($checkfav == '0') {
                                                                    ?>
                                                                    <i class="far fa-heart" id="<?php echo "fav_class_" . $pro['int_id']; ?>"></i>
                                                                <?php } else { ?>
                                                                    <i class="fas fa-heart" id="<?php echo "fav_class_" . $pro['int_id']; ?>"></i>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>

                                        </div>

                                        <div class="cat-detail">

                                            <h1><a href="<?php echo SITE_PATH . $pro['varAlias']; ?>"><?php echo $pro['varName']; ?></a></h1>

                                            <?php if ($pro['varPrice'] != '0') { ?>
                                                <?php
                                                if ($pro['varCurrency'] == '1') {
                                                    $currency = "&#8377;";
                                                } else {
                                                    $currency = "$";
                                                }
                                                ?>
                                                <div class="list-detail price">
                                                    <div class="price-special">

                                                        <nobr><h6>Price:&nbsp;</h6><span><?php echo $currency . $pro['varPrice']; ?>&nbsp;/&nbsp;<?php echo $pro['PriceUnit']; ?></span></nobr>
                                                    </div>
                                                </div>
                                            <?php } if ($pro['varMOQ'] != '0') { ?>
                                                <div class="list-detail price">
                                                    <div class="price-special">
                                                        <h6>MOQ: </h6>
                                                        <span><?php echo $pro['varMOQ']; ?>&nbsp;<?php echo $pro['MOQUnit']; ?></span>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                        </div>

                                        <div class="list-btn float-last btn-clasify">
                                            <?php
                                            if ($pro['varSubdomain'] != '') {
                                                $subdomain = str_replace("___", $pro['varSubdomain'], SUB_DOMAIN);
                                            } else {
                                                $subdomain = SITE_PATH . $pro['usersite'];
                                            }
                                            ?>
                                            <a target="_blank" href="<?php echo SITE_PATH . $pro['varAlias']; ?>?contact=1" class="waves-effect waves-light btn tooltipped" data-position="top" data-tooltip="Contact Supplier"><i class="far fa-envelope-open"></i> Contact Supplier</a> 
                                            <a href="javascript:;" class="none-chatt waves-effect waves-light btn tooltipped chat-clear none-chatt on-chatt" data-position="top" data-tooltip="Chat Now"><i class="far fa-comments"></i></a>
                                        </div>

                                    </div>

                                <?php } ?>
                            </section>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php
            $getProductCategory = $this->Module_Model->getCategoryProductsData($ShowAllPagesRecords['intParentCategory']);
            if (count($getProductCategory) > 0) {
                ?>
                <div class="col s12 m12 padding product-supplier-detail">
                    <div class="supplier-product card">
                        <div class="supplier-heading">
                            <div class="sup-head">
                                <h1 class="wow fadeIn animated animated inline">Similar Products</h1>
                            </div>
                            <div class="sup-view-all">
                                <a href="<?php echo $this->common_model->getUrl("pages", "2", "51", '') . "?cat=" . $ShowAllPagesRecords['intParentCategory']; ?>" class="waves-effect waves-light btn wow fadeIn animated animated inline" data-wow-duration="2s" data-wow-delay="500ms">View All</a>
                            </div>
                        </div>
                        <div class="slider-effect list-group change-detail-slide list-group-item similer-product">
                            <section class="customer-logos slider1 ">
                                <?php foreach ($getProductCategory as $category) { ?>

                                    <div class="slide card wow fadeIn animated animated inline">
                                        <div class="fixed-width padding-right">
                                            <div class="slider-container">
                                                <div class="slider">

                                                    <?php
                                                    $getProductImages = $this->Module_Model->getProductListingImageData($category['int_id']);
//                                                    print_R($getProductImage);
                                                    foreach ($getProductImages as $pro_imgs) {
                                                        $photo_thumb = $pro_imgs['varImage'];
                                                        $thumb = 'upimages/productgallery/images/' . $photo_thumb;
                                                        if (file_exists($thumb) && $photo_thumb != '') {
                                                            $thumbphoto1 = image_thumb($thumb, PHOTOGALLERY_WIDTH, PHOTOGALLERY_HEIGHT);
                                                            ?>

                                                            <div class="slider__item">
                                                                <div class="in-callimg">
                                                                    <div class="place-img"></div>
                                                                    <div class="cate-img1">
                                                                        <div class="in-changeimg">
                                                                            <img src="<?php echo $thumbphoto1; ?>" alt="<?php echo $category['varName']; ?>" title="<?php echo $category['varName']; ?>"> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="list-related-button">
                                                <ul class="list-inline">
                                                    <li>
                                                        <a href="javascript:;"  onclick="return addtofav(<?php echo $category['int_id']; ?>);" class="list-heart similar-like">
                                                            <?php
                                                            $checkfav = $this->common_model->checkProductFav($category['int_id']);
                                                            if ($checkfav == '0') {
                                                                ?>
                                                                <i class="far fa-heart" id="<?php echo "fav_class_" . $category['int_id']; ?>"></i>
                                                            <?php } else { ?>
                                                                <i class="fas fa-heart" id="<?php echo "fav_class_" . $category['int_id']; ?>"></i>
                                                            <?php } ?>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>

                                            <div class="cat-detail">
                                                <p><?php echo $category['varCompany']; ?></p>
                                                <?php if ($category['varCity'] != '') { ?>
                                                    <h6><?php echo $category['varCity']; ?>(<?php echo $category['varCountry']; ?>)</h6>
                                                <?php } ?>
                                                <h1><a href="<?php echo SITE_PATH . $category['varAlias']; ?>"><?php echo $category['varName']; ?></a></h1>
                                                <?php if ($category['varPrice'] != '0') { ?>
                                                    <?php
                                                    if ($category['varCurrency'] == '1') {
                                                        $currency = "&#8377;";
                                                    } else {
                                                        $currency = "$";
                                                    }
                                                    ?>
                                                    <div class="list-detail price">
                                                        <div class="price-special">

                                                            <nobr><h6>Price:&nbsp;</h6><span><?php echo $currency . $category['varPrice']; ?>&nbsp;/&nbsp;<?php echo $category['PriceUnit']; ?></span></nobr>
                                                        </div>
                                                    </div>
                                                <?php } if ($category['varMOQ'] != '0') { ?>
                                                    <div class="list-detail price">
                                                        <div class="price-special">
                                                            <h6>MOQ: </h6>
                                                            <span><?php echo $category['varMOQ']; ?>&nbsp;<?php echo $category['MOQUnit']; ?></span>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>


                                        </div>



                                        <div class="list-btn float-last btn-clasify">

                                            <a target="_blank" href="<?php echo SITE_PATH . $category['varAlias']; ?>?contact=1" class="waves-effect waves-light btn tooltipped" data-position="top" data-tooltip="Contact Supplier"><i class="far fa-envelope-open"></i> Contact Supplier</a> 

                                            <a href="javascript:;" class="none-chatt waves-effect waves-light btn tooltipped chat-clear none-chatt on-chatt" data-position="top" data-tooltip="Chat Now"><i class="far fa-comments"></i></a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </section>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div id="contact-suppliermain" class="modal modal-fixed-footer get-quot-popup contect-supplier-withdetail">
    <?php
    $attributes = array('name' => 'FrmProduct', 'id' => 'FrmProduct', 'enctype' => 'multipart/form-data', 'class' => 'register-form all-product-form', 'method' => 'post');
    $action = $this->common_model->getUrl("pages", "2", "50", '') . "/contact_supplier";
    echo form_open($action, $attributes);
    ?>
    <div class="modal-content mCustomScrollbar light" data-mcs-theme="minimal-dark">
        <div class="contact-sup-main row">
            <div class="contact-sup-head"><h6 class="modal-title">CONTACT SUPPLIER</h6></div>
            <div class="contact-all-detail">



                <input type="hidden" id="intProduct" name="intProduct" value="<?php echo RECORD_ID; ?>">
                <div class="col s12 m12">
                    <div class="conttect-slide">
                        <div class="col s12 m5">
                            <div class="name-contect-sup">
                                <h6><?php echo $ShowAllPagesRecords['CompanyName']; ?></h6>
                            </div>
                            <div class="slider">
                                <ul class="slides">
                                    <?php
                                    $getProductImage = $this->Module_Model->getProductImage(RECORD_ID);
                                    $photo_thumbs = $getProductImage['varImage'];
                                    $thumbs = 'upimages/productgallery/images/' . $photo_thumbs;
                                    if (file_exists($thumbs) && $photo_thumbs != '') {
                                        $thumbphoto1 = image_thumb($thumb, PHOTOGALLERY_WIDTH, PHOTOGALLERY_HEIGHT);
                                        $original_thumb = SITE_PATH . $thumbs;
                                        ?>
                                        <li>
                                            <img src="<?php echo $original_thumb; ?>">
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col s12 m2">
                        </div>
                        <div class="col s12 m4">
                            <div class="rfq-attachment  upload-attachment">
                                <div class="custom-file-container" style="padding:0" data-upload-id="mySecondImage">
                                    <!--<h1>File Attachment</h1>-->
                                    <label><a href="javascript:;" class="custom-file-container__image-clear" title="Clear Image"></a></label>
                                    <label class="custom-file-container__custom-file" >
                                        <input type="file" id="varBrochure" name="varBrochure" class="custom-file-container__custom-file__custom-file-input" accept="*" >
                                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                                    </label>
                                    <div class="custom-file-container__image-preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="contact-supp-list">
                        <input  readonly type="hidden" id="varUProduct" name="varUProduct" value="<?php echo $ShowAllPagesRecords['varName']; ?>">
                        <input readonly type="hidden" name="varHSCode" id="varHSCode" value="<?php echo $ShowAllPagesRecords['varHSCode']; ?>">
                        <input readonly type="hidden" name="varMaterial" id="varMaterial" value="<?php echo $ShowAllPagesRecords['varMaterial']; ?>">
                        <input readonly type="hidden" name="txtDescription" id="txtDescription" value="<?php echo strip_tags($ShowAllPagesRecords['txtDescription']); ?>">

                    </div>
                </div>


                <div class="detail-show">
                </div>
                <div class="col s12 m12">
                    <div class="right-show-detail">
                        <input type="hidden"  id="varUse" name="varUse" value="<?php echo $ShowAllPagesRecords['varUse']; ?>">
                        <div class="col m12 s12 location-fill prefer-width">
                            <div class="input-field field-custom">
                                <textarea id="txtUDescription" required="" name="txtUDescription" class="materialize-textarea"></textarea>
                                <label for="txtUDescription">Description</label>
                            </div>
                        </div>
                        <div class="col m6 s12 clear-both get-bprder-mixed">
                            <div class="col m6 s6 more-info padding border-radius qty-paid">
                                <div class="form-part margin-none quntity-contact">
                                    <div class="input-field field-custom">
                                        <input id="varQty" name="varQty" required type="text"  onkeypress="return KeycheckOnlyNumeric(event);">
                                        <label for="varQty" class="">Qty</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col m6 s6 more-info padding padding-right border-radius">
                                <div class="form-part margin-none">
                                    <div class="input-field field-custom">
                                        <?php echo $getMOQUnitData; ?>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="col m6 s12 mixed  currency-width-product">
                            <div class="col l2 m3 s3 padding">
                                <div class="input-field field-custom">
                                    <select  id="varCurrency" name="varCurrency">        
                                        <option value="1" selected="">&#8377;</option>
                                        <option value="2">$</option>
                                    </select>
                                    <!-- <label>Sub Category</label> -->
                                </div>
                            </div> 
                            <div class="col m5 s5 padding">
                                <div class="input-field field-custom">
                                    <input id="varPrice" name="varPrice" type="text" onkeypress="return KeycheckOnlyNumeric(event);">
                                    <label for="varPrice" class="">Price<sup>*</sup></label>
                                </div>
                            </div> 
                            <div class="col l5 m4 s4 padding">
                                <div class="input-field field-custom">
                                    <?php echo $getPriceUnitData; ?>
                                    <!-- <label>Sub Category</label> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12">
                    <div class="contact-quots-supp">
                        <label>
                            <input id="chrMatching" name="chrMatching" type="checkbox" class="filled-in" />
                            <span>Matching supplier </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer submit-footer contact-supp-btn">
        <input type="submit" class="waves-effect waves-blue btn-flat" value="Send Inquiry">      
    </div>
</div>

<?php
echo form_close();
?>
<div class="close-outside"><a href="javascript:;" class="modal-close waves-effect waves-blue btn-flat"><i class="fas fa-times"></i></a></div>

<script src="<?php echo FRONT_MEDIA_URL; ?>js/file-upload-with-preview.js"></script>
<script>
                                        var secondUpload = new FileUploadWithPreview('mySecondImage');
</script>
<script type="text/javascript" src="<?php echo FRONT_MEDIA_URL; ?>js/product-slider.js"></script> 