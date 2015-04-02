<div class="container">
    <div class="row">

        <?php echo $welcomesidebar; ?>
        <!-- /#sidebar -->

        <div id="main" class="span9">

            <h2><?php echo $page_title; ?></h2>
            <div class="properties-grid featured">
                <?php if (!empty($data)) { ?>
                    <div class="row">
                        <?php foreach ($data as $key => $value) { ?>
                            <div class="span3">
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

                                        <div class="builder-name">
                                            <?php echo Asset::img('builder_logo/' . idconvert::get_property_builder_img($value['builder_id'])); ?>
                                        </div>

                                        <div class="add-to-fav">
                                            <a href="<?php echo Uri::base(false).'user/removecart/'.$value['property_id'];?>" class="removefromcart" title="add to favourites"><?php echo Asset::img('removeshopping232.png'); ?></a>
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

                                        <?php if ($value['property_area'] != 0) { ?>
                                            <div class="location"><?php echo $value['property_area']; ?></div>
                                        <?php } else { ?>
                                            <div class="location">&nbsp;</div>
                                        <?php } ?>
                                        <?php if ($value['project_details'] != 0) { ?>
                                            <div class="location"><?php echo $value['project_details']; ?></div>
                                        <?php } else { ?>
                                            <div class="location">&nbsp;</div>
                                        <?php } ?>
                                        <!--<div class="location">Type: 1BHK, 2BHK, 3BHK</div>-->
                                        <!-- /.location -->
                                    </div>
                                    <!-- /.info -->

                                </div>
                                <!-- /.property -->
                                <div class="property-info clearfix">

                                    <!--                                <div class="area">
                                                                        <i class="icon icon-normal-cursor-scale-up"></i>
                                                                        1235 Sq.Ft.<sup>2</sup>
                                                                    </div>
                                                                     /.area 
                                    
                                                                    <div class="bedrooms">
                                                                        <a href="#" data-toggle="tooltip" data-placement="right" title="Download Brosture"><i class="icon icon-normal-download" altr="Downlaod" title="Download brosture"></i></a>
                                                                    </div>
                                    
                                                                    <div class="bedrooms">
                                                                        <i class="icon icon-normal-bed"></i>
                                                                        2
                                                                    </div>
                                                                     /.bedrooms 
                                    
                                                                    <div class="bathrooms">
                                                                        <i class="icon icon-normal-shower"></i>
                                                                        2
                                                                    </div>-->
                                </div>
                                <!-- /.property-info -->

                            </div>
                            <!-- /.span4 -->
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="span3"> <h4>Sorry No Property to display.</h4></div>
                    </div>
                <?php } ?>
            </div>
            <!-- /.properties-grid -->

            <div class="pagination pagination-centered">
                <ul class="unstyled">
                    <li> <?php echo $prev; ?></li>
                    <li><?php echo $page; ?></li>
                    <li><?php echo $next; ?></li>
                    <!--                    <li><a href="#">Previous</a></li>
                                        <li class="active"><a href="#">3</a></li>
                                        <li><a href="#">5</a></li>
                                        <li><a href="#">Next</a></li>-->
                </ul>
            </div>               
            <hr>
        </div>
        <!-- /#main -->

    </div>
    <!-- /.row -->
</div>