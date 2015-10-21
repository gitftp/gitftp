<div class="visible-md visible-lg">
    <div class="space20"></div>
    <div class="space20"></div>
</div>
<div class="space20"></div>
<div class="space20"></div>
<div class="space20"></div>
<section class="section small-padding active-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                <div class="text-center">
                    <?php echo Asset::img('logo-sm.png'); ?>
                    <span class="text-uppercase" style="font-weight: 500; font-size: 20px; vertical-align: middle">Login</span>
                </div>
                <div class="space20"></div>
                <div class="panel panel-default">
                    <form action="" id="home-login">
                        <div class="panel-body">
                            <div class="btn-group btn-group-justified">
                                <a href="#" class="btn btn-default btn-clean btn-gitftp login-via" data-id="github">
                                    <i class="fa fa-github-alt"></i> Github
                                </a>
                                <a href="#" class="btn btn-default btn-clean btn-gitftp login-via" data-id="bitbucket">
                                    <i class="fa fa-bitbucket"></i> Bitbucket
                                </a>
                            </div>
                            <div class="line">
                                <p class="text">or</p>
                            </div>
                            <div class="form-group">
                                <label for="email">Username or Email</label>
                                <input type="text" id="email" name="email" placeholder="Your Email or Username" class="form-control" autofocus="true">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" placeholder="Your Password" class="form-control">
                            </div>
                            <strong><a class="pull-right" href="<?php echo Uri::create('forgot-password') ?>">Forgot password?</a></strong>

                            <div class="clearfix"></div>
                            <div class="space10"></div>
                            <button type="submit" class="btn btn-info btn-block">
                                <i class="fa fa-lock fa-fw" style=""></i> Login
                            </button>
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
            content: 'Your account has been successfully activated. <br/>You may now login to your account.',
            icon: 'fa fa-check green fa-fw',
            cancelButton: 'Dismiss',
            backgroundDismiss: false,
        });
        <?php }else{ ?>
        $.alert({
            title: 'Activation Expired!',
            content: 'The Activation token has expired.',
            icon: 'fa fa-warning fa-fw orange',
            confirmButton: 'close',
            confirmButtonClass: 'btn-default btn-clean',
            backgroundDismiss: false,
        });
        <?php } ?>
    </script>
<?php } ?>