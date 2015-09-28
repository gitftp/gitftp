<section class="section small-padding active-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="text-center">
                    <?php // echo Asset::img('logo-sm.png'); ?>
                    <span class="" style="font-weight: 500; font-size: 20px; vertical-align: middle">SIGNUP</span>
                </div>
                <div class="space20"></div>
                <div class="panel panel-default">
                    <form action="" id="home-signup">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="text" id="email" name="email" placeholder="Your Email address" class="form-control">
                                        <label class="emailvalid error" style="display: none;">This email address is already registered.<br> <a href="<?php echo \Uri::create('forgot-password'); ?>" >Reset password</a> or <a href="<?php echo \Uri::create('login'); ?>" >Login</a></label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="username" id="username" name="username" placeholder="Your Username" class="form-control">
                                        <label class="usernamevalid error" style="display: none;">This username is taken</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" name="password" placeholder="Your Password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info btn-block">
                                <i class="fa fa-lock fa-fw" style=""></i> Signup
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