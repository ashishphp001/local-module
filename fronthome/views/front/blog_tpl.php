
<?php
$login_user_session = $this->session->userdata(PREFIX);
print_R($login_user_session);
?>
<section class="company-titel-mini" style="background-image: url(<?php echo FRONT_MEDIA_URL; ?>images/listing-image.jpg);">
    <div class="container">
        <div class="row">
            <div class="company-info-mini">
                <h5>Blog</h5>
            </div>
            <div id="breadcum-spot">  

                <ul>

                    <li class="active waves-effect waves-light btn">Blog</li>

                    <li><a href="<?php echo SITE_PATH; ?>" class="waves-effect waves-light btn"><i class="fa fa-home"></i></a></li>

                </ul>

            </div>
        </div>
    </div>
</section>
<section class="blog-list-view">
    <div class="row glog-list-over">
        <div class="col s12 m12">
            <?php
            $i = 1;
            foreach ($ShowAllPagesRecords as $row) {
                ?>

                <div class="col s12 m6 l4">
                    <!-- Post Boxed-->
                    <?php
                    $subdomain = str_replace("___", "blog", SUB_DOMAIN) . "/" . $row['varAlias'];
                    ?>
                    <a class="reveal-block" target="_blank" href="<?php echo $subdomain; ?>">
                        <div class="post post-boxed">
                            <!-- Post media-->
                            <?php
                            $imagename = $row['varImage'];
                            $imagepath = 'upimages/blogs/images/' . $imagename;
                            if (file_exists($imagepath) && $row['varImage'] != '') {
                                $image_thumb1 = image_thumb($imagepath, BLOGS_WIDTH, BLOGS_HEIGHT);
                            }
                            if ($imagename != "") {
                                if (file_exists($imagepath)) {
                                    $image = $image_thumb1;
                                } else {
                                    $image = FRONT_MEDIA_URL . "images/images/no_img/no_image_408_250.jpg";
                                }
                            } else {
                                $image = FRONT_MEDIA_URL . "images/images/no_img/no_image_408_250.jpg";
                            }
                            ?>
                            <div class="post-media">
                                <img class="img-responsive" width="570" height="321" src="<?php echo $image; ?>" alt="<?php echo $row['varTitle']; ?>" title="<?php echo $row['varTitle']; ?>">
                            </div>
                            <!-- Post content-->
                            <section class="post-content text-left">
                                <div class="post-tags group-xs">
                                    <?php
                                    $type = $row['varType'];
                                    $atype = explode(",", $type);
                                    foreach ($atype as $bg) {
                                        ?>
                                        <span class="label-custom label-lg-custom label-primary"><?php echo $bg; ?></span>
                                    <?php } ?>
                                </div>
                                <div class="post-body">
                                    <!-- Post Title-->
                                    <div class="post-title">
                                        <h5><?php echo $row['varTitle']; ?></h5>
                                    </div>
                                    <div class="post-meta small">
                                        <ul class="list-inline list-inline-sm p">
                                            <li class="text-italic text-middle">by&nbsp;
                                                <span class="text-picton-blue"><?php echo $row['varAuthor']; ?></span>
                                            </li>
                                            <li>
                                                <span class="text-middle icon-xxs mdi mdi-clock far fa-clock"></span>
                                                <time class="text-italic text-middle text-picton-blue" datetime="<?php echo $row['dtBlogDate']; ?>"><?php
                                                    $blogdate = $this->module_model->time_ago($row['dtBlogDate']);
                                                    echo $blogdate;
                                                    ?></time>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </a>
                </div>
                <?php
            }
            ?>

        </div>	

    </div>
</section>
