<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 - Gitftp.com</title>
    <?php echo Asset::css('bootstrap.css'); ?>
</head>
<body>
<br/><br/><br/><br/>
<p class="text-center">
    <?php echo Asset::img('logo-s.png', array('style' => 'width: 100px;')); ?>
</p>
<br/>
<h4 class="text-center">404, We could not find anything for the requested URL.</h4>
<p class="text-center">
    Requested: <em><?php echo $_SERVER['REQUEST_URI']; ?></em>
</p>
<p class="text-center">
    <a href="<?php echo home_url; ?>" class="btn btn-info">RETURN HOME</a>
</p>
</body>
</html>