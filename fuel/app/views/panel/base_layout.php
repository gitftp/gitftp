<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title><?php echo isset($title) ? $title : 'Gitftp' ?></title>
    <meta name="description"
          content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

    <?php echo $css ?>
    <base href="<?php echo \Fuel\Core\Uri::base(); ?>">
    <script>
        var BASE = '<?php echo \Fuel\Core\Uri::base() ?>';
        var PATH = '<?php echo \Fuel\Core\Uri::string(); ?>';
        var API_PATH = '<?php echo $apiUrl; ?>'
        var GITHUB_CALLBACK = '<?php echo $githubCallback; ?>';
        var BITBUCKET_CALLBACK = '<?php echo $bitbucketCallback; ?>';
    </script>

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body ng-init='
user = <?php echo json_encode($user); ?>;
availableProviders = <?php echo json_encode($availableProviders) ?>;
readyProviders = <?php echo json_encode($readyProviders) ?>;
projects = <?php echo json_encode($projects) ?>
'>
<div class="app">

    <div id="content" class="app-content" role="main">
        <div class="box">
            <div top-header></div>
            <div class="box-row">
                <div class="box-cell">
                    <div class="box-inner">
                        <div ng-view></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php echo $js ?>
<script type="text/javascript" src="<?php echo \Fuel\Core\Uri::base(); ?>app/build.js"></script>
</body>
</html>
