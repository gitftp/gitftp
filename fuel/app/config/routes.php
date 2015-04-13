<?php

/**
 * Hosting configuration for homepage and dashboard application.
 */
$host = $_SERVER['HTTP_HOST']
if($host == 'git.gitftp.com'){
    $which_server = 'dashboard'
}else{
    
}
        
define('SITE', $which_server);

return array(
    '_root_' => 'welcome/index', // The default route
    'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
    '_404_' => 'new/pages/404', // The main 404 route
);
