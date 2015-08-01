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
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<body>
<br/>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            <nav class="navbar navbar-default navbar-fixed-top">
                <a class="navbar-brand" href="#">Admin</a>
                <ul class="nav navbar-nav">
                    <li>
                        <a href="<?php echo Uri::create('administrator/home/'); ?>">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo Uri::create('administrator/user/'); ?>" >List users</a>
                    </li>
                </ul>
            </nav>
        </div>

        <br/><br/><br/>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo $data; ?>
        </div>
    </div>
</div>
</body>
</html>
