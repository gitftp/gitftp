<?php

/**
 * Hosting configuration for homepage and dashboard application.
 */
$host = $_SERVER['HTTP_HOST'];
if(preg_match('/git.gitftp.com|stg.gitftp.com/i', $host)) {
    $is_dash = true;
    $controller = 'dashboard/index';
}else{
    $controller = 'welcome/index';
    $is_dash = false;
}

if('localhost' == $host){
    $base = 'http://stg.gitftp.com/';
}
if('stg.gitftp.com' == $host){
    $base = 'http://localhost/';
}
if('git.gitftp.com' == $host){
    $base = 'http://gitftp.com/';
}
if('gitftp.com' == $host){
    $base = 'http://git.gitftp.com/';
}

define('base', $base);
define('is_dash', $is_dash);

return array(
    '_root_' => $controller, // The default route
    'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
    '_404_' => 'new/pages/404', // The main 404 route
);
