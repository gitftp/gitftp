<div class="callus" style="display:none">

    <div class="callus-inner">
        <div class="form" style="display:none">
            <h4>Get a call back</h4>
            <form action="#" method="get">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" placeholder="Enter Your Name" class="form-control">
                </div>
                <div class="form-group">
                    <label>Mobile no.</label>
                    <input type="text" placeholder="Your Mobile Number." class="form-control">
                </div>
                <div class="form-group">
                    <label>Email id.</label>
                    <input type="text" placeholder="Your Email id." class="form-control">
                </div>
                <button class="btn btn-primary btn-block"> <i class></i> Request a callback.</button>
                <p>OR email us at <br>info@globalpropertykart.com</p>
            </form>
        </div>
        <div class="image">
            <?php echo Asset::img('callus.png'); ?>
        </div>
        <span class="close">[x]</span>
    </div>
</div>

<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-like" data-href="https://www.facebook.com/pages/Global-Property-Kart/408277832668136" data-width="800px" data-layout="box_count" data-action="like" data-show-faces="false" data-share="false"></div>

<div class="ads">
    <div class="ads-inner">

        <div class="close-this">
            [x]
        </div>
        <?php echo Asset::img('newyear-offer4.png') ?>
        <img src="newyear-offer4.png" /> 
    </div>
</div>


<div id="footer-top">
    <div id="footer-top-inner" class="container">
        <div class="row">
            <div class="span6 property-listing">
                <p class="title">Property listing</p>
                <div class="row-fluid">
                    <div class="span3">
                        <ul>
                            <?php
                            foreach (idconvert::get_location_by_limit(0) as $key => $value) {
                                echo '<li><a href="' . Uri::base(false) . 'location/' . $value['locality_name'] . '">' . $value['locality_name'] . ' (' . idconvert::get_count_property_locaton($value['location_Id']) . ')</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="span3">
                        <ul>
                            <?php
                            foreach (idconvert::get_location_by_limit(10) as $key => $value) {
                                echo '<li><a href="' . Uri::base(false) . 'location/' . $value['locality_name'] . '">' . $value['locality_name'] . ' (' . idconvert::get_count_property_locaton($value['location_Id']) . ')</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="span3">
                        <ul>
                            <?php
                            foreach (idconvert::get_location_by_limit(20) as $key => $value) {
                                echo '<li><a href="' . Uri::base(false) . 'location/' . $value['locality_name'] . '">' . $value['locality_name'] . ' (' . idconvert::get_count_property_locaton($value['location_Id']) . ')</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="span3">
                        <ul>
                            <?php
                            foreach (idconvert::get_location_by_limit(30) as $key => $value) {
                                echo '<li><a href="' . Uri::base(false) . 'location/' . $value['locality_name'] . '">' . $value['locality_name'] . ' (' . idconvert::get_count_property_locaton($value['location_Id']) . ')</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="span3 ">
                <p class="title">Visit Office</p>
                Office No : 47,Kesar Garden,<br>
                Plot No-53, Sector-20,<br>
                Kharghar,Navi Mumbai - 410210 <br>
                <strong>Phone: +022-2774 2092</strong>
                <p class="title">Connect with us.</p>

                <a href="https://www.facebook.com/pages/Global-Property-Kart/408277832668136" title="Facebook"><?php echo Asset::img('fb32.png', 'img'); ?></a>
                <a href="https://twitter.com/globalproperty9" title="Twitter"><?php echo Asset::img('tw32.png', 'img'); ?></a>
                <a href="https://plus.google.com/u/0/108920282043778785652/posts" title="Google plus"><?php echo Asset::img('gp32.png', 'img'); ?></a>
                <a href="https://www.linkedin.com/profile/view?id=259958247&trk=nav_responsive_tab_profile_pic" title="Linked In"><?php echo Asset::img('li32.png', 'img'); ?></a>
                <a href="https://www.youtube.com/channel/UCAoMTD72XK3KgbDhIXXvjoA" title="YouTube"><?php echo Asset::img('yt32.png', 'img'); ?></a>

            </div>

            <div class="span3 property-listing">
                <p class="title">Navi Mumbai Real Estate</p>
                <ul>
                    <li><a href="#">Search Property</a></li>
                    <li><a href="#">Search Builder</a></li>
                    <li><a href="#">Advertise with Us</a></li>
                    <li><a href="#">Bulk Buying Power</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!--<div id="footer-top">
    <div id="footer-top-inner" class="container">
        <div class="row">
            <div class="span3">
                <div id="mostrecentproperties_widget-3" class="widget properties">

                    <h2>Most Recent Properties</h2>

                    <div class="content">
                        <div class="property clearfix">
                            <div class="image">
                                <a href="properties/property-detail.html">
                                    <img width="570" height="425" src="assets/img/property/19.jpg"
                                         class="thumbnail-image " alt="19"/>
                                </a>
                            </div>
                            

                            <div class="wrapper">
                                <div class="title">
                                    <h3><a href="properties/property-detail.html">
                                            643 37th Ave
                                        </a></h3>
                                </div>

                                <div class="location">Burrville</div>

                                <div class="price">
                                    Contact us
                                </div>
                            </div>
                        </div>

                        <div class="property-info clearfix">
                            <div class="area">
                                <i class="icon icon-normal-cursor-scale-up"></i>
                                800m<sup>2</sup>
                            </div>

                            <div class="bedrooms">
                                <i class="icon icon-normal-bed"></i>
                                2
                            </div>

                        </div>
                        <div class="property clearfix">
                            <div class="image">
                                <a href="properties/property-detail.html">
                                    <img width="570" height="425" src="assets/img/property/20.jpg"
                                         class="thumbnail-image " alt="20"/>
                                </a>
                            </div>

                            <div class="wrapper">
                                <div class="title">
                                    <h3><a href="properties/property-detail.html">
                                            2459 Tilden St
                                        </a></h3>
                                </div>

                                <div class="location">Judiciary Square</div>

                                <div class="price">
                                    500 € <span class="suffix">/ per month</span></div>
                            </div>
                        </div>

                        <div class="property-info clearfix">
                            <div class="area">
                                <i class="icon icon-normal-cursor-scale-up"></i>
                                1030m<sup>2</sup>
                            </div>

                            <div class="bedrooms">
                                <i class="icon icon-normal-bed"></i>
                                12
                            </div>

                            <div class="bathrooms">
                                <i class="icon icon-normal-shower"></i>
                                6
                            </div>
                        </div>
                        <div class="property clearfix">
                            <div class="image">
                                <a href="properties/property-detail.html">
                                    <img width="570" height="425" src="assets/img/property/17.jpg"
                                         class="thumbnail-image " alt="17"/>
                                </a>
                            </div>

                            <div class="wrapper">
                                <div class="title">
                                    <h3><a href="properties/property-detail.html">
                                            677 Cottage Terrace
                                        </a></h3>
                                </div>

                                <div class="location">Spring Valley</div>

                                <div class="price">
                                    59,600 €
                                </div>
                            </div>
                        </div>

                        <div class="property-info clearfix">
                            <div class="area">
                                <i class="icon icon-normal-cursor-scale-up"></i>
                                650m<sup>2</sup>
                            </div>

                            <div class="bedrooms">
                                <i class="icon icon-normal-bed"></i>
                                1
                            </div>

                            <div class="bathrooms">
                                <i class="icon icon-normal-shower"></i>
                                1
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="span3">
                <div id="nav_menu-2" class="widget widget-nav_menu"><h2>Helpful Links</h2>

                    <div class="menu-helpful-links-container">
                        <ul id="menu-helpful-links" class="menu">
                            <li class="menu-item"><a
                                    href="templates/default-left.html">Default Template</a></li>
                            <li class="menu-item"><a
                                    href="templates/default-right.html">Right Sidebar Template</a></li>
                            <li class="menu-item"><a
                                    href="templates/default-full.html">Fullwidth Template</a></li>
                            <li class="menu-item"><a
                                    href="properties">Properties Grid Template</a></li>
                            <li class="menu-item"><a
                                    href="faq.html">FAQ</a></li>
                            <li class="menu-item"><a
                                    href="404.html">404 page</a></li>
                            <li class="menu-item"><a
                                    href="login.html">Login Template</a></li>
                            <li class="menu-item"><a
                                    href="register.html">Register Template</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="span3">
                <div id="agents_widget-2" class="widget our-agents">

                    <h2>Agents</h2>

                    <div class="content">
                        <div class="agent clearfix">
                            <div class="image">
                                <a href="agents/agent-detail.html">
                                    <img src="assets/img/agents/2.jpg" alt="Cynthia G. Stenson">
                                </a>
                            </div>

                            <div class="name">
                                <a href="agents/agent-detail.html">Cynthia G. Stenson</a>
                            </div>

                            <div class="phone">
                                <i class="icon icon-normal-phone"></i>
                                985-632-254
                            </div>

                            <div class="email">
                                <i class="icon icon-normal-mail"></i>
                                <a href="mailto:cynthia@example.com">cynthia@example.com</a>
                            </div>
                        </div>
                        <div class="agent clearfix">
                            <div class="image">
                                <a href="agents/agent-detail.html">
                                    <img src="assets/img/agents/1.jpg" alt="Stephen E. Kennedy">
                                </a>
                            </div>

                            <div class="name">
                                <a href="agents/agent-detail.html">Stephen E. Kennedy</a>
                            </div>

                            <div class="phone">
                                <i class="icon icon-normal-phone"></i>
                                987-852-123
                            </div>

                            <div class="email">
                                <i class="icon icon-normal-mail"></i>
                                <a href="mailto:stephen@example.com">stephen@example.com</a>
                            </div>
                        </div>
                        <div class="agent clearfix">
                            <div class="image">
                                <a href="agents/agent-detail.html">
                                    <img src="assets/img/agents/2.jpg" alt="Myrtle J. Metz">
                                </a>
                            </div>

                            <div class="name">
                                <a href="agents/agent-detail.html">Myrtle J. Metz</a>
                            </div>

                            <div class="phone">
                                <i class="icon icon-normal-phone"></i>
                                987-963-654
                            </div>

                            <div class="email">
                                <i class="icon icon-normal-mail"></i>
                                <a href="mailto:myrtle@example.com">myrtle@example.com</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="span3">
                <div id="featuredproperties_widget-2" class="widget properties">

                    <h2>Featured Properties</h2>

                    <div class="content">
                        <div class="property clearfix">
                            <div class="image">
                                <a href="properties/property-detail.html">
                                    <img width="570" height="425" src="assets/img/property/1.jpg"
                                         class="thumbnail-image " alt="1"/>
                                </a>
                            </div>

                            <div class="wrapper">
                                <div class="title">
                                    <h3><a href="properties/property-detail.html">
                                            20th St NE
                                        </a></h3>
                                </div>

                                <div class="location">Benning</div>

                                <div class="price">
                                    85,600 €
                                </div>
                            </div>
                        </div>

                        <div class="property-info clearfix">
                            <div class="area">
                                <i class="icon icon-normal-cursor-scale-up"></i>
                                450m<sup>2</sup>
                            </div>

                            <div class="bedrooms">
                                <i class="icon icon-normal-bed"></i>
                                1
                            </div>

                            <div class="bathrooms">
                                <i class="icon icon-normal-shower"></i>
                                2
                            </div>
                        </div>
                        <div class="property clearfix">
                            <div class="image">
                                <a href="properties/property-detail.html">
                                    <img width="570" height="425" src="assets/img/property/12.jpg"
                                         class="thumbnail-image " alt="12"/>
                                </a>
                            </div>

                            <div class="wrapper">
                                <div class="title">
                                    <h3><a href="properties/property-detail.html">
                                            246 Varnum Pl NE
                                        </a></h3>
                                </div>

                                <div class="location">Kingman Park</div>

                                <div class="price">
                                    32,500 €
                                </div>
                            </div>
                        </div>

                        <div class="property-info clearfix">
                            <div class="area">
                                <i class="icon icon-normal-cursor-scale-up"></i>
                                500m<sup>2</sup>
                            </div>

                            <div class="bedrooms">
                                <i class="icon icon-normal-bed"></i>
                                2
                            </div>

                            <div class="bathrooms">
                                <i class="icon icon-normal-shower"></i>
                                3
                            </div>
                        </div>
                        <div class="property clearfix">
                            <div class="image">
                                <a href="properties/property-detail.html">
                                    <img width="570" height="425" src="assets/img/property/6.jpg"
                                         class="thumbnail-image " alt="6"/>
                                </a>
                            </div>

                            <div class="wrapper">
                                <div class="title">
                                    <h3><a href="properties/property-detail.html">
                                            Randolph St NW
                                        </a></h3>
                                </div>

                                <div class="location">Civic Betterment</div>

                                <div class="price">
                                    97,400 €
                                </div>
                            </div>
                        </div>

                        <div class="property-info clearfix">
                            <div class="area">
                                <i class="icon icon-normal-cursor-scale-up"></i>
                                680m<sup>2</sup>
                            </div>

                            <div class="bedrooms">
                                <i class="icon icon-normal-bed"></i>
                                3
                            </div>

                            <div class="bathrooms">
                                <i class="icon icon-normal-shower"></i>
                                2
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div> -->