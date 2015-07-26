<?php

return array(
	'_root_'  => base_controller,  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
    'login' => 'user/login',
    'signup' => 'user/signup',
    'forgot-password' => 'user/forgotpassword',
    'feed' => 'api/etc/feed'
);
