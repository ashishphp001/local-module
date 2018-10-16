<div class="register-main site-map-change contact-us-indi" style="background: url(<?php echo FRONT_MEDIA_URL; ?>images/site-map.jpg) repeat-x scroll center top #fff !important;">
    <div class="container">
        <div class="row">
            <div class="parent-register"><h1>Site Map</h1></div>
            <div class="contact-start-all card">
                <div class="site-map-content">
                    <?php echo $SiteMapData; ?>
                    <?php // echo $BlogSiteMapData; ?>
                </div>
                <div class="col s12 footer-social">
                    <ul class="list-inline">
                        <?php if (FACEBOOK_LINK != '') { ?>
                            <li>
                                <a class="icon fab fa-facebook-f icon-xxs icon-circle icon-darkest-filled waves-effect waves-light btn" target="_blank" href="<?php echo FACEBOOK_LINK; ?>"></a>
                            </li>
                        <?php } if (TWITTER_LINK != '') { ?>
                            <li>
                                <a class="icon fab fa-twitter icon-xxs icon-circle icon-darkest-filled waves-effect waves-light btn" target="_blank" href="<?php echo TWITTER_LINK; ?>"></a>
                            </li>
                        <?php } if (GOOGLE_PLUS_LINK != '') { ?>
                            <li>
                                <a class="icon fab fa-google-plus-g icon-xxs icon-circle icon-darkest-filled waves-effect waves-light btn" target="_blank" href="<?php echo GOOGLE_PLUS_LINK; ?>"></a>
                            </li>
                        <?php } if (LINKEDIN_LINK != '') { ?>
                            <li>
                                <a class="icon fab fa-linkedin-in icon-xxs icon-circle icon-darkest-filled waves-effect waves-light btn" target="_blank" href="<?php echo LINKEDIN_LINK; ?>"></a>
                            </li>
                        <?php } if (INSTAGRAM_LINK != '') { ?>
                            <li>
                                <a class="icon fab fa-instagram icon-xxs icon-circle icon-darkest-filled waves-effect waves-light btn" target="_blank" href="<?php echo INSTAGRAM_LINK; ?>"></a>
                            </li>
                        <?php } if (GITHUB_LINK != '') { ?>
                            <li>
                                <a class="icon fab fa-github icon-xxs icon-circle icon-darkest-filled waves-effect waves-light btn" target="_blank" href="<?php echo GITHUB_LINK; ?>"></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>