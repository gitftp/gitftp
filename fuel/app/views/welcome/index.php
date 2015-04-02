<!DOCTYPE HTML>
<!--[if gt IE 8]> <html class="ie9" lang="en"> <![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml" class="ihome">

    
    <head>
        <?php echo $header; ?>

    </head>
    <body>
        <div id="loader-overlay"><img src="<?php echo Uri::base(false) ?>assets/img/loader.gif" alt="Loading" /></div>

        <header>

            <div class="header-bg">

                <div id="search-overlay">
                    <div class="container">
                        <div id="close">X</div>

                        <input id="hidden-search" type="text" placeholder="Start Typing..." autofocus autocomplete="off"  /> <!--hidden input the user types into-->
                        <input id="display-search" type="text" placeholder="Start Typing..." autofocus autocomplete="off" /> <!--mirrored input that shows the actual input value-->
                    </div></div>


                <!--Topbar-->
                <div class="topbar-info no-pad">                    
                    <div class="container">                     
                        <div class="social-wrap-head col-md-2 no-pad">
                            <ul>
                                <li><a href="#"><i class="icon-facebook head-social-icon" id="face-head" data-original-title="" title=""></i></a></li>
                                <li><a href="#"><i class="icon-social-twitter head-social-icon" id="tweet-head" data-original-title="" title=""></i></a></li>
                                <li><a href="#"><i class="icon-google-plus head-social-icon" id="gplus-head" data-original-title="" title=""></i></a></li>
                                <li><a href="#"><i class="icon-linkedin head-social-icon" id="link-head" data-original-title="" title=""></i></a></li>
                                <li><a href="#"><i class="icon-rss head-social-icon" id="rss-head" data-original-title="" title=""></i></a></li>
                            </ul>
                        </div>                            
                        <div class="top-info-contact pull-right col-md-6">Call Us Today! +123 455 755  |    contact@nubello.com  <div id="search" class="fa fa-search search-head"></div>
                        </div>                      
                    </div>
                </div><!--Topbar-info-close-->





                <div id="headerstic">

                    <div class=" top-bar container">
                        <div class="row">
                            <nav class="navbar navbar-default" role="navigation">
                                <div class="container-fluid">
                                    <!-- Brand and toggle get grouped for better mobile display -->
                                    <div class="navbar-header">

                                        <button type="button" class="navbar-toggle icon-list-ul" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                            <span class="sr-only">Toggle navigation</span>
                                        </button>
                                        <button type="button" class="navbar-toggle icon-rocket" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                                            <span class="sr-only">Toggle navigation</span>
                                        </button>

                                        <a href="<?php echo Uri::base(false);?>"><div class="logo"></div></a>
                                    </div>

                                    <!-- Collect the nav links, forms, and other content for toggling -->
                                    <?php echo $nav; ?>
                                    <!-- /.navbar-collapse -->



                                    <div class="hide-mid collapse navbar-collapse option-drop" id="bs-example-navbar-collapse-2">


                                        <ul class="nav navbar-nav navbar-right other-op">
                                            <li><i class="icon-phone2"></i>+91 9028556688</li>
                                            <li><i class="icon-mail"></i><a href="#" class="mail-menu">demo@companyname.com</a></li>

                                            <li><i class="icon-globe"></i>
                                                <a href="#" class="mail-menu"><i class="icon-facebook"></i></a>
                                                <a href="#" class="mail-menu"><i class="icon-google-plus"></i></a>
                                                <a href="#" class="mail-menu"><i class="icon-linkedin"></i></a>
                                                <a href="#" class="mail-menu"><i class="icon-social-twitter"></i></a>
                                            </li>
                                            <li><i class="icon-search"></i>
                                                <div class="search-wrap"><input type="text" id="search-text" class="search-txt" name="search-text">
                                                        <button id="searchbt" name="searchbt" class="icon-search search-bt"></button></div>
                                            </li>

                                        </ul>
                                    </div><!-- /.navbar-collapse -->

                                    <div class="hide-mid collapse navbar-collapse cart-drop" id="bs-example-navbar-collapse-3">



                                        <ul class="nav navbar-nav navbar-right">
                                            <li><a href="#"><i class="icon-cart"></i>0 item(s) - $0.00</a></li>
                                            <li><a href="#"><i class="icon-user"></i>My Account</a></li>
                                        </ul>
                                    </div><!-- /.navbar-collapse -->



                                </div><!-- /.container-fluid -->
                            </nav>
                        </div>    
                    </div><!--Topbar End-->
                </div>
            </div>
        </header>
        <!--long-version-->
        <!--Container start-->
        <?php echo $contain; ?>
        <!--Container end-->

        </div>
        <?php echo $switch; ?>

        <div class="complete-footer">
            <footer id="footer">

                <div class="container">
                    <div class="row">
                        <!--Foot widget-->
                        <div class="col-xs-12 col-sm-6 col-md-3 foot-widget">
                            <a href="#"><div class="foot-logo col-xs-12 no-pad"></div></a>

                            <address class="foot-address">
                                <div class="col-xs-12 no-pad"><i class="icon-globe address-icons"></i>Nubello Clinic <br />123 Fifth Avenue <br />New York, NY 10160</div>
                                <div class="col-xs-12 no-pad"><i class="icon-phone2 address-icons"></i>+123 455 755</div>
                                <div class="col-xs-12 no-pad"><i class="icon-file address-icons"></i>+123 555 755</div>
                                <div class="col-xs-12 no-pad"><i class="icon-mail address-icons"></i>contact@nubelloclinic.com</div>
                            </address>
                        </div>

                        <!--Foot widget-->
                        <!-- <div class="col-xs-12 col-sm-6 col-md-3 recent-post-foot foot-widget">
                            <div class="foot-widget-title">Recent Posts</div>
                            <ul>
                                <li><a href="#">Consecte tur adipiscing elit ut eunt<br /><span class="event-date">3 days ago</span></a></li>
                                <li><a href="#">Fusce vel tempus augue nunc<br /><span class="event-date">5 days ago</span></a></li>
                                <li><a href="#">Lorem nulla, vitae eleifend leo tincidunt<br /><span class="event-date">7 days ago</span></a></li>
                            </ul>
                        </div> -->

                        <!--Foot widget-->
                       <!--  <div class="col-xs-12 col-sm-6 col-md-3 recent-tweet-foot foot-widget">
                            <div class="foot-widget-title">Recent News</div>
                            <ul>
                                <li>Integer iaculis egestas odio. eget: <b>t.co/RTSoououIdg</b><br /><span class="event-date">7 days ago</span></li>
                                <li>Integer iaculis egestas odio. eget: <b>t.co/RTSoououIdg</b><br /><span class="event-date">7 days ago</span></li>
                            </ul>
                        </div> -->

                        <div class="col-xs-12 col-sm-6 col-md-6 footer-links foot-widget">
                            <div class="foot-widget-title">Services</div>
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- <p>asdsad</p> -->
                                    <ul>
                                        <li>FUE Hair Transplant</li>
                                        <li>FUE Hair Transplant</li>
                                        <li>FUE Hair Transplant</li>
                                        <li>FUE Hair Transplant</li>
                                        <li>FUE Hair Transplant</li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <ul>
                                        <li>FUE Hair Transplant</li>
                                        <li>FUE Hair Transplant</li>
                                        <li>FUE Hair Transplant</li>
                                        <li>FUE Hair Transplant</li>
                                        <li>FUE Hair Transplant</li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <ul>
                                        <li>FUE Hair Transplant</li>
                                        <li>FUE Hair Transplant</li>
                                        <li>FUE Hair Transplant</li>
                                        <li>FUE Hair Transplant</li>
                                        <li>FUE Hair Transplant</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                
<style>
    
.footer-links li{
    color: white;
    margin-bottom: 5px;
}

</style>

                        <!--Foot widget-->
                        <div class="col-xs-12 col-sm-6 col-md-3 foot-widget">
                            <div class="foot-widget-title">newsletter</div>
                            <p>Get latest news for best deals.</p>
                            <div class="news-subscribe"><input type="text" class="news-tb" placeholder="Email Address" /><button class="news-button">Subscribe</button></div>
                            <div class="foot-widget-title">social media</div>
                            <div class="social-wrap">
                                <ul>
                                    <li><a href="#"><i class="icon-facebook foot-social-icon" id="face-foot" data-toggle="tooltip" data-placement="bottom" title="Facebook"></i></a></li>
                                    <li><a href="#"><i class="icon-social-twitter foot-social-icon" id="tweet-foot" data-toggle="tooltip" data-placement="bottom" title="Twitter"></i></a></li>
                                    <li><a href="#"><i class="icon-google-plus foot-social-icon" id="gplus-foot" data-toggle="tooltip" data-placement="bottom" title="Google+"></i></a></li>
                                    <li><a href="#"><i class="icon-linkedin foot-social-icon" id="link-foot" data-toggle="tooltip" data-placement="bottom" title="Linked in"></i></a></li>
                                    <li><a href="#"><i class="icon-rss foot-social-icon" id="rss-foot" data-toggle="tooltip" data-placement="bottom" title="RSS"></i></a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>       

            </footer>

            <div class="bottom-footer">
                <div class="container">

                    <div class="row">
                        <!--Foot widget-->
                        <div class="col-xs-12 col-sm-12 col-md-12 foot-widget-bottom">
                            <p class="col-xs-12 col-md-5 no-pad">&copy; 2014 nubelloclinic | All Rights Reserved</p>
                            <ul class="foot-menu col-xs-12 col-md-7 no-pad">
                                <li><a href="about-us-1.html">Pages</a></li>    
                                <li><a href="gallery-3-columns.html">Gallery</a></li>
                                <li><a href="blog-masonry-full-width.html">Blog</a></li>    
                                <li><a href="#">Features</a></li>    
                                <li><a href="contact-2.html">Contact</a></li>    
                                <li><a href="index-2.html">home</a></li>                           

                            </ul>
                        </div>
                    </div>
                </div> 
            </div>

        </div>



        <!--JS Inclution-->
        <?php echo $footerscript; ?>

    </body>

    <!-- Mirrored from imedica.sharkslab.com/HTML/home-page-5.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 05 Jan 2015 08:46:30 GMT -->
</html>
