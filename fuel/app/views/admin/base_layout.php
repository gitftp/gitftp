<!DOCTYPE html>
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
    <title>Gitftp admin console</title>
    <?php echo Asset::css('bootstrap.css'); ?>
    <?php echo Asset::js('vendor/jquery-1.11.2.js'); ?>
    <?php
    echo Asset::js('vendor/bootstrap.min.js');
    echo Asset::js('vendor/summernote.js');
    echo Asset::css('summernote.css');
    echo Asset::css('font-awesome.css');
    ?>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
<!--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>-->
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-default navbar-fixed-top">
                <a class="navbar-brand" href="<?php echo Uri::create(''); ?>"><?php echo Asset::img('logo-sm-2.png', ['style' => 'margin-top: -9px;']); ?></a>
                <ul class="nav navbar-nav">
                    <li>
                        <a href="<?php echo Uri::create('administrator/home/'); ?>">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo Uri::create('administrator/user/'); ?>">Users</a>
                    </li>
                    <li>
                        <a href="<?php echo Uri::create('administrator/feedback/'); ?>">Feedback</a>
                    </li>
                    <li>
                        <a href="<?php echo Uri::create('administrator/log/'); ?>">Logs</a>
                    </li>
                    <li>
                        <a href="<?php echo Uri::create('administrator/manage/'); ?>">Manage</a>
                    </li>
                    <li>
                        <a href="<?php echo Uri::create('administrator/seo/'); ?>">Seo</a>
                    </li>
                    <li>
                        <a href="<?php echo Uri::create('administrator/docs/'); ?>">Docs pages</a>
                    </li>
                </ul>
            </nav>
            <div style="height: 70px"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo $data; ?>
        </div>
    </div>
</div>

</body>
</html>
