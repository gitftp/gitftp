<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Something is not right..</title>
    <?php echo Asset::css('bootstrap.css'); ?>
</head>
<body>
<br/><br/><br/><br/>
<p class="text-center">
    <?php echo Asset::img('generic/face.svg', array('style' => 'width: 100px;')); ?>
</p>
<br/>
<h4 class="text-center">500: Something is not right</h4>
<p class="text-center">
    <?php echo $message; ?>
</p>
<br/>
<p class="text-center">
    <a href="<?php echo home_url; ?>" class="btn btn-info">RETURN HOME</a>
</p>
</body>
</html>