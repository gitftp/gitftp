<?php
echo Asset::js(array(
    'vendor/jquery-1.11.2.js',
    'vendor/underscore.js',
    'vendor/modernizr-2.8.3-respond-1.4.2.min.js',
    'vendor/bootstrap.min.js',
    'vendor/jquery-confirm.min.js',
    'vendor/jquery.noty.packaged.min.js',
    'vendor/moment.js',
    'vendor/jquery.validation.js',
    'vendor/selectivity-full.js',
    'vendor/backbone.js',
    'main.js',
));
?>
<script data-main="<?php echo Uri::base(FALSE); ?>assets/js/dashboard/main" src="<?php echo Uri::base(FALSE); ?>assets/js/vendor/require.js"></script>