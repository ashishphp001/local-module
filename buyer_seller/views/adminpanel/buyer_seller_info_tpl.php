<div id="page_content">  
    <div id="page_content_inner">
        <div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
            <div class="uk-width-large-7-10">

                <div class="md-card">
                    <div class="user_heading user_heading_bg" style="background-image: url('<?php echo ADMIN_MEDIA_URL; ?>assets/img/gallery/Image10.jpg')">
                        <div class="bg_overlay">
                            <div class="user_heading_menu hidden-print">
                                <div class="uk-display-inline-block"><i class="md-icon md-icon-light material-icons" id="page_print">&#xE8ad;</i></div>
                            </div>
                            <div class="user_heading_avatar">
                                <div class="thumbnail">
                                    <?php
                                    $getProduct = $this->Module_Model->getUserProductDatas($Row['int_id']);
                                    $getBuyLead = $this->Module_Model->getUserBuyLeads($Row['int_id']);

                                    $imagename = $Row['varImage'];
                                    $imagepath = 'upimages/users/images/' . $imagename;

                                    if (file_exists($imagepath) && $Row['varImage'] != '') {
                                        $image_detail_thumb = image_thumb($imagepath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                                        $image_thumb = image_thumb($imagepath, USERS_WIDTH, USERS_HEIGHT);
                                    } else {
                                        $image_thumb = ADMIN_MEDIA_URL . "assets/img/avatars/avatar_03.png";
                                    }
                                    ?>
                                    <img src="<?php echo $image_thumb; ?>" alt="<?php echo $Row['varName']; ?>" title="<?php echo $Row['varName']; ?>"/>
                                </div>
                            </div>
                            <div class="user_heading_content">
                                <h2 class="heading_b uk-margin-bottom"><span class="uk-text-truncate"><?php echo $Row['varName']; ?></span><span class="sub-heading"><?php echo $Row['varCompany']; ?></span></h2>
                                <ul class="user_stats">
                                    <li>
                                        <h4 class="heading_a"><?php echo count($getProduct); ?> <span class="sub-heading">Products</span></h4>
                                    </li>
                                    <li>
                                        <h4 class="heading_a"><?php echo count($getBuyLead); ?> <span class="sub-heading">Buy Leads</span></h4>
                                    </li>
                                    <li>
                                        <h4 class="heading_a">0 <span class="sub-heading">Orders</span></h4>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="user_content">
                        <ul id="user_profile_tabs" class="uk-tab" data-uk-tab="{connect:'#user_profile_tabs_content', animation:'slide-horizontal'}" data-uk-sticky="{ top: 48, media: 960 }">
                            <li class="uk-active"><a href="javascript:;">About</a></li>
                            <li><a href="javascript:;">Company Photos</a></li>
                            <li><a href="javascript:;">Posts</a></li>
                        </ul>
                        <ul id="user_profile_tabs_content" class="uk-switcher uk-margin">
                            <li>
                                <div class="uk-grid uk-margin-medium-top uk-margin-large-bottom" data-uk-grid-margin>
                                    <div class="uk-width-large-1-2">
                                        <h4 class="heading_c uk-margin-small-bottom">Contact Info</h4>
                                        <ul class="md-list md-list-addon">
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <i class="md-list-addon-icon material-icons">&#xE158;</i>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><?php echo $Row['UserEmail']; ?></span>
                                                    <span class="uk-text-small uk-text-muted">Email</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <i class="md-list-addon-icon material-icons">&#xE0CD;</i>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><?php echo $Row['varPhone']; ?></span>
                                                    <span class="uk-text-small uk-text-muted">Phone</span>
                                                </div>
                                            </li>
                                            <?php if ($Row['varLocation'] != '') { ?>
                                                <li>
                                                    <div class="md-list-addon-element">
                                                        <i class="md-list-addon-icon material-icons">location_on</i>
                                                    </div>
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading"><?php echo $Row['varLocation']; ?></span>
                                                        <span class="uk-text-small uk-text-muted">Location</span>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <i class="md-list-addon-icon material-icons">credit_card</i>
                                                </div>
                                                <div class="md-list-content">
                                                    <?php if ($Row['chrPayment'] == 'Y') { ?>
                                                        <span class="md-list-heading"><?php echo $Row['varPlanName']; ?></span>
                                                    <?php } else { ?>
                                                        <span class="md-list-heading">Free User</span>
                                                    <?php } ?>
                                                    <span class="uk-text-small uk-text-muted">Plan</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <i class="md-list-addon-icon material-icons">web</i>
                                                </div>
                                                <div class="md-list-content">
                                                    <?php
                                                    if ($Row['chrPayment'] == 'Y') {
                                                        $subdomain = str_replace("___", $Row['varSubdomain'], SUB_DOMAIN);
                                                        ?>
                                                        <span class="md-list-heading"><a href="<?php echo $subdomain; ?>" target="_blank"><?php echo $subdomain; ?></a></span>
                                                    <?php } else { ?>
                                                        <span class="md-list-heading"><a href="<?php echo SITE_PATH; ?>" target="_blank"><?php echo SITE_PATH; ?></a></span>
                                                    <?php } if ($Row['varWebsite'] != '') { ?>
                                                        <span class="md-list-heading"><a href="<?php echo $Row['varWebsite']; ?>" target="_blank"><?php echo $Row['varWebsite']; ?></a></span>
                                                    <?php } ?>
                                                    <span class="uk-text-small uk-text-muted">Website</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                                <hr>
                                <h4 class="heading_c uk-margin-small-bottom">Company Info</h4>
                                <?php if ($Row['varTelephone'] != '') { ?>
                                    <b> Tel Phone: </b> <?php echo $Row['varTelephone']; ?><br>
                                <?php }if ($Row['varCompanyAdv'] != '') { ?>
                                    <b>Company Advantages: </b> <?php echo nl2br($Row['varCompanyAdv']); ?><br>
                                <?php }if ($Row['varTotalEmployees'] != '') { ?>
                                    <b> Total Employees: </b> <?php echo $Row['varTotalEmployees']; ?><br>
                                <?php }if ($Row['varQCStaff'] != '') { ?>
                                    <b>  QC Staff: </b> <?php echo $Row['varQCStaff']; ?><br>
                                <?php }if ($Row['varRDStaff'] != '') { ?>
                                    <b>  No of R&D Staff: </b> <?php echo $Row['varQCStaff']; ?><br>
                                <?php }if ($Row['varProductionLine'] != '') { ?>
                                    <b>  Production line: </b> <?php echo $Row['varProductionLine']; ?><br>
                                <?php }if ($Row['varCompanyEmail'] != '') { ?>
                                    <b>  Company Email: </b> <?php echo $Row['varCompanyEmail']; ?><br>
                                <?php }if ($Row['varRegistration'] != '') { ?>
                                    <b>  Year Of Registration: </b> <?php echo $Row['varRegistration']; ?><br>
                                <?php }if ($Row['varCompanyPhone'] != '') { ?>
                                    <b>  Company Mobile Number: </b> <?php echo $Row['varCompanyPhone']; ?><br>
                                <?php }if ($Row['varTelephone'] != '') { ?>
                                    <b>  Company Tel Number: </b> <?php echo $Row['varTelephone']; ?><br>
                                <?php }if ($Row['varTotalEmp'] != '') { ?>
                                    <b>  Total No Of Employee: </b> <?php echo $Row['varTotalEmp']; ?><br>
                                <?php }if ($Row['varOwnerType'] != '') { ?>
                                    <b>  Ownership Type: </b> <?php echo $Row['varOwnerType']; ?><br>
                                    <?php
                                }
                                if ($Row['varCurrency'] != '') {
                                    if ($Row['varCurrency'] == '2') {
                                        $currency = "&#x24; (Doller)";
                                    } else {
                                        $currency = "&#x20B9; (Rupee)";
                                    }
                                    ?>
                                    <b>Currency: </b> <?php echo $currency; ?><br>
                                <?php } if ($Row['varAnnualTurnover'] != '') { ?>
                                    <b> Annual Turnover: </b> <?php echo $Row['varAnnualTurnover']; ?><br>
                                <?php }
                                ?>  
                                <hr>
                                <h4 class="heading_c uk-margin-small-bottom">Corporate Office Address</h4>
                                <?php if ($Row['varLocation'] != '') { ?>
                                    <b> Location: </b>  <?php echo $Row['varCLocation']; ?><br>
                                <?php } ?>
                                <hr>
                                <h4 class="heading_c uk-margin-small-bottom">Factory Address</h4>
                                <?php if ($Row['varLocation'] != '') { ?>
                                    <b> Location: </b>  <?php echo $Row['varFLocation']; ?><br>
                                <?php } ?>
                                <hr>
                                <h4 class="heading_c uk-margin-small-bottom">Branch or Franchise Details</h4>
                                <?php if ($Row['varBranchCompanyName'] != '') { ?>
                                    <b> Company Name: </b>  <?php echo $Row['varBranchCompanyName']; ?><br>
                                <?php } if ($Row['varBranchPersonName'] != '') { ?>
                                    <b> Contact Person Name: </b>  <?php echo $Row['varBranchPersonName']; ?><br>
                                <?php } if ($Row['varBranchLocation'] != '') { ?>
                                    <b> Location: </b>  <?php echo $Row['varBranchLocation']; ?><br>
                                <?php } if ($Row['varBranchLocationEmail'] != '') { ?>
                                    <b> Email: </b>  <?php echo $Row['varBranchLocationEmail']; ?><br>
                                <?php } if ($Row['varBranchLocationPhone'] != '') { ?>
                                    <b> Mobile Number: </b>  <?php echo $Row['varBranchLocationPhone']; ?><br>
                                    <?php
                                }
                                if ($Row['varBranchLocationTel'] != '') {
                                    ?>
                                    <b> Telephone Number: </b>  <?php echo $Row['varBranchLocationTel']; ?><br>
                                <?php } if ($Row['DesignationName'] != '') { ?>
                                    <b> Designation: </b>  <?php echo $Row['DesignationName']; ?><br>
                                <?php } ?>
                            </li>
                            <li>
                                <div id="user_profile_gallery" data-uk-check-display class="uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4" data-uk-grid="{gutter: 4}">
                                    <?php
                                    $getCompanyPhoto = $this->Module_Model->getCompanyPhotos($Row['int_id']);
                                    foreach ($getCompanyPhoto as $row) {
                                        $imagenames = $row['varImage'];
                                        $imagepaths = 'upimages/company/companygallery/' . $imagenames;

                                        if (file_exists($imagepaths) && $imagenames != '') {
                                            $image_thumbs = image_thumb($imagepaths, PRODUCTGALLERY_WIDTH, PRODUCTGALLERY_HEIGHT);
                                            ?>
                                            <div>
                                                <a href="<?php echo $image_thumbs; ?>" data-uk-lightbox="{group:'user-photos'}">
                                                    <img style="border: 1px solid #E0E0E0;border-radius: 5px;padding: 3px;" src="<?php echo $image_thumbs; ?>" alt="<?php echo $Row['varCompany']; ?>"/>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                </div>
                            </li>
                            <li>
                                <?php
                                $listdata = array();
                                $listdata = array_merge($getProduct, $getBuyLead);

                                $date = array();
                                foreach ($listdata as $key => $rows) {
                                    $date[$key] = $rows['dtCreateDate'];
                                }
                                array_multisort($date, SORT_DESC, $listdata);
                                ?>
                                <ul class="md-list">
                                    <?php foreach ($listdata as $list) { ?>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading">
                                                    <?php if ($list['type'] == 'product') { ?>
                                                        <a target="_blank" href="<?php echo SITE_PATH . $list['varAlias']; ?>">New Product Added - <?php echo $list['varName']; ?></a>
                                                    <?php } else { ?>
                                                        <a target="_blank" href="<?php echo SITE_PATH . $list['varAlias']; ?>">New Buy Lead Added - <?php echo $list['varName']; ?></a>
                                                    <?php } ?>
                                                </span>
                                                <div class="uk-margin-small-top">
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small"><?php echo date('d M Y', strtotime($list['dtCreateDate'])) ?></span>
                                                    </span>
    <!--                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">9</span>
                                                    </span>-->
                                                    <span class="uk-margin-right">
                                                        <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small"><?php echo ($list['intPageHits'] + $list['intMobileHits']); ?></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="uk-width-large-3-10 hidden-print">
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-margin-medium-bottom">
                            <h3 class="heading_c uk-margin-bottom">Alerts</h3>
                            <ul class="md-list md-list-addon">
                                <li>
                                    <div class="md-list-addon-element">
                                        <i class="md-list-addon-icon material-icons uk-text-warning">&#xE8B2;</i>
                                    </div>
                                    <div class="md-list-content">
                                        <span class="md-list-heading">Eos quia.</span>
                                        <span class="uk-text-small uk-text-muted uk-text-truncate">Suscipit tempora exercitationem et inventore.</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-addon-element">
                                        <i class="md-list-addon-icon material-icons uk-text-success">&#xE88F;</i>
                                    </div>
                                    <div class="md-list-content">
                                        <span class="md-list-heading">Molestiae velit.</span>
                                        <span class="uk-text-small uk-text-muted uk-text-truncate">Recusandae consequatur optio aliquid facere.</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-addon-element">
                                        <i class="md-list-addon-icon material-icons uk-text-danger">&#xE001;</i>
                                    </div>
                                    <div class="md-list-content">
                                        <span class="md-list-heading">Ab enim aperiam.</span>
                                        <span class="uk-text-small uk-text-muted uk-text-truncate">Et odit quasi quas consequatur magni.</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="heading_c uk-margin-bottom">Friends</h3>
                        <ul class="md-list md-list-addon uk-margin-bottom">
                            <li>
                                <div class="md-list-addon-element">
                                    <img class="md-user-image md-list-addon-avatar" src="<?php echo ADMIN_MEDIA_URL; ?>assets/img/avatars/avatar_02_tn.png" alt=""/>
                                </div>
                                <div class="md-list-content">
                                    <span class="md-list-heading">Misty Price</span>
                                    <span class="uk-text-small uk-text-muted">Molestias voluptatibus voluptas earum sed.</span>
                                </div>
                            </li>
                            <li>
                                <div class="md-list-addon-element">
                                    <img class="md-user-image md-list-addon-avatar" src="<?php echo ADMIN_MEDIA_URL; ?>assets/img/avatars/avatar_07_tn.png" alt=""/>
                                </div>
                                <div class="md-list-content">
                                    <span class="md-list-heading">Thora Littel</span>
                                    <span class="uk-text-small uk-text-muted">Consequatur vero facilis alias et.</span>
                                </div>
                            </li>
                            <li>
                                <div class="md-list-addon-element">
                                    <img class="md-user-image md-list-addon-avatar" src="<?php echo ADMIN_MEDIA_URL; ?>assets/img/avatars/avatar_06_tn.png" alt=""/>
                                </div>
                                <div class="md-list-content">
                                    <span class="md-list-heading">Lennie Kling</span>
                                    <span class="uk-text-small uk-text-muted">Libero magnam consequatur nesciunt quas.</span>
                                </div>
                            </li>
                        </ul>
                        <a class="md-btn md-btn-flat md-btn-flat-primary" href="#">Show all</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>