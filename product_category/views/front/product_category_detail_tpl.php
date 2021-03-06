<script type="text/javascript">
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
    function getCategoryMobileSearch() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("varSearch1");
        filter = input.value.toUpperCase();
        ul = document.getElementById("varCategoryResult1");
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
            $('#notcategory1').show();
        } else {
            $('#notcategory1').hide();
        }
    }
</script>


<?php
//$getfirstcategory = $this->Module_Model->getParentCategory();
//print_r($getfirstcategory);
$getproductcategory = $this->Module_Model->getProductCategories(RECORD_ID);
?>
<section class="contentcat">
    <div class="col m3 s12 padding-right mobile-padding-cat">
        <div class="sidebar">
            <div class="floater-wrapper">
                <div class="floater" 
                     data-component="floater"
                     data-floater-container=".contentcat"
                     data-floater-options='{"paddingBottom": "50", "animationDuration": "0"}'>
                    <div class="category-list-view card "> 
                        <a href="#cat-open-popup" id="pull" class="cat-display-mobile waves-effect waves-light btn modal-trigger">category Name <i class="far fa-hand-pointer"></i></a>         
                        <div class="search-category search-mibile-cat">
                            <div class="search-input col m10 s10 padding">
                                <input  type="search"  id="varSearch" onkeyup="getCategorySearch()"  class="search-field" placeholder="Search Category"> 
                                <input type="hidden" id="intCategory" name="intCategory" value="0">
                            </div>
<!--                            <div class="search-button col m2 s2">
                                <input type="submit" disabled="" name="submit" value="search">
                            </div>-->
                        </div>
                        <nav class="clearfix">
                            <a href="javascript:;" id="pull" class="cat-display-decstop">Menu <i class="fas fa-bars"></i></a>
                            <ul class="clearfix" id="varCategoryResult">
                                <?php
                                $getParent = $this->Module_Model->getProductCategory(RECORD_ID);
                                $getParentCategory = $this->Module_Model->getProductCategories($getParent);
                                foreach ($getParentCategory as $row) {
                                    if ($row['int_id'] == RECORD_ID) {
                                        $class = "active";
                                    } else {
                                        $class = "";
                                    }
                                    if ($row['childcount'] > 0) {
                                        if ($_GET['type'] == 'rfq') {
                                            $link = SITE_PATH . $row['varAlias'] . "?type=rfq";
                                        } else {
                                            $link = SITE_PATH . $row['varAlias'];
                                        }
                                    } else {
                                        if ($_GET['type'] == 'rfq') {
                                            $rfq_link = $this->common_model->getUrl("pages", "2", "28", '');
                                            $link = $rfq_link . "?cat=" . $row['int_id'];
                                        } else {
                                            $product_link = $this->common_model->getUrl("pages", "2", "51", '');
                                            $link = $product_link . "?cat=" . $row['int_id'];
                                        }
                                    }
                                    ?>
                                    <li><a href="<?php echo $link; ?>" class="<?php echo $class; ?> waves-effect waves-light btn"><?php echo $row['varName']; ?></a></li>
                                <?php } ?>
                                <li id="notcategory" style="display:none;"><a class='waves-effect waves-light btn' href='javascript:; '>No Category found.</a></li>
                            </ul>            
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col m9 s12 padding-left mobile-padding-cat maincontent">
        <div class="category-list-info card">
            <div class="hide-story">
                <div class="category-slides">

                    <?php
                    $product_link = $this->common_model->getUrl("pages", "2", "51", '');
                    $rfq_link = $this->common_model->getUrl("pages", "2", "28", '');
                    if (count($getproductcategory) == 0) {
                        if ($_GET['type'] == 'rfq') {
                            header("Location:$rfq_link?cat=" . RECORD_ID);
                        } else {
                            header("Location:$product_link?cat=" . RECORD_ID);
                        }
                    }
                    foreach ($getproductcategory as $cat) {
                        $imagepath = 'upimages/product_category/images/' . $cat['varImage'];
                        if (file_exists($imagepath) && $cat['varImage'] != '') {
                            $image_thumb = image_thumb($imagepath, PRODUCTS_CATEGORY_WIDTH, PRODUCTS_CATEGORY_HEIGHT);
                        } else {
                            $image_thumb = FRONT_MEDIA_URL . "images/no_img/pc-noimg.png";
                        }
                        if ($cat['childcount'] > 0) {
                            if ($_GET['type'] == 'rfq') {
                                $alink = SITE_PATH . $cat['varAlias'] . "?type=rfq";
                            } else {
                                $alink = SITE_PATH . $cat['varAlias'];
                            }
                        } else {
                            if ($_GET['type'] == 'rfq') {

                                $alink = $rfq_link . "?cat=" . $cat['int_id'];
                            } else {

                                $alink = $product_link . "?cat=" . $cat['int_id'];
                            }
                        }
                        ?>
                        <div class="col m4 s12 cat-landscap">
                            <a href="<?php echo $alink; ?>" class="cat-box card">
                                <div class="cat-image-source">
                                    <img src="<?php echo $image_thumb; ?>" title="<?php echo $cat['varName']; ?>" alt="<?php echo $cat['varName']; ?>">
                                </div>
                                <div class="cat-pro-detail">
                                    <h1><?php echo $cat['varName']; ?></h1>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="cat-open-popup" class="modal bottom-sheet">
    <div class="modal-content mCustomScrollbar light" data-mcs-theme="minimal-dark">
        <div class="quot-content row">
            <div class="search-category">
                <form>
                    <div class="search-input col m10 s10 padding">
                        <input type="text"   id="varSearch1" onkeyup="getCategoryMobileSearch()" autocomplete="nope" autocomplete="off" class="search-field" placeholder="Search Category"> 
                    </div>
<!--                    <div class="search-button col m2 s2">
                        <input type="submit" name="submit" value="search" disabled="">
                    </div>-->
                </form>
            </div>
            <nav class="clearfix">
                <a href="javascript:;" id="pull" class="cat-display-decstop">Menu <i class="fas fa-bars"></i></a>
                <ul class="clearfix"  id="varCategoryResult1">
                    <?php
                    foreach ($getParentCategory as $row) {
                        if ($row['childcount'] > 0) {
                            if ($_GET['type'] == 'rfq') {
                                $mlink = SITE_PATH . $row['varAlias'] . "?type=rfq";
                            } else {
                                $mlink = SITE_PATH . $row['varAlias'];
                            }
                        } else {
                            if ($_GET['type'] == 'rfq') {
                                $rfq_link = $this->common_model->getUrl("pages", "2", "28", '');
                                $mlink = $rfq_link . "?cat=" . $cat['int_id'];
                            } else {
                                $product_link = $this->common_model->getUrl("pages", "2", "51", '');
                                $mlink = $product_link . "?cat=" . $cat['int_id'];
                            }
                        }
                        ?>
                        <li><a href="<?php echo $mlink; ?>" class="waves-effect waves-light btn"><?php echo $row['varName']; ?></a></li>
                    <?php } ?>   
                    <li id="notcategory1" style="display:none;"><a class='waves-effect waves-light btn' href='javascript:; '>No Category found.</a></li>

                </ul>            
            </nav>
        </div>
    </div>
    <div class="close-outside">
        <a href="javascript:;" class="modal-close waves-effect waves-blue btn-flat"><i class="fas fa-times"></i></a>
    </div>
</div>