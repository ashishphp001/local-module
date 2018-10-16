<script>

    var kk = 1;
    function isScrolledIntoView(elem)
    {
        var $elem = $(elem);
        var $window = $(window);

        var docViewTop = $window.scrollTop();
        var docViewBottom = docViewTop + $window.height();

        var elemTop = $elem.offset().top;
        var elemBottom = elemTop + $elem.height();

        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    }

//    $(window).scroll(function () {
//        if (isScrolledIntoView("#FrmPayment")) {
//            viewmore();
//        }
//        kk++

//    });
    var ii = 1;

    function viewmore() {

//slider__item
        $(".loadingmainoverlay1").show();
        var search_product = document.getElementById('search_product').value;
        if (search_product == '') {
            var newurl = window.location.href + '?keyword=' + search_product;
            window.history.pushState({path: newurl}, '', newurl);
        }
        ii++;
        var alteredURL = removeParam("page", window.location.href);
        var newurl = alteredURL + '&page=' + ii;
        window.history.pushState({path: newurl}, '', newurl);
        $.ajax({
            type: "POST",
            data: {"csrf_indibizz": csrfHash, "keyword": search_product, "page": ii, "ajax": "Y"},
            url: "<?php echo $this->common_model->getUrl("pages", "2", "51", ''); ?>" + "/index",
            async: false,
            success: function (Data)
            {
                $(".loadingmainoverlay1").hide();
                $(Data).insertBefore("#viewmore");
            }
        });

    }
    function updatefilter(type, value = '') {

//        $.ajax({
//            url: "<?php echo FRONT_MEDIA_URL; ?>js/product-slider.js",
//            dataType: 'script'
//        });

        var search_product = document.getElementById('search_product').value;
        if (search_product == '') {
            var newurl = window.location.href + '?keyword=' + search_product;
            window.history.pushState({path: newurl}, '', newurl);
        }
        if (history.pushState) {
//            City Filter...
            if (type == 'city') {
                var ChkBox = document.getElementById("varCity" + value);
                var t_business = document.getElementById('city').value;
                if (ChkBox.checked == 1) {
                    var text_business = value + "," + t_business;
                } else {
                    var text_business = removeValue(t_business, value, ",");
                }
                document.getElementById('city').value = text_business;
                var alteredURL = removeParam("city", window.location.href);
                var newurl = alteredURL + '&city=' + text_business;
            }
//            Business Type Filter...
            if (type == 'business') {
                var ChkBox = document.getElementById("intBusinessType" + value);
                var t_business = document.getElementById('business').value;
                if (ChkBox.checked == 1) {
                    var text_business = value + "," + t_business;
                } else {
                    var text_business = removeValue(t_business, value, ",");
                }
                document.getElementById('business').value = text_business;
                var alteredURL = removeParam("business", window.location.href);
                var newurl = alteredURL + '&business=' + text_business;
            }
//            Plan Filter...
            if (type == 'plans') {
                var ChkBox = document.getElementById("intPlans" + value);
                var t_plans = document.getElementById('plans').value;
                if (ChkBox.checked == 1) {
                    var text_plans = value + "," + t_plans;
                } else {
                    var text_plans = removeValue(t_plans, value, ",");
                }
                document.getElementById('plans').value = text_plans;
                var alteredURL = removeParam("plans", window.location.href);
                var newurl = alteredURL + '&plans=' + text_plans;
            }
            if (type == 'cat') {
                var alteredURL = removeParam("cat", window.location.href);
                var newurl = alteredURL + '&cat=' + value;
            }
            if (type == 'rating') {
                var alteredURL = removeParam("rating", window.location.href);
                var newurl = alteredURL + '&rating=' + value;
            }
            if (type == 'response') {
                var alteredURL = removeParam("response", window.location.href);
                var newurl = alteredURL + '&response=' + value;
            }
//            Trade Security Filter...
//            if (type == 'trade_security') {
//                var ChkBox = document.getElementById("chrSecurity");
//                if (ChkBox.checked == 1) {
//                    var alteredURL = removeParam("security", window.location.href);
//                    var newurl = alteredURL + '&security=1';
//                } else {
//                    var alteredURL = removeParam("security", window.location.href);
//                    var newurl = alteredURL;
//                }
//            }
            if (type == 'page') {
//                var body = $("html, body");
//                body.stop().animate({scrollTop: 0}, 800, 'swing', function () {
//                });
                $('html, body').animate({scrollTop: $('#gridbody_front').position().top}, 'slow');

                var alteredURL = removeParam("page", window.location.href);
                var newurl = alteredURL + '&page=' + value;

//                $(window).scrollTop(0);


            }
//            Free Sample Filter...
            if (type == 'free_sample') {
                var ChkBox = document.getElementById("chrSample");
                if (ChkBox.checked == 1) {
                    var alteredURL = removeParam("sample", window.location.href);
                    var newurl = alteredURL + '&sample=1';
                } else {
                    var alteredURL = removeParam("sample", window.location.href);
                    var newurl = alteredURL;
                }
            }
            window.history.pushState({path: newurl}, '', newurl);
        }

        $('#products').load(document.URL + ' #products');


    }
    function removeValue(list, value, separator) {
        separator = separator || ",";
        var values = list.split(separator);
        for (var i = 0; i < values.length; i++) {
            if (values[i] == value) {
                values.splice(i, 1);
                return values.join(separator);
            }
        }
        return list;
    }
    function removeParam(key, sourceURL) {
        var rtn = sourceURL.split("?")[0],
                param,
                params_arr = [],
                queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
        if (queryString !== "") {
            params_arr = queryString.split("&");
            for (var i = params_arr.length - 1; i >= 0; i -= 1) {
                param = params_arr[i].split("=")[0];
                if (param === key) {
                    params_arr.splice(i, 1);
                }
            }
            rtn = rtn + "?" + params_arr.join("&");
        }
        return rtn;
    }
</script>
<div id="gridbody_front">
    <!-- related search history -->

    <div class="all-search-list">
        <div class="container">
            <div class="row">
                <div class="related-search-header">
                    <?php
                    if (count($getProductSearch) > 0) {
                        $product_link = $this->common_model->getUrl("pages", "2", "51", "");
                        ?>
                        <span class="heade-related">
                            Related Search : 
                        </span>
                        <ul>
                            <?php foreach ($getProductSearch as $sproduct) { ?>
                                <li><a href="<?php echo $product_link . "?keyword=" . $sproduct['varName'] . "&type=1"; ?>"><?php echo $sproduct['varName']; ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- End related search history -->
    <div class="list-page-main" id="tab1product">
        <div class="row position-maintain">                
            <div class="product-info col m12 s12">
                <div class="product-multi change-color">
                    <div class="col s12 m2 l2 side menu cat-list-menu">
                        <div class="call-side card">
                            <div id="btn">
                                <span>filter</span>
                                <i class="fas fa-filter"></i>
                            </div>
                            <div class="related-pro card"  id="box">
                                <div class="all-option">
                                    <h6 class="sticky-onscroll"><a href="#one" class="all-up"> Category</h6>
                                    <div class="inner-menu">
                                        <div class="sub-menu-class" id="one">
                                            <?php
                                            echo $getCategoryNames['html'];
                                            if ($getCategoryNames['count'] >= 3) {
                                                ?>
                                                <a href="javascript:;" class="on-slide"><i class="fa fa-plus-circle"></i>See More</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <!--                                <div class="all-option">
                                                                    <h6 class="sticky-onscroll"><a href="#one2" class="all-up">Nearby<span style="text-transform: lowercase;"> (km) </a></span></h6>
                                                                    <div class="inner-menu nearby-me" id="one2">
                                                                        <div class="sub-menu-class none-slide">
                                                                            <div class="slider-container">
                                                                                <input type="text" id="slider3" class="slider" />
                                                                            </div>                               
                                                                        </div>
                                                                    </div>
                                                                </div>-->
                                <div class="all-option">
                                    <h6 class="sticky-onscroll"><a href="#one2" class="all-up">Location</a></h6>
                                    <div class="inner-menu">
                                        <div class="sub-menu-class" id="one2">
                                            <?php echo $getCityFilter; ?>
                                            <a href="javascript:;" class="on-slide1"><i class="fa fa-plus-circle"></i>See More</a>  
                                        </div>
                                    </div>
                                </div>
                                <div class="all-option">
                                    <h6 class="sticky-onscroll"><a href="#one3" class="all-up">Business Type</a></h6>
                                    <div class="inner-menu">
                                        <div class="sub-menu-class" id="one3">
                                            <?php echo $getBusinessType; ?>
                                            <a href="javascript:;" class="on-slide1"><i class="fa fa-plus-circle"></i>See More</a>  
                                        </div>
                                    </div>
                                </div>
                                <div class="all-option">
                                    <h6 class="free-fill">
                                        <div class="check-filter sample-free">
                                            <label>
                                                <?php
                                                if ($_GET['sample'] != '') {
                                                    $samplecheck = "checked";
                                                } else {
                                                    $samplecheck = "";
                                                }
                                                ?>
                                                <input type="checkbox" <?php echo $samplecheck; ?> id="chrSample" onclick="return updatefilter('free_sample', '')"  class="filled-in" />
                                                <span>Free Sample</span>
                                            </label>
                                        </div>
                                    </h6>                
                                </div>
                                <div class="all-option">
                                    <h6 class="sticky-onscroll"><a href="#one4" class="all-up">supplier type</a></h6>
                                    <div class="inner-menu">
                                        <div class="sub-menu-class" id="one4">
                                            <!--                                            <div class="check-filter trade-s">
                                                                                            <label>
                                            <?php
//                                                    if ($_GET['security'] != '') {
//                                                        $security_check = "checked";
//                                                    } else {
//                                                        $security_check = "";
//                                                    }
                                            ?>
                                                                                                <input id="chrSecurity" <?php echo $security_check; ?> onclick="return updatefilter('trade_security', '')" type="checkbox" class="filled-in" />
                                                                                                <span>Trade security</span>
                                                                                            </label>
                                                                                        </div>-->
                                            <?php
                                            $i = 0;
                                            foreach ($getPlanList as $row) {
                                                $i++;
                                                $plans = explode(",", $_GET['plans']);
                                                if (in_array($row['int_id'], $plans)) {
                                                    $plan_check = "checked";
                                                } else {
                                                    $plan_check = "";
                                                }
                                                if ($i == 5) {
                                                    ?> 
                                                    <div class="see-more-menu2">
                                                    <?php } ?>
                                                    <div class="check-filter">
                                                        <label>
                                                            <input <?php echo $plan_check; ?> type="checkbox" onclick="return updatefilter('plans', '<?php echo $row['int_id']; ?>')"  value="<?php echo $row['int_id']; ?>" type="checkbox" name="intPlans[]" id="intPlans<?php echo $row['int_id']; ?>" class="filled-in"  />
                                                            <span><?php echo $row['varName']; ?></span>
                                                        </label>
                                                    </div>
                                                    <?php
                                                }
                                                if ($i >= 5) {
                                                    ?> </div>
                                            <?php } if ($i >= 5) { ?>
                                                <a href="javascript:;" class="on-slide2"><i class="fa fa-plus-circle"></i>See More</a> 
                                            <?php } ?>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="all-option">
                                    <h6 class="sticky-onscroll"><a href="#one5" class="all-up">Search History</a></h6>
                                    <div class="inner-menu">
                                        <div class="sub-menu-class" id="one5">
                                            <?php
                                            $getCookiesProducts = $this->mylibrary->requestGetCookie('cookies_search_products');
                                            $explodeProduct = explode(",", $getCookiesProducts);
                                            $explodeProducts = array_reverse($explodeProduct);
                                            $a = 0;
                                            foreach ($explodeProducts as $pro_cookies) {
                                                if ($pro_cookies != '') {
                                                    $a++;
                                                    if ($a == 5) {
                                                        ?>
                                                        <div class="see-more-menu3">
                                                            <?php
                                                        }
                                                        $get_cookies_product_url = $this->common_model->getUrl("pages", "2", "51", '') . "?keyword=" . $pro_cookies;
                                                        ?>
                                                        <a target="_blank" href="<?php echo $get_cookies_product_url; ?>"><?php echo $pro_cookies; ?></a>
                                                        <?php
                                                    }
                                                }
                                                if ($a >= 5) {
                                                    ?> 
                                                </div>
                                            <?php } if ($a >= 5) { ?>
                                                <a href="javascript:;" class="on-slide3"><i class="fa fa-plus-circle"></i>See More</a> 
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-banner">
                                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                    <!-- Product Listing -->
                                    <ins class="adsbygoogle"
                                         style="display:block"
                                         data-ad-client="ca-pub-9007149304752455"
                                         data-ad-slot="5368372138"
                                         data-ad-format="auto"
                                         data-full-width-responsive="true"></ins>
                                    <script>
                                                                (adsbygoogle = window.adsbygoogle || []).push({});
                                    </script>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m9 l9 list-all padding middle-list">
                        <div class="change-view">
                            <!-- filter in mobile view -->
                            <div class="tab-change col s12 m12">
                                <ul class="pro-main">
                                    <?php
                                    if (count($_GET) > 0) {
                                        $get_url_par = "?";
                                        foreach ($_GET as $key => $par) {
                                            $get_url_par .= $key . "=" . $par . "&";
                                        }
                                        $getSupplierurl = rtrim($get_url_par, "&");
                                        $getSupplierurl = $this->common_model->getUrl("pages", "2", "99", '') . $getSupplierurl;
                                    } else {
                                        $getSupplierurl = $this->common_model->getUrl("pages", "2", "99", '');
                                    }
                                    ?>
                                    <li><a class="active" href="javascript:;">Products</a></li>
                                    <?php; ?>
                                    <li><a href="<?php echo $getSupplierurl; ?>">Suppliers</a></li>
                                </ul>
                                <div class="list-grid grid-way">
                                    <div class="well well-sm">
                                        <div class="btn-group">
                                            <a href="javascript:;" id="grid" class="btn btn-default btn-sm">
                                                <i class="material-icons">list</i>
                                            </a>
                                            <a href="javascript:;" id="list" class="btn btn-default btn-sm">
                                                <i class="material-icons">grid_on</i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-junk">                                 
                                <div class="product-detail-diff">
                                    <a href="javascript:;">View&nbsp;<strong><?php echo $getCountProductListing; ?></strong>&nbsp;Product(s)</a>
                                </div> 
                                <div class="product-detail-diff rating-user">
                                    <div class="rating-small">
                                        Rating: 
                                        <span class="starRating">
                                            <?php
                                            for ($j = 5; $j >= 1; $j--) {
                                                if ($j == $_GET['rating']) {
                                                    $rate_check = "checked";
                                                } else {
                                                    $rate_check = "";
                                                }
                                                ?>
                                                <input id="rating<?php echo $j; ?>" <?php echo $rate_check; ?> onclick='return updatefilter("rating",<?php echo $j; ?>)' type="radio" name="rating" value="<?php echo $j; ?>">
                                                <label for="rating<?php echo $j; ?>"><?php echo $j; ?></label>
                                            <?php } ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="product-detail-diff response-user">
                                    <div class="diff-stop"><b><i class="fas fa-edit"></i></b>
                                        <strong>Response Rate</strong>&nbsp;&nbsp;
                                        <span class="diff-drop">
                                            <div class="more-info">
                                                <div class="form-part">
                                                    <div class="input-field field-custom">
                                                        <select onchange='return updatefilter("response", this.value)'>
                                                            <!--<option value="" disabled="" selected="selected">Select</option>-->
                                                            <option value="4">76% - 100%</option>
                                                            <option value="3">51% - 75%</option>
                                                            <option value="2">26% - 50%</option>
                                                            <option value="1">0% - 25%</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>   
                                        </span> 
                                    </div>
                                </div>                                  
                                <div class="product-detail-diff short-userlist">
                                    <div class="check-online">
                                        <label>
                                            <input type="checkbox" class="filled-in" />
                                            <span>Online</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="list-provider gride-provider"  id="products">
                                <div class="row list-group">
                                    <input type="hidden" id="city" value="<?php echo $_GET['city']; ?>">
                                    <input type="hidden" id="business" value="<?php echo $_GET['business']; ?>">
                                    <input type="hidden" id="plans" value="<?php echo $_GET['plans']; ?>">
                                    <div class="item grid-group-item scroll-product" id="product_pagedata">
                                        <!--<div class="item list-group-item " >-->
                                        <?php
                                        $k = 1;
                                        foreach ($getProductListing as $row) {
                                            ?>
                                            <div id="pageval<?php echo $k; ?>"></div>
                                            <div class="col s12 m12 l12 gride-show">
                                                <div class="list-row">
                                                    <div class="col fixed-width padding-right card">
                                                        <?php $getProductImages = $this->Module_Model->getProductListingImageData($row['int_id']); ?>
                                                        <div class=" iamge-call">
                                                            <div class="slide1">
                                                                <?php
                                                                $img = 0;
                                                                foreach ($getProductImages as $pro_img) {
                                                                    $photo_thumb = $pro_img['varImage'];
                                                                    $thumb = 'upimages/productgallery/images/' . $photo_thumb;
                                                                    if (file_exists($thumb) && $photo_thumb != '') {
                                                                        $img++;
                                                                    }
                                                                }
                                                                if ($img > 0) {
                                                                    ?>
                                                                    <div class="col-image-number">
                                                                        <?php echo $img; ?> Photo
                                                                    </div>
                                                                <?php } ?>
                                                                <div class="slider-container">
                                                                    <div class="slider">
                                                                        <!-- Item -->
                                                                        <?php
                                                                        foreach ($getProductImages as $pro_img) {
                                                                            $photo_thumb = $pro_img['varImage'];
                                                                            $thumb = 'upimages/productgallery/images/' . $photo_thumb;
                                                                            if (file_exists($thumb) && $photo_thumb != '') {
                                                                                $thumbphoto1 = image_thumb($thumb, PHOTOGALLERY_WIDTH, PHOTOGALLERY_HEIGHT);
                                                                                ?>
                                                                                <div class="slider__item" style="width:195px;">
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

                                                                        if ($img == 0) {
                                                                            ?>
                                                                            <div class="slider__item">
                                                                                <div class="in-callimg">
                                                                                    <div class="place-img"></div>
                                                                                    <div class="cate-img1">

                                                                                        <div class="in-changeimg">
                                                                                            <img src="<?php echo FRONT_MEDIA_URL . "images/no_img/ib_no_image.jpg"; ?>" title="<?php echo $row['varName']; ?>" alt="<?php echo $row['varName']; ?>">
                                                                                        </div>

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
                                                                    <a href="javascript:;"  onclick="return addtofav(<?php echo $row['int_id']; ?>);" class="list-heart">
                                                                        <?php if (USER_ID == '') { ?>
                                                                            <i class="far fa-heart" id="<?php echo "fav_class_" . $row['int_id']; ?>"></i>
                                                                            <?php
                                                                        } else {
                                                                            $checkfav = $this->common_model->checkProductFav($row['int_id'], USER_ID);
                                                                            if ($checkfav == '0') {
                                                                                ?>
                                                                                <i class="far fa-heart" id="<?php echo "fav_class_" . $row['int_id']; ?>"></i>
                                                                            <?php } else { ?>
                                                                                <i class="fas fa-heart" id="<?php echo "fav_class_" . $row['int_id']; ?>"></i>
                                                                            <?php }
                                                                        }
                                                                        ?>
                                                                    </a>
                                                                    <?php
                                                                    $keyword = $_GET['keyword'];
                                                                    $name = $row['varName'];
                                                                    $product_name = str_ireplace($keyword, '<strong class="diff-color">' . $keyword . "</strong>", $name);
                                                                    ?>
                                                                    <div class="list-pro-name">
                                                                        <a href="<?php echo SITE_PATH . $row['varAlias']; ?>" class="list-head-most"><?php echo $product_name; ?></a>
                                                                        <!--<a href="" class="list-head-most">Product011 <strong class="diff-color">supplier</strong> Name of The person supplier The person supplier</a>-->
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                if ($row['chrPayment'] == 'Y') {
                                                                    $payment = 100;
                                                                } else {
                                                                    $payment = 60;
                                                                }
                                                                ?>
                                                                <div class="col s12 m2 rating-info">
                                                                    <div class="user-rating-all">
                                                                        <div class="star-ratings-sprite"><span style="width:<?php echo $payment; ?>%" class="star-ratings-sprite-rating"></span></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col m7 s12 l8 padding-right gride-info-full smess-all">
                                                                <div class="listview">
                                                                    <div class="product-list">
                                                                        <div class="col s12 m5 l4 padding-left most-left gride-info-full">
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

                                                                                        <nobr><h6>Price:&nbsp;</h6><span><?php echo $currency . $row['varPrice']; ?>&nbsp;/&nbsp;<?php echo $row['PriceUnit']; ?></span></nobr>
                                                                                    </div>
                                                                                </div>
    <?php } if ($row['varMOQ'] != '0') { ?>
                                                                                <div class="list-detail price">
                                                                                    <div class="price-special">
                                                                                        <h6>MOQ: </h6>
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
                                                                        $data = strip_tags($row['txtDescription']);
                                                                        $desc = substr($data, 0, 120);
                                                                        if (strlen($data) > 120) {
                                                                            $pro_desc = $desc . "...";
                                                                        } else {
                                                                            $pro_desc = $desc;
                                                                        }
                                                                        echo $pro_desc;
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col s12 m5 l4 supplier-width padding same-left gride-responce">
                                                                <div class="right-list">
                                                                    <?php if ($row['chrTradeSecurity'] == 'Y') { ?>
                                                                        <div class="shield-source" style="background: url(<?php echo FRONT_MEDIA_URL; ?>images/shild.png) no-repeat;"></div>
                                                                        <?php } ?>
                                                                    <div class="companyname enlarge">
                                                                        <?php
                                                                        if ($row['varSubdomain'] != '') {
                                                                            $subdomain = str_replace("___", $row['varSubdomain'], SUB_DOMAIN);
                                                                        } else {
                                                                            $subdomain = $this->common_model->getUrl("users", "136", $row['intSupplier'], '');
                                                                        }
                                                                        if ($row['intPlan'] == '1') {
                                                                            $plan_img = "ibase.png";
                                                                        } else if ($row['intPlan'] == '2') {
                                                                            $plan_img = "istanderd.png";
                                                                        } else {
                                                                            $plan_img = "freee.png";
                                                                        }
                                                                        ?>

                                                                        <a target="_blank" href="<?php echo $subdomain; ?>" class="comp-name company-name-list"><img src="<?php echo FRONT_MEDIA_URL; ?>images/<?php echo $plan_img; ?>" alt="<?php echo $row['CompanyName']; ?>"><?php echo $row['CompanyName']; ?>
                                                                            <span>
                                                                                <div class="call-image">
                                                                                    <img src="<?php echo FRONT_MEDIA_URL; ?>images/<?php echo $plan_img; ?>" alt="<?php echo $row['CompanyName']; ?>" title="<?php echo $row['CompanyName']; ?>">
                                                                                </div>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                    <!--                                                                    <div class="companyname">
                                                                                                                                            <a target="_blank" href="<?php echo $subdomain; ?>" class="comp-name company-name-list"><img src="<?php echo FRONT_MEDIA_URL; ?>images/scurity.png" alt="<?php echo $row['CompanyName']; ?>" title="<?php echo $row['CompanyName']; ?>"><?php echo $row['CompanyName']; ?></a>
                                                                                                                                        </div>-->
    <?php if ($row['varCity'] != '') { ?>
                                                                        <div class="companyname trade-asurence special-none">
                                                                            <a href="javascript:;"><i class="fas fa-map-marker-alt"></i>&nbsp;<?php echo $row['varCity']; ?> (<?php echo $row['varCountry']; ?>)</a>
                                                                        </div>
    <?php } if ($row['varBusinessType'] != '') { ?>
                                                                        <div class="companyname business-rate special-none">                                                
                                                                            <span><?php
                                                                                $getBusinessType = $this->Module_Model->getBusinessType($row['varBusinessType']);
//                                                                                echo $row['varBusinessType'];
                                                                                echo rtrim($getBusinessType, ", ");
                                                                                ?></span>
                                                                        </div>
    <?php } if ($row['varRegistration'] != '') { ?> 
                                                                        <div class="companyname near-to">
                                                                            <div class="response-rate">
                                                                                <p>Year of registration : &nbsp;</p>
                                                                                <span><?php echo $row['varRegistration'] ?></span>
                                                                            </div>
                                                                        </div>
    <?php } if ($row['ftResponseRate'] != '0' && $row['ftResponseRate'] != '') { ?>
                                                                        <div class="companyname near-to">
                                                                            <div class="response-rate">
                                                                                <p>Response Rate : &nbsp;</p>
                                                                                <span><?php echo $row['ftResponseRate'] . "%"; ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <?php } ?>
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
                                                                    <a target="_blank" href="<?php echo SITE_PATH . $row['varAlias'] . "?contact=1"; ?>" class="waves-effect waves-light btn tooltipped" data-position="top" data-tooltip="Contact Supplier"><i class="far fa-envelope-open"></i> Contact Supplier</a>
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
                                            <?php
                                            $k++;
                                        }
                                        ?>

                                        <div id="viewmore"></div>

                                    </div>
                                </div>

                                <input type="hidden" id="pagename" >

                                <!-- end -->
                                <!-- end*********************************************** -->     
<?php if ($getCountProductListing / DEFAULT_PAGESIZE >= 1) { ?>
                                    <div class="animation-short">
                                        <div class="arrow bounce">
                                            <a class="design-button card" href="javascript:;"  onclick="viewmore();">
                                                <div class="double">
                                                    <span class="ouro ouro3">
                                                        <span class="left"><span class="anim"></span></span>
                                                        <span class="right"><span class="anim"></span></span>
                                                    </span>
                                                </div>
                                                Click here to load more</a>
                                        </div>
                                    </div>
<?php } ?>

                            </div>
                        </div>
                        <!-- rfq form  -->
                        <div class="col m12 s12 padding">
                            <div class="gride-rfq-form">
                                <div class="quots-main col m12 s12 l12">
                                    <div class="input-boxes card inline">
                                        <div class="col s12 m6 rfq-all">
                                            <div class="rfq-headleft">
                                                <h6>REQUEST FOR QUOTATION</h6>
                                                <p>dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown</p>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            $(document).ready(function () {
                                                $("#FrmPayment").validate({
                                                    ignore: [],
                                                    rules: {
                                                        varProduct: {
                                                            required: true
                                                        },
                                                        txtDescription: {
                                                            required: true
                                                        },
                                                        varQuantity: {
                                                            required: true
                                                        },
                                                        intUnit: {
                                                            required: true
                                                        }
                                                    },
                                                    errorPlacement: function (error, element) {

                                                    },
                                                    submitHandler: function (form) {
                                                        form.submit();
                                                    }
                                                });
                                            });
                                        </script>
                                        <div class="rfq-detail col s12 m6 padding">
                                            <div class="rfq-fomr-fill card">
                                                <?php
                                                $action = $this->common_model->getUrl("pages", "2", "52", '');
                                                $attributes = array('name' => 'FrmPayment', 'id' => 'FrmPayment', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form', 'method' => 'post');
                                                echo form_open($action, $attributes);
                                                ?>
                                                <div class="col m12 s12 padding">
                                                    <div class="input-field field-custom">
                                                        <input type="text" value="<?php echo $this->input->get_post('keyword'); ?>" id="varProduct" name="varProduct" autocomplete="off" class="autocomplete">
                                                        <label for="request-product-input">Product Name<sup>*</sup></label>
                                                    </div>
                                                </div>
                                                <div class="col m12 s12 padding">
                                                    <div class="input-field field-custom">
                                                        <textarea id="txtDescription" name="txtDescription" class="materialize-textarea" required=""></textarea>
                                                        <label for="txtDescription">Description<sup>*</sup></label>
                                                    </div>
                                                </div>
                                                <div class="col m12 s12 padding border-radius">
                                                    <div class="col m6 s6 padding">        
                                                        <div class="input-field field-custom qtity-work">
                                                            <input id="varQuantity" name="varQuantity"  onkeypress="return KeycheckOnlyNumeric(event);" type="text">
                                                            <label for="varQuantity">Qty<sup>*</sup></label>
                                                        </div>
                                                    </div>
                                                    <div class="col m6 s6 padding-right padding-left">
                                                        <div class="input-field field-custom">
                                                            <div class="input-field">
<?php echo $getQtyData; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="quots">
                                                        <button class="waves-effect waves-light btn modal-trigger button-design" href="#home-get-quot">Get a Quote</button>
                                                    </div>
                                                </div>
                                                <?php
                                                echo form_close();
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="quots-images col m6 s12 l6">
                                  <div class="rfq-imageone">
                                     <img src="<?php echo FRONT_MEDIA_URL; ?>images/rfq-list.jpg">
                                  </div>
                                </div> -->
                            </div>
                        </div>
                        <!-- end  -->
                    </div>
                    <div class="col s12 m2 l1 related-content advance-search">
                        <div class="product-searchc">
                            <h1>Premium Related Supplier</h1>
<?php foreach ($getSupplierData as $supplier_type) { ?>
                                <li>
                                    <div class="porduct-recent">
                                        <?php
                                        $getUserProductLink = $this->common_model->getUserData($supplier_type['int_id']);
                                        if ($getUserProductLink['varSubdomain'] != '') {
                                            $subdomain = str_replace("___", $getUserProductLink['varSubdomain'], SUB_DOMAIN);
                                        } else {
                                            $subdomain = $this->common_model->getUrl("buyer_seller", "136", $supplier_type['int_id'], '');
                                        }
                                        ?>
                                        <a href="<?php echo $subdomain; ?>" target="_blank" class="card"> 
                                            <ul class="enlarge">
                                                <li class="immg-short">
                                                    <?php
                                                    $imagename = $supplier_type['varImage'];
                                                    $imagepath = 'upimages/users/images/' . $imagename;
                                                    if (file_exists($imagepath) && $supplier_type['varImage'] != '') {
                                                        $image_thumb = image_thumb($imagepath, USERS_WIDTH, USERS_HEIGHT);
                                                    } else {
                                                        $image_thumb = FRONT_MEDIA_URL . "images/no_img/ib_no_image.jpg";
                                                    }
                                                    ?>
                                                    <img src="<?php echo $image_thumb; ?>" alt="<?php echo $supplier_type['varCompany']; ?>" title="<?php echo $supplier_type['varCompany']; ?>" />
    <!--                                                    <p><?php // echo $supplier_type['varCompany'];                                    ?></p>-->
                                                    <span>
                                                        <div class="call-image">
                                                            <img src="<?php echo $image_thumb; ?>" alt="<?php echo $supplier_type['varCompany']; ?>" title="<?php echo $supplier_type['varCompany']; ?>" />
                                                        </div>
                                                        <p><?php echo $supplier_type['varCompany']; ?></p>
                                                    </span>
                                                </li>                                        
                                            </ul>
                                        </a>
                                    </div>
                                </li>
<?php } ?>
                            <div class="add-banner">
                                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                <!-- Product Listing -->
                                <ins class="adsbygoogle"
                                     style="display:block"
                                     data-ad-client="ca-pub-9007149304752455"
                                     data-ad-slot="5368372138"
                                     data-ad-format="auto"
                                     data-full-width-responsive="true"></ins>
                                <script>
                                                                (adsbygoogle = window.adsbygoogle || []).push({});
                                </script>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>


<script type="text/javascript" src="<?php echo FRONT_MEDIA_URL; ?>js/product-slider.js"></script>