<div class="row">
    <div class="col-lg-12">
        <form role="form" method="POST" action="" name="propertyaddform" id="propertyaddform" enctype="multipart/form-data">
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">

                            <label>Builder Name</label>
                            <select class="form-control" name="builder_name" placeholder="Property Bed">
                                <option value="">-select-</option>
                                <?php
                                foreach ($builder as $key => $value) {
                                    if ($pt_data['builder_id'] == $value['builder_id']) {
                                        echo '<option selected="selected" value="' . $value['builder_id'] . '">' . $value['builder_name'] . '</option>';
                                    } else {
                                        echo '<option value="' . $value['builder_id'] . '">' . $value['builder_name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">

                            <label>Property Name</label>
                            <input class="form-control" name="property_name" placeholder="Property Name" value="<?php echo $pt_data['property_name']; ?>">                              
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">

                            <label>Property Desc</label>
                            <textarea class="form-control" name="property_desc" placeholder="Property Desc"><?php echo $pt_data['property_desc']; ?></textarea>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">

                            <label>Property Location</label>
                            <select class="form-control" name="location" placeholder="Property Bed">
                                <option value="">-select-</option>
                                <?php
                                foreach ($location as $key => $value) {
                                    if ($pt_data['location'] == $value['location_Id']) {
                                        echo '<option selected="selected" value="' . $value['location_Id'] . '">' . $value['locality_name'] . '</option>';
                                    } else {

                                        echo '<option value="' . $value['location_Id'] . '">' . $value['locality_name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>                    
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">

                            <label>Project Details</label>
                            <input class="form-control" name="project_details" placeholder="Project Details Ex 1 BHK, 2 BHK" value="<?php echo $pt_data['project_details']; ?>">                     
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Property Address</label>
                            <textarea class="form-control" name="property_address" placeholder="Property Address"><?php echo $pt_data['property_address']; ?></textarea>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">

                            <label>Sector</label>
                            <input class="form-control" name="property_sector" placeholder="Property Sector" value="<?php echo $pt_data['sector']; ?>">
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">

                            <label>Property Type</label>
                            <select class="form-control" name="property_type" placeholder="Property Bed">
                                <option value="">-select-</option>
                                <?php
                                foreach ($property_type as $key => $value) {
                                    if ($pt_data['property_type'] == $value['type_id']) {
                                        echo '<option selected="selected" value="' . $value['type_id'] . '">' . $value['type_name'] . '</option>';
                                    } else {
                                        echo '<option value="' . $value['type_id'] . '">' . $value['type_name'] . '</option>';
                                    }
                                }
                                ?>
                            </select> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">

                            <label>Property Status</label>
                            <select class="form-control" name="property_conduction" placeholder="Property Bed">
                                <option value="">-select-</option>
                                <?php
                                foreach ($conduction as $key => $value) {
                                    if ($pt_data['property_conduction'] == $value['conduction_id']) {
                                        echo '<option selected="selected" value="' . $value['conduction_id'] . '">' . $value['conduction_name'] . '</option>';
                                    } else {
                                        echo '<option value="' . $value['conduction_id'] . '">' . $value['conduction_name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>                              
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">

                            <label>Property Mode</label>
                            <select class="form-control" name="property_mode" placeholder="Property Bed">
                                <option value="">-select-</option>
                                <?php
                                foreach ($property_mode as $key => $value) {
                                    if ($pt_data['property_mode'] == $value['mode_id']) {
                                        echo '<option selected="selected" value="' . $value['mode_id'] . '">' . $value['mode_name'] . '</option>';
                                    } else {
                                        echo '<option value="' . $value['mode_id'] . '">' . $value['mode_name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>                   
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">

                            <label>Property Price</label>
                            <input class="form-control" name="property_price" placeholder="Property Price" value="<?php echo $pt_data['property_price']; ?>">                     
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <label>Property Area</label>
                        <input class="form-control" name="property_area" placeholder="Property Area 500 to 9000 Sp. Ft" value="<?php echo $pt_data['property_area']; ?>">                 
                    </div>
                    <div class="col-lg-3">
                        <label>Possesion date</label><br>
                        <input type="date" name="possesion_date" class="form-control" value="<?php echo $pt_data['possesion_date']; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">

                            <label>Feature Project</label><br>
                            <?php
                            if ($pt_data['featured_property'] == 'Yes') {
                                echo '<input type="checkbox" name="featured_property" checked value="Yes">';
                            } else {
                                echo '<input type="checkbox" name="featured_property" value="No">';
                            }
                            ?>

                        </div>
                    </div>
                </div>