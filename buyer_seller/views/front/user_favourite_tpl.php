<link rel="stylesheet" href="<?php echo FRONT_MEDIA_URL; ?>css/das/uikit.almost-flat.min.css" media="all">
<link rel="stylesheet" href="<?php echo FRONT_MEDIA_URL; ?>css/das/main.min.css" media="all">
<?php
echo $this->load->view($UserSideBar);
?>
<div class="row">
    <div id="page_content">
        <div id="page_content_inner">
            <div class="col s12 m12">
                <div class="col s12 m12 padding dashbord-design-motive">
                    <div class="dashbord-tab card favourti-smart">
                        <div class="col s12 m12 l12">
                            <div class="detail-tabs">
                                <div class="row">
                                    <div class="col s12 padding">
                                        <ul class="tabs">
                                            <li class="tab"><a class="active" href="#basic-detail">Products</a></li>
                                            <li class="tab"><a href="#packing">Buylead</a></li>
                                        </ul>
                                    </div>
                                    <div class="card tab-withdetail">


                                        <div id="basic-detail" class="col s12">
                                            <?php $getUserFavoriteList = $this->Module_Model->getProductFavList(USER_ID, "all"); ?>
                                            <?php foreach ($getUserFavoriteList as $row) { ?>
                                                <div class="basic-detail-info">
                                                    <div class="display-bl">
                                                        <div class="card-smell">
                                                            <div class="box-image-s">
                                                                <div class="slider-effect">
                                                                    <section class="slide-prod slider1">
                                                                        <?php
                                                                        foreach ($getProductImages as $pro_img) {
                                                                            $photo_thumb = $pro_img['varImage'];
                                                                            $thumb = 'upimages/productgallery/images/' . $photo_thumb;
                                                                            if (file_exists($thumb) && $photo_thumb != '') {
                                                                                $thumbphoto1 = image_thumb($thumb, PHOTOGALLERY_WIDTH, PHOTOGALLERY_HEIGHT);
                                                                                ?>
                                                                                <div class="slide">
                                                                                    <div class="in-callimg">
                                                                                        <div class="place-img"></div>
                                                                                        <div class="cate-img1">
                                                                                            <div class="in-changeimg">
                                                                                                <img src="<?php echo $thumbphoto1; ?>" alt="<?php echo $row['varName']; ?>" title="<?php echo $row['varName']; ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </section>
                                                                </div>
                                                            </div>
                                                            <div class="id-boxes-detail">
                                                                <div class="date-rfq card">
                                                                    <div class="full-date "><?php echo date('d', strtotime($row['dtCreateDate'])); ?><span class="month"><?php echo date('M Y', strtotime($row['dtCreateDate'])); ?></span></div>
                                                                </div>
                                                                <div class="name-define">
                                                                    <div class="product-user-dass">
                                                                        <a href="<?php echo SITE_PATH . $row['varAlias']; ?>"><?php echo $row['varName']; ?></a>
                                                                        <div class="col s12 m2 rating-info">
                                                                            <div class="user-rating-all">
                                                                                <div class="star-ratings-sprite"><span style="width:52%" class="star-ratings-sprite-rating"></span></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="all-set-cource">
                                                                        <div class="col s12 m3 moz-list-pricemop">
                                                                            <?php if ($row['varPrice'] != '0') { ?>
                                                                                <?php
                                                                                if ($row['varCurrency'] == '1') {
                                                                                    $currency = "&#8377;";
                                                                                } else {
                                                                                    $currency = "$";
                                                                                }
                                                                                ?>
                                                                                <div class="list-detail price">
                                                                                    <div class="price-special">
                                                                                        <h6>Price</h6>
                                                                                        <span><?php echo $currency . $row['varPrice']; ?>&nbsp;/&nbsp;<?php echo $row['PriceUnit']; ?></span>
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
                                                                        <div class="col s12 m4 list-source gride-info-full list-info-mid special-none">
                                                                            <?php if ($row['varBrand'] != '') { ?>
                                                                                <div class="info-list">
                                                                                    <span class="name-list"> Brand name:</span>
                                                                                    <span>
                                                                                        <?php
                                                                                        $bdata = $row['varBrand'];
                                                                                        $bd = substr($bdata, 0, 45);
                                                                                        if (strlen($bdata) > 45) {
                                                                                            $brand = $bd . "...";
                                                                                        } else {
                                                                                            $brand = $bd;
                                                                                        }
                                                                                        echo $brand;
                                                                                        ?>
                                                                                    </span>
                                                                                </div>
                                                                            <?php } ?>
                                                                            <?php if ($row['varMaterial'] != '') { ?>
                                                                                <div class="info-list">
                                                                                    <span class="name-list">Material Type: </span>
                                                                                    <span><?php
                                                                                        $mdata = $row['varMaterial'];
                                                                                        $mat = substr($mdata, 0, 40);
                                                                                        if (strlen($mdata) > 40) {
                                                                                            $material = $mat . "...";
                                                                                        } else {
                                                                                            $material = $mat;
                                                                                        }
                                                                                        echo str_replace(",", ", ", $material);
                                                                                        ?></span>
                                                                                </div>
                                                                            <?php } ?>
                                                                            <?php if ($row['varModelNo'] != '') { ?>
                                                                                <div class="info-list">
                                                                                    <span class="name-list">Model Number: </span>
                                                                                    <span> <?php
                                                                                        $modata = $row['varModelNo'];
                                                                                        $mod = substr($modata, 0, 45);
                                                                                        if (strlen($modata) > 45) {
                                                                                            $model = $mod . "...";
                                                                                        } else {
                                                                                            $model = $mod;
                                                                                        }
                                                                                        echo $model;
                                                                                        ?></span>
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                        <div class="col s12 m5">
                                                                            <div class="security-purpose change-facourit">
                                                                                <div class="fav-change">
                                                                                    <a href="" class="comp-name company-name-list"><img src="https://www.indibizz.com/front-media/images/ibase.png" alt="Divya Enterprise" title="Divya Enterprise">Divya Enterprise</a>
                                                                                </div>
                                                                                <a href="javascript:;"><i class="fas fa-map-marker-alt"></i>&nbsp;Rajkot (India)</a>
                                                                            </div>
                                                                            <div class="response-rate">
                                                                                <p>Response Rate : &nbsp;</p>
                                                                                <span>N/A</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="companyname mode-define special-none">
                                                                            <!-- <span><i class="far fa-dot-circle color-off"></i>2 hour(ago)</span> -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <span class="all-btn remove-fav">
                                                    <a href="#" class="card"><i class="fas fa-minus-circle"></i>Remove From Favourite</a>
                                                </span>  
                                            <?php } ?>
                                        </div>
                                        <!-- sss -->
                                        <div id="packing" class="col s12">
                                            <div class="basic-detail-info">
                                                <div class="display-bl">
                                                    <div class="card-smell">
                                                        <div class="box-image-s">
                                                            <div class="slider-effect">
                                                                <section class="slide-prod slider1">
                                                                    <div class="slide wow fadeIn animated animated inline" data-wow-duration="2s" data-wow-delay="500ms">
                                                                        <div class="in-callimg">
                                                                            <div class="place-img"></div>
                                                                            <div class="cate-img1">
                                                                                <div class="in-changeimg">
                                                                                    <img src="https://www.indibizz.com/upload/product/0_42782500_1487856048_IMG-20170223-WA0009.jpg" alt="" title="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="slide wow fadeIn animated animated inline" data-wow-duration="2s" data-wow-delay="500ms">
                                                                        <div class="in-callimg">
                                                                            <div class="place-img"></div>
                                                                            <div class="cate-img1">
                                                                                <div class="in-changeimg">
                                                                                    <img src="https://www.indibizz.com/upload/product/0_42782500_1487856048_IMG-20170223-WA0009.jpg" alt="" title="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                        </div>
                                                        <div class="id-boxes-detail ">
                                                            <div class="date-rfq card">
                                                                <div class="full-date ">05<span class="month">Nov 2018</span></div>
                                                            </div>
                                                            <div class="name-define">
                                                                <div class="product-user-dass">
                                                                    <a href="#">PP Virgin Granules</a>
                                                                    <div class="col s12 m2 rating-info">
                                                                        <div class="user-rating-all">
                                                                            <div class="star-ratings-sprite"><span style="width:52%" class="star-ratings-sprite-rating"></span></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="all-set-cource ">
                                                                    <div class="col s12 m3 moz-list-pricemop">
                                                                        <div class="list-detail price">
                                                                            <div class="price-special">
                                                                                <h6>Expected Price</h6>
                                                                                <span>?112 / Kilogram</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="list-detail price">
                                                                            <div class="price-special">
                                                                                <h6>MOQ</h6>
                                                                                <span>10 Metric Ton</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col s12 m4 list-source gride-info-full list-info-mid special-none">
                                                                        <div class="info-list">
                                                                            <span class="name-list"> Approx Order:</span>
                                                                            <span>?1000000 - ?1500000</span>
                                                                        </div>
                                                                        <div class="info-list">
                                                                            <div class="short-desc-rfq">
                                                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                                                                                    <span>
                                                                                        <b>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the</b>
                                                                                    </span>
                                                                                </p>                           
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col s12 m5">
                                                                        <div class="security-purpose change-facourit">
                                                                            <div class="fav-change">
                                                                                <a href="" class="comp-name company-name-list"><img src="https://www.indibizz.com/front-media/images/ibase.png" alt="Divya Enterprise" title="Divya Enterprise">Brijesh Gadhiya</a>
                                                                            </div>
                                                                            <a href="javascript:;"><i class="fas fa-map-marker-alt"></i>&nbsp;Rajkot (India)</a>
                                                                            <div class="companyname intro-rfq">
                                                                                <div class="response-rate">
                                                                                    <i class="far fa-clock"></i>Requirement Time:  <span>Urgent</span>
                                                                                </div>
                                                                                <div class="companyname intro-rfq">
                                                                                    <div class="response-rate">
                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Requirement Type:  <span>Regular</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!--  <div class="response-rate">
                                                                            <p>Response Rate : &nbsp;</p>
                                                                            <span>N/A</span>
                                                                        </div> -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="button-soan">
                                                                <a class="waves-effect waves-light btn tooltipped" data-position="top" data-tooltip="Set Reminder"><i class="fas fa-bell"></i>Set Reminder</a>
                                                                <a class="waves-effect waves-light btn tooltipped" data-position="top" data-tooltip="Attachment"><i class="fas fa-paperclip"></i>Attachment</a>
                                                                <a class="waves-effect waves-light btn tooltipped" data-position="top" data-tooltip="Access Buy Lead"><i class="far fa-comments"></i>Access Buy Lead</a>
                                                                <span class="all-btn remove-fav change-ss">
                                                                    <a href="#" class="card"><i class="fas fa-minus-circle"></i>Remove From Favourite</a>
                                                                </span>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>