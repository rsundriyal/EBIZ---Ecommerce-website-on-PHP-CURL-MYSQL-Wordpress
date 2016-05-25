<div id="YLC"></div>
<script type="text/javascript">

    (function ($) {

        $(document).ready(function () {

            var options = {<?php ylc_get_plugin_options(); ?>};
            var premium = {};

            <?php apply_filters( 'ylc_js_premium', '' ); ?>

            $('#YLC').ylc(options, premium);

        });

    }(window.jQuery || window.Zepto));

</script>