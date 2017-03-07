<?php

Autoloader::add_classes([
    'Gf\Misc'                           => __DIR__ . '/classes/misc.php',
    'Gf\Utils'                          => __DIR__ . '/classes/utils.php',
    'Gf\Exception\UserException'        => __DIR__ . '/classes/exception/userexception.php',
    'Gf\Exception\AppException'         => __DIR__ . '/classes/exception/appexception.php',
    'Gf\Exception\Log'                  => __DIR__ . '/classes/exception/log.php',
    'Gf\Exception\Logger'               => __DIR__ . '/classes/exception/logger.php',
    'Gf\Exception\ExceptionInterceptor' => __DIR__ . '/classes/exception/exceptioninterceptor.php',
    'Gf\Settings'                       => __DIR__ . '/classes/settings.php',
    'Gf\Auth\OAuth'                     => __DIR__ . '/classes/auth/oauth.php',
    'Gf\Auth\Auth'                      => __DIR__ . '/classes/auth/auth.php',
    'Gf\Auth\SessionManager'            => __DIR__ . '/classes/auth/sessionmanager.php',
    'Gf\Auth\Users'                     => __DIR__ . '/classes/auth/users.php',
    'Gf\Platform'                       => __DIR__ . '/classes/platform.php',
    'Gf\Config'                         => __DIR__ . '/classes/config.php',
    'Gf\Git'                            => __DIR__ . '/classes/git.php',
    'Gf\Projects'                       => __DIR__ . '/classes/projects.php',
]);

/* End of file bootstrap.php */
