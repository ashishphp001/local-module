<?php foreach ($getProductListing as $row) { ?>
    <div class="col s12 m6"> 
        <div class="row-supplier-list card">
            <div class="col m5 s12 padding">
                <div class="supplier-pro-img">
                    <?php $getProductImages = $this->Module_Model->getProductImages($row['intSupplier']); ?>
                    <?php foreach ($getProductImages as $images) { ?>
                        <div class="in-callimg">
                            <div class="place-img"></div>
                            <div class="cate-img1">
                                <div class="in-changeimg">
                                    <a href="<?php echo SITE_PATH . $images['varAlias']; ?>">
                                        <?php
                                        $photo_thumb = $images['varImage'];
                                        $thumb = 'upimages/productgallery/images/' . $photo_thumb;
                                        if (file_exists($thumb) && $photo_thumb != '') {
                                            $thumbphoto1 = image_thumb($thumb, PHOTOGALLERY_WIDTH, PHOTOGALLERY_HEIGHT);
                                        } else {
                                            $thumbphoto1 = FRONT_MEDIA_URL . "images/no_img/ib_no_image.jpg";
                                        }
                                        ?>
                                        <img src="<?php echo $thumbphoto1; ?>" alt="<?php echo $images['varName']; ?>" title="<?php echo $images['varName']; ?>">
                                        <div class="user-related-content">
                                            <span><?php echo $images['varName']; ?></span>
                                        </div>
                                    </a>
                                    <span class="on-sup-prod-hover">
                                        <div class="call-image">
                                            <img src="<?php echo $thumbphoto1; ?>" title="<?php echo $images['varName']; ?>" alt="<?php echo $images['varName']; ?>">
                                        </div>
                                        <a href="<?php echo SITE_PATH . $images['varAlias']; ?>" class="sup-cont"><?php echo $images['varName']; ?></a>
                                        <a href="javascript:;"  onclick="return addtofav(<?php echo $images['intProduct']; ?>);" class="list-heart">
                                            <?php if (USER_ID == '') { ?>
                                                <i class="far fa-heart" id="<?php echo "fav_class_" . $images['intProduct']; ?>"></i>
                                                <?php
                                            } else {
                                                $checkfav = $this->common_model->checkProductFav($images['intProduct'], USER_ID);
                                                if ($checkfav == '0') {
                                                    ?>
                                                    <i class="far fa-heart" id="<?php echo "fav_class_" . $images['intProduct']; ?>"></i>
                                                <?php } else { ?>
                                                    <i class="fas fa-heart" id="<?php echo "fav_class_" . $images['intProduct']; ?>"></i>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>


                </div>
            </div>
            <div class="col s12 m7 l7">
                <div class="list-user-cont">
                    <div class="list-pro-name">
                        <div class="companyname">
                            <a href="javascript:;" class="comp-name company-name-list"><img src="<?php echo FRONT_MEDIA_URL; ?>/images/scurity.png" alt="Security" title="Security"><?php echo $row['CompanyName']; ?></a>
                        </div>
                    </div>
                    <div class="right-list">
                        <div class="companyname trade-asurence special-none">
                            <?php if ($row['varCity'] != '') { ?>
                                <a href="javascript:;"><i class="fas fa-map-marker-alt"></i>&nbsp;<?php echo $row['varCity']; ?> (<?php echo $row['varCountry']; ?>)</a>
                            <?php } ?>
                        </div>
                        <?php if ($row['varBusinessType'] != '') { ?>
                            <div class="companyname business-rate special-none">                                                
                                <span><?php
                                    $getBusinessType = $this->Module_Model->getBusinessType($row['varBusinessType']);
                                    echo rtrim($getBusinessType, ", ");
                                    ?></span>
                            </div>
                        <?php } ?>
                        <!--                        <div class="companyname near-to">
                                                    <div class="response-rate">
                                                        <p>Response Rate : &nbsp;</p>
                                                        <span>68.8%</span>
                                                    </div>
                                                </div>-->
                        <?php // if ($row['chrTradeSecurity'] == 'Y') { ?>
                        <!--                                                            <div class="companyname mode-define special-none">
                                                                                        <a href=""><img src="<?php echo FRONT_MEDIA_URL; ?>images/trade-security.png" alt=""> Trade Security</a>
                                                                                        <span><i class="fas fa-circle"></i>Online</span>
                                                                                    </div>-->
                        <?php // } ?>
                    </div>
                    <div class="list-btn float-last btn-clasify">
                        <a class="waves-effect waves-light btn tooltipped" data-position="top" data-tooltip="Contact Supplier"><i class="far fa-envelope-open"></i> Contact Supplier</a>
                        <a class="waves-effect waves-light btn tooltipped chat-now  none-chatt" data-position="top" data-tooltip="Chat Now"><i class="far fa-comments"></i>Chat Now</a>
                        <a href="#" class="waves-effect waves-light btn tooltipped chat-clear none-chatt on-chatt" data-position="top" data-tooltip="Chat Now"><i class="far fa-comments"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>