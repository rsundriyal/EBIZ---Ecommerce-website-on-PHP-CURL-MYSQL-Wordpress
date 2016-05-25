jQuery(function ($) {

    $('body')
        .on('click', 'button.ywrr-send-test-email', function () {

            var result = $(this).next(),
                email = $(this).prev().attr('value'),
                template = $('#ywrr_mail_template').val() || 'base',
                re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            result.show();
            result.removeClass('send-progress send-fail send-success');

            if (!re.test(email)) {

                result.addClass('send-fail');
                result.html(ywrr_admin.test_mail_wrong);

            } else {


                var data = {
                    action  : 'ywrr_send_test_mail',
                    email : email,
                    template: template
                };

                result.addClass('send-progress');
                result.html(ywrr_admin.before_send_test_email);

                $.post(ywrr_admin.ajax_url, data, function (response) {

                    result.removeClass('send-progress');

                    if (response === true) {

                        result.addClass('send-success');
                        result.html(ywrr_admin.after_send_test_email);

                    } else {

                        result.addClass('send-fail');
                        result.html(response.error);

                    }

                });

            }

        });

});

