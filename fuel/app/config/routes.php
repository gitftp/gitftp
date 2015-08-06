<?php
if (is_dash) {
    $routes = array(
        '_root_'                                          => base_controller,
        '_404_'                                           => 'welcome/404',
        'feed'                                            => 'api/etc/feed',
        'hook/i/(:segment)/(:segment)/(:segment)'         => 'hook/$1/$2/$3',
        'api/(:segment)'                                  => 'api/$1',
        'api/(:segment)/(:segment)'                       => 'api/$1/$2',
        'api/(:segment)/(:segment)/(:segment)'            => 'api/$1/$2/$3',
        'api/(:segment)/(:segment)/(:segment)/(:segment)' => 'api/$1/$2/$3/$4',
        'user/logout'                                     => 'user/logout',
        '(:any)'                                          => base_controller,
    );
} else {
    $routes = array(
        '_root_'          => base_controller,
        '_404_'           => 'welcome/404',
        'login'           => 'user/login',
        'signup'          => 'user/signup',
        'forgot-password' => 'user/forgotpassword',
    );
}
return $routes;
