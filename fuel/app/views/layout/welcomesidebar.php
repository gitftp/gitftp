<div class="sidebar span3">
    <?php if (isset($request)) { ?>
        <div id="quick-search" class="widget widget-search"><h2>Request for </h2>

            <div class="content">
                <form method="POST" action="<?php echo Uri::base(false) . 'user/propertyenq'; ?>" class="site-search" action="javascript:void(0);" id="property-inquery-form">
                    <input class="search-query form-text" placeholder="Name" type="text" name="name" id="name">
                    <input class="search-query form-text" placeholder="Mobile No" type="text" name="mobileno" id="mobileno" >
                    <input class="search-query form-text" placeholder="Email" type="text" name="email" id="email">
                    <input class="search-query form-text" placeholder="Email" type="hidden" name="property_id" id="property_enquiry_id" value="<?php echo $request[0]['property_id']; ?>">
                    <textarea placeholder="" style="height: 100px">Yes, I am interested in <?php echo idconvert::get_property_type($request[0]['property_type']) . ' property name' . $request[0]['property_name'] . ', ' . idconvert::get_property_location($request[0]['location']) . '. Project Id:- ' . $request[0]['property_id']; ?></textarea>
                    <div id="property-inquery-msg"></div>
                    <button type="submit" class="btn" id="property-inquery-btn">Request</button>
                </form>
                <!-- /.site-search -->
            </div>
            <!-- /.inner -->
        </div>                
    <?php } ?>
    <!--    <div id="quick-search" class="widget widget-search"><h2>Quick Search</h2>
    
            <div class="content">
                <form method="get" class="site-search" action="javascript:void(0);">
                    <input class="search-query form-text" placeholder="Search" type="text" name="s" id="s" value="">
                    <button type="submit" class="btn">Search</button>
                </form>
                 /.site-search 
            </div>
             /.inner 
        </div>                -->
    <div id="partners_widget-2" class="widget partners">

        <h2>Builder</h2>

        <div class="partners">
            <div class="row">
                <div class="span3">
                    <div class="partner">
                        <a href="http://lodhadowntown-palava.com/">
                            <img width="270" height="70" src="<?php echo Uri::base(false); ?>assets/img/builder_logo/LODHA_logo_new.jpg"
                                 class="thumbnail-image" alt="themeforest"/>
                        </a>
                    </div>
                </div>
                <div class="span3">
                    <div class="partner">
                        <a href="http://globalpropertykart.com/">
                            <img width="270" height="70" src="<?php echo Uri::base(false); ?>assets/img/builder_logo/Marathon-NewLogo-resized1.png"
                                 class="thumbnail-image" alt="themeforest"/>
                        </a>
                    </div>
                </div>
                <!-- /.span3 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.partners -->
    </div>                <div id="mostrecentproperties_widget-2" class="widget properties">

        <h2>Most Recent Properties</h2>

        <div class="content">
            <marquee direction="up" onmouseover="this.stop();" onmouseout="this.start();">
                <?php foreach ($recentproperty as $key => $value) { ?>
                    <div class="property clearfix">
                        <div class="image">
                            <a href="<?php echo Uri::base(false) . 'welcome/singlelist/' . $value['property_id']; ?>">
                                <img width="570" height="425" src="<?php echo Uri::base(false) . 'assets/img/property/' . $value['property_id'] . '-1.jpg' ?>"  class="thumbnail-image " alt="19"/>
                            </a>
                        </div>
                        <!-- /.image -->

                        <div class="wrapper">
                            <div class="title">
                                <h3><a href="<?php echo Uri::base(false) . 'welcome/singlelist/' . $value['property_id']; ?>">
                                        <?php echo $value['property_name']; ?>
                                    </a></h3>
                            </div>
                            <!-- /.title -->

                            <div class="location"> <?php echo idconvert::get_property_location($value['location']); ?> </div>
                            <!-- /.location -->
                            <div class="location"> <?php echo idconvert::get_property_conduction($value['property_conduction']); ?> </div>
                            <div class="location"> <?php
                                if ($value['property_price'] != '') {
                                    echo $value['property_price'];
                                }
                                ?></div>
                            <!-- /.price -->
                        </div>
                        <!-- /.wrapper -->
                    </div>
                    <!-- /.property -->

                    <div class="property-info clearfix">
                        <div class="area">
                            <i class="icon icon-normal-cursor-scale-up"></i>
                            <?php echo $value['project_details']; ?>
                        </div>
                        <!-- /.area -->
                    </div>
                    <!-- /.info -->
                <?php } ?>
            </marquee>
        </div>
        <!-- /.content -->

    </div>                
    <div id="agencies_widget-2" class="widget agencies">
        <h2>Contact</h2>
        <div class="content">
            <div class="agency clearfix">
                <div class="header">
                    <!--                    <div class="image">
                                            <a href="agencies/agency-detail.html">
                                                <img src="assets/img/agency-small-tmp.png" alt="Beverly Hills Real Estate">
                                            </a>
                                        </div>-->
                    <!-- /.image -->

                    <div class="info">
                        <h2>Global Real Estate</h2> 
                    </div>
                    <!-- /.info -->
                </div>
                <!-- /.header -->

                <div class="address">
                    Shop No : 47,Kesar Garden,Plot No-53, Sector-20,Kharghar,Navi Mumbai - 410210 
                    <br/>

                </div>
                <!-- /.address -->

                <div class="email">
                    <a href="mailto:info@globalpropertykart.com">info@globalpropertykart.com</a>
                </div>
                <!-- /.email -->

                <div class="phone">
                    022-27742092
                </div>
                <!-- /.phone -->

            </div>          
        </div>
        <!-- /.content -->
    </div> 
    <div id="agencies_widget-2" class="widget agencies">
        <h2>Feedback</h2> <button class="btn btn-default add-feedback">Submit Feedback</button>
        <div class="content">
            <marquee direction="up" onmouseover="this.stop();" onmouseout="this.start();">
                <!--                <div class="agency clearfix">
                                    <div class="header">
                                                            <div class="image">
                                                                <a href="agencies/agency-detail.html">
                                                                    <img src="assets/img/agency-small-tmp.png" alt="Beverly Hills Real Estate">
                                                                </a>
                                                            </div>
                                         /.image 
                                        <div class="info">
                                            <h2>Gaurish Rane</h2> 
                                        </div>
                                         /.info 
                                    </div>
                                     /.header 
                                    <div>
                                        Hi Global Team,<br>
                                        Just wanted to let you know how impressed I am with Global Property Services work of finding me a homely property
                                        <br/>
                                    </div>
                                     /.address 
                                </div> -->

            </marquee>
        </div>
        <!-- /.content -->
    </div> 
</div>