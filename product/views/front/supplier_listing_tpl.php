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

    $(window).scroll(function () {
//        if (isScrolledIntoView("#FrmPayment")) {
//            viewmore();
//        }
//        kk++

    });
    var ii = 1;

    function viewmore() {

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
            url: "<?php echo $this->common_model->getUrl("pages", "2", "99", ''); ?>" + "/index",
            async: false,
            success: function (Data)
            {
                $(".loadingmainoverlay1").hide();
                $(Data).insertBefore("#viewmore");
            }
        });

    }


    function updatefilter(type, value = '') {
        var search_product = document.getElementById('search_product').value;
        if (search_product == '') {

            var newurl = window.location.href + '?keyword=' + search_product;
            window.history.pushState({path: newurl}, '', newurl);
        }
        if (history.pushState) {

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
//            Business Type Filter...
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
//            Trade Security Filter...
            if (type == 'trade_security') {
                var ChkBox = document.getElementById("chrSecurity");
                if (ChkBox.checked == 1) {
                    var alteredURL = removeParam("security", window.location.href);
                    var newurl = alteredURL + '&security=1';
                } else {
                    var alteredURL = removeParam("security", window.location.href);
                    var newurl = alteredURL;
                }
            }
            if (type == 'page') {
                var alteredURL = removeParam("page", window.location.href);
                var newurl = alteredURL + '&page=' + value;
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
                                    <h6 class="sticky-onscroll"><a href="#one" class="all-up"> Category</a></h6>
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
                                            <div class="check-filter trade-s">
                                                <label>
                                                    <?php
                                                    if ($_GET['security'] != '') {
                                                        $security_check = "checked";
                                                    } else {
                                                        $security_check = "";
                                                    }
                                                    ?>
                                                    <input id="chrSecurity" <?php echo $security_check; ?> onclick="return updatefilter('trade_security', '')" type="checkbox" class="filled-in" />
                                                    <span>Trade security</span>
                                                </label>
                                            </div>
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
                                        $getProducturl = rtrim($get_url_par, "&");
                                        $getProducturl = $this->common_model->getUrl("pages", "2", "51", '') . $getProducturl;
                                    } else {
                                        $getProducturl = $this->common_model->getUrl("pages", "2", "51", '');
                                    }
                                    ?>
                                    <li><a href="<?php echo $getProducturl; ?>">Products</a></li>
                                    <li><a class="active" href="javascript:;">Suppliers</a></li>
                                </ul>
                            </div>
                            <div class="product-junk">                                 
                                <div class="product-detail-diff">
                                    <a href="javascript:;">View&nbsp;<strong><?php echo $getCountProductListing; ?></strong>&nbsp;Supplier(s)</a>
                                </div> 
                                <div class="product-detail-diff rating-user">
                                    <div class="rating-small">
                                        Rating: 
                                        <span class="starRating">
                                            <input id="rating5" type="radio" name="rating" value="5">
                                            <label for="rating5">5</label>
                                            <input id="rating4" type="radio" name="rating" value="4">
                                            <label for="rating4">4</label>
                                            <input id="rating3" type="radio" name="rating" value="3">
                                            <label for="rating3">3</label>
                                            <input id="rating2" type="radio" name="rating" value="2">
                                            <label for="rating2">2</label>
                                            <input id="rating1" type="radio" name="rating" value="1">
                                            <label for="rating1">1</label>
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
                                                        <select>
                                                            <option value="" disabled selected>70.00% Up</option>
                                                            <option value="1">20.00% Up</option>
                                                            <option value="2">100.00% Up</option>
                                                            <option value="3">50.00% Up</option>
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
                                <!--                                <div class="product-detail-diff sort-pro response-user">
                                                                    <strong>Sort</strong>&nbsp;&nbsp;
                                                                    <span class="diff-drop">
                                                                        <div class="more-info">
                                                                            <div class="form-part">
                                                                                <div class="input-field field-custom">
                                                                                    <select>
                                                                                        <option value="" disabled selected>Date</option>
                                                                                        <option value="1">Paid</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>   
                                                                    </span>
                                                                </div>  -->
                            </div>
                            <div class="suppier-list-user" id="products">
                                 <input type="hidden" id="city" value="<?php echo $_GET['city']; ?>">
                                <input type="hidden" id="business" value="<?php echo $_GET['business']; ?>">
                                <input type="hidden" id="plans" value="<?php echo $_GET['plans']; ?>">
                                <!--<div class="item list-group-item " >-->
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
                                                                        <div class="supplier-fav">
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
                                                                        </div>
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
                                                                <span>
                                                                    <?php
                                                                    $getBusinessType = $this->Module_Model->getBusinessType($row['varBusinessType']);
                                                                    echo rtrim($getBusinessType, ", ");
                                                                    ?>
                                                                </span>
                                                            </div>
                                                        <?php } ?>
                                                        <!--                                                        <div class="companyname near-to">
                                                                                                                    <div class="response-rate">
                                                                                                                        <p>Response Rate : &nbsp;</p>
                                                                                                                        <span>68.8%</span>
                                                                                                                    </div>
                                                                                                                </div>-->
                                                        <?php // if ($row['chrTradeSecurity'] == 'Y') {  ?>
                                                        <!--                                                            <div class="companyname mode-define special-none">
                                                                                                                        <a href=""><img src="<?php echo FRONT_MEDIA_URL; ?>images/trade-security.png" alt=""> Trade Security</a>
                                                                                                                        <span><i class="fas fa-circle"></i>Online</span>
                                                                                                                    </div>-->
                                                        <?php // }  ?>
                                                    </div>
                                                    <div class="list-btn float-last btn-clasify">
                                                        <?php
                                                        if ($row['varSubdomain'] != '') {
                                                            $getSupplierLink = str_replace("___", $row['varSubdomain'], SUB_DOMAIN) . "/contact";
                                                        } else {
                                                            $getSupplierLink = $this->common_model->getUrl("buyer_seller", "136", $row['intSupplier'], '') . "/contact";
                                                        }
                                                        ?>

                                                        <a target="_blank" href="<?php echo $getSupplierLink; ?>"  class="waves-effect waves-light btn tooltipped" data-position="top" data-tooltip="Contact"><i class="far fa-envelope-open"></i> Contact</a>
                                                        <a class="waves-effect waves-light btn tooltipped chat-now  none-chatt" data-position="top" data-tooltip="Chat Now"><i class="far fa-comments"></i>Chat Now</a>
                                                        <a href="#" class="waves-effect waves-light btn tooltipped chat-clear none-chatt on-chatt" data-position="top" data-tooltip="Chat Now"><i class="far fa-comments"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- end -->
                                <div id="viewmore"></div>

                            </div>
                        </div>

                        <input type="hidden" id="pagename" >
                        <?php if ($getCountProductListing / DEFAULT_PAGESIZE >= 1) { ?>
                            <div class="animation-short">
                                <div class="arrow bounce">
                                    <a class="design-button card" href="javascript:;"  onclick="viewmore();">
                                        <div class="double">
                                            <span class="ouro ouro3">
                                                <span class="left"><span class="anim"></span></span>
                                                <span class="right"><span class="anim"></span></span>
                                            </span>
                                        </div>View More</a>
                                </div>
                            </div>
                        <?php } ?>

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
                                        <div class="rfq-detail col s12 m6 padding">
                                            <div class="rfq-fomr-fill card">
                                                <?php
                                                $action = $this->common_model->getUrl("pages", "2", "52", '');
                                                $attributes = array('name' => 'FrmPayment', 'id' => 'FrmPayment', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form', 'method' => 'post');
                                                echo form_open($action, $attributes);
                                                ?>
                                                <div class="col m12 s12 padding">
                                                    <div class="input-field field-custom">
                                                        <input type="text" id="varProduct" name="varProduct" autocomplete="off" class="autocomplete">
                                                        <label for="request-product-input">Product Name<sup>*</sup></label>
                                                    </div>
                                                </div>
                                                <div class="col m12 s12 padding">
                                                    <div class="input-field field-custom">
                                                        <textarea id="txtDescription" name="txtDescription" class="materialize-textarea"></textarea>
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
                                        <a href="" class="card"> 
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
                                <a href=""><img src="<?php echo FRONT_MEDIA_URL; ?>images/add.jpg"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
