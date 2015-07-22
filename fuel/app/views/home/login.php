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
                    <div class="panel-body">
                        <form action="" id="home-login">
<!--                            <p class="text-center big-text" style="font-weight: 500; text-transform: uppercase">Login with</p>-->
<!--                            <div class="btn-group btn-group-justified">-->
<!--                                <a href="#" class="btn btn-default btn-clean btn-gitftp ">-->
<!--                                    <i class="fa fa-github-alt"></i> Github-->
<!--                                </a>-->
<!--                                <a href="#" class="btn btn-default btn-clean btn-gitftp ">-->
<!--                                    <i class="fa fa-bitbucket"></i> Bitbucket-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <hr/>-->
                            <div class="form-group">
                                <label for="email">Username or Email</label>
                                <input type="text" id="email" name="email" placeholder="Your Email or Username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" placeholder="Your Password" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-info btn-block">
                                <i class="fa fa-lock fa-fw" style=""></i> Login
                            </button>
                            <!--                            <a href="--><?php //echo home_url . 'api/user/oauth/github'; ?><!--">github ?</a>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>