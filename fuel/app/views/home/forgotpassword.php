<div class="visible-md visible-lg">
    <div class="space20"></div>
    <div class="space20"></div>
</div>
<div class="space20"></div>
<div class="space20"></div>
<div class="space20"></div>
<section class="section small-padding active-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                <div class="text-center">
                    <?php // echo Asset::img('logo-sm.png'); ?>
                    <span class="text-uppercase" style="font-weight: 500; font-size: 20px; vertical-align: middle">Forgot password</span>
                </div>
                <div class="space20"></div>
                <div class="panel panel-default">
                    <?php if ($reset) { ?>
                        <form action="" id="home-password-reset-confirmed">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="password">New password</label>
                                    <input type="password" id="password" name="password" placeholder="New password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password2">Confirm new password</label>
                                    <input type="password" id="password2" name="password2" placeholder="Re-enter new password" class="form-control">
                                </div>
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"/>
                                <input type="hidden" name="key" value="<?php echo $key; ?>"/>
                                <button type="submit" class="btn btn-info btn-block">
                                    Change password
                                </button>
                            </div>
                        </form>
                    <?php } else { ?>
                        <form action="" id="home-password-reset">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="email">Username or Email</label>
                                    <input type="text" id="email" name="email" placeholder="Your Email or Username" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-info btn-block">
                                    Submit
                                </button>
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>