<style>
    .detail-sort-heading{
        width:205px !important;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
if (USER_ID != '') {
    $checkquote = $this->common_model->checkQuote_now_leads(RECORD_ID, USER_ID);
    if ($checkquote > 0) {
        $isQuote = '1';
    } else {
        $isQuote = '0';
    }
    $UserData = $this->common_model->getUserData(USER_ID);
} else {
    $UserData = array();
    $isQuote = '0';
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
                                    <?php
                                    if (USER_ID != '') {
                                        if ($UserData['chrPayment'] == 'Y') {
                                            if ($UserData['intQuoteLeft'] == '0') {
                                                $getPlanData = $this->common_model->getPlanData($UserData['intPlan']);
                                                ?>
                                                <p><b>Oops!</b> It seems your leads are expired. You can continue in just &#8377;<?php echo $getPlanData['intPerBuyLead']; ?></p>
                                            <?php } else { ?>
                                                <p>Quote your amazing deals now.</p>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <p><b>Congratulations! </b> <br>We have brought a very good opportunity to get a membership with us. Join us to touch your sky.</p>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        Login Required.
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col s12 m3">
                                <div class="rfq-click-quot">
                                    <?php
                                    if (USER_ID != '') {
                                        if ($UserData['chrPayment'] == 'Y') {
                                            if ($_GET['quote'] == 1 || $isQuote == '1') {
                                                $getQuoteNowUrl = $this->common_model->getUrl("pages", "2", "100", '') . "?buylead=" . RECORD_ID;
                                                ?>
                                                <a href="<?php echo $getQuoteNowUrl; ?>" class="quots-accement change-one waves-effect waves-light btn">Quote Now</a>
                                                <!--<a href="javascript:;" class="quots-accement waves-effect waves-light btn" onclick="openaccesslead()">Quote Now</a>-->
                                                <!--                                                    <div id="panel">
                                                                                                        <a href="#accesslead" class="quots-accement change-one waves-effect waves-light btn modal-trigger">Upload</a>
                                                                                                        
                                                                                                        <a href="<?php echo $getQuoteNowUrl; ?>" class="quots-accement change-one waves-effect waves-light btn">Quote Now</a>
                                                                                                    </div>-->
                                                <?php
                                            } else {
                                                if ($UserData['intQuoteLeft'] == '0') {
                                                    ?>
                                                    <!--150rs popup-->
                                                    <a href="javascript:;" class="quots-accement waves-effect waves-light btn">Access By Lead</a>
                                                    <?php
                                                } else {

                                                    $QuoteNowUrl = $this->common_model->getUrl("buyleads", "147", RECORD_ID, '') . "?quote=1";
                                                    ?>
                                                    <a href="<?php echo $QuoteNowUrl; ?>" class="quots-accement waves-effect waves-light btn">Access By Lead</a>
                                                    <?php
                                                }
                                            }
                                        } else {
                                            $getMembershipUrl = $this->common_model->getUrl("pages", "2", "44", '') . "?buylead=" . RECORD_ID;
                                            ?>
                                            <a href="<?php echo $getMembershipUrl; ?>" target="_blank" class="quots-accement waves-effect waves-light btn">Access By Lead</a>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <a id="loginclick" href="#home-login-popup" class="quots-accement waves-effect waves-light btn modal-trigger">Access By Lead</a>
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
                                        <h6><?php echo $ShowAllPagesRecords['varName']; ?></h6>
                                        <?php echo date('d', strtotime($ShowAllPagesRecords['dtCreateDate'])) . " " . date('M, Y H:i', strtotime($ShowAllPagesRecords['dtCreateDate'])); ?>
                                    </div>
                                </div>
                                <div class="col s12 m9 l9 all-padding-main" style="text-align: left;">
                                    <div class="col s12 m12 l12 all-info-support" >
                                        <h6>Basic Detail</h6>
                                        <div class="inner-detail detail-price">
                                            <div class="detail-sort-heading"><nobr>Requirement Type:</nobr></div>
                                            <div class="brand-detail"><?php echo $ShowAllPagesRecords['varReqType']; ?></div>
                                        </div>

                                        <div class="inner-detail detail-price">
                                            <div class="detail-sort-heading">Description:</div>
                                            <div class="brand-detail"><?php echo $ShowAllPagesRecords['txtDescription']; ?></div>
                                        </div>
                                        <?php
                                        if ($ShowAllPagesRecords['chrApproxOrder'] == 'Y') {
                                            if ($ShowAllPagesRecords['varExpectedPrice'] != '0' && $ShowAllPagesRecords['varExpectedPrice'] != '') {
                                                ?>
                                                <div class="inner-detail detail-price">
                                                    <div class="detail-sort-heading">Expected Price:</div>
                                                    <div class="brand-detail"><?php
                                                        if ($ShowAllPagesRecords['varExpectedPrice'] != '') {
                                                            if ($ShowAllPagesRecords['varCurrency'] == '1') {
                                                                echo "&#8377;";
                                                            } else {
                                                                echo "$";
                                                            }
                                                            echo $ShowAllPagesRecords['varExpectedPrice'] . " / " . $ShowAllPagesRecords['EUnit'];
                                                        }
                                                        ?></div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        if ($ShowAllPagesRecords['varQuantity'] != '') {
                                            ?>
                                            <div class="inner-detail detail-price">
                                                <div class="detail-sort-heading">MOQ:</div>
                                                <div class="brand-detail"><?php echo $ShowAllPagesRecords['varQuantity'] . " " . $ShowAllPagesRecords['PriceUnit']; ?></div>
                                            </div>
                                        <?php } if ($ShowAllPagesRecords['varStartPrice'] != '' && $ShowAllPagesRecords['varStartPrice'] != '0') { ?>
                                            <div class="inner-detail detail-price">
                                                <div class="detail-sort-heading">Approx Order:</div>
                                                <div class="brand-detail"> <?php
                                                    if ($ShowAllPagesRecords['varApproxCurrency'] == '1') {
                                                        $aorder = "&#8377;";
                                                    } else {
                                                        $aorder = "$";
                                                    }
                                                    echo $aorder . $ShowAllPagesRecords['varStartPrice'] . " - " . $aorder . $ShowAllPagesRecords['varEndPrice'];
                                                    ?></div>
                                            </div>
                                        <?php } ?>
                                        <div class="inner-detail detail-price">
                                            <div class="detail-sort-heading">Requirement Type:</div>
                                            <div class="brand-detail"> <?php echo $ShowAllPagesRecords['varReqType']; ?></div>
                                        </div>
                                        <div class="inner-detail detail-price">
                                            <div class="detail-sort-heading">Requirement Time:</div>
                                            <div class="brand-detail"> <?php if ($ShowAllPagesRecords['chrRequirement'] == 'U') { ?>
                                                    Urgent
                                                <?php } else { ?>
                                                    With in <?php
                                                    echo $ShowAllPagesRecords['varDays'] . " Days";
                                                }
                                                ?></div>
                                        </div>
                                        <?php if ($ShowAllPagesRecords['ProductCategory'] != '') { ?>
                                            <div class="inner-detail detail-price">
                                                <div class="detail-sort-heading">Industry Type:</div>
                                                <div class="brand-detail"><?php echo $ShowAllPagesRecords['ProductCategory']; ?></div>
                                            </div>
                                        <?php } ?>
                                        <div class="inner-detail detail-price">
                                            <div class="detail-sort-heading">Preferred Supplier Location <?php
                                                if ($ShowAllPagesRecords['varLocation2'] != '') {
                                                    echo "1";
                                                }
                                                ?>: 
                                            </div>
                                            <div class="brand-detail">
                                                <?php
                                                if ($ShowAllPagesRecords['varLocation'] != '') {
                                                    echo $ShowAllPagesRecords['varLocation'];
                                                } else {
                                                    echo "-";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php if ($ShowAllPagesRecords['varLocation2'] != '') { ?>
                                            <div class="inner-detail detail-price">
                                                <div class="detail-sort-heading">Preferred Supplier Location 2 :
                                                </div>
                                                <div class="brand-detail">
                                                    <?php echo $ShowAllPagesRecords['varLocation2']; ?>
                                                </div>
                                            </div>
                                        <?php } if ($ShowAllPagesRecords['varLocation3'] != '') { ?>
                                            <div class="inner-detail detail-price">
                                                <div class="detail-sort-heading">Preferred Supplier Location 3 :
                                                </div>
                                                <div class="brand-detail">
                                                    <?php echo $ShowAllPagesRecords['varLocation3']; ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <a class="read-more-show waves-effect waves-light btn" href="#" id="1">Read More...</a>
                                    <div class="user-other-detail read-more-content hide01">
                                        <div class="col s12 m12 l12 all-info-support">
                                            <h6>Other Details</h6>
                                            <?php
                                            if ($ShowAllPagesRecords['varBusinessType'] != '') {
                                                $businessname = $this->Module_Model->getBusinessTypeName($ShowAllPagesRecords['varBusinessType']);
                                                ?>
                                                <div class="inner-detail detail-price">
                                                    <div class="detail-sort-heading">Preferred Supplier Type: </div>

                                                    <div class="brand-detail">
                                                        <?php echo $businessname; ?>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <div class="inner-detail detail-price">
                                                <div class="detail-sort-heading">Want To Import:</div>
                                                <div class="brand-detail">
                                                    <?php
                                                    if ($ShowAllPagesRecords['chrImport'] == 'Y') {
                                                        echo "Yes";
                                                    } else {
                                                        echo "No";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php if ($ShowAllPagesRecords['varPackaging'] != '') { ?>
                                                <div class="inner-detail detail-price">
                                                    <div class="detail-sort-heading">Packing:</div>
                                                    <div class="brand-detail">
                                                        <?php echo $ShowAllPagesRecords['varPackaging']; ?>
                                                    </div>
                                                </div>
                                            <?php } ?>


                                        </div>
                                        <a class="read-more-hide waves-effect waves-light btn" href="javascript:;" more-id="1">Read Less...</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="rfq-list-information contact-info-rfq">
                            <div class="profile-match">
                                <div class="col s12 m12 l12 padding"  style="text-align:left">
                                    <div class="detail-tabs">

                                        <div class="col s12 padding">
                                            <ul class="tabs">
                                                <li class="tab"><a class="active" href="#company-detail">Company Information</a></li>
                                                <li class="tab"><a href="#packing">Quote Record</a></li>
                                            </ul>
                                        </div>

                                        <div class="card tab-withdetail">
                                            <div id="company-detail" class="col s12">
                                                <div class="basic-detail-info">
                                                    <?php
//                                    echo $ShowAllPagesRecords['chrPayment'].$ShowAllPagesRecords['intQuoteLeft'].USER_ID;
                                                    if (($UserData['chrPayment'] == 'Y' && $UserData['intQuoteLeft'] != '0' && USER_ID != '' && $_GET['quote'] == 1) || $isQuote == '1') {
//                                                        $username = $ShowAllPagesRecords['Username'];
                                                        if ($ShowAllPagesRecords['varSubdomain'] != '') {
                                                            $website = str_replace("___", $ShowAllPagesRecords['varSubdomain'], SUB_DOMAIN);
                                                        } else {
                                                            $website = $this->common_model->getUrl("buyer_seller", "136", $ShowAllPagesRecords['intUser'], '');
                                                        }
                                                        $companyname = "<a href='" . $website . "' target='_blank'>" . $ShowAllPagesRecords['CompanyName'] . "</a>";
                                                        $email = "<a href='mailto:" . $ShowAllPagesRecords['UserEmail'] . "'>" . $ShowAllPagesRecords['UserEmail'] . "</a>";
                                                        $phone = $ShowAllPagesRecords['UserPhone'];
                                                        $tel = $ShowAllPagesRecords['UserTel'];
                                                        $updatebuylead = $this->common_model->updatequote_now_leads(RECORD_ID, USER_ID);

                                                        if ($tel == '') {
                                                            $tel = "-";
                                                        }
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

                                                    $city = $ShowAllPagesRecords['varCity'];
                                                    $country = $ShowAllPagesRecords['varCountry'];
                                                    ?>
                                                    <div class="col s12 m12 l12 all-info-support">
                                                        <div class="inner-detail detail-price">
                                                            <div class="detail-sort-heading">Full Name:</div>
                                                            <div class="brand-detail"><?php echo $ShowAllPagesRecords['Username']; ?></div>
                                                        </div>
                                                        <?php if ($city != '') { ?>
                                                            <div class="inner-detail detail-price">
                                                                <div class="detail-sort-heading">Location:</div>
                                                                <div class="brand-detail"><?php echo $city; ?> (<?php echo $country; ?>)</div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="inner-detail detail-price">
                                                            <div class="detail-sort-heading">Company Name:</div>
                                                            <div class="brand-detail"><?php echo $companyname; ?></div>
                                                        </div>
                                                        <div class="inner-detail detail-price">
                                                            <div class="detail-sort-heading">Email:</div>
                                                            <div class="brand-detail"><?php echo $email; ?></div>
                                                        </div>
                                                        <div class="inner-detail detail-price">
                                                            <div class="detail-sort-heading">Phone No:</div>
                                                            <div class="brand-detail"><?php echo $phone; ?></div>
                                                        </div>
                                                        <div class="inner-detail detail-price">
                                                            <div class="detail-sort-heading">Tel No:</div>
                                                            <div class="brand-detail"><?php echo $tel; ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="packing" class="col s12">
                                                <div class="basic-detail-info">
                                                    <?php $getQuoteNowData = $this->Module_Model->getQuoatationData(RECORD_ID); ?>
                                                    <div class="col s12 m12 l12 all-info-support">
                                                        <?php if (count($getQuoteNowData) > 0) { ?>
                                                            <table>
                                                                <tr>
                                                                    <td>Company Name</td>
                                                                    <td>Location</td>
                                                                    <td>Date Time</td>
                                                                    <td>Email</td>
                                                                    <td>Response</td>
                                                                </tr>
                                                                <?php
                                                                foreach ($getQuoteNowData as $quote) {
                                                                    ?>

                                                                    <tr>
                                                                        <td>
                                                                            XXXXX XXXXX
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            if ($quote['varCity'] != '') {
                                                                                echo $quote['varCity'];
                                                                                ?> (<?php echo $quote['varCountry']; ?>)
                                                                                <?php
                                                                            } else {
                                                                                echo "-";
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo date('d M, Y h:i:s A', strtotime($quote['dtCreateDate'])); ?>
                                                                        </td>
                                                                        <td>
                                                                            XXXXXX@XXXX.com
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            if ($quote['intResponse'] == '1') {
                                                                                echo "Read";
                                                                            } else if ($quote['intResponse'] == '2') {
                                                                                echo "Accepted";
                                                                            } else {
                                                                                echo "Unread";
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>

                                                                <?php } ?>
                                                            </table>
                                                            <?php
                                                        } else {
                                                            echo "No Records found.";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="col s12 m3">
                    <?php
                    $getSideBuyleadsData = $this->Module_Model->getSideSupplier($ShowAllPagesRecords['intProduct']);
                    foreach ($getSideBuyleadsData as $row) {
                        ?>
                        <div class="related-rfq card">
                            <div class="supplier-detail-right-side">
                                <div class="right-list">
                                    <div class="related-head-image">
                                        <div class="rfq-related-image">
                                            <?php
                                            $ImagePath = 'upimages/buyleads/images/' . $row['varImage'];
                                            if (file_exists($ImagePath) && $row['varImage'] != '') {
                                                $image_thumb = image_thumb($ImagePath, BUY_LEADS_WIDTH, BUY_LEADS_HEIGHT);
                                            } else {
                                                $image_thumb = FRONT_MEDIA_URL . "images/no_img/ib_no_image.jpg";
                                            }
//                                            $website =$row['varAlias'];
                                            ?>
                                            <img title="<?php echo $row['varName']; ?>" name="<?php echo $row['varName']; ?>" src="<?php echo $image_thumb; ?>"> 
                                            <div class="companyname trade-asurence city-code-rfq">
                                                <a href="<?php echo SITE_PATH . $row['varAlias']; ?>"><i class="far fa-calendar-alt"></i>&nbsp;<?php echo date('d F, Y H:i', strtotime($row['dtCreateDate'])); ?></a>
                                            </div>   
                                            <div class="heading-rfq-sort"><a href="<?php echo SITE_PATH . $row['varAlias']; ?>" class="comp-name company-name-list"><?php echo $row['varName']; ?></a></div>
                                        </div>
                                    </div>
                                    <div class="companyname business-rate rfq-desc"><?php echo $row['CompanyName']; ?></div>
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
                                            <i class="fas fa-map-marker-alt"></i>&nbsp;<?php echo $row['varLocation']; ?><br>
                                        <?php } if ($row['varLocation2'] != '') { ?>
                                            <i class="fas fa-map-marker-alt"></i>&nbsp;<?php echo $row['varLocation2']; ?><br>
                                        <?php } if ($row['varLocation3'] != '') { ?>
                                            <i class="fas fa-map-marker-alt"></i>&nbsp;<?php echo $row['varLocation3']; ?>
                                        <?php } ?>
                                    </div> 
                                    <div class="companyname near-to rfq-moq-price">
                                        <?php if ($row['varExpectedPrice'] != '') { ?>
                                            <div class="response-rate">
                                                <p>Price : &nbsp;</p>
                                                <span><?php
                                                    if ($row['varExpectedPrice'] != '0' && $row['varExpectedPrice'] != '') {
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
                                                <?php
                                                if (USER_ID != '') {
                                                    $checkquote = $this->common_model->checkQuote_now_leads($row['int_id'], USER_ID);
                                                    if ($checkquote > 0) {
                                                        $isQuote = '1';
                                                    } else {
                                                        $isQuote = '0';
                                                    }
                                                } else {
                                                    $isQuote = '0';
                                                }
                                                if ($isQuote == '1') {
                                                    $getQuoteNowUrl = $this->common_model->getUrl("pages", "2", "100", '') . "?buylead=" . $row['int_id'];
                                                    ?>
                                                    <a href="<?php echo $getQuoteNowUrl; ?>" class="waves-effect waves-light btn"><i class="far fa-comments"></i>Quote Now</a>
                                                <?php } else { ?>
                                                    <a href="<?php echo SITE_PATH . $row['varAlias'] . "?quote=1"; ?>" class="waves-effect waves-light btn"><i class="far fa-comments"></i>Access Buy Lead</a>
                                                <?php } ?>
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
            <input type="submit" class="uploaded-quots" value="Upload Quotation">
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