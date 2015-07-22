<section class="section small-padding active-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="text-center">
                    <?php // echo Asset::img('logo-sm.png'); ?>
                    <span class="text-uppercase" style="font-weight: 500; font-size: 20px; vertical-align: middle">SIGNUP with gitftp</span>
                </div>
                <div class="space20"></div>
                <div class="well-sm">
                    <i class="fa fa-info"></i> Gitftp is in beta, and is only available for selected members.
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="" id="home-signup">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="fullname">Full name</label>
                                        <input type="text" id="fullname" name="fullname" placeholder="Your Full name" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="text" id="email" name="email" placeholder="Your Email or Username" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="username" id="username" name="username" placeholder="Your Username" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" name="password" placeholder="Your Password" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info btn-block" disabled>
                                <i class="fa fa-lock fa-fw" style=""></i> Signup
                            </button>
                            <!--                            <a href="--><?php //echo home_url . 'api/user/oauth/github'; ?><!--">github ?</a>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>