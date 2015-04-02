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
                        <h2 class="page-header">Property Response</h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
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
                                            <input type="date" class="form-control" name="enquiry_date" placeholder="">  
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Location: </label>
                                            <select class="form-control" name="location" placeholder="Property Bed">
                                                <option value="">Select Location</option>
                                                <?php
                                                foreach ($location as $key => $value) {
                                                    echo '<option value="' . $value['location_Id'] . '">' . $value['locality_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Budget</label>
                                            <select name="property_price" id="inputPriceFrom-" class="form-control" style="width: 160px">
                                                <option value="">Price</option>
                                                <?php foreach (idconvert::get_budget(1) as $key => $value) { ?>
                                                    <?php echo '<option value="' . $value['budget_id'] . '">' . $value['budget'] . '</option>'; ?>
                                                <?php } ?>
                                            </select>  
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Floor</label><br>
                                            <select name="property_price" id="inputPriceFrom-" class="form-control" style="width: 160px">
                                                <option value="">Floor</option>
                                                <?php foreach ($floor as $key => $value) { ?>
                                                    <?php echo '<option value="' . $value['floor_id'] . '">' . $value['floor_name'] . '</option>'; ?>
                                                <?php } ?>
                                            </select>  
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label>Person Name</label><br>
                                        <input type="text" name="person_name" class="form-control" placeholder="Person Name"/><br>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Enquiry Status</label><br>
                                        <select name="enquiry_status" id="inputPriceFrom-" class="form-control" style="width: 160px">
                                            <option value="" >Enquiry Status</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Final">Final</option>
                                            <option value="Waiting for Response">Waiting for Response</option>
                                            <option value="Not Interested">Not Interested</option>
                                        </select>  
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Builder</label><br>
                                        <select name="property_price" id="inputPriceFrom-" class="form-control" style="width: 160px">
                                            <option value="">Builder</option>
                                            <?php foreach ($builder as $key => $value) { ?>
                                                <?php echo '<option value="' . $value['builder_id'] . '">' . $value['builder_name'] . '</option>'; ?>
                                            <?php } ?>
                                        </select>  
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Property Type</label><br>
                                        <select name="property_price" id="inputPriceFrom-" class="form-control" style="width: 160px">
                                            <option value="">Property Type</option>
                                            <?php foreach ($project_type as $key => $value) { ?>
                                                <?php echo '<option value="' . $value['type_id'] . '">' . $value['type_name'] . '</option>'; ?>
                                            <?php } ?>
                                        </select>  
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
                                        <table class="table" style="width: 100%">
                                            <tr>
                                                <th>&nbsp;</th>
                                                <th>Eq Id:</th>
                                                <th>User Details:</th>
                                                <th>Property Details:</th>
                                                <th>Enquiry Data</th>
                                                <th>State</th>
                                                <th>&nbsp;</th>
                                            </tr>

                                            <?php
                                            if (!empty($enquiry)) {
                                                foreach ($enquiry as $key => $value) {
                                                    ?>
                                                    <tr style="background-color: <?php echo idconvert::get_bg_color_status($value['status']); ?>">
                                                        <td><input type="checkbox" /></td>
                                                        <td><?php echo $value['enquiry_id']; ?></td>
                                                        <td width="20%"><strong>Name:</strong><?php echo $value['name']; ?><br>
                                                            <strong>Mobile No:</strong><?php echo $value['mobileno']; ?><br>
                                                            <strong>Email:</strong><?php echo $value['email']; ?><br>
                                                        </td>
                                                        <td width="20%">
                                                            <strong>Pro id:</strong><?php echo $value['property_id']; ?><br>
                                                            <strong>Pro Name:</strong><?php echo idconvert::get_property_name($value['property_id']); ?><br>                                                            
                                                            <strong>Location:</strong><?php echo idconvert::get_property_location_by_id($value['property_id']); ?><br>                                                            
                                                            <strong>Price:</strong><?php echo idconvert::get_property_price_by_id($value['property_id']); ?><br>                                                            
                                                        </td>
                                                        <td><?php echo date("d-M-Y H:m", strtotime($value['enquiry_date'])); ?></td>
                                                        <td width="20%" >
                                                            <strong>Status:</strong><?php echo $value['status']; ?><br>
                                                            <strong>Comment:</strong><?php echo $value['comments']; ?><br>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                    Status <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li ><a href="#" class="eq-status-change" data-eq-id="<?php echo $value['enquiry_id']; ?>" data-status="Final">Final</a></li>
                                                                    <li ><a href="#" class="eq-status-change" data-eq-id="<?php echo $value['enquiry_id']; ?>" data-status="Waiting for Response">Waiting for Response</a></li>
                                                                    <li ><a href="#" class="eq-status-change" data-eq-id="<?php echo $value['enquiry_id']; ?>" data-status="Not Interested">Not Interested</a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                        <td><a href="<?php echo Uri::base(false) . 'admin/'; ?>">View Details</a></td>
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
                                        <?php echo $previous; ?>
                                        <?php echo $page_name; ?>
                                        <?php echo $next; ?>
                                        <span class="print"><a href="#">print</a></span>
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
