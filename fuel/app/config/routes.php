<?php

/**
 * Hosting configuration for homepage and dashboard application.
 */
$host = $_SERVER['HTTP_HOST'];
if(preg_match('/git.gitftp.com|stg.gitftp.com/i', $host)) {
    $is_dash = true;
    $controller = 'dashboard/index';
    $dash_url = 'http://stg.gitftp.com/';
    $home_url = 'http://localhost/gitploy';
    
}else{
    $controller = 'welcome/index';
    $is_dash = false;
    $dash_url = 'http://stg.gitftp.com/';
    $home_url = 'http://localhost/gitploy';
}

define('dash_url', $dash_url);
define('home_url', $home_url);
define('is_dash', $is_dash);

return array(
    '_root_' => $controller, // The default route
    'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
    '_404_' => 'new/pages/404', // The main 404 route
);
