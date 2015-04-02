<?php
echo View::forge('intro/search/header');
echo View::forge('intro/search/breadcumb');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main-block">
                <div class="about-seller">
                    <span class="title text-center"><h2><i class="fa fa-info fa-fw"></i>404. Page Not Found</h2></span>
                    <div class="space10"></div>
                    <h4>Sorry, the page you tried was not found. You may have used an outdated link or perhaps typed the address (URL) incorrectly. </h4>
                    <p>Please let us help you find what you are looking for.<br> You can go back to the home page </p>
                    <a href="<?php echo Uri::base(false); ?>" class="btn btn-warning">www.globalpropertykart.com</a>
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
