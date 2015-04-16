<?php

/**
 * Hosting configuration for homepage and dashboard application.
 */

return array(
    '_root_' => base_controller, // The default route
    'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
    '_404_' => 'new/pages/404', // The main 404 route
);
