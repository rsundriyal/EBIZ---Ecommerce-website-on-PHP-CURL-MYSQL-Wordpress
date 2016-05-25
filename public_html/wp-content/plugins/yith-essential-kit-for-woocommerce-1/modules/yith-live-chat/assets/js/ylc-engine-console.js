(function ($, window, document, undefined) {

    var YLC_console = "ylc_console",

    // The name of using in .data()
        data_plugin = "plugin_" + YLC_console,

    // Default options
        defaults = {
            app_id   : '',
            user_info: {
                user_id     : null,
                user_name   : null,
                user_email  : null,
                gravatar    : null,
                user_type   : null,
                avatar_type : null,
                avatar_image: null,
                current_page: null,
                user_ip     : null
            }
        },
        premium = {}; // premium options

    function Plugin() {

        this.opts = $.extend({}, defaults);
        this.premium = $.extend({}, premium);

    }

    Plugin.prototype = {

        init              : function (opts, premium) {

            $.extend(this.opts, opts);

            this.data = {
                auth          : null, 		// Firebase auth reference
                ref           : null, 		// Firebase chat reference
                is_mobile     : false,
                active_user_id: 0,
                mode          : "offline",    // Current mode
                logged        : false,        // Logged in?
                assets_url    : ylc.plugin_url,
                user          : {}, 	        // User data
                online_ops    : {} 	        // Online operators list
            };

            this.strings = {
                months      : [
                    ylc.strings.months.jan,
                    ylc.strings.months.feb,
                    ylc.strings.months.mar,
                    ylc.strings.months.apr,
                    ylc.strings.months.may,
                    ylc.strings.months.jun,
                    ylc.strings.months.jul,
                    ylc.strings.months.aug,
                    ylc.strings.months.sep,
                    ylc.strings.months.oct,
                    ylc.strings.months.nov,
                    ylc.strings.months.dec
                ],
                months_short: [
                    ylc.strings.months_short.jan,
                    ylc.strings.months_short.feb,
                    ylc.strings.months_short.mar,
                    ylc.strings.months_short.apr,
                    ylc.strings.months_short.may,
                    ylc.strings.months_short.jun,
                    ylc.strings.months_short.jul,
                    ylc.strings.months_short.aug,
                    ylc.strings.months_short.sep,
                    ylc.strings.months_short.oct,
                    ylc.strings.months_short.nov,
                    ylc.strings.months_short.dec
                ],
                time        : {
                    suffix : ylc.strings.time.suffix,
                    seconds: ylc.strings.time.seconds,
                    minute : ylc.strings.time.minute,
                    minutes: ylc.strings.time.minutes,
                    hour   : ylc.strings.time.hour,
                    hours  : ylc.strings.time.hours,
                    day    : ylc.strings.time.day,
                    days   : ylc.strings.time.days,
                    month  : ylc.strings.time.month,
                    months : ylc.strings.time.months,
                    year   : ylc.strings.time.year,
                    years  : ylc.strings.time.years
                },
                msg         : {
                    chat_title       : ylc.strings.msg.chat_title,
                    prechat_msg      : ylc.strings.msg.prechat_msg,
                    welc_msg         : ylc.strings.msg.welc_msg,
                    start_chat       : ylc.strings.msg.start_chat,
                    offline_body     : ylc.strings.msg.offline_body,
                    busy_body        : ylc.strings.msg.busy_body,
                    close_msg        : ylc.strings.msg.close_msg,
                    close_msg_user   : ylc.strings.msg.close_msg_user,
                    reply_ph         : ylc.strings.msg.reply_ph,
                    send_btn         : ylc.strings.msg.send_btn,
                    no_op            : ylc.strings.msg.no_op,
                    no_msg           : ylc.strings.msg.no_msg,
                    sending          : ylc.strings.msg.sending,
                    connecting       : ylc.strings.msg.connecting,
                    writing          : ylc.strings.msg.writing,
                    please_wait      : ylc.strings.msg.please_wait,
                    chat_online      : ylc.strings.msg.chat_online,
                    chat_offline     : ylc.strings.msg.chat_offline,
                    your_msg         : ylc.strings.msg.your_msg,
                    end_chat         : ylc.strings.msg.end_chat,
                    conn_err         : ylc.strings.msg.conn_err,
                    you              : ylc.strings.msg.you,
                    online_btn       : ylc.strings.msg.online_btn,
                    offline_btn      : ylc.strings.msg.offline_btn,
                    field_empty      : ylc.strings.msg.field_empty,
                    invalid_email    : ylc.strings.msg.invalid_email,
                    invalid_username : ylc.strings.msg.invalid_username,
                    user_name        : ylc.strings.msg.user_name,
                    user_email       : ylc.strings.msg.user_email,
                    user_ip          : ylc.strings.msg.user_ip,
                    user_page        : ylc.strings.msg.user_page,
                    connect          : ylc.strings.msg.connect,
                    disconnect       : ylc.strings.msg.disconnect,
                    you_offline      : ylc.strings.msg.you_offline,
                    save_chat        : ylc.strings.msg.save_chat,
                    ntf_close_console: ylc.strings.msg.ntf_close_console,
                    new_msg          : ylc.strings.msg.new_msg,
                    new_user_online  : ylc.strings.msg.new_user_online,
                    saving           : ylc.strings.msg.saving,
                    waiting_users    : ylc.strings.msg.waiting_users,
                    good             : ylc.strings.msg.good,
                    bad              : ylc.strings.msg.bad,
                    chat_evaluation  : ylc.strings.msg.chat_evaluation,
                    talking_label    : ylc.strings.msg.talking_label,
                    timer            : ylc.strings.msg.timer,
                    chat_copy        : ylc.strings.msg.chat_copy,
                    already_logged   : ylc.strings.msg.already_logged,
                    current_shop     : ylc.strings.msg.current_shop,
                    macro_title      : ylc.strings.msg.macro_title,
                    macro_opts       : ylc.strings.msg.macro_opts,
                    macro_err        : ylc.strings.msg.macro_err
                }
            };

            if (ylc.is_premium) {
                $.extend(this.premium, premium);
            }

            this.objs = {
                last_cnv_id       : null,
                last_user_id      : null,
                last_msg_id       : null,
                right_sidebar_html: '',
                list_interval     : null,
                working           : false,
                checked_user_ids  : [],
                new_msgs_count    : {}
            };

            var self = this;

            $('#YLC_connect').click(function (e) {

                e.preventDefault();

                $('#YLC_notify').show().html(self.strings.msg.connecting + '...');

                if (!$(this).data('logged')) {

                    self.login(true);

                } else if ($(this).data('status', 'online')) {

                    self.be_offline();

                }

            });

            // Is mobile?
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                this.data.is_mobile = true;
            }

            // Get application token
            this.post('ylc_ajax_callback', 'get_token', {}, function (r) {
                if (!r.error) {
                    self.data.auth_token = r.token;
                    self.check_ntf();
                    self.auth();
                }
            });
        },
        /**
         * Authentication
         */
        auth              : function (callback) {

            if (!this.opts.app_id) {
                console.error('App ID not provided');
                return;
            }

            if (this.data.ref == null) {

                this.data.ref = new Firebase('https://' + this.opts.app_id + '.firebaseIO.com');
                this.data.ref_conn = new Firebase('https://' + this.opts.app_id + '.firebaseIO.com/.info/connected');
                this.data.ref_cnv = new Firebase('https://' + this.opts.app_id + '.firebaseIO.com/chat_sessions');
                this.data.ref_msgs = new Firebase('https://' + this.opts.app_id + '.firebaseIO.com/chat_messages');
                this.data.ref_users = new Firebase('https://' + this.opts.app_id + '.firebaseIO.com/chat_users');

            }

            this.login(false, callback);

            this.after_load();

        },
        /**
         * After load
         */
        after_load        : function () {

            var self = this;

            $(document).on('keydown', '#YLC_cnv_reply', function () {
                $(this).trigger('autosize.resize');
                $(window).trigger('resize');
            });

            $(document).on('focus', '#YLC_cnv_reply', function () {
                $(this).autosize({
                    append: ''
                });
            });

            /**
             * When click user on the users list
             */
            $(document).on('click', '#YLC_users li.free, #YLC_users li.busy', function () {

                var obj_user = $(this);

                if (self.objs.list_interval != null)
                    clearInterval(self.objs.list_interval);

                self.get_user_data($(this).data('id'), function (user) {

                    if (self.data.active_user_id)
                        $('#YLC_chat_user_' + self.data.active_user_id).removeClass('chat-active');

                    obj_user.addClass('chat-active').removeClass('new-msg').data('count', 0).find('.chat-count').empty();

                    $('#YLC_popup_cnv').removeClass('chat-welcome')
                        .html(self.get_template('console-conversation', {
                            reply_ph: self.strings.msg.reply_ph,
                            load_msg: self.strings.msg.please_wait + '...',
                            avatar  : self.set_avatar(self.data.user.user_type, {
                                gravatar    : self.data.user.gravatar,
                                avatar_type : self.data.user.avatar_type,
                                avatar_image: self.data.user.avatar_image
                            })
                        }));

                    $('#YLC_cnv_reply').focus();

                    if (obj_user.data('id') !== self.data.user.user_id) {

                        self.objs.right_sidebar_html = self.get_template('console-user-tools', {
                            save_chat_btn: ( !ylc.is_premium ) ? '' : self.trigger_premium('show_save_button', obj_user.data('cnv-id')),
                            obj_user_data: obj_user.data('cnv-id'),
                            button_text  : self.strings.msg.end_chat
                        });

                    }

                    self.objs.right_sidebar_html = self.objs.right_sidebar_html + self.get_template('console-user-info', {
                            name_title       : self.strings.msg.user_name,
                            name             : user.user_name,
                            ip_title         : self.strings.msg.user_ip,
                            ip_address       : user.user_ip,
                            info_title       : self.strings.msg.user_email,
                            email            : user.user_email,
                            page_title       : self.strings.msg.user_page,
                            href_current_page: ( user.current_page ) ? user.current_page : '#',
                            current_page     : ( user.current_page ) ? user.current_page : 'N/A'
                        });

                    self.objs.cnv = $('#YLC_cnv');
                    self.data.user.conversation_id = obj_user.data('cnv-id');
                    self.data.active_user_id = obj_user.data('id');

                    self.reload_cnv(obj_user.data('cnv-id'));
                    self.manage_reply_box(self.objs.last_cnv_id);

                    self.objs.last_cnv_id = obj_user.data('cnv-id');

                    $('#YLC_sidebar_right').html(self.objs.right_sidebar_html).show();

                    if (obj_user.data('chat') == 'free') {

                        self.data.ref_users.child(obj_user.data('id')).child('chat_with').set(self.data.user.user_id);

                    } else {

                        if (obj_user.data('chat') == self.data.user.user_id) {
                            $('#YLC_end_chat').show();
                        } else {
                            $('#YLC_end_chat').hide();
                        }


                    }

                    if (ylc.is_premium) {
                        self.trigger_premium('show_chat_timer', obj_user.data('cnv-id'));
                        self.trigger_premium('show_macros');
                    }


                    $(window).trigger('resize');

                });

            });

            /**
             * End chat
             */
            $(document).on('click', '#YLC_save, #YLC_end_chat', function (e) {

                var btn = $(this),
                    ntf = $('#YLC_save_ntf'),
                    delete_from_app = ( $(this).attr('id') === 'YLC_end_chat' ),
                    now = new Date(),
                    end_chat = now.getTime();

                if (self.objs.working) {
                    ntf.html(self.strings.msg.please_wait + '...');
                    return;
                }

                self.objs.working = true;

                $(this).addClass('button-disabled');

                ntf.html(self.strings.msg.saving + '...');

                if (delete_from_app) {

                    if (self.objs.list_interval != null)
                        clearInterval(self.objs.list_interval);

                }

                if (ylc.is_premium) {

                    self.trigger_premium('end_chat_console', $(this).data('cnv-id'), delete_from_app, end_chat, btn, ntf);

                } else {

                    self.clear_user_data($(this).data('cnv-id'), function () {

                        self.objs.working = false;

                        btn.removeClass('button-disabled');

                        setTimeout(function () {

                            ntf.fadeOut(500);

                        }, 100);

                        setTimeout(function () {

                            self.show_welcome_popup();

                        }, 1000);

                    });
                }

            });

            /**
             * Remove active user highlight when visitor already mouseover on the conversation
             */
            $('#YLC_popup_cnv').mouseover(function () {

                $('#YLC_chat_user_' + self.data.active_user_id).removeClass('new-msg')
                    .data('count', 0)
                    .find('.chat-count').empty();

            });

            setInterval(function () {

                $('.chat-last-online').each(function (i) {

                    $(this).html(self.timeago($(this).data('time')));

                });

            }, 60000);

            var wait = 0;

            setInterval(function () {

                var new_wait = 0;

                self.data.ref_users.once('value', function (snap) {

                    var users = snap.val();

                    if (users !== null) {

                        $.each(users, function (user_id, user) {

                            if (user) {

                                if (user.status === 'wait') {

                                    new_wait = new_wait + 1;
                                }

                            }

                        });

                    }

                });

                wait = new_wait;

                if (new_wait > 0) {

                    $('#YLC_queue').html(self.strings.msg.waiting_users.replace(/%d/i, new_wait)).show();

                } else {

                    $('#YLC_queue').hide();

                }

            }, 15000);

            window.onbeforeunload = function (e) {
                var ev = e || window.event;

                //IE & Firefox
                if (ev) {
                    ev.returnValue = self.strings.msg.ntf_close_console;
                }

                // For Safari
                return self.strings.msg.ntf_close_console;
            };

        },
        /**
         * Login
         */
        login             : function (new_user, callback) {

            var self = this;

            this.manage_connections();

            this.data._new_user = new_user;
            this.data.auth = this.data.ref.authWithCustomToken(this.data.auth_token, function (error) {

                if (error) {

                    console.error(error.code, error.message);

                    $('#YLC_connect').removeClass('button-disabled');

                    $('#YLC_notify').hide().html(error.message).fadeIn(200);

                    self.display_ntf(self.strings.msg.conn_err, 'error');

                } else {

                    $('#YLC_notify').html(self.strings.msg.you_offline);

                    $('#YLC_connect').html(self.strings.msg.connect)
                        .data('logged', 0)
                        .removeClass('button-disabled');

                    self.data.logged = true;

                    self.data.ref_users.once('value', function (snap) {

                        var users = snap.val(),
                            i = 0;

                        if (users !== null) {

                            var total_user = Object.keys(users).length;

                            $.each(users, function (user_id, user) {

                                i++;

                                if (user) {

                                    if (user.user_type == 'operator' && user.status === 'online') {
                                        self.data.online_ops[user.user_id] = user;
                                    }

                                }

                                if (i === total_user) {

                                    self.data.mode = 'offline';


                                    self.check_user(self.opts.user_info.user_id);

                                }

                            });

                        } else {

                            self.data.mode = 'offline';
                            self.check_user(self.opts.user_info.user_id);

                        }

                        if (callback)
                            callback();

                    });

                }

            });

        },
        /**
         * Logged in successfully
         */
        logged_in         : function (user) {

            var self = this;

            if (ylc.is_premium) {
                self.trigger_premium('play_sound', 'connected');
            }

            self.listen_msgs();

            $('#YLC_notify').hide().empty();

            $('#YLC_connect').html('<i class="fa fa-check-circle" style="color:#acc327;"></i> ' + self.strings.msg.online_btn)
                .data('logged', 1)
                .data('status', 'online')
                .removeClass('button-disabled');

            self.purge_firebase();

        },
        /**
         * Logout from Firebase
         */
        logout            : function (end_chat) {

            var self = this;

            if (this.data.user.user_id) {

                self.data.ref_user.off();   // Don't listen current user

                self.data.ref_users.off();  // Don't listen users

                self.data.ref_msgs.off();   // Don't listen message anymore

                if (ylc.is_premium) {
                    self.trigger_premium('play_sound', 'offline');
                }

                $('#YLC_notify').html(self.strings.msg.you_offline);

                $('#YLC_connect').html(self.strings.msg.connect)
                    .data('logged', 0)
                    .data('status', 'offline')
                    .removeClass('button-disabled');

                self.show_welcome_popup();

            }

            if (ylc.is_premium) {

                self.trigger_premium('end_chat_options', end_chat);

            } else {

                if (end_chat)
                    self.clear_user_data(self.data.user.conversation_id);

                setTimeout(function () {

                    self.be_offline();

                }, 2000);

            }

            // Resize window to ensure chat box is responsive
            $(window).trigger('resize');

            // Callback: Current user is offline now
            self.offline();
        },
        /**
         * Just be offline, don't logout completely
         */
        be_offline        : function () {

            // Set mode
            this.data.mode = 'offline';

            if (this.data.ref_user) {

                // Set status offline in Firebase
                this.data.ref_user.child('status').set('offline');

                // Set last online
                this.data.ref_user.child('last_online').set(Firebase.ServerValue.TIMESTAMP);

            }

            // Callback: Current user is offline now
            this.offline();

        },
        /**
         * Current user is offline
         */
        offline           : function () {
            var self = this;

            if (ylc.is_premium) {
                self.trigger_premium('play_sound', 'disconnected');
            }

            $('#YLC_notify').html(self.strings.msg.you_offline);

            $('#YLC_connect').html('<i class="fa fa-check-circle" style="color:#e54045;"></i> ' + self.strings.msg.offline_btn)
                .data('logged', 0)
                .data('status', 'offline')
                .removeClass('button-disabled');

        },
        /**
         * Check user if exists in Firebase
         */
        check_user        : function (user_id) {

            var self = this;

            // User reference
            this.data.ref_user = this.data.ref_users.child(user_id);

            // Get user
            this.data.ref_user.once('value', function (snap) {

                var user_data = snap.val();

                // User data must always be object
                if (!user_data)
                    user_data = {};

                // Get user now
                self.get_user(user_id, user_data);

            });

            this.data.ref_user.child('chat_with').on('value', function (snap) {

                var value = snap.val();

                if (value != null) {

                    self.data.user.chat_with = value;

                }

            });

            // Check current user connectivity
            this.data.ref_users.on('child_removed', function (snap) {

                var user = snap.val();

                if (!user) {
                    return;
                }

                if (user_id === user.user_id) {
                    self.logout();
                }

            });

        },
        /**
         * Get user from Firebase. If not exists, create new one
         */
        get_user          : function (user_id, user_data, callback) {

            var self = this;

            // Get current user data
            if (user_data.user_id) {

                // Get user data
                this.data.user = user_data;

                // Update current mode in Firebase
                this.data.ref_user.child('status').set('offline');

                // Update other user data
                this.data.ref_user.child('user_ip').set(this.opts.user_info.user_ip);
                this.data.ref_user.child('current_page').set(this.opts.user_info.current_page);
                this.data.ref_user.child('user_name').set(this.opts.user_info.user_name);
                this.data.ref_user.child('user_email').set(this.opts.user_info.user_email);
                this.data.ref_user.child('gravatar').set(this.opts.user_info.gravatar);
                this.data.ref_user.child('avatar_type').set(this.opts.user_info.avatar_type);
                this.data.ref_user.child('avatar_image').set(this.opts.user_info.avatar_image);
                this.data.ref_user.child('vendor_id').set(ylc.active_vendor.vendor_id);
                this.data.ref_user.child('vendor_name').set(ylc.active_vendor.vendor_name);

                this.data.mode = 'offline';

                // Check user connection
                this.manage_connections();

                // Callback: Logged in successfully
                this.logged_in(this.data.user);

                // Now listen users activity
                this.listen_users();

                if (callback)
                    callback();


                // Create new user
            } else if (this.data._new_user === true) {

                // Create new conversation
                var cnv = this.data.ref_cnv.push({
                        user_id     : user_id,
                        created_at  : Firebase.ServerValue.TIMESTAMP,
                        accepted_at : '',
                        evaluation  : '',
                        user_type   : 'operator',
                        receive_copy: false
                    }),
                // Prepare user data
                    data = {
                        user_id        : user_id,
                        conversation_id: cnv.key(),
                        last_online    : '',
                        is_mobile      : this.data.is_mobile,
                        chat_with      : 'free',
                        status         : 'online',// Connection status
                        vendor_id      : ylc.active_vendor.vendor_id,
                        vendor_name    : ylc.active_vendor.vendor_name
                    };

                // Merge with default user data
                for (var i in this.opts.user_info) {
                    data[i] = this.opts.user_info[i];
                }

                // Update user data
                this.data.user = data;

                // Create user in Firebase
                this.data.ref_user.set(data, function (error) {

                    if (!error) {

                        // Show conversation
                        self.data.mode = 'online';

                        // Callback: Logged in successfully
                        self.logged_in(self.data.user);

                        // Check this new user connection again
                        self.manage_connections();

                        // Now listen users activity
                        self.listen_users();

                    }

                    if (callback)
                        callback();

                });


            } else {

                // Now listen users activity
                this.listen_users();

            }

        },
        /**
         * Get users
         */
        listen_users      : function () {

            var self = this;

            this.data.last_changed_id = null;

            // Clean list if already exists
            $('#YLC_users > ul').remove();

            // Add ul list
            $('#YLC_users').append('<ul></ul>');

            // Select list
            this.data.user_list = $('#YLC_users > ul');

            // Listen users once in the beginning of page load
            this.data.ref_users.once('value', function (snap) {

                var users = snap.val(),
                    i = 0;

                if (users !== null) {

                    var total_user = Object.keys(users).length;

                    // Reset total ops
                    self.data.online_ops = {};

                    $.each(users, function (user_id, user) {

                        // Increase index
                        i = i + 1;

                        if (user) {

                            if (self.valid_operator(user.vendor_id)) {

                                if (user.user_type === 'operator') {

                                    // Check operator connection
                                    if (user.status === 'online') {

                                        self.data.online_ops[user.user_id] = user;

                                    } else {

                                        delete self.data.online_ops[user.user_id];
                                    }

                                }

                                // Add user item into the list
                                self.add_user_item(user);
                            }

                        }

                        if (i === total_user) { // Last index in the while

                            self.data.ref_users.on('value', function (snap) {

                                // Clear list now
                                $('#YLC_users > ul').empty();

                                var users = snap.val();

                                $.each(users, function (user_id, user) {

                                    if (self.valid_operator(user.vendor_id)) {

                                        self.update_user(user);

                                    }

                                });

                            });

                        }

                    });

                }

            });
        },
        /**
         * Update user info in Firebase
         */
        update_user       : function (user, prev_id) {

            if (user) {

                // User is not ready for adding wait for all information added into Firebase
                if (!user.user_id) {
                    return;
                }
            }

            if (user) {

                if (user.conversation_id) {

                    // Add user item into the list
                    this.add_user_item(user);

                    if (user.user_type === 'operator') { // Don't repeat same changes triggered more than once

                        // Increase total operator number
                        if (user.status === 'online') {
                            this.data.online_ops[user.user_id] = user;

                            // Decrease total number of operator
                        } else {
                            delete this.data.online_ops[user.user_id];
                        }

                    }

                    // Callback: New user is online!
                    if (!prev_id)
                        if ($.inArray(user.user_id, this.objs.checked_user_ids) == -1 && user.user_id != this.data.user.user_id) {

                            if (ylc.is_premium) {
                                this.trigger_premium('play_sound', 'online');
                            }

                            if (user.user_type != 'operator')
                                this.notify(this.strings.msg.new_user_online, user.user_name + ' (' + user.user_type + ')', null, 'user_online');

                            this.objs.checked_user_ids.push(user.user_id);

                        }
                    // Update user active page url
                    if (this.data.active_user_id === user.user_id)
                        $('#YLC_active_page').attr('href', user.current_page).find('span').html(user.current_page);

                    // Remove user. It is trash! Because it doesn't have cnv_id
                } else {

                    // Save user data, and then delete from Firebase
                    this.clean_user_data(user.user_id);

                }

            }

            // Update last changed id
            this.data.last_changed_id = prev_id;

        },
        /**
         * Clean user data from Firebase
         */
        clean_user_data   : function (user_id) {

            var self = this,
                ref_user = this.data.ref_users.child(user_id);

            // Remove user from users list
            ref_user.once('value', function (snap) {

                var user = snap.val();

                // Remove user reference
                ref_user.remove();

                // Clean user conversation
                if (user.conversation_id) {
                    self.ref_cnv.child(user.conversation_id);
                }

                // Remove user messages
                self.data.ref_msgs.once('value', function (msg_snap) {

                    var msgs = msg_snap.val();

                    if (msgs) {
                        $.each(msgs, function (msg_id, msg) {

                            if (msg.user_id === user_id) {
                                self.data.ref_msgs.child(msg_id).remove();
                            }

                        });
                    }

                });

            });

        },
        /**
         * Add user into the list
         */
        add_user_item     : function (user) {

            if (!user.user_id || !this.data.user_list)
                return;

            var username = '',
                is_busy = false,
                elem_id = '#YLC_chat_user_' + user.user_id;

            if (user.chat_with != 'free') {

                if (this.data.online_ops[user.chat_with] == null) {

                    this.data.ref_users.child(user.user_id).child('chat_with').set('free');
                    is_busy = false;

                } else {

                    is_busy = ( user.chat_with != this.data.user.user_id );
                    username = this.data.online_ops[user.chat_with]['user_name']

                }

            }

            var user_status = ( is_busy ) ? ' busy' : ' free';

            var last_online = ( user.status === 'offline' || user.status === 'wait' ) ? ' - <span class="other-info" data-time="' + user.last_online + '">' + this.timeago(user.last_online) + '</span>' : '',
                user_info = ( is_busy ) ? '<br /><span class="other-info">' + this.strings.msg.talking_label.replace(/%s/i, username) + '</span>' : '',
                vendor = '';

            if (user.user_type == 'operator') {
                user_status = ' op';
            }

            if (ylc.yith_wpv_active && ylc.active_vendor.vendor_id == '0') {
                vendor = (user.vendor_id == 0) ? '' : this.strings.msg.current_shop.replace(/%s/i, user.vendor_name) + ' ';
            }

            $(elem_id).remove();

            this.data.user_list.append(this.get_template('console-user-item', {
                id       : user.user_id,
                class    : 'user-' + user.status + ' user-' + user.user_type + user_status,
                color    : user.color || 'transparent',
                username : user.user_name || user.user_email || 'N/A',
                is_mobile: ( user.is_mobile ) ? '<i class="fa fa-mobile"></i>' : '',
                avatar   : this.set_avatar(user.user_type, {
                    gravatar    : user.gravatar,
                    avatar_type : user.avatar_type,
                    avatar_image: user.avatar_image
                }),
                cnv_id   : user.conversation_id,
                chat_with: user.chat_with,
                meta     : vendor + user.user_type + last_online + user_info
            }));

            var obj_user = $(elem_id);

            if (user.user_id == this.data.active_user_id) {

                obj_user.addClass('chat-active').removeClass('new-msg').data('count', 0).find('.chat-count').empty();
                if (this.objs.new_msgs_count[user.user_id] != null)
                    this.objs.new_msgs_count[user.user_id] = 0;

            } else {

                var msg_count = ( this.objs.new_msgs_count[user.user_id] != null ) ? this.objs.new_msgs_count[user.user_id] : 0;

                if (msg_count > 0)
                    obj_user.data('count', msg_count).find('.chat-count').html('(' + msg_count + ')');

            }

            $(window).trigger('resize');

        },
        /**
         * Desktop Notifications
         */
        notify            : function (title, msg, callback, tag) {

            // No notification support and don't show it on front end
            if (!Notification)
                return;

            // Check if browser supports notifications
            // And don't notify in front-end
            if (!( "Notification" in window )) {
                return;

                // Display notification if possible!
            } else if (Notification.permission === "granted") {

                // If it's okay let's create a notification
                var notification = new Notification(title, {
                    body: msg,
                    icon: ylc.plugin_url + '/images/ylc-ico.png',
                    tag : tag
                });

                if (callback)
                    notification.onclick = function () {
                        callback();
                    };
                else
                    notification.close();

                // Hide notification after for a while
                setTimeout(function () {
                    notification.close();
                }, 4000);

                // Otherwise, we need to ask the user for permission
                // Note, Chrome does not implement the permission static property
                // So we have to check for NOT 'denied' instead of 'default'
            } else if (Notification.permission !== 'denied') {
                Notification.requestPermission(function (permission) {

                    // Whatever the user answers, we make sure we store the information
                    if (!( 'permission' in Notification )) {
                        Notification.permission = permission;
                    }

                    // If the user is okay, let's create a notification
                    if (permission === "granted") {

                        // If it's okay let's create a notification
                        var notification = new Notification(title, {
                            body: msg
                        });

                        if (callback)
                            notification.onclick = function () {
                                callback();
                            };
                        else
                            notification.close();

                        // Hide notification after for a while
                        setTimeout(function () {
                            notification.close();
                        }, 4000);

                    }

                });
            }
        },
        /**
         * Set avatar for user or operator
         */
        set_avatar        : function (user_type, user_data) {

            user_type = ( user_type == 'operator' ) ? 'admin' : 'user';

            if (ylc.is_premium) {

                return this.trigger_premium('set_avatar_premium', user_type, user_data)

            } else {

                return this.data.assets_url + '/images/default-avatar-' + user_type + '.png';

            }

        },
        /**
         * Time template
         */
        time              : function (t, n) {

            return this.strings.time[t] && this.strings.time[t].replace(/%d/i, Math.abs(Math.round(n)));

        },
        /**
         * Time ago function
         */
        timeago           : function (time) {

            if (!time)
                return '';

            var now = new Date(),
                seconds = ( ( now.getTime() - time ) * 0.001 ) >> 0,
                minutes = seconds / 60,
                hours = minutes / 60,
                days = hours / 24,
                years = days / 365;

            return (
                    seconds < 45 && this.time('seconds', seconds) ||
                    seconds < 90 && this.time('minute', 1) ||
                    minutes < 45 && this.time('minutes', minutes) ||
                    minutes < 90 && this.time('hour', 1) ||
                    hours < 24 && this.time('hours', hours) ||
                    hours < 42 && this.time('day', 1) ||
                    days < 30 && this.time('days', days) ||
                    days < 45 && this.time('month', 1) ||
                    days < 365 && this.time('months', days / 30) ||
                    years < 1.5 && this.time('year', 1) ||
                    this.time('years', years)
                ) + ' ' + this.strings.time.suffix;

        },
        /**
         * Listen message
         */
        listen_msgs       : function () {

            var self = this;

            // Clear previous listen
            this.data.ref_msgs.off();

            // Get current messages
            this.data.ref_msgs.once('value', function (snap) {

                var msgs = snap.val(),
                    total_msgs = msgs ? Object.keys(msgs).length : 0,
                    i = 1;

                // Load old messages after page refresh
                if (msgs) {

                    $.each(msgs, function (msg_id, msg) {

                        // First load
                        msg.first_load = true;

                        // Callback: New message arrived at initial state
                        self.new_msg(msg);

                        // Last msg id
                        if (total_msgs == i) {

                            self.listen_new_msgs(msg_id); // Listen new messages

                        }

                        // Increase index
                        i = i + 1;
                    });

                } else {

                    self.listen_new_msgs();

                }

            });

        },
        /**
         * New message sent to any online user
         */
        new_msg           : function (msg, msg_id) {

            var self = this;

            if (self.valid_operator(msg.vendor_id)) {

                var obj_user = $('#YLC_chat_user_' + msg.user_id),
                    obj_count = obj_user.find('.chat-count'),
                    total_msg = parseInt(obj_user.data('count'));

                //if (!msg.old_msg && !msg.first_load && msg.user_id != self.data.user.user_id && msg.user_type != 'operator') {
                if (msg.read == false && msg.user_id != self.data.user.user_id && !msg_id) {

                    total_msg = total_msg + 1;

                    self.objs.new_msgs_count[msg.user_id] = total_msg;

                    obj_user.addClass('new-msg').data('count', total_msg);
                    obj_count.html('(' + total_msg + ')');

                    if (ylc.is_premium) {
                        self.trigger_premium('play_sound', 'new-msg');
                    }

                    self.notify(self.strings.msg.new_msg, msg.user_name + ': ' + msg.msg, null, 'new_msg');

                }

                if (self.data.user.conversation_id == msg.conversation_id) {

                    $('#YLC_load_msg').remove();

                    self.add_msg(msg, self.objs.last_user_id, self.objs.last_msg_id);

                    self.objs.last_user_id = msg.user_id;

                    if (self.objs.last_user_id != msg.user_id || !self.objs.last_msg_id)
                        self.objs.last_msg_id = msg.msg_id;

                }

                if (msg_id) {
                    self.data.ref_msgs.child(msg_id).child('read').set(true);
                }

            }

        },
        /**
         * Listen new messages
         */
        listen_new_msgs   : function (msg_id) {

            var self = this,
                ref_msgs = !msg_id ? self.data.ref_msgs : self.data.ref_msgs.startAt(null, msg_id),
                first = true;

            // Don't ignore first message when you check all messages
            if (!msg_id)
                first = false;

            ref_msgs.on('child_added', function (new_snap) {

                var new_msg = new_snap.val();

                // Include message id
                new_msg.id = new_snap.key();

                // Callback: New message arrived
                self.new_msg(new_msg);

                // Not first message anymore
                first = false;

            });

        },
        /**
         * Add message into conversation
         */
        add_msg           : function (msg, last_user_id, last_msg_id) {

            var now = new Date(),
                d = new Date(msg.msg_time), // Chat message date
                t = d.getHours() + ':' + ( d.getMinutes() < 10 ? '0' : '' ) + d.getMinutes(), // Chat message time
                msg_content = this.sanitize_msg(msg.msg),
                msg_time = ( d.toDateString() == now.toDateString() ) ? t : d.getUTCDate() + ' ' + this.strings.months_short[d.getUTCMonth()] + ', ' + t; // Set message time either time or short date like '21 May'

            if (this.objs.cnv) {

                this.objs.cnv.append(this.get_template('console-chat-line', {
                    msg_id: msg.id,
                    time  : msg_time,
                    date  : d.getUTCDate() + ' ' + this.strings.months[d.getUTCMonth()] + ' ' + d.getUTCFullYear() + ' ' + t,
                    color : 'transparent',
                    avatar: this.set_avatar(msg.user_type, {
                        gravatar    : msg.gravatar,
                        avatar_type : msg.avatar_type,
                        avatar_image: msg.avatar_image
                    }),
                    name  : msg.user_name,
                    msg   : msg_content,
                    class : ( msg.user_id == this.data.user.user_id ) ? ' chat-you' : ''
                })).scrollTop(this.objs.cnv.prop('scrollHeight'));

            }

        },
        /**
         * Add message into conversation
         */
        sanitize_msg      : function (str) {

            var msg, pattern_url, pattern_pseudo_url, pattern_email, pattern_html, pattern_line;

            //removes html tags to avoid malicious code
            var tagsToReplace = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;'
            };

            msg = str.replace(/[&<>]/g, function (i) {
                return tagsToReplace[i] || i;
            });

            //pattern_html = /(<([^>]+)>)/gim;
            //msg = str.replace(pattern_html, '');

            //renders multiline
            pattern_line = /\n/gim;
            msg = msg.replace(pattern_line, '<br />');

            //URLs starting with http://, https://, or ftp://
            pattern_url = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
            msg = msg.replace(pattern_url, '<a href="$1" target="_blank">$1</a>');

            //URLs starting with "www." (without // before it, or it'd re-link the ones done above).
            pattern_pseudo_url = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
            msg = msg.replace(pattern_pseudo_url, '$1<a href="http://$2" target="_blank">$2</a>');

            //Change email addresses to mailto:: links.
            pattern_email = /(([a-zA-Z0-9\-\_\.])+@[a-zA-Z\_]+?(\.[a-zA-Z]{2,6})+)/gim;
            msg = msg.replace(pattern_email, '<a href="mailto:$1">$1</a>');

            return msg;

        },
        /**
         * Manage reply box
         */
        manage_reply_box  : function (last_cnv_id) {

            var self = this,
                writing = false,
                obj_reply = $('#YLC_cnv_reply'),
                fn_delay = (function () {
                    /**
                     * Delay for a specified time
                     */
                    var timer = 0;

                    return function (callback, ms) {
                        clearTimeout(timer);
                        timer = setTimeout(callback, ms);
                    };

                })();

            // First clean typing list in any case!
            this.data.ref_cnv.child(this.data.user.conversation_id + '/typing').remove();

            // Manage reply box
            obj_reply.keydown(function (e) {

                // When clicks ENTER key (but not shift + ENTER )
                if (e.keyCode === 13 && !e.shiftKey) {

                    e.preventDefault();

                    var msg = $(this).val();

                    if (msg) {

                        // Clean reply box
                        $(this).val('').trigger('autosize.resize');

                        // Send message to Firebase
                        self.push_msg(msg);

                        // User isn't typing anymore
                        self.data.ref_cnv.child(self.data.user.conversation_id + '/typing/' + self.data.user.user_id).remove();

                    }

                    // Usual writing..
                } else {

                    // Check if current user (operator & visitor) is typing...
                    if (!writing) {

                        // Don't listen some keys
                        switch (e.keyCode) {
                            case 17     : // ctrl
                            case 18     : // alt
                            case 16     : // shift
                            case 9      : // tab
                            case 8      : // backspace
                            case 224    : // cmd (firefox)
                            case 17     : // cmd (opera)
                            case 91     : // cmd (safari/chrome) Left Apple
                            case 93     : // cmd (safari/chrome) Right Apple
                                return;
                        }

                        // Add user typing list in current conversation
                        self.data.ref_cnv.child(self.data.user.conversation_id + '/typing/' + self.data.user.user_id).set(self.data.user.user_name);

                        // User is writing now
                        writing = true;

                    }

                    // Remove user from typing list after the user has stopped typing
                    // for a specified amount of time
                    fn_delay(function () {

                        // User isn't typing anymore
                        self.data.ref_cnv.child(self.data.user.conversation_id + '/typing/' + self.data.user.user_id).remove();

                        // User isn't writing anymore
                        writing = false;

                    }, 1300);

                }

            });

            // Stop listen last conversation
            if (last_cnv_id) {
                this.data.ref_cnv.child(last_cnv_id + '/typing').off();
                this.data.ref_cnv.child(last_cnv_id).off('child_added');
            }

            // Check if a user is typing in current conversation...
            this.data.ref_cnv.child(this.data.user.conversation_id + '/typing').on('value', function (snap) {

                var i = 0,
                    users = snap.val(),
                    total_users = ( users ) ? Object.keys(users).length : 0;

                if (!users) {
                    self.clean_ntf();

                    return;
                }

                $.each(users, function (user_id, user_name) {

                    if (user_id != null && user_id != self.data.user.user_id) {

                        // Show notification
                        self.display_ntf(self.strings.msg.writing.replace(/%s/i, user_name), 'typing');

                        return; // Don't check other writers
                    }

                    if (total_users === i) { // Last index
                        self.clean_ntf();
                    }

                    i = i + 1; // Increase index

                });
            });

            this.data.ref_cnv.child(this.data.user.conversation_id).on('child_added', function (new_snap) {

                if (new_snap.val() == 'closed') {

                    $('#YLC_cnv_reply').attr('disabled', 'disabled');
                    $('.chat-cnv-input').addClass('chat-disabled');

                }

            });

        },
        /**
         * Read current conversation messages and update cnv area (reload messages)
         * It is good to use when user open empty conversation box on user interface
         * and show up old messages
         */
        reload_cnv        : function (cnv_id) {

            var self = this;

            // Get current conversation messages
            this.data.ref_msgs.once('value', function (snap) {

                var now = new Date(),
                    all_msgs = snap.val(),
                    total_msgs = all_msgs ? Object.keys(all_msgs).length : 0,
                    total_user_msgs = 0,
                    i = 1;

                if (all_msgs) {

                    $.each(all_msgs, function (msg_id, msg) {

                        if (msg.conversation_id == cnv_id) {

                            // This message from chat history
                            //msg.read = true;

                            // Callback: New message arrived
                            self.new_msg(msg, msg_id);

                            // Increase total number of user messages
                            total_user_msgs = total_user_msgs + 1;

                        }

                        if (total_msgs == i) { // Last index

                            // Callback: All conversation messages loaded
                            self.cnv_msgs_loaded(total_user_msgs);
                        }

                        // Increase index
                        i = i + 1;

                    });

                } else { // No message

                    // Callback: All conversation messages loaded
                    self.cnv_msgs_loaded(0);

                }

            });

        },
        /**
         * Conversation messages loaded
         */
        cnv_msgs_loaded   : function (total_msgs) {

            if (!total_msgs)
                $('#YLC_load_msg').html(this.strings.msg.no_msg + '.');
            else
                $('#YLC_load_msg').empty();

        },
        /**
         * Create new message
         */
        push_msg          : function (msg) {

            // Push message to Firebase
            this.data.ref_msgs.push({
                user_id        : this.data.user.user_id,
                user_type      : this.data.user.user_type,
                conversation_id: this.data.user.conversation_id,
                user_name      : this.data.user.user_name || this.data.user.user_email,
                gravatar       : this.data.user.gravatar,
                avatar_type    : this.data.user.avatar_type,
                avatar_image   : this.data.user.avatar_image,
                msg            : msg,
                msg_time       : Firebase.ServerValue.TIMESTAMP,
                vendor_id      : ylc.active_vendor.vendor_id,
                read           : true
            });

        },
        /**
         * Get template to render
         */
        get_template      : function (template, params) {

            var html;

            switch (template) {

                //Chat lines
                case 'console-chat-line':
                    html = ylc.templates.console_chat_line;
                    break;

                //User item - backend
                case 'console-user-item':
                    html = ylc.templates.console_user_item;
                    break;

                //Conversation - backend
                case 'console-conversation':
                    html = ylc.templates.console_conversation;
                    break;

                //User info - backend
                case 'console-user-info':
                    html = ylc.templates.console_user_info;
                    break;

                //User tools - backend
                case 'console-user-tools':
                    html = ylc.templates.console_user_tools;
                    break;

                case 'console-user-tools-premium' :
                    html = ylc.templates.premium.console_user_tools_premium;
                    break;

                case 'console-user-timer-premium' :
                    html = ylc.templates.premium.console_user_timer_premium;
                    break;
                case 'console-macro-premium' :
                    html = ylc.templates.premium.console_macro_premium;
                    break;

                default:
                    html = '';

            }

            return this.string_replace(html, params);

        },
        /**
         * Replace placeholder strings in templates
         */
        string_replace    : function (str, args) {
            for (var key in args) {
                if (args.hasOwnProperty(key)) {
                    var regex = new RegExp('ylc\.' + key, 'gm');
                    str = str.replace(regex, args[key])
                }
            }
            return str;
        },
        /**
         * Get a user data
         */
        get_user_data     : function (user_id, callback) {

            this.data.ref_users.child(user_id).once('value', function (snap) {

                var user = snap.val();

                // Just run callback
                callback(user);

            });
        },
        /**
         * Manage connections
         */
        manage_connections: function () {

            var self = this;

            if (!this.data.ref_user) {
                return;
            }

            // Manage connections
            this.data.ref_conn.on('value', function (snap) {

                // User is connected (or re-connected)!
                // and things happen here that should happen only if online (or on reconnect)
                if (snap.val() === true) {
                    $('#YLC_firebase_offline').hide();

                    // Add this device to user's connections list
                    var conn = self.data.ref_user.child('connections').push(true);

                    // When user disconnect, remove this device
                    conn.onDisconnect().remove();

                    // Set online
                    self.data.ref_user.child('status').set('online');

                    // Update user connection status when disconnect
                    self.data.ref_user.child('status').onDisconnect().set('offline');

                    // Update last time user was seen online when disconnect
                    self.data.ref_user.child('last_online').onDisconnect().set(Firebase.ServerValue.TIMESTAMP);

                    // Remove user typing list on disconnect
                    self.data.ref_cnv.child(self.data.user.conversation_id + '/typing/' + self.data.user.user_id).onDisconnect().remove();

                } else {

                    $('#YLC_firebase_offline').show();

                }

            });

        },
        /**
         * Custom POST wrapper
         */
        post              : function (action, mode, data, callback) {

            var self = this;

            $.post(ylc.ajax_url + '?action=' + action + '&mode=' + mode, data, callback, 'json')
                .fail(function (jqXHR) {

                    // Log error
                    console.log(mode, ': ', jqXHR);

                    return false;

                });

        },
        /**
         * Trigger Premium
         */
        trigger_premium   : function (event, p1, p2, p3, p4, p5, p6) {

            return this.premium[event].call(this, p1, p2, p3, p4, p5, p6);

        },
        /**
         * Check if browser supports notifications
         */
        check_ntf         : function () {

            // No notification support
            if (!( "Notification" in window )) {
                return;

                // Otherwise, we need to ask the user for permission
                // Note, Chrome does not implement the permission static property
                // So we have to check for NOT 'denied' instead of 'default'
            } else if (Notification.permission !== 'denied') {
                Notification.requestPermission(function (permission) {

                    // Whatever the user answers, we make sure we store the information
                    if (!( 'permission' in Notification )) {
                        Notification.permission = permission;
                    }

                });
            }

        },
        /**
         * Display notification
         */
        display_ntf       : function (ntf, type) {

            var icon;

            switch (type) {

                case 'success':
                    icon = '<i class="fa fa-check"></i> ';
                    break;
                case 'error':
                    icon = '<i class="fa fa-exclamation-triangle"></i> ';
                    break;
                case 'typing':
                    icon = '<i class="fa fa-pencil-square-o"></i> ';
                    break;
                default:
                    icon = '';

            }

            $('#YLC_popup_ntf').removeClass().addClass('chat-ntf chat-' + type).html(icon + ntf).fadeIn(300);

        },
        /**
         * Clean notification
         */
        clean_ntf         : function () {

            $('#YLC_popup_ntf').html('').hide();

        },
        /**
         * Clear user data
         */
        clear_user_data   : function (cnv_id, callback) {

            var self = this;

            this.data.ref_cnv.child(cnv_id).once('value', function (snap_cnv) {

                var cnv = snap_cnv.val();

                if (!cnv)
                    return;

                var user_id = cnv.user_id;

                self.data.ref_msgs.once('value', function (snap_msgs) {

                    var msgs = snap_msgs.val(),
                        total_msgs = msgs ? Object.keys(msgs).length : 0,
                        i = 0;

                    if (msgs) {

                        $.each(msgs, function (msg_id, msg) {

                            i = i + 1;

                            if (msg.conversation_id === cnv_id) {

                                self.data.ref_msgs.child(msg_id).remove();

                            }

                            if (total_msgs === i) {

                                if (callback)
                                    callback();

                            }

                        });

                    } else if (callback) {

                        callback();

                    }

                    self.data.ref_users.child(user_id).remove();
                    self.data.ref_cnv.child(cnv_id).remove();

                });

            });

        },
        /**
         * Total number of online operators
         */
        total_online_ops  : function () {

            if (this.data.online_ops) {
                return Object.keys(this.data.online_ops).length;
            } else {
                return 0;
            }

        },
        /**
         * Purge Firebase from inactive users and conversations
         */
        purge_firebase    : function (force_purge) {

            var self = this;

            this.data.ref_users.once('value', function (snap) {

                var users = snap.val(),
                    i = 0,
                    del_list = [],
                    cnv_list = [],
                    op_cnv_list = [],
                    interval = ( force_purge ) ? 0 : 3600; //3600 = 1 hour

                if (users !== null) {

                    var total_user = Object.keys(users).length,
                        now = new Date();

                    $.each(users, function (user_id, user) {

                        i++;

                        if (user) {

                            if (user.status === 'offline') {

                                var seconds = ( ( now.getTime() - user.last_online ) * 0.001 ) >> 0;

                                if (seconds >= interval) {

                                    if (user.user_type != 'operator') {


                                        if (user.conversation_id != null) {

                                            cnv_list.push(user.conversation_id)

                                        } else {

                                            del_list.push(user_id)

                                        }


                                    } else {

                                        del_list.push(user_id);
                                        op_cnv_list.push(user.conversation_id);

                                    }

                                }

                            }

                        }

                        if (i === total_user) {

                            $.each(del_list, function (index, user_id) {

                                self.data.ref_users.child(user_id).remove()

                            });

                            $.each(op_cnv_list, function (index, cnv_id) {

                                self.data.ref_cnv.child(cnv_id).remove();
                            });

                            $.each(cnv_list, function (index, cnv_id) {

                                if (ylc.is_premium) {

                                    self.trigger_premium('save_user_data', cnv_id, true, now.getTime());

                                } else {

                                    self.clear_user_data(cnv_id);

                                }

                            });

                        }

                    });

                }

            });

        },
        /**
         * Show welcome popup
         */
        show_welcome_popup: function () {

            $('#YLC_popup_cnv').addClass('chat-welcome').html('');
            $('#YLC_sidebar_right').html('').hide();

        },
        /**
         * Valid Operator
         */
        valid_operator    : function (vendor_id) {

            if (!ylc.yith_wpv_active) {
                return true
            }

            if (ylc.yith_wpv_active && ylc.active_vendor.vendor_id === vendor_id) {
                return true;
            }

            if (ylc.yith_wpv_active && ylc.active_vendor.vendor_id == '0' && !ylc.vendor_only_chat) {
                return true;
            }

            return false;

        }

    };

    /*
     * Plugin wrapper, preventing against multiple instantiations and allowing any public function to be called via the jQuery plugin
     */
    $.fn[YLC_console] = function (arg, arg_prem) {

        var args, instance;

        // only allow the plugin to be instantiated once
        if (!( this.data(data_plugin) instanceof Plugin )) {

            // if no instance, create one
            this.data(data_plugin, new Plugin(this));
        }

        instance = this.data(data_plugin);

        /*
         * because this boilerplate support multiple elements using same Plugin instance, so element should set here
         */
        instance.el = this;

        // Is the first parameter an object (arg), or was omitted, call Plugin.init( arg )
        if (typeof arg === 'undefined' || typeof arg === 'object') {

            if (typeof instance['init'] === 'function') {
                instance.init(arg, arg_prem);
            }

            // checks that the requested public method exists
        } else if (typeof arg === 'string' && typeof instance[arg] === 'function') {

            // copy arguments & remove function name
            args = Array.prototype.slice.call(arguments, 1);

            // call the method
            return instance[arg].apply(instance, args);

        } else {

            $.error('Method ' + arg + ' does not exist on jQuery.' + YLC_console);

        }
    };

}(jQuery, window, document));