<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang=""> <!--<![endif]-->
<head>
    <?php echo Asset::css('bootstrap.css'); ?>
</head>
<body>
<br/>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="<?php echo Uri::create('administrator/user/'); ?>" class="list-group-item">List users</a>
                <a href="#" class="list-group-item">Users</a>
                <a href="#" class="list-group-item">Users</a>
                <a href="#" class="list-group-item">Users</a>
                <a href="#" class="list-group-item">Users</a>
                <a href="#" class="list-group-item">Users</a>
            </div>
        </div>
        <div class="col-md-9">
            <?php echo $data; ?>
        </div>
    </div>
</div>
</body>
</html>
