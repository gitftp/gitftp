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
                        <h1 class="page-header">Builder List</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <form role="form" method="POST" action="" name="propertyaddform" id="propertyaddform" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label>Builder Name</label>
                                        <input class="form-control" name="builder_name" placeholder="Builder Name">                              
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Builder Name</label>
                                        <input class="form-control" name="builder_desc" placeholder="Builder Description">                              
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Builder Logo</label>
                                        <input type="file" class="form-control" name="builder_logo" placeholder="Builder logo">                        
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-default">Add Builder</button>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table" style="width: 100%">
                            <tr>
                                <th>&nbsp;</th>
                                <th>Builder Id:</th>
                                <th>Builder Name:</th>
                                <th>No of Property List:</th>
                                <th>Builder Logo:</th>
                                <th>&nbsp;</th>
                            </tr>

                            <?php
                            if (!empty($builder)) {
                                foreach ($builder as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" /></td>
                                        <td><?php echo $value['builder_id']; ?></td>
                                        <td><?php echo $value['builder_name']; ?></td>
                                        <td><?php echo idconvert::get_count_property_builder($value['builder_id']); ?></td>
                                        <td width="20%"><img src="<?php echo Uri::base(false) . 'assets/img/builder_logo/' . $value['image_name']; ?>" style="height: 150px; width: 250px"/></td>
                                        <td>
                                            <a href="#" class="btn btn-default">Edit</a>
                                            <a href="#" class="btn btn-danger">Delete</a>
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
                        <?php echo $pre; ?>
                        <?php echo $page; ?>
                        <?php echo $next; ?>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <?php echo $footer; ?>
    </body>

</html>
