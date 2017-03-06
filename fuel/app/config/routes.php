<?php

return $defaults = [
    '_root_'             => 'init',
    'setup'              => 'setup/setup/index',
    'setup/api/(:any)'   => 'setup/api/$1',
    'console/api/(:any)' => 'console/api/$1',
    'login'              => 'login/index',
    '(:any)'             => 'init',
    '_404_'              => 'start/404',
];
