<?php
//
///**
// * Hosting configuration for homepage and dashboard application.
// */
//$host = $_SERVER['HTTP_HOST']
//
//define('SITE', $which_server);
$a = 'welcome/index';

return array(
    '_root_' => 'welcome/index', // The default route
    'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
    '_404_' => 'new/pages/404', // The main 404 route
);
