<section class="Middle-Section">    <div class="container">        <div class="row">            <div class="clearfix"></div>            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cms">                <div class="Detail-Image">                    <div class="Detail-Imase-Center">                        <span class="Center-Det">                            <?php                            $imagename = $ShowAllPagesRecords['varImage'];                            $imagepath = 'upimages/blog/' . $imagename;                            if ($imagename != '' && file_exists($imagepath)) {                                $Image = image_thumb($imagepath, BLOGALBUM_WIDTH, BLOGALBUM_HEIGHT);                            } else {                                $Image = FRONT_MEDIA_URL . "Themes/ThemeDefault/images/No-images/home-services-no-images-700X700.jpg";                            }                            ?>                            <img src="<?php echo $Image; ?>" alt="Shop-Images">                        </span>                        <?php if($ShowAllPagesRecords["dtStartDate"] != ''){ ?>                        <div class="Blog-Date"><div class="date-bot"><span><?php echo date("d", strtotime($ShowAllPagesRecords["dtStartDate"])); ?></span><?php echo date("M", strtotime($ShowAllPagesRecords["dtStartDate"])); ?><br><?php echo date("Y", strtotime($ShowAllPagesRecords["dtStartDate"])); ?></div></div>                        <?php } ?>                    </div>                </div>                <?php                if ($ShowAllPagesRecords['txtDescription'] != '') {                    echo $this->mylibrary->Replace_Varible_with_Sitepath($ShowAllPagesRecords['txtDescription']);                } else {                    echo nl2br("<p>" . $ShowAllPagesRecords['varShortDesc'] . "<p>");                }                ?>            </div>        </div>    </div></section>