<div class="container">
    <div class="row">

        <?php echo $welcomesidebar; ?>
        <!-- /#sidebar -->

        <div id="main" class="span9">

            <div class="login-register">
                <h2></h2>

                <div class="row">
                    <div class="span8">
                        <ul class="tabs nav nav-tabs">
                            <li class="active"><a href="#login" data-toggle="tab">User Details</a></li>
                            <li class=""><a href="<?php echo Uri::base(false) . 'user/cart'; ?>" data-toggle="tab">View Cart</a></li>
                        </ul>
                        <!-- /.nav -->

                        <div class="tab-content">
                            <div class="tab-pane active" id="login">
                                <form method="post" action="javascript:void(0)">

                                    <div class="control-group">
                                        <label class="control-label">
                                            User Name
                                            <span class="form-required">*</span>
                                        </label>
                                        <label class="control-label">
                                            <?php echo Auth::get_screen_name(); ?>
                                        </label>

                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->

                                    <div class="control-group">
                                        <label class="control-label">
                                            Email:
                                            <span class="form-required">*</span>
                                        </label>
                                        <label class="control-label">
                                            <?php echo Auth::get_email(); ?>
                                        </label>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->

                                    <div class="control-group">
                                        <label class="control-label">
                                            Mobile No
                                            <span class="form-required">*</span>
                                        </label>
                                        <label class="control-label">
                                            <?php
                                            $d = Auth::get_profile_fields(array('mobile_no'));
                                            echo $d['mobile_no'];
                                            ?>
                                        </label>
                                        <!-- /.controls -->
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" value="Register" class="btn btn-primary arrow-right">Edit Details</button>
                                    </div>
                                    <!-- /.form-actions -->
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                        <hr>
                    </div>
                    <!-- /.span4-->




                </div>
                <!-- /.row -->
            </div>
            <!-- /.login-register -->

        </div>
        <!-- /.row -->
    </div>