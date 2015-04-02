<!DOCTYPE html>
<html lang="en">

    <head>
        <?php echo $header; ?>
        <script>
            $(document).ready(function() {
                $('span.print').printPage();
            });
        </script>
    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <?php echo $nav; ?>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header">User Listing</h2>
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
                                        <label>User Name</label><br>
                                        <input type="text" name="person_name" class="form-control" placeholder="Person Name"/><br>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>User Type</label><br>
                                        <select name="enquiry_status" id="inputPriceFrom-" class="form-control" style="width: 160px">
                                            <option value="" >User Type</option>
                                            <option value="Admin">Admin</option>
                                            <option value="User">User</option>
                                            <option value="Dataentry">Dataentry</option>s
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
                                                <th>User Right:</th>
                                                <th>Registration Data:</th>
                                                <th>State:</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                            <?php
                                            if (!empty($enquiry)) {
                                                foreach ($enquiry as $key => $value) {
//                                                    print_r($value);
                                                    ?>
                                                    <tr >
                                                        <td><input type="checkbox" /></td>
                                                        <td></td>
                                                        <td width="20%"><strong>Name:</strong><?php echo $value['username']; ?><br>
                                                            <?php
                                                                try{
                                                                    $ser = unserialize($value['profile_fields']);
                                                                    $ser = $ser['mobileno'];
                                                                } catch (Exception $ex) {
                                                                    $ser = 'not set';
                                                                }
                                                            ?>
                                                            <strong>Mobile No:</strong> <?php echo $ser; //$value['mobileno']; ?><br>
                                                            <strong>Email:</strong> <?php echo $value['email']; ?><br>
                                                        </td>
                                                        <td width="20%">
                                                            <strong>Pro id:</strong> <?php echo $value['id']; ?><br>                                                        
                                                        </td>
                                                        <td>
                                                            <?php echo date('d-M-Y',$value['created_at']); ?>
                                                        </td>
                                                        <td width="20%" >
                                                            <strong>Status:</strong><br>
                                                            <strong>Comment:</strong><br>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                    Status <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li ><a href="#" class="eq-status-change" data-eq-id="" data-status="Final">Final</a></li>
                                                                    <li ><a href="#" class="eq-status-change" data-eq-id="" data-status="Waiting for Response">Waiting for Response</a></li>
                                                                    <li ><a href="#" class="eq-status-change" data-eq-id="" data-status="Not Interested">Not Interested</a></li>
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
