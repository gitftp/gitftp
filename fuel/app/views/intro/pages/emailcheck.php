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
                        <h4 class="text-center">Reset Password</h4>

                        <form action="<?php echo Uri::base(false) . 'user/emailcheck'; ?>" id="global-emailcheck">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" name="email" class="form-control" required title="Please enter Username">
                            </div>
                            <p class="text-danger login-error" style="display:none"></p>
                            <button class="btn btn-warning pull-right" type="submit">Send</button>
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
