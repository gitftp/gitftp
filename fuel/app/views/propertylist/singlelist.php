<div class="container">
    <div class="row">
        <?php echo $welcomesidebar; ?>
        <!-- /#sidebar -->
        <div id="main" class="span9 single-property">

            <h1 class="page-header fl"><?php echo $detailsdata[0]['property_name']; ?>,</h1>
            <span><?php echo idconvert::get_property_location($detailsdata[0]['location']); ?></span>
            <div class="property-detail">

                <div class="row">
                    <div class="span6 gallery">
                        <div class="preview">
                            <img src="<?php echo Uri::base(false) . 'assets/img/property/' . $detailsdata[0]['property_id'] . '-1.jpg'; ?>" alt="" style="height: 450px;">
                        </div>

                        <div class="content">
                            <ul>
                                <li class="active">
                                    <div class="thumb">
                                        <a href="#"><img src="<?php echo Uri::base(false) . 'assets/img/property/' . $detailsdata[0]['property_id'] . '-1.jpg'; ?>" alt=""></a>
                                    </div>
                                </li>
                                <li class="active">
                                    <div class="thumb">
                                        <a href="#"><img src="<?php echo Uri::base(false) . 'assets/img/property/' . $detailsdata[0]['property_id'] . '-2.jpg'; ?>" alt=""></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="thumb">
                                        <a href="#"><img src="<?php echo Uri::base(false) . 'assets/img/property/' . $detailsdata[0]['property_id'] . '-3.jpg'; ?>" alt=""></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- /.content -->
                    </div>

                    <div class="overview">
                        <div class="pull-right overview">
                            <div class="row">
                                <div class="span3">
                                    <!-- <h2>Overview</h2> -->

                                    <table>
                                        <tbody>
                                            <tr>
                                                <th>Property ID:</th>
                                                <td><strong>#<?php echo $detailsdata[0]['property_id']; ?></strong></td>
                                            </tr>                                           
                                            <tr>
                                                <th>Stage of Construction:</th>
                                                <td >
                                                    <?php echo idconvert::get_property_conduction($detailsdata[0]['property_conduction']); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                            <tr>
                                                <th>Property type:</th>
                                                <td >
                                                    <?php echo idconvert::get_property_type($detailsdata[0]['property_type']); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Location:</th>
                                                <td><?php echo idconvert::get_property_location($detailsdata[0]['location']); ?></td>
                                            </tr>
                                            <tr>
                                                <th>BHK:</th>
                                                <td><?php echo $detailsdata[0]['project_details']; ?></td>
                                            </tr>
                                            <?php if ($detailsdata[0]['possesion_date'] != 0) { ?>
                                                <tr>
                                                    <th>Possession Date:</th>
                                                    <td class="price"><?php echo $detailsdata[0]['possesion_date']; ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="2" class="builder-name"><?php echo Asset::img('builder_logo/' . idconvert::get_property_builder_img($detailsdata[0]['builder_id']), array('width' => '100%')); ?></td>
                                            </tr>
                                            <?php if ($detailsdata[0]['area'] != 0) { ?>
                                                <tr>
                                                    <th>Area:</th>
                                                    <td><?php echo $detailsdata[0]['area']; ?></td>
                                                </tr>                                        
                                            <?php } ?>
                                            <tr>
                                                <th><button onclick="$('#property-inquery-form-sg').show();
                                                        $(this).hide();" class="btn btn-primary">Contact Us</button></th>
                                                <td colspan="2" class="builder-name"></td>
                                            </tr>
                                        </tbody>
                                    </table>


                                    <form method="POST" action="<?php echo Uri::base(false) . 'user/propertyenq'; ?>" class="site-search"  id="property-inquery-form-sg" style="display:none">
                                        <h3>Contact</h3>
                                        <div class="form-group">
                                            <label for="">Name</label>
                                            <input type="text" placeholder="Name" name="name" class="form-control" style="display:block; width:100%">
                                            <input type="hidden" name="property_id" id="property_enquiry_id-sg" value="<?php echo $detailsdata[0]['property_id']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="text" placeholder="Email"  name="email" class="form-control" style="display:block; width:100%">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Mobile no.</label>
                                            <input type="text" placeholder="Mobile no." name="mobileno" class="form-control" style="display:block; width:100%">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Request.</label>
                                            <textarea style="display:block; width:100%; height: 80px">Yes, I am interested in <?php echo idconvert::get_property_type($detailsdata[0]['property_type']) . ' property name' . $detailsdata[0]['property_name'] . ', ' . idconvert::get_property_location($detailsdata[0]['location']) . '. Project Id:- ' . $detailsdata[0]['property_id']; ?></textarea>
                                        </div>
                                        <div style="height: 10px;"></div>
                                        <button type="submit" class="btn btn-primary pull-right" id="property-inquery-btn">Send</button>
                                        <div class="clear"></div> 
                                    </form>

                                </div>
                                <!-- /.span2 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.overview -->        </div>
                </div>

                <table style="width: 100%" class="table-responsive table">
                    <tr style="background-color: rgb(0, 64, 80);color: white;">
                        <th>About Property</th>
                    </tr>
                    <tr>
                        <td ><?php echo $detailsdata[0]['property_desc']; ?></td>
                    </tr>

                </table>
                <p>
                <table style="width: 100%" class="table-responsive table">
                    <tr style="background-color: rgb(0, 64, 80);color: white;">
                        <th>Type</th>
                        <th>BHK</th>
                        <th>Size</th>
                        <th>Price Per Sq. Ft</th>
                        <th>Total Price</th>
                    </tr>

                    <?php
                    if (!empty($property_details)) {
                        foreach ($property_details as $key => $value) {
                            $bhk = idconvert::get_floor($value['bhk']);
                            echo '<tr>';
                            echo '<td>' . $value['type'] . '</td>';
                            echo '<td>' . $bhk[0]['floor_name'] . '</td>';
                            echo '<td>' . $value['size'] . ' Sqft</td>';
                            if ($value['visibility'] == 'No') {
                                $tempver = "'.popup.example'";
                                echo '<td colspan="2"><a href="#" onclick="$(' . $tempver . ').show()"><strong>Price on Request</strong></a></td>';
                            } else {
                                echo '<td>' . $value['priceper'] . '</td>';
                                echo '<td>' . $value['totalprice'] . '</td>';
                            }
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">Sorry no details to display.</td></tr>';
                    }
                    ?>

                </table>
                </p>
                <?php if ($detailsdata[0]['property_address'] != '') { ?>
                    <h2>Address</h2>
                    <p><?php echo $detailsdata[0]['property_address']; ?></p>
                <?php } ?>


                <div class="row">
                    <div class="span6">
                        <div class="row">
                            <div class="span6">
                                <h2>General amenities</h2>

                                <div class="row">
                                    <ul class="span2">
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['in_vastu']); ?>">Vastu</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['in_intercom']); ?>">Inter Com</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_gym']); ?>">GYM</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_security']); ?>">Security</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_swimming']); ?>">Swimming</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_lift']); ?>">Lift</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_parking']); ?>">Parking</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_powerbackup']); ?>">Power Backup</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_communityhall']); ?>">Community Hall</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_badmintoncourt']); ?>">Badminton Court</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_cardroom']); ?>">Card Room</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_cafeteria']); ?>">Cafe Teria</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_library']); ?>">Library</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_indoorgames']); ?>">Indoor Games</li>
                                    </ul>
                                    <!-- /.span2 -->
                                    <ul class="span2">
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_lift']); ?>">Lift</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_parking']); ?>">Parking</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_powerbackup']); ?>">Power Backup</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_babypool']); ?>">Baby Pool</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_joggingtrack']); ?>">Jogging Track</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_landscapegarden']); ?>">Land Scape Garden</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_amphitheatre']); ?>">Amphi Theatre</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_temple']); ?>">Temple</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_minitheatre']); ?>">Mini Theatre</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_jacuzzis']); ?>">Jacuzzis</li>
                                        <li class="<?php echo idconvert::get_am_checked($amut_data[0]['ex_medicationlawn']); ?>">Medication Lawn</li>
                                    </ul>



                                </div>

                                <!-- /.row -->
                            </div>
                            <!-- /.span12 -->
                        </div>
                        <!-- /.row -->
                    </div>

                    <div class="span3">
                        <h2>Distance From Key Facilities</h2>
                        <!--<div><strong>Distance From Key Facilities</strong></div>-->
                        <ul class="span2">
                            <?php echo idconvert::get_dist_def($distance_details[0]['hospital_dis'], 'Hospital'); ?>
                            <?php echo idconvert::get_dist_def($distance_details[0]['school_dis'], 'School'); ?> 
                            <?php echo idconvert::get_dist_def($distance_details[0]['railway_dis'], ''); ?>
                            <?php echo idconvert::get_dist_def($distance_details[0]['airport_dis'], 'Railway Station'); ?>
                            <?php echo idconvert::get_dist_def($distance_details[0]['bus_depot'], 'Bus Depot'); ?>
                        </ul>
                        <!--                        <div id="property-map"
                                                     style="position: relative; background-color: rgb(229, 227, 223); overflow: hidden; -webkit-transform: translateZ(0);">
                                                </div>-->

<!--                        <script type="text/javascript">
                            jQuery(document).ready(function($) {
                                function LoadMapProperty() {
                                    var locations = new Array(
                                            [38.951399, -76.958463]
                                            );
                                    var types = new Array(
                                            'family-house'
                                            );
                                    var markers = new Array();
                                    var plainMarkers = new Array();

                                    var mapOptions = {
                                        center: new google.maps.LatLng(38.951399, -76.958463),
                                        zoom: 14,
                                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                                        scrollwheel: false
                                    };

                                    var map = new google.maps.Map(document.getElementById('property-map'), mapOptions);

                                    $.each(locations, function(index, location) {
                                        var marker = new google.maps.Marker({
                                            position: new google.maps.LatLng(location[0], location[1]),
                                            map: map,
                                            icon: '../assets/img/marker-transparent.png'
                                        });

                                        var myOptions = {
                                            draggable: true,
                                            content: '<div class="marker ' + types[index] + '"><div class="marker-inner"></div></div>',
                                            disableAutoPan: true,
                                            pixelOffset: new google.maps.Size(-21, -58),
                                            position: new google.maps.LatLng(location[0], location[1]),
                                            closeBoxURL: "",
                                            isHidden: false,
                                            // pane: "mapPane",
                                            enableEventPropagation: true
                                        };
                                        marker.marker = new InfoBox(myOptions);
                                        marker.marker.isHidden = false;
                                        marker.marker.open(map, marker);
                                        markers.push(marker);
                                    });

                                    google.maps.event.addListener(map, 'zoom_changed', function() {
                                        $.each(markers, function(index, marker) {
                                            marker.infobox.close();
                                        });
                                    });
                                }

                                google.maps.event.addDomListener(window, 'load', LoadMapProperty);

                                var dragFlag = false;
                                var start = 0, end = 0;

                                function thisTouchStart(e) {
                                    dragFlag = true;
                                    start = e.touches[0].pageY;
                                }

                                function thisTouchEnd() {
                                    dragFlag = false;
                                }

                                function thisTouchMove(e) {
                                    if (!dragFlag)
                                        return;
                                    end = e.touches[0].pageY;
                                    window.scrollBy(0, (start - end));
                                }

                                document.getElementById("property-map").addEventListener("touchstart", thisTouchStart, true);
                                document.getElementById("property-map").addEventListener("touchend", thisTouchEnd, true);
                                document.getElementById("property-map").addEventListener("touchmove", thisTouchMove, true);
                            });

                        </script>-->
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .popup{
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        top: 0;
        background-color: rgba(0,0,0,.8);
        z-index: 9999999999;
        display: none;
    }
    .popup .popupclose{
        position: absolute;
        right: 25px;
        top: 25px;
        color: white;
        font-size: 20px;
        cursor: pointer;
    }
    .popup .popup-inner{
        background-color: white;
        border-radius: 3px;
        padding: 10px;
        top: 250px;
        margin-top: 10px;
    }
</style>

<!--
<div class="popup example">
    <div class="popupclose" onclick="$(this).parent().hide();
            return false;">[x]</div>
    <div class="container">
        <div class="row">
            <div class="span6 offset3">
                <div class="popup-inner">
                    <form action="">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" placeholder="Name" class="form-control" style="display:block; width:100%">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" placeholder="Email" class="form-control" style="display:block; width:100%">
                        </div>
                        <div class="form-group">
                            <label for="">Mobile no.</label>
                            <input type="text" placeholder="Mobile no." class="form-control" style="display:block; width:100%">
                        </div>
                        <div style="height: 10px;"></div>
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>-->
