
<div id="page_content">
    <div id="page_content_inner">
        <div class="uk-grid">
            <div class="uk-width-medium-2-3">
                <div class="md-card">
                    <div class="md-card-content">
                        Click on user to start chat.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="intLoginId" value="<?php echo ADMIN_ID; ?>">

<div id="sidebar_secondary">
    <div class="sidebar_secondary_wrapper uk-margin-remove">
        <ul class="md-list md-list-addon list-chatboxes" id="chatboxes">
            <?php if (ADMIN_ID == 2) { ?>
                <li data-user="Karianne Bergnaum" data-id="1" data-user-avatar="avatar_02">
                    <div class="md-list-addon-element">
                        <span class="element-status element-status-danger"></span>
                        <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_02_tn.png" alt=""/>
                    </div>
                    <div class="md-list-content">
                        <span class="md-list-heading">Karianne Bergnaum</span>
                        <span class="uk-text-small uk-text-muted uk-text-truncate">Totam repellendus architecto quas.</span>
                    </div>
                </li>
            <?php } else { ?>
                <li data-user="Kayley Doyle" data-id="2" data-user-avatar="avatar_07">
                    <div class="md-list-addon-element">
                        <span class="element-status element-status-success"></span>
                        <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_07_tn.png" alt=""/>
                    </div>
                    <div class="md-list-content">
                        <span class="md-list-heading">Kayley Doyle</span>
                        <span class="uk-text-small uk-text-muted uk-text-truncate">Rerum autem ut odio reiciendis neque.</span>
                    </div>
                </li>
            <?php } ?>
            <!--            <li data-user="Kaci Eichmann" data-id="3" data-user-avatar="avatar_06">
                            <div class="md-list-addon-element">
                                <span class="element-status element-status-success"></span>
                                <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_06_tn.png" alt=""/>
                            </div>
                            <div class="md-list-content">
                                <span class="md-list-heading">Kaci Eichmann</span>
                                <span class="uk-text-small uk-text-muted uk-text-truncate">Vero tenetur dolor rerum nemo.</span>
                            </div>
                        </li>
                        <li data-user="Akeem Halvorson" data-id="4" data-user-avatar="avatar_01">
                            <div class="md-list-addon-element">
                                <span class="element-status element-status-danger"></span>
                                <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_01_tn.png" alt=""/>
                            </div>
                            <div class="md-list-content">
                                <span class="md-list-heading">Akeem Halvorson</span>
                                <span class="uk-text-small uk-text-muted uk-text-truncate">Commodi mollitia ea nostrum.</span>
                            </div>
                        </li>
                        <li data-user="Shannon Schultz" data-id="5" data-user-avatar="avatar_08">
                            <div class="md-list-addon-element">
                                <span class="element-status element-status-warning"></span>
                                <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_08_tn.png" alt=""/>
                            </div>
                            <div class="md-list-content">
                                <span class="md-list-heading">Shannon Schultz</span>
                                <span class="uk-text-small uk-text-muted uk-text-truncate">Tempora quis unde temporibus ut.</span>
                            </div>
                        </li>
                        <li data-user="Nella Bergstrom" data-id="6" data-user-avatar="avatar_04">
                            <div class="md-list-addon-element">
                                <span class="element-status element-status-success"></span>
                                <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_04_tn.png" alt=""/>
                            </div>
                            <div class="md-list-content">
                                <span class="md-list-heading">Nella Bergstrom</span>
                                <span class="uk-text-small uk-text-muted uk-text-truncate">Recusandae culpa et.</span>
                            </div>
                        </li>-->
        </ul>
    </div>
</div>
<div id="chatbox_wrapper"></div>

<script id="chatbox_template" type="text/x-handlebars-template">
    <div class="chatbox" data-user="{{ username }}" data-id="{{ id }}">
    <div class="chatbox_header">
    <div class="header_actions">
    <div class="actions_dropdown" data-uk-dropdown="{pos:'bottom-right',mode:'click'}">
    <a href="#"><i class="material-icons">&#xE8B9;</i></a>
    <div class="uk-dropdown uk-dropdown-small">
    <ul class="uk-nav uk-nav-dropdown">
    <li><a href="#">Show full conversation</a></li>
    <li><a href="#">Block messages</a></li>
    <li><a href="#">Report</a></li>
    </ul>
    </div>
    </div>
    <a href="#" class="chatbox_close"><i class="material-icons">&#xE14C;</i></a>
    </div>
    <span class="header_name">
    {{ username }}
    </span>
    </div>
    <div class="chatbox_content" id="chatdata<?php echo ADMIN_ID; ?>">
    {{> conversation this }}
    </div>
    <div class="chatbox_footer">
    <textarea placeholder="Write message..." class="message_input"></textarea>
    </div>
    </div>
</script>
<script id="chatbox_conversation" type="text/x-handlebars-template">
    {{#if conversation }}
    {{#each conversation }}
    <div class="chatbox_message{{#exists own }} own{{/exists}}">
    {{#exists avatarUrl }}
    <a href="#" class="chatbox_avatar">
    <img src="{{avatarUrl}}" />
    </a>
    {{/exists}}
    <ul class="chatbox_message_content">
    {{> messages this}}
    </ul>
    </div>
    {{/each}}
    {{/if}}
</script>
<script id="chatbox_messages" type="text/x-handlebars-template">
    {{#if messages }}
    {{#each messages }}
    <li><span{{#exists time}} data-uk-tooltip="{pos:'right'}" {{/exists}}>{{ text }}</span></li>
    {{/each}}
    {{/if}}
</script>

<!-- google web fonts -->
<script>
    WebFontConfig = {
        google: {
            families: [
                'Source+Code+Pro:400,700:latin',
                'Roboto:400,300,500,700,400italic:latin'
            ]
        }
    };
    (function () {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
    })();
</script>
<script src="<?php echo base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js'); ?>"></script>