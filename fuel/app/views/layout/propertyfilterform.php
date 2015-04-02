<div class="row">
    <div class="span12">
        <div class="switcher-tab-wrapper">
            <div class="switcher-tab">
                <a class="tab active" data-id="sale">
                    BUY
                </a>
                <a class="tab" data-id="rent">
                    RENT
                </a>
            </div>
        </div>
        <div class="property-filter widget filter-horizontal">
            <div class="content" data-for="sale">
                <form method="get" action="<?php echo Uri::base(false); ?>search/flats" class="form-inline map-filtering">
                    <div class="general" style="position:relative;">
                        <select name="location" id="inputLocation-" class="location">
                            <option value="">Location</option>
                            <?php foreach ($location as $key => $value) { ?>
                                <option value="<?php echo $value['location_Id']; ?>"><?php echo $value['locality_name']; ?></option>
                            <?php } ?>
                        </select>
                        <select name="bedrooms" id="inputBeds-" class="beds">
                            <option value="">BHK</option>
                            <?php
                            $floor = idconvert::get_floor();
                            foreach ($floor as $key => $value) {
                                echo '<option value="' . $value['floor_id'] . '">' . $value['floor_name'] . '</option>';
                            }
                            ?>
                        </select>

                        <input type="text" name="property_sale_type" value="1" style="display: none">
                        <select name="property_price" id="inputPriceFrom-" class="price-from" style="width: 160px">
                            <option value="">Price</option>
                            <?php foreach (idconvert::get_budget(1) as $key => $value) { ?>
                                <?php echo '<option value="' . $value['budget_id'] . '">' . $value['budget'] . '</option>'; ?>
                            <?php } ?>
                        </select> 


                        <select name="property_type" id="property_type-" class="property_conduction-select">
                            <option value="">Property Type</option>
                            <?php
                            $property_type = idconvert::get_data_model(array('table' => 'property_type'));
                            foreach ($property_type as $key => $value) {
                                echo '<option value="' . $value['type_id'] . '">' . $value['type_name'] . '</option>';
                            }
                            ?>
                        </select>

<!--                        <select name="property_conduction" id="property_conduction-" class="property_conduction-select">
                            <option value="">Looking For</option>
                            <option value="1">Pre-launch</option>
                            <option value="2">Under Construction</option>
                            <option value="3">Ready Possession</option>
                        </select>-->

                        <button class="btn btn-primary btn-lg" style="position:absolute;top:0;right:0;" type="submit">Search Property</button>
                        <div style="clear:both" class="clearfix"></div>
                    </div>
                    <!-- /.general -->
                </form>
            </div>
            <div class="content" data-for="rent" style="display:none">
                <form method="get" action="<?php echo Uri::base(false); ?>search/flats" class="form-inline map-filtering">
                    <div class="general">
                        <select name="location" id="inputLocation2-" class="location">
                            <option value="">Location</option>
                            <?php foreach ($location as $key => $value) { ?>
                                <option value="<?php echo $value['location_Id']; ?>"><?php echo $value['locality_name']; ?></option>
                            <?php } ?>
                        </select>
                        <select name="bedrooms" id="inputBeds2-" class="beds">
                            <option value="">BHK</option>
                            <?php
                            foreach ($floor as $key => $value) {
                                echo '<option value="' . $value['floor_id'] . '">' . $value['floor_name'] . '</option>';
                            }
                            ?>
                        </select>

                        <input type="text" name="property_sale_type" value="2" style="display: none">

                        <select name="property_price" id="inputPriceFrom2-" class="price-from" style="width: 160px">
                            <option value="">Price</option>
                            <?php foreach (idconvert::get_budget(2) as $key => $value) { ?>
                                <?php echo '<option value="' . $value['budget_id'] . '">' . $value['budget'] . '</option>'; ?>
                            <?php } ?>
                        </select>

                        <select name="property_type2" id="property_type2-" class="property_conduction-select">
                            <option value="">Property Type</option>
                            <?php
                            foreach ($property_type as $key => $value) {
                                echo '<option value="' . $value['type_id'] . '">' . $value['type_name'] . '</option>';
                            }
                            ?>
                        </select>

<!--                        <select name="property-looking2" id="property-looking2-" class="property-type-select">
                            <option value="">Looking For</option>
                            <option value="5">Un-Furnished</option>
                            <option value="6">Semi Furnished</option>
                            <option value="7">Fully Furnished</option>
                        </select>-->

                        <button class="btn btn-primary btn-large" type="submit">Search Property</button>
                        <div style="clear:both"></div>
                    </div>
                    <!-- /.general -->
                </form>
            </div>
            <!-- /.content -->
        </div>
        <!-- /.property-filter -->                        
    </div>
    <!-- /.span12 -->
</div>