<!DOCTYPE html>
<html lang="en">

    <head>
        <?php echo $header; ?>
    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Sign In</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" id="admin-login" method="POST" action="<?php echo Uri::base(false);?>user/loginadmin">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Usernmae" name="username" type="text" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                        </label>
                                    </div>
                                    <span id="admin-login-msg"></span>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#wrapper -->

        <?php echo $footer; ?>
    </body>

</html>
