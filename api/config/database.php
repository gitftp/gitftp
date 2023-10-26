<?php

return [
    'default' => 'mysql',
    'migrations' => 'migrations',
    'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => \Config::instance()->get('mysql.host'),
            'port'      => \Config::instance()->get('mysql.port'),
            'database'  => \Config::instance()->get('mysql.database'),
            'username'  => \Config::instance()->get('mysql.username'),
            'password'  => \Config::instance()->get('mysql.password'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
            'unix_socket' => \Config::instance()->get('mysql.socket', ''),
        ],
    ],
];
