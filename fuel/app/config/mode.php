<?php

$env = [
    'production'  => array(
        'home' => 'www.gitftp.com',
        'dash' => 'console.gitftp.com',
    ),
    'development' => array(
        'home' => 'stg-home.gitftp.com',
        'dash' => 'stg.gitftp.com',
    )
];

$current_env = $env[\Fuel::$env];

if (isset($_SERVER['HTTP_HOST'])) {
    $host = $_SERVER['HTTP_HOST'];
    // non cli ?
} else {
    $host = $current_env['dash'];
}

// If any other host, redirect back to homepage !
if (!in_array($host, Arr::flatten($current_env))) {
    Response::redirect('http://' . $current_env['home']);
}

if ($host == $current_env['dash']) {
    $controller = 'dashboard/index';
    $is_dash = TRUE;
} else {
    $controller = 'welcome/index';
    $is_dash = FALSE;
}

$dash_url = 'http://' . $current_env['dash'] . '/';
$home_url = 'http://' . $current_env['home'] . '/';

define('dash_url', $dash_url);
define('home_url', $home_url);
define('is_dash', $is_dash);
define('base_controller', $controller);


return array();