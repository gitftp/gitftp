<div class="container">
    <div class="row">

        <?php echo $welcomesidebar; ?>
        <!-- /#sidebar -->

        <div id="main" class="span9 property-listing">

            <h1 class="page-header"><?php echo $page_title; ?></h1>

            <div class="clearfix">


                <div class="properties-rows">
                    <div class="filter-wrapper">
                        <div class="filter pull-right">
                            <form action="javascript:void(0)" method="get" class="form-sort form-horizontal pull-right">

                                <div class="pager pull-right">
                                    <ul class="pager">
                                        <li><?php echo $prev; ?></li>
                                        <li><?php echo $next; ?></li>
                                    </ul>
                                </div>
                                <!-- /.pager -->

                                <!--                                <div class="control-group pull-right">
                                                                    <div class="controls">
                                                                        <select name="filter_sort_by" id="inputSortBy" class="chzn-done" style="display: none;">
                                                                            <option value="price">Price</option>
                                                                            <option value="published">Published</option>
                                                                        </select>
                                                                        <div id="inputSortBy_chzn" class="chzn-container chzn-container-single chzn-container-single-nosearch" style="width: 220px;" title=""><a href="javascript:void(0)" class="chzn-single" tabindex="-1"><span>Price</span><div><b></b></div></a><div class="chzn-drop" style="left:-9000px;"><div class="chzn-search"><input type="text" autocomplete="off"></div><ul class="chzn-results"><li id="inputSortBy_chzn_o_0" class="active-result result-selected" style="">Price</li><li id="inputSortBy_chzn_o_1" class="active-result" style="">Published</li></ul></div></div>
                                                                    </div>
                                                                </div>
                                
                                                                <div class="control-group pull-right">
                                                                    <div class="controls">
                                                                        <select id="inputOrder" name="filter_order" class="chosen chzn-done" style="display: none;">
                                                                            <option value="DESC">Descending</option>
                                                                            <option value="ASC">Ascending</option>
                                                                        </select>
                                                                        <div id="inputOrder_chzn" class="chzn-container chzn-container-single chzn-container-single-nosearch chzn-container-active" style="width: 220px;" title=""><a href="javascript:void(0)" class="chzn-single chzn-single-with-drop" tabindex="-1"><span>Descending</span><div><b></b></div></a><div class="chzn-drop" style="left: 0px;"><div class="chzn-search"><input type="text" autocomplete="off"></div><ul class="chzn-results"><li id="inputOrder_chzn_o_0" class="active-result result-selected highlighted" style="">Descending</li><li id="inputOrder_chzn_o_1" class="active-result" style="">Ascending</li></ul></div></div>
                                                                    </div>
                                                                     /.controls 
                                                                </div>-->
                                <!-- /.control-group -->
                            </form>
                            <!-- /.filter -->
                        </div>
                    </div>
                    <!-- /.properties-rows -->        </div>


                <div class="properties-rows">
                    <div class="row">
                        <?php if (!empty($data)) { ?>
                            <?php foreach ($data as $key => $value) { ?>
                                <div class="property span9">
                                    <div class="row">
                                        <div class="span3">
                                            <div class="image">
                                                <div class="content">
                                                    <a href="<?php echo Uri::base(false) . 'welcome/singlelist/' . $value['property_id']; ?>">
                                                        <img style="height: 250px" src="<?php echo Uri::base(false) . 'assets/img/property/' . $value['property_id'] . '-1.jpg'; ?>" class="thumbnail-image" alt="19">
                                                    </a>
                                                </div>
                                                <!-- /.content -->
                                            </div>
                                            <!-- /.image -->
                                        </div>

                                        <div class="body span6">
                                            <div class="title-price row">
                                                <div class="title span4">
                                                    <h2><a href="<?php echo Uri::base(false) . 'welcome/singlelist/' . $value['property_id']; ?>"><?php echo $value['property_name']; ?></a>
                                                    </h2>
                                                </div>
                                                <!-- /.title -->
                                                <?php
                                                if ($value['property_price'] != '') {
                                                    echo '<div class="price">' . $value['property_price'] . '</div>';
                                                } else {
                                                    echo '<div class="price">Contact Us</div>';
                                                }
                                                ?>
                                                <!-- /.price -->
                                            </div>
                                            <!-- /.title -->

                                            <div class="location"><?php echo idconvert::get_property_location($value['location']); ?></div>
                                            <!-- /.location -->

                                            <div class="body">
                                                <p>  <?php echo substr($value['property_desc'], 0, 150); ?>...</p>
                                                <p><strong>Status: <?php echo idconvert::get_property_conduction($value['property_conduction']); ?></strong></p>
                                            </div>
                                            <!-- /.body -->


                                            <div class="property-info clearfix">
                                                <?php if ($value['property_area'] != 0) { ?>
                                                    <div class="area">
                                                        <i class="icon icon-normal-cursor-scale-up"></i>
                                                        <?php echo $value['property_area']; ?>
                                                    </div>
                                                    <!-- /.area -->
                                                <?php } else { ?>
                                                    <div class="area">
                                                        &nbsp;
                                                    </div>
                                                    <!-- /.area -->
                                                <?php } ?>
                                                <?php if ($value['project_details'] != 0) { ?>
                                                    <div class="bedrooms">
                                                        <i class="icon icon-normal-bed"></i>
                                                        <?php echo $value['project_details']; ?>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="bedrooms">
                                                        &nbsp;
                                                    </div>
                                                <?php } ?>
                                                <!-- /.bedrooms -->


                                                <div class="more-info">
                                                    <a href="<?php echo Uri::base(false) . 'welcome/singlelist/' . $value['property_id']; ?>">More Info<i class="icon icon-normal-right-arrow-circle"></i></a>
                                                </div>
                                            </div>
                                            <!-- /.info -->
                                        </div>
                                        <!-- /.body -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.property -->
                            <?php } ?>
                        <?php } else { ?>
                                <div class="property span9">
                                    <div class="row">
                                        <h3>Sorry No Property for your search. </h3>  
                                    </div>
                                </div>
                        <?php } ?>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.properties-grid -->

                <div class="pagination pagination-centered">
                    <ul class="unstyled">
                        <li> <?php echo $prev; ?></li>
                        <li><?php echo $page; ?></li>
                        <li><?php echo $next; ?></li>
                    </ul>
                </div>


            </div>

            <!-- /#main -->

        </div>
        <!-- /#main -->
    </div>
    <!-- /.row -->
</div>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('select[name=filter_sort_by]').change(function() {
            $('form.form-sort').submit();
        });

        $('select[name=filter_order]').change(function() {
            $('form.form-sort').submit();
        });


    });


</script>