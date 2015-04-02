<div class="container">
    <div class="row">

        <?php echo $welcomesidebar; ?>
        <!-- /#sidebar -->

        <div id="main" class="span9">

            <div class="login-register">
                <h2>Login or Register</h2>

                <div class="row">
                    <div class="span9">
                        <ul class="tabs nav nav-tabs">
                            <li class=""><a href="#login" data-toggle="tab">Login</a></li>
                            <li class="active"><a href="#register" data-toggle="tab">Register</a></li>
                        </ul>
                        <!-- /.nav -->

                        <div class="tab-content">
                            <div class="tab-pane" id="login">
                                <form method="post" action="javascript:void(0)">

                                    <div class="control-group">
                                        <label class="control-label">
                                            Login
                                            <span class="form-required">*</span>
                                        </label>

                                        <div class="controls">
                                            <input type="text" name="log" required="required">
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
                                            <input type="password" name="pwd" required="required">
                                        </div>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->

                                    <div class="form-actions">
                                        <input type="submit" value="Login" class="btn btn-primary arrow-right">
                                    </div>
                                    <!-- /.form-actions -->
                                </form>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane active" id="register">
                                <form method="post" action="javascript:void(0)">

                                    <div class="control-group">
                                        <label class="control-label">
                                            Username
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>

                                        <div class="controls">
                                            <input type="text" required="required" name="user_login">
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
                                            <input type="email" required="required" name="user_email">
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
                                            <input type="email" required="required" name="user_email">
                                        </div>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->
                                    <div class="control-group">
                                        <label class="control-label">
                                           I am
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>

                                        <div class="controls">
                                            <select name="signup-iam" id="inputiam-signup" class="signup">
                                                <option value="">Select</option><option value="Buyer">Buyer</option><option value="Builder">Builder</option><option value="Landlord">Landlord</option><option value="Tenant">Tenant</option><option value="Owner">Owner</option></select>
                                        </div>
                                        <!-- /.controls -->
                                    </div>
                                    <!-- /.control-group -->

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


                    <div class="span9">
                        <article class="status-publish entry">
                            <header class="entry-header">
                                <h1 class="page-header entry-title">
                                    <a href="login" rel="bookmark">Login Template</a>
                                </h1>

                            </header>
                            <!-- .entry-header -->

                            <div class="entry-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse
                                    euismod ipsum a gravida tristique. Aliquam eu posuere sapien. Nunc
                                    non nunc nisl. Class aptent taciti sociosqu ad litora torquent per
                                    conubia nostra, per inceptos himenaeos. Nam diam odio, convallis
                                    eget scelerisque eget, posuere ut purus. Suspendisse rhoncus felis
                                    vel lorem porttitor, at blandit leo bibendum. Curabitur convallis
                                    eget velit at accumsan. Sed sed augue blandit, facilisis magna vel,
                                    tristique mauris. Sed facilisis, quam eu ornare mollis, lectus sem
                                    sagittis est, sed cursus enim diam ut diam. </p>
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