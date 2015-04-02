<div class="container">
    <div class="row">

        <?php echo $welcomesidebar; ?>
        <!-- /#sidebar -->

        <div id="main" class="span9">
            <h2>Featured Properties</h2>
            <div class="properties-grid featured">
                <div class="row">
                    <?php foreach ($propertydatafeat as $key => $value) { ?>
                        <div class="span9">
                            <div class="property">
                                <div class="image">
                                    <a href="<?php echo Uri::base(false) . 'welcome/singlelist/' . $value['property_id']; ?>">
                                        <div class="content" style="background-image:url('<?php echo Asset::get_file('property/' . $value['property_id'] . '-1.jpg', 'img') ?>');background-size: cover;background-position:center top;height:250px; ">
                                        </div>
                                    </a>
                                    <!-- /.content -->

                                    <div class="rent-sale">
                                        <?php echo idconvert::get_property_conduction($value['property_conduction']); ?>
                                    </div>
                                    <!-- /.rent-sale -->

                                    <div class="builder-name">
                                        <?php
                                        //echo idconvert::get_property_builder_img($value['builder_id']);
                                        echo Asset::img('builder_logo/' . idconvert::get_property_builder_img($value['builder_id']));
                                        ?>
                                        <?php //echo '<img src"'.Uri::base(false).'assets/img/builder_logo/'.idconvert::get_property_builder_img($value['builder_id']).'">';   ?>
                                    </div>

                                    <div class="add-to-fav">
                                        <a class="addtocart" data-property-id="<?php echo $value['property_id']; ?>" href="<?php echo Uri::base(false) . 'user/addcart/' . $value['property_id']; ?>" title="add to favourites"><?php echo Asset::img('shopping232-add.png'); ?></a>
                                    </div>

                                    <?php
                                    if ($value['property_price'] != '') {
                                        echo '<div class="price">' . $value['property_price'] . '</div>';
                                    }
                                    ?>
                                    <!-- /.price -->

                                </div>
                                <!-- /.image -->

                                <div class="info">
                                    <div class="title clearfix">
                                        <h2><a href="<?php echo Uri::base(false) . 'welcome/singlelist/' . $value['property_id']; ?>">
                                                <?php echo $value['property_name']; ?>
                                            </a></h2>
                                    </div>
                                    <!-- /.title -->

                                    <div class="location"><?php echo idconvert::get_property_location($value['location']); ?></div>
                                    <?php if ($value['property_area'] != 0) { ?>
                                        <div class="location"><?php echo $value['property_area']; ?></div>
                                    <?php } ?>
                                    <!-- /.location -->
                                </div>
                                <!-- /.info -->

                            </div>
                            <!-- /.property -->
                            <?php if ($value['project_details'] != 0) { ?>
                                <div class="property-info clearfix">
                                    <div class="area">
                                        <i class="icon icon-normal-cursor-scale-up"></i>
                                        <?php echo $value['project_details']; ?>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="property-info clearfix">
                                    <div class="area">
                                        <!--<i class="icon icon-normal-cursor-scale-up"></i>-->
                                        &nbsp;
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- /.property-info -->

                        </div>
                        <!-- /.span4 -->
                    <?php } ?>
                </div>
            </div>
            <!-- /.properties-grid -->

            <div class="show-all">
                <a href="<?php echo Uri::base(false) . 'featureproject'; ?>">Show all</a>
            </div>                <hr>

            <h1 class="page-header">Ready Possession</h1>
            <div class="properties-grid">
                <div class="row-fluid">
                    <?php
                    $countready = 1;
                    foreach ($propertydataready as $key => $value) {
                        ?>
                        <div class="span3">
                            <div class="property">
                                <div class="image">
                                    <a href="<?php echo Uri::base(false) . 'welcome/singlelist/' . $value['property_id']; ?>">
                                        <div class="content" style="background-image:url('<?php echo Asset::get_file('property/' . $value['property_id'] . '-1.jpg', 'img') ?>');background-size: cover;background-position: top center;height:200px;">
                                        </div>
                                    </a>
                                    <!-- /.content -->

                                    <div class="rent-sale">
                                        <?php echo idconvert::get_property_conduction($value['property_conduction']); ?>
                                    </div>
                                    <!-- /.rent-sale -->

                                    <div class="add-to-fav">
                                        <a class="addtocart" data-property-id="<?php echo $value['property_id']; ?>" href="<?php echo Uri::base(false) . 'user/addcart/' . $value['property_id']; ?>" title="add to favourites"><?php echo Asset::img('shopping232-add.png'); ?></a>
                                    </div>

                                    <?php
                                    if ($value['property_price'] != '') {
                                        echo '<div class="price">' . $value['property_price'] . '</div>';
                                    }
                                    ?>
                                    <!-- /.price -->

                                </div>
                                <!-- /.image -->

                                <div class="info">
                                    <div class="title clearfix">
                                        <h2><a href="<?php echo Uri::base(false) . 'welcome/singlelist/' . $value['property_id']; ?>">
                                                <?php echo $value['property_name']; ?>
                                            </a></h2>
                                    </div>
                                    <!-- /.title -->
                                    <div class="location"><?php echo idconvert::get_property_location($value['location']); ?></div>
                                    <?php if ($value['property_area'] != 0) { ?>
                                        <div class="location"><?php echo $value['property_area']; ?></div>
                                    <?php } ?>
                                    <!-- /.location -->
                                </div>
                                <!-- /.info -->
                            </div>
                            <!-- /.property -->

                            <?php if ($value['project_details'] != 0) { ?>
                                <div class="property-info clearfix">
                                    <div class="area">
                                        <i class="icon icon-normal-cursor-scale-up"></i>
                                        <?php echo $value['project_details']; ?>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="property-info clearfix">
                                    <div class="area">
                                        <!--<i class="icon icon-normal-cursor-scale-up"></i>-->
                                        &nbsp;
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- /.area -->
                            <!-- /.property-info -->

                        </div>
                        <?php
                        if ($countready == 4) {
                            echo '</div><div class="row-fluid">';
                        }
                        $countready++;
                    }
                    ?>

                </div>
                <div class="row-fluid">
                </div>
                <!-- /.row -->
            </div>
            <!-- /.properties-grid -->
            <div class="show-all">
                <a href="<?php echo Uri::base(false) . 'readypossession'; ?>">Show all</a>
            </div>                <hr>

            <!--            under Construction -->
            <div id="carouselproperties" class="property-carousel widget">
                <h2>Under Construction</h2>
                <div class="carousel">
                    <ul class="bxslider properties-grid unstyled">
                        <?php foreach ($propertydataunder as $key => $value) { ?>
                            <li>
                                <div class="property">
                                    <div class="image">
                                        <a href="<?php echo Uri::base(false) . 'welcome/singlelist/' . $value['property_id']; ?>">
                                            <div class="content" style="background-image:url('<?php echo Asset::get_file('property/' . $value['property_id'] . '-1.jpg', 'img') ?>');background-size: cover;height:250px; ">
                                            </div>
                                        </a>
                                        <!-- /.content -->

                                        <div class="rent-sale">
                                            <?php echo idconvert::get_property_conduction($value['property_conduction']); ?>
                                        </div>
                                        <!-- /.rent-sale -->

                                        <div class="add-to-fav">
                                            <a class="addtocart" data-property-id="<?php echo $value['property_id']; ?>" href="<?php echo Uri::base(false) . 'user/addcart/' . $value['property_id']; ?>" title="add to favourites"><?php echo Asset::img('shopping232-add.png'); ?></a>
                                        </div>

                                        <?php
                                        if ($value['property_price'] != '') {
                                            echo '<div class="price">' . $value['property_price'] . '</div>';
                                        }
                                        ?>
                                        <!-- /.price -->

                                    </div>
                                    <!-- /.image -->

                                    <div class="info">
                                        <div class="title clearfix">
                                            <h2><a href="properties/property-detail.html">
                                                    <?php echo $value['property_name']; ?>
                                                </a></h2>
                                        </div>
                                        <!-- /.title -->

                                        <div class="location"><?php echo idconvert::get_property_location($value['location']); ?></div>
                                        <?php if ($value['property_area'] != 0) { ?>
                                            <div class="location"><?php echo $value['property_area']; ?></div>
                                        <?php } ?>
                                        <!-- /.location -->
                                    </div>
                                    <!-- /.info -->

                                </div>
                                <!-- /.property -->

                                <?php if ($value['project_details'] != 0) { ?>
                                    <div class="property-info clearfix">
                                        <div class="area">
                                            <i class="icon icon-normal-cursor-scale-up"></i>
                                            <?php echo $value['project_details']; ?>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="property-info clearfix">
                                        <div class="area">
                                            <!--<i class="icon icon-normal-cursor-scale-up"></i>-->
                                            &nbsp;
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- /.property-info -->

                            </li>
                        <?php } ?>
                    </ul>
                </div>


            </div>

            <!--            under Construction End-->
            <div id="carouselproperties" class="property-carousel widget">
                <h2>Pre-launch</h2>
                <div class="carousel">
                    <ul class="bxslider properties-grid unstyled">
                        <?php foreach ($propertydatapre as $key => $value) { ?>
                            <li>
                                <div class="property">
                                    <div class="image">
                                        <a href="<?php echo Uri::base(false) . 'welcome/singlelist/' . $value['property_id']; ?>">
                                            <div class="content" style="background-image:url('<?php echo Asset::get_file('property/' . $value['property_id'] . '-1.jpg', 'img') ?>');background-size: cover;height:250px; ">
                                            </div>
                                        </a>
                                        <!-- /.content -->

                                        <div class="rent-sale">
                                            <?php echo idconvert::get_property_conduction($value['property_conduction']); ?>
                                        </div>
                                        <!-- /.rent-sale -->

                                        <div class="add-to-fav">
                                            <a class="addtocart" data-property-id="<?php echo $value['property_id']; ?>" href="<?php echo Uri::base(false) . 'user/addcart/' . $value['property_id']; ?>" title="add to favourites"><?php echo Asset::img('shopping232-add.png'); ?></a>
                                        </div>

                                        <?php
                                        if ($value['property_price'] != '') {
                                            echo '<div class="price">' . $value['property_price'] . '</div>';
                                        }
                                        ?>
                                        <!-- /.price -->

                                    </div>
                                    <!-- /.image -->

                                    <div class="info">
                                        <div class="title clearfix">
                                            <h2><a href="properties/property-detail.html">
                                                    <?php echo $value['property_name']; ?>
                                                </a></h2>
                                        </div>
                                        <!-- /.title -->

                                        <div class="location"><?php echo idconvert::get_property_location($value['location']); ?></div>
                                        <!-- /.location -->
                                        <?php if ($value['property_area'] != 0) { ?>
                                            <div class="location"><?php echo $value['property_area']; ?></div>
                                        <?php } ?>
                                    </div>
                                    <!-- /.info -->

                                </div>
                                <!-- /.property -->

                                <?php if ($value['project_details'] != 0) { ?>
                                    <div class="property-info clearfix">
                                        <div class="area">
                                            <i class="icon icon-normal-cursor-scale-up"></i>
                                            <?php echo $value['project_details']; ?>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="property-info clearfix">
                                        <div class="area">
                                            <!--<i class="icon icon-normal-cursor-scale-up"></i>-->
                                            &nbsp;
                                        </div>
                                    </div>
                                <?php } ?> 
                                <!-- /.property-info -->

                            </li>
                        <?php } ?>
                    </ul>
                </div
            </div>

            <div id="partners_widget-3" class="widget partners">

                <h2>Builders</h2>

                <div class="partners">

                    <div class="row">
                        <?php foreach ($builder as $key => $value) { ?>
                            <div class="span1">
                                <div class="partner" style="">
                                    <a href="<?php echo Uri::base(false) . 'builder/' . $value['builder_name']; ?>">
                                        <img style="" src="<?php echo Uri::base(false) . 'assets/img/builder_logo/' . $value['image_name']; ?>"
                                             class="thumbnail-image" alt="<?php echo $value['builder_name'] ?>"/>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- /.row -->
                </div>
                <!-- /.partners -->
            </div>
        </div>
        <!-- /#main -->

    </div>
    <!-- /.row -->
</div>