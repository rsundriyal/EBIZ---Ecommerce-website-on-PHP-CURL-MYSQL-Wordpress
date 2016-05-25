<div class="yith-live-chat-console-container">
    <div id="YLC_console" class="yith-live-chat-console">
        <div id="YLC_sidebar_left" class="console-sidebar-left">
            <div class="sidebar-header">
                <?php _e( 'Users', 'yith-live-chat' ); ?>
                <a href="" id="YLC_connect" class="connect button button-disabled">
                    <?php _e( 'Please wait', 'yith-live-chat' ); ?>
                </a>
            </div>
            <div id="YLC_users" class="sidebar-users">
                <div id="YLC_queue" class="sidebar-queue"></div>
                <div id="YLC_notify" class="sidebar-notify">
                    <?php _e( 'Please wait', 'yith-live-chat' ); ?>...
                </div>
            </div>
        </div>
        <div class="console-footer">
            <span><?php echo date( 'Y' ); ?> YITH Live Chat</span>
        </div>
        <div id="YLC_popup_cnv" class="chat-content chat-welcome"></div>
        <div id="YLC_sidebar_right" class="console-sidebar-right"></div>
        <div id="YLC_firebase_offline" class="firebase-offline">
            <div><?php _e( 'Firebase offline or not available. Please wait...', 'yith-live-chat' ); ?></div>
        </div>
    </div>
</div>
<script type="text/javascript">

    (function ($) {

        $(document).ready(function () {

            var options = {<?php ylc_get_plugin_options(); ?>};
            var premium = {};

            <?php apply_filters( 'ylc_js_premium', '' ); ?>

            $('#YLC_console').ylc_console(options, premium);

            $(window).resize(function () {

                var win_h = $(window).height(),
                    win_w = $(window).width(),
                    console_h = win_h - 74,
                    console_w = $('#wpbody-content').width();

                if (win_w < 766 && ylc.is_premium ) {

                    $('#YLC_console').css('height', '');
                    $('#YLC_sidebar_left').css('height', '');
                    $('#YLC_popup_cnv').css('height', '');
                    $('#YLC_sidebar_right').css('height', '');
                    $('#YLC_users').css('height', '');
                    $('#YLC_cnv').css('height', '');
                    $('.yith-live-chat-console-container').width(console_w - 12);

                } else {

                    $('#YLC_console').height(console_h);
                    $('#YLC_sidebar_left').height(console_h);
                    $('#YLC_popup_cnv').height(console_h);
                    $('#YLC_sidebar_right').height(console_h);
                    $('#YLC_users').height(console_h - 110);
                    $('#YLC_cnv').height(console_h - $('#YLC_cnv_bottom').innerHeight() - 30);
                    $('.yith-live-chat-console-container').width(console_w - 20);

                }

            }).trigger('resize');

        });

    }(window.jQuery || window.Zepto));

</script>