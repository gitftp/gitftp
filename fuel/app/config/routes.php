<?php
//if (is_dash) {
//    $routes = array(
//        'feed'                                                       => 'api/etc/feed',
//        'hook/i/(:segment)/(:segment)/(:segment)'                    => 'hook/i/$1/$2/$3',
//        'api/(:segment)'                                             => 'api/$1',
//        'api/(:segment)/(:segment)'                                  => 'api/$1/$2',
//        'api/(:segment)/(:segment)/(:segment)'                       => 'api/$1/$2/$3',
//        'api/(:segment)/(:segment)/(:segment)/(:segment)'            => 'api/$1/$2/$3/$4',
//        'api/(:segment)/(:segment)/(:segment)/(:segment)/(:segment)' => 'api/$1/$2/$3/$4/$5',
//        '(:any)'                                                     => base_controller,
//    );
//} else {
//    $routes = array(
//        'home'                                                        => 'welcome',
//        'login'                                                       => 'user/login',
//        'signup'                                                      => 'user/signup',
//        'forgot-password'                                             => 'user/forgotpassword',
//        'terms'                                                       => 'pages/terms',
//        'pricing'                                                     => 'pages/pricing',
//        'guide'                                                       => 'pages/guide',
//        'guide/(:segment)'                                            => 'pages/guide/$1',
//        'guide/(:segment)/(:segment)'                                 => 'pages/guide/$1/$2',
//        'hapi/(:segment)'                                             => 'home_api/$1',
//        'hapi/(:segment)/(:segment)'                                  => 'home_api/$1/$2',
//        'hapi/(:segment)/(:segment)/(:segment)'                       => 'home_api/$1/$2/$3',
//        'hapi/(:segment)/(:segment)/(:segment)/(:segment)'            => 'home_api/$1/$2/$3/$4',
//        'hapi/(:segment)/(:segment)/(:segment)/(:segment)/(:segment)' => 'home_api/$1/$2/$3/$4/$5',
//    );
//}

return $defaults = [
    '_root_'                                         => 'start',
    '_404_'                                          => 'start/404',
    'one'                                            => 'start/one',
    'administrator/(:segment)'                       => 'administrator/$1',
    'administrator/(:segment)/(:segment)'            => 'administrator/$1/$2',
    'administrator/(:segment)/(:segment)/(:segment)' => 'administrator/$1/$2/$3',
    'logout'                                         => 'user/logout',
    'test/(:segment)'                                => 'test/$1',
    'test/(:segment)/(:segment)'                     => 'test/$1/$2',
    'test/(:segment)/(:segment)/(:segment)'          => 'test/$1/$2/$3',
];
