<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 - Gitftp.com</title>
    <?php echo Asset::css('bootstrap.css'); ?>
</head>
<body>
<br/><br/>
<p class="text-center">
    <?php echo Asset::img('generic/link.svg', array('style' => 'width: 100px;')); ?>
</p>
<br/>
<h1 class="text-center" style="font-size: 70px;">404</h1>
<h3 class="text-center">Dammit, We could not find anything for the requested URL.</h3>
<p class="text-center">
    <em>Requested:</em> <?php echo $_SERVER['REQUEST_URI']; ?>
</p>
<p class="text-center">
    <a href="<?php echo home_url; ?>" class="btn btn-info"><strong>RETURN HOME</strong></a>
</p>
</body>
</html>