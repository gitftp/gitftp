<!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<?php echo Asset::css('home-main.css'); ?>
<?php echo Asset::js('home-main.js'); ?>

<div class="home-login">
    <?php echo View::forge('layout/nav'); ?>
    <div style="height: 10px;"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <h3 class="title text-center">
                	Login to your a/c
                </h3>
                <form action="">
                	<div class="form-group">
                		<label for="email">Email</label>
                		<input type="email" id="email" name="email" placeholder="Your email" class="form-control">
                	</div>
                	<div class="form-group">
                		<label for="email">Password</label>
                		<input type="password" id="password" name="password" placeholder="Your password" class="form-control">
                	</div>
                	<button type="submit" class="btn btn-default">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
<br>