<?php
echo View::forge('intro/search/header');
echo View::forge('intro/search/breadcumb');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main-block">
                <div class="property-details">
                    <span class="title"> <strong><?php echo $base_details[0]['property_name']; ?></strong> <?php echo $base_details[0]['property_area']; ?>
                        <span class="goright">
                            <span><strong><?php echo $base_details[0]['property_price']; ?></strong></span>
                        </span>
                    </span>
                    <span class="title-line">
                        <span>By <?php echo idconvert::get_property_builder($base_details[0]['builder_id']); ?></span>
                        <span class="pull-right">Negoriable</span>
                    </span>
                    <span class="title-line">
                        <span><?php echo idconvert::get_property_location($base_details[0]['location']); ?></span>
<!--                        <span class="pull-right">6000 per sqft</span>-->
                    </span>
                </div>
            </div>
            <div class="main-block-nav">
                <ul>
                    <li>
                        <a href="#" class="smoothScroll" data-to="overview">Overview</a>
                    </li>
                    <li>
                        <a href="#" class="smoothScroll" data-to="projectdetails">Project Details</a>
                    </li>
                    <!--                    <li>
                                            <a href="#" class="smoothScroll" data-to="location">Location</a>
                                        </li>-->
                    <li>
                        <a href="#" class="smoothScroll" data-to="floorplan">Floor Plan</a>
                    </li>
                    <li>
                        <a href="#" class="smoothScroll" data-to="amenities">Amenities</a>
                    </li>
                    <li>
                        <a href="#" class="smoothScroll" data-to="builderdetails">Builder Details</a>
                    </li>
                </ul>
            </div>
            <div class="main-block slider" id="smoothScroll-overview">
                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-4">
                                <a class="slide" href="<?php echo Uri::base(false) . 'assets/img/property/' . $base_details[0]['property_id'] . '-1.jpg' ?>" style="background-image:url('<?php echo Uri::base(false) . 'assets/img/property/' . $base_details[0]['property_id'] . '-1.jpg' ?>')" data-lighter>
                                </a>
                            </div>
                            <?php foreach ($property_img_details as $key => $value) { ?>
                                <div class="col-md-4">
                                    <a class="slide" href="<?php echo Uri::base(false) . 'assets/img/property/' . $value['img_name'] ?>" style="background-image:url('<?php echo Uri::base(false) . 'assets/img/property/' . $value['img_name'] ?>')" data-lighter>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class=""  id="smoothScroll-projectdetails">
                            <h4><strong>About</strong></h4>
                            <p> <?php echo Markdown::parse($base_details[0]['property_desc']); ?></p>
                            <div class="space10"></div>
                            <?php
                            $brif_detail = idconvert::get_dt_table($base_details[0]);
                            ?>
                            <table class="table">
                                <?php foreach ($brif_detail as $key => $value) { ?>
                                    <tr>
                                        <td>
                                            <?php echo $value['name']; ?>
                                        </td>
                                        <td>
                                            <strong><?php echo $value['value']; ?></strong>
                                        </td>
                                    </tr>
                                <?php } ?>                               
                            </table>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-3">
                        <!-- FORM USED IN JQUERY_CONFIRM AS CONTENT -->

                        <div class="detail-right-box">
                            <a href="" class="btn btn-warning btn-block btn-lg btn-action-contact" data-propertyid="<?php echo $base_details[0]['property_id']; ?>">
                                Contact Owner
                            </a>
                            <div class="space10"></div>
                            <a href="#" class="btn btn-default btn-block btn-action-viewnumber" data-propertyid="<?php echo $base_details[0]['property_id']; ?>">
                                View phone no.
                            </a>
                            <!--<div class="space10"></div>-->
                            <!--                            <div class="btn-group btn-group-justified">
                                                            <a href="<?php echo Uri::base(false) . 'user/user/addcart/' . $base_details[0]['property_id']; ?>" class="btn btn-default btn-shortlist">Shortlist</a>
                                                        </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $distance_data = idconvert::get_dt_distance($distance_details[0]);
            if (!empty($distance_data)) {
                ?>
                <div class="main-block" id="smoothScroll-location">
                    <div class="about-seller">
                        <span class="title">Distance From Key Facilities</span>
                        <div class="space10"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered table-condensed">
                                    <?php foreach ($distance_data as $key => $value) { ?>
                                        <tr>
                                            <td style="width: 25%">
                                                <strong><?php echo $value['name']; ?></strong>
                                            </td>
                                            <td  style="width: 25%">
                                                <?php echo $value['value']; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <!--                            To add table on right side-->
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="main-block slider" id="smoothScroll-floorplan">
                <div class="about-seller">
                    <span class="title">Floor Plan</span>
                    <div class="space10"></div>
                    <div class="row">
                        <?php foreach ($property_img_floor as $key => $value) { ?>
                            <div class="col-md-3">
                                <a class="slide" href="<?php echo Uri::base(false) . 'assets/img/property/' . $value['img_name'] ?>" style="background-image:url('<?php echo Uri::base(false) . 'assets/img/property/' . $value['img_name'] ?>')" data-lighter></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php
//            $property_details_data = idconvert::get_dt_project_floor_details($property_details[0]);
//            $property_details_data = $property_details[0];
            if (!empty($property_details)) {
                ?>
                <div class="main-block" >
                    <div class="about-seller">
                        <span class="title">Floor Details</span>
                        <div class="space10"></div>
                        <table class="table">
                            <tr>
                                <th>Type</th>
                                <th>BHK</th>
                                <th>Size</th>
                                <th>Price Per Sq. Ft</th>
                                <th>Total Price</th>
                            </tr> 
                            <?php
                            foreach ($property_details as $pd_key => $pd_value) {
                                $bhk = idconvert::get_floor($pd_value['bhk']);
                                ?>
                                <tr>
                                    <?php
                                    echo '<th>' . $pd_value['type'] . '</th>';
                                    echo '<th>' . $bhk[0]['floor_name'] . '</th>';
                                    echo '<th>' . $pd_value['size'] . '</th>';
                                    echo '<th>Rs. ' . $pd_value['priceper'] . '</th>';
                                    if ($pd_value['visibility'] == 'Yes') {
                                        echo '<th>Rs. ' . $pd_value['totalprice'] . '</th>';
                                    } else {
                                        echo '<th><a href="" class="btn btn-warning btn-sm btn-action-contact" data-propertyid="' . $base_details[0]['property_id'] . '">Contact Owner</a></th>';
                                    }
                                    ?>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="main-block" id="smoothScroll-amenities">
        <div class="about-seller">
            <span class="title">Amenities</span>
            <div class="space10"></div>
            <div class="row">
                <div class="col-md-3">
                    <ul class="amenities">    
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['in_vastu']); ?>">Vastu</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['in_intercom']); ?>">Inter Com</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_gym']); ?>">GYM</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_security']); ?>">Security</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_swimming']); ?>">Swimming</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_lift']); ?>">Lift</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_parking']); ?>">Parking</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <ul class="amenities">
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_powerbackup']); ?>">Power Backup</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_communityhall']); ?>">Community Hall</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_badmintoncourt']); ?>">Badminton Court</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_cardroom']); ?>">Card Room</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_cafeteria']); ?>">Cafe Teria</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_library']); ?>">Library</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_indoorgames']); ?>">Indoor Games</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <ul class="amenities">
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_lift']); ?>">Lift</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_parking']); ?>">Parking</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_powerbackup']); ?>">Power Backup</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_babypool']); ?>">Baby Pool</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_joggingtrack']); ?>">Jogging Track</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_landscapegarden']); ?>">Land Scape Garden</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_amphitheatre']); ?>">Amphi Theatre</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <ul class="amenities">
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_temple']); ?>">Temple</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_minitheatre']); ?>">Mini Theatre</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_jacuzzis']); ?>">Jacuzzis</li>
                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_medicationlawn']); ?>">Medication Lawn</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <?php $resent_property_list = Model_Property::get_recentproperty(3); ?>
    <div class="main-block">
        <div class="similar">
            <span class="title">Similar Properties</span>
            <div class="sliderContainer">
                <div class="flexslider carousel">
                    <ul class="slides">
                        <li>
                            <div class="row">
                                <?php
                                foreach ($resent_property_list as $rest_key => $rest_value) {
                                    ?>
                                    <div class="col-md-4">
                                        <a href="#">
                                            <div class="property-small">
                                                <div class="image" style="background-image: url('<?php echo Uri::base(false) . 'assets/img/property/' . $rest_value['property_id'] . '-1.jpg';
                                    ?>')"></div>
                                                <div class="contents">
                                                    <span><?php echo $rest_value['property_name']; ?></span>
                                                    <span><strong><?php echo $rest_value['project_details']; ?></strong></span>
                                                    <span><?php echo idconvert::get_property_location($rest_value['location']); ?></span>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="main-block" id="smoothScroll-builderdetails">
        <div class="about-seller">
            <span class="title">About the Builder</span>
            <div class="space10"></div>
            <p><strong><?php echo idconvert::get_property_builder($base_details[0]['builder_id']); ?></strong></p>
            <p> <?php echo idconvert::get_property_builder_desc($base_details[0]['builder_id']); ?></p>
        </div>

    </div>
</div>
</div>
</div>
<?php
echo View::forge('intro/search/footer');
?>
</body>
</html>
