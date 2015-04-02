<!DOCTYPE HTML>
<!--
        Big Picture by HTML5 UP
        html5up.net | @n33co
        Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
    <head>
        <?php $seo_desc = idconvert::get_seo_details('home'); ?>
        <title><?php echo $seo_desc['title'] ?></title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="<?php echo $seo_desc['meta_description'] ?>" />
        <meta name="keywords" content="<?php echo $seo_desc['meta_keywords'] ?>" />
        <meta name="revisit-after" content="<?php echo $seo_desc['meta_revisit_after'] ?>">

        <script src="<?php echo Uri::base(false) . 'assets/js/singlepage/'; ?>jquery.min.js"></script>
        <script src="<?php echo Uri::base(false) . 'assets/js/singlepage/'; ?>jquery.poptrox.min.js"></script>
        <script src="<?php echo Uri::base(false) . 'assets/js/singlepage/'; ?>jquery.scrolly.min.js"></script>
        <script src="<?php echo Uri::base(false) . 'assets/js/singlepage/'; ?>jquery.scrollex.min.js"></script>
        <script src="<?php echo Uri::base(false) . 'assets/js/singlepage/'; ?>skel.min.js"></script>
        <script src="<?php echo Uri::base(false) . 'assets/js/singlepage/'; ?>init.js"></script>
        <script src="<?php echo Uri::base(false) . 'assets/js/newsearch/'; ?>jquery-confirm.min.js"></script>

        <link rel="stylesheet" href="<?php echo Uri::base(false) . 'assets/css/singlepage/' ?>bootstrap.css" />
        <link rel="stylesheet" href="<?php echo Uri::base(false); ?>assets/css/newsearch/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo Uri::base(false); ?>assets/css/newsearch/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo Uri::base(false); ?>assets/css/newsearch/jquery-confirm.css">
        <link rel="stylesheet" href="<?php echo Uri::base(false) . 'assets/css/singlepage/' ?>style-wide.css" />
        <link rel="stylesheet" href="<?php echo Uri::base(false) . 'assets/css/singlepage/' ?>style-normal.css" />
        <link rel="stylesheet" href="<?php echo Uri::base(false) . 'assets/css/singlepage/' ?>style.css" />
        <link rel="stylesheet" href="<?php echo Uri::base(false) . 'assets/css/singlepage/' ?>skel.css" />
        <link rel="stylesheet" href="<?php echo Uri::base(false); ?>assets/css/newsearch/font-awesome.min.css">


        <style>
            body, .f{
                font-family: 'Segoe UI', Frutiger, 'Frutiger Linotype', 'Dejavu Sans', 'Helvetica Neue', Arial, sans-serif;
            }
            .footer-intro{
                height: 300px !important; 
            }
            .specialcontiner1{
                background-image: url('http://localhost/global3/public/assets/img/singlepage/thumbs/01.jpg');
                background-size: cover;
                -webkit-background-size: cover;
                display: block;
                position: fixed;

            }
        </style>
        <script>
            var base_url = '<?php echo Uri::base(false) ?>';
        </script>
    </head>
    <body>

        <!-- Header -->
        <header id="header">

            <!-- Logo -->
            <!--<h1 id="logo">Global property kart</h1>-->
            <style>
                .logo{
                    width: 170px;
                    /* margin: 10px 0 0 10px; */
                    background-color: rgba(255,255,255,1);
                    border-radius: 0 0 5px 5px;
                    padding: 20px 10px 10px 10px;
                    margin-left: 30px;
                    box-shadow: 0 2px 3px rgba(0,0,0,.2);
                }
            </style>
            <img src="http://globalpropertykart.com/assets/img/logo.png" alt="Home" class="logo">

            <!-- Nav -->
            <nav id="nav">
                <ul>
                    <li><a href="#intro">Home</a></li>
                    <li><a href="#one">Lodha down town</a></li>
                    <li><a href="#two">Next level township</a></li>
                    <li><a href="#work">Feature Projects</a></li>
                    <?php if (Auth::check()) { ?>
                        <li><a href="<?php echo Uri::base(false) . 'user/logout'; ?>" class="btn btn-warning btn-sm login-signup" style="color: white; font-size: 14px;">Welcome <?php echo Auth::get_screen_name() . ' / Logout';
                        ?></a></li>
                    <?php } else { ?>
                        <li><a href="<?php echo Uri::base(false); ?>login" class="btn btn-warning btn-sm login-signup" style="color: white; font-size: 14px;">Login / Signup</a></li>
                    <?php } ?>
                </ul>
            </nav>
        </header>

        <!-- Intro -->
        <section id="intro" class="main style1 dark fullscreen">

            <div class="content container 75%">
                <header class="header-title">
                    <span class="f" style="font-size: 3em">Welcome to Global Property Kart</span><br>
                    <span class="f" style="font-size: 2em"><em>Buyers Domain, Sellers Mart</em></span>
                </header>

                <div class="intro-form">
                    <div class="tabs">
                        <a href="#" class="active" data-to="rent">SALE</a>
                        <a href="#" data-to="sale">RENT</a>
                        <div class="clear"></div>
                    </div>
                    <div class="tab-container" id="rent-thing">
                        <form class="form-inline" action="<?php echo Uri::base(false) . 'new/search/new'; ?>" method="GET">
                            <input type="hidden" name="property_sale_type" value="1" />
                            <div class="form-group">
                                <select name="location" id="location" class="form-control sp input-lg">
                                    <?php
                                    foreach (idconvert::get_nav_details('location') as $key => $value) {
                                        echo '<option value="' . $value['location_Id'] . '">' . $value['locality_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="bedrooms" id="bedrooms-" class="form-control sp input-lg">
                                    <option value="">BHK</option>
                                    <?php
                                    $floor = idconvert::get_floor();
                                    foreach ($floor as $key => $value) {
                                        echo '<option value="' . $value['floor_id'] . '">' . $value['floor_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="property_price" id="inputPriceFrom-" class="form-control sp input-lg">
                                    <option value="">Price</option>
                                    <?php foreach (idconvert::get_budget(1) as $key => $value) { ?>
                                        <?php echo '<option value="' . $value['budget_id'] . '">' . $value['budget'] . '</option>'; ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="property_type" id="property_type" class="form-control sp input-lg">
                                    <option value="">Property Type</option>
                                    <option value="1">Flat</option>
                                    <option value="1">Shop</option>
                                    <option value="1">Plot</option>
                                </select>
                            </div> 
                            <button type="submit" class="btn btn-danger btn-lg pull-right">Search</button>
                            <br>

                            <div style="height: 7px;"></div>
                            <div class="form-group">
                                <label style="color: black; font-size: 16px; display:inline-block"><input type="checkbox" style="vertical-align:bottom" name="property_conduction[]" value="1"> Pre-Launch &nbsp;&nbsp;</label>
                            </div>
                            <div class="form-group">
                                <label style="color: black; font-size: 16px; display:inline-block"><input type="checkbox" style="vertical-align:bottom" name="property_conduction[]" value="2"> Under Construction &nbsp;&nbsp;</label>
                            </div>
                            <div class="form-group">
                                <label style="color: black; font-size: 16px; display:inline-block"><input type="checkbox" style="vertical-align:bottom" name="property_conduction[]" value="3"> Ready Prossion &nbsp;&nbsp;</label>
                            </div>
                            <div class="form-group">

                                <label style="color: black; font-size: 16px; display:inline-block"><input type="checkbox" style="vertical-align:bottom" name="property_conduction[]" value="4"> Commerical &nbsp;&nbsp;</label>
                            </div>
                        </form>
                    </div>
                    <div class="tab-container" id="sale-thing" style="display:none">
                        <form class="form-inline" action="<?php echo Uri::base(false) . 'new/search/new'; ?>" method="GET">
                            <input type="hidden" name="property_sale_type" value="2" />
                            <div class="form-group">
                                <select name="location" id="location" class="form-control sp input-lg">
                                    <option value="">Location</option>
                                    <?php
                                    foreach (idconvert::get_nav_details('location') as $key => $value) {
                                        echo '<option value="' . $value['location_Id'] . '">' . $value['locality_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="bedrooms" id="bedrooms-" class="form-control sp input-lg">
                                    <option value="">BHK</option>
                                    <?php
                                    $floor = idconvert::get_floor();
                                    foreach ($floor as $key => $value) {
                                        echo '<option value="' . $value['floor_id'] . '">' . $value['floor_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="property_price" id="inputPriceFrom-" class="form-control sp input-lg">
                                    <option value="">Price</option>
                                    <?php foreach (idconvert::get_budget(2) as $key => $value) { ?>
                                        <?php echo '<option value="' . $value['budget_id'] . '">' . $value['budget'] . '</option>'; ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="property_type" id="property_type" class="form-control sp input-lg">
                                    <option value="">Property Type</option>
                                    <option value="1">Flat</option>
                                    <option value="3">Bunglow</option>
                                    <option value="4">Commercial </option>
                                    <option value="5">Shop</option> 
                                </select>
                            </div>
                            <button type="submit" class="btn btn-danger btn-lg pull-right">Search</button>
                            <div style="height: 7px;"></div>
                            <div class="form-group">
                                <label style="color: black; font-size: 14px; display:inline-block"><input type="checkbox" style="vertical-align:bottom" name="property_conduction[]" value="5"> Un-Furnished &nbsp;&nbsp;</label>
                            </div>
                            <div class="form-group">
                                <label style="color: black; font-size: 14px; display:inline-block"><input type="checkbox" style="vertical-align:bottom" name="property_conduction[]" value="6"> Semi Furnished &nbsp;&nbsp;</label>
                            </div>
                            <div class="form-group">
                                <label style="color: black; font-size: 14px; display:inline-block"><input type="checkbox" style="vertical-align:bottom" name="property_conduction[]" value="7"> Fully Furnished &nbsp;&nbsp;</label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <footer>
                <!--<a href="#one" class="button style2 down">More</a>-->
            </footer>
        </div>
    </section>

    <!-- One -->
    <section id="one" class="main style2 right dark fullscreen">
        <div class="content box style2">
            <header>
                <a href="http://lodhadowntown-palava.com/"><img alt="" src="http://lodhadowntown-palava.com/logoNG.jpg"></a>
                <h2>lodhadowntown</h2>
            </header>
            <p>
                High-octane nightlife, exquisite dining options by the lakefront, hundreds of brands at your door step waiting at the high street, beautiful performances at the iconic Centre for Arts and Culture are some of the most phenomenal features of this pulsating hub.
            </p>
            <button class="btn-default btn" href="http://lodhadowntown-palava.com/">Read More</button>
        </div>
        <a href="#two" class="button style2 down anchored">Next</a>
    </section>

    <!-- Two -->
    <section id="two" class="main style2 left dark fullscreen">
        <div class="content box style2">
            <header>
                <a href="http://lodhadowntown-palava.com/"><img alt="" src="http://globalpropertykart.com/assets/img/builder_logo/Marathon-NewLogo-resized1.png" width="90%"></a>
                <h2>Next level township in Panvel</h2>
            </header>
            <p>Planned development over 25 Acres<br>
                Swimming Pool, Tennis Court, Squash Court, Badminton, Clubhouse,<br>
                Children's Play Area, Landscaped Garden, Mall & Multiplex within the premises<br>
                Schools, colleges, hospitals & bus terminals in close proximity<br>
                Ample Car Parking<br>
            </p>
            <button class="btn-default btn" href="http://lodhadowntown-palava.com/">Read More</button>
        </div>
        <a href="#properties" class="button style2 down anchored">Next</a>
    </section>

    <!--Budget home box start-->
    <div class="container intro-property-container" id="properties">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h2 class="text-center intro-property-title">Budget Properties</h2>
                <p class="text-center intro-property-sub">View popular projects</p>
                <div class="row">
                    <?php
                    $budget_property_details = idconvert::get_feature_property();
                    foreach ($budget_property_details as $key => $value) {
                        ?>
                        <div class="col-md-3">
                            <div class="intro-property">
                                <a href="<?php echo Uri::base(false) . 'new/search/newdetails/' . $value['property_id']; ?>">
                                    <span class="title"><?php echo $value['property_name']; ?></span>
                                    <div class="image" style="background-image: url('<?php echo Uri::base(false) . 'assets/img/property/' . $value['property_id'] . '-1.jpg'; ?>')"></div>
                                    <div style="height: 5px;"></div>
                                    <table>
                                        <tr>
                                            <td><span class="sub"><?php echo $value['project_details']; ?>  | <?php echo idconvert::get_property_location($value['location']); ?> </span></td>
                                            <td rowspan="2" class="price"><span class="sub-rupess"><?php echo $value['property_price']; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="sub"><?php echo $value['property_area']; ?></span></td>
                                        </tr>
                                    </table>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div style="height: 20px;"></div>
    <!--Budget home box end-->

    <!--    Navi mumbai box start-->
    <div class="container intro-property-container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h2 class="text-center intro-property-title">Properties in Navi Mumbai</h2>
                <p class="text-center intro-property-sub">View popular projects</p>
                <div class="row">
                    <div class="col-md-4">
                        <div class="intro-property">
                            <a href="<?php echo Uri::base(false) . 'Akshar-Evorra'; ?>">
                                <span class="title">Akshar Evorra</span>
                                <div class="image" style="background-image: url('<?php echo Uri::base(false) . 'Akshar-Evorra/images/header2.jpg'; ?>')"></div>
                                <div style="height: 5px;"></div>
                                <table>
                                    <tr>
                                        <td><span class="sub">2 BHK | DRONAGIRI </span></td>
                                        <td rowspan="2" class="price"><span class="sub-rupess">NaN</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="sub">995 to 1065 Sq.Ft</span></td>
                                    </tr>
                                </table>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="intro-property">
                            <a href="<?php echo Uri::base(false) . 'Arihant-Akanksha' ?>">
                                <span class="title">ARIHANT AKANKSHA</span>
                                <div class="image" style="background-image: url('<?php echo Uri::base(false) . 'Arihant-Akanksha/images/header1.jpg'; ?>')"></div>
                                <div style="height: 5px;"></div>
                                <table>
                                    <tr>
                                        <td><span class="sub">2, 3 & 4 BHK| Panvel</span></td>
                                        <td rowspan="2" class="price"><span class="sub-rupess">66.27 Lac</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="sub">1205 to 2790 sq. ft.</span></td>
                                    </tr>
                                </table>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="intro-property">
                            <a href="<?php echo Uri::base(false) . 'India-Bulls' ?>">
                                <span class="title">India Bulls</span>
                                <div class="image" style="background-image: url('<?php echo Uri::base(false) . 'India-Bulls/images/headerimage1.jpg'; ?>')"></div>
                                <div style="height: 5px;"></div>
                                <table>
                                    <tr>
                                        <td><span class="sub">1,2,3,4,5,6 BHK | Panvel</span></td>
                                        <td rowspan="2" class="price"><span class="sub-rupess">26.50 Lacs onw</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="sub">530 - 4320 sqft.</span></td>
                                    </tr>
                                </table>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="intro-property">
                            <a href="<?php echo Uri::base(false) . 'Sai-Worid-City'; ?>">
                                <span class="title">Sai Worid City</span>
                                <div class="image" style="background-image: url('<?php echo Uri::base(false) . 'Sai-Worid-City/images/headerimage1.jpg'; ?>')"></div>
                                <div style="height: 5px;"></div>
                                <table>
                                    <tr>
                                        <td><span class="sub">2 & 3 BHK | Panvel</span></td>
                                        <td rowspan="2" class="price"><span class="sub-rupess">77.16 Lacs</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="sub">1265 to 2005 sqft.</span></td>
                                    </tr>
                                </table>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="intro-property">
                            <a href="<?php echo Uri::base(false) . 'Sai-Developer'; ?>">
                                <span class="title">Sai Developer</span>
                                <div class="image" style="background-image: url('<?php echo 'http://www.magicbricks.com/microsites/sai_developers/cache/59077/headerimage1.jpg'; ?>')"></div>
                                <div style="height: 5px;"></div>
                                <table>
                                    <tr>
                                        <td><span class="sub">2 BHK | RoadPali</span></td>
                                        <td rowspan="2" class="price"><span class="sub-rupess">61.34 Lacs</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="sub">1136 to 1139 sqft.</span></td>
                                    </tr>
                                </table>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="height: 20px;"></div>
    <!--    Navi mumbai box end -->

    <!--    Mumbai box start-->
    <!--    Mumbai box end -->

    <!--    Pune box start-->

    <!--    Pune box end -->

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>REAL ESTATE IN INDIA:</p>
                    <div class="row">
                        <div class="col-md-6">
                            <ul>
                                <li>
                                    <a href="<?php echo Uri::base(false) . 'builder/Marathon'; ?>">Property in Mumbai</a>
                                </li>
                                <!--                                <li>
                                                                    <a href="#">Property in Navi Mumbai</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Property in Pune</a>
                                                                </li>-->
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li>
                                    <a href="<?php echo Uri::base(false) . 'builder/Marathon'; ?>">Property of Marathon</a>
                                </li>
                                <li>
                                    <a href="<?php echo Uri::base(false) . 'builder/Lodha%20Group'; ?>">Property of Lodha</a>
                                </li>
                                <li>
                                    <a href="<?php echo Uri::base(false) . 'builder/Akshar'; ?>">Property of Akshar</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
<!--                    <p>NEW PROJECTS IN INDIA:</p>-->
                    <div class="row">
                        <div class="col-md-12">
                            <ul>
                                <li>
                                    <a href="<?php echo Uri::base(false) . 'conduction/Ready Possession'; ?>">Ready Possession Property</a>
                                </li>
                                <li>
                                    <a href="<?php echo Uri::base(false) . 'conduction/Pre-Launch'; ?>">Pre-Launch Property</a>
                                </li>
                                <li>
                                    <a href="<?php echo Uri::base(false) . 'conduction/Under Construction'; ?>">Under Construction Property</a>
                                </li>
                                <li>
                                    <a href="<?php echo Uri::base(false) . 'conduction/Commerical'; ?>">Commerical Property</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <p>RESOURCES:</p>
                    <div class="row">
                        <div class="col-md-12">
                            <ul>
                                <li>
                                    <a href="http://blog.globalpropertykart.com/">Blog</a>
                                </li>
                                <li>
                                    <a href="<?php echo Uri::base(false) . 'nri'; ?>">NRI HOME</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer footer-dark">
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <a href="<?php echo Uri::base(false) . 'new/contact'; ?>">
                            <p class="text-center">
                                <i class="fa fa-user fa-3x"></i> <br>
                                Customer care
                            </p>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="<?php echo Uri::base(false) . 'new/pages/termnconduction'; ?>">
                            <p class="text-center">
                                <i class="fa fa-user fa-3x"></i> <br>
                                Terms and condition
                            </p>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="<?php echo Uri::base(false) . 'new/pages/termnconduction'; ?>">
                            <p class="text-center">
                                <i class="fa fa-book fa-3x"></i> <br>
                                Privacy policy
                            </p>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="<?php echo Uri::base(false) . 'new/pages/underconstruction'; ?>">
                            <p class="text-center">
                                <i class="fa fa-question fa-3x"></i> <br>
                                FAQ
                            </p>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="<?php echo Uri::base(false) . 'new/pages/underconstruction'; ?>">
                            <p class="text-center">
                                <i class="fa fa-briefcase fa-3x"></i> <br>
                                Career
                            </p>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="<?php echo Uri::base(false) . 'new/contact'; ?>">
                            <p class="text-center">
                                <i class="fa fa-envelope fa-3x"></i> <br>
                                Contact Us
                            </p>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="socialBlock">
                            <span class="follow">Follow Us on:</span>
                            <a href="https://www.facebook.com/pages/Global-Property-Kart/408277832668136" target="_blank" class="face" title="Facebook"><img img="img" src="http://globalpropertykart.com/assets/img/fb32.png?1424326880" alt=""></a>
                            <a href="https://twitter.com/globalproperty9" target="_blank" class="twit" title="Twitter"><img img="img" src="http://globalpropertykart.com/assets/img/tw32.png?1424326935" alt=""></a> 
                            <a href="https://www.linkedin.com/profile/view?id=259958247&trk=nav_responsive_tab_profile_pic" target="_blank" class="link" title="Linkedin"><img img="img" src="http://globalpropertykart.com/assets/img/li32.png?1424326918" alt=""></a> 
                            <a href="https://plus.google.com/u/0/108920282043778785652/posts" target="_blank" class="gPlus" title="g+"><img img="img" src="http://globalpropertykart.com/assets/img/gp32.png?1424326918" alt=""></a>
                            <a href="https://www.youtube.com/channel/UCAoMTD72XK3KgbDhIXXvjoA" target="_blank" class="gPlus" title="g+"><img img="img" src="http://globalpropertykart.com/assets/img/yt32.png?1424326689" alt=""></a>
                            <div class="clearAll"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="space20"></div>
                        <p><strong>Disclaimer:</strong></p>
                        <p>
                            The Plans, specification, images and other details herein are only indicative and the Developer/Owner reserves the right to changes any, or all of these in the interest of the development.
                        </p>
                    </div>
                    <div class="col-md-12">
                        <div class="space20"></div>
                        <p>
                            globalpropertykart.com is a part of Global. <br>
                            All trademarks, logos and names are properties of their respective owners. All Rights Reserved. � Copyright 2014 global.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="popup" style="display:none">
        <div class="popup-bg"></div>
        <div class="p-i">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="p-i-i">
                            <div class="row">
                                <div class="col-md-6" style="padding-top: 0;">
                                    <img src="http://dummyimage.com/320x400/ebebeb/cccccc.png" alt="" style="width: 100%; border-radius: 0 0 4px 4px;box-shadow: 0 4px 6px rgba(0,0,0,.5)">
                                </div>
                                <div class="col-md-6" style="padding-top: 0;">
                                    <div style="height: 20px;"></div>
                                    <span style="font-size: 24px;">This is the title.</span>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                    </p>
                                    <div style="height: 10px;"></div>
                                    <form action="">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <div style="height: 5px;"></div>
                                            <input type="text" placeholder="Enter your name" name="name" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="mobileno">Mobile no.</label>
                                            <div style="height: 5px;"></div>
                                            <input type="text" placeholder="Enter your mobile no." name="mobileno" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <div style="height: 5px;"></div>
                                            <input type="text" placeholder="Enter your email" name="email" class="form-control">
                                        </div>
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-primary">SEND</button>
                                            <button type="button" class="btn btn-default" onclick="$('.popup').fadeOut('fast');">CLOSE</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
    .popup{
        position: fixed;
        top:0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 99999999999999999999999999;
    }
    .popup .popup-bg{
        background-color: rgba(0,0,0,.4);
        position:absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }
    .popup .p-i{
        height: 400px;
        top: 50%;
        position:absolute;
        margin-top: -200px;
        left: 0;
        right: 0;
    }
    .popup .p-i-i{
        background-color: white;
        border-radius: 4px;
        height: 400px;
        padding-left: 20px;
        padding-right: 20px;
        box-shadow: 0 2px 3px rgba(0,0,0,.3);
    }
    </style>

    <script>

        $(function(){
            setTimeout(function(){
                $('.popup').fadeIn('fast');
            }, 2000);
        });

    </script>
</body>
</html>
