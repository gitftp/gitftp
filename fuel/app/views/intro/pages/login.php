<?php
echo View::forge('intro/search/header');
echo View::forge('intro/search/breadcumb');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main-block">
                <div class="about-seller">
                    <span class="title">Login / Register</span>
                </div>
                <div class="space20"></div>
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="text-center">Login</h4>

                        <form action="<?php echo Uri::base(false) . 'user/login'; ?>" id="global-login-form">
                            <div class="form-group">
                                <label for="">Username</label>
                                <input type="text" name="username" class="form-control" required title="Please enter Username">
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" required title="Please enter Password">
                            </div>
                            <p class="text-danger login-error" style="display:none"></p>
                            <a href="<?php echo Uri::base(false).'resetpassword';?>" class="btn btn-link">reset password</a>
                            <button class="btn btn-warning pull-right" type="submit">Login</button>
                        </form>
                    </div>
                    <div class="col-md-4" >
                        <h4 class="text-center">Register</h4>

                        <form action="user/signup" id="global-register-form">
                            <div class="form-group">
                                <label for="">Username</label>
                                <input type="text" name="gl-name" class="form-control" required title="Please enter your username">
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="gl-email" class="form-control" required title="Please enter E-mail">
                            </div>
                            <div class="form-group">
                                <label for="">Mobile no.</label>
                                <input type="text" name="gl-mobile" class="form-control" required title="Please enter Moblie no.">
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="gl-password" class="form-control" required title="Please enter Password">
                            </div>
                            <div class="checkbox">
                                <label for="terms">
                                    <input type="checkbox" name="terms" value="Yes" id="terms" checked required title="You need to accept the terms.">
                                    I Confirm Terms and Conditions of Global Property Kart *
                                </label>
                            </div>
                            <p class="text-danger login-error" style="display:none"></p>
                            <div class="checkbox">
                                <label for="homeloan">
                                    <input type="checkbox" name="homeloan" id="homeloan" value="Yes">
                                    I am interested in home loan
                                </label>
                            </div>
                            <button class="btn btn-warning pull-right gl-registration" type="submit">Register</button>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <img style="width: 100%" src="http://dummyimage.com/300x300/f0f0f0/808080&text= Advertise" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo View::forge('intro/search/footer');
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.js"><\/script>')</script>

<script src="<?php echo Uri::base(false); ?>assets/js/newsearch/vendor/bootstrap.min.js"></script>
<script src="<?php echo Uri::base(false); ?>assets/js/newsearch/main.js"></script>
<script src="<?php echo Uri::base(false); ?>assets/js/newsearch/jquery.flexslider-min.js"></script>
</body>
</html>
