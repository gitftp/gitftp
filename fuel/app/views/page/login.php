<!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<?php echo Asset::css('home-main.css'); ?>
<?php echo Asset::js('home-main.js'); ?>

<div class="home-login">
    <?php echo View::forge('layout/nav'); ?>
    <div class="space20"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <h3 class="title text-center">
                    Login to <span class="blue">gitftp</span>.com
                </h3>
                <div class="space20"></div>
                <form id="" method="post">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Your email" class="form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label for="email">Password</label>
                        <input type="password" id="password" name="password" placeholder="Your password" class="form-control input-lg">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                        <i class="fa fa-lock fa-fw" style=""></i> Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<br>