<?php
foreach ($getProductListing as $row) {
    ?>
    <div class = "col s12 m12 l12 gride-show" >
        <div class="list-row">
            <div class="col fixed-width padding-right card">
                <?php $getProductImages = $this->Module_Model->getProductListingImageData($row['int_id']); ?>
                <div class=" iamge-call">
                    <div class="slide1">
                        <div class="col-image-number">
                            <?php
                            $img = 0;
                            foreach ($getProductImages as $pro_img) {
                                $photo_thumb = $pro_img['varImage'];
                                $thumb = 'upimages/productgallery/images/' . $photo_thumb;
                                if (file_exists($thumb) && $photo_thumb != '') {
                                    $img++;
                                }
                            }
                            ?>

                            <?php echo $img; ?> Photo
                        </div>
                        <div class="arrowmain">
                            <span class="Arrows"></span>
                            <!-- Carousel Container -->
                            <div class="SlickCarousel">
                                <!-- Item -->
                                <?php
                                foreach ($getProductImages as $pro_img) {
                                    $photo_thumb = $pro_img['varImage'];
                                    $thumb = 'upimages/productgallery/images/' . $photo_thumb;
                                    if (file_exists($thumb) && $photo_thumb != '') {
                                        $thumbphoto1 = image_thumb($thumb, PHOTOGALLERY_WIDTH, PHOTOGALLERY_HEIGHT);
                                        ?>
                                        <div class="ProductBlock">
                                            <div class="Content">
                                                <div class="img-fill">
                                                    <img src="<?php echo $thumbphoto1; ?>" title="<?php echo $row['varName']; ?>" alt="<?php echo $row['varName']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }

                                if ($img == 0) {
                                    ?>
                                    <div class="ProductBlock">
                                        <div class="Content">
                                            <div class="img-fill">
                                                <img src="<?php echo FRONT_MEDIA_URL . "images/no_img/ib_no_image.jpg"; ?>" title="<?php echo $row['varName']; ?>" alt="<?php echo $row['varName']; ?>">
                                            </div>
                                        </div>
                                    </div> 
                                <?php }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-related-button">
                    <ul class="list-inline">
                        <li>
                            <a class=" far fa-heart icon-xxs icon-circle icon-darkest-filled waves-effect waves-light btn tooltipped" data-position="top" data-tooltip="favourite" target="_blank" href=""></a>
                        </li>
                        <?php
                        if ($row['varBrochure'] != '') {
                            $download_product = $this->common_model->getUrl("pages", "2", "51", '') . "/download?file=" . $row['varBrochure'];
                            ?>
                            <li>
                                <a class=" fas fa-paperclip icon-xxs icon-circle icon-darkest-filled waves-effect waves-light btn tooltipped" data-position="top" data-tooltip="Attachment" href="<?php echo $download_product; ?>"></a>
                            </li>
                        <?php } ?>
                        <?php if ($row['chrSample'] == 'Y') { ?>
                            <li>
                                <a class=" fas fa-balance-scale icon-xxs icon-circle icon-darkest-filled waves-effect waves-light btn tooltipped none-chatt" data-position="top" data-tooltip="Get Free Sample" target="_blank" href=""></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>	
            </div>
            <div class="list-gride-combo">
                <div class="list-detail gride-list card">
                    <div class="col s12 m12 list-heading">
                        <div class="col s12 m10 list-main-gride">
                            <a href="#" class="list-heart">
                                <i class="fas fa-heart"></i>
                            </a>
                            <?php
                            $keyword = $this->input->get_post('keyword');
                            $name = $row['varName'];
                            $product_name = str_ireplace($keyword, '<strong class="diff-color">' . $keyword . "</strong>", $name)
                            ?>
                            <div class="list-pro-name">
                                <a href="<?php echo SITE_PATH . $row['varAlias']; ?>" class="list-head-most"><?php echo $product_name; ?></a>
                                <!--<a href="" class="list-head-most">Product011 <strong class="diff-color">supplier</strong> Name of The person supplier The person supplier</a>-->
                            </div>
                        </div>
                        <div class="col s12 m2 rating-info">
                            <div class="user-rating-all">
                                <div class="star-ratings-sprite"><span style="width:52%" class="star-ratings-sprite-rating"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col m7 s12 l8 padding-right gride-info-full smess-all">
                        <div class="listview">
                            <div class="product-list">
                                <div class="col s12 m5 l4 padding-left most-left gride-info-full">
                                    <?php if ($row['varPrice'] != '0') { ?>
                                        <div class="list-detail price">
                                            <div class="price-special">
                                                <h6>Price</h6>
                                                <span> <?php
                                                    if ($row['varCurrency'] == '1') {
                                                        echo "&#8377;";
                                                    } else {
                                                        echo "$";
                                                    }
                                                    ?><?php echo $row['varPrice']; ?>&nbsp;/&nbsp;<?php echo $row['PriceUnit']; ?></span>
                                            </div>
                                        </div>
                                    <?php } if ($row['varMOQ'] != '0') { ?>
                                        <div class="list-detail price">
                                            <div class="price-special">
                                                <h6>MOQ</h6>
                                                <span><?php echo $row['varMOQ']; ?>&nbsp;<?php echo $row['MOQUnit']; ?></span>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col s12 m8 list-source gride-info-full list-info-mid special-none">
                                    <?php if ($row['varBrand'] != '') { ?>
                                        <div class="info-list">
                                            <span class="name-list"> Brand name:</span>
                                            <span><?php
                                                $bdata = $row['varBrand'];
                                                $bd = substr($bdata, 0, 45);
                                                if (strlen($bdata) > 45) {
                                                    $brand = $bd . "...";
                                                } else {
                                                    $brand = $bd;
                                                }
                                                echo $brand;
                                                ?></span>
                                        </div>
                                    <?php } ?>
                                    <?php if ($row['varMaterial'] != '') { ?>
                                        <div class="info-list">
                                            <span class="name-list">Material Type: </span>
                                            <span>
                                                <?php
                                                $mdata = $row['varMaterial'];
                                                $mat = substr($mdata, 0, 40);
                                                if (strlen($mdata) > 40) {
                                                    $material = $mat . "...";
                                                } else {
                                                    $material = $mat;
                                                }
                                                echo str_replace(",", ", ", $material);
                                                ?>
                                            </span>
                                        </div>
                                    <?php } ?>
                                    <?php if ($row['varModelNo'] != '') { ?>
                                        <div class="info-list">
                                            <span class="name-list">Model Number: </span>
                                            <span>
                                                <?php
                                                $modata = $row['varModelNo'];
                                                $mod = substr($modata, 0, 45);
                                                if (strlen($modata) > 45) {
                                                    $model = $mod . "...";
                                                } else {
                                                    $model = $mod;
                                                }
                                                ?>
                                                <?php echo $model; ?></span>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="short-desc">
                                <?php
                                $data = $row['txtDescription'];
                                $desc = substr($data, 0, 120);
                                if (strlen($data) > 120) {
                                    $pro_desc = $desc . "...";
                                } else {
                                    $pro_desc = $desc;
                                }
                                echo strip_tags($pro_desc);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m5 l4 supplier-width padding same-left gride-responce">
                        <div class="right-list">
                            <?php if ($row['chrTradeSecurity'] == 'Y') { ?>
                                <div class="shield-source" style="background: url(<?php echo FRONT_MEDIA_URL; ?>images/shild.png) no-repeat;"></div>
                            <?php } ?>
                            <div class="companyname">
                                <a href="" class="comp-name company-name-list"><img src="<?php echo FRONT_MEDIA_URL; ?>images/scurity.png" alt="<?php echo $row['CompanyName']; ?>" title="<?php echo $row['CompanyName']; ?>"><?php echo $row['CompanyName']; ?></a>
                            </div>
                            <?php if ($row['varCity'] != '') { ?>
                                <div class="companyname trade-asurence special-none">
                                    <a href="javascript:;"><i class="fas fa-map-marker-alt"></i>&nbsp;<?php echo $row['varCity']; ?> (<?php echo $row['varCountry']; ?>)</a>
                                </div>
                            <?php } if ($row['varBusinessType'] != '') { ?>
                                <div class="companyname business-rate special-none">                                                
                                    <span><?php
                                        $getBusinessType = $this->Module_Model->getBusinessType($row['varBusinessType']);
                                        echo rtrim($getBusinessType, ", ");
                                        ?></span>
                                </div>
                            <?php } ?>
                            <div class="companyname near-to">
                                <div class="response-rate">
                                    <p>Response Rate : &nbsp;</p>
                                    <span>N/A</span>
                                </div>
                            </div>
                            <div class="companyname mode-define special-none">
                                <?php if ($row['chrTradeSecurity'] == 'Y') { ?>
                                    <img src="<?php echo FRONT_MEDIA_URL; ?>images/trade-security.png" alt=""> Trade Security
                                <?php } ?>
                                <span><i class="fas fa-circle"></i>Online</span>
                                 <!-- <span><i class="far fa-dot-circle color-off"></i>2 hour(ago)</span> -->
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m12 gride-padding padding">
                        <div class="list-btn float-last btn-clasify">
                            <a class="waves-effect waves-light btn tooltipped" data-position="top" data-tooltip="Contact Supplier"><i class="far fa-envelope-open"></i> Contact Supplier</a>
                            <?php
                            if ($row['varBrochure'] != '') {
                                $download_product = $this->common_model->getUrl("pages", "2", "51", '') . "/download?file=" . $row['varBrochure'];
                                ?>
                                <a href="<?php echo $download_product; ?>" class="waves-effect waves-light btn tooltipped allnone" data-position="top" data-tooltip="Attachment"><i class="fas fa-paperclip"></i>Attachment</a>
                            <?php } ?>
                            <?php if ($row['chrSample'] == 'Y') { ?>
                                <a class="waves-effect waves-light btn tooltipped allnone  none-chatt" data-position="top" data-tooltip="Get Free Sample"><i class=" fas fa-balance-scale "></i>Get Free Sample</a>
                            <?php } ?>
                            <a class="waves-effect waves-light btn tooltipped chat-now none-chatt" data-position="top" data-tooltip="Chat Now"><i class="far fa-comments"></i>Chat Now</a>
                            <a href="javascript:;"  class="none-chatt waves-effect waves-light btn tooltipped chat-clear none-chatt on-chatt" data-position="top" data-tooltip="Chat Now" ><i class="far fa-comments"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>