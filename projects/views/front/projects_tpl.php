<main class="page-content">
    <!-- Portfolio fullwidth 4 columns-->
    <section class="section-top-50 section-sm-top-10">
        <div class="offset-top-50">
            <div class="isotope-wrap">
                <div class="row">
                    <!-- Isotope Filters-->
                    <div class="col-lg-12">
                        <div class="isotope-filters isotope-filters-horizontal">
                            <ul class="list-inline list-inline-sm">
                                <li class="veil-md">
                                    <p>Choose your category:</p>
                                </li>
                                <li class="section-relative">
                                    <button class="isotope-filters-toggle btn btn-sm btn-default" data-custom-toggle="isotope-1" data-custom-toggle-disable-on-blur="true">Filter<span class="caret"></span></button>
                                    <ul class="list-sm-inline isotope-filters-list" id="isotope-1">
                                        <li><a class="text-bold active" data-isotope-filter="*" data-isotope-group="gallery" href="#">All</a></li>
                                        <?php
                                        $type = array("App", "Web", "Game");
                                        foreach ($type as $row) {
                                            echo '<li><a class="text-bold" data-isotope-filter="' . $row . '" data-isotope-group="gallery" href="#">' . $row . '</a></li>';
                                        }
                                        ?>
                                        <!--                                        <li><a class="text-bold" data-isotope-filter="Clients" data-isotope-group="gallery" href="#">Clients</a></li>
                                                                                <li><a class="text-bold" data-isotope-filter="Business" data-isotope-group="gallery" href="#">Business</a></li>
                                                                                <li><a class="text-bold" data-isotope-filter="Happiness" data-isotope-group="gallery" href="#">Happiness</a></li>-->
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Isotope Content-->
                    <div class="col-lg-12 offset-top-34">
                        <div class="isotope" data-isotope-layout="fitRows" data-isotope-group="gallery">
                            <div class="offset-top-30 row row-condensed" data-photo-swipe-gallery="gallery">
                                <?php
                                foreach ($ShowAllPagesRecords as $row) {
                                    $imagename = $row['varImage'];
                                    $imagepath = 'upimages/projects/images/' . $imagename;

                                    if (file_exists($imagepath) && $row['varImage'] != '') {
                                        $image_thumb = image_thumb($imagepath, PROJECTS_WIDTH, PROJECTS_HEIGHT);
                                    }
                                    ?>
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 isotope-item" data-filter="<?php echo $row['intProject']; ?>">
                                        <!-- Thumbnail Zoe-->
                                        <figure class="thumbnail-zoe">
                                            <a href="<?php echo SITE_PATH . $row['varAlias']; ?>">
                                                <img width="570" height="420" src="<?php echo $image_thumb; ?>" alt="<?php echo $row['varShortName']; ?>" title="<?php echo $row['varShortName']; ?>"></a>
                                            <figcaption class="text-left">
                                                <h5 class="thumbnail-zoe-title veil reveal-lg-block offset-top-20"><?php echo $row['varShortName']; ?></h5>
                                            </figcaption>
                                        </figure>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>