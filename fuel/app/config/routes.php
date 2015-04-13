<?php

/**
 * Hosting configuration for homepage and dashboard application.
 */
$host = $_SERVER['HTTP_HOST'];

if(preg_match('/git.gitftp.com|stg.gitftp.com/i', $host)) {
//    $controller = 'welcome/index'; // change this to dashboard.
    $controller = 'dashboard/index';
    $is_dash = true;
    $dash_url = 'http://'.$host.'/';
    $home_url = ($host == 'git.gitftp.com') ? 'http://gitftp.com/': 'http://stg-home.gitftp.com/';
}else{
    $controller = 'welcome/index';
    $is_dash = false;
    $dash_url = ($host == 'www.gitftp.com') ? 'http://git.gitftp.com/': 'http://stg.gitftp.com/';
    $home_url = 'http://'.$host.'/';
}

define('dash_url', $dash_url);
define('home_url', $home_url);
define('is_dash', $is_dash);

return array(
    '_root_' => $controller, // The default route
    'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
    '_404_' => 'new/pages/404', // The main 404 route
);
