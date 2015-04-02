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
                        <h1 class="page-header"><?php echo $page_title; ?></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <script>
                    if ('<?php echo $message ?>') {
                        alert('property added successfully!');
                    }
                </script>

                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <form role="form" method="POST" action="" name="propertyaddform" id="propertyaddform" enctype="multipart/form-data">
                            <div class="form-group">
                                <?php echo $property_details; ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h1 class="page-header">Details</h1>
                                    </div>
                                </div>
                                <?php echo $property_floor_details; ?>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h1 class="page-header">Feature</h1>
                                    </div>
                                </div>
                                <?php echo $property_feature; ?>

                                <!-- /.row -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h1 class="page-header">Distance</h1>
                                    </div>
                                </div>
                                <?php echo $property_distance; ?>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h1 class="page-header">Images</h1>
                                    </div>
                                </div>
                                <?php echo $property_img; ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h1 class="page-header">Contact</h1>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>Contact Name</label>
                                            <input class="form-control" name="contact_name" placeholder="Contact Name">  
                                        </div>
                                        <div class="col-lg-3">
                                            <label>Contact No</label>
                                            <input class="form-control" name="contact_no" placeholder="Contact No">  
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-default" onclick="return confirm('Are you sure to add property?');">Submit Button</button>
                                <button type="reset" class="btn btn-default">Reset Button</button>
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
