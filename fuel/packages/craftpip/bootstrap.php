<?php

Autoloader::add_classes(array(
    'Utils'                           => __DIR__ . '/classes/utils.php',
    'Craftpip\Mail'                   => __DIR__ . '/classes/mail.php',

    'Craftpip\Oauth\Oauth'            => __DIR__ . '/classes/oauth/oauth.php',
    'Craftpip\Oauth\Auth'             => __DIR__ . '/classes/oauth/auth.php',
    'Craftpip\Oauth\Db'               => __DIR__ . '/classes/oauth/db.php',

    'Craftpip\GitApi\GitApiInterface' => __DIR__ . '/classes/gitapi/gitapiinterface.php',
    'Craftpip\GitApi\Github'          => __DIR__ . '/classes/gitapi/github.php',
    'Craftpip\GitApi\Bitbucket'       => __DIR__ . '/classes/gitapi/bitbucket.php',
    'Craftpip\GitApi'                 => __DIR__ . '/classes/gitapi/gitapi.php',

    'Craftpip\Git'                    => __DIR__ . '/classes/git.php',
    'Craftpip\Exception'              => __DIR__ . '/classes/exception.php',

    'Gfcore'                          => __DIR__ . '/classes/core/gfcore.php',
    'Gitcore'                         => __DIR__ . '/classes/core/gitcore.php',
    'Deploy'                          => __DIR__ . '/classes/core/deploy.php',
    'DeployHelper'                    => __DIR__ . '/classes/core/deployhelper.php',
));

/* End of file bootstrap.php */
