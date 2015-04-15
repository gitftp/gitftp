<?php echo View::forge('layout/nav'); ?>

<div style="height: 30px;"></div>
<form class="navbar-form navbar-right" method="POST" action="<?php echo dash_url ?>user/login" role="search">
    <div class="form-group">
        <input type="text" name="email" class="form-control" placeholder="Email" value="">
    </div>
    <div class="form-group">
        <input type="text" name="password" class="form-control" placeholder="Password" value="">
    </div>
    <button type="submit" class="btn btn-danger">Login</button>
</form>