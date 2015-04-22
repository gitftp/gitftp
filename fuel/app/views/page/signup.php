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
            <div class="col-md-12">
                <h3 class="title text-center">
                    Signup to <span class="blue">gitftp</span>.com
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="space20"></div>
                <form id="home-signup-module" action="<?php echo Uri::base(false) ?>user/login" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-message"><i class="fa fa-info"> We are on Beta, and Signups are only provided to Individuals willing to help reporting bugs.</div>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-info signup-form-error" style="display:none"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fullname">Fullname</label>
                                <input type="text" id="fullname" name="fullname" placeholder="John Doe" class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" placeholder="johndoe" class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input  type="email" id="email" name="email" placeholder="john@gmail.com" class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Password</label>
                                <input type="password" id="password" name="password" placeholder="******" class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-md-6 col-md-offset-6">
                            <button type="submit" class="btn btn-danger btn-lg pull-right">
                                Signup
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<br>