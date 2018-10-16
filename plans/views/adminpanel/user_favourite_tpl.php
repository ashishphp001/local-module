<link rel="stylesheet" href="<?php echo FRONT_MEDIA_URL; ?>css/das/uikit.almost-flat.min.css" media="all">
<link rel="stylesheet" href="<?php echo FRONT_MEDIA_URL; ?>css/das/main.min.css" media="all">
<?php
echo $this->load->view($UserSideBar);
?>
<script>
    function deleteproduct(id) {
        $.ajax({
            type: "POST",
            data: {"csrf_indibizz": csrfHash, "int_id": id},
            url: "<?php echo $this->common_model->getUrl("pages", "2", "110", ''); ?>" + "/delete_product",
            async: false,
            success: function (Data)
            {
                $("#product_list" + id).hide();
                $("#1product_list" + id).hide();

            }
        });
    }
    function updatefilter(type, value = '') {
        var search_product = document.getElementById('search_product').value;
        if (search_product == '') {
            var newurl = window.location.href + '?filter=' + search_product;
            window.history.pushState({path: newurl}, '', newurl);
        }
//        alert(type);
        if (history.pushState) {
            if (type == 'photo') {
                var ChkBox = document.getElementById("chrPhoto");
                if (ChkBox.checked == 1) {

                    var alteredURL = removeParam("photo", window.location.href);
                    var newurl = alteredURL + '&photo=1';
                } else {
                    var alteredURL = removeParam("photo", window.location.href);
                    var newurl = alteredURL;
                }

            }
            if (type == 'price') {
                var ChkBox = document.getElementById("chrPrice");
                if (ChkBox.checked == 1) {

                    var alteredURL = removeParam("price", window.location.href);
                    var newurl = alteredURL + '&price=1';
                } else {
                    var alteredURL = removeParam("price", window.location.href);
                    var newurl = alteredURL;
                }
            }
            window.location = newurl;
//            alert(newurl);
//              window.history.pushState({path: newurl}, '', newurl);
    }
//        $('#refreshdiv').load(document.URL + ' #refreshdiv');
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
<div class="row">
    <div id="page_content">
        <div id="page_content_inner">
            <div class="col s12 m12">
                <div class="col s12 m12 padding">
                    <div class="filter-dasbord card aligncenter-top">
                        <div class="col m2 l1 s12 ">
                            <div class="check-photo">
                                <label>
                                    <?php
                                    if ($_GET['photo'] != '') {
                                        $photocheck = "checked";
                                    } else {
                                        $photocheck = "";
                                    }
                                    ?>
                                    <input type="checkbox" class="filled-in" <?php echo $photocheck; ?> id="chrPhoto" name="chrPhoto"  onclick="return updatefilter('photo', '')" />
                                    <span>Photo</span>
                                </label>
                            </div>
                        </div>
                        <div class="col m2 l1 s12 ">
                            <div class="check-photo">
                                <label>
                                    <?php
                                    if ($_GET['price'] != '') {
                                        $pricecheck = "checked";
                                    } else {
                                        $pricecheck = "";
                                    }
                                    ?>
                                    <input type="checkbox" class="filled-in" <?php echo $pricecheck; ?> id="chrPrice" name="chrPrice"  onclick="return updatefilter('price', '')"  />
                                    <span>Price</span>
                                </label>
                            </div>
                        </div>
                        <div class="col s12 m3 rating-create">
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
                        </div>
                        <div class="col m2 s12">
                            <div class="col m12 s12 more-info padding change-height">
                                <div class="form-part">
                                    <div class="input-field field-custom">
                                        <select>
                                            <option value="" disabled selected>Ratings</option>
                                            <option value="1">Highest To Lowest</option>
                                            <option value="2">Lowest To Highest</option>
                                        </select>
                                        <!-- <label>Sub Category</label> -->
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="col s12 m4">
                            <div class="search-category search-mibile-cat">
                                <div class="search-input col m12 s12">
                                    <input type="search" name="search" class="search-field" placeholder="Search Category"> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col s12 m12 padding dashbord-design-motive">
                    <div class="dashbord-tab card">
                        <div class="col s12 m12 l12">
                            <div class="detail-tabs tabe-near">
                                <div class="row">
                                    <div class="col s12 m9 padding">
                                        <ul class="tabs">
                                            <?php
                                            $type = $this->input->get_post('type');

                                            if ($type == 'a') {
                                                $altype = '';
                                                $atype = ' class="active"';
                                                $ptype = '';
                                                $rtype = '';
                                            } else if ($type == 'p') {
                                                $altype = '';
                                                $atype = '';
                                                $ptype = ' class="active"';
                                                $rtype = '';
                                            } else if ($type == 'r') {
                                                $altype = '';
                                                $atype = '';
                                                $ptype = '';
                                                $rtype = ' class="active"';
                                            } else {
                                                $altype = ' class="active"';
                                                $atype = '';
                                                $ptype = '';
                                                $rtype = '';
                                            }
                                            ?>
                                            <li class="tab"><a <?php echo $altype; ?> href="#basic-detail">All Products</a></li>
                                            <li class="tab"><a <?php echo $atype; ?> href="#packing">Approved</a></li>
                                            <li class="tab"><a <?php echo $ptype; ?> href="#feature">Pending</a></li>
                                            <li class="tab"><a <?php echo $rtype; ?> href="#rejected">Rejected</a></li>
                                        </ul>                                            
                                    </div>
                                    <div class="col s12 m3 padding">
                                        <div class="add-product"> 
                                            <?php
                                            $getproductUrl = $this->common_model->getUrl("pages", "2", "50", '');
                                            ?>
                                            <a href="<?php echo $getproductUrl; ?>" class="add-click"><i class="fas fa-plus-circle"></i>Add Products</a>
                                        </div>
                                    </div>
                                    <div class="card tab-withdetail" id="refreshdiv">
                                        <div id="basic-detail" class="col s12">
                                            <?php
                                            $getAllUserProductList = $this->Module_Model->getProductList(USER_ID, "all");
                                            foreach ($getAllUserProductList as $row) {
                                                $getProductImages = $this->Module_Model->getProductListingImageData($row['int_id']);
                                                if ($_GET['photo'] != '') {
                                                    if (count($getProductImages) > 0) {
                                                        $isdisplay = "1";
                                                    } else {
                                                        $isdisplay = "0";
                                                    }
                                                } else {
                                                    $isdisplay = "1";
                                                }
                                                if ($isdisplay == "1") {
                                                    ?>
                                                    <div class="basic-detail-info" id="product_list<?php echo $row['int_id'] ?>">
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
                                                                                <div class="security-purpose">
                                                                                    <div class="companyname mode-define special-none">
                                                                                        <?php if ($row['chrPublish'] == 'Y') { ?>
                                                                                            <span><i class="fas fa-circle"></i>Approved</span>
                                                                                        <?php } else if ($row['chrApprove'] == 'P') { ?>     
                                                                                            <span><i class="fas fa-clock"></i>Pending</span>
                                                                                        <?php } else if ($row['chrApprove'] == 'N' && $row['chrPublish'] == 'N') { ?>     
                                                                                            <span><i class="fa fa-circle offline"></i>Rejected</span>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>                                       
                                                            </div>
                                                            <span class="all-btn">
                                                                <a href="<?php echo $getproductUrl . "?product=" . $this->mylibrary->cryptPass($row['int_id']); ?>"><i class="fas fa-user-edit card"></i></a>
                                                                <a href="javascript:;" onclick="return deleteproduct(<?php echo $row['int_id']; ?>);"><i class="far fa-trash-alt card"></i></a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div id="packing" class="col s12">
                                            <?php
                                            $getApprovalUserProductList = $this->Module_Model->getProductList(USER_ID, "app");
                                            foreach ($getApprovalUserProductList as $row) {
                                                $getProductImages = $this->Module_Model->getProductListingImageData($row['int_id']);
                                                if ($_GET['photo'] != '') {
                                                    if (count($getProductImages) > 0) {
                                                        $isdisplay = "1";
                                                    } else {
                                                        $isdisplay = "0";
                                                    }
                                                } else {
                                                    $isdisplay = "1";
                                                }
                                                if ($isdisplay == "1") {
                                                    ?>
                                                    <div class="basic-detail-info" id="1product_list<?php echo $row['int_id'] ?>">
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
                                                                                <div class="security-purpose">
                                                                                    <div class="companyname mode-define special-none">
                                                                                        <?php if ($row['chrPublish'] == 'Y') { ?>
                                                                                            <span><i class="fas fa-circle"></i>Approved</span>
                                                                                        <?php } else if ($row['chrApprove'] == 'P') { ?>     
                                                                                            <span><i class="fas fa-clock"></i>Pending</span>
                                                                                        <?php } else if ($row['chrApprove'] == 'N' && $row['chrPublish'] == 'N') { ?>     
                                                                                            <span><i class="fa fa-circle offline"></i>Rejected</span>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>                                       
                                                            </div>
                                                            <span class="all-btn">
                                                                <a href="<?php echo $getproductUrl . "?product=" . $this->mylibrary->cryptPass($row['int_id']); ?>"><i class="fas fa-user-edit card"></i></a>
                                                                <a href="javascript:;" onclick="return deleteproduct(<?php echo $row['int_id']; ?>);"><i class="far fa-trash-alt card"></i></a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div id="feature" class="col s12">
                                            <?php
                                            $pgetPendingUserProductList = $this->Module_Model->getProductList(USER_ID, "pen");
                                            foreach ($pgetPendingUserProductList as $row) {
                                                $getProductImages = $this->Module_Model->getProductListingImageData($row['int_id']);
                                                if ($_GET['photo'] != '') {
                                                    if (count($getProductImages) > 0) {
                                                        $isdisplay = "1";
                                                    } else {
                                                        $isdisplay = "0";
                                                    }
                                                } else {
                                                    $isdisplay = "1";
                                                }
                                                if ($isdisplay == "1") {
                                                    ?>
                                                    <div class="basic-detail-info" id="1product_list<?php echo $row['int_id'] ?>">
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
                                                                                    $pthumbphoto1 = image_thumb($thumb, PHOTOGALLERY_WIDTH, PHOTOGALLERY_HEIGHT);
                                                                                    ?>
                                                                                    <div class="slide">
                                                                                        <div class="in-callimg">
                                                                                            <div class="place-img"></div>
                                                                                            <div class="cate-img1">
                                                                                                <div class="in-changeimg">
                                                                                                    <img src="<?php echo $pthumbphoto1; ?>" alt="<?php echo $row['varName']; ?>" title="<?php echo $row['varName']; ?>">
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
                                                                                <div class="security-purpose">
                                                                                    <div class="companyname mode-define special-none">
                                                                                        <?php if ($row['chrPublish'] == 'Y') { ?>
                                                                                            <span><i class="fas fa-circle"></i>Approved</span>
                                                                                        <?php } else if ($row['chrApprove'] == 'P') { ?>     
                                                                                            <span><i class="fas fa-clock"></i>Pending</span>
                                                                                        <?php } else if ($row['chrApprove'] == 'N' && $row['chrPublish'] == 'N') { ?>     
                                                                                            <span><i class="fa fa-circle offline"></i>Rejected</span>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>                                       
                                                            </div>
                                                            <span class="all-btn">
                                                                <a href="<?php echo $getproductUrl . "?product=" . $this->mylibrary->cryptPass($row['int_id']); ?>"><i class="fas fa-user-edit card"></i></a>
                                                                <a href="javascript:;" onclick="return deleteproduct(<?php echo $row['int_id']; ?>);"><i class="far fa-trash-alt card"></i></a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div id="rejected" class="col s12">
                                            <?php
                                            $getRejectedUserProductList = $this->Module_Model->getProductList(USER_ID, "rej");
                                            foreach ($getRejectedUserProductList as $row) {
                                                $rgetProductImages = $this->Module_Model->getProductListingImageData($row['int_id']);
                                                if ($_GET['photo'] != '') {
                                                    if (count($rgetProductImages) > 0) {
                                                        $isdisplay = "1";
                                                    } else {
                                                        $isdisplay = "0";
                                                    }
                                                } else {
                                                    $isdisplay = "1";
                                                }
                                                if ($isdisplay == "1") {
                                                    ?>
                                                    <div class="basic-detail-info" id="1product_list<?php echo $row['int_id'] ?>">
                                                        <div class="display-bl">
                                                            <div class="card-smell">
                                                                <div class="box-image-s">
                                                                    <div class="slider-effect">
                                                                        <section class="slide-prod slider1">
                                                                            <?php
                                                                            foreach ($rgetProductImages as $pro_img) {
                                                                                $photo_thumb = $pro_img['varImage'];
                                                                                $thumb = 'upimages/productgallery/images/' . $photo_thumb;
                                                                                if (file_exists($thumb) && $photo_thumb != '') {
                                                                                    $rthumbphoto1 = image_thumb($thumb, PHOTOGALLERY_WIDTH, PHOTOGALLERY_HEIGHT);
                                                                                    ?>
                                                                                    <div class="slide">
                                                                                        <div class="in-callimg">
                                                                                            <div class="place-img"></div>
                                                                                            <div class="cate-img1">
                                                                                                <div class="in-changeimg">
                                                                                                    <img src="<?php echo $rthumbphoto1; ?>" alt="<?php echo $row['varName']; ?>" title="<?php echo $row['varName']; ?>">
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
                                                                                <div class="security-purpose">
                                                                                    <div class="companyname mode-define special-none">
                                                                                        <?php if ($row['chrPublish'] == 'Y') { ?>
                                                                                            <span><i class="fas fa-circle"></i>Approved</span>
                                                                                        <?php } else if ($row['chrApprove'] == 'P') { ?>     
                                                                                            <span><i class="fas fa-clock"></i>Pending</span>
                                                                                        <?php } else if ($row['chrApprove'] == 'N' && $row['chrPublish'] == 'N') { ?>     
                                                                                            <span><i class="fa fa-circle offline"></i>Rejected</span>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>                                       
                                                            </div>
                                                            <span class="all-btn">
                                                                <a href="<?php echo $getproductUrl . "?product=" . $this->mylibrary->cryptPass($row['int_id']); ?>"><i class="fas fa-user-edit card"></i></a>
                                                                <a href="javascript:;" onclick="return deleteproduct(<?php echo $row['int_id']; ?>);"><i class="far fa-trash-alt card"></i></a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
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
</div>

