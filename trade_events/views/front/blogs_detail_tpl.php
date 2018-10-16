<script language="javascript">
    function fbshareCurrentPage()
    {
        window.open("https://www.facebook.com/sharer/sharer.php?u=" + escape(window.location.href), '',
                'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
        return false;
    }
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>
<style>
    i.fa.fa-quote-left {
        font-size: 20px;
        color: #0189FF;
        margin-right: 10px;
    }
    i.fa.fa-quote-right {
        font-size: 20px;
        color: #0189FF;
        margin-right: 10px;
    }

</style>
<main class="page-content section-98 section-sm-110">
    <div class="shell">
        <div class="range range-xs-center">
            <div class="cell-lg-8">
                <!-- Blog Default Single-->
                <section>
                    <!-- Post Wide-->
                    <article class="post post-default text-left">
                        <!-- Post Header-->
                        <div class="header post-header">
                            <!-- Post Meta-->
                            <ul class="post-controls list-inline list-inline-sm p text-dark">
                                <li><span class="text-middle icon-xxs text-picton-blue mdi mdi-clock"></span>
                                    <time class="text-middle small" datetime="<?php echo date('j', strtotime($ShowAllPagesRecords['dtBlogDate'])); ?><small><?php echo date('S', strtotime($ShowAllPagesRecords['dtBlogDate'])); ?></small> <?php echo date('F, Y', strtotime($ShowAllPagesRecords['dtBlogDate'])); ?>-01"><?php echo date('j', strtotime($ShowAllPagesRecords['dtBlogDate'])); ?><small><?php echo date('S', strtotime($ShowAllPagesRecords['dtBlogDate'])); ?></small> <?php echo date('F, Y', strtotime($ShowAllPagesRecords['dtBlogDate'])); ?></time>
                                </li>
                                <li><span class="text-middle icon-xxs text-picton-blue mdi mdi-account-outline">&nbsp;</span><span class="text-middle small"><?php echo $ShowAllPagesRecords['varAuthor']; ?></span></li>
                                <li><span class="text-middle icon-xxs text-picton-blue mdi mdi-folder-outline">&nbsp;</span>
                                    <?php echo str_replace(",", ", ", $ShowAllPagesRecords['varType']); ?>
                                </li>
                            </ul>
                            <!-- Post Meta-->
                            <h3 class="post-title"><a href="javascript:;"><?php echo $ShowAllPagesRecords['varShortName']; ?></a></h3>
                            <!-- Post Media-->
                            <div class="post-media offset-top-34">
                                <header class="post-media">
                                    <div data-photo-swipe="gallery"><a class="thumbnail-classic" href="#" target="_self">

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
                                            <figure><img width="570" height="321" src="<?php echo $image; ?>" alt="" style="text-shadow:2px 8px 6px rgba(0, 0, 0, 0.1), 0 -5px 35px rgba(255, 255, 255, 0.3);">
                                            </figure></a>
                                    </div>
                                </header>
                            </div>
                        </div>
                        <div class="offset-top-30 text-center">
                            <p>
                                <i class="fa fa-quote-left" aria-hidden="true"></i>
                                <span class="text-italic h3 text-bold"><?php echo $ShowAllPagesRecords['varShortDesc']; ?></span>
                                <i class="fa fa-quote-right" aria-hidden="true"></i>
                            </p>
                        </div>
                        <section class="post-content offset-top-41">
                            <?php
                            if ($ShowAllPagesRecords['txtDescription'] != '') {
                                echo $this->mylibrary->Replace_Varible_with_Sitepath($ShowAllPagesRecords['txtDescription']);
                            }
                            ?> 
                        </section>
                    </article>
                    <footer class="offset-top-50 text-sm-left clearfix">
                        <div class="group">
                            <?php
                            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                            ?> 
                            <!--<a class="btn btn-danger btn-icon btn-icon-left" href="#"><span class="icon icon-xs mdi mdi-heart"></span>like <span class="badge">521</span></a>-->
                            <a style="background-color:#4867AA !important;border-color: #4867AA;" class="btn btn-sapphire btn-icon btn-icon-left"  href="javascript:;" onclick='return fbshareCurrentPage();'><span class="icon icon-xs mdi mdi-facebook"></span>Share on facebook</a>
                            <a class="btn btn-info btn-icon btn-icon-left" target="_blank" href="http://twitter.com/share?text=<?php echo $ShowAllPagesRecords['varShortName']; ?>&url=<?php echo $actual_link; ?>"><span class="icon icon-xs mdi mdi-twitter"></span>Share on Twitter</a>
                            <a class="btn btn-danger btn-icon btn-icon-left" target="_blank" href="https://plus.google.com/share?text=<?php echo $ShowAllPagesRecords['varShortName']; ?>&url=<?php echo $actual_link; ?>"><span class="icon icon-xs mdi mdi-google-plus"></span>Share on Google Plus</a>
                        </div>
                    </footer>
                    <hr class="offset-top-66">
                    <h4 class="offset-top-66 text-uppercase text-spacing-120 text-left text-bold">Related Posts</h4>
                    <div class="range offset-top-41">
                        <div class="cell-md-12">
                            <!-- Post Widget-->
                            <?php
                            $i = 1;
                            foreach ($Pages_Records1 as $bg) {
                                ?>
                                <?php
                                $imagename = $bg['varImage'];
                                $imagepath = 'upimages/blogs/images/' . $imagename;
                                if (file_exists($imagepath) && $bg['varImage'] != '') {
                                    $image_thumb1 = image_thumb($imagepath, 60, 60);
                                }
                                if ($imagename != "") {
                                    if (file_exists($imagepath)) {
                                        $image = $image_thumb1;
                                    } else {
                                        $image = FRONT_MEDIA_URL . "images/users/user-john-doe-60x60.jpg";
                                    }
                                } else {
                                    $image = FRONT_MEDIA_URL . "images/users/user-john-doe-60x60.jpg";
                                }
                                if ($i % 2 == 0) {
                                    $class = "right";
                                } else {
                                    $class = "left";
                                }
                                ?>
                                <div class="cell-md-6">

                                    <article class="post widget-post text-<?php echo $class; ?>">
                                        <a href="<?php echo SITE_PATH . $bg['varAlias']; ?>">
                                            <div class="unit unit-horizontal unit-spacing-xs unit-middle">
                                                <div class="unit-left"><img class="img-circle" width="60" height="60" src="<?php echo $image; ?>" alt="<?php echo $bg['varShortName']; ?>" title="<?php echo $bg['varShortName']; ?>"></div>
                                                <div class="unit-body">
                                                    <div class="post-meta"><span class="icon-xxs mdi mdi-arrow-right text-picton-blue"></span>
                                                        <time class="text-dark" datetime="<?php echo $bg['dtBlogDate']; ?>"><?php echo $bg['dtBlogDate']; ?></time>
                                                    </div>
                                                    <div class="post-title">
                                                        <h6 class="text-regular"><?php echo $bg['varShortName']; ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </article>
                                </div>

                                <?php
                                $i++;
                            }
                            ?>
                            <!--                            <div class="offset-top-24">
                                                             Post Widget
                                                            <article class="post widget-post text-left"><a href="blog-classic-single-post.html">
                                                                    <div class="unit unit-horizontal unit-spacing-xs unit-middle">
                                                                        <div class="unit-left"><img class="img-circle" width="60" height="60" src="<?php echo FRONT_MEDIA_URL; ?>images/users/user-bernard-show-60x60.jpg" alt=""></div>
                                                                        <div class="unit-body">
                                                                            <div class="post-meta"><span class="icon-xxs mdi mdi-arrow-right text-picton-blue"></span>
                                                                                <time class="text-dark" datetime="2016-01-01">05/18/2015</time>
                                                                            </div>
                                                                            <div class="post-title">
                                                                                <h6 class="text-regular">Proper Color Solutions For The Office</h6>
                                                                            </div>
                                                                        </div>
                                                                    </div></a></article>
                                                        </div>-->
                        </div>
                        <!--                        <div class="cell-sm-6 offset-top-24 offset-sm-top-0">
                                                     Post Widget
                                                    <article class="post widget-post text-left"><a href="blog-classic-single-post.html">
                                                            <div class="unit unit-horizontal unit-spacing-xs unit-middle">
                                                                <div class="unit-left"><img class="img-circle" width="60" height="60" src="<?php echo FRONT_MEDIA_URL; ?>images/users/user-sam-cole-60x60.jpg" alt=""></div>
                                                                <div class="unit-body">
                                                                    <div class="post-meta"><span class="icon-xxs mdi mdi-arrow-right text-picton-blue"></span>
                                                                        <time class="text-dark" datetime="2016-01-01">05/9/2015</time>
                                                                    </div>
                                                                    <div class="post-title">
                                                                        <h6 class="text-regular">Going Green Is So Much Simpler Than Most People Think</h6>
                                                                    </div>
                                                                </div>
                                                            </div></a></article>
                                                    <div class="offset-top-24">
                                                         Post Widget
                                                        <article class="post widget-post text-left"><a href="blog-classic-single-post.html">
                                                                <div class="unit unit-horizontal unit-spacing-xs unit-middle">
                                                                    <div class="unit-left"><img class="img-circle" width="60" height="60" src="<?php echo FRONT_MEDIA_URL; ?>images/users/user-july-mao-60x60.jpg" alt=""></div>
                                                                    <div class="unit-body">
                                                                        <div class="post-meta"><span class="icon-xxs mdi mdi-arrow-right text-picton-blue"></span>
                                                                            <time class="text-dark" datetime="2016-01-01">05/21/2015</time>
                                                                        </div>
                                                                        <div class="post-title">
                                                                            <h6 class="text-regular">Let's Change the world</h6>
                                                                        </div>
                                                                    </div>
                                                                </div></a></article>
                                                    </div>
                                                </div>-->
                    </div>
                    <hr class="offset-top-66">
                </section>
            </div>
        </div>
    </div>
</main>
