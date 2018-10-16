<script type="text/javascript">
    function getBlogSearch() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("varBlogSearch");
        filter = input.value.toUpperCase();
        ul = document.getElementById("BlogList");
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
            $('#noblogs').show();
        } else {
            $('#noblogs').hide();
        }
    }
</script>
<script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5b6d650c04b9a500117b0c21&product=inline-share-buttons' async='async'></script>
<section class="company-titel-mini" style="background-image: url(<?php echo FRONT_MEDIA_URL; ?>images/listing-image.jpg);">
    <div class="container">
        <div class="row">
            <div class="company-info-mini">
                <h5>Blog</h5>
            </div>
            <div id="breadcum-spot">  
                <?php
//                $blogurl = $this->common_model->getUrl("pages", "2", "60", ""); 
                $blogurl = str_replace("___", "blog", SUB_DOMAIN);
                ?>
                <ul>
                    <li><a href="<?php echo $blogurl; ?>" class="waves-effect waves-light btn">Blogs</a></li>

                    <li><a href="<?php echo SITE_PATH; ?>" class="waves-effect waves-light btn"><i class="fa fa-home"></i></a></li>

                </ul>

            </div>
        </div>
    </div>
</section>

<section class="blog-list-view">
    <div class="container">
        <div class="row">
            <div class="blog-detail-once">
                <div class="col s12 m8 l8">
                    <div class="blog-posting card">
                        <div class="blog-heading-one">
                            <a href="" class="head-blog"><i class="fas fa-rss"></i><?php echo $ShowAllPagesRecords['varTitle']; ?></a>
                        </div>
                        <div class="blog-post-image">
                            <?php
                            $imagename = $ShowAllPagesRecords['varImage1'];
                            $imagepath = 'upimages/blogs/images/' . $imagename;
                            if (file_exists($imagepath) && $ShowAllPagesRecords['varImage1'] != '') {
                                $image_thumb1 = image_thumb($imagepath, BLOGS_DETAIL_WIDTH, BLOGS_DETAIL_HEIGHT);
                            }
                            if ($imagename != "") {
                                if (file_exists($imagepath)) {
                                    $image = $image_thumb1;
                                } else {
                                    $image = FRONT_MEDIA_URL . "images/blog/post-01-570x321.jpg";
                                }
                            } else {
                                $image = FRONT_MEDIA_URL . "images/blog/post-01-570x321.jpg";
                            }
                            ?>
                            <img src="<?php echo $image; ?>">
                        </div>
                        <div class="col s12 m12 padding">

                            <div class="blog-content-post">
                                <div class="col s12 m12">
                                    <div class="col s12 m6 padding">
                                        <div class="blog-priview">
                                            <ul class="post-controls list-inline list-inline-sm p text-dark ">
                                                <li><span class="text-middle icon-xxs text-picton-blue mdi mdi-clock far fa-clock"></span>
                                                    <time class="text-middle small" datetime="<?php echo date('j', strtotime($ShowAllPagesRecords['dtBlogDate'])); ?><small><?php echo date('S', strtotime($ShowAllPagesRecords['dtBlogDate'])); ?></small> <?php echo date('F, Y', strtotime($ShowAllPagesRecords['dtBlogDate'])); ?>-01"><?php echo date('j', strtotime($ShowAllPagesRecords['dtBlogDate'])); ?><small><?php echo date('S', strtotime($ShowAllPagesRecords['dtBlogDate'])); ?></small> <?php echo date('F, Y', strtotime($ShowAllPagesRecords['dtBlogDate'])); ?></time>
                                                </li>
                                                <li><span class="text-middle icon-xxs text-picton-blue mdi mdi-account-outline fas fa-user-tie">&nbsp;</span><span class="text-middle small"><?php echo $ShowAllPagesRecords['varAuthor']; ?></span></li>
                                                <li><span class="text-middle icon-xxs text-picton-blue mdi mdi-folder-outline far fa-folder">&nbsp;</span>
                                                    <?php echo str_replace(",", ", ", $ShowAllPagesRecords['varType']); ?>                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col s12 m6">
                                        <div class="blog-social">

                                            <div class="sharethis-inline-share-buttons"></div>
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col s12 m12">
                                    <div class="blog-full">
                                        <h6><?php echo $ShowAllPagesRecords['varShortDesc']; ?></h6>
                                        <?php
                                        if ($ShowAllPagesRecords['txtDescription'] != '') {
                                            echo $this->mylibrary->Replace_Varible_with_Sitepath($ShowAllPagesRecords['txtDescription']);
                                        }
                                        ?> 
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m4 l4">
                    <div class="blog-right-post card">
                        <div class="blog-search">
                            <div class="search-category search-mibile-cat">

                                <div class="search-input col m10 s12 padding">

                                    <input type="text" autocomplete="off" id="varBlogSearch" onkeyup="getBlogSearch()" name="search" class="search-field" placeholder="Search Blog"> 

                                </div>

                                <!--                                <div class="search-button col m2 s2">
                                
                                                                    <input type="submit" name="submit" value="search">
                                
                                                                </div>-->

                            </div>
                        </div>
                        <div class="blog-recent">
                            <h6>Recent Posts</h6>
                            <ul id="BlogList">
                                <?php
                                foreach ($getRecentBlogs as $recent) {
                                    $subdomain = str_replace("___", "blog", SUB_DOMAIN) . "/" . $recent['varAlias'];
                                    ?>
                                    <li><a href="<?php echo $subdomain; ?>"><i class="far fa-circle"></i><?php echo $recent['varTitle']; ?></a></li>
                                <?php } ?>
                                <li id="noblogs" style="display:none;"><a href='javascript:; '>No Blog found.</a></li>
                            </ul>
                        </div>

                        <div class="blog-recent">
                            <h6>Archives</h6>
                            <ul>
                                <?php
                                for ($i = 1; $i <= 6; $i++) {
                                    ?>
                                    <li><a href="<?php echo $blogurl . "?month=" . date('m', strtotime("-$i month")); ?>"><i class="far fa-circle"></i><?php echo date('F Y', strtotime("-$i month")); ?></a></li>
                                <?php } ?>

                            </ul>
                        </div>
                        <div class="blog-recent">
                            <h6>Categories</h6>
                            <ul>
                                <?php
                                foreach ($getBusinessType as $types) {
                                    if ($types != '') {
                                        ?>
                                        <li><a href="<?php echo $blogurl . "?cat=" . trim($types); ?>"><i class="far fa-circle"></i><?php echo trim($types); ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
