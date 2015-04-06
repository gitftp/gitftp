<?php

/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.5
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

Autoloader::add_classes(array(
    'bridge' => __DIR__ . '/classes/backend/curl.php',
    'bridge' => __DIR__ . '/classes/backend/ftp.php',
    'bridge' => __DIR__ . '/classes/backend/ssh2.php',
    'bridge' => __DIR__ . '/classes/backend.php',
    'bridge' => __DIR__ . '/classes/bridge.php',
));


/* End of file bootstrap.php */
