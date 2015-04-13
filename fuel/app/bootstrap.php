<?php

// Load in the Autoloader
require COREPATH . 'classes' . DIRECTORY_SEPARATOR . 'autoloader.php';
class_alias('Fuel\\Core\\Autoloader', 'Autoloader');

// Bootstrap the framework DO NOT edit this
require COREPATH . 'bootstrap.php';


Autoloader::add_classes(array(
        // Add classes you want to override here
        // Example: 'View' => APPPATH.'classes/view.php',
));

// Register the autoloader
Autoloader::register();

/**
 * Your environment.  Can be set to any of the following:
 *
 * Fuel::DEVELOPMENT
 * Fuel::TEST
 * Fuel::STAGE
 * Fuel::PRODUCTION
 */
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    Fuel::$env = (isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : Fuel::DEVELOPMENT);
} else if ($_SERVER['HTTP_HOST'] == 'git.gitftp.com' || $_SERVER['HTTP_HOST'] == 'gitftp.com' || $_SERVER['HTTP_HOST'] == '54.149.18.148') {
    Fuel::$env = (isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : Fuel::PRODUCTION);
} else {
    Fuel::$env = (isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : Fuel::TEST);
}

//Fuel::$env = (isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : Fuel::DEVELOPMENT);
// Initialize the framework with the config file.
Fuel::init('config.php');
