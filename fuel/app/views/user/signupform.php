<div class="container">
    <div class="row">

        <?php echo $welcomesidebar; ?>
        <!-- /#sidebar -->

        <div id="main" class="span9">

            <div class="login-register">
                <h2></h2>

                <div class="row">
                    <div class="span4">
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
                    <!--                    span 4 end-->
                    <div class="span4">
                        <ul class="tabs nav nav-tabs">
                            <li class=""><a href="#login" data-toggle="tab">Login</a></li>
                            <li class="active"><a href="#register" data-toggle="tab">Register</a></li>
                        </ul>
                        <!-- /.nav -->

                        <div class="tab-content">
                            <div class="tab-pane" id="login">
                                <form method="post" action="<?php echo Uri::base(false) . 'user/login' ?>" id="tab-login-form">

                                    <div class="control-group">
                                        <label class="control-label">
                                            Login
                                            <span class="form-required">*</span>
                                        </label>

                                        <div class="controls">
                                            <input type="text" name="username" placeholder="Username" required="required">
                                        </div>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->

                                    <div class="control-group">
                                        <label class="control-label">
                                            Password
                                            <span class="form-required">*</span>
                                        </label>

                                        <div class="controls">
                                            <input type="password" name="password" placeholder="Password" required="required">
                                        </div>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->
                                    <span id="tab-login-msg"></span>
                                    <a href="#">Forgot Password</a>
                                    <div class="form-actions">
                                        <input type="submit" value="Login" id="tab-login" class="btn btn-primary arrow-right">
                                    </div>
                                    <!-- /.form-actions -->
                                </form>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane active" id="register">
                                <form method="post" action="<?php echo Uri::base(false); ?>user/signup" id="gl-registration">

                                    <div class="control-group">
                                        <label class="control-label">
                                            Username
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>

                                        <div class="controls">
                                            <input type="text" required="required" name="gl-name">
                                            <span class="validation" id="signup-username"></span>
                                        </div>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->

                                    <div class="control-group">
                                        <label class="control-label">
                                            E-mail
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>

                                        <div class="controls">
                                            <input type="email" required="required" name="gl-email">
                                            <span class="validation" id="signup-email"></span>
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
                                            <input type="text" required="required" name="user_email">
                                            <span class="validation" id="signup-mobile"></span>
                                        </div>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->
                                    <div class="control-group">
                                        <label class="control-label">
                                            Password
                                            <span class="form-required">*</span>
                                        </label>

                                        <div class="controls">
                                            <input type="password" name="gl-password" required="required">
                                            <span class="validation" id="signup-password"></span>
                                        </div>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->
                                    <div class="control-group">
                                        <label class="control-label">
                                            <input type="checkbox" required="required" name="user_email" checked>*  I Confirm Terms and Conditions of Global Property Kart
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>

                                        <label class="control-label">
                                            <input type="checkbox"  name="user_email"> I am interested in home loan  
                                            <span class="form-required" title="This field is required."></span>
                                        </label>

                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->

                                    <!-- /.control-group -->
                                    <span class="msg-signup" id="registration-msg"></span>
                                    <div class="form-actions">
                                        <button type="submit" value="Register" class="btn btn-primary arrow-right">Register</button>
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