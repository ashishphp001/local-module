<main class="page-content">
    <!-- Section single project type 2-->
    <section class="section-top-50 section-sm-top-110 section-bottom-34">
        <div class="shell">
            <h2 class="text-bold"><?php echo $ShowAllPagesRecords['varShortDesc']; ?></h2>
            <hr class="divider bg-mantis">
            <div class="offset-sm-top-66">
                <div class="range">
                    <?php
                    $getPhotoGallery = $this->Module_Model->getPhotoGallery(RECORD_ID);
                    if (count($getPhotoGallery) > 0) {
                        ?>
                        <div class="cell-md-7 cell-lg-7">
                            <!-- Owl Carousel-->
                            <div class="owl-carousel owl-carousel-classic" data-items="1" data-dots="true" data-nav="true" data-nav-class="[&quot;owl-prev mdi mdi-chevron-left&quot;, &quot;owl-next mdi mdi-chevron-right&quot;]" data-photo-swipe-gallery>
                                <?php
                                foreach ($getPhotoGallery as $photo) {
                                    $imagename = $photo['varImage'];
                                    $imagepath = 'upimages/photogallery/images/' . $imagename;

                                    if (file_exists($imagepath) && $photo['varImage'] != '') {
                                        $image_thumb = image_thumb($imagepath, PHOTOGALLERY_WIDTH, PHOTOGALLERY_HEIGHT);
                                    }
                                    ?>
                                                                                                                                                                                    <!--                                <a class="thumbnail-classic" data-photo-swipe-item="" data-size="716x404" href="<?php echo FRONT_MEDIA_URL; ?>images/portfolio/portfolio-single-03-716x404.jpg">
                                                                                                                                                                                                                <figure><img width="716" height="404" src="<?php echo FRONT_MEDIA_URL; ?>images/portfolio/portfolio-single-03-716x404.jpg" alt="">
                                                                                                                                                                                                                </figure>
                                                                                                                                                                                                                </a>-->
                                    <a class="thumbnail-classic" data-photo-swipe-item="" data-size="716x404" href="<?php echo SITE_PATH . 'upimages/photogallery/images/' . $imagename; ?>">
                                        <figure>
                                            <img width="716" height="404" src="<?php echo $image_thumb; ?>" alt="<?php echo $photo['varName']; ?>" title="<?php echo $photo['varName']; ?>">
                                        </figure>
                                    </a>
                                <?php } ?>
                            </div>


                        </div>

                        <?php
                    }
                    $title = explode("__", $ShowAllPagesRecords['varSTitle']);
                    $totals = count($title);
//                    echo $totals[0];
//                    if ($ShowAllPagesRecords['varSTitle'] != '' || $ShowAllPagesRecords['varWebsiteName']!='') {
                    ?>
                    <div class="cell-md-4 cell-lg-5 text-md-left inset-md-left-30 offset-top-66 offset-sm-top-0">
                        <div class="range">
                            <div>
                                <!-- Bootstrap Table-->
                                <?php // if ($totals[0]!='') { ?>
                                <div class="table-responsive clearfix">
                                    <table class="table table-striped">
                                        <?php if ($title[0] != '') { ?>
                                            <tr>
                                                <th>Project Details</th>
                                                <th></th>
                                            </tr>
                                            <?php
                                            $ans = explode("__", $ShowAllPagesRecords['varSvalue']);
//                                        $title=
                                            for ($i = 0; $i <= $totals; $i++) {
                                                ?>
                                                <tr>
                                                    <th><?php echo $title[$i]; ?></th>
                                                    <td><?php echo $ans[$i]; ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        if ($ShowAllPagesRecords['varWebsiteName'] != '') {
                                            ?>
                                            <tr>
                                                <th>Website</th>
                                                <td><a href="<?php echo $ShowAllPagesRecords['varWebsiteName']; ?>" target="_blank"><?php echo $ShowAllPagesRecords['varWebsiteName']; ?></a></td>
                                            </tr>
                                        <?php }
                                        ?>

                                    </table>
                                    <center>
                                        <div>
                                            <?php if ($ShowAllPagesRecords['varAndroidName'] != '') { ?>
                                                <a href="https://<?php echo $ShowAllPagesRecords['varAndroidName']; ?>" target="_blank"><img style="width:50%;margin-left:-5px;" src="<?php echo FRONT_MEDIA_URL . "images/playstore.png"; ?>"></a>
                                            <?php } if ($ShowAllPagesRecords['varIOSName'] != '') { ?>
                                                <a href="https://<?php echo $ShowAllPagesRecords['varIOSName']; ?>" target="_blank"><img style="width:45%" src="<?php echo FRONT_MEDIA_URL . "images/appstore.png"; ?>"></a>
                                            <?php } ?>    

                                        </div>
                                    </center>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php // }  ?>
                    <div class="cell-md-12 cell-lg-12">
                        <div class="text-sm-left offset-top-50">
                            <h5 class="text-bold"><?php echo $ShowAllPagesRecords['varShortName']; ?></h5>
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
            </div>
        </div>
    </section>
    <!-- section related project-->
    <?php
    $Pages_Records = $this->Module_Model->SelectAll_detail_front_id(RECORD_ID, $ShowAllPagesRecords['intProject']);
    if (count($Pages_Records) > 0) {
        ?>
        <section class="context-dark" style="margin-bottom:20px;" id="contexts">
            <h1 style="color:#434345">Related Projects</h1>
            <hr class="divider bg-mantis">
            <div class="owl-carousel owl-carousel-default owl-carousel-arrows owl-carousel-arrows-fullwidth veil-xl-owl-dots veil-owl-nav reveal-xl-owl-nav" data-items="1" data-md-items="2" data-lg-items="4" data-nav="true" data-dots="true" data-nav-class="[&quot;owl-prev mdi mdi-chevron-left&quot;, &quot;owl-next mdi mdi-chevron-right&quot;]">


                <?php
                foreach ($Pages_Records as $rel_pro) {
                    $imagename = $rel_pro['varImage'];
                    $imagepath = 'upimages/projects/images/' . $imagename;

                    if (file_exists($imagepath) && $rel_pro['varImage'] != '') {
                        $image_thumb1 = image_thumb($imagepath, PROJECTS_WIDTH, PROJECTS_HEIGHT);
                    }
                    ?>
                    <div>
                        <div class="range range-xs-center">
                            <div class="cell-xs-8 cell-sm-6 cell-md-12">
                                <!-- Thumbnail Terry-->
                                <figure class="thumbnail-terry thumbnail-border-none"><a href="<?php echo $rel_pro['varAlias']; ?>"><img width="480" height="480" src="<?php echo $image_thumb1; ?>" alt="<?php echo $rel_pro['varShortName']; ?>" title="<?php echo $rel_pro['varShortName']; ?>"/></a>
                                    <figcaption>
                                        <div>
                                            <h4 class="thumbnail-terry-title"><?php echo $rel_pro['varShortName']; ?></h4>
                                        </div>
                                        <p class="thumbnail-terry-desc offset-top-0"></p>
                                        <a class="btn offset-top-10 offset-md-top-0 btn-primary" href="<?php echo $rel_pro['varAlias']; ?>">view Project</a>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    </div>


                    <!--                    <div class="cell-xs-10 cell-sm-6 cell-md-3">
                                            <a class="thumbnail-classic" href="<?php echo SITE_PATH . $rel_pro['varAlias']; ?>" title="<?php echo $rel_pro['varShortName']; ?>" alt="<?php echo $rel_pro['varShortName']; ?>">
                                                <figure><img width="370" height="278" src="<?php echo $image_thumb1; ?>" alt="<?php echo $rel_pro['varShortName']; ?>" title="<?php echo $rel_pro['varShortName']; ?>">
                                                </figure>
                                            </a>
                                            <div>
                                                <h6 class="offset-top-24"><a href="<?php echo SITE_PATH . $row['varAlias']; ?>"><?php echo $rel_pro['varShortName']; ?></a></h6>
                                            </div>
                                        </div>-->
                <?php } ?>
            </div>
        </section>
    <?php } ?>
</main>