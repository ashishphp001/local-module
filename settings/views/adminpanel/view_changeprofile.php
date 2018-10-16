<div id="page_content">
    <div id="page_content_inner">
        <div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
            <div class="uk-width-large-7-10">
                <div class="md-card">
                    <div class="user_heading">
                        <div class="user_heading_menu hidden-print">
                            <div class="uk-display-inline-block" data-uk-dropdown="{pos:'left-top'}">
<!--                                <i class="md-icon material-icons md-icon-light">&#xE5D4;</i>
                                <div class="uk-dropdown uk-dropdown-small">
                                    <ul class="uk-nav">
                                        <li><a href="#">Action 1</a></li>
                                        <li><a href="#">Action 2</a></li>
                                    </ul>
                                </div>-->
                            </div>
                            <div class="uk-display-inline-block"><i class="md-icon md-icon-light material-icons" id="page_print">&#xE8ad;</i></div>
                        </div>
                        <div class="user_heading_avatar">
                            <div class="thumbnail">
                                 
                                <img src="<?php echo ADMIN_MEDIA_URL; ?>assets/img/avatars/avatar_11.png" alt="user avatar"/>
                            </div>
                        </div>
                        <div class="user_heading_content">
                            <h2 class="heading_b uk-margin-bottom"><span class="uk-text-truncate"><?php echo $ProfileData->varName; ?></span>
                                <span class="sub-heading">Land acquisition specialist</span>
                            </h2>
                            <ul class="user_stats">
                                <li>
                                    <h4 class="heading_a">2391 <span class="sub-heading">Posts</span></h4>
                                </li>
                                <li>
                                    <h4 class="heading_a">120 <span class="sub-heading">Photos</span></h4>
                                </li>
                                <li>
                                    <h4 class="heading_a">284 <span class="sub-heading">Following</span></h4>
                                </li>
                            </ul>
                        </div>
                        <a class="md-fab md-fab-small md-fab-accent hidden-print" href="page_user_edit.html">
                            <i class="material-icons">&#xE150;</i>
                        </a>
                    </div>
                    <div class="user_content">
                        <ul id="user_profile_tabs" class="uk-tab" data-uk-tab="{connect:'#user_profile_tabs_content', animation:'slide-horizontal'}" data-uk-sticky="{ top: 48, media: 960 }">
                            <li class="uk-active"><a href="#">About</a></li>
                            <li><a href="#">Posts</a></li>
                        </ul>
                        <ul id="user_profile_tabs_content" class="uk-switcher uk-margin">
                            <li>
                                <?php echo $ProfileData->txtDescription; ?>
                                <div class="uk-grid uk-margin-medium-top uk-margin-large-bottom" data-uk-grid-margin>
                                    <div class="uk-width-large-1-2">
                                        <h4 class="heading_c uk-margin-small-bottom">Contact Info</h4>
                                        <ul class="md-list md-list-addon">
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <i class="md-list-addon-icon material-icons">&#xE158;</i>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading">cletus17@ryanberge.com</span>
                                                    <span class="uk-text-small uk-text-muted">Email</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <i class="md-list-addon-icon material-icons">&#xE0CD;</i>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading">036.009.8795</span>
                                                    <span class="uk-text-small uk-text-muted">Phone</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <i class="md-list-addon-icon uk-icon-facebook-official"></i>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading">facebook.com/envato</span>
                                                    <span class="uk-text-small uk-text-muted">Facebook</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <i class="md-list-addon-icon uk-icon-twitter"></i>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading">twitter.com/envato</span>
                                                    <span class="uk-text-small uk-text-muted">Twitter</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="uk-width-large-1-2">
                                        <h4 class="heading_c uk-margin-small-bottom">My groups</h4>
                                        <ul class="md-list">
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Cloud Computing</a></span>
                                                    <span class="uk-text-small uk-text-muted">104 Members</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Account Manager Group</a></span>
                                                    <span class="uk-text-small uk-text-muted">229 Members</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">Digital Marketing</a></span>
                                                    <span class="uk-text-small uk-text-muted">35 Members</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="#">HR Professionals Association - Human Resources</a></span>
                                                    <span class="uk-text-small uk-text-muted">262 Members</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <h4 class="heading_c uk-margin-bottom">Timeline</h4>
                                <div class="timeline">
                                    <div class="timeline_item">
                                        <div class="timeline_icon timeline_icon_success"><i class="material-icons">&#xE85D;</i></div>
                                        <div class="timeline_date">
                                            09 <span>Jan</span>
                                        </div>
                                        <div class="timeline_content">Created ticket <a href="#"><strong>#3289</strong></a></div>
                                    </div>
                                    <div class="timeline_item">
                                        <div class="timeline_icon timeline_icon_danger"><i class="material-icons">&#xE5CD;</i></div>
                                        <div class="timeline_date">
                                            15 <span>Jan</span>
                                        </div>
                                        <div class="timeline_content">Deleted post <a href="#"><strong>Deleniti aut est corporis voluptatem rerum.</strong></a></div>
                                    </div>
                                    <div class="timeline_item">
                                        <div class="timeline_icon"><i class="material-icons">&#xE410;</i></div>
                                        <div class="timeline_date">
                                            19 <span>Jan</span>
                                        </div>
                                        <div class="timeline_content">
                                            Added photo
                                            <div class="timeline_content_addon">
                                                <img src="<?php echo ADMIN_MEDIA_URL; ?>assets/img/gallery/Image16.jpg" alt=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="timeline_item">
                                        <div class="timeline_icon timeline_icon_primary"><i class="material-icons">&#xE0B9;</i></div>
                                        <div class="timeline_date">
                                            21 <span>Jan</span>
                                        </div>
                                        <div class="timeline_content">
                                            New comment on post <a href="#"><strong>Aperiam aperiam repellendus.</strong></a>
                                            <div class="timeline_content_addon">
                                                <blockquote>
                                                    Repellat et consectetur nam placeat repellendus impedit magni qui itaque nemo optio qui voluptas expedita sapiente reiciendis.&hellip;
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="timeline_item">
                                        <div class="timeline_icon timeline_icon_warning"><i class="material-icons">&#xE7FE;</i></div>
                                        <div class="timeline_date">
                                            29 <span>Jan</span>
                                        </div>
                                        <div class="timeline_content">
                                            Added to Friends
                                            <div class="timeline_content_addon">
                                                <ul class="md-list md-list-addon">
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <img class="md-user-image md-list-addon-avatar" src="<?php echo ADMIN_MEDIA_URL; ?>assets/img/avatars/avatar_02_tn.png" alt=""/>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading">Estella Corwin</span>
                                                            <span class="uk-text-small uk-text-muted">Commodi autem cum nulla.</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <ul class="md-list">
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Eum impedit maxime commodi nemo.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">28 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">9</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">191</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Et ipsam ducimus vero delectus.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">06 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">10</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">780</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Iure sapiente eos nemo voluptatem sed pariatur.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">28 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">17</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">868</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Sapiente cum officia quis.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">20 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">14</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">725</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Voluptas ut aut aut nihil et nostrum.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">09 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">20</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">265</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Id modi omnis error et dolor excepturi.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">18 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">26</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">951</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Quia modi consectetur ea non corporis qui.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">09 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">16</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">483</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Debitis sint vel ullam soluta eum sit.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">28 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">2</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">981</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Quas ad fugit sequi.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">25 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">26</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">259</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Cumque consectetur illo laudantium assumenda sunt hic placeat.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">07 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">19</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">336</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Explicabo sint aliquam accusamus non quo cupiditate inventore debitis.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">03 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">18</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">626</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Perspiciatis suscipit architecto quidem aut sint quam esse ipsa.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">06 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">23</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">925</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Exercitationem voluptatem quam dignissimos qui.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">27 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">21</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">553</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Dolore est doloribus itaque ut nostrum qui.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">23 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">11</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">997</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Velit perspiciatis animi autem reprehenderit id.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">14 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">19</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">707</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Et dolor quia distinctio autem qui adipisci.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">19 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">8</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">629</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Voluptatibus cumque minus quidem porro corporis assumenda consequatur.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">18 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">16</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">228</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Atque unde impedit repudiandae.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">02 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">14</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">291</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Enim maxime magnam aut et dolor quibusdam doloremque magnam.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">29 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">10</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">212</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#">Eligendi dolores ut porro odio incidunt quia.</a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE192;</i> <span class="uk-text-muted uk-text-small">06 Jan 2018</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE0B9;</i> <span class="uk-text-muted uk-text-small">15</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons">&#xE417;</i> <span class="uk-text-muted uk-text-small">812</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
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