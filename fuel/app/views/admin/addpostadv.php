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
                        <h1 class="page-header">Post Adv</h1>
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
                                        <label>Adv Name</label>
                                        <input class="form-control" name="advname" placeholder="Adv. Name">                              
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Adv Desc</label>
                                        <input class="form-control" name="advdesc" placeholder="Adv. Description">                              
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Adv Link</label>
                                        <input class="form-control" name="advlink" placeholder="Adv. Link">                              
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Adv. Image</label>
                                        <input type="file" class="form-control" name="advimg" placeholder="Adv. Image">                        
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-default">Post Adv.</button>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table" style="width: 100%">
                            <tr>
                                <th>&nbsp;</th>
                                <th>Adv Id</th>
                                <th>Adv Name:</th>
                                <th>Adv Desc:</th>
                                <th>Adv Link:</th>
                                <th>Adv Image:</th>
                                <th>&nbsp;</th>
                            </tr>

                            <?php
                            if (!empty($postadv)) {
                                foreach ($postadv as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" /></td>
                                        <td><?php echo $value['post_adv']; ?></td>
                                        <td><?php echo $value['adv_name']; ?></td>
                                        <td><?php echo $value['adv_desc']; ?></td>
                                        <td><?php echo $value['link']; ?></td>
                                        <td width="20%"><img src="<?php echo Uri::base(false) . 'assets/img/postadv/' . $value['image_name']; ?>" style="height: 150px; width: 250px"/></td>
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
