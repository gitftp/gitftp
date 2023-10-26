<?php

return [
    'default' => [
        'type'         => 'mysqli',
        'connection'   => [
            'hostname' => GF_DB_HOST,
            'port'     => '3306',
            'database' => GF_DB_NAME,
            'username' => GF_DB_USERNAME,
            'password' => GF_DB_PASSWORD,
        ],
        'table_prefix' => '',
    ],
];
