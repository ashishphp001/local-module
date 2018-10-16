<div id="page_content">
    <div id="page_content_inner">

        <!-- statistics (small charts) -->
        <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium hierarchical_show" data-uk-grid-margin>
            <a href='<?php echo ADMINPANEL_URL . "sellleads"; ?>'>
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_visitors peity_data">5,3,9,6,5,9,7</span></div>
                        <span class="uk-text-muted uk-text-small">Today's Sell Leads</span>
                        <h2 class="uk-margin-remove">
                            <?php
                            if ($CountSellleadsRecords != '') {
                                echo $CountSellleadsRecords;
                            } else {
                                echo 0;
                            }
                            ?>
                        </h2>
                    </div>
                </div>
            </a>
            <a href='<?php echo ADMINPANEL_URL . "buyleads"; ?>'>
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data">5,3,9,6,5,9,7,3,5,2</span></div>
                        <span class="uk-text-muted uk-text-small">Today's Buy Leads</span>
                        <h2 class="uk-margin-remove">
                            <?php
                            if ($CountBuyleadsRecords != '') {
                                echo $CountBuyleadsRecords;
                            } else {
                                echo 0;
                            }
                            ?>

                        </h2>
                    </div>
                </div>
            </a>
            <a href='<?php echo ADMINPANEL_URL . "buyer_seller?types=p"; ?>'>
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">75/100</span></div>
                        <span class="uk-text-muted uk-text-small">Today's New User</span>
                        <h2 class="uk-margin-remove">
                            <?php
                            if ($CountUsersRecords != '') {
                                echo $CountUsersRecords;
                            } else {
                                echo 0;
                            }
                            ?>

                        </h2>
                    </div>
                </div>
            </a>
            <a href='<?php echo SITE_PATH; ?>' target="_blank">
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_live peity_data">5,3,9,6,5,9,7,3,5,2,5,3,9,6,5,9,7,3,5,2</span></div>
                        <span class="uk-text-muted uk-text-small">Visitors (live)</span>
                        <h2 class="uk-margin-remove" id="peity_live_text">46</h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- circular charts -->
        <div class="uk-grid uk-grid-width-small-1-2 uk-grid-width-large-1-3 uk-grid-width-xlarge-1-5 uk-text-center uk-sortable sortable-handler" id="dashboard_sortable_cards" data-uk-sortable data-uk-grid-margin>
            <div>
                <div class="md-card md-card-hover md-card-overlay">
                    <div class="md-card-content">
                        <div class="epc_chart" data-percent="76" data-bar-color="#03a9f4">
                            <span class="epc_chart_icon"><i class="material-icons">&#xE0BE;</i></span>
                        </div>
                    </div>
                    <div class="md-card-overlay-content">
                        <div class="uk-clearfix md-card-overlay-header">
                            <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                            <h3>
                                Contact Us
                            </h3>
                        </div>
                        <h5>Today: 
                            <?php
                            if ($CountTodayContactRecords != '') {
                                echo $CountTodayContactRecords;
                            } else {
                                echo 0;
                            }
                            ?>
                        </h5>
                        <a class="md-btn md-btn-primary"  href="<?php echo ADMINPANEL_URL . "contactusleads"; ?>">View All</a>
                    </div>
                </div>
            </div>
            <div>
                <div class="md-card md-card-hover md-card-overlay">
                    <div class="md-card-content uk-flex uk-flex-center uk-flex-middle">
                        <span class="peity_conversions_large peity_data">5,3,9,6,5,9,7</span>
                    </div>
                    <div class="md-card-overlay-content">
                        <div class="uk-clearfix md-card-overlay-header">
                            <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                            <h3>
                                Conversions
                            </h3>
                        </div>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </div>
                </div>
            </div>
            <div>
                <div class="md-card md-card-hover md-card-overlay md-card-overlay-active">
                    <div class="md-card-content" id="canvas_1">
                        <div class="epc_chart" data-percent="37" data-bar-color="#9c27b0">
                            <span class="epc_chart_icon"><i class="material-icons">&#xE85D;</i></span>
                        </div>
                    </div>
                    <div class="md-card-overlay-content">
                        <div class="uk-clearfix md-card-overlay-header">
                            <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                            <h3>
                                Tasks List
                            </h3>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <button class="md-btn md-btn-primary">More</button>
                    </div>
                </div>
            </div>
            <div>
                <div class="md-card md-card-hover md-card-overlay">
                    <div class="md-card-content">
                        <div class="epc_chart" data-percent="53" data-bar-color="#009688">
                            <span class="epc_chart_text">53%</span>
                        </div>
                    </div>
                    <div class="md-card-overlay-content">
                        <div class="uk-clearfix md-card-overlay-header">
                            <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                            <h3>
                                Orders
                            </h3>
                        </div>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </div>
                </div>
            </div>
            <div>
                <div class="md-card md-card-hover md-card-overlay">
                    <div class="md-card-content">
                        <div class="epc_chart" data-percent="37" data-bar-color="#607d8b">
                            <span class="epc_chart_icon"><i class="material-icons">&#xE7FE;</i></span>
                        </div>
                    </div>
                    <div class="md-card-overlay-content">
                        <div class="uk-clearfix md-card-overlay-header">
                            <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                            <h3>
                                User Registrations
                            </h3>
                        </div>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </div>
                </div>
            </div>
        </div>


        <div class="uk-grid uk-grid-medium" data-uk-grid-margin>
            <div class="uk-width-large-2-2">
                <div class="md-card">
                    <div id="clndr_events" class="clndr-wrapper">

                        <script>
                            clndrEvents =<?php echo $getEvents; ?>;
                            // calendar events
//                            clndrEvents = [
//                                {date: '2018-06-08', title: 'Doctor appointment', url: 'javascript:void(0)', timeStart: '10:00', timeEnd: '11:00'},
//                                {date: '2018-06-09', title: 'John\'s Birthday', url: 'javascript:void(0)'},
//                                {date: '2018-06-09', title: 'Party', url: 'javascript:void(0)', timeStart: '08:00', timeEnd: '08:30'},
//                                {date: '2018-06-13', title: 'Meeting', url: 'javascript:void(0)', timeStart: '18:00', timeEnd: '18:20'},
//                                {date: '2018-06-18', title: 'Work Out', url: 'javascript:void(0)', timeStart: '07:00', timeEnd: '08:00'},
//                                {date: '2018-06-18', title: 'Business Meeting', url: 'javascript:void(0)', timeStart: '11:10', timeEnd: '11:45'},
//                                {date: '2018-06-23', title: 'Meeting', url: 'javascript:void(0)', timeStart: '20:25', timeEnd: '20:50'},
//                                {date: '2018-06-26', title: 'Haircut', url: 'javascript:void(0)'},
//                                {date: '2018-06-26', title: 'Lunch with Katy', url: 'javascript:void(0)', timeStart: '08:45', timeEnd: '09:45'},
//                                {date: '2018-06-26', title: 'Concept review', url: 'javascript:void(0)', timeStart: '15:00', timeEnd: '16:00'},
//                                {date: '2018-06-27', title: 'Swimming Poll', url: 'javascript:void(0)', timeStart: '13:50', timeEnd: '14:20'},
//                                {date: '2018-06-29', title: 'Team Meeting', url: 'javascript:void(0)', timeStart: '17:25', timeEnd: '18:15'},
//                                {date: '2018-06-02', title: 'Dinner with John', url: 'javascript:void(0)', timeStart: '16:25', timeEnd: '18:45'},
//                                {date: '2018-06-13', title: 'Business Meeting', url: 'javascript:void(0)', timeStart: '10:00', timeEnd: '11:00'}
//                            ]
                        </script>
                        <script id="clndr_events_template" type="text/x-handlebars-template">
                            <div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions">
                            <i class="md-icon clndr_add_event material-icons">&#xE145;</i>
                            <i class="md-icon clndr_today material-icons">&#xE8DF;</i>
                            <i class="md-icon clndr_previous material-icons">&#xE408;</i>
                            <i class="md-icon clndr_next material-icons uk-margin-remove">&#xE409;</i>
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                            {{ month }} {{ year }}
                            </h3>
                            </div>
                            <div class="clndr_days">
                            <div class="clndr_days_names">
                            {{#each daysOfTheWeek}}
                            <div class="day-header">{{ this }}</div>
                            {{/each}}
                            </div>
                            <div class="clndr_days_grid">
                            {{#each days}}
                            <div class="{{ this.classes }}" {{#if this.id }} id="{{ this.id }}" {{/if}}>
                            <span>{{ this.day }}</span>
                            </div>
                            {{/each}}
                            </div>
                            </div>
                            <div class="clndr_events">
                            <i class="material-icons clndr_events_close_button">&#xE5CD;</i>
                            {{#each eventsThisMonth}}
                            <div class="clndr_event" data-clndr-event="{{ dateFormat this.date format='YYYY-MM-DD' }}">
                            <a target="_blank" href="{{ this.url }}">
                            <span class="clndr_event_title">{{ this.title }}</span>
                            <span class="clndr_event_more_info">
                            {{~dateFormat this.date format='MMM Do'}}
                            {{~#ifCond this.timeStart '||' this.timeEnd}} ({{/ifCond}}
                            {{~#if this.timeStart }} {{~this.timeStart~}} {{/if}}
                            {{~#ifCond this.timeStart '&&' this.timeEnd}} - {{/ifCond}}
                            {{~#if this.timeEnd }} {{~this.timeEnd~}} {{/if}}
                            {{~#ifCond this.timeStart '||' this.timeEnd}}){{/ifCond~}}
                            </span>
                            </a>
                            </div>
                            {{/each}}
                            </div>
                        </script>
                    </div>
                    <div class="uk-modal" id="modal_clndr_new_event">
                        <div class="uk-modal-dialog">
                            <div class="uk-modal-header">
                                <h3 class="uk-modal-title">New Event</h3>
                            </div>
                            <div class="uk-margin-bottom">
                                <label for="clndr_event_title_control">Event Title</label>
                                <input type="text" class="md-input" id="clndr_event_title_control" />
                            </div>
                            <div class="uk-margin-medium-bottom">
                                <label for="clndr_event_link_control">Event Link</label>
                                <input type="text" class="md-input" id="clndr_event_link_control" />
                            </div>
                            <div class="uk-grid uk-grid-width-medium-1-3 uk-margin-large-bottom" data-uk-grid-margin>
                                <div>
                                    <div class="uk-input-group">
                                        <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                        <label for="clndr_event_date_control">Event Date</label>
                                        <input class="md-input" type="text" id="clndr_event_date_control" data-uk-datepicker="{format:'YYYY-MM-DD', minDate: '2018-01-16' }">
                                    </div>
                                </div>
                                <div>
                                    <div class="uk-input-group">
                                        <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-clock-o"></i></span>
                                        <label for="clndr_event_start_control">Event Start</label>
                                        <input class="md-input" type="text" id="clndr_event_start_control" data-uk-timepicker>
                                    </div>
                                </div>
                                <div>
                                    <div class="uk-input-group">
                                        <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-clock-o"></i></span>
                                        <label for="clndr_event_end_control">Event End</label>
                                        <input class="md-input" type="text" id="clndr_event_end_control" data-uk-timepicker>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-modal-footer uk-text-right">
                                <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button><button type="button" class="md-btn md-btn-flat md-btn-flat-primary" id="clndr_new_event_submit">Add Event</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<aside id="sidebar_secondary" class="tabbed_sidebar">
    <ul class="uk-tab uk-tab-icons uk-tab-grid" data-uk-tab="{connect:'#dashboard_sidebar_tabs', animation:'slide-horizontal'}">
        <li class="uk-active uk-width-1-3"><a href="#"><i class="material-icons">&#xE422;</i></a></li>
        <li class="uk-width-1-3 chat_sidebar_tab"><a href="#"><i class="material-icons">&#xE0B7;</i></a></li>
        <li class="uk-width-1-3"><a href="#"><i class="material-icons">&#xE8B9;</i></a></li>
    </ul>

    <div class="scrollbar-inner">
        <ul id="dashboard_sidebar_tabs" class="uk-switcher">
            <li>
                <div class="timeline timeline_small uk-margin-bottom">
                    <div class="timeline_item">
                        <div class="timeline_icon timeline_icon_success"><i class="material-icons">&#xE85D;</i></div>
                        <div class="timeline_date">
                            09<span>Jan</span>
                        </div>
                        <div class="timeline_content">Created ticket <a href="#"><strong>#3289</strong></a></div>
                    </div>
                    <div class="timeline_item">
                        <div class="timeline_icon timeline_icon_danger"><i class="material-icons">&#xE5CD;</i></div>
                        <div class="timeline_date">
                            15<span>Jan</span>
                        </div>
                        <div class="timeline_content">Deleted post <a href="#"><strong>Rerum saepe beatae nulla distinctio omnis vitae eaque.</strong></a></div>
                    </div>
                    <div class="timeline_item">
                        <div class="timeline_icon"><i class="material-icons">&#xE410;</i></div>
                        <div class="timeline_date">
                            19<span>Jan</span>
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
                            21<span>Jan</span>
                        </div>
                        <div class="timeline_content">
                            New comment on post <a href="#"><strong>Officiis debitis omnis.</strong></a>
                            <div class="timeline_content_addon">
                                <blockquote>
                                    Quia nulla cumque aut aut quae vitae id voluptas ex culpa.&hellip;
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <div class="timeline_item">
                        <div class="timeline_icon timeline_icon_warning"><i class="material-icons">&#xE7FE;</i></div>
                        <div class="timeline_date">
                            29<span>Jan</span>
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
                                            <span class="md-list-heading">Ollie Veum</span>
                                            <span class="uk-text-small uk-text-muted">Tempore fugit veritatis voluptatem nisi vel.</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <ul class="md-list md-list-addon chat_users">
                    <li>
                        <div class="md-list-addon-element">
                            <span class="element-status element-status-success"></span>
                            <img class="md-user-image md-list-addon-avatar" src="<?php echo ADMIN_MEDIA_URL; ?>assets/img/avatars/avatar_02_tn.png" alt=""/>
                        </div>
                        <div class="md-list-content">
                            <div class="md-list-action-placeholder"></div>
                            <span class="md-list-heading">Mary Sauer</span>
                            <span class="uk-text-small uk-text-muted uk-text-truncate">Rerum est.</span>
                        </div>
                    </li>
                    <li>
                        <div class="md-list-addon-element">
                            <span class="element-status element-status-success"></span>
                            <img class="md-user-image md-list-addon-avatar" src="<?php echo ADMIN_MEDIA_URL; ?>assets/img/avatars/avatar_09_tn.png" alt=""/>
                        </div>
                        <div class="md-list-content">
                            <div class="md-list-action-placeholder"></div>
                            <span class="md-list-heading">Shanel Blick</span>
                            <span class="uk-text-small uk-text-muted uk-text-truncate">Animi ipsam.</span>
                        </div>
                    </li>
                    <li>
                        <div class="md-list-addon-element">
                            <span class="element-status element-status-danger"></span>
                            <img class="md-user-image md-list-addon-avatar" src="<?php echo ADMIN_MEDIA_URL; ?>img/avatars/avatar_04_tn.png" alt=""/>
                        </div>
                        <div class="md-list-content">
                            <div class="md-list-action-placeholder"></div>
                            <span class="md-list-heading">Eloise Wilderman</span>
                            <span class="uk-text-small uk-text-muted uk-text-truncate">Iusto odit.</span>
                        </div>
                    </li>
                    <li>
                        <div class="md-list-addon-element">
                            <span class="element-status element-status-warning"></span>
                            <img class="md-user-image md-list-addon-avatar" src="<?php echo ADMIN_MEDIA_URL; ?>assets/img/avatars/avatar_07_tn.png" alt=""/>
                        </div>
                        <div class="md-list-content">
                            <div class="md-list-action-placeholder"></div>
                            <span class="md-list-heading">Melody Stark</span>
                            <span class="uk-text-small uk-text-muted uk-text-truncate">Esse qui.</span>
                        </div>
                    </li>
                </ul>
                <div class="chat_box_wrapper chat_box_small" id="chat">
                    <div class="chat_box chat_box_colors_a">
                        <div class="chat_message_wrapper">
                            <div class="chat_user_avatar">
                                <img class="md-user-image" src="<?php echo ADMIN_MEDIA_URL; ?>assets/img/avatars/avatar_11_tn.png" alt=""/>
                            </div>
                            <ul class="chat_message">
                                <li>
                                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio, eum? </p>
                                </li>
                                <li>
                                    <p> Lorem ipsum dolor sit amet.<span class="chat_message_time">13:38</span> </p>
                                </li>
                            </ul>
                        </div>
                        <div class="chat_message_wrapper chat_message_right">
                            <div class="chat_user_avatar">
                                <img class="md-user-image" src="<?php echo ADMIN_MEDIA_URL; ?>assets/img/avatars/avatar_03_tn.png" alt=""/>
                            </div>
                            <ul class="chat_message">
                                <li>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem delectus distinctio dolor earum est hic id impedit ipsum minima mollitia natus nulla perspiciatis quae quasi, quis recusandae, saepe, sunt totam.
                                        <span class="chat_message_time">13:34</span>
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <div class="chat_message_wrapper">
                            <div class="chat_user_avatar">
                                <img class="md-user-image" src="<?php echo ADMIN_MEDIA_URL; ?>assets/img/avatars/avatar_11_tn.png" alt=""/>
                            </div>
                            <ul class="chat_message">
                                <li>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque ea mollitia pariatur porro quae sed sequi sint tenetur ut veritatis.
                                        <span class="chat_message_time">23 Jun 1:10am</span>
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <div class="chat_message_wrapper chat_message_right">
                            <div class="chat_user_avatar">
                                <img class="md-user-image" src="<?php echo ADMIN_MEDIA_URL; ?>assets/img/avatars/avatar_03_tn.png" alt=""/>
                            </div>
                            <ul class="chat_message">
                                <li>
                                    <p> Lorem ipsum dolor sit amet, consectetur. </p>
                                </li>
                                <li>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                        <span class="chat_message_time">Friday 13:34</span>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <h4 class="heading_c uk-margin-small-bottom uk-margin-top">General Settings</h4>
                <ul class="md-list">
                    <li>
                        <div class="md-list-content">
                            <div class="uk-float-right">
                                <input type="checkbox" data-switchery data-switchery-size="small" checked id="settings_site_online" name="settings_site_online" />
                            </div>
                            <span class="md-list-heading">Site Online</span>
                            <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                        </div>
                    </li>
                    <li>
                        <div class="md-list-content">
                            <div class="uk-float-right">
                                <input type="checkbox" data-switchery data-switchery-size="small" id="settings_seo" name="settings_seo" />
                            </div>
                            <span class="md-list-heading">Search Engine Friendly URLs</span>
                            <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                        </div>
                    </li>
                    <li>
                        <div class="md-list-content">
                            <div class="uk-float-right">
                                <input type="checkbox" data-switchery data-switchery-size="small" id="settings_url_rewrite" name="settings_url_rewrite" />
                            </div>
                            <span class="md-list-heading">Use URL rewriting</span>
                            <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                        </div>
                    </li>
                </ul>
                <hr class="md-hr">
                <h4 class="heading_c uk-margin-small-bottom uk-margin-top">Other Settings</h4>
                <ul class="md-list">
                    <li>
                        <div class="md-list-content">
                            <div class="uk-float-right">
                                <input type="checkbox" data-switchery data-switchery-size="small" data-switchery-color="#7cb342" checked id="settings_top_bar" name="settings_top_bar" />
                            </div>
                            <span class="md-list-heading">Top Bar Enabled</span>
                            <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                        </div>
                    </li>
                    <li>
                        <div class="md-list-content">
                            <div class="uk-float-right">
                                <input type="checkbox" data-switchery data-switchery-size="small" data-switchery-color="#7cb342" id="settings_api" name="settings_api" />
                            </div>
                            <span class="md-list-heading">Api Enabled</span>
                            <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                        </div>
                    </li>
                    <li>
                        <div class="md-list-content">
                            <div class="uk-float-right">
                                <input type="checkbox" data-switchery data-switchery-size="small" data-switchery-color="#d32f2f" id="settings_minify_static" checked name="settings_minify_static" />
                            </div>
                            <span class="md-list-heading">Minify JS files automatically</span>
                            <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

    <button type="button" class="chat_sidebar_close uk-close"></button>
    <div class="chat_submit_box">
        <div class="uk-input-group">
            <input type="text" class="md-input" name="submit_message" id="submit_message" placeholder="Send message">
            <span class="uk-input-group-addon">
                <a href="#"><i class="material-icons md-24">&#xE163;</i></a>
            </span>
        </div>
    </div>

</aside>

<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALUlEoHAIPkVJPMlYq7AJ5_TH98eB8u-E&callback=initMap" async defer></script>-->