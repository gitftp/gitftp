<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> -->
        <?php
        if (isset($seopagename)) {
            $seo_desc = idconvert::get_seo_details($seopagename);
        } else {
            $seo_desc = idconvert::get_seo_details('home');
        }
        ?>
        <title><?php echo $seo_desc['title'] ?></title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="<?php echo $seo_desc['meta_description'] ?>" />
        <meta name="keywords" content="<?php echo $seo_desc['meta_keywords'] ?>" />
        <meta name="revisit-after" content="<?php echo $seo_desc['meta_revisit_after'] ?>">

        <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
        <link rel="stylesheet" href="<?php echo Uri::base(false); ?>assets/css/newsearch/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo Uri::base(false); ?>assets/css/newsearch/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo Uri::base(false); ?>assets/css/newsearch/main.css">
        <link rel="stylesheet" href="<?php echo Uri::base(false); ?>assets/css/newsearch/jquery.lighter.css">
        <link rel="stylesheet" href="<?php echo Uri::base(false); ?>assets/css/newsearch/flexslider.css">
        <link rel="stylesheet" href="<?php echo Uri::base(false); ?>assets/css/newsearch/bootstrap-select.less">
        <link rel="stylesheet" href="<?php echo Uri::base(false); ?>assets/css/newsearch/jquery-confirm.css">
        <link rel="stylesheet" href="<?php echo Uri::base(false); ?>assets/css/newsearch/font-awesome.min.css">
        <script src="<?php echo Uri::base(false); ?>assets/js/newsearch/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
        <script>
            var base_url = '<?php echo Uri::base(false); ?>';
        </script>
    </head>
    <body>
        <div class="header-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="header ">
                            <div class="xtra-links">
                                <ul>
                                    <li><a href="<?php echo Uri::base(false) . 'nri'; ?>">NRI Home</a></li>
                                    <?php if (Auth::check()) { ?>
                                        <li><a href="<?php echo Uri::base(false); ?>"><?php echo Auth::get_screen_name(); ?></a></li>
                                        <li><a href="<?php echo Uri::base(false) . 'user/logout'; ?>">Logout</a></li>
                                        <li><a href="<?php echo Uri::base(false) . 'shortlist'; ?>">Short List Property(<?php
                                                list($driver, $userid) = Auth::get_user_id();
                                                echo idconvert::get_cart_count($userid);
                                                ?>)</a></li>
                                    <?php } else { ?>
                                        <li><a href="<?php echo Uri::base(false) . 'login'; ?>">Login</a></li>
                                    <?php } ?>
                                    <li><a href="#">Terms</a></li>
                                </ul>
                            </div>
                            <img src="<?php echo Uri::base(false) . 'assets/img/logo.png'; ?>" alt="">
                            <ul class="navigator">
                                <li>
                                    <a href="<?php echo Uri::base(false); ?>">Home</a>
                                </li>
                                <li>
                                    <a href="#">New Project</a>
                                    <div class="navigator-dropdown">
                                        <h4>New project</h4>
                                        <div class="row">
                                            <?php
                                            $i = 1;
                                            echo '<div class="col-md-3">';
                                            foreach (idconvert::get_nav_details('location') as $key => $value) {
                                                echo '<a href="' . Uri::base(false) . 'newproject/' . $value['locality_name'] . '">' . $value['locality_name'] . ' (' . idconvert::get_count_property_newproject($value['location_Id']) . ')</a>';
                                                if (($i % 9) == 0) {
                                                    echo ' </div><div class="col-md-3">';
//                                                    $i = 0;
                                                }
                                                $i++;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a href="#">Location</a>
                                    <div class="navigator-dropdown">
                                        <h4>Location</h4>
                                        <div class="row">
                                            <?php
                                            $i = 1;
                                            echo '<div class="col-md-3">';
                                            foreach (idconvert::get_nav_details('location') as $key => $value) {
                                                echo '<a href="' . Uri::base(false) . 'location/' . $value['locality_name'] . '">' . $value['locality_name'] . ' (' . idconvert::get_count_property_locaton($value['location_Id']) . ')</a>';
                                                if (($i % 9) == 0) {
                                                    echo ' </div><div class="col-md-3">';
//                                                    $i = 0;
                                                }
                                                $i++;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a href="#">Builder</a>
                                    <div class="navigator-dropdown">
                                        <h4>Builder</h4>
                                        <div class="row">
                                            <?php
                                            $i = 1;
                                            echo '<div class="col-md-3">';
                                            foreach (idconvert::get_nav_details('builder') as $key => $value) {
                                                echo ' <a href="' . Uri::base(false) . 'builder/' . $value['builder_name'] . '">' . $value['builder_name'] . ' (' . idconvert::get_count_property_builder($value['builder_id']) . ')</a>';
                                                if (($i % 9) == 0) {
                                                    echo ' </div><div class="col-md-3">';
//                                                    $i = 0;
                                                }
                                                $i++;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a href="<?php echo Uri::base(false) . 'services/forbuilder'; ?>">Service</a>
                                </li>
                                <li>
                                    <a href="<?php echo Uri::base(false) ?>new/contact">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>