<script>
    var base = '<?php echo Uri::base(FALSE); ?>';
    var home_url = '<?php echo home_url; ?>';
    var dash_url = '<?php echo dash_url; ?>';
    var is_dash = '<?php echo is_dash; ?>';
</script>
<?php
$color = 'black';
$s = Uri::segments();
if (count($s) == 0) {
    $color = 'white';
} elseif ($s[0] == 'welcome') {
    $color = 'white';
}
?>

<header id="header" class="transparent <?php echo $color; ?>-header header active-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="logo">
                    <a href="<?php echo home_url; ?>" title="">
                        <img src="assets/img/logo-sm-2-name.png" class="black-logo standard-logo middle-content" alt="">
                        <img src="assets/img/logo-sm-2w-name.png" class="white-logo standard-logo middle-content" alt="">
                    </a>
                </div>
            </div>
            <div class="col-md-9 menu-col text-right">
                <div class="menu">
                    <ul class="list-inline">
                        <?php if (\Auth::instance()->check()) { ?>
                            <li class="">
                                <a href="<?php echo dash_url; ?>">
                                    <i class="fa fa-sign-in"></i>&nbsp; <?php echo strtoupper(\Auth::instance()->get('username')); ?>
                                </a>
                            </li>
                            <li class="">
                                <a href="<?php echo home_url . 'user/logout'; ?>"> LOGOUT</a>
                            </li>
                        <?php } else { ?>
                            <li class="">
                                <a href="<?php echo home_url . 'login'; ?>">LOGIN</a>
                            </li>
                            <li class="">
                                <a href="<?php echo home_url . 'signup'; ?>">SIGNUP</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="header-line">
                <div class="line"></div>
            </div>
            <div class="menu-toggle">
                <i class="ti-menu"></i>
            </div>
        </div>
    </div>
</header>