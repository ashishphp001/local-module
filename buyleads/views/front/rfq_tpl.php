<script type="text/javascript">
    var kk = 1;
//    var ii = <?php echo $_GET['page']; ?>;
//    if (<?php // echo $_GET['page'];  ?> == '') {
    var ii = 1;
//    } else {
//        var ii = <?php // echo $_GET['page'];  ?>;
//    }

    function viewmore() {


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
            url: "<?php echo $this->common_model->getUrl("pages", "2", "28", ''); ?>" + "/index",
            async: false,
            success: function (Data)
            {
                $(Data).insertBefore("#viewmore");
            }
        });

    }


    function getCategorySearch() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("varSearch");
        filter = input.value.toUpperCase();
        ul = document.getElementById("varCategoryResult");
        li = ul.getElementsByTagName("li");
        var j = 0;
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                j++;
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
        if (j == 0) {
            $('#notcategory').show();
        } else {
            $('#notcategory').hide();
        }
    }

    function submitrfqSearch() {

        var search_product1 = document.getElementById('search_product1').value;
        if (search_product1 == '') {
            M.toast({html: 'Please enter the value to search.'});
            return false;
        }
        var cat_type = document.getElementById('intSearchCategory1').value;
//        alert(cat_type);
        if (cat_type == '1' || cat_type == '') {
            var type = "&type=1";
            window.location = '<?php echo $this->common_model->getUrl("pages", "2", "51", "") . "?keyword=" ?>' + search_product1 + type;
        } else if (cat_type == '2') {
            var type = "&type=2";
            window.location = '<?php echo $this->common_model->getUrl("pages", "2", "28", "") . "?keyword=" ?>' + search_product1 + type;
        } else if (cat_type == '3') {
            var type = "&type=3";
            window.location = '<?php echo $this->common_model->getUrl("pages", "2", "99", "") . "?keyword=" ?>' + search_product1 + type;
        }
        return false;
    }

    $(document).ready(function () {
        $("#search_product1").keyup(function () {

            var cat_type = document.getElementById('intSearchCategory1').value;
            var search_product1 = document.getElementById('search_product1').value;
            if (cat_type != '3') {
                $.ajax({
                    type: "POST",
                    url: "<?php echo SITE_PATH; ?>fronthome/get_all_products",
                    data: {"csrf_indibizz": csrfHash, 'query': $(this).val(), 'type': cat_type},
                    success: function (data) {
                        $("#suggesstion-box1").show();
                        $("#suggesstion-box1").html(data);
                    }
                });
            }
        });
    });

    function updatefilter(type, value = '') {


        var search_product1 = document.getElementById('search_product1').value;


        if (search_product1 == '') {
//             var alteredURL = removeParam("keyword", window.location.href);
            var newurl = window.location.href;
            var string = newurl,
                    substring = "?keyword";
            if (string.includes(substring) == 1) {

            } else {

                var newurl = window.location.href + '?keyword=' + search_product1
                window.history.pushState({path: newurl}, '', newurl);
            }
        }
        if (history.pushState) {
//            Business Type Filter...
            if (type == 'time') {
                var alteredURL = removeParam("time", window.location.href);
                if (value == 'all') {
                    var newurl = alteredURL;
                } else {
                    var newurl = alteredURL + '&time=' + value;
                }
            }
            if (type == 'business') {
                var alteredURL = removeParam("business", window.location.href);
                var newurl = alteredURL + '&business=' + value;
            }
            if (type == 'photo') {
                var ChkBox = document.getElementById("photo");
                if (ChkBox.checked == 1) {
                    var alteredURL = window.location.href;
                    var newurl = alteredURL + '&photo=1';
                } else {
                    var alteredURL = removeParam("photo", window.location.href);
                    var newurl = alteredURL;

                }
            }
            if (type == 'attachment') {
                var ChkBoxs = document.getElementById("attachment");

                if (ChkBoxs.checked == 1) {
                    var alteredURL = window.location.href;
                    var newurl = alteredURL + '&attachment=1';
                } else {
                    var alteredURL = removeParam("attachment", window.location.href);
                    var newurl = alteredURL;

                }
            }
            if (type == 'requirement') {
                var ChkBoxs = document.getElementById("requirement");
                if (ChkBoxs.checked == 1) {
                    var alteredURL = window.location.href;
                    var newurl = alteredURL + '&requirement=1';
                } else {
                    var alteredURL = removeParam("requirement", window.location.href);
                    var newurl = alteredURL;
                }
            }
//            Business Type Filter...
//            if (type == 'plans') {
//                var ChkBox = document.getElementById("intPlans" + value);
//                var t_plans = document.getElementById('plans').value;
//                if (ChkBox.checked == 1) {
//                    var text_plans = value + "," + t_plans;
//                } else {
//                    var text_plans = removeValue(t_plans, value, ",");
//                }
//                document.getElementById('plans').value = text_plans;
//                var alteredURL = removeParam("plans", window.location.href);
//                var newurl = alteredURL + '&plans=' + text_plans;
//            }
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
                $('html, body').animate({scrollTop: $('#gridbody_front').position().top}, 'slow');

                var alteredURL = removeParam("page", window.location.href);
                var newurl = alteredURL + '&page=' + value;
            }
//            Free Sample Filter...
//            if (type == 'free_sample') {
//                var ChkBox = document.getElementById("chrSample");
//                if (ChkBox.checked == 1) {
//                    var alteredURL = removeParam("sample", window.location.href);
//                    var newurl = alteredURL + '&sample=1';
//                } else {
//                    var alteredURL = removeParam("sample", window.location.href);
//                    var newurl = alteredURL;
//                }
//            }
            window.history.pushState({path: newurl}, '', newurl);
        }

        $('#buyleads').load(document.URL + ' #buyleads');


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


    $(document).ready(function ()
    {

        $("#FrmRfq").validate({
            ignore: [],
            rules: {
                search_product1: {
                    required: true
                },
                varQuantity: {
                    required: true
                },
                intUnit: {
                    required: true
                }
            },
            errorPlacement: function (error, element)
            {

            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });

</script>
<div id="page-wrapper"></div> 
<div id="gridbody_front">
    <div class="listing-search" style="background-image: url(<?php echo FRONT_MEDIA_URL; ?>images/listing-image.jpg);">
        <div class="container">
            <div class="row centerlist">
                <div class="list-middle">
                    <div class="col m2 l2 s12">
                        <div class="listing-logo">
                            <a href="<?php echo SITE_PATH; ?>"> <img src="<?php echo FRONT_MEDIA_URL; ?>images/listing-logo.png"></a>
                        </div>
                    </div>
                    <div class="col m10 l10 s12">
                        <div class="rfq-info-search">
                            <?php
                            $action = $this->common_model->getUrl("pages", "2", "52", '');
                            $attributes = array('name' => 'FrmRfq', 'id' => 'FrmRfq', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form', 'method' => 'post');
                            echo form_open($action, $attributes);
                            ?>
                            <div class="col m6 l7 s12">
                                <div class="related-listing card">
                                    <div class="product-search">
                                        <div class="search-option card"><!--Search option -->
                                            <div class="input-field col m3 s4">
                                                <select id="intSearchCategory1" name="intSearchCategory1">
                                                    <option value="" disabled >All Categories</option>
                                                    <option value="1">Product</option>
                                                    <option value="2" selected>Buy Lead</option>
                                                    <option value="3">Supplier</option>
                                                </select>
                                            </div>
                                            <div class="search-input col m8 s7 padding">
                                                <input type="search" autocomplete="off" value="<?php echo $_GET['keyword']; ?>" id="search_product1" name="varProduct" class="search-field" placeholder="Search Products">  

                                                <div class="divpopup card" style="display: none;">
                                                    <div class="populer-search">
                                                        <div class="pop-action">
                                                            <h3>Popular Searches</h3>
                                                            <a href="javascript:;"  onclick="return clearProductCookies();">Clear</a></div>
                                                        <?php
                                                        $getCookiesProducts = $this->mylibrary->requestGetCookie('cookies_search_products');
                                                        $explodeProduct = explode(",", $getCookiesProducts);
                                                        ?>

                                                        <ul id="cookies_product">
                                                            <?php
                                                            $explodeProducts = array_reverse($explodeProduct);
                                                            $a = 0;
                                                            foreach ($explodeProducts as $pro_cookies) {
                                                                if ($pro_cookies != '') {
                                                                    if ($a < 10) {
                                                                        $get_cookies_product_url = $this->common_model->getUrl("pages", "2", "51", '') . "?keyword=" . $pro_cookies;
                                                                        ?>
                                                                        <li><a href="<?php echo $get_cookies_product_url; ?>"><?php echo $pro_cookies; ?></a></li>
                                                                        <?php
                                                                    }
                                                                }
                                                                $a++;
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div> 
                                                <!-- on search value -->
                                                <div class="search-list card" style="display: none;">
                                                    <div class="populer-search"  id="suggesstion-box1">
                                                    </div>
                                                </div> 
                                                <!-- end search value -->
                                            </div>
                                            <div class="search-button col m1 s1">
                                                <a class="rfq-submit"  onclick="return submitrfqSearch();"></a>
                                            </div>
                                        </div><!-- End Search option -->
                                    </div>
                                </div>
                            </div>
                            <div class="col m6 l5 s12">
                                <div class="related-moq card">
                                    <div class="moq-listing">
                                        <div class="col m12 s12 padding border-radius">
                                            <div class="col m4 s6 padding">        
                                                <div class="input-field field-custom qtity-work">
                                                    <input id="varQuantity" name="varQuantity"  onkeypress="return KeycheckOnlyNumeric(event);" type="text" placeholder="Qty">
                                                </div>
                                            </div>
                                            <div class="col m4 s6 padding">
                                                <div class="input-field field-custom">
                                                    <div class="input-field">
                                                        <?php echo $getQtyData; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="quots col s12 m4 l4 padding">
                                                <button type="submit" class="waves-effect waves-light btn modal-trigger button-design">Get a Quote</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            echo form_close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="listing-rfq-list">
        <div class="row">
            <div class="listing-category-rfq">
                <div class="col l3 m3 s12 padding drop-code-menu ">
                    <div class="cd-dropdown-wrapper">
                        <a class="cd-dropdown-trigger deckstopcat mobilecat mobile-menu" href="javascript:;">All Categories</a>
                        <nav class="cd-dropdown card">
                            <h2>All Categories</h2>
                            <a href="javascript:;" class="cd-close deckstopcat mobilecat mobile-sorce">Close</a>
                            <?php echo $getRFQAllCategories; ?>
                        </nav>
                    </div>
                </div>
                <div class="col m12 l9 s12">
                    <ul>
                        <li>
                            <div id="btn">
                                <span>filter</span>
                                <i class="fas fa-filter"></i>
                            </div>
                            <div class="rfq-listing-right" id="box">
                                <div class="sortlist card">
                                    <div class="rfq-cat-list">
                                        <?php
                                        if ($_GET['keyword'] != '') {
                                            ?>
                                            <div class="col s12 m12">
                                                <?php
                                                echo $getCatRFQListing;
                                                ?>
    <!--                                                <div class="cat-listrfqmain"><a href="">Sub category (08)<i class="fas fa-caret-right"></i></a></div>
                        <div class="cat-listrfqmain"><a href="">Sub Last category (10)<i class="fas fa-caret-right"></i></a></div>
                        <div class="cat-listrfqmain"><a href="">Sub Last category (10)<i class="fas fa-caret-right"></i></a></div>
                        <div class="cat-listrfqmain"><a href="">Sub Last category (10)<i class="fas fa-caret-right"></i></a></div>-->
                                                <!--<a class="read-more-show hide01" href="#" id="1">Read More...</a>-->
                                                <!--                                                <div class="read-more-content">
                                                                                                    <div class="cat-listrfqmain"><a href="">Main category (20)<i class="fas fa-caret-right"></i></a></div>
                                                                                                    <div class="cat-listrfqmain"><a href="">Sub category (15)<i class="fas fa-caret-right"></i></a></div>
                                                                                                    <div class="cat-listrfqmain"><a href="">Sub Last category (20)<i class="fas fa-caret-right"></i></a></div>
                                                                                                    <div class="cat-listrfqmain"><a href="">Sub category (20)<i class="fas fa-caret-right"></i></a></div>
                                                                                                    <div class="cat-listrfqmain"><a href="">Sub Last category (20)<i class="fas fa-caret-right"></i></a></div>
                                                                                                    <a class="read-more-hide hide01" href="#" more-id="1">Read Less...</a>
                                                                                                </div>-->
                                            </div>
                                        <?php } ?>
                                        <div class="col s12 m12 l8 padding">
                                            <div class="sort-check">
                                                <span class="sort-head">
                                                    Sort :
                                                </span>
                                                <div class="check-all">
                                                    <div class="check-border">
                                                        <label>
                                                            <?php
                                                            if ($_GET['photo'] == '1') {
                                                                $checked = "checked";
                                                            } else {
                                                                $checked = "";
                                                            }
                                                            ?>
                                                            <input <?php echo $checked; ?> onclick="return updatefilter('photo');" id="photo" type="checkbox" class="filled-in" />
                                                            <span for="photo">With photo</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="check-all">
                                                    <div class="check-border">
                                                        <label>
                                                            <?php
                                                            if ($_GET['attachment'] == '1') {
                                                                $achecked = "checked";
                                                            } else {
                                                                $achecked = "";
                                                            }
                                                            ?>
                                                            <input <?php echo $achecked; ?> onclick="return updatefilter('attachment');" id="attachment" type="checkbox" class="filled-in" />
                                                            <span  for="attachment">With attachment</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="check-all">
                                                    <div class="check-border">
                                                        <label>
                                                            <?php
                                                            if ($_GET['requirement'] == '1') {
                                                                $rchecked = "checked";
                                                            } else {
                                                                $rchecked = "";
                                                            }
                                                            ?>
                                                            <input <?php echo $rchecked; ?> onclick="return updatefilter('requirement');" id="requirement" type="checkbox" class="filled-in"  />
                                                            <span>Urgent requirement</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="check-all">
                                                    <div class="check-border">
                                                        <label>
                                                            <input type="checkbox" class="filled-in" />
                                                            <span>Verify</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="requirtype">
                                                <span class="sort-head">
                                                    Requirement type :
                                                </span>
                                                <div class="type-radio">
                                                    <label>
                                                        <?php
                                                        if ($_GET['business'] == "1") {
                                                            $check1 = "checked";
                                                        } else {
                                                            $check1 = "";
                                                        }
                                                        ?>
                                                        <input <?php echo $check1; ?> onclick="return updatefilter('business', '1')" class="with-gap" name="group1" type="radio"  />
                                                        <span>One Time</span>
                                                    </label>
                                                </div>
                                                <div class="type-radio">
                                                    <label>
                                                        <?php
                                                        if ($_GET['business'] == "2") {
                                                            $check2 = "checked";
                                                        } else {
                                                            $check2 = "";
                                                        }
                                                        ?>
                                                        <input <?php echo $check2 ?> onclick="return updatefilter('business', '2')" class="with-gap" name="group1" type="radio"  />
                                                        <span>Regular</span>
                                                    </label>
                                                </div>
                                                <div class="type-radio">
                                                    <label>
                                                        <?php
                                                        if ($_GET['business'] == "3") {
                                                            $check3 = "checked";
                                                        } else {
                                                            $check3 = "";
                                                        }
                                                        ?>
                                                        <input <?php echo $check3; ?> onclick="return updatefilter('business', '3')" class="with-gap" name="group1" type="radio"  />
                                                        <span>Monthly</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col s12 m12 padding">
                                                <span class="sort-head">
                                                    Time posted :
                                                </span>
                                                <div class="post-req"><a href="javascript:;" onclick="return updatefilter('time', '8h')" >Last 8 hours<i class="fas fa-caret-right"></i></a></div>
                                                <div class="post-req"><a href="javascript:;" onclick="return updatefilter('time', '24h')">Last 24 hour<i class="fas fa-caret-right"></i></a></div>
                                                <div class="post-req"><a href="javascript:;" onclick="return updatefilter('time', '2d')">Last 2 Days<i class="fas fa-caret-right"></i></a></div>
                                                <div class="post-req"><a href="javascript:;" onclick="return updatefilter('time', '1w')">Last Week<i class="fas fa-caret-right"></i></a></div>
                                                <div class="post-req"><a href="javascript:;" onclick="return updatefilter('time', '1m')">Last Month<i class="fas fa-caret-right"></i></a></div>
                                                <div class="post-req"><a href="javascript:;" onclick="return updatefilter('time', 'all')">All<i class="fas fa-caret-right"></i></a></div>
                                            </div>
                                        </div>
                                        <div class="col s12 m12 l4">
                                            <div class="col s12 m12 l12">
                                                <div class="col s12 m12 l12 padding">
                                                    <div class="all-option rfq-range">
                                                        <h6>Nearby  <span style="text-transform: lowercase;"> (km)</span></h6>
                                                        <div class="inner-menu nearby-me" id="one2">
                                                            <div class="sub-menu-class none-slide">
                                                                <div class="slider-container">
                                                                    <input type="text" id="slider3" class="slider" />
                                                                </div>                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s12 m12 rouond-source">
                                        <div class="rfq-list-loac">
                                            <ul>
                                                <li>
                                                    <div class=" tooltipped-hover" id="btnclick"><i class="material-icons dp48">add_location</i>
                                                        <div class="colon-hover card">
                                                            Select Location
                                                        </div>
                                                    </div>
                                                    <div class="open-loac card">
                                                        <span>
                                                            <form class="import-city">
                                                                <input type="search" placeholder="Search...">
                                                            </form>
                                                            <div class="find-search-city">
                                                                <div class="check-all">
                                                                    <div class="check-border">
                                                                        <label>
                                                                            <input type="checkbox" class="filled-in" />
                                                                            <span>United States (20)</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="check-all">
                                                                    <div class="check-border">
                                                                        <label>
                                                                            <input type="checkbox" class="filled-in" />
                                                                            <span>South Korea (20)</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="check-all">
                                                                    <div class="check-border">
                                                                        <label>
                                                                            <input type="checkbox" class="filled-in" />
                                                                            <span>Canada (10)</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="check-all">
                                                                    <div class="check-border">
                                                                        <label>
                                                                            <input type="checkbox" class="filled-in" />
                                                                            <span>Australia (05)</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </div>
                                                </li>                  
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>  
                    </ul>
                    <div id="buyleads">
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
                        <div id="viewmore"></div>

                        <input type="hidden" id="pagename" >

                        <?php if (count($getRFQListing) > 0) { ?>
                            <?php if ($getCountBuyLeadsListing / DEFAULT_PAGESIZE >= 1) { ?>
                                <div class="animation-short">
                                    <div class="arrow bounce">
                                        <a class="design-button card" href="javascript:;"  onclick="viewmore();">
                                            <div class="double">
                                                <span class="ouro ouro3">
                                                    <span class="left"><span class="anim"></span></span>
                                                    <span class="right"><span class="anim"></span></span>
                                                </span>
                                            </div>
                                            View More</a>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <center><p>No record found.</p></center>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>