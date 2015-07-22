<script>
    var base = '<?php echo Uri::base(false); ?>';
    var home_url = '<?php echo home_url; ?>';
    var dash_url = '<?php echo dash_url; ?>';
    var is_dash = '<?php echo is_dash; ?>';
</script>
<header id="header" class="transparent <?php echo (count(Uri::segments()) == 0) ? 'white' : 'black'; ?>-header header active-section">
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
                        <li class="">
                            <a href="<?php echo home_url.'login'; ?>">LOGIN</a>
                        </li>
                        <li class="">
                            <a href="<?php echo home_url.'signup'; ?>">SIGNUP</a>
                        </li>
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