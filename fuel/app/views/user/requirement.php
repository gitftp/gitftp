<div class="container">
    <div class="row">

        <?php echo $welcomesidebar; ?>
        <!-- /#sidebar -->

        <div id="main" class="span9">

            <div class="login-register">
                <h2></h2>

                <div class="row">
                    <!--                    span 4 end-->
                    <div class="span6">
                        <ul class="tabs nav nav-tabs">
                            <li class=""><a href="#requirement" data-toggle="tab">Post your Requirement</a></li>
                        </ul>
                        <!-- /.nav -->

                        <div class="tab-content">
                            <div class="tab-pane active" id="requirement">
                                <span class="label-default"><?php echo $msg; ?></span>
                                <form method="post" action="" id="property-requiment" class="map-filtering">

                                    <div class="control-group" class="span2">
                                        <label class="control-label" >
                                            Username
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>

                                        <div class="controls">
                                            <input type="text" required="required" name="req-name" class="span2">
                                            <span class="validation" id="signup-username"></span>
                                        </div>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->
                                    <!--<div class="clear">-->
                                    <div class="control-group">
                                        <label class="control-label">
                                            E-mail
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>

                                        <div class="controls">
                                            <input type="email" required="required" name="req-email">
                                            <span class="validation" id="req-email"></span>
                                        </div>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->
                                    <div class="control-group">
                                        <label class="control-label">
                                            Mobile No
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>

                                        <div class="controls">
                                            <input type="text" required="required" name="req-mobile">
                                            <span class="validation" id="signup-mobile"></span>
                                        </div>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->
                                    <div class="control-group">
                                        <label class="control-label" >
                                            Location
                                            <span class="form-required">*</span>
                                        </label>

                                        <div class="controls" >
                                            <select name="location" id="inputReqLocation-" class="location">
                                                <?php
                                                foreach ($location as $key => $value) {
                                                    echo '<option value="' . $value['location_Id'] . '">' . $value['locality_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <span class="validation" id="signup-password"></span>
                                        </div>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->
                                    <!-- /.control-group -->
                                    <div class="control-group">
                                        <label class="control-label">
                                            Floor
                                            <span class="form-required">*</span>
                                        </label>

                                        <div class="controls">
                                            <select name="floor">
                                                <?php
                                                foreach ($floor as $key => $value) {
                                                    echo '<option value="' . $value['floor_id'] . '">' . $value['floor_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <span class="validation" id="signup-password"></span>
                                        </div>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->
                                    <!-- /.control-group -->
                                    <div class="control-group">
                                        <label class="control-label">
                                            Budget
                                            <span class="form-required">*</span>
                                        </label>

                                        <div class="controls">
                                            <select name="budget">
                                                <?php
                                                foreach ($budget as $key => $value) {
                                                    echo '<option value="' . $value['budget_id'] . '">' . $value['budget'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <span class="validation" id="signup-password"></span>
                                        </div>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->
                                    <!-- /.control-group -->
                                    <div class="control-group">
                                        <label class="control-label">
                                            Property Type
                                            <span class="form-required">*</span>
                                        </label>

                                        <div class="controls">
                                            <select name="property_type">
                                                <?php
                                                foreach ($project_type as $key => $value) {
                                                    echo '<option value="' . $value['type_id'] . '">' . $value['type_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <span class="validation" id="signup-password"></span>
                                        </div>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->
                                    <!-- /.control-group -->
                                    <div class="control-group">
                                        <label class="control-label">
                                            Property conduction
                                            <span class="form-required">*</span>
                                        </label>

                                        <div class="controls">
                                            <select name="property_conduction">
                                                <?php
                                                foreach ($conduction as $key => $value) {
                                                    echo '<option value="' . $value['conduction_id'] . '">' . $value['conduction_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <span class="validation" id="signup-password"></span>
                                        </div>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->
                                    <div class="control-group">
                                        <label class="control-label" style="display: inline-block">
                                            <input type="radio" required="required" name="property_mode" checked>* Buy
                                        </label>
                                        <label class="control-label" style="display: inline-block">
                                            <input type="radio" required="required" name="property_mode" checked>* Rent
                                        </label>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->

                                    <!-- /.control-group -->
                                    <span class="msg-signup" id="registration-msg"></span>
                                    <div class="form-actions">
                                        <button type="submit" value="Register" class="btn btn-primary arrow-right">Send your Requirement</button>
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
                    <div class="span2">
                        <article class="status-publish entry">
                            <header class="entry-header">
                                <h1 class="page-header entry-title">
                                    <a href="login" rel="bookmark"></a>
                                </h1>
                                <p>

                                <div class="accordion" id="faq66">
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#faq66" href="#collapse661">
                                                <i class="icon icon-normal-circle-plus"></i>Pre Launch Offer
                                            </a>
                                        </div>


                                        <div id="collapse661" class="accordion-body collapse" style="height: 0px;">
                                            <div class="accordion-inner">
                                                Details
                                            </div>

                                        </div>
                                    </div>
                                    <!-- /.accordion-group end-->
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#faq66" href="#collapse661">
                                                <i class="icon icon-normal-circle-plus"></i> Best Deal
                                            </a>
                                        </div>


                                        <div id="collapse661" class="accordion-body collapse" style="height: 0px;">
                                            <div class="accordion-inner">
                                                Details
                                            </div>

                                        </div>
                                    </div>
                                    <!-- /.accordion-group end-->
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#faq66" href="#collapse663">
                                                <i class="icon icon-normal-circle-plus"></i> Arrange Site Visit
                                            </a>
                                        </div>


                                        <div id="collapse663" class="accordion-body collapse" style="height: 0px;">
                                            <div class="accordion-inner">
                                                Details
                                            </div>

                                        </div>
                                    </div>
                                    <!-- /.accordion-group end-->

                                </div>
                                </p>
                            </header>
                            <!-- .entry-header -->

                            <div class="entry-content">
                                <p></p>
                            </div>
                            <!-- .entry-content -->
                        </article>
                        <!-- /#post -->
                    </div>





                </div>
                <!-- /.row -->
            </div>
            <!-- /.login-register -->

        </div>
        <!-- /.row -->
    </div>