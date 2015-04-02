<div class="top">
    <div class="container">
        <div class="top-menu">
            <div class="well well-sm">
                <div class="row-fluid">
                    <div class="span6">
                        <p style="margin:5px 0 5px">
                            The BEST Property Portal in Navi Mumbai<br>
                            <a href="<?php echo Uri::base(false); ?>about">About Us</a> |
                            <!--<a href=" echo Uri::base(false); ?>#">Top Selling</a> |-->
                            <a href="<?php echo Uri::base(false); ?>nri">NRI Home</a> |
                            <a href="<?php echo Uri::base(false); ?>commercial">Commercial</a> |                                     
                            <a href="http://blog.globalpropertykart.com/">Blog</a> |                                     
                        </p>
                    </div>
                    <div class="span6">
                        <span class="pull-right topheader-nav" style="margin-top:10px;">
                            <?php if (Auth::check()) { ?>
                                <!--<a href="#" class="btn btn-primary btn-sm">Sell / Rent Property</a>-->
                                <a href="<?php echo Uri::base(false); ?>user/userregistration" class="btn btn-primary btn-sm">Post your Requirement</a>
                                <a href="<?php echo Uri::base(false); ?>user/dashboard" class="btn btn-primary btn-sm">Welcome <?php echo Auth::get_screen_name(); ?></a>
                                <a href="<?php echo Uri::base(false); ?>user/logout" class="btn btn-primary btn-sm" >Logout</a>
                                <a href="<?php echo Uri::base(false); ?>user/cart" class="cart-button">
                                    <div class="cart-icon"></div>
                                    <div class="cart-count"><?php
                                        list($driver, $userid) = Auth::get_user_id();
                                        echo idconvert::get_cart_count($userid);
                                        ?></div>
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo Uri::base(false); ?>user/userregistration" class="btn btn-primary btn-sm">Post your Requirement</a>
                                <a href="<?php echo Uri::base(false); ?>user/userregistration" class="btn btn-primary btn-sm">Register</a>
                                <a href="#" class="btn btn-primary btn-sm showLogin" >Login</a>
                                <a href="#" class="cart-button">
                                    <div class="cart-icon"></div>
                                    <div class="cart-count"></div>
                                </a>
                            <?php } ?>
                        </span>
                    </div>

                    <div class="login-wrapper">
                        <p class="text-center"><strong>Login to Global</strong></p>
                        <form action="<?php echo Uri::base(false); ?>user/login" method="post" id="gl-login">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" placeholder="username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" placeholder="password">
                            </div>

                            <div class="space" id="login-msg"></div>
                            <div class="space"></div>
                            <a href="#">Forgot Password</a>
                            <div class="space"></div>
                            <button class="btn btn-primary btn-block" type="submit" id="gl-login-btn">Login</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="top-inner inverted">
            <div class="header clearfix">
                <?php echo $flex; ?>
                <div class="logo">
                    <a href="<?php echo Uri::base(false); ?>" title="Home">
                        <img src="<?php echo Uri::base(false); ?>assets/img/logo.png" alt="Home">
                    </a>
                </div>
            </div>
            <!-- /.header -->
            <div class="navigation navbar clearfix">
                <div class="pull-left">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <div class="nav-collapse collapse">
                        <ul id="menu-main" class="nav">
                            <li class="menu-item active-menu-item menu-item-parent">
                                <a href="<?php echo Uri::base(false); ?>">Home</a>

                            </li>

                            <li class="menu-item menu-item-parent">
                                <a href="#">New Project</a>
                                <div class="long-sub-menu">
                                    <p class="menu-title">New project</p>
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <ul>
                                                <?php
                                                $i = 1;
                                                foreach ($location as $key => $value) {
                                                    echo ' <li><a href="' . Uri::base(false) . 'newproject/' . $value['locality_name'] . '">' . $value['locality_name'] . ' (' . idconvert::get_count_property_newproject($value['location_Id']) . ')</a></li>';
                                                    if (($i % 9) == 0) {
                                                        echo '</ul></div><div class="span3"><ul>';
                                                    }
                                                    $i++;
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="menu-item menu-item-parent">
                                <a href="#">Browse by Location</a>
                                <div class="long-sub-menu">
                                    <p class="menu-title">Browse by Location</p>
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <ul>
                                                <?php
                                                $i = 1;
                                                foreach ($location as $key => $value) {
                                                    echo ' <li><a href="' . Uri::base(false) . 'location/' . $value['locality_name'] . '">' . $value['locality_name'] . ' (' . idconvert::get_count_property_locaton($value['location_Id']) . ')</a></li>';
                                                    if (($i % 9) == 0) {
                                                        echo '</ul></div><div class="span3"><ul>';
                                                    }
                                                    $i++;
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="menu-item menu-item-parent">
                                <a href="#">Browse by Builder</a>
                                <div class="long-sub-menu">
                                    <p class="menu-title">Browse by Builder</p>
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <ul>
                                                <?php
                                                $i = 1;
                                                foreach ($builder as $key => $value) {
                                                    echo ' <li><a href="' . Uri::base(false) . 'builder/' . $value['builder_name'] . '">' . $value['builder_name'] . ' (' . idconvert::get_count_property_builder($value['builder_id']) . ')</a></li>';
                                                    if (($i % 9) == 0) {
                                                        echo '</ul></div><div class="span3"><ul>';
                                                    }
                                                    $i++;
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="menu-item menu-item-parent">
                                <a href="#">Ready Possession</a>
                                <div class="long-sub-menu">
                                    <p class="menu-title">Ready Possession</p>
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <ul>
                                                <?php
                                                $i = 1;
                                                foreach ($location as $key => $value) {
                                                    echo ' <li><a href="' . Uri::base(false) . 'readypossession/' . $value['locality_name'] . '">' . $value['locality_name'] . ' (' . idconvert::get_count_property_readyposs($value['location_Id']) . ')</a></li>';
                                                    if (($i % 9) == 0) {
                                                        echo '</ul></div><div class="span3"><ul>';
                                                    }
                                                    $i++;
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="menu-item menu-item-parent">
                                <a href="<?php echo Uri::base(false); ?>offers">Offers</a>
                                <ul class="sub-menu">
                                    <li class="menu-item"><a href="<?php echo Uri::base(false); ?>offers/bulkbuying">Bulk Buying Power</a></li>
                                    <li class="menu-item"><a href="<?php echo Uri::base(false); ?>offers/backoffers">Buy Back Offers</a></li>
                                    <li class="menu-item"><a href="<?php echo Uri::base(false); ?>offers/groupbuying">Group Buying</a></li>
                                    <li class="menu-item"><a href="<?php echo Uri::base(false); ?>offers/jointventure">Joint Venture</a></li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="#">Service</a>
                                <ul class="sub-menu">
                                    <li class="menu-item"><a href="<?php echo Uri::base(false); ?>service">Service to Buyer</a></li>
                                    <li class="menu-item"><a href="<?php echo Uri::base(false); ?>service/servicebuilder">Service to Builder</a></li>
                                </ul>
                            </li>

                            <li class="active-menu-item menu-item-parent">
                                <a href="<?php echo Uri::base(false); ?>contact">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!--
                <div class="pull-right">
                    <div class="list-property">
                        <a href="submissions/default.htm" alt="List You Property"><div class="ribbon"><span class="icon icon-normal-circle-plus"></span></div>
                        </a>
                    </div>
                </div>
                -->

            </div>

            <!--            <div class="breadcrumb pull-left">
                             Breadcrumb NavXT 4.4.0 
                            <a title="Go to Home." href="default.htm" class="home">Home</a>
                        </div>-->
            <!-- /.breadcrumb -->
        </div>
    </div>
</div>