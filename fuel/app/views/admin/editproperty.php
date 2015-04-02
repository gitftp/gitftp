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
                        <h3 class="page-header">Edit Property</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                
                <script>
                    if('<?php echo $message?>'){
                        alert('Successfully updated');
                    }
                </script>

                <!--                                Property master start -->
                <?php echo $propertymaster; ?>
                <!--                                Property master ends -->
                <!--property Details start-->
                <?php echo $propertydetails; ?>
                <!--property details ends-->
                <!--                                feature detail start-->
                <?php echo $featuredetails; ?>
                <!--                                feature detail end-->

                <!-- /.row -->
                <!--                                distance start-->
                <?php echo $distance; ?>
                <!--                                distance end-->                                
                <!--images & contact start -->
                <?php echo $images; ?>
                <!--images & contact end -->
                <button type="submit" class="btn btn-default" onclick="return confirm('Are you sure to update this property?')">Update Property</button>
                <!--<button type="reset" class="btn btn-default">Reset Button</button>-->
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
