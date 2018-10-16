<?php foreach ($getRFQListing as $row) { ?>
    <div class="rfq-list-detail">
        <div class="list-rfq-row card">
            <?php
            $ImagePath = 'upimages/buyleads/images/' . $row['varImage'];
            if (file_exists($ImagePath) && $row['varImage'] != '') {
                $image_thumb = image_thumb($ImagePath, BUY_LEADS_WIDTH, BUY_LEADS_HEIGHT);
            } else {
                $image_thumb = FRONT_MEDIA_URL . "images/no_img/ib_no_image.jpg";
            }
            ?>
            <div class="col s4 m2 padding">
                <div class="in-callimg">
                    <div class="place-img"></div>
                    <div class="cate-img1 card">
                        <div class="in-changeimg rfq-detail-image">
                            <img class="materialboxed" src="<?php echo $image_thumb; ?>" alt="<?php echo $row['varName']; ?>" title="<?php echo $row['varName']; ?>">
                        </div>
                    </div>
                </div>
                <!--  -->
            </div>
            <div class="col s8 m7 main-rfq-intrest card">
                <div class="date-rfq card">
                    <div class="full-date "><?php echo date('d', strtotime($row['dtCreateDate'])); ?><span class="month"><?php echo date('M Y H:i', strtotime($row['dtCreateDate'])); ?></span></div>
                </div>
                <?php
                $keyword = $_GET['keyword'];
                $name = $row['varName'];
                $product_name = str_ireplace($keyword, '<strong class="diff-color">' . $keyword . "</strong>", $name)
                ?>
                <div class="list-of-inner">
                    <a href="<?php echo SITE_PATH . $row['varAlias']; ?>"><?php echo $product_name; ?></a>
                    <div class="col s12 m12 l12 padding rfq-list-data">
                        <?php
                        if ($row['chrApproxOrder'] == 'Y') {
                            if ($row['varExpectedPrice'] != '0' && $row['varExpectedPrice'] != '') {
                                ?>
                                <div class="list-detail price">
                                    <div class="price-special">
                                        <h6>Expected Price :</h6>
                                        <span><?php
                                            if ($row['varExpectedPrice'] != '') {
                                                if ($row['varCurrency'] == '1') {
                                                    echo "&#8377;";
                                                } else {
                                                    echo "$";
                                                }
                                                echo $row['varExpectedPrice'] . " / " . $row['EUnit'];
                                            }
                                            ?></span>
                                    </div>
                                </div>
                                <?php
                            }
                        } if ($row['PriceUnit'] != '') {
                            ?>
                            <div class="list-detail price">
                                <div class="price-special">
                                    <h6>MOQ :</h6><span><?php echo $row['varQuantity'] . " " . $row['PriceUnit']; ?></span>
                                </div>
                            </div>
                        <?php } if ($row['chrApproxOrder'] == 'Y') { ?>
                            <br>
                            <div class="list-detail price">
                                <div class="price-special">
                                    <h6>Approx Order :</h6>
                                    <span> 
                                        <?php
                                        if ($row['varApproxCurrency'] == '1') {
                                            $aorder = "&#8377;";
                                        } else {
                                            $aorder = "$";
                                        }
                                        echo $aorder . $row['varStartPrice'] . " - " . $aorder . $row['varEndPrice'];
                                        ?>
                                    </span>
                                </div>
                            </div>
                        <?php } ?>
                        <div class = "verify-all">
                            <div class = "certificat-virify">
                                <a href = ""><img src = "<?php echo FRONT_MEDIA_URL; ?>images/star.png"></a>
                            </div>
                        </div>
                        <div class = "short-desc-rfq">
                            <?php
                            $data = strip_tags($row['txtDescription']);
                            $desc = substr($data, 0, 130);
                            if (strlen($data) > 130) {
                                $pro_desc = $desc . "...";
                            } else {
                                $pro_desc = $desc;
                            }
                            ?>
                            <div class="short-desc-rfq">
                                <p><?php echo $pro_desc; ?>
                                    <span>
                                        <b><?php echo $data; ?></b>
                                    </span>
                                </p>					       
                            </div>

                        </div>
                    </div>
                </div>
                <div class = "col s12 m12 btn-rfq-more">
                    <a onclick="return addtofavbuylead(<?php echo $row['int_id']; ?>);" href="javascript:;" class = "waves-effect waves-light btn tooltipped" data-position = "top" data-tooltip = "Add to favourite">
                        <?php if (USER_ID == '') { ?>
                            <i class="far fa-heart" id="<?php echo "fav_class_" . $row['int_id']; ?>"></i>
                            <?php
                        } else {
                            $checkfav = $this->common_model->checkProductFavBuyLead($row['int_id'], USER_ID);
                            if ($checkfav == '0') {
                                ?>
                                <i class="far fa-heart" id="<?php echo "fav_class_" . $row['int_id']; ?>"></i>
                            <?php } else { ?>
                                <i class="fas fa-heart" id="<?php echo "fav_class_" . $row['int_id']; ?>"></i>
                                <?php
                            }
                        }
                        ?>
                        Add to favourite </a>
                    <a class = "waves-effect waves-light btn tooltipped mobile-reminder" data-position = "top" data-tooltip = "Set Reminder"><i class = "fas fa-bell"></i>Set Reminder</a>
                    <?php
                    $getfiles = $this->Module_Model->downloadfiles($row['int_id']);
                    if (count($getfiles) > 0) {
                        $download_attachment = SITE_PATH . "fronthome/downloadfiles?id=" . $row['int_id'];
                        ?>
                        <a href="<?php echo $download_attachment; ?>" class="waves-effect waves-light btn tooltipped" data-position = "top" data-tooltip = "Attachment"><i class = "fas fa-paperclip"></i>Attachment</a>
                    <?php } ?>
                </div>
            </div>
            <div class = "col s9 m3 buyerlist">
                <div class = "buyername">
                    <span class = "comp-name company-name-list">
                        <img src = "<?php echo FRONT_MEDIA_URL; ?>images/scurity.png" alt = ""><?php echo $row['CompanyName']; ?>
                    </span>
                    <?php if ($row['varCity'] != '') { ?>
                        <div class = "companyname trade-asurence">
                            <a href = ""><i class = "fas fa-map-marker-alt"></i>&nbsp;
                                <?php echo $row['varCity']; ?> (<?php echo $row['varCountry']; ?>)</a>
                        </div>
                    <?php } ?>
                    <div class="companyname intro-rfq">

                        <?php if ($row['chrRequirement'] == 'U') { ?>
                            <div class = "response-rate">
                                <i class = "far fa-clock"></i>Requirement Time:  <span>Urgent</span>
                            </div>
                        <?php } else { ?>
                            <div class = "response-rate ">
                                <i class = "far fa-clock"></i>Requirement Time: <span><?php echo $row['varDays'] . " Days"; ?></span>
                            </div>
                        <?php } ?>

                    </div>
                    <div class="companyname intro-rfq">
                        <div class="response-rate">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Requirement Type:  <span><?php echo $row['varReqType']; ?></span>
                        </div>
                    </div>
                </div>
                <div class = "buy-lead-main">
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
                        <a href="<?php echo $getQuoteNowUrl; ?>" class = "waves-effect waves-light btn tooltipped" data-position = "top" data-tooltip = "Quote Now"><i class = "far fa-comments"></i>Quote Now</a>
                    <?php } else { ?>
                        <a href="<?php echo SITE_PATH . $row['varAlias'] . "?quote=1"; ?>" class = "waves-effect waves-light btn tooltipped" data-position = "top" data-tooltip = "Access Buy Lead"><i class = "far fa-comments"></i>Access Buy Lead</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>