<!DOCTYPE html>
<html lang="en">

    <head>
        <?php echo $header; ?>
    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <?php echo $nav; ?>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header">Property Details</h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <style>
                    .modal-body{
                        max-height: 400px;
                        overflow-y:scroll;
                    }
                </style>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <form role="form" method="get" action="" name="propertyaddform" id="propertyaddform" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="row">
                                    <!-- /.col-lg-12 -->
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Date:</label>
                                            <input type="date" class="form-control" name="create_date" placeholder="" value="">  
                                            <input type="hidden" name="mode" value="1">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Location: </label>
                                            <select class="form-control" name="location" placeholder="Property Bed">
                                                <option value="">Select Location</option>
                                                <?php
                                                foreach ($location as $key => $value) {
                                                    if (Input::get('location') == $value['location_Id']) {
                                                        echo '<option selected value="' . $value['location_Id'] . '">' . $value['locality_name'] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $value['location_Id'] . '">' . $value['locality_name'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Budget: </label>
                                            <select name="property_budget" id="inputPriceFrom-" class="form-control" style="width: 160px">
                                                <option value="">Price</option>
                                                <?php
                                                foreach (idconvert::get_budget(1) as $key => $value) {
                                                    if (Input::get('property_budget') == $value['budget_id']) {
                                                        echo '<option selected value="' . $value['budget_id'] . '">' . $value['budget'] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $value['budget_id'] . '">' . $value['budget'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>  
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Floor</label>
                                            <select name="property_floor" id="inputPriceFrom-" class="form-control" style="width: 160px">
                                                <option value="">Floor</option>
                                                <?php
                                                foreach ($floor as $key => $value) {
                                                    if (Input::get('property_floor') == $value['floor_id']) {
                                                        echo '<option selected value="' . $value['floor_id'] . '">' . $value['floor_name'] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $value['floor_id'] . '">' . $value['floor_name'] . '</option>';
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
                                            <label>Property Id</label><br>
                                            <input type="text" name="property_id" class="form-control" placeholder="Property Id"/><br>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Builder </label><br>
                                            <select name="builder" id="inputPriceFrom-" class="form-control" style="width: 160px">
                                                <option value="">Builder</option>
                                                <?php
                                                foreach ($builder as $key => $value) {
                                                    if (Input::get('builder_id') == $value['builder_id']) {
                                                        echo '<option selected value="' . $value['builder_id'] . '">' . $value['builder_name'] . '</option>';
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
                                            <label>Property Type</label><br>
                                            <select name="property_type" id="inputPriceFrom-" class="form-control" style="width: 160px">
                                                <option value="">Property Type</option>
                                                <?php
                                                foreach ($project_type as $key => $value) {
                                                    if (Input::get('property_type') == $value['type_id']) {
                                                        echo '<option selected value="' . $value['type_id'] . '">' . $value['type_name'] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $value['type_id'] . '">' . $value['type_name'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Property Conduction</label><br>
                                            <select name="property_conduction" id="inputPriceFrom-" class="form-control" style="width: 160px">
                                                <option value="">Property Conduction</option>
                                                <?php foreach ($conduction as $key => $value) { ?>
                                                    <?php echo '<option value="' . $value['conduction_id'] . '">' . $value['conduction_name'] . '</option>'; ?>
                                                <?php } ?>
                                            </select> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <button type="submit" class="btn btn-default">Find</button>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?php echo $msgbox; ?>
                                        <table class="table" style="width: 100%">
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Details1</th>
                                                <th>Details2</th>
                                                <th></th>
                                            </tr>
                                            <?php
                                            if (!empty($properties)) {
                                                foreach ($properties as $key => $value) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $value['property_id'] ?></td>
                                                        <td width="40%">
                                                            <?php echo $value['property_name'] ?> <br>
                                                            <strong>Description:</strong> <?php echo $value['property_desc'] ?><br>
                                                            <strong>Address:</strong> <?php echo $value['property_address'] ?> <br>

                                                            <img src="<?php echo Uri::base(false) ?>assets/img/property/<?php echo $value['property_id']; ?>-1.jpg" alt="" style="width: 100px; float:left;">
                                                            <img src="<?php echo Uri::base(false) ?>assets/img/property/<?php echo $value['property_id']; ?>-2.jpg" alt="" style="width: 100px; float:left;">
                                                            <img src="<?php echo Uri::base(false) ?>assets/img/property/<?php echo $value['property_id']; ?>-3.jpg" alt="" style="width: 100px; float:left;">
                                                        </td>
                                                        <td>
                                                            <strong>Project details:</strong> <?php echo $value['project_details'] ?><br>
                                                            <strong>Property price:</strong> <?php echo $value['property_price'] ?><br>
                                                            <strong>Property conduction:</strong> <?php echo idconvert::get_property_conduction($value['property_conduction']); ?><br>
                                                        </td>
                                                        <td>
                                                            <strong>Created on:</strong> <?php echo date("d-M-Y H:m", strtotime($value['create_date'])) ?><br>
                                                            <strong>User id:</strong> <?php echo $value['user_id'] ?><br>
                                                            <strong>Property type:</strong> <?php echo idconvert::get_property_type($value['property_type']); ?><br>
                                                            <strong>Builder Id:</strong> <?php echo idconvert::get_property_builder($value['builder_id']); ?><br>
                                                            <strong>Property mode:</strong> <?php echo idconvert::get_property_mode($value['property_mode']); ?><br>
                                                            <strong>Location:</strong> <?php echo idconvert::get_property_location($value['location']); ?><br>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-primary btn-xs" onclick="return viewproperty(<?php echo $value['property_id']; ?>)">
                                                                PROPERTY DETAILS
                                                            </button>
                                                            <div style="height:5px"></div>
                                                            <button class="btn btn-default btn-xs" onclick="return viewdistance(<?php echo $value['property_id']; ?>)">
                                                                DISTANCE
                                                            </button>
                                                            <div style="height:5px"></div>
                                                            <button class="btn btn-default btn-xs" onclick="return viewcontact(<?php echo $value['property_id']; ?>)">
                                                                CONTACT
                                                            </button>
                                                            <div style="height:5px"></div>
                                                            <button class="btn btn-default btn-xs" onclick="return viewenquiry(<?php echo $value['property_id']; ?>)">
                                                                ENQUIRY
                                                            </button>
                                                            <div style="height:5px"></div>
                                                            <a class="btn btn-info btn-xs" href="<?php echo Uri::base(false) ?>editadminbuilder/editproperty/<?php echo $value['property_id']; ?>" target="asda">
                                                                EDIT
                                                            </a>
                                                            <div style="height:5px"></div>
                                                            <a class="btn btn-danger btn-xs" href="<?php echo Uri::base(false) ?>admin/viewproperty?deleteproperty=<?php echo $value['property_id']; ?>" onclick="return confirm('Are you sure you want to delete this property?')">
                                                                Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="9">Sorry no data for the search.</td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                        <div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
                                            <?php echo $last; ?>
                                            <?php echo $pages; ?>
                                            <?php echo $previous; ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->
                        </form>
                    </div>
                </div>
                <!-- /.row -->

                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <?php echo $footer; ?>
    </body>

</html>
