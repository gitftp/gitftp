<?php
echo Asset::js(array(
    'vendor/jquery-1.11.2.js',
    'vendor/underscore.js',
    'vendor/modernizr-2.8.3-respond-1.4.2.min.js',
    'vendor/bootstrap.min.js',
    'vendor/backbone.js',
    'vendor/jquery-confirm.min.js',
    'main.js',
    ));
?>
<script data-main="<?php echo Uri::base(false); ?>assets/js/dashboard/main" src="<?php echo Uri::base(false); ?>assets/js/vendor/require.js"></script>