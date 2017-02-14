<?php

Autoloader::add_classes([
    'Gf\Misc'                           => __DIR__ . '/classes/misc.php',
    'Gf\Utils'                          => __DIR__ . '/classes/utils.php',
    'Gf\Exception\UserException'        => __DIR__ . '/classes/exception/userexception.php',
    'Gf\Exception\AppException'         => __DIR__ . '/classes/exception/appexception.php',
    'Gf\Exception\Log'                  => __DIR__ . '/classes/exception/log.php',
    'Gf\Exception\Logger'               => __DIR__ . '/classes/exception/logger.php',
    'Gf\Exception\ExceptionInterceptor' => __DIR__ . '/classes/exception/exceptioninterceptor.php',
    'Gf\Settings'                       => __DIR__ . '/classes/settings',
]);

/* End of file bootstrap.php */
