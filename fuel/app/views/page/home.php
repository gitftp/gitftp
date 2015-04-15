<!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<?php echo Asset::css('home-main.css'); ?>

<div class="home-image">
    <?php echo View::forge('layout/nav'); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div style="height: 60px;"></div>
                <p class="text-center" style="color: #999">
                    <?php echo Asset::img('logo.png', array('class', 'logo-image')); ?> <br>
                    <span style="font-size: 3em">
                        <span style="font-weight: 100">Set your workflow.</span>
                    </span>
                </p>
            </div>
            <div class="col-md-4">
                <h4>Register</h4>
                <form>
                    <div class="form-group">
                        <label>
                            Username
                        </label>
                        <input type="text" placeholder="something" class="form-control">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>