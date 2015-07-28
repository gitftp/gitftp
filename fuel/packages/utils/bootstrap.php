<?php

Autoloader::add_classes(array(
    'Utils'                           => __DIR__ . '/classes/utils.php',
    'Craftpip\Mail'                   => __DIR__ . '/classes/mail.php',
    'Craftpip\Auth'                   => __DIR__ . '/classes/auth.php',
    'Craftpip\GitApi\GitApiInterface' => __DIR__ . '/classes/gitapi/gitapiinterface.php',
    'Craftpip\GitApi\Github'          => __DIR__ . '/classes/gitapi/github.php',
    'Craftpip\GitApi\Bitbucket'       => __DIR__ . '/classes/gitapi/bitbucket.php',
    'Craftpip\GitApi'                 => __DIR__ . '/classes/gitapi/gitapi.php',
));

/* End of file bootstrap.php */
