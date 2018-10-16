<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function () {
        FB.init({appId: '418540598487174', status: true, cookie: true,
            xfbml: true});
    };
    (function () {
        var e = document.createElement('script');
        e.async = true;
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
    }());
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>



<div id="blog-page" class="container" role="main">
    <div class="row">

        <!-- BLOG POSTS HOLDER -->	
        <div id="blog-large" class="col-md-8">

            <!-- SINGLE IMAGE POST -->
            <article class="post-large">
                <div class="row">							
                    <div class="col-md-12 blog-item">
                        <!-- Post Image -->
                        <div class="post-img">
                            <?php
                            $imagename = $ShowAllPagesRecords['varImage1'];
                            $imagepath = 'upimages/blogs/images/' . $imagename;
                            if (file_exists($imagepath) && $ShowAllPagesRecords['varImage1'] != '') {
                                $image_thumb1 = image_thumb($imagepath, BLOGS_DETAIL_WIDTH, BLOGS_DETAIL_HEIGHT);
//                                $image_path = SITE_PATH . $imagepath;
                            }
                            if ($imagename != "") {
                                if (file_exists($imagepath)) {
                                    ?>   
                                    <img src="<?php echo $image_thumb1; ?>" alt="image" class="img-responsive">
                                <?php } else { ?>
                                    <img src="<?php echo FRONT_MEDIA_URL; ?>images/blogthumb.jpg" alt="image" class="img-responsive">                                          
                                    <?php
                                }
                            } else {
                                ?>
                                <img src="<?php echo FRONT_MEDIA_URL; ?>images/blogthumb.jpg" alt="image" class="img-responsive">                                          
                            <?php } ?>

                        </div>

                        <h3><?php echo $ShowAllPagesRecords['varShortName']; ?></h3>

                        <!-- Post Meta -->
                        <div class="post-meta">
                            <ul class="post-meta-list clearfix">	
                                <li>Published on  <?php echo date('j', strtotime($ShowAllPagesRecords['dtBlogDate'])); ?><small><?php echo date('S', strtotime($ShowAllPagesRecords['dtBlogDate'])); ?></small> <?php echo date('F, Y', strtotime($ShowAllPagesRecords['dtBlogDate'])); ?> &ensp;/</li>	
                                <li><i>By <span class="theme-color"><?php echo SITE_NAME; ?></span></i></li>
                            </ul>
                        </div>

                        <!-- Post Content -->
                        <div class="post-content">												
                            <?php
                            if ($ShowAllPagesRecords['txtDescription'] != '') {
                                echo $this->mylibrary->Replace_Varible_with_Sitepath($ShowAllPagesRecords['txtDescription']);
                            } else {
                                echo nl2br($ShowAllPagesRecords['varShortDesc']);
                            }
                            ?>
                        </div>
                    </div>								
                </div>	  

                <div>
                    <div class=" col-md-12 p0 mtop50">																	
                        <ul class="footer-socials clearfix">
                            <li class="share">Share with </li>
                            <li><a class="foo_social ico-facebook sobgred" href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="foo_social ico-twitter sobgred" href="#"><i class="fa fa-twitter"></i></a></li>	
                            <li><a class="foo_social ico-google-plus sobgred" href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class=" col-md-12 p0">	
                    <h4><a href="<?php echo SITE_PATH . "blogs"; ?>">Back</a></h4>
                </div>
            </article>	  <!-- END SINGLE IMAGE POST -->
        </div>	<!-- END BLOG POSTS HOLDER -->	


        <!-- SIDEBAR RIGHT         ============================================= -->
        <aside id="sidebar-right" class="col-md-4">
            <!-- Most Popular Posts -->
            <div class="row">							
                <div id="popular-posts-holder"  >	
                    <h4>Most Popular Posts:</h4>
                    <ul class="media-list main-list">
                        <?php
                        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        foreach ($Pages_Records1 as $data) {
                            ?>
                            <li class="media">
                                <a class="" href="<?php echo SITE_PATH . $data['varAlias']; ?>">
                                <!--<a class="pull-left" href="<?php echo SITE_PATH . $data['varAlias']; ?>">-->
                                    <?php
                                    $imagename = $data['varImage'];
                                    $imagepath = 'upimages/blogs/images/' . $imagename;
                                    if (file_exists($imagepath) && $data['varImage'] != '') {
                                        $image_thumb1 = image_thumb($imagepath, BLOGS_WIDTH, BLOGS_HEIGHT);
                                    }
                                    if ($imagename != "") {
                                        if (file_exists($imagepath)) {
                                            ?>   
                                            <img src="<?php echo $image_thumb1; ?>" alt="<?php echo $data['varShortName']; ?>" title="<?php echo $data['varShortName']; ?>" class="media-object">
                                        <?php } else { ?>
                                            <img src="http://placehold.it/<?php echo BLOGS_WIDTH; ?>x<?php echo BLOGS_HEIGHT; ?>" alt="image" class="media-object">                                          
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <img src="http://placehold.it/<?php echo BLOGS_WIDTH; ?>x<?php echo BLOGS_HEIGHT; ?>" alt="image" class="media-object">                                          
                                    <?php } ?>
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading" style="text-shadow:2px 8px 6px rgba(0, 0, 0, 0.1), 0 -5px 35px rgba(255, 255, 255, 0.3);font-size: 20px;"><?php echo $data['varShortName']; ?></h4>
                                    <!--<p class="by-author">By <?php echo SITE_NAME; ?></p>-->
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>								
            </div>		 
        </aside>	 
    </div>	 
</div>