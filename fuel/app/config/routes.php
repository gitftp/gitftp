<?php
if (is_dash) {
    $routes = array(
        'feed'                                                       => 'api/etc/feed',
        'hook/i/(:segment)/(:segment)/(:segment)'                    => 'hook/i/$1/$2/$3',
        'api/(:segment)'                                             => 'api/$1',
        'api/(:segment)/(:segment)'                                  => 'api/$1/$2',
        'api/(:segment)/(:segment)/(:segment)'                       => 'api/$1/$2/$3',
        'api/(:segment)/(:segment)/(:segment)/(:segment)'            => 'api/$1/$2/$3/$4',
        'api/(:segment)/(:segment)/(:segment)/(:segment)/(:segment)' => 'api/$1/$2/$3/$4/$5',
        'user/logout'                                                => 'user/logout',
        '(:any)'                                                     => base_controller,
    );
} else {
    $routes = array(
        'login'           => 'user/login',
        'signup'          => 'user/signup',
        'forgot-password' => 'user/forgotpassword',
        'terms'           => 'pages/terms',
    );
}

$defaults = array(
    '_root_'                                         => base_controller,
    '_404_'                                          => 'welcome/404',
    'administrator'                                  => 'administrator/home',
    'administrator/(:segment)'                       => 'administrator/$1',
    'administrator/(:segment)/(:segment)'            => 'administrator/$1/$2',
    'administrator/(:segment)/(:segment)/(:segment)' => 'administrator/$1/$2/$3',
    'test/(:segment)'                                => 'test/$1',
    'test/(:segment)/(:segment)'                     => 'test/$1/$2',
    'test/(:segment)/(:segment)/(:segment)'          => 'test/$1/$2/$3',
);

return array_merge($defaults, $routes);
