<section class="section small-padding active-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="text-center">
                    <?php echo Asset::img('logo-sm.png'); ?>
                    <span class="text-uppercase" style="font-weight: 500; font-size: 20px; vertical-align: middle">Login</span>
                </div>
                <div class="space20"></div>
                <div class="panel panel-default">
                    <form action="" id="home-login">
                        <div class="panel-body">
                            <p class="text-center big-text" style="font-weight: 500; text-transform: uppercase">Login with</p>

                            <div class="btn-group btn-group-justified">
                                <a href="#" class="btn btn-default btn-clean btn-gitftp" id="login-via-github">
                                    <i class="fa fa-github-alt"></i> Github
                                </a>
                            </div>

                            <hr/>
                            <div class="form-group">
                                <label for="email">Username or Email</label>
                                <input type="text" id="email" name="email" placeholder="Your Email or Username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" placeholder="Your Password" class="form-control">
                            </div>
                            <strong><a class="pull-right" href="<?php echo Uri::create('forgot-password') ?>">Forgot password</a></strong>

                            <div class="clearfix"></div>
                            <div class="space10"></div>
                            <button type="submit" class="btn btn-info btn-block">
                                <i class="fa fa-lock fa-fw" style=""></i> Login
                            </button>
                            <!--                            <a href="--><?php //echo home_url . 'api/user/oauth/github'; ?><!--">github ?</a>-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="space20"></div>
<div class="space20"></div>
<div class="space20"></div>
<?php if (!is_null($email_verification)) { ?>
    <script>
        <?php if($email_verification){ ?>
        $.alert({
            title: 'Thank you!',
            content: 'Your Email has been successfully verified',
            icon: 'fa fa-check green',
            confirmButton: 'close',
            confirmButtonClass: 'btn-info'
        });
        <?php }else{ ?>
        $.alert({
            title: 'Verification Expired!',
            content: 'The verification token has expired.',
            icon: 'fa fa-info gray',
            confirmButton: 'close',
            confirmButtonClass: 'btn-default btn-clean'
        });
        <?php } ?>
    </script>
<?php } ?>