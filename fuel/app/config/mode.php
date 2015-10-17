<?php

$env = array(
    'production'  => array(
        'home'     => 'www.gitftp.com',
        'dash'     => 'console.gitftp.com',
        'protocol' => 'https',
        'debug'    => FALSE
    ),
    'staging'     => array(
        'home'     => 'www.gitftp.com',
        'dash'     => 'console.gitftp.com',
        'protocol' => 'https',
        'debug'    => FALSE
    ),
    'test'        => array(
        'home'     => 'www.gitftp.com',
        'dash'     => 'console.gitftp.com',
        'protocol' => 'http',
        'debug'    => FALSE
    ),
    'development' => array( // dev -> local server.
        'home'     => 'stg-home.gitftp.com',
        'dash'     => 'stg.gitftp.com',
        'protocol' => 'http',
        'debug'    => TRUE
    ),
);

$current_env = $env[\Fuel::$env];

if (isset($_SERVER['HTTP_HOST'])) {
    $host = $_SERVER['HTTP_HOST'];
    if (Input::protocol() != $current_env['protocol'])
        Response::redirect($current_env['protocol'] . '://' . $current_env['home'] . $_SERVER['REQUEST_URI']);
} else {
    // cli.
    $host = $current_env['dash'];
}

// If any other host, redirect back to homepage !
if (!in_array($host, Arr::flatten($current_env))) {
    Response::redirect($current_env['protocol'] . '://' . $current_env['home'] . $_SERVER['REQUEST_URI']);
}

if ($host == $current_env['dash']) {
    $controller = 'dashboard/index';
    $is_dash = TRUE;
} else {
    $controller = 'welcome/index';
    $is_dash = FALSE;
}

$dash_url = $current_env['protocol'] . '://' . $current_env['dash'] . '/';
$home_url = $current_env['protocol'] . '://' . $current_env['home'] . '/';

define('dash_url', $dash_url);
define('home_url', $home_url);
define('is_dash', $is_dash);
define('base_controller', $controller);
define('protocol', $current_env['protocol']);
define('is_debug', $current_env['debug']);

return array();